<?php
/* -----------------------------------------------------------------------------------------
   $Id: fedexeu.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   sur la base du: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce( fedexeu.php,v 1.01 2003/02/18 03:25:00); www.oscommerce.com 
   (c) 2003	 nextcommerce (fedexeu.php,v 1.5 2003/08/1); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   fedex_europe_1.02        	Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/



define('MODULE_SHIPPING_FEDEXEU_TEXT_TITLE', 'FedEx Express Europe');
define('MODULE_SHIPPING_FEDEXEU_TEXT_DESCRIPTION', 'FedEx Express Europe');
define('MODULE_SHIPPING_FEDEXEU_TEXT_WAY', 'Expédier à');
define('MODULE_SHIPPING_FEDEXEU_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_FEDEXEU_INVALID_ZONE', 'Malheureusement, il n&apos;est pas possible d&apos;expédier dans ce pays.');
define('MODULE_SHIPPING_FEDEXEU_UNDEFINED_RATE', 'Les frais d&apos;expédition ne peuvent pas être calculés pour le moment.');

define('MODULE_SHIPPING_FEDEXEU_STATUS_TITLE' , 'FedEx Express Europe');
define('MODULE_SHIPPING_FEDEXEU_STATUS_DESC' , 'Voulez-vous offrir l&apos;expédition FedEx Express Europe ?');
define('MODULE_SHIPPING_FEDEXEU_HANDLING_TITLE' , 'frais de manutention.');
define('MODULE_SHIPPING_FEDEXEU_HANDLING_DESC' , 'Frais de manutention pour ce mode d&apos;expédition en Euro.');
define('MODULE_SHIPPING_FEDEXEU_TAX_CLASS_TITLE' , 'Tax Rate');
define('MODULE_SHIPPING_FEDEXEU_TAX_CLASS_DESC' , 'Utilisez la classe de taxe suivante sur les frais d&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_ZONE_TITLE' , 'Zone d&apos;expédition');
define('MODULE_SHIPPING_FEDEXEU_ZONE_DESC' , 'Si une zone est sélectionnée, n&apos;activez cette méthode d&apos;expédition que pour cette zone.');
define('MODULE_SHIPPING_FEDEXEU_SORT_ORDER_TITLE' , 'Ordre de tri');
define('MODULE_SHIPPING_FEDEXEU_SORT_ORDER_DESC' , 'séquence de présentation');
define('MODULE_SHIPPING_FEDEXEU_ALLOWED_TITLE' , 'Allowed Shipping Zones');
define('MODULE_SHIPPING_FEDEXEU_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément</b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_1_TITLE' , 'Pays de la zone 1 Europe');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_1_DESC' , 'Liste séparée par des virgules des codes de pays ISO à deux caractères faisant partie de la zone 1');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_1_TITLE' , 'Tableau d&apos;expédition pour la zone 1 jusqu&apos;à 2.50 kg PAK');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_1_DESC' , 'Tableau d&apos;expédition pour la zone 1, sur la base du <b>\'PAK\'</b> jusqu&apos;à 2.50 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_1_TITLE' , 'Shipping Table for 1 jusqu&apos;à 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_1_DESC' , 'Tableau d&apos;expédition pour la zone 1, sur la base du <b>\'BOX\'</b> jusqu&apos;à 10 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_1_TITLE' , 'Supplément de prix jusqu&apos;à 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_1_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_1_TITLE' , 'Supplément de prix jusqu&apos;à 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_1_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_1_TITLE' , 'Supplément de prix jusqu&apos;à 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_1_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_2_TITLE' , 'Pays de la zone 2 Europe');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_2_DESC' , 'Liste séparée par des virgules des codes de pays ISO à deux caractères faisant partie de la zone 2.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_2_TITLE' , 'Tableau d&apos;expédition pour la zone 2 jusqu&apos;à 2.50 kg PAK');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_2_DESC' , 'Shipping Table for die Zone 2, sur la base du <b>\'PAK\'</b> jusqu&apos;à 2.50 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_2_TITLE' , 'Tableau d&apos;expédition pour la zone 2 jusqu&apos;à 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_2_DESC' , 'Tableau d&apos;expédition pour la zone 2, sur la base du <b>\'BOX\'</b> jusqu&apos;à 10 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_2_TITLE' , 'Supplément de prix jusqu&apos;à 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_2_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_2_TITLE' , 'Supplément de prix jusqu&apos;à 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_2_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_2_TITLE' , 'Supplément de prix jusqu&apos;à 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_2_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_3_TITLE' , 'Pays de la zone 3 Europe');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_3_DESC' , 'Liste séparée par des virgules des codes de pays ISO à deux caractères faisant partie de la zone 3.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_3_TITLE' , 'Tableau d&apos;expédition pour la zone 3 jusqu&apos;à 2.50 kg PAK');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_3_DESC' , 'Tableau d&apos;expédition pour la zone 3, sur la base du <b>\'PAK\'</b> jusqu&apos;à 2.50 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_3_TITLE' , 'Tableau d&apos;expédition pour la zone 3 jusqu&apos;à 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_3_DESC' , 'Tableau d&apos;expédition pour la zone 3, sur la base du <b>\'BOX\'</b> jusqu&apos;à 10 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_3_TITLE' , 'Supplément de prix jusqu&apos;à 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_3_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_3_TITLE' , 'Supplément de prix jusqu&apos;à 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_3_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_3_TITLE' , 'Supplément de prix jusqu&apos;à 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_3_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_4_TITLE' , 'World Zone A Europe');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_4_DESC' , 'Liste séparée par des virgules des codes de pays ISO à deux caractères faisant partie de la zone World A.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_4_TITLE' , 'Tableau d&apos;expédition pour la zone A jusqu&apos;à 2.50 kg PAK');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_4_DESC' , 'Tableau d&apos;expédition pour la zone A, sur la base du <b>\'PAK\'</b> jusqu&apos;à 2.50 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_4_TITLE' , 'Tableau d&apos;expédition pour la zone A jusqu&apos;à 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_4_DESC' , 'Tableau d&apos;expédition pour la zone A, sur la base du <b>\'BOX\'</b> jusqu&apos;à 10 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_4_TITLE' , 'Supplément de prix jusqu&apos;à 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_4_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_4_TITLE' , 'Supplément de prix jusqu&apos;à 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_4_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_4_TITLE' , 'Supplément de prix jusqu&apos;à 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_4_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_5_TITLE' , 'World Zone B Europe');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_5_DESC' , 'Liste séparée par des virgules des codes de pays ISO à deux caractères faisant partie de la zone World B.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_5_TITLE' , 'Tableau d&apos;expédition pour la zone B jusqu&apos;à 2.50 kg PAK');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_5_DESC' , 'Tableau d&apos;expédition pour la zone B, sur la base du <b>\'PAK\'</b> jusqu&apos;à 2.50 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_5_TITLE' , 'Tableau d&apos;expédition pour la zone B jusqu&apos;à 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_5_DESC' , 'Tableau d&apos;expédition pour la zone B, sur la base du <b>\'BOX\'</b> jusqu&apos;à 10 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_5_TITLE' , 'Supplément de prix jusqu&apos;à 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_5_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_5_TITLE' , 'Supplément de prix jusqu&apos;à 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_5_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_5_TITLE' , 'Supplément de prix jusqu&apos;à 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_5_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_6_TITLE' , 'World Zone C Europe');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_6_DESC' , 'Liste séparée par des virgules des codes de pays ISO à deux caractères faisant partie de la zone World C.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_6_TITLE' , 'Tableau d&apos;expédition pour la zone C jusqu&apos;à 2.50 kg PAK');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_6_DESC' , 'Tableau d&apos;expédition pour la zone C, sur la base du <b>\'PAK\'</b> jusqu&apos;à 2.50 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_6_TITLE' , 'Tableau d&apos;expédition pour la zone C jusqu&apos;à 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_6_DESC' , 'Tableau d&apos;expédition pour la zone C, sur la base du <b>\'BOX\'</b> jusqu&apos;à 10 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_6_TITLE' , 'Supplément de prix jusqu&apos;à 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_6_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_6_TITLE' , 'Supplément de prix jusqu&apos;à 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_6_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_6_TITLE' , 'Supplément de prix jusqu&apos;à 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_6_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_7_TITLE' , 'World Zone D Europe');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_7_DESC' , 'Liste séparée par des virgules des codes de pays ISO à deux caractères faisant partie de la zone World D.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_7_TITLE' , 'Tableau d&apos;expédition pour la zone D jusqu&apos;à 2.50 kg PAK');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_7_DESC' , 'Tableau d&apos;expédition pour la zone D, sur la base du <b>\'PAK\'</b> jusqu&apos;à 2.50 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_7_TITLE' , 'Tableau d&apos;expédition pour la zone D jusqu&apos;à 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_7_DESC' , 'Tableau d&apos;expédition pour la zone D, sur la base du <b>\'BOX\'</b> jusqu&apos;à 10 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_7_TITLE' , 'Supplément de prix jusqu&apos;à 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_7_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_7_TITLE' , 'Supplément de prix jusqu&apos;à 40 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_7_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_7_TITLE' , 'Supplément de prix jusqu&apos;à 70 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_7_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_8_TITLE' , 'World Zone E Europe');
define('MODULE_SHIPPING_FEDEXEU_COUNTRIES_8_DESC' , 'Liste séparée par des virgules des codes de pays ISO à deux caractères faisant partie de la zone World E.');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_8_TITLE' , 'Tableau d&apos;expédition pour la zone E jusqu&apos;à 2.50 kg PAK');
define('MODULE_SHIPPING_FEDEXEU_COST_PAK_8_DESC' , 'Tableau d&apos;expédition pour la zone E, sur la base du <b>\'PAK\'</b> jusqu&apos;à 2.50 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_8_TITLE' , 'Tableau d&apos;expédition pour la zone E jusqu&apos;à 10 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_COST_BOX_8_DESC' , 'Tableau d&apos;expédition pour la zone E, sur la base du <b>\'BOX\'</b> jusqu&apos;à 10 kg poids à l&apos;expédition.');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_8_TITLE' , 'Supplément de prix jusqu&apos;à 20 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_20_8_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_8_TITLE' , 'Supplément de prix jusqu&apos;à 30 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_40_8_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_8_TITLE' , 'Supplément de prix jusqu&apos;à 50 kg BOX');
define('MODULE_SHIPPING_FEDEXEU_STEP_BOX_70_8_DESC' , 'Supplément pour chaque 0,50 kg supplémentaire en EUR');
?>
