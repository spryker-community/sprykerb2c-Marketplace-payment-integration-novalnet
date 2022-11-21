<?php

namespace Novalnet\Zed\NovalnetPayment\Business\Payment;

use ArrayObject;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig;
use Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface;

class PaymentMethodFilter implements PaymentMethodFilterInterface
{
    protected const NOVALNET_PAYMENT_METHOD = 'novalnet';

    /**
     * @var \Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig
     */
    protected $config;

    /**
     * @var \Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @param \Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig $config
     * @param \Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface $queryContainer
     */
    public function __construct(
        NovalnetPaymentConfig $config,
        NovalnetPaymentQueryContainerInterface $queryContainer
    ) {
        $this->config = $config;
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentMethodsTransfer $paymentMethodsTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodsTransfer
     */
    public function filterPaymentMethods(PaymentMethodsTransfer $paymentMethodsTransfer, QuoteTransfer $quoteTransfer): PaymentMethodsTransfer
    {
        $result = new ArrayObject();

        foreach ($paymentMethodsTransfer->getMethods() as $paymentMethod) {
            $enabledPayments[] = $paymentMethod->getMethodName();
        }

        foreach ($paymentMethodsTransfer->getMethods() as $paymentMethod) {
            if (
                $this->isPaymentMethodNovalnet($paymentMethod)
                && !$this->isAvailable($paymentMethod, $quoteTransfer, $enabledPayments)
            ) {
                continue;
            }
            $result->append($paymentMethod);
        }

        $paymentMethodsTransfer->setMethods($result);

        return $paymentMethodsTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer $paymentMethodTransfer
     *
     * @return bool
     */
    protected function isPaymentMethodNovalnet(PaymentMethodTransfer $paymentMethodTransfer): bool
    {
        return strpos($paymentMethodTransfer->getMethodName(), static::NOVALNET_PAYMENT_METHOD) !== false;
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer $paymentMethodTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param array $enabledPayments
     *
     * @return bool
     */
    protected function isAvailable(PaymentMethodTransfer $paymentMethodTransfer, QuoteTransfer $quoteTransfer, $enabledPayments): bool
    {
        $paymentMethod = $paymentMethodTransfer->getMethodName();
        $standardParameter = $this->config->getRequestStandardParameter();
        $orderTotal = $quoteTransfer->getTotals()->getGrandTotal();
        $flag = true;

        if (in_array($paymentMethod, [ 'novalnetSepaGuarantee', 'novalnetInvoiceGuarantee', 'novalnetSepa', 'novalnetInvoice' ], true)) {
            if (in_array($paymentMethod, [ 'novalnetInvoiceGuarantee', 'novalnetInvoice' ])) {
                $guaranteeMinimumAmount = $standardParameter->getInvoiceGuaranteeMinAmtLimit();
            } elseif (in_array($paymentMethod, [ 'novalnetSepaGuarantee', 'novalnetSepa' ])) {
                $guaranteeMinimumAmount = $standardParameter->getSepaGuaranteeMinAmtLimit();
            }

            $guaranteeMinimumAmount = (empty($guaranteeMinimumAmount) || $guaranteeMinimumAmount < 999) ? 999 : $guaranteeMinimumAmount;

            if (
                $orderTotal >= $guaranteeMinimumAmount
                && $quoteTransfer->getBillingAddress()->getFirstName() == $quoteTransfer->getShippingAddress()->getFirstName()
                && $quoteTransfer->getBillingAddress()->getLastName() == $quoteTransfer->getShippingAddress()->getLastName()
                && $quoteTransfer->getBillingAddress()->getAddress1() == $quoteTransfer->getShippingAddress()->getAddress1()
                && $quoteTransfer->getBillingAddress()->getAddress2() == $quoteTransfer->getShippingAddress()->getAddress2()
                && $quoteTransfer->getBillingAddress()->getCity() == $quoteTransfer->getShippingAddress()->getCity()
                && $quoteTransfer->getBillingAddress()->getZipCode() == $quoteTransfer->getShippingAddress()->getZipCode()
                && $quoteTransfer->getBillingAddress()->getIso2Code() == $quoteTransfer->getShippingAddress()->getIso2Code()
                && $quoteTransfer->getBillingAddress()->getCompany() == $quoteTransfer->getShippingAddress()->getCompany()
                && $quoteTransfer->getBillingAddress()->getPhone() == $quoteTransfer->getShippingAddress()->getPhone()
                && in_array($quoteTransfer->getBillingAddress()->getIso2Code(), ['DE', 'AT', 'CH'], true)
                && $quoteTransfer->getCurrency()->getCode() === 'EUR'
            ) {
                $flag = true;
                if ($paymentMethod === 'novalnetSepa' && in_array('novalnetSepaGuarantee', $enabledPayments, 1)) {
                    $flag = false;
                } elseif ($paymentMethod === 'novalnetInvoice' && in_array('novalnetInvoiceGuarantee', $enabledPayments, 1)) {
                    $flag = false;
                }
            } elseif (in_array($paymentMethod, [ 'novalnetSepaGuarantee', 'novalnetInvoiceGuarantee' ], true)) {
                $flag = false;
            }
        }

        $merchantDetails = [];
        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            if ($itemTransfer->getMerchantReference()) {
                $marketplaceQuery = $this->queryContainer->queryMarketplace()->filterBySpyMerchantRef($itemTransfer->getMerchantReference());
                $marketplaceVendorData = $marketplaceQuery->findOne();

                if (!empty($marketplaceVendorData) && $marketplaceVendorData->getNnMerchantActiveStatus() == 'ACTIVATED') {
                    $merchantDetails[] = $itemTransfer->getMerchantReference();
                }
            }
        }

        if (
            !empty($merchantDetails)
            && !in_array($paymentMethod, ['novalnetCreditCard', 'novalnetSepa', 'novalnetSepaGuarantee', 'novalnetInvoice', 'novalnetInvoiceGuarantee', 'novalnetPrepayment', 'novalnetIdeal', 'novalnetSofort', 'novalnetGiropay', 'novalnetPrzelewy', 'novalnetEps', 'novalnetPostfinanceCard', 'novalnetPostfinance', 'novalnetBancontact', 'novalnetOnlineBanktransfer', 'novalnetTrustly'])
        ) {
            $flag = false;
        }

        return ( !empty($standardParameter->getSignature()) && $flag ) ? true : false;
    }
}
