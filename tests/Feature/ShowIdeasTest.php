<?php

namespace Tests\Feature;

use App\Http\Controllers\IdeaController;
use App\Models\Idea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function list_of_ideas_is_shown_on_main_page()
    {
        $ideaA = Idea::factory()->create([
            'title' => 'First test idea',
            'description' => 'Description of the first test idea.',
        ]);
        $ideaB = Idea::factory()->create([
            'title' => 'Second test idea',
            'description' => 'Description of the second test idea.',
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();

        $response->assertSee($ideaA->title);
        $response->assertSee($ideaA->description);

        $response->assertSee($ideaB->title);
        $response->assertSee($ideaB->description);
    }

    /**
     * @test
     */
    public function single_idea_is_shown_on_the_show_page()
    {
        $idea = Idea::factory()->create([
            'title' => 'First test idea',
            'description' => 'Description of the first test idea.',
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();

        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
    }

    /**
     * @test
     */
    public function pagination()
    {
        Idea::factory(IdeaController::PAGINATION_COUNT + 1)->create();

        $firstIdea = Idea::find(1);
        $firstIdea->title = 'My first idea';
        $firstIdea->save();

        $lastIdea = Idea::find(IdeaController::PAGINATION_COUNT + 1);
        $lastIdea->title = 'My last idea';
        $lastIdea->save();

        $response = $this->get(route('idea.index'));
        $response->assertSee($firstIdea->title);
        $response->assertDontSee($lastIdea->title);

        $response = $this->get(route('idea.index', ['page' => 2]));
        $response->assertDontSee($firstIdea->title);
        $response->assertSee($lastIdea->title);
    }
}
