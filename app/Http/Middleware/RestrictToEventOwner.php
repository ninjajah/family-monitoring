<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;

class RestrictToEventOwner
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $event = $request->route('event');

        if (! $event instanceof Event) {
            abort(404, 'Событие не найдено');
        }

        if ($user->hasRole('admin') || $event->user_id === $user->id) {
            return $next($request);
        }

        abort(403, 'Вы можете работать только со своими событиями');
    }
}
