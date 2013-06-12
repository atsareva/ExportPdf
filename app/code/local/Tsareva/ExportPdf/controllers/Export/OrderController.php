<?php

/**
 * Controller handling order export requests.
 *
 * @category   Tsareva
 * @package    Tsareva_SalesGrid
 * @author     Tsareva Alena <tsareva.as@gmail.com>
 */
class Tsareva_ExportPdf_Export_OrderController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Exports orders defined by id in post param "order_ids" to pdf and offers file directly for download
     * when finished.
     */
    public function exportAction()
    {
        $orders = $this->getRequest()->getPost('order_ids', array());
        $file   = Mage::getModel('tsareva_exportpdf/export_pdf')->exportOrders($orders);
        //$this->_prepareDownloadResponse($file, file_get_contents(Mage::getBaseDir('export') . '/' . $file));
    }

}

?>