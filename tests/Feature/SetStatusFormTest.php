<?php

namespace Tests\Feature;

use App\Http\Livewire\SetStatusForm;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Database\Seeders\StatusSeeder;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SetStatusFormTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    /** @test */
    public function admins_can_see_a_set_status_form()
    {
        $idea = Idea::factory()->create();
        /** @var Authenticatable */
        $admin = User::factory()->create([
            'email' => 'admin@email.com',
        ]);

        $this
            ->actingAs($admin)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire(SetStatusForm::class);
    }

    /** @test */
    public function regular_user_cannot_see_a_set_status_form()
    {
        $idea = Idea::factory()->create();
        /** @var Authenticatable */
        $user = User::factory()->create([
            'email' => 'not.admin@email.com',
        ]);

        $this
            ->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertDontSeeLivewire(SetStatusForm::class);
    }

    /** @test */
    public function admin_can_change_an_idea_status()
    {
        $idea = Idea::factory()->create();
        $admin = User::factory()->create([
            'email' => 'admin@email.com',
        ]);

        Livewire::actingAs($admin)
            ->test(SetStatusForm::class, ['idea' => $idea])
            ->set('status', 'in-progress')
            ->call('changeStatus')
            ->assertEmitted('update:status');

        $idea = $idea->fresh();

        $this->assertEquals('in-progress', $idea->status->name);
    }

    /** @test */
    public function initially_set_status_on_the_form_matches_the_idea_status()
    {
        $initialStatus = Status::query()->where('name', 'in-progress')->firstOrFail();
        $idea = Idea::factory()->create([
            'status_id' => $initialStatus,
        ]);
        $admin = User::factory()->create([
            'email' => 'admin@email.com',
        ]);

        Livewire::actingAs($admin)
            ->test(SetStatusForm::class, ['idea' => $idea])
            ->assertSet('status', 'in-progress');
    }
}
