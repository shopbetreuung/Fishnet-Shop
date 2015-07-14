<?php

require_once(DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

$sales_report_query = xtc_db_query("SELECT 
										round(coalesce(sum(if(date(o.date_purchased) = current_date, ot.value, null)), 0), 2) today,
										round(coalesce(sum(if(date(o.date_purchased) = current_date - interval 1 day, ot.value, null)), 0), 2) yesterday, 
										round(coalesce(sum(if(extract(year_month from o.date_purchased) = extract(year_month from current_date), ot.value, null)), 0), 2) this_month,
										round(coalesce(sum(if(extract(year_month from o.date_purchased) = extract(year_month from current_date - interval 1 year_month), ot.value, null)), 0), 2) last_month,
										round(coalesce(sum(if(extract(year_month from o.date_purchased) = extract(year_month from current_date - interval 1 year_month) and o.orders_status <> 1, ot.value, null)), 0), 2) last_month_paid,
										round(coalesce(sum(ot.value), 0), 2) total   
									FROM
										".TABLE_ORDERS." o 
										JOIN ".TABLE_ORDERS_TOTAL." ot on ot.orders_id = o.orders_id 
									WHERE
										ot.class = 'ot_total'");
$sales_report = xtc_db_fetch_array($sales_report_query);	
?>

<table class="table table-bordered">
	<tr>
		 <th><?php echo TURNOVER_TODAY; ?>:</th>
		 <td align="right"><?php echo $currencies->format($turnover['today']); ?></td>
	</tr>
	<tr>
		 <th><?php echo TURNOVER_YESTERDAY; ?>:</th>
		 <td align="right"><?php echo $currencies->format($turnover['yesterday']); ?></td>
	</tr>
	<tr>
		 <th><?php echo TURNOVER_THIS_MONTH; ?>:</th>
		 <td align="right"><?php echo $currencies->format($turnover['this_month']); ?></td>
	</tr>
	<tr>
		 <th><?php echo TURNOVER_LAST_MONTH; ?>:</th>
		 <td align="right"><?php echo $currencies->format($turnover['last_month']); ?></td>
	</tr>
	<tr>
		 <th><?php echo TURNOVER_LAST_MONTH_PAID; ?>:</th>
		 <td align="right"><?php echo $currencies->format($turnover['last_month_paid']); ?></td>
	</tr>
	<tr>
		 <th><?php echo TOTAL_TURNOVER; ?>:</th>
		 <td align="right"><?php echo $currencies->format($turnover['total']); ?></td>
	</tr>
</table>
