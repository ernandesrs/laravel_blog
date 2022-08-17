<?php

namespace App\Console;

use App\Models\AccessRegister;
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
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        /**
         * reset de dados de visita
         */
        $schedule->call(function () {
            $accessRegisters = AccessRegister::where("weekly_access", "!=", 0)->get();
            foreach ($accessRegisters as $ar)
                $ar->weeklyReset();
        })->weeklyOn(1, '0:0');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
