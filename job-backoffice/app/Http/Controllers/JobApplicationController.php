<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationUpdateRequest;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = JobApplication::latest();

        if (Auth::user()->role == 'company-owner') {
            $query->whereHas('jobVacancy', function ($query) {
                $query->where('companyId', Auth::user()->company->first()->id);
            });
        }

        // Archived
        if ($request->has('archived') == 'true') {
            $query->onlyTrashed();
        }

        $jobApplications = $query->paginate(5)->onEachSide(1);

        return view('job-application.index', compact('jobApplications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('job-application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('job-application.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationUpdateRequest $request, string $id)
    {

        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->update([
            'status' => $request->input('status'),
        ]);

        if ($request->query('redirectToList') == 'false') {
            // if editing from index, go back to index
            return redirect()->route('job-applications.show', $id)->with('success', 'Applicant status updated successfully.');
        }

        return redirect()->route('job-applications.index')->with('success','Applicant status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();

        return redirect()->route('job-applications.index')->with('success', 'Job Application archived successfully.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id) {
        $jobVacancy = JobApplication::withTrashed()->findOrFail($id);
        $jobVacancy->restore();

        return redirect()->route('job-applications.index', ['archived' => 'true'])->with('success', 'Job Vacancy restored successfully.');
    }
}
