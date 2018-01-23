<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\HelperController;

class ActualizarTasaCambioMoneda extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actualizar:moneda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'consulta la tasa actual del cambio de moneda a nivel mundial y lo guarda en la tabla paises';

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
		HelperController::actualizarTasaCambioMoneda(0);
    }
}
