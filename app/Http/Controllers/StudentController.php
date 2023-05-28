<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateApiException;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\JsonResponse;
use App\Services\SanityService;

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
}
