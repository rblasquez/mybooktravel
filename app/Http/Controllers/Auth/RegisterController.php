<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\RegisterUserRequest;
use App\Notifications\FinalizarRegistro;

use App\Http\Controllers\Administracion\CuponDescuentoController;

use Illuminate\Support\Facades\Mail;
use App\Mail\Registro;

use App\Pais;
use App\User;
use App\Newsletter;

use Auth;
use Meta;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->only(['index', 'create', 'store']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            ]);
    }

    public function index()
    {
        return view('auth.registro', [
            'paises' => Pais::orderBy('nombre')->pluck('nombre', 'iso2')
            ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ]);
    }

    public function store(RegisterUserRequest $request)
    {
        $pais = Pais::where('iso2', $request->pais_id)->first();

        $usuario = new User;
        $usuario->nombres       = $request->nombres;
        $usuario->apellidos     = $request->apellidos;
        $usuario->email         = $request->email;
        $usuario->pais_id       = $pais->id;
        $usuario->telefono      = $request->telefono;
        $usuario->password      = $request->password;
        $usuario->confirm_token = csrf_token();
        $usuario->save();


        if ($request->novedades) {
            $newsletter = new Newsletter;
            $newsletter->email = $usuario->email;
            $newsletter->save();
        }

        Mail::to($usuario->email)->send(new Registro($usuario));
        alert()->success('Hemos enviado una notificación a tu email, verificalo para completar tu registro.', 'Listo')->persistent('Aceptar');
        return redirect()->route('verificar.email', $usuario->id);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        }
    }
}
