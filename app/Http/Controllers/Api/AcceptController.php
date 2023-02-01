<?php

namespace App\Http\Controllers\Api;

use App\Services\AcceptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AcceptController extends Controller
{

    private $acceptService;

    /**
     * @var AcceptService $acceptService
     */

    public function __construct(AcceptService $acceptService)
    {
        $this->acceptService = $acceptService;

    }

    /**
     * Accept First call back function after payment success
     * @param Request $request
     * @return array
     */
    public function callbackProcess(Request $request): array
    {
        info($request->all());
        $type = $request->get('type');
        $obj = $request->get('obj');
        $hmac = $request->get('hmac');
        $calculatedHmac = $this->acceptService->calculateHmac($obj, config('accept.hmac_secret'));
        Log::info("calculated Hmac :" . json_encode($calculatedHmac));
        Log::info("response Hmac :" . json_encode($hmac));
        Log::info("response request :" . json_encode($request->all()));

        $orderId = explode('-', $obj['order']['merchant_order_id'])[0];
        $order = Order::where('id', $orderId)->first();

        Log::info("order :" . json_encode($order));
        Log::info("callback response from paymob :" . json_encode($obj));

        if ($this->acceptService->validateCallback($type, $obj, $hmac, $calculatedHmac)) {
            Log::info("valida response");
            // if accept sent us valid transaction callback, update order as paid, update payment info


            return [
                "status"=>true,
                "message"=>"Order confirmed successfully.",
             ];
        }

    }
}
