<?php
/**
 * pdfbill.php
 * 10.2007 h.koch (hendrik.koch@gmx.de)
 */
 
require( DIR_FS_CATALOG.'includes/classes/xtcPrice.php' );

require( DIR_FS_CATALOG.'admin/includes/ipdfbill/classes/pdf_datacell.php' );
require( DIR_FS_CATALOG.'admin/includes/ipdfbill/classes/pdfbill_closed.php' );

require( DIR_FS_CATALOG.'admin/includes/ipdfbill/classes/order_pdf.php' );

require_once (DIR_FS_INC.'xtc_get_order_data.inc.php');
require_once (DIR_FS_INC.'xtc_get_attributes_model.inc.php');

define('ATTACHMENT_TXT' , 'includes/ipdfbill/user/pdf_attachment.txt' );    

define('COUNT_FOOTERBLOCKS' , 4);

define('DEFAULT_LANGUAGE_ID' , 2);   
define('DEMOTEXT' , 'DEMO');                        // if Demomode

define('DATA_CELL_WIDTH' , 135);               // default
define('DATA_CELL_HEIGHT' , 10);          
define('DATA_CELL_FONT_COLOR' , '#000000' ); 
define('DATA_CELL_FONT_TYPE' , 'arial' );   
define('DATA_CELL_FONT_STYLE' , '' );  
define('DATA_CELL_FONT_SIZE' , '6' );  
define('DATA_CELL_POSITION' , 'L' );  

define('DATA_CELL_IMAGE_WIDTH' , 20 );               // default
define('DATA_CELL_IMAGE_HEIGHT' , 20 );          
//define('DATA_CELL_IMAGE_IMGPATH' , DIR_FS_CATALOG_THUMBNAIL_IMAGES );          
define('DATA_CELL_IMAGE_IMGPATH' , DIR_FS_CATALOG_INFO_IMAGES );          

define('PAGE_HEIGHT' , 250 ); 
define('PAGE_WIDTH' , 180 );

define('DEFAULT_BORDER' , 0 );
define('DEFAULT_BORDER_COLOR' , '#000000' );

define('PDF_IMAGE_DIR', 'includes/ipdfbill/images/user/' );






class pdfbill extends pdfbill_closed {
   
  var $xtcPrice;
  
  
  function __construct( $parameter_arr, $orders_id, $demomode=false ) {
    if( !$demomode ) {
      $parameter_arr['pdfdebug']='0';
      $parameter_arr['grids']='0';
    }

    $this->xtcPrice = new xtcPrice( $this->parameter_arr['data_currencie'], 
                                    $this->parameter_arr['data_customers_status'] );

    parent::pdfbill_closed($parameter_arr, $orders_id, $demomode );
  }



	/**
	 * Produktdaten einlesen
	 *
	 * @param array $selected_products	uebergebene Auswahl
	 */
   
  function LoadData($oID) {
    global $xtPrice;
    
    // --- bof -- changes -- h.koch@hen-vm68.com -- 05.2016 --
    //$c_query ="SELECT
    //            customers_status
    //          FROM " . TABLE_ORDERS . "
    //          WHERE
    //            orders_id = '".$oID."'";
    $c_query ="SELECT
               customers_status,
               currency
               FROM " . TABLE_ORDERS . "
               WHERE
               orders_id = '".$oID."'";
    // --- eof -- changes -- h.koch@hen-vm68.com -- 05.2016 --
		$c_query = xtDBquery($c_query);
		$c_query = xtc_db_fetch_array($c_query);
    $customers_status = $c_query['customers_status'];
    $currency         = $c_query['currency'];  // EUR, CHF 
    // --- changes -- h.koch@hen-vm68.com -- 05.2016 --


    //$xtPrice = new xtcPrice( 'EUR',  $customers_status );
    $xtPrice = new xtcPrice( $currency,  $customers_status ); 
    // --- changes -- h.koch@hen-vm68.com -- 05.2016 --
	  $order = new order_pdf($oID);    
	  $this->data['address_label_customer'] = xtc_address_format($order->customer['format_id'], $order->customer, 0, '', "\n");
	  $this->data['address_label_shipping'] = xtc_address_format($order->delivery['format_id'], $order->delivery, 0, '', "\n");
	  $this->data['address_label_payment']  = xtc_address_format($order->billing['format_id'], $order->billing, 0, '', "\n");
    $this->data['ACCOUNT_HOLDER'] = $order->info['account_holder'];
	  $this->data['ACCOUNT_NUMBER'] = $order->info['account_number'];
	  $this->data['BANK_CODE'] = $order->info['bank_code'];
	  $this->data['BANK_NAME'] = $order->info['bank_name'];
	  $this->data['INVOICE_REFERENCE'] = $order->info['invoice_reference'];
	  $this->data['INVOICE_DUE_DATE'] = $order->info['invoice_due_date'];
          
    $this->data['PAYPAL_ADDRESS'] = $order->info['address_pp'];
	  $this->data['PAYPAL_EMAIL'] = $order->info['email_pp'];
	  $this->data['PAYPAL_ACC_STATUS'] = $order->info['account_status_pp'];
	  $this->data['PAYPAL_INTENT'] = $order->info['intent_pp'];
	  $this->data['PAYPAL_PRICE'] = $order->info['price_pp'];
	  $this->data['csID'] = $order->customer['csID'];
	  // get products data
	  $order_total = $order->getTotalData($oID); 
	  $this->data['order_data'] = $order->getOrderData($oID);
	  $this->data['order_total'] = $order_total['data'];

	  // assign language to template for caching
	  $this->data['language'] = $_SESSION['language'];
	  $this->data['oID'] = $oID;
	  if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
		  include (DIR_FS_LANGUAGES.$_SESSION['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
		  $payment_method = constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));
	  }
    $this->data['payment_method'] = $order->info['payment_method'];
	  $this->data['PAYMENT_METHOD'] =$payment_method;
	  $this->data['COMMENT'] = $order->info['comments'];
	  $this->data['order'] = $order;
	  $this->data['DATE'] = xtc_date_short($order->info['date_purchased']);
	  $this->data['DATE_INVOICE'] = xtc_date_short($order->info['ibn_billdate']);
    
