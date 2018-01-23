<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

use App\Mail\RecuperarPassword;

use App\User;

use Carbon\Carbon;
use DB;
use Auth;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
        parent::__construct();
    }

    public function reset(Request $request)
    {

        $recuperacion = DB::table('password_resets')->where('email', $request->email)->value('token');

        if (Hash::check($request->token, $recuperacion)) {
            $usuario_id = DB::table('usuarios')->where('email', $request->email)->value('id');
            $usuario = User::find($usuario_id);
            $usuario->password = $request->password;
            $usuario->save();

            Auth::login($usuario);
            return redirect()->route('index');
        }
    }
}
