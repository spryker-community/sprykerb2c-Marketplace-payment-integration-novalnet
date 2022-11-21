<?php

namespace Novalnet\Zed\NovalnetPayment\Persistence;

use Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetCallbackQuery;
use Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetDetailQuery;
use Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetMarketplaceQuery;
use Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface getQueryContainer()
 * @method \Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig getConfig()
 */
class NovalnetPaymentPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetTransactionLogQuery
     */
    public function createPaymentNovalnetTransactionLogQuery(): SpyPaymentNovalnetTransactionLogQuery
    {
        return SpyPaymentNovalnetTransactionLogQuery::create();
    }

    /**
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetCallbackQuery
     */
    public function createPaymentNovalnetCallbackQuery(): SpyPaymentNovalnetCallbackQuery
    {
        return SpyPaymentNovalnetCallbackQuery::create();
    }

    /**
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetDetailQuery
     */
    public function createPaymentNovalnetDetailQuery(): SpyPaymentNovalnetDetailQuery
    {
        return SpyPaymentNovalnetDetailQuery::create();
    }

    /**
     * @return \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetMarketplaceQuery
     */
    public function createPaymentNovalnetMarketplaceQuery(): SpyPaymentNovalnetMarketplaceQuery
    {
        return SpyPaymentNovalnetMarketplaceQuery::create();
    }
}
