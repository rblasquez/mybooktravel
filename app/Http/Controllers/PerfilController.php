<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mensaje;

use Auth;
use App\User;
use App\Pais;
# use App\Propiedad;
# use App\Reserva;

use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Validator;

class PerfilController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(){

        # return $propiedades = Propiedad::byUsuario()
        # ->join('propiedades_ubicaciones', 'propiedades.id', '=', 'propiedades_ubicaciones.propiedad_id')
        # ->join('paises', 'paises.iso2', '=', 'propiedades_ubicaciones.pais')
        # ->select('paises.moneda', 'propiedades.*')
        # ->get();

        # $reservas = Reserva::byUsuario()->count();

        return view('auth.index', [
            # 'propiedades' => $propiedades,
            # 'reservas' => $reservas,
            ]);
    }

    public function store(Request $request){
    	$campos = $request->all();
        $rules = [
            'email'     => 'required',
            'password'  => 'required'
        ];

        $validator = Validator::make($campos, $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->recuerdame)) {
            return redirect()->intended('/');
        }

        return redirect()->back()->withErrors(['errorMensaje' => 'Combinación usuario & contraseña son incorrectos, intente nuevamente']);
    }

    public function avatar(Request $request)
    {
        # return $request->all();
        # obtengo los datos para tranformar la imagen
        $data = json_decode($request->get('avatar_data'), true);

        $usuario = Auth::user();

        //verificar el que sea un mime type correcto
        if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/i', $request->canvas, $matches)) {
            $imageType = $matches[1];
            $imageData = base64_decode($matches[2]);
            
            # Stream
            $avatar = imagecreatefromstring($imageData);
            
            # Agregar la extensión correcta, aunque perfectamente se puede guardar sin extensión
            $usuario->imagen = 'usuario_'.$usuario->id.'.'.$imageType;
            # guardo el nombre de la imagen en la base de datos
            $usuario->save();

            $filepath = 'user_img/'.$usuario->imagen;

            # ...y guardo dicha imagen en el servidor
            if( Storage::cloud('minio')->put($filepath, $imageData, 'public') === true ){
                # Aplico los ajustes que indico el usuario a la imagen y sobreescribo la original
                return response()->json( Storage::cloud('minio')->url($filepath) );
                # return response()->json( Storage::cloud('minio')->temporaryUrl($filepath, \Carbon\Carbon::now()->addMinutes(30)) );
            } else {
                throw new Exception('Imposible guardar archivo.');
            }
        
        } else {
            throw new Exception('Invalid data URL.');
        }

    }

    public function update(Request $request, $id)
    {
        $pais = Pais::where('iso2', $request->pais_id)->first();
        $usuario = User::find($id);
        $usuario->nombres       = $request->nombres;
        $usuario->apellidos     = $request->apellidos;
        $usuario->email         = $request->email;
        $usuario->telefono      = $request->telefono;
        $usuario->fecha_naci    = Carbon::parse($request->fecha_naci)->format('Y-m-d');
        $usuario->pais_id       = $pais->id;
        $usuario->direccion     = $request->direccion;
        $usuario->idiomas       = $request->idiomas;
        $usuario->divisa        = $request->divisa;
        $usuario->sexo          = $request->sexo;
        $usuario->descripcion   = $request->descripcion;
        $usuario->save();

        alert()->success('Hemos actualizado tu información.', 'Listo')->persistent('Aceptar');
        return redirect()->route('perfil.index');
        dd( $usuario);
    }

    public function editar()
    {
        return view('auth.edit', [
            'paises' => Pais::orderBy('nombre')->pluck('nombre', 'iso2'),
            'pais' => Pais::find(Auth::user()->pais_id),
        ]);
    }

}
