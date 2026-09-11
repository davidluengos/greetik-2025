<?php

namespace App\Services\Automatiza;

final class AutomationResult
{
    /**
     * @param  list<ProcessRecommendation>  $recommendations
     */
    public function __construct(
        public readonly int $score,
        public readonly string $scoreLevelKey,
        public readonly string $scoreLevelLabel,
        public readonly float $hoursSavedPerWeek,
        public readonly int $hourlyCost,
        public readonly bool $hourlyCostIsEstimate,
        public readonly int $weeklySaving,
        public readonly int $monthlySaving,
        public readonly int $annualSaving,
        public readonly string $recommendedSolutionKey,
        public readonly string $recommendedSolutionLabel,
        public readonly string $recommendedSolutionDescription,
        public readonly int $investmentMin,
        public readonly int $investmentMax,
        public readonly array $recommendations,
        public readonly array $meta,
    ) {
    }

    public function toStorageArray(): array
    {
        return [
            'score' => $this->score,
            'score_level' => $this->scoreLevelKey,
            'estimated_hours_saved' => (int) round($this->hoursSavedPerWeek),
            'estimated_annual_saving' => $this->annualSaving,
            'recommended_solution_key' => $this->recommendedSolutionKey,
            'estimated_investment_min' => $this->investmentMin,
            'estimated_investment_max' => $this->investmentMax,
            'recommendations' => array_map(
                static fn (ProcessRecommendation $r): array => $r->toArray(),
                $this->recommendations,
            ),
            'meta' => $this->meta,
        ];
    }
}
