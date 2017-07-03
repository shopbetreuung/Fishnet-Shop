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

if(isset($_GET['wID'])){

  $wholesalers_query_raw = "select wholesaler_id, wholesaler_name, wholesaler_email, wholesaler_email_template from " . TABLE_WHOLESALERS . " where wholesaler_id = '". $_GET['wID'] ."' order by wholesaler_name";
  $wholesalers_split = new splitPageResults($_GET['page'], '20', $wholesalers_query_raw, $wholesalers_query_numrows);
  $wholesalers_query = xtc_db_query($wholesalers_query_raw);
  while ($wholesalers = xtc_db_fetch_array($wholesalers_query)) {
      $wholesaler_products_query = xtc_db_query("select p.products_id,
              p.wholesaler_reorder,
			  p.products_quantity,
              pd.products_name
              from " . TABLE_PRODUCTS . " p, ".TABLE_PRODUCTS_DESCRIPTION." pd  where wholesaler_id = '" . $wholesalers['wholesaler_id'] . "' and p.products_quantity <= p.wholesaler_reorder and p.products_id = pd.products_id and pd.language_id = '".$_SESSION['languages_id']."'");
      $wholesaler_products_array = array();
      $price_reorder_sum = 0;
      while ($wholesaler_products = xtc_db_fetch_array($wholesaler_products_query)) {
          $wholesaler_products_array[$wholesaler_products["products_id"]] = $wholesaler_products;
      }
      $wholesalers['products'] =  $wholesaler_products_array;
      $wInfo = new objectInfo($wholesalers);
  }
  
  if($_GET["action"] == "send"){
    #MN: Send mail with template and unset session("new products") variable
    $smarty = new Smarty;
    
    $smarty->template_dir = DIR_FS_CATALOG.'templates';
    $smarty->compile_dir = DIR_FS_CATALOG.'templates_c';
    $smarty->config_dir = DIR_FS_CATALOG.'lang';
    
	$order_products = array();
	$sendorder = false;

	foreach ($_POST["quantity"] as $pid=>$products_quantity) {
		
		if ($products_quantity > 0) {
			$order_products[$pid] = array("products_name" => $wInfo->products[$pid]["products_name"], "products_quantity" => $products_quantity);
			$sendorder = true;
		}
		
	}
	
    $smarty->assign('PRODUCTS', $order_products);
    $html_mail = $smarty->fetch('db:'.$wInfo->wholesaler_email_template.".html");
    $subject = $smarty->fetch('db:'.$wInfo->wholesaler_email_template.".subject");
    if($subject == '') $subject = EMAIL_SUBJECT_WHOLESALER;
    
    if (SEND_EMAILS == true && $sendorder == true) {
      xtc_php_mail( EMAIL_SUPPORT_ADDRESS,                                //  $from_email_address,        
                    EMAIL_SUPPORT_NAME,                                   //  $from_email_name,           
                    $wInfo->wholesaler_email,                             //  $to_email_address,          
                    $wInfo->wholesaler_name,                                //  $to_name,                   
                    '',                                                   //  $forwarding_to,             
                    EMAIL_SUPPORT_REPLY_ADDRESS,                          //  $reply_address,             
                    EMAIL_SUPPORT_REPLY_ADDRESS_NAME,                //  $reply_address_name,        
                    '',                                                   //  $path_to_attachement,       
                    '',                                                   //  $name_of_attachment, 
                    $subject,                        //  $email_subject,             
                    $html_mail,                                           //  $message_body_html,         
                    '' );                                                 //  $message_body_plain
     
	  $message_stack = "Bestellung erfolgreich abgeschickt!";
	  
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
<?php
if (isset($message_stack) && !empty($message_stack)) {
	echo '<div class="alert alert-success" role="alert">'.$message_stack.'</div>';
}
?>
<div class='row'>
            <div class="pageHeading col-xs-12">
            <?php 
            echo '<p class="h2">'.WHOLESALER_DETAILS.'</p>'; 
            echo WHOLESALER_NAME.' '.$wInfo->wholesaler_name.'<br>'; 
            echo WHOLESALER_EMAIL.' '.$wInfo->wholesaler_email.'<br>';
            echo WHOLESALER_TEMPLATE.' '.$wInfo->wholesaler_email_template.'<br>';
            
			?>
            </div>
            
        <div class='col-xs-12'><br></div>
        <div class='col-xs-12'>
            <div id='responsive_table' class='table-responsive pull-left col-sm-12'>
			<?php
				echo xtc_draw_form('wholesaler_order', FILENAME_WHOLESALER_LIST,  'page=' . $_GET['page'] . '&action=send&wID=' . $wInfo->wholesaler_id, 'post', 'enctype="multipart/form-data"');
			?>
            <table class="table table-striped">
				<thead>
					<tr>
					  <th><?php echo WHOLESALER_PRODUCTS_NAME; ?></th>
					  <th><?php echo WHOLESALER_PRODUCTS_QUANTITY; ?></th>
					  <th><?php echo WHOLESALER_PRODUCTS_REORDER; ?></th>
					  <th><?php echo WHOLESALER_PRODUCTS_ORDER; ?></th>
					</tr>
				</thead>
				<tbody>
				<?php
				  foreach($wInfo->products as $key => $product ) {      
				?>
				  <tr>
					  <td><?php echo $product['products_name']; ?></td>
					  <td><?php echo $product['products_quantity']; ?></td>
					  <td><?php echo $product['wholesaler_reorder']; ?></td>
					  <td><?php echo xtc_draw_input_field('quantity['.$product['products_id'].']'); ?></td>
				  </tr>
				<?php
				  }
				  ?>
				</tbody>
				</table>
            
			<div class='col-xs-12'>
                <?php echo xtc_button(BUTTON_SEND_EMAIL, 'submit'); ?>
            </div>
				</form>
    </div>
<?php
  $heading = array();
  $contents = array();
    $product_key = 0;
    if(isset($_GET['pID'])){
        $product_key = $_GET['pID'];
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
