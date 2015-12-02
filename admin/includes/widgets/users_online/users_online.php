<p class="h3" style="margin-top: 0;"><?php echo TABLE_CAPTION_USERS_ONLINE; ?></p>

<table class="table table-striped">
	<thead>
		<tr>
			<th><?php echo TABLE_HEADING_USERS_ONLINE_SINCE; ?></th>
			<th><?php echo TABLE_HEADING_USERS_ONLINE_NAME; ?></th>
			<th><?php echo TABLE_HEADING_USERS_ONLINE_LAST_CLICK; ?></th>
			<th><?php echo TABLE_HEADING_USERS_ONLINE_INFO; ?></th>
		</tr>
	</thead>
	<tbody>
	<?php

	$whos_online_query = xtc_db_query("select customer_id, full_name, ip_address, time_entry, time_last_click, last_page_url, session_id from " . TABLE_WHOS_ONLINE ." order by time_last_click desc");

	while ($whos_online = xtc_db_fetch_array($whos_online_query)) {	
		$time_online = (time() - $whos_online['time_entry']);	
		if ( ((!$_GET['info']) || (@$_GET['info'] == $whos_online['session_id'])) && (!$info) ) {	
			$info = $whos_online['session_id'];	
		}	    
		?>
		<tr>
			<td><a href="whos_online.php?info=<?php echo $whos_online['session_id']; ?>"><?php echo gmdate('H:i:s', $time_online); ?></a></td>
			<td><a href="whos_online.php?info=<?php echo $whos_online['session_id']; ?>"><?php echo $whos_online['full_name']; ?></a></td>
			<td><a href="whos_online.php?info=<?php echo $whos_online['session_id']; ?>"><?php echo date('H:i:s', $whos_online['time_last_click']); ?></a></td>
			<td><a href="whos_online.php?info=<?php echo $whos_online['session_id']; ?>"><?php echo TABLE_CELL_USERS_ONLINE_INFO; ?></u></td>
		</tr>
	<?php	
	}	
	?>       
	</tbody>
</table>