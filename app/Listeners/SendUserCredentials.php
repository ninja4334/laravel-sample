<?php

namespace App\Listeners;

use App\Events\UserWasCreated;
use App\Mail\UserCredentials;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendUserCredentials implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param UserWasCreated $event
     */
    public function handle(UserWasCreated $event)
    {
        Mail::queue(new UserCredentials($event->user, $event->password));
    }
}
