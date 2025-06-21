<?php

namespace Tests\Feature;

use App\Livewire\EditIdeaForm;
use App\Models\Category;
use App\Models\Idea;
use App\Models\User;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditIdeaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    #[Test]
    public function edit_idea_form_is_present_on_the_ideas_index_page()
    {
        $this
            ->get(route('idea.index'))
            ->assertSeeLivewire(EditIdeaForm::class);
    }

    #[Test]
    public function edit_idea_form_is_present_on_the_idea_show_page()
    {
        $idea = Idea::factory()->create();

        $this
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire(EditIdeaForm::class);
    }

    #[Test]
    public function can_change_edited_idea_with_event()
    {
        $author = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $author,
        ]);

        Livewire::actingAs($author)
            ->test(EditIdeaForm::class)
            ->dispatch('edit:idea', ideaId: $idea->id)
            ->assertSet('idea.id', $idea->id);
    }

    #[Test]
    public function idea_author_can_change_their_idea()
    {
        $oldCategory = Category::factory()->create();
        $newCategory = Category::factory()->create();

        $author = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $author,
            'category_id' => $oldCategory,
        ]);

        Livewire::actingAs($author)
            ->test(EditIdeaForm::class)
            ->set('idea', $idea)
            ->set('category', $newCategory->id)
            ->set('title', 'Updated title')
            ->set('description', 'Updated description')
            ->call('updateIdea')
            ->assertDispatched('update:idea');

        $idea->refresh();

        $this->assertEquals($newCategory->id, $idea->category_id);
        $this->assertEquals('Updated title', $idea->title);
        $this->assertEquals('Updated description', $idea->description);
    }

    #[Test]
    public function user_cannot_edit_someone_elses_ieda()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(EditIdeaForm::class)
            ->set('idea', $idea)
            ->set('title', 'Updated title')
            ->call('updateIdea')
            ->assertNotDispatched('update:idea')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    #[Test]
    public function user_cannot_edit_ideas_created_more_than_one_hour_ago()
    {
        $author = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $author,
            'created_at' => now()->subHour()->subMinute(),
        ]);

        Livewire::actingAs($author)
            ->test(EditIdeaForm::class)
            ->set('idea', $idea)
            ->call('updateIdea')
            ->assertNotDispatched('update:idea')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
