<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\blast::class,
        Commands\CheckSubscription::class,
        Commands\checkValidNumber::class,
//        Commands\DemoCron::class,
        Commands\ScheduleCron::class,
        Commands\StartBlast::class
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('schedule:cron')->everyMinute();
        $schedule->command('subscription:check')->daily();
        $schedule->command('start:blast')->everyMinute();
        // $schedule->command('demo:cron')->everyMinute();
        // $schedule->command('check:wavalidnumber')->daily();
      //  $schedule->command('schedule:blast')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
