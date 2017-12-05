<?php
if(isset($_POST['delete-guest'])){
    $query = xtc_db_query("SELECT c.customers_id, c.customers_firstname, c.customers_email_address FROM customers c JOIN customers_info ci ON c.customers_id = ci.customers_info_id WHERE c.customers_id NOT IN (SELECT o.customers_id FROM orders o) AND c.customers_status = '1' AND ci.customers_info_date_account_created < DATE_SUB(NOW(), INTERVAL 60 DAY)");
    while($query_array = xtc_db_fetch_array($query)){
        $cID = $query_array['customers_id'];
        $tables_array = array(TABLE_ADDRESS_BOOK, TABLE_CUSTOMERS, TABLE_CUSTOMERS_BASKET, TABLE_CUSTOMERS_BASKET_ATTRIBUTES, TABLE_PRODUCTS_NOTIFICATIONS, TABLE_CUSTOMERS_STATUS_HISTORY, TABLE_CUSTOMERS_IP, TABLE_ADMIN_ACCESS, TABLE_NEWSLETTER_RECIPIENTS, TABLE_CUSTOMERS_MEMO);
        foreach ($tables_array as $table) {
            xtc_db_query("DELETE FROM ".$table." WHERE customers_id = '".$cID."'");
        }
        xtc_db_query("DELETE FROM ".TABLE_CUSTOMERS_INFO." WHERE customers_info_id = '".$cID."'");
        xtc_db_query("DELETE FROM ".TABLE_WHOS_ONLINE." WHERE customer_id = '".$cID."'");
    }
}
?>
