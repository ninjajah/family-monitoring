<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Models\FamilyType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Reports/Index',[
            'familyTypes' => FamilyType::all()->toArray()
        ]);
    }

    public function newChildren(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'family_type_id' => 'nullable|exists:family_types,id'
        ]);

        $query = Event::where('event_type_id', 1) // Тип "Принята на сопровождение"
        ->whereBetween('created_at', [
            $validated['start_date'] . ' 00:00:00',
            $validated['end_date'] . ' 23:59:59'
        ])
            ->with(['eventType', 'familyType'])
            ->orderBy('created_at', 'desc'); // Сортировка по дате (новые сначала)

        if (!empty($validated['family_type_id'])) {
            $query->where('family_type_id', $validated['family_type_id']);
        }

        $events = $query->get();

        $stats = [
            'families_count' => $events->count(),
            'children_count' => $events->sum('children_affected'),
            'biological_children' => $events->sum('biological_children'),
            'foster_children' => $events->sum('foster_children'),
            'disabled_children' => $events->sum('disabled_children'),
            'in_family' => $events->sum('children_in_family'),
            'in_institution' => $events->sum('children_in_institution')
        ];

        return Inertia::render('Admin/Reports/Index', [
            'newChildren' => [
                'period' => [
                    'start' => $validated['start_date'],
                    'end' => $validated['end_date']
                ],
                'stats' => $stats,
                'events' => $events
            ],
            'filters' => $request->only(['start_date', 'end_date', 'family_type_id']),
            'familyTypes' => FamilyType::all()->toArray()
        ]);
    }

    public function currentStatus(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'family_type_id' => 'nullable|exists:family_types,id'
        ]);

        $subQuery = Event::where('created_at', '<=', $validated['date'] . ' 23:59:59')
            ->selectRaw('
            family_type_id,
            MAX(created_at) as last_event_date
        ')
            ->groupBy('family_type_id');

        $query = Event::joinSub($subQuery, 'last_events', function($join) {
            $join->on('events.family_type_id', '=', 'last_events.family_type_id')
                ->on('events.created_at', '=', 'last_events.last_event_date');
        })
            ->where('event_type_id', 2)
            ->with(['eventType', 'familyType'])
            ->orderBy('events.created_at', 'desc'); // Сортировка по дате (новые сначала)

        if (!empty($validated['family_type_id'])) {
            $query->where('events.family_type_id', $validated['family_type_id']);
        }

        $events = $query->get();

        return Inertia::render('Admin/Reports/Index', [
            'currentStatus' => [
                'date' => $validated['date'],
                'stats' => [
                    'families_count' => $events->count(),
                    'children_count' => $events->sum('children_affected'),
                    'by_family_type' => $events->groupBy('family_type_id')->map(function($group) {
                        return [
                            'count' => $group->count(),
                            'children' => $group->sum('children_affected')
                        ];
                    })
                ],
                'events' => $events
            ],
            'filters' => $request->only(['date', 'family_type_id']),
            'familyTypes' => FamilyType::all()->toArray()
        ]);
    }
}
