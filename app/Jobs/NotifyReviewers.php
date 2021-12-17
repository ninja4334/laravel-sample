<?php

namespace App\Jobs;

use App\Mail\SubmissionNeedsReview;
use App\Models\Submission;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Criteria\UserCriteria;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class NotifyReviewers implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Submission
     */
    protected $submission;

    /**
     * Create a new job instance.
     *
     * @param Submission $submission
     */
    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Execute the job.
     *
     * @param UserRepositoryContract $userRepository
     */
    public function handle(UserRepositoryContract $userRepository)
    {
        $app = $this->submission->app;

        $params = [
            'app_id' => $app->id,
            'role'   => 'reviewer'
        ];
        $users = $userRepository
            ->pushCriteria(new UserCriteria($params))
            ->active()
            ->all();

        if ($users->isEmpty()) {
            $params = [
                'board_id' => $app->board_id,
                'role'     => 'admin'
            ];
            $users = $userRepository
                ->resetCriteria()
                ->pushCriteria(new UserCriteria($params))
                ->active()
                ->all();
        }

        $users->each(function ($user) {
            Mail::to($user->email, $user->full_name)
                ->queue(new SubmissionNeedsReview($this->submission));
        });
    }
}
