<?php

/*
	Idealo, Export-Modul

	(c) Idealo 2013,
	
	Please note that this extension is provided as is and without any warranty. It is recommended to always backup your installation prior to use. Use at your own risk.
	
	Extended by
	
	Christoph Zurek (Idealo Internet GmbH, http://www.idealo.de)
*/





defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

if (!file_exists ( DIR_FS_CATALOG . 'export/idealo/idealo_csv_set_and_get_setting.php') ){
	$missingClasses [] = 'idealo_csv_set_and_get_setting.php';
}else{
	require_once ( DIR_FS_CATALOG . 'export/idealo/idealo_csv_set_and_get_setting.php' );	
}

if (!file_exists ( DIR_FS_CATALOG . 'export/idealo/idealo_csv_tools.php') ){
	$missingClasses [] = 'idealo_csv_tools.php';
}else{
	require_once ( DIR_FS_CATALOG . 'export/idealo/idealo_csv_tools.php' );	
}

if (!file_exists ( DIR_FS_CATALOG . 'export/idealo/idealo_csv_shipping.php') ){
	$missingClasses [] = 'idealo_csv_shipping.php';
}else{
	include_once ( DIR_FS_CATALOG . 'export/idealo/idealo_csv_shipping.php' );	
}

if (!file_exists ( DIR_FS_CATALOG . 'export/idealo/idealo_csv_payment.php') ){
	$missingClasses [] = 'idealo_csv_payment.php';
}else{
	include_once ( DIR_FS_CATALOG . 'export/idealo/idealo_csv_payment.php' );	
}

if (!file_exists ( DIR_FS_CATALOG . 'export/idealo/idealo_csv_definition.php') ){
	$missingClasses [] = 'idealo_csv_definition.php';
}else{
	require_once ( DIR_FS_CATALOG . 'export/idealo/idealo_csv_definition.php' );	
}

