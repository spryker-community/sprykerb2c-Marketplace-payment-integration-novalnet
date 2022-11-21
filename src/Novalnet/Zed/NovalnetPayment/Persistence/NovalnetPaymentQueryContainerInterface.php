<?php

namespace Novalnet\Zed\NovalnetPayment\Persistence;

use Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface NovalnetPaymentQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @api
     *
     * @param int $idSalesOrder
     * @param string $transactionType
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery
     */
    public function queryTransactionByIdSalesOrderAndType(int $idSalesOrder, string $transactionType): SpyPaymentNovalnetTransactionLogQuery;

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery
     */
    public function queryExternalResponseTransactionLog(int $idSalesOrder): SpyPaymentNovalnetTransactionLogQuery;

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery
     */
    public function createLastApiLogsByOrderId($idSalesOrder);

    /**
     * @api
     *
     * @param int $orderReference
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery
     */
    public function createLastApiLogsByOrderReference($orderReference);

    /**
     * @api
     *
     * @param int $transactionId
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery
     */
    public function createLastApiLogsByTransactionId($transactionId);

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetCallbackQuery
     */
    public function createLastCallbackByOrderId($idSalesOrder);

    /**
     * @api
     *
     * @param int $orderReference
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetCallbackQuery
     */
    public function createLastCallbackByOrderReference($orderReference);

    /**
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetDetailQuery
     */
    public function createLastDetailByOrderId($idSalesOrder);

    /**
     * @api
     *
     * @param int $orderReference
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetDetailQuery
     */
    public function createLastDetailByOrderReference($orderReference);

    /**
     * @api
     *
     * @param int $spyMerchantId
     *
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetMarketplaceQuery
     */
    public function createLastDetailBySpyMerchantId($spyMerchantId);
}
