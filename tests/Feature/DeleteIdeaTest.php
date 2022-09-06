<?php

namespace Tests\Feature;

use App\Http\Livewire\DeleteIdeaConfirmationModal;
use App\Models\Idea;
use App\Models\User;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteIdeaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    /** @test */
    public function delete_idea_modal_is_present_on_the_ideas_index_page()
    {
        $this
            ->get(route('idea.index'))
            ->assertSeeLivewire(DeleteIdeaConfirmationModal::class);
    }

    /** @test */
    public function delete_idea_modal_is_present_on_the_idea_show_page()
    {
        $idea = Idea::factory()->create();

        $this
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire(DeleteIdeaConfirmationModal::class);
    }

    /** @test */
    public function can_change_idea_to_be_deleted_with_event()
    {
        $author = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $author,
        ]);

        Livewire::actingAs($author)
            ->test(DeleteIdeaConfirmationModal::class)
            ->emit('open-delete-modal:idea', $idea)
            ->assertSet('idea', $idea)
            ->assertDispatchedBrowserEvent('open-delete-modal:idea');
    }

    /** @test */
    public function idea_author_can_delete_their_idea()
    {
        $author = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $author,
        ]);

        Livewire::actingAs($author)
            ->test(DeleteIdeaConfirmationModal::class)
            ->set('idea', $idea)
            ->call('deleteIdea')
            ->assertDispatchedBrowserEvent('close-delete-modal:idea')
            ->assertEmitted('destroy:idea');

        $this->assertDatabaseMissing('ideas', [
            'id' => $idea->id,
        ]);
    }

    /** @test */
    public function admin_can_delete_any_idea()
    {
        $admin = User::factory()->admin()->create();
        $idea = Idea::factory()->create();

        Livewire::actingAs($admin)
            ->test(DeleteIdeaConfirmationModal::class)
            ->set('idea', $idea)
            ->call('deleteIdea')
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('ideas', [
            'id' => $idea->id,
        ]);
    }

    /** @test */
    public function other_user_cannot_delete_someone_elses_idea()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(DeleteIdeaConfirmationModal::class)
            ->set('idea', $idea)
            ->call('deleteIdea')
            ->assertNotDispatchedBrowserEvent('close-delete-modal:idea')
            ->assertNotEmitted('destroy:idea')
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
        ]);
    }
}
