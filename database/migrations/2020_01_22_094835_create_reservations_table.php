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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('table_id');
            $table->timestamps();
            $table->string('name');
            $table->integer('length');
            $table->string('accepted_from');
            $table->integer('person_count');
            $table->dateTime('starting_at');
            $table->text('notice')->nullable();
            $table->string('color')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_numer')->nullable();

            $table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
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
