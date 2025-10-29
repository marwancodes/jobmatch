<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index (Request $request) {

        $query = JobVacancy::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%') // fuzzy search which matches any part of the title
                ->orWhere('location', 'like', '%' . $request->input('search') . '%') // for searching in location
                ->orWhereHas('company', function ($q) use ($request) { // for searching in related company name
                    $q->where('name', 'like', '%' . $request->input('search') . '%');
                });
        }

        if ($request->has('filter')) {
            $query->where('type', $request->input('filter'));
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();
        return view('dashboard', compact('jobs'));
    }
}
