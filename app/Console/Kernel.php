<?php

namespace App\Console;

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
        Commands\ActualizaVacaciones::class,
        Commands\TurnosEquiposInviernoApertura::class,
        Commands\TurnosEquiposVeranoApertura::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('test:task')
        ->timezone('America/Mexico_City')
        ->dailyAt('01:00');

        //Invierno equipos apertura
        $schedule->command('Invierno:Equipos')
        ->timezone('America/Mexico_City')
        ->dailyAt('08:00');

        //verano equipos apertura
        $schedule->command('Verano:Equipos')
        ->timezone('America/Mexico_City')
        ->dailyAt('09:00');
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
