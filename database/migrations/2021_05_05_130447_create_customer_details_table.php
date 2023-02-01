<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_details', function (Blueprint $table) {
            $table->id();
            $table->string('firebase_token')->nullable();
            $table->string('os_system')->nullable();
            $table->string('os_version')->nullable();
            $table->foreignId('customer_id')->constrained();
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
        Schema::dropIfExists('customer_details');
    }
}
