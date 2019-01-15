<?php
/* -----------------------------------------------------------------------------------------
$Id: dhlgkapi_print_label.php v1.10 02.11.2017 nb $   

Autor: Nico Bauer (c) 2016-2017 Dörfelt GmbH for DHL Paket GmbH

Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html]  
-----------------------------------------------------------------------------------------
Changelog:
1.01    Enable/Force WSDL Caching
1.02    email always included if parcelshop, packstation or postfiliale
1.03    wrong variable used
1.05	enhanced compatibility for modified 1.06
1.06	change order status correctly
1.07    remove php warnings in $dhl_xml object creation
1.08    enhanced compatibility for modified 1.06
1.09    check if shipping class in order has been manipulated by backend
1.10    check if destination country has changed
1.11    corrected cod calculation
1.12    display order backend modify message
-----------------------------------------------------------------------------------------*/

//ini_set('display_errors', '1');
//ini_set('error_reporting', E_ALL);

//Enable WSDL Caching
ini_set('soap.wsdl_cache_enabled', '1'); //NB 1.01
//Set Cache Time to 1 Day 
ini_set('soap.wsdl_cache_ttl', '86400'); //NB 1.01

function output_object($var, $level = 0) { 
    $indent = "      ";
    for ($i = 1; $i <= $level; $i++) {
        $indent .= "      ";
    }

    $return =  "\n";
    foreach($var as $key => $value) {
        if (is_array($value) || is_object($value)) {
            $level++;
            $value = output_object($value, $level);
            $level--;
        }

        if(is_numeric($key)) {
            $key_desc = " - ";
        } else {
            $key_desc = $key . " => "; 
        }

        $return .= $indent . $key_desc . $value . "\n";
    }
    return $return;
}

function find_first_of($haystack, $needlesAsString, $offset=0)
{
    $max = strlen($needlesAsString);
    $index = strlen($haystack)+1;
    for($ii=0; $ii<$max;$ii++){
        $result = strpos($haystack,$needlesAsString[$ii], $offset);
        if( $result !== FALSE  && $result < $index)
            $index = $result;
    }
    return ( $index > strlen($haystack)? FALSE: $index);
}

function soap_request($dhl_xml,$function, $oID = 0, $testmode = false) {

    //Webservice URL
    $dhlwsdlurl='https://cig.dhl.de/cig-wsdls/com/dpdhl/wsdl/geschaeftskundenversand-api/2.0/geschaeftskundenversand-api-2.0.wsdl';
    //$location='https://cig.dhl.de/services/sandbox/soap';
    $location='https://cig.dhl.de/services/production/soap';
    
    //CIG Credentials
    $application_id='dhlgkapi_1';
    $application_token='ok8lCcpVAgpHwME98Gd4TJBnqcwzUc';


    //Optionsarray
    //Optionen für SSL php 5.6
    $ssl_opts = array(
        'ssl' => array('verify_peer'=>false, 'verify_peer_name'=>false)
    );

    $options = array(
        'location' => $location,
        'trace' => 1,
        'soap_version' => SOAP_1_1, 
        'encoding' => 'UTF-8',
        'login' => $application_id,//MODULE_SHIPPING_DHLGKAPI_CIG_LOGIN, //$config_data['CIG_LOGIN'],
        'password' => $application_token, //MODULE_SHIPPING_DHLGKAPI_CIG_PASSWORD, //$config_data['CIG_PASSWORD'],
        'authentication' => SOAP_AUTHENTICATION_BASIC,
        'connection_timeout' => 60,
        'cache_wsdl' => WSDL_CACHE_DISK, //NB 1.01 Cache the WSDL to Disk
        'stream_context' => stream_context_create($ssl_opts)
    );

    $soapClient = new SoapClient($dhlwsdlurl, $options);

    $sh_param = array(
        user => MODULE_SHIPPING_DHLGKAPI_USER, //$config_data['USER'],  
        signature => MODULE_SHIPPING_DHLGKAPI_PASSWORD, //$config_data['PASSWORD'],
        type => '0'
    );

    $headers = new SoapHeader('http://dhl.de/webservice/cisbase','Authentification', $sh_param);

    //SOAPClient
    $soapClient->__setSoapHeaders(array($headers));

    //SOAP Anfrage
    try {
        $result = $soapClient->{$function}($dhl_xml);

        //Fehlermeldung prüfen
        if (isset($result->CreationState->LabelData->Status)) {
            $status=$result->CreationState->LabelData->Status;
        } else {                                                                                          
            $status=$result->Status;
        }

        //Fehlerausgabe zusammenstellen
        if ($status->statusCode != '0'){
            $errormsg=urlencode(output_object($status));
            if (!$testmode) xtc_redirect(xtc_href_link('dhlgkapi_print_label.php', 'oID='.$oID.'&error='.$errormsg.'&function='.$function));
        }

    } catch (SoapFault $fault) {
        //Fehlermeldung schon bei der SOAP-Anfrage
        $debugxml=$soapClient->__getLastRequest();
        $errormsg=urlencode(print_r($fault->faultcode.': '.$fault->faultstring,true));
        if (!$testmode) xtc_redirect(xtc_href_link('dhlgkapi_print_label.php', 'oID='.$oID.'&error='.$errormsg.'&function='.$function));
    }
    unset($soapClient);

    return $result;
}

//Dateien einlesen
require ('includes/application_top.php');
require(DIR_FS_INC . 'xtc_get_attributes_model.inc.php');
require_once (DIR_WS_CLASSES.'order.php');
require_once (DIR_FS_CATALOG.DIR_WS_CLASSES.'xtcPrice.php');
if (!file_exists(DIR_FS_EXTERNAL.'phpmailer/PHPMailerAutoload.php')) require_once (DIR_FS_CATALOG.DIR_WS_CLASSES.'class.phpmailer.php'); //NB 1.05
require_once (DIR_FS_INC.'xtc_php_mail.inc.php');
require_once (DIR_FS_INC.'get_tracking_link.inc.php');

//OrderID
$oID = xtc_db_prepare_input($_GET['oID']);

//keine OrderID vorhanden
if (($oID=='') && (!isset($_GET['error']))) {
    include (DIR_FS_LANGUAGES . $_SESSION['language'].'/modules/shipping/dhlgkapi.php');
    $errormsg=urlencode(MODULE_SHIPPING_DHLGKAPI_ORDERERROR);
    xtc_redirect(xtc_href_link('dhlgkapi_print_label.php', 'oID='.$oID.'&error='.$errormsg));
}

