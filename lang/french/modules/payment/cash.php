<?php

/* -----------------------------------------------------------------------------------------
   $Id: cash.php 1102 2005-07-24 15:05:38Z mz $

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

define('MODULE_PAYMENT_CASH_TEXT_DESCRIPTION', 'argent liquide');
define('MODULE_PAYMENT_CASH_TEXT_TITLE', 'argent liquide');
define('MODULE_PAYMENT_CASH_TEXT_INFO', '');
define('MODULE_PAYMENT_CASH_STATUS_TITLE', 'Activer le module de paiement en liquide');
define('MODULE_PAYMENT_CASH_STATUS_DESC', 'Voulez-vous accepter l&apos;argent comptant comme moyen de paiement ?');
define('MODULE_PAYMENT_CASH_ORDER_STATUS_ID_TITLE', 'Définir le statut de l&apos;ordre');
define('MODULE_PAYMENT_CASH_ORDER_STATUS_ID_DESC', 'Définir le statut des commandes passées avec ce module de paiement à cette valeur.');
define('MODULE_PAYMENT_CASH_SORT_ORDER_TITLE', 'Sort order of display.');
define('MODULE_PAYMENT_CASH_SORT_ORDER_DESC', 'Ordre de tri de l&apos;affichage. Le plus bas est affiché en premier.');
define('MODULE_PAYMENT_CASH_ZONE_TITLE', 'Zone de paiement');
define('MODULE_PAYMENT_CASH_ZONE_DESC', 'Si une zone est sélectionnée, n&apos;activez ce mode de paiement que pour cette zone.');
define('MODULE_PAYMENT_CASH_ALLOWED_TITLE', 'Zones autorisées');
define('MODULE_PAYMENT_CASH_ALLOWED_DESC', 'Veuillez entrer les zones <b>séparément</b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
?>