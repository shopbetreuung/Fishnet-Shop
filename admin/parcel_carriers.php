<?php
  /* --------------------------------------------------------------
   $Id$

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $page_parcel = (isset($_GET['page']) ? $_GET['page'] : '');
  
  $number_of_carriers = (defined('TEXT_DISPLAY_NUMBER_OF_CARRIERS')) ? TEXT_DISPLAY_NUMBER_OF_CARRIERS : '';

  if (xtc_not_null($action)) {
    switch ($action) {
      case 'insert':
        $carrier_name = xtc_db_prepare_input($_POST['carrier_name']);
        $carrier_tracking_link = xtc_db_prepare_input($_POST['carrier_tracking_link']);
        $carrier_sort_order = xtc_db_prepare_input($_POST['carrier_sort_order']);
        $date_added = xtc_db_prepare_input($_POST['carrier_date_added']);
        xtc_db_query("insert into " . TABLE_CARRIERS . " (carrier_name, carrier_tracking_link, carrier_sort_order, carrier_date_added) values ('" . xtc_db_input($carrier_name) . "', '" . xtc_db_input($carrier_tracking_link) . "', '" . xtc_db_input($carrier_sort_order) . "', now())");
        xtc_redirect(xtc_href_link(FILENAME_PARCEL_CARRIERS));
        break;

      case 'save':
        $carrier_id = xtc_db_prepare_input($_GET['carrierID']);
        $carrier_name = xtc_db_prepare_input($_POST['carrier_name']);
        $carrier_tracking_link = xtc_db_prepare_input($_POST['carrier_tracking_link']);
        $carrier_sort_order = xtc_db_prepare_input($_POST['carrier_sort_order']);
        $last_modified = xtc_db_prepare_input($_POST['carrier_last_modified']);
        xtc_db_query("update " . TABLE_CARRIERS . " set carrier_id = '" . (int)$carrier_id . "', carrier_name = '" . xtc_db_input($carrier_name) . "', carrier_tracking_link = '" . xtc_db_input($carrier_tracking_link) . "', carrier_sort_order = '" . xtc_db_input($carrier_sort_order) . "', carrier_last_modified = now() where carrier_id = '" . (int)$carrier_id . "'");
        xtc_redirect(xtc_href_link(FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&carrierID=' . $carrier_id));
        break;

      case 'deleteconfirm':
        $carrier_id = xtc_db_prepare_input($_GET['carrierID']);
        xtc_db_query("delete from " . TABLE_CARRIERS . " where carrier_id = '" . (int)$carrier_id . "'");
        xtc_redirect(xtc_href_link(FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel));
        break;
    }
  }


require (DIR_WS_INCLUDES.'head.php');
?>
  <script type="text/javascript" src="includes/general.js"></script>
</head>
<body>
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->
    <!-- body //-->
	
	<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<p class="h2"><?php echo HEADING_TITLE; ?></p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-8 col-lg-9">
			<table class="table table-bordered table-striped"> <!--table-bordered -->
				<thead>
					<tr>
						<th><?php echo TABLE_HEADING_CARRIER_NAME; ?></th>
						<th><?php echo TABLE_HEADING_TRACKING_LINK; ?></th>
						<th><?php echo TABLE_HEADING_SORT_ORDER; ?></th>
						<th><?php echo TABLE_HEADING_ACTION; ?></th>
					</tr>
				</thead>
				<tbody>
                        <?php
                        $carriers_query_raw = "select
                                                     carrier_id,
                                                     carrier_name,
                                                     carrier_tracking_link,
                                                     carrier_sort_order,
                                                     carrier_date_added,
                                                     carrier_last_modified
                                                from " . TABLE_CARRIERS . "
                                            order by carrier_sort_order";
                        $carriers_split = new splitPageResults($page_parcel, MAX_DISPLAY_SEARCH_RESULTS, $carriers_query_raw, $carriers_query_numrows);
                        $carriers_query = xtc_db_query($carriers_query_raw);
                        while ($carriers = xtc_db_fetch_array($carriers_query)) {
                          if ((!isset($_GET['carrierID']) || (isset($_GET['carrierID']) && ($_GET['carrierID'] == $carriers['carrier_id']))) && !isset($carriersInfo) && (substr($action, 0, 3) != 'new')) {
                            $carriersInfo = new objectInfo($carriers);
                          }
                          if (isset($carriersInfo) && is_object($carriersInfo) && ($carriers['carrier_id'] == $carriersInfo->carrier_id) ) {
                            echo '              <tr class="success" onmouseover="this.style.cursor=\'pointer\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&carrierID=' . $carriersInfo->carrier_id . '&action=edit') . '\'">' . "\n";
                          } else {
                            echo'              <tr onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'pointer\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&carrierID=' . $carriers['carrier_id']) . '\'">' . "\n";
                          }
                            ?>
                            <td><?php echo $carriers['carrier_name']; ?></td>
                            <td><?php echo $carriers['carrier_tracking_link']; ?></td>
                            <td><?php echo $carriers['carrier_sort_order']; ?></td>
                            <td><?php if (isset($carriersInfo) && is_object($carriersInfo) && ($carriers['carrier_id'] == $carriersInfo->carrier_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ICON_ARROW_RIGHT); } else { echo '<a href="' . xtc_href_link(FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&carrierID=' . $carriers['carrier_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
                          </tr>
                          <?php
                        }
                        ?>
				</tbody>
			</table>
                            <table border="0" width="100%" cellspacing="0" cellpadding="2">
                              <tr>
                                <td class="smallText" valign="top"><?php echo $carriers_split->display_count($carriers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $page_parcel, $number_of_carriers); ?></td>
                                <td class="smallText" align="right"><?php echo $carriers_split->display_links($carriers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $page_parcel); ?></td>
                              </tr>
                              <?php
                              if (empty($action)) {
                                ?>
                                <tr>
                                  <td colspan="2" align="right"><?php echo '<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&action=new') . '">' . BUTTON_NEW_CARRIER . '</a>'; ?></td>
                                </tr>
                                <?php
                              }
                              ?>
                              <tr>
                                <td colspan="2" class="smallText"><?php echo TEXT_CARRIER_LINK_DESCRIPTION; ?></td>
                              </tr>
                            </table>
		</div>
		<div class="col-sm-4 col-lg-3">
			<?php
			$heading = array();
			$contents = array();
			switch ($action) {
			  case 'new':
				$heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CARRIER . '</b>');
				$contents = array('form' => xtc_draw_form('carrier', FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&action=insert'));
				$contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
				$contents[] = array('text' => '<br />' . TEXT_INFO_CARRIER_NAME . '<br />' . xtc_draw_input_field('carrier_name'));
				$contents[] = array('text' => '<br />' . TEXT_INFO_CARRIER_TRACKING_LINK . '<br />' . xtc_draw_input_field('carrier_tracking_link','','style="width:300px;"'));
				$contents[] = array('text' => '<br />' . TEXT_INFO_CARRIER_SORT_ORDER . '<br />' . xtc_draw_input_field('carrier_sort_order', $carriersInfo->carrier_sort_order));
				$contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_INSERT . '"/>&nbsp;<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel) . '">' . BUTTON_CANCEL . '</a>');
				break;
			  case 'edit':
				$heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CARRIER . '</b>');
				$contents = array('form' => xtc_draw_form('carrier', FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&carrierID=' . $carriersInfo->carrier_id . '&action=save'));
				$contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
				$contents[] = array('text' => '<br />' . TEXT_INFO_CARRIER_NAME . '<br />' . xtc_draw_input_field('carrier_name', $carriersInfo->carrier_name));
				$contents[] = array('text' => '<br />' . TEXT_INFO_CARRIER_TRACKING_LINK . '<br />' . xtc_draw_input_field('carrier_tracking_link', $carriersInfo->carrier_tracking_link,'style="width:300px;"'));
				$contents[] = array('text' => '<br />' . TEXT_INFO_CARRIER_SORT_ORDER . '<br />' . xtc_draw_input_field('carrier_sort_order', $carriersInfo->carrier_sort_order));
				$contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_UPDATE . '"/>&nbsp;<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&carrierID=' . $carriersInfo->carrier_id) . '">' . BUTTON_CANCEL . '</a>');
				break;
			  case 'delete':
				$heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CARRIER . '</b>');
				$contents = array('form' => xtc_draw_form('carrier', FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&carrierID=' . $carriersInfo->carrier_id . '&action=deleteconfirm'));
				$contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
				$contents[] = array('text' => '<br /><b>' . $carriersInfo->carrier_name . '</b>');
				$contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_DELETE . '"/>&nbsp;<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&carrierID=' . $carriersInfo->carrier_id) . '">' . BUTTON_CANCEL . '</a>');
				break;
			  default:
				if (isset($carriersInfo) && is_object($carriersInfo)) {
				  $heading[] = array('text' => '<b>' . $carriersInfo->carrier_name . '</b>');
				  $contents[] = array('align' => 'center', 'text' => '<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&carrierID=' . $carriersInfo->carrier_id . '&action=edit') . '">' . BUTTON_EDIT . '</a> <a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_PARCEL_CARRIERS, 'page=' . $page_parcel . '&carrierID=' . $carriersInfo->carrier_id . '&action=delete') . '">' . BUTTON_DELETE . '</a>');
				  $contents[] = array('text' => '<br />' . TEXT_INFO_DATE_ADDED . ' ' . xtc_date_short($carriersInfo->carrier_date_added));
				  $contents[] = array('text' => '' . TEXT_INFO_LAST_MODIFIED . ' ' . xtc_date_short($carriersInfo->carrier_last_modified));
				  $contents[] = array('text' => '<br />' . TEXT_INFO_CARRIER_NAME . '<br />' . $carriersInfo->carrier_name);
				}
				break;
			}
			if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
			  $box = new box;
			  echo $box->infoBox($heading, $contents); // cYbercOsmOnauT - 2011-02-07 - Changed methods of the classes box and tableBox to static
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