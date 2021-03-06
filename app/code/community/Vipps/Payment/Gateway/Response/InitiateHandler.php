<?php
/**
 * Copyright 2018 Vipps
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

/**
 * Class InitiateHandler
 */
class Vipps_Payment_Gateway_Response_InitiateHandler extends Vipps_Payment_Gateway_Response_HandlerAbstract
{
    /**
     * @var \Vipps_Payment_Model_Adapter_CartRepository
     */
    private $cartRepository;

    /**
     * @var Mage_Customer_Model_Session
     */
    private $customerSession;

    /**
     * @var \Vipps_Payment_Model_Adapter_ResourceConnectionProvider
     */
    private $resourceConnection;

    /**
     * @var \Vipps_Payment_Model_QuoteManagement
     */
    private $vippsQuoteManagement;

    /**
     * InitiateHandler constructor.
     *
     */
    public function __construct(
    ) {
        parent::__construct();

        $this->cartRepository = Mage::getSingleton('vipps_payment/adapter_cartRepository');
        $this->customerSession = Mage::getSingleton('customer/session');
        $this->resourceConnection = Mage::getSingleton('vipps_payment/adapter_resourceConnectionProvider');
        $this->vippsQuoteManagement = Mage::getSingleton('vipps_payment/quoteManagement');
    }

    /**
     * Save quote payment method.
     *
     * @param array $handlingSubject
     * @param array $responseBody
     *
     * @throws \Exception
     */
    public function handle(array $handlingSubject, array $responseBody) //@codingStandardsIgnoreLine
    {
        /** @var PaymentDataObjectInterface $paymentDO */
        $paymentDO = $this->subjectReader->readPayment($handlingSubject);
        /** @var Payment $payment */
        $payment = $paymentDO->getPayment();
        /** @var Mage_Sales_Model_Quote $quote */
        $quote = $payment->getQuote();

        if (!$quote->getCheckoutMethod()) {
            if ($this->customerSession->isLoggedIn()) {
                $quote->setCheckoutMethod(Mage_Sales_Model_Quote::CHECKOUT_METHOD_LOGIN_IN);
            } elseif ($quote->isAllowedGuestCheckout()) {
                $quote->setCheckoutMethod(Mage_Sales_Model_Quote::CHECKOUT_METHOD_GUEST);
            } else {
                $quote->setCheckoutMethod(Mage_Sales_Model_Quote::CHECKOUT_METHOD_GUEST);
            }
        }
        $payment->setMethod('vipps');
        $quote->setIsActive(false);

        $connection = $this->resourceConnection->getConnection();

        try {
            $connection->beginTransaction();

            $this->cartRepository->save($quote);
            $this->vippsQuoteManagement->create($quote);

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
            throw $e;
        }
    }
}
