<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('reservation_table', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('reservation_id');
      $table->unsignedInteger('table_id');
      $table->timestamps();

      $table->index(['reservation_id', 'table_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('reservation_table');
  }
}
