<?php

/* -----------------------------------------------------------------------------------------
   $Id: xtc_product_link.inc.php 779 2005-02-19 17:19:28Z novalis $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2005 XT-Commerce


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include_once(DIR_FS_INC . 'xtc_get_parent_categories.inc.php');

function xtc_product_link($pID, $name='') {

    #Check for current category link    
    $c_path = $_SERVER['QUERY_STRING'];
    if(strpos($c_path,'cPath') !== false){
        $category_path = substr($c_path, strpos($c_path,'=')+1);
        $categorie_previous = end(explode('_', $category_path));
        $cat_children = array();
        $cat_children = xtc_get_categories_children($categorie_previous);
        foreach($cat_children as $linked_cat){
            $category_query_check = "select p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = '" . (int)$pID . "' and p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id != 0 and p2c.categories_id = '".$linked_cat."'";
            $category_query_check  = xtDBquery($category_query_check);
            if (xtc_db_num_rows($category_query_check,true)) {
                $cID = (xtc_db_fetch_array($category_query_check)['categories_id']);
                break;
            }
        }
    }
        
    #Take default categorie id
    if(!isset($cID)){
        $category_query = "select p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = '" . (int)$pID . "' and p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id != 0";
        $category_query  = xtDBquery($category_query);
        if (xtc_db_num_rows($category_query,true)) {
            $cID = xtc_db_fetch_array($category_query)['categories_id'];
        }
    }
    
    #Create category path from category ID
    $categories = array();
    xtc_get_parent_categories($categories, $cID);
    $categories = array_reverse($categories);
    $categories[] = $cID;
    $cPath = implode('_', $categories);

    return 'products_id='.$pID.'&cPath='.$cPath;
}
?>