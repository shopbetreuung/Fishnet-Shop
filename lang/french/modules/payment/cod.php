<?php
/* -----------------------------------------------------------------------------------------
   $Id: cod.php 998 2005-07-07 14:18:20Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.7 2002/04/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (cod.php,v 1.5 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
define('MODULE_PAYMENT_TYPE_PERMISSION', 'contre-remboursement');
define('MODULE_PAYMENT_COD_TEXT_TITLE', 'Paiement à la livraison');
define('MODULE_PAYMENT_COD_TEXT_DESCRIPTION', 'Paiement à la livraison');
define('MODULE_PAYMENT_COD_TEXT_INFO','');
define('MODULE_PAYMENT_COD_ZONE_TITLE' , 'Zone de paiement');
define('MODULE_PAYMENT_COD_ZONE_DESC' , 'Si une zone est sélectionnée, n&apos;activez ce mode de paiement que pour cette zone.');
define('MODULE_PAYMENT_COD_ALLOWED_TITLE' , 'Zones autorisées');
define('MODULE_PAYMENT_COD_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
define('MODULE_PAYMENT_COD_STATUS_TITLE' , 'Enable Cash On Delivery Module');
define('MODULE_PAYMENT_COD_STATUS_DESC' , 'Voudriez-vous accepter Cash On Delevery payments?');
define('MODULE_PAYMENT_COD_SORT_ORDER_TITLE' , 'Sort order of display');
define('MODULE_PAYMENT_COD_SORT_ORDER_DESC' , 'Ordre de tri de l&apos;affichage. Le plus bas est affiché en premier.');
define('MODULE_PAYMENT_COD_ORDER_STATUS_ID_TITLE' , 'Définir le statut de l&apos;ordre.');
define('MODULE_PAYMENT_COD_ORDER_STATUS_ID_DESC' , 'Définir le statut des commandes passées avec ce module de paiement à cette valeur');
?>