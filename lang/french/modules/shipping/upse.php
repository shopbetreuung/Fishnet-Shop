<?php
/* -----------------------------------------------------------------------------------------
   $Id: UPS.php,v 1.1 2003/09/06 21:54:34 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce( fedexeu.php,v 1.01 2003/02/18 03:25:00); www.oscommerce.com 
   (c) 2003	 nextcommerce (fedexeu.php,v 1.5 2003/08/1); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   fedex_europe_1.02        	Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/



define('MODULE_SHIPPING_UPSE_TEXT_TITLE', 'United Parcel Service Express');
define('MODULE_SHIPPING_UPSE_TEXT_DESCRIPTION', 'United Parcel Service Express - Module d&apos;expédition');
define('MODULE_SHIPPING_UPSE_TEXT_WAY', 'Expédition à');
define('MODULE_SHIPPING_UPSE_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_UPSE_INVALID_ZONE', 'L&apos;expédition vers ce pays n&apos;est pas possible.');
define('MODULE_SHIPPING_UPSE_UNDEFINED_RATE', 'Les frais d&apos;expédition ne peuvent pas être calculés pour le moment.');

define('MODULE_SHIPPING_UPSE_STATUS_TITLE' , 'UPS Express');
define('MODULE_SHIPPING_UPSE_STATUS_DESC' , 'Souhaitez-vous offrir l&apos;expédition par UPS Express ?');
define('MODULE_SHIPPING_UPSE_HANDLING_TITLE' , 'Surtaxe');
define('MODULE_SHIPPING_UPSE_HANDLING_DESC' , 'Supplément de traitement pour ce mode d&apos;expédition en Euro.');
define('MODULE_SHIPPING_UPSE_TAX_CLASS_TITLE' , 'Cadence');
define('MODULE_SHIPPING_UPSE_TAX_CLASS_DESC' , 'Sélectionnez le taux de TVA pour cette méthode d&apos;expédition.');
define('MODULE_SHIPPING_UPSE_ZONE_TITLE' , 'Zone d&apos;expédition');
define('MODULE_SHIPPING_UPSE_ZONE_DESC' , 'Si vous sélectionnez une zone, cette méthode d&apos;expédition n&apos;est offerte que dans cette zone.');
define('MODULE_SHIPPING_UPSE_SORT_ORDER_TITLE' , 'Séquence d&apos;affichage');
define('MODULE_SHIPPING_UPSE_SORT_ORDER_DESC' , 'Le plus bas est affiché en premier.');
define('MODULE_SHIPPING_UPSE_ALLOWED_TITLE' , 'Zones d&apos;expédition');
define('MODULE_SHIPPING_UPSE_ALLOWED_DESC' , 'Spécifiez <b>individuel</b> les zones vers lesquelles l&apos;expédition devrait être possible, par exemple : AT,DE.');


/* UPS Express

*/

