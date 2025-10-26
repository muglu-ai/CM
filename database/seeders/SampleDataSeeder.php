<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Session;
use App\Models\Speaker;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create an admin user (password: password) if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                // Note: UserFactory hashes password; when creating manually we can set plain and let model cast if available.
                'password' => 'password',
            ]
        );

        // If there are already events present, skip creating sample events/sessions/speakers to avoid duplication
        if (Event::count() > 0) {
            return;
        }

        // Create 2 events
        $events = Event::factory()->count(2)->create();

        foreach ($events as $event) {
            // create 4 sessions per event
            $sessions = Session::factory()->count(4)->for($event)->create();

            // create 6 speakers per event
            $speakers = Speaker::factory()->count(6)->create();

            // attach speakers to sessions with different roles
            foreach ($sessions as $i => $session) {
                // pick 1-3 random speakers
                $selected = $speakers->random(rand(1, 3));

                foreach ($selected as $idx => $speaker) {
                    $roles = ['Presenter', 'Co-presenter', 'Moderator', 'Panelist'];
                    $role = $roles[($i + $idx) % count($roles)];

                    $session->speakers()->attach($speaker->id, ['role' => $role]);
                }
            }
        }
    }
}
