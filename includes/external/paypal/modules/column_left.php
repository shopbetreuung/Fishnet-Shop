<?php
/* -----------------------------------------------------------------------------------------
   $Id$

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
  

  $menu_items['configuration'][] = array(	"name" 		=> TEXT_PAYPAL_TAB_CONFIG,
											"is_main"	=> true,
											"link" 		=> xtc_href_link('paypal_config.php', '', 'NONSSL'),
											"access"	=> "paypal_config",
											"check"		=> true);	

  $menu_items['configuration'][] = array(	"name" 		=> TEXT_PAYPAL_TAB_PROFILE,
											"is_main"	=> true,
											"link" 		=> xtc_href_link('paypal_profile.php', '', 'NONSSL'),
											"access"	=> "paypal_profile",
											"check"		=> true);	


  $menu_items['configuration'][] = array(	"name" 		=> TEXT_PAYPAL_TAB_WEBHOOK,
											"is_main"	=> true,
											"link" 		=> xtc_href_link('paypal_webhook.php', '', 'NONSSL'),
											"access"	=> "paypal_webhook",
											"check"		=> true);	


  $menu_items['configuration'][] = array(	"name" 		=> TEXT_PAYPAL_TAB_MODULE,
											"is_main"	=> true,
											"link" 		=> xtc_href_link('paypal_module.php', '', 'NONSSL'),
											"access"	=> "paypal_module",
											"check"		=> true);	


  $menu_items['configuration'][] = array(	"name" 		=> TEXT_PAYPAL_TAB_TRANSACTIONS,
											"is_main"	=> true,
											"link" 		=> xtc_href_link('paypal_payment.php', '', 'NONSSL'),
											"access"	=> "paypal_payment",
											"check"		=> true);	


  $menu_items['configuration'][] = array(	"name" 		=> false, "is_main"	=> true);
?>