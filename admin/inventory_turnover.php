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
   $error = false;
    if($_GET['action'] == 'inventory_turnover'){
        $handler = new xtc_export_csv_inventory_turnover(CSV_NAME_FILE, $products_name, $ai, $it, $_SESSION['start_date'], $_SESSION['inventory_turnover']);
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
<div class='col-xs-12'>
    <form method="post" action="inventory_turnover.php">
        
        <div class="col-xs-12">
                <?php echo TEXT_INVENTORY_TURNOVER; ?><input type="text" size="4" value="<?php echo $_POST['inventory_turnover']; ?>" name ="inventory_turnover"/> <br />
                <?php echo TEXT_DATE; ?>
                <div style="display: inline-block;"><input type="text" size="2" maxlength="2" onFocus="javascript:CheckMe('1',this.form);" name="from_t" value="<?php echo $_POST['from_t']; ?>"> / </div>
                <div style="display: inline-block;"><input type="text" size="2" maxlength="2" onFocus="javascript:CheckMe('1',this.form);" name="from_m" value="<?php echo $_POST['from_m']; ?>"> / </div>
                <div style="display: inline-block;"><input type="text" size="4" maxlength="4" onFocus="javascript:CheckMe('1',this.form);" name="from_y" value="<?php echo $_POST['from_y']; ?>"></div>
                <div style="display: inline-block;"><?php echo TEXT_UNTIL_TODAY; echo '('.date('d/m/Y', time()).')';?> </div>
        </div>
        <input type="submit" class="btn btn-default" onclick="this.blur();" value= '<?php echo BUTTON_SHOW_INVENTORY_TURNOVER; ?>'/>
</div>
    <div class='table-responsive col-xs-12'>
        <table class='table table-bordered'>
            <tr><td> <?php echo TEXT_PRODUCTS_NAME; ?> </td> <td> <?php echo TEXT_AI; ?> </td> <td> <?php echo TEXT_IT; ?> </td></tr>
        <?php
        if (isset($_POST['from_t']) && is_numeric($_POST['from_t']) && isset($_POST['from_m']) && is_numeric($_POST['from_m']) && isset($_POST['from_y']) && is_numeric($_POST['from_y']) && isset($_POST['inventory_turnover']) && is_numeric($_POST['inventory_turnover'])) {
            $start_date = (int) $_POST['from_y'] . '-' . (int) $_POST['from_m'] . '-' . (int) $_POST['from_t'] . ' 00:00:00';
            $inputed_inventory_turnover = xtc_round($_POST['inventory_turnover'], 2);
            $_SESSION['start_date'] = $start_date;
            $_SESSION['inventory_turnover'] = $inputed_inventory_turnover;
            $today = date('Y-m-d H:i:s', time());
            $products_query = xtc_db_query("select distinct op.products_id, op.products_name, p.products_quantity, p.products_ordered from " . TABLE_PRODUCTS. " p
                    JOIN products_description pd ON p.products_id = pd.products_id
                    JOIN orders_products op ON p.products_id = op.products_id
                    JOIN orders o ON op.orders_id = o.orders_id 
                    WHERE pd.language_id = '" . $_SESSION['languages_id']."' 
                    AND (o.date_purchased BETWEEN '" . $start_date . "' AND '" . $today . "')
                    GROUP BY op.products_name ASC");
            while ($products_values = xtc_db_fetch_array($products_query)) {

                $sold_stock = $products_values['products_ordered'];
                $current_stock = $products_values['products_quantity'];
                
                $whole_stock = $current_stock + $sold_stock;
                $ai = ($whole_stock + $current_stock)  / 2;

                $it = $sold_stock / $ai;

                $date = $products_values['date_purcashed'];
                $datefinal = date('d.m.Y', strtotime($date));
                
                $products_attributes_query = xtc_db_query("SELECT op.products_quantity, opa.products_options_values, pa.attributes_stock, op.products_quantity
                                                  FROM orders_products_attributes opa
                                                  JOIN products_attributes pa ON opa.orders_products_options_values_id = pa.options_values_id
						  JOIN orders_products op ON op.orders_products_id = opa.orders_products_id
                                                  JOIN products_options_values pov ON pov.products_options_values_id = pa.options_values_id
                                               WHERE
                                                   pa.products_id = '".$products_values['products_id'] . "'
                                               AND pov.language_id = '" . $_SESSION['languages_id'] . "'
                                               GROUP BY opa.products_options_values 
                            ");
                if($inputed_inventory_turnover > xtc_round($it, 2)){
                    echo '<tr><td width="33.3333333%" class="dataTableContent">'.$products_values['products_name'] . '</td>';
                        echo '<td width="33.3333333%" class="dataTableContent">'.$ai.'</td>';
                        echo '<td width="33.3333333%" class="dataTableContent">'.xtc_round($it, 2).'</td>';
                    echo '</tr>';
                }
                while ($products_attributes_values = xtc_db_fetch_array($products_attributes_query)) {
        
                    $sold_attr_stock = $products_attributes_values['products_quantity'];
                    $current_attr_stock = $products_attributes_values['attributes_stock'];

                    $whole_attr_stock = $sold_attr_stock + $current_attr_stock;

                    $ai_attr = ($whole_attr_stock + $current_attr_stock)  / 2;

                    $it_attr = $sold_attr_stock / $ai_attr;

                    if($inputed_inventory_turnover > xtc_round($it_attr, 2)){
                        echo '<tr><td width="33.3333333%" class="dataTableContent">&nbsp;&nbsp;&nbsp;&nbsp;-'.$products_attributes_values['products_options_values'] . '</td>';
                            echo '<td width="33.3333333%" class="dataTableContent">'.$ai_attr.'</td>';
                            echo '<td width="33.3333333%" class="dataTableContent">'.xtc_round($it_attr, 2).'</td>';
                        echo '</tr>';
                    }
                }
            }
        }
                    ?>  
        </table>
    </div>
</form>
</div>
<?php 
echo xtc_draw_form('inventory_turnover',FILENAME_INVENTORY_TURNOVER_ORDERS,'action=inventory_turnover','POST','enctype="multipart/form-data"'); 
echo '<br/><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_EXPORT_INVENTORY_TURNOVER_CSV . '"/>';
?>
</form>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>