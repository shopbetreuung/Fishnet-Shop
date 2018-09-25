<?php
/* -----------------------------------------------------------------------------------------
   $Id: zones.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(zones.php,v 1.3 2002/04/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (zones.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
   // CUSTOMIZE THIS SETTING
define('NUMBER_OF_ZONES',10);

define('MODULE_SHIPPING_ZONES_TEXT_TITLE', 'Tarifs zone');
define('MODULE_SHIPPING_ZONES_TEXT_DESCRIPTION', 'Tarifs par zone');
define('MODULE_SHIPPING_ZONES_TEXT_WAY', 'Expédition à :');
define('MODULE_SHIPPING_ZONES_TEXT_UNITS', 'lb(s)');
define('MODULE_SHIPPING_ZONES_INVALID_ZONE', 'Pas de livraison disponible pour le pays sélectionné!');
define('MODULE_SHIPPING_ZONES_UNDEFINED_RATE', 'Le taux d&apos;expédition ne peut être déterminé pour le moment..');

define('MODULE_SHIPPING_ZONES_STATUS_TITLE' , 'Enable Zones Method');
define('MODULE_SHIPPING_ZONES_STATUS_DESC' , 'Do you want to offer zone rate shipping?');
define('MODULE_SHIPPING_ZONES_ALLOWED_TITLE' , 'Zones autorisées');
define('MODULE_SHIPPING_ZONES_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément</b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
define('MODULE_SHIPPING_ZONES_TAX_CLASS_TITLE' , 'Catégorie fiscale');
define('MODULE_SHIPPING_ZONES_TAX_CLASS_DESC' , 'Utilisez la classe de taxe suivante sur les frais d&apos;expédition.');
define('MODULE_SHIPPING_ZONES_SORT_ORDER_TITLE' , 'Ordre de tri');
define('MODULE_SHIPPING_ZONES_SORT_ORDER_DESC' , 'séquence de présentation');

for ($ii=0;$ii<NUMBER_OF_ZONES;$ii++) {
define('MODULE_SHIPPING_ZONES_COUNTRIES_'.$ii.'_TITLE' , 'Zone '.$ii.' Pays');
define('MODULE_SHIPPING_ZONES_COUNTRIES_'.$ii.'_DESC' , 'Liste séparée par des virgules des codes de pays ISO à deux caractères faisant partie de la zone '.$ii.'.');
define('MODULE_SHIPPING_ZONES_COST_'.$ii.'_TITLE' , 'Zone '.$ii.' Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_'.$ii.'_DESC' , 'Tarifs d&apos;expédition vers la zone '.$ii.' Destinations basées sur un groupe de poids maximum de commande. Exemple :  3:8.50,7:10.50,... Les poids inférieurs ou égaux à 3 coûteraient 8,50 pour la zone  '.$ii.' destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_'.$ii.'_TITLE' , 'Zone '.$ii.' Frais de manutention');
define('MODULE_SHIPPING_ZONES_HANDLING_'.$ii.'_DESC' , 'Frais de manutention pour cette zone d&apos;expédition');
}
?>