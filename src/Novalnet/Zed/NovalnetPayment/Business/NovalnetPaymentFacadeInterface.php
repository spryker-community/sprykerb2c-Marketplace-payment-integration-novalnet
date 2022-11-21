<?php

namespace Novalnet\Zed\NovalnetPayment\Business;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\NovalnetCallbackResponseTransfer;
use Generated\Shared\Transfer\NovalnetCancelTransfer;
use Generated\Shared\Transfer\NovalnetCaptureTransfer;
use Generated\Shared\Transfer\NovalnetRedirectResponseTransfer;
use Generated\Shared\Transfer\NovalnetRefundTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface NovalnetPaymentFacadeInterface
{
    /**
     * Specification:
     * - Performs payment authorization request to Novalnet API and updates payment data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    public function authorizePayment(OrderTransfer $orderTransfer);

    /**
     * Specification:
     * - Handles redirects and errors after order placement.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return \Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    public function postSaveHook(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse);

    /**
     * Specification:
     * - Handles payment detail saving process.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return \Generated\Shared\Transfer\saveOrderTransfer
     */
    public function saveOrderHook(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer);

    /**
     * Specification:
     * - Handles redirect payment response.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer
     */
    public function processRedirectPaymentResponse(NovalnetRedirectResponseTransfer $redirectResponseTransfer);

    /**
     * Specification:
     * - Check whether the payment request is authorized.
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isAuthorized(int $idSalesOrder);

    /**
     * Specification:
     * - Check whether the authorize payment request is error.
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isAuthorizeError(int $idSalesOrder);

    /**
     * Specification:
     * - Check the payment trasnaction is under paid (like on-hold).
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentAuthorized(int $idSalesOrder);

    /**
     * Specification:
     * - Check the payment trasnaction is under paid (like Prepayment & Invoice).
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isWaitingForPayment(int $idSalesOrder);

    /**
     * Specification:
     * - Check the payment canceled for the authorized transaction.
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentCanceled(int $idSalesOrder);

    /**
     * Specification:
     * - Check the payment received from the end-customer account for the transaction.
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentPaid(int $idSalesOrder);

    /**
     * Specification:
     * - Performs payment capture for authorized payment transaction.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NovalnetCaptureTransfer $captureTransfer
     *
     * @return void
     */
    public function capturePayment(NovalnetCaptureTransfer $captureTransfer);

    /**
     * Specification:
     * - Check the payment captured for the authorized transaction.
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentCaptured(int $idSalesOrder);

    /**
     * Specification:
     * - Performs payment cancel for authorized payment transaction.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NovalnetCancelTransfer $cancelTransfer
     *
     * @return void
     */
    public function cancelPayment(NovalnetCancelTransfer $cancelTransfer);

    /**
     * Specification:
     * - Check the payment canceled by the customer or bank.
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentVoided(int $idSalesOrder);

    /**
     * Specification:
     * - Performs payment refund for confirmed transaction.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NovalnetRefundTransfer $refundTransfer
     *
     * @return void
     */
    public function refundPayment(NovalnetRefundTransfer $refundTransfer);

    /**
     * Specification:
     * - Check the payment is refunded.
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentRefunded(int $idSalesOrder);

    /**
     * Specification:
     * - Handles callback process for the payment transactions.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer $callbackResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer
     */
    public function processCallbackResponse(NovalnetCallbackResponseTransfer $callbackResponseTransfer);

    /**
     * Specification:
     * - Update the order status to paid based on the Novalnet callback response.
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isCallbackPaid(int $idSalesOrder);

    /**
     * Specification:
     * - Get payment transaction details.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getTransactionDetails(OrderTransfer $orderTransfer);

    /**
     * Specification:
     * - Handles affiliate creation with Novalnet(Via API).
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function updateMarketplaceData(MerchantTransfer $merchantTransfer);

    /**
     * Specification:
     * - Handles affiliate creation with Novalnet(Via API).
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function createMarketplaceData(MerchantTransfer $merchantTransfer);
}
