<?php

namespace Novalnet\Client\NovalnetPayment;

use Novalnet\Client\NovalnetPayment\Dependency\Client\NovalnetPaymentToZedRequestClientInterface;
use Novalnet\Client\NovalnetPayment\Zed\NovalnetPaymentStub;
use Novalnet\Client\NovalnetPayment\Zed\NovalnetPaymentStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class NovalnetPaymentFactory extends AbstractFactory
{
    /**
     * @return \Novalnet\Client\NovalnetPayment\Zed\NovalnetPaymentStubInterface
     */
    public function createZedNovalnetPaymentStub(): NovalnetPaymentStubInterface
    {
        return new NovalnetPaymentStub($this->getZedRequestClient());
    }

    /**
     * @return \Novalnet\Client\NovalnetPayment\Dependency\Client\NovalnetPaymentToZedRequestClientInterface
     */
    public function getZedRequestClient(): NovalnetPaymentToZedRequestClientInterface
    {
        return $this->getProvidedDependency(NovalnetPaymentDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
