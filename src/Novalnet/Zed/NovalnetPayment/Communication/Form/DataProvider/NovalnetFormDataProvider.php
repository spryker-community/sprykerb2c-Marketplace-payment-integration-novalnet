<?php

namespace Novalnet\Zed\NovalnetPayment\Communication\Form\DataProvider;

use Generated\Shared\Transfer\NovalnetMarketplaceTransfer;
use Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig;
use Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetMarketplace;

class NovalnetFormDataProvider
{
    /**
     * @var \Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig
     */
    protected $config;

    /**
     * @param \Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig $config
     */
    public function __construct(NovalnetPaymentConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return [];
    }

    /**
     * @param \Generated\Shared\Transfer\NovalnetMarketplaceTransfer|null $novalnetMarketplaceTransfer
     * @param \Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetMarketplace|null $transactionLog
     *
     * @return \Generated\Shared\Transfer\NovalnetMarketplaceTransfer
     */
    public function getData(
        ?NovalnetMarketplaceTransfer $novalnetMarketplaceTransfer,
        ?SpyPaymentNovalnetMarketplace $transactionLog
    ): NovalnetMarketplaceTransfer {
        if ($novalnetMarketplaceTransfer === null) {
            $novalnetMarketplaceTransfer = new NovalnetMarketplaceTransfer();

            if (!empty($transactionLog)) {
                $novalnetMarketplaceTransfer->setNnMerchantId($transactionLog->getNnMerchantId());
                $novalnetMarketplaceTransfer->setNnMerchantActiveStatus($transactionLog->getNnMerchantActiveStatus());
            }
        }

        return $novalnetMarketplaceTransfer;
    }
}
