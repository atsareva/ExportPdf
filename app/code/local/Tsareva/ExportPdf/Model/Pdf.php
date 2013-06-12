<?php

define('P_EXT', '.pdf');

/**
 * Pdf Model
 *
 * @category   Tsareva
 * @package    Tsareva_SalesGrid
 * @author     Tsareva Alena <tsareva.as@gmail.com>
 */
class Tsareva_ExportPdf_Model_Pdf extends Mage_Core_Model_Abstract
{

    /**
     * Export html to pdf
     *
     * @param html $html
     * @param string $documentName
     */
    public function export($html, $documentName)
    {
        //include pdf library
        include ('Tsareva/ExportPdf/lib/mpdf/mpdf.php');

        //set format, indents, etc
        $mpdf = new mPDF('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /* задаем формат, отступы и.т.д. */

        //get style sheet
        $stylesheet = file_get_contents(Mage::getModuleDir('lib', 'Tsareva_ExportPdf') . '/lib/mpdf/mpdf.css');

        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->list_indent_first_level = 0;

        //forming pdf
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output((string) $documentName . P_EXT, 'I');
    }

}