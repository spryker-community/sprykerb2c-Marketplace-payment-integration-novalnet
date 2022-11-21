<?php

namespace Novalnet\Zed\NovalnetPayment;

use Generated\Shared\Transfer\NovalnetCallbackScriptParameterTransfer;
use Generated\Shared\Transfer\NovalnetStandardParameterTransfer;
use Novalnet\Shared\NovalnetPayment\NovalnetConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class NovalnetPaymentConfig extends AbstractBundleConfig
{
    /**
     * @return \Generated\Shared\Transfer\NovalnetStandardParameterTransfer
     */
    public function getRequestStandardParameter()
    {
        $settings = $this->get(NovalnetConstants::NOVALNET);
        $standardParameter = new NovalnetStandardParameterTransfer();
        // ------------------ Vendor information ----------------------
        $standardParameter->setSignature($settings[NovalnetConstants::NOVALNET_CREDENTIALS_SIGNATURE]);
        $standardParameter->setTariffId($settings[NovalnetConstants::NOVALNET_CREDENTIALS_TARIFF]);
        $standardParameter->setAccessKey($settings[NovalnetConstants::NOVALNET_CREDENTIALS_ACCESS_KEY]);
        $standardParameter->setTestMode($settings[NovalnetConstants::NOVALNET_SANDBOX_MODE]);
        // ------------------ Shop information ----------------------
        $standardParameter->setCurrency(Store::getInstance()->getCurrencyIsoCode());
        $standardParameter->setLanguage(Store::getInstance()->getCurrentLanguage());
        $standardParameter->setReturnUrl($settings[NovalnetConstants::NOVALNET_REDIRECT_SUCCESS_URL]);
        $standardParameter->setErrorReturnUrl($settings[NovalnetConstants::NOVALNET_REDIRECT_ERROR_URL]);
        // ------------------ Payment information ----------------------
        $standardParameter->setPrepaymentDueDate($settings[NovalnetConstants::NOVALNET_PREPAYMENT_DUE_DATE]);
        $standardParameter->setInvoiceDueDate($settings[NovalnetConstants::NOVALNET_INVOICE_DUE_DATE]);
        $standardParameter->setSepaDueDate($settings[NovalnetConstants::NOVALNET_SEPA_DUE_DATE]);
        $standardParameter->setSepaGuaranteeDueDate($settings[NovalnetConstants::NOVALNET_SEPA_GUARANTEE_DUE_DATE]);
        $standardParameter->setCpDueDate($settings[NovalnetConstants::NOVALNET_BARZAHLEN_SLIP_EXPIRY_DATE]);
        // ------------------ Payment on-hold amount limit ----------------------
        $standardParameter->setCreditCardOnHoldLimit($settings[NovalnetConstants::NOVALNET_CREDIT_CARD_ONHOLD_AMOUNT_LIMIT]);
        $standardParameter->setSepaOnHoldLimit($settings[NovalnetConstants::NOVALNET_SEPA_ONHOLD_AMOUNT_LIMIT]);
        $standardParameter->setSepaGuaranteeMinAmtLimit($settings[NovalnetConstants::NOVALNET_SEPA_GUARANTEE_MINIMUM_AMOUNT_LIMIT]);
        $standardParameter->setSepaGuaranteeOnHoldLimit($settings[NovalnetConstants::NOVALNET_SEPA_GUARANTEE_ONHOLD_AMOUNT_LIMIT]);
        $standardParameter->setInvoiceOnHoldLimit($settings[NovalnetConstants::NOVALNET_INVOICE_ONHOLD_AMOUNT_LIMIT]);
        $standardParameter->setInvoiceGuaranteeMinAmtLimit($settings[NovalnetConstants::NOVALNET_INVOICE_GUARANTEE_MINIMUM_AMOUNT_LIMIT]);
        $standardParameter->setInvoiceGuaranteeOnHoldLimit($settings[NovalnetConstants::NOVALNET_INVOICE_GUARANTEE_ONHOLD_AMOUNT_LIMIT]);
        $standardParameter->setPaypalOnHoldLimit($settings[NovalnetConstants::NOVALNET_PAYPAL_ONHOLD_AMOUNT_LIMIT]);

        return $standardParameter;
    }

    /**
     * @return \Generated\Shared\Transfer\NovalnetCallbackScriptParameterTransfer
     */
    public function getCallbackScriptParameter()
    {
        $settings = $this->get(NovalnetConstants::NOVALNET_CALLBACK);
        $standardParameter = new NovalnetCallbackScriptParameterTransfer();
        $standardParameter->setDebugMode($settings[NovalnetConstants::NOVALNET_CALLBACK_DEBUG_MODE]);
        $standardParameter->setCallbackMailToAddress($settings[NovalnetConstants::NOVALNET_CALLBACK_EMAIL_TO_ADDRESS]);

        return $standardParameter;
    }
}
