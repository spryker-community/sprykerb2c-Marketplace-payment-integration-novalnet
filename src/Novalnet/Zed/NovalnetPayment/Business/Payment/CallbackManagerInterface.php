<?php

namespace Novalnet\Zed\NovalnetPayment\Business\Payment;

use Generated\Shared\Transfer\NovalnetCallbackResponseTransfer;

interface CallbackManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer $callbackResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer
     */
    public function processCallback(NovalnetCallbackResponseTransfer $callbackResponseTransfer);
}
