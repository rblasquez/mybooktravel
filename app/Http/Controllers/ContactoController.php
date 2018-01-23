<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SolicitudLlamadaNotification;
use App\Notifications\SolicitudInfoNotification;
use Illuminate\Support\Facades\Mail;

use App\Mail\SolicitudLlamada;
use App\Mail\SolicitudInfo;

use App\ContactoCorreo;
use App\ContactoLlamada;

use Notification;
use Auth;

class ContactoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function contacto_mail(Request $request)
    {
    	$contacto = ContactoCorreo::firstOrCreate($request->except('_token'));
    	
    	$contacto->notify(new SolicitudInfoNotification($contacto));
    	Mail::to('contacto@mybooktravel.com')->send(new SolicitudInfo($contacto));
    	
    	return redirect()->route('contacto.finalizar.telefono');
    }

    public function contacto_llamada(Request $request)
    {
    	$contacto = ContactoLlamada::firstOrCreate($request->except('_token'));

    	$contacto->notify(new SolicitudLlamadaNotification($contacto));
    	Mail::to('contacto@mybooktravel.com')->send(new SolicitudLlamada($contacto));

    	return redirect()->route('contacto.finalizar.telefono');
    }

    public function finalizar()
    {
    	return view('contacto.llamada');
    }
}
