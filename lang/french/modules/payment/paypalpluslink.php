<?php
/* -----------------------------------------------------------------------------------------
   $Id$

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


$lang_array = array(
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_TITLE' => 'PayPal Plus Link',
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_INFO' => '<img src="https://www.paypal.com/de_DE/DE/i/logo/lockbox_150x47.gif" />',
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_DESCRIPTION' => 'Après "Confirmation", vous serez dirigé vers PayPal pour payer votre commande.<br />Vous retournerez ensuite à la boutique et recevrez votre confirmation de commande.<br />Payez plus vite maintenant avec la protection illimitée PayPal - gratuitement, bien sûr.',
  'MODULE_PAYMENT_PAYPALPLUSLINK_ALLOWED_TITLE' => 'Zones autorisées',
  'MODULE_PAYMENT_PAYPALPLUSLINK_ALLOWED_DESC' => 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).',
  'MODULE_PAYMENT_PAYPALPLUSLINK_STATUS_TITLE' => 'Activer le module PayPal',
  'MODULE_PAYMENT_PAYPALPLUSLINK_STATUS_DESC' => 'Voudriez-vous accepter PayPal payments?',
  'MODULE_PAYMENT_PAYPALPLUSLINK_SORT_ORDER_TITLE' => 'Ordre de tri de la vue.',
  'MODULE_PAYMENT_PAYPALPLUSLINK_SORT_ORDER_DESC' => 'Ordre de tri de la vue. Le chiffre le plus bas sera affiché en premier.',
  'MODULE_PAYMENT_PAYPALPLUSLINK_ZONE_TITLE' => 'Zone de paiement',
  'MODULE_PAYMENT_PAYPALPLUSLINK_ZONE_DESC' => 'Si une zone est choisie, le mode de paiement ne sera valable que pour cette zone.',
  'MODULE_PAYMENT_PAYPALPLUSLINK_LP' => '<br /><br /><a target="_blank" rel="noopener" href="http://www.paypal.com/de/webapps/mpp/referral/paypal-business-account2?partner_id=EHALBVD4M2RQS"><strong>Create PayPal account now.</strong></a>',

  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_EXTENDED_DESCRIPTION' => '<strong><font color="red">ATTENTION:</font></strong>  Veuillez configurer PayPal sous "Partner Modules" -> "PayPal" -> <a href="'.xtc_href_link('paypal_config.php').'"><strong>"PayPal Configuration"</strong></a>!',

  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_ERROR_HEADING' => 'Note',
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_ERROR_MESSAGE' => 'Le paiement PayPal a été annulé.',
  
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_SUCCESS' => 'Payez maintenant avec PayPal. Veuillez cliquer sur le lien suivant:<br/> %s',
  'MODULE_PAYMENT_PAYPALPLUSLINK_TEXT_COMPLETED' => 'Merci de payer avec PayPal.',
);


foreach ($lang_array as $key => $val) {
  defined($key) or define($key, $val);
}
?>