<?php

namespace Tests\Feature;

use App\Livewire\DeleteIdeaConfirmationModal;
use App\Models\Idea;
use App\Models\User;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteIdeaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    #[Test]
    public function delete_idea_modal_is_present_on_the_ideas_index_page()
    {
        $this
            ->get(route('idea.index'))
            ->assertSeeLivewire(DeleteIdeaConfirmationModal::class);
    }

    #[Test]
    public function delete_idea_modal_is_present_on_the_idea_show_page()
    {
        $idea = Idea::factory()->create();

        $this
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire(DeleteIdeaConfirmationModal::class);
    }

    #[Test]
    public function idea_author_can_delete_their_idea()
    {
        $author = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $author,
        ]);

        Livewire::actingAs($author)
            ->test(DeleteIdeaConfirmationModal::class)
            ->call('deleteIdea', $idea->id)
            ->assertDispatched('destroy:idea');

        $this->assertDatabaseMissing('ideas', [
            'id' => $idea->id,
        ]);
    }

    #[Test]
    public function admin_can_delete_any_idea()
    {
        $admin = User::factory()->admin()->create();
        $idea = Idea::factory()->create();

        Livewire::actingAs($admin)
            ->test(DeleteIdeaConfirmationModal::class)
            ->call('deleteIdea', $idea->id)
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('ideas', [
            'id' => $idea->id,
        ]);
    }

    #[Test]
    public function other_user_cannot_delete_someone_elses_idea()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(DeleteIdeaConfirmationModal::class)
            ->call('deleteIdea', $idea->id)
            ->assertNotDispatched('destroy:idea')
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
        ]);
    }
}
