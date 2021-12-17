<?php

namespace App\Console\Commands;

use App\Jobs\SendAppRenewalNotifications;
use Illuminate\Console\Command;

class SendAppRenewalNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apps:send-renewal-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the applicant renewal notifications.';

    /**
     * Execute the console command.
     * TODO: maybe need to add a count of the sent notifications in the future.
     * TODO: (additional feature)
     *
     * @return mixed
     */
    public function handle()
    {
        dispatch(new SendAppRenewalNotifications());

        $this->info("Notifications sent.");
    }
}
