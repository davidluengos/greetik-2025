<?php

namespace App\Services\Automatiza;

use Illuminate\Support\Facades\Config;

/**
 * Recorre config('automatiza.processes'), suma los puntos que dispara
 * cada respuesta del wizard y devuelve los procesos con mayor
 * potencial de automatizacion.
 *
 * Las reglas viven en config para poder ajustarlas sin tocar codigo.
 */
final class ProcessRecommendationEngine
{
    /**
     * @return list<ProcessRecommendation>
     */
    public function recommend(AutomationInput $input, int $limit = 3): array
    {
        $processes = (array) Config::get('automatiza.processes', []);
        $answers = $this->answersMap($input);

        $scored = [];
        foreach ($processes as $key => $definition) {
            $score = $this->scoreProcess((array) ($definition['triggers'] ?? []), $answers);
            if ($score <= 0) {
                continue;
            }

            $scored[] = new ProcessRecommendation(
                key: (string) $key,
                title: (string) ($definition['title'] ?? $key),
                reason: (string) ($definition['reason'] ?? ''),
                solution: (string) ($definition['solution'] ?? ''),
                score: $score,
                potentialLabel: $this->potentialFor($score),
            );
        }

        // Orden estable por score desc; en empate mantenemos el orden de config.
        usort($scored, static fn (ProcessRecommendation $a, ProcessRecommendation $b): int => $b->score <=> $a->score);

        return array_slice($scored, 0, $limit);
    }

    /**
     * @return array<string, list<string>>
     */
    private function answersMap(AutomationInput $input): array
    {
        return [
            'sector' => array_filter([$input->sector]),
            'company_size' => array_filter([$input->companySize]),
            'tools' => $input->tools,
            'repetitive_hours' => array_filter([$input->repetitiveHours]),
            'customer_management' => array_filter([$input->customerManagement]),
            'quotations' => array_filter([$input->quotations]),
            'follow_up' => array_filter([$input->followUp]),
            'documents' => $input->documents,
            'communication' => $input->communication,
            'hourly_cost' => array_filter([$input->hourlyCost]),
        ];
    }

    /**
     * @param  array<string, array<string, int>>  $triggers
     * @param  array<string, list<string>>  $answers
     */
    private function scoreProcess(array $triggers, array $answers): int
    {
        $total = 0;
        foreach ($triggers as $field => $optionPoints) {
            $selected = $answers[$field] ?? [];
            if (! is_array($optionPoints) || $selected === []) {
                continue;
            }
            foreach ($selected as $option) {
                $total += (int) ($optionPoints[$option] ?? 0);
            }
        }

        return max(0, $total);
    }

    private function potentialFor(int $score): string
    {
        return match (true) {
            $score >= 7 => 'Alto potencial',
            $score >= 4 => 'Potencial medio/alto',
            $score >= 2 => 'Potencial medio',
            default => 'Potencial bajo',
        };
    }
}
