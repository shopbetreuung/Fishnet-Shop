<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_product_path.inc.php 1009 2005-07-11 16:19:29Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce 
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_get_product_path.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

   if (!function_exists('shopstat_functions')) {
    require_once (DIR_FS_INC . 'shopstat_functions.inc.php');
   }
   if (!function_exists('xtc_get_categories_name')) {
    require_once (DIR_FS_INC . 'xtc_get_categories_name.inc.php');
   }

// Construct a category path to the product
// TABLES: products_to_categories
  function xtc_get_product_path($products_id) {
    $cPath = '';

    $category_query = "select p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = '" . (int)$products_id . "' and p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id != 0";
    $category_query  = xtDBquery($category_query);
    if (xtc_db_num_rows($category_query,true)) {
        #Default category( first picked from table)
        $category = xtc_db_fetch_array($category_query);
        $p_path_full = $_SERVER['REQUEST_URI'];
        $p_path = $_SERVER['QUERY_STRING'];
        
        #If we display product check linked categories
        if(strpos($p_path,'products_id') !== false){
            
            while ($categoryies = xtc_db_fetch_array($category_query) ){
                $cat_name =  xtc_get_categories_name($categoryies['categories_id']);
                $cat_name_slug = shopstat_hrefSmallmask($cat_name);
                $p_path_full_array = explode('/', $p_path_full);
                if($p_path_full_array[count($p_path_full_array)-2] === $cat_name_slug){
                    $category = $categoryies;
                    break;
                }
             }
        }
        
        # Check if current categorie or its children have linked product
        $c_path = $_SERVER['QUERY_STRING'];
        if(strpos($c_path,'cPath') !== false){
            $category_path = substr($c_path, strpos($c_path,'=')+1);
            $categorie_previous = end(explode('_', $category_path));
            $cat_children = array();
            $cat_children = xtc_get_categories_children($categorie_previous);
            foreach($cat_children as $linked_cat){
                $category_query_check = "select p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = '" . (int)$products_id . "' and p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id != 0 and p2c.categories_id = '".$linked_cat."'";
                $category_query_check  = xtDBquery($category_query_check);
                if (xtc_db_num_rows($category_query_check,true)) {
                    $category = xtc_db_fetch_array($category_query_check);
                    break;
                }
            }
        }

      $categories = array();
      xtc_get_parent_categories($categories, $category['categories_id']);

      $categories = array_reverse($categories);

      $cPath = implode('_', $categories);

      if (xtc_not_null($cPath)) $cPath .= '_';
      $cPath .= $category['categories_id'];
  }
//BOF - Dokuman - 2009-10-02 - removed feature, due to wrong links in category on "last viewed"  
/*
  if($_SESSION['lastpath']!=''){
    $cPath = $_SESSION['lastpath'];
  }
*/
//EOF - Dokuman - 2009-10-02 - removed feature, due to wrong links in category on "last viewed"  
  return $cPath;
}
?>