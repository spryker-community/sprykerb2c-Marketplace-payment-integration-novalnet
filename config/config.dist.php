<?php
/**
 * Copy over the following configs to your config
 */

use Novalnet\Shared\NovalnetPayment\NovalnetConfig;
use Novalnet\Shared\NovalnetPayment\NovalnetConstants;

$config[KernelConstants::CORE_NAMESPACES] = array_merge($config[KernelConstants::CORE_NAMESPACES], [
    'Novalnet',
]);

// ------------------------------ SECURITY ------------------------------------
$config[KernelConstants::DOMAIN_WHITELIST] = array_merge($trustedHosts, [
    'payport.novalnet.de', // trusted Novalnet domain
]);

// ---------- State machine (OMS) Configuration
$config[OmsConstants::PROCESS_LOCATION] = [
    APPLICATION_ROOT_DIR . '/vendor/novalnet/sprykerb2c-marketplace/config/Zed/Oms',
];
$config[OmsConstants::ACTIVE_PROCESSES] = [
    'NovalnetCreditCard01',
    'NovalnetSepa01',
    'NovalnetSepaGuarantee01',
    'NovalnetInvoice01',
    'NovalnetInvoiceGuarantee01',
    'NovalnetPrepayment01',
    'NovalnetIdeal01',
    'NovalnetSofort01',
    'NovalnetGiropay01',
    'NovalnetBarzahlen01',
    'NovalnetPrzelewy01',
    'NovalnetEps01',
    'NovalnetPaypal01',
    'NovalnetPostfinanceCard01',
    'NovalnetPostfinance01',
    'NovalnetBancontact01',
    'NovalnetMultibanco01',
    'NovalnetOnlineBanktransfer01',
    'NovalnetTrustly01',
    'NovalnetAlipay01',
    'NovalnetWechatpay01',
];
$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_CC => 'NovalnetCreditCard01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_SEPA => 'NovalnetSepa01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_SEPA_GUARANTEE => 'NovalnetSepaGuarantee01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_INVOICE => 'NovalnetInvoice01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_INVOICE_GUARANTEE => 'NovalnetInvoiceGuarantee01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_PREPAYMENT => 'NovalnetPrepayment01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_IDEAL => 'NovalnetIdeal01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_SOFORT => 'NovalnetSofort01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_GIROPAY => 'NovalnetGiropay01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_BARZAHLEN => 'NovalnetBarzahlen01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_PRZELEWY => 'NovalnetPrzelewy01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_EPS => 'NovalnetEps01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_PAYPAL => 'NovalnetPaypal01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_POSTFINANCE_CARD => 'NovalnetPostfinanceCard01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_POSTFINANCE => 'NovalnetPostfinance01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_BANCONTACT => 'NovalnetBancontact01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_MULTIBANCO => 'NovalnetMultibanco01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_ONLINEBANKTRANSFER => 'NovalnetOnlineBanktransfer01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_TRUSTLY => 'NovalnetTrustly01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_ALIPAY => 'NovalnetAlipay01',
    NovalnetConfig::NOVALNET_PAYMENT_METHOD_WECHATPAY => 'NovalnetWechatpay01',
];

// ----------- Translator
$config[TranslatorConstants::TRANSLATION_ZED_FILE_PATH_PATTERNS] = [
    APPLICATION_ROOT_DIR . '/vendor/novalnet/sprykerb2c-marketplace/data/translation/Zed/[a-z][a-z]_[A-Z][A-Z].csv',
];

