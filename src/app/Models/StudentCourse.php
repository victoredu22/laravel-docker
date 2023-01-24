<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
  protected $table = "tblStudentCourse";
  protected $primaryKey = "idStudentCourse";


  public function getStudentById($idStudent)
  {
    $alumno = StudentCourse::find($idStudent)
      ->first();
    return $alumno;
  }

  public function getStudentCourse($idsCurso)
  {
    $get = StudentCourse::select('tblStudentCourse.idStudent', 'tblStudentCourse.idStudentCourse', 'tblStudent.dni', 'tblDetailStudent.firstName', 'tblDetailStudent.lastName')
      ->whereIn('tblStudentCourse.idCourse', $idsCurso)
      ->leftJoin('tblStudent', 'tblStudentCourse.idStudent', '=', 'tblStudent.idStudent')
      ->leftJoin('tblDetailStudent', 'tblStudentCourse.idStudent', '=', 'tblDetailStudent.idStudent')
      ->get()->unique('idStudent');
    return $get;
  }
}
