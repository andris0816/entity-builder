<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Relationship>
 */
class RelationshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source' => null,
            'target' => null,
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['Allies with', 'Located in', 'Own', 'Fights', 'Occurs in']),
        ];
    }
}
