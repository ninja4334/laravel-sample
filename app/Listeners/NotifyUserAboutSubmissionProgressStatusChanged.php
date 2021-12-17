<?php

namespace App\Listeners;

use App\Mail\SubmissionStatusChanged;
use App\Repositories\ApplicationSubmissionRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class NotifyUserAboutSubmissionProgressStatusChanged implements ShouldQueue
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
        $user = $submission->user;
        $metadata = $event->metadata;

        // Format old status
        $oldStatus = str_replace('_', ' ', $metadata['old_progress_status']);
        $oldStatus = title_case($oldStatus);

        // Format new status
        $newStatus = str_replace('_', ' ', $submission->progress_status);
        $newStatus = title_case($newStatus);

        $mail = new SubmissionStatusChanged($submission, $newStatus, $oldStatus);
        Mail::to($user->email, $user->full_name)->queue($mail);
    }
}
