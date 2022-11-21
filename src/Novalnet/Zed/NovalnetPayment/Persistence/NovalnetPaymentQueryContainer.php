<?php

namespace Novalnet\Zed\NovalnetPayment\Persistence;

use Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

/**
 * @method \Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentPersistenceFactory getFactory()
 */
class NovalnetPaymentQueryContainer extends AbstractQueryContainer implements NovalnetPaymentQueryContainerInterface
{
    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery
     */
    public function queryExternalResponseTransactionLog(int $idSalesOrder): SpyPaymentNovalnetTransactionLogQuery
    {
        return $this->getFactory()
            ->createPaymentNovalnetTransactionLogQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->filterByTransactionType('redirect');
    }

    /**
     * @api
     *
     * @param int $idSalesOrder
     * @param string $transactionType
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery
     */
    public function queryTransactionByIdSalesOrderAndType(int $idSalesOrder, string $transactionType): SpyPaymentNovalnetTransactionLogQuery
    {
        return $this->getFactory()
            ->createPaymentNovalnetTransactionLogQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->filterByTransactionType($transactionType);
    }

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery
     */
    public function createLastApiLogsByOrderId($idSalesOrder)
    {
        $query = $this->getFactory()->createPaymentNovalnetTransactionLogQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->orderByCreatedAt(Criteria::DESC);

        return $query;
    }

    /**
     * @api
     *
     * @param int $orderReference
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery
     */
    public function createLastApiLogsByOrderReference($orderReference)
    {
        $query = $this->getFactory()->createPaymentNovalnetTransactionLogQuery()
            ->filterByOrderReference($orderReference)
            ->orderByCreatedAt(Criteria::DESC);

        return $query;
    }

    /**
     * @api
     *
     * @param int $transactionId
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery
     */
    public function createLastApiLogsByTransactionId($transactionId)
    {
        $query = $this->getFactory()->createPaymentNovalnetTransactionLogQuery()
            ->filterByTransactionId($transactionId)
            ->orderByCreatedAt(Criteria::DESC);

        return $query;
    }

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetCallbackQuery
     */
    public function createLastCallbackByOrderId($idSalesOrder)
    {
        $query = $this->getFactory()->createPaymentNovalnetCallbackQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->orderByCreatedAt(Criteria::DESC);

        return $query;
    }

    /**
     * @api
     *
     * @param int $orderReference
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetCallbackQuery
     */
    public function createLastCallbackByOrderReference($orderReference)
    {
        $query = $this->getFactory()->createPaymentNovalnetCallbackQuery()
            ->filterByOrderReference($orderReference)
            ->orderByCreatedAt(Criteria::DESC);

        return $query;
    }

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetDetailQuery
     */
    public function createLastDetailByOrderId($idSalesOrder)
    {
        $query = $this->getFactory()->createPaymentNovalnetDetailQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->orderByCreatedAt(Criteria::DESC);

        return $query;
    }

    /**
     * @api
     *
     * @param int $orderReference
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetDetailQuery
     */
    public function createLastDetailByOrderReference($orderReference)
    {
        $query = $this->getFactory()->createPaymentNovalnetDetailQuery()
            ->filterByOrderReference($orderReference)
            ->orderByCreatedAt(Criteria::DESC);

        return $query;
    }

    /**
     * @api
     *
     * @param int $spyMerchantId
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetMarketplaceQuery
     */
    public function createLastDetailBySpyMerchantId($spyMerchantId)
    {
        $query = $this->getFactory()->createPaymentNovalnetMarketplaceQuery()
            ->filterBySpyMerchantId($spyMerchantId)
            ->orderByCreatedAt(Criteria::DESC);

        return $query;
    }

    /**
     * @api
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetMarketplaceQuery
     */
    public function queryMarketplace()
    {
        return $this->getFactory()->createPaymentNovalnetMarketplaceQuery();
    }
}
