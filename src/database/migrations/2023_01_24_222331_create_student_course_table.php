<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCourseTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('student_course', function (Blueprint $table) {
      $table->increments('idStudentCourse');
      $table->integer('idStudent')->unsigned();
      $table->integer('idCourse')->unsigned();
      $table->timestamps();

      $table->foreign('idStudent')->references('idStudent')->on('student');
      $table->foreign('idCourse')->references('idCourse')->on('course');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('studen_course');
  }
}
