<?php

namespace Novalnet\Yves\NovalnetPayment;

use Novalnet\Yves\NovalnetPayment\Form\AlipaySubForm;
use Novalnet\Yves\NovalnetPayment\Form\BancontactSubForm;
use Novalnet\Yves\NovalnetPayment\Form\BarzahlenSubForm;
use Novalnet\Yves\NovalnetPayment\Form\CreditCardSubForm;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\AlipayFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\BancontactFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\BarzahlenFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\CreditCardFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\EpsFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\GiropayFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\IdealFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\InvoiceFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\InvoiceGuaranteeFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\MultibancoFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\OnlineBanktransferFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\PaypalFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\PostfinanceCardFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\PostfinanceFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\PrepaymentFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\PrzelewyFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\SepaFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\SepaGuaranteeFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\SofortFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\TrustlyFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\DataProvider\WechatpayFormDataProvider;
use Novalnet\Yves\NovalnetPayment\Form\EpsSubForm;
use Novalnet\Yves\NovalnetPayment\Form\GriopaySubForm;
use Novalnet\Yves\NovalnetPayment\Form\IdealSubForm;
use Novalnet\Yves\NovalnetPayment\Form\InvoiceGuaranteeSubForm;
use Novalnet\Yves\NovalnetPayment\Form\InvoiceSubForm;
use Novalnet\Yves\NovalnetPayment\Form\MultibancoSubForm;
use Novalnet\Yves\NovalnetPayment\Form\OnlineBanktransferSubForm;
use Novalnet\Yves\NovalnetPayment\Form\PaypalSubForm;
use Novalnet\Yves\NovalnetPayment\Form\PostfinanceCardSubForm;
use Novalnet\Yves\NovalnetPayment\Form\PostfinanceSubForm;
use Novalnet\Yves\NovalnetPayment\Form\PrepaymentSubForm;
use Novalnet\Yves\NovalnetPayment\Form\PrzelewySubForm;
use Novalnet\Yves\NovalnetPayment\Form\SepaGuaranteeSubForm;
use Novalnet\Yves\NovalnetPayment\Form\SepaSubForm;
use Novalnet\Yves\NovalnetPayment\Form\SofortSubForm;
use Novalnet\Yves\NovalnetPayment\Form\TrustlySubForm;
use Novalnet\Yves\NovalnetPayment\Form\WechatpaySubForm;
use Novalnet\Yves\NovalnetPayment\Handler\NovalnetHandler;
use Spryker\Yves\Kernel\AbstractFactory;

/**
 * @method \Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig getConfig()
 */
class NovalnetPaymentFactory extends AbstractFactory
{
    /**
     * @return \Novalnet\Yves\NovalnetPayment\Handler\NovalnetHandler
     */
    public function createNovalnetHandler()
    {
        return new NovalnetHandler();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\CreditCardSubForm
     */
    public function createCreditCardForm()
    {
        return new CreditCardSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\CreditCardFormDataProvider
     */
    public function createCreditCardFormDataProvider()
    {
        return new CreditCardFormDataProvider($this->getConfig());
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\SepaSubForm
     */
    public function createSepaForm()
    {
        return new SepaSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\SepaFormDataProvider
     */
    public function createSepaFormDataProvider()
    {
        return new SepaFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\SepaGuaranteeSubForm
     */
    public function createSepaGuaranteeForm()
    {
        return new SepaGuaranteeSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\SepaGuaranteeFormDataProvider
     */
    public function createSepaGuaranteeFormDataProvider()
    {
        return new SepaGuaranteeFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\InvoiceSubForm
     */
    public function createInvoiceForm()
    {
        return new InvoiceSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\InvoiceFormDataProvider
     */
    public function createInvoiceFormDataProvider()
    {
        return new InvoiceFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\InvoiceGuaranteeSubForm
     */
    public function createInvoiceGuaranteeForm()
    {
        return new InvoiceGuaranteeSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\InvoiceGuaranteeFormDataProvider
     */
    public function createInvoiceGuaranteeFormDataProvider()
    {
        return new InvoiceGuaranteeFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\PrepaymentSubForm
     */
    public function createPrepaymentForm()
    {
        return new PrepaymentSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\PrepaymentFormDataProvider
     */
    public function createPrepaymentFormDataProvider()
    {
        return new PrepaymentFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\IdealSubForm
     */
    public function createIdealForm()
    {
        return new IdealSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\IdealFormDataProvider
     */
    public function createIdealFormDataProvider()
    {
        return new IdealFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\SofortSubForm
     */
    public function createSofortForm()
    {
        return new SofortSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\SofortFormDataProvider
     */
    public function createSofortFormDataProvider()
    {
        return new SofortFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\GriopaySubForm
     */
    public function createGiropayForm()
    {
        return new GriopaySubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\GiropayFormDataProvider
     */
    public function createGiropayFormDataProvider()
    {
        return new GiropayFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\BarzahlenSubForm
     */
    public function createBarzahlenForm()
    {
        return new BarzahlenSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\BarzahlenFormDataProvider
     */
    public function createBarzahlenFormDataProvider()
    {
        return new BarzahlenFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\PrzelewySubForm
     */
    public function createPrzelewyForm()
    {
        return new PrzelewySubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\PrzelewyFormDataProvider
     */
    public function createPrzelewyFormDataProvider()
    {
        return new PrzelewyFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\EpsSubForm
     */
    public function createEpsForm()
    {
        return new EpsSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\EpsFormDataProvider
     */
    public function createEpsFormDataProvider()
    {
        return new EpsFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\PaypalSubForm
     */
    public function createPaypalForm()
    {
        return new PaypalSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\PaypalFormDataProvider
     */
    public function createPaypalFormDataProvider()
    {
        return new PaypalFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\PostfinanceCardSubForm
     */
    public function createPostfinanceCardForm()
    {
        return new PostfinanceCardSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\PostfinanceCardFormDataProvider
     */
    public function createPostfinanceCardFormDataProvider()
    {
        return new PostfinanceCardFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\PostfinanceSubForm
     */
    public function createPostfinanceForm()
    {
        return new PostfinanceSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\PostfinanceFormDataProvider
     */
    public function createPostfinanceFormDataProvider()
    {
        return new PostfinanceFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\BancontactSubForm
     */
    public function createBancontactForm()
    {
        return new BancontactSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\BancontactFormDataProvider
     */
    public function createBancontactFormDataProvider()
    {
        return new BancontactFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\MultibancoSubForm
     */
    public function createMultibancoForm()
    {
        return new MultibancoSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\MultibancoFormDataProvider
     */
    public function createMultibancoFormDataProvider()
    {
        return new MultibancoFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\OnlineBanktransferSubForm
     */
    public function createOnlineBanktransferForm()
    {
        return new OnlineBanktransferSubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\OnlineBanktransferFormDataProvider
     */
    public function createOnlineBanktransferFormDataProvider()
    {
        return new OnlineBanktransferFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\TrustlySubForm
     */
    public function createTrustlyForm()
    {
        return new TrustlySubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\TrustlyFormDataProvider
     */
    public function createTrustlyFormDataProvider()
    {
        return new TrustlyFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\AlipaySubForm
     */
    public function createAlipayForm()
    {
        return new AlipaySubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\AlipayFormDataProvider
     */
    public function createAlipayFormDataProvider()
    {
        return new AlipayFormDataProvider();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\WechatpaySubForm
     */
    public function createWechatpayForm()
    {
        return new WechatpaySubForm();
    }

    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\DataProvider\WechatpayFormDataProvider
     */
    public function createWechatpayFormDataProvider()
    {
        return new WechatpayFormDataProvider();
    }
}
