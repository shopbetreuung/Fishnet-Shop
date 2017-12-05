<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_write_user_info.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
   (c) 2003	 nextcommerce (xtc_write_user_info.inc.php,v 1.4 2003/08/13); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  function xtc_write_user_info($customer_id) {
      
        if(SAVE_IP_IN_DATABASE == 'true'){
            $ip = $_SESSION['tracking']['ip'];
        }elseif(SAVE_IP_IN_DATABASE == 'false'){
            $ip = '0';
        }elseif(SAVE_IP_IN_DATABASE == 'shortened'){
            if(filter_var($_SESSION['tracking']['ip'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ip = preg_replace("/(\d+\.\d+\.\d+)\.\d+/", "$1.0", $_SESSION['tracking']['ip']);
            }else{
                $ip = $_SESSION['tracking']['ip'];
            }
            
        }
      
      $sql_data_array = array('customers_id' => xtc_db_input((int)$customer_id),
                              'customers_ip' => xtc_db_input($ip),
                              'customers_ip_date' => 'now()',
                              'customers_host' => xtc_db_input($_SESSION['tracking']['http_referer']['host']),
                              'customers_advertiser' => xtc_db_input($_SESSION['tracking']['refID']),
                              'customers_referer_url' => xtc_db_input($_SESSION['tracking']['http_referer']['host']).xtc_db_input($_SESSION['tracking']['http_referer']['path']),
                              );

      xtc_db_perform(TABLE_CUSTOMERS_IP, $sql_data_array);
    return -1;
  }
?>