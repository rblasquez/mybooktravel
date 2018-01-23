<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use App\Mail\FinalizarRegistro;
use App\Mail\Registro;

use App\User;

use Auth;

use App\Http\Controllers\Administracion\CuponDescuentoController;

class GuessController extends Controller
{
	public function __construct()
    {
        parent::__construct();
    }

	public function verificar($id){
		$user = User::find($id);
		if ($user) {
			if ($user->estatus) {
				return redirect()->route('perfil.index');
			}else{
				return view('auth.verificar', ['usuario' => $user]);
			}
		}
		return view('login');
	}

	public function reenviarEmail($id, $token)
	{
		$usuario = User::find($id);
		$usuario->confirm_token = $token;
		$usuario->save();

		Mail::to($usuario->email)->send(new Registro($usuario));

		alert()->success('Hemos enviado una notificación a tu email, verificalo para completar tu registro.', 'Listo')->persistent('Aceptar');
		return back();
	}

	public function confirmar($id, $token)
	{
		$usuario = User::find($id);

		if ($usuario->estatus == false && $usuario->confirm_token == $token) {
			$usuario->estatus = true;
			$usuario->confirm_token = null;
			$usuario->save();


			if(Auth::loginUsingId($usuario->id, true)) {

				//inicio cupon descuento
				$cupon = CuponDescuentoController::crearCuponPorRegistrarse($usuario);
				session(['cupon'=>$cupon]);
				//finc cupon descuento

				Mail::to($usuario->email)->send(new FinalizarRegistro($usuario));
				alert()->success('Ahora todos somos parte de un mismo viaje, ya puedes encontrar tu hospedaje ideal o publicarlo con <strong class="text-primary">MyBookTravel</strong>.', '¡Listo!')->html()->persistent('Aceptar');
				return redirect()->route('perfil.index');
			}
		}elseif($usuario->estatus == true && $usuario->confirm_token == null){
			if (Auth::user()) {
				return redirect()->route('perfil.index');
			}elseif(Auth::loginUsingId($usuario->id, true)) {
				return redirect()->route('perfil.index');
			}
		}else{
			alert()->error('Su clave de seguridad expiro, solicite nuevamente un correo de activación para proceder.', '¡Disculpe!')->persistent('Aceptar');
			return redirect()->route('verificar.email', $usuario->estatus);
		}

		alert()->error('Algo salio mal durante la activación de su cuenta, solicite nuevamente un correo de activación para proceder.', '¡Disculpe!')->persistent('Aceptar');
		return redirect()->route('verificar.email', $usuario->estatus);
	}
}
