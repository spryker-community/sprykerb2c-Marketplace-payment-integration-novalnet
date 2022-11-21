<?php

namespace Novalnet\Zed\NovalnetPayment\Dependency\Facade;

class PaymentToNovalnetPaymentFacadeBridge implements PaymentToNovalnetPaymentFacadeInterface
{
    /**
     * @var \Spryker\Zed\Payment\Business\PaymentFacadeInterface
     */
    protected $paymentFacade;

    /**
     * @param \Spryker\Zed\Payment\Business\PaymentFacadeInterface $paymentFacade
     */
    public function __construct($paymentFacade)
    {
        $this->paymentFacade = $paymentFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getTransactionDetails($orderTransfer)
    {
        return $this->paymentFacade->getTransactionDetails($orderTransfer);
    }
}
