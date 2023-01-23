<?php

namespace App\Http\Controllers;


use App\Models\Student;
use Exception;
use Illuminate\Http\Request;


class StudentController extends Controller
{
  protected $student;

  public function __construct()
  {
    $this->student = new Student();
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      $students = $this->student->getStudentsDetail();

      $students->map(function ($student) {
        $student->dni = $student->dni . '-' . $this->calculaDV($student->dni);
        return $student;
      });
      return response()
        ->json([
          'ok' => true,
          'students' => $students
        ]);
    } catch (Exception $e) {
      return response()
        ->json([
          'error' => $e->getMessage()
        ], 422);
    }
  }


  /**
   * Busqueda del alumno segun el rut entrega todos los datos personales del alumno
   * 
   * @author victor curilao
   */
  public function show(Request $request)
  {
    try {
      $student = $this->student->getStudentById($request->rut);
      return response()
        ->json([
          'ok' => true,
          'student' => $student
        ]);
    } catch (Exception $e) {
      return response()
        ->json([
          'error' => $e->getMessage()
        ], 422);
    }
  }
  /**
   * Calcula el digito verificador de un RUT.
   * Fuente: http://www.dcc.uchile.cl/~mortega/microcodigos/validarrut/php.php
   * @author Luis Dujovne
   * @param int $r  Un RUT sin DV
   * @return char(1) el digito verificador del RUT
   */
  public function calculaDV($r)
  {
    $s = 1;
    for ($m = 0; $r != 0; $r /= 10) {
      $s = ($s + $r % 10 * (9 - $m++ % 6)) % 11;
    }

    return chr($s ? $s + 47 : 75);
  }
}
