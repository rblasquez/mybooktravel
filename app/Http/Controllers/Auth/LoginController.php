<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use App\Newsletter;

use App\User;
use App\Pais;

use Auth;
use Meta;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function index(Request $request)
    {
        Meta::set('title', 'Registro - MyBookTravel');
        return view('login', [
            'paises' => Pais::orderBy('nombre')->pluck('nombre', 'iso2')
        ]);
    }

    public function store(LoginRequest $request)
    {
        $request->all();

        $conectado = $request->conectado ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $conectado)) {
            if (Auth::user()->estatus == false) {
                $id = Auth::user()->id;
                Auth::logout();
                alert()->error('Su correo aun no ha sido verificado, si no le ha sido entregado solicitelo nuevamente.', '¡Disculpe!')->persistent('Aceptar');
                return redirect()->route('verificar.email', $id);
            } else {
                return redirect()->intended('/');
            }
        }
        alert()->error('Combinación usuario & contraseña son incorrectos, intente nuevamente', 'Algo salio mal')->autoclose(3000);
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.index');
    }
}
