<?php

class xtc_export_csv_stock {
    function xtc_export_csv_stock($filename, $product_id, $product_name, $product_stock, $products_attributes_name, $product_attribute_stock){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename . '.csv');
        ob_end_clean();
        $output = fopen('php://output', 'w');
        
        $output_header_fields = TEXT_PRODUCTS_ID.";".TEXT_PRODUCTS_NAME.";".TEXT_PRODUCTS_STOCK.";".TEXT_PRODUCTS_ATTRIBUTES;
        
        fputcsv($output, explode(';', $output_header_fields), ";");
        
        $products_query = xtc_db_query("SELECT p.products_id, p.products_quantity, pd.products_name FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd WHERE pd.language_id = '" . $_SESSION['languages_id'] . "' AND pd.products_id = p.products_id ORDER BY products_quantity");

        while ($products_values = xtc_db_fetch_array($products_query)) {
            
            $product_id = $products_values['products_id'];
            $product_name = $products_values['products_name'];
            $product_stock = $products_values['products_quantity'];
            
            $products_attributes_query = xtc_db_query("SELECT
                                                   pov.products_options_values_name,
                                                   pa.attributes_stock
                                               FROM
                                                   " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
                                               WHERE
                                                   pa.products_id = '".$products_values['products_id'] . "' AND pov.products_options_values_id = pa.options_values_id AND pov.language_id = '" . $_SESSION['languages_id'] . "' ORDER BY pa.attributes_stock");
            $output_fields = $product_id.";".$product_name.";".$product_stock.";";
            $attributes_array = array();
            while ($products_attributes_values = xtc_db_fetch_array($products_attributes_query)) {
                $products_attributes_name = $products_attributes_values['products_options_values_name'];
                $product_attribute_stock = $products_attributes_values['attributes_stock'];
                $attributes_array['attr_name'] =  $products_attributes_name;
                $attributes_array['attr_stock'] = $product_attribute_stock;
                $output_fields .= "Attribute: ".$attributes_array['attr_name'] . " ".TEXT_HAVE." " . $attributes_array['attr_stock']." ". TEXT_IN_STOCK." \n";
            }
            fputcsv($output, explode(';', $output_fields), ";");
        }
        fclose($output) or die("Can't close php://output");
	exit;
    }
}
class xtc_export_csv_invoice_orders {
    function xtc_export_csv_invoice_orders($filename, $invoice_number, $invoice_date, $total_net, $total_gross, $paid = false){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename . '.csv');
        ob_end_clean();
        $output = fopen('php://output', 'w');
        
        $output_header_fields = TEXT_INVOICE_NUMBER.";".TEXT_INVOICE_DATE.";".TEXT_TOTAL_NET.";".TEXT_TOTAL_GROSS;
        
        fputcsv($output, explode(';', $output_header_fields), ";");
        
        if($paid == true){
            $order_status = "AND o.orders_status != '3'";
        }
        
        $orders_query = xtc_db_query("SELECT o.customers_name, o.orders_id, o.ibn_billnr, o.ibn_billdate FROM " . TABLE_ORDERS . " o WHERE o.ibn_billnr != 0 ".$order_status." ORDER BY o.ibn_billnr DESC");
        while ($orders_values = xtc_db_fetch_array($orders_query)) {
            $invoice_number = $orders_values['ibn_billnr'];
            $netto = floatval(0);
            $brutto = floatval(0);
            $order_total_qry = xtc_db_query("SELECT value, class FROM ".TABLE_ORDERS_TOTAL." WHERE orders_id = '".(int)$orders_values['orders_id']."' AND (class = 'ot_tax' or class = 'ot_total')");
		  while ($order_total = xtc_db_fetch_array($order_total_qry)) {
			if ($order_total["class"] == 'ot_tax') {
				$netto -= $order_total["value"];
			}
			if ($order_total["class"] == 'ot_total') {
				$netto += floatval($order_total["value"]);
				$brutto = floatval($order_total["value"]);
			}			
		  }
            $total_net = $netto;
            $total_gross = $brutto;
            $datetimestring = explode(" ", $orders_values['ibn_billdate']);
            $datestring = explode("-", $datetimestring[0]);
            $invoice_date = $datestring[2] . "." . $datestring[1] . "." . $datestring[0];
            
            $output_fields = $invoice_number.";".$invoice_date.";".$total_net.";".$total_gross;
            fputcsv($output, explode(';', $output_fields), ";");
        }
        fclose($output) or die("Can't close php://output");
	exit;
    }
}

class xtc_export_csv_inventory_turnover{
    function xtc_export_csv_inventory_turnover($filename, $products_name, $ai, $it, $start_date){
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=' . $filename . '.csv');
            ob_end_clean();
            $output = fopen('php://output', 'w');
            
            $output_header_fields = TEXT_PRODUCTS_NAME.";".TEXT_AI.";".CSV_TEXT_INVENTORY_TURNOVER;

            fputcsv($output, explode(';', $output_header_fields), ";");
            $today = date('Y-m-d H:i:s', time());
            $selected = 'o.orders_id, p.products_id, pd.products_name, p.products_quantity, p.products_ordered';
            $products_query = xtc_db_query("SELECT DISTINCT ".$selected." 
                    FROM products p
                    JOIN products_description pd ON p.products_id = pd.products_id
                    JOIN orders_products op ON p.products_id = op.products_id
                    JOIN orders o ON op.orders_id = o.orders_id 
                    WHERE pd.language_id = '" . $_SESSION['languages_id']."' 
                    AND (o.date_purchased BETWEEN '" . $start_date . "' AND '" . $today . "') ");
            while ($products_values = xtc_db_fetch_array($products_query)) {

                $sold_stock = $products_values['products_ordered'];
                
                $products_name = $products_values['products_name'];
                $current_stock = $products_values['products_quantity'];
                
                $whole_stock = $current_stock + $sold_stock;
                $ai = ($whole_stock + $current_stock)  / 2;

                $it = $sold_stock / $ai;
                
                $output_fields = $products_name.";".$ai.";".xtc_round($it, 2).";";

                fputcsv($output, explode(';', $output_fields), ";");
            }

                fclose($output) or die("Can't close php://output");
                exit;
    }
}