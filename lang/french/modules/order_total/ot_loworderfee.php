<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_loworderfee.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_loworderfee.php,v 1.2 2002/04/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (ot_loworderfee.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_ORDER_TOTAL_LOWORDERFEE_TITLE', 'surtaxe des petites quantités');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_DESCRIPTION', 'Supplément pour les commandes inférieures à la valeur minimale de commande.');

  define('MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS_TITLE','Afficher la surcharge de quantité minimale');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS_DESC','Souhaitez-vous voir le supplément pour la quantité minimale ?');

  define('MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER_TITLE','ordre de tri');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER_DESC','séquence de présentation');

  define('MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE_TITLE','Autoriser la surcharge pour la quantité minimale');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE_DESC','Souhaitez-vous autoriser des suppléments pour les petites quantités ?');

  define('MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER_TITLE','Supplément pour les commandes inférieures à 50 euros.');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER_DESC','Ajoutez les frais de commande réduits aux commandes d&apos;un montant inférieur à ce montant.');

  define('MODULE_ORDER_TOTAL_LOWORDERFEE_FEE_TITLE','fée de l&apos;ordre');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_FEE_DESC','Frais de commande petite.');

  define('MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION_TITLE','Attach Low Order Fee On Orders Made');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION_DESC','Attach low order fee for orders to be sent to the set destination.');

  define('MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS_TITLE','Tax Class');
  define('MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS_DESC','Use the following tax class on the low order fee.');
?>