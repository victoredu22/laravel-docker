<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailStudentTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('detail_student', function (Blueprint $table) {
      $table->increments('idDetailStudent');
      $table->integer('idStudent')->unsigned();
      $table->string('firstName');
      $table->string('lastName');
      $table->timestamps();

      $table->foreign('idStudent')->references('idStudent')->on('student');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('detail_student');
  }
}
