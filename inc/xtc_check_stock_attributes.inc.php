<?php

	/**
	 * Check the attributes Stock
	 * @param int $products_id
	 * @param int $options_id
	 * @param int $options_values_id
	 * @param int $attributes_quantity
	 * @return boolean true = in Stock | false = out of Stock
	 */
	function xtc_check_stock_attributes($products_id, $options_id, $options_values_id, $attributes_quantity) {

		$stock_query=xtc_db_query("	SELECT
										attributes_stock
									FROM ".TABLE_PRODUCTS_ATTRIBUTES."
									WHERE
										products_id = '".(int)$products_id."'
										AND options_id = '".(int)$options_id."'
										AND options_values_id = '".(int)$options_values_id."';");
	
		$stock_data = xtc_db_fetch_array($stock_query); 		
		$stock_left = $stock_data['attributes_stock'] - $attributes_quantity;

		if ($stock_left >= 0) {
		  return true;
		}

		return false;
	}