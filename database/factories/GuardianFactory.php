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
        return [
            'user_id' => User::where('user_type', 'parent')
                ->whereDoesntHave('guardian', function ($query) {
                    $query->where('guardian_code', $this->faker->unique()->numberBetween(100000, 999999));
                })
                ->inRandomOrder()
                ->firstOrFail()
                ->id,
            'guardian_code' => $this->faker->unique()->numberBetween(100000, 999999)
        ];
    }
}
