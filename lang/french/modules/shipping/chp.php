<?php
/* -----------------------------------------------------------------------------------------
   $Id: chp.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(chp.php,v 1.01 2003/02/18 03:30:00); www.oscommerce.com 
   (c) 2003	 nextcommerce (chp.php,v 1.4 2003/08/1); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   swiss_post_1.02       	Autor:	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers | http://www.themedia.at & http://www.oscommerce.at

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


define('MODULE_SHIPPING_CHP_TEXT_TITLE', 'The Swiss Post');
define('MODULE_SHIPPING_CHP_TEXT_DESCRIPTION', 'La Poste Suisse');
define('MODULE_SHIPPING_CHP_TEXT_WAY', 'Expédier à');
define('MODULE_SHIPPING_CHP_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_CHP_INVALID_ZONE', 'Malheureusement, il n&apos;est pas possible d&apos;expédier dans ce pays.');
define('MODULE_SHIPPING_CHP_UNDEFINED_RATE', 'Les frais d&apos;expédition ne peuvent pas être calculés pour le moment.');

define('MODULE_SHIPPING_CHP_COST_PRI_5_TITLE' , 'Tableau des tarifs pour la zone 4 à 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_5_DESC' , 'Tableau tarifaire pour la zone 4, basé sur <b>\'PRI\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_ECO_5_TITLE' , 'Tableau des tarifs pour la zone 4 à 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_5_DESC' , 'Tableau tarifaire pour la zone 4, basé sur <b>\'ECO\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COUNTRIES_5_TITLE' , 'Pays de la zone tarifaire 4');
define('MODULE_SHIPPING_CHP_COUNTRIES_5_DESC' , 'Liste de pays séparés par des virgules sous forme de code ISO à deux caractères, les codes de pays faisant partie de la zone 4');
define('MODULE_SHIPPING_CHP_COST_ECO_4_TITLE' , 'Tableau des tarifs pour la zone 3 à 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_4_DESC' , 'Tableau tarifaire pour la zone 3, basé sur <b>\'ECO\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_PRI_4_TITLE' , 'Tableau des tarifs pour la zone 3 à 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_4_DESC' , 'Tableau tarifaire pour la zone 3, basé sur <b>\'PRI\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_URG_4_TITLE' , 'Tableau des tarifs pour la zone 3 à 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_4_DESC' , 'Tableau tarifaire pour la zone 3, basé sur <b>\'URG\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_URG_3_TITLE' , 'Tableau des tarifs pour la zone 2 à 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_3_DESC' , 'Tableau tarifaire pour la zone 2, basé sur <b>\'URG\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COUNTRIES_4_TITLE' , 'Pays de la zone tarifaire 3');
define('MODULE_SHIPPING_CHP_COUNTRIES_4_DESC' , 'Liste des pays séparés par des virgules sous forme de code ISO à deux caractères Codes de pays faisant partie de la zone 3.');
define('MODULE_SHIPPING_CHP_STATUS_TITLE' , 'La Poste Suisse');
define('MODULE_SHIPPING_CHP_STATUS_DESC' , 'Voulez-vous expédier par la Poste Suisse ?');
define('MODULE_SHIPPING_CHP_HANDLING_TITLE' , 'frais de manutention.');
define('MODULE_SHIPPING_CHP_HANDLING_DESC' , 'Frais de traitement pour ce mode d&apos;expédition en CHF');
define('MODULE_SHIPPING_CHP_TAX_CLASS_TITLE' , 'Cadence');
define('MODULE_SHIPPING_CHP_TAX_CLASS_DESC' , 'Sélectionnez le taux de TVA pour cette méthode d&apos;expédition.');
define('MODULE_SHIPPING_CHP_ZONE_TITLE' , 'Zone d&apos;expédition');
define('MODULE_SHIPPING_CHP_ZONE_DESC' , 'Si vous sélectionnez une zone, cette méthode d&apos;expédition n&apos;est offerte que dans cette zone.');
define('MODULE_SHIPPING_CHP_SORT_ORDER_TITLE' , 'Séquence d&apos;affichage');
define('MODULE_SHIPPING_CHP_SORT_ORDER_DESC' , 'Le plus bas est affiché en premier.');
define('MODULE_SHIPPING_CHP_ALLOWED_TITLE' , 'Zones d&apos;expédition');
define('MODULE_SHIPPING_CHP_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément</b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
define('MODULE_SHIPPING_CHP_COUNTRIES_1_TITLE' , 'Pays de la zone tarifaire 0');
define('MODULE_SHIPPING_CHP_COUNTRIES_1_DESC' , 'zone domestique');
define('MODULE_SHIPPING_CHP_COST_ECO_1_TITLE' , 'Tableau des tarifs pour la zone 0 jusqu&apos;à 30 kgECO');
define('MODULE_SHIPPING_CHP_COST_ECO_1_DESC' , 'Tableau tarifaire pour la zone domestique, sur la base de <b>\'ECO\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_PRI_1_TITLE' , 'Tableau des tarifs pour la zone 0 jusqu&apos;à 30 kgPRI');
define('MODULE_SHIPPING_CHP_COST_PRI_1_DESC' , 'Tableau tarifaire pour la zone domestique, sur la base de <b>\'PRI\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COUNTRIES_2_TITLE' , 'Pays de la zone tarifaire 1');
define('MODULE_SHIPPING_CHP_COUNTRIES_2_DESC' , 'Liste de pays séparés par des virgules sous forme de code ISO à deux caractères, les codes de pays faisant partie de la zone 1.');
define('MODULE_SHIPPING_CHP_COST_ECO_2_TITLE' , 'Tableau des tarifs pour la zone 1 jusqu&apos;à 30 kgECO');
define('MODULE_SHIPPING_CHP_COST_ECO_2_DESC' , 'Tableau tarifaire pour la zone 1, sur la base de <b>\'ECO\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_PRI_2_TITLE' , 'Tableau des tarifs pour la zone 1 jusqu&apos;à 30 kgPRI');
define('MODULE_SHIPPING_CHP_COST_PRI_2_DESC' , 'Tableau tarifaire pour la zone 1, sur la base de <b>\'PRI\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_URG_2_TITLE' , 'Tableau des tarifs pour la zone 1 jusqu&apos;à 30 kgURG');
define('MODULE_SHIPPING_CHP_COST_URG_2_DESC' , 'Tableau tarifaire pour la zone 1, sur la base de <b>\'URG\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COUNTRIES_3_TITLE' , 'Pays de la zone tarifaire 2');
define('MODULE_SHIPPING_CHP_COUNTRIES_3_DESC' , 'Liste de pays séparés par des virgules sous forme de code ISO à deux caractères, les codes de pays faisant partie de la zone 2');
define('MODULE_SHIPPING_CHP_COST_ECO_3_TITLE' , 'Tableau des tarifs pour la zone 2 à 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_3_DESC' , 'Tableau tarifaire pour la zone 2, basé sur <b>\'ECO\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_PRI_3_TITLE' , 'Tableau des tarifs pour la zone 2 à 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_3_DESC' , 'Tableau tarifaire pour la zone 2, basé sur <b>\'PRI\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_URG_5_TITLE' , 'Tableau des tarifs pour la zone 4 à 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_5_DESC' , 'Tableau tarifaire pour la zone 4, basé sur <b>\'URG\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COUNTRIES_6_TITLE' , 'Pays de la zone tarifaire 4');
define('MODULE_SHIPPING_CHP_COUNTRIES_6_DESC' , 'Liste de pays séparés par des virgules sous forme de code ISO à deux caractères, les codes de pays faisant partie de la zone 4');
define('MODULE_SHIPPING_CHP_COST_ECO_6_TITLE' , 'Tableau des tarifs pour la zone 4 à 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_6_DESC' , 'Tableau tarifaire pour la zone 4, basé sur <b>\'ECO\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_PRI_6_TITLE' , 'Tableau des tarifs pour la zone 4 à 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_6_DESC' , 'Tableau tarifaire pour la zone 4, basé sur <b>\'PRI\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_URG_6_TITLE' , 'Tableau des tarifs pour la zone 4 à 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_6_DESC' , 'Tableau tarifaire pour la zone 4, basé sur <b>\'URG\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COUNTRIES_7_TITLE' , 'Pays de la zone tarifaire 5');
define('MODULE_SHIPPING_CHP_COUNTRIES_7_DESC' , 'Liste de pays séparés par des virgules sous forme de code ISO à deux caractères, les codes de pays faisant partie de la zone 5');
define('MODULE_SHIPPING_CHP_COST_ECO_7_TITLE' , 'Tableau des tarifs pour la zone 5 jusqu&apos;à 30 kgECO');
define('MODULE_SHIPPING_CHP_COST_ECO_7_DESC' , 'Tableau tarifaire pour la zone 5, sur la base de <b>\'ECO\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_PRI_7_TITLE' , 'Tableau des tarifs pour la zone 5 jusqu&apos;à 30 kgPRI');
define('MODULE_SHIPPING_CHP_COST_PRI_7_DESC' , 'Tableau tarifaire pour la zone 5, sur la base de <b>\'PRI\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
define('MODULE_SHIPPING_CHP_COST_URG_7_TITLE' , 'Tableau des tarifs pour la zone 5 jusqu&apos;à 30 kgURG');
define('MODULE_SHIPPING_CHP_COST_URG_7_DESC' , 'Tableau tarifaire pour la zone 5, sur la base de <b>\'URG\'</b> un poids d&apos;expédition jusqu&apos;à 30 kg.');
?>