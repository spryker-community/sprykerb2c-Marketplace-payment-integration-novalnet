<?php

namespace Novalnet\Zed\NovalnetPayment\Business\Payment;

use Generated\Shared\Transfer\NovalnetCallbackResponseTransfer;
use Generated\Shared\Transfer\NovalnetCallbackScriptParameterTransfer;
use Generated\Shared\Transfer\NovalnetStandardParameterTransfer;
use Novalnet\Zed\NovalnetPayment\Dependency\Facade\NovalnetPaymentToGlossaryInterface;
use Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface;
use Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetCallback;
use Orm\Zed\Sales\Persistence\SpySalesOrderQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrderTotalsQuery;

class CallbackManager extends PaymentManager implements CallbackManagerInterface
{
    /**
     * @var \Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \Generated\Shared\Transfer\NovalnetCallbackScriptParameterTransfer
     */
    protected $callbackParameter;

    /**
     * @var \Generated\Shared\Transfer\NovalnetStandardParameterTransfer
     */
    protected $standardParameter;

    /**
     * @var \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer
     */
    protected $callbackResponseTransfer;

    /**
     * @var \Novalnet\Zed\NovalnetPayment\Dependency\Facade\NovalnetPaymentToGlossaryInterface
     */
    protected $glossaryFacade;

    /**
     * @var bool $test
     */
    protected $test;

    /**
     * @var object $callbackResponse
     */
    protected $callbackResponse;

    /**
     * @var string $orderNo
     */
    protected $orderNo;

    /**
     * @var string $order
     */
    protected $order;

    /**
     * @var string $currency
     */
    protected $currency;

    /**
     * @var string $currentTime
     */
    protected $currentTime;

    /**
     * @var string $emailBody
     */
    protected $emailBody;

    /**
     * @var string $eventType
     */
    protected $eventType;

    /**
     * @var string $eventTid
     */
    protected $eventTid;

    /**
     * @var string $parentTid
     */
    protected $parentTid;

    /**
     * @var string $paymentAccessKey
     */
    protected $paymentAccessKey;

    /**
     * @var string $paymentAccessKey
     */
    protected $isAffiliateEvent;

