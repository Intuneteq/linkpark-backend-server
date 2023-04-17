<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Http\Resources\SchoolResource;
use App\Repositories\SchoolRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        //Get page size from query param for pagination
        $page_size = $request->page_size ?? 10;
        $schools = School::query()->paginate($page_size);
        return SchoolResource::collection($schools);
    }

    public function store(StoreSchoolRequest $request, SchoolRepository $repository)
    {
        $school = $repository->create($request->only([
            'name', 'address', 'city', 'state', 'country', 'email'
        ]));

        return new SchoolResource($school);
    }

    public function show(School $school)
    {
        return new SchoolResource($school);
    }

    public function update(UpdateSchoolRequest $request, School $school, SchoolRepository $repository)
    {
        $school = $repository->update($school, $request->only([
            'name', 'address', 'city', 'state', 'country', 'email'
        ]));
        return new SchoolResource($school);
    }

    public function destroy(School $school, SchoolRepository $repository)
    {
        $deleted = $repository->forceDelete($school);

        return new JsonResponse([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
