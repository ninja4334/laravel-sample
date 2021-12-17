<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $sender;

    /**
     * @var User
     */
    protected $recipient;

    /**
     * @var string
     */
    protected $msg;

    /**
     * @param User   $sender
     * @param User   $recipient
     * @param string $message
     */
    public function __construct(User $sender, User $recipient, $message)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->msg = $message;
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
            ->subject(trans('emails.new_message.subject'))
            ->view('emails.new_message')
            ->with([
                'sender'    => $this->sender,
                'recipient' => $this->recipient,
                'msg'       => $this->msg
            ]);
    }
}
