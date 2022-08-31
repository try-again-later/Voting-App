<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeasList;
use App\Models\Idea;
use App\Models\Status;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    /** @test */
    public function ideas_list_has_correct_ideas_when_query_filter_is_set()
    {
        Idea::factory()
            ->count(2)
            ->sequence(fn () => [
                'title' => 'abc',
            ])
            ->create();

        Idea::factory()
            ->count(3)
            ->sequence(fn () => [
                'title' => 'def',
            ])
            ->create();

        Livewire::test(IdeasList::class)
            ->set('searchQuery', 'abc')
            ->assertViewHas(
                'ideas',
                fn ($users) => $users->count() === 2,
            );
    }

    /** @test */
    public function ideas_list_has_correct_search_query_set_when_search_query_parameter_is_present()
    {
        Livewire::withQueryParams(['q' => 'abc'])
            ->test(IdeasList::class)
            ->assertSet('searchQuery', 'abc');
    }
}