/*
//Konfiguration ermitteln
$config_query = xtc_db_query("select configuration_key, configuration_value from configuration where configuration_key like 'MODULE_SHIPPING_DHLGKAPI%' ORDER BY configuration_key");
while($config_value = xtc_db_fetch_array($config_query)) {
$config_data[str_replace('MODULE_SHIPPING_DHLGKAPI_','',$config_value['configuration_key'])] = $config_value['configuration_value'];
}
*/

if (isset($_GET['testlabel'])) {
    //dummy order erstellen
    $dhl_weight = '1.0';
    $cod_amount = '0.0';
    $order_data['language'] = 'german';
    $order_data['shipping_class'] = 'dhlgkapi_V01PAK';
    $order_data['delivery_company'] = 'DHL Paket GmbH';
    $order_data['delivery_street_address'] = 'Sträßchensweg 10';
    $order_data['delivery_postcode']='53113';
    $order_data['delivery_city']='Bonn';
    $order_data['delivery_country_iso_code_2']='DE';
    $order_data['customers_email_address']='no-reply@deutschepost.de';

} else {
    //Order einlesen
    $order_data_query = xtc_db_query("select * from ".TABLE_ORDERS." where orders_id = '".xtc_db_input($oID)."'");
    $order_data = xtc_db_fetch_array($order_data_query);

    //Wunschpaket Services
    $wunschpaket_services=array(
        'PD' => 'PreferredDay',
        'PT' => 'PreferredTime',
        'PN' => 'PreferredNeighbour',
        'PL' => 'PreferredLocation'
    );
    preg_match('/\[(.*?)\]/',$order_data['shipping_method'],$wunschpaket_array);
    $wunschpaket=array();
    if (!empty($wunschpaket_array)) {
        foreach(explode('~',$wunschpaket_array[1]) as $wunsch) {
            $wunsch_array=explode(':', $wunsch);
            $wunschpaket[$wunsch_array['0']]=$wunsch_array[1];  
        }
    }

    //Gewichtsberechnung
    //Startgewicht = Versandkartongewicht
    $dhl_weight = SHIPPING_BOX_WEIGHT;
    $weight_query = xtc_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '".$oID."'");
    while ($weight_product = xtc_db_fetch_array($weight_query))
    {
        //Basisgewicht ermitteln
        $basic_weight_query = xtc_db_query("select products_weight from " . TABLE_PRODUCTS . " where products_id = '".$weight_product['products_id']."'");
        $basic_weight = xtc_db_fetch_array($basic_weight_query);
        if ($basic_weight['products_weight'] != 0)
        {
            $dhl_weight += ($basic_weight['products_weight'] * $weight_product['products_quantity']);
        } else
        {
            $dhl_weight += 0; //Gewicht addieren, wenn kein Gewicht angegeben
        }
        //language-id ermitteln
        $weight_language_query = xtc_db_query("select languages_id from ". TABLE_LANGUAGES ." where directory = '".$order_data['language']."'");
        $weight_language_id = xtc_db_fetch_array($weight_language_query);
        $weight_language_id = $weight_language_id['languages_id'];
        //attribute checken
        $weight_attributes_query = xtc_db_query("select * from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '".$oID."' and orders_products_id = '".$weight_product['orders_products_id']."'");
        while ($weight_attribute = xtc_db_fetch_array($weight_attributes_query))
        {
            //Attribute aus Bestellung ermitteln
            $weight_model = xtc_get_attributes_model($weight_product['products_id'], $weight_attribute['products_options_values'], $weight_attribute['products_options'], $weight_language_id);
            if ($weight_model != '')
            {
                $weight_attribute_weight_query = xtc_db_query("select options_values_weight, weight_prefix from ".TABLE_PRODUCTS_ATTRIBUTES." where attributes_model = '".$weight_model."'");
                $weight_attribute_weight = xtc_db_fetch_array($weight_attribute_weight_query);
                if ($weight_attribute_weight['weight_prefix'] == '-')
                {
                    $dhl_weight -= ($weight_attribute_weight['options_values_weight'] * $weight_product['products_quantity']);
                } else
                {
                    $dhl_weight += ($weight_attribute_weight['options_values_weight'] * $weight_product['products_quantity']);
                }
            }
        }
    }

    //Nachnahmebetrag
    $cod_amount_query=xtc_db_query("select value from ".TABLE_ORDERS_TOTAL." where orders_id='".$oID."' order by sort_order desc");
    $cod_amount_array=xtc_db_fetch_array($cod_amount_query);
    $cod_amount=$cod_amount_array['value'];                                                                                                                            

    $cod_fee=preg_replace('/[^0-9.,]/','',MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE);  
    $cod_fee=str_replace(',','.',$cod_fee);

    if (isset($_GET['CODAmount'])) {
        $cod_amount=preg_replace('/[^0-9.,]/','',$_GET['CODAmount']);
        $cod_amount=str_replace(',','.',$cod_amount); 
        $cod_amount -= $cod_fee; //NB 1.11 corrected cod calculation
    }

    $cod_amount=number_format($cod_amount + $cod_fee,'2','.','');
}

//Sprache
require (DIR_FS_LANGUAGES . $order_data['language'].'/modules/shipping/dhlgkapi.php');

//Angezeigte Services
$display_services=unserialize(MODULE_SHIPPING_DHLGKAPI_DISPLAY_SERVICES);

//Produkt/Service Matrix
$valid_services=unserialize(MODULE_SHIPPING_DHLGKAPI_VALID_SERVICES);

//Versandart ermitteln
$shipping_class_array=explode('_',$order_data['shipping_class']);
$shipping_method_array=explode('|',$shipping_class_array[1]);
$dhl_type=$shipping_method_array[0];
$dhl_type_addon=$shipping_method_array[1];
$dhl_product=preg_replace("/\([\w]*\)/","",$dhl_type);
$product_code=substr(preg_replace("/[^0-9]/","",$dhl_product),0,2);

