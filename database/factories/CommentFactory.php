<?php

namespace Database\Factories;

use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id' => User::factory(),
            'idea_id' => Idea::factory(),
            'new_idea_status_id' => null,
            'body' => $this->faker->paragraph(rand(min: 1, max: 5)),
        ];
    }

    public function statusChangeComment()
    {
        return $this->state(function () {
            return [
                'author_id' => User::factory()->admin(),
                'new_idea_status_id' => Status::factory(),
                'body' => rand() / getrandmax() < 0.75
                    ? null
                    : $this->faker->paragraph(rand(min: 1, max: 5)),
            ];
        });
    }
}
