<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
   
    protected $commands = [
        \App\Console\Commands\LegalNotifyUsers::class,
        \App\Console\Commands\MonthlySms::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('users:notify')
                ->daily();
        $schedule->command('sms:monthly')
            ->dailyAt('12:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
