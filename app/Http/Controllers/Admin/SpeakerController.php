<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpeakerController extends Controller
{

    public function index()
    {
        // Eager-load tracks to avoid N+1 queries when showing tracks in admin list
        $speakers = Speaker::with('tracks')->latest()->paginate(20);

        return view('admin.speakers.index', compact('speakers'));
    }

    public function create()
    {
        $tracks = Track::orderBy('name')->get();
        return view('admin.speakers.create', compact('tracks'));
    }

    // this is https://bengalurutechsummit.com/img/speakers-25/demo.jpg


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'image_path' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'tracks' => 'nullable|array',
            'tracks.*' => 'integer|exists:tracks,id',
        ]);

        // Generate slug automatically from name
        $data['slug'] = Str::slug($data['name']);

        //we have to set the image path as https://bengalurutechsummit.com/img/speakers-25/demo.jpg
        // instead of demo.jpg we have to set the image name as $data['slug'].jpg
        if (empty($data['image_path'])) {
            $data['image_path'] = 'https://bengalurutechsummit.com/img/speakers-25/' . $data['slug'] . '.jpg';
        }

        $speaker = Speaker::create($data);

        // Sync tracks if provided
        if (!empty($data['tracks'])) {
            $speaker->tracks()->sync($data['tracks']);
        }

        return redirect()->route('admin.speakers.index')->with('success', 'Speaker created.');
    }

    public function edit(Speaker $speaker)
    {
        // Eager-load tracks relationship to avoid extra queries in the view
        $speaker->load('tracks');

        $tracks = Track::orderBy('name')->get();

        // Ensure selected IDs are returned as integers for the multi-select
        $selected = $speaker->tracks->pluck('id')->map(fn($id) => (int) $id)->toArray();

        return view('admin.speakers.edit', compact('speaker', 'tracks', 'selected'));
    }

    public function update(Request $request, Speaker $speaker)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'image_path' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'tracks' => 'nullable|array',
            'tracks.*' => 'integer|exists:tracks,id',
        ]);

        // Generate slug automatically from name
        $data['slug'] = Str::slug($data['name']);

        $speaker->update($data);

        // Sync tracks
        $speaker->tracks()->sync($data['tracks'] ?? []);

        return redirect()->route('admin.speakers.index')->with('success', 'Speaker updated.');
    }

    public function destroy(Speaker $speaker)
    {
        $speaker->delete();

        return redirect()->route('admin.speakers.index')->with('success', 'Speaker deleted.');
    }
}
