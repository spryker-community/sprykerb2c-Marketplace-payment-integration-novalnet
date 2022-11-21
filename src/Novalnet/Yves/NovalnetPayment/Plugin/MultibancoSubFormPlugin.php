<?php

namespace Novalnet\Yves\NovalnetPayment\Plugin;

use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface;

/**
 * @method \Novalnet\Yves\NovalnetPayment\NovalnetPaymentFactory getFactory()
 */
class MultibancoSubFormPlugin extends AbstractPlugin implements SubFormPluginInterface
{
    /**
     * @return \Novalnet\Yves\NovalnetPayment\Form\MultibancoSubForm
     */
    public function createSubForm()
    {
        return $this->getFactory()->createMultibancoForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createSubFormDataProvider()
    {
        return $this->getFactory()->createMultibancoFormDataProvider();
    }
}
