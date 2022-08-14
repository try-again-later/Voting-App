<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{Status, Category, Idea};
use Database\Seeders\StatusSeeder;

class IdeaIndexTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    /** @test */
    public function all_ideas_are_shown_on_index_page()
    {
        $previewsPerPage = 5;
        $ideasCount = 13;

        $status = Status::factory()->create();
        $category = Category::factory()->create();
        $ideas = Idea::factory()
            ->count($ideasCount)
            ->sequence(fn () => [
                'status_id' => $status,
                'category_id' => $category,
            ])
            ->create()
            ->sortByDesc('id')
            ->sortByDesc('created_at');

        $ideaIndex = 0;
        foreach ($ideas as $idea) {
            $page = intval($ideaIndex / $previewsPerPage) + 1;
            $response = $this
                ->get(route('idea.index', ['page' => $page]))
                ->assertOk();

            $response->assertSeeLivewire('idea-preview');
            $response->assertSee($idea->title, escape: false);
            $response->assertSee($idea->category->name, escape: false);
            $response->assertSee($idea->status->human_name, escape: false);

            ++$ideaIndex;
        }
    }
}
