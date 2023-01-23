<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentCourse;
use App\Models\Course;
use Exception;

class CourseController extends Controller
{
  protected $student;
  protected $course;
  public function __construct()
  {
    $this->student = new StudentCourse();
    $this->course = new Course();
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      $course = $this->course->getCursoAll();
      return response()->json([
        'ok' => true,
        'getCurso' => $course
      ]);
    } catch (Exception $e) {
      return response()
        ->json([
          'error' => $e->getMessage()
        ], 422);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $idCourse)
  {
    try {
      $url = explode('/', $request->path());
      if (end($url) === 'students') {
        $idCourse = explode(',', $idCourse);
        foreach ($idCourse as $index => $value) {
          $idCourse[$index] = (int) $value;
        }
        $students = $this->student->getStudentCourse($idCourse)->values()->all();
        return response()->json(["student" => $students], 200);
      }

      $students = $this->student->getStudentCourse([(int) $idCourse])->values()->all();
      collect($students)->map(function ($student) {
        $student->dni = $student->dni . '-' . $this->calculaDV($student->dni);
        return $student;
      });
      return response()->json(["student" => $students], 200);
    } catch (Exception $e) {
      return response()
        ->json([
          'error' => $e->getMessage()
        ], 422);
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
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