    $this->data['ibn_billdate'] = $order->info['ibn_billdate'];
    $this->data['ibn_billnr'] = $order->info['ibn_billnr'];
    
//echo "data:<pre>"; print_r($this->data); echo "</pre>";    
    return;

    
  }
  
  
	function format_sortData(){
    $sorted_products=array();
		$categories = xtc_get_category_tree();
		for($i_cat=1;$i_cat<sizeof($categories);$i_cat++){
			for($i_products=0;$i_products<sizeof($this->data);$i_products++){
				if($categories[$i_cat]['id'] == $this->data[$i_products]['categories_id']){
					//unset($data[$i_products][8]);
					$sorted_products[] = $this->data[$i_products];
				}
			}
		}
		$this->data=$sorted_products;
	} 
  
  
  function make_categorie_tree() {
		$categories = xtc_get_category_tree();
    foreach( $categories as $i => $cat ) {
      if( $i==0 ) continue;                      // ignore "top" categorie
      
			$count = substr_count($cat['text'], '&nbsp;'); 
      $categories[$i]['text'] = str_replace( '&nbsp;', '', $cat['text']);
      
      $last[$count] = $cat['id'];
      $last_inx[$count] = $i;
      
      $cat_id    = $cat['id'];
      $parent_id = $count>0?$last[$count-3]:0;
      $categories[$i]['parent_id'] = $parent_id;
      $categories[$i]['parent_index'] = $count>0?$last_inx[$count-3]:0;
		}
    $this->categorie_tree = $categories;  
  }
  
  function make_categorie_path_txt( $cat_id ) {
    $ret = array();
    if( !isset($this->categorie_tree) ){ 
      $this->make_categorie_tree();
    }
    for( $i=0; $i<sizeof($this->categorie_tree); $i++ ) {
      if( $cat_id == $this->categorie_tree[$i]['id'] ) {
        break;
      }
    }
    if( $i<sizeof($this->categorie_tree) ) {
      while( $i>=0 ) {
        $ret[] = $this->categorie_tree[$i]['text'];
        $i=$this->categorie_tree[$i]['parent_index'];
        if( $i==0 ) {
          break;
        }
      }
    }
    
    return array_reverse($ret);
  }
  
  
  function make_categorie_path_id( $cat_id ) {
    $ret = array();
    if( !isset($this->categorie_tree) ){ 
      $this->make_categorie_tree();
    }
    for( $i=0; $i<sizeof($this->categorie_tree); $i++ ) {
      if( $cat_id == $this->categorie_tree[$i]['id'] ) {
        break;
      }
    }
    if( $i<sizeof($this->categorie_tree) ) {
      while( $i>=0 ) {
        $ret[] = $this->categorie_tree[$i]['id'];
        $i=$this->categorie_tree[$i]['parent_index'];
        if( $i==0 ) {
          break;
        }
      }
    }
    
    return array_reverse($ret);
  }   
    
}
  

    
    
?>