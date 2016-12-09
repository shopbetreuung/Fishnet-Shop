<?php
/* --------------------------------------------------------------
   $Id: orders_status.php 1497 2010-11-15 18:06:58Z dokuman $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders_status.php,v 1.19 2003/02/06); www.oscommerce.com
   (c) 2003	nextcommerce (orders_status.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2006 XT-Commerce (orders_status.php 1125 2005-07-28)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (xtc_not_null($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        $error = array();
        if (isset($_GET['oID'])) $orders_status_id = xtc_db_prepare_input($_GET['oID']);

        $languages = xtc_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $orders_status_name_array = $_POST['orders_status_name'];
          $language_id = $languages[$i]['id'];

            $check_if_name_exist = xtc_db_find_database_field_by_language(TABLE_ORDERS_STATUS, 'orders_status_name', $orders_status_name_array[$language_id], $language_id, 'language_id');

            if(!$orders_status_name_array[$language_id] || $check_if_name_exist){
                $url_action = 'edit';
                if($_GET['action'] == 'save'){
                    if($check_if_name_exist['orders_status_id'] != $orders_status_id){
                        $error[] = ERROR_TEXT_NAME;
                    }
                } else {
                    $url_action = 'new';
                    $error[] = ERROR_TEXT_NAME;
                }
            }
        }
        
        if(empty($error)){
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
            $orders_status_name_array = $_POST['orders_status_name'];
            $language_id = $languages[$i]['id'];

          $sql_data_array = array('orders_status_name' => xtc_db_prepare_input($orders_status_name_array[$language_id]),
								  'pdfbill_send' => ($_POST['pdfbill_send'] == 'on')?'1':'0');

          if ($action == 'insert') {
            if (!xtc_not_null($orders_status_id)) {
              $next_id_query = xtc_db_query("select max(orders_status_id) as orders_status_id from " . TABLE_ORDERS_STATUS . "");
              $next_id = xtc_db_fetch_array($next_id_query);
              $orders_status_id = $next_id['orders_status_id'] + 1;
            }

            $insert_sql_data = array('orders_status_id' => $orders_status_id,
                                     'language_id' => $language_id);
            $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
            xtc_db_perform(TABLE_ORDERS_STATUS, $sql_data_array);
          } elseif ($action == 'save') {
        //BOF - web28 - 2010-07-11 - BUGFIX no entry stored for previous deactivated languages
        $orders_status_query = xtc_db_query("select * from ".TABLE_ORDERS_STATUS." where language_id = '".(int)$language_id."' and orders_status_id = '".(int)$orders_status_id."'");
        if (xtc_db_num_rows($orders_status_query) == 0) xtc_db_perform(TABLE_ORDERS_STATUS, array ('orders_status_id' => (int)$orders_status_id, 'language_id' => (int)$language_id));
        //EOF - web28 - 2010-07-11 - BUGFIX no entry stored for previous deactivated languages
        xtc_db_perform(TABLE_ORDERS_STATUS, $sql_data_array, 'update', "orders_status_id = '" . (int)$orders_status_id . "' and language_id = '" . (int)$language_id . "'");
          }
        }

        if (isset($_POST['default']) && ($_POST['default'] == 'on')) {
          xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . xtc_db_input($orders_status_id) . "' where configuration_key = 'DEFAULT_ORDERS_STATUS_ID'");
        }
        xtc_redirect(xtc_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $orders_status_id));
		
        } else {
            $_SESSION['repopulate_form'] = $_REQUEST;
            $_SESSION['errors'] = $error;
            xtc_redirect(xtc_href_link(FILENAME_ORDERS_STATUS, 'page='.$_GET['page'].'&action='.$url_action.'&errors=1&oID=' . $orders_status_id));
        }
        break;
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
<div class="row">
<!-- body_text //-->
    <div class='col-xs-12'>
        <p class="h2">
            <?php echo BOX_ORDERS_STATUS; ?>
        </p>
        Configuration
    </div>
<?php include DIR_WS_INCLUDES.FILENAME_ERROR_DISPLAY; ?>
<div class='col-xs-12'><br></div>
<div class='col-xs-12'>
    <div id='responsive_table' class='table-responsive pull-left col-sm-12'>
    <table class="table table-bordered table-striped">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ORDERS_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $orders_status_query_raw = "select orders_status_id, orders_status_name, pdfbill_send from " . TABLE_ORDERS_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "' order by orders_status_id";
  $orders_status_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $orders_status_query_raw, $orders_status_query_numrows);
  $orders_status_query = xtc_db_query($orders_status_query_raw);
  while ($orders_status = xtc_db_fetch_array($orders_status_query)) {
    if ((!isset($_GET['oID']) || (isset($_GET['oID']) && ($_GET['oID'] == $orders_status['orders_status_id']))) && !isset($oInfo) && (substr($action, 0, 3) != 'new')) {
      $oInfo = new objectInfo($orders_status);
    }

    if (isset($oInfo) && is_object($oInfo) && ($orders_status['orders_status_id'] == $oInfo->orders_status_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'pointer\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id . '&action=edit') . '#edit-box\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'pointer\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $orders_status['orders_status_id']) . '#edit-box\'">' . "\n";
    }

    if (DEFAULT_ORDERS_STATUS_ID == $orders_status['orders_status_id']) {
      echo '                <td class="dataTableContent"><b>' . $orders_status['orders_status_name'] . ' (' . TEXT_DEFAULT . ')</b></td>' . "\n";
    } else {
      echo '                <td class="dataTableContent">' . $orders_status['orders_status_name'] . '</td>' . "\n";
    }
?>
<?php /*<!-- BOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons -->
                <td class="dataTableContent" align="right"><?php if ( (is_object($oInfo)) && ($orders_status['orders_status_id'] == $oInfo->orders_status_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . xtc_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $orders_status['orders_status_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
*/ ?>
                <td class="dataTableContent" align="right"><?php if (isset($oInfo) && is_object($oInfo) && ($orders_status['orders_status_id'] == $oInfo->orders_status_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ICON_ARROW_RIGHT); } else { echo '<a href="' . xtc_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $orders_status['orders_status_id']) . '#edit-box">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
