<?php
/* -----------------------------------------------------------------------------------------
   $Id: moneybookers_csi.php 3598 2012-09-06 06:22:36Z dokuman $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2006 xt:Commerce; www.xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_MONEYBOOKERS_CSI_TEXT_TITLE', 'CartaSi');
$_var = 'CartaSi via Moneybookers';
if (_PAYMENT_MONEYBOOKERS_EMAILID=='') {
  $_var.='<br /><br /><b><font color="red">Veuillez d&apos;abord configurer moneybookers.com ! (Adv. Configuration -> Partner -> Moneybookers.com)!</font></b>';
}
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_TEXT_DESCRIPTION', $_var);
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_NOCURRENCY_ERROR', 'Il n&apos;y a pas de monnaie acceptée par Moneybookers installée !');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_ERRORTEXT1', 'payment_error=');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_TEXT_INFO','');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_ERRORTEXT2', '&error=Il y a eu une erreur lors de votre paiement chez Moneybookers !');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_ORDER_TEXT', 'Date de la commande: ');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_TEXT_ERROR', 'Erreur de paiement !');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_CONFIRMATION_TEXT', 'Merci pour votre commande !');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_TRANSACTION_FAILED_TEXT', 'Votre transaction de paiement chez Moneybookers a échoué. Veuillez réessayer ou choisir une autre option de paiement !');


define('MODULE_PAYMENT_MONEYBOOKERS_CSI_STATUS_TITLE', 'Enable Moneybookers');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_STATUS_DESC', 'Voudriez-vous accepter paiements par l&apos;intermédiaire de Moneybookers?');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_SORT_ORDER_TITLE', 'Ordre de tri de l&apos;affichage.');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_SORT_ORDER_DESC', 'Ordre de tri de l&apos;affichage. Le plus bas est affiché en premier.');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_ZONE_TITLE', 'Zone de paiement');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_ZONE_DESC', 'Si une zone est sélectionnée, n&apos;activez ce mode de paiement que pour cette zone.');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_ALLOWED_TITLE' , 'Zones autorisées');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');

// BOF - Hendrik - 2010-08-11 - exlusion config for shipping modules
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_NEG_SHIPPING_TITLE', 'Exclusion en cas d&apos;expédition');
define('MODULE_PAYMENT_MONEYBOOKERS_CSI_NEG_SHIPPING_DESC', 'activer ce paiement si l&apos;un de ces modes d&apos;expédition est sélectionné (liste séparée par une virgule)');
// EOF - Hendrik - 2010-08-11 - exlusion config for shipping modules
?>