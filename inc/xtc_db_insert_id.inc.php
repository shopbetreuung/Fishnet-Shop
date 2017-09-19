<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_db_insert_id.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
   (c) 2003	 nextcommerce (xtc_db_insert_id.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   // include needed functions
  include_once(DIR_FS_INC . 'xtc_db_error.inc.php');
   
  function xtc_db_insert_id($link = 'db_link') {
    global ${$link};
    
    return mysqli_insert_id(${$link});
  }
 ?>