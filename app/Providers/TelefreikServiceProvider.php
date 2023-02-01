<?php

namespace App\Providers;

use App\Repositories\CountryRepository;
use App\Repositories\GlobalSettingRepository;
use App\Repositories\Interfaces\ICountryRepository;
use App\Repositories\Interfaces\IGlobalSettingRepository;
use App\Repositories\Interfaces\ILocationRepository;
use App\Repositories\Interfaces\ILoginRepository;
use App\Repositories\Interfaces\IProviderRepository;
use App\Repositories\Interfaces\IPushNotificationRepository;
use App\Repositories\Interfaces\IRegisterRepository;
use App\Repositories\Interfaces\IReplyRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\LocationRepository;
use App\Repositories\LoginRepository;
use App\Repositories\ProviderRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\FaqRepository;
use App\Repositories\HomeSettingRepository;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IFaqRepository;
use App\Repositories\Interfaces\IHomeSettingRepository;
use App\Repositories\Interfaces\IPromotionalOfferRepository;
use App\Repositories\Interfaces\ITicketRepository;
use App\Repositories\Interfaces\ITicketReservationRepository;
use App\Repositories\PromotionalOfferRepository;
use App\Repositories\PushNotificationRepository;
use App\Repositories\RegisterRepository;
use App\Repositories\ReplyRepository;
use App\Repositories\TicketRepository;
use App\Repositories\TicketReservationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class TelefreikServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(IProviderRepository::class, ProviderRepository::class);
        $this->app->bind(ICustomerRepository::class, CustomerRepository::class);
        $this->app->bind(ITicketRepository::class, TicketRepository::class);
        $this->app->bind(IFaqRepository::class, FaqRepository::class);
        $this->app->bind(ILoginRepository::class, LoginRepository::class);
        $this->app->bind(IRegisterRepository::class, RegisterRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IGlobalSettingRepository::class, GlobalSettingRepository::class);
        $this->app->bind(IHomeSettingRepository::class, HomeSettingRepository::class);
        $this->app->bind(ICountryRepository::class, CountryRepository::class);
        $this->app->bind(IPushNotificationRepository::class, PushNotificationRepository::class);
        $this->app->bind(IReplyRepository::class, ReplyRepository::class);
        $this->app->bind(IPromotionalOfferRepository::class, PromotionalOfferRepository::class);
        $this->app->bind(ITicketReservationRepository::class, TicketReservationRepository::class);
        $this->app->bind(ILocationRepository::class, LocationRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
