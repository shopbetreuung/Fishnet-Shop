<?php

	define('TABLE_CAPTION_NEW_CUSTOMERS', 'Neue Kunden');
	define('TABLE_CAPTION_NEW_CUSTOMERS_COMMENT', '(die letzten 15)');
	define('TABLE_HEADING_NEW_CUSTOMERS_LASTNAME', 'Name');
	define('TABLE_HEADING_NEW_CUSTOMERS_FIRSTNAME', 'Vorname');
	define('TABLE_HEADING_NEW_CUSTOMERS_REGISTERED', 'angemeldet am');
	define('TABLE_HEADING_NEW_CUSTOMERS_EDIT', 'bearbeiten');
	define('TABLE_HEADING_NEW_CUSTOMERS_ORDERS', 'Bestellungen');
	define('TABLE_CELL_NEW_CUSTOMERS_EDIT', 'bearbeiten');
	define('TABLE_CELL_NEW_CUSTOMERS_ORDERS', 'Bestellungen');

?>

<p class="h3" style="margin-top: 0;"><?php echo TABLE_CAPTION_NEW_CUSTOMERS; ?> <small><?php echo TABLE_CAPTION_NEW_CUSTOMERS_COMMENT; ?></small></p>

<table class="table table-striped">
	<thead>
		<tr>
			<th><?php echo TABLE_HEADING_NEW_CUSTOMERS_LASTNAME; ?></th>
			<th><?php echo TABLE_HEADING_NEW_CUSTOMERS_FIRSTNAME; ?></th>
			<th><?php echo TABLE_HEADING_NEW_CUSTOMERS_REGISTERED; ?></th>
			<th><?php echo TABLE_HEADING_NEW_CUSTOMERS_EDIT; ?></th>
			<th><?php echo TABLE_HEADING_NEW_CUSTOMERS_ORDERS; ?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	  $ergebnis = xtc_db_query("SELECT * FROM " . TABLE_CUSTOMERS . " ORDER BY customers_date_added DESC LIMIT 15");
	  while($row = xtc_db_fetch_array($ergebnis)) {
	?>
		<tr>
			<td><?php  echo $row["customers_lastname"]; ?></td>
			<td><?php  echo $row["customers_firstname"]; ?></td>
			<td><?php  echo $row["customers_date_added"]; ?> </td>
			<td>
				<a href="customers.php?page=1&cID=<?php echo $row["customers_id"]; ?>&action=edit">
					<?php echo TABLE_CELL_NEW_CUSTOMERS_EDIT; ?>
				</a>
			</td>
			<td>
				<a href="orders.php?cID=<?php echo $row["customers_id"]; ?>">
					<?php echo TABLE_CELL_NEW_CUSTOMERS_ORDERS; ?>
				</a>
			</td>
		</tr>
	<?php
	  }
	?>
	</tbody>
</table>