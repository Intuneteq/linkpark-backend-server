<?php

namespace Database\Factories;

use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Student::class; // Define model
    public function definition(): array
    {
        $user = User::where('user_type', 'student')->inRandomOrder()->first();
        $guardian = Guardian::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'guardian_code' => $guardian->guardian_code
        ];
    }
}
