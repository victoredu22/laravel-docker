<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Validator;


class ContactController extends Controller
{
    protected $contact;

    public function __construct()
    {
        $this->contact = new Contact();
    }

    /**
     * Metodo que inserta  un nuevo contacto en la bd, puede venir desde cumbre o tour huellas
     * 
     * @author Victor Curilao
     */
    public function insertContacto(Request $request)
    {
        $reglas = array(
            'email' => "required",
            'mensaje' => "required",
            'tipoContacto' => "required",
        );
        $msg = ['required' => "Es un campo obligatorio"];

        $validador = FacadesValidator::make($request->all(), $reglas, $msg);

        if ($validador->fails()) {
            return response()
                ->json([
                    'ok' => false,
                    "msg" => "errorValidacion",
                    "errores" => $validador->errors()
                ]);
        }

        $insert = $this->contact->insertContact($request);
        return response()->json([
            'ok' => true,
            'msg' => 'Se ha ingresado el contacto con exito.'
        ]);
    }
}
