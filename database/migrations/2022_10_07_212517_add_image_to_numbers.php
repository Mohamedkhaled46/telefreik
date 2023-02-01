<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('numbers', function (Blueprint $table) {
        //     $table->dropColumn(['title', 'sub_title', 'number']);
        //     $table->string('number');
        // });
        // Schema::table('features', function (Blueprint $table) {
        //     $table->dropColumn(['subtitle']);
        //     $table->string('image');
        //     $table->text('description')->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('numbers', function (Blueprint $table) {
        //     //
        // });
    }
}
