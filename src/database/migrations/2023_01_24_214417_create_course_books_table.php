<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseBooksTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('course_books', function (Blueprint $table) {
      $table->increments('idCourseBooks');
      $table->integer('idCourse')->unsigned();
      $table->integer('idBook')->unsigned();
      $table->boolean('active');
      $table->timestamps();

      $table->foreign('idCourse')->references('idCourse')->on('course');
      $table->foreign('idBook')->references('idBook')->on('book');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('course_books');
  }
}
