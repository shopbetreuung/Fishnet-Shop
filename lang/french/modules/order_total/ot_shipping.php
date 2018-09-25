<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_shipping.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_shipping.php,v 1.4 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (ot_shipping.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', 'frais d&apos;expédition');
  define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', 'Frais d&apos;expédition d&apos;une commande');

  define('FREE_SHIPPING_TITLE', 'Pas de frais d&apos;expédition');
  define('FREE_SHIPPING_DESCRIPTION', 'Livraison gratuite pour les commandes de plus de %s');

  define('MODULE_ORDER_TOTAL_SHIPPING_STATUS_TITLE','frais d&apos;expédition');
  define('MODULE_ORDER_TOTAL_SHIPPING_STATUS_DESC','Affichage des frais d&apos;expédition ?');

  define('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER_TITLE','ordre de tri');
  define('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER_DESC', 'séquence de présentation');

  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_TITLE','Autoriser la livraison gratuite ?');
  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_DESC','Autoriser la livraison gratuite ?');

  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_TITLE','Livraison gratuite pour les commandes nationales de plus de');
  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_DESC','Livraison gratuite pour les commandes d&apos;un montant supérieur au montant fixé.');

  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_INTERNATIONAL_TITLE','Livraison gratuite pour les commandes internationales de plus de');
  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_INTERNATIONAL_DESC','Livraison gratuite pour les commandes d&apos;un montant supérieur au montant fixé.');

  define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_TITLE','Livraison gratuite pour les commandes passéese');
  define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_DESC','Livraison gratuite pour les commandes envoyées à la destination définie.');
  
  define('MODULE_ORDER_TOTAL_SHIPPING_TAX_CLASS_TITLE','Classe fiscale');
  define('MODULE_ORDER_TOTAL_SHIPPING_TAX_CLASS_DESC','Sélectionner la classe fiscale (seulement le traitement des commandes)');   
?>