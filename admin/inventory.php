<?php
/* --------------------------------------------------------------
   $Id: inventory.php 06.11.2017 DM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  
  require (DIR_WS_INCLUDES.'head.php');
  require(DIR_WS_CLASSES . 'report_classes.php');
  if($_GET['action'] == 'export_stock_orders'){
      $handler = new xtc_export_csv_stock(TEXT_LINK_NAME, $product_id, $product_name, $product_stock, $products_attributes_name, $product_attribute_stock);
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
<?php
  $products_query = xtc_db_query("SELECT p.products_id, p.products_quantity, pd.products_name FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd WHERE pd.language_id = '" . $_SESSION['languages_id'] . "' AND pd.products_id = p.products_id ORDER BY products_quantity");
  while ($products_values = xtc_db_fetch_array($products_query)) {
    echo '<tr><td width="50%" class="dataTableContent"><a href="' . xtc_href_link(FILENAME_CATEGORIES, 'pID=' . $products_values['products_id'] . '&action=new_product') . '"><b>' . $products_values['products_name'] . '</b></a></td><td width="50%" class="dataTableContent">';
    if ($products_values['products_quantity'] <='0') {
      echo '<font color="#ff0000"><b>'.$products_values['products_quantity'].'</b></font>';
    } else {
      echo $products_values['products_quantity'];
    }
    echo '</td></tr>';

    $products_attributes_query = xtc_db_query("SELECT
                                                   pov.products_options_values_name,
                                                   pa.attributes_stock
                                               FROM
                                                   " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
                                               WHERE
                                                   pa.products_id = '".$products_values['products_id'] . "' AND pov.products_options_values_id = pa.options_values_id AND pov.language_id = '" . $_SESSION['languages_id'] . "' ORDER BY pa.attributes_stock");
								
    while ($products_attributes_values = xtc_db_fetch_array($products_attributes_query)) {
      echo '<tr><td width="50%" class="dataTableContent">&nbsp;&nbsp;&nbsp;&nbsp;-' . $products_attributes_values['products_options_values_name'] . '</td><td width="50%" class="dataTableContent">';
      if ($products_attributes_values['attributes_stock'] <= '0') {
        echo '<font color="#ff0000"><b>' . $products_attributes_values['attributes_stock'] . '</b></font>';
      } else {
        echo $products_attributes_values['attributes_stock'];
      }
      echo '</td></tr>';
    }
  }
?>  
</table>

    </div>
</div>
<?php 
echo xtc_draw_form('export_stock_orders',FILENAME_INVENTORY,'action=export_stock_orders','POST','enctype="multipart/form-data"'); 
echo '<br/><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_EXPORT_STOCK_CSV . '"/>';
?>
</form>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>