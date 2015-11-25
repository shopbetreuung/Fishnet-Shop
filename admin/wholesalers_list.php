<?php
/* --------------------------------------------------------------
   $Id: wholesalers_list.php 901 2005-04-29 10:32:14Z novalis $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturers.php,v 1.52 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (manufacturers.php,v 1.9 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

require('includes/application_top.php');
require_once (DIR_FS_CATALOG.DIR_WS_CLASSES.'class.phpmailer.php');
require_once (DIR_FS_INC.'xtc_php_mail.inc.php');
require_once(DIR_FS_INC .'xtc_format_price.inc.php');

if(!empty($_POST) && isset($_GET['wID'])){

    switch ($_GET['action']) {
    case 'save':
      $wholesaler_id = xtc_db_prepare_input($_GET['wID']);
      $product_id =   xtc_db_prepare_input($_GET['pID']);
      $wholesaler_reorder = xtc_db_prepare_input($_POST['wholesaler_reorder']);
      $products_quantity = xtc_db_prepare_input($_POST['products_quantity']);

      #Error
      if($products_quantity < $wholesaler_reorder){
          break;
      }
      
      xtc_db_query("update " . TABLE_PRODUCTS . " set wholesaler_reorder = '".xtc_db_input($wholesaler_reorder)."' where wholesaler_id = '" . xtc_db_input($wholesaler_id) . "' and products_id = '".xtc_db_input($product_id)."'");
     
      if (USE_CACHE == 'true') {
        xtc_reset_cache_block('wholesalers');
      }
      
      xtc_redirect(xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wholesaler_id));
      break;

    case 'deleteconfirm':
      $wholesaler_id = xtc_db_prepare_input($_GET['wID']);
      $product_id =   xtc_db_prepare_input($_GET['pID']);

      xtc_db_query("update " . TABLE_PRODUCTS . " set wholesaler_id = '', wholesaler_reorder = '0' where wholesaler_id = '" . xtc_db_input($wholesaler_id) . "' and products_id = '".xtc_db_input($product_id)."'");
     
      if (USE_CACHE == 'true') {
        xtc_reset_cache_block('wholesalers');
      }
      
      xtc_redirect(xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wholesaler_id));
      break;
      
    case 'new_product':
      $wholesaler_id = xtc_db_prepare_input($_GET['wID']);
      $product_id =  xtc_db_prepare_input($_POST['product_new']);
      $wholesaler_reorder = xtc_db_prepare_input($_POST['wholesaler_reorder']);
      $price_reorder_sum = 0;
      $products_query = xtc_db_query("select p.products_id,
              p.products_price,
              p.products_quantity,
              pd.products_name
              from " . TABLE_PRODUCTS . " p, ".TABLE_PRODUCTS_DESCRIPTION." pd  where p.products_id = '" . $product_id . "' and p.products_id = pd.products_id and pd.language_id = '".$_SESSION['languages_id']."'");
      $product = xtc_db_fetch_array($products_query);
      
      if($product['products_quantity'] < $wholesaler_reorder){
          break;
      }
      
      $product['price_reorder'] = $product['products_price']*$wholesaler_reorder;
      $product['wholesaler_reorder'] = $wholesaler_reorder;

      $_SESSION['one_time_products'][$wholesaler_id][$product_id] = $product;

      if (USE_CACHE == 'true') {
        xtc_reset_cache_block('wholesalers');
      }
      
      xtc_redirect(xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wholesaler_id));
      break;

  }
} 

if(isset($_GET['wID'])){
   #One time (new) products setter
    if(!isset($_SESSION['one_time_products'][$_GET['wID']])){
        $_SESSION['one_time_products'][$_GET['wID']]=array();
    }

  $wholesalers_query_raw = "select wholesaler_id, wholesaler_name, wholesaler_email, wholesaler_email_template from " . TABLE_WHOLESALERS . " where wholesaler_id = '". $_GET['wID'] ."' order by wholesaler_name";
  $wholesalers_split = new splitPageResults($_GET['page'], '20', $wholesalers_query_raw, $wholesalers_query_numrows);
  $wholesalers_query = xtc_db_query($wholesalers_query_raw);
  while ($wholesalers = xtc_db_fetch_array($wholesalers_query)) {
      $wholesaler_products_query = xtc_db_query("select p.products_id,
              p.products_price,
              p.products_quantity,
              p.wholesaler_reorder,
              pd.products_name
              from " . TABLE_PRODUCTS . " p, ".TABLE_PRODUCTS_DESCRIPTION." pd  where wholesaler_id = '" . $wholesalers['wholesaler_id'] . "' and p.products_id = pd.products_id and pd.language_id = '".$_SESSION['languages_id']."'");
      $wholesaler_products_array = array();
      $price_reorder_sum = 0;
      while ($wholesaler_products = xtc_db_fetch_array($wholesaler_products_query)) {
          $wholesaler_products['price_reorder'] = $wholesaler_products['products_price']*$wholesaler_products['wholesaler_reorder'];
          $price_reorder_sum += $wholesaler_products['price_reorder'];
          $wholesaler_products_array[] = $wholesaler_products;
      }
      #total price
      if(!empty($_SESSION['one_time_products'][$_GET['wID']])){
        foreach ($_SESSION['one_time_products'][$_GET['wID']] as $key => $product ){
            $price_reorder_sum +=  $product['price_reorder'];
        }
      }
      $wholesalers['price_reorder_sum'] =  $price_reorder_sum;
      $wholesalers['products'] =  $wholesaler_products_array;
      $wInfo = new objectInfo($wholesalers);
  }
  
  if($_GET["action"] == "new_product_delete"){
      $_SESSION['one_time_products'][$_GET['wID']]= array();
  }
  
  if($_GET["action"] == "send"){
    #MN: Send mail with template and unset session("new products") variable
    $smarty = new Smarty;
    
    $smarty->template_dir = DIR_FS_CATALOG.'templates';
    $smarty->compile_dir = DIR_FS_CATALOG.'templates_c';
    $smarty->config_dir = DIR_FS_CATALOG.'lang';
    
    $smarty->assign('WHOLESALER_ID',$wInfo->wholesaler_id);
    $smarty->assign('WHOLESALER_NAME',$wInfo->wholesaler_name);
    $smarty->assign('WHOLESALER_EMAIL',$wInfo->wholesaler_email);
    $smarty->assign('WHOLESALER_TOTAL_PRICE', xtc_format_price($wInfo->price_reorder_sum, 1, false, 1));
    $smarty->assign('PRODUCTS', $wInfo->products);
    $smarty->assign('PRODUCTS_ADDITION', $_SESSION['one_time_products'][$_GET['wID']]);

    $html_mail = $smarty->fetch(CURRENT_TEMPLATE.'/admin/mail/wholesaler/'.$wInfo->wholesaler_email_template);
    $_SESSION['one_time_products'][$_GET['wID']]= array();
    if (SEND_EMAILS == true) {
      xtc_php_mail( EMAIL_SUPPORT_ADDRESS,                                //  $from_email_address,        
                    EMAIL_SUPPORT_NAME,                                   //  $from_email_name,           
                    $wInfo->wholesaler_email,                             //  $to_email_address,          
                    $wInfo->wholesaler_name,                                //  $to_name,                   
                    '',                                                   //  $forwarding_to,             
                    EMAIL_SUPPORT_REPLY_ADDRESS,                          //  $reply_address,             
                    EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC,                //  $reply_address_name,        
                    '',                                                   //  $path_to_attachement,       
                    '',                                                   //  $name_of_attachment, 
                    PACKET_TRACKING_EMAIL_SUBJECT,                        //  $email_subject,             
                    $html_mail,                                           //  $message_body_html,         
                    '' );                                                 //  $message_body_plain
     } 
  }
}                                   
    
require (DIR_WS_INCLUDES.'head.php');
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<!-- body //-->
<div class='row'>
            <div class="pageHeading col-xs-12">
            <?php 
            echo '<p class="h2">'.WHOLESALER_DETAILS.'</p>'; 
            echo WHOLESALER_NAME.' '.$wInfo->wholesaler_name.'<br>'; 
            echo WHOLESALER_EMAIL.' '.$wInfo->wholesaler_email.'<br>';
            echo WHOLESALER_TEMPLATE.' '.$wInfo->wholesaler_email_template.'<br>';
            echo WHOLESALER_PRODUCTS;
            ?>
                <div class='pull-right'>
                    <?php echo xtc_button_link(WHOLESALER_ONE_TIME_PRODUCT, xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id . '&action=new_product')); ?>
                    <?php echo xtc_button_link(WHOLESALER_ONE_TIME_PRODUCT_DELETE, xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id . '&action=new_product_delete')); ?>
                </div>
            </div>
            
        <div class='col-xs-12'><br></div>
        <div class='col-xs-12'>
            <div id='responsive_table' class='table-responsive pull-left col-sm-12'>
            <table class="table table-bordered table-striped">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo WHOLESALER_PRODUCTS_NAME; ?></td>
                <td class="dataTableHeadingContent hidden-xs"><?php echo WHOLESALER_PRODUCTS_PRICE; ?></td>
                <td class="dataTableHeadingContent hidden-xs"><?php echo WHOLESALER_PRODUCTS_QUANTITY; ?></td>
                <td class="dataTableHeadingContent hidden-xs"><?php echo WHOLESALER_PRODUCTS_REORDER; ?></td>
                <td class="dataTableHeadingContent hidden-xs"><?php echo WHOLESALER_PRODUCTS_MULTIPLIED_PRICE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php

  foreach($wInfo->products as $key => $product ) {      
    if ( (is_array($product))) {
      echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'pointer\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id . '&pID='. $key ) . '#edit-box\'">' . "\n";
    } 
?>
                <td class="dataTableContent"><?php echo $product['products_name']; ?></td>
                <td class="dataTableContent hidden-xs"><?php echo xtc_format_price($product['products_price'],1,false,1); ?></td>
                <td class="dataTableContent hidden-xs"><?php echo $product['products_quantity']; ?></td>
                <td class="dataTableContent hidden-xs"><?php echo $product['wholesaler_reorder']; ?></td>
                <td class="dataTableContent hidden-xs"><?php echo xtc_format_price($product['price_reorder'],1,false,1); ?></td>
                <td class="dataTableContent" align="right"><?php echo '<a href="' . xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id. '&action=edit' . '&pID='. $key ) . '#edit-box">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; ?>&nbsp;</td>

              </tr>
<?php
  }
  if(!empty($_SESSION['one_time_products'][$wInfo->wholesaler_id])){
    foreach ($_SESSION['one_time_products'][$wInfo->wholesaler_id] as $key => $product ){
  ?>
       <tr class="dataTableRowSelected">
                  <td class="dataTableContent"><?php echo $product['products_name']; ?></td>
                  <td class="dataTableContent hidden-xs"><?php echo xtc_format_price($product['products_price'],1,false,1); ?></td>
                  <td class="dataTableContent hidden-xs"><?php echo $product['products_quantity']; ?></td>
                  <td class="dataTableContent hidden-xs"><?php echo $product['wholesaler_reorder']; ?></td>
                  <td class="dataTableContent hidden-xs"><?php echo xtc_format_price($product['price_reorder'],1,false,1); ?></td>
                  <td class="dataTableContent" align="right"><?php echo ONE_TIME_STATUS; ?>&nbsp;</td>
      </tr>  
  <?php 
    }
  }
?></table>
            <div class='col-xs-12'>
                <div class="smallText col-xs-12"><?php echo xtc_button_link(BUTTON_SEND_EMAIL, xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id . '&action=send')); ?></div>
                <div class="smallText col-xs-12 text-right"><?php echo WHOLESALER_TOTAL_PRICE." ".xtc_format_price($wInfo->price_reorder_sum,1,false,1); ?></div>
            </div>
    </div>
<?php
  $heading = array();
  $contents = array();
    $product_key = 0;
    if(isset($_GET['pID'])){
        $product_key = $_GET['pID'];
    }
  switch ($_GET['action']) {
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_WHOLESALER_PRODUCT . $wInfo->products[$product_key]['products_name'] . ':</b>');

      $contents = array('form' => xtc_draw_form('wholesalers', FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id . '&action=save'. '&pID='. $wInfo->products[$product_key]['products_id'], 'post', 'enctype="multipart/form-data"'));
      
      $contents[] = array('text' => '<br />' . TEXT_WHOLESALERS_NUMBER . '<br />' . xtc_draw_input_field('wholesaler_reorder', $wInfo->products[$product_key]['wholesaler_reorder'])); 
      $contents[] = array('text' => xtc_draw_hidden_field('products_quantity', $wInfo->products[$product_key]['products_quantity']));
      $contents[] = array('align' => 'center', 'text' => '<br />' . xtc_button(BUTTON_SAVE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id)));
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_WHOLESALER . '</b>');

      $contents = array('form' => xtc_draw_form('wholesalers', FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id . '&action=deleteconfirm'. '&pID='. $wInfo->products[$product_key]['products_id']));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => xtc_draw_hidden_field('helper', '1'));
      $contents[] = array('text' => '<br /><b>' . $wInfo->products[$product_key]['products_name'] . '</b>');

      $contents[] = array('align' => 'center', 'text' => '<br />' . xtc_button(BUTTON_DELETE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id .'&pID='. $product_key)));
      break;
  
    case 'new_product':
        
      $products_query = xtc_db_query("select p.products_id,
                p.products_quantity,
              pd.products_name
              from " . TABLE_PRODUCTS . " p, ".TABLE_PRODUCTS_DESCRIPTION." pd  where wholesaler_id <> '" . $wInfo->wholesaler_id . "'  and p.products_id = pd.products_id and pd.language_id = '".$_SESSION['languages_id']."'");
      $products_array_dropdown = array();
      $price_reorder_sum = 0;
      while ($product = xtc_db_fetch_array($products_query)) {
            if(!array_key_exists($product['products_id'] ,$_SESSION['one_time_products'][$wInfo->wholesaler_id])){
                $products_array_dropdown[] = array('id' => $product['products_id'], 'text' => $product['products_name']."(".$product['products_quantity'].")");
            }  
      }    
    
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_PRODUCT . '</b>');

      $contents = array('form' => xtc_draw_form('wholesalers', FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id . '&action=new_product'. '&pID='));
      $contents[] = array('text' => TEXT_INTRO_NEW_PRODUCT);
      $contents[] = array('text' => '<br />' . TEXT_WHOLESALERS_NEW_PRODUCT_LIST . '<br />' . xtc_draw_pull_down_menu('product_new', $products_array_dropdown, $selected, $parameters)); 
      $contents[] = array('text' => '<br />' . TEXT_WHOLESALERS_NUMBER . '<br />' . xtc_draw_input_field('wholesaler_reorder')); 

      $contents[] = array('align' => 'center', 'text' => '<br />' . xtc_button(BUTTON_SAVE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id .'&pID='. $product_key)));
      break;
  
    default:
      if (is_object($wInfo)) {
        $heading[] = array('text' => '<b>' . $wInfo->products[$product_key]['products_name']. '</b>');
        $contents[] = array('align' => 'center', 'text' => xtc_button_link(BUTTON_EDIT, xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id . '&action=edit'. '&pID='. $product_key.'#edit-box')) . '&nbsp;' . xtc_button_link(BUTTON_DELETE, xtc_href_link(FILENAME_WHOLESALER_LIST, 'page=' . $_GET['page'] . '&wID=' . $wInfo->wholesaler_id . '&action=delete'. '&pID='. $product_key.'#edit-box')));
      }
      break;
  }

  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
    echo '            <div class="col-md-3 col-sm-12 col-xs-12 pull-right edit-box-class">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </div>' . "\n";
        ?>
    <script>
        //responsive_table
        $('#responsive_table').addClass('col-md-9');
    </script>               
    <?php
  }
?>
        </div>
</div>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
