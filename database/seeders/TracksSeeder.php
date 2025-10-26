<?php

namespace Database\Seeders;

use App\Models\Track;
use App\Models\Session;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TracksSeeder extends Seeder
{
    public function run(): void
    {
        // Create a few sensible tracks
        $trackNames = ['Web', 'API', 'Security', 'DevOps', 'Data', 'UX'];

        $tracks = collect();

        foreach ($trackNames as $name) {
            $tracks->push(Track::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Sessions related to {$name}",
            ]));
        }

        // Assign tracks to sessions that don't have one
        $sessions = Session::whereNull('track_id')->get();
        if ($sessions->count()) {
            foreach ($sessions as $session) {
                $track = $tracks->random();
                $session->track_id = $track->id;
                $session->save();
            }
        }
    }
}

