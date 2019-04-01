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
 * Class Vipps_Payment_Model_Resource_Profiling_Item_RequestType
 */
class Vipps_Payment_Model_Resource_Profiling_Item_RequestType
{
    public function toOptionHash()
    {
        $hash = [];
        foreach ($this->toOptionArray() as $item) {
            $hash[$item['value']] = $item['label'];
        }

        return $hash;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => Vipps_Payment_Model_Profiling_TypeInterface::INITIATE_PAYMENT,
                'label' => Vipps_Payment_Model_Profiling_TypeInterface::INITIATE_PAYMENT_LABEL,
            ],
            [
                'value' => Vipps_Payment_Model_Profiling_TypeInterface::GET_PAYMENT_DETAILS,
                'label' => Vipps_Payment_Model_Profiling_TypeInterface::GET_PAYMENT_DETAILS_LABEL,
            ],
            [
                'value' => Vipps_Payment_Model_Profiling_TypeInterface::GET_ORDER_STATUS,
                'label' => Vipps_Payment_Model_Profiling_TypeInterface::GET_ORDER_STATUS_LABEL,
            ],
            [
                'value' => Vipps_Payment_Model_Profiling_TypeInterface::CAPTURE,
                'label' => Vipps_Payment_Model_Profiling_TypeInterface::CAPTURE_LABEL,
            ],
            [
                'value' => Vipps_Payment_Model_Profiling_TypeInterface::REFUND,
                'label' => Vipps_Payment_Model_Profiling_TypeInterface::REFUND_LABEL,
            ],
            [
                'value' => Vipps_Payment_Model_Profiling_TypeInterface::CANCEL,
                'label' => Vipps_Payment_Model_Profiling_TypeInterface::CANCEL_LABEL,
            ],
            [
                'value' => Vipps_Payment_Model_Profiling_TypeInterface::VOID,
                'label' => Vipps_Payment_Model_Profiling_TypeInterface::VOID_LABEL,
            ]
        ];
    }
}