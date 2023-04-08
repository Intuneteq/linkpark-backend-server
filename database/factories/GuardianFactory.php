<?php

namespace Database\Factories;

use App\Models\Guardian;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $user = User::where('user_type', 'parent')
            ->whereDoesntHave('guardian')
            ->inRandomOrder()
            ->first();

        return [
            'user_id' => $user->id,
            'guardian_code' => mt_rand(100000, 999999)
        ];
    }
}
