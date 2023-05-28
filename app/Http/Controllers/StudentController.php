<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\JsonResponse;
use Sanity\Client as SanityClient;

class StudentController extends Controller
{
    public function getAllSubjects()
    {
        $client = new SanityClient([
            'projectId' => env('SANITY_PROJECT_ID'),
            'dataset' => env('SANITY_DATA_SET'),
            'apiVersion' => env('SANITY_API_VERSION'),
            'token' => env('SANITY_API_TOKEN')
        ]);

        $query = '*[_type == "jss1" && title == "JSS1A"]{subjects[]{
            title, teacher,
          "image": image.asset->url
        }}';

        $result = $client->fetch($query);
        return new JsonResponse([
            'success' => true,
            'data' => $result[0],
            'message' => 'success'
        ]);
    }
}
