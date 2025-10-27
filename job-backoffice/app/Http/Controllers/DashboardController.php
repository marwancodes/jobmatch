<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $analytics = $this->adminDashboard();
        } else {
            $analytics = $this->companyOwnerDashboard();
        }

        return view('dashboard.index', compact(['analytics']));
    }

    private function adminDashboard() {

        // Last 30 days active users (job-seeker role)
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')->count();

        // Total Jobs (not deleted)
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        // Total Applications (not deleted)
        $totalApplications = JobApplication::whereNull('deleted_at')->count();


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

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates,
        ];

        return $analytics;
    }

    private function companyOwnerDashboard() {

        $company = Auth::user()->company->first();

        // filter active users by applying to jobs of the company
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')
            ->whereHas('jobApplications', function ($query) use ($company) {
                $query->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'));
            })
            ->count();

        // total jobs of the company
        $totalJobs = $company->jobVacancies->count();

        // total applications to the company's jobs
        $totalApplications = JobApplication::whereIn('jobVacancyId', $company->jobVacancies->pluck('id'))->count();

        // most applied jobs of the company
        $mostAppliedJobs = JobVacancy::withCount('JobApplications as totalCount')
            ->whereIn('id', $company->jobVacancies->pluck('id'))
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get();
        
        // Conversion Rates  of the company
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
            ->whereIn('id', $company->jobVacancies->pluck('id'))
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

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates,
        ];

        return $analytics;
    }
}
