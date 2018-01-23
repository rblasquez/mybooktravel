<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Reservas\Anfitrion\RealizarConfirmacion;
use App\Mail\Reservas\Anfitrion\CalificarEstadia;

use App\Reserva;

class NotificarReservas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificar:reservas {estatus} {horas}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifica a los anfitriones y huespedes información
								sobre prereservas y reservas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $estatus = $this->argument('estatus');
        $horas = $this->argument('horas');
        
        $query = "SELECT 
					*,
					DATE_ADD( updated_at, INTERVAL ".$horas." HOUR ) as ".$horas."horasdespues,
					now() ahora
				 FROM 
					reservas
				 where 
					 estatus_reservas_id = ".$estatus."
					 and 
					 now() >= DATE_ADD( updated_at, INTERVAL ".$horas." HOUR )
					 and 
					 notificaciones > 0 ;
					 ";
        
        //echo $query;
        
        $result = DB::select($query);
    
		foreach($result as $current)
		{
			
			//echo "<pre>";
			//print_r($current);
			//echo "</pre>";
			
			//estatus 1: pre reserva
			//estatus 4: finalizado
			
			
			$reserva = Reserva::find($current->id);
			$notificaciones = $reserva->notificaciones ;
			
			$email_anfitrion = $reserva->propiedad->usuario->email;
			$email_huesped = $reserva->usuario->email;
			//$email_anfitrion = "juancarlosestradanieto@gmail.com";
			
			if($estatus == 1)
			{
				//echo "entro en estatus 1 \n ";
				Mail::to($email_anfitrion)
				->queue(new RealizarConfirmacion($reserva));
			}
			if($estatus == 4)
			{
				//echo "entro en estatus 4 \n ";
				Mail::to($email_huesped)
				->queue(new CalificarEstadia($reserva));
			}
			
			$reserva->notificaciones = $reserva->notificaciones - 1;
			$reserva->save();
			
		}
		
    }
    
   /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            ['estatus', InputArgument::REQUIRED, 'estatus de la reserva'],
            ['horas', InputArgument::REQUIRED, 'Horas despues del estatus de la reserva'],
        );
    }
}
