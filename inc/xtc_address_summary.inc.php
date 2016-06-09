<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_address_summary.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_address_summary.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function xtc_address_summary($customers_id, $address_id) {
    $customers_id = xtc_db_prepare_input($customers_id);
    $address_id = xtc_db_prepare_input($address_id);

    $address_query = xtc_db_query("select ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_state, ab.entry_country_id, ab.entry_zone_id, c.countries_name, c.address_format_id from " . TABLE_ADDRESS_BOOK . " ab, " . TABLE_COUNTRIES . " c where ab.address_book_id = '" . xtc_db_input((int)$address_id) . "' and ab.customers_id = '" . xtc_db_input((int)$customers_id) . "' and ab.entry_country_id = c.countries_id");
    $address = xtc_db_fetch_array($address_query);

    $street_address = $address['entry_street_address'];
    $suburb = $address['entry_suburb'];
    $postcode = $address['entry_postcode'];
    $city = $address['entry_city'];
    $state = xtc_get_zone_code($address['entry_country_id'], $address['entry_zone_id'], $address['entry_state']);
    $country = $address['countries_name'];

    $address_format_query = xtc_db_query("select address_summary from " . TABLE_ADDRESS_FORMAT . " where address_format_id = '" . (int)$address['address_format_id'] . "'");
    $address_format = xtc_db_fetch_array($address_format_query);

//    eval("\$address = \"{$address_format['address_summary']}\";");
    $address_summary = $address_format['address_summary'];
    eval("\$address = \"$address_summary\";");

    return $address;
  }
 ?>