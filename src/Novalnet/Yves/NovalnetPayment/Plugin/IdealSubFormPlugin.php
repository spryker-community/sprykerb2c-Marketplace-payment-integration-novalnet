<?php

namespace Novalnet\Yves\NovalnetPayment\Plugin;

use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface;

/**
 * @method \Novalnet\Yves\NovalnetPayment\NovalnetPaymentFactory getFactory()
 */
class IdealSubFormPlugin extends AbstractPlugin implements SubFormPluginInterface
{
    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\IdealSubForm
     */
    public function createSubForm()
    {
        return $this->getFactory()->createIdealForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createSubFormDataProvider()
    {
        return $this->getFactory()->createIdealFormDataProvider();
    }
}