//NB 1.09 check, ob Order im Backend verändert wurde: versuchen Versandart heraussuchen...
$output_msg = '';
if ((is_array($shipping_class_array) && $shipping_class_array[1] == 'dhlgkapi') || (($order_data['date_purchased'] !=  $order_data['last_modified']) && $order_data['last_modified'] != '')) {
    require ('../includes/modules/shipping/dhlgkapi.php');

    $order = new order($oID);

    $country_query = xtc_db_query("select countries_iso_code_2 from " . TABLE_COUNTRIES . " where countries_name = '" . $order->delivery['country'] . "'");
    $country = xtc_db_fetch_array($country_query);

    $order->delivery['country']=array();
    $order->delivery['country']['iso_code_2'] = $country['countries_iso_code_2'];

    $dhlgkapi = new dhlgkapi;

    $quote = $dhlgkapi->quote();

    $dhl_type_new = $quote['methods']['0']['id'];
    $dhl_product_new = preg_replace("/\([\w]*\)/","",$dhl_type_new);
    $product_code_new = substr(preg_replace("/[^0-9]/","",$dhl_product_new),0,2);

    //NB 1.10 feststellen, ob Land geändert wurde
    if ($dhl_type_new != $dhl_type) {

        $dhl_type = $dhl_type_new;
        $dhl_product = $dhl_product_new;
        $product_code = $product_code_new;

        //DHL Produkt Info in DB zurückschreiben
        $shipping_class = 'dhlgkapi_'.$dhl_type;
        xtc_db_query("UPDATE ".TABLE_ORDERS." SET shipping_class='".xtc_db_prepare_input($shipping_class)."' WHERE orders_id='".$oID."'");
        //NB 1.12 display order backend modify message
        $output_msg = MODULE_SHIPPING_DHLGKAPI_BACKEND_MODIFIED.$dhl_type;   
    }
}

//Versanddatum = Heute                                     
$shipmentdate=date('Y-m-d');                               

//Gewicht per Formular eingegeben    
if (isset($_GET['WeightInKG'])) {
    $dhl_weight=preg_replace('/[^0-9.,]/','',$_GET['WeightInKG'.strval($i)]);
    $dhl_weight=str_replace(',','.',$dhl_weight);
}

//Formatierung des Gewichtes
$dhl_weight=number_format($dhl_weight, 2,'.','');

//StraßŸenname und Hausnummer trennen
$receiver_street_raw = str_replace('.', '. ',trim(substr($order_data['delivery_street_address'],0,40)));
$look_for="0123456789";
$nrpos = find_first_of($receiver_street_raw,$look_for,0);

//neue Hausnummernermittlung
if (preg_match("/[0-9\,]+[a-zA-Z]*[-,\/]*[0-9]*[a-zA-Z]*/", $receiver_street_raw, $matches)) {
    $receiver_streetnumber=$matches[0];
    $receiver_streetname=trim(str_replace($receiver_streetnumber,'', $receiver_street_raw));
    $receiver_streetnumber=trim($receiver_streetnumber,'.-, ');
}
else {  
    //alte Variante als Fallback
    $receiver_streetname = trim(substr($receiver_street_raw, 0, $nrpos));
    $receiver_streetnumber = trim(substr($receiver_street_raw, $nrpos));   
}

//XML Bilden
//Basisgerüst für die Anfrage erstellen
$dhl_xml = new stdClass();
$dhl_xml->Version = new stdClass();
$dhl_xml->Version->majorRelease=2;
$dhl_xml->Version->minorRelease=0;
$dhl_xml->ShipmentOrder = new stdClass();
$dhl_xml->ShipmentOrder->sequenceNumber=1;

//Produkt eintragen
$dhl_xml->ShipmentOrder->Shipment = new stdClass();
$dhl_xml->ShipmentOrder->Shipment->ShipmentDetails = new stdClass();
$dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->product=$dhl_product;

//Accountnummer (14stellig: EKP+Verfahren+Teilnahme)
$dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->accountNumber=MODULE_SHIPPING_DHLGKAPI_EKP.$product_code.constant('MODULE_SHIPPING_DHLGKAPI_'.$dhl_type.'_ATTENDANCE'); //NB 1.03

//Sendungsreferenz
$dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->customerReference=$oID;

//Versanddatum
$dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->shipmentDate=$shipmentdate;

//Gewicht
$dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->ShipmentItem = new stdClass();
$dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->ShipmentItem->weightInKG=$dhl_weight;

//Services buchen (wenn verfügbar)

//Services aktivieren
$dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service = new stdClass(); 
foreach($display_services as $service) {
    if (isset($_GET[$service])){
        
        if($service!='PrintOnlyIfCodeable' && $service!='Return') $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service->{$service}['active']='1';

        switch($service) {
            case 'PrintOnlyIfCodeable':  //Nur Label, wenn leitcodierbar
                $dhl_xml->ShipmentOrder->PrintOnlyIfCodeable['active']=isset($_GET['PrintOnlyIfCodeable'])?'1':'0';
                break;

            case 'AdditionalInsurance': //Transportversicherung
                if (isset($_GET['insuranceAmount']) && $_GET['insuranceAmount']!='' && $_GET['insuranceAmount'] > 0){
                    $insuranceAmount=preg_replace('/[^0-9.,]/','',$_GET['insuranceAmount']);
                    $insuranceAmount=str_replace(',','.',$insuranceAmount);
                    $insuranceAmount=number_format($insuranceAmount,'2','.','');
                    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service->{$service}['insuranceAmount']=$insuranceAmount;
                } else {
                    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service->{$service}['active']='0';
                }
                break;

            case 'CashOnDelivery': //Nachnahme
                if ($cod_amount > 0) {
                    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service->CashOnDelivery['codAmount']=$cod_amount;
                    //Bankdaten
                    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->BankData = new stdClass();
                    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->BankData->accountOwner=MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER;
                    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->BankData->bankName=MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME;
                    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->BankData->iban=MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN;
                    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->BankData->bic=MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC; 
                } else {
                    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service->{$service}['active']='0'; 
                }
                break;

            case 'VisualCheckOfAge':
                if (isset($_GET['VisualCheckOfAgeType']) && $_GET['VisualCheckOfAgeType']!='') {
                    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service->{$service}['type']=$_GET['VisualCheckOfAgeType'];
                } else {
                    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service->{$service}['active']='0'; 
                }
        } 
    } 
}

//Wunschpaket Services aktivieren
foreach($wunschpaket_services as $id => $service) {
    if (isset($_GET[$service]) && $_GET[$service]!='' ) {
        $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service->{$service}['active']='1';
        if ($id=='PT') {
           $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service->{$service}['type']=$_GET[$service]; 
        } else {
           $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service->{$service}['details']=$_GET[$service]; 
        }
    }
}

//Versandnachricht durch DHL
if (MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED=='True') {
    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Notification = new stdClass();
    $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Notification->recipientEmailAddress=$order_data['customers_email_address'];
}

