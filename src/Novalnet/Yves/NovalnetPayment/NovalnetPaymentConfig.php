<?php

namespace Novalnet\Yves\NovalnetPayment;

use Novalnet\Shared\NovalnetPayment\NovalnetConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Kernel\AbstractBundleConfig;

class NovalnetPaymentConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getCreditCardClientKey()
    {
        $settings = $this->get(NovalnetConstants::NOVALNET);

        return $settings[NovalnetConstants::NOVALNET_CREDIT_CARD_FORM_CLIENT_KEY];
    }

    /**
     * @return bool
     */
    public function getCreditCardInline()
    {
        $settings = $this->get(NovalnetConstants::NOVALNET);

        return $settings[NovalnetConstants::NOVALNET_CREDIT_CARD_FORM_INLINE];
    }

    /**
     * @return string
     */
    public function getCreditCardStyleContainer()
    {
        $settings = $this->get(NovalnetConstants::NOVALNET);

        return $settings[NovalnetConstants::NOVALNET_CREDIT_CARD_FORM_STYLE_CONTAINER];
    }

    /**
     * @return string
     */
    public function getCreditCardStyleInput()
    {
        $settings = $this->get(NovalnetConstants::NOVALNET);

        return $settings[NovalnetConstants::NOVALNET_CREDIT_CARD_FORM_STYLE_INPUT];
    }

    /**
     * @return string
     */
    public function getCreditCardStyleLabel()
    {
        $settings = $this->get(NovalnetConstants::NOVALNET);

        return $settings[NovalnetConstants::NOVALNET_CREDIT_CARD_FORM_STYLE_LABEL];
    }

    /**
     * @return bool
     */
    public function getTestMode()
    {
        $settings = $this->get(NovalnetConstants::NOVALNET);

        return $settings[NovalnetConstants::NOVALNET_SANDBOX_MODE];
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return Store::getInstance()->getCurrencyIsoCode();
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return Store::getInstance()->getCurrentLanguage();
    }
}
