<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypal.php 192 2007-02-24 16:24:52Z mzanier $
   XT-Commerce - community made shopping
   http://www.xt-commerce.com
   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(paypal.php,v 1.7 2002/04/17); www.oscommerce.com
   (c) 2003         nextcommerce (paypal.php,v 1.4 2003/08/13); www.nextcommerce.org
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
define('MODULE_PAYMENT_PAYPAL_TEXT_TITLE', 'PayPal Checkout');
define('MODULE_PAYMENT_PAYPAL_TEXT_INFO','<img src="https://www.paypal.com/de_DE/DE/i/logo/lockbox_150x47.gif" />');
define('MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', 'Après "confirmer", vous serez dirigé vers PayPal pour payer votre commande.<br />Retour dans la boutique, vous recevrez votre e-mail.');
define('MODULE_PAYMENT_PAYPAL_ALLOWED_TITLE' , 'Zones autorisées');
define('MODULE_PAYMENT_PAYPAL_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
define('MODULE_PAYMENT_PAYPAL_STATUS_TITLE', 'Activer le module PayPal');
define('MODULE_PAYMENT_PAYPAL_STATUS_DESC', 'Voudriez-vous accepter PayPal payments?');
define('MODULE_PAYMENT_PAYPAL_SORT_ORDER_TITLE' , 'Ordre de tri de la vue.');
define('MODULE_PAYMENT_PAYPAL_SORT_ORDER_DESC' , 'Ordre de tri de la vue. Le chiffre le plus bas sera affiché en premier.');
define('MODULE_PAYMENT_PAYPAL_ZONE_TITLE' , 'Zone de paiement');
define('MODULE_PAYMENT_PAYPAL_ZONE_DESC' , 'Si une zone est choisie, le mode de paiement ne sera valable que pour cette zone.');
define('MODULE_PAYMENT_PAYPAL_LP', '<br /><br /><a target="_blank" rel="noopener" href="http://www.paypal.com/de/webapps/mpp/referral/paypal-business-account2"><strong>Créez un compte PayPal maintenant.</strong></a>');
?>
