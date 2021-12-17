<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordResetLink extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $link;

    /**
     * @param User   $user
     * @param string $token
     * @param string $link
     */
    public function __construct(User $user, string $token, string $link = null)
    {
        $this->user = $user;
        $this->token = $token;
        $this->link = $link;
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
            ->to($this->user->email, $this->user->full_name)
            ->subject(trans('emails.password_reset.subject'))
            ->view('emails.password_reset')
            ->with([
                'user'  => $this->user,
                'token' => $this->token,
                'link'  => $this->link
            ]);
    }
}
