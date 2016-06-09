<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_oe_get_options_values_name.inc.php

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_get_products_name.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   XTC-Bestellbearbeitung:
   http://www.xtc-webservice.de / Matthias Hinsche
   info@xtc-webservice.de

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
  function xtc_oe_get_options_values_name($products_options_values_id, $language = '') {

    if (empty($language)) $language = $_SESSION['languages_id'];

    $product_query = xtc_db_query("select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . xtc_db_input((int)$products_options_values_id) . "' and language_id = '" . xtc_db_input((int)$language) . "'");
    $product = xtc_db_fetch_array($product_query);

    return $product['products_options_values_name'];
  }
 ?>