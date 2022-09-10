<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            ->count(13)
            ->create();

        $users
            ->push(User::factory()->admin()->create([
                'email' => env('ADMIN_EMAIL', 'admin@example.com'),
                'password' => Hash::make(env('ADMIN_PASSWORD', '123123123')),
            ]))
            ->push(User::factory()->create([
                'email' => env('REGULAR_USER_EMAIL', 'someone@example.com'),
                'password' => Hash::make(env('REGULAR_USER_PASSWORD', '123123123')),
            ]));

        $admins = User::factory()
            ->admin()
            ->count(5)
            ->create();
        $users = $users->merge($admins);

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
                    'user_id' => $voter,
                    'idea_id' => $idea,
                ]);
            }

            $statusChangesCount = rand(min: $idea->status->name === 'open' ? 0 : 1, max: 5);
            $commentsCount = rand(min: $statusChangesCount, max: 50);
            // - "0" for a regular comment
            // - "1" OR "2" for a "status changed" comment
            // - "2" is the last "status changed" comment which means that it must change the status
            //   of the idea to the current one
            $commentsTypes = array_fill(0, $commentsCount, 0);
            for ($i = 0; $i < $statusChangesCount; ++$i) {
                $commentsTypes[$i] = 1;
            }
            shuffle($commentsTypes);

            $lastStatusChangeIndex = null;
            for ($i = 0; $i < count($commentsTypes); ++$i) {
                if ($commentsTypes[$i] === 1) {
                    $lastStatusChangeIndex = $i;
                }
            }
            if (!is_null($lastStatusChangeIndex)) {
                $commentsTypes[$lastStatusChangeIndex] = 2;
            }

            $previousStatus = $statuses->where('name', 'open')->first();
            foreach ($commentsTypes as $commentType) {
                if ($commentType === 0) {
                    Comment::factory()->create([
                        'author_id' => $users->random(),
                        'idea_id' => $idea,
                    ]);
                } else if ($commentType === 1) {
                    $newStatus = $statuses->random();
                    while ($newStatus->id === $previousStatus->id) {
                        $newStatus = $statuses->random();
                    }

                    Comment::factory()->statusChangeComment()->create([
                        'author_id' => $admins->random(),
                        'idea_id' => $idea,
                        'new_idea_status_id' => $newStatus,
                    ]);

                    $previousStatus = $newStatus;
                } else if ($commentType === 2 && $idea->status->id !== $previousStatus->id) {
                    Comment::factory()->statusChangeComment()->create([
                        'author_id' => $admins->random(),
                        'idea_id' => $idea,
                        'new_idea_status_id' => $idea->status,
                    ]);
                }
            }
        }
    }
}
