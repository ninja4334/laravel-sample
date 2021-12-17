<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class LicenseBoardWasRegistered extends Event
{
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    public $link;

    /**
     * Create a new event instance.
     *
     * @param User   $user
     * @param string $link
     */
    public function __construct(User $user, string $link)
    {
        $this->user = $user;
        $this->link = $link;
    }
}
