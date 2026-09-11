<?php

namespace App\Services\Automatiza;

final class ProcessRecommendation
{
    public function __construct(
        public readonly string $key,
        public readonly string $title,
        public readonly string $reason,
        public readonly string $solution,
        public readonly int $score,
        public readonly string $potentialLabel,
    ) {
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'title' => $this->title,
            'reason' => $this->reason,
            'solution' => $this->solution,
            'score' => $this->score,
            'potential_label' => $this->potentialLabel,
        ];
    }
}
