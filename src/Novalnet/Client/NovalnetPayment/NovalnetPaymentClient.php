<?php

namespace Novalnet\Client\NovalnetPayment;

use Generated\Shared\Transfer\NovalnetCallbackResponseTransfer;
use Generated\Shared\Transfer\NovalnetRedirectResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Novalnet\Client\NovalnetPayment\NovalnetPaymentFactory getFactory()
 */
class NovalnetPaymentClient extends AbstractClient implements NovalnetPaymentClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer
     */
    public function processRedirectPaymentResponse(NovalnetRedirectResponseTransfer $redirectResponseTransfer): NovalnetRedirectResponseTransfer
    {
        return $this
            ->getFactory()
            ->createZedNovalnetPaymentStub()
            ->processRedirectPaymentResponse($redirectResponseTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer $callbackResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer
     */
    public function processCallbackResponse(NovalnetCallbackResponseTransfer $callbackResponseTransfer): NovalnetCallbackResponseTransfer
    {
        return $this
            ->getFactory()
            ->createZedNovalnetPaymentStub()
            ->processCallbackResponse($callbackResponseTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getTransactionDetails(OrderTransfer $orderTransfer): OrderTransfer
    {
        return $this
            ->getFactory()
            ->createZedNovalnetPaymentStub()
            ->getTransactionDetails($orderTransfer);
    }
}
