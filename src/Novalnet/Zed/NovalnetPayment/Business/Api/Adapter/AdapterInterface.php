<?php

namespace Novalnet\Zed\NovalnetPayment\Business\Api\Adapter;

interface AdapterInterface
{
    /**
     * @param array $params
     * @param string $payportUrl
     *
     * @return array
     */
    public function sendRawRequest(array $params, $payportUrl);

    /**
     * @param array $requestData
     * @param string $transactionType
     *
     * @return array
     */
    public function sendRequest($requestData, $transactionType);
}
