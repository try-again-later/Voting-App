<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
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
        $categories = Category::factory()
            ->count(4)
            ->sequence(
                ['name' => 'Category A'],
                ['name' => 'Category B'],
                ['name' => 'Category C'],
                ['name' => 'Category D'],
            )
            ->create();

        $statuses = Status::factory()
            ->count(5)
            ->sequence(
                [
                    'name' => 'open',
                    'human_name' => 'Open'
                ],
                [
                    'name' => 'in-progress',
                    'human_name' => 'In progress'
                ],
                [
                    'name' => 'implemented',
                    'human_name' => 'Implemented'
                ],
                [
                    'name' => 'considering',
                    'human_name' => 'Considering'
                ],
                [
                    'name' => 'closed',
                    'human_name' => 'Closed'
                ],
            )
            ->create();

        Idea::factory()
            ->count(30)
            ->sequence(fn () => [
                'category_id' => $categories->random(),
                'status_id' => $statuses->random(),
            ])
            ->create();
    }
}
