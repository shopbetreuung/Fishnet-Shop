<?php
/* -----------------------------------------------------------------------------------------
   $Id: invoice.php 1101 2005-07-24 14:51:13Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.28 2003/02/14); www.oscommerce.com
   (c) 2003	 nextcommerce (invoice.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_INVOICE_TEXT_DESCRIPTION', 'Facture');
define('MODULE_PAYMENT_INVOICE_TEXT_TITLE', 'Facture');
define('MODULE_PAYMENT_INVOICE_TEXT_INFO','');
define('MODULE_PAYMENT_INVOICE_STATUS_TITLE' , 'Activer le module Factures');
define('MODULE_PAYMENT_INVOICE_STATUS_DESC' , 'Voudriez-vous accepter Factures comme moyen de paiement ');
define('MODULE_PAYMENT_INVOICE_ORDER_STATUS_ID_TITLE' , 'Définir le statut de l&apos;ordre.');
define('MODULE_PAYMENT_INVOICE_ORDER_STATUS_ID_DESC' , 'Définir le statut des commandes passées avec ce module de paiement à cette valeur');
define('MODULE_PAYMENT_INVOICE_SORT_ORDER_TITLE' , 'Sort order of display.');
define('MODULE_PAYMENT_INVOICE_SORT_ORDER_DESC' , 'Ordre de tri de l&apos;affichage. Le plus bas est affiché en premier.');
define('MODULE_PAYMENT_INVOICE_ZONE_TITLE' , 'Zone de paiement');
define('MODULE_PAYMENT_INVOICE_ZONE_DESC' , 'Si une zone est sélectionnée, n&apos;activez ce mode de paiement que pour cette zone.');
define('MODULE_PAYMENT_INVOICE_ALLOWED_TITLE' , 'Zones autorisées');
define('MODULE_PAYMENT_INVOICE_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
define('MODULE_PAYMENT_INVOICE_MIN_ORDER_TITLE' , 'Commandes minimales');
define('MODULE_PAYMENT_INVOICE_MIN_ORDER_DESC' , 'Commandes minimales pour qu&apos;un client puisse voir cette option.');
?>