//Absenderadresse
$dhl_xml->ShipmentOrder->Shipment->Shipper = new stdClass();
$dhl_xml->ShipmentOrder->Shipment->Shipper->Name = new stdClass();
$dhl_xml->ShipmentOrder->Shipment->Shipper->Name->name1=MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME;
$dhl_xml->ShipmentOrder->Shipment->Shipper->Address = new stdClass();
$dhl_xml->ShipmentOrder->Shipment->Shipper->Address->streetName=MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME;
$dhl_xml->ShipmentOrder->Shipment->Shipper->Address->streetNumber=MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER;
$dhl_xml->ShipmentOrder->Shipment->Shipper->Address->zip=MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP;
$dhl_xml->ShipmentOrder->Shipment->Shipper->Address->city=MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY;
$dhl_xml->ShipmentOrder->Shipment->Shipper->Address->Origin = new stdClass();
$dhl_xml->ShipmentOrder->Shipment->Shipper->Address->Origin->countryISOCode=MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY;
$dhl_xml->ShipmentOrder->Shipment->Shipper->Communication = new stdClass();
$dhl_xml->ShipmentOrder->Shipment->Shipper->Communication->phone=MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE;
$dhl_xml->ShipmentOrder->Shipment->Shipper->Communication->contactPerson=MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON;


//Empfängeradresse

//Hausadresse
//Firma?
$dhl_xml->ShipmentOrder->Shipment->Receiver = new stdClass(); 
if ($order_data['delivery_company']!='') {
    $dhl_xml->ShipmentOrder->Shipment->Receiver->name1=$order_data['delivery_company'];
    $dhl_xml->ShipmentOrder->Shipment->Receiver->Communication = new stdClass();
    $dhl_xml->ShipmentOrder->Shipment->Receiver->Communication->contactPerson=$order_data['delivery_firstname'].' '.$order_data['delivery_lastname'];
} else {
    $dhl_xml->ShipmentOrder->Shipment->Receiver->name1=$order_data['delivery_firstname'].' '.$order_data['delivery_lastname']; 
}
$dhl_xml->ShipmentOrder->Shipment->Receiver->Address = new stdClass();
$dhl_xml->ShipmentOrder->Shipment->Receiver->Address->addressAddition=$order_data['delivery_suburb'];
$dhl_xml->ShipmentOrder->Shipment->Receiver->Address->streetName=$receiver_streetname;
$dhl_xml->ShipmentOrder->Shipment->Receiver->Address->streetNumber=$receiver_streetnumber;
$dhl_xml->ShipmentOrder->Shipment->Receiver->Address->zip=$order_data['delivery_postcode'];
$dhl_xml->ShipmentOrder->Shipment->Receiver->Address->city=$order_data['delivery_city'];
$dhl_xml->ShipmentOrder->Shipment->Receiver->Address->Origin = new stdClass();
$dhl_xml->ShipmentOrder->Shipment->Receiver->Address->Origin->countryISOCode=$order_data['delivery_country_iso_code_2'];

$name_raw=$order_data['delivery_company']."\n";
$name_raw.=$order_data['delivery_firstname'].' '.$order_data['delivery_lastname']."\n";
$address_raw=$order_data['delivery_suburb']."\n";
$address_raw.=$receiver_streetname.' '.$receiver_streetnumber."\n";
$address_raw.=$order_data['delivery_postcode'].' '.$order_data['delivery_city']."\n";
$address_raw.=$order_data['delivery_country_iso_code_2'];

//Postnummer vorhanden?
if (preg_match("/[0-9]{6}/", $order_data['delivery_suburb'])) {
    //Packstation
    if (preg_match("/Packstation/i", $order_data['delivery_street_address'])) {
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Packstation = new stdClass();
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Packstation->packstationNumber=preg_replace('/[^0-9]/','',$order_data['delivery_street_address']);
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Packstation->postNumber=preg_replace('/[^0-9]/','',$order_data['delivery_suburb']);
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Packstation->zip=$order_data['delivery_postcode'];
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Packstation->city=$order_data['delivery_city'];
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Packstation->Origin = new stdClass();
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Packstation->Origin->countryISOCode=$order_data['delivery_country_iso_code_2'];
       //NB 2.05 if (!isset($dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Notification)) $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Notification = new stdClass();
        //NB 2.05 $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Notification->recipientEmailAddress=$order_data['customers_email_address']; //NB 1.02
        
        unset($dhl_xml->ShipmentOrder->Shipment->Receiver->Address);
    }
    //Postfiliale
    
    if (preg_match("/Postfiliale/i", $order_data['delivery_street_address'])) {
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Postfiliale = new stdClass();
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Postfiliale->postfilialNumber=preg_replace('/[^0-9]/','',$order_data['delivery_street_address']);
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Postfiliale->postNumber=preg_replace('/[^0-9]/','',$order_data['delivery_suburb']);
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Postfiliale->zip=$order_data['delivery_postcode'];
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Postfiliale->city=$order_data['delivery_city'];
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Postfiliale->Origin = new stdClass();
        $dhl_xml->ShipmentOrder->Shipment->Receiver->Postfiliale->Origin->countryISOCode=$order_data['delivery_country_iso_code_2'];
       //NB 2.05 if (!isset($dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Notification)) $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Notification = new stdClass();
        //NB 2.05 $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Notification->recipientEmailAddress=$order_data['customers_email_address']; //NB 1.02
        
        unset($dhl_xml->ShipmentOrder->Shipment->Receiver->Address);
    }
}

//Parcelshop
if (preg_match("/Paketshop|Parcelshop/i", $order_data['delivery_street_address'])) {
    $dhl_xml->ShipmentOrder->Shipment->Receiver->ParcelShop = new stdClass();
    $dhl_xml->ShipmentOrder->Shipment->Receiver->ParcelShop->parcelShopNumber=preg_replace('/[^0-9]/','',$order_data['delivery_suburb']);;
    $dhl_xml->ShipmentOrder->Shipment->Receiver->ParcelShop->streetName=$receiver_streetname;
    $dhl_xml->ShipmentOrder->Shipment->Receiver->ParcelShop->streetNumber=$receiver_streetnumber;
    $dhl_xml->ShipmentOrder->Shipment->Receiver->ParcelShop->zip=$order_data['delivery_postcode'];
    $dhl_xml->ShipmentOrder->Shipment->Receiver->ParcelShop->city=$order_data['delivery_city'];
    $dhl_xml->ShipmentOrder->Shipment->Receiver->ParcelShop->Origin = new stdClass();
    $dhl_xml->ShipmentOrder->Shipment->Receiver->ParcelShop->Origin->countryISOCode=$order_data['delivery_country_iso_code_2'];
   //NB 2.05 if (!isset($dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Notification)) $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Notification = new stdClass();
		//NB 2.05 $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Notification->recipientEmailAddress=$order_data['customers_email_address']; //NB 1.02
     
    unset($dhl_xml->ShipmentOrder->Shipment->Receiver->Address);
}

//Kommunikationsoptionen
		if (!isset($dhl_xml->ShipmentOrder->Shipment->Receiver->Communication)) $dhl_xml->ShipmentOrder->Shipment->Receiver->Communication = new stdClass();
		//NB 2.05 $dhl_xml->ShipmentOrder->Shipment->Receiver->Communication->phone=$order_data['customers_telephone'];
		$dhl_xml->ShipmentOrder->Shipment->Receiver->Communication->contactPerson = $order_data['delivery_firstname'].' '.$order_data['delivery_lastname']; //NB 2.05

