<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [SiteController::class, 'index'])->name('site.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])
        ->name('admin.roles.permissions.update');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/event-types', [EventTypeController::class, 'index'])->name('admin.event_types.index');
    Route::get('/event-types/create', [EventTypeController::class, 'create'])->name('admin.event_types.create');
    Route::post('/event-types', [EventTypeController::class, 'store'])->name('admin.event_types.store');
    Route::get('/event-types/{eventType}/edit', [EventTypeController::class, 'edit'])->name('admin.event_types.edit');
    Route::put('/event-types/{eventType}', [EventTypeController::class, 'update'])->name('admin.event_types.update');
    Route::delete('/event-types/{eventType}', [EventTypeController::class, 'destroy'])->name('admin.event_types.destroy');
});

Route::middleware(['auth', 'role:admin|user'])->prefix('admin')->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('admin.events.create');
    Route::post('/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
});

Route::middleware(['auth', 'role:admin|user'])->group(function () {
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/new-children', [ReportController::class, 'newChildren'])->name('admin.reports.new-children');
    Route::get('/admin/reports/current', [ReportController::class, 'currentStatus'])->name('admin.reports.current');
});

require __DIR__.'/auth.php';
