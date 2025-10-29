<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanyLookupController extends Controller
{
    /**
     * Return JSON list of company names from external applications DB.
     *
     * @param string $letter A-Z (case-insensitive) to filter by first letter, or '#' for non-alphabetic
     */
    public function index(string $letter)
    {
        $connection = DB::connection('applications');

        $query = $connection->table('applications')
            ->select('company_name')
            ->whereNotNull('company_name');

        $letter = trim($letter);

        if ($letter === '#') {
            // Company names NOT starting with A-Z
            $query->whereRaw("company_name NOT REGEXP '^[A-Za-z]'");
        } else {
            $first = Str::upper(Str::substr($letter, 0, 1));
            if (!preg_match('/^[A-Z]$/', $first)) {
                return response()->json([ 'error' => 'Invalid letter' ], 422);
            }
            $query->where('company_name', 'LIKE', $first . '%');
        }

        $companies = $query
            ->distinct()
            ->orderBy('company_name')
            ->pluck('company_name');

        return response()->json($companies);
    }
}


