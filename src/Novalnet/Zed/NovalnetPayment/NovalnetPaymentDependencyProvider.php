<?php

namespace Novalnet\Zed\NovalnetPayment;

use Novalnet\Zed\NovalnetPayment\Dependency\Facade\NovalnetPaymentToGlossaryBridge;
use Novalnet\Zed\NovalnetPayment\Dependency\Facade\NovalnetPaymentToOmsBridge;
use Novalnet\Zed\NovalnetPayment\Dependency\Facade\NovalnetPaymentToRefundBridge;
use Novalnet\Zed\NovalnetPayment\Dependency\Facade\NovalnetPaymentToSalesBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class NovalnetPaymentDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_OMS = 'oms facade';

    public const FACADE_SALES = 'sales facade';

    public const FACADE_REFUND = 'refund facade';

    public const FACADE_GLOSSARY = 'glossary facade';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container[self::FACADE_OMS] = function (Container $container) {
            return new NovalnetPaymentToOmsBridge($container->getLocator()->oms()->facade());
        };

        $container[self::FACADE_SALES] = function (Container $container) {
            return new NovalnetPaymentToSalesBridge($container->getLocator()->sales()->facade());
        };

        $container[self::FACADE_REFUND] = function (Container $container) {
            return new NovalnetPaymentToRefundBridge($container->getLocator()->refund()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container[static::FACADE_GLOSSARY] = function (Container $container) {
            return new NovalnetPaymentToGlossaryBridge($container->getLocator()->glossary()->facade());
        };

        return $container;
    }
}
