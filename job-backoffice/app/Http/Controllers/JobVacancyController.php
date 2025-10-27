<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         // Active
        $query = JobVacancy::latest();

        if (Auth::user()->role == 'company-owner') {
            $query->where('companyId', Auth::user()->company->first()->id);
        }

        // Archived
        if ($request->has('archived') == 'true') {
            $query->onlyTrashed();
        }

        $jobVacancies = $query->paginate(5)->onEachSide(1);

        return view('job-vacancy.index', compact('jobVacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        return view('job-vacancy.create', compact('companies', 'jobCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $validated = $request->validated();
        JobVacancy::create($validated);
        return redirect()->route('job-vacancies.index')->with('success','Job Vacancy created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::find($id);
        return view('job-vacancy.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $companies = Company::all();
        $jobCategories = JobCategory::all();

        return view('job-vacancy.edit', compact('jobVacancy', 'companies', 'jobCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->update($validated);

        if ($request->query('redirectToList') == 'false') {
            // if editing from index, go back to index
            return redirect()->route('job-vacancies.show', $id)->with('success', 'Job Vacancy updated successfully.');
        }

        return redirect()->route('job-vacancies.index')->with('success','Job Vacancy updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();

        return redirect()->route('job-vacancies.index')->with('success', 'Job Vacancy archived successfully.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id) {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $jobVacancy->restore();

        return redirect()->route('job-vacancies.index', ['archived' => 'true'])->with('success', 'Job Vacancy restored successfully.');
    }
}
