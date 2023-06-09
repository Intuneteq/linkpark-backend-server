<?php

namespace Database\Factories;

use App\Models\Guardian;
use App\Models\User;
use App\Models\School;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Unique;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guardian>
 */
class GuardianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Guardian::class; // Define model

    public function definition(): array
    {
        $school = School::inRandomOrder()->first();
        $user = User::doesntHave('guardian')->where('user_type', 'guardian')->inRandomOrder()->first();
        return [
            'school_id' => $school->id,
            'user_id' => $user->id,
            'guardian_code' => mt_rand(100000, 999999)
        ];
    }
}
