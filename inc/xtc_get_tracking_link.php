<?php

/**
 * @author    Timo Psul <mail@timopaul.com>
 * @copyright (c) 2015, Timo Paul Dienstleistungen
 * @license   http://www.gnu.de/documents/gpl-2.0.de.html
 *            GNU General Public License v2
 * 
 * returns existing tracking links
 */

function xtc_get_tracking_link($order_id) {
  $where = array();
  $where[] = 'o.orders_id = ' . $order_id;
  $where[] = 'ot.ortra_parcel_id != ""';
  // check if customer owns order
  if (0 != (int) $_SESSION['customers_status']['customers_status_id']) {
    $where[] = 'o.customers_id = ' . $_SESSION['customer_id'];
  }
  
  $stmt = 'SELECT ot.ortra_parcel_id, c.carrier_name, c.carrier_tracking_link ' . 
          'FROM ' . TABLE_ORDERS . ' AS o ' .
            'LEFT JOIN ' . TABLE_ORDERS_TRACKING . ' AS ot ' .
              'ON o.orders_id = ot.ortra_order_id ' .
            'LEFT JOIN ' . TABLE_CARRIERS . ' as c ' .
              'ON ot.ortra_carrier_id = c.carrier_id ' .
          'WHERE ' . implode(' AND ', $where) . ' ' .
          'ORDER BY c.carrier_sort_order';
  $query = xtc_db_query($stmt);
  $links = array();
  if (0 < xtc_db_num_rows($query)) {
    while ($row = xtc_db_fetch_array($query)) {
      $links[] = array(
        'carrier' => $row['carrier_name'],
        'number'  => $row['ortra_parcel_id'],
        'href'    => str_replace('$1', $row['ortra_parcel_id'], $row['carrier_tracking_link']),
      );
    }
  }
  return count($links) ? $links : false;
}

?>