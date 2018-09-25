<?php
/* --------------------------------------------------------------
   $Id: indeximages.php 001 2008-07-29 12:19:00Z Hetfield $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(indeximages.php,v 1.52 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (indeximages.php,v 1.9 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once(DIR_FS_INC . 'xtc_wysiwyg.inc.php');

  function xtc_get_indeximages_image($indeximages_id, $language_id) {
          $indeximages_query = xtc_db_query("select indeximages_image from ".TABLE_INDEXIMAGES_INFO." where indeximages_id = '".$indeximages_id."' and languages_id = '".$language_id."'");
          $indeximage = xtc_db_fetch_array($indeximages_query);	
          return $indeximage['indeximages_image'];
  }
  function xtc_get_indeximages_url($indeximages_id, $language_id) {
          $indeximages_query = xtc_db_query("select indeximages_url from ".TABLE_INDEXIMAGES_INFO." where indeximages_id = '".$indeximages_id."' and languages_id = '".$language_id."'");
          $indeximage = xtc_db_fetch_array($indeximages_query);	
          return $indeximage['indeximages_url'];
  }
  function xtc_get_indeximages_url_target($indeximages_id, $language_id) {
          $indeximages_query = xtc_db_query("select indeximages_url_target from ".TABLE_INDEXIMAGES_INFO." where indeximages_id = '".$indeximages_id."' and languages_id = '".$language_id."'");
          $indeximage = xtc_db_fetch_array($indeximages_query);	
          return $indeximage['indeximages_url_target'];
  }
  function xtc_get_indeximage_sorting($indeximage_id) {
          $indeximages_query = xtc_db_query("select sorting from ".TABLE_INDEXIMAGES." where indeximages_id = '".$indeximage_id."'");
          $indeximage = xtc_db_fetch_array($indeximages_query);	
          return $indeximage['sorting'];
  }
  function xtc_get_indeximages_url_type($indeximages_id, $language_id) {
          $indeximages_query = xtc_db_query("select indeximages_url_type from ".TABLE_INDEXIMAGES_INFO." where indeximages_id = '".$indeximages_id."' and languages_id = '".$language_id."'");
          $indeximage = xtc_db_fetch_array($indeximages_query);	
          return $indeximage['indeximages_url_type'];
  }
  function xtc_get_indeximages_title($indeximages_id, $language_id) {
          $indeximages_query = xtc_db_query("select indeximages_title from ".TABLE_INDEXIMAGES_INFO." where indeximages_id = '".$indeximages_id."' and languages_id = '".$language_id."'");
          $indeximage = xtc_db_fetch_array($indeximages_query);	
          return $indeximage['indeximages_title'];
  }

  function xtc_get_indeximages_alt($indeximages_id, $language_id) {
    $indeximages_query = xtc_db_query("select indeximages_alt from ".TABLE_INDEXIMAGES_INFO." where indeximages_id = '".$indeximages_id."' and languages_id = '".$language_id."'");
    $indeximage = xtc_db_fetch_array($indeximages_query); 
    return $indeximage['indeximages_alt'];
  }

  function xtc_get_indeximages_description($indeximages_id, $language_id) {
          $indeximages_query = xtc_db_query("select indeximages_description from ".TABLE_INDEXIMAGES_INFO." where indeximages_id = '".$indeximages_id."' and languages_id = '".$language_id."'");
          $indeximage = xtc_db_fetch_array($indeximages_query);	
          return $indeximage['indeximages_description'];
  }
	
  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $error = array();
      $indeximages_id = xtc_db_prepare_input($_GET['iID']);
      $indeximages_name = xtc_db_prepare_input($_POST['indeximages_name']);	  

      $indeximages_status = xtc_db_prepare_input($_POST['indeximages_status']);
      $indeximages_sorting = xtc_db_prepare_input($_POST['indeximages_sorting']);

      $sql_data_array = array('indeximages_name' => $indeximages_name,
	  						  'status' => $indeximages_status,
							  'sorting' => $indeximages_sorting
	  );

      $url_action = 'new';
        if ($_GET['action'] == 'insert') {
            $check_if_name_exist = xtc_db_find_database_field(TABLE_INDEXIMAGES, 'indeximages_name', $indeximages_name, 'indeximages_name');
        } elseif ($_GET['action'] == 'save') {
            $url_action = 'edit';
            $check_if_name_exist = xtc_db_find_database_field(TABLE_INDEXIMAGES, 'indeximages_name', $indeximages_name);
        }
        
        if(!$indeximages_name || $check_if_name_exist){
            if($_GET['action'] == 'save'){
                if($check_if_name_exist['indeximages_id'] != $indeximages_id){
                    $error[] = ERROR_TEXT_NAME;
                }
            } else {
                $error[] = ERROR_TEXT_NAME;
            }
        }
        
    if(empty($error)){
      if ($_GET['action'] == 'insert') {
        $insert_sql_data = array('date_added' => 'now()');
        $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
        xtc_db_perform(TABLE_INDEXIMAGES, $sql_data_array);
        $indeximages_id = xtc_db_insert_id();
      } elseif ($_GET['action'] == 'save') {
        $update_sql_data = array('last_modified' => 'now()');
        $sql_data_array = xtc_array_merge($sql_data_array, $update_sql_data);
        xtc_db_perform(TABLE_INDEXIMAGES, $sql_data_array, 'update', "indeximages_id = '" . xtc_db_input($indeximages_id) . "'");
      }    

      $languages = xtc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	  	  if ($_POST['indeximages_image_delete'. $i] == true) {
		  	 @unlink(DIR_FS_CATALOG_IMAGES.xtc_get_indeximages_image($indeximages_id, $languages[$i]['id']));
			 $imagepfad = '';
		  }
	  	  if ($image = &xtc_try_upload('indeximages_image'.$i, DIR_FS_CATALOG_IMAGES.'indeximages/'.$languages[$i]['directory'].'/')) {
			 $imagepfad = 'indeximages/'.$languages[$i]['directory'].'/'.$image->filename;
          } else {
		  	 if ($_POST['indeximages_image_delete'. $i] == false) {
			 	$imagepfad = xtc_get_indeximages_image($indeximages_id, $languages[$i]['id']);
			 } 
		  }
		  $indeximages_url_array = $_POST['indeximages_url'];
		  $indeximages_url_target_array = $_POST['indeximages_url_target'];
		  $indeximages_url_type_array = $_POST['indeximages_url_type'];			
		  $indeximages_title_array = $_POST['indeximages_title'];
      $indeximages_alt_array = $_POST['indeximages_alt'];
		  $indeximages_description_array = $_POST['indeximages_description'];
          $language_id = $languages[$i]['id'];
          $sql_data_array = array('indeximages_url' => xtc_db_prepare_input($indeximages_url_array[$language_id]),
		  						'indeximages_url_target' => xtc_db_prepare_input($indeximages_url_target_array[$language_id]),
								  'indeximages_url_type' => xtc_db_prepare_input($indeximages_url_type_array[$language_id]),
								  'indeximages_image' => $imagepfad,
                  'indeximages_title' => xtc_db_prepare_input($indeximages_title_array[$language_id]),
								  'indeximages_alt' => xtc_db_prepare_input($indeximages_alt_array[$language_id]),
								  'indeximages_description' => xtc_db_prepare_input($indeximages_description_array[$language_id]));
	
          if ($_GET['action'] == 'insert') {
            $insert_sql_data = array('indeximages_id' => $indeximages_id,
                                     'languages_id' => $language_id);
            $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
            xtc_db_perform(TABLE_INDEXIMAGES_INFO, $sql_data_array);
          } elseif ($_GET['action'] == 'save') {
            xtc_db_perform(TABLE_INDEXIMAGES_INFO, $sql_data_array, 'update', "indeximages_id = '" . xtc_db_input($indeximages_id) . "' and languages_id = '" . $language_id . "'");
          }
      }

      xtc_redirect(xtc_href_link(FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $indeximages_id));
    } else {
        $_SESSION['repopulate_form'] = $_REQUEST;
        $_SESSION['errors'] = $error;
        xtc_redirect(xtc_href_link(FILENAME_INDEXIMAGES, 'page='.$_GET['page'].'&action='.$url_action.'&errors=1&iID=' . $indeximages_id));
    }
      break;

    case 'deleteconfirm':
      $indeximages_id = xtc_db_prepare_input($_GET['iID']);

      if ($_POST['delete_image'] == 'on') {        
		  $languages = xtc_get_languages();
		  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
		     $image_location = DIR_FS_CATALOG_IMAGES.xtc_get_indeximages_image($indeximages_id, $languages[$i]['id']);
			 if (file_exists($image_location)) {
			 	@unlink($image_location);
			 }
		  }
      }

      xtc_db_query("delete from " . TABLE_INDEXIMAGES . " where indeximages_id = '" . xtc_db_input($indeximages_id) . "'");
      xtc_db_query("delete from " . TABLE_INDEXIMAGES_INFO . " where indeximages_id = '" . xtc_db_input($indeximages_id) . "'");

      xtc_redirect(xtc_href_link(FILENAME_INDEXIMAGES, 'page=' . $_GET['page']));
      break;
	  
	  case 'setflag':
	  	$indeximages_id = xtc_db_prepare_input((int)$_GET['iID']);
		$indeximages_status = xtc_db_prepare_input((int)$_GET['flag']);
	  	xtc_db_query("UPDATE " . TABLE_INDEXIMAGES . " SET status = ".xtc_db_input($indeximages_status)." WHERE indeximages_id = '" . xtc_db_input($indeximages_id) . "'");
	  break;
  }
require (DIR_WS_INCLUDES.'head.php');
?>

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
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
<div class='table-responsive col-xs-12'>
    <div id='responsive_table' class='pull-left col-sm-12'>
    
<?php  
if (($_GET['action'] != 'new') && ($_GET['action'] != 'edit')) {
?>		
            <table class="table table-bordered">		 
			   <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TEXT_HEADING_NEW_INDEXIMAGES; ?></td>
                <td class="dataTableHeadingContent hidden-xs"><?php echo TABLE_HEADING_SORTING; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php  
}
  // $indeximages_query_raw = "select indeximages_id, indeximages_name, status, sorting, date_added, last_modified from " . TABLE_INDEXIMAGES . " order by sorting";
  // BOF - Fishnet Services - Nicolas Gemsjaeger
  // Erweiterung: Categories
  $indeximages_query_raw = "select indeximages_id, indeximages_name, status, sorting, date_added, last_modified from " . TABLE_INDEXIMAGES . " order by sorting";
  // EOF - Fishnet Services - Nicolas Gemsjaeger
  $indeximages_split = new splitPageResults($_GET['page'], '20', $indeximages_query_raw, $indeximages_query_numrows);
  $indeximages_query = xtc_db_query($indeximages_query_raw);
  while ($indeximages = xtc_db_fetch_array($indeximages_query)) {
    if (((!$_GET['iID']) || (@$_GET['iID'] == $indeximages['indeximages_id'])) && (!$iInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      	$iInfo = new objectInfo($indeximages);
	  	$iInfo->indeximages_image = xtc_get_indeximages_image($iInfo->indeximages_id, $language_id);
    }
    if (($_GET['action'] != 'new') && ($_GET['action'] != 'edit')) {
		if ( (is_object($iInfo)) && ($indeximages['indeximages_id'] == $iInfo->indeximages_id) ) {
			echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $indeximages['indeximages_id'] . '&action=edit') . '\'">' . "\n";
		} else {
			echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $indeximages['indeximages_id']) . '\'">' . "\n";
		}
?>
                <td class="dataTableContent"><?php echo $indeximages['indeximages_name']; ?></td>
                <td class="dataTableContent hidden-xs"><?php echo $indeximages['sorting']; ?></td>
                <td class="dataTableContent">
<?php
                if ($indeximages['status'] == '0') {
                     echo xtc_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . xtc_href_link(FILENAME_INDEXIMAGES, 'action=setflag&flag=1&iID=' . $indeximages['indeximages_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
                } else {
                     echo '<a href="' . xtc_href_link(FILENAME_INDEXIMAGES, 'action=setflag&flag=0&iID=' . $indeximages['indeximages_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . xtc_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
                }
?>
                </td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($iInfo)) && ($indeximages['indeximages_id'] == $iInfo->indeximages_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . xtc_href_link(FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $indeximages['indeximages_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
  }
if (($_GET['action'] != 'new') && ($_GET['action'] != 'edit')) {
?>
              </table>
                <div class="col-xs-12">
                  <div class="smallText col-xs-6" ><?php echo $indeximages_split->display_count($indeximages_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_INDEXIMAGES); ?></div>
                  <div class="smallText col-xs-6 text-right" ><?php echo $indeximages_split->display_links($indeximages_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
                </div>
              <div class="col-xs-12 text-right">
                <?php echo xtc_button_link(BUTTON_INSERT, xtc_href_link(FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $iInfo->indeximages_id . '&action=new')); ?>
              </div>
    </div>
<?php 
}
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_INDEXIMAGES . '</b>');

    if(isset($_SESSION['repopulate_form'])){
        $i_name = ($_SESSION['repopulate_form']['indeximages_name']) ? $_SESSION['repopulate_form']['indeximages_name'] : '';
        $i_sort = ($_SESSION['repopulate_form']['indeximages_sorting']) ? $_SESSION['repopulate_form']['indeximages_sorting'] : '';
        $i_url = ($_SESSION['repopulate_form']['indeximages_url']) ? $_SESSION['repopulate_form']['indeximages_url'] : '';
        $i_title = ($_SESSION['repopulate_form']['indeximages_title']) ? $_SESSION['repopulate_form']['indeximages_title'] : '';
        $i_desc = ($_SESSION['repopulate_form']['indeximages_description']) ? $_SESSION['repopulate_form']['indeximages_description'] : '';
        unset($_SESSION['repopulate_form']);
    }

      $contents = array('form' => xtc_draw_form('indeximages', FILENAME_INDEXIMAGES, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => ''.TEXT_NEW_INTRO.'');
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TEXT_INDEXIMAGES_NAME . '</td><td class="infoBoxContent"  valign="top">' . xtc_draw_input_field('indeximages_name', $i_name, 'style="width:99%;"').'</td></tr></table>');
      
      $sorting   = array ();
      $sorting[] = array ('id' => '1', 'text' => SUB_INDEXIMAGE_LEFT); 
      $sorting[] = array ('id' => '3', 'text' => SUB_INDEXIMAGE_RIGHT); 
      $sorting[] = array ('id' => '5', 'text' => SUB_INDEXIMAGE_CENTER); 
      $sorting[] = array ('id' => '2', 'text' => SUB_SUB_INDEXIMAGE_LEFT);
      $sorting[] = array ('id' => '4', 'text' => SUB_SUB_INDEXIMAGE_RIGHT);
      
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TABLE_HEADING_SORTING . '</td><td class="infoBoxContent"  valign="top">' . xtc_draw_pull_down_menu('indeximages_sorting', $sorting).'</td></tr></table>');
      
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TABLE_HEADING_STATUS . ':</td><td class="infoBoxContent"  valign="top">' . xtc_draw_selection_field('indeximages_status', 'radio', '0').ACTIVE.'&nbsp;&nbsp;&nbsp;'.xtc_draw_selection_field('indeximages_status', 'radio', '1').NOTACTIVE.'</td></tr></table>');

      $languages = xtc_get_languages();
	  
	  $indeximages_image_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	    $indeximages_image_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td class="infoBoxContent">' . xtc_draw_file_field('indeximages_image'.$i) . '</td></tr></table>';
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_INDEXIMAGES_IMAGE . '</td></tr></table>' . $indeximages_image_string);
      
	  $indeximages_url_string = '';
	  $url_target_array   = array ();
	  $url_target_array[] = array ('id' => '0', 'text' => NONE_TARGET); 
	  $url_target_array[] = array ('id' => '1', 'text' => TARGET_BLANK); 
	  $url_target_array[] = array ('id' => '2', 'text' => TARGET_TOP); 
	  $url_target_array[] = array ('id' => '3', 'text' => TARGET_SELF); 
	  $url_target_array[] = array ('id' => '4', 'text' => TARGET_PARENT);
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $indeximages_url_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td class="infoBoxContent">' . TEXT_TYP . '<br />'. 
									xtc_draw_selection_field('indeximages_url_type[' . $languages[$i]['id'] . ']', 'radio', '0').TYP_EXTERN.'<br />'.
									xtc_draw_selection_field('indeximages_url_type[' . $languages[$i]['id'] . ']', 'radio', '1').TYP_INTERN.'<br />'.
									xtc_draw_selection_field('indeximages_url_type[' . $languages[$i]['id'] . ']', 'radio', '2').TYP_PRODUCT.'<br />'.
									xtc_draw_selection_field('indeximages_url_type[' . $languages[$i]['id'] . ']', 'radio', '3').TYP_CATEGORIE.'<br />'.
									xtc_draw_selection_field('indeximages_url_type[' . $languages[$i]['id'] . ']', 'radio', '4').TYP_CONTENT.'<br /><br />'.
									TEXT_URL . xtc_draw_input_field('indeximages_url[' . $languages[$i]['id'] . ']', $i_url[$languages[$i]['id']], 'style="width:50%;"') . '&nbsp;' . TEXT_TARGET . '&nbsp;' . xtc_draw_pull_down_menu('indeximages_url_target[' . $languages[$i]['id'] . ']', $url_target_array) . '<br /><br /></td></tr></table>';
	  }      
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_INDEXIMAGES_URL .'</td></tr></table>' . $indeximages_url_string);
			
	  $indeximages_title_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $indeximages_title_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_input_field('indeximages_title[' . $languages[$i]['id'] . ']', $i_title[$languages[$i]['id']], 'style="width:99% !important;"').'</td></tr></table>';
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="30%" valign="top">' . TEXT_INDEXIMAGES_TITLE .'</td></tr></table>' .  $indeximages_title_string);

    $indeximages_alt_string = '';
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $indeximages_alt_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_input_field('indeximages_alt[' . $languages[$i]['id'] . ']', $i_title[$languages[$i]['id']], 'style="width:99% !important;"').'</td></tr></table>';
    }
    $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="30%" valign="top">' . TEXT_INDEXIMAGES_ALT .'</td></tr></table>' .  $indeximages_alt_string);


    $indeximages_description_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $indeximages_description_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_textarea_field('indeximages_description['.$languages[$i]['id'].']', 'soft', '70', '25', $i_desc[$languages[$i]['id']], 'style="width: 99%;"').'</td></tr></table>'; 
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_INDEXIMAGES_DESCRIPTION .'</td></tr></table>' .  $indeximages_description_string);
      
	  $contents[] = array('align' => 'right', 'text' => '<br />' . xtc_button(BUTTON_SAVE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $_GET['iID'])));
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_INDEXIMAGES . '</b>');

      $contents = array('form' => xtc_draw_form('indeximages', FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $iInfo->indeximages_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TEXT_INDEXIMAGES_NAME . '</td><td class="infoBoxContent"  valign="top">' . xtc_draw_input_field('indeximages_name', $iInfo->indeximages_name, 'style="width:99%;"').'</td></tr></table>');
      
      $sorting   = array ();
      $sorting[] = array ('id' => '1', 'text' => SUB_INDEXIMAGE_LEFT); 
      $sorting[] = array ('id' => '5', 'text' => SUB_INDEXIMAGE_RIGHT); 
      $sorting[] = array ('id' => '3', 'text' => SUB_INDEXIMAGE_CENTER); 
      $sorting[] = array ('id' => '2', 'text' => SUB_SUB_INDEXIMAGE_LEFT);
      $sorting[] = array ('id' => '4', 'text' => SUB_SUB_INDEXIMAGE_RIGHT);
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TABLE_HEADING_SORTING . '</td><td class="infoBoxContent"  valign="top">' . xtc_draw_pull_down_menu('indeximages_sorting', $sorting, xtc_get_indeximage_sorting($iInfo->indeximages_id)).'</td></tr></table>');

      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TABLE_HEADING_STATUS . ':</td><td class="infoBoxContent"  valign="top">' . xtc_draw_selection_field('indeximages_status', 'radio', '0',$iInfo->status==0 ? true : false).ACTIVE.'&nbsp;&nbsp;&nbsp;'.xtc_draw_selection_field('indeximages_status', 'radio', '1',$iInfo->status==1 ? true : false).NOTACTIVE.'</td></tr></table>');

      $languages = xtc_get_languages();
      
      $indeximages_image_string = '';
	  $image = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	    $indeximages_image_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td class="infoBoxContent">' . xtc_draw_file_field('indeximages_image'.$i) . '<br />'.  xtc_info_image(xtc_get_indeximages_image($iInfo->indeximages_id, $languages[$i]['id']), $iInfo->indeximages_name) . '<br />' . xtc_draw_selection_field('indeximages_image_delete'. $i, 'checkbox', 'indeximages_image'. $i) .' '. TEXT_HEADING_DELETE_INDEXIMAGES .'</td></tr></table>';
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_INDEXIMAGES_IMAGE . '</td></tr></table>' . $indeximages_image_string);
	
	  $indeximages_url_string = '';
	  $url_target_array   = array ();
	  $url_target_array[] = array ('id' => '0', 'text' => NONE_TARGET); 
	  $url_target_array[] = array ('id' => '1', 'text' => TARGET_BLANK); 
	  $url_target_array[] = array ('id' => '2', 'text' => TARGET_TOP); 
	  $url_target_array[] = array ('id' => '3', 'text' => TARGET_SELF); 
	  $url_target_array[] = array ('id' => '4', 'text' => TARGET_PARENT);
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $indeximages_url_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td class="infoBoxContent">' . TEXT_TYP . '<br />'. 
									xtc_draw_selection_field('indeximages_url_type[' . $languages[$i]['id'] . ']', 'radio', '0',xtc_get_indeximages_url_type($iInfo->indeximages_id, $languages[$i]['id'])==0 ? true : false).TYP_EXTERN.'<br />'.
									xtc_draw_selection_field('indeximages_url_type[' . $languages[$i]['id'] . ']', 'radio', '1',xtc_get_indeximages_url_type($iInfo->indeximages_id, $languages[$i]['id'])==1 ? true : false).TYP_INTERN.'<br />'.
									xtc_draw_selection_field('indeximages_url_type[' . $languages[$i]['id'] . ']', 'radio', '2',xtc_get_indeximages_url_type($iInfo->indeximages_id, $languages[$i]['id'])==2 ? true : false).TYP_PRODUCT.'<br />'.
									xtc_draw_selection_field('indeximages_url_type[' . $languages[$i]['id'] . ']', 'radio', '3',xtc_get_indeximages_url_type($iInfo->indeximages_id, $languages[$i]['id'])==3 ? true : false).TYP_CATEGORIE.'<br />'.
									xtc_draw_selection_field('indeximages_url_type[' . $languages[$i]['id'] . ']', 'radio', '4',xtc_get_indeximages_url_type($iInfo->indeximages_id, $languages[$i]['id'])==4 ? true : false).TYP_CONTENT.'<br /><br />'.
									TEXT_URL . xtc_draw_input_field('indeximages_url[' . $languages[$i]['id'] . ']', xtc_get_indeximages_url($iInfo->indeximages_id, $languages[$i]['id']), 'style="width:50%;"') . '&nbsp;' . TEXT_TARGET . '&nbsp;' . xtc_draw_pull_down_menu('indeximages_url_target[' . $languages[$i]['id'] . ']', $url_target_array, xtc_get_indeximages_url_target($iInfo->indeximages_id, $languages[$i]['id'])) . '<br /><br /></td></tr></table>';
	  }      
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_INDEXIMAGES_URL .'</td></tr></table>' . $indeximages_url_string);
	
	  $indeximages_title_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $indeximages_title_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_input_field('indeximages_title[' . $languages[$i]['id'] . ']', xtc_get_indeximages_title($iInfo->indeximages_id, $languages[$i]['id']), 'style="width:99% !important;"').'</td></tr></table>';
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_INDEXIMAGES_TITLE .'</td></tr></table>' . $indeximages_title_string);
		
    $indeximages_alt_string = '';
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $indeximages_alt_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_input_field('indeximages_alt[' . $languages[$i]['id'] . ']', xtc_get_indeximages_alt($iInfo->indeximages_id, $languages[$i]['id']), 'style="width:99% !important;"').'</td></tr></table>';
    }
    $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_INDEXIMAGES_ALT .'</td></tr></table>' . $indeximages_alt_string);

	  $indeximages_description_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $indeximages_description_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_textarea_field('indeximages_description['.$languages[$i]['id'].']','soft','70','25',(($indeximages_description[$languages[$i]['id']]) ? stripslashes($indeximages_description[$languages[$i]['id']]) : xtc_get_indeximages_description($iInfo->indeximages_id, $languages[$i]['id'])), 'style="width:99%;"').'</td></tr></table>'; 
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_INDEXIMAGES_DESCRIPTION .'</td></tr></table>' . $indeximages_description_string);
			
      $contents[] = array('align' => 'right', 'text' => '<br />' . xtc_button(BUTTON_SAVE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $iInfo->indeximages_id)));
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_INDEXIMAGES . '</b>');

      $contents = array('form' => xtc_draw_form('indeximages', FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $iInfo->indeximages_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $iInfo->indeximages_name . '</b>');
      $contents[] = array('text' => '<br />' . xtc_draw_checkbox_field('delete_image', '', true) . ' ' . TEXT_DELETE_IMAGE);
	  $contents[] = array('align' => 'left', 'text' => '<br />' . xtc_button(BUTTON_DELETE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $iInfo->indeximages_id)));
      break;

    default:
      if (is_object($iInfo)) {
        $heading[] = array('text' => '<b>' . $iInfo->indeximages_name . '</b>');

        $contents[] = array('align' => 'left', 'text' => xtc_button_link(BUTTON_EDIT, xtc_href_link(FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $iInfo->indeximages_id . '&action=edit')) . '&nbsp;' . xtc_button_link(BUTTON_DELETE, xtc_href_link(FILENAME_INDEXIMAGES, 'page=' . $_GET['page'] . '&iID=' . $iInfo->indeximages_id . '&action=delete')));
        $contents[] = array('text' => '<br />' . TEXT_DATE_ADDED . ' ' . xtc_date_short($iInfo->date_added));
        if (xtc_not_null($iInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . xtc_date_short($iInfo->last_modified));
        $contents[] = array('text' => '<br />' . xtc_get_indeximages_image($iInfo->indeximages_id, $languages[$i]['id']));
      }
      break;
  }

  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
	
	  //if ($_GET['action'] == 'new' || $_GET['action'] == 'edit') {	
      echo '           </tr><tr><td valign="top">' . "\n";
		//} else {
		//  echo '           <td width="25%" valign="top">' . "\n";
		//}

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
</div>
</div>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
<?php
if (USE_WYSIWYG == 'true') {
	$query = xtc_db_query("SELECT code FROM ".TABLE_LANGUAGES." WHERE languages_id='".$_SESSION['languages_id']."'");
	$data = xtc_db_fetch_array($query);
	$languages = xtc_get_languages();
?>
<script type="text/javascript" src="includes/modules/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	window.onload = function()
		{<?php
	// generate editor for categories
	if ($_GET['action'] == 'new' || $_GET['action'] == 'edit') {
		for ($i = 0; $i < sizeof($languages); $i ++) {
			echo xtc_wysiwyg('indeximages_description', $data['code'], $languages[$i]['id']);
		}
	}
?>}
</script><?php
}
?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
