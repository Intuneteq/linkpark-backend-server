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
use Illuminate\Support\Facades\DB;
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

            // Check if school id exist
            $school_id_exist = School::query()->find($request->school_id);

            if (!$school_id_exist) {
                throw new CreateApiException('School does not exist', 400);
            }

            // Create a new User instance and set the attributes
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->school_id = $request->school_id;
            $user->user_type = $request->user_type;
            $user->setBcryptPasswordAttribute($request->password); // hash the password
            $user->save();

            // When user is a guardian
            if ($user_type === 'guardian') {

                // Generate a unique guardian code
                $guardianCode = mt_rand(100000, 999999);
                while (Guardian::where('guardian_code', $guardianCode)->exists()) {
                    $guardianCode = mt_rand(100000, 999999);
                }

                // Create a new guardian record
                $guardian = new Guardian([
                    'guardian_code' => $guardianCode,
                    'user_id' => $user->id,
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
                $user->student()->save($student);
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
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) throw new CreateApiException("User does not exist", 404);

        // Validate user
        $validateUser = Hash::check($request->password, $user->password);
        if (!$validateUser) throw new CreateApiException("Unauthorized", 401);

        // Create Token
        $token = $user->createToken('user', [$user->user_type]);


        // Return a success response
        return new JsonResponse([
            'success' => true,
            'data' => [
                "full_name" => $user->first_name . " " . $user->last_name,
                "accessToken" => $token->plainTextToken
            ],
            'message' => 'success',
        ]);
    }
}
