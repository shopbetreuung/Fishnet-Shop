<?php
/* -----------------------------------------------------------------------------------------
   $Id: moneyorder.php 998 2005-07-07 14:18:20Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', 'Chèque / mandat-poste');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', 'Faire à l&apos;ordre de :&nbsp;' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br />Send to:<br /><br />' . nl2br(STORE_NAME_ADDRESS) . '<br /><br />' . 'Your order will not ship until we receive payment!');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "Faire à l&apos;ordre de : ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\nSend to:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Your order will not ship until we receive payment');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_INFO','Nous expédions votre commande après réception du paiement.');
  define('MODULE_PAYMENT_MONEYORDER_STATUS_TITLE' , 'Activer le module Chèque et mandat-poste');
  define('MODULE_PAYMENT_MONEYORDER_STATUS_DESC' , 'Voudriez-vous accepter Chèque?');
  define('MODULE_PAYMENT_MONEYORDER_ALLOWED_TITLE' , 'Zones autorisées');
  define('MODULE_PAYMENT_MONEYORDER_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
  define('MODULE_PAYMENT_MONEYORDER_PAYTO_TITLE' , 'Faire à l&apos;ordre de :');
  define('MODULE_PAYMENT_MONEYORDER_PAYTO_DESC' , 'À qui les paiements doivent-ils être faits à l&apos;ordre de ?');
  define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_TITLE' , 'Ordre de tri de l&apos;affichage.');
  define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_DESC' , 'Ordre de tri de l&apos;affichage. Le plus bas est affiché en premier.');
  define('MODULE_PAYMENT_MONEYORDER_ZONE_TITLE' , 'Zone de paiement');
  define('MODULE_PAYMENT_MONEYORDER_ZONE_DESC' , 'Si une zone est sélectionnée, n&apos;activez ce mode de paiement que pour cette zone.');
  define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_TITLE' , 'Définir le statut de l&apos;ordre.');
  define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_DESC' , 'Définir le statut des commandes passées avec ce module de paiement à cette valeur');
?>