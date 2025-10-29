<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyLookupController;

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

// Company lookup by starting letter (A-Z) or '#' for others
Route::get('companies/{letter}', [CompanyLookupController::class, 'index']);
