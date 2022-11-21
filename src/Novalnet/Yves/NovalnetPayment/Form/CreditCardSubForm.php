<?php

namespace Novalnet\Yves\NovalnetPayment\Form;

use Generated\Shared\Transfer\NovalnetTransfer;
use Novalnet\Shared\NovalnetPayment\NovalnetConfig;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreditCardSubForm extends AbstractSubForm
{
    protected const PAYMENT_METHOD = 'credit-card';
    protected const NOVALNET_PAYMENT = 'NovalnetPayment';

    public const OPTION_PAN_HASH = 'panHash';
    public const OPTION_UNIQUE_ID = 'uniqueId';
    public const OPTION_DO_REDIRECT = 'doRedirect';

    public const OPTION_FIRST_NAME = 'firstName';
    public const OPTION_LAST_NAME = 'lastName';
    public const OPTION_EMAIL = 'email';
    public const OPTION_STREET = 'street';
    public const OPTION_HOUSE_NO = 'houseNo';
    public const OPTION_CITY = 'city';
    public const OPTION_ZIP = 'zip';
    public const OPTION_COUNTRY_CODE = 'countryCode';
    public const OPTION_AMOUNT = 'amount';
    public const OPTION_CURRENCY = 'currency';
    public const OPTION_TEST_MODE = 'testMode';
    public const OPTION_LANG = 'lang';

    public const OPTION_FORM_CLIENT_KEY = 'formClientKey';
    public const OPTION_FORM_INLINE = 'formInline';
    public const OPTION_FORM_STYLE_CONTAINER = 'formStyleContainer';
    public const OPTION_FORM_STYLE_INPUT = 'formStyleInput';
    public const OPTION_FORM_STYLE_LABEL = 'formStyleLabel';

    /**
     * @return string
     */
    public function getName()
    {
        return NovalnetConfig::NOVALNET_PAYMENT_METHOD_CC;
    }

    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return NovalnetConfig::NOVALNET_PAYMENT_METHOD_CC;
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
        $builder->add(
            self::OPTION_PAN_HASH,
            HiddenType::class,
            ['label' => false]
        );

        $builder->add(
            self::OPTION_UNIQUE_ID,
            HiddenType::class,
            ['label' => false]
        );

        $builder->add(
            self::OPTION_DO_REDIRECT,
            HiddenType::class,
            ['label' => false]
        );
        // Add iFrame data (clientKey, iFrame form customization inputs)
        $this->addFrameData($builder, $options);
        // Add transaction data (amount, currency, etc.,)
        $this->addTransactionData($builder, $options);
        // Add customer data (firstname, lastname, etc.,)
        $this->addCustomerData($builder, $options);
        // Add custom data (language)
        $this->addCustomData($builder, $options);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addFrameData(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            self::OPTION_FORM_CLIENT_KEY,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_FORM_CLIENT_KEY],
            ]
        );

        $builder->add(
            self::OPTION_FORM_INLINE,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_FORM_INLINE],
            ]
        );

        $builder->add(
            self::OPTION_FORM_STYLE_CONTAINER,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_FORM_STYLE_CONTAINER],
            ]
        );

        $builder->add(
            self::OPTION_FORM_STYLE_INPUT,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_FORM_STYLE_INPUT],
            ]
        );

        $builder->add(
            self::OPTION_FORM_STYLE_LABEL,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_FORM_STYLE_LABEL],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addTransactionData(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            self::OPTION_AMOUNT,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_AMOUNT],
            ]
        );

        $builder->add(
            self::OPTION_CURRENCY,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_CURRENCY],
            ]
        );

        $builder->add(
            self::OPTION_TEST_MODE,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_TEST_MODE],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addCustomerData(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            self::OPTION_FIRST_NAME,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_FIRST_NAME],
            ]
        );

        $builder->add(
            self::OPTION_LAST_NAME,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_LAST_NAME],
            ]
        );

        $builder->add(
            self::OPTION_EMAIL,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_EMAIL],
            ]
        );

        $builder->add(
            self::OPTION_STREET,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_STREET],
            ]
        );

        $builder->add(
            self::OPTION_HOUSE_NO,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_HOUSE_NO],
            ]
        );

        $builder->add(
            self::OPTION_CITY,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_CITY],
            ]
        );

        $builder->add(
            self::OPTION_ZIP,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_ZIP],
            ]
        );

        $builder->add(
            self::OPTION_COUNTRY_CODE,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_COUNTRY_CODE],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addCustomData(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            self::OPTION_LANG,
            HiddenType::class,
            [
                'label' => false,
                'data' => $options[self::OPTIONS_FIELD_NAME][self::OPTION_LANG],
            ]
        );

        return $this;
    }
}
