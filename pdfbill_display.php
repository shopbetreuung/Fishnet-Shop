<?php

$admindir='admin/';

require('includes/application_top.php');
require($admindir.'includes/ipdfbill/pdfbill_lib.php');  


//security checks
if (!isset ($_SESSION['customer_id'])) { xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL')); }
if (!isset ($_GET['oID']) || (isset ($_GET['oID']) && !is_numeric($_GET['oID']))) { 
   xtc_redirect(xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
}

$customer_info_query = xtc_db_query("select customers_id from ".TABLE_ORDERS." where orders_id = '".(int) $_GET['oID']."'");
$customer_info = xtc_db_fetch_array($customer_info_query);
if ($customer_info['customers_id'] != $_SESSION['customer_id']) { 
  xtc_redirect(xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL')); 
}





  
$pdffile= $admindir.get_pdf_invoice_filename( $_GET['oID'] );
$pdffile_downloadname = get_pdf_invoice_download_filename( $_GET['oID'] );

/*
echo "pdffflie=$pdffile<br>\n";
echo "pdffile_downloadname=$pdffile_downloadname<br>\n";
exit;
*/

$fp = fopen($pdffile, 'rb');
$template = fread ($fp, filesize ($pdffile));
fclose ($fp);


//HTTP-Header ausgeben
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$pdffile_downloadname\"");
header("Content-type: application/pdf");

//das fertige PDF ausgeben
echo $template;

?>