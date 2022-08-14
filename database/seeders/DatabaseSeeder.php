<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([StatusSeeder::class]);
        $statuses = Status::all();

        $categories = Category::factory()
            ->count(4)
            ->sequence(
                ['name' => 'Category A'],
                ['name' => 'Category B'],
                ['name' => 'Category C'],
                ['name' => 'Category D'],
            )
            ->create();

        $users = User::factory()
            ->count(20)
            ->create();

        $ideas = Idea::factory()
            ->count(30)
            ->sequence(fn () => [
                'category_id' => $categories->random(),
                'status_id' => $statuses->random(),
                'user_id' => $users->random(),
            ])
            ->create();

        foreach ($ideas as $idea) {
            $voters = $users->random(rand(min: 0, max: $users->count()));

            foreach ($voters as $voter) {
                Vote::factory()->create([
                    'user_id' => $voter->id,
                    'idea_id' => $idea->id,
                ]);
            }
        }
    }
}
