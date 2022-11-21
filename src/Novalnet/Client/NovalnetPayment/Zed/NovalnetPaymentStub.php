<?php

namespace Novalnet\Client\NovalnetPayment\Zed;

use Generated\Shared\Transfer\NovalnetCallbackResponseTransfer;
use Generated\Shared\Transfer\NovalnetRedirectResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Novalnet\Client\NovalnetPayment\Dependency\Client\NovalnetPaymentToZedRequestClientInterface;

class NovalnetPaymentStub implements NovalnetPaymentStubInterface
{
    /**
     * @var \Novalnet\Client\NovalnetPayment\Dependency\Client\NovalnetPaymentToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \Novalnet\Client\NovalnetPayment\Dependency\Client\NovalnetPaymentToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(NovalnetPaymentToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer
     */
    public function processRedirectPaymentResponse(NovalnetRedirectResponseTransfer $redirectResponseTransfer): NovalnetRedirectResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer $redirectResponseTransfer */
        $redirectResponseTransfer = $this->zedRequestClient->call('/novalnet-payment/gateway/process-redirect-payment-response', $redirectResponseTransfer);

        return $redirectResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer $callbackResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer
     */
    public function processCallbackResponse(NovalnetCallbackResponseTransfer $callbackResponseTransfer): NovalnetCallbackResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer $callbackResponseTransfer */
        $callbackResponseTransfer = $this->zedRequestClient->call('/novalnet-payment/gateway/process-callback-response', $callbackResponseTransfer);

        return $callbackResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getTransactionDetails(OrderTransfer $orderTransfer): OrderTransfer
    {
        /** @var \Generated\Shared\Transfer\OrderTransfer $orderTransfer */
        $orderTransfer = $this->zedRequestClient->call('/novalnet-payment/gateway/transaction-details', $orderTransfer);

        return $orderTransfer;
    }
}
