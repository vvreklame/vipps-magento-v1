<?php
/**
 * Copyright 2018 Vipps
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 *  documentation files (the "Software"), to deal in the Software without restriction, including without limitation
 *  the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
 *  and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 *  TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL
 *  THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
 *  CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 *  IN THE SOFTWARE.
 *
 */

namespace Vipps\Payment\Model\Adapter;

//use Magento\Framework\Exception\NoSuchEntityException;
//use Magento\Quote\Api\Data\CartInterface;
//use Vipps\Payment\Api\Data\QuoteInterface;
//use Vipps\Payment\Api\QuoteManagementInterface;
use Vipps\Payment\Model\Adapter\Adapter\Quote\Factory;

/**
 * Class QuoteRepository
 */
class QuoteManagement
{
    /**
     * @var Factory
     */
    private $quoteFactory;

    /**
     * @var QuoteRepository
     */
    private $quoteRepository;

    /**
     * QuoteManagement constructor.
     */
    public function __construct() {
        $this->quoteFactory = new Factory();
        $this->quoteRepository = new QuoteRepository();
    }

    /**
     * @param \Mage_Sales_Model_Quote $cart
     * @return \Mage_Core_Model_Abstract
     */
    public function create(\Mage_Sales_Model_Quote $cart)
    {
        /** @var Quote $monitoringQuote */
        $monitoringQuote = $this->quoteFactory->create();

        $monitoringQuote
            ->setQuoteId($cart->getId())
            ->setStoreId($cart->getStoreId())
            ->setReservedOrderId($cart->getReservedOrderId());

        return $this->quoteRepository->save($monitoringQuote);
    }

    /**
     * @param \Mage_Sales_Model_Quote $quote
     * @return \Vipps_Payment_Model_Quote
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function getByQuote(\Mage_Sales_Model_Quote $quote)
    {
        try {
            $vippsQuote = $this->quoteRepository->loadByQuote($quote->getId());
        } catch (NoSuchEntityException $exception) {
            // Setup default values for backward compatibility with current quotes.
            $vippsQuote = $this->quoteFactory->create()
                ->setQuoteId($quote->getId())
                ->setReservedOrderId($quote->getReservedOrderId());

            // Backward compatibility for old quotes paid with vipps.
            $this->quoteRepository->save($vippsQuote);
        }

        return $vippsQuote;
    }

    /**
     * @param \Vipps_Payment_Model_Quote $quote
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Vipps_Payment_Model_Quote $quote)
    {
        $this->quoteRepository->save($quote);
    }
}
