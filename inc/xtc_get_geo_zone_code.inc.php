<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_geo_zone_code.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_get_zone_code.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function xtc_get_geo_zone_code($country_id) {
    $geo_zone_query = xtc_db_query("select geo_zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where zone_country_id = '" . xtc_db_input((int)$country_id) . "'");
    $geo_zone = xtc_db_fetch_array($geo_zone_query);
    return $geo_zone['geo_zone_id'];
    }
 ?>