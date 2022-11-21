<?php

namespace Novalnet\Yves\NovalnetPayment\Handler;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Novalnet\Shared\NovalnetPayment\NovalnetConfig;
use Novalnet\Yves\NovalnetPayment\Exception\PaymentMethodNotFoundException;

class NovalnetHandler
{
    public const PAYMENT_PROVIDER = 'Novalnet';

    /**
     * @var array
     */
    protected static $paymentMethods = [
        PaymentTransfer::NOVALNET_CREDIT_CARD => NovalnetConfig::NOVALNET_PAYMENT_METHOD_CC,
        PaymentTransfer::NOVALNET_SEPA => NovalnetConfig::NOVALNET_PAYMENT_METHOD_SEPA,
        PaymentTransfer::NOVALNET_SEPA_GUARANTEE => NovalnetConfig::NOVALNET_PAYMENT_METHOD_SEPA_GUARANTEE,
        PaymentTransfer::NOVALNET_INVOICE => NovalnetConfig::NOVALNET_PAYMENT_METHOD_INVOICE,
        PaymentTransfer::NOVALNET_INVOICE_GUARANTEE => NovalnetConfig::NOVALNET_PAYMENT_METHOD_INVOICE_GUARANTEE,
        PaymentTransfer::NOVALNET_PREPAYMENT => NovalnetConfig::NOVALNET_PAYMENT_METHOD_PREPAYMENT,
        PaymentTransfer::NOVALNET_IDEAL => NovalnetConfig::NOVALNET_PAYMENT_METHOD_IDEAL,
        PaymentTransfer::NOVALNET_SOFORT => NovalnetConfig::NOVALNET_PAYMENT_METHOD_SOFORT,
        PaymentTransfer::NOVALNET_GIROPAY => NovalnetConfig::NOVALNET_PAYMENT_METHOD_GIROPAY,
        PaymentTransfer::NOVALNET_BARZAHLEN => NovalnetConfig::NOVALNET_PAYMENT_METHOD_BARZAHLEN,
        PaymentTransfer::NOVALNET_PRZELEWY => NovalnetConfig::NOVALNET_PAYMENT_METHOD_PRZELEWY,
        PaymentTransfer::NOVALNET_EPS => NovalnetConfig::NOVALNET_PAYMENT_METHOD_EPS,
        PaymentTransfer::NOVALNET_PAYPAL => NovalnetConfig::NOVALNET_PAYMENT_METHOD_PAYPAL,
        PaymentTransfer::NOVALNET_POSTFINANCE_CARD => NovalnetConfig::NOVALNET_PAYMENT_METHOD_POSTFINANCE_CARD,
        PaymentTransfer::NOVALNET_POSTFINANCE => NovalnetConfig::NOVALNET_PAYMENT_METHOD_POSTFINANCE,
        PaymentTransfer::NOVALNET_BANCONTACT => NovalnetConfig::NOVALNET_PAYMENT_METHOD_BANCONTACT,
        PaymentTransfer::NOVALNET_MULTIBANCO => NovalnetConfig::NOVALNET_PAYMENT_METHOD_MULTIBANCO,
        PaymentTransfer::NOVALNET_ONLINE_BANKTRANSFER => NovalnetConfig::NOVALNET_PAYMENT_METHOD_ONLINEBANKTRANSFER,
        PaymentTransfer::NOVALNET_TRUSTLY => NovalnetConfig::NOVALNET_PAYMENT_METHOD_TRUSTLY,
        PaymentTransfer::NOVALNET_ALIPAY => NovalnetConfig::NOVALNET_PAYMENT_METHOD_ALIPAY,
        PaymentTransfer::NOVALNET_WECHATPAY => NovalnetConfig::NOVALNET_PAYMENT_METHOD_WECHATPAY,
    ];

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentToQuote(QuoteTransfer $quoteTransfer)
    {
        $paymentSelection = $quoteTransfer->getPayment()->getPaymentSelection();

        $this->setPaymentProviderAndMethod($quoteTransfer, $paymentSelection);
        $this->setNovalnetPayment($quoteTransfer, $paymentSelection);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @return void
     */
    protected function setPaymentProviderAndMethod(QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $quoteTransfer->getPayment()
            ->setPaymentSelection($paymentSelection)
            ->setPaymentProvider(self::PAYMENT_PROVIDER)
            ->setPaymentMethod(self::$paymentMethods[$paymentSelection]);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @return void
     */
    protected function setNovalnetPayment(QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $novalnetPaymentTransfer = $this->getNovalnetPaymentTransfer($quoteTransfer, $paymentSelection);
        $method = 'set' . ucfirst($paymentSelection);
        $quoteTransfer->getPayment()->$method(clone $novalnetPaymentTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @throws \Novalnet\Yves\NovalnetPayment\Exception\PaymentMethodNotFoundException
     *
     * @return \Generated\Shared\Transfer\NovalnetTransfer
     */
    protected function getNovalnetPaymentTransfer(QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $paymentMethod = ucfirst($paymentSelection);
        $method = 'get' . $paymentMethod;
        $paymentTransfer = $quoteTransfer->getPayment();

        if (!method_exists($paymentTransfer, $method) || ($quoteTransfer->getPayment()->$method() === null)) {
            throw new PaymentMethodNotFoundException(sprintf('Selected payment method "%s" not found in PaymentTransfer', $paymentMethod));
        }
        $novalnetPaymentTransfer = $quoteTransfer->getPayment()->$method();

        return $novalnetPaymentTransfer;
    }
}
