<?php

namespace Novalnet\Zed\NovalnetPayment\Communication\Plugin\MerchantGui;

use Generated\Shared\Transfer\MerchantResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MerchantExtension\Dependency\Plugin\MerchantPostCreatePluginInterface;

/**
 * @method \Novalnet\Zed\NovalnetPayment\Business\NovalnetPaymentFacadeInterface getFacade()
 * @method \Novalnet\Zed\NovalnetPayment\NovalnetPaymentConfig getConfig()
 * @method \Novalnet\Zed\NovalnetPayment\Communication\NovalnetPaymentCommunicationFactory getFactory()
 * @method \Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface getQueryContainer()
 */
class NovalnetMarketplacePostCreatePlugin extends AbstractPlugin implements MerchantPostCreatePluginInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function postCreate(MerchantTransfer $merchantTransfer): MerchantResponseTransfer
    {
        $this->getFacade()->createMarketplaceData($merchantTransfer);

        return (new MerchantResponseTransfer())
            ->setIsSuccess(true)
            ->setMerchant($merchantTransfer);
    }
}
