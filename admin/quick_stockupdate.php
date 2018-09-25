<?php
/*Quick Product update - V3.9.4

  ChangeLog:
  v3.9.4 09/24/14 Version by: mr.mc.mauser
  Summary :
  1. Artikelpreis entweder Brutto oder Netto je nachdem was in den shop Optionen eingestellt ist
  2. Fehler mit den Bildern Behoben
  3. Die Möglichkeit Lagerbestand direkt einzugeben
  4. Spanische Sprachdatei von carlosmazagon ergänzt
  
  v3.9.3  08/10/14 Version by: modified eComemrce Shopsoftware
  Summary :
  1. Bugfix, see: http://www.modified-shop.org/forum/index.php?topic=12740.msg278965#msg278965
  2. Code improvement, see: http://www.modified-shop.org/forum/index.php?topic=12740.msg280089#msg280089
  3. Fixed typo: qs_upsate_db -> qs_update_db
  4. Changed $sql2 -> $sql0

  v3.9.2  07/22/14 Version by: sixtyseven multimedia
  Summary : Possibility to change the delivery status - requested by Martin109, Thanks to kgd for the initial approach

  v3.9.1  07/16/14 Version by: sixtyseven multimedia
  Summary : Possibility to sort the output at will - requested by Bonner

  v3.9   07/16/14 Version by: sixtyseven multimedia
  Summary : Several addtitions and bugfixes, settings

  v3.8.1   05/06/09 Version by: Azrin Aris
  Summary :

    1. Add "Title" tag to Category/Manufacture selector to show its category/manufacture id - requested by Jim Hande ;)

  BugFix:
    1. MySQL not updating if manufactures_id is not set when MySQL is configures as 'STRICT' - Fixed by Steve (Jimbob_pooley)

  v3.8   05/05/09 Version by: Azrin Aris
  Summary :
  1. Minor Redesign on UI:
    + added Top/Bottom Action Bar
  2. Added Update/Copy/Move/Delete Function
  3. Added Numeric Input filtering
  4. Added quick_stockupdate.css file for easier table customization

  BugFix:
    - if a value is more than a thousand, using autoupdate will make the price to 1.00 - Fixed

  v3.7   01/25/09 Version by: Azrin Aris
  Summary :
  1. Add Language filter

  v3.6   01/23/09 Version by: Azrin Aris
  Summary :
  1. Remove the need to use /tmp directory
  2. Add Search by Category or By Manufacture

  v3.5   12/16/08 Version by: Azrin Aris
  Summary :
  1. Add Quick Stock Updater Configuration page (Configuration->Quick Stock Updater)
     - Enable/Disable Add to stock option (value entered in 'New Stock' will be added to existing stock - Default = Enable)
     - Enable/Disable Update Process time (Default = Enable)
     - Set Max input character for 'Model' field (Default = 8)
     - Set Max input character for 'Weight' field (Default = 4)
     - Set Max input character for 'New Stock' field (Default = 4)
     - Set Max input character for 'Price' field (Default = 6)
     - Set decimal point for 'Price' field (Default = 2)
  2. SQL installation script for configuration page QuickStock_sql_install.sql is included
  3. SQL uninstallation script for configuration page QuickStock_sql_uninstall.sql is included

  v3.2   12/12/08 Version by: Azrin Aris
  Summary :
  1. Remove Server loading checking
  2. Remove Row-By-Row SQL Update method
  3. Change update method to SQL import method
  4. Add update time display

  v3.1   12/1/08 Version by: Azrin Aris
  Summary :
  1. Added serverload checking to avoid server bogging if items are too many
  2. Added Data changed event to update only changed record(s) to minimize server load
  3. Added Message notification
  4. Added Screen shot ;)
  5. Added MoSoft German Translation - but addition Variable still need translation

  v3.0   12/1/08 Version by: Azrin Aris
  Summary :
  Rewrite the quick_stokupdate.php in admin/include - solved the > 40 items problem (at least on my online store ;)). I've tested on FireFox, please let me know if it works on other browsers.
*/
define('QUICK_VERSION','3.9.3');
//--------------------------------------------------------------------------------------------------------------------------------------------------
//
// additional settings by sixtyseven
//
//--------------------------------------------------------------------------------------------------------------------------------------------------

# Tausendertrennzeichen? yes = Verwenden, no = wie im Rest des Shops
define('QUICK_SETTINGS_SHOW_DECIMAL','no');

# Spalte EAN anzeigen? yes = anzeigen, no = verbergen
define('QUICK_SETTINGS_SHOW_COL_EAN','no');

# Standardsortierung: Erlaubte Werte = 'product_id','products_sort','products_model','products_ean','products_quantity','products_weight','products_price','products_name','products_quantity','products_shippingtime'
define('QUICK_SETTINGS_SORT_COLUMN','products_sort');

# Standardsortierung Reihenfolge: Erlaubte Werte = 'ASC' für aufsteigend,'DESC' für absteigend
define('QUICK_SETTINGS_SORT_ORDER','ASC');

// BOF Auf Lager Direkt bearbeiten by mr.mc.mauser
# Spalte Auf Lager Direkt bearbeiten? yes = Direktbearbeiten, no = über Hinzufügen ändern
define('QUICK_SETTINGS_DIREKT_STOCK','no');
// EOF Auf Lager Direkt bearbeiten by mr.mc.mauser

//--------------------------------------------------------------------------------------------------------------------------------------------------

require('includes/application_top.php');
require(DIR_WS_CLASSES . 'currencies.php');

//--------------------------------------------------------------------------------------------------------------------------------------------------
$languages_list = xtc_quickstock_get_language_list();
if(count($languages_list) > 1){
	define('QUICK_SHOW_LANGSWITCH','yes');
} else {
	define('QUICK_SHOW_LANGSWITCH','no');
}

$shipping_list = xtc_get_shipping_status();


