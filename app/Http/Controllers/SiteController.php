<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Models\FamilyType;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'eventTypes' => EventType::all(),
            'familyTypes' => FamilyType::all(),
            'users' => User::all(),
        ]);

    }
}
