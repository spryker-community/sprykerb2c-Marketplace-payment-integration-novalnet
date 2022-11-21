<?php

namespace Novalnet\Client\NovalnetPayment\Dependency\Client;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface NovalnetPaymentToZedRequestClientInterface
{
    /**
     * @param string $url
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $object
     * @param array|int|null $requestOptions
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function call($url, TransferInterface $object, $requestOptions = null);
}
