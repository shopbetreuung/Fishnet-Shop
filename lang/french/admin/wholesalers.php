<?php
/* --------------------------------------------------------------
   $Id: wholesalers.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturers.php,v 1.14 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (manufacturers.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Wholesalers');

define('TABLE_HEADING_WHOLESALERS', 'Wholesalers');
define('TABLE_WHOLESALERS_EMAIL', 'Email');
define('TABLE_WHOLESALERS_FILE', 'File name');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_HEADING_NEW_WHOLESALER', 'New Wholesaler');
define('TEXT_HEADING_EDIT_WHOLESALER', 'Edit Wholesaler');
define('TEXT_HEADING_DELETE_WHOLESALER', 'Delete Wholesaler');

define('TEXT_WHOLESALERS', 'Wholesalers:');
define('TEXT_DATE_ADDED', 'Date Added:');
define('TEXT_LAST_MODIFIED', 'Last Modified:');
define('TEXT_PRODUCTS', 'Products:');

define('TEXT_NEW_INTRO', 'Please fill out the following information for the new wholesaler.');
define('TEXT_EDIT_INTRO', 'Please make any necessary changes');

define('TEXT_WHOLESALERS_NAME', 'Wholesaler Name:');
define('TEXT_WHOLESALERS_EMAIL', 'Wholesaler email address:');
define('TEXT_WHOLESALERS_FILE', 'Wholesaler email template name(example.html):');

define('TEXT_DELETE_INTRO', 'Are you sure you want to delete this wholesaler?');
define('TEXT_DELETE_IMAGE', 'Delete wholesalers image?');
define('TEXT_DELETE_PRODUCTS', 'Delete products from this wholesaler? (including product reviews, products on special, upcoming products)');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>WARNING:</b> There are %s products still linked to this wholesaler!');

define('ERROR_DIRECTORY_NOT_WRITEABLE', 'Error: I can not write to this directory. Please set the right user permissions on: %s');
define('ERROR_DIRECTORY_DOES_NOT_EXIST', 'Error: Directory does not exist: %s');

define('ERROR_TEXT_HEADING', 'Wholesaler not saved, fix errors:');
define('ERROR_TEXT_NAME', 'Wholesaler name invalid!');
define('ERROR_TEXT_EMAIL', 'Wholesaler email address required!');
define('ERROR_TEXT_EMAIL_INVALID', 'Wholesaler email address is invalid!');
define('ERROR_TEXT_FILE', 'Wholesaler template name required!');
?>