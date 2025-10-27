<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Track;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    /**
     * Download a small CSV sample that matches the expected import columns.
     */
    public function downloadSample()
    {
        $headers = [
            'Name', 'Job Title', 'Company', 'Linkedin',
            'TRENDS STAGE (IT & DeepTech)', 'CIRCUIT STAGE (Electronics & Semicon)', 'LIFE STAGE (Digihealth & Biotech)',
            'STARTUP STAGE I', 'STARTUP STAGE II', 'WORLD STAGE-1 (GIA)', 'WORLD STAGE-2 (GIA)'
        ];

        $rows = [
            $headers,
            ['John Doe', 'Engineer', 'Acme Inc', 'https://linkedin.com/in/johndoe', '1', '', '', '', '', '', '']
        ];

        $filename = 'speakers_sample.csv';

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            foreach ($rows as $row) {
                fputcsv($out, $row);
            }
            fclose($out);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Import speakers from uploaded CSV. Minimal and forgiving.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
        ]);

        $path = $request->file('file')->getRealPath();

        // Use PhpSpreadsheet to load CSV or Excel files so we support .xlsx/.xls/.csv
        try {
            $spreadsheet = IOFactory::load($path);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Unable to read uploaded file: ' . $e->getMessage());
        }

        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        // Convert rows to zero-indexed numeric arrays for simpler handling
        // `toArray()` returns an array keyed by spreadsheet row numbers (1-based).
        // Use array_values on the outer array to reindex to 0..N-1 so $plain[0] exists.
        $plain = array_values(array_map(function ($r) { return array_values($r); }, $rows));
        if (count($plain) === 0) {
            return redirect()->back()->with('error', 'Uploaded file appears empty.');
        }

        $header = $plain[0];
        // Normalize header keys
        $cols = array_map(function ($h) { return trim($h); }, $header);

        // Known speaker fields (case-insensitive match)
        $known = ['name','job title','company','linkedin','title','image','website'];

        $created = 0;
        $updated = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            // Iterate data rows (starting from index 1)
            for ($r = 1, $len = count($plain); $r < $len; $r++) {
                $row = $plain[$r];

                // Skip empty rows
                if (count(array_filter($row, fn($v)=>trim((string)$v) !== '')) === 0) {
                    continue;
                }

                $assoc = [];
                foreach ($cols as $i => $col) {
                    $assoc[$col] = $row[$i] ?? null;
                }

                $name = trim($assoc['Name'] ?? $assoc['name'] ?? '');
                if ($name === '') {
                    $errors[] = 'Missing name on a row, skipping';
                    continue;
                }

                $slug = Str::slug($name);

                //here in image path if (empty($data['image_path'])) {
                //            $data['image_path'] = 'https://bengalurutechsummit.com/img/speakers-25/' . $data['slug'] . '.jpg';
                //        }

                $image_path = 'https://bengalurutechsummit.com/img/speakers-25/' . $slug . '.jpg';

                $data = [
                    'name' => $name,
                    'slug' => $slug,
                    'title' => trim($assoc['Job Title'] ?? $assoc['title'] ?? ''),
                    'company' => trim($assoc['Company'] ?? ''),
                    'linkedin' => trim($assoc['Linkedin'] ?? ''),
                    'image_path' => $image_path,
                    'bio' => null,
                    'website' => null,
                ];

                // Create or update speaker
                $speaker = Speaker::updateOrCreate(['slug' => $slug], $data);
                if ($speaker->wasRecentlyCreated) {
                    $created++;
                } else {
                    $updated++;
                }

                // Map track columns: any column not in known list is treated as a track name
                $trackIds = [];
                foreach ($cols as $i => $col) {
                    $normalized = strtolower(trim($col));
                    if (in_array($normalized, $known)) {
                        continue;
                    }

                    $val = $row[$i] ?? '';
                    // Normalize value and only map when it's exactly '1' (numeric or string)
                    $valNormalized = is_null($val) ? '' : trim((string) $val);
                    if ($valNormalized !== '1') {
                        continue;
                    }

                    $trackName = trim($col);
                    $trackSlug = Str::slug($trackName);

                    $track = Track::firstWhere('slug', $trackSlug) ?? Track::firstWhere('name', $trackName);
                    if (!$track) {
                        // Create track if not found
                        $track = Track::create(['name' => $trackName, 'slug' => $trackSlug]);
                    }

                    $trackIds[] = $track->id;
                }

                if (!empty($trackIds)) {
                    // attach without detaching existing relations
                    $speaker->tracks()->syncWithoutDetaching($trackIds);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // no fopen handle to close when using IOFactory
            return redirect()->back()->with('error', 'Import failed: '.$e->getMessage());
        }


        $msg = "Import complete. Created: $created, Updated: $updated";
        if (!empty($errors)) {
            $msg .= '. Warnings: '.implode('; ', array_slice($errors,0,5));
        }

        return redirect()->route('admin.speakers.index')->with('success', $msg);
    }

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
