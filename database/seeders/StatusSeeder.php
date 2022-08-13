<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::factory()
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
    }
}
