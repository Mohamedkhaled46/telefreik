<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

if (!function_exists('getLocales')) {
    /**
     * @return array array of supported locales
     */
    function getLocales()
    {
        return ["ar", "en"];
    }
}
if (!function_exists('asyncGetRequest')) {

    /**
     * @return array array of supported locales
     */
    function asyncGetRequest($url,$token ="",  $data = [], $json = false)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}",
            'Content-Type' => "application/json",
        ])->async()->get($url, $data);


        return  $response;
    }
}
if (!function_exists('asyncPostRequest')) {

    /**
     * @return array array of supported locales
     */
    function asyncPostRequest($url,$token ="",  $data = [], $json = false)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$token}",
            'Content-Type' => "application/json",
        ])->async()->post($url, $data);

        return  $response;
    }
}
if (!function_exists('resourceToArray')) {

    /**
     * @return array array of supported locales
     */
    function resourceToArray($resource,$data)
    {
        $collection = $resource::collection($data);
        //change laravel collection to array
        return collect($collection)->toArray();
    }
}

if (!function_exists('sendResponse')) {

    /**
     * return success response.
     *
     * @return \Illuminate\Http\Response
     */
    function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }
}

if (!function_exists('sendError')) {

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}

// Eng Fahmi Moustafa
if (!function_exists('randomCode')) {
    /**
     * @param $length int size of randomly generated number max size 100
     * @param $type int 0 for alphanumeric , 1  for numeric only, 2 for alphapitical only
     * @return mixed
     */
    function randomCode($length, $type = 0)
    {
        $min_lenght = 1;
        $max_lenght = 100;
        $bigL = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $smallL = "abcdefghijklmnopqrstuvwxyz";
        $number = "123456789";
        $bigB = str_shuffle($bigL);
        $smallS = str_shuffle($smallL);
        $numberS = str_shuffle($number);
        $subA = substr($bigB, 0, 5);
        $subB = substr($bigB, 6, 5);
        $subC = substr($bigB, 10, 5);
        $subD = substr($smallS, 0, 5);
        $subE = substr($smallS, 6, 5);
        $subF = substr($smallS, 10, 5);
        $subG = substr($numberS, 0, 5);
        $subH = substr($numberS, 6, 5);
        $subI = substr($numberS, 9, 5);
        switch ($type) {
            case 1:
                $RandCode1 = str_shuffle($subG . $subH . $subI);
                break;
            case 2:
                $RandCode1 = str_shuffle($subA . $subD . $subB . $subF . $subC . $subE);
                break;
            default:
                $RandCode1 = str_shuffle($subA . $subD . $subB . $subF . $subC . $subE . $subG . $subH . $subI);
                break;
        }
        $RandCode2 = str_shuffle($RandCode1);
        $RandCode = $RandCode1 . $RandCode2;

        if ($length > $min_lenght && $length < $max_lenght) {
            $CodeEX = substr($RandCode, 0, $length);
        } else {
            $CodeEX = $RandCode;
        }
        return $CodeEX;
    }
}

if (!function_exists('sendSMS')) {
    /**
     * @param $message string message to customer
     * @param $mobile string customer mobile number without country code
     * @return array
     */
    function sendSMS($message, $mobile)
    {
        $result = array();
        if (env('SMS') == "local") {
            $result["sms"] = true;
            $result["smsapi"] = true;
        } else {
            $guzzelClient = new Client();
            $response = $guzzelClient->request('POST', 'sms prvider api', [
                'json' => [
                    "account_id" => 12365546,
                    "text" => "{$message}",
                    "msisdn" => "2{$mobile}",
                    // "mnc" => "1",
                    // "mcc" => "602",
                    "sender" => "marasil",
                ],
                [
                    'connect_timeout' => 30
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ',
                ]
            ]);
            if ($response->getStatusCode() === 200) {
                $data =  (string) $response->getBody();
                $data = json_decode($data, true);
                $sms = filter_var($data['status'], FILTER_VALIDATE_BOOLEAN);
                $smsAPI = true;
            } else {
                $sms = false;
                $smsAPI = false;
            }
            $result["sms"] = $sms;
            $result["smsapi"] = $smsAPI;
        }
        return $result;
    }
}
