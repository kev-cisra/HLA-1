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
        Commands\TurnosEquipos::class,
        Commands\TurnosEquiposInviernoApertura::class,
        Commands\TurnosEquiposVeranoApertura::class,
        commands\CierreParoInvierno::class,
        commands\CierreParoVerano::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /* ->everyMinute(); */

        // $schedule->command('inspire')->hourly();
        $schedule->command('test:task')
        ->timezone('America/Mexico_City')
        ->dailyAt('01:00');

        //Invierno equipos apertura
        $schedule->command('CTurnos:General')
        ->timezone('America/Mexico_City')
        ->dailyAt('07:00');

        //Invierno equipos apertura
        $schedule->command('Invierno:Equipos')
        ->timezone('America/Mexico_City')
        ->dailyAt('08:00');

        //Invierno cierre de paros por turnos apertura
        $schedule->command('cierre:paroInvierno')
        ->timezone('America/Mexico_City')
        ->twiceDaily(8, 20);
        //->everyMinute();

        //verano equipos apertura
        $schedule->command('Verano:Equipos')
        ->timezone('America/Mexico_City')
        ->dailyAt('09:00');

        //Invierno cierre de paros por turnos apertura
        $schedule->command('cierre:paroVerano')
        ->timezone('America/Mexico_City')
        ->twiceDaily(9, 21);
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
