<?php

namespace Novalnet\Zed\NovalnetPayment\Business\Api\Adapter\Http;

use Novalnet\Zed\NovalnetPayment\Business\Api\Adapter\AdapterInterface;
use Novalnet\Zed\NovalnetPayment\Business\Exception\TimeoutException;

abstract class AbstractHttpAdapter implements AdapterInterface
{
    public const DEFAULT_TIMEOUT = 240;

    /**
     * @var int
     */
    protected $timeout = self::DEFAULT_TIMEOUT;

    /**
     * @var string
     */
    protected $url;

    /**
     * @param string $paymentGatewayUrl
     */
    public function __construct($paymentGatewayUrl)
    {
        $this->url = $paymentGatewayUrl;
    }

    /**
     * @param int $timeout
     *
     * @return void
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param array $params
     * @param string $payportUrl
     *
     * @return array
     */
    public function sendRawRequest(array $params, $payportUrl)
    {
        $result = $this->performRequest($params, $payportUrl);

        return $result;
    }

    /**
     * @param array $requestData
     * @param string $transactionType
     *
     * @return array
     */
    public function sendRequest($requestData, $transactionType)
    {
        try {
            $payportUrl = $this->getPayportUrl($requestData, $transactionType);

            return $this->sendRawRequest($requestData, $payportUrl);
        } catch (TimeoutException $e) {
            $fakeArray = [
                'status' => 'TIMEOUT',
            ];

            return $fakeArray;
        }
    }

    /**
     * @param array $params
     * @param string $payportUrl
     *
     * @return array
     */
    abstract protected function performRequest(array $params, $payportUrl);

    /**
     * @param array $requestData
     * @param string $transactionType
     *
     * @return string|null
     */
    public function getPayportUrl($requestData, $transactionType)
    {
        $payportUrl = 'https://payport.novalnet.de/v2/';

        if ($transactionType == 'authorize') {
            $transactionUrl = 'authorize';
        } elseif ($transactionType == 'capture') {
            $transactionUrl = 'transaction/capture';
        } elseif ($transactionType == 'cancel') {
            $transactionUrl = 'transaction/cancel';
        } elseif ($transactionType == 'refund') {
            $transactionUrl = 'transaction/refund';
        } elseif ($transactionType == 'transaction') {
            $transactionUrl = 'transaction/details';
        } elseif ($transactionType == 'affiliate') {
            $transactionUrl = 'affiliate/create';
        } else {
            $transactionUrl = 'payment';
        }

        return $payportUrl . $transactionUrl;
    }
}
