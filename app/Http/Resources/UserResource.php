<?php

namespace App\Http\Resources;

use App\Models\Guardian;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Mockery\Undefined;

class UserResource extends JsonResource
{
    private function getSchool()
    {
        $school_name = '';
        $user_type = $this->user_type;
        if ($user_type === 'guardian') {

            $guardian = $this->guardian;
            $school = $guardian->school;
            $school_name = $school->name;
        }

        if ($user_type === 'student') {

            $user = $this; // Assuming $this represents the current User model instance

            // Retrieve the related Student model
            $student = $user->student;

            // Retrieve the related Guardian model through the Student model
            $guardian = $student->guardian;

            // Retrieve the related School model through the Guardian model
            $school = $guardian->school;

            // Retrieve the school name
            $school_name = $school->name;
        }

        return $school_name;
    }

    private function getStudents()
    {
        return $this->students;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'name' => $this->first_name . ' ' . $this->last_name,
            'school' => $this->getSchool(),
            'user_type' => $this->user_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    
        if ($this->user_type === "guardian") {
            $response['students'] = $this->getStudents();
        }
    
        return $response;
    }
}
