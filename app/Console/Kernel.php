<?php

namespace App\Console;

use App\Console\Commands\PurgeMediaCommand;
use App\Console\Commands\SendAppNotificationsCommand;
use App\Console\Commands\SendAppRenewalNotificationsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        PurgeMediaCommand::class,
        SendAppNotificationsCommand::class,
        SendAppRenewalNotificationsCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('media:purge --force')->weekly();
        $schedule->command('apps:send-notifications')->dailyAt('08:00');
        $schedule->command('apps:send-renewal-notifications')->dailyAt('07:00');
    }
}
