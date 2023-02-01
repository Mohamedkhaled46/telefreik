<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use App\Services\AcceptService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestController extends Controller
{


    private $acceptService;

    public function __construct(AcceptService $acceptService)
    {
        $this->acceptService = $acceptService;
    }

    public function runQuery()
    {
        Schema::table('features', function (Blueprint $table) {
            $table->dropColumn(['subtitle']);
            $table->string('image');
            $table->text('description')->nullable();
        });
    }
    public function runCommand()
    {
        Artisan::call('migrate', [
            '--force' => true,
        ]);
    }
    public function runExecute()
    {
        shell_exec("cd /home1/rbfnjvmy/public_html/telefreik-backend && composer i");
    }
    public function run()
    {
        return  Artisan::call('config:cache', []);
    }
    public function payment()
    {
        $integration_id = config('accept.integration_id');

        $order = new \stdClass();
        $order->id = rand(9000000000, 999999999999);
        $order->price = rand(500, 99999);
        $order->order_number = rand(9000000000, 999999999999);


        $token = $this->acceptService->processPayment($order, $integration_id);


        return view('payment.paymob', compact('integration_id', 'token'));
    }
}
