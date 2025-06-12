<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Models\FamilyType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Event::with(['eventType', 'familyType', 'user']);

        if (! $user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        }

        $events = $query->latest()->get();

        return Inertia::render('Admin/Events/Index', [
            'events' => $events,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Events/Create', [
            'eventTypes' => EventType::all(),
            'familyTypes' => FamilyType::all(),
            'users' => User::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_type_id' => 'required|exists:event_types,id',
            'family_type_id' => 'required|exists:family_types,id',
            'biological_children' => 'required|integer|min:0',
            'foster_children' => 'required|integer|min:0',
            'disabled_children' => 'required|integer|min:0',
            'disabled_adults' => 'required|integer|min:0',
            'children_in_family' => 'required|integer|min:0',
            'children_in_institution' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Событие успешно создано');
    }

    public function edit(Event $event)
    {
        return Inertia::render('Admin/Events/Edit', [
            'event' => $event->load(['eventType', 'familyType', 'user']),
            'eventTypes' => EventType::all(),
            'familyTypes' => FamilyType::all(),
            'users' => User::all(),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'event_type_id' => 'required|exists:event_types,id',
            'family_type_id' => 'required|exists:family_types,id',
            'biological_children' => 'required|integer|min:0',
            'foster_children' => 'required|integer|min:0',
            'disabled_children' => 'required|integer|min:0',
            'disabled_adults' => 'required|integer|min:0',
            'children_in_family' => 'required|integer|min:0',
            'children_in_institution' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Событие успешно обновлено');
    }

    public function destroy(Event $event)
    {
        try {
            $event->delete();

            return redirect()->back()
                ->with('success', 'Событие успешно удалено');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении события');
        }
    }
}
