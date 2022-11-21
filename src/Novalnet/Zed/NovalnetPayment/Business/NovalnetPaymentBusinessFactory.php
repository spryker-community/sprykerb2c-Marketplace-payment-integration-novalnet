<?php

namespace Novalnet\Zed\NovalnetPayment\Business;

use Novalnet\Zed\NovalnetPayment\Business\Api\Adapter\Http\Guzzle;
use Novalnet\Zed\NovalnetPayment\Business\Payment\CallbackManager;
use Novalnet\Zed\NovalnetPayment\Business\Payment\PaymentManager;
use Novalnet\Zed\NovalnetPayment\Business\Payment\PaymentMethodFilter;
use Novalnet\Zed\NovalnetPayment\Business\Payment\PaymentMethodFilterInterface;
use Novalnet\Zed\NovalnetPayment\NovalnetPaymentDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig getConfig()
 * @method \Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface getQueryContainer()
 */
class NovalnetPaymentBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @var \Generated\Shared\Transfer\NovalnetStandardParameterTransfer
     */
    private $standardParameter;

    /**
     * @var \Generated\Shared\Transfer\NovalnetCallbackScriptParameterTransfer
     */
    private $callbackParameter;

    /**
     * @return \Novalnet\Zed\NovalnetPayment\Business\Payment\PaymentManagerInterface
     */
    public function createPaymentManager()
    {
        $paymentManager = new PaymentManager(
            $this->createExecutionAdapter(),
            $this->getQueryContainer(),
            $this->getStandardParameter(),
            $this->getGlossaryFacade()
        );

        return $paymentManager;
    }

    /**
     * @return \Novalnet\Zed\NovalnetPayment\Business\Api\Adapter\AdapterInterface
     */
    protected function createExecutionAdapter()
    {
        $config = $this->getStandardParameter();

        return new Guzzle($config->getAccessKey());
    }

    /**
     * @return \Generated\Shared\Transfer\NovalnetStandardParameterTransfer
     */
    protected function getStandardParameter()
    {
        if ($this->standardParameter === null) {
            $this->standardParameter = $this->getConfig()->getRequestStandardParameter();
        }

        return $this->standardParameter;
    }

    /**
     * @return \Novalnet\Zed\NovalnetPayment\Business\Payment\CallbackManagerInterface
     */
    public function createCallbackManager()
    {
        $callbackManager = new CallbackManager(
            $this->getQueryContainer(),
            $this->getCallbackParameter(),
            $this->getStandardParameter(),
            $this->getGlossaryFacade()
        );

        return $callbackManager;
    }

    /**
     * @return \Generated\Shared\Transfer\NovalnetCallbackScriptParameterTransfer
     */
    protected function getCallbackParameter()
    {
        if ($this->callbackParameter === null) {
            $this->callbackParameter = $this->getConfig()->getCallbackScriptParameter();
        }

        return $this->callbackParameter;
    }

    /**
     * @return \Novalnet\Zed\NovalnetPayment\Dependency\Facade\NovalnetPaymentToGlossaryInterface
     */
    protected function getGlossaryFacade()
    {
        return $this->getProvidedDependency(NovalnetPaymentDependencyProvider::FACADE_GLOSSARY);
    }

    /**
     * @return \Novalnet\Zed\NovalnetPayment\Business\Payment\PaymentMethodFilterInterface
     */
    public function createPaymentMethodFilter(): PaymentMethodFilterInterface
    {
        return new PaymentMethodFilter(
            $this->getConfig(),
            $this->getQueryContainer()
        );
    }
}
