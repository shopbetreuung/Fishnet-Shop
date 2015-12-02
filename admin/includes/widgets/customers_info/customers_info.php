<?php
$language_id = (int) $_SESSION['languages_id'];
$customers_query = xtc_db_query('select cs.customers_status_name cust_group, count(*) cust_count   
                     from ' . TABLE_CUSTOMERS . ' c
                     join ' . TABLE_CUSTOMERS_STATUS . ' cs on cs.customers_status_id = c.customers_status
                     --  exclude admin
                     where c.customers_status > 0
                     -- restrict to current language setting
                     and cs.language_id = ' . $language_id . '
                     group by 1
                     union
                     select \'' . TOTAL_CUSTOMERS . '\', count(*)   
                     from ' . TABLE_CUSTOMERS . '
                     order by 2 desc');
$customers = array();
while ($row = xtc_db_fetch_array($customers_query)){
  $customers[] = $row;
}

$newsletter_query = xtc_db_query("select count(*) as count 
                    from " . TABLE_NEWSLETTER_RECIPIENTS. " where mail_status='1'");
$newsletter = xtc_db_fetch_array($newsletter_query);
?>
<table class="table table-bordered"> 
	<?php
	foreach ($customers as $customer) {
		echo '<tr><td><strong>' . $customer['cust_group'] . ':</strong></td>';
		echo '<td align="center">' . $customer['cust_count'] . '</td></tr>';
	}
	?>
	<tr>
		<td><strong><?php echo TOTAL_SUBSCRIBERS; ?>:</strong></td>
		<td align="center"><?php echo $newsletter['count']; ?></td>
	</tr>
</table>

