<?php

namespace App\Jobs;

use App\Models\Idea;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\IdeaStatusUpdatedMail;

class NotifyAllVoters implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Idea $idea;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Idea $idea)
    {
        $this->idea = $idea->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->idea->votes()
            ->chunk(100, function ($voters) {
                foreach ($voters as $voter) {
                    Mail::to($voter)->queue(new IdeaStatusUpdatedMail($this->idea));
                }
            });
    }
}
