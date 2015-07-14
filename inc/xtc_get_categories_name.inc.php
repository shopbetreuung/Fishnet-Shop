<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_categories_name.inc.php 1000 2008-08-14 Hetfield $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
   (c) 2003	 nextcommerce (xtc_get_categories.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function xtc_get_categories_name($categories_id) {

    if (GROUP_CHECK == 'true') { $group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 "; }
    
	$categories_name_query = "SELECT cd.categories_name FROM ".TABLE_CATEGORIES_DESCRIPTION." cd, ".TABLE_CATEGORIES." c WHERE cd.categories_id = '".$categories_id."' AND c.categories_id=cd.categories_id ".$group_check." AND cd.language_id='".(int) $_SESSION['languages_id']."'";
    $categories_name_query  = xtDBquery($categories_name_query);
    $categories_name = xtc_db_fetch_array($categories_name_query,true);
	
    return $categories_name['categories_name'];
	
  }
?>