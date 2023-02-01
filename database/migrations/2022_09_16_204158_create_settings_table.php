<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('intro_title')->nullable();
            $table->string('intro_sub_title')->nullable();
            $table->string('welcome_hint')->nullable();
            $table->string('welcome_title')->nullable();
            $table->text('welcome_sub_title_title')->nullable();
            $table->string('welcome_image')->nullable();
            $table->string('about_title')->nullable();
            $table->string('about_sub_title')->nullable();
            $table->string('about_more_button_title')->nullable();
            $table->string('about_more_link')->nullable();
            $table->string('video_first_url')->nullable();
            $table->string('video_second_url')->nullable();
            $table->string('video_title')->nullable();
            $table->string('video_description')->nullable();
            $table->string('video_button_text')->nullable();
            $table->string('video_button_url')->nullable();
            $table->string('iphone_button_url')->nullable();
            $table->string('iphone_button_text')->nullable();
            $table->string('iphone_title')->nullable();
            $table->string('iphone_image')->nullable();
            $table->string('iphone_sub_title')->nullable();
            $table->string('android_button_url')->nullable();
            $table->string('android_button_text')->nullable();
            $table->string('android_title')->nullable();
            $table->string('android_image')->nullable();
            $table->string('android_sub_title')->nullable();

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
        Schema::dropIfExists('settings');
    }
}
