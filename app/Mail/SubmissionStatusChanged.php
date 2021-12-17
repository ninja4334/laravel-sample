<?php

namespace App\Mail;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubmissionStatusChanged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Submission
     */
    protected $submission;

    /**
     * @var string
     */
    protected $newStatus;

    /**
     * @var string
     */
    protected $oldStatus;

    /**
     * @param Submission $submission
     * @param string     $newStatus
     * @param string     $oldStatus
     */
    public function __construct(Submission $submission, string $newStatus, string $oldStatus)
    {
        $this->submission = $submission;
        $this->newStatus = $newStatus;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject(trans('emails.submission_status_was_changed.subject'))
            ->view('emails.submission_status_was_changed')
            ->with([
                'user'       => $this->submission->user,
                'submission' => $this->submission,
                'new_status' => $this->newStatus,
                'old_status' => $this->oldStatus
            ]);
    }
}
