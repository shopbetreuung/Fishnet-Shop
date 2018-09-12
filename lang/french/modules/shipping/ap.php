<?php
/* -----------------------------------------------------------------------------------------
   $Id: ap.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ap.php,v 1.02 2003/02/18); www.oscommerce.com 
   (c) 2003	 nextcommerce (ap.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   austrian_post_1.05       	Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   

define('MODULE_SHIPPING_AP_TEXT_TITLE', 'Austrian Post AG');
define('MODULE_SHIPPING_AP_TEXT_DESCRIPTION', 'Austrian Post AG - Expédition dans le monde entier');
define('MODULE_SHIPPING_AP_TEXT_WAY', 'Expédier à');
define('MODULE_SHIPPING_AP_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_AP_INVALID_ZONE', 'Malheureusement, il n&apos;est pas possible d&apos;expédier dans ce pays.');
define('MODULE_SHIPPING_AP_UNDEFINED_RATE', 'Les frais d&apos;expédition ne peuvent pas être calculés pour le moment.');

define('MODULE_SHIPPING_AP_STATUS_TITLE' , 'Austrian Post AG');
define('MODULE_SHIPPING_AP_STATUS_DESC' , 'Vous souhaitez expédier via la poste autriche?');
define('MODULE_SHIPPING_AP_HANDLING_TITLE' , 'frais de manutention.');
define('MODULE_SHIPPING_AP_HANDLING_DESC' , 'Frais de traitement pour ce mode d&apos;expédition en Euro');
define('MODULE_SHIPPING_AP_TAX_CLASS_TITLE' , 'Cadence');
define('MODULE_SHIPPING_AP_TAX_CLASS_DESC' , 'Sélectionnez le taux de TVA pour cette méthode d&apos;expédition.');
define('MODULE_SHIPPING_AP_ZONE_TITLE' , 'Zone d&apos;expédition');
define('MODULE_SHIPPING_AP_ZONE_DESC' , 'Si vous sélectionnez une zone, cette méthode d&apos;expédition n&apos;est offerte que dans cette zone.');
define('MODULE_SHIPPING_AP_SORT_ORDER_TITLE' , 'Séquence d&apos;affichage');
define('MODULE_SHIPPING_AP_SORT_ORDER_DESC' , 'Le plus bas est affiché en premier.');
define('MODULE_SHIPPING_AP_ALLOWED_TITLE' , 'Zones d&apos;expédition');
define('MODULE_SHIPPING_AP_ALLOWED_DESC' , 'Préciser <b>individuel</b> les zones vers lesquelles l&apos;expédition devrait être possible. ex.');
define('MODULE_SHIPPING_AP_COUNTRIES_1_TITLE' , 'Zone 1a pays');
define('MODULE_SHIPPING_AP_COUNTRIES_1_DESC' , 'Liste de pays séparés par des virgules sous forme de code ISO à deux caractères Codes de pays faisant partie de la zone 1a');
define('MODULE_SHIPPING_AP_COST_1_TITLE' , 'Zone 1a Table tarifaire jusqu&apos;à 20 kg');
define('MODULE_SHIPPING_AP_COST_1_DESC' , 'Tableau tarifaire pour la zone 1a,  basé sur <b>\'Emballage rapide\'</b> jusqu&apos;à 20 kg de poids d&apos;expédition.');
define('MODULE_SHIPPING_AP_COUNTRIES_2_TITLE' , 'Zone 1b pays');
define('MODULE_SHIPPING_AP_COUNTRIES_2_DESC' , 'Liste de pays séparés par des virgules sous forme de code ISO à deux caractères Codes de pays faisant partie de la zone 1b');
define('MODULE_SHIPPING_AP_COST_2_TITLE' , 'Zone 1b Table tarifaire jusqu&apos;à 20 kg');
define('MODULE_SHIPPING_AP_COST_2_DESC' , 'Tableau tarifaire pour la zone 1b,  basé sur <b>\'Emballage rapide\'</b> jusqu&apos;à 20 kg de poids d&apos;expédition.');
define('MODULE_SHIPPING_AP_COUNTRIES_3_TITLE' , 'Zone 2 pays');
define('MODULE_SHIPPING_AP_COUNTRIES_3_DESC' , 'Liste de pays séparés par des virgules sous forme de code ISO à deux caractères Codes de pays faisant partie de la zone 2.');
define('MODULE_SHIPPING_AP_COST_3_TITLE' , 'Zone 2 Table tarifaire jusqu&apos;à 20 kg');
define('MODULE_SHIPPING_AP_COST_3_DESC' , 'Tableau tarifaire pour la zone 2, basé sur <b>\'Emballage rapide\'</b> jusqu&apos;à 20 kg de poids d&apos;expédition.');
define('MODULE_SHIPPING_AP_COUNTRIES_4_TITLE' , 'Pays de la zone 3');
define('MODULE_SHIPPING_AP_COUNTRIES_4_DESC' , 'Liste des pays séparés par des virgules sous forme de code ISO à deux caractères Codes de pays faisant partie de la zone 3.');
define('MODULE_SHIPPING_AP_COST_4_TITLE' , 'Zone 3 Table tarifaire jusqu&apos;à 20 kg');
define('MODULE_SHIPPING_AP_COST_4_DESC' , 'Tableau tarifaire pour la zone 3, basé sur <b>\'Emballage rapide\'</b> jusqu&apos;à 20 kg de poids d&apos;expédition.');
define('MODULE_SHIPPING_AP_COUNTRIES_5_TITLE' , 'Zone 4 pays');
define('MODULE_SHIPPING_AP_COUNTRIES_5_DESC' , 'Liste de pays séparés par des virgules sous forme de code ISO à deux caractères Codes de pays faisant partie de la zone 4');
define('MODULE_SHIPPING_AP_COST_5_TITLE' , 'Zone 4 Table tarifaire jusqu&apos;à 20 kg');
define('MODULE_SHIPPING_AP_COST_5_DESC' , 'Tableau tarifaire pour la zone 4, basé sur <b>\'Emballage rapide\'</b> jusqu&apos;à 20 kg de poids d&apos;expédition.');
define('MODULE_SHIPPING_AP_COUNTRIES_6_TITLE' , 'Zone 4 pays');
define('MODULE_SHIPPING_AP_COUNTRIES_6_DESC' , 'Liste de pays séparés par des virgules sous forme de code ISO à deux caractères Codes de pays faisant partie de la zone 4');
define('MODULE_SHIPPING_AP_COST_6_TITLE' , 'Zone 4 Table tarifaire jusqu&apos;à 20 kg');
define('MODULE_SHIPPING_AP_COST_6_DESC' , 'Tableau tarifaire pour la zone 4, basé sur <b>\'Emballage rapide\'</b> jusqu&apos;à 20 kg de poids d&apos;expédition.');
define('MODULE_SHIPPING_AP_COUNTRIES_7_TITLE' , 'Zone 5 pays');
define('MODULE_SHIPPING_AP_COUNTRIES_7_DESC' , 'Liste de pays séparés par des virgules sous forme de code ISO à deux caractères Codes de pays faisant partie de la zone 5');
define('MODULE_SHIPPING_AP_COST_7_TITLE' , 'Zone 5 Table tarifaire jusqu&apos;à 20 kg');
define('MODULE_SHIPPING_AP_COST_7_DESC' , 'Tableau tarifaire pour la zone 5,  basé sur <b>\'Emballage rapide\'</b> jusqu&apos;à 20 kg de poids d&apos;expédition.');
define('MODULE_SHIPPING_AP_COUNTRIES_8_TITLE' , 'Zone Inland');
define('MODULE_SHIPPING_AP_COUNTRIES_8_DESC' , 'Inlandszone');
define('MODULE_SHIPPING_AP_COST_8_TITLE' , 'Zone Table tarifaire jusqu&apos;à 31.5 kg');
define('MODULE_SHIPPING_AP_COST_8_DESC' , 'Tableau tarifaire pour la zone domestique, jusqu&apos;à 31,5 kg de poids d&apos;expédition.');
?>