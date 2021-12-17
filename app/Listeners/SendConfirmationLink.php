<?php

namespace App\Listeners;

use App\Events\Event;
use App\Mail\ConfirmRegistration;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendConfirmationLink implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param Event $event
     */
    public function handle(Event $event)
    {
        Mail::queue(new ConfirmRegistration($event->user, $event->link));
    }
}
