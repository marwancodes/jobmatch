<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        // Last 30 days active users (job-seeker role)
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')->count();

        // Total Jobs (not deleted)
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        // Total Applications (not deleted)
        $totalApplications = JobApplication::whereNull('deleted_at')->count();

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
        ];

        // Most applied jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount') // jobApplications it should match the relationship name in JobVacancy model
            ->orderByDesc('TotalCount') // order by the count of applications
            ->limit(5) // get top 5
            ->whereNull('deleted_at') // exclude deleted jobs
            ->get();  // execute the query

        // Conversion Rates
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
            ->whereNull('deleted_at')
            ->having('totalCount', '>', 0) // only jobs with applications
            ->orderByDesc('TotalCount') // order by the count of applications
            ->limit(5) // get top 5
            ->get()
            ->map(function ($job) {
                if ($job->viewCount > 0) {
                    $job->conversionRate = round(($job->totalCount / $job->viewCount) * 100, 2); // round to 2 decimal places
                } else {
                    $job->conversionRate = 0;
                }
                return $job;
            });


        return view('dashboard.index', compact(['analytics', 'mostAppliedJobs', 'conversionRates']));
    }
}
