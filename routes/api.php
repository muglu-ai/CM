<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Minimal route that returns all tracks that have speakers, with each
| track's speakers as an array of speaker names. Intended for simple API use.
|
*/

Route::get('tracks-with-speakers', [\App\Http\Controllers\SpeakerController::class, 'speakersAPI']);
