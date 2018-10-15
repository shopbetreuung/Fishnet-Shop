<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_gv.php 899 2005-04-29 02:40:57Z hhgag $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_gv.php,v 1.1.2.1 2003/05/15); www.oscommerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_ORDER_TOTAL_GV_TITLE', 'Bon cadeau');
  define('MODULE_ORDER_TOTAL_GV_HEADER', 'Bon cadeau');
  define('MODULE_ORDER_TOTAL_GV_DESCRIPTION', 'Bon cadeau');
  define('SHIPPING_NOT_INCLUDED', ' [Livraison non comprise]');
  define('TAX_NOT_INCLUDED', ' [Taxe en sus]');
  define('MODULE_ORDER_TOTAL_GV_USER_PROMPT', 'Cochez cette case pour utiliser le solde de votre compte Chèque-cadeau. ->&nbsp;');
  define('TEXT_ENTER_GV_CODE', 'Veuillez entrer ici votre code de bon d&apos;achat.&nbsp;&nbsp;');
  
  define('MODULE_ORDER_TOTAL_GV_STATUS_TITLE', 'Affichage du total');
  define('MODULE_ORDER_TOTAL_GV_STATUS_DESC', 'Voulez-vous afficher la valeur du chèque cadeau ?');
  define('MODULE_ORDER_TOTAL_GV_SORT_ORDER_TITLE', 'Ordre de tri');
  define('MODULE_ORDER_TOTAL_GV_SORT_ORDER_DESC', 'Ordre de tri de l&apos;affichage');
  define('MODULE_ORDER_TOTAL_GV_QUEUE_TITLE', 'liste de diffusion');
  define('MODULE_ORDER_TOTAL_GV_QUEUE_DESC', 'Les chèques-cadeaux commandés doivent-ils d&apos;abord être ajoutés à la liste d&apos;approbation ?');
  define('MODULE_ORDER_TOTAL_GV_INC_SHIPPING_TITLE', 'Frais d&apos;expédition inclus');
  define('MODULE_ORDER_TOTAL_GV_INC_SHIPPING_DESC', 'Inclure les frais d&apos;expédition dans le calcul');
  define('MODULE_ORDER_TOTAL_GV_INC_TAX_TITLE', 'TVA incluse.');
  define('MODULE_ORDER_TOTAL_GV_INC_TAX_DESC', 'Inclure la taxe dans le calcul.');
  define('MODULE_ORDER_TOTAL_GV_CALC_TAX_TITLE', 'Recalculer la TVA');
  define('MODULE_ORDER_TOTAL_GV_CALC_TAX_DESC', 'Recalculer la TVA');
  define('MODULE_ORDER_TOTAL_GV_TAX_CLASS_TITLE', 'Catégorie de taxe');
  define('MODULE_ORDER_TOTAL_GV_TAX_CLASS_DESC', 'Utilisez la classe d&apos;imposition suivante lorsque vous traitez les chèques-cadeaux comme des notes de crédit.');
  define('MODULE_ORDER_TOTAL_GV_CREDIT_TAX_TITLE', 'Le solde créditeur comprend la TVA.');
  define('MODULE_ORDER_TOTAL_GV_CREDIT_TAX_DESC', 'ajouter la TVA à la valeur du bon d&apos;achat');
?>