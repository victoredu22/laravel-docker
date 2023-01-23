<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB as FacadesDB;

class StudentCourse extends Model
{
  protected $table = "tblStudentCourse";
  protected $primaryKey = "idStudentCourse";


  public function getStudentById($idStudent)
  {

    $alumno = FacadesDB::table('tblStudentCourse')
      ->where('idStudent', $idStudent)
      ->get()
      ->first();

    return $alumno;
  }

  public function getStudentCourse($idsCurso)
  {

    $get = FacadesDB::table('tblStudentCourse')
      ->whereIn('tblStudentCourse.idCourse', $idsCurso)
      ->leftJoin('tblStudent', 'tblStudentCourse.idStudent', '=', 'tblStudent.idStudent')
      ->leftJoin('tblDetailStudent', 'tblStudentCourse.idStudent', '=', 'tblDetailStudent.idStudent')
      ->select('tblStudentCourse.idStudent', 'tblStudentCourse.idStudentCourse', 'tblStudent.dni', 'tblDetailStudent.firstName', 'tblDetailStudent.lastName')
      ->get()->unique('idStudent');
    return $get;
  }
}
