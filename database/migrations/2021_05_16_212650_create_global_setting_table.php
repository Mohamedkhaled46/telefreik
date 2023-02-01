<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGlobalSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_setting', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();
        });


        $data = [
            ['key' => 'social_facebook'],
            ['key' => 'social_instagram'],
            ['key' => 'social_twitter'],
            ['key' => 'contact_phone'],
            ['key' => 'contact_email'],
            ['key' => 'footer_title'],
            ['key' => 'footer_description'],
            ['key' => 'footer_link_1'],
            ['key' => 'footer_title_1'],
            ['key' => 'footer_link_2'],
            ['key' => 'footer_title_2'],
            ['key' => 'footer_link_3'],
            ['key' => 'footer_title_3'],
            ['key' => 'footer_link_4'],
            ['key' => 'footer_title_4'],
            ['key' => 'footer_link_5'],
            ['key' => 'footer_title_5'],
            ['key' => 'android_link'],
            ['key' => 'apple_link'],
            ['key' => 'terms_and_conditions'],
        ];
        DB::table('global_setting')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_setting');
    }
}
