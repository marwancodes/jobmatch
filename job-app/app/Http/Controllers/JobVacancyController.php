<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
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

    public function proccessApplication(Request $request, string $id) {
        
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
