<?php

namespace App\Jobs;

use App\Events\SubmissionStatusWasChanged;
use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DispatchSubmissionStatusWasChangedEvent implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Submission
     */
    protected $submission;

    /**
     * @var array
     */
    protected $metadata;

    /**
     * Create a new job instance.
     *
     * @param Submission $submission
     * @param array      $metadata
     */
    public function __construct(Submission $submission, array $metadata)
    {
        $this->submission = $submission;
        $this->metadata = $metadata;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        event(new SubmissionStatusWasChanged($this->submission, $this->metadata));
    }
}
