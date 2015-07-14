<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_set_customer_status_upgrade.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_set_customer_status_upgrade.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
//set customer satus to new customer for upgrade account
function xtc_inc_next_ibillnr(){
  $query = "select 
              configuration_value 
            from " . 
              TABLE_CONFIGURATION . "
            where 
              configuration_key = 'IBN_BILLNR'";
  $result = xtc_db_query($query);
  $data=xtc_db_fetch_array($result);
  
  $data = $data['configuration_value'];
  if( $data==0 ) 
    return 0;

  $data++;
  
  $query = "update " . 
              TABLE_CONFIGURATION . " 
            set 
              configuration_value = '" . $data . "'
            where 
              configuration_key = 'IBN_BILLNR'";
  return xtc_db_query($query);
}

 ?>