    /**
     * @param \Novalnet\Zed\NovalnetPayment\Persistence\NovalnetPaymentQueryContainerInterface $queryContainer
     * @param \Generated\Shared\Transfer\NovalnetCallbackScriptParameterTransfer $callbackParameter
     * @param \Generated\Shared\Transfer\NovalnetStandardParameterTransfer $standardParameter
     * @param \Novalnet\Zed\NovalnetPayment\Dependency\Facade\NovalnetPaymentToGlossaryInterface $glossaryFacade
     */
    public function __construct(
        NovalnetPaymentQueryContainerInterface $queryContainer,
        NovalnetCallbackScriptParameterTransfer $callbackParameter,
        NovalnetStandardParameterTransfer $standardParameter,
        NovalnetPaymentToGlossaryInterface $glossaryFacade
    ) {
        $this->queryContainer = $queryContainer;
        $this->callbackParameter = $callbackParameter;
        $this->standardParameter = $standardParameter;
        $this->glossaryFacade = $glossaryFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer $callbackResponseTransfer
     *
     * @return \Generated\Shared\Transfer\NovalnetCallbackResponseTransfer
     */
    public function processCallback(NovalnetCallbackResponseTransfer $callbackResponseTransfer)
    {
        // Generated\Shared\Transfer\NovalnetCallbackResponseTransfer
        $this->callbackResponseTransfer = $callbackResponseTransfer;
        // Current timestamp value
        $this->currentTime = date('Y-m-d H:i:s');

        // Assign callback script debug mode (only for testing purpose)
        $this->test = $this->callbackParameter->getDebugMode();

        // Assign Access key
        $this->paymentAccessKey = $this->standardParameter->getAccessKey();

        // Validate the IP control check
        if (!$this->validateIpAddress($callbackResponseTransfer->getClientIp())) {
            return $callbackResponseTransfer;
        }

        // Assign callback script request parameters
        $this->callbackResponse = $callbackResponseTransfer->getCallbackResponse();

        // Set Event data.
        $this->eventType = $this->callbackResponse['event']['type'];
        $this->isAffiliateEvent = false;

        if ($this->eventType == 'AFFILIATE_ACTIVATION') {
            $this->isAffiliateEvent = true;
        } else {
            $this->eventTid = $this->callbackResponse['event']['tid'];
            $this->parentTid = $this->eventTid;
            if (!empty($this->callbackResponse['event']['parent_tid'])) {
                $this->parentTid = $this->callbackResponse['event']['parent_tid'];
            }
        }

        // Assign order reference number
        $this->orderNo = $this->getOrderIncrementId();
        if (empty($this->orderNo)) {
            return $callbackResponseTransfer;
        }

        // Check the callback mandatory parameters
        if (!$this->checkParams()) {
            return $callbackResponseTransfer;
        }

        // Validate the
        if (!$this->validateEventData()) {
            return $callbackResponseTransfer;
        }

        if ($this->isAffiliateEvent) {
            $this->handleAffiliateActivation();

            return $callbackResponseTransfer;
        }

        // Get order using order reference
        $this->order = $this->getOrder();
        if (!$callbackResponseTransfer->getOrderNo()) {
            $callbackResponseTransfer->setOrderNo($this->orderNo);
        }

        if (empty($this->order) || ($this->order && !$this->order->getOrderReference())) {
            $this->showDebug(['message' => 'Transaction mapping failed']);

            return $callbackResponseTransfer;
        }

        // Complete the order in-case response failure from Novalnet server
        if ($this->handleCommunicationFailure()) {
            return $callbackResponseTransfer;
        }

        // Handle callback process
        if (!$this->hanldeCallbackProcess()) {
            return $callbackResponseTransfer;
        }

        if (!empty($this->emailBody)) {
            $this->sendCallbackMail();
        }

        $callbackResponseTransfer->setIsSuccess(true);

        return $callbackResponseTransfer;
    }

    /**
     * @param string|null $callerIp
     *
     * @return bool|string
     */
    protected function validateIpAddress($callerIp = null)
    {
        $allowedIp = gethostbyname('pay-nn.de');

        if (empty($allowedIp)) {
            $this->showDebug([ 'message' => 'Novalnet HOST IP missing']);

            return false;
        }

        if ($callerIp != $allowedIp && !$this->test) {
            $this->showDebug([ 'message' => 'Unauthorised access from the IP [' . $callerIp . ']']);

            return false;
        }

        return true;
    }

    /**
     * @param string $text
     *
     * @return void
     */
    protected function showDebug($text)
    {
        if (!empty($text)) {
            $this->callbackResponseTransfer->setStatusMessage(json_encode($text));
        }
    }

    /**
     * @return int
     */
    protected function getOrderIncrementId()
    {
        // Get order increment id
        $orderNo = !empty($this->callbackResponse['transaction']['order_no']) ? $this->callbackResponse['transaction']['order_no'] : '';
        $orderNo = $orderNo ? $orderNo : $this->getOrderIdByTransId();

        if (empty($orderNo)) {
            $this->showDebug(['message' => 'Required (Transaction ID) not Found!']);

            return false;
        }

        return $orderNo;
    }

    /**
     * @return bool
     */
    protected function validateEventData()
    {
        if ($this->isAffiliateEvent) {
            $token_string = $this->callbackResponse['event']['type'] . $this->callbackResponse['merchant']['vendor'] . $this->callbackResponse['affiliate']['vendor'];
        } else {
            $token_string = $this->callbackResponse['event']['tid'] . $this->callbackResponse['event']['type'] . $this->callbackResponse['result']['status'];
        }

        if (isset($this->callbackResponse['transaction']['amount'])) {
            $token_string .= $this->callbackResponse['transaction']['amount'];
        }
        if (isset($this->callbackResponse['transaction']['currency'])) {
            $token_string .= $this->callbackResponse['transaction']['currency'];
        }
        if (!empty($this->paymentAccessKey)) {
            $token_string .= strrev($this->paymentAccessKey);
        }

        $generated_checksum = hash('sha256', $token_string);

        if ($generated_checksum !== $this->callbackResponse['event']['checksum']) {
            $this->showDebug([ 'message' => 'While notifying some data has been changed. The hash check failed' ]);

            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function checkParams()
    {
        if (!empty($this->callbackResponse['custom']['shop_invoked'])) {
            $this->showDebug(['message' => 'Process already handled in the shop.' ]);

            return false;
        }

        $paramsRequired = $this->getRequiredParams(); // Get required params for callback process

        // Check the necessary params for callback script process
        foreach ($paramsRequired as $category => $parameters) {
            if (empty($this->callbackResponse[$category])) {
                // Could be a possible manipulation in the notification data.
                $this->showDebug(['message' => "Required parameter category($category) not received" ]);

                return false;
            } elseif (!empty($parameters)) {
                foreach ($parameters as $parameter) {
                    if (empty($this->callbackResponse[$category][$parameter])) {
                        // Could be a possible manipulation in the notification data.
                        $this->showDebug([ 'message' => "Required parameter($parameter) in the category($category) not received" ]);

                        return false;
                    } elseif (in_array($parameter, [ 'tid', 'parent_tid' ], true) && !preg_match('/^\d{17}$/', $this->callbackResponse[$category][$parameter])) {
                        $this->showDebug([ 'message' => "Invalid TID received in the category($category) not received $parameter" ]);

                        return false;
                    }
                }
            }
        }

        if (!empty($this->callbackResponse['result']) && $this->callbackResponse['result']['status'] != 'SUCCESS') {
            $message = !empty($this->orderNo)
                ? 'Status is not valid. Refer Order :' . $this->orderNo : 'Status is not valid';

            $this->showDebug([ 'message' => $message]);

            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    protected function getRequiredParams()
    {
        $paramsRequired = [
            'event' => [
                'type',
                'checksum',
                'tid',
            ],
            'merchant' => [
                'vendor',
                'project',
            ],
            'result' => [
                'status',
            ],
            'transaction' => [
                'tid',
                'payment_type',
                'status',
            ],
        ];

        if ($this->isAffiliateEvent) {
            $paramsRequired = [
                'event' => [
                    'type',
                    'checksum',
                ],
                'merchant' => [
                    'vendor',
                    'project',
                ],
                'affiliate' => [
                    'vendor',
                    'activation_date',
                    'reference',
                ],
            ];
        }

        return $paramsRequired;
    }

    /**
     * @return int
     */
    protected function getParentTid()
    {
        // Get the original/parent transaction id
        $tid = $this->eventTid;

        if (!empty($this->parentTid)) {
            $tid = $this->parentTid;
        }

        return $tid;
    }

    /**
     * @return int
     */
    protected function getOrderIdByTransId()
    {
        $parentTid = $this->getParentTid(); // Get the original/parent transaction id
        $transactionLogsQuery = $this->queryContainer->createLastApiLogsByTransactionId($parentTid);
        $transactionLog = $transactionLogsQuery->findOne();
        $orderId = '';

        if ($transactionLog) {
            $orderId = $transactionLog->getOrderReference();
        }

        return $orderId;
    }

    /**
     * @return object
     */
    protected function getOrder()
    {
        $order = SpySalesOrderQuery::create()
                ->filterByOrderReference($this->orderNo)
                ->findOne();

        return $order;
    }

    /**
     * @return object
     */
    protected function getTransactionByOrderId()
    {
        $transactionLogsQuery = $this->queryContainer->createLastApiLogsByOrderReference($this->orderNo);
        $transactionLog = $transactionLogsQuery->findOne();

        return ($transactionLog ? $transactionLog : '');
    }

    /**
     * @return object|null
     */
    protected function getCallbackByOrderId()
    {
        $callbackQuery = $this->queryContainer->createLastCallbackByOrderReference($this->orderNo);
        $callback = $callbackQuery->findOne();

        return ($callback ? $callback : '');
    }

    /**
     * @return object
     */
    protected function getOrderTotals()
    {
        $orderTotals = SpySalesOrderTotalsQuery::create()
                ->filterByFkSalesOrder($this->order->getIdSalesOrder())
                ->findOne();

        return $orderTotals;
    }

    /**
     * @return bool
     */
    protected function hanldeCallbackProcess()
    {
        if ($this->order) {
            $this->currency = $this->order->getCurrencyIsoCode();
            $this->callbackResponseTransfer->setOrderNo($this->orderNo);

            switch ($this->eventType) {
                case 'PAYMENT':
                    $this->showDebug([ 'message' => 'The Payment has been received' ]);

                    return true;
                case 'TRANSACTION_CAPTURE':
                    $this->transactionConfirmation();

                    return true;
                case 'TRANSACTION_CANCEL':
                    $this->transactionCancellation();

                    return true;
                case 'TRANSACTION_REFUND':
                case 'CHARGEBACK':
                case 'RETURN_DEBIT':
                case 'REVERSAL':
                    $this->transactionRefund();

                    return true;
                case 'TRANSACTION_UPDATE':
                    $this->transactionUpdate();

                    return true;
                case 'CREDIT':
                    $this->paymentCreditProcess();

                    return true;
                case 'AFFILIATE':
                    $this->handleMarketPlaceFollowup();

                    return true;
                case 'AFFILIATE_ACTIVATION':
                    $this->handleAffiliateActivation();

                    return true;
                default:
                    $this->showDebug([ 'message' => "The webhook notification has been received for the unhandled EVENT type($this->eventType)" ]);

                    return false;
            }

            return true;
        } else {
            $this->showDebug([ 'message' => "Novalnet Callback: No order for Increment-ID $this->orderNo found." ]);

            return false;
        }
    }

    /**
     * @return void
     */
    protected function handleMarketPlaceFollowup()
    {
        $transactionLog = $this->getTransactionByOrderId();
        $marketplaceDetails = json_decode($transactionLog->getPaymentResponse(), true);
        $marketplaceDetails[$this->callbackResponse['merchant']['vendor']]['vendor'] = $this->callbackResponse['merchant']['vendor'];
        $marketplaceDetails[$this->callbackResponse['merchant']['vendor']]['tid'] = $this->callbackResponse['event']['tid'];
        $marketplaceDetails[$this->callbackResponse['merchant']['vendor']]['followup_booking'] = $this->callbackResponse['marketplace']['followup_booking'];

        $transactionLog->setPaymentResponse(json_encode($marketplaceDetails));
        $transactionLog->save();
    }

    /**
     * @return bool
     */
    protected function handleAffiliateActivation()
    {
        $marketplaceQuery = $this->queryContainer->queryMarketplace()->filterByNnMerchantId((int)$this->callbackResponse['affiliate']['vendor']);
        $marketplaceVendorData = $marketplaceQuery->findOne();

        $comment = '';
        if (!empty($marketplaceVendorData) && $marketplaceVendorData->getNnMerchantActiveStatus() != 'ACTIVATED') {
            $additionalDetails = json_decode($marketplaceVendorData->getAdditionalData());
            $additionalDetails->callback_request = $this->callbackResponse;
            $marketplaceVendorData->setNnMerchantActiveStatus('ACTIVATED');
            $marketplaceVendorData->setAdditionalData(json_encode($additionalDetails));
            $marketplaceVendorData->save();
            $comment = 'Affiliate details are successfully updated / activated';
        } else {
            $comment = 'Affiliate details are not found / already activated';
        }

        $this->showDebug([ 'message' => $comment ]);

        return true;
    }

    /**
     * @return bool
     */
    protected function handleCommunicationFailure()
    {
        $transactionLog = $this->getTransactionByOrderId();

        if ($transactionLog && empty($transactionLog->getTransactionId())) {
            $transactionLog->setTransactionId($this->eventTid);
            $transactionLog->setStatus($this->callbackResponse['transaction']['status']);
            $transactionLog->setTransactionStatus($this->callbackResponse['transaction']['status']);
            $transactionLog->setPaymentMethod($this->callbackResponse['transaction']['payment_type']);
            $paymentMethod = $this->callbackResponse['transaction']['payment_type'];

            if (!empty($paymentMethod)) {
                $transactionLog->setPaymentMethod($paymentMethod);
            }

            $additionalData = $this->getAdditionalData($transactionLog, $this->callbackResponse);
            $transactionLog->setAdditionalData(json_encode($additionalData));

            $transactionLog->save();

            // Update order status
            $this->updateOrderStatus('communication_failure');
            $this->showDebug([ 'message' => 'The Payment has been received' ]);

            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    protected function transactionConfirmation()
    {
        $transactionId = $this->getParentTid();
        $transactionLog = $this->getTransactionByOrderId();

        if (
            !empty($this->callbackResponse['transaction']['due_date'])
            && in_array($this->callbackResponse['transaction']['payment_type'], ['PREPAYMENT', 'INVOICE', 'GUARANTEED_INVOICE'])
        ) {
            $additionalData = json_decode($transactionLog->getAdditionalData(), true);
            $additionalData['captured_amount'] = !empty($additionalData['captured_amount'])
                ? $additionalData['captured_amount'] + $this->callbackResponse['transaction']['amount']
                : $this->callbackResponse['transaction']['amount'];
            $invoiceComments = explode('|', $additionalData['invoice_comments']);
            $invoiceComments[1] = $this->glossaryFacade->translate('novalnet.invoice-bank-note-transfer-text-with-due-date', ['%amount%' => number_format($additionalData['captured_amount'] / 100, 2, '.', '') . ' ' . $this->callbackResponse['transaction']['currency'], '%due_date%' => $this->callbackResponse['transaction']['due_date']]);
            $additionalData['invoice_comments'] = implode('|', $invoiceComments);

            if ($this->callbackResponse['transaction']['payment_type'] == 'GUARANTEED_INVOICE') {
                $additionalData['guarantee_pending_comments'] = '';
            }

            $transactionLog->setAdditionalData(json_encode($additionalData))->save();
        }

        $paymentStatus = $transactionLog->getTransactionStatus(); // Get payment original transaction status
        $orderStatus = 'paid';
        if ($this->callbackResponse['transaction']['payment_type'] == 'INVOICE') {
            $orderStatus = 'waiting_for_payment';
        }
        $transactionLog->setTransactionStatus($this->callbackResponse['transaction']['status']);
        $transactionLog->save();

        $statusMessage = ['message' => "The transaction has been confirmed on $this->currentTime"];
        $this->setCallbackComments($statusMessage);
        $this->updateOrderStatus($orderStatus);
        $this->emailBody = $statusMessage;
        $this->sendCallbackMail();
        $this->showDebug($statusMessage);
    }

    /**
     * @return void
     */
    protected function transactionCancellation()
    {
        // Get Novalnet transaction using order reference
        $transactionLog = $this->getTransactionByOrderId();
        $transactionLog->setTransactionStatus($this->callbackResponse['transaction']['status'])->save();
        $statusMessage = ['message' => "The transaction has been canceled on $this->currentTime"];
        $this->setCallbackComments($statusMessage);
        $this->updateOrderStatus('canceled');
        $this->emailBody = $statusMessage;
        $this->sendCallbackMail();
        $this->showDebug($statusMessage);
    }

    /**
     * @return void
     */
    protected function transactionRefund()
    {
        // Update callback comments for Refunds
        $amount = ($this->eventType == 'TRANSACTION_REFUND') ? $this->callbackResponse['transaction']['refund']['amount'] : $this->callbackResponse['transaction']['amount'];
        $amount = number_format($amount / 100, 2, '.', '') . ' ' . $this->currency;
        $transactionId = $this->parentTid;
        $tid = $this->eventTid;

        $statusMessage = ($this->eventType == 'TRANSACTION_REFUND')
            ? ['message' => "Refund has been initiated for the TID: $transactionId with the amount of $amount. New TID: $tid for the refunded amount."]
            : ['message' => "Chargeback executed successfully for the TID: $transactionId amount: $amount on $this->currentTime. The subsequent TID: $tid"];

        $this->setCallbackComments($statusMessage);
        $this->emailBody = $statusMessage;
        $this->showDebug($statusMessage);
    }

    /**
     * @return void
     */
    protected function transactionUpdate()
    {
        $orderStatus = $statusMessage = '';
        $transactionId = $this->getParentTid();
        $transactionLog = $this->getTransactionByOrderId();
        $additionalData = json_decode($transactionLog->getAdditionalData(), true);
        $amount = number_format($this->callbackResponse['transaction']['amount'] / 100, 2, '.', '') . ' ' . $this->currency;
        $paymentStatus = $transactionLog->getTransactionStatus(); // Get payment original transaction status

        if ($paymentStatus == 'PENDING' && $this->callbackResponse['transaction']['status'] == 'ON_HOLD') {
            if ($this->callbackResponse['transaction']['payment_type'] == 'GUARANTEED_INVOICE') {
                $additionalData['guarantee_pending_comments'] = '';
                $transactionLog->setAdditionalData(json_encode($additionalData))->save();
            }

            $orderStatus = 'authorize';
            $statusMessage = ['message' => "The transaction status has been changed from pending to on hold for the TID: $transactionId on $this->currentTime."];
        } elseif ($paymentStatus == 'PENDING' && $this->callbackResponse['transaction']['status'] == 'CONFIRMED') {
            if ($this->callbackResponse['transaction']['payment_type'] == 'GUARANTEED_INVOICE') {
                $additionalData['guarantee_pending_comments'] = '';
                $transactionLog->setAdditionalData(json_encode($additionalData))->save();
            }

            $statusMessage = ['message' => "Transaction updated successfully for the TID: $transactionId with amount $amount"];
            $orderStatus = 'paid';
        } elseif ($paymentStatus == 'PENDING' && $this->callbackResponse['transaction']['status'] == 'PENDING') {
            if (
                !empty($this->callbackResponse['transaction']['update_type']) && $this->callbackResponse['transaction']['update_type'] == 'DUE_DATE'
                && !empty($this->callbackResponse['transaction']['due_date'])
            ) {
                $dueDate = $this->callbackResponse['transaction']['due_date'];
                /* translators: %1$s: tid, %2$s: amount, %3$s: due date */
                $statusMessage = ['message' => "Transaction updated successfully for the TID: $transactionId with amount $amount and due date $dueDate"];
            } else {
                /* translators: %1$s: tid, %2$s: amount*/
                $statusMessage = ['message' => "Transaction updated successfully for the TID: $transactionId with amount $amount"];
            }

            $invoiceComments = explode('|', $additionalData['invoice_comments']);
            $invoiceComments[1] = $this->glossaryFacade->translate('novalnet.invoice-bank-note-transfer-text-with-due-date', ['%amount%' => $amount, '%due_date%' => $this->callbackResponse['transaction']['due_date']]);
            $additionalData['invoice_comments'] = implode('|', $invoiceComments);
            $transactionLog->setAdditionalData(json_encode($additionalData))->save();

            $orderStatus = 'authorize';
        }

        if ($orderStatus) {
            $this->updateOrderStatus($orderStatus);
        }

        if ($statusMessage) {
            $this->setCallbackComments($statusMessage);
        }
        $statusMessage = ['message' => $statusMessage];
        $transactionLog->setTransactionStatus($this->callbackResponse['transaction']['status'])->save();
        // Update callback comments for Refunds
        $amount = number_format($this->callbackResponse['transaction']['amount'] / 100, 2, '.', '') . ' ' . $this->currency;
        $transactionId = $this->parentTid;
        $tid = $this->eventTid;
        $this->showDebug($statusMessage);
    }

    /**
     * @return void
     */
    protected function paymentCreditProcess()
    {
        $amount = number_format($this->callbackResponse['transaction']['amount'] / 100, 2, '.', '') . ' ' . $this->currency;
        $transactionId = $this->parentTid;
        $referenceTid = $this->eventTid;

        if (in_array($this->callbackResponse['transaction']['payment_type'], ['MULTIBANCO_CREDIT', 'INVOICE_CREDIT', 'ONLINE_TRANSFER_CREDIT', 'CASHPAYMENT_CREDIT'])) {
            $callbackLog = $this->getCallbackByOrderId();
            $callbackAmount = ($callbackLog && $callbackLog->getCallbackAmount()) ? $callbackLog->getCallbackAmount() : 0;
            $totalAmount = sprintf(($this->callbackResponse['transaction']['amount'] + $callbackAmount), 0.2);
            $orderPaidAmount = ($callbackLog && $callbackLog->getCallbackAmount()) ? sprintf($callbackLog->getCallbackAmount(), 0.2) : 0;
            $orderTotals = $this->getOrderTotals();
            $grandTotal = round(sprintf($orderTotals->getGrandTotal(), 0.2));
            $statusMessage = "Credit has been successfully received for the TID: $transactionId with amount $amount on $this->currentTime. Please refer PAID order details in our Novalnet Admin Portal for the TID: $referenceTid. ";

            // Log callback data
            $this->logCallbackInfo($callbackLog, $totalAmount);

            if ($orderPaidAmount < $grandTotal) {
                if ($this->callbackResponse['transaction']['payment_type'] == 'ONLINE_TRANSFER_CREDIT') {
                    $statusMessage = ($totalAmount >= $grandTotal) ? $statusMessage . "The amount of $amount for the order $this->orderNo has been paid. Please verify received amount and TID details, and update the order status accordingly." : $statusMessage;
                } elseif ($totalAmount >= $grandTotal) {
                    $this->updateOrderStatus('paid');
                    $transactionLog = $this->getTransactionByOrderId();
                    $transactionLog->setTransactionStatus($this->callbackResponse['transaction']['status'])->save();
                }
                $statusMessage = ['message' => $statusMessage];
                $this->setCallbackComments($statusMessage);
                $this->emailBody = $statusMessage;
                $this->showDebug($statusMessage);
            } else {
                $this->showDebug(
                    [
                    'message' => 'Callback Script executed already. Refer Order :' . $this->orderNo,
                    ]
                );
            }
        } else {
            $statusMessage = ['message' => "Credit has been successfully received for the TID: $transactionId with amount $amount on $this->currentTime. Please refer PAID order details in our Novalnet Admin Portal for the TID: $referenceTid."];

            $this->setCallbackComments($statusMessage);
            $this->emailBody = $statusMessage;
            $this->showDebug($statusMessage);
        }
    }

    /**
     * @param Orm\Zed\Novalnet\Persistence\SpyPaymentNovalnetCallbackQuery $callbackLog
     * @param float $amount
     *
     * @return void
     */
    protected function logCallbackInfo($callbackLog, $amount)
    {
        $transactionId = $this->getParentTid(); // Get the original/parent transaction id

        if (!$callbackLog) {
            $callbackLog = new SpyPaymentNovalnetCallback();
        }

        $callbackLog->setFkSalesOrder($this->order->getIdSalesOrder());
        $callbackLog->setOrderReference($this->orderNo);
        $callbackLog->setCallbackAmount($amount);
        $callbackLog->setReferenceTid($this->eventTid);
        $callbackLog->setTransactionId($transactionId);
        $callbackLog->setCallbackLog(json_encode($this->callbackResponse));
        $callbackLog->save();
    }

    /**
     * @param string $orderStatus
     *
     * @return void
     */
    protected function updateOrderStatus($orderStatus)
    {
        if ($orderStatus) {
            $this->callbackResponseTransfer->setOrderStatus($orderStatus);
        }
    }

    /**
     * @param string|null $statusMessage
     *
     * @return void
     */
    protected function setCallbackComments($statusMessage = null)
    {
        if ($statusMessage) {
            $transactionLog = $this->getTransactionByOrderId();

            $additionalData = json_decode($transactionLog->getAdditionalData(), true);
            $callbackComments = !empty($additionalData['callback_comments']) ? $additionalData['callback_comments'] . $statusMessage['message'] : $statusMessage['message'];
            $additionalData['callback_comments'] = $callbackComments . '|';

            $transactionLog->setAdditionalData(json_encode($additionalData))->save();
        }
    }

    /**
     * Send callback notification E-mail
     *
     * @throws \Exception
     *
     * @return void
     */
    public function sendCallbackMail()
    {
        if ($this->callbackParameter->getCallbackMailToAddress()) {
            try {
                $subject = 'Novalnet Callback Script Access Report';
                $emailToAddr = $this->validateEmail($this->callbackParameter->getCallbackMailToAddress());
                $senderMail = $this->glossaryFacade->translate('mail.sender.email', []);
                $headers = "From: $senderMail\r\n";

                mail($emailToAddr, $subject, $this->emailBody['message'], $headers); // Send mail
            } catch (ClientException $e) {
                throw new Exception($e->getResponse());
            }
        }
    }

    /**
     * Check the email id is valid
     *
     * @param string $emailAddress
     *
     * @return string
     */
    public function validateEmail($emailAddress)
    {
        $email = explode(',', $emailAddress);

        $validMail = [];
        foreach ($email as $emailAddrVal) {
            if (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", trim($emailAddrVal))) { // Check the email id is valid
                $validMail[] = $emailAddrVal;
            }
        }

        return implode(',', $validMail);
    }
}
