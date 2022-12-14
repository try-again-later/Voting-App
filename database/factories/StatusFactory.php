<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'human_name' => $this->faker->words(nb: rand(1, 2), asText: true),
            'name' => $this->faker->slug(nbWords: rand(1, 2)),
        ];
    }
}
