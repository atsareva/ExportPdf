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
        $orderIds = $this->getRequest()->getPost('order_ids', array());

        //get orders info by id's
        $ordersInfo   = Mage::getModel('tsareva_exportpdf/export_pdf')->getOrdersInfo($orderIds);

        //retrieve orders html
        $html = Mage::getModel('core/layout')->createBlock('core/template', 'exportPdf', array('template' => 'exportpdf/sales/order/view.phtml'))->assign('orders', $ordersInfo)->toHtml();

        //export to pdf
        Mage::getModel('tsareva_exportpdf/pdf')->export($html, 'Order_' . date("Ymd_His"));
    }

}

?>