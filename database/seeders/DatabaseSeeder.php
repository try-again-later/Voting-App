<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Idea;
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

        Idea::factory()
            ->count(30)
            ->sequence(fn () => [
                'category_id' => $categories->random(),
            ])
            ->create();
    }
}
