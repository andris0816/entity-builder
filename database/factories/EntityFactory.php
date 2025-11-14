<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entity>
 */
class EntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'world_id' => null,
            'name' => $this->faker->firstName(),
            'desc' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['Character', 'Location', 'Item', 'Event']),
        ];
    }
}
