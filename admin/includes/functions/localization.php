<?php
/* --------------------------------------------------------------
   $Id: localization.php  2017-11-19 15:30:50Z hpz $

   XT-Commerce - community made shopping

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(localization.php,v 1.12 2003/06/25); www.oscommerce.com
   (c) 2003      nextcommerce (localization.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

  // include needed function
  require_once(DIR_FS_INC.'get_external_content.inc.php');

  function quote_oanda_currency($code, $base = DEFAULT_CURRENCY) {
    $url = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
    $page = get_external_content($url, 3, false);    
    $XML = simplexml_load_string($page);
        
    $cur = array();         
    foreach($XML->Cube->Cube->Cube as $rate){
      $cur[(string)$rate["currency"]] = (float)$rate["rate"];
    }
    
    $cur["EUR"] = 1;
    
    if (!empty($cur[$code]) && !empty($cur[$base])) {    
      return $cur[$code] / $cur[$base];
    } else {
      return false;
    }
  }
 
  function quote_xe_currency($to, $from = DEFAULT_CURRENCY) {
    $url = 'https://www.xe.com/currencyconverter/convert/?Amount=1&From=' . $from . '&To=' . $to;
    $page = get_external_content($url, 3, false);

    preg_match('/[0-9.]+\s*' . $from . '\s*=\s*([0-9.]+)\s*' . $to . '/', $page, $match);  

    if (sizeof($match) > 0) {
      return $match[1];
    } else {
      return false;
    }
  }
