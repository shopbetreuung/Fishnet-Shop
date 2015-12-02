<?php
	$language_id = (int) $_SESSION['languages_id'];
	$orders_query = xtc_db_query('select os.orders_status_name status, coalesce(o.order_count, 0) order_count
					from ' . TABLE_ORDERS_STATUS . ' os
					left join (select orders_status, count(*) order_count
							   from ' . TABLE_ORDERS . ' 
							   group by 1) o on o.orders_status = os.orders_status_id
					where os.language_id = ' . $language_id . '
					order by os.orders_status_id');
	$orders = array();
	while ($row = xtc_db_fetch_array($orders_query)){
	  $orders[] = $row;
	}
?>

<table class="table table-bordered"> 
	<?php
	foreach ($orders as $order) {
		echo '<tr><td><strong>' . $order['status'] . ':</strong></td>';
		echo '<td>' . $order['order_count'] . '</td></tr>';
	}
	?>	
</table>
