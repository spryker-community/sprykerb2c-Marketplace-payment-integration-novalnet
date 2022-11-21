<?php

namespace Novalnet\Zed\NovalnetPayment\Dependency\Facade;

interface PaymentToNovalnetPaymentFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getTransactionDetails($orderTransfer);
}
