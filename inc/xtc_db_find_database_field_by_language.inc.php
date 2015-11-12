<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_db_find_database_field_by_language.inc.php 899 2005-04-29 02:40:57Z hhgag $   

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
 * @param type $table - select table
 * @param type $column - select column in table
 * @param type $search_value - select record in column
 * @param type $language_id - where language id
 * @param type $language_field - is in language column
 * @return type mixed - false if record not found; array if found;
 */

function xtc_db_find_database_field_by_language($table, $column, $search_value, $language_id, $language_field, $select = '*') {
    $query = xtc_db_query("select ".$select." from ".$table." where `".$column."` = '".$search_value."' and `".$language_field."` = '".$language_id."'");
    return xtc_db_fetch_array($query);
}
?>
