<?php

namespace Novalnet\Zed\NovalnetPayment\Business\Payment;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\NovalnetCancelTransfer;
use Generated\Shared\Transfer\NovalnetCaptureTransfer;
use Generated\Shared\Transfer\NovalnetRedirectResponseTransfer;
use Generated\Shared\Transfer\NovalnetRefundTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface PaymentManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AuthorizationResponseTransfer
     */
    public function authorize(OrderTransfer $orderTransfer);

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return \Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    public function postSaveHook(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse);

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    public function saveOrderHook(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer);

    /**
     * @param \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer
     */
    public function processRedirectPaymentResponse(NovalnetRedirectResponseTransfer $redirectResponseTransfer);

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPayment3DSecure(int $idSalesOrder);

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isAuthorized(int $idSalesOrder);

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isAuthorizeError(int $idSalesOrder);

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentAuthorized(int $idSalesOrder);

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isWaitingForPayment(int $idSalesOrder);

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentCanceled(int $idSalesOrder);

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentPaid(int $idSalesOrder);

    /**
     * @param \Generated\Shared\Transfer\NovalnetCaptureTransfer $captureTransfer
     *
     * @return bool|null
     */
    public function capture(NovalnetCaptureTransfer $captureTransfer);

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentCaptured(int $idSalesOrder);

    /**
     * @param \Generated\Shared\Transfer\NovalnetCancelTransfer $cancelTransfer
     *
     * @return bool|null
     */
    public function cancel(NovalnetCancelTransfer $cancelTransfer);

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentVoided(int $idSalesOrder);

    /**
     * @param \Generated\Shared\Transfer\NovalnetRefundTransfer $refundTransfer
     *
     * @return object|null
     */
    public function refund(NovalnetRefundTransfer $refundTransfer);

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPaymentRefunded(int $idSalesOrder);

    /**
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isCallbackPaid(int $idSalesOrder);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getTransactionDetails(OrderTransfer $orderTransfer);

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function createMarketplaceData(MerchantTransfer $merchantTransfer);

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function updateMarketplaceData(MerchantTransfer $merchantTransfer);
}
