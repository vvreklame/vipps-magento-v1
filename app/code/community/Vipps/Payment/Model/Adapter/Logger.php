<?php
/**
 * Copyright 2019 Vipps
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 *    documentation files (the "Software"), to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
 *  and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

/**
 * Class Logger
 */
class Vipps_Payment_Model_Adapter_Logger
{
    const FILENAME_CRITICAL = 'vipps_exception.log';
    const FILENAME_DEBUG = 'vipps_debug.log';

    /**
     * @param string $message
     * @param array $context
     */
    public function critical($message, $context = null)
    {
        Mage::log($message, LOG_CRIT, self::FILENAME_CRITICAL);
        if (!is_null($context)) {
            Mage::log('CONTEXT:' . json_encode($context), LOG_CRIT, self::FILENAME_CRITICAL);
        }
    }

    /**
     * @param string $message
     */
    public function debug($message)
    {
        Mage::log($message, LOG_DEBUG, self::FILENAME_DEBUG);
    }

    /**
     * @param $message
     * @param array $context
     */
    public function info($message, $context = null)
    {
        Mage::log($message, LOG_INFO, self::FILENAME_DEBUG);
        if (!is_null($context)) {
            Mage::log('CONTEXT:' . json_encode($context), LOG_INFO, self::FILENAME_DEBUG);
        }
    }

    /**
     * @param $message
     */
    public function error($message)
    {
        Mage::log($message, LOG_ERR, self::FILENAME_CRITICAL);
    }
}
