<?php
/* -----------------------------------------------------------------------------------------
 $Id: afterbuy.php 1287 2005-10-07 10:41:03Z mz $

 modified by F.T.Store (FTS) 2007-08-156 20:07 FTS
 Version 1.8 (August 2007)

 mickser pimpmyxtc.de
 Modifikation:
 2008 	Bei vorhandener Attribut-Artikelnummer diese für die Übertragung verwenden
 2009 	urlencode statt ereg_replace
 		Zahlungsstatus iPayment
		Auswertung Afterbuy-Daten (UID,AID etc.) und eintragen in DB
 2010   getCurrency und getCustomerstatustax ausgelagert (unnötige mehrfach-DB-Anfragen)
 2011-2013 diverse Ergänzungen und Änderungen, neue API-URL (2012)
 
 XT-Commerce - community made shopping
 http://www.xt-commerce.com

 Copyright (c) 2003 XT-Commerce
 -----------------------------------------------------------------------------------------
 based on:
 (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 (c) 2002-2003 osCommerce(Coding Standards); www.oscommerce.com

 Released under the GNU General Public License
 ---------------------------------------------------------------------------------------*/

class xtc_afterbuy_functions 
{
	public $order_id;
	public $afterbuy_aid;
	public $payment_id;
	public $payment_name;
	public $shipment_name;
	public $paid;
	public $logging;
	public $file;
	public $afterbuyString;
	public $afterbuy_URL;
	
	// constructor
	public function __construct($order_id) 
	{
		$this->order_id = $order_id;
	}
	
	public function url_encode($string)
	{
		return urlencode(utf8_decode($string));
	}

	public function setOrder_id($order_id)
	{
		$this->order_id = $order_id;
	}
	
