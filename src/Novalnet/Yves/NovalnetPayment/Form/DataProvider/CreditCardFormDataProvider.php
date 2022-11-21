<?php

namespace Novalnet\Yves\NovalnetPayment\Form\DataProvider;

use Generated\Shared\Transfer\NovalnetTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Novalnet\Yves\NovalnetPayment\Form\CreditCardSubForm;
use Novalnet\Yves\NovalnetPayment\NovalnetPaymentConfig;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;

class CreditCardFormDataProvider implements StepEngineFormDataProviderInterface
{
    /**
     * @var \Novalnet\Yves\NovalnetPayment\NovalnetPaymentConfig
     */
    protected $config;

    /**
     * @param \Novalnet\Yves\NovalnetPayment\NovalnetPaymentConfig $config
     */
    public function __construct(NovalnetPaymentConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer)
    {
        if ($quoteTransfer->getPayment() === null) {
            $paymentTransfer = new PaymentTransfer();
            $paymentTransfer->setNovalnetCreditCard(new NovalnetTransfer());

            $quoteTransfer->setPayment($paymentTransfer);
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    public function getOptions(AbstractTransfer $quoteTransfer)
    {
        return [
            CreditCardSubForm::OPTION_FIRST_NAME => $quoteTransfer->getBillingAddress()->getFirstName(),
            CreditCardSubForm::OPTION_LAST_NAME => $quoteTransfer->getBillingAddress()->getLastName(),
            CreditCardSubForm::OPTION_EMAIL => $quoteTransfer->getCustomer()->getEmail(),
            CreditCardSubForm::OPTION_STREET => $quoteTransfer->getBillingAddress()->getAddress1(),
            CreditCardSubForm::OPTION_HOUSE_NO => $quoteTransfer->getBillingAddress()->getAddress2(),
            CreditCardSubForm::OPTION_CITY => $quoteTransfer->getBillingAddress()->getCity(),
            CreditCardSubForm::OPTION_ZIP => $quoteTransfer->getBillingAddress()->getZipCode(),
            CreditCardSubForm::OPTION_COUNTRY_CODE => $quoteTransfer->getBillingAddress()->getIso2Code(),
            CreditCardSubForm::OPTION_AMOUNT => $quoteTransfer->getTotals()->getGrandTotal(),
            CreditCardSubForm::OPTION_CURRENCY => $quoteTransfer->getCurrency()->getCode(),
            CreditCardSubForm::OPTION_TEST_MODE => ($this->config->getTestMode() === true ? 1 : 0),
            CreditCardSubForm::OPTION_LANG => $this->config->getLanguage(),
            CreditCardSubForm::OPTION_FORM_CLIENT_KEY => $this->config->getCreditCardClientKey(),
            CreditCardSubForm::OPTION_FORM_INLINE => ($this->config->getCreditCardInline() === true ? 1 : 0),
            CreditCardSubForm::OPTION_FORM_STYLE_CONTAINER => $this->config->getCreditCardStyleContainer(),
            CreditCardSubForm::OPTION_FORM_STYLE_INPUT => $this->config->getCreditCardStyleInput(),
            CreditCardSubForm::OPTION_FORM_STYLE_LABEL => $this->config->getCreditCardStyleLabel(),
        ];
    }
}
