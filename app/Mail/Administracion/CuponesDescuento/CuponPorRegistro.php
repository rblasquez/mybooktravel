<?php

namespace App\Mail\Administracion\CuponesDescuento;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Models\Administracion\DCuponDescuento;

class CuponPorRegistro extends Mailable
{

  use Queueable, SerializesModels;

  public $usuario, $cupon;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(User $usuario, DCuponDescuento $cupon)
  {
    $this->usuario = $usuario;
    $this->cupon = $cupon;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('administracion.cupon_descuento.email.cupon_por_registro'
    // ,[
    //   'usuario' => $this->usuario,
    //   'cupon' => $this->cupon,
    // ]
    );
  }

}
