<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailStudent extends Model
{
  protected $table = "detail_student";
  protected $primaryKey = "idDetailStudent";
  protected $fillable = [
    'idStudent',
    'firstName',
    'lastName',
  ];
}
