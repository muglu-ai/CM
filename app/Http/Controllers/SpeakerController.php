<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use App\Models\Track;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    /**
     * Display a listing of speakers grouped by track (only tracks that have speakers).
     */
    public function index()
    {
        // Fetch tracks that have at least one speaker, eager-load speakers and order them by name
        $tracks = Track::whereHas('speakers')
            ->with(['speakers' => function ($q) {
                $q->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        return view('speakers.index', compact('tracks'));
    }


    public function speakersAPI()
    {
        // Define the track sequence order
        $trackSequence = [
            'TRENDS STAGE (IT & DeepTech)',
            'CIRCUIT STAGE (Electronics & Semicon)',
            'LIFE STAGE (Digihealth & Biotech)',
            'Startup Stage I',
            'Startup Stage II',
            'World Stage-1 (GIA)',
            'World Stage-2 (GIA)'
        ];

        $tracks = Track::whereHas('speakers')
            ->with(['speakers' => function ($q) {
                // select only needed columns to keep payload small and order speakers by name
                $q->select(
                    'speakers.id',
                    'speakers.name',
                    'speakers.title',
                    'speakers.company',
                    'speakers.linkedin',
                    'speakers.image_path',

                )->orderBy('name');
            }])
            ->select('id', 'name', 'slug')
            ->get();

        // Sort tracks according to the defined sequence
        $sortedTracks = $tracks->sortBy(function ($track) use ($trackSequence) {
            $index = array_search($track->name, $trackSequence);
            return $index !== false ? $index : 999; // Put unknown tracks at the end
        });

        $payload = $sortedTracks->map(function ($t) {
            return [
                'id' => $t->id,
                'name' => $t->name,
                'speakers' => $t->speakers->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->name,
                        'title' => $s->title,
                        'company' => $s->company,
                        'linkedin' => $s->linkedin,
                        'image_path' => $s->image_url,
                    ];
                })->values(),
            ];
        })->values();

        return response()->json($payload);
    }

    public function speakersAPI2()
    {
        $tracks = Track::whereHas('speakers')
            ->with(['speakers' => function ($q) {
                // select only needed columns to keep payload small and order speakers by name
                $q->select(
                    'speakers.id',
                    'speakers.name',
                    'speakers.title',
                    'speakers.company',
                    'speakers.linkedin',
                    'speakers.image_path',

                )->orderBy('name');
            }])
            ->select('id', 'name', 'slug')
            ->orderBy('name')
            ->get();

        $payload = $tracks->map(function ($t) {
            return [
                'id' => $t->id,
                'name' => $t->name,
                'speakers' => $t->speakers->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'name' => $s->name,
                        'title' => $s->title,
                        'company' => $s->company,
                        'linkedin' => $s->linkedin,
                        'image_path' => $s->image_url,
                    ];
                })->values(),
            ];
        })->values();

        return response()->json($payload);
    }

}
