<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseBooks extends Model
{
  protected $table = "course_books";
  protected $primaryKey = "idCourseBooks";
  protected $fillable = [
    'idCourse',
    'idBook',
    'active'
  ];
}
