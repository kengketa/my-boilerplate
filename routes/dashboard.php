<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Dashboard\AnnouncementController;
use App\Http\Controllers\RoleController;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('dashboard')->as('dashboard.')->group(function () {
        Route::get('/', [PageController::class, 'dashboard'])->name('index');

        //Role
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

        //Announcement
        Route::get('/announcements', [AnnouncementController::class, 'index'])
            ->name('announcements.index');
        Route::get('/announcements/create', [AnnouncementController::class, 'create'])
            ->name('announcements.create');
        Route::post('/announcements', [AnnouncementController::class, 'store'])
            ->name('announcements.store');
        Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])
            ->name('announcements.show');
        Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])
            ->name('announcements.edit');
        Route::patch('/announcements/{announcement}', [AnnouncementController::class, 'update'])
            ->name('announcements.update');
        Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])
            ->name('announcements.destroy');
    });
});


