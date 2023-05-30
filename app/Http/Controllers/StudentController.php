<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateApiException;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\JsonResponse;
use App\Services\SanityService;
use Request;

class StudentController extends Controller
{
    protected $sanityService;

    public function __construct(SanityService $sanityService)
    {
        $this->sanityService = $sanityService;
    }

    public function getAllSubjects()
    {
        // GROQ query for Student class subjects from sanity studio.
        $query = '*[_type == "jss1" && title == "JSS1A"]{subjects[]{
           "id": _key, title, teacher,
          "image": image.asset->url
        }}';

        try {
            $data = $this->sanityService->fetchData($query);
        } catch (\Throwable $th) {
            throw new CreateApiException($th->getMessage(), 500);
        }


        return new JsonResponse([
            'success' => true,
            'data' => $data[0]['subjects'],
            'message' => 'success'
        ]);
    }

    public function getSubjectById($subjectId)
    {
        // GROQ query for Student class subjects from sanity studio.
        $query = '*[_type == "jss1" && title == "JSS1A"]{subjects[]{
                    "id": _key, title, teacher, outline,
                    "image": image.asset->url
                }}';

        try {
            $data = $this->sanityService->fetchData($query);
        } catch (\Throwable $th) {
            throw new CreateApiException($th->getMessage(), 500);
        }

        // All subjects in a class
        $subjects = $data[0]['subjects'];

        // Find specific subject by it's ID
        $foundSubject = array_filter($subjects, fn ($subject) => $subject['id'] === $subjectId);

        // Extract the object
        $result = reset($foundSubject);

        // If no subject, throw 404 exception
        if(!$result) throw new CreateApiException('subject not found', 404);

        // Number of lessons in subject
        $lessons = count($result['outline']);

        // Student class
        $result['class'] = 'JSS1A';

        // Return number of lessons
        $result['lessons'] = $lessons;


        return new JsonResponse([
            'data' => $result
        ]);
    }
}
