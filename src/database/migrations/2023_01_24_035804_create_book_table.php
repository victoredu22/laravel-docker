<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('book', function (Blueprint $table) {
      $table->increments('idBook');
      $table->string('nameBook');
      $table->string('author');
      $table->string('detail');
      $table->string('state');
      $table->bigInteger('count');
      $table->string('destiny');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('book');
  }
}
