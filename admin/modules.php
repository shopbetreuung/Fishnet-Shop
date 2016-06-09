<?php
  /* --------------------------------------------------------------
   $Id: modules.php 4200 2013-01-10 19:47:11Z Tomcraft1980 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(modules.php,v 1.45 2003/05/28); www.oscommerce.com
   (c) 2003 nextcommerce (modules.php,v 1.23 2003/08/19); www.nextcommerce.org
   (c) 2006 XT-Commerce (categories.php 1123 2005-07-27)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  //Eingefügt um Fehler in CC Modul zu unterdrücken.
  require(DIR_FS_CATALOG.DIR_WS_CLASSES . 'xtcPrice.php');
  $xtPrice = new xtcPrice($_SESSION['currency'],'');
  $module_directory = '';
  $module_key = '';

  $set = (isset($_GET['set']) ? $_GET['set'] : '');
  if (xtc_not_null($set)) {
    switch ($set) {
      case 'shipping':
        $module_type = 'shipping';
        $module_directory = DIR_FS_CATALOG_MODULES . 'shipping/';
        $module_key = 'MODULE_SHIPPING_INSTALLED';
        define('HEADING_TITLE', HEADING_TITLE_MODULES_SHIPPING);
        break;
      case 'ordertotal':
        $module_type = 'order_total';
        $module_directory = DIR_FS_CATALOG_MODULES . 'order_total/';
        $module_key = 'MODULE_ORDER_TOTAL_INSTALLED';
        define('HEADING_TITLE', HEADING_TITLE_MODULES_ORDER_TOTAL);
        break;
      case 'payment':
      default:
        $module_type = 'payment';
        $module_directory = DIR_FS_CATALOG_MODULES . 'payment/';
        $module_key = 'MODULE_PAYMENT_INSTALLED';
        define('HEADING_TITLE', HEADING_TITLE_MODULES_PAYMENT);
        if (isset($_GET['error'])) {
          $messageStack->add($_GET['error'], 'error');
        }
        break;
    }
  }
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if (xtc_not_null($action)) {
    switch ($action) {
      case 'save':
        reset($_POST['configuration']); //DokuMan - 2011-09-29 - reset $_POST array
        while (list($key, $value) = each($_POST['configuration'])) {
          xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $value . "' where configuration_key = '" . $key . "'");
        }
        xtc_redirect(xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $_GET['module']));
        break;
      case 'install':
      case 'remove':
        $file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
        $class = basename($_GET['module']);
        if (file_exists($module_directory . $class . $file_extension)) {
          include($module_directory . $class . $file_extension);
          $module = new $class(0);
          if ($action == 'install') {
            $module->install();
          } elseif ($action == 'remove') {
            $module->remove();
          }
        }
        xtc_redirect(xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $class));
        break;
    }
  }


require (DIR_WS_INCLUDES.'head.php');
?>
</head>
<body>
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->
    <!-- body //-->
        
    <div class="row">
      
    <div class='col-xs-12'>
        <div class="col-xs-3 col-sm-1 text-right"><?php echo xtc_image(DIR_WS_ICONS.'heading_modules.gif'); ?></div>
        <div class="col-xs-9 col-sm-11"><p class="h2"><?php echo defined('HEADING_TITLE')?HEADING_TITLE:''; ?></p> Modules</div>
    </div>
    <div class='col-xs-12'><br></div>
    <div class='col-xs-12'>
        <div id='responsive_table' class='table-responsive pull-left col-sm-12'>
        <table class="table table-bordered">
                        <tr class="dataTableHeadingRow">
                          <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_MODULES; ?></td>
                          <td class="dataTableHeadingContent hidden-xs"><?php echo TABLE_HEADING_FILENAME; ?></td>
                          <td class="dataTableHeadingContent hidden-xs" align="right"><?php echo TABLE_HEADING_SORT_ORDER; ?></td>
                          <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
                        </tr>
                        <?php
                        #MN: Country check for klarna
						$country_query = xtc_db_query('SELECT countries_iso_code_2 FROM countries WHERE countries_id = "'.$_SESSION['customer_country_id'].'"');
						$country = xtc_db_fetch_array($country_query);
						$user_country_iso = $country['countries_iso_code_2'];
						$klarna_supported_countries = array('SE', 'NO', 'DK', 'FI', 'DE', 'NL', 'SWE', 'NOR', 'DNK', 'FIN', 'DEU', 'NLD');
                        ##MN##
                        $directory_array = array(0 => array(), 1 => array());
                        if ($dir = @dir($module_directory)) {
							while ($file = $dir->read()) {
							if(($file == 'klarna_invoice.php' || $file == 'klarna_SpecCamp.php' || $file == 'klarna_partPayment.php') && !in_array($user_country_iso, $klarna_supported_countries)){
								continue;
							}
                            if (!is_dir($module_directory . $file)) {
                              if (substr($file, -4) == ".php") {
                                //BOF - DokuMan - 2011-07-19 - sorting of modules (credits to GTB)
                                if (file_exists(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/' . $module_type . '/' . $file)) {
                                  include_once(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/' . $module_type . '/' . $file);
                                  include_once($module_directory . $file);
                                  $class = substr($file, 0, strrpos($file, '.'));
                                  if (xtc_class_exists($class)) {
                                    $module = new $class();
                                  }
                                } else {
                                  $messageStack->add_session(sprintf(TEXT_MODULE_FILE_MISSING, $_SESSION['language'], $file), 'warning');
                                }
                                if (isset($module->sort_order) && is_numeric($module->sort_order)) {
                                  if (empty($directory_array[0][$module->sort_order])) {
                                    $directory_array[0][$module->sort_order] = $file;
                                  } else {
                                    $directory_array[0][] = $file;
                                  }
                                } else {
                                  $directory_array[1][] = $file;
                                }
                                unset($module);
                              //EOF - DokuMan - 2011-07-19 - sorting of modules (credits to GTB)
                              }
                            }
                          }
                          //BOF - DokuMan - 2011-07-19 - sorting of modules (credits to GTB)
                          if (is_array($directory_array[0])) {
                            ksort($directory_array[0]);
                            foreach ($directory_array[0] as $key => $val){
                              $directory_array[0][$key] = $val;
                            }
                            $directory_array[0] = array_values($directory_array[0]);
                          }
                          sort($directory_array[1]);
                          //EOF - DokuMan - 2011-07-19 - sorting of modules (credits to GTB)
                          ksort($directory_array);
                          $dir->close();
                        }
                        $installed_modules = array();
                        foreach ($directory_array as $directory_array) { //foreach-loop start - DokuMan - 2011-07-19 - sorting of modules (credits to GTB)
                          for ($i = 0, $n = sizeof($directory_array); $i < $n; $i++) {
                            $file = $directory_array[$i];
                            if (file_exists(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/' . $module_type . '/' . $file)) {
                              include_once(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/' . $module_type . '/' . $file);
                              include_once($module_directory . $file);
                              $class = substr($file, 0, strrpos($file, '.'));
                              if (xtc_class_exists($class)) {
                                $module = new $class();
                                if ($module->check() > 0) {
                                  // BOF - DokuMan - 2011-05-10 revise fix for sorting of modules
                                  if (($module->sort_order > 0) && !isset($installed_modules[$module->sort_order])) {
                                    $installed_modules[$module->sort_order] = $file;
                                  } else {
                                    $installed_modules[] = $file;
                                  }
                                  // EOF - DokuMan - 2011-05-10 revise fix for sorting of modules
                                }
                                if ((!isset($_GET['module']) || (isset($_GET['module']) && ($_GET['module'] == $class))) && !isset($mInfo)) {
                                  $module_info = array('code' => $module->code,
                                                       'title' => $module->title,
                                                       'description' => $module->description,
                                                       'extended_description' => $module->extended_description,
                                                       'status' => $module->check());
                                  $module_keys = $module->keys();
                                  $keys_extra = array();
                                  for ($j = 0, $k = sizeof($module_keys); $j < $k; $j++) {
                                    $key_value_query = xtc_db_query("select configuration_key,configuration_value, use_function, set_function from " . TABLE_CONFIGURATION . " where configuration_key = '" . $module_keys[$j] . "'");
                                    $key_value = xtc_db_fetch_array($key_value_query);
                                    if ($key_value['configuration_key'] !='')
                                      $keys_extra[$module_keys[$j]]['title'] = constant(strtoupper($key_value['configuration_key'] .'_TITLE'));
                                    $keys_extra[$module_keys[$j]]['value'] = $key_value['configuration_value'];
                                    if ($key_value['configuration_key'] !='')
                                      $keys_extra[$module_keys[$j]]['description'] = constant(strtoupper($key_value['configuration_key'] .'_DESC'));
                                    $keys_extra[$module_keys[$j]]['use_function'] = $key_value['use_function'];
                                    $keys_extra[$module_keys[$j]]['set_function'] = $key_value['set_function'];
                                  }
                                  $module_info['keys'] = $keys_extra;
                                  $mInfo = new objectInfo($module_info);
                                }
                                if (isset($mInfo) && is_object($mInfo) && ($class == $mInfo->code) ) {
                                  if ($module->check() > 0) {
                                    echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'pointer\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $class . '&action=edit') . '\'">' . "\n";
                                  } else {
                                    echo '              <tr class="dataTableRowSelected">' . "\n";
                                  }
                                } else {
                                  echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'pointer\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $class) . '\'">' . "\n";
                                }
                                ?>
                                <td class="dataTableContent">
                                  <?php
                                    echo $module->title;
                                    if (isset($module->icons_available)) {
                                      echo '<br />'.$module->icons_available;
                                    }
                                  ?>
                                </td>
                                <td class="dataTableContent hidden-xs"><?php echo str_replace('.php','',$file); ?></td>
                                <td class="dataTableContent hidden-xs" align="right">
                                <?php if (isset($module->sort_order) && is_numeric($module->sort_order)) echo $module->sort_order; ?>&nbsp;</td>
                                <td class="dataTableContent" align="right">
                                    <span class="hidden-xs hidden-sm">
                                    <?php if (isset($mInfo) && is_object($mInfo) && ($class == $mInfo->code) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ICON_ARROW_RIGHT); } else { echo '<a href="' . xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $class) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;
                                    </span>
                                    <span class="hidden-md hidden-lg">
                                        <?php 
                                        if ($module->check() == '1') {
                                            echo '<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $mInfo->code . '&action=remove') . '">' . BUTTON_MODULE_REMOVE . '</a>';
                                        } else {
                                            echo '<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $mInfo->code . '&action=install') . '">' . BUTTON_MODULE_INSTALL . '</a>';
                                        }
                                        ?>
                                    </span>
                                </td>
                              </tr>
                              <?php
                              }
                            }
                          }
                        } //foreach-loop end - DokuMan - 2011-07-19 - sorting of modules (credits to GTB)

                        ksort($installed_modules);
                        $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = '" . $module_key . "'");
                        if (xtc_db_num_rows($check_query)) {
                          $check = xtc_db_fetch_array($check_query);
                          if ($check['configuration_value'] != implode(';', $installed_modules)) {
                            xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . implode(';', $installed_modules) . "', last_modified = now() where configuration_key = '" . $module_key . "'");
                          }
                        } else {
                          xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ( '" . $module_key . "', '" . implode(';', $installed_modules) . "','6', '0', now())");
                        }
                        ?>
                      </table>
                        <div class="col-xs-12 smallText">
                          <?php echo TEXT_MODULE_DIRECTORY . ' ' . $module_directory; ?>
                        </div>
                    </div>
                    <?php
                    $heading = array();
                    $contents = array();
                    switch ($action) {
                      // BOF - Tomcraft - 2009-10-03 - Paypal Express Modul
                      case 'removepaypal':
                        $heading[] = array('text' => '<b>' . $mInfo->title . '</b>');
                        $contents = array ('form' => xtc_draw_form('modules', FILENAME_MODULES, 'set=' . $set . '&module=' . $_GET['module'] . '&action=remove'));
                        $contents[] = array ('text' => '<br />'.TEXT_INFO_DELETE_PAYPAL.'<br /><br />'.$mInfo->description);
                        $contents[] = array ('text' => '<br />'.xtc_draw_checkbox_field('paypaldelete').' '.BUTTON_MODULE_REMOVE);
                        $contents[] = array ('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="'. BUTTON_START .'"><a class="btn btn-default" onclick="this.blur();" href="'.xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $_GET['module']).'">' . BUTTON_CANCEL . '</a>');
                        break;
                      // EOF - Tomcraft - 2009-10-03 - Paypal Express Modul
                      case 'edit':
                        $keys = '';
                        reset($mInfo->keys);
                        while (list($key, $value) = each($mInfo->keys)) {
                          $keys .= '<b>' . $value['title'] . '</b><br />' .  $value['description'].'<br />';
                          if ($value['set_function']) {
                            eval('$keys .= ' . $value['set_function'] . "'" . $value['value'] . "', '" . $key . "');");
                          } else {
                            $keys .= xtc_draw_input_field('configuration[' . $key . ']', $value['value'], 'class="inputModule"'); //web28- 2010-05-17 - set css definition
                          }
                          $keys .= '<br /><br />';
                        }
                        $keys = substr($keys, 0, strrpos($keys, '<br /><br />'));
                        $heading[] = array('text' => '<b>' . $mInfo->title . '</b>');
                        $contents = array('form' => xtc_draw_form('modules', FILENAME_MODULES, 'set=' . $set . '&module=' . $_GET['module'] . '&action=save'));
                        $contents[] = array('text' => $keys);
                        $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_UPDATE . '"/> <a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $_GET['module']) . '">' . BUTTON_CANCEL . '</a>');
                        break;
                      default:
                        if (isset($mInfo) && is_object($mInfo)) {
                          $heading[] = array('text' => '<b>' . $mInfo->title . '</b>');
                          if ($mInfo->status == '1') {
                            $keys = '';
                            reset($mInfo->keys);
                            while (list(, $value) = each($mInfo->keys)) {
                              $keys .= '<b>' . (isset($value['title'])?$value['title']:'') . '</b><br />';
                              if ($value['use_function']) {
                                $use_function = $value['use_function'];
                                if (preg_match('/->/', $use_function)) { // Hetfield - 2009-08-19 - replaced deprecated function ereg with preg_match to be ready for PHP >= 5.3
                                  $class_method = explode('->', $use_function);
                                  if (!isset(${$class_method[0]}) || !is_object(${$class_method[0]})) { // DokuMan - 2011-05-10 - check if object is first set
                                    include(DIR_WS_CLASSES . $class_method[0] . '.php');
                                    ${$class_method[0]} = new $class_method[0]();
                                  }
                                  $keys .= xtc_call_function($class_method[1], $value['value'], ${$class_method[0]});
                                } else {
                                  $keys .= xtc_call_function($use_function, $value['value']);
                                }
                              } else {
                                if(strlen($value['value']) > 30) {
                                  $keys .=  substr($value['value'],0,30) . ' ...';
                                } else {
                                  $keys .=  $value['value'];
                                }
                              }
                              $keys .= '<br /><br />';
                            }
                            $keys = substr($keys, 0, strrpos($keys, '<br /><br />'));
                            $contents[] = array('align' => 'center', 'text' => '<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $mInfo->code . '&action=remove') . '">' . BUTTON_MODULE_REMOVE . '</a> <a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $mInfo->code . '&action=edit') . '">' . BUTTON_EDIT . '</a>');
                            $contents[] = array('text' => '<br />' . $mInfo->description);
                            if (isset($mInfo->extended_description) && $mInfo->extended_description != '') {
                              if (($mInfo->code == "paypal" || $mInfo->code == "paypalexpress") && PAYPAL_API_USER == '') {
                                // Special text in paypal and paypalexpress if API_USER not defined
                                $contents[] = array('text' => '<br />' . $mInfo->extended_description);
                              }
                            }
                            $contents[] = array('text' => '<br />' . $keys);
                          } else {
                            $contents[] = array('align' => 'center', 'text' => '<a class="btn btn-default" onclick="this.blur();" href="' . xtc_href_link(FILENAME_MODULES, 'set=' . $set . '&module=' . $mInfo->code . '&action=install') . '">' . BUTTON_MODULE_INSTALL . '</a>');
                            $contents[] = array('text' => '<br />' . $mInfo->description);
                          }
                          break;
                        }
                    }
                    if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
                      echo '<div class="col-md-3 hidden-xs hidden-sm pull-right">' . "\n";#col-sm-12 col-xs-12 
                      echo box::infoBoxSt($heading, $contents); // cYbercOsmOnauT - 2011-02-07 - Changed methods of the classes box and tableBox to static
                      echo '</div>' . "\n";
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