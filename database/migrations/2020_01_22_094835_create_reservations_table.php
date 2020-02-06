<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->timestamps();
            $table->string('name');
            $table->integer('length');
            $table->bigIncrements('id');
            $table->string('accepted_from');
            $table->integer('person_count');
            $table->dateTime('starting_at');
            $table->unsignedBigInteger('user_id');
            $table->text('notice')->nullable();
            $table->json('tables')->nullable();
            $table->string('color')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_numer')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
