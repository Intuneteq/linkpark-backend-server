<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateApiException;
use App\Http\Requests\StoreUserRequest;
use App\Models\Guardian;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(StoreUserRequest $request)
    {

        // Create a new User instance and set the attributes
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->school_id = $request->school_id;
        $user->user_type = $request->user_type;
        $user->setBcryptPasswordAttribute($request->password); // hash the password

        // Save the User instance
        $user->save();

        // Generate a unique guardian code
        $guardianCode = mt_rand(100000, 999999);
        while (Guardian::where('guardian_code', $guardianCode)->exists()) {
            $guardianCode = mt_rand(100000, 999999);
        }

        // Create a new guardian record
        $guardian = new Guardian([
            'guardian_code' => $guardianCode,
        ]);
        $user->guardian()->save($guardian);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully'
        ]);
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
