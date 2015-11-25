<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_product_original_path.inc.php 
   ---------------------------------------------------------------------------------------*/
   
// Construct a category path to the product
  function xtc_get_product_original_path($products_id) {
    $cPath = '';
    
    $category_query = "select p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = '" . (int)$products_id . "' and p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id != 0 limit 1";
    $category_query  = xtDBquery($category_query);
    if (xtc_db_num_rows($category_query,true)) {
      $category = xtc_db_fetch_array($category_query);

      $categories = array();
      xtc_get_parent_categories($categories, $category['categories_id']);

      $categories = array_reverse($categories);

      $cPath = implode('_', $categories);

      if (xtc_not_null($cPath)) $cPath .= '_';
      $cPath .= $category['categories_id'];
  }
  return $cPath;
}
?>