<?php /*<!-- EOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons --> */ ?>
              </tr>
<?php
  }
?>
              </table>
                  <div class="col-xs-12">
                    <div class="col-xs-6 smallText" ><?php echo $orders_status_split->display_count($orders_status_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS); ?></div>
                    <div class="smallText col-xs-6 text-right" ><?php echo $orders_status_split->display_links($orders_status_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
                  </div>
<?php
  if (empty($action)) {
?>
                  <div class="text-right col-xs-12">
                    <?php echo '<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&action=new') . '">' . BUTTON_INSERT . '</a>'; ?>
                  </div>
<?php
  }
?>
    </div>
<?php
  $heading = array();
  $contents = array();
  switch ($action) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_ORDERS_STATUS . '</b>');

    if(isset($_SESSION['repopulate_form'])){
        $os_name = ($_SESSION['repopulate_form']['orders_status_name']) ? $_SESSION['repopulate_form']['orders_status_name'] : '';
        unset($_SESSION['repopulate_form']);
    }

      $contents = array('form' => xtc_draw_form('status', FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);

      $orders_status_inputs_string = '';
      $languages = xtc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $orders_status_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . '&nbsp;' . xtc_draw_input_field('orders_status_name[' . $languages[$i]['id'] . ']', $os_name[$languages[$i]['id']]);
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_ORDERS_STATUS_NAME . $orders_status_inputs_string);
	  
	  $contents[] = array('text' => '<br />' . xtc_draw_checkbox_field('pdfbill_send') . ' ' . TEXT_SET_PDFBILL_SEND);
	  $contents[] = array('text' => '<br />' . xtc_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_INSERT . '"/> <a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page']) . '">' . BUTTON_CANCEL . '</a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_ORDERS_STATUS . '</b>');

      $contents = array('form' => xtc_draw_form('status', FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id  . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);

      $orders_status_inputs_string = '';
      $languages = xtc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $orders_status_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . '&nbsp;' . xtc_draw_input_field('orders_status_name[' . $languages[$i]['id'] . ']', xtc_get_orders_status_name($oInfo->orders_status_id, $languages[$i]['id']));
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_ORDERS_STATUS_NAME . $orders_status_inputs_string);
	  $contents[] = array('text' => '<br />' . xtc_draw_checkbox_field('pdfbill_send', '', ($oInfo->pdfbill_send == '1')?true:false) . ' ' . TEXT_SET_PDFBILL_SEND); // TODO NICO
      if (DEFAULT_ORDERS_STATUS_ID != $oInfo->orders_status_id) $contents[] = array('text' => '<br />' . xtc_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_UPDATE . '"/> <a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id) . '">' . BUTTON_CANCEL . '</a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ORDERS_STATUS . '</b>');

      $contents = array('form' => xtc_draw_form('status', FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $oInfo->orders_status_name . '</b>');
      if ($remove_status) $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_DELETE . '"/> <a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id) . '">' . BUTTON_CANCEL . '</a>');
      break;

    default:
      if (isset($oInfo) && is_object($oInfo)) {
        $heading[] = array('text' => '<b>' . $oInfo->orders_status_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id . '&action=edit') . '#edit-box">' . BUTTON_EDIT . '</a>');

        $orders_status_inputs_string = '';
        $languages = xtc_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $orders_status_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . '&nbsp;' . xtc_get_orders_status_name($oInfo->orders_status_id, $languages[$i]['id']);
        }

        $contents[] = array('text' => $orders_status_inputs_string);
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
</div></div>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>