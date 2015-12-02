<?php
/**
 * Project:	xt:Commerce - eCommerce Engine
 * @version $Id
 *
 * xt:Commerce - Shopsoftware
 * (c) 2003-2007 xt:Commerce (Winger/Zanier), http://www.xt-commerce.com
 *
 * xt:Commerce ist eine geschützte Handelsmarke und wird vertreten durch die xt:Commerce GmbH (Austria)
 * xt:Commerce is a protected trademark and represented by the xt:Commerce GmbH (Austria)
 *
 * @copyright Copyright 2003-2007 xt:Commerce (Winger/Zanier), www.xt-commerce.com
 * @copyright based on Copyright 2002-2003 osCommerce; www.oscommerce.com
 * @copyright Porttions Copyright 2003-2007 Zen Cart Development Team
 * @copyright Porttions Copyright 2004 DevosC.com
 * @license http://www.xt-commerce.com.com/license/2_0.txt GNU Public License V2.0
 *
 * For questions, help, comments, discussion, etc., please join the
 * xt:Commerce Support Forums at www.xt-commerce.com
 *
 */
if(isset($error)) echo $error;
echo xtc_draw_form('refund_transaction', FILENAME_PAYPAL, xtc_get_all_get_params(array('action')) . 'action=perform');
echo xtc_draw_hidden_field('txn_id', $ipn_data['txn_id']);
echo xtc_draw_hidden_field('amount', $ipn_data['mc_gross']);
echo xtc_draw_hidden_field('ipn_id', (int)$_GET['paypal_ipn_id']);
?>
<div class="highlightbox">
	<p class="h3"><?php echo TEXT_PAYPAL_CAPTURE_TRANSACTION; ?></p>
	<p><?php echo TEXT_PAYPAL_NOTE_CAPTURE_INFO; ?></p>
        <div class="col-xs-12"><hr noshade></div>
		<div class="col-xs-12">
			<div class="col-xs-12 col-sm-3"><?php echo TEXT_PAYPAL_TXN_ID; ?></div>
			<div class="col-xs-12 col-sm-9"><?php echo $ipn_data['txn_id']; ?></div>
		</div>
		<div class="col-xs-12">
			<div class="col-xs-12 col-sm-3"><?php echo TEXT_PAYPAL_ADRESS; ?></div>
			<div class="col-xs-12 col-sm-9"><?php echo $ipn_data['address_name']; ?></div>
		</div>
		<div class="col-xs-12">
			<div class="col-xs-12 col-sm-3"><?php echo TEXT_PAYPAL_PAYER_EMAIL; ?></div>
			<div class="col-xs-12 col-sm-9" valign="middle"><?php echo $ipn_data['payer_email'];?></div>
		</div>
		<div class="col-xs-12">
			<div class="col-xs-12 col-sm-3"><?php echo TEXT_PAYPAL_TRANSACTION_AUTH_TOTAL; ?></div>
			<div class="col-xs-12 col-sm-9"><?php echo $ipn_data['mc_authorization'].' '.$ipn_data['mc_currency']; ?></div>
		</div>
		<div class="col-xs-12">
			<div class="col-xs-12 col-sm-3"><?php echo TEXT_PAYPAL_TRANSACTION_AUTH_CAPTURED; ?></div>
			<div class="col-xs-12 col-sm-9"><?php echo $ipn_data['mc_captured'].' '.$ipn_data['mc_currency']; ?></div>
		</div>
		<div class="col-xs-12">
			<div class="col-xs-12 col-sm-3"><?php echo TEXT_PAYPAL_TRANSACTION_AUTH_OPEN; ?></div>
			<div class="col-xs-12 col-sm-9"><?php echo $ipn_data['mc_authorization']-$ipn_data['mc_captured'].' '.$ipn_data['mc_currency']; ?></div>
		</div>
		<div class="col-xs-12">
			<div class="col-xs-12 col-sm-3"><?php echo TEXT_PAYPAL_TRANSACTION_AMOUNT; ?></div>
			<div class="col-xs-12 col-sm-9"><?php echo xtc_draw_input_field('capture_amount',$ipn_data['mc_authorization']-$ipn_data['mc_captured'],'size="10"'); ?></div>
		</div>
		<div class="col-xs-12">
			<div class="col-xs-12 col-sm-3"><?php echo TEXT_PAYPAL_REFUND_NOTE; ?></div>
			<div class="col-xs-12 col-sm-9">
				<?php echo xtc_draw_textarea_field('refund_info', '', '50', '5', ''); ?>
			</div>
		</div>
	<input type="submit" class="btn btn-default" value="<?php echo CAPTURE; ?>">
	<?php echo '<a class="btn btn-default" href="'.xtc_href_link(FILENAME_PAYPAL).'">Zur&uuml;ck</a>'; ?>
</div>
</form>