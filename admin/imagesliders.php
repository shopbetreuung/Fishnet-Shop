<?php
/* --------------------------------------------------------------
   $Id: imagesliders.php 001 2008-07-29 12:19:00Z Hetfield $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(imagesliders.php,v 1.52 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (imagesliders.php,v 1.9 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once(DIR_FS_INC . 'xtc_wysiwyg.inc.php');

	function xtc_get_imageslider_image($imageslider_id, $language_id) {
		$imageslider_query = xtc_db_query("select imagesliders_image from ".TABLE_IMAGESLIDERS_INFO." where imagesliders_id = '".$imageslider_id."' and languages_id = '".$language_id."'");
		$imageslider = xtc_db_fetch_array($imageslider_query);	
		return $imageslider['imagesliders_image'];
	}
	function xtc_get_imageslider_url($imageslider_id, $language_id) {
		$imageslider_query = xtc_db_query("select imagesliders_url from ".TABLE_IMAGESLIDERS_INFO." where imagesliders_id = '".$imageslider_id."' and languages_id = '".$language_id."'");
		$imageslider = xtc_db_fetch_array($imageslider_query);	
		return $imageslider['imagesliders_url'];
	}
	function xtc_get_imageslider_url_target($imageslider_id, $language_id) {
		$imageslider_query = xtc_db_query("select imagesliders_url_target from ".TABLE_IMAGESLIDERS_INFO." where imagesliders_id = '".$imageslider_id."' and languages_id = '".$language_id."'");
		$imageslider = xtc_db_fetch_array($imageslider_query);	
		return $imageslider['imagesliders_url_target'];
	}
	function xtc_get_imageslider_url_typ($imageslider_id, $language_id) {
		$imageslider_query = xtc_db_query("select imagesliders_url_typ from ".TABLE_IMAGESLIDERS_INFO." where imagesliders_id = '".$imageslider_id."' and languages_id = '".$language_id."'");
		$imageslider = xtc_db_fetch_array($imageslider_query);	
		return $imageslider['imagesliders_url_typ'];
	}
	function xtc_get_imageslider_title($imageslider_id, $language_id) {
		$imageslider_query = xtc_db_query("select imagesliders_title from ".TABLE_IMAGESLIDERS_INFO." where imagesliders_id = '".$imageslider_id."' and languages_id = '".$language_id."'");
		$imageslider = xtc_db_fetch_array($imageslider_query);	
		return $imageslider['imagesliders_title'];
	}
	function xtc_get_imageslider_alt($imageslider_id, $language_id) {
		$imageslider_query = xtc_db_query("select imagesliders_alt from ".TABLE_IMAGESLIDERS_INFO." where imagesliders_id = '".$imageslider_id."' and languages_id = '".$language_id."'");
		$imageslider = xtc_db_fetch_array($imageslider_query);	
		return $imageslider['imagesliders_alt'];
	}
	function xtc_get_imageslider_description($imageslider_id, $language_id) {
		$imageslider_query = xtc_db_query("select imagesliders_description from ".TABLE_IMAGESLIDERS_INFO." where imagesliders_id = '".$imageslider_id."' and languages_id = '".$language_id."'");
		$imageslider = xtc_db_fetch_array($imageslider_query);	
		return $imageslider['imagesliders_description'];
	}
	
  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $error = array();
      $imagesliders_id = xtc_db_prepare_input($_GET['iID']);
      $imagesliders_name = xtc_db_prepare_input($_POST['imagesliders_name']);	  
	  // BOF - Fishnet Services - Nicolas Gemsjaeger
	  // Erweiterung: Categories
	  $imagesliders_categories = xtc_db_prepare_input($_POST['imagesliders_categories']);	  
	  // EOF - Fishnet Services - Nicolas Gemsjaeger
	  $imagesliders_status = xtc_db_prepare_input($_POST['imagesliders_status']);
	  $imagesliders_sorting = xtc_db_prepare_input($_POST['imagesliders_sorting']);

      $sql_data_array = array('imagesliders_name' => $imagesliders_name,
							  // BOF - Fishnet Services - Nicolas Gemsjaeger
							  // Erweiterung: Categories
							  'imagesliders_categories' => (!empty($imagesliders_categories))?$imagesliders_categories:"0",
							  // EOF - Fishnet Services - Nicolas Gemsjaeger	  
	  						  'status' => $imagesliders_status,
							  'sorting' => $imagesliders_sorting
	  );

      $url_action = 'new';
        if ($_GET['action'] == 'insert') {
            $check_if_name_exist = xtc_db_find_database_field(TABLE_IMAGESLIDERS, 'imagesliders_name', $imagesliders_name, 'imagesliders_name');
        } elseif ($_GET['action'] == 'save') {
            $url_action = 'edit';
            $check_if_name_exist = xtc_db_find_database_field(TABLE_IMAGESLIDERS, 'imagesliders_name', $imagesliders_name);
        }
        
        if(!$imagesliders_name || $check_if_name_exist){
            if($_GET['action'] == 'save'){
                if($check_if_name_exist['imagesliders_id'] != $imagesliders_id){
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
        xtc_db_perform(TABLE_IMAGESLIDERS, $sql_data_array);
        $imagesliders_id = xtc_db_insert_id();
      } elseif ($_GET['action'] == 'save') {
        $update_sql_data = array('last_modified' => 'now()');
        $sql_data_array = xtc_array_merge($sql_data_array, $update_sql_data);
        xtc_db_perform(TABLE_IMAGESLIDERS, $sql_data_array, 'update', "imagesliders_id = '" . xtc_db_input($imagesliders_id) . "'");
      }    

      $languages = xtc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	  	  if ($_POST['imagesliders_image_delete'. $i] == true) {
		  	 @unlink(DIR_FS_CATALOG_IMAGES.xtc_get_imageslider_image($imagesliders_id, $languages[$i]['id']));
			 $imagepfad = '';
		  }
	  	  if ($image = &xtc_try_upload('imagesliders_image'.$i, DIR_FS_CATALOG_IMAGES.'imagesliders/'.$languages[$i]['directory'].'/')) {
			 $imagepfad = 'imagesliders/'.$languages[$i]['directory'].'/'.$image->filename;
          } else {
		  	 if ($_POST['imagesliders_image_delete'. $i] == false) {
			 	$imagepfad = xtc_get_imageslider_image($imagesliders_id, $languages[$i]['id']);
			 } 
		  }
		  $imagesliders_url_array = $_POST['imagesliders_url'];
		  $imagesliders_url_target_array = $_POST['imagesliders_url_target'];
		  $imagesliders_url_typ_array = $_POST['imagesliders_url_typ'];			
		  $imagesliders_title_array = $_POST['imagesliders_title'];
		  $imagesliders_alt_array = $_POST['imagesliders_alt'];
		  $imagesliders_description_array = $_POST['imagesliders_description'];
          $language_id = $languages[$i]['id'];
          $sql_data_array = array('imagesliders_url' => xtc_db_prepare_input($imagesliders_url_array[$language_id]),
		  						  'imagesliders_url_target' => xtc_db_prepare_input($imagesliders_url_target_array[$language_id]),
								  'imagesliders_url_typ' => xtc_db_prepare_input($imagesliders_url_typ_array[$language_id]),
								  'imagesliders_image' => $imagepfad,
								  'imagesliders_title' => xtc_db_prepare_input($imagesliders_title_array[$language_id]),
								  'imagesliders_alt' => xtc_db_prepare_input($imagesliders_alt_array[$language_id]),
								  'imagesliders_description' => xtc_db_prepare_input($imagesliders_description_array[$language_id]));
	
          if ($_GET['action'] == 'insert') {
            $insert_sql_data = array('imagesliders_id' => $imagesliders_id,
                                     'languages_id' => $language_id);
            $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
            xtc_db_perform(TABLE_IMAGESLIDERS_INFO, $sql_data_array);
          } elseif ($_GET['action'] == 'save') {
            xtc_db_perform(TABLE_IMAGESLIDERS_INFO, $sql_data_array, 'update', "imagesliders_id = '" . xtc_db_input($imagesliders_id) . "' and languages_id = '" . $language_id . "'");
          }
      }

      xtc_redirect(xtc_href_link(FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $imagesliders_id));
    } else {
        $_SESSION['repopulate_form'] = $_REQUEST;
        $_SESSION['errors'] = $error;
        xtc_redirect(xtc_href_link(FILENAME_IMAGESLIDERS, 'page='.$_GET['page'].'&action='.$url_action.'&errors=1&iID=' . $imagesliders_id));
    }
      break;

    case 'deleteconfirm':
      $imagesliders_id = xtc_db_prepare_input($_GET['iID']);

      if ($_POST['delete_image'] == 'on') {        
		  $languages = xtc_get_languages();
		  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
		     $image_location = DIR_FS_CATALOG_IMAGES.xtc_get_imageslider_image($imagesliders_id, $languages[$i]['id']);
			 if (file_exists($image_location)) {
			 	@unlink($image_location);
			 }
		  }
      }

      xtc_db_query("delete from " . TABLE_IMAGESLIDERS . " where imagesliders_id = '" . xtc_db_input($imagesliders_id) . "'");
      xtc_db_query("delete from " . TABLE_IMAGESLIDERS_INFO . " where imagesliders_id = '" . xtc_db_input($imagesliders_id) . "'");

      xtc_redirect(xtc_href_link(FILENAME_IMAGESLIDERS, 'page=' . $_GET['page']));
      break;
	  
	  case 'setflag':
	  	$imagesliders_id = xtc_db_prepare_input((int)$_GET['iID']);
		$imagesliders_status = xtc_db_prepare_input((int)$_GET['flag']);
	  	xtc_db_query("UPDATE " . TABLE_IMAGESLIDERS . " SET status = ".xtc_db_input($imagesliders_status)." WHERE imagesliders_id = '" . xtc_db_input($imagesliders_id) . "'");
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_IMAGESLIDERS; ?></td>
                <td class="dataTableHeadingContent hidden-xs"><?php echo TABLE_HEADING_SORTING; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php  
}
  // $imagesliders_query_raw = "select imagesliders_id, imagesliders_name, status, sorting, date_added, last_modified from " . TABLE_IMAGESLIDERS . " order by sorting";
  // BOF - Fishnet Services - Nicolas Gemsjaeger
  // Erweiterung: Categories
  $imagesliders_query_raw = "select imagesliders_id, imagesliders_name, status, sorting, date_added, last_modified, imagesliders_categories from " . TABLE_IMAGESLIDERS . " order by sorting";
  // EOF - Fishnet Services - Nicolas Gemsjaeger
  $imagesliders_split = new splitPageResults($_GET['page'], '20', $imagesliders_query_raw, $imagesliders_query_numrows);
  $imagesliders_query = xtc_db_query($imagesliders_query_raw);
  while ($imagesliders = xtc_db_fetch_array($imagesliders_query)) {
    if (((!$_GET['iID']) || (@$_GET['iID'] == $imagesliders['imagesliders_id'])) && (!$iInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      	$iInfo = new objectInfo($imagesliders);
	  	$iInfo->imagesliders_image = xtc_get_imageslider_image($iInfo->imagesliders_id, $language_id);
    }
    if (($_GET['action'] != 'new') && ($_GET['action'] != 'edit')) {
		if ( (is_object($iInfo)) && ($imagesliders['imagesliders_id'] == $iInfo->imagesliders_id) ) {
			echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $imagesliders['imagesliders_id'] . '&action=edit') . '\'">' . "\n";
		} else {
			echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $imagesliders['imagesliders_id']) . '\'">' . "\n";
		}
?>
                <td class="dataTableContent"><?php echo $imagesliders['imagesliders_name']; ?></td>
                <td class="dataTableContent hidden-xs"><?php echo $imagesliders['sorting']; ?></td>
                <td class="dataTableContent">
<?php
                if ($imagesliders['status'] == '0') {
                     echo xtc_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . xtc_href_link(FILENAME_IMAGESLIDERS, 'action=setflag&flag=1&iID=' . $imagesliders['imagesliders_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
                } else {
                     echo '<a href="' . xtc_href_link(FILENAME_IMAGESLIDERS, 'action=setflag&flag=0&iID=' . $imagesliders['imagesliders_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . xtc_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
                }
?>
                </td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($iInfo)) && ($imagesliders['imagesliders_id'] == $iInfo->imagesliders_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . xtc_href_link(FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $imagesliders['imagesliders_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
  }
if (($_GET['action'] != 'new') && ($_GET['action'] != 'edit')) {
?>
              </table>
                <div class="col-xs-12">
                  <div class="smallText col-xs-6" ><?php echo $imagesliders_split->display_count($imagesliders_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_IMAGESLIDERS); ?></div>
                  <div class="smallText col-xs-6 text-right" ><?php echo $imagesliders_split->display_links($imagesliders_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
                </div>
              <div class="col-xs-12 text-right">
                <?php echo xtc_button_link(BUTTON_INSERT, xtc_href_link(FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $iInfo->imagesliders_id . '&action=new')); ?>
              </div>
    </div>
<?php 
}
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_IMAGESLIDER . '</b>');

    if(isset($_SESSION['repopulate_form'])){
        $i_name = ($_SESSION['repopulate_form']['imagesliders_name']) ? $_SESSION['repopulate_form']['imagesliders_name'] : '';
        $i_cat = ($_SESSION['repopulate_form']['imagesliders_categories']) ? $_SESSION['repopulate_form']['imagesliders_categories'] : '';
        $i_sort = ($_SESSION['repopulate_form']['imagesliders_sorting']) ? $_SESSION['repopulate_form']['imagesliders_sorting'] : '';
        $i_url = ($_SESSION['repopulate_form']['imagesliders_url']) ? $_SESSION['repopulate_form']['imagesliders_url'] : '';
        $i_title = ($_SESSION['repopulate_form']['imagesliders_title']) ? $_SESSION['repopulate_form']['imagesliders_title'] : '';
		$i_alt = ($_SESSION['repopulate_form']['imagesliders_alt']) ? $_SESSION['repopulate_form']['imagesliders_alt'] : '';
        $i_desc = ($_SESSION['repopulate_form']['imagesliders_description']) ? $_SESSION['repopulate_form']['imagesliders_description'] : '';
        unset($_SESSION['repopulate_form']);
    }

      $contents = array('form' => xtc_draw_form('imagesliders', FILENAME_IMAGESLIDERS, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => ''.TEXT_NEW_INTRO.'');
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TEXT_IMAGESLIDERS_NAME . '</td><td class="infoBoxContent"  valign="top">' . xtc_draw_input_field('imagesliders_name', $i_name, 'style="width:99%;"').'</td></tr></table>');
	  // BOF - Fishnet Services - Nicolas Gemsjaeger
	  // Erweiterung: Categories
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TEXT_CATEGORIES . '</td><td class="infoBoxContent"  valign="top">' . xtc_draw_input_field('imagesliders_categories', $i_cat, 'style="width:99%;"').'</td></tr></table>');
	  // EOF - Fishnet Services - Nicolas Gemsjaeger
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TABLE_HEADING_SORTING . ':</td><td class="infoBoxContent"  valign="top">' . xtc_draw_input_field('imagesliders_sorting', $i_sort, 'style="width:99%;"').'</td></tr></table>');
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TABLE_HEADING_STATUS . ':</td><td class="infoBoxContent"  valign="top">' . xtc_draw_selection_field('imagesliders_status', 'radio', '0').ACTIVE.'&nbsp;&nbsp;&nbsp;'.xtc_draw_selection_field('imagesliders_status', 'radio', '1').NOTACTIVE.'</td></tr></table>');

      $languages = xtc_get_languages();
	  
	  $imageslider_image_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	    $imageslider_image_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td class="infoBoxContent">' . xtc_draw_file_field('imagesliders_image'.$i) . '</td></tr></table>';
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_IMAGESLIDERS_IMAGE . '</td></tr></table>' . $imageslider_image_string);
      
	  $imageslider_url_string = '';
	  $url_target_array   = array ();
	  $url_target_array[] = array ('id' => '0', 'text' => NONE_TARGET); 
	  $url_target_array[] = array ('id' => '1', 'text' => TARGET_BLANK); 
	  $url_target_array[] = array ('id' => '2', 'text' => TARGET_TOP); 
	  $url_target_array[] = array ('id' => '3', 'text' => TARGET_SELF); 
	  $url_target_array[] = array ('id' => '4', 'text' => TARGET_PARENT);
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $imageslider_url_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td class="infoBoxContent">' . TEXT_TYP . '<br />'. 
									xtc_draw_selection_field('imagesliders_url_typ[' . $languages[$i]['id'] . ']', 'radio', '0').TYP_EXTERN.'<br />'.
									xtc_draw_selection_field('imagesliders_url_typ[' . $languages[$i]['id'] . ']', 'radio', '1').TYP_INTERN.'<br />'.
									xtc_draw_selection_field('imagesliders_url_typ[' . $languages[$i]['id'] . ']', 'radio', '2').TYP_PRODUCT.'<br />'.
									xtc_draw_selection_field('imagesliders_url_typ[' . $languages[$i]['id'] . ']', 'radio', '3').TYP_CATEGORIE.'<br />'.
									xtc_draw_selection_field('imagesliders_url_typ[' . $languages[$i]['id'] . ']', 'radio', '4').TYP_CONTENT.'<br /><br />'.
									TEXT_URL . xtc_draw_input_field('imagesliders_url[' . $languages[$i]['id'] . ']', $i_url[$languages[$i]['id']], 'style="width:50%;"') . '&nbsp;' . TEXT_TARGET . '&nbsp;' . xtc_draw_pull_down_menu('imagesliders_url_target[' . $languages[$i]['id'] . ']', $url_target_array) . '<br /><br /></td></tr></table>';
	  }      
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_IMAGESLIDERS_URL .'</td></tr></table>' . $imageslider_url_string);
			
	  $imageslider_title_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $imageslider_title_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_input_field('imagesliders_title[' . $languages[$i]['id'] . ']', $i_title[$languages[$i]['id']], 'style="width:99% !important;"').'</td></tr></table>';
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="30%" valign="top">' . TEXT_IMAGESLIDERS_TITLE .'</td></tr></table>' .  $imageslider_title_string);
		
	  $imageslider_alt_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $imageslider_alt_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_input_field('imagesliders_alt[' . $languages[$i]['id'] . ']', $i_alt[$languages[$i]['id']], 'style="width:99% !important;"').'</td></tr></table>';
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="30%" valign="top">' . TEXT_IMAGESLIDERS_ALT .'</td></tr></table>' .  $imageslider_alt_string);	  
		  
      $imageslider_description_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $imageslider_description_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_textarea_field('imagesliders_description['.$languages[$i]['id'].']', 'soft', '70', '25', $i_desc[$languages[$i]['id']], 'style="width: 99%;"').'</td></tr></table>'; 
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_IMAGESLIDERS_DESCRIPTION .'</td></tr></table>' .  $imageslider_description_string);
      
	  $contents[] = array('align' => 'right', 'text' => '<br />' . xtc_button(BUTTON_SAVE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $_GET['iID'])));
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_IMAGESLIDER . '</b>');

      $contents = array('form' => xtc_draw_form('imagesliders', FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $iInfo->imagesliders_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TEXT_IMAGESLIDERS_NAME . '</td><td class="infoBoxContent"  valign="top">' . xtc_draw_input_field('imagesliders_name', $iInfo->imagesliders_name, 'style="width:99%;"').'</td></tr></table>');
	  // BOF - Fishnet Services - Nicolas Gemsjaeger
	  // Erweiterung: Categories
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TEXT_CATEGORIES . '</td><td class="infoBoxContent"  valign="top">' . xtc_draw_input_field('imagesliders_categories', $iInfo->imagesliders_categories, 'style="width:99%;"').'</td></tr></table>');
	  // EOF - Fishnet Services - Nicolas Gemsjaeger
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TABLE_HEADING_SORTING . ':</td><td class="infoBoxContent"  valign="top">' . xtc_draw_input_field('imagesliders_sorting', $iInfo->sorting, 'style="width:99%;"').'</td></tr></table>');
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="150px" valign="top">' . TABLE_HEADING_STATUS . ':</td><td class="infoBoxContent"  valign="top">' . xtc_draw_selection_field('imagesliders_status', 'radio', '0',$iInfo->status==0 ? true : false).ACTIVE.'&nbsp;&nbsp;&nbsp;'.xtc_draw_selection_field('imagesliders_status', 'radio', '1',$iInfo->status==1 ? true : false).NOTACTIVE.'</td></tr></table>');
	  
	  $languages = xtc_get_languages();
      
      $imageslider_image_string = '';
	  $image = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
	    $imageslider_image_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td class="infoBoxContent">' . xtc_draw_file_field('imagesliders_image'.$i) . '<br />'.  xtc_info_image(xtc_get_imageslider_image($iInfo->imagesliders_id, $languages[$i]['id']), $iInfo->imagesliders_name) . '<br />' . xtc_draw_selection_field('imagesliders_image_delete'. $i, 'checkbox', 'imagesliders_image'. $i) .' '. TEXT_HEADING_DELETE_IMAGESLIDER .'</td></tr></table>';
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_IMAGESLIDERS_IMAGE . '</td></tr></table>' . $imageslider_image_string);
	
	  $imageslider_url_string = '';
	  $url_target_array   = array ();
	  $url_target_array[] = array ('id' => '0', 'text' => NONE_TARGET); 
	  $url_target_array[] = array ('id' => '1', 'text' => TARGET_BLANK); 
	  $url_target_array[] = array ('id' => '2', 'text' => TARGET_TOP); 
	  $url_target_array[] = array ('id' => '3', 'text' => TARGET_SELF); 
	  $url_target_array[] = array ('id' => '4', 'text' => TARGET_PARENT);
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $imageslider_url_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td class="infoBoxContent">' . TEXT_TYP . '<br />'. 
									xtc_draw_selection_field('imagesliders_url_typ[' . $languages[$i]['id'] . ']', 'radio', '0',xtc_get_imageslider_url_typ($iInfo->imagesliders_id, $languages[$i]['id'])==0 ? true : false).TYP_EXTERN.'<br />'.
									xtc_draw_selection_field('imagesliders_url_typ[' . $languages[$i]['id'] . ']', 'radio', '1',xtc_get_imageslider_url_typ($iInfo->imagesliders_id, $languages[$i]['id'])==1 ? true : false).TYP_INTERN.'<br />'.
									xtc_draw_selection_field('imagesliders_url_typ[' . $languages[$i]['id'] . ']', 'radio', '2',xtc_get_imageslider_url_typ($iInfo->imagesliders_id, $languages[$i]['id'])==2 ? true : false).TYP_PRODUCT.'<br />'.
									xtc_draw_selection_field('imagesliders_url_typ[' . $languages[$i]['id'] . ']', 'radio', '3',xtc_get_imageslider_url_typ($iInfo->imagesliders_id, $languages[$i]['id'])==3 ? true : false).TYP_CATEGORIE.'<br />'.
									xtc_draw_selection_field('imagesliders_url_typ[' . $languages[$i]['id'] . ']', 'radio', '4',xtc_get_imageslider_url_typ($iInfo->imagesliders_id, $languages[$i]['id'])==4 ? true : false).TYP_CONTENT.'<br /><br />'.
									TEXT_URL . xtc_draw_input_field('imagesliders_url[' . $languages[$i]['id'] . ']', xtc_get_imageslider_url($iInfo->imagesliders_id, $languages[$i]['id']), 'style="width:50%;"') . '&nbsp;' . TEXT_TARGET . '&nbsp;' . xtc_draw_pull_down_menu('imagesliders_url_target[' . $languages[$i]['id'] . ']', $url_target_array, xtc_get_imageslider_url_target($iInfo->imagesliders_id, $languages[$i]['id'])) . '<br /><br /></td></tr></table>';
	  }      
      $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_IMAGESLIDERS_URL .'</td></tr></table>' . $imageslider_url_string);
	
	  $imageslider_title_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $imageslider_title_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_input_field('imagesliders_title[' . $languages[$i]['id'] . ']', xtc_get_imageslider_title($iInfo->imagesliders_id, $languages[$i]['id']), 'style="width:99%;"').'</td></tr></table>';
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_IMAGESLIDERS_TITLE .'</td></tr></table>' . $imageslider_title_string);
		  
	  $imageslider_alt_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $imageslider_alt_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_input_field('imagesliders_alt[' . $languages[$i]['id'] . ']', xtc_get_imageslider_alt($iInfo->imagesliders_id, $languages[$i]['id']), 'style="width:99%;"').'</td></tr></table>';
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_IMAGESLIDERS_ALT .'</td></tr></table>' . $imageslider_alt_string);	  
			
	  $imageslider_description_string = '';
	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $imageslider_description_string .= '<table width="100%"><tr><td class="infoBoxContent" width="1%" valign="top">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '</td><td>' . xtc_draw_textarea_field('imagesliders_description['.$languages[$i]['id'].']','soft','70','25',(($imageslider_description[$languages[$i]['id']]) ? stripslashes($imageslider_description[$languages[$i]['id']]) : xtc_get_imageslider_description($iInfo->imagesliders_id, $languages[$i]['id'])), 'style="width:99%;"').'</td></tr></table>'; 
	  }
	  $contents[] = array('text' => '<table width="100%"><tr><td class="infoBoxContent" width="100%" valign="top">' . TEXT_IMAGESLIDERS_DESCRIPTION .'</td></tr></table>' . $imageslider_description_string);
			
      $contents[] = array('align' => 'right', 'text' => '<br />' . xtc_button(BUTTON_SAVE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $iInfo->imagesliders_id)));
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_IMAGESLIDER . '</b>');

      $contents = array('form' => xtc_draw_form('imagesliders', FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $iInfo->imagesliders_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $iInfo->imagesliders_name . '</b>');
      $contents[] = array('text' => '<br />' . xtc_draw_checkbox_field('delete_image', '', true) . ' ' . TEXT_DELETE_IMAGE);
	  $contents[] = array('align' => 'left', 'text' => '<br />' . xtc_button(BUTTON_DELETE) . '&nbsp;' . xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $iInfo->imagesliders_id)));
      break;

    default:
      if (is_object($iInfo)) {
        $heading[] = array('text' => '<b>' . $iInfo->imagesliders_name . '</b>');

        $contents[] = array('align' => 'left', 'text' => xtc_button_link(BUTTON_EDIT, xtc_href_link(FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $iInfo->imagesliders_id . '&action=edit')) . '&nbsp;' . xtc_button_link(BUTTON_DELETE, xtc_href_link(FILENAME_IMAGESLIDERS, 'page=' . $_GET['page'] . '&iID=' . $iInfo->imagesliders_id . '&action=delete')));
        $contents[] = array('text' => '<br />' . TEXT_DATE_ADDED . ' ' . xtc_date_short($iInfo->date_added));
        if (xtc_not_null($iInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . xtc_date_short($iInfo->last_modified));
        $contents[] = array('text' => '<br />' . xtc_get_imageslider_image($iInfo->imagesliders_id, $languages[$i]['id']));
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
	// generate editor for imagesliders
	$languages = xtc_get_languages();
?>
<script type="text/javascript" src="includes/modules/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	window.onload = function()
		{<?php
	// generate editor for categories
	if ($_GET['action'] == 'new' || $_GET['action'] == 'edit') {
		for ($i = 0; $i < sizeof($languages); $i ++) {
			echo xtc_wysiwyg('imagesliders_description', $data['code'], $languages[$i]['id']);
		}
	}
?>}
</script><?php
}
?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
