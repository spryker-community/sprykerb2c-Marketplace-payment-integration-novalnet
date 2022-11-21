<?php

namespace Novalnet\Zed\NovalnetPayment\Communication\Plugin\MerchantGui;

use Novalnet\Zed\NovalnetPayment\Communication\Form\NovalnetMarkeplaceFormType;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MerchantGuiExtension\Dependency\Plugin\MerchantFormExpanderPluginInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig getConfig()
 * @method \Novalnet\Zed\NovalnetPayment\Communication\NovalnetPaymentCommunicationFactory getFactory()
 * @method \Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface getQueryContainer()
 * @method \Novalnet\Zed\NovalnetPayment\Business\NovalnetPaymentFacadeInterface getFacade()
 */
class NovalnetFormExpanderPlugin extends AbstractPlugin implements MerchantFormExpanderPluginInterface
{
    public const NOVALNET_MARKETPLACE = 'novalnetMarketplace';

    /**
     * @api
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public function expand(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $this->addNovalnetMarketplaceFieldSubform($builder);

        return $builder;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNovalnetMarketplaceFieldSubform(FormBuilderInterface $builder)
    {
        $options = $this->getMarketplaceFormOptions($builder);

        $builder->add(
            static::NOVALNET_MARKETPLACE,
            NovalnetMarkeplaceFormType::class,
            $options
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return array
     */
    protected function getMarketplaceFormOptions(FormBuilderInterface $builder): array
    {
        $merchantProfileDataProvider = $this->getFactory()
            ->createNovalnetFormDataProvider();

        $merchantTransfer = $builder->getForm()->getData();
        $transactionLogsQuery = $this->getQueryContainer()->createLastDetailBySpyMerchantId($merchantTransfer->getIdMerchant());
        $transactionLog = $transactionLogsQuery->findOne();

        $options = $merchantProfileDataProvider->getOptions();
        $options['data'] = $merchantProfileDataProvider->getData($merchantTransfer->getNovalnetMarketplace(), $transactionLog);

        return $options;
    }
}
