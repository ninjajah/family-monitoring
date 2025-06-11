<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventTypeController extends Controller
{
    public function index()
    {
        $EventTypes = EventType::with('user')->latest()->get();

        return Inertia::render('Admin/EventTypes/Index', [
            'eventTypes' => $EventTypes,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/EventTypes/Create', [
            'users' => User::role('admin')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        EventType::create($validated);

        return redirect()->route('admin.event_types.index')
            ->with('success', 'Тип события успешно создан');
    }

    public function edit(EventType $eventType)
    {
        return Inertia::render('Admin/EventTypes/Edit', [
            'eventType' => $eventType->load('user'),
            'users' => User::role('admin')->get(),
        ]);
    }

    public function update(Request $request, EventType $eventType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $eventType->update($validated);

        return redirect()->route('admin.event_types.index')
            ->with('success', 'Тип события успешно обновлён');
    }

    public function destroy(EventType $eventType)
    {
        try {
            $eventType->delete();

            return redirect()->back()
                ->with('success', 'Тип события успешно удалён');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении типа события');
        }
    }
}
