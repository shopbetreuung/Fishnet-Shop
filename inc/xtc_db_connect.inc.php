<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_db_connect.inc.php 4200 2013-01-10 19:47:11Z Tomcraft1980 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
   (c) 2003 nextcommerce (xtc_db_connect.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2006 XT-Commerce (xtc_db_connect.inc.php 1248 2005-09-27)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  include_once(DIR_FS_INC . 'xtc_db_error.inc.php');

  function xtc_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global ${$link};

    if (!function_exists('mysqli_connect')) {
      die ('Call to undefined function: mysqli_connect(). Please install the MySQL Connector for PHP');
    }

    if (USE_PCONNECT == 'true') {
      ${$link} = @mysqli_connect($server, $username, $password, $database);
    } else {
      ${$link} = @mysqli_connect($server, $username, $password, $database);
    }

    //vr - 2010-01-01 - Disable "STRICT" mode for MySQL 5!
    if(version_compare(@mysqli_get_server_info(${$link}), '5.0.0', '>=')) {
      @mysqli_query(${$link}, "SET SESSION sql_mode=''");
    }

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    
    mysqli_set_charset(${$link}, 'utf8');
    
    return ${$link};
  }
?>
