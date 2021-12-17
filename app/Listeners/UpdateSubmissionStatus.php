<?php

namespace App\Listeners;

use App\Mail\SubmissionStatusChanged;
use App\Repositories\ApplicationSubmissionRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class UpdateSubmissionStatus implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param $event
     */
    public function handle($event)
    {
        $submission = $event->submission;
        $metadata = $event->metadata;

        $submission->status_id = $metadata['new_status_id'];
        $submission->save();
    }
}
