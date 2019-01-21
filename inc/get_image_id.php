<?php

function get_image_id($products_id, $image_nr) {
	$get_image_id_query = xtc_db_query("SELECT image_id from ".TABLE_PRODUCTS_IMAGES." WHERE products_id = '".$products_id."' AND image_nr = '".$image_nr."'");
	$get_image_id = xtc_db_fetch_array($get_image_id_query);
	return $get_image_id['image_id'];
}

?>