define('MODULE_SHIPPING_UPSE_COUNTRIES_1_TITLE' , 'Pays pour la zone UPS Express 1');
define('MODULE_SHIPPING_UPSE_COUNTRIES_1_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 1:');
define('MODULE_SHIPPING_UPSE_COST_1_TITLE' , 'Tarifs de la zone UPS Express 1');
define('MODULE_SHIPPING_UPSE_COST_1_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 1. Exemple : le transport entre 0 et 0,5 kg coûte EUR 22,70 = 0.5:22.7,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_2_TITLE' , 'Pays pour la zone UPS Express 2');
define('MODULE_SHIPPING_UPSE_COUNTRIES_2_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 2:');
define('MODULE_SHIPPING_UPSE_COST_2_TITLE' , 'Tarifs de la zone UPS Express 2');
define('MODULE_SHIPPING_UPSE_COST_2_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 2. Exemple : le transport entre 0 et 0,5 kg coûte EUR 51,55 = 0.5:51.55,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_3_TITLE' , 'Pays pour la zone UPS Express 3');
define('MODULE_SHIPPING_UPSE_COUNTRIES_3_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 3:');
define('MODULE_SHIPPING_UPSE_COST_3_TITLE' , 'Tarifs de la zone UPS Express 3');
define('MODULE_SHIPPING_UPSE_COST_3_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 3. Exemple : le transport entre 0 et 0,5 kg coûte EUR 60,70 = 0.5:60.70,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_4_TITLE' , 'Pays pour la zone UPS Express 4');
define('MODULE_SHIPPING_UPSE_COUNTRIES_4_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 4:');
define('MODULE_SHIPPING_UPSE_COST_4_TITLE' , 'Tarifs de la zone UPS Express 4');
define('MODULE_SHIPPING_UPSE_COST_4_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 4. Exemple : le transport entre 0 et 0,5 kg coûte EUR 66,90 = 0.5:66.90,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_5_TITLE' , 'Pays pour la zone UPS Express 41');
define('MODULE_SHIPPING_UPSE_COUNTRIES_5_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 41:');
define('MODULE_SHIPPING_UPSE_COST_5_TITLE' , 'Tarifs de la zone UPS Express 41');
define('MODULE_SHIPPING_UPSE_COST_5_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 41. Exemple : le transport entre 0 et 0,5 kg coûte EUR 82,10 = 0.5:82.10,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_6_TITLE' , 'Pays pour la zone UPS Express 42');
define('MODULE_SHIPPING_UPSE_COUNTRIES_6_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 42:');
define('MODULE_SHIPPING_UPSE_COST_6_TITLE' , 'Tarifs de la zone UPS Express 42');
define('MODULE_SHIPPING_UPSE_COST_6_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 42. Exemple : le transport entre 0 et 0,5 kg coûte EUR 82,90 = 0.5:82.90,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_7_TITLE' , 'Pays pour la zone UPS Express 5');
define('MODULE_SHIPPING_UPSE_COUNTRIES_7_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 5:');
define('MODULE_SHIPPING_UPSE_COST_7_TITLE' , 'Tarifs de la zone UPS Express 5');
define('MODULE_SHIPPING_UPSE_COST_7_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 5. Exemple : le transport entre 0 et 0,5 kg coûte EUR 59,00 = 0.5:59.00,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_8_TITLE' , 'Pays pour la zone UPS Express 6');
define('MODULE_SHIPPING_UPSE_COUNTRIES_8_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 6:');
define('MODULE_SHIPPING_UPSE_COST_8_TITLE' , 'Tarifs de la zone UPS Express 6');
define('MODULE_SHIPPING_UPSE_COST_8_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 6. Exemple : le transport entre 0 et 0,5 kg coûte EUR 84,50 = 0.5:84.50,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_9_TITLE' , 'Pays pour la zone UPS Express 7');
define('MODULE_SHIPPING_UPSE_COUNTRIES_9_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 7:');
define('MODULE_SHIPPING_UPSE_COST_9_TITLE' , 'Tarifs de la zone UPS Express 7');
define('MODULE_SHIPPING_UPSE_COST_9_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 7. Exemple : le transport entre 0 et 0,5 kg coûte EUR 71,85 = 0.5:71.85,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_10_TITLE' , 'Pays pour la zone UPS Express 8');
define('MODULE_SHIPPING_UPSE_COUNTRIES_10_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 8:');
define('MODULE_SHIPPING_UPSE_COST_10_TITLE' , 'Tarifs de la zone UPS Express 8');
define('MODULE_SHIPPING_UPSE_COST_10_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 8. Exemple : le transport entre 0 et 0,5 kg coûte EUR 80,05 = 0.5:80.05,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_11_TITLE' , 'Pays pour la zone UPS Express 9');
define('MODULE_SHIPPING_UPSE_COUNTRIES_11_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 9:');
define('MODULE_SHIPPING_UPSE_COST_11_TITLE' , 'Tarifs de la zone UPS Express 9');
define('MODULE_SHIPPING_UPSE_COST_11_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 9. Exemple : le transport entre 0 et 0,5 kg coûte EUR 85,20 = 0.5:85.20,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_12_TITLE' , 'Pays pour la zone UPS Express 10');
define('MODULE_SHIPPING_UPSE_COUNTRIES_12_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 10:');
define('MODULE_SHIPPING_UPSE_COST_12_TITLE' , 'Tarifs de la zone UPS Express 10');
define('MODULE_SHIPPING_UPSE_COST_12_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 10. Exemple : le transport entre 0 et 0,5 kg coûte EUR 93,10 = 0.5:93.10,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_13_TITLE' , 'Pays pour la zone UPS Express 11');
define('MODULE_SHIPPING_UPSE_COUNTRIES_13_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 11:');
define('MODULE_SHIPPING_UPSE_COST_13_TITLE' , 'Tarifs de la zone UPS Express 11');
define('MODULE_SHIPPING_UPSE_COST_13_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 11. Exemple : le transport entre 0 et 0,5 kg coûte EUR 103,50 = 0.5:103.50,...');

define('MODULE_SHIPPING_UPSE_COUNTRIES_14_TITLE' , 'Pays pour la zone UPS Express 12');
define('MODULE_SHIPPING_UPSE_COUNTRIES_14_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 12:');
define('MODULE_SHIPPING_UPSE_COST_14_TITLE' , 'Tarifs de la zone UPS Express 12');
define('MODULE_SHIPPING_UPSE_COST_14_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 12. Exemple : le transport entre 0 et 0,5 kg coûte EUR 105,20 = 0.5:105.20,...');
?>