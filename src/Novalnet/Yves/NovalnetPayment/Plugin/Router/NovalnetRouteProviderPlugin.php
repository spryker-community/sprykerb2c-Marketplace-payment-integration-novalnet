<?php

namespace Novalnet\Yves\NovalnetPayment\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class NovalnetRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    public const NOVALNET_PAYMENT = 'novalnet-payment';

    public const NOVALNET_CALLBACK = 'novalnet-callback';

    /**
     * Specification:
     * - Adds Routes to the RouteCollection.
     *
     * @api
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addNovalnetIndexRoute($routeCollection);
        $routeCollection = $this->addNovalnetCallbackRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addNovalnetIndexRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/novalnet/payment', 'NovalnetPayment', 'Novalnet', 'paymentAction');
        $route = $route->setMethods(['GET', 'POST']);
        $routeCollection->add(static::NOVALNET_PAYMENT, $route);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addNovalnetCallbackRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/novalnet/callback', 'NovalnetPayment', 'Novalnet', 'callbackAction');
        $route = $route->setMethods(['GET', 'POST']);
        $routeCollection->add(static::NOVALNET_CALLBACK, $route);

        return $routeCollection;
    }
}
