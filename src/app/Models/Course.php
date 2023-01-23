<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB as FacadesDB;

class Course extends Model
{
  protected $table = "tblCourse";
  protected $primaryKey = "idCourse";

  /**
   * 
   *  Busca las propiedades del curso segun su id busqueda
   * 
   * @return get
   */
  public function getCursoById($idCurso)
  {
    $curso = new Course;
    $curso = Course::find($idCurso);
    return $curso;
  }

  public function getCursoAll()
  {
    $get = FacadesDB::table('tblCourse')
      ->get()
      ->all();

    return $get;
  }
}
