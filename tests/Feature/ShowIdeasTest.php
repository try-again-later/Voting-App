<?php

namespace Tests\Feature;

use App\Http\Controllers\IdeaController;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
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
        $statusA = Status::factory()->create();
        $categoryA = Category::factory()->create();
        $ideaA = Idea::factory()->create([
            'category_id' => $categoryA,
            'status_id' => $statusA,
        ]);

        $statusB = Status::factory()->create();
        $categoryB = Category::factory()->create();
        $ideaB = Idea::factory()->create([
            'category_id' => $categoryB,
            'status_id' => $statusB,
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();

        $response->assertSee($ideaA->title);
        $response->assertSee($ideaA->description);
        $response->assertSee($categoryA->name);
        $response->assertSee($statusA->human_name);

        $response->assertSee($ideaB->title);
        $response->assertSee($ideaB->description);
        $response->assertSee($categoryB->name);
        $response->assertSee($statusB->human_name);
    }

    /**
     * @test
     */
    public function single_idea_is_shown_on_the_show_page()
    {
        $status = Status::factory()->create();
        $category = Category::factory()->create();
        $idea = Idea::factory()->create([
            'category_id' => $category,
            'status_id' => $status,
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();

        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($category->name);
        $response->assertSee($status->human_name);
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
