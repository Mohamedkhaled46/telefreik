<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('trip_id');
            $table->string('price');
            $table->bigInteger('from_location_id');
            $table->bigInteger('to_location_id');
            $table->longText('stations_from')->nullable();
            $table->longText('stations_to')->nullable();
            $table->string('company')->nullable();
            $table->integer('seats')->nullable();
            $table->string('class')->nullable();
            $table->string('type')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('locations');
    }
}
