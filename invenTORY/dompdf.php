<?php
require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
ob_start();
 include 'report_view_inventory.php';
 $file = ob_get_contents(); 
 ob_end_clean();
$dompdf->loadHtml($file);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("inventorypdf",array('Attachment'=>0));

?>