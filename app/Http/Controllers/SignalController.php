<?php

namespace App\Http\Controllers;

use App\Models\Signal;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class SignalController extends Controller
{
    public function index()
    {
        $signals = Signal::with('user')->latest()->get();
        return Inertia::render('Admin/Signals/Index', [
            'signals' => $signals
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Signals/Create', [
            'users' => User::role('admin')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id'
        ]);

        Signal::create($validated);

        return redirect()->route('admin.signals.index')
            ->with('success', 'Сигнал успешно создан');
    }

    public function edit(Signal $signal)
    {
        return Inertia::render('Admin/Signals/Edit', [
            'signal' => $signal->load('user'),
            'users' => User::role('admin')->get(),
        ]);
    }

    public function update(Request $request, Signal $signal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id'
        ]);

        $signal->update($validated);

        return redirect()->route('admin.signals.index')
            ->with('success', 'Сигнал успешно обновлён');
    }

    public function destroy(Signal $signal)
    {
        try {
            $signal->delete();

            return redirect()->back()
                ->with('success', 'Сигнал успешно удалён');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ошибка при удалении сигнала');
        }
    }
}
