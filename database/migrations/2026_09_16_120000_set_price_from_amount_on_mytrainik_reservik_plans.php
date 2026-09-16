<?php

use App\Models\Project;
use Illuminate\Database\Migrations\Migration;

/*
 * Setea el campo estructurado `price_from_amount` (numerico, EUR) en el primer plan
 * del pricing table de MyTrainik y Reservik.
 *
 * El precio publicado en la landing es unitario ("2 €/mes por usuario", "15 €/mes por
 * pista"), pero el minimo facturable real es distinto por el minimo de contratacion.
 * Google usa este numero en Product > offers > price para rich results, y mostrar
 * "2 €/mes" seria enganoso porque nadie factura menos de 10 €/mes en MyTrainik.
 *
 * Valores acordados con negocio (2026-09-16):
 *   - MyTrainik: 10 EUR/mes (2 € × 5 usuarios min, sin IVA).
 *   - Reservik: 15 EUR/mes (1 pista, sin IVA).
 *
 * Idempotente: si el campo ya esta al valor esperado, no hace nada.
 */
return new class extends Migration
{
    private const AMOUNTS = [
        1 => 10.0, // MyTrainik
        2 => 15.0, // Reservik
    ];

    public function up(): void
    {
        foreach (self::AMOUNTS as $projectId => $amount) {
            $this->setFirstPlanAmount($projectId, $amount);
        }
    }

    public function down(): void
    {
        foreach (array_keys(self::AMOUNTS) as $projectId) {
            $this->setFirstPlanAmount($projectId, null);
        }
    }

    private function setFirstPlanAmount(int $projectId, ?float $amount): void
    {
        $project = Project::with('pricingTable')->find($projectId);
        if (! $project || ! $project->pricingTable) {
            return;
        }

        $pricing = $project->pricingTable;
        $plans = is_array($pricing->plans) ? $pricing->plans : [];
        if (! isset($plans[0]) || ! is_array($plans[0])) {
            return;
        }

        if ($amount === null) {
            unset($plans[0]['price_from_amount']);
        } else {
            $plans[0]['price_from_amount'] = $amount;
        }

        $pricing->plans = $plans;
        $pricing->save();
    }
};
