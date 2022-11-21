<?php

namespace Novalnet\Shared\NovalnetPayment;

interface NovalnetConfig
{
    public const PROVIDER_NAME = 'Novalnet';
    public const NOVALNET_PAYMENT_METHOD_CC = 'novalnetCreditCard';
    public const NOVALNET_PAYMENT_METHOD_SEPA = 'novalnetSepa';
    public const NOVALNET_PAYMENT_METHOD_SEPA_GUARANTEE = 'novalnetSepaGuarantee';
    public const NOVALNET_PAYMENT_METHOD_INVOICE = 'novalnetInvoice';
    public const NOVALNET_PAYMENT_METHOD_INVOICE_GUARANTEE = 'novalnetInvoiceGuarantee';
    public const NOVALNET_PAYMENT_METHOD_PREPAYMENT = 'novalnetPrepayment';
    public const NOVALNET_PAYMENT_METHOD_IDEAL = 'novalnetIdeal';
    public const NOVALNET_PAYMENT_METHOD_SOFORT = 'novalnetSofort';
    public const NOVALNET_PAYMENT_METHOD_GIROPAY = 'novalnetGiropay';
    public const NOVALNET_PAYMENT_METHOD_BARZAHLEN = 'novalnetBarzahlen';
    public const NOVALNET_PAYMENT_METHOD_PRZELEWY = 'novalnetPrzelewy';
    public const NOVALNET_PAYMENT_METHOD_EPS = 'novalnetEps';
    public const NOVALNET_PAYMENT_METHOD_PAYPAL = 'novalnetPaypal';
    public const NOVALNET_PAYMENT_METHOD_POSTFINANCE_CARD = 'novalnetPostfinanceCard';
    public const NOVALNET_PAYMENT_METHOD_POSTFINANCE = 'novalnetPostfinance';
    public const NOVALNET_PAYMENT_METHOD_BANCONTACT = 'novalnetBancontact';
    public const NOVALNET_PAYMENT_METHOD_MULTIBANCO = 'novalnetMultibanco';
    public const NOVALNET_PAYMENT_METHOD_ONLINEBANKTRANSFER = 'novalnetOnlineBanktransfer';
    public const NOVALNET_PAYMENT_METHOD_TRUSTLY = 'novalnetTrustly';
    public const NOVALNET_PAYMENT_METHOD_ALIPAY = 'novalnetAlipay';
    public const NOVALNET_PAYMENT_METHOD_WECHATPAY = 'novalnetWechatpay';
}
