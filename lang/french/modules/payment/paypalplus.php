<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypalplus.php 10346 2016-10-26 13:17:10Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


$lang_array = array(
  'MODULE_PAYMENT_PAYPALPLUS_TEXT_TITLE' => 'PayPal Plus',
  'MODULE_PAYMENT_PAYPALPLUS_TEXT_INFO' => '<div style="padding: 15px;text-align: center;margin: 10px 0px -13px;color: #003087;">Veuillez sélectionner l&apos;une des méthodes de paiement listées ici en cliquant.</div>',
  'MODULE_PAYMENT_PAYPALPLUS_TEXT_DESCRIPTION' => 'Après "confirmer", vous serez dirigé vers PayPal pour payer votre commande.<br />De retour dans la boutique, vous recevrez votre email de confirmation.<br />PayPal est le moyen le plus sûr de payer en ligne. Nous gardons vos coordonnées à l&apos;abri des autres et pouvons vous aider à récupérer votre argent en cas de problème.',
  'MODULE_PAYMENT_PAYPALPLUS_ALLOWED_TITLE' => 'Zones autorisées',
  'MODULE_PAYMENT_PAYPALPLUS_ALLOWED_DESC' => 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).',
  'MODULE_PAYMENT_PAYPALPLUS_STATUS_TITLE' => 'Activer le module PayPal',
  'MODULE_PAYMENT_PAYPALPLUS_STATUS_DESC' => 'Voudriez-vous accepter PayPal payments?',
  'MODULE_PAYMENT_PAYPALPLUS_SORT_ORDER_TITLE' => 'Ordre de tri de la vue.',
  'MODULE_PAYMENT_PAYPALPLUS_SORT_ORDER_DESC' => 'Ordre de tri de la vue. Le chiffre le plus bas sera affiché en premier.',
  'MODULE_PAYMENT_PAYPALPLUS_ZONE_TITLE' => 'Zone de paiement',
  'MODULE_PAYMENT_PAYPALPLUS_ZONE_DESC' => 'Si une zone est choisie, le mode de paiement ne sera valable que pour cette zone.',
  'MODULE_PAYMENT_PAYPALPLUS_LP' => '<br /><br /><a target="_blank" rel="noopener" href="http://www.paypal.com/de/webapps/mpp/referral/paypal-business-account2?partner_id=EHALBVD4M2RQS"><strong>Créez un compte PayPal maintenant.</strong></a>',

  'MODULE_PAYMENT_PAYPALPLUS_TEXT_EXTENDED_DESCRIPTION' => '<strong><font color="red">ATTENTION:</font></strong> Veuillez configurer la configuration de PayPal under "Partner Modules" -> "PayPal" -> <a href="'.xtc_href_link('paypal_config.php').'"><strong>"PayPal Configuration"</strong></a>!',

  'MODULE_PAYMENT_PAYPALPLUS_TEXT_ERROR_HEADING' => 'Note',
  'MODULE_PAYMENT_PAYPALPLUS_TEXT_ERROR_MESSAGE' => 'Le paiement PayPal a été annulé.',

  'MODULE_PAYMENT_PAYPALPLUS_INVOICE' => 'payer sur facture',
);


foreach ($lang_array as $key => $val) {
  defined($key) or define($key, $val);
}
?>