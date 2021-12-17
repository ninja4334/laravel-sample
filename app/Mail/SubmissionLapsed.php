<?php

namespace App\Mail;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubmissionLapsed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Submission
     */
    protected $submission;

    /**
     * @param Submission $submission
     */
    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
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
            ->subject(trans('emails.submission_lapsed.subject'))
            ->view('emails.submission_lapsed')
            ->with([
                'submission' => $this->submission
            ]);
    }
}
