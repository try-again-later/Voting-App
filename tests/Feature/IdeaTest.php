<?php

namespace Tests\Feature;

use App\Models\{Idea, User, Vote};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\StatusSeeder;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;

class IdeaTest extends TestCase
{
    use RefreshDatabase;

    private Idea $idea;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
        $this->idea = Idea::factory()->create();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function voted_by_method_returns_false_when_null_is_passed_as_user()
    {
        assertFalse($this->idea->votedBy(null));
    }

    #[Test]
    public function voted_by_method_shows_when_there_is_no_entry_in_votes_table()
    {
        $this->assertFalse($this->idea->votedBy($this->user));
        Vote::factory()->create([
            'idea_id' => $this->idea,
            'user_id' => $this->user,
        ]);
        $this->assertTrue($this->idea->votedBy($this->user));
    }

    #[Test]
    public function user_can_vote_for_idea()
    {
        $this->assertFalse($this->idea->votedBy($this->user));
        $this->idea->vote($this->user);
        $this->assertTrue($this->idea->votedBy($this->user));
    }

    #[Test]
    public function calling_vote_twice_does_not_give_errors()
    {
        $this->expectNotToPerformAssertions();

        $this->idea->vote($this->user);
        $this->idea->vote($this->user);
    }

    #[Test]
    public function user_can_remove_a_vote_from_idea()
    {
        Vote::factory()->create([
            'idea_id' => $this->idea,
            'user_id' => $this->user,
        ]);

        $this->assertTrue($this->idea->votedBy($this->user));
        $this->idea->unvote($this->user);
        $this->assertFalse($this->idea->votedBy($this->user));
    }

    #[Test]
    public function calling_unvote_twice_does_not_give_errors()
    {
        $this->expectNotToPerformAssertions();

        $this->idea->vote($this->user);
        $this->idea->unvote($this->user);
        $this->idea->unvote($this->user);
    }
}
