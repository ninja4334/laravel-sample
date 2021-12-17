<?php

namespace App\Listeners;

use App\Events\LicenseBoardWasRegistered;
use App\Mail\BoardRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class NotifyAdminAboutNewUser implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param LicenseBoardWasRegistered $event
     */
    public function handle(LicenseBoardWasRegistered $event)
    {
        Mail::queue(new BoardRegistered($event->user));
    }
}
