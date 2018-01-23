<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reserva;
use App\Http\Requests\PropiedadCalificacionGuardarRequest;

class PropiedadCalificacionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        //
    }

    public function agregar(Request $request)
    {
        $reserva = Reserva::find($request->id_reserva);
        $id_usuario_reserva = $reserva->usuarios_id;
        $id_usuario_session = \Auth::user()->id;

        if($id_usuario_reserva == $id_usuario_session)
        {
			return view('reservas.calificar', ['reserva' => $reserva]);
		}
		else
		{
			return redirect('/');
		}
    }

    public function guardar(PropiedadCalificacionGuardarRequest $request)
    {
        //
        $reserva = Reserva::find($request->id_reserva);

        if($reserva->calificaciones()->count() == 0)
        {
			$reserva->calificaciones()->create([
				'puntuacion'=>$request->puntuacion,
				'comentario'=>$request->comentario
			]);
		}

		return response()->json([
			'success' => 'true'
		]);

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
