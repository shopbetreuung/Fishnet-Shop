<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_db_find_database_field.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_check_stock.inc.php); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
 // Fetch field - find if it already entry exist

/**
 * 
 * @param type $table - Select table
 * @param type $column - Select column in table
 * @param type $search_value - Select record in column
 * @param string $select -What columns do we want to select, default all(*)
 * @return type mixed - False if record not found; array if found;
 */


function xtc_db_find_database_field($table, $column, $search_value, $select = '*') {
    $query = xtc_db_query("select ".$select." from ".$table." where `".$column."` = '".$search_value."'");
    return xtc_db_fetch_array($query);
}
?>
