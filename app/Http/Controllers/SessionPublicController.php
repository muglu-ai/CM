<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionPublicController extends Controller
{
    public function index(Request $request)
    {
        // If sessions use the event_day column (day1, day2...), prefer that for tabs/grouping.
        $usesEventDay = Session::query()->whereNotNull('event_day')->exists();

        $days = [];

        if ($usesEventDay) {
            // Get distinct event_day values and sort by numeric suffix
            $distinct = Session::query()
                ->whereNotNull('event_day')
                ->select('event_day')
                ->groupBy('event_day')
                ->get()
                ->pluck('event_day')
                ->toArray();

            // Normalize and sort by number
            usort($distinct, function ($a, $b) {
                preg_match('/(\d+)/', $a, $ma);
                preg_match('/(\d+)/', $b, $mb);
                $na = isset($ma[1]) ? (int)$ma[1] : 0;
                $nb = isset($mb[1]) ? (int)$mb[1] : 0;
                return $na <=> $nb;
            });

            foreach ($distinct as $i => $d) {
                // try to find a representative date for display (first session's starts_at for that event_day)
                $rep = Session::query()->where('event_day', $d)->whereNotNull('starts_at')->orderBy('starts_at')->value('starts_at');
                $label = $rep ? date('Y-m-d', strtotime($rep)) : strtoupper($d);
                $days[$i + 1] = $label;
            }
        } else {
            // gather distinct session dates (Y-m-d) sorted
            $dates = Session::query()
                ->whereNotNull('starts_at')
                ->select(DB::raw("date(starts_at) as day"))
                ->groupBy('day')
                ->orderBy('day')
                ->pluck('day')
                ->toArray();

            // map day numbers to dates: Day 1 => dates[0]
            foreach ($dates as $i => $d) {
                $days[$i + 1] = $d;
            }
        }

        $format = $request->query('format');
        $day = (int) $request->query('day');
        $q = $request->query('q');
        $trackId = $request->query('track_id');

        // Build the filtered query used for pagination / filters
        $sessionsQuery = Session::with(['event','speakers','track'])
            ->when($day && isset($days[$day]) && !empty($days[$day]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $days[$day]), function ($query) use ($days, $day) {
                $query->whereDate('starts_at', $days[$day]);
            })
            ->when($format, function ($query) use ($format) {
                $query->where('format', $format);
            })
            ->when($trackId, function ($query) use ($trackId) {
                $query->where('track_id', $trackId);
            })
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhereHas('speakers', function ($s) use ($q) {
                            $s->where('name', 'like', "%{$q}%");
                        });
                });
            })
            ->orderBy('starts_at');

        // Get the full unfiltered collection so views that group by track/day can use the complete schedule
        $allSessions = Session::with(['event','speakers','track'])->orderBy('starts_at')->get();

        $sessions = $sessionsQuery->paginate(12)->withQueryString();

        // distinct formats for filter
        $formats = Session::query()->whereNotNull('format')->groupBy('format')->orderBy('format')->pluck('format')->toArray();

        // available tracks for filter
        $tracks = Track::orderBy('name')->get();

        return view('sessions.index', compact('sessions','allSessions','days','formats','tracks','day','format','q','trackId'));
    }
}
