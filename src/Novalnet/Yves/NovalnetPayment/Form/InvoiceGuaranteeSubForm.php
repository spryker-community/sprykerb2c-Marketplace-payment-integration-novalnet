<?php

namespace Novalnet\Yves\NovalnetPayment\Form;

use Generated\Shared\Transfer\NovalnetTransfer;
use Novalnet\Shared\NovalnetPayment\NovalnetConfig;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvoiceGuaranteeSubForm extends AbstractSubForm
{
    protected const PAYMENT_METHOD = 'invoice-guarantee';

    protected const NOVALNET_PAYMENT = 'NovalnetPayment';

    protected const FIELD_DOB = 'dob';

    protected const DOB_LABEL = 'Date of birth';

    /**
     * @return string
     */
    public function getName()
    {
        return NovalnetConfig::NOVALNET_PAYMENT_METHOD_INVOICE_GUARANTEE;
    }

    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return NovalnetConfig::NOVALNET_PAYMENT_METHOD_INVOICE_GUARANTEE;
    }

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return static::NOVALNET_PAYMENT . DIRECTORY_SEPARATOR . static::PAYMENT_METHOD;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     *
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NovalnetTransfer::class,
        ])->setRequired(self::OPTIONS_FIELD_NAME);
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

        $builder->add(
            self::FIELD_DOB,
            TextType::class,
            [
                'label' => static::DOB_LABEL,
                'required' => true,
            ]
        );
    }
}
