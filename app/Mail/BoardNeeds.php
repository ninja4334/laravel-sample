<?php

namespace App\Mail;

use App\Services\SettingsService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BoardNeeds extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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
            ->from($this->data['email'])
            ->to($settings->get('system_email'))
            ->subject(trans('emails.need_board_notify.subject'))
            ->view('emails.need_board_notify')
            ->with($this->data);
    }
}
