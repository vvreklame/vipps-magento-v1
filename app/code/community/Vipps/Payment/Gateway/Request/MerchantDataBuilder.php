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
 * Class MerchantDataBuilder
 */
class Vipps_Payment_Gateway_Request_MerchantDataBuilder extends Vipps_Payment_Gateway_Request_AbstractBuilder
{
    /**
     * @var Vipps_Payment_Gateway_Config_Config
     */
    private $gatewayConfig;

    public function __construct()
    {
        parent::__construct();

        $this->gatewayConfig = $this->helper->getSingleton('config_config');
    }

    /**
     * Merchant info block name
     *
     * @var string
     */
    private static $merchantInfo = 'merchantInfo';

    /**
     * Identifies a merchant sales channel i.e. website, mobile app etc. Value must be less than or equal to
     * 6 characters.
     *
     * @var string
     */
    private static $merchantSerialNumber = 'merchantSerialNumber';

    /**
     * Get merchant related data for request.
     *
     * @param array $buildSubject
     *
     * @return array
     * @throws \Exception
     */
    public function build(array $buildSubject) //@codingStandardsIgnoreLine
    {
        return [
            self::$merchantInfo => [
                self::$merchantSerialNumber => $this->gatewayConfig->getValue('merchant_serial_number'),
            ]
        ];
    }
}
