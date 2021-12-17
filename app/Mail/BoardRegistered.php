<?php

namespace App\Mail;

use App\Models\User;
use App\Services\SettingsService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BoardRegistered extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @param SettingsService $settings
     * @return $this
     */
    public function build(SettingsService $settings)
    {
        return $this
            ->from($this->user->email, $this->user->full_name)
            ->to($settings->get('system_email'))
            ->subject(trans('emails.license_board_registered.subject'))
            ->view('emails.application_board_registered')
            ->with(['user' => $this->user]);
    }
}
