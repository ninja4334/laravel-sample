<?php

namespace App\Events;

use App\Models\Submission;
use Illuminate\Queue\SerializesModels;

class SubmissionStatusWasChanged extends Event
{
    use SerializesModels;

    /**
     * @var Submission
     */
    public $submission;

    /**
     * @var array
     */
    public $metadata;

    /**
     * Create a new event instance.
     *
     * @param Submission $submission
     * @param array      $metadata
     */
    public function __construct(Submission $submission, array $metadata)
    {
        $this->submission = $submission;
        $this->metadata = $metadata;
    }
}
