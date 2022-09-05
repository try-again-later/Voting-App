<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Models\{User, Idea};
use Database\Seeders\StatusSeeder;
use App\Jobs\NotifyAllVoters;
use App\Mail\IdeaStatusUpdatedMail;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\VarDumper\VarDumper;

class NotifyAllVotersJobTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(StatusSeeder::class);
    }

    #[Test]
    public function it_sends_emails_to_all_voters_for_the_given_idea()
    {
        $idea = Idea::factory()->create();

        $voters = User::factory(5)->create();
        foreach ($voters as $voter) {
            $idea->vote($voter);
        }

        Mail::fake();

        NotifyAllVoters::dispatch($idea);

        foreach ($voters as $voter) {
            Mail::assertQueued(IdeaStatusUpdatedMail::class, function ($mail) use ($voter) {
                return $mail->hasTo($voter->email);
            });
        }
    }
}
