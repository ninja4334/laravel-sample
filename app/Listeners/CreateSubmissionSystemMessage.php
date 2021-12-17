<?php

namespace App\Listeners;

use App\Events\Event;
use App\Models\AppStatus;
use App\Models\Submission;
use App\Models\User;
use App\Services\MessengerService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateSubmissionSystemMessage implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var MessengerService
     */
    protected $messenger;

    /**
     * @param MessengerService $messenger
     */
    public function __construct(MessengerService $messenger)
    {
        $this->messenger = $messenger;
    }

    /**
     * Handle the event.
     *
     * @param Event $event
     */
    public function handle(Event $event)
    {
        $submission = $event->submission;

        $board = $submission->app->board;

        $users = [];
        array_push($users, $submission->user_id);
        array_push($users, $board->users()->byRoleName('ADMIN')->first()->id);
        $users = array_merge($users, $submission->app->users()
            ->pluck('id')
            ->toArray());

        $sender = User::byRoleName('SYSTEM')->firstOrFail();

        if (
            $submission->status->system_name == AppStatus::SYSTEM_NAME_SUBMITTED
            && $submission->progress_status == Submission::STATUS_IN_REVIEW
        ) {
            $status = 'In review';
        } else {
            $status = $submission->status->title;
        }

        $this->messenger->send(
            'Status was changed to ' . $status . '!',
            $sender->id,
            $users,
            ['submission_id' => $submission->id]
        );
    }
}
