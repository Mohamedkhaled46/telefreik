<?php


use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PromotionalOfferController;
use App\Http\Controllers\Api\PushNotificationController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StateController;
use App\Http\Controllers\Api\TicketReservationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\website\GlobalSettingController;
use App\Http\Controllers\Api\website\HomeSettingController;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\Api\CustomersController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\Api\website\CardsApiController;
use App\Http\Controllers\Api\website\AboutCardsApiController;
use App\Http\Controllers\Api\website\FeatureApiController;
use App\Http\Controllers\Api\website\NumberApiController;
use App\Http\Controllers\Api\website\SubscriptionApiController;
use App\Http\Controllers\Api\TripApiController;


Route::group(['prefix' => 'v1'], function () {
    /**
     * Dashboard
     */
    Route::group(['prefix' => 'dashboard'], function () {
        Route::post('login', [LoginController::class, 'loginDashBoard']);
        Route::post('forgot_password', [LoginController::class, 'forgotPassword']);
        Route::post('reset_password/{token}', [LoginController::class, 'resetPassword'])->name('password.reset');
        Route::post('setting/global/show', [GlobalSettingController::class, 'show']);
        Route::get('setting/terms_conditions', [GlobalSettingController::class, 'showTermsAndConditions']);
        Route::get('setting/home/show', [HomeSettingController::class, 'show']);
        Route::get('faqs', [FaqsController::class, 'index']);
        Route::get('setting/home-cards', [CardsApiController::class, 'list']);
        Route::get('setting/about-cards', [AboutCardsApiController::class, 'list']);
        Route::get('setting/features', [FeatureApiController::class, 'list']);
        Route::get('setting/numbers', [NumberApiController::class, 'list']);
    });

    Route::group(['prefix' => 'dashboard', 'middleware' => 'auth:sanctum'], function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::post('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('setting/global/update', [GlobalSettingController::class, 'update']);
        Route::post('setting/terms_conditions/update', [GlobalSettingController::class, 'updateTermsAndConditions']);
        Route::get('slkp/roles', [RoleController::class, 'index']);
        Route::get('slkp/states', [StateController::class, 'index']);
        Route::apiResource('providers', ProvidersController::class);
        Route::post('customers/{id}/change-status', [CustomersController::class, 'changeStatus']);
        Route::apiResource('customers', CustomersController::class);
        Route::post('tickets/{id}/change-status', [TicketsController::class, 'changeStatus']);
        Route::resource('tickets', TicketsController::class);
        Route::post('replies', [ReplyController::class, 'createFromDashBoard'])->name('replies.create.dashboard');
        Route::apiResource('faqs', FaqsController::class, ['except' => 'index']);
        Route::post('setting/home/update', [HomeSettingController::class, 'update']);
        Route::post('notifications/sendPushNotification', [PushNotificationController::class, 'sendPushNotification'])->name('sendPushNotification');

        Route::group(['prefix' => 'setting'], function () {
            Route::group(['prefix' => 'home-cards'], function () {
                Route::post('/new', [CardsApiController::class, 'create']);
                Route::get('/{card}', [CardsApiController::class, 'get']);
                Route::post('/{card}/update', [CardsApiController::class, 'update']);
                Route::delete('/{card}', [CardsApiController::class, 'delete']);
            });
            Route::group(['prefix' => 'about-cards'], function () {
                Route::post('/new', [AboutCardsApiController::class, 'create']);
                Route::get('/{card}', [AboutCardsApiController::class, 'get']);
                Route::post('/{card}/update', [AboutCardsApiController::class, 'update']);
                Route::delete('/{card}', [AboutCardsApiController::class, 'delete']);
            });
            Route::group(['prefix' => 'features'], function () {
                Route::post('/new', [FeatureApiController::class, 'create']);
                Route::get('/{feature}', [FeatureApiController::class, 'get']);
                Route::post('/{feature}/update', [FeatureApiController::class, 'update']);
                Route::delete('/{feature}', [FeatureApiController::class, 'delete']);
            });
            Route::group(['prefix' => 'numbers'], function () {
                Route::post('/new', [NumberApiController::class, 'create']);
                Route::get('/{number}', [NumberApiController::class, 'get']);
                Route::post('/{number}/update', [NumberApiController::class, 'update']);
                Route::delete('/{number}', [NumberApiController::class, 'delete']);
            });
            Route::group(['prefix' => 'subscription'], function () {
                Route::get('/', [SubscriptionApiController::class, 'list']);
                Route::post('/new', [SubscriptionApiController::class, 'create']);
                Route::get('get/{subscription}', [SubscriptionApiController::class, 'get']);
                //Route::post('/{subscription}/update',[SubscriptionApiController::class,'update']);
                Route::delete('/{subscription}', [SubscriptionApiController::class, 'delete']);
            });
        });
    });

    /**
     * App
     */
    Route::group(['prefix' => 'mobile'], function () {
        Route::post('customer/login', [LoginController::class, 'loginMobile'])->name('loginMobile');
        Route::post('customer/register', [RegisterController::class, 'registerMobile'])->name('registerMobile');
        Route::post('customer/social-register', [RegisterController::class, 'socialRegister'])->name('socialRegister');
        Route::get('promotionaloffers/list', [PromotionalOfferController::class, 'index'])->name('promotionaloffers.index');
    });

    Route::group(['prefix' => 'mobile', 'middleware' => ['auth:customer-api', 'scopes:customer']], function () {
        // authenticated staff routes here
        // Route::get('customer/test',function(){
        //     return "ssssssss";
        // });

        Route::post('customer/resendotp', [CustomersController::class, 'resendOTP'])->name('resendOTP');
        Route::post('customer/verifyotp', [CustomersController::class, 'verifyOTP'])->name('verifyOTP');

        Route::get('customer/showForMobile', [CustomersController::class, 'showForMobile'])->name('showForMobile');
        Route::post('customer/logout', [LoginController::class, 'logoutMobile'])->name('logoutMobile');
        Route::post('customer/refreshFirebaseToken', [LoginController::class, 'refreshFirebaseToken'])->name('refreshFirebaseToken');
        Route::post('customer/updateCustomerNonMobForMobile', [CustomersController::class, 'updateCustomerNonMobForMobile'])->name('updateCustomerNonMobForMobile');
        Route::post('customer/updateCustomerMobForMobile', [CustomersController::class, 'updateCustomerMobForMobile'])->name('updateCustomerMobForMobile');
        Route::get('customer/showNotificationsPerCustomerForMobile', [PushNotificationController::class, 'showNotificationsPerCustomerForMobile'])->name('showNotificationsPerCustomerForMobile');
        Route::post('customer/updateReadStatusForMobile', [PushNotificationController::class, 'updateReadStatusForMobile'])->name('updateReadStatusForMobile');
        Route::post('ticket/create', [TicketsController::class, 'create'])->name('tickets.create');
        Route::get('ticket/getAllForCustomer', [TicketsController::class, 'getAllForCustomer'])->name('tickets.getAllForCustomer');
        Route::get('ticket/{id}', [TicketsController::class, 'showForMobile'])->name('tickets.getForMobile');
        Route::post('replies/createForMobile', [ReplyController::class, 'createFromMobile'])->name('replies.create.mobile');

        Route::get('ticketreservation/search', [TicketReservationController::class, 'search'])->name('ticketreservation.search');
        Route::post('ticketreservation/create', [TicketReservationController::class, 'create'])->name('ticketreservation.create');
    });

    Route::group(['prefix' => 'trips'], function () {
        Route::any('bus/locations', [TripApiController::class, 'getTripsLocations']);
        Route::any('bus/locations/{sync}', [TripApiController::class, 'getTripsLocations'])->where('sync', 'sync');
        Route::any('we-bus-locations', [TripApiController::class, 'getWeBusLocations']);
        Route::get('bus/search', [TripApiController::class, 'searchTrip']);
        Route::get('bus/search/{sync}', [TripApiController::class, 'searchTrip'])->where('sync', 'sync');
        Route::post('we-bus-search-trip', [TripApiController::class, 'searchTripWeBus']);
        Route::post('we-bus-search-trip-main', [TripApiController::class, 'searchTripWeBusMain']);
        Route::post('available-seats', [TripApiController::class, 'availableSeats']);
        Route::post('create-order', [TripApiController::class, 'createOrder']);
    });
});
