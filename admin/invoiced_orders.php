<?php
/* --------------------------------------------------------------
   $Id: invoiced_orders.php 06.11.2017 DM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  
  require (DIR_WS_INCLUDES.'head.php');
  require(DIR_WS_CLASSES . 'report_classes.php');
  if($_GET['action'] == 'export_invoiced_orders'){
      $handler = new xtc_export_csv_invoice_orders(TEXT_LINK_NAME, $invoice_number, $invoice_date, $total_net, $total_gross);
  }
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<div class='row'>
                <div class='col-xs-12'>
                    <div class="col-xs-3 col-sm-1 text-right"><?php echo xtc_image(DIR_WS_ICONS.'heading_statistic.gif'); ?></div>
                    <div class="col-xs-9 col-sm-11"><p class="h2"><?php echo HEADING_TITLE; ?></p> <?php echo TEXT_EXPORT; ?></div>
                </div>
                <div class='col-xs-12'><br></div>
                <div class='table-responsive col-xs-12'>
<table class='table table-bordered'>
    <tr><td> <?php echo TEXT_CUSTOMERS_NAME; ?> </td> <td> <?php echo TEXT_ORDERS_ID; ?> </td> </tr>
<?php
  $orders_query = xtc_db_query("SELECT o.customers_name, o.orders_id, o.ibn_billnr, o.ibn_billdate FROM " . TABLE_ORDERS . " o WHERE o.ibn_billnr != 0 ORDER BY o.ibn_billnr DESC");
  while ($orders_values = xtc_db_fetch_array($orders_query)) {
    echo '<tr><td width="50%" class="dataTableContent"><a href="' . xtc_href_link(FILENAME_ORDERS, 'oID=' . $orders_values['orders_id'] . '&action=edit') . '"><b>' . $orders_values['customers_name'] . '</b></a></td><td width="50%" class="dataTableContent">';
    echo $orders_values['orders_id'];
    echo '</td></tr>';
  }
?>  
</table>

    </div>
</div>
<?php 
echo xtc_draw_form('export_invoiced_orders',FILENAME_INVOICED_ORDERS,'action=export_invoiced_orders','POST','enctype="multipart/form-data"'); 
echo '<br/><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_EXPORT_INVOICED_CSV . '"/>';
?>
</form>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>