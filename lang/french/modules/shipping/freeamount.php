<?php
/* -----------------------------------------------------------------------------------------
   $Id: freeamount.php 1288 2005-10-07 14:47:50Z gwinger $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce( freeamount.php,v 1.01 2002/01/24 03:25:00); www.oscommerce.com 
   (c) 2003	 nextcommerce (freeamount.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   freeamountv2-p1         	Autor:	dwk

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_FREEAMOUNT_TEXT_TITLE', 'Livraison gratuite.');
define('MODULE_SHIPPING_FREEAMOUNT_TEXT_DESCRIPTION', 'Livraison gratuite avec montant minimum de commande');
define('MODULE_SHIPPING_FREEAMOUNT_TEXT_WAY', 'Livraison gratuite minimum de commande :  %s');
define('MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER', 'Ordre de tri');

define('MODULE_SHIPPING_FREEAMOUNT_ALLOWED_TITLE' , 'Zones autorisées');
define('MODULE_SHIPPING_FREEAMOUNT_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément</b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
define('MODULE_SHIPPING_FREEAMOUNT_STATUS_TITLE' , 'Permettre la livraison gratuite avec un achat minimum.');
define('MODULE_SHIPPING_FREEAMOUNT_STATUS_DESC' , 'Voulez-vous offrir la livraison gratuite ?');
define('MODULE_SHIPPING_FREEAMOUNT_DISPLAY_TITLE' , 'Activer la visualisation');
define('MODULE_SHIPPING_FREEAMOUNT_DISPLAY_DESC' , 'Voulez-vous afficher du texte si le montant minimum n&apos;est pas atteint ?');
define('MODULE_SHIPPING_FREEAMOUNT_AMOUNT_TITLE' , 'Coût minimum');
define('MODULE_SHIPPING_FREEAMOUNT_AMOUNT_DESC' , 'Montant minimum de commande acheté avant que la livraison ne soit gratuite ?');
define('MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER_TITLE' , 'séquence de présentation');
define('MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER_DESC' , 'Le plus bas sera affiché en premier.');
?>