<?php

namespace App\Listeners;

use App\Events\MessageWasSent;
use App\Mail\NewMessage;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendMessageToEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param MessageWasSent $event
     */
    public function handle(MessageWasSent $event)
    {
        if ($event->sender->role->name == 'system') {
            return;
        }
        $recipient = User::find($event->recipient_id);

        $mail = new NewMessage($event->sender, $recipient, $event->message);

        Mail::to($recipient->email, $recipient->full_name)->queue($mail);
    }
}
