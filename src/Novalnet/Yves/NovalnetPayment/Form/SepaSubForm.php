<?php

namespace Novalnet\Yves\NovalnetPayment\Form;

use Generated\Shared\Transfer\NovalnetTransfer;
use Novalnet\Shared\NovalnetPayment\NovalnetConfig;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SepaSubForm extends AbstractSubForm
{
    protected const PAYMENT_METHOD = 'sepa';

    protected const NOVALNET_PAYMENT = 'NovalnetPayment';

    protected const FIELD_IBAN = 'iban';

    protected const IBAN_LABEL = 'IBAN';

    protected const FIELD_BIC = 'bic';

    protected const BIC_LABEL = 'BIC';

    /**
     * @return string
     */
    public function getName()
    {
        return NovalnetConfig::NOVALNET_PAYMENT_METHOD_SEPA;
    }

    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return NovalnetConfig::NOVALNET_PAYMENT_METHOD_SEPA;
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
        $this->addIBAN($builder);
        $this->addBIC($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIBAN(FormBuilderInterface $builder)
    {
        $builder->add(
            self::FIELD_IBAN,
            TextType::class,
            [
                'label' => static::IBAN_LABEL,
                'required' => true,
                'attr' => [
                    'onchange' => 'return NovalnetUtility.formatIban(event);',
                    'onkeypress' => 'return NovalnetUtility.formatIban(event);',
                ],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addBIC(FormBuilderInterface $builder)
    {
        $builder->add(
            self::FIELD_BIC,
            TextType::class,
            [
                'label' => static::BIC_LABEL,
                'required' => true,
            ]
        );

        return $this;
    }
}
