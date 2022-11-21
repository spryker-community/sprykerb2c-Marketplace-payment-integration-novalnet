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
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Novalnet\Zed\NovalnetPayment\Business\NovalnetPaymentBusinessFactory getFactory()
 */
class NovalnetPaymentFacade extends AbstractFacade implements NovalnetPaymentFacadeInterface
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
    public function authorizePayment(OrderTransfer $orderTransfer)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->authorize($orderTransfer);
    }

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
    public function postSaveHook(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->postSaveHook($quoteTransfer, $checkoutResponse);
    }

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
    public function saveOrderHook(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->saveOrderHook($quoteTransfer, $saveOrderTransfer);
    }

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
    public function processRedirectPaymentResponse(NovalnetRedirectResponseTransfer $redirectResponseTransfer)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->processRedirectPaymentResponse($redirectResponseTransfer);
    }

    /**
     * Specification:
     * - Check whether the payment is Credit Card 3D Secure.
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function isPayment3DSecure(int $idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->isPayment3DSecure($idSalesOrder);
    }

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
    public function isAuthorized(int $idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->isAuthorized($idSalesOrder);
    }

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
    public function isAuthorizeError(int $idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->isAuthorizeError($idSalesOrder);
    }

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
    public function isPaymentAuthorized(int $idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->isPaymentAuthorized($idSalesOrder);
    }

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
    public function isWaitingForPayment(int $idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->isWaitingForPayment($idSalesOrder);
    }

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
    public function isPaymentCanceled(int $idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->isPaymentCanceled($idSalesOrder);
    }

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
    public function isPaymentPaid(int $idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->isPaymentPaid($idSalesOrder);
    }

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
    public function capturePayment(NovalnetCaptureTransfer $captureTransfer)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->capture($captureTransfer);
    }

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
    public function isPaymentCaptured(int $idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->isPaymentCaptured($idSalesOrder);
    }

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
    public function cancelPayment(NovalnetCancelTransfer $cancelTransfer)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->cancel($cancelTransfer);
    }

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
    public function isPaymentVoided(int $idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->isPaymentVoided($idSalesOrder);
    }

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
    public function refundPayment(NovalnetRefundTransfer $refundTransfer)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->refund($refundTransfer);
    }

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
    public function isPaymentRefunded(int $idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->isPaymentRefunded($idSalesOrder);
    }

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
    public function processCallbackResponse(NovalnetCallbackResponseTransfer $callbackResponseTransfer)
    {
        return $this->getFactory()
            ->createCallbackManager()
            ->processCallback($callbackResponseTransfer);
    }

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
    public function isCallbackPaid(int $idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->isCallbackPaid($idSalesOrder);
    }

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
    public function getTransactionDetails(OrderTransfer $orderTransfer)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->getTransactionDetails($orderTransfer);
    }

    /**
     * Specification:
     * - Filters Novalnet payment methods.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PaymentMethodsTransfer $paymentMethodsTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodsTransfer
     */
    public function filterPaymentMethods(PaymentMethodsTransfer $paymentMethodsTransfer, QuoteTransfer $quoteTransfer): PaymentMethodsTransfer
    {
        return $this->getFactory()
            ->createPaymentMethodFilter()
            ->filterPaymentMethods($paymentMethodsTransfer, $quoteTransfer);
    }

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
    public function updateMarketplaceData(MerchantTransfer $merchantTransfer)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->updateMarketplaceData($merchantTransfer);
    }

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
    public function createMarketplaceData(MerchantTransfer $merchantTransfer)
    {
        return $this->getFactory()
            ->createPaymentManager()
            ->createMarketplaceData($merchantTransfer);
    }
}
