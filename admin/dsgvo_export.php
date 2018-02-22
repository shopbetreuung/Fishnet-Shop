<?php

require('includes/application_top.php');
require_once(DIR_FS_INC .'xtc_format_price.inc.php');

if ($_GET['action'] != 'export_csv') {
    require (DIR_WS_INCLUDES.'head.php');
}

$search_email_address = '';
if (isset($_GET['dsgvo_export_search']) && xtc_not_null($_GET['dsgvo_export_search'])) {
    $search_email_address = xtc_db_input(xtc_db_prepare_input($_GET['dsgvo_export_search']));
} 

if (isset($_GET['action']) && $_GET['action'] == 'export_csv' && $_GET['csID'] != '') {

    ob_end_clean();

    $output = fopen("php://output",'w') or die("Can't open php://output");
    header("Content-Type:text/csv"); 
    header("Content-Disposition:attachment; filename=customer_data_".$_GET['csID'].".csv");   

    $dsgvo_export_query = xtc_db_query("SELECT c.customers_gender, c.customers_firstname, c.customers_lastname, c.customers_email_address, ab.entry_company, c.customers_vat_id, ab.entry_street_address, ab.entry_postcode, ab.entry_city, tc.countries_name, c.customers_telephone, c.customers_fax FROM ".TABLE_CUSTOMERS." c JOIN ".TABLE_ADDRESS_BOOK." ab ON c.customers_id = ab.customers_id JOIN ".TABLE_COUNTRIES." tc ON tc.countries_id = ab.entry_country_id WHERE c.customers_id = ".$_GET['csID']);
    $dsgvo_export_array = xtc_db_fetch_array($dsgvo_export_query);

    foreach ($dsgvo_export_array as $key=>$value) {
        if ($key == 'customers_gender') {
            if ($value == 'm') {
                $value = MALE;
            } else {
                $value = FEMALE;
            }               
        }
        fputcsv($output, array(constant('DSGVO_'.strtoupper($key)),$value),';');           
    }     
    fputcsv($output, array(''),';');

    $dsgvo_export_reviews = xtc_db_query("SELECT r.date_added, rd.reviews_text, pd.products_name FROM ".TABLE_REVIEWS." r JOIN ".TABLE_REVIEWS_DESCRIPTION." rd ON r.reviews_id = rd.reviews_id JOIN ".TABLE_PRODUCTS_DESCRIPTION." pd ON pd.products_id = r.products_id WHERE customers_id =".$_GET['csID']." AND pd.language_id = ".$_SESSION['languages_id']);

    if (xtc_db_num_rows($dsgvo_export_reviews) > 0) {
        $rNum = 1;
        fputcsv($output, array(DSGVO_REVIEWS_HEADING),';');
        fputcsv($output, array(''),';');
        
        while ($dsgvo_export_reviews_array = xtc_db_fetch_array($dsgvo_export_reviews)) {
            fputcsv($output, array(DSGVO_REVIEW_HEADING." ".$rNum,),';'); 
            fputcsv($output, array(DSGVO_DATE,date('d.m.Y', strtotime($dsgvo_export_reviews_array['date_added']))),';');
            fputcsv($output, array(DSGVO_PRODUCT_NAME,$dsgvo_export_reviews_array['products_name']),';');
            fputcsv($output, array(DSGVO_REVIEWS_TEXT,$dsgvo_export_reviews_array['reviews_text']),';');
            fputcsv($output, array(''),';');

            $rNum++;
        }
    }

    $dsgvo_orders_query = xtc_db_query("SELECT o.orders_id, o.date_purchased, o.customers_ip, o.comments, o.customers_name, o.customers_street_address, o.customers_postcode, o.customers_city, o.customers_country, o.delivery_name, o.delivery_street_address, o.delivery_postcode, o.delivery_city, o.delivery_country, o.billing_name, o.billing_street_address, o.billing_postcode, o.billing_city, o.billing_country, o.language, o.payment_method, o.currency FROM ".TABLE_ORDERS." o WHERE customers_id = ".$_GET['csID']);

    if (xtc_db_num_rows($dsgvo_orders_query) > 0) {

        fputcsv($output, array(DSGVO_ORDERS_HEADING),';');
        fputcsv($output, array(''),';');  

        $oNum = 1;

        while ($dsgvo_orders_array = xtc_db_fetch_array($dsgvo_orders_query)) {

            fputcsv($output, array(DSGVO_ORDER_HEADING." ".$oNum),';'); 
            fputcsv($output, array(DSGVO_ORDER_ID,$dsgvo_orders_array['orders_id']),';'); 
            fputcsv($output, array(DSGVO_ORDER_DATE,$dsgvo_orders_array['date_purchased']),';'); 
            fputcsv($output, array(DSGVO_ORDER_IP_ADDRESS,$dsgvo_orders_array['customers_ip']),';'); 
            fputcsv($output, array(DSGVO_ORDER_COMMENT,$dsgvo_orders_array['comments']),';');                 
            fputcsv($output, array(DSGVO_CUSTOMER_ADDRESS,$dsgvo_orders_array['customers_name'],$dsgvo_orders_array['customers_street_address'],$dsgvo_orders_array['customers_postcode'].' '.$dsgvo_orders_array['customers_city'],$dsgvo_orders_array['customers_country']),';'); 
            fputcsv($output, array(DSGVO_SHIPPING_ADDRESS,$dsgvo_orders_array['delivery_name'],$dsgvo_orders_array['delivery_street_address'],$dsgvo_orders_array['delivery_postcode'].' '.$dsgvo_orders_array['delivery_city'],$dsgvo_orders_array['delivery_country']),';'); 
            fputcsv($output, array(DSGVO_BILLING_ADDRESS,$dsgvo_orders_array['billing_name'],$dsgvo_orders_array['billing_street_address'],$dsgvo_orders_array['billing_postcode'].' '.$dsgvo_orders_array['billing_city'],$dsgvo_orders_array['billing_country']),';'); 
            fputcsv($output, array(DSGVO_CUSTOMER_LANGUAGE,$dsgvo_orders_array['language']),';'); 
            fputcsv($output, array(DSGVO_PAYMENT_METHOD,$dsgvo_orders_array['payment_method']),';'); 

            $dsgvo_product_query = xtc_db_query("SELECT op.orders_id, op.orders_products_id, op.products_quantity, op.products_name, op.products_price, op.products_model, op.products_tax, op.final_price, op.products_id, op.allow_tax FROM ".TABLE_ORDERS_PRODUCTS." op WHERE op.orders_id = ".$dsgvo_orders_array['orders_id']);

            $first_product = true;

            while ($dsgvo_product_array = xtc_db_fetch_array($dsgvo_product_query)) {    
                $products_price = format_price($dsgvo_product_array['products_price'], 0, $dsgvo_orders_array['currency'], $dsgvo_product_array['allow_tax'], $dsgvo_product_array['products_tax']);                
                $attribute_query = xtc_db_query("SELECT opa.products_options, opa.products_options_values FROM ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES." opa WHERE opa.orders_id = ".$dsgvo_product_array['orders_id']." AND opa.orders_products_id = ".$dsgvo_product_array['orders_products_id']);

                $attr_string = '';

                    if (xtc_db_num_rows($attribute_query) > 0) {

                        while ($attribute_fetch_array = xtc_db_fetch_array($attribute_query)) {
                          $attr_string.= ' / '.$attribute_fetch_array['products_options'].': '.$attribute_fetch_array['products_options_values'];                            
                        }                               
                    }

                    if ($first_product) {
                        fputcsv($output, array(DSGVO_ORDER_HEADING,$dsgvo_product_array['products_quantity']." x ".$dsgvo_product_array['products_name']." ".$attr_string,DSGVO_PRODUCT_NUMBER.": ".$dsgvo_product_array['products_model'],DSGVO_PRICE_EXKL.": ".$products_price,DSGVO_TAX.": ".(int)$dsgvo_product_array['products_tax']."%",DSGVO_PRICE_INKL.": ".xtc_format_price($dsgvo_product_array['products_price'],1,false),DSGVO_TOTAL_PRICE.": ".xtc_format_price($dsgvo_product_array['final_price'],1,false)),';');  
                        $first_product = false;
                    } else {
                        fputcsv($output, array('',$dsgvo_product_array['products_quantity']." x ".$dsgvo_product_array['products_name']." ".$attr_string,DSGVO_PRODUCT_NUMBER.": ".$dsgvo_product_array['products_model'],DSGVO_PRICE_EXKL.": ".$products_price,DSGVO_TAX.": ".(int)$dsgvo_product_array['products_tax']."%",DSGVO_PRICE_INKL.": ".xtc_format_price($dsgvo_product_array['products_price'],1,false),DSGVO_TOTAL_PRICE.": ".xtc_format_price($dsgvo_product_array['final_price'],1,false)),';'); 
                    }    
            }                 

            $dsgvo_order_total_query = xtc_db_query("SELECT ot.text, ot.value, ot.title FROM ".TABLE_ORDERS_TOTAL." ot WHERE ot.orders_id = ".$dsgvo_orders_array['orders_id'] ." ORDER BY ot.sort_order ASC");               

            while ($dsgvo_order_total_array = xtc_db_fetch_array($dsgvo_order_total_query)) { 
                fputcsv($output, array('','','','','','','', strip_tags(html_entity_decode($dsgvo_order_total_array['title'])).strip_tags($dsgvo_order_total_array['text'])),';');
            }
            fputcsv($output, array(''),';');
            $oNum++;
        }
    }
    fclose($output) or die("Can't close php://output");
    exit();
}

?>
</head>
<body>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <div class='row'>
        <div class='col-xs-12'>
            <p class="h2">
                <?php echo DSGVO_EXPORT_HEADING_TITLE; ?>
            </p>           
        </div>
        <br />
        <div class='col-xs-12'>
            <?php  
                echo xtc_draw_form('dsgvo_export_form', FILENAME_DSGVO_EXPORT,'','get');
                echo DSGVO_EXPORT_SEARCH_FIELD.' '.xtc_draw_input_field('dsgvo_export_search',$_GET['dsgvo_export_search'],'style="width: 200px !important"');
                echo xtc_button(DSGVO_SEARCH_BUTTON, 'submit');
            ?>
            </form>            
            <div class='col-xs-12'> <br /> </div>
            <table class='table table-bordered'>  
                <tr>
                    <td> <?php echo '<strong>'.DSGVO_EXPORT_TABLE_CUSTOMER_FIRSTNAME.'</strong>'; ?> </td> 
                    <td> <?php echo '<strong>'.DSGVO_EXPORT_TABLE_CUSTOMER_LASTNAME.'</strong>'; ?> </td> 
                    <td> <?php echo '<strong>'.DSGVO_EXPORT_TABLE_CUSTOMER_EMAIL_ADDRESS.'</strong>'; ?> </td> 
                    <td> <?php echo '<strong>'.DSGVO_EXPORT_TABLE_CUSTOMER_EXPORT_BUTTON.'</strong>'; ?> </td> 
                </tr>
                <?php
                $where_str = '';
                if (isset($search_email_address) && $search_email_address != '') {
                    $where_str = "WHERE c.customers_email_address LIKE '%".$search_email_address."%'";
                }
                $dsgvo_export_select = "SELECT c.customers_firstname, c.customers_lastname, c.customers_email_address, c.customers_id FROM ".TABLE_CUSTOMERS." c ".$where_str;
                $dsgvo_export_split = new splitPageResults($_GET['page'], '30', $dsgvo_export_select, $dsgvo_export_query_numrows);
                $dsgvo_export_query = xtc_db_query($dsgvo_export_select);

                while ($dsgvo_export_array = xtc_db_fetch_array($dsgvo_export_query)) {
                ?>
                <tr>
                    <td class="dataTableContent" align="right" width="25%"><?php echo $dsgvo_export_array['customers_firstname']; ?>&nbsp;</td>  
                    <td class="dataTableContent" align="right" width="25%"><?php echo $dsgvo_export_array['customers_lastname']; ?>&nbsp;</td>  
                    <td class="dataTableContent" align="right" width="25%"><?php echo $dsgvo_export_array['customers_email_address']; ?>&nbsp;</td>  
                    <td class="dataTableContent" align="right" width="25%">
                       <?php
                          echo '<a class="btn btn-default" href="' . xtc_href_link(FILENAME_DSGVO_EXPORT,'page='.$_GET['page'] .'&dsgvo='.$_GET['dsgvo_export_search']. '&csID='.$dsgvo_export_array['customers_id']. '&action=export_csv') . '">'.DSGVO_EXPORT_EXPORT_BUTTON.'</a>';                    
                       ?>
                    </td>  
                </tr> 
                <?php
                }

                ?>

            </table>
            <div class='col-xs-12'>
                <div class="smallText col-xs-6"><?php echo $dsgvo_export_split->display_count($dsgvo_export_query_numrows, '30', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_DSGVO_EXPORT); ?></div>
                <div class="smallText col-xs-6 text-right"><?php echo $dsgvo_export_split->display_links($dsgvo_export_query_numrows, '30', MAX_DISPLAY_PAGE_LINKS,$_GET['page'], xtc_get_all_get_params(array('page'))); ?></div>
            </div>
        </div>
    </div>
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
