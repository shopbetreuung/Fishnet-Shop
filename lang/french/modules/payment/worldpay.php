<?php
/* -----------------------------------------------------------------------------------------
   $Id: worldpay.php,v 1.0
   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   Anpassung Worldpay by XTC-Webservice.de, Matthias Hinsche
   -----------------------------------------------------------------------------------------
   based on:

  Author : 	Graeme Conkie (graeme@conkie.net)
  Title: WorldPay Payment Callback Module V4.0 Version 1.4

  Revisions:
	Version MS1a Cleaned up code, moved static English to language file to allow for bi-lingual use,
	        Now posting language code to WP, Redirect on failure now to Checkout Payment,
			Reduced re-direct time to 8 seconds, added MD5, made callback dynamic 
			NOTE: YOU MUST CHANGE THE CALLBACK URL IN WP ADMIN TO <wpdisplay item="MC_callback">
	Version 1.4 Removes boxes to prevent users from clicking away before update, 
			Fixes currency for Yen, 
			Redirects to Checkout_Process after 10 seconds or click by user
	Version 1.3 Fixes problem with Multi Currency
	Version 1.2 Added Sort Order and Default order status to work with snapshots after 14 Jan 2003
	Version 1.1 Added Worldpay Pre-Authorisation ability
	Version 1.0 Initial Payment Module

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_WORLDPAY_TEXT_TITLE', 'Paiement sécurisé par carte de crédit');
  define('MODULE_PAYMENT_WORLDPAY_TEXT_DESC', 'Modules de paiement Worldpay');
define('MODULE_PAYMENT_WORLDPAY_TEXT_INFO','');
  define('MODULE_PAYMENT_WORLDPAY_STATUS_TITLE', 'Activer les modules WorldPay');
  define('MODULE_PAYMENT_WORLDPAY_STATUS_DESC', 'Voudriez-vous accepter WorldPay payments?');

  define('MODULE_PAYMENT_WORLDPAY_ID_TITLE', 'Worldpay Installation ID');
  define('MODULE_PAYMENT_WORLDPAY_ID_DESC', 'Votre WorldPay Select Junior ID');

  define('MODULE_PAYMENT_WORLDPAY_MODE_TITLE', 'Mode');
  define('MODULE_PAYMENT_WORLDPAY_MODE_DESC', 'Le mode dans lequel vous travaillez (100 = Test Mode Accepter, 101 = Test Mode Decline, 0 = Live)');

  define('MODULE_PAYMENT_WORLDPAY_USEMD5_TITLE', 'Utiliser MD5');
  define('MODULE_PAYMENT_WORLDPAY_USEMD5_DESC', 'Utiliser l&apos;encodage MD5 pour les transactions ? (1 = Oui, 0 = Non)');

  define('MODULE_PAYMENT_WORLDPAY_MD5KEY_TITLE', 'Utiliser MD5');
  define('MODULE_PAYMENT_WORLDPAY_MD5KEY_DESC', 'Utiliser l&apos;encodage MD5 pour les transactions ? (1 = Oui, 0 = Non)');

  define('MODULE_PAYMENT_WORLDPAY_SORT_ORDER_TITLE', 'Sort order of display.');
  define('MODULE_PAYMENT_WORLDPAY_SORT_ORDER_DESC', 'Ordre de tri de l&apos;affichage. Le plus bas est affiché en premier.');

  define('MODULE_PAYMENT_WORLDPAY_USEPREAUTH_TITLE', 'Utiliser la préautorisation ?');
  define('MODULE_PAYMENT_WORLDPAY_USEPREAUTH_DESC', 'Voulez-vous préautoriser les paiements ? Par défaut=Faux. Vous devez en faire la demande auprès de WorldPay avant de l&apos;utiliser.');

  define('MODULE_PAYMENT_WORLDPAY_ORDER_STATUS_ID_TITLE', 'Définir le statut de l&apos;ordre.');
  define('MODULE_PAYMENT_WORLDPAY_ORDER_STATUS_ID_DESC', 'Définir le statut des commandes passées avec ce module de paiement à cette valeur');

  define('MODULE_PAYMENT_WORLDPAY_PREAUTH_TITLE', 'Pre-Auth');
  define('MODULE_PAYMENT_WORLDPAY_PREAUTH_DESC', 'Le mode dans lequel vous travaillez (A = Pay Now, E = Pre Auth). Ignoré si Use PreAuth est faux.');

  define('MODULE_PAYMENT_WORLDPAY_ZONE_TITLE', 'Zone de paiement');
  define('MODULE_PAYMENT_WORLDPAY_ZONE_DESC', 'Si une zone est sélectionnée, n&apos;activez ce mode de paiement que pour cette zone.');

define('MODULE_PAYMENT_WORLDPAY_ALLOWED_TITLE' , 'Zones autorisées');
define('MODULE_PAYMENT_WORLDPAY_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');

?>