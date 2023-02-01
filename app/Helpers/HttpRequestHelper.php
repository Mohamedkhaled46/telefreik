<?php


namespace App\Helpers;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HttpRequestHelper
{
    protected $client;

    /**
     * HttpRequest constructor.
     * @param Client $client
     */
//    public function __construct(Client $client)
//    public function __construct(Client $client)
//    {
//        $this->client = $client;
//    }

    /**
     * @param string $url
     * @param string $method
     * @param array $options
     * @return array|mixed
     */
    public function sendRequest(string $url, string $method = 'POST' , array $options = [])
    {
        $data = [];
        try {
            $this->client = New Client();
            $response = $this->client->request(
                $method,
                $url,
                $options
            );
            $data = json_decode($response->getBody()->getContents(),true);
            $data['success'] = true;
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        } catch (GuzzleException $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }
        return $data;
    }

}