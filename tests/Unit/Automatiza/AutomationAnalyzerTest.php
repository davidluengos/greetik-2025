<?php

namespace Tests\Unit\Automatiza;

use App\Services\Automatiza\AutomationAnalyzer;
use App\Services\Automatiza\AutomationInput;
use App\Services\Automatiza\ProcessRecommendationEngine;
use Tests\TestCase;

class AutomationAnalyzerTest extends TestCase
{
    private function analyzer(): AutomationAnalyzer
    {
        return new AutomationAnalyzer(new ProcessRecommendationEngine());
    }

    private function make(array $overrides = []): AutomationInput
    {
        return AutomationInput::fromArray(array_merge([
            'sector' => 'servicios_profesionales',
            'company_size' => '2_5',
            'tools' => ['excel', 'whatsapp', 'email'],
            'repetitive_hours' => '5_10',
            'customer_management' => 'excel',
            'quotations' => 'word_excel',
            'follow_up' => 'aveces',
            'documents' => ['presupuestos', 'facturas'],
            'communication' => ['duplicidad', 'buscar'],
            'main_problem' => null,
            'hourly_cost' => '20',
        ], $overrides));
    }

    public function test_bajo_potencial_para_empresa_ya_automatizada(): void
    {
        $input = $this->make([
            'tools' => ['crm', 'erp', 'app_propia'],
            'repetitive_hours' => 'lt_2',
            'customer_management' => 'crm',
            'quotations' => 'software_especifico',
            'follow_up' => 'no',
            'documents' => ['ninguno'],
            'communication' => [],
        ]);

        $result = $this->analyzer()->analyze($input);

        $this->assertLessThanOrEqual(25, $result->score);
        $this->assertSame('bajo', $result->scoreLevelKey);
    }

    public function test_alto_potencial_para_empresa_muy_manual(): void
    {
        $input = $this->make([
            'sector' => 'construccion',
            'company_size' => '11_25',
            'tools' => ['papel', 'excel', 'whatsapp', 'varias'],
            'repetitive_hours' => 'gt_20',
            'customer_management' => 'ninguno',
            'quotations' => 'manual',
            'follow_up' => 'mucho',
            'documents' => ['presupuestos', 'facturas', 'partes', 'informes', 'contratos'],
            'communication' => ['duplicidad', 'entre_programas', 'seguimiento', 'documentos', 'empleados'],
            'hourly_cost' => '30',
        ]);

        $result = $this->analyzer()->analyze($input);

        $this->assertGreaterThanOrEqual(76, $result->score);
        $this->assertSame('alto', $result->scoreLevelKey);
        $this->assertGreaterThan(0, $result->annualSaving);
        $this->assertGreaterThanOrEqual(3, count($result->recommendations));
    }

    public function test_selecciona_tres_procesos_prioritarios(): void
    {
        $input = $this->make([
            'sector' => 'construccion',
            'quotations' => 'manual',
            'documents' => ['partes', 'presupuestos', 'informes'],
            'communication' => ['duplicidad', 'entre_programas', 'seguimiento'],
            'follow_up' => 'mucho',
        ]);

        $result = $this->analyzer()->analyze($input);

        $this->assertCount(3, $result->recommendations);
        // Con partes de trabajo + sector construccion, "work_orders" debe estar entre los top.
        $keys = array_map(fn ($r) => $r->key, $result->recommendations);
        $this->assertContains('work_orders', $keys);
    }

    public function test_hourly_cost_desconocido_se_marca_como_estimado(): void
    {
        $input = $this->make(['hourly_cost' => 'unknown']);
        $result = $this->analyzer()->analyze($input);

        $this->assertTrue($result->hourlyCostIsEstimate);
        $this->assertSame(config('automatiza.default_hourly_cost'), $result->hourlyCost);
    }

    public function test_ahorro_economico_escala_con_horas_y_coste(): void
    {
        $barato = $this->analyzer()->analyze($this->make([
            'repetitive_hours' => '10_20',
            'hourly_cost' => '10',
        ]));

        $caro = $this->analyzer()->analyze($this->make([
            'repetitive_hours' => '10_20',
            'hourly_cost' => '40',
        ]));

        $this->assertLessThan($caro->annualSaving, $barato->annualSaving);
    }

    public function test_empresa_grande_amplifica_horas_ahorradas(): void
    {
        $pequenia = $this->analyzer()->analyze($this->make([
            'company_size' => 'solo',
            'repetitive_hours' => '5_10',
        ]));

        $grande = $this->analyzer()->analyze($this->make([
            'company_size' => '50_plus',
            'repetitive_hours' => '5_10',
        ]));

        $this->assertGreaterThan($pequenia->hoursSavedPerWeek, $grande->hoursSavedPerWeek);
    }

    public function test_recomienda_solucion_mayor_para_empresas_grandes_con_score_alto(): void
    {
        $input = $this->make([
            'sector' => 'mantenimiento',
            'company_size' => '50_plus',
            'tools' => ['papel', 'excel', 'whatsapp', 'varias'],
            'repetitive_hours' => 'gt_20',
            'customer_management' => 'ninguno',
            'quotations' => 'manual',
            'follow_up' => 'mucho',
            'documents' => ['presupuestos', 'facturas', 'partes', 'informes'],
            'communication' => ['duplicidad', 'entre_programas', 'seguimiento', 'empleados'],
            'hourly_cost' => '30',
        ]);

        $result = $this->analyzer()->analyze($input);

        $this->assertContains($result->recommendedSolutionKey, ['app_completa', 'gestion_personalizada']);
        $this->assertGreaterThan(0, $result->investmentMax);
    }

    public function test_ninguna_solucion_para_score_muy_bajo_y_pocas_horas(): void
    {
        $input = $this->make([
            'tools' => ['crm', 'erp', 'app_propia'],
            'repetitive_hours' => 'lt_2',
            'customer_management' => 'crm',
            'quotations' => 'software_especifico',
            'follow_up' => 'no',
            'documents' => ['ninguno'],
            'communication' => [],
            'company_size' => 'solo',
        ]);

        $result = $this->analyzer()->analyze($input);

        // No forzamos "ninguna" exactamente porque el score puede caer en "mejora_procesos";
        // ambos son aceptables cuando el potencial es bajo.
        $this->assertContains($result->recommendedSolutionKey, ['ninguna', 'mejora_procesos']);
    }

    public function test_ahorro_semanal_mensual_y_anual_son_coherentes(): void
    {
        $result = $this->analyzer()->analyze($this->make([
            'repetitive_hours' => '10_20',
            'hourly_cost' => '25',
        ]));

        $this->assertGreaterThan(0, $result->weeklySaving);
        $this->assertGreaterThan($result->weeklySaving, $result->monthlySaving);
        $this->assertGreaterThan($result->monthlySaving, $result->annualSaving);
    }

    public function test_todas_las_recomendaciones_tienen_estructura_valida(): void
    {
        $result = $this->analyzer()->analyze($this->make([
            'repetitive_hours' => '10_20',
            'documents' => ['presupuestos', 'facturas', 'partes'],
        ]));

        foreach ($result->recommendations as $rec) {
            $this->assertNotEmpty($rec->key);
            $this->assertNotEmpty($rec->title);
            $this->assertNotEmpty($rec->reason);
            $this->assertNotEmpty($rec->solution);
            $this->assertGreaterThan(0, $rec->score);
        }
    }
}
