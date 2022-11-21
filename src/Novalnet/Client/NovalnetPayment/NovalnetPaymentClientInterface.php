<?php

namespace Novalnet\Client\NovalnetPayment;

use Generated\Shared\Transfer\NovalnetCallbackResponseTransfer;
use Generated\Shared\Transfer\NovalnetRedirectResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;

interface NovalnetPaymentClientInterface
{
    /**
     * Specification:
     * - Handle response from Novalnet after redirect customer back to the shop after authorization on Sofort, iDeal, PayPal payment methods.
     * - Save response, update status etc.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer
     */
    public function processRedirectPaymentResponse(NovalnetRedirectResponseTransfer $redirectResponseTransfer): NovalnetRedirectResponseTransfer;

    /**
     * Specification:
     * - Handle Novalnet callback process after the payment.
     * - Save response, update status etc.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer $callbackResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer
     */
    public function processCallbackResponse(NovalnetCallbackResponseTransfer $callbackResponseTransfer): NovalnetCallbackResponseTransfer;

    /**
     * Specification:
     * - Get completed payment transaction details.
     * - Show in order history page.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getTransactionDetails(OrderTransfer $orderTransfer): OrderTransfer;
}
