<?php

/**
 * Observer to append option to export to csv to mass action select box in the orders grid.
 *
 * @category   Tsareva
 * @package    Tsareva_SalesGrid
 * @author     Tsareva Alena <tsareva.as@gmail.com>
 */
class Tsareva_ExportPdf_Model_Observer extends Mage_Core_Model_Abstract
{

    /**
     * Extends the mass action select box to append the option to export to csv.
     * Event: core_block_abstract_prepare_layout_before
     */
    public function addMassaction($observer)
    {
        $block = $observer->getEvent()->getBlock();
        if (get_class($block) == 'Mage_Adminhtml_Block_Widget_Grid_Massaction' && $block->getRequest()->getControllerName() == 'sales_order') {
            $block->addItem('pdfexport', array(
                'label' => Mage::helper('core')->__('Export to .pdf file'),
                'url'   => $this->getUrl('exportPdf/export_order/export'))
            );
        }
    }

}