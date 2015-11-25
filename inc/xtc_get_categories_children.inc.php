<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_categories_children.inc.php Milan Niksic 23.10.2015

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


function xtc_get_categories_children($cat_id){
    $cat_children = array();
    $cat_children[]=$cat_id;
    xtc_get_categories_children_calc($cat_id, $cat_children);
    return $cat_children;
}


 function xtc_get_categories_children_calc($cat_id, &$cat_children){
    $categories_query = "select categories_id, parent_id from " . TABLE_CATEGORIES . "  where parent_id = '" . $cat_id . "'";
    $categories_query  = xtDBquery($categories_query);
    if (xtc_db_num_rows($categories_query,true)) {
        while ($categoryies = xtc_db_fetch_array($categories_query) ){  
            $cat_children[] = $categoryies['categories_id'];
            xtc_get_categories_children($categoryies['categories_id'], $cat_children);
        }
    }
}

?>