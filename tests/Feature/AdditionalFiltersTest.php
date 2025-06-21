<?php

namespace Tests\Feature;

use App\Livewire\IdeasList;
use App\Models\{Idea, User, Vote};
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdditionalFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    private static function ideasSortedByVotes($ideas, string $ordering = 'desc'): bool
    {
        $previousIdea = null;
        foreach ($ideas as $idea) {
            if ($previousIdea !== null && (
                $ordering === 'desc' && $previousIdea->votes->count() < $idea->votes->count() ||
                $ordering === 'asc' && $previousIdea->votes->count() > $idea->votes->count()
            )) {
                return false;
            }
            $previousIdea = $idea;
        }

        return true;
    }

    #[Test]
    public function ideas_list_can_be_sorted_by_votes_count()
    {
        $ideasPerPage = 5;
        $users = User::factory()->count(100)->create();
        $ideas = Idea::factory()->count($ideasPerPage)->create();

        foreach ($ideas as $idea) {
            $voters = $users->random(rand(min: 0, max: $users->count()));

            foreach ($voters as $voter) {
                Vote::factory()->create([
                    'user_id' => $voter->id,
                    'idea_id' => $idea->id,
                ]);
            }
        }

        Livewire::test(IdeasList::class)
            ->set('additionalFilter', 'top-voted')
            ->assertViewHas(
                'ideas',
                fn ($ideas) => self::ideasSortedByVotes($ideas, 'desc'),
            );
    }

    #[Test]
    public function ideas_list_can_be_filtered_by_ideas_created_by_auth_user()
    {
        $authUser = User::factory()->create();
        $anotherUser = User::factory()->create();

        Idea::factory()->count(2)->sequence(fn () => ['user_id' => $anotherUser])->create();
        Idea::factory()->count(3)->sequence(fn () => ['user_id' => $authUser])->create();

        Livewire::actingAs($authUser)
            ->test(IdeasList::class)
            ->set('additionalFilter', 'my-ideas')
            ->assertViewHas(
                'ideas',
                fn ($ideas) =>
                    $ideas->filter(fn ($idea) => $idea->user->id !== $authUser->id)->count() === 0,
            );
    }
}
