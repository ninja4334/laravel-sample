<?php

namespace App\Listeners;

use App\Events\SubmissionStatusWasChanged;
use App\Mail\SubmissionWasApproved;
use App\Models\AppStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class NotifyUserAboutSubmissionApproved implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param SubmissionStatusWasChanged $event
     */
    public function handle(SubmissionStatusWasChanged $event)
    {
        $submission = $event->submission;

        if ($event->metadata['new_status_id'] == 2) {
            $mail = new SubmissionWasApproved($submission);

            Mail::to($submission->user->email, $submission->user->full_name)
                ->queue($mail);
        }
    }
}