$config[NovalnetConstants::NOVALNET] = [
    // ------------------ Vendor Configurations ----------------------
    NovalnetConstants::NOVALNET_CREDENTIALS_SIGNATURE => '', // The signature is provided by Novalnet AG after the opening of a merchant account.
    NovalnetConstants::NOVALNET_CREDENTIALS_TARIFF => '', // The tariff ID is a unique identification number for each project you have created. The merchant can create any number of tariffs in the Novalnet admin portal.
    NovalnetConstants::NOVALNET_CREDENTIALS_ACCESS_KEY => '', // This is the secure public key for encrypting and decrypting transaction parameters. This is mandatory value for all online transfers, Credit Card-3D secure and wallet systems.
    NovalnetConstants::NOVALNET_SANDBOX_MODE => false, // (true/false) true = The payment will be processed in the test mode therefore amount for this transaction will not be charged, false = The payment will be processed in the live mode.
    // ------------------ Shop URL information ----------------------
    NovalnetConstants::NOVALNET_REDIRECT_SUCCESS_URL => sprintf(
        '%s/novalnet/payment',
        $config[ApplicationConstants::BASE_URL_YVES]
    ),
    NovalnetConstants::NOVALNET_REDIRECT_ERROR_URL => sprintf(
        '%s/novalnet/payment',
        $config[ApplicationConstants::BASE_URL_YVES]
    ),

    // ------------------ Credit Card payment ----------------------
    NovalnetConstants::NOVALNET_CREDIT_CARD_ONHOLD_AMOUNT_LIMIT => '', // (in minimum unit of currency. Example. enter 100 which is equal to 1.00) In case the order amount exceeds mentioned limit, the transaction will be set on hold till your confirmation of transaction.
    NovalnetConstants::NOVALNET_CREDIT_CARD_FORM_CLIENT_KEY => '', // A public unique key needs linked to your account. It is needed to do the client-side authentication. You can find this credential by logging into your Novalnet Admin Portal
    NovalnetConstants::NOVALNET_CREDIT_CARD_FORM_INLINE => true, // (true/false) true = Show Inline Credit card form form, false = Show Credit Card form in multi lines.
    NovalnetConstants::NOVALNET_CREDIT_CARD_FORM_STYLE_CONTAINER => '', // Customize styles of the Credit Card iframe.
    NovalnetConstants::NOVALNET_CREDIT_CARD_FORM_STYLE_INPUT => '',  // Customize styles of the Credit Card iframe input element.
    NovalnetConstants::NOVALNET_CREDIT_CARD_FORM_STYLE_LABEL => '', // Customize styles of the Credit Card iframe label element.

    // ------------------ Invoice payment ----------------------
    NovalnetConstants::NOVALNET_INVOICE_DUE_DATE => '', // (in days) Enter the number of days within which the payment is to be made at Novalnet (at least 7 days). If this field is empty, 14 days will be set as the default time.
    NovalnetConstants::NOVALNET_INVOICE_ONHOLD_AMOUNT_LIMIT => '', // (in minimum unit of currency. Example. enter 100 which is equal to 1.00) In case the order amount exceeds mentioned limit, the transaction will be set on hold till your confirmation of transaction.

    // ------------------ Prepayment payment ----------------------
    NovalnetConstants::NOVALNET_PREPAYMENT_DUE_DATE => '', // (in days) Enter the number of days within which the payment is to be made at Novalnet (at least 7 days). If this field is empty, 14 days will be set as the default time.

    // ------------------ Guraranteed Invoice payment ----------------------
    NovalnetConstants::NOVALNET_INVOICE_GUARANTEE_MINIMUM_AMOUNT_LIMIT => '', // Enter the minimum amount (in cents) for the transaction to be processed with payment guarantee. For example, enter 100 which is equal to 1,00. By default, the amount will be 9,99 EUR
    NovalnetConstants::NOVALNET_INVOICE_GUARANTEE_ONHOLD_AMOUNT_LIMIT => '', // (in minimum unit of currency. Example. enter 100 which is equal to 1.00) In case the order amount exceeds mentioned limit, the transaction will be set on hold till your confirmation of transaction.

    // ------------------ Direct Debit SEPA payment ----------------------
    NovalnetConstants::NOVALNET_SEPA_DUE_DATE => '', // (in days) Enter the number of days after which the payment should be processed (must be between 2 and 14 days).
    NovalnetConstants::NOVALNET_SEPA_ONHOLD_AMOUNT_LIMIT => '', // (in minimum unit of currency. Example. enter 100 which is equal to 1.00) In case the order amount exceeds mentioned limit, the transaction will be set on hold till your confirmation of transaction.

    // ------------------ Guraranteed Direct Debit SEPA payment ----------------------
    NovalnetConstants::NOVALNET_SEPA_GUARANTEE_DUE_DATE => '', // (in days) Enter the number of days after which the payment should be processed (must be between 2 and 14 days).
    NovalnetConstants::NOVALNET_SEPA_GUARANTEE_MINIMUM_AMOUNT_LIMIT => '', // Enter the minimum amount (in cents) for the transaction to be processed with payment guarantee. For example, enter 100 which is equal to 1,00. By default, the amount will be 9,99 EUR
    NovalnetConstants::NOVALNET_SEPA_GUARANTEE_ONHOLD_AMOUNT_LIMIT => '', // (in minimum unit of currency. Example. enter 100 which is equal to 1.00) In case the order amount exceeds mentioned limit, the transaction will be set on hold till your confirmation of transaction.

    // ------------------ Barzahlen payment ----------------------
    NovalnetConstants::NOVALNET_BARZAHLEN_SLIP_EXPIRY_DATE => '', // (in days) Enter the number of days within which your customer will pay the amount of the order in a cash partner store near him. If the ticket does not redeem and pay the payment in time, it will expire. If the field is empty, by default it is set to 14 days as the due date.

    // ------------------ PayPayl payment ----------------------
    NovalnetConstants::NOVALNET_PAYPAL_ONHOLD_AMOUNT_LIMIT => '', // (in minimum unit of currency. Example. enter 100 which is equal to 1.00) In case the order amount exceeds mentioned limit, the transaction will be set on hold till your confirmation of transaction.
];

// ------------------ Novalnet Callback Script ----------------------
    $config[NovalnetConstants::NOVALNET_CALLBACK] = [
        NovalnetConstants::NOVALNET_CALLBACK_DEBUG_MODE => false, // (true/false) Please disable this option before setting your shop to LIVE mode, to avoid unauthorized calls from external parties (excl. Novalnet). For LIVE, set the value as false.
        NovalnetConstants::NOVALNET_CALLBACK_EMAIL_TO_ADDRESS => '', // E-mail address of the recipient for To
    ];
