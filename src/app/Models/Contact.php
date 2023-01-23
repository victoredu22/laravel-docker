<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Contact extends Model
{
    protected $table = "tblContact";
    protected $primaryKey = "idContacto";

    public function insertContact($request)
    {
        $contacto = new Contact;
        $contacto->email = $request->email;
        $contacto->phone = $request->telefono;
        $contacto->message = $request->mensaje;
        $contacto->type = $request->tipoContacto;
        $contacto->save();

        return $contacto;
    }
}
