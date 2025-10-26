<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = Track::latest()->paginate(20);

        return view('admin.tracks.index', compact('tracks'));
    }

    public function create()
    {
        return view('admin.tracks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tracks,name',
            'slug' => 'required|string|max:255|unique:tracks,slug',
            'description' => 'nullable|string',
        ]);

        Track::create($data);

        return redirect()->route('admin.tracks.index')->with('success', 'Track created.');
    }

    public function edit(Track $track)
    {
        return view('admin.tracks.edit', compact('track'));
    }

    public function update(Request $request, Track $track)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tracks,name,' . $track->id,
            'slug' => 'required|string|max:255|unique:tracks,slug,' . $track->id,
            'description' => 'nullable|string',
        ]);

        $track->update($data);

        return redirect()->route('admin.tracks.index')->with('success', 'Track updated.');
    }

    public function destroy(Track $track)
    {
        $track->delete();

        return redirect()->route('admin.tracks.index')->with('success', 'Track deleted.');
    }
}

