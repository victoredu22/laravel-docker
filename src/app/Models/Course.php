<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    $curso = Course::find($idCurso);
    return $curso;
  }

  public function getCursoAll()
  {
    $get = Course::get();

    return $get;
  }
}
