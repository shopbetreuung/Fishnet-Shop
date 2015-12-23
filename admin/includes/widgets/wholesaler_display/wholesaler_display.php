<div class='row table_container'>
	<div class='col-lg-12'>
	<p class="h3" style="margin-top: 0;">Großhändler</p>
	<hr>
	<?php

		$wholesalers_query_raw = "select wholesaler_id, wholesaler_name, wholesaler_email, wholesaler_email_template from " . TABLE_WHOLESALERS . " order by wholesaler_name";
		$wholesalers_split = new splitPageResults($_GET['page'], '20', $wholesalers_query_raw, $wholesalers_query_numrows);
		$wholesalers_query = xtc_db_query($wholesalers_query_raw);
		while ($wholesalers = xtc_db_fetch_array($wholesalers_query)) {
			$product_query = xtc_db_query("SELECT count(*) as anzahl
										FROM ".TABLE_PRODUCTS." p
									   WHERE p.wholesaler_id = '".(int) $wholesalers['wholesaler_id']."' and p.products_quantity <= p.wholesaler_reorder");
			if(xtc_db_num_rows($product_query) > 0){
				$product = xtc_db_fetch_array($product_query);
				if ($product["anzahl"] > 0) {
				?>
				<div class='row table_container'>
					<div class='col-lg-12'>
						<div class='row'>
							<div class='col-lg-6'>
								<h4><?php echo $wholesalers['wholesaler_name'].' ('.$product["anzahl"].')'?></h4>
							</div>
							<div class='col-lg-6'>
								 <?php
								 echo '&nbsp;&nbsp;<a class="btn btn-default pull-right" href="' . xtc_href_link(FILENAME_WHOLESALER_LIST, 'wID=' . $wholesalers['wholesaler_id']) . '" >Nachbestellung vorbereiten</a>';
								 ?>
							</div>
						</div>
				<?php
			}
			?>  
					</div>
				</div>
			<?php
			}
		}
	?>          
	</div>
</div>