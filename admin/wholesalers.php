<?php
/* --------------------------------------------------------------
   $Id: wholesalers.php 901 2005-04-29 10:32:14Z novalis $   

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

  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $error = array();
      $wholesaler_id = xtc_db_prepare_input($_GET['wID']);
      $wholesaler_name = xtc_db_prepare_input($_POST['wholesaler_name']);
      $wholesaler_email = xtc_db_prepare_input($_POST['wholesaler_email']);
      $wholesaler_file = xtc_db_prepare_input($_POST['wholesaler_email_template']);

      $sql_data_array = array('wholesaler_name' => $wholesaler_name,
                              'wholesaler_email' => $wholesaler_email,             
                              'wholesaler_email_template' => $wholesaler_file);
      
        $url_action = 'new';
        if ($_GET['action'] == 'insert') {
            $check_if_name_exist = xtc_db_find_database_field(TABLE_WHOLESALERS, 'wholesaler_name', $wholesaler_name, 'wholesaler_name');
        } elseif ($_GET['action'] == 'save') {
            $url_action = 'edit';
            $check_if_name_exist = xtc_db_find_database_field(TABLE_WHOLESALERS, 'wholesaler_name', $wholesaler_name);
        }

        
        if(!$wholesaler_name || $check_if_name_exist){
            if($_GET['action'] == 'save'){
                if($check_if_name_exist['wholesaler_id'] != $wholesaler_id){
                    $error[] = ERROR_TEXT_NAME;
                }
            } else {
                $error[] = ERROR_TEXT_NAME;
            }
        }
        
        if(!$wholesaler_email){
            $error[] = ERROR_TEXT_EMAIL;
        } elseif(!xtc_validate_email($wholesaler_email)){
            $error[] = ERROR_TEXT_EMAIL_INVALID;
        }
        
        if(!$wholesaler_file){
            $error[] = ERROR_TEXT_FILE;
        }
      
    if(empty($error)){ 
        if ($_GET['action'] == 'insert') {
            xtc_db_perform(TABLE_WHOLESALERS, $sql_data_array);
            $wholesaler_id = xtc_db_insert_id();
			
			// BOF - Mail Manager Template
			xtc_db_query("INSERT INTO email_manager (em_name, em_language, em_body, em_delete, em_type, em_body_txt) VALUES
('".$wholesaler_file."',	2,	'<p>Sehr geehrte Damen und Herren,</p>\\r\\n<p>wir m&ouml;chten bitte folgende Produkte bei Ihnen Nachbestellen:</p>\\r\\n<p><br />\\r\\n{foreach name=aussen item=order_values from=\$PRODUCTS}{\$order_values.products_quantity} x {\$order_values.products_name}<br />\\r\\n{/foreach}</p>',	0,	'wholesaler',	'Sehr geehrte Damen und Herren,\\r\\n\\r\\nwir möchten bitte folgende Produkte bei Ihnen Nachbestellen\\r\\n\\r\\n{foreach name=aussen item=order_values from=\$PRODUCTS}\\r\\n{\$order_values.products_quantity} x {\$order_values.products_name}\\r\\n{/foreach}');
");
			// EOF - Mail Manager Template
			
        } elseif ($_GET['action'] == 'save') {
              xtc_db_perform(TABLE_WHOLESALERS, $sql_data_array, 'update', "wholesaler_id = '" . xtc_db_input($wholesaler_id) . "'");
        }
    
        if (USE_CACHE == 'true') {
            xtc_reset_cache_block('wholesalers');
        }

        xtc_redirect(xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $wholesaler_id));
      
    } else {
        $_SESSION['repopulate_form'] = $_REQUEST;
        $_SESSION['errors'] = $error;
        xtc_redirect(xtc_href_link(FILENAME_WHOLESALERS, 'page='.$_GET['page'].'&action='.$url_action.'&errors=1&wID=' . $wholesaler_id));
    }
      break;

    case 'deleteconfirm':
      $wholesaler_id = xtc_db_prepare_input($_GET['wID']);

      xtc_db_query("delete from " . TABLE_WHOLESALERS . " where wholesaler_id = '" . xtc_db_input($wholesaler_id) . "'");
      xtc_db_query("update " . TABLE_PRODUCTS . " set wholesaler_id = '' where wholesaler_id = '" . xtc_db_input($wholesaler_id) . "'");
     
      if (USE_CACHE == 'true') {
        xtc_reset_cache_block('wholesalers');
      }

      xtc_redirect(xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page']));
      break;
  }

require (DIR_WS_INCLUDES.'head.php');
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<div class="row">
<!-- body_text //-->
    <div class='col-xs-12'>
        <p class="h2">
            <?php echo HEADING_TITLE; ?>
        </p>
    </div>
<?php include DIR_WS_INCLUDES.FILENAME_ERROR_DISPLAY; ?>
<div class='col-xs-12'><br></div>
<div class='col-xs-12'>
    <div id='responsive_table' class='table-responsive pull-left col-sm-12'>
    <table class="table table-bordered table-striped">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_WHOLESALERS; ?></td>
                <td class="dataTableHeadingContent hidden-xs"><?php echo TABLE_WHOLESALERS_EMAIL; ?></td>
                <td class="dataTableHeadingContent hidden-xs"><?php echo TABLE_WHOLESALERS_FILE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $wholesalers_query_raw = "select wholesaler_id, wholesaler_name, wholesaler_email, wholesaler_email_template from " . TABLE_WHOLESALERS . " order by wholesaler_name";
  $wholesalers_split = new splitPageResults($_GET['page'], '20', $wholesalers_query_raw, $wholesalers_query_numrows);
  $wholesalers_query = xtc_db_query($wholesalers_query_raw);
  while ($wholesalers = xtc_db_fetch_array($wholesalers_query)) {
    if (((!$_GET['wID']) || (@$_GET['wID'] == $wholesalers['wholesaler_id'])) && (!$mInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $wholesaler_products_query = xtc_db_query("select count(*) as products_count from " . TABLE_PRODUCTS . " where wholesaler_id = '" . $wholesalers['wholesaler_id'] . "'");
      $wholesaler_products = xtc_db_fetch_array($wholesaler_products_query);

      $mInfo_array = xtc_array_merge($wholesalers, $wholesaler_products);
      $mInfo = new objectInfo($mInfo_array);
    }

    if ( (is_object($mInfo)) && ($wholesalers['wholesaler_id'] == $mInfo->wholesaler_id) ) {
      echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'pointer\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $wholesalers['wholesaler_id'] . '&action=edit') . '#edit-box\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'pointer\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $wholesalers['wholesaler_id']) . '#edit-box\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $wholesalers['wholesaler_name']; ?></td>
                <td class="dataTableContent hidden-xs"><?php echo $wholesalers['wholesaler_email']; ?></td>
                <td class="dataTableContent hidden-xs"><?php echo $wholesalers['wholesaler_email_template']; ?></td>
<!-- BOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons -->
<!--
                <td class="dataTableContent" align="right"><?php if ( (is_object($mInfo)) && ($wholesalers['wholesaler_id'] == $mInfo->wholesaler_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $wholesalers['wholesaler_id']) . '#edit-box">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
-->
                <td class="dataTableContent" align="right"><?php if ( (is_object($mInfo)) && ($wholesalers['wholesaler_id'] == $mInfo->wholesaler_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ICON_ARROW_RIGHT); } else { echo '<a href="' . xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $wholesalers['wholesaler_id']) . '#edit-box">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
<!-- EOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons -->
              </tr>
<?php
  }
?>
              </table>
                  <div class='col-xs-12'>
                    <div class="smallText col-xs-6"><?php echo $wholesalers_split->display_count($wholesalers_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_WHOLESALERS); ?></div>
                    <div class="smallText col-xs-6 text-right"><?php echo $wholesalers_split->display_links($wholesalers_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
                  </div>
<?php
  if ($_GET['action'] != 'new') {
?>
              <div class='col-xs-12 text-right'>
                <?php echo xtc_button_link(BUTTON_INSERT, xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $mInfo->wholesaler_id . '&action=new')); ?>
              </div>
<?php
  }
?>
    </div>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_WHOLESALER . '</b>');
        
    if(isset($_SESSION['repopulate_form'])){
        $w_name = ($_SESSION['repopulate_form']['wholesaler_name']) ? $_SESSION['repopulate_form']['wholesaler_name'] : '';
        $w_email = ($_SESSION['repopulate_form']['wholesaler_email']) ? $_SESSION['repopulate_form']['wholesaler_email'] : '';
        $w_file = ($_SESSION['repopulate_form']['wholesaler_email_template']) ? $_SESSION['repopulate_form']['wholesaler_email_template'] : '';
        unset($_SESSION['repopulate_form']);
    }
      
      $contents = array('form' => xtc_draw_form('wholesalers', FILENAME_WHOLESALERS, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_WHOLESALERS_NAME . '<br />' . xtc_draw_input_field('wholesaler_name', $w_name));
      $contents[] = array('text' => '<br />' . TEXT_WHOLESALERS_EMAIL . '<br />' . xtc_draw_input_field('wholesaler_email', $w_email));
      $contents[] = array('text' => '<br />' . TEXT_WHOLESALERS_FILE . '<br />' . xtc_draw_input_field('wholesaler_email_template', $w_file)); 
      
      $contents[] = array('align' => 'center', 'text' => '<br />' . xtc_button(BUTTON_SAVE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $_GET['wID'])));
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_WHOLESALER . '</b>');

      $contents = array('form' => xtc_draw_form('wholesalers', FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $mInfo->wholesaler_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_WHOLESALERS_NAME . '<br />' . xtc_draw_input_field('wholesaler_name', $mInfo->wholesaler_name));
      $contents[] = array('text' => '<br />' . TEXT_WHOLESALERS_EMAIL . '<br />' . xtc_draw_input_field('wholesaler_email', $mInfo->wholesaler_email));
      $contents[] = array('text' => '<br />' . TEXT_WHOLESALERS_FILE . '<br />' . xtc_draw_input_field('wholesaler_email_template', $mInfo->wholesaler_email_template)); 

      $contents[] = array('align' => 'center', 'text' => '<br />' . xtc_button(BUTTON_SAVE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $mInfo->wholesaler_id)));
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_WHOLESALER . '</b>');

      $contents = array('form' => xtc_draw_form('wholesalers', FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $mInfo->wholesaler_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $mInfo->wholesaler_name . '</b>');



      $contents[] = array('align' => 'center', 'text' => '<br />' . xtc_button(BUTTON_DELETE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $mInfo->wholesaler_id)));
      break;

    default:
      if (is_object($mInfo)) {
        $heading[] = array('text' => '<b>' . $mInfo->wholesaler_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => xtc_button_link(BUTTON_EDIT, xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $mInfo->wholesaler_id . '&action=edit#edit-box')) . '&nbsp;' . xtc_button_link(BUTTON_DELETE, xtc_href_link(FILENAME_WHOLESALERS, 'page=' . $_GET['page'] . '&wID=' . $mInfo->wholesaler_id . '&action=delete#edit-box')));
        
      }
      break;
  }

  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
    echo '            <div class="col-md-3 col-sm-12 col-xs-12 pull-right edit-box-class" >' . "\n";

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
