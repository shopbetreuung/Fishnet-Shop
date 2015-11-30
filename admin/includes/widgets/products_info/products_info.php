<?php 

	define('TOTAL_PRODUCTS_ACTIVE','Aktive Artikel');
	define('TOTAL_PRODUCTS_INACTIVE','Inaktive Artikel');
	define('TOTAL_PRODUCTS','Artikel gesamt');
	define('TOTAL_SPECIALS','Sonderangebote');
	
	$products_query = xtc_db_query("SELECT
										 count(if(products_status = 0, products_id, null)) inactive_count,
										 count(if(products_status = 1, products_id, null)) active_count,
										 count(*) total_count 
									FROM " . TABLE_PRODUCTS);
	$products = xtc_db_fetch_array($products_query);
	
	$specials_query = xtc_db_query("select count(*) as specials_count from " . TABLE_SPECIALS);
	$specials = xtc_db_fetch_array($specials_query);	   
	
?>
<table class="table table-bordered">       
	<tr>
		<td><strong><?php echo TOTAL_PRODUCTS_ACTIVE; ?>:</strong></td>
		<td><?php echo $products['active_count']; ?></td>
	</tr>
	<tr>
		<td><strong><?php echo TOTAL_PRODUCTS_INACTIVE; ?>:</strong></td>
		<td><?php echo $products['inactive_count']; ?></td>
	</tr>
	<tr>
		<td><strong><?php echo TOTAL_PRODUCTS; ?>:</strong></td>
		<td><?php echo $products['total_count'] ?></td>
	</tr>
	<tr>
		<td><strong><?php echo TOTAL_SPECIALS; ?>:</strong></td>
		<td><?php echo $specials['specials_count']; ?></td>
	</tr>
</table>