<?php
//require('includes/application_top.php');
//require('includes/pdfbill/pdfbill_lib.php');  
  
  
if( $_GET['file']!='' ) {  
  $pdffile= $admindir.$_GET['file'];
  $pdffile_downloadname = basename($_GET['file']);
} else {
  $pdffile= $admindir.get_pdf_invoice_filename( $_GET['oID'] );
  $pdffile_downloadname = get_pdf_invoice_download_filename( $_GET['oID'] );
}

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