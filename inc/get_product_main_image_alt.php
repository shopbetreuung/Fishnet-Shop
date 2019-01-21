<?php

	function get_product_main_image_alt($products_id, $language_id) {
    	$product_main_image_alt_query = xtc_db_query("SELECT products_main_image_alt from ".TABLE_PRODUCTS_DESCRIPTION." WHERE products_id = '".$products_id."' AND language_id = '".$language_id."'");
        $product_main_image_alt = xtc_db_fetch_array($product_main_image_alt_query);  
        return $product_main_image_alt['products_main_image_alt'];
	}

?>