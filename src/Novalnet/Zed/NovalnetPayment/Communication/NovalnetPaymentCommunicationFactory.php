<?php

namespace Novalnet\Zed\NovalnetPayment\Communication;

use Novalnet\Zed\NovalnetPayment\Communication\Form\DataProvider\NovalnetFormDataProvider;
use Novalnet\Zed\NovalnetPayment\NovalnetPaymentDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig getConfig()
 * @method \Novalnet\Zed\NovalnetPayment\Business\NovalnetPaymentFacadeInterface getFacade()
 * @method \Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface getQueryContainer()
 */
class NovalnetPaymentCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Novalnet\Zed\NovalnetPayment\Dependency\Facade\NovalnetPaymentToOmsInterface
     */
    public function getOmsFacade()
    {
        return $this->getProvidedDependency(NovalnetPaymentDependencyProvider::FACADE_OMS);
    }

    /**
     * @return \Novalnet\Zed\NovalnetPayment\Dependency\Facade\NovalnetPaymentToSalesInterface
     */
    public function getSalesFacade()
    {
        return $this->getProvidedDependency(NovalnetPaymentDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \Novalnet\Zed\NovalnetPayment\Dependency\Facade\NovalnetPaymentToRefundInterface
     */
    public function getRefundFacade()
    {
        return $this->getProvidedDependency(NovalnetPaymentDependencyProvider::FACADE_REFUND);
    }

    /**
     * @return Novalnet\Zed\NovalnetPayment\Communication\Form\DataProvider\NovalnetFormDataProvider
     */
    public function createNovalnetFormDataProvider(): NovalnetFormDataProvider
    {
        return new NovalnetFormDataProvider(
            $this->getConfig()
        );
    }
}