	public function process_order() 
	{
		$this->createAfterbuyString();
		$this->sendOrder();
	}
	public function createAfterbuyString() 
	{

		//ini_set('display_errors',1);
		error_reporting(E_ALL ^E_DEPRECATED ^E_NOTICE);
		require_once("xmlparserv4.php");
		$this->paid = 0;
		
		// ############ SETTINGS ################
		//Daten im XT Admin (werden von Afterbuy mitgeteilt)
		$PartnerID = AFTERBUY_PARTNERID;
		$PartnerPass = AFTERBUY_PARTNERPASS;
		$UserID = AFTERBUY_USERID;
		$order_status = AFTERBUY_ORDERSTATUS;

		define('TABLE_PAYPAL','paypal');
		// ############ THUNK ################

		$customer = array ();
		$this->afterbuy_URL = 'https://api.afterbuy.de/afterbuy/ShopInterface.aspx';

		//***************************************************************************************************************************************//
		//settings:
		$this->file = DIR_FS_DOCUMENT_ROOT.'afterbuylog.txt';
		$this->logging = 1;
		
		//Sendesperre: 
		//bereits übertragene Bestellungen nicht mehr übertragen
		// 1 = aktiv (Standard)
		// 0 = inaktiv
		$sendesperre_bereitsversendet = 1;
		
		//bei Afterbuy vorhandene Bestellungen nicht neu anlegen
		// 1 = aktiv (Standard)
		// 0 = inaktiv
		$afterbuysperre_bereitsvorhandene_Bestellungen = 1;

		//unbezahlte PayPal Bestellungen nicht übertragen
		// 1 = aktiv (Standard)
		// 0 = inaktiv
		$afterbuysperre_unbezahlte_Bestellungen_PayPal = 1;
		
		$verwende_shop_artikelnummer = 0;
		// 0 = Artikelnummer des Shopartikels
		// 1 = interne products_id des Shopartikels (DB-ID)
		// 2 = Afterbuy Produkt-ID (wenn vorhanden, in älteren AfterbuyImportSchnittstellenversionen nicht verwenden)
		// 3 = EAN des Shopartikels 
		
		$paypalexpress = 1;
		$moneybookers = 0;
		$masterpayment = 0;

		$feedbackdatum = '0';
		//0= Feedbackdatum setzen und KEINE automatische Erstkontaktmail versenden
		//1= KEIN Feedbackdatum setzen, aber automatische Erstkontaktmail versenden (Achtung: Kunde müsste Feedback durchlaufen wenn die Erstkontakt nicht angepasst wird!)
		//2= Feedbackdatum setzen und automatische Erstkontaktmail versenden (Achtung: Erstkontaktmail muss mit Variablen angepasst werden!)

		$versandermittlung_ab = 1;
		// 1 = Versand aus XT
		// 0 = Versandermittlung durch Afterbuy (nur wennStammartikel erkannt wird!)
		
		$kundenerkennung = '1';
		// 0=Standard EbayName (= gesamte Zeile "Benutzername" in dieser Datei)
		// 1=Email
		// 2=EKNummer (wenn im XT vorhanden!)

		// ############# ARTIKELERKENNUNG SETZEN #############
		// modified FT
		$Artikelerkennung = '0';
		// 0 = Product ID (p_Model XT muss gleich Product ID Afterbuy sein)
		// 1 = Artikelnummer (p_Model XT muss gleich Arrikelnummer Afterbuy sein)
		// 2 = EAN (p_Model XT muss gleich EAN Afterbuy sein)
		// sollen keine Stammartikel erkannt werden, muss die Zeile: $this->afterbuyString .= "Artikelerkennung=" . $Artikelerkennung ."&";  gelöscht werden
		// sollen keine Stammartikel erkannt werden, muss die Zeile: $Artikelerkennung = '1';  gelöscht werden

		$AlternArtikelNr = '3';
		// 0 = Artikelnummer des Shopartikels
		// 1 = interne products_id des Shopartikels (DB-ID)
		// 2 = Afterbuy Produkt-ID (wenn vorhanden, in älteren AfterbuyImportSchnittstellenversionen nicht verwenden)
		// 3 = EAN des Shopartikels 
		//***************************************************************************************************************************************//
		
		$SoldCurrency = 0;
		// 0 = keine Währungsinformationen übertragen
		// 1 = Währungscodes übertragen
		
		// get order data
		$o_query = xtc_db_query("SELECT * FROM ".TABLE_ORDERS." WHERE orders_id='".$this->order_id."'");
		$oData = xtc_db_fetch_array($o_query);

		// ############CUSTOMERS ADRESS################
		// modified FT (Neuer Parameter Übergabe der 2.Adresszeile)

		$customer['id'] = $oData['customers_id'];
		$customer['firma'] = $this->url_encode($oData['billing_company']);
		$customer['vorname'] = $this->url_encode($oData['billing_firstname']);
		$customer['nachname'] = $this->url_encode($oData['billing_lastname']);
		$customer['strasse'] = $this->url_encode($oData['billing_street_address']);
		$customer['strasse2'] = $this->url_encode($oData['billing_suburb']);
		$customer['plz'] = $this->url_encode($oData['billing_postcode']);
		$customer['ort'] = $this->url_encode($oData['billing_city']);
		$customer['tel'] = $this->url_encode($oData['customers_telephone']);
		$customer['fax'] = "";
		$customer['mail'] = $oData['customers_email_address'];
		// get ISO code
		$ctr_query=xtc_db_query("SELECT countries_iso_code_2 FROM ".TABLE_COUNTRIES." WHERE  countries_name='".$oData['customers_country']."'");
		$crt_data=xtc_db_fetch_array($ctr_query);
		$customer['land']=$crt_data['countries_iso_code_2'];

		// ############ VAT_ID ################

		$ustid_querystrg="SELECT customers_vat_id, customers_status FROM ".TABLE_CUSTOMERS." WHERE customers_id ='".$customer['id']."'";
		$ustid_query=xtc_db_query($ustid_querystrg);
		$ustid_data=xtc_db_fetch_array($ustid_query);
		$customer['ustid']=$ustid_data['customers_vat_id'];

		// ############ CUSTOMERS ANREDE ################

		$c_query = xtc_db_query("SELECT customers_gender FROM ".TABLE_CUSTOMERS." WHERE customers_id='".$customer['id']."'");
		$c_data = xtc_db_fetch_array($c_query);
		switch ($c_data['customers_gender']) {
			case 'm' :
				$customer['gender'] = 'Herr';
				break;
			case 'f' :
				$customer['gender'] = 'Frau';
				break;
			default :
				$customer['gender'] = '';
				break;
		}

		// ############ DELIVERY ADRESS ################
		// modified FT (Neuer Parameter Übergabe der 2.Adresszeile)

		$customer['d_firma'] = $this->url_encode($oData['delivery_company']);
		$customer['d_vorname'] = $this->url_encode($oData['delivery_firstname']);
		$customer['d_nachname'] = $this->url_encode($oData['delivery_lastname']);
		$customer['d_strasse'] = $this->url_encode($oData['delivery_street_address']);
		$customer['d_strasse2'] = $this->url_encode($oData['delivery_suburb']);
		$customer['d_plz'] = $this->url_encode($oData['delivery_postcode']);
		$customer['d_ort'] = $this->url_encode($oData['delivery_city']);
		// get ISO code
		$ctr_query=xtc_db_query("SELECT countries_iso_code_2 FROM ".TABLE_COUNTRIES." WHERE  countries_name='".$oData['delivery_country']."'");
		$crt_data=xtc_db_fetch_array($ctr_query);
		$customer['d_land']=$crt_data['countries_iso_code_2'];

		// ############# KUNDENERKENNUNG SETZEN #############
		// Modifiziert FT

		$this->afterbuyString .= "Kundenerkennung=" . $kundenerkennung . "&";
		
		// ############ GET PRODUCT RELATED TO ORDER / INIT GET STRING ################
		// modified FT (Leerzeichen)

		$p_query = xtc_db_query("SELECT * FROM ".TABLE_ORDERS_PRODUCTS." WHERE orders_id='".$this->order_id."'");
		$p_count = xtc_db_num_rows($p_query);
		$this->afterbuyString .= "Action=new&";
		$this->afterbuyString .= "PartnerID=".$PartnerID."&";
		$this->afterbuyString .= "PartnerPass=".$PartnerPass."&";
		$this->afterbuyString .= "UserID=".$UserID."&";
		//$this->afterbuyString .= "Kbenutzername=".$customer['id']."_XTC_".$this->order_id."&";
		$this->afterbuyString .= "Kbenutzername=shop%20cID:".$customer['id']."%20oID:".$this->order_id."&";
		$this->afterbuyString .= "Kanrede=".$customer['gender']."&";
		$this->afterbuyString .= "KFirma=".$customer['firma']."&";
		$this->afterbuyString .= "KVorname=".$customer['vorname']."&";
		$this->afterbuyString .= "KNachname=".$customer['nachname']."&";
		$this->afterbuyString .= "KStrasse=".$customer['strasse']."&";
		$this->afterbuyString .= "KStrasse2=" . $customer['strasse2'] . "&";
		$this->afterbuyString .= "KPLZ=".$customer['plz']."&";
		$this->afterbuyString .= "KOrt=".$customer['ort']."&";
		$this->afterbuyString .= "KTelefon=".$customer['tel']."&";
		$this->afterbuyString .= "Kfax=&";
		$this->afterbuyString .= "Kemail=".$customer['mail']."&";
		$this->afterbuyString .= "KLand=".$customer['land']."&";
		
		// ############# LIEFERANSCHRIFT SETZEN #############
		// Modifiziert FT (Neuer Parameter Übergabe der 2.Adresszeile)
		// hier wird die Rechnungs-und Lieferanschrift verglichen, wenn die Adressen gleich sind, wird kein "L" in der Übersicht gesetzt
		// soll generell ein "L" in der Übersicht gesetzt werden, müssen die $this->afterbuyStrings "Lieferanschrift=1&" sein
			
		if( ($customer['firma']    == $customer['d_firma']) &&
		($customer['vorname']  == $customer['d_vorname']) &&
		($customer['nachname'] == $customer['d_nachname']) &&
		($customer['strasse']  == $customer['d_strasse']) &&
		($customer['strasse2'] == $customer['d_strasse2']) &&
		($customer['plz']      == $customer['d_plz']) &&
		($customer['ort']      == $customer['d_ort']))
		{
			$this->afterbuyString .= "Lieferanschrift=0&";
		}
		else
		{
			$this->afterbuyString .= "Lieferanschrift=1&";
			$this->afterbuyString .= "KLFirma=".$customer['d_firma']."&";
			$this->afterbuyString .= "KLVorname=".$customer['d_vorname']."&";
			$this->afterbuyString .= "KLNachname=".$customer['d_nachname']."&";
			$this->afterbuyString .= "KLStrasse=".$customer['d_strasse']."&";
			$this->afterbuyString .= "KLStrasse2=".$customer['d_strasse2']."&";
			$this->afterbuyString .= "KLPLZ=".$customer['d_plz']."&";
			$this->afterbuyString .= "KLOrt=".$customer['d_ort']."&";
			$this->afterbuyString .= "KLLand=".$customer['d_land']."&";
		}
		
		$this->afterbuyString .= "UsStID=".$customer['ustid']."&";
		
		// ############# HÄNDLERMARKIERUNG AFTERBUY KUNDENDATENSATZ #############
		// Modifiziert FT
		// "H" Kennzeichnung im Kundendatensatz in Afterbuy
		// "Haendler=0&" bedeutet Checkbox deaktiviert
		// "Haendler=1&" bedeutet Checkbox aktiviert
		// "case 'X'" steht für die jeweilige Kundengruppen_ID im XT (-->siehe Admin)

		$customer_status = $ustid_data['customers_status'];
		switch ($customer_status) 
		{
			case '0': //Admin
				$this->afterbuyString .= "Haendler=0&";
				break;
			case '1': //Gast
				$this->afterbuyString .= "Haendler=0&";
				break;
			case '2': //Kunde
				$this->afterbuyString .= "Haendler=0&";
				break;
			case '3': //Händler
				$this->afterbuyString .= "Haendler=1&";
				break;
			case '4': //Händler Ausland
				$this->afterbuyString .= "Haendler=1&";
				break;
			default: //wenn alles nicht zutrifft
				$this->afterbuyString .= "Haendler=0&";
		}

		$xt_currency = $this->getCurrency($oData['currency']);
			
		// ############# PRODUCTS_DATA TEIL1 #############
		// modified FT
		$this->afterbuyString .= "Artikelerkennung=" . $Artikelerkennung ."&";
		$nr = 0;
		$anzahl = 0;
		while ($pDATA = xtc_db_fetch_array($p_query)) {
			$nr ++;
			      
			$check_query = xtc_db_query('SHOW COLUMNS FROM products like "ab_productsid"');
      
			if (xtc_db_num_rows($check_query) == 1) {

				$select_ab_products_id = xtc_db_query("SELECT ab_productsid FROM products WHERE products_id = '".$pDATA['products_id']."'");
				$ab_products_id = xtc_db_fetch_array($select_ab_products_id);
				$afterbuy_products_id = $ab_products_id['ab_productsid'];
				
			} else {
				$afterbuy_products_id = 0;
			}
				
			if ($verwende_shop_artikelnummer == 1)
			{
				$artnr = $pDATA['products_id'];
				if ($artnr == '')
					$artnr = "99999";
			}
			elseif ($verwende_shop_artikelnummer == 2 && $afterbuy_products_id != 0)
			{
				$select_ab_products_id = xtc_db_query("SELECT ab_productsid FROM products WHERE products_id = '".$pDATA['products_id']."'");
				$ab_products_id = xtc_db_fetch_array($select_ab_products_id);
				$artnr = $afterbuy_products_id;
				
			}	
			elseif ($verwende_shop_artikelnummer == 3)
			{
				$select_ab_products_id = xtc_db_query("SELECT products_ean FROM products WHERE products_id = '".$pDATA['products_id']."'");
				$ab_products_id = xtc_db_fetch_array($select_ab_products_id);
				$artnr = $ab_products_id['products_ean'];
				
			}	
			else
			{
				$artnr = $pDATA['products_model'];
			}
		
			if ($AlternArtikelNr == 1)
			{
				$alter_artnr = $pDATA['products_id'];
				if ($alter_artnr == '')
					$alter_artnr = "99999";
			}
			elseif ($AlternArtikelNr == 2 && $afterbuy_products_id != 0)
			{
				$select_ab_products_id = xtc_db_query("SELECT ab_productsid FROM products WHERE products_id = '".$pDATA['products_id']."'");
				$ab_products_id = xtc_db_fetch_array($select_ab_products_id);
				$alter_artnr = $ab_products_id['ab_productsid'];
				
			}	
			elseif ($AlternArtikelNr == 3)
			{
				$select_ab_products_id = xtc_db_query("SELECT products_ean FROM products WHERE products_id = '".$pDATA['products_id']."'");
				$ab_products_id = xtc_db_fetch_array($select_ab_products_id);
				$alter_artnr = $ab_products_id['products_ean'];
				
			}	
			else
			{
				$alter_artnr = $pDATA['products_model'];
			}
			
			
			$a_query = xtc_db_query("SELECT * FROM ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES." WHERE orders_id='".$this->order_id."' AND orders_products_id='".$pDATA['orders_products_id']."'");
			while ($aDATA = xtc_db_fetch_array($a_query))
			{
				if( $verwende_shop_artikelnummer == 1)
				{
					$attribute_model = $this->xtc_get_attributes_products_attributes_id($pDATA['products_id'], $aDATA['products_options_values'], $aDATA['products_options']);
					if ((int)$attribute_model >0)
						$artnr = $attribute_model;
				}
				elseif ($verwende_shop_artikelnummer == 2 && $afterbuy_products_id != 0)
				{
					$attribute_model = $this->xtc_get_attributes_ab_productsid($pDATA['products_id'], $aDATA['products_options_values'], $aDATA['products_options']);
					if ((int)$attribute_model >0)
						$artnr = $attribute_model;
				}
				else
				{
					$attribute_model = $this->xtc_get_attributes_model($pDATA['products_id'], $aDATA['products_options_values'], $aDATA['products_options']);
					if ((int)$attribute_model >0)
						$artnr = $attribute_model;
				}
			}
			
			$artnr = preg_replace('/[^0-9]*/','',$artnr);
			if ($artnr == '')
					$artnr = $pDATA['products_id'];
					
			//$pean_query = xtc_db_query("SELECT * FROM ".TABLE_PRODUCTS." WHERE products_id='".$pDATA['orders_products_id']."' LIMIT 1");
			/*while ($pean = xtc_db_fetch_array($pean_query))
			{
				$attribute_model = $this->xtc_get_attributes_model($pDATA['products_id'], $aDATA['products_options_values'], $aDATA['products_options']);
				if ((int)$attribute_model >0)
				$artnr = $attribute_model;

			}*/
			$this->afterbuyString .= "Artikelnr_".$nr."=".$artnr."&";
			$this->afterbuyString .= "AlternArtikelNr1_".$nr."=".$alter_artnr."&";
			$this->afterbuyString .= "ArtikelStammID_" . $nr . "=" . $afterbuy_products_id . "&";
			$this->afterbuyString .= "Artikelname_".$nr."=".$this->url_encode($pDATA['products_name'])."&";

			// ############# PREISÜBERGABE BRUTTO/NETTO NACH KUNDENGRUPPE #############
			// Kundengruppen müssen jeweilige Zuordnung inkl/excl. Anzeige im Admin XT haben

			$price = $pDATA['products_price'];
			$tax_rate = $pDATA['products_tax'];
			if ($pDATA['allow_tax']==0) {
				$cQuery=xtc_db_query("SELECT customers_status_add_tax_ot FROM ".TABLE_CUSTOMERS_STATUS." WHERE customers_status_id='".$oData['customers_status']."' LIMIT 0,1");
				$cData=xtc_db_fetch_array($cQuery);
				if ($cData['customers_status_add_tax_ot']==0) {
					$tax_rate=0;
				} else {
					$price+=$price/100*$tax_rate;
				}
			}
			//Währungsprüfung
			
			$price = $price * $xt_currency;
			//Währungsprüfung END
			$price = $this->change_dec_separator($price);
			$tax = $this->change_dec_separator($tax_rate);

			// ############# PRODUCTS_DATA TEIL2 #############

			$weight_query = xtc_db_query("SELECT products_weight FROM products WHERE products_id = '".$pDATA['products_id']."'");
			$ab_products_weight = xtc_db_fetch_array($weight_query);
			
			$this->afterbuyString .= "ArtikelEPreis_".$nr."=".$price."&";
			$this->afterbuyString .= "ArtikelGewicht_".$nr."=".$this->change_dec_separator($ab_products_weight['products_weight'])."&";
			$this->afterbuyString .= "ArtikelMwst_".$nr."=".$tax."&";
			$this->afterbuyString .= "ArtikelMenge_".$nr."=". $this->change_dec_separator($pDATA['products_quantity'])."&";
			$url = HTTP_SERVER.DIR_WS_CATALOG.'product_info.php?products_id='.$pDATA['products_id'];
			$this->afterbuyString .= "ArtikelLink_".$nr."=".$url."&";
			//Attributübergabe
			$a_query = xtc_db_query("SELECT * FROM ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES." WHERE orders_id='".$this->order_id."' AND orders_products_id='".$pDATA['orders_products_id']."'");
			$options = '';
			
			
			while ($aDATA = xtc_db_fetch_array($a_query)) 
			{
				$aDATA['products_options_values'] = $this->url_encode($aDATA['products_options_values']);
				$aDATA['products_options'] = $this->url_encode($aDATA['products_options']);
				if ($options == '') {
					$options = $aDATA['products_options'].":".$aDATA['products_options_values'];
				} else {
					$options .= "|".$aDATA['products_options'].":".$aDATA['products_options_values'];
				}
			}
			if ($options != "") {
				$this->afterbuyString .= "Attribute_".$nr."=".$options."&";
			}
			$anzahl += (int)$pDATA['products_quantity'];

		}
		// ############# ORDER_TOTAL #############

		$order_total_query = xtc_db_query("SELECT
											  title,
						                      class,
						                      value,
						                      sort_order
						                      FROM ".TABLE_ORDERS_TOTAL."
						                      WHERE orders_id='".$this->order_id."'
						                      ORDER BY sort_order ASC");

		$order_total = array ();
		$zk = '';
		$cod_fee = '';
		$cod_flag = false;
		$discount_flag = false;
		$gv_flag = false;
		$coupon_flag = false;
		$gv = '';
		$charge_flag = false;
		$loworder_flag = false;
		$ts_schutz_flag = false;
		$ts_schutz = 0;
		$zahlartenaufschlag = 0;
		$customers_status_show_price_tax = $this->getCustomertaxstatus($oData['customers_status']);
		
		while ($order_total_values = xtc_db_fetch_array($order_total_query)) {

			$order_total[] = array ('CLASS' => $order_total_values['class'], 'VALUE' => $order_total_values['value']);

			// ############# NACHNAHME/GUTSCHEINE/KUPONS/RABATTE #############
			if ($order_total_values['class'] == 'ot_shipping')
			$shipping = $order_total_values['value'];

			// Nachnamegebuehr
			if ($order_total_values['class'] == 'ot_cod_fee') {
				$cod_flag = true;
				$cod_fee = $order_total_values['value'];
			}
			// Rabatt
			if ($order_total_values['class'] == 'ot_discount') {
				$discount_flag = true;
				$discount = $order_total_values['value'];
			}
			// Gutschein
			if ($order_total_values['class'] == 'ot_gv') {
				$gv_flag = true;
				$gv = $order_total_values['value'];
			}
			// Kupon
			if ($order_total_values['class'] == 'ot_coupon') {
				$coupon_flag = true;
				$coupon = $order_total_values['value'];
				$coupon_title = $order_total_values['title'];
			}
			// ot_payment
			if ($order_total_values['class']=='ot_payment') {
				$ot_payment_flag=true;
				$ot_payment=$order_total_values['value'];
			}
			// Bonuspunkte
			if ($order_total_values['class'] == 'ot_bonus_fee') {
				$bonus_flag = true;
				$bonus_fee = $order_total_values['value'];
			}
			if ($order_total_values['class'] == 'ot_charge') {
				$charge_flag = true;
				$charge = $order_total_values['value'];
			}			
			if ($order_total_values['class'] == 'ot_loworder') {
				$loworder_flag = true;
				$loworder = $order_total_values['value'];
			}
			//trusted shops 
			if ($order_total_values['class'] == 'ot_ts_schutz') {
				$ts_schutz_flag = true;
				$ts_schutz = $order_total_values['value'];
			}

		}
		// ############# ÜBERGABE NACHNAHME/GUTSCHEINE/KUPONS/RABATTE #############

		$xt_currency = $this->getCurrency($oData['currency']);
		$customers_status_show_price_tax = $this->getCustomertaxstatus($oData['customers_status']);
		
		// Bonuspunkte Übergabe als Produkt
		if ($bonus_flag) 
		{
			$nr ++;
			$this->afterbuyString .= "Artikelnr_".$nr."=99999991&";
			$this->afterbuyString .= "Artikelname_".$nr."=Bonuspunkte&";
			$bonus_fee = $this->get_ot_total_fee($customers_status_show_price_tax, $tax_rate, $xt_currency, (-1)*$bonus_fee);
	
			$this->afterbuyString .= "ArtikelEPreis_".$nr."=".$bonus_fee."&";
			$this->afterbuyString .= "ArtikelMwst_".$nr."=".$tax."&";
			$this->afterbuyString .= "ArtikelMenge_".$nr."=1&";
			$p_count ++;
		}
		// Loworder Übergabe als Produkt
		if ($loworder_flag) 
		{
			$nr ++;
			$this->afterbuyString .= "Artikelnr_".$nr."=99999991&";
			$this->afterbuyString .= "Artikelname_".$nr."=Mindermengenzuschlag&";
			$loworder = $this->get_ot_total_fee($customers_status_show_price_tax, $tax_rate, $xt_currency, $loworder);
	
			$this->afterbuyString .= "ArtikelEPreis_".$nr."=".$loworder."&";
			$this->afterbuyString .= "ArtikelMwst_".$nr."=".$tax."&";
			$this->afterbuyString .= "ArtikelMenge_".$nr."=1&";
			$p_count ++;
		}
		// Nachnamegebuehr Übergabe als Produkt
		if ($cod_flag) {
			$nr ++;
			$this->afterbuyString .= "Artikelnr_".$nr."=99999999&";
			$this->afterbuyString .= "Artikelname_".$nr."=Nachnahme&";
			
			$cod_fee = $this->get_ot_total_fee($customers_status_show_price_tax, $tax_rate, $xt_currency, $cod_fee);
			
			$this->afterbuyString .= "ArtikelEPreis_".$nr."=".$cod_fee."&";
			$this->afterbuyString .= "ArtikelMwst_".$nr."=".$tax."&";
			$this->afterbuyString .= "ArtikelMenge_".$nr."=1&";
			$p_count ++;
		}
		// Rabatt Übergabe als Produkt
		if ($discount_flag) {
			$nr ++;
			$this->afterbuyString .= "Artikelnr_".$nr."=99999998&";
			$this->afterbuyString .= "Artikelname_".$nr."=Rabatt&";
			
			$value_ot_total = $this->get_ot_total_fee($customers_status_show_price_tax, $tax_rate, $xt_currency, $discount);
			
			$this->afterbuyString .= "ArtikelEPreis_".$nr."=".$value_ot_total."&";
			$this->afterbuyString .= "ArtikelMwst_".$nr."=".$tax."&";
			$this->afterbuyString .= "ArtikelMenge_".$nr."=1&";
			$p_count ++;
		}
		// Gutschein Übergabe als Produkt
		if ($gv_flag) {
			$nr ++;
			$this->afterbuyString .= "Artikelnr_".$nr."=99999997&";
			$this->afterbuyString .= "Artikelname_".$nr."=Gutschein&";
			$value_ot_total = $this->get_ot_total_fee($customers_status_show_price_tax, $tax_rate, $xt_currency, (-1)*$gv);
			
			$this->afterbuyString .= "ArtikelEPreis_".$nr."=".$value_ot_total."&";
			$this->afterbuyString .= "ArtikelMwst_".$nr."=".$tax."&";
			$this->afterbuyString .= "ArtikelMenge_".$nr."=1&";
			$p_count ++;
		}
		// Kupon Übergabe als Produkt
		if ($coupon_flag) {
			$nr ++;
			$this->afterbuyString .= "Artikelnr_".$nr."=99999996&";
		    $ab_coupon_title .=  $coupon_title;
		    $this->afterbuyString .= "Artikelname_".$nr."=$ab_coupon_title&";
			
			$value_ot_total = $this->get_ot_total_fee($customers_status_show_price_tax, $tax_rate, $xt_currency, -$coupon);
			
			$this->afterbuyString .= "ArtikelEPreis_".$nr."=".$value_ot_total."&";
			$this->afterbuyString .= "ArtikelMwst_".$nr."=".$tax."&";
			$this->afterbuyString .= "ArtikelMenge_".$nr."=1&";
			$p_count ++;
		}
		//ot_payment Übergabe als Produkt
		if ($ot_payment_flag) {
			$nr++;
			$this->afterbuyString .= "Artikelnr_" . $nr . "=99999995&";
			$this->afterbuyString .= "Artikelname_" . $nr . "=Zahlartenrabatt&";
			$value_ot_total = $this->get_ot_total_fee($customers_status_show_price_tax, $tax_rate, $xt_currency, $ot_payment);
			
			$this->afterbuyString .= "ArtikelEPreis_".$nr."=".$value_ot_total."&";
			$this->afterbuyString .= "ArtikelMwst_" . $nr . "=" . $tax . "&";
			$this->afterbuyString .= "ArtikelMenge_" . $nr . "=1&";
			$p_count++;
		}

		if ($charge_flag) {
			$nr ++;
			$this->afterbuyString .= "Artikelnr_".$nr."=99999995&";
			$this->afterbuyString .= "Artikelname_".$nr."=Zahlartenaufschlag&";
			$charge = $this->change_dec_separator($charge);
			$this->afterbuyString .= "ArtikelEPreis_".$nr."=".$charge."&";
			$this->afterbuyString .= "ArtikelMwst_".$nr."=0&";
			$this->afterbuyString .= "ArtikelMenge_".$nr."=1&";
			$p_count ++;
		}
		//ts_schutz Übergabe als Produkt
		if ($ts_schutz_flag) {
			$nr++;
			$this->afterbuyString .= "Artikelnr_" . $nr . "=99999995&";
			$this->afterbuyString .= "Artikelname_" . $nr . "=".$this->url_encode('Käuferschutz')."&";
			$value_ot_total = $this->get_ot_total_fee($customers_status_show_price_tax, $tax_rate, $xt_currency, $ts_schutz );
			
			$this->afterbuyString .= "ArtikelEPreis_".$nr."=".$value_ot_total."&";
			$this->afterbuyString .= "ArtikelMwst_" . $nr . "=" . $tax . "&";
			$this->afterbuyString .= "ArtikelMenge_" . $nr . "=1&";
			$p_count++;
		}
		
		$this->afterbuyString .= "PosAnz=".$p_count."&";

		// ############# ÜBERGABE BRUTTO/NETTO VERSAND #############
		// mofified FT Kundengruppen müssen jeweilige Zuordnung inkl/excl. Anzeige im Admin XT haben
		if ($order_total_values['class'] == 'ot_shipping')
		$shipping = $order_total_values['value'];
		if ($pDATA['allow_tax']==0) {
				if ($customers_status_show_price_tax == 1)
					$tax_rate=0;
				else				
					$shipping=((($shipping/100)*$tax_rate)+$shipping);
			
		}
		if ((int)$xt_currency > 0)
			$shipping = $shipping * $xt_currency;
		//Währungsprüfung END
		
		$this->afterbuyString .= "Versandkosten=" . $this->change_dec_separator($shipping) . "&";

		//$s_method = explode('_', $oData['shipping_class']);
		$s_method = explode('(', $oData['shipping_method']);
		$s_method = $s_method[0];
		$this->afterbuyString .= "Versandart=".$this->url_encode($s_method)."&";
		//$this->getShipment($s_method[0]);
		$this->afterbuyString .= "kommentar=".$this->url_encode($oData['comments'])."&";
		//$this->afterbuyString .= "Versandart=".$this->url_encode($this->shipment_name)."&";
		$this->afterbuyString .= "NoVersandCalc=".$versandermittlung_ab."&";
        $this->afterbuyString .= "VID=".$this->order_id."&";
		if ($afterbuysperre_bereitsvorhandene_Bestellungen == 1)
			$this->afterbuyString .= "CheckVID=1&";
		
		
		//$this->afterbuyString .= "ZahlartenAufschlag=". $this->change_dec_separator( $zahlartenaufschlag). "&";

		$this->getPayment($oData['payment_method']);
		$this->afterbuyString .= "Zahlart=".$this->url_encode($this->payment_name). "&";
		$this->afterbuyString .= "ZFunktionsID=".$this->payment_id. "&";
		
		/*if ($oData['payment_method'] == 'paypal_gambio' OR $oData['payment_method'] == 'paypa_ipn') {
			$feedbackdatum = '2';
		}*/

		//Übergabe Bankdaten
		if ($oData['payment_method'] == 'banktransfer') 
		{

			if ($_GET['oID']) {
				$b_query = xtc_db_query("SELECT * FROM banktransfer WHERE orders_id='".(int)$_GET['oID']."'");
				$b_data=xtc_db_fetch_array($b_query);
				$this->afterbuyString .= "Bankname=".$this->url_encode($b_data['banktransfer_bankname'])."&";
				$this->afterbuyString .= "BLZ=".$b_data['banktransfer_blz']."&";
				$this->afterbuyString .= "Kontonummer=".$b_data['banktransfer_number']."&";
				$this->afterbuyString .= "Kontoinhaber=".$this->url_encode($b_data['banktransfer_owner'])."&";
			} else {
				$this->afterbuyString .= "Bankname=".$this->url_encode($_POST['banktransfer_bankname'])."&";
				$this->afterbuyString .= "BLZ=".$_POST['banktransfer_blz']."&";
				$this->afterbuyString .= "Kontonummer=".$_POST['banktransfer_number']."&";
				$this->afterbuyString .= "Kontoinhaber=".$this->url_encode($_POST['banktransfer_owner'])."&";
			}	
		}
		
		if ($moneybookers == 1)
		{
			$sql = "SELECT * FROM `payment_moneybookers` WHERE mb_ORDERID = '".$this->order_id."' ORDER BY mb_DATE DESC";
			$mb_query = xtc_db_query($sql);
			if (count($mb_query)) 
			{
				$mb_data = xtc_db_fetch_array($mb_query);
				if ($mb_data['mb_STATUS'] == '2')
			{
					$this->afterbuyString .= "SetPay=1&";
				}
			}
		}
		//
		//$this->afterbuyString .= "MarkierungID=9852&";
		//$this->afterbuyString .= "Bestandart=auktion&"; //shop oder auktion
		$this->afterbuyString .= "Bestandart=shop&";	
		
		if ($oData['payment_method'] == 'masterpayment_credit_card' ||	
			$oData['payment_method'] == 'masterpayment_elv')
		{
			if($masterpayment == 1)
			{
				$sql = "SELECT * FROM orders_status_history  WHERE  orders_id='".$this->order_id."' ORDER BY date_added DESC";
				$masterpay_query = xtc_db_query($sql);
				if (count($masterpay_query)) 
				{
					$masterpay = xtc_db_fetch_array($masterpay_query);
					if ($masterpay['orders_status_id'] == $this->getMasterPaymentSuccessStatusId())
					{
						$this->afterbuyString .= "SetPay=1&";
					}
					//else
					//	return;
				}
			}
		}
		if ($oData['payment_method'] == 'paypal' ||
			$oData['payment_method'] == 'paypal_gambio' ||	
			$oData['payment_method'] == 'paypalde' ||	
			$oData['payment_method'] == 'paypalexpress')
		{
			if($paypalexpress == 1)
			{
				$paypal_sql = "SELECT * FROM ".TABLE_PAYPAL." WHERE xtc_order_id ='".$this->order_id."' ORDER BY payment_date DESC";
				$paypal_query = xtc_db_query($paypal_sql);
				if (count($paypal_query)) 
				{
					$paypal_data = xtc_db_fetch_array($paypal_query);
					if ($paypal_data['payment_status'] == 'Completed')
					{
						$this->afterbuyString .= "SetPay=1&";
					}
					else
					{
						if ($afterbuysperre_unbezahlte_Bestellungen_PayPal == 1)
							return;
					}
				}
			}
		}
		
		if ($this->paid == 1)
			$this->afterbuyString .= "SetPay=1&";
		
		$this->afterbuyString .= "NoFeedback=" . $feedbackdatum . "&";
		if ($SoldCurrency == 1)
			$this->afterbuyString .= "SoldCurrency=".$oData['currency']."&";
		
		if ($this->logging == 1)
		{	
			$current = file_get_contents($this->file);
			$current .= "$this->afterbuyString \n";
			file_put_contents($this->file, $current);
		}
		

	}	
	
	public function sendOrder()
	{
		// connect
		$ch = curl_init();

		// This is the URL that you want PHP to fetch. You can also set this option when initializing a session with the curl_init()  function.
		curl_setopt($ch, CURLOPT_URL, $this->afterbuy_URL);

		// curl_setopt($ch, CURLOPT_CAFILE, 'D:/curl-ca.crt');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//bei einer leeren Transmission Error Mail + cURL Problemen die nächste Zeile auskommentieren
		//curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);

		// Set this option to a non-zero value if you want PHP to do a regular HTTP POST. This POST is a normal application/x-www-form-urlencoded  kind, most commonly used by HTML forms.
		curl_setopt($ch, CURLOPT_POST, 1);
		// #############  CHECK  #############
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->afterbuyString);
		$result = curl_exec($ch);
		
		// close session
		curl_close($ch);
		if ($this->logging == 1)
		{
			$current = file_get_contents($this->file);
			$current .= "$result \n";
			file_put_contents($this->file, $current);
		}	
		if (preg_match("/<success>1<\/success>/", $result)) {
			// result ok, mark order
			// extract ID from result
			$cdr = explode('<KundenNr>', $result);
			$cdr = explode('</KundenNr>', $cdr[1]);
			$cdr = $cdr[0];
			xtc_db_query("update ".TABLE_ORDERS." set afterbuy_success='1',afterbuy_id='".$cdr."' where orders_id='".$this->order_id."'");
			$p = new XMLParser($result);
			$array_complete_parse = $p->getOutput();

			$array_results_parse = $array_complete_parse["result"];
			$ab_aid = $array_results_parse["data"]["AID"];
			$ab_uid = $array_results_parse["data"]["UID"];
			$ab_ui = trim($array_results_parse["data"]["UID"],"{}");
			
			$ab_kundennr = $array_results_parse["data"]["KundenNr"];
			$ab_ekundennr = $array_results_parse["data"]["EKundenNr"];
			$this->afterbuy_aid = $ab_aid;
			//wenn Kundenkommentar
			if ($oData['comments'] != '') {
				$mail_content .= "Name: " .$oData['billing_firstname']." ".$oData['billing_lastname']. "\nEmailadresse: " .$oData['customers_email_address']. "\nKundenkommentar: " .$oData['comments']. "\nBestellnummer: " .$this->order_id.chr(13).chr(10). "\n";
				mail(EMAIL_BILLING_ADDRESS, "Kundenkommentar bei Bestellung", $mail_content);
				//mail(EMAIL_BILLING_ADDRESS, "Kundenkommentar bei Bestellung", $mail_content);
			}
			//set new order status
			if ($order_status != '') {
				xtc_db_query("update ".TABLE_ORDERS." set orders_status='".$order_status."' where orders_id='".$this->order_id."'");
			}
		} else {

			// mail to shopowner
			$mail_content = 'Fehler bei &Uuml;bertragung der Bestellung: '.$this->order_id.chr(13).chr(10).'Folgende Fehlermeldung wurde vom afterbuy.de zur&uuml;ckgegeben:'.chr(13).chr(10).$result;
			mail(EMAIL_BILLING_ADDRESS, "Afterbuy-Fehl&uuml;bertragung", $mail_content);
			//mail("info@pimpmyxtc.de", "Afterbuy-Fehl&uuml;bertragung", $mail_content);
		}
		
	}

	// Funktion zum ueberpruefen ob Bestellung bereits an Afterbuy gesendet.
	function order_send() {
		$check_query = xtc_db_query("SELECT afterbuy_success FROM ".TABLE_ORDERS." WHERE orders_id='".$this->order_id."'");
		$data = xtc_db_fetch_array($check_query);

		if ($sendesperre_bereitsversendet == 1)
		{
			if ($data['afterbuy_success'] == 1)
				return false;
		}
		return true;
	}
	
	function getCurrency($o_currency)
	{
		//Währungsprüfung
		$curreny_query = xtc_db_query("SELECT * FROM " . TABLE_CURRENCIES ." WHERE code = '".$o_currency."' LIMIT 1");
		while ($currency_array = xtc_db_fetch_array($curreny_query)) 
		{
			$xt_currency = $currency_array['value'];
		}
		return $xt_currency;
	}
		
	function getCustomertaxstatus($customers_status)
	{
		//Steuerprüfung
		$cQuery=xtc_db_query("SELECT customers_status_show_price_tax FROM ".TABLE_CUSTOMERS_STATUS." WHERE customers_status_id='".$customers_status."' LIMIT 1");
		$cData=xtc_db_fetch_array($cQuery);
		if ($cData['customers_status_show_price_tax']==1) 
		{
			$customers_status_show_price_tax = 1;
		} 
		else 
		{
			$customers_status_show_price_tax = 2;		
		}
		return $customers_status_show_price_tax;
		
	}
	
	function getShipment($shipment)
	{
		$this->shipment_name = $shipment;
		/*
		switch($shipment) {
			case 'flat':
				$this->shipment_name = "DHL-Paket";	
			break;			
			case 'dp':
				$this->shipment_name = "DHL-Express";	
			break;			
			case 'zones':
				$this->shipment_name = "DHL-AT";	
			break;
			default:
				$this->shipment_name = $shipment;
			break;	
		}*/
	}
	
	public function getPayment($payment)
	{
		switch($payment) {
			case 'banktransfer':
				$this->payment_id = '7';
				$this->payment_name = "Bankeinzug";	
			break;			
			case 'secupay_lastschrift_xtc':
				$this->payment_id = '7';
				$this->payment_name = "Lastschrift Secupay";	
			break;
			case 'cash':
				$this->payment_id = '2';
				$this->payment_name = "Barzahlung";
			break;
			case 'cod':
				$this->payment_id = '4';
				$this->payment_name = "Nachnahme";
			break;
			case 'invoice':
				$this->payment_id = '6';
				$this->payment_name = "Rechnung";
			break;			
			case 'paymorrow_standard':
				$this->payment_id = '6';
				$this->payment_name = "Rechnung paymorrow";
			break;
			case 'moneyorder':
			case 'moneyorderde':
			case 'eustandardtransfer':
				$this->payment_id = '1';
				$this->payment_name = "Überweisung/Vorkasse";
			break;
			case 'moneybookers':
				$this->payment_name = "Moneybookers";
				$this->payment_id = '15';
			break;
			case 'moneybookers_cc':
				$this->payment_name = "Moneybookers CC";
				$this->payment_id = '15';
			break;
			case 'moneybookers_cgb':
				$this->payment_name = "Moneybookers CGB";
				$this->payment_id = '15';
			break;
			case 'moneybookers_csi':
				$this->payment_name = "Moneybookers CSI";
				$this->payment_id = '15';
			break;
			case 'moneybookers_elv':
				$this->payment_name = "Moneybookers ELV";
				$this->payment_id = '15';
			break;
			case 'moneybookers_giropay':
				$this->payment_name = "Moneybookers GIROPAY";
				$this->payment_id = '15';
			break;
			case 'moneybookers_ideal':
				$this->payment_name = "Moneybookers IDEAL";
				$this->payment_id = '15';
			break;
			case 'moneybookers_mae':
				$this->payment_name = "Moneybookers MAE";
				$this->payment_id = '15';
			break;
			case 'moneybookers_netpay':
				$this->payment_name = "Moneybookers NETPAY";
				$this->payment_id = '15';
			break;
			case 'moneybookers_psp':
				$this->payment_name = "Moneybookers PSP";
				$this->payment_id = '15';
			break;
			case 'moneybookers_pwy':
				$this->payment_name = "Moneybookers PWY";
				$this->payment_id = '15';
			break;
			case 'moneybookers_sft':
				$this->payment_name = "Moneybookers SFT";
				$this->payment_id = '15';
			break;
			case 'moneybookers_wlt':
				$this->payment_name = "Moneybookers WLT";
				$this->payment_id = '15';
			break;
			case 'eprompt_dd':
			case 'ipaymentelv':
				$this->payment_name = "Lastschrift";
				$this->payment_id = '7';
			break;			
			case 'eprompt_cc':
				$this->payment_name = "Kreditkarte";
				$this->payment_id = '99';
			break;
			case 'paypal':
			case 'paypalexpress':
			case 'paypal_gambio':
			case 'paypalde':
				$this->payment_id = '5';
				$this->payment_name = "Paypal";
			break;
			case 'paypal_ppp_rechnung':
				case 'paypalplus':
				$this->payment_id = '5';
				$this->payment_name = "Paypal Rechnung";
				$this->paid = 1;
			break;
            case 'sofort_sofortueberweisung':
			case 'sofortueberweisung':
			case 'sofortueberweisungredirect':
			case 'sofortueberweisung_direct':
			case 'sofortueberweisungvorkasse':
			case 'pn_sofortueberweisung':
				$this->payment_id = '12';
				$this->payment_name = "Sofortüberweisung";
				//$this->paid = 1;
			break;
			case 'billsafe_2':
			case 'billsafe':
			case 'pi_billsafe':
				$this->payment_id = '18';
				$this->payment_name = "Rechnungskauf (BillSAFE)";
				$this->paid = 1;
			break;	
			case 'billpay':
			case 'billpaydebit':
				$this->payment_id = '18';
				$this->payment_name = "Billpay";
				$this->paid = 1;
			break;			
			case 'ipayment':
				$this->payment_id = '99';
				$this->payment_name = "IPayment";
			break;			
			case 'cc':
				$this->payment_id = '99';
				$this->payment_name = "Kreditkarte";
			break;			
			case 'sp':
				$this->payment_id = '99';
				$this->payment_name = "Kreditkarte Secupay";
			break;
            case 'masterpayment_credit_card':
                $this->payment_id = '16';
                $this->payment_name = "Masterpayment Kreditkarte";
            break;
            case 'masterpayment_elv':
                $this->payment_id = '17';
                $this->payment_name = "Masterpayment Lastschrift";
            break;
			default:
				$this->payment_id = '99';
				$this->payment_name = "sonstige Zahlungsweise";
		}
	}
	
	function getMasterPaymentSuccessStatusId() {
   		$status_query	= xtc_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where orders_status_name like 'masterpayment successful' group by orders_status_id");
   	    $status_id		= xtc_db_fetch_array($status_query);  	  
   	    return $status_id['orders_status_id'];
   	}
	
	function xtc_get_attributes_ab_productsid($product_id, $attribute_name,$options_name,$language='')
    {
		if ($language=='') $language=$_SESSION['languages_id'];
		$options_value_id_query=xtc_db_query("SELECT
			pa.ab_productsid
			FROM
			".TABLE_PRODUCTS_ATTRIBUTES." pa
			INNER JOIN ".TABLE_PRODUCTS_OPTIONS." po ON po.products_options_id = pa.options_id
			INNER JOIN ".TABLE_PRODUCTS_OPTIONS_VALUES." pov ON pa.options_values_id = pov.products_options_values_id
			WHERE
			po.language_id = '".$language."' AND
			po.products_options_name = '".$options_name."' AND
			pov.language_id = '".$language."' AND
			pov.products_options_values_name = '".$attribute_name."' AND 
			pa.products_id='".$product_id."'");


		$options_attr_data = xtc_db_fetch_array($options_value_id_query);
		return $options_attr_data['ab_productsid'];	
    	
    }
	
	function xtc_get_attributes_products_attributes_id($product_id, $attribute_name,$options_name,$language='')
    {
		if ($language=='') $language=$_SESSION['languages_id'];
		$options_value_id_query=xtc_db_query("SELECT
			pa.products_attributes_id
			FROM
			".TABLE_PRODUCTS_ATTRIBUTES." pa
			INNER JOIN ".TABLE_PRODUCTS_OPTIONS." po ON po.products_options_id = pa.options_id
			INNER JOIN ".TABLE_PRODUCTS_OPTIONS_VALUES." pov ON pa.options_values_id = pov.products_options_values_id
			WHERE
			po.language_id = '".$language."' AND
			po.products_options_name = '".$options_name."' AND
			pov.language_id = '".$language."' AND
			pov.products_options_values_name = '".$attribute_name."' AND 
			pa.products_id='".$product_id."'");


		$options_attr_data = xtc_db_fetch_array($options_value_id_query);
		return $options_attr_data['products_attributes_id'];	
    	
    }
	
	public function get_ot_total_fee($customers_status_show_price_tax, $tax_rate, $xt_currency, $fee)
	{
		//Übergabe Brutto/Netto
		if ($pDATA['allow_tax']==0) 
		{
			if ($customers_status_show_price_tax == 1)
				$tax_rate=0;
			else
				$fee=((($fee/100)*$tax_rate)+$fee);
			
		}
		
		//Währung berücksichtigen
		if ((int)$xt_currency > 0)
			$fee = $fee * $xt_currency;
		
		return $this->change_dec_separator($fee);
		
	}
	
	public function change_dec_separator($value)
	{
		return preg_replace("/\./", ",", $value);
	}

	public function get_afterbuy_aid()
	{
		$aid_query = xtc_db_query("SELECT afterbuy_aid FROM ".TABLE_ORDERS." WHERE orders_id='".$this->order_id."'");
		$data = xtc_db_fetch_array($aid_query);

		return $data['afterbuy_aid'];
	}
	
	public function xtc_get_attributes_model($product_id, $attribute_name,$options_name,$language='2')
    {
		if ($language=='') $language=$_SESSION['languages_id'];
		$options_value_id_query=xtc_db_query("SELECT
			pa.attributes_model
			FROM
			".TABLE_PRODUCTS_ATTRIBUTES." pa
			INNER JOIN ".TABLE_PRODUCTS_OPTIONS." po ON po.products_options_id = pa.options_id
			INNER JOIN ".TABLE_PRODUCTS_OPTIONS_VALUES." pov ON pa.options_values_id = pov.products_options_values_id
			WHERE
			po.language_id = '".$language."' AND
			po.products_options_name = '".trim($options_name)."' AND
			pov.language_id = '".$language."' AND
			pov.products_options_values_name LIKE '%".trim($attribute_name)."%' AND 
			pa.products_id='".$product_id."'");

	// Korrigierte Version aus dem Forum, attributes_model wurde nicht korrekt ermittelt, da
	// in dem SQL die letzte Zeile fehlte.

		$options_attr_data = xtc_db_fetch_array($options_value_id_query);
		return $options_attr_data['attributes_model'];	
    	
    }
}
?>