if ( !empty ($missingClasses) ){
	
	$javaSK = '<script type="text/javascript">
						alert("Die folgenden Dateien existieren nicht, bzw. koennen nicht geoeffnet werden:\n\n';

						foreach ($missingClasses as $miss ){
			    				
			    			$javaSK .= '\ ' . $miss . '\n';
		    			
		    			}


					$javaSK .= '\ \nUeberpruefen Sie in den Ordner export/idealo/, ob die Dateien vorhanden sind und gelesen werden koennen.\n\n' .
							'Ohne diese Dateien kann das Modul nicht ausgefuehrt werden!");</script>';
	
	
	
	echo$javaSK;
	
}
class idealo{
    public $code;
    public $title;
    public $description;
    public $enabled;
	
	public $payment = array();
	
    public $shipping = array();	
    
    public function __construct() {

      $this->saveUrl();
                      
      $this->code = 'idealo';
		
	  if ( TEXT_IDEALO_CSV_MODIFIED == 'no' ){
      	      $this->title = MODULE_IDEALO_CSV_TEXT_TITLE . ' v. '. MODULE_IDEALO_CSV_VERSION_TEXT_02 . ' - ' . NEW_IDEALO_CSV_VERSION_TEXT;
      }else{
      	      $this->title = MODULE_IDEALO_CSV_TEXT_TITLE . ' v. '. MODULE_IDEALO_CSV_VERSION_TEXT_02 . '.mod - ' . NEW_IDEALO_CSV_VERSION_TEXT;
      }

      $this->description = MODULE_IDEALO_CSV_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_IDEALO_CSV_SORT_ORDER;
      $this->enabled = ((MODULE_IDEALO_CSV_STATUS == 'True') ? true : false);
      $this->CAT=array();
      $this->PARENT=array();
      $this->productsPrice = 0;
      $this->description = '<center><a href="http://www.idealo.de" target="_blank">'.xtc_image(DIR_WS_CATALOG.'export/idealo/logo_blue_big.png').'</a></center>';
      $this->country_array = array();
    }

	public function saveURL(){
		 $fp = fopen(DIR_FS_DOCUMENT_ROOT.'export/link.ido', "w+");
	          fputs($fp, HTTP_CATALOG_SERVER . '|'.  DIR_WS_CATALOG_ORIGINAL_IMAGES);
	          fclose($fp); 
	}


	
	
	

	
	
	
	public function createModule(){
	
		$checkLOF = xtc_db_query("	SELECT table_name
									FROM information_schema.tables
									WHERE `table_name` = 'idealo_csv_settings' AND `table_schema` LIKE '" . DB_DATABASE . "';");

		$result = xtc_db_fetch_array($checkLOF);
		
		if ( empty ( $result ) ){
			
			
			$sql = "CREATE TABLE `idealo_csv_setting` (`idealo` varchar(10)";
			$sql2 = "INSERT INTO `idealo_csv_setting` VALUES(''";
			
			$idealo_shipping = new idealo_csv_shipping();
	 		$this->shipping = $idealo_shipping->shipping;
			
			foreach ( $this->shipping as $ship ) {
				
				$active = 'idealo_' . $ship['country'] . '_active';
				$sql .= ", `" . $active . "` varchar(10)";
				$sql2 .= ", '0'";
				
				$costs = 'idealo_' . $ship['country'] . '_costs';
				$sql .= ", `" . $costs . "` varchar(300)";
				$sql2 .= ", ''";
				
				$free = 'idealo_' . $ship['country'] . '_free';
				$sql .= ", `" . $free . "` varchar(20)";
				$sql2 .= ", ''";
				
				$type = 'idealo_' . $ship['country'] . '_type';
				$sql .= ", `" . $type . "` varchar(10)";
				$sql2 .= ", ''";
				
			}

			$idealo_payment = new idealo_csv_payment();
	 		$this->payment = $idealo_payment->payment;

			foreach ( $this->payment as $pay ) {
							
				$active = 'idealo_' . $pay [ 'db' ] . '_active';
				$sql .= ", `" . $active . "` varchar(10)";
				$sql2 .= ", '0'";
				
				$countries = 'idealo_' . $pay [ 'db' ] . '_countries';
				$sql .= ", `" . $countries . "` varchar(10)";
				$sql2 .= ", ''";
						
				$fix = 'idealo_' . $pay [ 'db' ] . '_fix';
				$sql .= ", `" . $fix . "` varchar(10)";
				$sql2 .= ", ''";
							
				$percent = 'idealo_' . $pay [ 'db' ] . '_percent';
				$sql .= ", `" . $percent . "` varchar(10)";
				$sql2 .= ", ''";
							
				$shipping = 'idealo_' . $pay [ 'db' ] . '_shipping';
				$sql .= ", `" . $shipping . "` varchar(10)";			
				$sql2 .= ", '0'";
				
				$max = 'idealo_' . $pay [ 'db' ] . '_max';
				$sql .= ", `" . $max . "` varchar(10)";			
				$sql2 .= ", ''";
				
			}
			
			$sql .= ", `idealoMinorderprice` varchar(10), `idealoMinorder` varchar(10), `idealoMinorderBorder` varchar(10), `idealoExportAttributes` varchar(1000));";
			$sql2 .= ", '', '', '', '');";

			xtc_db_query ( $sql );			
			xtc_db_query ( $sql2 );			
			
		}		
				
	}
    
    
     private function deleteModule(){
     		xtc_db_query("DROP TABLE `idealo_csv_setting`");
     		
     }
   
   
   
    private function setValueIdealoSetting($row, $value){
    	$sql = "UPDATE `idealo_csv_setting` SET `" . $row . "` = '" . $value . "';";
		xtc_db_query($sql);
    }
   
   
   
   public function isInError ( $error_array, $error ){
   	
   	foreach ( $error_array as $elemnt ){
   		
   		if ( $elemnt == $error ){
   			
   			return true;
   			
   		}
   		
   	}
   	
   	return false;
   	
   }
   
   
    private function errorSettingMessage ( $not_set ){

    	$missing_config = '';
	 	
	 	foreach ( $not_set as $value ){
	 		
	 		$missing_config .= $value . ';';
	 		
	 	}
	 	
	 	$missing_config = substr ( $missing_config, 0, -1 );
    	xtc_db_query("update " . TABLE_CONFIGURATION . "
				      set configuration_value = '" . $missing_config . "'
				      where configuration_key = 'MODULE_IDEALO_CSV_MISSING_CONFIG'");

    	$html = '	<body bgcolor="#99CCFF">
						<b>
						<center>
						<font face="Arial,MS Sans Serif">
			 			
			 			<form action="javascript:history.back()">
			 				<br><br>
			 				<div id="logo">
								<a href="http://www.idealo.de" target="_blank">'.xtc_image(DIR_WS_CATALOG.'export/idealo/logo_blue_big.png', 'Price Comparison', '', '', 'class="logo noborder"').'</a>
							</div>
										
							<br><br>
							Der Export konnte nicht erfolgen.<br><br>
									
							Folgende Einstellungen m&uuml;ssen erg&auml;nzt, oder ge&auml;ndert werden:<br><br>';
							
		if ( $this->isInError ( $not_set, "file" ) ){
				
			$html .= IDEALO_TEXT_MISSING_CONFIG;
			
		}
		
		if ( $this->isInError ( $not_set, "separator" ) ){
			
			$html .= IDEALO_TEXT_MISSING_SEPARATOR . '<br><br>';
			
		}
		
		if ( $this->isInError ( $not_set, "to_long" ) ){
			
			$html .= IDEALO_TEXT_MISSING_SEPARATOR_TO_LONG . '<br><br>';
			
		}
		
		if ( $this->isInError ( $not_set, "shipping" ) ){
			
			$html .= IDEALO_TEXT_MISSING_SHIPPING . '<br><br>';
			
		}
		
		if ( $this->isInError ( $not_set, "payment" ) ){
			
			$html .= IDEALO_TEXT_MISSING_PAYMENT . '<br><br>';
			
		}
		
		if ( $this->isInError ( $not_set, "idealo_DE_active" ) ){
			
			$html .= IDEALO_TEXT_MISSING_COSTS_IDEALO_DE . '<br><br>';
			
		}
		
		if ( $this->isInError ( $not_set, "idealo_AT_active" ) ){
			
			$html .= IDEALO_TEXT_MISSING_COSTS_IDEALO_DE . '<br><br>';
			
		}
		
		if($this->isInError ( $not_set, "shippingDElenght" )
			|| $this->isInError ( $not_set, "shippingDEone" )
			|| $this->isInError ( $not_set, "shippingATlenght" )
			|| $this->isInError ( $not_set, "shippingATone" )){
				$html .= IDEALO_CSV_SHIPPING_FORMAT_TEXT . '<br><br>';
			}
					
		if ( $this->isInError ( $not_set, "shippingDElenght" ) ){
			
			$html .= IDEALO_TEXT_WRONG_COSTS_FORMAT_DE . '<br><br>';
			
		}
		
		if ( $this->isInError ( $not_set, "shippingDEone" ) ){
			
			$html .= IDEALO_TEXT_ONEWRONG_COSTS_FORMAT_DE . '<br><br>';
			
		}
		
		if ( $this->isInError ( $not_set, "shippingATlenght" ) ){
			
			$html .= IDEALO_TEXT_WRONG_COSTS_FORMAT_AT . '<br><br>';
			
		}
		
		if ( $this->isInError ( $not_set, "shippingATone" ) ){
			
			$html .= IDEALO_TEXT_ONEWRONG_COSTS_FORMAT_AT . '<br><br>';
			
		}
							
		$html .=		'<input id="export" type="submit" name="failed" value="Zur&uuml;ck zum Modul" />
		    				 		
		    			</form>
		    			</font>
						</center>
						</b>
					</body>';
		
		echo $html;
					
    }
   
   	
   	private function checkSettingSet (){

   		$not_set = array();
   		
   		$file = $_POST [ 'configuration' ];
   		
   		$file = $file [ 'MODULE_IDEALO_CSV_FILE' ];

   		if ( $file == '' ){
   			
   			$not_set [] = 'file';
   			   			
   		}

   		if ( $_POST [ 'idealo_csv_separator_input' ] == '' ){
   			
   			$not_set [] = 'separator';
   			
   		}elseif ( strlen ( $_POST [ 'idealo_csv_separator_input' ] ) > 1 ) {
   			
   			$not_set [] = 'to_long';
   			
   		}
   		$idealo_shipping = new idealo_csv_shipping();
	 	$this->shipping = $idealo_shipping->shipping;
		
		$shipping_active = false;
				
	 	foreach( $this->shipping as $ship ){

	 		$active = 'idealo_' . $ship['country'] . '_active';
	 		$value = $_POST['shipping_' . $ship['country'] . '_active'];			
				
				if ( $value == '1' ){	
				
					$shipping_active = true;
					
					$costs = 'idealo_' . $ship['country'] . '_costs';
					$value = $_POST['shipping_' . $ship['country'] . '_costs'];
					
					if ( $value == '' ){
						
						$not_set [] = $active;
						
					} 
				
				}
						
			
	 	}

   		if($shipping_active !== true){
   			$not_set [] = 'shipping';
   		}
   		$idealo_payment = new idealo_csv_payment();
	 	$this->payment = $idealo_payment->payment;
	 	
	 	$payment_active = false;

	 	foreach( $this->payment as $pay ){
	 		
	 		$active = '$_csv__' . $pay['db'] . '_active';
			$value = $_POST['payment_' . $pay['db'] . '_active'];
			
			if ( $value == '1' ){
	
				$payment_active = true;
				
				break;
				
			}
			
		}

	 	if ( !$payment_active ){

   			$not_set [] = 'payment';
   			
   		}
   		
   		if($_POST['shipping_DE_active'] == 1 && $_POST['shipping_DE_type'] == 3){
   			if(!is_numeric($_POST['shipping_DE_costs'])){
   				$not_set [] = 'shippingDElenght';
   			}
   		}

   		if($_POST['shipping_DE_active'] == 1 && $_POST['shipping_DE_type'] != 3){
   			$shippingCostsDE = explode(";", $_POST['shipping_DE_costs']);
   			if(count($shippingCostsDE) <= 1){
   				$not_set []= 'shippingDElenght';
   			}else{
   				foreach($shippingCostsDE as $costs){
   					$costs = explode(":", $costs);
   					if(count($costs) <= 1){
						$not_set [] = 'shippingDEone';
						break;
   					}	
   					
   				}
   			}
   			
   		}
   		
   		if($_POST['shipping_AT_active'] == 1 && $_POST['shipping_AT_type'] == 3){
   			if(!is_numeric($_POST['shipping_AT_costs'])){
   				$not_set [] = 'shippingATlenght';
   			}
   		}
   		if($_POST['shipping_AT_active'] == 1 && $_POST['shipping_AT_type'] != 3){
   			$shippingCostsDE = explode(";", $_POST['shipping_AT_costs']);
   			if(count($shippingCostsDE) <= 1){
   				$not_set []= 'shippingATlenght';
   			}else{
   				foreach($shippingCostsDE as $costs){
   					$costs = explode(":", $costs);
   					if(count($costs) <= 1){
						$not_set [] = 'shippingATone';
						break;
   					}	
   					
   				}
   			}
   			
   		}

   		if ( count ( $not_set ) > 0 ){
   			
   			$this->errorSettingMessage ( $not_set );
   			
   			return false;
   				
   		}else{
	   		$this->noSettingErrors();
	   		
	   		return true;
   			
   		}
   		
   	}
   
   
   
    private function noSettingErrors(){
    	xtc_db_query("update " . TABLE_CONFIGURATION . "
				      set configuration_value = ''
				      where configuration_key = 'MODULE_IDEALO_CSV_MISSING_CONFIG'");
    	
    }
    
   
	     
	 public function saveSetting(){
	 	xtc_db_query("update " . TABLE_CONFIGURATION . "
				      set configuration_value = ''
				      where configuration_key = 'MODULE_CSV_MISSING_CONFIG'");
	 	
	 	$check = $this->checkSettingSet();

		$idealo_shipping = new idealo_csv_shipping();
	 	$this->shipping = $idealo_shipping->shipping;
	 	foreach( $this->shipping as $ship ){
	
	 		$active = 'idealo_' . $ship['country'] . '_active';
	 		$value = $_POST['shipping_' . $ship['country'] . '_active'];
			$shipping['active'] = $this->setValueIdealoSetting($active, $value);
			
			$costs = 'idealo_' . $ship['country'] . '_costs';
			$value = $_POST['shipping_' . $ship['country'] . '_costs'];
     		$this->setValueIdealoSetting($costs, $value);
     
     		$free = 'idealo_' . $ship['country'] . '_free';
     		$value = $_POST['shipping_' . $ship['country'] . '_free'];
     		$this->setValueIdealoSetting($free, $value);
			
			$type = 'idealo_' . $ship['country'] . '_type';
			$value = $_POST['shipping_' . $ship['country'] . '_type'];
			
     		$this->setValueIdealoSetting ( $type, $value );
     		
	 	}
	 	
	 	$idealo_payment = new idealo_csv_payment();
	 	$this->payment = $idealo_payment->payment;
	 	
	 	foreach( $this->payment as $pay ){
	 		
	 		$active = 'idealo_' . $pay['db'] . '_active';
			$value = $_POST['payment_' . $pay['db'] . '_active'];
			$this->setValueIdealoSetting($active, $value);
			
			$countries = 'idealo_' . $pay['db'] . '_countries';
			$value = $_POST['payment_' . $pay['db'] . '_country'];
			$this->setValueIdealoSetting($countries, $value);
					
			$fix = 'idealo_' . $pay['db'] . '_fix';
			$value = $_POST['payment_' . $pay['db'] . '_extrafee_fix'];
			$this->setValueIdealoSetting($fix, $value);
						
			$percent = 'idealo_' . $pay['db'] . '_percent';
			$value = $_POST['payment_' . $pay['db'] . '_extrafee_nofix'];
			$this->setValueIdealoSetting($percent, $value);
				
			$max = 'idealo_' . $pay['db'] . '_max';
			$value = $_POST['payment_' . $pay['db'] . '_extrafee_max'];
			$this->setValueIdealoSetting($max, $value);
				
			$value = '1';		
			$shipping = 'idealo_' . $pay['db'] . '_shipping';
			
			if ( $_POST['payment_' . $pay['db'] . '_nofix_inkl_sc'] == 'no' ){
				
				$value = '0';
				
			}
			
			$this->setValueIdealoSetting ( $shipping, $value );
			
		 }
    	xtc_db_query("UPDATE `idealo_csv_setting` SET `idealoMinorder` = '" . $_POST['idealo_csv_minOrder_input'] . "';");	
    	xtc_db_query("UPDATE `idealo_csv_setting` SET `idealoMinorderprice` = '" . $_POST['idealo_csv_minOrderPrice_input'] . "';");	
		xtc_db_query("UPDATE `idealo_csv_setting` SET `idealoMinorderBorder` = '" . $_POST['idealo_csv_minOrderBorder_input'] . "';");	
				      	 		 	
	 	if ( $check ){
	 		
	 		return true;
	 		
	 	}
	 	
	 	return false;
	 	
	 }




	
    public function process ( $file ) {

		if ( $this->saveSetting() ){

	    	@xtc_set_time_limit(0);
	    	
	    	$export_query = xtc_db_query( " SELECT count(*) FROM " . TABLE_PRODUCTS . ";" );
	                            
			$articleCount = xtc_db_fetch_array ( $export_query);
			
			$articleCount = $articleCount  ['count(*)'];

	    	$tools = new idealo_csv_tools();
	    	
	    	$tools->AllNeeded();
	    	
	    	$schema = $tools->createHeader();
	    	
	    	$tools->createFile($schema);
			
			$begin = 0;
						
			$step = 10;
			
			do{
				$schema = $tools->exportArticle( $begin, $step );
	           
    			$tools->openCSVFile($schema);
    			
    			$begin += $step;
    			
			}while ( $begin < ($articleCount + $step));	    	
	    	
	    	if ( $tools->separatorWarning ){

	    		$separatorInt = false;
	    		
	    		foreach ($tools->separatorArray as $separ ){
	    			
	    			if ( $separ[ 'comes' ] == 0 ){
	    				
	    				$separatorInt = true;
	    				
	    			}
	    			
	    		}
	    		
	    		$javaSK = '<script type="text/javascript">
						alert("Der eingestellte Spaltentrenner \"'. IDEALO_CSV_SEPARATOR . '\" kommt in Ihren Texten '. $tools->separatorInt .' mal vor!\n\n' .
								'\Dies kann zur Spaltenverschiebungen in Ihrer Datei fuehren\n\n' .
								'\Alternativ sollten Sie einen der folgenden Spaltentrenner verwenden:\n\n';

						if ( !$separatorInt ){
							
							$javaSK .= '\Leider kann Ihnen das Modul keinen Vorschlag machen. Wenden Sie sich bitte an csv@idealo.de';
							
						}else{
							
							foreach ($tools->separatorArray as $separ ){
	    			
				    			if ( $separ[ 'comes' ] == 0 ){
				    				
				    				$javaSK .= '\ ' . $separ[ 'separator' ] . '\n';
				    				
				    			}
			    			
			    			}
							
						}

					$javaSK .= '\ ");</script>';
					
					echo $javaSK;
	    		
	    	}

	    	$this->backToBackend(substr ( $_SERVER [ 'PHP_SELF' ], 0, -24));
			    
		}else{
			die();
			
		}		

	}
	
	
	 public function backToBackend ( $url ){
       $html = '	<body bgcolor="#99CCFF">
					<b>
					<center>
					<font face="Arial,MS Sans Serif">
		 				<br><br>
		 				<div id="logo">
							<a href="http://www.idealo.de" target="_blank">'.xtc_image(DIR_WS_CATALOG.'export/idealo/logo_blue_big.png', 'Price Comparison', '', '', 'class="logo noborder"').'</a>
						</div><br><br>';
									
		$html .= '<br><br>';
					
		$html .=		'Ihre Artikel wurden erfolgreich exportiert.<br><br>

						Sie k&ouml;nnen die Datei hier herunterladen:<br><br>
						<a href="' . $url . '/export/idealo.csv"><img src="' . $url . '/export/idealo/idealo_csv_file.gif"></a><br><br>
						Link zu der CSV Datei:<br><br>'
						. HTTP_CATALOG_SERVER . $url . '/export/idealo.csv</a><br><br>

						Schicken Sie diesen Link bitte an csv@idealo.de<br><br>
						<form name="back" action="javascript:history.back()">
	    				<input id="back" type="submit" name="back" value="zur&uuml;ck zum Backend" />
	    			</form>		
	    			</font>
					</center>
					</b>
				</body>';

		echo $html;die();
				 
	 }	
	
    public function display() {
		$tools = new idealo_csv_tools();
		$missing_config_db = $tools->getConfigurationValue('MODULE_IDEALO_CSV_MISSING_CONFIG');
		$missing_config_file = '';
		$missing_config_separator = '';
		$missing_config_separator_to_long = '';		
		$missing_config_shipping = '';
		$missing_config_payment = '';
		
		$missing_config_costs_idealo_DE_active = '';
		$missing_config_costs_idealo_DE_active = '';
		$missing_config_format_idealo_AT_shipping = '';
		$missing_config_format_idealo_AT_shipping = '';
		
		if ( $missing_config_db != '' ){
			
			if ( strpos ( $missing_config_db, "file" ) !== false ){
				
				$missing_config_file = IDEALO_TEXT_MISSING_CONFIG;
				
			}
			
			if ( strpos ( $missing_config_db, "separator" ) !== false ){
				
				$missing_config_separator = IDEALO_TEXT_MISSING_SEPARATOR . '<br><br>';
				
			}
			
			if ( strpos ( $missing_config_db, "to_long" ) !== false ){
				
				$missing_config_separator_to_long = IDEALO_TEXT_MISSING_SEPARATOR_TO_LONG . '<br><br>';
				
			}
			
			if ( strpos ( $missing_config_db, "shipping" ) !== false && strpos ( $missing_config_db, "shippingDE" ) === false){
				
				$missing_config_shipping = IDEALO_TEXT_MISSING_SHIPPING;
				
			}
			
			if ( strpos ( $missing_config_db, "payment" ) !== false ){
				
				$missing_config_payment = IDEALO_TEXT_MISSING_PAYMENT;
				
			}
			
			if ( strpos ( $missing_config_db, "idealo_DE_active" ) !== false ){
				
				$missing_config_costs_idealo_DE_active = IDEALO_TEXT_MISSING_COSTS_IDEALO_DE;
				
			}
			
			if ( strpos ( $missing_config_db, "idealo_AT_active" ) !== false ){
				
				$missing_config_costs_idealo_AT_active = IDEALO_TEXT_MISSING_COSTS_IDEALO_DE;
				
			}
			
			if ( strpos ( $missing_config_db, "shippingDElenght" ) !== false || strpos ( $missing_config_db, "shippingDEone" ) !== false){
				
				$missing_config_format_idealo_DE_shipping = '<font color="#FF0000"><b>* ' . IDEALO_TEXT_WRONG_COSTS_FORMAT_DE . '</b></font>';
				
			}
			
			if ( strpos ( $missing_config_db, "shippingATlenght" ) !== false || strpos ( $missing_config_db, "shippingATone" ) !== false){
				
				$missing_config_format_idealo_AT_shipping = '<font color="#FF0000"><b>* ' . IDEALO_TEXT_WRONG_COSTS_FORMAT_AT . '</b></font>';
				
			}
			
		}
		
		$button_text = 'Exportieren';

	    $customers_statuses_array = xtc_get_customers_statuses();	    
	    
		$ship_text = '';
		
		$tools->getShipping();
	 	$this->shipping = $tools->shipping;
		
		foreach($this->shipping as $ship){     		
			if($ship['country'] == 'DE'){
				$ship_text .= $this->getDisplayShip($ship,
				                                    $missing_config_costs_idealo_DE_active,
				                                    $missing_config_format_idealo_DE_shipping
				                                   );	
			}
			
			if($ship['country'] == 'AT'){
				$ship_text .= $this->getDisplayShip($ship,
				                                    $missing_config_costs_idealo_AT_active,
				                                    $missing_config_format_idealo_AT_shipping
				                                   );	
			}
     	}
     	
		$payment_text = '';	
		
		$tools->getPayment();
	 	$this->payment = $tools->payment;
		
		foreach($this->payment as $payment){     		
     		$payment_text .= $this->getDisplayPayment($payment);	
     	}		
   			   	
   		$article_filter_array[] = array('id' => 'filter', 'text' => 'filtern',);
		$article_filter_array[] = array('id' => 'export', 'text' => 'exportieren',);
		$article_filter = IDEALO_CSV_ARTICLE_FILTER . '<br>' .
						  IDEALO_CSV_ARTICLE_FILTER_SELECTION . '<br>'.
						  xtc_draw_pull_down_menu('article_filter',
						                          $article_filter_array,
						                          $tools->getConfigurationValue('MODULE_IDEALO_CSV_ARTICLE_FILTER')
						                         ).'<br><br>'.
						  IDEALO_CSV_ARTICLE_FILTER_TEXT . '<br>' .
						  xtc_draw_input_field('article_filter_value',
						                       $tools->getConfigurationValue('MODULE_IDEALO_CSV_ARTICLE_FILTER_VALUE')
						                      ) . '<br><br>';
		
		$brand_filter_array[] = array('id' => 'filter', 'text' => 'filtern',);
		$brand_filter_array[] = array('id' => 'export', 'text' => 'exportieren',);
		$brand_filter = IDEALO_CSV_BRAND_FILTER . '<br>' .
						IDEALO_CSV_BRAND_FILTER_SELECTION . '<br>'.
						xtc_draw_pull_down_menu('brand_filter',
						                        $brand_filter_array,
						                        $tools->getConfigurationValue('MODULE_IDEALO_CSV_BRAND_FILTER')
						                       ).'<br><br>'.
						IDEALO_CSV_BRAND_FILTER_TEXT . '<br>' .
						xtc_draw_input_field('brand_filter_value',
						                     $tools->getConfigurationValue('MODULE_IDEALO_CSV_BRAND_FILTER_VALUE')
						                    ) . '<br><br>';
		
		$cat_filter_array[] = array('id' => 'filter', 'text' => 'filtern',);
		$cat_filter_array[] = array('id' => 'export', 'text' => 'exportieren',);
		$cat_filter = IDEALO_CSV_CAT_FILTER . '<br>' .
					  IDEALO_CSV_CAT_FILTER_SELECTION . '<br>'.
					  xtc_draw_pull_down_menu('cat_filter',
					                          $cat_filter_array,
					                          $tools->getConfigurationValue('MODULE_IDEALO_CSV_CAT_FILTER')
					                         ).'<br><br>'.
					  IDEALO_CSV_CAT_FILTER_TEXT . '<br>' .
					  xtc_draw_input_field('cat_filter_value',
					                       $tools->getConfigurationValue('MODULE_IDEALO_CSV_CAT_FILTER_VALUE')
					                      ) . '<br><br>';		
		
		$tools->getMinorderValues();
		
		$minOrderDisplay =	IDEALO_CSV_MIN_ORDER_TITLE . '<br><br>' .
							IDEALO_CSV_MIN_ORDER_VALUE . '<br>' .
		   			   		xtc_draw_input_field('idealo_csv_minOrder_input', $tools->minOrder) . '<br>' .
							IDEALO_CSV_MIN_ORDER_TEXT . '<br><br>' .
							IDEALO_CSV_MIN_EXTRA_COSTS	. '<br>' .
							xtc_draw_input_field('idealo_csv_minOrderPrice_input', $tools->minOrderPrice) . '<br>' .
							IDEALO_CSV_MIN_ORDER_PRICE_TEXT . '<br>' .
							IDEALO_CSV_MIN_ORDER_BORDER_VALUE . '<br>' .
							xtc_draw_input_field('idealo_csv_minOrderBorder_input', $tools->minorderBorder) . '<br>' .
							IDEALO_CSV_MIN_ORDER_BORDER_TEXT;
		   			   		
	    return array('text' => $missing_config_file. '<br>' . 
	    						
	    						FIELDSEPARATOR . '<br>' .
	    						FIELDSEPARATOR_HINT_IDEALO . '<br>' .
	    						xtc_draw_small_input_field('idealo_csv_separator_input', IDEALO_CSV_SEPARATOR) . '<br><br>' .
	    						$missing_config_separator . $missing_config_separator_to_long . 
	    						QUOTING . '<br>' .
	    						QUOTING_HINT . '<br><br>' .
	    						xtc_draw_small_input_field('idealo_csv_quoting_input', IDEALO_CSV_QUOTECHAR) . '<br><br>' .
	        					
	    						SHIPPING . '<br>' .
	    						$missing_config_shipping . '<br><br>' .
	    						
	    						$ship_text .
	            
	                            SHIPPINGCOMMENT . '<br>' .
	                            SHIPPINGCOMMENT_HINT . '<br>' .
	                            xtc_draw_input_field('shippingcomment_input',
	                                                 $tools->getConfigurationValue('MODULE_IDEALO_CSV_SHIPPINGCOMMENT')
	                                                ) . '<br><br>'.
																
	    						PAYMENT . '<br>' .
	    						$missing_config_payment . '<br><br>' .
	    							 
								$payment_text .
								

								$article_filter .
								$brand_filter .
								$cat_filter .
								
								$minOrderDisplay . '<br><br>' .
	            
	                            $this->displayExportKonfigs() .
								
								IDEALO_CSV_EXPORT_TEXT .

                           		xtc_button(BUTTON_EXPORT) . '<font size="+1">*</font> ' . 
	                
	                			'<input id ="export" type="hidden" name="export" value="yes">' .
	                
	                            xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_MODULE_EXPORT,
	                                                                         'set=' . $_GET['set'] . '&module=idealo')
	                                                                        ) .

	                            EXPORT . '<br><br>' .
	                            TEXT_WARANTY_IDEALO_CSV
	                            );


    }

    public function myPopUp(){
        return 
        '<script language="JavaScript" type="text/javascript">
             function OpenWindowWithPost(url, windowoption, name, params){
                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", url);
                form.setAttribute("target", name);
     
                for(var i in params){
                    if(params.hasOwnProperty(i)){
                        var input = document.createElement(\'input\');
                        input.type = \'hidden\';
                        input.name = i;
                        input.value = params[i];
                        form.appendChild(input);
                    }
                }
     
                document.body.appendChild(form);
    
                w = window.open(url, name, windowoption);
                w.focus();
                    
                form.submit();
     
                document.body.removeChild(form);
            }      
                      
            function popup(URL) {
               param = {\'languages_id\' : \'' . $_SESSION [ 'languages_id' ] . '\'};
               w = OpenWindowWithPost(URL, "toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=200,height=400,left=740,top=325", "Attribute Choise", param);
            }
        </script>
       
        <form id="attributeSelection" action="attributeSelectionAction" method="post">       
           <input class=button value="Attributauswahl" onClick="javascript:popup(\'' . substr ( $_SERVER [ 'PHP_SELF' ], 0, -24) . '/export/idealo/csv_variant_choise.php\')">    
        </form>
        Nach dem Klicken &ouml;ffnet sich ein neues Fenster f&uuml;r die Einstellungen, 1x Klicken und bitte warten!<br><br>';
    }
    
	public function displayExportKonfigs(){
	    $tools = new idealo_csv_tools();
	    
	    $text = IDEALO_CSV_EXPORT_SETTINGS . '<br><br>';
	    
	    $campaign_array[] = array ('id' => '0', 'text' => 'no');
	    $campaign_array[] = array ('id' => 'refID=' . CAMPAIGN . '&', 'text' => '94511215 (idealo)');

	    $text .= IDEALO_CSV_CAMPAIGNS.'<br>'.
	             IDEALO_CSV_CAMPAIGNS_DESC.'<br>'.
	             xtc_draw_pull_down_menu('campaign',
	                                     $campaign_array,
	                                     $tools->getConfigurationValue('MODULE_IDEALO_CSV_CAMPAIGN')
	                                    ).'<br><br>';
	    
        $text .= IDEALO_CSV_EXPORT_WAREHOUSE_TEXT . '<br>' .
                 IDEALO_CSV_EXPORT_WAREHOUSE_TEXTDEFINITION . '<br>';
        
	    $warehouse_array[] = array ('id' => '0', 'text' => 'nein');
	    $warehouse_array[] = array ('id' => '1', 'text' => 'ja');
	    
	    $text.= xtc_draw_pull_down_menu('warehouse',
	                                    $warehouse_array,
	                                    $tools->getConfigurationValue('MODULE_IDEALO_CSV_WAREHOUSE')
	                                   ).'<br><br>';
	    $text .= IDEALO_CSV_EXPORT_VARIANTEXPORT_TEXT . '<br>' .
                 IDEALO_CSV_EXPORT_VARIANTEXPORT_TEXTDEFINITION . '<br>';
	    $text.= xtc_draw_pull_down_menu('variantexport',
	                                    $warehouse_array,
	                                    $tools->getConfigurationValue('MODULE_IDEALO_CSV_VARIANT')
	                                   );
	    $text .= $this->myPopUp();
	     
	    return $text;
	}
    
    
	 public function getDisplayPayment( $payment ){
	 	
	 	$active_array[] = array ('id' => '1', 'text' => 'ja',);
		$active_array[] = array ('id' => '0', 'text' => 'nein',);
		
		$country_array [] = array ('id' => '1', 'text' => 'DE',);
		$country_array [] = array ('id' => '2', 'text' => 'AT',);
		$country_array [] = array ('id' => '3', 'text' => 'DE/AT',);
		
		if( $payment['shipping'] == '1' ) {
			$nofix_scinclusive_yes = true;
			$nofix_scinclusive_no = false;
		} else {
			$nofix_scinclusive_yes = false;
			$nofix_scinclusive_no = true;
		}

		return 	  '<b>' . $payment['title'] . '</b><br>'.
				  xtc_draw_pull_down_menu ( 'payment_' . $payment [ 'db' ] . '_active', $active_array, $payment [ 'active' ] ) . '<br>' . 
				  xtc_draw_input_field ( 'payment_' . $payment [ 'db' ] . '_extrafee_fix', $payment [ 'fix' ] ) . PAYMENTEXTRAFEE_INPUT_FIX . '<br>' .
				  xtc_draw_input_field ( 'payment_' . $payment [ 'db' ] . '_extrafee_nofix', $payment [ 'percent' ] ) . PAYMENTEXTRAFEE_INPUT_NOFIX . '<br>' .
				  xtc_draw_input_field ( 'payment_' . $payment [ 'db' ] . '_extrafee_max', $payment [ 'max'] ) . PAYMENTEXTRAFEE_MAX . '<br>' .
	              xtc_draw_radio_field ( 'payment_' . $payment [ 'db' ] . '_nofix_inkl_sc', 'yes', $nofix_scinclusive_yes ) . PAYMENTEXTRAFEE_RADIO_SCINCLUSIVE . '&nbsp;' .
	              xtc_draw_radio_field ( 'payment_' . $payment [ 'db' ] . '_nofix_inkl_sc', 'no', $nofix_scinclusive_no ) . PAYMENTEXTRAFEE_RADIO_SCNOTINCLUSIVE . '<br>' .
	              xtc_draw_pull_down_menu ( 'payment_' . $payment [ 'db' ] .  '_country', $country_array, $payment [ 'country' ] ) . '<br><br>';
	              
	 }

	
	 public function getDisplayShip ( $ship, $missing_text, $wrongShippingFormat ){

	 	$active_array[] = array ('id' => '1', 'text' => 'ja',);
		$active_array[] = array ('id' => '0', 'text' => 'nein',);
		$country_array[] = array ('id' => '3', 'text' => 'Pauschal',);
		$country_array[] = array ('id' => '1', 'text' => 'Gewicht',);
		$country_array[] = array ('id' => '2', 'text' => 'Preis',);
		
		
		return  SHIPPING_TEXT_01 . ' '. $ship['country'] . '?<br>' .
				xtc_draw_pull_down_menu('shipping_' . $ship['country'] . '_active', $active_array, $ship['active']).'<br>' .
				SHIPPING_TEXT_02 . '<br>' .
				$wrongShippingFormat . '<br>' .
				xtc_draw_input_field('shipping_' . $ship['country'] . '_costs', $ship['costs']) . SHIPPING_TEXT_03 . '<br>' .$missing_text . '<br>' .
				SHIPPING_TEXT_04 . '<br>' .
				xtc_draw_input_field('shipping_' . $ship['country'] . '_free', $ship['free']) . SHIPPING_TEXT_05. '<br>' .
				SHIPPING_TEXT_06. '<br>' .
				xtc_draw_pull_down_menu('shipping_' . $ship['country'] . '_type', $country_array, $ship['type']). '<br><br>';
				
	 }
    
    
    
    public function check() {
    	
      if ( !isset( $this->_check ) ) {
      	
        $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_IDEALO_CSV_STATUS'");
        $this->_check = xtc_db_num_rows( $check_query );
        
      }
      
      return $this->_check;
      
    }

	
    public function install() {
      xtc_db_query ( "delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE '%IDEALO_CSV%'" );
      xtc_db_query ( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_IDEALO_CSV_FILE', 'idealo.csv',  '6', '1', '', now())" );
      xtc_db_query ( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_IDEALO_CSV_FILE_TITLE', 'Datei',  '6', '1', '', now())" );
      xtc_db_query ( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_IDEALO_CSV_SEPARATOR', '',  '6', '1', '', now())" );
      xtc_db_query ( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_IDEALO_CSV_QUOTING', '',  '6', '1', '', now())" );
      xtc_db_query ( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_IDEALO_CSV_STATUS', 'True',  '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      xtc_db_query ( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_IDEALO_CSV_STATUS_TITLE', 'True',  '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      xtc_db_query ( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_IDEALO_CSV_STATUS_DESC', 'True',  '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      xtc_db_query ( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_IDEALO_CSV_LANGUAGE', 'DE',  '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      xtc_db_query ( "insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_IDEALO_CSV_MISSING_CONFIG', '1',  '6', '1', '', now())" );
      
      $this->createModule();
      
    }

	
    public function remove() {
    	
      xtc_db_query ( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode ( "', '", $this->keys() ) . "')" );
      xtc_db_query ( "delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE '%IDEALO_CSV%'" );
      
      $this->deleteModule();
      
    }

    public function keys() {
    	
      return array ( 'MODULE_IDEALO_CSV_STATUS','MODULE_IDEALO_CSV_FILE' );
      
    }
    
    
  }
?>