//Retourelabel
if (MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED=='True' && isset($_GET['Return'])) {
    if (constant('MODULE_SHIPPING_DHLGKAPI_'.$dhl_type.'_RETOURE_ATTENDANCE')!='0') {
        $retoure_products=unserialize(MODULE_SHIPPING_DHLGKAPI_RETOURE_PRODUCTS);
        $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->returnShipmentAccountNumber=MODULE_SHIPPING_DHLGKAPI_EKP.$retoure_products[$dhl_type].constant('MODULE_SHIPPING_DHLGKAPI_'.$dhl_type.'_RETOURE_ATTENDANCE');
        $dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->returnShipmentReference=$oID;
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver = new stdClass();
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Name = new stdClass();
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Name->name1=MODULE_SHIPPING_DHLGKAPI_RETURN_NAME;
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Address = new stdClass();
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Address->streetName=MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME;
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Address->streetNumber=MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER;
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Address->zip=MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP;
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Address->city=MODULE_SHIPPING_DHLGKAPI_RETURN_CITY;
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Address->Origin = new stdClass();
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Address->Origin->countryISOCode=MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY;

        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Communication = new stdClass();
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Communication->phone=MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE;
        $dhl_xml->ShipmentOrder->Shipment->ReturnReceiver->Communication->contactPerson=MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON;
    }  
} else {
    unset($dhl_xml->ShipmentOrder->Shipment->ReturnReceiver);
}

//Zolldaten
if (!in_array($order_data['delivery_country_iso_code_2'],explode(',',MODULE_SHIPPING_DHLGKAPI_EU_COUNTRIES))) {
    $dhl_xml->ShipmentOrder->Shipment->ExportDocument=(object) array(
        'invoiceNumber' => $_GET['invoiceNumber'],
        'exportType' => 'OTHER',
        'exportTypeDescription' => 'Permanent',
        'termsOfTrade' => $_GET['termsOfTrade'],
        'placeOfCommital' => MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY,
        'additionalFee' => str_replace(',','.',$_GET['additionalFee'])
    );

    $dhl_xml->ShipmentOrder->Shipment->ExportDocument->ExportDocPosition=(object) array(
        'description' => 'ExportPositionOne',
        'countryCodeOrigin' => MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY,
        'customsTariffNumber' => $_GET['customsTariffNumber'],
        'amount' => '1',
        'netWeightInKG' => str_replace(',','.',$_GET['netWeightInKG']),
        'customsValue' => str_replace(',','.',$_GET['customsValue'])
    );
}

