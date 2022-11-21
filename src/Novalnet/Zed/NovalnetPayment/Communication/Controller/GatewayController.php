<?php

namespace Novalnet\Zed\NovalnetPayment\Communication\Controller;

use Generated\Shared\Transfer\NovalnetCallbackResponseTransfer;
use Generated\Shared\Transfer\NovalnetRedirectResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItemQuery;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Novalnet\Zed\NovalnetPayment\Business\NovalnetPaymentFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer
     */
    public function processRedirectPaymentResponseAction(NovalnetRedirectResponseTransfer $redirectResponseTransfer): NovalnetRedirectResponseTransfer
    {
        $response = $this->getFacade()->processRedirectPaymentResponse($redirectResponseTransfer);

        $orderItems = SpySalesOrderItemQuery::create()
                ->useOrderQuery()
                ->filterByOrderReference($redirectResponseTransfer->getOrderNo())
                ->endUse()
                ->find();

        $this->getFactory()->getOmsFacade()->triggerEvent('redirect response', $orderItems, []);

        return $response;
    }

    /**
     * @param \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer $callbackResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer
     */
    public function processCallbackResponseAction(NovalnetCallbackResponseTransfer $callbackResponseTransfer): NovalnetCallbackResponseTransfer
    {
        $response = $this->getFacade()->processCallbackResponse($callbackResponseTransfer);

        if ($callbackResponseTransfer->getOrderStatus()) {
            $orderItems = SpySalesOrderItemQuery::create()
                    ->useOrderQuery()
                    ->filterByOrderReference($callbackResponseTransfer->getOrderNo())
                    ->endUse()
                    ->find();

            if ($callbackResponseTransfer->getOrderStatus() == 'communication_failure') {
                $this->getFactory()->getOmsFacade()->triggerEvent('redirect response', $orderItems, []);
            } elseif ($callbackResponseTransfer->getOrderStatus() == 'waiting_for_payment') {
                $this->getFactory()->getOmsFacade()->triggerEvent('waiting for payment', $orderItems, []);
            } elseif ($callbackResponseTransfer->getOrderStatus() == 'paid') {
                $this->getFactory()->getOmsFacade()->triggerEvent('callback paid', $orderItems, []);
            } elseif ($callbackResponseTransfer->getOrderStatus() == 'canceled') {
                $this->getFactory()->getOmsFacade()->triggerEvent('callback canceled', $orderItems, []);
            }
        }

        return $response;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function transactionDetailsAction(OrderTransfer $orderTransfer): OrderTransfer
    {
        $response = $this->getFacade()->getTransactionDetails($orderTransfer);

        return $response;
    }
}
