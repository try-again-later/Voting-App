<?php

namespace Tests\Feature;

use App\Livewire\CreateIdea;
use App\Models\Category;
use App\Models\Idea;
use App\Models\User;
use Database\Seeders\StatusSeeder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CreateIdeaTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    #[Test]
    public function create_idea_form_is_not_shown_when_not_logged_in()
    {
        $this->get(route('idea.index'))
            ->assertOk()
            ->assertSee('Please login or sign up to add a new idea.', escape: false)
            ->assertDontSee(
                'Let us know what you would like and we\'ll take a look over!',
                escape: false,
            );
    }

    #[Test]
    public function create_idea_form_is_shown_when_logged_in()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('idea.index'))
            ->assertOk()
            ->assertDontSee('Please login or sign up to add a new idea.', escape: false)
            ->assertSee(
                'Let us know what you would like and we\'ll take a look over!',
                escape: false,
            );
    }

    #[Test]
    public function ideas_index_page_contains_create_idea_component()
    {
        /** @var Authenticatable */
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('idea.index'))
            ->assertOk()
            ->assertSeeLivewire('create-idea');
    }

    #[Test]
    public function create_idea_form_validation_works()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set('title', '')
            ->set('category', '')
            ->set('description', '')
            ->call('createIdea')
            ->assertHasErrors(['title', 'category', 'description']);
    }

    #[Test]
    public function create_idea_form_creates_an_idea()
    {
        $category = Category::factory()->create();

        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set('title', 'Idea title')
            ->set('category', $category->id)
            ->set('description', 'Idea description')
            ->call('createIdea')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('ideas', [
            'title' => 'Idea title',
            'description' => 'Idea description',
        ]);
    }

    #[Test]
    public function ideas_with_same_title_are_created_with_different_slugs()
    {
        $category = Category::factory()->create();
        $title = 'Idea title';
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', $title)
            ->set('category', $category->id)
            ->set('description', 'Idea description')
            ->call('createIdea')
            ->assertHasNoErrors();
        $firstIdea = Idea::orderby('id', 'desc')->first();
        $this->assertNotEmpty($firstIdea);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', $title)
            ->set('category', $category->id)
            ->set('description', 'Idea description')
            ->call('createIdea')
            ->assertHasNoErrors();
        $secondIdea = Idea::orderby('id', 'desc')->first();
        $this->assertNotEmpty($secondIdea);

        $this->assertEquals($firstIdea->title, $secondIdea->title);
        $this->assertNotEquals($firstIdea->slug, $secondIdea->slug);
    }
}
