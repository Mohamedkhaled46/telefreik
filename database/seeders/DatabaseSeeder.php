<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use App\Models\Customer;
use App\Models\Faq;
use App\Models\Reply;
use App\Models\Ticket;
use App\Models\HomeSetting;
use App\Models\PromotionalOffer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\ProviderSeeder;
use Database\Seeders\HomeSettingSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        $this->call(ProviderSeeder::class);
        Customer::factory(10)->create();
        CreditCard::factory(10)->create();
        Ticket::factory(10)->create();
        Reply::factory(10)->create();
        $this->call(HomeSettingSeeder::class);
        Ticket::factory(10)->create();
        Reply::factory(10)->create();
        Faq::factory(10)->create();
        PromotionalOffer::factory(20)->create();
    }
}
