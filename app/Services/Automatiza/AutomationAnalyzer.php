<?php

namespace App\Services\Automatiza;

use Illuminate\Support\Facades\Config;

/**
 * Motor de calculo principal: convierte las respuestas del wizard en
 * un score (0-100), horas ahorrables por semana, ahorro economico
 * anual, tipo de solucion recomendada y rango de inversion.
 *
 * Los pesos, umbrales y rangos viven en config('automatiza') para
 * poder ajustarlos sin tocar codigo.
 */
final class AutomationAnalyzer
{
    public function __construct(
        private readonly ProcessRecommendationEngine $processes,
    ) {
    }

    public function analyze(AutomationInput $input): AutomationResult
    {
        $rawScore = $this->rawScore($input);
        $maxRaw = max(1, (int) Config::get('automatiza.score_max_raw', 20));
        $score = (int) min(100, round(($rawScore / $maxRaw) * 100));

        [$levelKey, $levelLabel] = $this->levelFor($score);

        [$hoursSaved, $baseHours, $savingRatio] = $this->hoursSaved($input);
        [$hourlyCost, $costIsEstimate] = $this->hourlyCost($input);

        $weekly = (int) round($hoursSaved * $hourlyCost);
        $monthly = $this->roundEconomic($weekly * 4.33);
        $annual = $this->roundEconomic($weekly * 52);

        $recommendations = $this->processes->recommend($input, 3);
        [$solutionKey, $solutionMin, $solutionMax] = $this->pickSolution($score, $hoursSaved, $recommendations, $input);
        $solutions = (array) Config::get('automatiza.solutions', []);
        $solutionMeta = $solutions[$solutionKey] ?? [];

        return new AutomationResult(
            score: $score,
            scoreLevelKey: $levelKey,
            scoreLevelLabel: $levelLabel,
            hoursSavedPerWeek: $hoursSaved,
            hourlyCost: $hourlyCost,
            hourlyCostIsEstimate: $costIsEstimate,
            weeklySaving: $weekly,
            monthlySaving: $monthly,
            annualSaving: $annual,
            recommendedSolutionKey: $solutionKey,
            recommendedSolutionLabel: (string) ($solutionMeta['label'] ?? ''),
            recommendedSolutionDescription: (string) ($solutionMeta['description'] ?? ''),
            investmentMin: $solutionMin,
            investmentMax: $solutionMax,
            recommendations: $recommendations,
            meta: [
                'raw_score' => $rawScore,
                'base_hours' => $baseHours,
                'saving_ratio' => $savingRatio,
                'hourly_cost_is_estimate' => $costIsEstimate,
            ],
        );
    }

