<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_db_perform.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_db_perform.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function xtc_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    global ${$link};
    
    if (!is_array($data) || count($data) < 1) {
      return false;
    }
    
    reset($data);

    if ($action == 'insert') {
      $query = 'INSERT INTO ' . $table . ' (';
      
      $sub_query = array();
      while (list($columns, ) = each($data)) {
        $sub_query[] = $columns;
      }
      $query .= implode(', ', $sub_query) . ') VALUES (';
      reset($data);
      
      $sub_query = array();
      while (list(, $value) = each($data)) {
        $value = (string)$value;
        switch ($value) {
          case 'now()':
            $sub_query[] = 'now()';
            break;
          case 'null':
            $sub_query[] = 'null';
            break;
          default:
            $sub_query[] = '\'' . xtc_db_input($value) . '\'';
            break;
        }
      }
      $query .= implode(', ', $sub_query) . ')';
    } elseif ($action == 'update') {
      $query = 'UPDATE ' . $table . ' SET ';
      
      $sub_query = array();
      while (list($columns, $value) = each($data)) {
        $value = (string)$value;
        switch ($value) {
          case 'now()':
            $sub_query[] = $columns . ' = now()';
            break;
          case 'null':
            $sub_query[] = $columns . ' = null';
            break;
          default:
            $sub_query[] = $columns . ' = \'' . xtc_db_input($value) . '\'';
            break;
        }
      }
      $query .= implode(', ', $sub_query) . ' WHERE ' . $parameters;
    }

    return xtc_db_query($query, $link);
  }
 ?>