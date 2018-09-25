<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypalexpress.php 3072 2012-06-18 15:01:13Z hhacker $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(paypal.php,v 1.7 2002/04/17); www.oscommerce.com
   (c) 2003	 nextcommerce (paypal.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2006 xt:Commerce; www.xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
define('MODULE_PAYMENT_PAYPALEXPRESS_TEXT_TITLE', 'Achat PayPal Express');
define('MODULE_PAYMENT_PAYPALEXPRESS_TEXT_DESCRIPTION', 'PayPal Express Purchase');
define('MODULE_PAYMENT_PAYPAL_TEXT_EXTENDED_DESCRIPTION', '<strong><font color="red">ATTENTION:</font></strong> Veuillez configurer la configuration de PayPal! (Adv. Configuration -> Partner -> <a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=111125').'">PayPal</a>)!');
define('MODULE_PAYMENT_PAYPALEXPRESS_TEXT_INFO', '');
define('MODULE_PAYMENT_PAYPALEXPRESS_STATUS_TITLE', 'Activer PayPal-Express module');
define('MODULE_PAYMENT_PAYPALEXPRESS_STATUS_DESC', 'Voudriez-vous accepter PayPal Express payments?');
define('MODULE_PAYMENT_PAYPALEXPRESS_ALT_BUTTON', ' Pay with PayPal ');
define('MODULE_PAYMENT_PAYPALEXPRESS_LP', '<br /><br /><a target="_blank" rel="noopener" href="http://www.paypal.com/de/webapps/mpp/referral/paypal-business-account2"><strong>Créez un compte PayPal maintenant.</strong></a>');

// Hendrik - 15.07.2010 - exlusion config for shipping modules 
define('MODULE_PAYMENT_PAYPALEXPRESS_NEG_SHIPPING_TITLE', 'Exclusion en cas d&apos;expédition'); 
define('MODULE_PAYMENT_PAYPALEXPRESS_NEG_SHIPPING_DESC', 'activer ce paiement si l&apos;un de ces modes d&apos;expédition est sélectionné (liste séparée par des virgules)');
?>