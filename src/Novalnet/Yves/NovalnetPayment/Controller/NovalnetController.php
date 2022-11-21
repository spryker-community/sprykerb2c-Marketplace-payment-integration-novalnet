<?php

namespace Novalnet\Yves\NovalnetPayment\Controller;

use Generated\Shared\Transfer\NovalnetCallbackResponseTransfer;
use Generated\Shared\Transfer\NovalnetRedirectResponseTransfer;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @method \Novalnet\Client\NovalnetPayment\NovalnetPaymentClientInterface getClient()
 */
class NovalnetController extends AbstractController
{
    protected const ROUTE_CHECKOUT_SUCCESS = 'checkout-success';

    protected const CHECKOUT_ERROR = 'checkout-error';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function paymentAction(Request $request): RedirectResponse
    {
        $request = $this->getUrldecodedRequestBody($request);

        $redirectResponseTransfer = new NovalnetRedirectResponseTransfer();
        $redirectResponseTransfer->setStatusMessage(!empty($request['status_text']) ? $request['status_text'] : '');
        $redirectResponseTransfer->setPaymentResponse($request);
        $redirectResponseTransfer = $this->processPaymentResponse($redirectResponseTransfer);

        return $this->handleRedirectFromNovalnet($redirectResponseTransfer);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function getUrldecodedRequestBody(Request $request): array
    {
        $allRequestParameters = $request->query->all();

        foreach ($allRequestParameters as $key => $value) {
            if (is_string($value)) {
                $allRequestParameters[$key] = urldecode($value);
            }
        }

        return $allRequestParameters;
    }

    /**
     * @param \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer $redirectResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer
     */
    protected function processPaymentResponse(NovalnetRedirectResponseTransfer $redirectResponseTransfer): NovalnetRedirectResponseTransfer
    {
        return $this
            ->getClient()
            ->processRedirectPaymentResponse($redirectResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\NovalnetRedirectResponseTransfer $responseTransfer
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function handleRedirectFromNovalnet(NovalnetRedirectResponseTransfer $responseTransfer): RedirectResponse
    {
        if ($responseTransfer->getIsSuccess()) {
            $this->addSuccessMessage($responseTransfer->getStatusMessage()); // Add payport status message

            return $this->redirectResponseInternal(static::ROUTE_CHECKOUT_SUCCESS);
        } else {
            $this->addErrorMessage($responseTransfer->getStatusMessage()); // Add payport status message

            return $this->redirectResponseInternal(static::CHECKOUT_ERROR);
        }
    }

    /**
     * @param callable|null $callback
     * @param int $status
     * @param array $headers
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function streamedResponse($callback = null, $status = 200, $headers = []): StreamedResponse
    {
        $streamedResponse = new StreamedResponse($callback, $status, $headers);
        $streamedResponse->send();

        return $streamedResponse;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function callbackAction(Request $request): StreamedResponse
    {
        $clientIp = $this->getClientIp(); // Get the client IP address
        $requestJson = $request->getContent();
        $request = json_decode($requestJson, true);

        $callbackResponseTransfer = new NovalnetCallbackResponseTransfer();

        if (!empty($request['transaction']['order_no'])) {
            $callbackResponseTransfer->setOrderNo($request['transaction']['order_no']);
        }

        if (!empty($request['transaction']['payment_type'])) {
            $callbackResponseTransfer->setPaymentType($request['transaction']['payment_type']);
        }

        $callbackResponseTransfer->setClientIp($clientIp);
        $callbackResponseTransfer->setCallbackResponse($request);

        $response = $this->processCallbackResponse($callbackResponseTransfer);

        $callback = function () use ($response) {
            echo $response->getStatusMessage();
        };

        return $this->streamedResponse($callback);
    }

    /**
     * @param \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer $callbackResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer
     */
    protected function processCallbackResponse(NovalnetCallbackResponseTransfer $callbackResponseTransfer): NovalnetCallbackResponseTransfer
    {
        return $this
            ->getClient()
            ->processCallbackResponse($callbackResponseTransfer);
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        $ipKeys = ['HTTP_X_FORWARDED_HOST', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    // trim for safety measures
                    return (filter_var(trim($ip), FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ? '127.0.0.1' : trim($ip);
                }
            }
        }
    }
}
