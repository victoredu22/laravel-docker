<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('delivery', function (Blueprint $table) {
      $table->increments('idDelivery');
      $table->integer('idBook')->unsigned();
      $table->integer('idStudent')->unsigned();
      $table->integer('stateDelivery');
      $table->date('dateDelivery');
      $table->date('dateRetirement');
      $table->timestamps();

      $table->foreign('idBook')->references('idBook')->on('book');
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
    Schema::dropIfExists('delivery');
  }
}
