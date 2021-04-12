<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RestaurantUser extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('restaurant_user', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('restaurant_id');
      $table->unsignedInteger('user_id');
      $table->enum('role', ['user', 'admin'])->default('user');
      $table->timestamps();

      $table->index(['restaurant_id', 'user_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('restaurant_user');
  }
}
