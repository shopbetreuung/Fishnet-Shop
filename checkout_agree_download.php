<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout_agree_download.php 3434 2014-06-16 12:00:00Z Karsten Pohl $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_payment.php,v 1.110 2003/03/14); www.oscommerce.com
   (c) 2003 nextcommerce (checkout_payment.php,v 1.20 2003/08/17); www.nextcommerce.org
   (c) 2006 XT-Commerce (checkout_payment.php 1325 2005-10-30)

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   agree_conditions_1.01          Autor:  Thomas Pl�nkers (webmaster@oscommerce.at)

   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c) Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

//create smarty elements
$smarty = new Smarty;

// include boxes
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

//include needed functions

// if customer is not looged in, redirect him to login page
if (!isset ($_SESSION['customer_id']))
  xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() < 1)
  xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));

// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset ($_SESSION['cart']->cartID) && isset ($_SESSION['cartID'])) {
  if ($_SESSION['cart']->cartID != $_SESSION['cartID'])
    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
}

// if no shipping method has been selected, redirect the customer to the shipping method selection page
if (!isset ($_SESSION['shipping']))
  xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

//check if display conditions on checkout page is true

if (isset ($_POST['payment']))
  $_SESSION['payment'] = xtc_db_prepare_input($_POST['payment']);

if ($_POST['comments_added'] != '')
  $_SESSION['comments'] = xtc_db_prepare_input($_POST['comments']);

//-- TheMedia Begin check if display conditions on checkout page is true
if (isset ($_POST['cot_gv']))
  $_SESSION['cot_gv'] = true;
// if conditions are not accepted, redirect the customer to the payment method selection page

if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
  if (isset($_POST['conditions']) && $_POST['conditions'] == true) {
  	$_SESSION['conditions'] = true;
	}
  if ((!isset($_POST['conditions']) || $_POST['conditions'] == false) && (!isset($_SESSION['conditions']))) {
    $error = str_replace('\n', '<br />', ERROR_CONDITIONS_NOT_ACCEPTED);
    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode($error), 'SSL', true, false));
  }
}

// build list of products in cart
require (DIR_WS_CLASSES . 'order.php');
$order = new order();

// redirect to checkout_confirmation if no downloads in the cart
if (count($order->downloads) == 0) {
	xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'));
}

$shop_content_data = $main->getContentData(REVOCATION_ID);

if ($shop_content_data['content_file'] != '') {
  ob_start();
  if (strpos($shop_content_data['content_file'], '.txt'))
    echo '<pre>';
  include (DIR_FS_CATALOG . 'media/content/' . $shop_content_data['content_file']);
  if (strpos($shop_content_data['content_file'], '.txt'))
    echo '</pre>';
  $revocation = ob_get_contents();
  ob_end_clean();
} else {
  $revocation = '<div class="agbframe">' . $shop_content_data['content_text'] . '</div>';
}
  
// Create list of downloads

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_AGREE_DOWNLOAD, xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_AGREE_DOWNLOAD, xtc_href_link(FILENAME_CHECKOUT_AGREE_DOWNLOAD, '', 'SSL'));

$smarty->assign('DOWNLOADS_ARRAY', $order->downloads);
$smarty->assign('DOWNLOADS_COUNT', count($order->downloads));
$smarty->assign('GOODS_ARRAY', $order->goods);
$smarty->assign('GOODS_COUNT', count($order->goods));
$smarty->assign('REVOCATION', $revocation);
$smarty->assign('REVOCATION_TITLE', $shop_content_data['content_heading']);

// setup checkbox and button
$smarty->assign('FORM_ACTION', xtc_draw_form('checkout_agree_download', xtc_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post', 'onSubmit="return check_form();"'));
$smarty->assign('RADIO_AGREE_DOWNLOAD', '<input type="radio" value="agree_download" name="agree_download" id="agree_download" />');
$smarty->assign('RADIO_DISAGREE_DOWNLOAD', '<input type="radio" value="disagree_download" name="agree_download" id="disagree_download" />');
$smarty->assign('BUTTON_CONTINUE', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
$smarty->assign('FORM_END', '</form>');

require (DIR_WS_INCLUDES . 'header.php');


$smarty->assign('language', $_SESSION['language']);
$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/checkout_agree_download.html');
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined('RM')) {
  $smarty->load_filter('output', 'note');
}
$smarty->display(CURRENT_TEMPLATE . '/index.html');
include ('includes/application_bottom.php');
?>