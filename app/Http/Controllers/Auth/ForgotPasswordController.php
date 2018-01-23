<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    protected function sendResetLinkResponse($response)
    {
        alert()->success('El link para la recuperación de su contraseña fue enviado a su correo electrónico.', 'Recuperación de contraseña')->persistent('Aceptar');
        return back()->with('status', trans($response));
    }
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        alert()->error('El correo proporcionado no esta registrado en este sitio.', 'Algo salio mal')->persistent('Aceptar');
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }
}
