<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeasList;
use App\Models\Idea;
use App\Models\Status;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;

use Livewire\Livewire;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    /** @test */
    public function get_counts_by_statuses_function_returns_correct_counts()
    {
        $openStatus = Status::query()->where('name', 'open')->firstOrFail();
        $closedStatus = Status::query()->where('name', 'closed')->firstOrFail();

        Idea::factory()
            ->count(12)
            ->sequence(fn () => [
                'status_id' => $openStatus,
            ])
            ->create();

        Idea::factory()
            ->count(30)
            ->sequence(fn () => [
                'status_id' => $closedStatus,
            ])
            ->create();

        $ideasCountsByStatuses = Idea::getCountsByStatuses();
        $this->assertEquals(12, $ideasCountsByStatuses['open']);
        $this->assertEquals(30, $ideasCountsByStatuses['closed']);
        $this->assertEquals(42, $ideasCountsByStatuses['all']);
    }

    /** @test */
    public function ideas_index_page_contains_filters_component()
    {
        $consideringStatus = Status::query()->where('name', 'considering')->firstOrFail();
        Idea::factory()
            ->count(4)
            ->sequence(fn () => [
                'status_id' => $consideringStatus,
            ])
            ->create();

        $closedStatus = Status::query()->where('name', 'closed')->firstOrFail();
        Idea::factory()
            ->count(8)
            ->sequence(fn () => [
                'status_id' => $closedStatus,
            ])
            ->create();

        $this->get(route('idea.index'))
            ->assertSeeLivewire(IdeasList::class);

        Livewire::test(IdeasList::class)
            ->assertSee('All ideas (12)', escape: false)
            ->assertSee('Considering (4)', escape: false)
            ->assertSee('Closed (8)', escape: false);
    }

    /**
     * @test
     */
    public function filtering_ideas_by_status_works_when_status_query_parameter_is_present()
    {
        $ideasPerPage = 5;

        $statuses = Status::all();
        $ideas = Idea::factory()
            ->count(50)
            ->sequence(fn () => [
                'status_id' => $statuses->random(),
            ])
            ->create()
            ->sortByDesc('id')
            ->sortByDesc('created_at');

        $response = $this->get(route('idea.index', ['status' => 'in-progress']));

        foreach ($ideas as $idea) {
            if ($idea->status->name !== 'in-progress') {
                $response->assertDontSee($idea->title, escape: false);
            }
        }

        $inProgressIdeas = $ideas->filter(fn ($idea) => $idea->status->name === 'in-progress');
        foreach ($inProgressIdeas->take($ideasPerPage) as $idea) {
            $response->assertSee($idea->title, escape: false);
        }
    }
}
