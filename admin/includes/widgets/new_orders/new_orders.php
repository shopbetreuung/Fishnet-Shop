<p class="h3" style="margin-top: 0;"><?php echo TABLE_CAPTION_NEW_ORDERS; ?> <small><?php echo TABLE_CAPTION_NEW_ORDERS_COMMENT; ?></small></p>

<table class="table table-striped">
	<thead>
		<tr>
			<th><?php echo TABLE_HEADING_NEW_ORDERS_ORDER_NUMBER; ?></th>
			<th><?php echo TABLE_HEADING_NEW_ORDERS_ORDER_DATE; ?></th>
			<th><?php echo TABLE_HEADING_NEW_ORDERS_CUSTOMERS_NAME; ?></th>
			<th><?php echo TABLE_HEADING_NEW_ORDERS_EDIT; ?></th>
			<th><?php echo TABLE_HEADING_NEW_ORDERS_DELETE; ?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$ergebnis = xtc_db_query("SELECT * FROM " . TABLE_ORDERS . " ORDER BY orders_id DESC LIMIT 20");
	while($row = xtc_db_fetch_array($ergebnis)){
	?>
		<tr>
			<td><?php  echo $row-> orders_id; ?></td>
			<td><?php echo $row-> date_purchased; ?></td>
			<td><?php  echo $row-> delivery_name; ?></td>
			<td><a href="orders.php?page=1&oID=<?php echo $row-> orders_id; ?>&action=edit"><?php echo TABLE_CELL_NEW_CUSTOMERS_EDIT; ?></a></td>
			<td><a href="orders.php?page=1&oID=<?php echo $row-> orders_id; ?>&action=delete"><?php echo TABLE_CELL_NEW_CUSTOMERS_DELETE; ?></a></td>
		</tr>
	<?php

	}

	?>
	</tbody>
</table>