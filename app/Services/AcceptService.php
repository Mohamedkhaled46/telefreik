<?php


namespace App\Services;


use App\Helpers\HttpRequestHelper;
use Exception;
use Illuminate\Support\Facades\Log;

class AcceptService
{
    const BASE_URL = "https://accept.paymobsolutions.com/api";

    protected $request;

    /**
     * AcceptService constructor.
     * @param HttpRequestHelper $request
     */
    public function __construct(HttpRequestHelper $request)
    {
        $this->request = $request;
    }

    public function cardPayment($order, $integration_id)
    {
        return $this->processPayment($order, $integration_id);
    }

    /** start payment process using the order and card token related to order
     * @param Order $order
     * @param null $integration_id
     * @return string
     */
    public function processPayment($order, $integration_id)
    {
        if (!$integration_id) {
            $integration_id = config('accept.integration_id');
        }
        try {
            $merchantInfo = $this->authenticate();
            $registeredOrder = $this->registerOrder($order, $merchantInfo['token'], $merchantInfo['profile']['id']);

            return $this->generatePaymentKey($order, $merchantInfo['token'], $registeredOrder['id'], $integration_id);
        } catch (Exception $exception) {
            Log::info("Process Payment Error : " . $exception->getMessage());
            return $exception->getMessage();
        }
    }

    /**
     * generate merchant token using api_key
     * @return array|mixed
     * @throws Exception
     */
    public function authenticate()
    {
        $options = [
            'json' => ['api_key' => config('accept.api_key')]
        ];
        $response = $this->request->sendRequest(
            self::BASE_URL . "/auth/tokens",
            'POST',
            $options
        );

        if (!$response["success"])
            throw new Exception("Error authenticating merchant : " . $response['message']);

        return $response;
    }

    /**
     * registering order in accept gateway server using merchant token and id.
     * @param Order $order
     * @param string $token
     * @param string $merchantId
     * @return array|mixed
     * @throws Exception
     */
    public function registerOrder($order, string $token, string $merchantId)
    {
        $options = [
            'json' => [
                'auth_token' => $token,
                'delivery_needed' => "false",
                'merchant_id' => (string)$merchantId,
                'amount_cents' => (string)ceil($order->price * 100),
                'currency' => "EGP",
                'merchant_order_id' => $order->id . '-' . $order->order_number . '-' . time(),
            ]
        ];

        $response = $this->request->sendRequest(
            self::BASE_URL . "/ecommerce/orders",
            'POST',
            $options
        );

        if (!$response["success"])
            throw new Exception("Error registering order : " . $response['message']);

        return $response;
    }

    /** generate payment key for registered order
     * @param Order $order
     * @param string $token
     * @param string $orderId
     * @param $integration_id
     * @return array|mixed
     * @throws Exception
     */
    public function generatePaymentKey($order, string $token, string $orderId, $integration_id)
    {

        $timer = 10800;

        $options = [
            'json' => [
                'auth_token' => $token,
                'amount_cents' => (string)ceil($order->price * 100),
                'expiration' => $timer,//seconds
                'delivery_needed' => "false",
                'order_id' => $orderId,
                'billing_data' => $this->generateBillingData($order),
                'currency' => "EGP",
                'integration_id' => (int)$integration_id
            ]
        ];

        $response = $this->request->sendRequest(
            self::BASE_URL . "/acceptance/payment_keys",
            'POST',
            $options
        );

        if (!$response["success"])
            throw new Exception("Error generating payment key : " . $response['message']);
        Log::info("request: " . json_encode($response));
        return $response['token'];
    }


    protected function generateBillingData( $order): array
    {
        return [
            "apartment" => "NA",
            "email" => @$order->customer->email ?: "mail@bluebus.com",
            "floor" => "NA",
            "first_name" => @$order->customer->name?:"amin",
            "street" => "NA",
            "building" => "NA",
            "phone_number" => @$order->customer->phone?:'01017213866',
            "shipping_method" => "NA",
            "postal_code" => "NA",
            "city" => "NA",
            "country" => "NA",
            "last_name" => " -BlueBus",
            "state" => "NA"
        ];
    }


    /**
     * validate the request is success or not
     * @param $type
     * @param $obj
     * @param $hmac
     * @param $calculatedHmac
     * @return bool
     */

    public function validateCallback($type, $obj, $hmac, $calculatedHmac): bool
    {

        Log::info('request type:' . $type);


        if ($hmac !== $calculatedHmac) {
            return false;
        }

        if ((str_contains($type, "TRANSACTION"))) {
            if ($obj['success'] === true && $obj['pending'] === false && $obj['is_refunded'] === false) {
                return true;
            }
        }

        return false;


    }

