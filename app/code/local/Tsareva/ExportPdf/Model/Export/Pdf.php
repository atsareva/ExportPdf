<?php

/**
 * Export to Pdf Model
 *
 * @category   Tsareva
 * @package    Tsareva_SalesGrid
 * @author     Tsareva Alena <tsareva.as@gmail.com>
 */
class Tsareva_ExportPdf_Model_Export_Pdf extends Mage_Core_Model_Abstract
{

    public function exportOrders($ids)
    {
        $ordersInfo = array();

        foreach ($ids as $id) {
            $order = Mage::getModel('sales/order')->load($id);
            if ($order->getId()) {
                $ordersInfo[] = $this->_getOrderInfo($order);
            }
        }

        return $ordersInfo;
    }

    private function _getOrderInfo($order)
    {
        $orderInfo = array(
            'Order Information'   => array(
                'Order ID'   => $order->getRealOrderId(),
                'Order Date' => Mage::helper('core')->formatDate($order->getCreatedAt(), 'medium', true),
            ),
            'Account Information' => array(
                'Customer Name' => $order->getCustomerName(),
                'Email'         => $order->getCustomerEmail(),
            ),
            'Billing Address'     => $this->_getAddressHtml($order->getBillingAddress()),
            'Shipping Address'    => $this->_getAddressHtml($order->getShippingAddress()),
            'Items Ordered'       => $this->_getOrderedItems($order->getItemsCollection()->getItems()),
        );

        if ($order->getGiftMessageId())
            $orderInfo['Additional Information'] = $this->_getGiftMessage($order->getGiftMessageId());

        return $orderInfo;
    }

    /**
     * Retrieve billing|shipping address info
     *
     * @param object $address
     * @return string
     */
    private function _getAddressHtml($address)
    {
        $billingAddressHtml = '<p>' . $address->getFirstname() . ' ' . $address->getLastname() . '</p>' .
                '<p>' . $address->getStreet1() . '</p><p>' . $address->getCity();

        if ($address->getRegion())
            $billingAddressHtml .= ', ' . $address->getRegion();

        $billingAddressHtml .= $address->getPostcode() . '</p><p>' . $address->getCountry() . '</p>';

        if ($address->getTelephone())
            $billingAddressHtml .= '<p>T: ' . $address->getTelephone() . '</p>';

        return $billingAddressHtml;
    }

    /**
     * Retrieve ordered items info
     *
     * @param object $orderedItems
     * @return array
     */
    private function _getOrderedItems($orderedItems)
    {
        $items = array();
        foreach ($orderedItems as $item) {
            $items[$item->getId()] = array(
                'name' => $item->getName(),
                'sku'  => $item->getSku(),
            );

            $customOptions = $item->getProductOptions();
            if (isset($customOptions['options'])) {
                foreach ($customOptions['options'] as $option) {
                    $items[$item->getId()]['options'][] = array(
                        'label' => $option['label'],
                        'value' => $option['print_value']
                    );
                }
            }
        }
        return $items;
    }

    /**
     * Retrieve Gift Message by id
     *
     * @param int $messageId
     * @return string
     */
    private function _getGiftMessage($messageId)
    {
        return Mage::helper('giftmessage/message')->getGiftMessage($messageId)->getMessage();
    }

}