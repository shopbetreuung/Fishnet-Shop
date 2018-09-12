<?php
/* -----------------------------------------------------------------------------------------
   $Id: UPS.php,v 1.1 2003/09/06 21:54:34 fanta2k Exp $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(UPS.php,v 1.4 2003/02/18 04:28:00); www.oscommerce.com 
   (c) 2003	 nextcommerce (UPS.php,v 1.5 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   German Post (Deutsche Post WorldNet)
   Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at
   Changes for personal use: Copyright (C) 2004 Comm4All, Bernd Blazynski | http://www.comm4all.com & http://www.cheapshirt.de

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


define('MODULE_SHIPPING_UPS_TEXT_TITLE', 'United Parcel Service Standard');
define('MODULE_SHIPPING_UPS_TEXT_DESCRIPTION', 'United Parcel Service Standard - Module d&apos;expédition');
define('MODULE_SHIPPING_UPS_TEXT_WAY', 'Expédition à');
define('MODULE_SHIPPING_UPS_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_UPS_TEXT_FREE', 'A partir de EUR ' . MODULE_SHIPPING_UPS_FREEAMOUNT . ' de valeur de commande, nous vous envoyons votre commande sans frais d&apos;expédition.');
define('MODULE_SHIPPING_UPS_TEXT_LOW', 'A partir de EUR ' . MODULE_SHIPPING_UPS_FREEAMOUNT . ' de valeur de commande, nous envoyons votre commande à des frais d&apos;expédition réduits !');
define('MODULE_SHIPPING_UPS_INVALID_ZONE', 'L&apos;expédition vers ce pays n&apos;est pas possible.');
define('MODULE_SHIPPING_UPS_UNDEFINED_RATE', 'Les frais d&apos;expédition ne peuvent pas être calculés pour le moment.');

define('MODULE_SHIPPING_UPS_STATUS_TITLE' , 'UPS Standard');
define('MODULE_SHIPPING_UPS_STATUS_DESC' , 'Voulez-vous expédier via UPS Standard ?');
define('MODULE_SHIPPING_UPS_HANDLING_TITLE' , 'Surtaxe');
define('MODULE_SHIPPING_UPS_HANDLING_DESC' , 'Supplément de traitement pour ce mode d&apos;expédition en Euro.');
define('MODULE_SHIPPING_UPS_TAX_CLASS_TITLE' , 'Cadence');
define('MODULE_SHIPPING_UPS_TAX_CLASS_DESC' , 'Sélectionnez le taux de TVA pour cette méthode d&apos;expédition.');
define('MODULE_SHIPPING_UPS_ZONE_TITLE' , 'Zone d&apos;expédition');
define('MODULE_SHIPPING_UPS_ZONE_DESC' , 'Si vous sélectionnez une zone, cette méthode d&apos;expédition n&apos;est offerte que dans cette zone.');
define('MODULE_SHIPPING_UPS_SORT_ORDER_TITLE' , 'Séquence d&apos;affichage');
define('MODULE_SHIPPING_UPS_SORT_ORDER_DESC' , 'Le plus bas est affiché en premier.');
define('MODULE_SHIPPING_UPS_ALLOWED_TITLE' , 'Zones d&apos;expédition');
define('MODULE_SHIPPING_UPS_ALLOWED_DESC' , 'Spécifiez <b>individuel</b> les zones vers lesquelles l&apos;expédition devrait être possible, par exemple : AT,DE.');
define('MODULE_SHIPPING_UPS_FREEAMOUNT_TITLE' , 'Versandkostenfrei Inland');
define('MODULE_SHIPPING_UPS_FREEAMOUNT_DESC' , 'Valeur minimale de commande pour une livraison nationale gratuite et une livraison réduite à l&aposétranger..');

define('MODULE_SHIPPING_UPS_COUNTRIES_1_TITLE' , 'Pays pour UPS Standard Zone 1');
define('MODULE_SHIPPING_UPS_COUNTRIES_1_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 1:');
define('MODULE_SHIPPING_UPS_COST_1_TITLE' , 'Tarifs UPS Standard Zone 1');
define('MODULE_SHIPPING_UPS_COST_1_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 1. Exemple : le transport entre 0 et 4 kg coûte 5,15 = 4:5.15,...');

define('MODULE_SHIPPING_UPS_COUNTRIES_2_TITLE' , 'Pays pour UPS Standard Zone 3');
define('MODULE_SHIPPING_UPS_COUNTRIES_2_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 3:');
define('MODULE_SHIPPING_UPS_COST_2_TITLE' , 'Tarifs UPS Standard Zone 3');
define('MODULE_SHIPPING_UPS_COST_2_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 3. Exemple : le transport entre 0 et 4 kg coûte 13,75 = 4:13.75,...');

define('MODULE_SHIPPING_UPS_COUNTRIES_3_TITLE' , 'Pays pour UPS Standard Zone 31');
define('MODULE_SHIPPING_UPS_COUNTRIES_3_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 31:');
define('MODULE_SHIPPING_UPS_COST_3_TITLE' , 'Tarifs UPS Standard Zone 31');
define('MODULE_SHIPPING_UPS_COST_3_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 31. Exemple : le transport entre 0 et 4 kg coûte 23,50 = 4:23.50,...');

define('MODULE_SHIPPING_UPS_COUNTRIES_4_TITLE' , 'Pays pour UPS Standard Zone 4');
define('MODULE_SHIPPING_UPS_COUNTRIES_4_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 4:');
define('MODULE_SHIPPING_UPS_COST_4_TITLE' , 'Tarifs UPS Standard Zone 4');
define('MODULE_SHIPPING_UPS_COST_4_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 4. Exemple : le transport entre 0 et 4 kg coûte 25,40 = 4:25.40,...');

define('MODULE_SHIPPING_UPS_COUNTRIES_5_TITLE' , 'Pays pour UPS Standard Zone 41');
define('MODULE_SHIPPING_UPS_COUNTRIES_5_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 41:');
define('MODULE_SHIPPING_UPS_COST_5_TITLE' , 'Tarifs UPS Standard Zone 41');
define('MODULE_SHIPPING_UPS_COST_5_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 41. Exemple : le transport entre 0 et 4 kg coûte 30,00 = 4:30.00,...');

define('MODULE_SHIPPING_UPS_COUNTRIES_6_TITLE' , 'Pays pour UPS Standard Zone 5');
define('MODULE_SHIPPING_UPS_COUNTRIES_6_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 5:');
define('MODULE_SHIPPING_UPS_COST_6_TITLE' , 'Tarifs UPS Standard Zone 5');
define('MODULE_SHIPPING_UPS_COST_6_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 5. Exemple : le transport entre 0 et 4 kg coûte 34,35 = 4:34.35,...');

define('MODULE_SHIPPING_UPS_COUNTRIES_7_TITLE' , 'Pays pour UPS Standard Zone 6');
define('MODULE_SHIPPING_UPS_COUNTRIES_7_DESC' , 'Code ISO d&apos;états séparés par des virgules pour la zone 6:');
define('MODULE_SHIPPING_UPS_COST_7_TITLE' , 'Tarifs UPS Standard Zone 6');
define('MODULE_SHIPPING_UPS_COST_7_DESC' , 'Frais d&apos;expédition basés sur le poids à l&apos;intérieur de la zone 6. Exemple : le transport entre 0 et 4 kg coûte 37,10 = 4:37.10,...');



?>