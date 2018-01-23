<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\CorregirImagenes::class,
        Commands\ActualizarTasaCambioMoneda::class,
        Commands\NotificarReservas::class,
    ];

    protected function schedule(Schedule $schedule)
    {
		$schedule->command('actualizar:moneda')->everyThirtyMinutes();
		
        //$schedule->command('notificar:reservas 1 6')->everyMinute();//pre reserva
        //$schedule->command('notificar:reservas 1 12')->everyMinute();//pre reserva
        //$schedule->command('notificar:reservas 1 18')->everyMinute();//pre reserva
        //$schedule->command('notificar:reservas 4 24')->everyMinute();//finalizado: cuando el huesped abandona la propiedad
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
