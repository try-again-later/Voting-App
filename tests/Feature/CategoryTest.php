<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeasList;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    /** @test */
    public function ideas_list_has_correct_ideas_when_category_prop_is_set()
    {
        $statuses = Status::all();
        $categories = Category::factory()
            ->count(4)
            ->sequence(
                ['name' => 'Category A'],
                ['name' => 'Category B'],
                ['name' => 'Category C'],
                ['name' => 'Category D'],
            )
            ->create()
            ->sortByDesc('created_at')
            ->sortByDesc('id');
        $selectedCategoryId = 1;

        $ideas = Idea::factory()
            ->count(50)
            ->sequence(fn () => [
                'category_id' => $categories->random(),
                'status_id' => $statuses->random(),
            ])
            ->create();

        Livewire::test(IdeasList::class)
            ->set('categoryFilter', $selectedCategoryId)
            ->assertViewHas(
                'ideas',
                fn ($ideas) =>
                    $ideas->filter(
                        fn ($idea) => $idea->category->id !== $selectedCategoryId
                    )->count() === 0,
            );
    }

    /** @test */
    public function ideas_list_has_correct_category_set_when_category_query_parameter_is_present()
    {
        Livewire::withQueryParams(['category' => '3'])
            ->test(IdeasList::class)
            ->assertSet('categoryFilter', '3');
    }

    /** @test */
    public function ideas_list_has_all_category_by_default()
    {
        Livewire::test(IdeasList::class)
            ->assertSet('categoryFilter', 'all');
    }
}
