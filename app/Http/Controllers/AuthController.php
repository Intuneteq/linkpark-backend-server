<?php

namespace App\Http\Controllers;

use App\Events\Models\User\GuardianCode;
use App\Exceptions\CreateApiException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Guardian;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @group Authorization and Authentication
 * 
 * Endpoints to Authorize and Authenticate a user
 **/
class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $guardianCode = DB::transaction(function () use ($request) {
            $user_type = $request->user_type;

            // Create a new User instance and set the attributes
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->user_type = $request->user_type;
            $user->setBcryptPasswordAttribute($request->password); // hash the password
            $user->save();

            // When user is a guardian
            if ($user_type === 'guardian') {

                // Check if school id exist
                $school_id_exist = School::query()->find($request->school_id);

                if (!$school_id_exist) {
                    throw new CreateApiException('School does not exist', 400);
                }

                // Generate a unique guardian code
                $guardianCode = mt_rand(100000, 999999);
                while (Guardian::where('guardian_code', $guardianCode)->exists()) {
                    $guardianCode = mt_rand(100000, 999999);
                }

                // Create a new guardian record
                $guardian = new Guardian([
                    'guardian_code' => $guardianCode,
                    'user_id' => $user->id,
                    'school_id' => $request->school_id
                ]);
                $user->student()->save($guardian);

                try {
                    // Create event and email guardian code
                    event(new GuardianCode($user, $guardianCode));
                } catch (\Throwable $th) {
                    throw new CreateApiException('Could not send guardian email', 500);
                }
            }

            // Whwn user is a student
            if ($user_type === 'student') {
                $guardianCode = $request->guardian_code;
                if (!$guardianCode) throw new CreateApiException('Provide guardian code', 422);
                $student = new Student([
                    'guardian_code' => $guardianCode,
                    'user_id' => $user->id,
                ]);
                try {
                    $user->student()->save($student);
                } catch (\Throwable $th) {
                    throw new CreateApiException('Incorrect Guardian code', 400);
                }
            }
            return $guardianCode;
        });

        // Return a success response
        return new JsonResponse([
            'success' => true,
            'data' => [
                'name' => $request->first_name . ' ' . $request->last_name,
                'guardian_code' => $guardianCode
            ],
            'message' => 'success',
        ], 201);
    }

    public function login(LoginRequest $request)
    {

        $token = Auth::attempt($request->only('email', 'password'));
        if (!$token) throw new CreateApiException("Unauthorized", 401);

        // Create cookie token with sanctum(This will be used as the refresh token)

        $user = Auth::user();

        // Add token to cookie which will be sent with the request
        $cookie = cookie('jwt', $token, 60 * 24);

        return response([
            'success' => true,
            'data' => [
                'id' => $user->id,
                "full_name" => $user->first_name . " " . $user->last_name,
                "user_type" => $user->user_type,
                "accessToken" => $token
            ],
            'message' => 'success',
        ])->withCookie($cookie);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        // Verify sanctum token

        // create new access token
        $user = Auth::user();
        $token = Auth::refresh();
        $cookie = cookie('jwt', $token, 60 * 24);

        // Regenerate refresh token (sanctum)

        // Respond with jwt access token and sanctum token as cookie
        return response([
            'success' => true,
            'data' => [
                'id' => $user->id,
                "full_name" => $user->first_name . " " . $user->last_name,
                "accessToken" => $token
            ],
            'message' => 'success',
        ])->withCookie($cookie);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        try {
            // Validate the request data
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required',
            ]);
        } catch (\Throwable $th) {
            throw new CreateApiException($th->getMessage(), 422);
        }

        // Verify the old password
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'Incorrect old password',
            ], 422);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return new JsonResponse([
            'success' => true,
            'data' => [],
            'message' => 'Password updated successfully',
        ], 200);
    }

    public function forgotPassword()
    {
        $user = Auth::user();
        return $user;
    }
}
