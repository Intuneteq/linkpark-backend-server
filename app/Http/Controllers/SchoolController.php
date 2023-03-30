<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Http\Resources\SchoolResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::query()->paginate(10);
        return SchoolResource::collection($schools);
    }

    public function store(StoreSchoolRequest $request)
    {
        $school = School::query()->create([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'email' => $request->email
        ]);
        return new SchoolResource($school);
    }

    public function show(School $school)
    {
        return new SchoolResource($school);
    }

    public function update(UpdateSchoolRequest $request, School $school)
    {
        $updated = $school->update([
            'name' => $request->name ?? $school->name,
            'address' => $request->address ?? $school->address,
            'city' => $request->city ?? $school->city,
            'state' => $request->state ?? $school->state,
            'country' => $request->country ?? $school->country,
            'email' => $request->email ?? $school->email
        ]);

        if (!$updated) {
            return new JsonResponse([
                'error' => ['Failed to update']
            ], 400);
        }
        return new SchoolResource($school);
    }

    public function destroy(School $school)
    {
        $deleted = $school->forceDelete();

        if (!$deleted) {
            return new JsonResponse([
                'error' => ['could not delete resource']
            ], 400);
        }

        return new JsonResponse([
            'data' => 'deleted'
        ]);
    }
}
