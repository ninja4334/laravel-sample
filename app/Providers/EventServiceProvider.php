<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\MemberWasRegistered' => [
            'App\Listeners\SendConfirmationLink'
        ],
        'App\Events\LicenseBoardWasRegistered' => [
            'App\Listeners\SendConfirmationLink',
            'App\Listeners\NotifyAdminAboutNewUser',
        ],
        'App\Events\UserWasCreated' => [
            'App\Listeners\SendUserCredentials'
        ],
        'App\Events\SubmissionStatusWasChanged' => [
            'App\Listeners\NotifyUserAboutSubmissionStatusChanged',
            'App\Listeners\SendSystemMessage',
            'App\Listeners\ApproveSubmission',
            'App\Listeners\NotifyUserAboutSubmissionApproved',
            'App\Listeners\UpdateSubmissionStatus'
        ],
        'App\Events\SubmissionReviewing' => [
            'App\Listeners\SendSystemMessage',
            'App\Listeners\NotifyUserAboutSubmissionProgressStatusChanged'
        ],
        'App\Events\MessageWasSent' => [
            'App\Listeners\SendMessageToEmail'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
