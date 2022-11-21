<?php

namespace Novalnet\Zed\NovalnetPayment\Business\Api\Adapter\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Novalnet\Zed\NovalnetPayment\Business\Exception\TimeoutException;

class Guzzle extends AbstractHttpAdapter
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param string $accessKey
     */
    public function __construct($accessKey)
    {
        $options['headers'] = [
            'Content-Type' => 'application/json',
            'Charset' => 'utf-8',
            'Accept' => 'application/json',
            'X-NN-Access-Key' => base64_encode($accessKey),
        ];
        $options['timeout'] = $this->getTimeout();

        $this->client = new Client($options);
    }

    /**
     * @param array $params
     * @param string $payportUrl
     *
     * @throws \Novalnet\Zed\NovalnetPayment\Business\Exception\TimeoutException
     *
     * @return array
     */
    protected function performRequest(array $params, $payportUrl)
    {
        try {
            $response = $this->client->post($payportUrl, ['body' => json_encode($params)]);
        } catch (ConnectException $e) {
            throw new TimeoutException('Timeout - Novalnet Communication: ' . $e->getMessage());
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        $result = json_decode((string)$response->getBody());

        return $result;
    }
}
