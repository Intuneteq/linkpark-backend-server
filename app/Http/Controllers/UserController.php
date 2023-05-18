<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new JsonResponse([
            'data' => 'User'
        ]);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function studentsByGuardianId(User $user, Request $request)
    {
        $user = new UserResource($user);
        $students = $user->getStudents();
        return new JsonResponse([
            'success' => true,
            'data' => $students,
            'message' => 'success'
        ]);
    }
}
