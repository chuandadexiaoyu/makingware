<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * PayPal MEP Shopping cart totals xml renderer
 *
 * @category    Mage
 * @package     Mage_Cart
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Block_Cart_Paypal_Mep_Totals extends Mage_Checkout_Block_Cart_Totals
{
    /**
     * Render cart totals xml
     *
     * @return string
     */
    protected function _toHtml()
    {
        $quote = $this->getQuote();
        $totalsXmlObj  = new Mage_XmlConnect_Model_Simplexml_Element('<cart_totals></cart_totals>');
        list($items, $totals) = Mage::helper('paypal')->prepareLineItems($quote);

        if (Mage::helper('paypal')->areCartLineItemsValid($items, $totals, $quote->getBaseGrandTotal())) {
            foreach ($totals as $code => $amount) {
                $currencyAmount = $this->helper('core')->currency($amount, false, false);
                $totalsXmlObj->addChild($code, Mage::helper('xmlconnect')->formatPriceForXml($currencyAmount));
            }
        } else {
           Mage::throwException($this->__('Cart line items are not eligible for exporting to PayPal API'));
        }
        return $totalsXmlObj->asNiceXml();
    }
}
