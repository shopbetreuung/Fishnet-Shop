<?php

	function get_product_main_image_title($products_id, $language_id) {
		$product_main_image_title_query = xtc_db_query("SELECT products_main_image_title from ".TABLE_PRODUCTS_DESCRIPTION." WHERE products_id = '".$products_id."' AND language_id = '".$language_id."'");
	    $product_main_image_title = xtc_db_fetch_array($product_main_image_title_query);  
	    return $product_main_image_title['products_main_image_title'];
	}

?>