<?php

namespace App\Console\Commands;

use App\Jobs\SendAppNotification;
use Illuminate\Console\Command;

class SendAppNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apps:send-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the application notifications.';

    /**
     * Execute the console command.
     * TODO: maybe need to add a count of the sent notifications in the future.
     * TODO: (additional feature)
     *
     * @return mixed
     */
    public function handle()
    {
        dispatch(new SendAppNotification());

        $this->info("Notifications sent.");
    }
}
