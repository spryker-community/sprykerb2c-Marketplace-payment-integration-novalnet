<?php

namespace Novalnet\Zed\NovalnetPayment\Dependency\Facade;

interface NovalnetPaymentToSalesInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getOrderByIdSalesOrder($idSalesOrder);
}
