<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AutomationAssessment;
use Illuminate\Http\Request;

class AutomationAssessmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(AutomationAssessment::class, 'assessment');
    }

    public function index(Request $request)
    {
        $filter = $request->query('filter', 'leads');
        $sector = (string) $request->query('sector', '');
        $level = (string) $request->query('level', '');
        $search = trim((string) $request->query('q', ''));

        $query = AutomationAssessment::query()->orderByDesc('created_at');

        if ($filter === 'leads') {
            $query->whereNotNull('contacted_at');
        } elseif ($filter === 'new') {
            $query->whereNotNull('contacted_at')->whereNull('reviewed_at');
        } elseif ($filter === 'anon') {
            $query->whereNull('contacted_at');
        }

        if ($sector !== '') {
            $query->where('sector', $sector);
        }

        if ($level !== '') {
            $query->where('score_level', $level);
        }

        if ($search !== '') {
            $like = '%'.$search.'%';
            $query->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('company', 'like', $like)
                    ->orWhere('phone', 'like', $like);
            });
        }

        $assessments = $query->paginate(20)->withQueryString();

        $stats = [
            'total' => AutomationAssessment::count(),
            'leads' => AutomationAssessment::whereNotNull('contacted_at')->count(),
            'new' => AutomationAssessment::whereNotNull('contacted_at')->whereNull('reviewed_at')->count(),
        ];

        return view('admin.automatiza.index', [
            'assessments' => $assessments,
            'sectors' => (array) config('automatiza.sectors', []),
            'scoreLevels' => (array) config('automatiza.score_levels', []),
            'filter' => $filter,
            'currentSector' => $sector,
            'currentLevel' => $level,
            'search' => $search,
            'stats' => $stats,
        ]);
    }

    public function show(AutomationAssessment $assessment)
    {
        if ($assessment->contacted_at && $assessment->reviewed_at === null) {
            $assessment->forceFill(['reviewed_at' => now()])->save();
        }

        return view('admin.automatiza.show', [
            'assessment' => $assessment,
            'inputLabels' => $this->humanizedInput($assessment),
        ]);
    }

    public function destroy(AutomationAssessment $assessment)
    {
        $assessment->delete();

        return redirect()->route('admin.automatiza-leads.index')
            ->with('status', 'Registro eliminado.');
    }

    private function humanizedInput(AutomationAssessment $assessment): array
    {
        $labels = [
            'sectors' => (array) config('automatiza.sectors', []),
            'company_sizes' => (array) config('automatiza.company_sizes', []),
            'tools' => (array) config('automatiza.tools', []),
            'repetitive_hours' => array_map(
                static fn (array $entry): string => (string) ($entry['label'] ?? ''),
                (array) config('automatiza.repetitive_hours', []),
            ),
            'customer_management' => (array) config('automatiza.customer_management', []),
            'quotations' => (array) config('automatiza.quotations', []),
            'follow_up' => (array) config('automatiza.follow_up', []),
            'documents' => (array) config('automatiza.documents', []),
            'communication' => (array) config('automatiza.communication', []),
            'hourly_costs' => array_map(
                static fn (array $entry): string => (string) ($entry['label'] ?? ''),
                (array) config('automatiza.hourly_costs', []),
            ),
        ];

        $map = static fn (array $labelMap, ?string $value): ?string => $value ? ($labelMap[$value] ?? $value) : null;
        $mapList = static function (array $labelMap, ?array $values): array {
            $out = [];
            foreach ((array) $values as $value) {
                $out[] = $labelMap[$value] ?? $value;
            }
            return $out;
        };

        return [
            'sector' => $map($labels['sectors'], $assessment->sector),
            'company_size' => $map($labels['company_sizes'], $assessment->company_size),
            'tools' => $mapList($labels['tools'], $assessment->tools),
            'repetitive_hours' => $map($labels['repetitive_hours'], $assessment->repetitive_hours),
            'customer_management' => $map($labels['customer_management'], $assessment->customer_management),
            'quotations' => $map($labels['quotations'], $assessment->quotations),
            'follow_up' => $map($labels['follow_up'], $assessment->follow_up),
            'documents' => $mapList($labels['documents'], $assessment->documents),
            'communication' => $mapList($labels['communication'], $assessment->communication),
            'hourly_cost' => $map($labels['hourly_costs'], $assessment->hourly_cost),
        ];
    }
}
