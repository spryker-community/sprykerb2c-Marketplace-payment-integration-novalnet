<?php

namespace Novalnet\Zed\NovalnetPayment\Communication\Form;

use Generated\Shared\Transfer\NovalnetMarketplaceTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \Novalnet\Zed\NovalnetPayment\Business\NovalnetPaymentFacadeInterface getFacade()
 * @method \Novalnet\Zed\NovalnetPayment\Communication\NovalnetPaymentCommunicationFactory getFactory()
 * @method \Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig getConfig()
 * @method \Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface getQueryContainer()
 */
class NovalnetMarkeplaceFormType extends AbstractType
{
    public const NOVALNET_MERCHANT_ID = 'nn_merchant_id';
    public const NOVALNET_MERCHANT_ACTIVE_STATUS = 'nn_merchant_active_status';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NovalnetMarketplaceTransfer::class,
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $this->addMID($builder);
        $this->addActiveStatus($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMID(FormBuilderInterface $builder)
    {
        $builder->add(
            self::NOVALNET_MERCHANT_ID,
            TextType::class,
            [
                'label' => 'Merchant ID',
                'required' => true,
                'disabled' => true,
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addActiveStatus(FormBuilderInterface $builder)
    {
        $builder->add(
            self::NOVALNET_MERCHANT_ACTIVE_STATUS,
            TextType::class,
            [
                'label' => 'Merchant Status',
                'required' => true,
                'disabled' => true,
            ]
        );

        return $this;
    }
}
