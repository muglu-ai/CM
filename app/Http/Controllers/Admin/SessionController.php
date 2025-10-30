<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\Event;
use App\Models\Speaker;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::with(['event', 'track'])->latest()->paginate(20);

        return view('admin.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $events = Event::orderBy('name')->get();
        $tracks = Track::orderBy('name')->get();

        return view('admin.sessions.create', compact('events', 'tracks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starts_at' => 'nullable|date_format:Y-m-d\TH:i',
            'ends_at' => 'nullable|date_format:Y-m-d\TH:i',
            'event_day' => 'required|in:Day 1,Day 2,Day 3',
            'track_id' => 'nullable|exists:tracks,id',
            'location' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:255',
        ]);

        // Generate slug from title
        $data['slug'] = Str::slug($data['title']);
        
        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Session::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }


        Session::create($data);

        return redirect()->route('admin.sessions.index')->with('success', 'Session created.');
    }

    public function edit(Session $session)
    {
        $session->load('track');
        $events = Event::orderBy('name')->get();
        $tracks = Track::orderBy('name')->get();

        return view('admin.sessions.edit', compact('session', 'events', 'tracks'));
    }

    public function update(Request $request, Session $session)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starts_at' => 'nullable|date_format:Y-m-d\TH:i',
            'ends_at' => 'nullable|date_format:Y-m-d\TH:i',
            'event_day' => 'required|in:Day 1,Day 2,Day 3',
            'track_id' => 'nullable|exists:tracks,id',
            'location' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:255',
        ]);

        // Generate slug from title
        $data['slug'] = Str::slug($data['title']);
        
        // Ensure slug is unique (excluding current session)
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Session::where('slug', $data['slug'])->where('id', '!=', $session->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }


        $session->update($data);

        return redirect()->route('admin.sessions.index')->with('success', 'Session updated.');
    }

    public function destroy(Session $session)
    {
        $session->delete();

        return redirect()->route('admin.sessions.index')->with('success', 'Session deleted.');
    }

    // Manage speakers attached to a session
    public function manageSpeakers(Session $session)
    {
        $speakers = Speaker::orderBy('name')->get();

        return view('admin.sessions.manage_speakers', compact('session', 'speakers'));
    }

    public function attachSpeaker(Request $request, Session $session)
    {
        $data = $request->validate([
            'speaker_id' => 'required|exists:speakers,id',
            'role' => 'nullable|string|max:255',
        ]);

        $session->speakers()->syncWithoutDetaching([$data['speaker_id'] => ['role' => $data['role'] ?? null]]);

        return redirect()->route('admin.sessions.manageSpeakers', $session)->with('success', 'Speaker attached.');
    }

    public function detachSpeaker(Session $session, Speaker $speaker)
    {
        $session->speakers()->detach($speaker->id);

        return redirect()->route('admin.sessions.manageSpeakers', $session)->with('success', 'Speaker detached.');
    }
}

