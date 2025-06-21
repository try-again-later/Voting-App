<?php

namespace Tests\Feature;

use App\Livewire\IdeasList;
use App\Models\Category;
use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\StatusSeeder;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VotesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    #[Test]
    public function idea_show_page_receives_votes_count()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $category = Category::factory()->create();
        $idea  = Idea::factory()->create([
            'category_id' => $category,
            'user_id' => $userA,
        ]);

        Vote::factory()->count(2)->sequence(
            [
                'idea_id' => $idea,
                'user_id' => $userA,
            ],
            [
                'idea_id' => $idea,
                'user_id' => $userB,
            ]
        )->create();

        $this
            ->get(route('idea.show', $idea))
            ->assertViewHas('votesCount', 2);
    }

    #[Test]
    public function previews_on_ideas_index_page_show_correct_votes_count()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $idea  = Idea::factory()->create([
            'user_id' => $userA,
        ]);

        Vote::factory()->count(2)->sequence(
            [
                'idea_id' => $idea,
                'user_id' => $userA,
            ],
            [
                'idea_id' => $idea,
                'user_id' => $userB,
            ]
        )->create();

        Livewire::test(IdeasList::class)
            ->assertViewHas('ideas', fn ($ideas) => intval($ideas->first()->votes_count) === 2);
    }
}
