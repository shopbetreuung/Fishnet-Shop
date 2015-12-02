<?php
/* --------------------------------------------------------------
   $Id: zones.php 1123 2005-07-27 09:00:31Z novalis $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(zones.php,v 1.21 2002/03/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (zones.php,v 1.8 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'insert':
        $error = array();
        $zone_country_id = xtc_db_prepare_input($_POST['zone_country_id']);
        $zone_code = xtc_db_prepare_input($_POST['zone_code']);
        $zone_name = xtc_db_prepare_input($_POST['zone_name']);

        $check_if_name_exist = xtc_db_find_by_multiple(TABLE_ZONES, 
                array(array('column' => 'zone_name', 'value' => $zone_name), array('column' => 'zone_country_id', 'value' => $zone_country_id)), 
                'zone_name');
        if(!$zone_name || $check_if_name_exist){
                $error[] = ERROR_TEXT_NAME;
        }
        
        $check_if_code_exist = xtc_db_find_database_field(TABLE_ZONES, 'zone_code', $zone_code, 'zone_code');
        if(!$zone_code || $check_if_code_exist){
                $error[] = ERROR_TEXT_CODE;
        }
        
        if(empty($error)){ 
        xtc_db_query("insert into " . TABLE_ZONES . " (zone_country_id, zone_code, zone_name) values ('" . xtc_db_input($zone_country_id) . "', '" . xtc_db_input($zone_code) . "', '" . xtc_db_input($zone_name) . "')");
        xtc_redirect(xtc_href_link(FILENAME_ZONES));
        } else {
            $_SESSION['repopulate_form'] = $_REQUEST;
            $_SESSION['errors'] = $error;
            xtc_redirect(xtc_href_link(FILENAME_ZONES, 'page='.$_GET['page'].'&action=new&errors=1'));
        }
        break;
      case 'save':
        $error = array();
        $zone_id = xtc_db_prepare_input($_GET['cID']);
        $zone_country_id = xtc_db_prepare_input($_POST['zone_country_id']);
        $zone_code = xtc_db_prepare_input($_POST['zone_code']);
        $zone_name = xtc_db_prepare_input($_POST['zone_name']);

        $check_if_name_exist = xtc_db_find_by_multiple(TABLE_ZONES, 
                array(array('column' => 'zone_name', 'value' => $zone_name), array('column' => 'zone_country_id', 'value' => $zone_country_id)), 
                'zone_id, zone_name');

        if(!$zone_name || $check_if_name_exist){
            if($check_if_name_exist['zone_id'] != $zone_id){
                $error[] = ERROR_TEXT_NAME;
            }
        }
        
        $check_if_code_exist = xtc_db_find_database_field(TABLE_ZONES, 'zone_code', $zone_code);
        
        if(!$zone_code || $check_if_code_exist){
            if($check_if_code_exist['zone_id'] != $zone_id){
                $error[] = ERROR_TEXT_CODE;
            }
        }
        
        if(empty($error)){ 
        xtc_db_query("update " . TABLE_ZONES . " set zone_country_id = '" . xtc_db_input($zone_country_id) . "', zone_code = '" . xtc_db_input($zone_code) . "', zone_name = '" . xtc_db_input($zone_name) . "' where zone_id = '" . xtc_db_input($zone_id) . "'");
        xtc_redirect(xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $zone_id));
        } else {
            $_SESSION['repopulate_form'] = $_REQUEST;
            $_SESSION['errors'] = $error;
            xtc_redirect(xtc_href_link(FILENAME_ZONES, 'page='.$_GET['page'].'&action=edit&errors=1&cID=' . $zone_id));
        }
        break;
      case 'deleteconfirm':
        $zone_id = xtc_db_prepare_input($_GET['cID']);

        xtc_db_query("delete from " . TABLE_ZONES . " where zone_id = '" . xtc_db_input($zone_id) . "'");
        xtc_redirect(xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page']));
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
            <?php echo HEADING_TITLE; ?>
        </p>
        Configuration
    </div>
<?php include DIR_WS_INCLUDES.FILENAME_ERROR_DISPLAY; ?>
<div class='col-xs-12'><br></div>
<div class='col-xs-12'>
    <div id='responsive_table' class='table-responsive pull-left col-sm-12'>
    <table class="table table-bordered table-striped">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_COUNTRY_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ZONE_NAME; ?></td>
                <td class="dataTableHeadingContent hidden-xs" align="center"><?php echo TABLE_HEADING_ZONE_CODE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $zones_query_raw = "select z.zone_id, c.countries_id, c.countries_name, z.zone_name, z.zone_code, z.zone_country_id from " . TABLE_ZONES . " z, " . TABLE_COUNTRIES . " c where z.zone_country_id = c.countries_id order by c.countries_name, z.zone_name";
  $zones_split = new splitPageResults($_GET['page'], '20', $zones_query_raw, $zones_query_numrows);
  $zones_query = xtc_db_query($zones_query_raw);
  while ($zones = xtc_db_fetch_array($zones_query)) {
    if (((!$_GET['cID']) || (@$_GET['cID'] == $zones['zone_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $cInfo = new objectInfo($zones);
    }

    if ( (is_object($cInfo)) && ($zones['zone_id'] == $cInfo->zone_id) ) {
      echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'pointer\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id . '&action=edit') . '#edit-box\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'pointer\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $zones['zone_id']) . '#edit-box\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $zones['countries_name']; ?></td>
                <td class="dataTableContent"><?php echo $zones['zone_name']; ?></td>
                <td class="dataTableContent hidden-xs" align="center"><?php echo $zones['zone_code']; ?></td>
<!-- BOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons -->
<!--
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($zones['zone_id'] == $cInfo->zone_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $zones['zone_id']) . '#edit-box">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
-->
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($zones['zone_id'] == $cInfo->zone_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ICON_ARROW_RIGHT); } else { echo '<a href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $zones['zone_id']) . '#edit-box">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
<!-- EOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons -->
              </tr>
<?php
  }
?>
                </table>
                  <div class='col-xs-12'>
                    <div class="smallText" valign="top"><?php echo $zones_split->display_count($zones_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ZONES); ?></div>
                    <div class="smallText" align="right"><?php echo $zones_split->display_links($zones_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
                  </div>
<?php
  if (!$_GET['action']) {
?>
                  <div class='col-xs-12 text-right'>
                    <?php echo '<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&action=new') . '">' . BUTTON_NEW_ZONE . '</a>'; ?>
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
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_ZONE . '</b>');

    if(isset($_SESSION['repopulate_form'])){
        $z_name = ($_SESSION['repopulate_form']['zone_name']) ? $_SESSION['repopulate_form']['zone_name'] : '';
        $z_code = ($_SESSION['repopulate_form']['zone_code']) ? $_SESSION['repopulate_form']['zone_code'] : '';
        unset($_SESSION['repopulate_form']);
    }
        
      $contents = array('form' => xtc_draw_form('zones', FILENAME_ZONES, 'page=' . $_GET['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_INFO_ZONES_NAME . '<br />' . xtc_draw_input_field('zone_name', $z_name));
      $contents[] = array('text' => '<br />' . TEXT_INFO_ZONES_CODE . '<br />' . xtc_draw_input_field('zone_code', $z_code));
      $contents[] = array('text' => '<br />' . TEXT_INFO_COUNTRY_NAME . '<br />' . xtc_draw_pull_down_menu('zone_country_id', xtc_get_countries()));
      $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_INSERT . '"/>&nbsp;<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page']) . '">' . BUTTON_CANCEL . '</a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_ZONE . '</b>');

      $contents = array('form' => xtc_draw_form('zones', FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_INFO_ZONES_NAME . '<br />' . xtc_draw_input_field('zone_name', $cInfo->zone_name));
      $contents[] = array('text' => '<br />' . TEXT_INFO_ZONES_CODE . '<br />' . xtc_draw_input_field('zone_code', $cInfo->zone_code));
      $contents[] = array('text' => '<br />' . TEXT_INFO_COUNTRY_NAME . '<br />' . xtc_draw_pull_down_menu('zone_country_id', xtc_get_countries(), $cInfo->countries_id));
      $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_UPDATE . '"/>&nbsp;<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id) . '">' . BUTTON_CANCEL . '</a>');
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ZONE . '</b>');

      $contents = array('form' => xtc_draw_form('zones', FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $cInfo->zone_name . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_DELETE . '"/>&nbsp;<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id) . '">' . BUTTON_CANCEL . '</a>');
      break;
    default:
      if (is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . $cInfo->zone_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id . '&action=edit') . '#edit-box">' . BUTTON_EDIT . '</a> <a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id . '&action=delete') . '#edit-box">' . BUTTON_DELETE . '</a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_ZONES_NAME . '<br />' . $cInfo->zone_name . ' (' . $cInfo->zone_code . ')');
        $contents[] = array('text' => '<br />' . TEXT_INFO_COUNTRY_NAME . ' ' . $cInfo->countries_name);
      }
      break;
  }

  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
    echo '<div class="col-md-3 col-sm-12 col-xs-12 pull-right edit-box-class">' . "\n";
    $box = new box;
    echo $box->infoBox($heading, $contents);
    echo '</div>' . "\n";
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