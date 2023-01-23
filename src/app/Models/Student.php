<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class Student extends Model
{
  protected $table = "tblStudent";
  protected $primaryKey = "idStudent";

  /**
   * Metodo que trae detalles de todos los alumnos del sistema junto al detalleALumno
   *
   * @return get
   */
  public function getStudentsDetail()
  {
    $get = FacadesDB::table('tblStudent')
      ->join('tblDetailStudent', 'tblStudent.idStudent', 'tblDetailStudent.idStudent')
      ->select('tblStudent.idStudent', 'tblStudent.dni', 'tblStudent.email', 'tblDetailStudent.firstName', 'tblDetailStudent.lastName')
      ->get();
    return $get;
  }


  public function getStudenDetailByRut($numeroDocumento)
  {
    $get = FacadesDB::table('tblStudent')
      ->join('tblDetailStudent', 'tblStudent.idStudent', 'tblDetailStudent.idStudent')
      ->where('tblStudent.dni', $numeroDocumento)
      ->select('tblStudent.idStudent', 'tblStudent.dni', 'tblStudent.email', 'tblDetailStudent.firstName', 'tblDetailStudent.lastName')
      ->get()
      ->first();

    return $get;
  }
}