//Label anfordern / stornieren
if ((isset($_GET['getlabel']) || isset($_GET['stornolabel']) || isset($_GET['testlabel'])) && !isset($_GET['error'])) {

    //Testmode
    if (isset($_GET['testlabel'])) {
        $function='createShipmentOrder';

        $result=soap_request($dhl_xml, $function, $oID , true);
?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
        <html>
            <head>
                <title>DHLGKAPI Test</title>
                <style>
                    div {
                        font-family: Verdana, Arial, sans-serif; 
                        font-size: large;
                        font-weight: bold; 
                        padding: 10px; 
                        border: 1px solid black;
                        color: black;
                    }
                    .red {
                        background-color: LightPink;
                    }

                    .green {
                        background-color: LightGreen; 
                    }
                </style>
            </head>
            <body>

                <?php
                if (isset($result) && $result->Status->statusCode=='0') {
                    //Label erhalten -> wieder löschen...
                    //Request bilden
                    unset($dhl_xml->ShipmentOrder);
                    $dhl_xml->shipmentNumber=$result->CreationState->LabelData->shipmentNumber;

                    $function='deleteShipmentOrder';
                    $result=soap_request($dhl_xml, $function, $oID, true);
                ?>
                    <div class="green"><?php echo MODULE_SHIPPING_DHLGKAPI_TEST_OKAY; ?></div>
                    <?php
                } else {
                    ?>
                    <div class="red"><?php echo MODULE_SHIPPING_DHLGKAPI_TEST_NOT_OKAY; ?></div>
                <?php 
                }

                ?>



                <br />
                <br />
                <input type=button onClick="window.open('', '_self', ''); window.close();" value="schließen">
            </body>
        </html>
<?php
        die;
    }


    //SOAP Aktion festlegen
    if (isset($_GET['getlabel'])) {
        $function='createShipmentOrder';

        //Anfrage durchführen
        $result=soap_request($dhl_xml, $function, $oID);

        //Versandinformationen in Datenbank schreibem
        $carrier_query=xtc_db_query("SELECT carrier_id FROM ".TABLE_CARRIERS." WHERE carrier_name='DHL' LIMIT 1");

        if ($carrier=xtc_db_fetch_array($carrier_query)) {                        
            $carrier_id = $carrier[carrier_id];
            $parcel_id = xtc_db_prepare_input($result->CreationState->LabelData->shipmentNumber);
            $sql_data_array = array('ortra_order_id' => $oID,
                'ortra_carrier_id' => $carrier_id,
                'ortra_parcel_id' => $parcel_id);
            xtc_db_perform(TABLE_ORDERS_TRACKING,$sql_data_array);
            $tracking_id = xtc_db_insert_id();
        }

        $status = (int)MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED;
        $comments = xtc_db_prepare_input(MODULE_SHIPPING_DHLGKAPI_EMAILTEXT);
    }

    //Label stornieren
    if (isset($_GET['stornolabel'])) {
        //Sendungsnummer ermktteln
        $function='deleteShipmentOrder';
        if (isset($_GET['tracking_id']) && $_GET['tracking_id']!='') {
            $shipment_number=$_GET['tracking_id'];

            //Request bilden
            unset($dhl_xml->ShipmentOrder);
            $dhl_xml->shipmentNumber=$shipment_number;        
        } else {
            $errormsg=urlencode(MODULE_SHIPPING_DHLGKAPI_TRACKINGID_ERROR);
            xtc_redirect(xtc_href_link('dhlgkapi_print_label.php', 'oID='.$oID.'&error='.$errormsg.'&function='.$function));
        }

        //Anfrage durchführen
        $result=soap_request($dhl_xml, $function, $oID);    

        $status = (int)MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED;
        $comments = xtc_db_prepare_input(MODULE_SHIPPING_DHLGKAPI_CANCELTEXT);

        xtc_db_query("DELETE FROM ".TABLE_ORDERS_TRACKING." WHERE ortra_parcel_id=".xtc_db_prepare_input($shipment_number));
    }


    //Kommentar und Orderstatus festlegen
    $customer_notified = 0;

    //Email Versand, wenn erlaubt
    if (MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED=='True') {
        //Order History aktualidieren und Email an Kunden versenden...

        $smarty=new Smarty();

        $order=new order($oID);

        $xtPrice = new xtcPrice($order->info['currency'], $order->info['status']);

        if (isset($order) && is_object($order)) {
            $lang_query = xtc_db_query("SELECT languages_id, 
                language_charset
                code,
                image
                FROM " . TABLE_LANGUAGES . "
                WHERE directory = '" . $order->info['language'] . "'");
            $lang_array = xtc_db_fetch_array($lang_query);
            $lang = $lang_array['languages_id'];
            $lang_code = $lang_array['code'];
            $lang_charset = $lang_array['language_charset'];
        }

        $orders_status_array = array();
        $orders_status_query = xtc_db_query("SELECT orders_status_id,
            orders_status_name
            FROM ".TABLE_ORDERS_STATUS."
            WHERE language_id = '".$lang."'
        ORDER BY orders_status_id"); //NB 1.05
        while ($orders_status = xtc_db_fetch_array($orders_status_query)) {
            $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
        }

        $notify_comments = $comments;        
        //fallback gender modified < 2.00
        if (!isset($order->customer['gender']) || empty($order->customer['gender'])) {
            $gender_query = xtc_db_query("SELECT customers_gender
                FROM " . TABLE_CUSTOMERS . "
                WHERE customers_id = '" .$order->customer['id']. "'");
            $gender_array = xtc_db_fetch_array($gender_query);
            $order->customer['gender'] = $gender_array['customers_gender'];
        } 
        if ($order->customer['gender'] == 'f') {
            $smarty->assign('GENDER', FEMALE);
        } elseif ($order->customer['gender'] == 'm') {
            $smarty->assign('GENDER', MALE);
        } else {
            $smarty->assign('GENDER', '');
        }
        $smarty->assign('LASTNAME',$order->customer['lastname'] != '' ? $order->customer['lastname'] : $order->customer['name']);

        $smarty->assign('order', $order);
        $smarty->assign('order_data', $order->getOrderData($oID));

        $smarty->assign('tpl_path',DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE.'/');
        $smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
        $smarty->assign('NAME', $order->customer['name']);
        $smarty->assign('ORDER_NR', $order->info['order_id']);
        $smarty->assign('ORDER_ID', $oID);
        //send no order link to customers with guest account
        if ($order->customer['status'] != DEFAULT_CUSTOMERS_STATUS_ID_GUEST) {
            $smarty->assign('ORDER_LINK', xtc_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id='.$oID, 'SSL'));
        }
        // track & trace
        $tracking_array = get_tracking_link($oID, null, array($tracking_id));
        $smarty->assign('PARCEL_COUNT', count($tracking_array));
        $smarty->assign('PARCEL_ARRAY', $tracking_array);                                    

        $smarty->assign('ORDER_DATE', xtc_date_long($order->info['date_purchased']));
        $smarty->assign('NOTIFY_COMMENTS', nl2br($notify_comments));
        $smarty->assign('ORDER_STATUS', $orders_status_array[$status]);

        // assign language
        $smarty->assign('language', $order->info['language']);

        // set dirs manual
        $smarty->caching = false;
        $smarty->template_dir = DIR_FS_CATALOG.'templates';
        $smarty->compile_dir = DIR_FS_CATALOG.'templates_c';
        $smarty->config_dir = DIR_FS_CATALOG.'lang';

        $html_mail = $smarty->fetch('db:change_order_mail.html');
        $txt_mail = $smarty->fetch('db:change_order_mail.txt');
        $smarty->assign('nr', $oID);
        $smarty->assign('date', strftime(DATE_FORMAT_LONG));
        $smarty->assign('lastname', $order->customer['lastname']);
        $smarty->assign('firstname',$order->customer['firstname']);
        $order_subject = $smarty->fetch('db:change_order_mail.subject');

        xtc_php_mail(EMAIL_BILLING_ADDRESS,
            EMAIL_BILLING_NAME,
            $order->customer['email_address'],
            $order->customer['name'],
            '',
            EMAIL_BILLING_REPLY_ADDRESS,
            EMAIL_BILLING_REPLY_ADDRESS_NAME,
            '',
            '',
            $order_subject,
            $html_mail,
            $txt_mail
        );

        //send copy to admin
        if (defined('STATUS_EMAIL_SENT_COPY_TO_ADMIN') && STATUS_EMAIL_SENT_COPY_TO_ADMIN == 'true') {
            xtc_php_mail(EMAIL_BILLING_ADDRESS,
                EMAIL_BILLING_NAME,
                EMAIL_BILLING_ADDRESS,
                STORE_NAME,
                EMAIL_BILLING_FORWARDING_STRING,
                $order->customer['email_address'],
                $order->customer['name'],
                '',
                '',
                $order_subject,
                $html_mail,
                $txt_mail
            );
        }

        $customer_notified = 1;
    }


    //Orderhistory schreiben
    $sql_data_array = array('orders_id' => $oID,
        'orders_status_id' => $status,
        'date_added' => 'now()',
        'customer_notified' => $customer_notified,
        'comments' => $comments,
        'comments_sent' => 1
    );
    xtc_db_perform(TABLE_ORDERS_STATUS_HISTORY,$sql_data_array);
	
	//1.06 Orderstatus ändern
    xtc_db_query("update " . TABLE_ORDERS . " set orders_status = '".$status."' where orders_id = '".$oID."'");

    if (isset($_GET['stornolabel'])) xtc_redirect(xtc_href_link(FILENAME_ORDERS, 'oID='.$oID.'&action=edit'));

    //Label anzeigen und zurück zur Order
    echo "<html>";
    echo "  <head>";
    echo "      <title>DHLGKAPI</title>";
    echo "  </head>";
    echo "  <body>";
    echo "      <script language=\"javascript\">\n";
    echo "          window.open(\"".$result->CreationState->LabelData->labelUrl."\",\"DHLGKAPI\",\"height=600,width=640,resizable=1\");\n";
    echo "          location.replace('".xtc_href_link(FILENAME_ORDERS, 'oID='.$oID.'&action=edit')."')";
    echo "      </script>\n";
    echo "  </body>";
    echo "</html>";
    die;
}


require (DIR_WS_INCLUDES.'head.php');
?>
</head>
<body style="background-color: #FFFFFF;">
    <!-- header //-->
    <?php

    require (DIR_WS_INCLUDES.'header.php');
    ?>
    <!-- header_eof //-->
    <script type="text/javascript">
        function toggleView(id) {
            var div = document.getElementById(id);
            div.style.display = div.style.display == "none" ? "block" : "none"; 
        }
    </script>
    <!-- body //-->
    <table style="width: 30%;">
        <tr>
            <?php //left_navigation
            if (USE_ADMIN_TOP_MENU == 'false') {
                echo '<td class="columnLeft2">'.PHP_EOL;
                echo '<!-- left_navigation //-->'.PHP_EOL;       
                require_once(DIR_WS_INCLUDES . 'column_left.php');
                echo '<!-- left_navigation eof //-->'.PHP_EOL; 
                echo '</td>'.PHP_EOL;      
            }
            ?>

            <td  class="boxCenter" style="width: 100%; vertical-align: top;">

                <?php
                //Fahlermeldungen anzeigen    
                if ($_GET['error']!='') {
                    echo '<table width="100%"><tr><td style="font-family: Verdana, Arial, sans-serif; font-size: 12px; font-weight: bold; background-color: #ffb3b5; border:1px solid">';
                    echo 'ERROR:<br><br><pre>'.urldecode($_GET['error']).'</pre>';
                    echo '</pre></td></tr></table>';
                    echo '<a class="button" href="'.xtc_href_link(FILENAME_ORDERS, 'oID='.$oID.'&action=edit').'">'.BUTTON_BACK.'</a>&nbsp;';
                    die;
                }     
                ?>
                <table style="width: 100%;">
                    <tr>
                        <td class="pageHeading">DHL GKAPI Print Label</td>
                    </tr>
                </table>

                <form action="dhlgkapi_print_label.php">
                    <input type="hidden" name="oID" value="<?php echo $oID?>">
                    <table class="boxCenter" style="background: gold">
                        <?php
                        //NB 1.12 display message
                        if ($output_msg != '') {
                        ?>
                            <tr class="main">
                                <td colspan="4">
                                    <strong><?php echo $output_msg; ?></strong>
                                    <br />
                                    <br />
                                </td>
                            </tr>
                            <?php    
                        }

                        $tracking_array = get_tracking_link($oID, $lang_code);
                        if (count($tracking_array) > 0) {
                        ?>
                            <tr class="main">
                                <td style="vertical-align: top;">
                                    <strong><?php echo MODULE_SHIPPING_DHLGKAPI_SHIPMENTS; ?></strong>
                                </td>
                                <td colspan="3" style="text-align: right;">
                                    <?php
                                    foreach($tracking_array as $tracking) {
                                        if ($tracking['carrier_name']=='DHL'){
                                    ?>
                                            <a href="<?php echo $tracking['tracking_link']; ?>" target="_blank"><?php echo $tracking['parcel_id']; ?></a>
                                            &nbsp;&nbsp;
                                            <a href="dhlgkapi_print_label.php?stornolabel=on&oID=<?php echo $oID; ?>&tracking_id=<?php echo urlencode($tracking['parcel_id']); ?>" class="button">
                                            <?php echo MODULE_SHIPPING_DHLGKAPI_BUTTON_STORNO; ?>
                                            </a>
                                            <br />
                                    <?php
                                        }
                                    }
                                    ?>
                                    <br />
                                    <br />
                                </td> 
                            </tr>
                        <?php
                        }
                        ?>
                        <tr class="main">
                            <td style="vertical-align: top;" ><strong><?php echo MODULE_SHIPPING_DHLGKAPI_SHIPPER; ?></strong></td>
                            <td style="vertical-align: top;">
                                <?php
                                echo MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME."<br />";
                                echo MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON."<br />";
                                echo MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME.' '.MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER."<br />";
                                echo MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP.' '.MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY."<br />";
                                echo MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY."<br />";
                                ?>
                            </td>
                            <td style="vertical-align: top; text-align: left;"><strong><?php echo MODULE_SHIPPING_DHLGKAPI_EKP_TEXT; ?></strong><br><strong><?php echo MODULE_SHIPPING_DHLGKAPI_PRODUCT; ?></strong><br /><strong><?php echo MODULE_SHIPPING_DHLGKAPI_ATTENDANCE; ?></strong></td>
                            <td style="vertical-align: top;"><?php echo MODULE_SHIPPING_DHLGKAPI_EKP;?><br>
                                <?php echo $dhl_type; ?><br>
                                <?php echo constant('MODULE_SHIPPING_DHLGKAPI_'.$dhl_type.'_ATTENDANCE'); ?><br><br>
                            </td>
                        </tr>

                        <tr class="main" style="vertical-align: top;">
                            <td><strong><?php echo MODULE_SHIPPING_DHLGKAPI_SHIPPINGDATE; ?></strong></td>
                            <td><?php echo $shipmentdate ?></td>
                            <td><strong><?php echo MODULE_SHIPPING_DHLGKAPI_WEIGHT; ?></strong></td>
                            <td>
                                <?php 
                                echo '<input type="text" name="WeightInKG" value="'.$dhl_weight.'" size="4"/> kg<br>';
                                ?>
                            </td>
                        </tr>
                        <tr class="main">
                            <td style="vertical-align: top;"><strong><?php echo MODULE_SHIPPING_DHLGKAPI_RECEIVER; ?></strong></td>
                            <td style="vertical-align: top;">
                                <?php
                                $check_array=array('Packstation','Postfiliale','Parcelshop');
                                foreach($check_array as $check) {
                                    if(property_exists($dhl_xml->ShipmentOrder->Shipment->Receiver, $check)) {
                                        echo '<strong style="color: green;">'.$check.'</strong><br />';
                                    }
                                } 
                                echo nl2br($name_raw);
                                echo nl2br($address_raw);

                                ?>
                                <a href="https://www.google.de/maps/search/<?php echo urlencode(utf8_encode($address_raw));?>" target="_blank">[Google Maps]</a>
                            </td>
                            <td style="vertical-align: top;">
                                <strong><?php echo MODULE_SHIPPING_DHLGKAPI_EMAIL_TEXT; ?></strong><br />
                                <strong><?php echo MODULE_SHIPPING_DHLGKAPI_PHONE; ?></strong>
                            </td>
                            <td style="vertical-align: top;">
                                <?php echo $order_data['customers_email_address']?><br />
                                <?php echo $order_data['customers_telephone']?>
                            </td>


                        </tr>
                        <tr class="main">
                            <td colspan='2' style="vertical-align: top;">
                            </td>
                            <td style="vertical-align: top;">
                                <strong><?php echo MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_TITLE; ?></strong>
                            </td>
                            <td style="vertical-align: top;">
                                <?php
                                foreach ($wunschpaket_services as $id => $service) {
                                    echo '<strong>'.constant('MODULE_SHIPPING_DHLGKAPI_'.$id.'_TITLE').'</strong><br />';
                                    echo '<input maxlength="32" type="text" name="'.$service.'" value="'.$wunschpaket[$id].'"><br /><br />'; 
                                }
                                ?>
                            </td>
                        </tr> 
                        <tr class="main">
                            <td style="vertical-align: top;">
                                <strong><?php echo MODULE_SHIPPING_DHLGKAPI_CUSTOMS; ?></strong>
                            </td>
                            <td style="vertical-align: top;">
                                <?php
                                if (!in_array($order_data['delivery_country_iso_code_2'],explode(',',MODULE_SHIPPING_DHLGKAPI_EU_COUNTRIES))) {
                                    echo MODULE_SHIPPING_DHLGKAPI_INVOICENUMBER.'<br />'.xtc_draw_input_field('invoiceNumber',$oID);
                                    echo '<p>'.MODULE_SHIPPING_DHLGKAPI_ADDITIONALFEE.'<br />'.xtc_draw_input_field('additionalFee','0.00').'</p>';
                                    echo '<p>'.MODULE_SHIPPING_DHLGKAPI_CUSTOMSTARIFFNUMBER.'<br />'.xtc_draw_input_field('customsTariffNumber','').'</p>';
                                    echo '<p>'.MODULE_SHIPPING_DHLGKAPI_NETWEIGHTINKG.'<br />'.xtc_draw_input_field('netWeightInKG',($dhl_weight - SHIPPING_BOX_WEIGHT)).'</p>';
                                    echo '<p>'.MODULE_SHIPPING_DHLGKAPI_CUSTOMSVALUE.'<br />'.xtc_draw_input_field('customsValue',$cod_amount).'</p>';

                                    $terms=array('DDP','DXV','DDU','DDX');
                                    $select_array=array();
                                    foreach($terms as $term) {
                                        $select_array[]=array('id' => $term, 'text' => $term); 
                                    }

                                    echo MODULE_SHIPPING_DHLGKAPI_TERMSOFTRADE .'<br />'. xtc_draw_pull_down_menu('termsOfTrade',  $select_array, 'DDU') .'<br />'. MODULE_SHIPPING_DHLGKAPI_TERMSOFTRADE_DESC;
                                }
                                ?>
                            </td>
                            <td style="vertical-align: top;">
                                <strong><?php echo MODULE_SHIPPING_DHLGKAPI_SERVICES; ?></strong><br /><br />
                            </td>
                            <td style="vertical-align: top;">
                                <?php
                                $ages=array('A16','A18');
                                $age_array=array();
                                foreach($ages as $age) {
                                    $age_array[]=array('id' => $age, 'text' => $age); 
                                }
                                $count=0;
                                foreach ($display_services as $service) {
                                    if ($valid_services[$dhl_product][$service]=='1') {
                                        $extra_input='';
                                        $checked=$dhl_xml->ShipmentOrder->Shipment->ShipmentDetails->Service->{$service}['active']=='1'?true:false;
                                        $disabled=false;
                                        $display='';
                                        switch($service) {
                                            case 'CashOnDelivery':
                                                if ((MODULE_SHIPPING_DHLGKAPI_COD_ENABLED=='True') && (MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE==$order_data['payment_class'])) {
                                                    $checked=true; 
                                                    $extra_input= '<input size="10" type="text" name="CODAmount" value="'.$cod_amount.'"/> EUR';
                                                } else {
                                                    $disabled=true;
                                                }
                                                break;

                                            case 'GoGreen':
                                                if (constant('MODULE_SHIPPING_DHLGKAPI_'.strtoupper($service).'_ENABLED')=='True') {
                                                    $checked=true;
                                                }
                                                break;

                                            case 'PrintOnlyIfCodeable':
                                                $checked=true;
                                                break;

                                            case 'AdditionalInsurance':
                                                if ($cod_amount > 500) {
                                                    $extra_input = '<input size="10" type="text" name="insuranceAmount" value="'.$cod_amount.'"/> EUR';
                                                } else {
                                                    $disabled=true; 
                                                }
                                                break;

                                            case 'Return':
                                                if (constant('MODULE_SHIPPING_DHLGKAPI_'.strtoupper($service).'_ENABLED')=='True') $checked=true;
                                                break;

                                            case 'VisualCheckOfAge':
                                                $extra_input = xtc_draw_pull_down_menu('VisualCheckOfAgeType',  $age_array, 'A18');
                                                break;

                                            case 'IdentCheck':
                                                $extra_input = '<p>'.ENTRY_LAST_NAME.'<br /><input size="10" type="text" name="surname" value="'.$order_data['delivery_lastname'].'"></p>';
                                                $extra_input .= '<p>'.ENTRY_FIRST_NAME.'<br /><input size="10" type="text" name="givenName" value="'.$order_data['delivery_firstname'].'"></p>';
                                                $extra_input .= '<p>'.MODULE_SHIPPING_DHLGKAPI_MINIMUMAGE.'<br /><input size="10" type="text" name="minimumAge" value="18"></p>';
                                                $extra_input .= '<p>'.ENTRY_DATE_OF_BIRTH.'<br />'.xtc_draw_date_selector('IdentCheck',time()).'</p>';

                                                break; 
                                        }
                                        echo $count>0?"<p>":'';
                                        if (!$disabled) echo xtc_draw_checkbox_field($service, '', $checked, null ,'onClick="toggleView(\''.$service.'\')"'). '<strong> '.$service.'</strong>'.'<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.constant('MODULE_SHIPPING_DHLGKAPI_SERVICE_'.strtoupper($service).'_TEXT');
                                        if (!$checked) $display="display: none;";
                                        echo '<div id="'.$service.'" style="padding-left:35px;'.$display.'">'.$extra_input.'</div>';
                                        echo $count>0?"</p>":'';
                                        $count++;
                                    }       
                                }
                                ?>                       
                            </td> 
                        </tr>                                                                                                               
                        <tr class="main">
                            <td colspan="2" style="text-align: left;">
                                <?php
                                //Zurück
                                echo '<a class="button" href="'.xtc_href_link(FILENAME_ORDERS, 'oID='.$oID.'&action=edit').'">'.BUTTON_BACK.'</a>&nbsp;';
                                ?>
                            </td>
                            <td colspan="2" style="text-align: right;">
                                <?php
                                //Label erstellen 
                                echo '<input class="button" type="submit" name="getlabel" value="'.MODULE_SHIPPING_DHLGKAPI_BUTTON_GETLABEL.'"/>&nbsp';
                                ?> 
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table> 
</body>
</html>
