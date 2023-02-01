<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('status', ["Active", "Banned", "Inactive"])->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('SUUID')->nullable();
            $table->string('loggedBy')->comment('Enum : facebook,google,default');
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('country_id')->constrained();
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
        Schema::dropIfExists('customers');
    }
}
