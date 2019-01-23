<?php

	function get_product_images_alt($image_id, $image_nr, $language_id) {
		$product_main_image_title_query = xtc_db_query("SELECT image_alt from ".TABLE_PRODUCTS_IMAGES_DESCRIPTION." WHERE image_id = '".$image_id."' AND image_nr = '".$image_nr."' AND language_id = '".$language_id."'");
		$product_main_image_title = xtc_db_fetch_array($product_main_image_title_query);
		return $product_main_image_title['image_alt'];
	}

?>