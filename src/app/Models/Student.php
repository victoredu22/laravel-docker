<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
  protected $table = "student";
  protected $primaryKey = "idStudent";
  protected $fillable = [
    'email',
    'password',
    'dni',
  ];

  /**
   * Metodo que trae detalles de todos los alumnos del sistema junto al detalleALumno
   *
   * @return get
   */
  public function getStudentsDetail()
  {
    $get = Student::select('tblStudent.idStudent', 'tblStudent.dni', 'tblStudent.email', 'tblDetailStudent.firstName', 'tblDetailStudent.lastName')
      ->join('tblDetailStudent', 'tblStudent.idStudent', 'tblDetailStudent.idStudent')
      ->get();
    return $get;
  }
}
