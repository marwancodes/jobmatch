<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;

class JobVacancyController extends Controller
{
    public function show(string $id) {

        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job-vacancies.show', compact('jobVacancy'));
    }

    public function apply(string $id) {

        $jobVacancy = JobVacancy::findOrFail($id);

        return view('job-vacancies.apply', compact('jobVacancy'));
    }

    public function proccessApplication(ApplyJobRequest $request, string $id) {

        $file = $request->file('resume_file');

        $extension = $file->getClientOriginalExtension();
        $originalFileName = $file->getClientOriginalName();
        $fileName = 'resume_' . time() . '.' . $extension;

        // Store in Laravel Cloud
        $path = $file->storeAs('resumes', $fileName, 'cloud');

        // $fileUrl = config('filesystems.disks.cloud.url') . '/' . $path;

        $resume = Resume::create([
            'filename' => $originalFileName,
            'fileUri' => $path,
            'userId' => Auth::id(),
            'contactDetails' => json_encode([
                'name' => Auth::user()->name,
                'email' => Auth::user()->name,
            ]),
            "summary" => '',
            "skills" => '',
            "experience" => '',
            "education" => ''
        ]);

        JobApplication::create([
            'status' => 'pending',
            'jobVacancyId' => $id,
            'resumeId' => $resume->id,
            'userId' => Auth::id(),
            'aiGeneratedScore' => 0,
            'aiGeneratedFeedback' => ''
        ]);

        return redirect()->route('job-applications.index')->with('success', 'Application submitted successfully');
    }




    
    /**Test OpenAI */
    // public function testOpenAI() {
    //     $response = OpenAI::responses()->create([
    //         'model' => 'gpt-4o-mini',
    //         'input' => 'Hello!',
    //     ]);

    //     echo $response->outputText; // Hello! How can I assist you today?
    // }

}
