<?php

/**
 * Overrides Mage_Adminhtml_Block_Sales_Order_Grid to append option to export to pdf
 *
 * @category   Tsareva
 * @package    Tsareva_SalesGrid
 * @author     Tsareva Alena <tsareva.as@gmail.com>
 */
class Tsareva_ExportPdf_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{

    /**
     * Extends the mass action select box to append the option to export to pdf.
     */
    protected function _prepareMassaction()
    {
        // Let the base class do its work
        parent::_prepareMassaction();

        // Append option to export to csv to select box
        $this->getMassactionBlock()->addItem('pdfexport', array(
            'label' => $this->__('Export to .pdf file'),
            'url'   => $this->getUrl('exportPdf/export_order/export'))
        );

        return $this;
    }

}

?>