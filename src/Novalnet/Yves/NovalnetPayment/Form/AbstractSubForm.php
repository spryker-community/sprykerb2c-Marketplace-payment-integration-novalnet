<?php

namespace Novalnet\Yves\NovalnetPayment\Form;

use Novalnet\Shared\NovalnetPayment\NovalnetConstants;
use Spryker\Yves\StepEngine\Dependency\Form\AbstractSubFormType;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormProviderNameInterface;

abstract class AbstractSubForm extends AbstractSubFormType implements SubFormInterface, SubFormProviderNameInterface
{
    /**
     * @return string
     */
    public function getProviderName()
    {
        return NovalnetConstants::PROVIDER_NAME;
    }
}
