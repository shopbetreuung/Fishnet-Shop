<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypalinstallment.php 10425 2016-11-23 13:29:31Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


$lang_array = array(
  'MODULE_PAYMENT_PAYPALINSTALLMENT_TEXT_TITLE' => 'Paiement par acomptes provisionnels Powered by PayPal',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_TEXT_INFO' => '<img src="https://www.paypal.com/de_DE/DE/i/logo/lockbox_150x47.gif" />',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_TEXT_DESCRIPTION' => 'Après "Confirmation", vous serez dirigé vers PayPal pour payer votre commande.<br />Vous retournerez ensuite à la boutique et recevrez votre confirmation de commande.<br />Payez plus vite maintenant avec la protection illimitée PayPal - gratuitement, bien sûr.',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_ALLOWED_TITLE' => 'Zones autorisées',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_ALLOWED_DESC' => 'Spécifiez <b>individuel</b>les zones qui devraient être autorisées pour ce module. (p. ex. AT,DE (si vide, toutes les zones sont autorisées)). ',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_STATUS_TITLE' => 'PayPal Modul aktivieren',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_STATUS_DESC' => 'M&ouml;chten Sie Zahlungen per PayPal akzeptieren?',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_SORT_ORDER_TITLE' => 'séquence de présentation',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_SORT_ORDER_DESC' => 'Séquence d&apos;affichage. Le plus petit chiffre est affiché en premier.',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_ZONE_TITLE' => 'zone de paiement',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_ZONE_DESC' => 'Si une zone est sélectionnée, le mode de paiement ne s&apos;applique qu&apos;à cette zone.',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_LP' => '<br /><br /><a target="_blank" rel="noopener" href="http://www.paypal.com/de/webapps/mpp/referral/paypal-business-account2?partner_id=EHALBVD4M2RQS"><strong>Jetzt PayPal Konto hier erstellen.</strong></a>',

  'MODULE_PAYMENT_PAYPALINSTALLMENT_TEXT_EXTENDED_DESCRIPTION' => '<strong><font color="red">ATTENTION:</font></strong> Veuillez effectuer les réglages sous  "Partner Module" -> "PayPal" -> <a href="'.xtc_href_link('paypal_config.php').'"><strong>"PayPal Konfiguration"</strong></a> ',

  'MODULE_PAYMENT_PAYPALINSTALLMENT_TEXT_ERROR_HEADING' => 'Note',
  'MODULE_PAYMENT_PAYPALINSTALLMENT_TEXT_ERROR_MESSAGE' => 'Le paiement PayPal a été annulé',
);


foreach ($lang_array as $key => $val) {
  defined($key) or define($key, $val);
}
?>