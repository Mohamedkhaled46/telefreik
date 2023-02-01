<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePnotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pnotifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('link')->nullable();
            $table->boolean('read')->nullable();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('pnotification_type_id')->constrained();
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
        Schema::dropIfExists('pnotification');
    }
}