# Temp dir (nicht ändern)
define('QUICK_DIR_TEMP',DIR_FS_CATALOG . 'tmp/');
//--------------------------------------------------------------------------------------------------------------------------------------------------
  //Function to return time in seconds.
  function microtime_float(){
      list($usec, $sec) = explode(" ", microtime());
      return ((float)$usec + (float)$sec);
  }
//--------------------------------------------------------------------------------------------------------------------------------------------------
  //Credit to surfalot (Run SQL Script)
  function qs_db_query($query, $link = 'db_link') {
    global $$link;
    return mysqli_query($$link, $query);
  }
//--------------------------------------------------------------------------------------------------------------------------------------------------
  //Credit to surfalot (Run SQL Script)
  //Modified for Quick Stock Update - 2008-12-12 Azrin Aris
  function qs_update_db_file($qs_file){
    if (file_exists($qs_file)) {
      $fd = fopen($qs_file, 'rb');
      $restore_query = fread($fd, filesize($qs_file));
      fclose($fd);
      qs_update_db($restore_query);
    } else {
      return false;
    }
  }

  function qs_update_db($qs_sql){
    $sql_array = array();
    $sql_length = strlen($qs_sql);
    $pos = strpos($qs_sql, ';');
    for ($i=$pos; $i<$sql_length; $i++) {
      if ($qs_sql[0] == '#' || $qs_sql[0] == '-') {
        $qs_sql = ltrim(substr($qs_sql, strpos($qs_sql, "\n")));
        $sql_length = strlen($qs_sql);
        $i = strpos($qs_sql, ';')-1;
        continue;
      }
      if ($qs_sql[($i+1)] == "\n") {
        for ($j=($i+2); $j<$sql_length; $j++) {
          if (trim($qs_sql[$j]) != '') {
            $next = substr($qs_sql, $j, 6);
            if ($next[0] == '#' || $next[0] == '-') {
// find out where the break position is so we can remove this line (#comment line)
              for ($k=$j; $k<$sql_length; $k++) {
                if ($qs_sql[$k] == "\n") break;
              }
              $query = substr($qs_sql, 0, $i+1);
              $qs_sql = substr($qs_sql, $k);
// join the query before the comment appeared, with the rest of the dump
              $qs_sql = $query . $qs_sql;
              $sql_length = strlen($qs_sql);
              $i = strpos($qs_sql, ';')-1;
              continue 2;
            }
            break;
          }
        }
        if ($next == '') { // get the last insert query
          $next = 'insert';
        }
        if ( (preg_match('/alter /i', $next)) || (preg_match('/update/i', $next)) || (preg_match('/create/i', $next)) || (preg_match('/insert/i', $next)) || (preg_match('/delete/i', $next)) || (preg_match('/drop t/i', $next)) ) {
          $next = '';
          $sql_array[] = substr($qs_sql, 0, $i);
          $qs_sql = ltrim(substr($qs_sql, $i+1));
          $sql_length = strlen($qs_sql);
          $i = strpos($qs_sql, ';')-1;
        }
      }
    }

    for ($i=0; $i<sizeof($sql_array); $i++) {
      if (!qs_db_query($sql_array[$i])) {
        $db_error = mysql_error();
        $i = sizeof($sql_array);
      }
    }
    return true;
  }
