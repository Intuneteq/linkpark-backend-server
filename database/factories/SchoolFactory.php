<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    protected $model = School::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->name(),
            'country' => fake()->country()
        ];
    }

    public function defaultSchool()
    {
        return $this->state([
            'city' => 'Akure',
            'state' => 'Ondo-state',
            'country' => 'Nigeria'
        ]);
    }
}