    /**
     *  Sort the data dictionary by key Lexicographical order
     *  Concatenate the values (not the keys) in one string.
     *  Calculate the hash of the concatenated string using SHA512 and your HMAC secret, found in the profile tab in your dashboard.
     *   The resultant HMAC is Hex (base 16) lowercase.
     *   Please note that they need to be in the order shown below.
     *   amount_cents, created_at, currency, error_occured, has_parent_transaction, id, integration_id, is_3d_secure, is_auth, is_capture, is_refunded, is_standalone_payment, is_voided, order.id, owner, pending, source_data.pan, source_data.sub_type, source_data.type, success
     * https://accept.paymobsolutions.com/docs/guide/hmac_calculation/#hmac-calculation
     * @param $obj
     * @param $hmacSecret
     * @return string [type]             [description]
     */
    public function calculateHmac($obj, $hmacSecret): string
    {
        Log::info("source_data.ban: " . $obj['source_data']['pan']);
        if ($obj['source_data']['pan'] == null)
            $obj['source_data']['pan'] = "";
        Log::info("source_data.ban: " . $obj['source_data']['pan']);
        log::info("hmacSecret :" . $hmacSecret);
        $data =
            json_encode($obj['amount_cents']) .
            json_encode($obj['created_at']) .
            json_encode($obj['currency']) .
            json_encode($obj['error_occured']) .
            json_encode($obj['has_parent_transaction']) .
            json_encode($obj['id']) .
            json_encode($obj['integration_id']) .
            json_encode($obj['is_3d_secure']) .
            json_encode($obj['is_auth']) .
            json_encode($obj['is_capture']) .
            json_encode($obj['is_refunded']) .
            json_encode($obj['is_standalone_payment']) .
            json_encode($obj['is_voided']) .
            json_encode($obj['order']['id']) .
            json_encode($obj['owner']) .
            json_encode($obj['pending']) .
            json_encode($obj['source_data']['pan']) .
            json_encode($obj['source_data']['sub_type']) .
            json_encode($obj['source_data']['type']) .
            json_encode($obj['success']);
        $data = str_replace('"', '', $data);
        Log::info("hmac data : " . $data);
        return hash_hmac('SHA512', $data, $hmacSecret);
    }

    /**
     * @throws Exception
     */
    public function processRefund($transaction_id, $amount): bool
    {
        Log::info("trnx id: " . $transaction_id);
        Log::info("amount: " . $amount);
        $merchantInfo = $this->authenticate();
        return $this->refundAmount($transaction_id, $amount, $merchantInfo['token']);
    }

    private function refundAmount($transaction_id, $amount, $token): bool
    {
        Log::info("refund amount : " . json_encode($amount));
        $options = [
            'json' => [
                'auth_token' => $token,
                'transaction_id' => $transaction_id,
                'amount_cents' => (string)ceil($amount * 100),
            ]
        ];
        Log::info("refund request body: " . json_encode($options));
        $response = $this->request->sendRequest(
            self::BASE_URL . "/acceptance/void_refund/refund",
            'POST',
            $options
        );
        Log::info("refund response: " . json_encode($response));
        return $this->checkRefundResponse($response);
    }

    private function checkRefundResponse($response): bool
    {
        if ($response["success"] === true)
            return true;
        return false;
    }


    /**
     * @throws Exception
     */
    public function payWithAman($order)
    {
        return $this->kioskPayment($order, config('accept.aman_integration_id'));
    }

    /**
     * @throws Exception
     */
    public function payWithWallet($order, $phone)
    {
        return $this->WalletPayment($order, config('accept.wallet_integration_id'),$phone);
    }

    /**
     * @throws Exception
     */
    public function payWithMasary($order)
    {
        return $this->kioskPayment($order, config('accept.masary_integration_id'));
    }

    /**
     * @throws Exception
     */
    private function kioskPayment($order, $integration_id)
    {
        $payment_token = $this->processPayment($order, $integration_id);
        return $this->getKioskReferenceCode($payment_token);
    }

    /**
     * @throws Exception
     */
    private function WalletPayment($order, $integration_id, $phone)
    {
        $payment_token = $this->processPayment($order, $integration_id);
        return $this->getWalletPaymentUrl($payment_token,$phone);
    }

    /**
     * @throws Exception
     */
    private function getKioskReferenceCode($payment_token)
    {
        $options = [
            'json' => [
                "source" => [
                    "identifier" => "AGGREGATOR",
                    "subtype" => "AGGREGATOR"
                ],
                'payment_token' => $payment_token,
            ]
        ];

        $response = $this->request->sendRequest(
            self::BASE_URL . "/acceptance/payments/pay",
            'POST',
            $options
        );
        Log::info("pay with kiosk response :" . json_encode($response));
        if ($response["success"] && $response["pending"])
            return $response['data']['bill_reference'];

        throw new Exception("Error generating Aman Code : ");
    }

    /**
     * @throws Exception
     */
    private function getWalletPaymentUrl($payment_token,$phone)
    {
        $options = [
            'json' => [
                "source" => [
                    "identifier" => $phone?:auth('customers')->user()->phone,
                    "subtype" => "WALLET"
                ],
                'payment_token' => $payment_token,
            ]
        ];

        $response = $this->request->sendRequest(
            self::BASE_URL . "/acceptance/payments/pay",
            'POST',
            $options
        );
        Log::info("pay with wallet response :" . json_encode($response));
        if ($response["redirect_url"])
            return $response["redirect_url"];

        throw new Exception("Error generating Wallet Request : ");
    }


    public function payWithValue($order)
    {
        $integration_id = config('accept.Value_integration_id');
        return $this->processPayment($order, $integration_id);
    }

    public function voidTransaction($transaction_id)
    {
        Log::info("void request trans id :" . json_encode($transaction_id));
        $merchantInfo = $this->authenticate();
        Log::info("void request merchant token:" . json_encode($merchantInfo['token']));
        $options = [
            'json' => [
                'auth_token' => $merchantInfo['token'],
                'transaction_id' => $transaction_id,
            ]
        ];
        $response = $this->request->sendRequest(
            self::BASE_URL . "/acceptance/void_refund/void",
            'POST',
            $options
        );
        Log::info("void response :" . json_encode($response));

        return $this->checkVoidResponse($response);
    }

    private function checkVoidResponse($response): bool
    {
        if ($response["success"] === true && $response["pending"] === false && $response['is_voided'] === false && $response["is_void"] === true)
            return true;

        return false;
    }
}