//--------------------------------------------------------------------------------------------------------------------------------------------------
  // Function to query Manufacturer List from DB - Added 2008/12/30 Azrin Aris
  function xtc_quickstock_get_manufacturer_list(){
    //get manufacture id and name
    $manufacturers_query = xtc_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
    $manufacturers_array;
    while ($manufacturers = xtc_db_fetch_array($manufacturers_query)) {
      $manufacturers_array[$manufacturers['manufacturers_id']] = $manufacturers['manufacturers_name'];
    }
    return $manufacturers_array;
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------
// Function to create drop down list for manufacturer selection - Added 2009/01/21 Azrin Aris
  function xtc_quickstock_manufacturer_selector($manufacturers_list){
  global $mfg_id;
  $result = '';
  if (is_array($manufacturers_list) == true) {
  	$result = '<select name="mfg_id" onChange="this.form.submit();" title="'. QUICK_MANUFACTURER_ID . $mfg_id.'"><option value=0>--NONE--</option>';
	  reset($manufacturers_list);
	  while (list($key, $value) = each ($manufacturers_list)) {
		if($mfg_id==$key){
		  $result .= '<option value="' . $key . '" selected="selected">' . $value . '</option>';
		} else {
		  $result .= '<option value="' . $key . '">' . $value . '</option>';
		}
	  }
  	$result .= '</select>';
  } else {
	$result = QUICK_NOTAVAILABLE;
  }
  return $result;
  }
//--------------------------------------------------------------------------------------------------------------------------------------------------
  // Function to create drop down list for manufacturer selection - Added 2008/12/30 Azrin Aris
  function xtc_quickstock_manufacturer_selectorEx($manufacturers_list,$cat_id,$default_id){
 $result = '';

 if (is_array($manufacturers_list) == true) {
  $result = '<select name="stock_update[' .$cat_id . '][manufacturer]" onChange="changed(\'stock_update[' . $cat_id . '][changed]\');" title="'. QUICK_MANUFACTURER_ID . $default_id.'"><option value=></option>';
	  reset($manufacturers_list);
	  while (list($key, $value) = each ($manufacturers_list)) {
		if($default_id==$key){
		  $result .= '<option value="' . $key . '" selected="selected">' . $value . '</option>';
		} else {
		  $result .= '<option value="' . $key . '">' . $value . '</option>';
		}
	  }
  	$result .= '</select>';
 } else {
  $result = QUICK_NOTAVAILABLE;
 }
  return $result;
  }
//--------------------------------------------------------------------------------------------------------------------------------------------------
  // Function to query language List from DB - Added 2008/12/30 Azrin Aris
  function xtc_quickstock_get_language_list(){
    //get manufacture id and name
    $languages_query = xtc_db_query("select languages_id, name from " . TABLE_LANGUAGES . " WHERE status > 0 order by sort_order");
    $languages_array;
    while ($languages = xtc_db_fetch_array($languages_query)) {
      $languages_array[$languages['languages_id']] = $languages['name'];
    }
    return $languages_array;
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------
  // Function to create drop down list for language selection - Added 2009/01/21 Azrin Aris
  function xtc_quickstock_language_selector(){
  global $lang_id, $languages_list;

  $result = '<select name="lang_id" onChange="this.form.submit();" class="form-control">';
  reset($languages_list);
  while (list($key, $value) = each ($languages_list)) {
    if($lang_id==$key){
      $result .= '<option value="' . $key . '" selected="selected">' . $value . '</option>';
    } else {
      $result .= '<option value="' . $key . '">' . $value . '</option>';
    }  }
  $result .= '</select>';
  return $result;
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------
  // Function to create drop down list for shipping status selection - Added 2014/07/22 sixtyseven
function xtc_quickstock_shipping_selector($products_id,$shipping_id){
	global $shipping_list;
	$output = '';

	if((int)$products_id > 0 && (int) $shipping_id > 0) {
		$doChange = 'changed(\'stock_update[' . $products_id . '][changed]\');';
		if(count($shipping_list) == 1){
			$output = xtc_get_shipping_status_name($shipping_id).'<input type="hidden" name="stock_update['.$products_id.'][shippingtime]" value="'.$shipping_id.'" />';
		} else {
			$output = '<select name="stock_update['.$products_id.'][shippingtime]" onChange="' . $doChange . '" >';
			foreach ($shipping_list as $status){
				if((int)$status['id'] == (int)$shipping_id){
				  $output .= '<option value="' . $status['id'] . '" selected="selected">' . $status['text'] . '</option>';
				} else {
				  $output .= '<option value="' . $status['id'] . '">' . $status['text'] . '</option>';
				}
			}
			$output .= '</select>';
		}
	} else {
		$output = '--';
	}

	return $output;
}
//--------------------------------------------------------------------------------------------------------------------------------------------------
  // Function to create drop down list for category selection - Added 2008/12/30 Azrin Aris
  function xtc_quickstock_category_selectorEx($cat_id,$default_id,$enabled = true){
    $disabled = $enabled?"":" disabled";
    $select_name = 'stock_update[' .$cat_id . '][category]';
    $select_onChange = 'onChange="changed(\'stock_update[' . $cat_id . '][changed]\');"';
    $tree = xtc_get_category_tree();
    $dropdown= xtc_draw_pull_down_menu($select_name, $tree, $default_id, $select_onChange . ' title="'. QUICK_CATEGORY_ID . $default_id.'"' . $disabled); //single
    return $dropdown;
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------
  // Function to create drop down list for category selection - Added 2008/12/30 Azrin Aris
  function xtc_quickstock_category_selector(){
    global $cat_id;
    $tree = xtc_get_category_tree();
    $dropdown= xtc_draw_pull_down_menu('cat_id', $tree, '', 'onChange="this.form.submit();" title="'. QUICK_CATEGORY_ID . $cat_id.'"'); //single
    return $dropdown;
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------
  // Function to create sort links
  function quick_sorting($sort,$id,$type) {
	$page = 'quick_stockupdate.php';
	$allowed_types = array('cat_id','mfg_id');
	if(in_array($type,$allowed_types)){
		$the_type = $type;
	} else {
		$the_type = 'cat_id';
	}
    $nav= '<br /><a href="'.xtc_href_link($page,'sorting='.$sort.'&'.$the_type.'='.$id.xtc_get_all_get_params(array('action','sorting',$the_type))).'">';
    $nav.= xtc_image(DIR_WS_ICONS . 'sort_down.gif', '', '20' ,'20').'</a>';
    $nav.= '<a href="'.xtc_href_link($page,'sorting='.$sort.'-desc&'.$the_type.'='.$id.xtc_get_all_get_params(array('action','sorting',$the_type))).'">';
    $nav.= xtc_image(DIR_WS_ICONS . 'sort_up.gif', '', '20' ,'20').'</a>';
    return $nav;
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------
  // Function to create list of products base on selected category/manufacturer - Added 2008/12/30 Azrin Aris
  function xtc_quickstock_product_listing($sel_id){
    global $lang_id;
    global $manufacturers_list;
    global $filter_type;
    if (xtc_not_null($sel_id)) {
      if($filter_type==1){
		  $sql0 = xtc_db_query("SELECT p.products_sort, p.products_model, p.products_id, p.products_ean, p.products_quantity, p.products_shippingtime, p.products_status, p.products_weight, p.products_price, products_tax_class_id, p.manufacturers_id, p.products_image, pd.products_name, pd.language_id, ptc.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = ptc.products_id and p.products_id = pd.products_id and ptc.categories_id = '" . $sel_id . "' and pd.language_id = '" . (int)$lang_id . "' ORDER BY " . QUICK_ORDER_BY);
        } else {
		  $sql0 = xtc_db_query("SELECT p.products_sort, p.products_model, p.products_id, p.products_ean, p.products_quantity, p.products_shippingtime, p.products_status, p.products_weight, p.products_price, products_tax_class_id, p.manufacturers_id, p.products_image, pd.products_name, pd.language_id, ptc.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = ptc.products_id and p.products_id = pd.products_id and p.manufacturers_id = '" . $sel_id . "' and pd.language_id = '" . (int)$lang_id . "' ORDER BY " . QUICK_ORDER_BY);

        }
      while ($results = xtc_db_fetch_array($sql0)) {

       //check the item status
       $active = ($results['products_status'] == 1) ? ' checked="checked"' : '';
       $inactive = ($results['products_status'] == 0) ? ' checked="checked"' : '';
       //create mannufacture select statement
       if($filter_type==1){
        $catman_select = xtc_quickstock_manufacturer_selectorEx($manufacturers_list, $results['products_id'],$results['manufacturers_id']);
      }
      else {
        $catman_select = xtc_quickstock_category_selectorEx($results['products_id'],$results['categories_id'],false);
      }

      $doChange = 'changed(\'stock_update[' . $results['products_id'] . '][changed]\');';

	 $products_price_brutto = xtc_round($results['products_price'] * ((100 + xtc_get_tax_rate($results['products_tax_class_id'])) / 100), PRICE_PRECISION);

      $doValidate_flt = 'javascript: this.value = validate (this.value, 2, 0);';
      $doValidate_int = 'javascript: this.value = validate (this.value, 0, 2);';

      ?>

       <tr class="dataTableRow">
         <td class="dataTableContentNoBorder" align="center"><input type="checkbox" name="stock_update[<?php echo  $results['products_id'] ?>][changed]" />
            <input type="hidden" name="stock_update[<?php echo  $results['products_id'] ?>][ptc]" value="<?php echo $results['categories_id'] ?>" /></td>
         <td class="dataTableContentNoBorder" align="center"><?php echo $results['products_id'] ?></td>
	    <td class="dataTableContentNoBorder" align="center"><input type="text" size="5" name="stock_update[<?php echo $results['products_id'] ?>][sort]" value="<?php echo $results['products_sort'] ?>" onChange="<?php echo $doChange?> " /></td>
         <td class="dataTableContentNoBorder" align="center"><input type="text" size="12" name="stock_update[<?php echo  $results['products_id'] ?>][model]" value="<?php echo $results['products_model'] ?>" onChange="<?php echo $doChange?>" /></td>
         <?php if(defined('QUICK_SETTINGS_SHOW_COL_EAN') && QUICK_SETTINGS_SHOW_COL_EAN == 'yes'){ ?>
         <td class="dataTableContentNoBorder" align="center"><input type="text" size="14" name="stock_update[<?php echo  $results['products_id'] ?>][ean]" value="<?php echo $results['products_ean'] ?>" onChange="<?php echo $doChange?>" /></td>
         <?php } ?>
         <td class="dataTableContentNoBorder" align="center"><?php echo $catman_select?></td>
         <td class="dataTableContentNoBorder" align="center" width="50"><?php echo xtc_image(DIR_WS_CATALOG_THUMBNAIL_IMAGES. $results['products_image'], $products['products_image'], '', '50');?></td>
         <td class="dataTableContentNoBorder" align="left" ><a href="categories.php?cPath=0&pID=<?php echo $results['products_id'] ?>&action=new_product" target="_blank" style="color: black;"><?php echo $results['products_name'] ?></a></td>
         <td class="dataTableContentNoBorder" align="center"><input type="text" size="7" name="stock_update[<?php echo $results['products_id'] ?>][weight]" value="<?php echo $results['products_weight'] ?>" onChange="<?php echo $doChange?>" onBlur="<?php echo $doValidate_flt?>" /></td>
<?php
/*
         <td class="dataTableContent" align="center"><input type="text" size="7" name="stock_update[<?php echo $results['products_id'] ?>][price]" value="<?php echo number_format($products_price_brutto,2,'.',','); ?>" onChange="<?php echo $doChange?>" onBlur="<?php echo $doValidate_flt ?>" /></td>
         <td class="dataTableContent" align="right"><?php echo number_format($results['products_price'],4,'.',','); ?
*/

// BOF Brutto - Netto Switch by mr.mc.mauser
	if (PRICE_IS_BRUTTO == 'true'){ ?>
		<td class="dataTableContentNoBorder" align="center"><input type="text" size="7" name="stock_update[<?php echo $results['products_id'] ?>][price]" value="<?php echo number_format($products_price_brutto,2,'.',','); ?>" onChange="<?php echo $doChange?>" onBlur="<?php echo $doValidate_flt ?>" /></td>
		<td class="dataTableContentNoBorder" align="right"><?php echo number_format($results['products_price'],4,'.',','); ?></td>
	<?php } else { ?>
		<td class="dataTableContentNoBorder" align="center"><?php echo number_format($products_price_brutto,2,'.',','); ?></td>
		<td class="dataTableContentNoBorder" align="right"><input type="text" size="7" name="stock_update[<?php echo $results['products_id'] ?>][price_n]" value="<?php echo number_format($results['products_price'],4,'.',','); ?>" onChange="<?php echo $doChange?>" onBlur="<?php echo $doValidate_flt ?>" /></td>
	<?php }
// EOF Brutto - Netto Switch by mr.mc.mauser
?>
<?php
// BOF Auf Lager Direkt bearbeiten by mr.mc.mauser
	if(defined('QUICK_SETTINGS_DIREKT_STOCK') && QUICK_SETTINGS_DIREKT_STOCK == 'no') {?>
		<td class="dataTableContentNoBorder" align="center"><?php echo $results['products_quantity'] ?><input type="hidden" size="4" name="stock_update[<?php echo $results['products_id'] ?>][oldstock]" value="<?php echo $results['products_quantity'] ?>" onChange="<?php echo $doChange?>" /></td>
		<td class="dataTableContentNoBorder" align="center"><input type="text" size="4" name="stock_update[<?php echo $results['products_id'] ?>][newstock]" value="0" onChange="<?php echo $doChange?>" onBlur="<?php echo $doValidate_int?>" /></td>
<?php
	} elseif (defined('QUICK_SETTINGS_DIREKT_STOCK') && QUICK_SETTINGS_DIREKT_STOCK == 'yes'){?>
		<td class="dataTableContentNoBorder" align="center"><input size="4" name="stock_update[<?php echo $results['products_id'] ?>][oldstock]" value="<?php echo $results['products_quantity'] ?>" onChange="<?php echo $doChange?>" /></td>
<?php
	}
// BOF Auf Lager Direkt bearbeiten by mr.mc.mauser
?>
         <td class="dataTableContentNoBorder" align="center"><?php echo xtc_quickstock_shipping_selector($results['products_id'],$results['products_shippingtime']); ?></td>
         <td class="dataTableContentNoBorder" align="center" style="text-align:center"><input type="radio" name="stock_update[<?php echo $results['products_id'] ?>][active]" value="1" <?php echo $active ?> onClick="<?php echo $doChange?>" /></td>
         <td class="dataTableContentNoBorder" align="center" style="text-align:center"><input type="radio" name="stock_update[<?php echo $results['products_id'] ?>][active]" value="0" <?php echo $inactive ?> onClick="<?php echo $doChange?>" /></td>
        </tr>

      <?php
      }
    }
  }
//--------------------------------------------------------------------------------------------------------------------------------------------------

  // Function to create Action Bar - Added 2009/04/01 Azrin Aris
  function draw_action_bar($action_id){
  global $action_type;
  global $dest_id;
  global $auto_status;

  $colspan = 13;
  if(defined('QUICK_SETTINGS_SHOW_COL_EAN') && QUICK_SETTINGS_SHOW_COL_EAN == 'yes'){
  	$colspan ++;
  }

// BOF Auf Lager Direkt bearbeiten by mr.mc.mauser
	if(defined('QUICK_SETTINGS_DIREKT_STOCK') && QUICK_SETTINGS_DIREKT_STOCK == 'yes') {
		$colspan --;
	}
// EOF Auf Lager Direkt bearbeiten by mr.mc.mauser

  // $style = ' style="border-top: 1px solid #337ab7; border-bottom: 0px !important"';
  ?>
    <tr>
        <th scope="col" align="left" colspan="<?php echo $colspan; ?>" class="infoBoxHeading"<?php if($action_id == 2){echo $style;}?>>
          <?php echo QUICK_ACTIONBAR_HEADING; ?> :
          <select name="action_type[]" class="form-control" id="select_action" onChange="showElement(this)">
                <option value="0"<?php if($action_type==0){echo ' selected="selected"';}?>><?php echo QUICK_UPDATE?></option>
                <option value="1"<?php if($action_type==1){echo ' selected="selected"';}?>><?php echo QUICK_COPY  ?></option>
                <option value="2"<?php if($action_type==2){echo ' selected="selected"';}?>><?php echo QUICK_MOVE  ?></option>
                <option value="3"<?php if($action_type==3){echo ' selected="selected"';}?>><?php echo QUICK_DELETE?></option>
                </select>
          <?php
            $cat_tree = xtc_get_category_tree();
            echo xtc_draw_pull_down_menu('dest_id[]', $cat_tree, $dest_id, 'onChange="updateDest(this)"'); //single
          ?>
        </th>
        <th scope="col" colspan="2" align="center" class="infoBoxHeading"<?php if($action_id == 2){echo $style;}?> nowrap>
           <input type="checkbox" name="auto_status[]" onChange="updateAutoStatus(this)" /><?php echo QUICK_AUTOSTATUS?>
        </th>
    </tr>
  <?php
  }

//--------------------------------------------------------------------------------------------------------------------------------------------------

  // Function to remove formatted number - Added 2009/05/05 Azrin Aris
  function number_unformat ($input)
  {
    $curr = new currencies();
    $thousands_sep = $curr->currencies[DEFAULT_CURRENCY]['thousands_point'];
    $decimal_point = $curr->currencies[DEFAULT_CURRENCY]['decimal_point'];

      if ($thousands_sep == chr(160)) {
          // change non-breaking space into ordinary space
          $thousands_sep = chr(32);
      } // if
      $count = count_chars($input, 1);
      if ($count[ord($decimal_point)] > 1) {
          // too many decimal places
          return $input;
      } // if
      // split number into 2 distinct parts
      list($integer, $fraction) = explode($decimal_point, $input);
      // remove thousands separator
      $integer = str_replace($thousands_sep, NULL, $integer);
      // join the two parts back together again
      $number = $integer .'.' .$fraction;
      return $number;
  } // number_unformat
//--------------------------------------------------------------------------------------------------------------------------------------------------

  // check if there's a sorting
  $sort_column = '';
  $sort_order = 'ASC';
  if (isset($_GET['sorting']) && xtc_not_null($_GET['sorting'])) {
	$desc = '-desc' == substr($_GET['sorting'], -5);
	$sort_column = preg_replace('#-desc$#', '', $_GET['sorting']);
	$sort_order = $desc ? 'DESC' : 'ASC';
	$sort_allowed = array('product_id','products_sort','products_model','products_ean','products_quantity','products_weight','products_price','products_name','products_quantity','products_shippingtime');
	if(in_array($sort_column,$sort_allowed)){
		switch ($sort_column) {
			case 'products_name':
				$sort_column = 'pd.'.$sort_column;
				break;
			default:
				$sort_column = 'p.'.$sort_column;
		}
		define('QUICK_ORDER_BY', $sort_column.' '.$sort_order);
	} else {
		define('QUICK_ORDER_BY', QUICK_SETTINGS_SORT_COLUMN.' '.$sort_order);
	}
  } else {
	  // no sorting at all, so we set one ;-)
	  define('QUICK_ORDER_BY', QUICK_SETTINGS_SORT_COLUMN.' '.QUICK_SETTINGS_SORT_ORDER);
  }

  //Check if cat_id is set by user selection or URL
  if(isset($_POST['cat_id'])){
	  $cat_id = (int)$_POST['cat_id'];
  } else if(isset($_GET['cat_id'])){
	  $cat_id = (int)$_GET['cat_id'];
  }

  //Check if stock_update is set
  $stock_update = (isset($_POST['stock_update']) ? $_POST['stock_update'] : '');

  //Check if update_status is set
  $update_status = (isset($_POST['update_status']) ? $_POST['update_status'] : '');

  //Check if filter_type is set
  $filter_type = (isset($_POST['filter_type']) ? $_POST['filter_type'] : '1');

 //Check if mfg_id is set
  if(isset($_POST['mfg_id'])){
	  $mfg_id = (int)$_POST['mfg_id'];
  } else if(isset($_GET['mfg_id'])){
	  $mfg_id = (int)$_GET['mfg_id'];
  } else {
	$mfg_id = 0;
  }

 //Check if lang_id is set
  $lang_id = (isset($_POST['lang_id']) ? $_POST['lang_id'] : $_SESSION['languages_id']);

//Check if action_type is set
  $action_array = array();
  $action_array = (isset($_POST['action_type']) ? $_POST['action_type'] : '');
  $action_type = $action_array[1];

 //Check if dest_id is set
  $dest_array = array();
  $dest_array = (isset($_POST['dest_id']) ? $_POST['dest_id'] : '');
  $dest_id = $dest_array[1];

//Check if auto_status is set
  $auto_status_array = array();
  $auto_status_array = (isset($_POST['auto_status']) ? $_POST['auto_status'] : '');
  $auto_status = $auto_status_array[1]=="on"?1:0;
  $manufacturers_list[] = array();
  $manufacturers_list = xtc_quickstock_get_manufacturer_list();

//--------------------------------------------------------------------------------------------------------------------------------------------------

  if(xtc_not_null($stock_update)){
     $update_count = 0;
     $busy_count = 0;
     $qs_sql = '';
     while (list($key, $items) = each($stock_update)){

       $changed = $items['changed'];
       $categories_id = $items['oldstock'];
	   if(defined('QUICK_SETTINGS_SHOW_DECIMAL') && QUICK_SETTINGS_SHOW_DECIMAL == 'yes'){
      	 $items_price = number_unformat($items['price']);
	   } else {
		 $items_price = $items['price'];
	   }

       if ($items['manufacturer'] == '') {$items['manufacturer']=0;}// Credit to Jimbob_pooley for this fix
       if($action_type==0){
         // $current_stock = $items['newstock'] + $items['oldstock'];
// BOF Auf Lager Direkt bearbeiten by mr.mc.mauser
			if(defined('QUICK_SETTINGS_DIREKT_STOCK') && QUICK_SETTINGS_DIREKT_STOCK == 'yes') {
				$current_stock = $items['oldstock'];
			} else {
				$current_stock = $items['newstock'] + $items['oldstock'];
			}
// BOF Auf Lager Direkt bearbeiten by mr.mc.mauser
        if(xtc_not_null($auto_status)){
        $new_status = $current_stock>0?"1":"0";
          if($items['active']!=$new_status){
            $items['active'] = $new_status;
            $changed = 1;
          }
        }//End if(xtc_not_nul...

        if($changed){
          $update_count++;
                $taxResult = xtc_db_query("Select products_tax_class_id from ".TABLE_PRODUCTS." where products_id = ".$key."");
                if(mysqli_num_rows($taxResult)){
                        while($row = xtc_db_fetch_array($taxResult)){
							//$products_price_netto = xtc_round((($items['price'] / (100 + xtc_get_tax_rate($row['products_tax_class_id']))) * 100),PRICE_PRECISION);

// BOF Brutto - Netto Switch by mr.mc.mauser
							if (PRICE_IS_BRUTTO == 'true'){
								$products_price_netto = xtc_round((($items['price'] / (100 + xtc_get_tax_rate($row['products_tax_class_id']))) * 100),PRICE_PRECISION);
							} else {
								$products_price_netto = $items['price_n'];
							}
// EOF Brutto - Netto Switch by mr.mc.mauser

          if($filter_type==1){

            // $sql = "UPDATE " . TABLE_PRODUCTS . " SET products_sort = '".$items['sort']."', products_quantity = '".$current_stock."', products_model = '".$items['model']."', products_ean = '".$items['ean']."', products_image = '".$products_image."', products_price = '".$products_price_netto."', products_weight = '".$items['weight']."', manufacturers_id = '".$items['manufacturer']."', products_shippingtime = '".$items['shippingtime']."', products_status = '".$items['active']."' WHERE products_id = ".$key;
// BOF Bilderfix by mr.mc.mauser
			$sql = "UPDATE " . TABLE_PRODUCTS . " SET products_sort = '".$items['sort']."', products_quantity = '".$current_stock."', products_model = '".$items['model']."', products_ean = '".$items['ean']."', products_price = '".$products_price_netto."', products_weight = '".$items['weight']."', manufacturers_id = '".$items['manufacturer']."', products_shippingtime = '".$items['shippingtime']."', products_status = '".$items['active']."' WHERE products_id = ".$key;
// EOF Bilderfix by mr.mc.mauser
            $qs_sql .= "$sql;\n";
          }

          else {
            // $sql = "UPDATE " . TABLE_PRODUCTS . " SET products_sort = '".$items['sort']."', products_quantity = '".$current_stock."', products_model = '".$items['model']."', products_ean = '".$items['ean']."', products_image = '".$products_image."', products_price = '".$products_price_netto."', products_weight = '".$items['weight']."', products_shippingtime = '".$items['shippingtime']."', products_status = '".$items['active']."' WHERE products_id = ".$key;
// BOF Bilderfix by mr.mc.mauser
			$sql = "UPDATE " . TABLE_PRODUCTS . " SET products_sort = '".$items['sort']."', products_quantity = '".$current_stock."', products_model = '".$items['model']."', products_ean = '".$items['ean']."', products_price = '".$products_price_netto."', products_weight = '".$items['weight']."', products_shippingtime = '".$items['shippingtime']."', products_status = '".$items['active']."' WHERE products_id = ".$key;
// EOF Bilderfix by mr.mc.mauser
            $qs_sql .= "$sql;\n";
                  }
          }//End if($changed)
        }//End if($action_type==0)
       }//End while
        }//End if(xtc_not_null($stock_update))
       else if($action_type==1)
       {
         if($changed)
         {
            $update_count++;
          $sql = "INSERT into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('$key', '$dest_id')";
          $qs_sql .= "$sql;\n";
         }
       }
       else if($action_type==2)
       {
       if($changed)
         {
            $update_count++;
            $sql = "UPDATE " . TABLE_PRODUCTS_TO_CATEGORIES . " SET categories_id = '".$dest_id."' WHERE products_id = $key";
            $qs_sql .= "$sql;\n";
         }
       }
       else if($action_type==3)
       {
       if($changed)
         {
            $update_count++;
            $sql = "DELETE FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = $key AND categories_id ='" . $items['ptc'] ."'";
            $qs_sql .= "$sql;\n";
         }
       }
    }//End while($list...

    if($update_count){
      $time_start = microtime_float();
      $update_status = qs_update_db($qs_sql);
      $time_end = microtime_float();
      $time = $time_end - $time_start;
      if($update_status){
        $msg_str = sprintf(QUICK_MSG_ITEMSUPDATED,$update_count);
        $messageStack->add(QUICK_MSG_SUCCESS . ' ' . $msg_str,'success');
        $msg_str = sprintf(QUICK_MSG_UPDATETIME,$time);
        $messageStack->add(QUICK_MSG_SUCCESS . ' ' . $msg_str,'success');
      } else {
        $messageStack->add(QUICK_MSG_ERROR . ' ' . QUICK_MESSAGE_UPDATEERROR,'error');
      }//End if(qd_update_db(...
    } else {
      $messageStack->add(QUICK_MSG_WARNING . ' ' . QUICK_MSG_NOITEMUPDATED ,'warning');
    }//End if($update_count)
  }//End Of stock update
?>
<?php require (DIR_WS_INCLUDES.'head.php'); ?>
<style type="text/css">
<!--
body {
	font-family: Verdana,Arial,sans-serif;
}
.quick_submit {
	padding: 5px;
	cursor: pointer;
}
/* .QuickTable{
  font-size: 10px;
  color: #000000;
  background-color: #C9C9C9;
} */

.QuickTable caption{
  caption-side: bottom;
  font-style: italic;
  text-align: right;

}

.QuickTable th, .QuickTable td{
	background-color: #fff;
	top: auto;
}

.QuickTable th[scope=col]{
	background-color: #fff;
	white-space:nowrap;
	vertical-align:top;
	text-align:left;
}
.QuickTable tr.alt th, .QuickTable tr.alt td{
	background-color: #7d98b3;
	color: #FFF;
	font-size: 11px;
}
.QuickTable tr:hover th[scope=row], .QuickTable tr:hover td {
  background-color: #f9f0f1;
}
-->
</style>
<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript">
<!--
function changed(a){
  var allElements = document.getElementsByName(a);
  for (var i=0; i < allElements.length; i++) {
      allElements[i].value = 1;
      allElements[i].checked = true;
  }
}

function checkall(a){
  var forms = document.QuickUpdate_Form;
  for(i=0; i<forms.elements.length;i++)
  {
    if(forms.elements[i].type=="checkbox" && forms.elements[i].name!="auto_status[]")
    {
      forms.elements[i].checked=a.checked;
    }
  }
}

function updateAutoStatus(a){
  var ds = document.getElementsByName(a.name);
  var st = document.getElementsByName("status_txt");
  for (b=0; b < ds.length; b++) {
      ds[b].checked = a.checked;
  }
  st[0].style.visibility = a.checked?"visible":"hidden";
}

function updateDest(a){
  var ds = document.getElementsByName(a.name);
  for (b=0; b < ds.length; b++) {
      ds[b].value = a.value;
  }
}

function showElement(a){
  do_showElement(a.value);
}

function do_showElement(a){
  var action_select = document.getElementsByName("action_type[]");
  var dest_select = document.getElementsByName("dest_id[]");
  var auto_status = document.getElementsByName("auto_status[]");
  var st = document.getElementsByName("status_txt");
  var showelement = (a>0 && a<3);
  st[0].style.visibility = auto_status[0].checked?"visible":"hidden";
  for (var j=0; j < 2; j++) {
    action_select[j].value = a;
    if(showelement==true)
    {
        dest_select[j].style.visibility = "visible";
    }
    else
    {
        dest_select[j].style.visibility = "hidden";
    }
    if(a==0)
    {
         auto_status[j].disabled = "";
    }
    else
    {
      auto_status[j].disabled = "disabled";
    }
  }
}

function validate (str, dec, bNeg)
{ // auto-correct input - force numeric data based on params.
  var cDec = '.'; // decimal point symbol
   var bDec = false; var val = "";
   var strf = ""; var neg = ""; var i = 0;
   if (str == "")
    return parseFloat ("0").toFixed (dec);
   if (bNeg && str.charAt (i) == '-')
   {
    neg = '-';
    i++;
  }
   for (i; i < str.length; i++)
   {
      val = str.charAt (i);
      if (val == cDec)
      {
         if (!bDec)
      {
        strf += val;
        bDec = true;
      }
      }
      else if (val >= '0' && val <= '9')
       {
      strf += val;
    }
   }
   strf = (strf == "" ? 0 : neg + strf);
   return parseFloat (strf).toFixed (dec);
}
//-->
</script>
</head>
<body onLoad="SetFocus();" marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top">
      <table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
      </table>
    </td>
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top">
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="80" rowspan="2"><?php echo xtc_image(DIR_WS_ICONS.'heading_configuration.gif'); ?></td>
                <td class="pageHeading"><?php echo QUICK_HEAD1 . ' V ' . QUICK_VERSION; ?></td>
              </tr>
              <tr>
                <td class="main" valign="top">powered by sixtyseven multimedia</td>
              </tr>
              <tr>
              	<td>&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
        	<td class="main">&nbsp;</td>
        </tr>
        <tr>
          <td><form action="quick_stockupdate.php" method="post" name="SearchCriteria_Form"><table border="0" width="100%" cellspacing="0" cellpadding="0">

         <tr>
          <td align="left" width="250"><?php echo QUICK_SEARCH_FOR; ?></td>
          <td align="left" width="250"><?php echo $filter_type==1?QUICK_SELECT_CATEGORY:QUICK_SELECT_MANUFACTURER; ?></td>
          <?php if(defined('QUICK_SHOW_LANGSWITCH') && QUICK_SHOW_LANGSWITCH == 'yes') { ?>
          <td align="left" width="250"><?php echo QUICK_SELECT_LANG; ?></td>
          <?php } ?>
          <td>&nbsp;</td>
         </tr>

           <!--START OF SEARCH CRITERIA BOX-->
         <tr>
          <td class="main" align="left">
            <select class="form-control" name="filter_type" id="select" onChange="this.form.submit();">
              <option value="1"<?php if($filter_type==1){echo ' selected="selected"';}?>><?php echo QUICK_CATEGORY  ?></option>
              <option value="2"<?php if($filter_type==2){echo ' selected="selected"';}?>><?php echo QUICK_MANUFACTURER?></option>
            </select>
          </td>
          <td class="main" align="left"><p><?php if($filter_type==1){ echo xtc_quickstock_category_selector();} else{echo xtc_quickstock_manufacturer_selector($manufacturers_list);} ?></p></td>
          <?php if(defined('QUICK_SHOW_LANGSWITCH') && QUICK_SHOW_LANGSWITCH == 'yes') { ?>
          <td class="main" align="left"><p><?php echo xtc_quickstock_language_selector(); ?></p></td>
          <?php } ?>
          <td>&nbsp;</td>
         </tr>
         <!--/END OF SEARCH CRITERIA BOX-->


         </table></form></td>

     </tr>
     <tr>
     	<td>&nbsp;</td>
     </tr>
     <tr>
        <td><form action="quick_stockupdate.php" method="post" name="QuickUpdate_Form"><table border="0" width="100%" cellspacing="2" cellpadding="2">

         <tr>
          <td valign="top">
           <table class="QuickTable" border="0" width="100%" cellspacing="2" cellpadding="2">

             <!--/START OF ACTION BOX-->
      <?php draw_action_bar(1);?>
            <!--/END OF ACTION BOX-->
            <?php
			$sort_id = 0;
			$sort_type = '';
			if($filter_type==1){
				$sort_id = $cat_id;
				$sort_type = 'cat_id';
			} else {
				$sort_id = $mfg_id;
				$sort_type = 'mfg_id';
			}
			?>
            <tr>
             <th rowspan="2" scope="col" style="width:30px;"><input type="checkbox" name="check_all" onClick="checkall(this);" /></th>
             <th rowspan="2" scope="col" style="width:40px;"><?php echo QUICK_ID . quick_sorting('products_id',$sort_id,$sort_type); ?></th>
             <th rowspan="2" scope="col" style="width:40px;"><?php echo SORT_ID . quick_sorting('products_sort',$sort_id,$sort_type); ?></th>
             <th rowspan="2" scope="col" style="width:100px;"> <?php echo QUICK_MODEL . quick_sorting('products_model',$sort_id,$sort_type); ?></th>
             <?php if(defined('QUICK_SETTINGS_SHOW_COL_EAN') && QUICK_SETTINGS_SHOW_COL_EAN == 'yes'){ ?>
             <th rowspan="2" scope="col" style="width:100px;"> <?php echo QUICK_EAN . quick_sorting('products_ean',$sort_id,$sort_type);  ?></th>
             <?php } ?>
             <th rowspan="2" scope="col" style="width:150px;"> <?php echo $filter_type==1?QUICK_MANUFACTURER:QUICK_CATEGORY; ?></th>
             <th rowspan="2" scope="col" style="width:50px;"> <?php echo QUICK_IMAGE; ?></th>
             <th rowspan="2" scope="col" style="width:400px;"><?php echo QUICK_NAME . quick_sorting('products_name',$sort_id,$sort_type);  ?></th>
             <th rowspan="2" scope="col" style="width:80px;"><?php echo QUICK_WEIGHT . quick_sorting('products_weight',$sort_id,$sort_type);  ?></th>
             <th rowspan="2" scope="col" style="width:80px;"><?php echo QUICK_PRICE_VK . quick_sorting('products_price',$sort_id,$sort_type);  ?></th>
             <th rowspan="2" scope="col" style="width:80px;"><?php echo QUICK_PRICE_NE; ?></th>
             <th rowspan="2" scope="col" style="width:50px;"><?php echo QUICK_STOCK . quick_sorting('products_quantity',$sort_id,$sort_type);  ?></th>
<?php
// BOF Auf Lager Direkt bearbeiten by mr.mc.mauser
	if(defined('QUICK_SETTINGS_DIREKT_STOCK') && QUICK_SETTINGS_DIREKT_STOCK == 'no' ){ ?>
		<th rowspan="2" scope="col" style="width:60px;"><?php echo QUICK_NEW_STOCK; ?></th>
<?php
	}
// EOF Auf Lager Direkt bearbeiten by mr.mc.mauser
?>
             <th rowspan="2" scope="col" style="width:30px;"><?php echo QUICK_SIPPINGTIME. quick_sorting('products_shippingtime',$sort_id,$sort_type); ?></th>
             <th colspan="2" scope="col" style="width:20px; text-align: center"><?php echo QUICK_STATUS;?></th>
         </tr>
         <tr>
         	<th scope="col" style="text-align: center"><?php echo '<font color="#009933">' .QUICK_ACTIVE . '</font>';?></th>
            <th scope="col" style="text-align: center"><?php echo '<font color="#ff0000">' . QUICK_INACTIVE . '</font>';?></th>
         </tr>
         <?php xtc_quickstock_product_listing($filter_type==1?$cat_id:$mfg_id); ?>
             <!--/START OF ACTION BOX-->
      <?php draw_action_bar(2);?>
            <!--/END OF ACTION BOX-->

       </table>
          </td>
         </tr>
         <tr>
          <td align="center" colspan="10" class="smallText">
           <input type="hidden" name="cat_id" value="<?php echo $cat_id;?>" />
           <input type="hidden" name="mfg_id" value="<?php echo $mfg_id;?>" />
           <input type="hidden" name="lang_id" value="<?php echo $lang_id;?>" />
           <input type="hidden" name="filter_type" value="<?php echo $filter_type;?>" />
         <?php echo '<p name="status_txt">' . QUICK_TEXT . '</p>'; ?>
           <input type="submit" value="<?php echo QUICK_UPDATE_BUTTON;?>" class="btn btn-default"/>
                <script type="text/javascript">
                <!--
             do_showElement("<?php echo $action_type; ?>");
                //-->
                </script>
          </td>
         </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
       </table></form></td>
    </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
