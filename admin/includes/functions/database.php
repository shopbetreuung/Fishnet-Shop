<?php
/* --------------------------------------------------------------
   $Id: database.php 4255 2013-01-11 16:04:14Z web28 $   

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.22 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (database.php,v 1.6 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
  function xtc_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $$link;

    if (USE_PCONNECT == 'true') {
      $$link = mysqli_connect($server, $username, $password, $database);
    } else {
      $$link = mysqli_connect($server, $username, $password, $database);
    }

    if ($$link) mysqli_select_db($database);

    return $$link;
  }

  // db connection for Servicedatabase  
  function service_xtc_db_connect($server_service = SERVICE_DB_SERVER, $username_service = SERVICE_DB_SERVER_USERNAME, $password_service = SERVICE_DB_SERVER_PASSWORD, $database_service = SERVICE_DB_DATABASE, $link_service = 'db_link_service') {
    global $$link_service;

    if (SERVICE_USE_PCONNECT == 'true') {
      $$link_service = mysqli_connect($server_service, $username_service, $password_service, $database);
    } else {
      $$link_service = mysqli_connect($server_service, $username_service, $password_service, $database_service);
    }

    if ($$link_service) mysqli_select_db($database_service);

    return $$link_service;
  }

  function xtc_db_close($link = 'db_link') {
    global $$link;

    return mysqli_close($$link);
  }

  // db connection for Servicedatabase  
  function service_xtc_db_close($link_service = 'db_link_service') {
    global $$link_service;

    return mysqli_close($$link_service);
  }


  function xtc_db_error($query, $errno, $error) { 
    die('<font color="#000000"><strong>' . $errno . ' - ' . $error . '<br /><br />' . $query . '<br /><br /><small><font color="#ff0000">[TEP STOP]</font></small><br /><br /></strong></font>');
  }

  function xtc_db_query($query, $link = 'db_link') {
    global $$link, $logger;

    if (STORE_DB_TRANSACTIONS == 'true') {
      if (!is_object($logger)) $logger = new logger;
      $logger->write($query, 'QUERY');
    }

    $result = mysqli_query($$link, $query) or xtc_db_error($query, mysqli_errno($$link), mysqli_error($$link));

    if (STORE_DB_TRANSACTIONS == 'true') {
      if (mysqli_error($$link)) $logger->write(mysqli_error($$link), 'ERROR');
    }

    return $result;
  }

  // db connection for Servicedatabase 
  function service_xtc_db_query($query, $link_service = 'db_link_service') {
    global $$link_service, $logger_service;

    if (STORE_DB_TRANSACTIONS == 'true') {
      if (!is_object($logger_service)) $logger_service = new logger_service;
      $logger_service->write($query, 'QUERY');
    }

    $result = mysqli_query($$link_service, $query) or xtc_db_error($query, mysqli_errno($$link_service), mysqli_error($$link_service));

    if (STORE_DB_TRANSACTIONS == 'true') {
      if (mysqli_error($$link_service)) $logger_service->write(mysqli_error($$link_service), 'ERROR');
    }

    return $result;
  }
  
  function xtc_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    reset($data);
    if ($action == 'insert') {
      $query = 'insert into ' . $table . ' (';
      while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      reset($data);
      while (list(, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . xtc_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . xtc_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }

    return xtc_db_query($query, $link);
  }

  function xtc_db_fetch_array($db_query) {
    return mysqli_fetch_array($db_query, MYSQLI_ASSOC);
  }

  function xtc_db_result($result, $row, $field = '') {
    return mysqli_result($result, $row, $field);
  }

  function xtc_db_num_rows($db_query) {
    return mysqli_num_rows($db_query);
  }

  function xtc_db_data_seek($db_query, $row_number) {
    return mysqli_data_seek($db_query, $row_number);
  }

  function xtc_db_insert_id($link = 'db_link') {
    global $$link;

    return mysqli_insert_id($$link);
  }

  function xtc_db_free_result($db_query) {
    return mysqli_free_result($db_query);
  }

  function xtc_db_fetch_fields($db_query) {
    return mysqli_fetch_field($db_query);
  }

  function xtc_db_output($string) {
    return encode_htmlspecialchars($string);
  }

  function xtc_db_input($string) {
    return addslashes($string);
  }

  function xtc_db_prepare_input($string) {
    if (is_string($string)) {
      return trim(stripslashes($string));
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = xtc_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }
?>