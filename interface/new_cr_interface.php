<?php

require_once('rest_client.php');
require("../includes/application_top_export.php");

$rest = new \CR\tools\rest("https://rest.cleverreach.com/v2");

if (trim(CLEVERREACH_API_CLIENT_ID) == '' || trim(CLEVERREACH_API_USERNAME) == '' || trim(CLEVERREACH_API_PASSWORD) == '') {
	die('Please enter all login credentials for Cleverreach!');
}

$token = $rest->post('/login',
	array(
		"client_id"=> CLEVERREACH_API_CLIENT_ID,
		"login"=> 	CLEVERREACH_API_USERNAME,
		"password"=> CLEVERREACH_API_PASSWORD)
);

$rest->setAuthMode("bearer", $token);

$groups = $rest->get("/groups");

foreach ($groups as $group) {
	if ($group->isLocked !== true) {
		$group_id = $group->id;
		$group_count = $rest->get("/groups/".$group_id."/receivers");
	}
}

if (!isset($group_id)) {
	die('No groups found! Please create one in the Cleverreach backend');
}

$receivers = array();
if (CLEVERREACH_API_IMPORT_SUBSCRIBERS == 'true') {
	$manual_registered_customers = xtc_db_query("SELECT
										customers_id,
										customers_email_address as email, 
										date_added as registered,
										customers_firstname as firstname, 
										customers_lastname as lastname
									FROM " . TABLE_NEWSLETTER_RECIPIENTS . " WHERE mail_status = '1' ");

	while ($customer = xtc_db_fetch_array($manual_registered_customers)) {
		$orders = array();
		$order_rows = xtc_db_query("SELECT o.orders_id, op.products_id, op.products_name, op.products_price, op.products_quantity from " . TABLE_ORDERS . " o JOIN " . TABLE_ORDERS_PRODUCTS . " op ON o.orders_id = op.orders_id  WHERE customers_id = '" . $customer['customers_id'] . "' ORDER BY date_purchased ");
		while ($order_row = xtc_db_fetch_array($order_rows)) {

			$orders[] = array(
				"order_id"   => $order_row["orders_id"],      //required
				"product_id" => $order_row["products_id"],    //optional
				"product"    => utf8_encode($order_row["products_name"]),  //required
				"price"      => $order_row["products_price"],  //optional
				"currency"   => "EUR",                     //optional
				"amount"     => $order_row["products_quantity"], //optional
				"source"     => STORE_NAME          //optional
			);
		}

		$receivers[] = array(
			"email"			=> $customer["email"],
			"registered"	=> strtotime($customer["registered"]),
			"activated"		=> strtotime($customer["registered"]),
			"source"		=> STORE_NAME,
			"global_attributes"	=> array(
				"firstname" => utf8_encode($customer["firstname"]),
				"lastname" =>  utf8_encode($customer["lastname"])
				//"gender" =>    $row->gender
				),
			"orders" => $orders
		);
		
		if (count($receivers) > 1000) {
			$rest->post("/groups/".$group_id."/receivers", $receivers);
			$receivers = array();
			
		}
		
	}
}

if (CLEVERREACH_API_IMPORT_BUYERS == 'true') {
	$order_rows = xtc_db_query("SELECT DISTINCT o.orders_id, o.customers_id, op.products_id, op.products_name, op.products_price, op.products_quantity from " . TABLE_ORDERS . " o JOIN " . TABLE_ORDERS_PRODUCTS . " op ON o.orders_id = op.orders_id GROUP BY o.customers_id ORDER BY o.date_purchased ");
	while ($order_row = xtc_db_fetch_array($order_rows)) {
		
		$orders = array();
		
		$orders[] = array(
				"order_id"   => $order_row["orders_id"],      //required
				"product_id" => $order_row["products_id"],    //optional
				"product"    => utf8_encode($order_row["products_name"]),  //required
				"price"      => $order_row["products_price"],  //optional
				"currency"   => "EUR",                     //optional
				"amount"     => $order_row["products_quantity"], //optional
				"source"     => STORE_NAME          //optional
			);
		
		$flagged_customers = xtc_db_query("	SELECT
										customers_id,
										customers_email_address as email, 
										customers_date_added as registered,
										customers_firstname as firstname, 
										customers_lastname as lastname
									FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . $order_row["customers_id"] . "' ");

		while ($customer = xtc_db_fetch_array($flagged_customers)) {

			$receivers[] = array(
				"email"			=> $customer["email"],
				"registered"	=> strtotime($customer["registered"]),
				"activated"		=> strtotime($customer["registered"]),
				"source"		=> STORE_NAME,
				"global_attributes"	=> array(
					"firstname" => utf8_encode($customer["firstname"]),
					"lastname" =>  utf8_encode($customer["lastname"])
					//"gender" =>    $row->gender
					),
				"orders" => $orders
			);

			if (count($receivers) > 1000) {
				$rest->post("/groups/".$group_id."/receivers", $receivers);
				$receivers = array();
			}
		}
	}
	
}

if (count($receivers) > 0) {
	$rest->post("/groups/".$group_id."/receivers", $receivers);
} else {
	die('No new receivers found');
}
$receivers = array();
echo "Newsletter recipients successfully updated!";