    private function rawScore(AutomationInput $input): int
    {
        $score = 0;

        // 1) Herramientas: cuanto mas manual, mas potencial.
        $toolWeights = [
            'papel' => 4,
            'excel' => 2,
            'whatsapp' => 2,
            'email' => 1,
            'varias' => 3,
            'programa_gestion' => -1,
            'crm' => -2,
            'erp' => -2,
            'app_propia' => -2,
        ];
        foreach ($input->tools as $tool) {
            $score += $toolWeights[$tool] ?? 0;
        }

        // 2) Horas repetitivas semanales.
        $hoursScore = [
            'lt_2' => 0,
            '2_5' => 2,
            '5_10' => 3,
            '10_20' => 4,
            'gt_20' => 5,
            'unknown' => 2,
        ];
        $score += $hoursScore[$input->repetitiveHours ?? ''] ?? 0;

        // 3) Gestion de clientes.
        $customerScore = [
            'movil' => 3,
            'ninguno' => 4,
            'excel' => 2,
            'email' => 2,
            'crm' => 0,
            'programa' => 0,
        ];
        $score += $customerScore[$input->customerManagement ?? ''] ?? 0;

        // 4) Presupuestos.
        $quotationsScore = [
            'manual' => 3,
            'word_excel' => 2,
            'plantillas' => 1,
            'programa_gestion' => 0,
            'software_especifico' => -1,
            'ninguno' => 0,
        ];
        $score += $quotationsScore[$input->quotations ?? ''] ?? 0;

        // 5) Dificultad de seguimiento.
        $followScore = [
            'mucho' => 3,
            'bastante' => 2,
            'aveces' => 1,
            'poco' => 0,
            'no' => 0,
        ];
        $score += $followScore[$input->followUp ?? ''] ?? 0;

        // 6) Documentos repetitivos: cada tipo suma, con tope.
        $docsCount = count(array_filter($input->documents, static fn (string $d): bool => $d !== 'ninguno'));
        $score += min(3, $docsCount);

        // 7) Puntos calientes de perdida de tiempo.
        $commsWeights = [
            'duplicidad' => 2,
            'entre_programas' => 2,
            'buscar' => 1,
            'documentos' => 1,
            'seguimiento' => 1,
        ];
        foreach ($input->communication as $comm) {
            $score += $commsWeights[$comm] ?? 0;
        }

        return max(0, $score);
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function levelFor(int $score): array
    {
        foreach ((array) Config::get('automatiza.score_levels', []) as $level) {
            if ($score <= (int) ($level['max'] ?? 100)) {
                return [(string) ($level['key'] ?? 'medio'), (string) ($level['label'] ?? 'Medio')];
            }
        }

        return ['alto', 'Alto potencial'];
    }

    /**
     * @return array{0: float, 1: float, 2: float}
     */
    private function hoursSaved(AutomationInput $input): array
    {
        $config = (array) Config::get('automatiza.repetitive_hours', []);
        $entry = $config[$input->repetitiveHours ?? 'unknown'] ?? $config['unknown'] ?? [
            'hours' => 6.0,
            'saving_ratio' => 0.4,
        ];

        $baseHours = (float) ($entry['hours'] ?? 0);
        $ratio = (float) ($entry['saving_ratio'] ?? 0.4);

        // Ajuste marginal segun tamanio de empresa (grupos mayores suelen
        // absorber mas horas repetitivas globalmente).
        $sizeMultipliers = [
            'solo' => 0.9,
            '2_5' => 1.0,
            '6_10' => 1.15,
            '11_25' => 1.3,
            '26_50' => 1.5,
            '50_plus' => 1.8,
        ];
        $multiplier = $sizeMultipliers[$input->companySize ?? ''] ?? 1.0;

        $hoursSaved = $baseHours * $ratio * $multiplier;

        // Redondeo suave para no dar sensacion de falsa precision.
        return [round($hoursSaved, 1), $baseHours * $multiplier, $ratio];
    }

    /**
     * @return array{0: int, 1: bool}
     */
    private function hourlyCost(AutomationInput $input): array
    {
        $costs = (array) Config::get('automatiza.hourly_costs', []);
        $default = (int) Config::get('automatiza.default_hourly_cost', 20);
        $entry = $costs[$input->hourlyCost ?? 'unknown'] ?? null;

        if (! is_array($entry)) {
            return [$default, true];
        }

        return [
            (int) ($entry['value'] ?? $default),
            (bool) ($entry['estimate'] ?? false),
        ];
    }

    /**
     * @param  list<ProcessRecommendation>  $recommendations
     * @return array{0: string, 1: int, 2: int}
     */
    private function pickSolution(int $score, float $hoursSaved, array $recommendations, AutomationInput $input): array
    {
        $solutions = (array) Config::get('automatiza.solutions', []);

        $key = match (true) {
            $score <= 15 && $hoursSaved < 1 => 'ninguna',
            $score <= 30 => 'mejora_procesos',
            $score <= 45 && $hoursSaved < 4 => 'herramientas',
            $score <= 55 => 'integracion',
            $score <= 70 => 'app_pequenia',
            $score <= 85 => 'gestion_personalizada',
            default => 'app_completa',
        };

        // Empujes puntuales: si detectamos partes de trabajo o mucha
        // duplicidad de datos, tiene sentido saltar a "app pequenia".
        $recKeys = array_map(static fn (ProcessRecommendation $r): string => $r->key, $recommendations);
        if ($key === 'mejora_procesos' && array_intersect(['work_orders', 'data_entry'], $recKeys) !== []) {
            $key = 'herramientas';
        }
        if ($key === 'herramientas' && in_array('work_orders', $recKeys, true) && $hoursSaved >= 3) {
            $key = 'app_pequenia';
        }
        // Empresas grandes con score alto tienden a solucion mas completa.
        if (in_array($input->companySize, ['26_50', '50_plus'], true) && $key === 'gestion_personalizada') {
            $key = 'app_completa';
        }

        $range = $solutions[$key]['investment'] ?? [0, 0];

        return [$key, (int) ($range[0] ?? 0), (int) ($range[1] ?? 0)];
    }

    private function roundEconomic(float $value): int
    {
        if ($value <= 0) {
            return 0;
        }
        if ($value < 200) {
            return (int) (round($value / 10) * 10);
        }
        if ($value < 2000) {
            return (int) (round($value / 50) * 50);
        }
        return (int) (round($value / 100) * 100);
    }
}
