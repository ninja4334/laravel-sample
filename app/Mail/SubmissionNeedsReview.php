<?php

namespace App\Mail;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubmissionNeedsReview extends Mailable implements ShouldQueue
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
            ->subject(trans('emails.need_review_submission.subject'))
            ->view('emails.need_review_submission')
            ->with(['submission' => $this->submission]);
    }
}
