<?php

namespace Tests\Feature;

use App\Livewire\IdeaShow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\StatusSeeder;
use Livewire\Livewire;
use App\Models\{User, Idea, Vote};
use PHPUnit\Framework\Attributes\Test;

class IdeaShowTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    #[Test]
    public function single_idea_is_shown_on_the_show_page()
    {
        $idea = Idea::factory()->create();

        $response = $this
            ->get(route('idea.show', $idea))
            ->assertOk();

        $response->assertSee($idea->title, escape: false);
        $response->assertSee($idea->description, escape: false);
        $response->assertSee($idea->category->name, escape: false);
        $response->assertSee($idea->status->human_name, escape: false);
    }

    #[Test]
    public function when_auth_user_voted_for_idea_the_idea_card_indicates_this()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();
        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
        ]);

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 1,
                'voted' => true,
            ])
            ->assertSee('Voted');
    }

    #[Test]
    public function when_auth_user_has_not_voted_for_idea_the_idea_card_indicates_this()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();
        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
        ]);

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 0,
                'voted' => false,
            ])
            ->assertDontSee('Voted');
    }

    #[Test]
    public function is_rendered_on_show_page()
    {
        $idea = Idea::factory()->create();

        $this
            ->get(route('idea.show', $idea))
            ->assertOk()
            ->assertSeeLivewire('idea-show');
    }

    /** @test */
    public function calling_vote_method_when_not_authenticated_redirects_to_login_page()
    {
        $idea = Idea::factory()->create();

        Livewire::test(IdeaShow::class, [
            'idea' => $idea,
        ])
            ->call('vote')
            ->assertRedirect(route('login'));
    }
}
