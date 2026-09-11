<?php

namespace App\Services\Automatiza;

/**
 * DTO inmutable con las respuestas validadas del wizard. Aisla el
 * motor de calculo de la peticion HTTP: los tests inyectan instancias
 * de esta clase directamente sin pasar por controladores.
 */
final class AutomationInput
{
    /**
     * @param  list<string>  $tools
     * @param  list<string>  $documents
     * @param  list<string>  $communication
     */
    public function __construct(
        public readonly ?string $sector,
        public readonly ?string $sectorOther,
        public readonly ?string $companySize,
        public readonly array $tools,
        public readonly ?string $repetitiveHours,
        public readonly ?string $customerManagement,
        public readonly ?string $quotations,
        public readonly ?string $followUp,
        public readonly array $documents,
        public readonly array $communication,
        public readonly ?string $mainProblem,
        public readonly ?string $hourlyCost,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $normalizeList = static function ($value): array {
            if (! is_array($value)) {
                return [];
            }
            $out = [];
            foreach ($value as $item) {
                if (is_string($item) && $item !== '') {
                    $out[] = $item;
                }
            }
            return array_values(array_unique($out));
        };

        return new self(
            sector: isset($data['sector']) ? (string) $data['sector'] : null,
            sectorOther: isset($data['sector_other']) ? trim((string) $data['sector_other']) : null,
            companySize: isset($data['company_size']) ? (string) $data['company_size'] : null,
            tools: $normalizeList($data['tools'] ?? []),
            repetitiveHours: isset($data['repetitive_hours']) ? (string) $data['repetitive_hours'] : null,
            customerManagement: isset($data['customer_management']) ? (string) $data['customer_management'] : null,
            quotations: isset($data['quotations']) ? (string) $data['quotations'] : null,
            followUp: isset($data['follow_up']) ? (string) $data['follow_up'] : null,
            documents: $normalizeList($data['documents'] ?? []),
            communication: $normalizeList($data['communication'] ?? []),
            mainProblem: isset($data['main_problem']) ? trim((string) $data['main_problem']) : null,
            hourlyCost: isset($data['hourly_cost']) ? (string) $data['hourly_cost'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'sector' => $this->sector,
            'sector_other' => $this->sectorOther,
            'company_size' => $this->companySize,
            'tools' => $this->tools,
            'repetitive_hours' => $this->repetitiveHours,
            'customer_management' => $this->customerManagement,
            'quotations' => $this->quotations,
            'follow_up' => $this->followUp,
            'documents' => $this->documents,
            'communication' => $this->communication,
            'main_problem' => $this->mainProblem,
            'hourly_cost' => $this->hourlyCost,
        ];
    }
}
