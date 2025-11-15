<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Services\ResumeAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;

class JobVacancyController extends Controller
{
    protected $resumeAnalysisService;

    public function __construct(ResumeAnalysisService $resumeAnalysisService) 
    {
        $this->resumeAnalysisService = $resumeAnalysisService;
    }

    public function show(string $id) {

        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job-vacancies.show', compact('jobVacancy'));
    }

    public function apply(string $id) {

        $jobVacancy = JobVacancy::findOrFail($id);
        $resumes = Auth::user()->resumes;

        return view('job-vacancies.apply', compact('jobVacancy', 'resumes'));
    }

    public function proccessApplication(ApplyJobRequest $request, string $id) {

        $resumeId = null;
        $extractedInfo = null;

        if ($request->input('resume_option') === 'new_resume') {
            
            $file = $request->file('resume_file');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = $file->getClientOriginalName();
            $fileName = 'resume_' . time() . '.' . $extension;
    
            // Store in Laravel Cloud
            $path = $file->storeAs('resumes', $fileName, 'cloud');
    
            $fileUrl = config('filesystems.disks.cloud.url') . '/' . $path;
    

            $extractedInfo = $this->resumeAnalysisService->extractionResumeInformation($fileUrl);
            // $extractedInfo = [
            //     "summary" => '',
            //     "skills" => '',
            //     "experience" => '',
            //     "education" => ''
            // ];

            $resume = Resume::create([
                'filename' => $originalFileName,
                'fileUri' => $path,
                'userId' => Auth::id(),
                'contactDetails' => json_encode([
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ]),
                "summary" => is_array($extractedInfo['summary']) ? implode(', ', $extractedInfo['summary']) : $extractedInfo['summary'],
                "skills" => is_array($extractedInfo['skills']) ? implode(', ', $extractedInfo['skills']) : $extractedInfo['skills'],
                "experience" => is_array($extractedInfo['experience']) ? implode(', ', $extractedInfo['experience']) : $extractedInfo['experience'],
                "education" => is_array($extractedInfo['education']) ? implode(', ', $extractedInfo['education']) : $extractedInfo['education'],
            ]);
            
            $resumeId = $resume->id;
    
        } else {
            $resumeId = $request->input('resume_option');
            $resume = Resume::findOrFail($resumeId);

            $extractedInfo = [
                "summary" => $resume->summary,
                "skills" => $resume->skills,
                "experience" => $resume->experience,
                "education" => $resume->education
            ];
        }

        // TODO: Evalute Job Application
        // Use the $extractedInfo to evalute the job application
        
        JobApplication::create([
            'status' => 'pending',
            'jobVacancyId' => $id,
            'resumeId' => $resumeId,
            'userId' => Auth::id(),
            'aiGeneratedScore' => 0,
            'aiGeneratedFeedback' => ''
        ]);

        return redirect()->route('job-applications.index', $id)->with('success', 'Application submitted successfully');
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
