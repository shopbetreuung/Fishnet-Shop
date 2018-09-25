<?php
/*
  $Id: quick_stock_update.php, v 3.9.3 2014/08/10 14:42:25
  MODIFIED by Günter Geisler / http://www.highlight-pc.de
  RE-WRITTEN by Azrin Aris / http://www.free-fliers.com
  ADAPTED AND STREAMLINED FOR modified Shopsoftware 1.06 by André  R. Kohl / http://www.sixtyseven.info

  Released under the GNU General Public License
*/

define('BOX_CATALOG_QUICK_STOCKUPDATE', 'Quick-Stock-Updater');
define('QUICK_HEAD1', 'Quick-Stock-Updater');
define('QUICK_MODEL', 'Art. no');
define('QUICK_EAN', 'EAN');
define('QUICK_IMAGE', 'Image');
define('QUICK_ID', 'ID');
define('SORT_ID', 'Sort order');
define('QUICK_NAME', 'Description');
define('QUICK_NEW_STOCK', 'Add');
define('QUICK_PRICE_NE', 'Price (netto)');
define('QUICK_PRICE_VK', 'Price (brutto)');
define('QUICK_WEIGHT', 'Weight (Kg)');
define('QUICK_STOCK', 'In stock');
define('QUICK_STATUS', 'Article status');
define('QUICK_ACTIVE', 'Active');
define('QUICK_INACTIVE', 'Inactive');
define('QUICK_TEXT', '<i>(One or more articles in stock = <font color="#009933"><b>Active</b></font> / 0 or less in stock = <font color="#ff0000"><b>Inactive</b></font>)</i>');
define('QUICK_UPDATE', 'Update Article');
define('QUICK_COPY', 'Copy to category');
define('QUICK_MOVE', 'Move to category');
define('QUICK_DELETE', 'Delete article');
define('QUICK_AUTOSTATUS', 'Auto Status');
define('QUICK_MODIFIED', '');
define('QUICK_CATEGORY','Category');
define('QUICK_MANUFACTURER', 'Manufacturer');
define('QUICK_CATEGORY_ID','Category Id : ');
define('QUICK_MANUFACTURER_ID', 'Manufacturer Id: ');

define('QUICK_MSG_SUCCESS','Success:');
define('QUICK_MSG_WARNING','Warning:');
define('QUICK_MSG_ERROR','Error:');
define('QUICK_MSG_NOITEMUPDATED','No entry was updated.');
define('QUICK_MSG_ITEMSUPDATED','%d articles were updated.');
define('QUICK_MSG_UPDATETIME','Update Proces time : %.4f seconds');
define('QUICK_MSG_UPDATEERROR','Update of entries not possible - Please check directory varibles and/or permission');

// Addditions by sixtyseven
define('QUICK_SEARCH_FOR','Search for');
define('QUICK_SELECT_CATEGORY','Select category');
define('QUICK_SELECT_MANUFACTURER','Select manufacturer');
define('QUICK_SELECT_LANG','Select language');
define('QUICK_UPDATE_BUTTON','Update articles');
define('QUICK_ACTIONBAR_HEADING','Action');
define('QUICK_NOTAVAILABLE','Not available');
define('QUICK_SIPPINGTIME', 'Delivery time');  