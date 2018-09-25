<?php
/**
 * @version SOFORT Gateway 5.2.0 - $Date: 2012-09-06 14:27:56 +0200 (Thu, 06 Sep 2012) $
 * @author SOFORT AG (integration@sofort.com)
 * @link http://www.sofort.com/
 *
 * Copyright (c) 2012 SOFORT AG
 *
 * $Id: ot_sofort.php 3751 2012-10-10 08:36:20Z gtb-modified $
 */

$num = 3;

define('MODULE_ORDER_TOTAL_SOFORT_TITLE', 'module de remise sofort.com');
define('MODULE_ORDER_TOTAL_SOFORT_DESCRIPTION', 'Remise pour paiement par sofort.com');

define('MODULE_ORDER_TOTAL_SOFORT_STATUS_TITLE', 'Afficher la remise');
define('MODULE_ORDER_TOTAL_SOFORT_STATUS_DESC', 'Voulez-vous activer l&apos;escompte de paiement ?');

define('MODULE_ORDER_TOTAL_SOFORT_SORT_ORDER_TITLE', 'séquence de tri');
define('MODULE_ORDER_TOTAL_SOFORT_SORT_ORDER_DESC', 'Ordre d&aposaffichage. Le plus petit nombre apparaîtra en premier.');

define('MODULE_ORDER_TOTAL_SOFORT_PERCENTAGE_SU_TITLE', 'Rabais pour les services bancaires SOFORT');
define('MODULE_ORDER_TOTAL_SOFORT_PERCENTAGE_SU_DESC', 'Remise (valeur minimale : pourcentage&montant fixe)');

define('MODULE_ORDER_TOTAL_SOFORT_PERCENTAGE_SL_TITLE', 'Rabais pour SOFORT Lastschrift');
define('MODULE_ORDER_TOTAL_SOFORT_PERCENTAGE_SL_DESC', 'Remise (valeur minimale : pourcentage&montant fixe)');

define('MODULE_ORDER_TOTAL_SOFORT_PERCENTAGE_SR_TITLE', 'Discounts for Rechnung by SOFORT');
define('MODULE_ORDER_TOTAL_SOFORT_PERCENTAGE_SR_DESC', 'Remise (valeur minimale : pourcentage&montant fixe)');

define('MODULE_ORDER_TOTAL_SOFORT_PERCENTAGE_SV_TITLE', 'Discounts for Vorkasse by SOFORT');
define('MODULE_ORDER_TOTAL_SOFORT_PERCENTAGE_SV_DESC', 'Remise (valeur minimale : pourcentage&montant fixe)');

define('MODULE_ORDER_TOTAL_SOFORT_PERCENTAGE_LS_TITLE', 'Discounts for Lastschrift by SOFORT');
define('MODULE_ORDER_TOTAL_SOFORT_PERCENTAGE_LS_DESC', 'Remise (valeur minimale : pourcentage&montant fixe)');

define('MODULE_ORDER_TOTAL_SOFORT_INC_SHIPPING_TITLE', 'Including shipping');
define('MODULE_ORDER_TOTAL_SOFORT_INC_SHIPPING_DESC', 'Les frais d&aposexpédition sont calculés avec remise.');

define('MODULE_ORDER_TOTAL_SOFORT_INC_TAX_TITLE', 'TVA incluse');
define('MODULE_ORDER_TOTAL_SOFORT_INC_TAX_DESC', 'TVA avec remise');

define('MODULE_ORDER_TOTAL_SOFORT_CALC_TAX_TITLE', 'Calcul de la taxe');
define('MODULE_ORDER_TOTAL_SOFORT_CALC_TAX_DESC', 'recalculer le montant de la taxe');

define('MODULE_ORDER_TOTAL_SOFORT_ALLOWED_TITLE', 'Zones autorisées');
define('MODULE_ORDER_TOTAL_SOFORT_ALLOWED_DESC' , 'Spécifiez <b>single</b> les zones qui devraient être autorisées pour ce module. (p. ex. AT,DE (si vide, toutes les zones sont autorisées)).');

define('MODULE_ORDER_TOTAL_SOFORT_DISCOUNT', 'rabais');
define('MODULE_ORDER_TOTAL_SOFORT_FEE', 'supplément de prix');

define('MODULE_ORDER_TOTAL_SOFORT_TAX_CLASS_TITLE','catégorie fiscale');
define('MODULE_ORDER_TOTAL_SOFORT_TAX_CLASS_DESC','La classe de taxe n&aposest pas pertinente et ne sert qu&aposà prévenir un message d&aposerreur.');

define('MODULE_ORDER_TOTAL_SOFORT_BREAK_TITLE','Calcul multiple');
define('MODULE_ORDER_TOTAL_SOFORT_BREAK_DESC','Des calculs multiples devraient-ils être possibles ? Si ce n&aposest pas le cas, il est annulé après le premier rabais approprié.');
?>