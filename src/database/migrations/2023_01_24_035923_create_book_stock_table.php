<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookStockTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('book_stock', function (Blueprint $table) {
      $table->increments('idStockBook');
      $table->integer('idBook')->unsigned();
      $table->bigInteger('count');
      $table->timestamps();

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
    Schema::dropIfExists('book_stock');
  }
}
