<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('type')->comment('Flights, Voyage, Trains, Busses, Microbuses, Limousine')->nullable();
            $table->string('logo')->nullable();
            $table->decimal('rate', 2, 1)->nullable();
            $table->decimal('rating', 2, 1)->nullable();
            $table->decimal('cost', 16, 2)->nullable();
            $table->decimal('income', 16, 2)->nullable();
            $table->decimal('revenue', 16, 2)->nullable();
            $table->softDeletes();
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
        Schema::table('providers', function (Blueprint $table) {
            Schema::dropIfExists('providers');
        });
    }
}
