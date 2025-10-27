<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\SpeakerController;

//Route::get('/', function () {
//    return view('welcome');
//})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// Public sessions listing with filters & search
Route::get('sessions', [\App\Http\Controllers\SessionPublicController::class, 'index'])->name('sessions.index');

// Public speakers listing (all speakers on one page

Route::get('api/speakers', [SpeakerController::class, 'speakersAPI'])->name('speakers.api.index');
Route::get('/', [SpeakerController::class, 'index'])->name('speakers.index');
Route::get('/', [SpeakerController::class, 'index'])->name('home');
// Admin CRUD for events, sessions and speakers
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Events
    Route::get('events', [\App\Http\Controllers\Admin\EventController::class, 'index'])->name('events.index');
    Route::get('events/create', [\App\Http\Controllers\Admin\EventController::class, 'create'])->name('events.create');
    Route::post('events', [\App\Http\Controllers\Admin\EventController::class, 'store'])->name('events.store');
    Route::get('events/{event}/edit', [\App\Http\Controllers\Admin\EventController::class, 'edit'])->name('events.edit');
    Route::put('events/{event}', [\App\Http\Controllers\Admin\EventController::class, 'update'])->name('events.update');
    Route::delete('events/{event}', [\App\Http\Controllers\Admin\EventController::class, 'destroy'])->name('events.destroy');

    // Sessions
    Route::get('sessions', [\App\Http\Controllers\Admin\SessionController::class, 'index'])->name('sessions.index');
    Route::get('sessions/create', [\App\Http\Controllers\Admin\SessionController::class, 'create'])->name('sessions.create');
    Route::post('sessions', [\App\Http\Controllers\Admin\SessionController::class, 'store'])->name('sessions.store');
    Route::get('sessions/{session}/edit', [\App\Http\Controllers\Admin\SessionController::class, 'edit'])->name('sessions.edit');
    Route::put('sessions/{session}', [\App\Http\Controllers\Admin\SessionController::class, 'update'])->name('sessions.update');
    Route::delete('sessions/{session}', [\App\Http\Controllers\Admin\SessionController::class, 'destroy'])->name('sessions.destroy');

    // Manage session speakers
    Route::get('sessions/{session}/speakers', [\App\Http\Controllers\Admin\SessionController::class, 'manageSpeakers'])->name('sessions.manageSpeakers');
    Route::post('sessions/{session}/speakers', [\App\Http\Controllers\Admin\SessionController::class, 'attachSpeaker'])->name('sessions.attachSpeaker');
    Route::delete('sessions/{session}/speakers/{speaker}', [\App\Http\Controllers\Admin\SessionController::class, 'detachSpeaker'])->name('sessions.detachSpeaker');

    // Speakers
    Route::get('speakers', [\App\Http\Controllers\Admin\SpeakerController::class, 'index'])->name('speakers.index');
    Route::get('speakers/create', [\App\Http\Controllers\Admin\SpeakerController::class, 'create'])->name('speakers.create');
    Route::post('speakers', [\App\Http\Controllers\Admin\SpeakerController::class, 'store'])->name('speakers.store');
    // CSV/Excel import: sample download & import upload
    Route::get('speakers/sample', [\App\Http\Controllers\Admin\SpeakerController::class, 'downloadSample'])->name('speakers.sample');
    Route::post('speakers/import', [\App\Http\Controllers\Admin\SpeakerController::class, 'import'])->name('speakers.import');
    Route::get('speakers/{speaker}/edit', [\App\Http\Controllers\Admin\SpeakerController::class, 'edit'])->name('speakers.edit');
    Route::put('speakers/{speaker}', [\App\Http\Controllers\Admin\SpeakerController::class, 'update'])->name('speakers.update');
    Route::delete('speakers/{speaker}', [\App\Http\Controllers\Admin\SpeakerController::class, 'destroy'])->name('speakers.destroy');

    // Tracks
    Route::get('tracks', [\App\Http\Controllers\Admin\TrackController::class, 'index'])->name('tracks.index');
    Route::get('tracks/create', [\App\Http\Controllers\Admin\TrackController::class, 'create'])->name('tracks.create');
    Route::post('tracks', [\App\Http\Controllers\Admin\TrackController::class, 'store'])->name('tracks.store');
    Route::get('tracks/{track}/edit', [\App\Http\Controllers\Admin\TrackController::class, 'edit'])->name('tracks.edit');
    Route::put('tracks/{track}', [\App\Http\Controllers\Admin\TrackController::class, 'update'])->name('tracks.update');
    Route::delete('tracks/{track}', [\App\Http\Controllers\Admin\TrackController::class, 'destroy'])->name('tracks.destroy');
});
