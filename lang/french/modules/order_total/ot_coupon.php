<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_coupon.php 1243 2010-08-31 15:27:48Z dokuman $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(t_coupon.php,v 1.1.2.2 2003/05/15); www.oscommerce.com
   (c) 2006 XT-Commerce (ot_coupon.php 899 2005-04-29)

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

  define('MODULE_ORDER_TOTAL_COUPON_TITLE', 'Coupons de réduction');
  define('MODULE_ORDER_TOTAL_COUPON_HEADER', 'Bon cadeau/coupons rabais');
  define('MODULE_ORDER_TOTAL_COUPON_DESCRIPTION', 'Coupon de réduction');
  define('SHIPPING_NOT_INCLUDED', ' [Livraison non comprise]');
  define('TAX_NOT_INCLUDED', ' [Taxe en sus]');
  define('MODULE_ORDER_TOTAL_COUPON_USER_PROMPT', '');
  define('ERROR_NO_INVALID_REDEEM_COUPON', 'Code de coupon invalide');
 
  define('REDEEMED_MIN_ORDER', 'pour les marchandises de plus de ');  
  define('REDEEMED_RESTRICTIONS', ' [Articles / Catégorie Restrictions]');  
  define('TEXT_ENTER_COUPON_CODE', 'Entrez ici votre code de bon d&apos;achat &nbsp;&nbsp;');
  
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_TITLE', 'Valeur d&apos;affichage');
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_DESC', 'Souhaitez-vous voir la valeur du coupon de réduction ?');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_TITLE', 'ordre de tri');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_DESC', 'séquence de présentation');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_TITLE', 'Frais d&apos;expédition inclus');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_DESC', 'Inclure l&apos;expédition dans le calcul ?');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_TITLE', 'TVA comprise');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_DESC', 'Inclure la taxe dans le calcul.');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_TITLE', 'Recalculer l&apos;impôt');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_DESC', 'Recalculer l&apos;impôt');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_TITLE', 'Catégorie de taxe');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_DESC', 'Utilisez la catégorie d&apos;imposition suivante lorsque vous traitez le coupon d&apos;escompte comme une note de crédit.');
  //BOF - web28 - 2010-06-20 - no discount for special offers
  define('MODULE_ORDER_TOTAL_COUPON_SPECIAL_PRICES_TITLE', 'Remise pour les offres spéciales');
  define('MODULE_ORDER_TOTAL_COUPON_SPECIAL_PRICES_DESC', 'Remise autorisée pour les offres spéciales');
  //EOF - web28 - 2010-06-20 - no discount for special offers
?>