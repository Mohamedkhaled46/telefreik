<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class HomeSettingSeeder extends Seeder
{
    protected $keys = [
        'download_first_title', 'download_second_title', 'download_paragraph',
        'about_first_title', 'about_second_title', 'about_paragraph', 'about_image',
        'service_first_title', 'service_second_title', 'service_feature_title', 'service_feature_paragraph',
        'welcome_paragraph', 'welcome_image'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('home_settings')->truncate();
        $this->seed();
    }
    public function seed()
    {
        foreach ($this->keys as  $value) {
            DB::table('home_settings')->insert([
                'key' => $value,
                'value' => '',
                "created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
                "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
            ]);
        }
    }
}
