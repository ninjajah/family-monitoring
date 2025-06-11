<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Models\FamilyType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EventController extends Controller
{
    /**
     * @throws HttpException
     */
    protected function checkEventPermissions(Event $event)
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return;
        }

        if ($event->user_id !== $user->id) {
            abort(403, 'Вы можете работать только со своими событиями');
        }
    }

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
        $validator = Validator::make($request->all(), [
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

        $validator->after(function ($validator) use ($request) {
            $childrenSum =
                $request->biological_children +
                $request->foster_children +
                $request->disabled_children +
                $request->children_in_family +
                $request->children_in_institution;

            if ($childrenSum <= 0) {
                $validator->errors()->add(
                    'biological_children',
                    'Хотя бы одно поле с количеством детей должно быть больше нуля'
                );
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['children_affected'] =
            $validated['biological_children'] +
            $validated['foster_children'] +
            $validated['disabled_children'] +
            $validated['children_in_family'] +
            $validated['children_in_institution'];

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Событие успешно создано');
    }

    public function edit(Event $event)
    {
        $this->checkEventPermissions($event);

        return Inertia::render('Admin/Events/Edit', [
            'event' => $event->load(['eventType', 'familyType', 'user']),
            'eventTypes' => EventType::all(),
            'familyTypes' => FamilyType::all(),
            'users' => User::all(),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $this->checkEventPermissions($event);

        $validated = $request->validate([
            'event_type_id' => 'required|exists:event_types,id',
            'family_type_id' => 'required|exists:family_types,id',
            'children_affected' => 'required|integer|min:0',
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
            $this->checkEventPermissions($event);

            $event->delete();

            return redirect()->back()
                ->with('success', 'Событие успешно удалено');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении события');
        }
    }
}
