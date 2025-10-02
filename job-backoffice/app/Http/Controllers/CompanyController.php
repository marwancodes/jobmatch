<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    
    public $industries = [
        'Technology',
        'Finance',
        'Healthcare',
        'Education',
        'Retail',
        'Manufacturing',
        'other',
    ];

    public function index(Request $request)
    {
        // Active
        $query = Company::latest();

        // Archived
        if ($request->has('archived') == 'true') {
            $query->onlyTrashed();
        }

        $companies = $query->paginate(5)->onEachSide(1);

        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;

        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validated = $request->validated();

        // Create owner 
        $owner = User::create([
            'name'=> $validated['owner_name'],
            'email'=> $validated['owner_email'],
            'password'=> Hash::make($validated['owner_password']),
            'role' => 'company-owner',
        ]);

        // Return error if owner creation fails
        if (!$owner) {
            return redirect()->route('companies.create')->with('error', 'Failed to create company owner.');
        }

        // create company
        Company::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website'],
            'ownerId' => $owner->id,
        ]);

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);

        $applications = JobApplication::with('user')->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'))->get();
        return view('company.show', compact('company', 'applications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);
        $industries = $this->industries;
        return view('company.edit', compact('company', 'industries')); // compact means to pass the variable to the view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $company = Company::findOrFail($id);

        $company->update([
            'name'=> $validated['name'],
            'address'=> $validated['address'],
            'industry'=> $validated['industry'],
            'website'=> $validated['website'],
        ]);

        // Update Owner as well
        $ownerData = [];
        $ownerData['name'] = $validated['owner_name'];

        if ($validated['owner_password']) {
            $ownerData['password'] = Hash::make($validated['owner_password']);
        }

        $company->owner->update($ownerData);

        if ($request->query('redirectToList') == 'true') {
            return redirect()->route('companies.show', $id)->with('success', 'Company updated successfully.');
        }
        
        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company archived successfully.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('companies.index', ['archived' => 'true'])->with('success', 'Company restored successfully.');
    }
}
