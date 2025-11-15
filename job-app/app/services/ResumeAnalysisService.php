<?php 

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use Spatie\PdfToText\Pdf;

class ResumeAnalysisService {
    public function extractionResumeInformation(string $fileUrl) {

        try {
            // Extract raw text from the resume pdf file (read pdf file, and get the text)
            $rawText = $this->extractTextFromPdf($fileUrl);
    
            Log::debug('Successfully extracted text from pdf file' . strlen($rawText) . 'characters');
    
            // Use OpenAI to organize the text into a structured format
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' =>
                            "You are a precise resume parser.
                            You MUST return a JSON object where *all values are plain strings*. 
                            NEVER return arrays or objects inside any field.

                            Format rules:
                            - summary: a plain text string.
                            - skills: a comma-separated string.
                            - experience: a plain text string describing experience (no arrays, no objects).
                            - education: a plain text string describing education (no arrays, no objects).

                            If a section is not found, return an empty string.

                            IMPORTANT:
                            - Do NOT generate nested JSON.
                            - Do NOT return lists, arrays or objects.
                            - Every field MUST be a clean string only."
                    ],
                    [
                        'role' => 'user',
                        'content' =>
                            "Extract the following resume content and return ONLY a JSON Object with the fields:
                            'summary', 'skills', 'experience', 'education'.

                            Resume content:
                            {$rawText}"
                    ]
                ],
                'response_format' => [
                    'type' => 'json_object'
                ],
                'temperature' => 0.1 // Sets the randomness of the AI response to 0, making it deterministic and focused on the most likely completion
    
            ]);
    
            // Output: summary, skills, experience, education -> JSON
            $result = $response->choices[0]->message->content;
            Log::debug('OpenAI response: ' . $result);
    
            $parsedResult = json_decode($result, true);
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Failed to parse OpenAI response: ' . json_last_error_msg());
                throw new \Exception("Failed to parse OpenAI response");
                
            }
    
            // Validate the parsed result
            $requiredKeys = ['summary', 'skills', 'experience', 'education'];
            $missingKeys = array_diff($requiredKeys, array_keys($parsedResult));
    
            if (count($missingKeys) > 0) {
                Log::error('Missing required keys: ' . implode(', ', $missingKeys));
                throw new \Exception("Missing required keys in the parsed result");
            }
    
    
            // Return the JSON object
            return [
                'summary' => is_array($parsedResult['summary']) ? implode(', ', $parsedResult['summary']) : ($parsedResult['summary'] ?? ''),
                'skills' => is_array($parsedResult['skills']) ? implode(', ', $parsedResult['skills']) : ($parsedResult['skills'] ?? ''),
                'experience' => is_array($parsedResult['experience']) ? implode(', ', $parsedResult['experience']) : ($parsedResult['experience'] ?? ''),
                'education' => is_array($parsedResult['education']) ? implode(', ', $parsedResult['education']) : ($parsedResult['education'] ?? ''),
            ];

        } catch (\Throwable $e) {
            Log::error('Error extracting resume information: ' . $e->getMessage());
            return [
                'summary' => '',
                'skills' => '',
                'experience' => '',
                'education' => '',
            ];
        }
    }

    private function extractTextFromPdf(string $fileUrl) {

        //* Reading the file from the cloud to local storage in temp file
        $tempFile = tempnam(sys_get_temp_dir(), 'resume');

        $filePath = parse_url($fileUrl, PHP_URL_PATH);
        if (!$filePath) {
            throw new \Exception('Invalid file URL');
        }

        $filename = basename($filePath);

        $storagePath = "resumes/{$filename}";

        if (!Storage::disk('cloud')->exists(($storagePath))) {
            throw new \Exception('File not found');
        }

        $pdfContent = Storage::disk('cloud')->get($storagePath);
        if (!$pdfContent) {
            throw new \Exception('Failed to read file');
        }

        file_put_contents($tempFile, $pdfContent);


        //* Check if pdf-to-text is installed
        $pdfToTextPath = ['/usr/local/bin/pdftotext', '/opt/homebrew/bin/pdftext', '/usr/bin/pdftotext'];
        $pdfToTextAvailable = false;

        foreach ($pdfToTextPath as $path) {
            if (file_exists($path)) {
                $pdfToTextAvailable = true;
                break;
            }
        }

        if (!$pdfToTextPath) {
            throw new \Exception('pdf-to-text is not installed');
        }


        //* Extract text from the PDF file
        $instance = new Pdf();
        $instance->setPdf($tempFile);
        $text = $instance->text();


        //* Clean up the temp file
        unlink($tempFile);


        return $text;
    }   
}