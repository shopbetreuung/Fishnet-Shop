<?php
/* ---------------------------------------------------------------------------------------
$Id: dhlgkapi.php  v2.25 22.10.2018 nb $

Autor: Nico Bauer (c) 2016-2018 Dörfelt GmbH for DHL Paket GmbH

-----------------------------------------------------------------------------------------
based on:

zones.php

(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(zones.php,v 1.19 2003/02/05); www.oscommerce.com 
(c) 2003      nextcommerce (zones.php,v 1.7 2003/08/24); www.nextcommerce.org
(c) 2006      xtcommerce (zones.php 899 2005-04-29);

Released under the GNU General Public License
[http://www.gnu.org/licenses/gpl-2.0.html] 
-----------------------------------------------------------------------------------------
Changelog:
1.04    wrong constant and variable used
1.05    auto include needed function for modified V1.06
1.06    change for backend order manipulation
1.14    better frontend Wunschpaket selection/deselection and additional pricing frontend/backend
1.15    exclude payment methods when choosing Wunschtag and payments config in backend 
1.16    added keyword blacklist for userinput Wunschnachbar, Wunschort
1.17    added multi box shipment
1.18    added stock check for Wunschtag
2.00    added delivery time check for Wunschtag and more shipping zones
2.01    added array check because of Wunschnachbar changes
2.02    better Wunschtag calculation
2.04	fixed tax addition bug Wunschtag/Wunschzeit
2.06    always show DHL Logo and show module name incl/excl Wunschpaket
2.10    include/exclude Wunschpaket surcharge to freeamount
2.20    utilize Paketsteuerungs-API
2.23    add shipping email cut-off time
2.25    correct error shipping day calculation
-----------------------------------------------------------------------------------------
*/ 

class dhlgkapi {
    var $code, $title, $description, $icon, $enabled, $dhl_types;


    function __construct() {
        global $order, $shipping_weight; 

        $this->code = 'dhlgkapi';
        $this->title = MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_DHLGKAPI_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_DHLGKAPI_SORT_ORDER;
        $this->icon = '';
        $this->tax_class = MODULE_SHIPPING_DHLGKAPI_TAX_CLASS;
        $this->enabled = ((MODULE_SHIPPING_DHLGKAPI_STATUS == 'True') ? true : false);

        if (!function_exists('xtc_get_countriesList')) require_once(DIR_FS_INC."xtc_get_countries.inc.php"); //NB 1.05
        require_once(DIR_FS_INC."xtc_get_countries_with_iso_codes.inc.php");
        $this->store_country=xtc_get_countries_with_iso_codes(STORE_COUNTRY);

        switch ($this->store_country['countries_iso_code_2']) {
            case 'DE':
                $this->dhl_types = array('V01PAK', 'V53WPAK(Z1)', 'V53WPAK(Z2)', 'V53WPAK(Z3)', 'V53WPAK(Z4)', 'V53WPAK(Z5)', 'V53WPAK(Z6)'); //NB 2.00
                break;

            case 'AT':
                $this->dhl_types = array('V86PARCEL', 'V87PARCEL', 'V82PARCEL(Z1)', 'V82PARCEL(Z2)', 'V82PARCEL(Z3)', 'V82PARCEL(Z4)'); //NB 2.00
                break;

            default:
                $this->enabled = false;
        }

        if (isset($_POST['PreferredNeighbour']) && is_array($_POST['PreferredNeighbour'])) { //NB 2.01
            $_SESSION['dhlgkapi']['PreferredNeighbour']=array_filter($_POST['PreferredNeighbour']);
        } 

        if (isset($_POST['PreferredLocation'])) {
            $_SESSION['dhlgkapi']['PreferredLocation']=$_POST['PreferredLocation'];
        } 

        if (isset($_POST['PreferredDay'])) {
            $_SESSION['dhlgkapi']['PreferredDay']=$_POST['PreferredDay'];
        }

        if (isset($_POST['PreferredTime'])) {
            $_SESSION['dhlgkapi']['PreferredTime']=$_POST['PreferredTime'];
        }

        //NB 1.15
        if (isset($_SESSION['dhlgkapi']['PreferredDay']) && $_SESSION['dhlgkapi']['PreferredDay']!='-1') { 
            $payment_exclude = explode(',', $_SESSION['customers_status']['customers_status_payment_unallowed']);
            $dhlgkapi_exclude = explode(',',str_replace(' ','',MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_PAYMENT_EXCLUDE));  
            $_SESSION['customers_status']['customers_status_payment_unallowed']=implode(',',$new_payment_exclude=array_unique(array_filter(array_merge($payment_exclude, $dhlgkapi_exclude))));
        }

        if (isset($_SESSION['dhlgkapi']['PreferredTime']) && $_SESSION['dhlgkapi']['PreferredTime']!='-1') { 
            $payment_exclude = explode(',', $_SESSION['customers_status']['customers_status_payment_unallowed']);
            $dhlgkapi_exclude = explode(',',str_replace(' ','',MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_PAYMENT_EXCLUDE));  
            $_SESSION['customers_status']['customers_status_payment_unallowed']=implode(',',$new_payment_exclude=array_unique(array_filter(array_merge($payment_exclude, $dhlgkapi_exclude))));
        }

        if (isset($_SESSION['dhlgkapi']['PreferredNeighbour']) && !empty($_SESSION['dhlgkapi']['PreferredNeighbour'])) { 
            $payment_exclude = explode(',', $_SESSION['customers_status']['customers_status_payment_unallowed']);
            $dhlgkapi_exclude = explode(',',str_replace(' ','',MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_PAYMENT_EXCLUDE));  
            $_SESSION['customers_status']['customers_status_payment_unallowed']=implode(',',$new_payment_exclude=array_unique(array_filter(array_merge($payment_exclude, $dhlgkapi_exclude))));
        }

        if (isset($_SESSION['dhlgkapi']['PreferredLocation']) && $_SESSION['dhlgkapi']['PreferredLocation']!='') { 
            $payment_exclude = explode(',', $_SESSION['customers_status']['customers_status_payment_unallowed']);
            $dhlgkapi_exclude = explode(',',str_replace(' ','',MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_PAYMENT_EXCLUDE));  
            $_SESSION['customers_status']['customers_status_payment_unallowed']=implode(',',$new_payment_exclude=array_unique(array_filter(array_merge($payment_exclude, $dhlgkapi_exclude))));
        }
    }

    //NB 2.2 start
    function paketsteuerung($zip, $date) {
        $auth = base64_encode("dhlgkapi_ps_1:WrhRRabkVm8Z6zo16OguHoFz78l1AO");

        $options = array(
            'http'  => array(
                'header' => 
                'Authorization: Basic ' . $auth . "\r\n".
                'Accept: application/json' . "\r\n".
                "X-EKP: " . MODULE_SHIPPING_DHLGKAPI_EKP
            )
        );

        $context = stream_context_create($options);
        $result = @file_get_contents("https://cig.dhl.de/services/production/rest/checkout/".$zip."/availableServices?startDate=".$date, false, $context);   

        /*
        $result = '{"preferredTime": {
        "available": true,
        "timeframes": [
        {
        "start": "18:00",
        "end": "21:00",
        "code": "033"
        },
        {
        "start": "19:00",
        "end": "21:00",
        "code": "032"
        }
        ]
        }}';
        */

        if ($result) return json_decode($result, true);

        return false;  
    }
    //NB 2.2 end

    function quote($method = '') {
        global $xtPrice, $order, $shipping_weight, $shipping_num_boxes, $shipping_quoted, $shipping_quote_all, $ref_url;

        $dest_country = $order->delivery['country']['iso_code_2'];
        $dest_zones = array();
        $error = false;

        $tax = ($this->tax_class > 0 ? xtc_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']) : 0);

        if (isset($method) && $method!='') {
            $selected_type='';
            foreach ($this->dhl_types as $type) {
                if ($type == $method) {
                    $selected_type = $type;
                    break;
                } 
            } 

            if ($selected_type!='') {
                $this->dhl_types=array($type); 
            }
        }

        foreach ($this->dhl_types as $type) {
            $countries_table = constant('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES');
            $country_zones = explode(",", $countries_table);
            $zone_enabled = constant('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED');
            if (in_array($dest_country, $country_zones) && $zone_enabled == 'True') {
                $dest_zones[] = $type;
            }
        }

        //NB 2.06 
        //NB 2.10
        if ($method == '' && strstr($_SERVER["PHP_SELF"],'checkout_shipping')) {
            $shipping_method_addon_logo = '<div><img alt="DHL Logo" src="'.DIR_WS_ICONS.'/DHL_rgb_147px.png"></div>';  
        } else {
            $shipping_method_addon_logo = '';
        }

        $shipping_method_addon = '';

        $module_title = MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE_NO_WS; //NB 2.06

        if (!$dest_zones) {
            $error = true;
        } else {
            $shipping_methods=array();
            foreach ($dest_zones as $type) {

                $service_cost = 0;
                $shipping_method_text='';
                $shipping_method_text_array=array();

                if ($type=='V01PAK') {
                    if ($method == '' && strstr($_SERVER["PHP_SELF"],'checkout_shipping')) {
                        $dhl_smarty=new Smarty();
                        $dhl_smarty->assign('tpl_path',DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE.'/');
                        $dhl_smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
                        $dhl_smarty->assign('language', $_SESSION['language']); //NB 1.04;
                        $dhl_smarty->caching = false;
                        $dhl_smarty->template_dir = DIR_FS_CATALOG.'templates';
                        $dhl_smarty->compile_dir = DIR_FS_CATALOG.'templates_c';
                        $dhl_smarty->config_dir = DIR_FS_CATALOG.'lang';

                        if (MODULE_SHIPPING_DHLGKAPI_PSF_ENABLED == 'True') $dhl_smarty->assign('BUTTON_PSF', '<a href="'.xtc_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, null, 'SSL').'">'.MODULE_SHIPPING_DHLGKAPI_PSF_BUTTON.'</a>');
                        $dhl_smarty->assign('PSF_TITLE', MODULE_SHIPPING_DHLGKAPI_PSF_TITLE);
                        $dhl_smarty->assign('PSF_DESC', MODULE_SHIPPING_DHLGKAPI_PSF_DESC);  

                        $dhl_smarty->assign('WUNSCHPAKET_BLACKLIST', MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_BLACKLIST); //NB1.16

                        if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED == 'True' || MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED == 'True' || MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED == 'True' || MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED == 'True') {

                            //NB 2.2 start
                            if ($ref_url['path'] == '/checkout_shipping_address.php') {
                                $dhl_smarty->assign('WUNSCHPAKET_ADDRESS_CHANGE', MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_ADDRESS_CHANGE);
                            }

                            $pt_array=array('-1' => MODULE_SHIPPING_DHLGKAPI_NO_PREFERENCE);
                            $pd_array=array('-1' => array('date' => MODULE_SHIPPING_DHLGKAPI_NO_PREFERENCE, 'day' => ''));

                            //Einlieferungstag auch Versandtag?
                            $holidays = explode(',' , MODULE_SHIPPING_DHLGKAPI_HOLIDAYS); //Ausschlusstage

                            $daynames=unserialize(MODULE_SHIPPING_DHLGKAPI_DAYNAMES);
                            $shipping_days = explode(',', MODULE_SHIPPING_DHLGKAPI_SHIPPING_DAYS); //Versandtage
                            $shipping_days = array_map('strtoupper', $shipping_days);

                            $count=0; //Einlieferungstag bestimmen  //NB 2.02

                            if (time() > strtotime(MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME)) {
                                $count+=1;
                            }

                            $start = false;
                            while ($start != true) {
                                $date = strtotime('+'.$count.' days');
                                $date_short = date('d.m.', $date);
                                $weekday = date('w', $date);

                                if (in_array(strtoupper($daynames[$weekday]), $shipping_days) && !in_array($date_short, $holidays)) { //NB 2.25 nur Versandtage und kein Versand an Feiertagen
                                    $start = true;
                                } else {
                                    $count++;
                                }
                            }

                            if (MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True') { //NB 2.25

                                $time = strtotime("+".$count." days"); 

                                $date = date('Y-m-d', $time);

                                $strg_data = $this->paketsteuerung($order->delivery['postcode'],$date);

                                if (is_array($strg_data)) {

                                    if ($strg_data['preferredDay']['available'] == true) {
                                        foreach ($strg_data['preferredDay']['validDays'] as $index => $datetime) {
                                            $date=strtotime($datetime['start']);
                                            $delivery_date=date('d.m.y', $date);
                                            $delivery_date_shown=date('d', $date);
                                            $weekday=date('w', $date);

                                            $pd_array[$delivery_date] = array('date' => $delivery_date_shown, 'day' => $weekday);
                                            echo '';
                                        }

                                    } 

                                    if ($strg_data['preferredTime']['available'] == true) {
                                        foreach ($strg_data['preferredTime']['timeframes'] as $index => $timeframe) {
                                            $timestring = str_replace(':', '', $timeframe['start'].$timeframe['end']);

                                            $pt_array[$timestring] = substr($timeframe['start'], 0, 2) . '-' . substr($timeframe['end'], 0, 2);  //NB 2.2
                                        }
                                    }
                                }
                            }
                            //NB 2.2 end


                            $dhl_smarty->assign('WUNSCHPAKET_TEXT_TITLE', MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_TITLE);
                            $dhl_smarty->assign('WUNSCHPAKET_TEXT_DESC', MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_DESC);

                            // **** Wunschtag
                            if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED == 'True') {//NB 1.14 viele Änderungen

                                if ( (MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True' && $strg_data['preferredDay']['available'] == true) || (MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True' && $strg_data == false) ||  MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'False' ) { //NB 2.2

                                    //NB 1.18
                                    $all_available = true;
                                    if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_STOCK_CHECK == 'True') {
                                        foreach($order->products as $product) {
                                            $products_stock = xtc_get_products_stock($product['id']); //NB Fishnet
                                            if ($products_stock < $product['qty']) {
                                                $all_available = false;
                                                break;   
                                            }
                                        }
                                    }

                                    //NB 2.00
                                    if ($all_available == true && MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK == 'True') {
                                        foreach($order->products as $product) {
                                            $shipping_time_query = xtc_db_query("SELECT products_shippingtime
                                                FROM ".TABLE_PRODUCTS."
                                                WHERE products_id = '".(int)$product['id']."'");
                                            $shipping_time = implode(xtc_db_fetch_array($shipping_time_query));
                                            if ($shipping_time != MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_STATUS) {
                                                $all_available = false;
                                                break;
                                            }
                                        }
                                    }

                                    //NB 2.2
                                    if (MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True') {
                                        if (is_array($strg_data) && $strg_data['preferredDay']['available'] != true) {
                                            $all_available = false;
                                        }
                                    }

                                    if ($all_available == true) {

                                        if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST > 0) $dhl_smarty->assign('PD_COST', $xtPrice->xtcFormat(xtc_add_tax(MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST, $tax), true, 0, true));

                                        $dhl_smarty->assign('PD_TITLE', MODULE_SHIPPING_DHLGKAPI_PD_TITLE);
                                        $dhl_smarty->assign('PD_DESC', MODULE_SHIPPING_DHLGKAPI_PD_DESC);
                                        $dhl_smarty->assign('PD_TOOLTIP', MODULE_SHIPPING_DHLGKAPI_PD_TOOLTIP);

                                        $daynames_shown=unserialize(MODULE_SHIPPING_DHLGKAPI_DAYNAMES_SHOWN);

                                        if ((MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True' && $strg_data == false) || MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'False' ) { //NB 2.2
                                            $count+=2; //Wunschtag = E + 2..6 ARBEITStage

                                            //Starttag für Zustellung ermitteln (kein Feiertag und kein Sonntag)
                                            $start = false;
                                            while ($start != true) {
                                                $date=strtotime('+'.$count.' days');
                                                $date_short=date('d.m.', $date);
                                                $weekday=date('w', $date);

                                                if ($weekday!=0 && !in_array($date_short, $holidays)) {
                                                    $start = true;
                                                } else {
                                                    $count++;  
                                                }
                                            }

                                            $days=0;
                                            while($days<5) {
                                                $date=strtotime('+'.$count.' days');
                                                $delivery_date=date('d.m.y', $date);
                                                $date_short=date('d.m.', $date);
                                                $delivery_date_shown=date('d', $date);
                                                $weekday=date('w', $date);

                                                if ($weekday!=0 && !in_array($date_short, $holidays)) {//Sonntags keine Zustellung und auch keine Feiertage...                             
                                                    $pd_array[$delivery_date] = array('date' => $delivery_date_shown, 'day' => $weekday); 
                                                    $days++;
                                                }
                                                $count++;
                                            }
                                        }

                                        $pd_data=array();
                                        $count = 0;
                                        foreach ($pd_array as $delivery_date => $date_array) {
                                            $delivery_date_shown = $date_array['date']; 
                                            $weekday = $date_array['day'];
                                            $checked=false;

                                            if (!isset($_SESSION['dhlgkapi']['PreferredDay']) && $count == 0) $checked=true;
                                            if (isset($_SESSION['dhlgkapi']['PreferredDay']) && $_SESSION['dhlgkapi']['PreferredDay'] == $delivery_date) $checked=true;

                                            $pd_data[]=xtc_draw_radio_field('PreferredDay',$delivery_date, $checked,'id="PreferredDay'.$delivery_date.'"').'<label for="PreferredDay'.$delivery_date.'">'.$delivery_date_shown.'<br>'.($weekday != '' ? $daynames_shown[$weekday] : '').'</label>';

                                            $count++;
                                        } 

                                        $dhl_smarty->assign('PD_DATA', $pd_data);
                                    }
                                }
                            }

                            // **** Wunschzeit
                            if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED == 'True') {

                                if ( (MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True' && $strg_data['preferredTime']['available'] == true) || (MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True' && $strg_data == false) ||  MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'False' ) { //NB 2.2 

                                    if (MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True' && $strg_data == false || MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'False') {  //NB 2.2
                                        $pt_array=array(
                                            '-1' => MODULE_SHIPPING_DHLGKAPI_NO_PREFERENCE,
                                            '18002000' => '18-20',  //NB 2.25
                                            '19002100' => '19-21'
                                        );
                                    }

                                    if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_COST > 0) $dhl_smarty->assign('PT_COST', $xtPrice->xtcFormat(xtc_add_tax(MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_COST, $tax), true, 0, true));

                                    $dhl_smarty->assign('PT_TITLE', MODULE_SHIPPING_DHLGKAPI_PT_TITLE);
                                    $dhl_smarty->assign('PT_DESC', MODULE_SHIPPING_DHLGKAPI_PT_DESC);
                                    $dhl_smarty->assign('PT_TOOLTIP', MODULE_SHIPPING_DHLGKAPI_PT_TOOLTIP);

                                    $pt_data=array();
                                    $count = 0;
                                    foreach ($pt_array as $pt => $pt_text) {
                                        $checked=false;

                                        if (!isset($_SESSION['dhlgkapi']['PreferredTime']) && $count == 0) $checked=true;
                                        if (isset($_SESSION['dhlgkapi']['PreferredTime']) && $_SESSION['dhlgkapi']['PreferredTime'] == $pt) $checked=true;

                                        $pt_data[]=xtc_draw_radio_field('PreferredTime', $pt, $checked, 'id="PreferredTime'.$pt.'"').
                                        '<label for="PreferredTime'.$pt.'">'.$pt_text.'</label>';

                                        $count++;
                                    }

                                    $dhl_smarty->assign('PT_DATA', $pt_data);
                                }
                            }

                            if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED == 'True' && MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED == 'True' && MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST > 0) {
                                $dhl_smarty->assign('PDPT_COST', $xtPrice->xtcFormat(xtc_add_tax(MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST, $tax), true, 0, true)); //NB 2.04
                                $dhl_smarty->assign('PDPT_HINT', MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_HINT);
                            }

                            // **** Wunschnachbar
                            if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED == 'True') {
                                if ( (MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True' && $strg_data['preferredNeighbour']['available'] == true) || (MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True' && $strg_data == false) ||  MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'False' ) { //NB 2.2
                                    $dhl_smarty->assign('PN_TITLE', MODULE_SHIPPING_DHLGKAPI_PN_TITLE);
                                    $dhl_smarty->assign('PN_DESC', MODULE_SHIPPING_DHLGKAPI_PN_DESC);
                                    $dhl_smarty->assign('PN_TOOLTIP', MODULE_SHIPPING_DHLGKAPI_PN_TOOLTIP);
                                    $pn_data = xtc_draw_input_field('PreferredNeighbour[]',(isset($_SESSION['dhlgkapi']['PreferredNeighbour'][0]) ? $_SESSION['dhlgkapi']['PreferredNeighbour'][0] : null),'id="PreferredNeighbour1" maxlength="30" onInput="checkempty();" placeholder="'.MODULE_SHIPPING_DHLGKAPI_PN_PLACEHOLDER1.'"').' <br />';
                                    $pn_data .= xtc_draw_input_field('PreferredNeighbour[]',(isset($_SESSION['dhlgkapi']['PreferredNeighbour'][1]) ? $_SESSION['dhlgkapi']['PreferredNeighbour'][1] : null),'id="PreferredNeighbour2" maxlength="50" onInput="checkempty();" placeholder="'.MODULE_SHIPPING_DHLGKAPI_PN_PLACEHOLDER2.'"');
                                    $dhl_smarty->assign('PN_DATA', $pn_data);
                                }
                            }

                            // **** Wunschort
                            if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED == 'True') {
                                if ( (MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True' && $strg_data['preferredLocation']['available'] == true) || (MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'True' && $strg_data == false) ||  MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED == 'False' ) { //NB 2.2
                                    $dhl_smarty->assign('PL_TITLE', MODULE_SHIPPING_DHLGKAPI_PL_TITLE);
                                    $dhl_smarty->assign('PL_DESC', MODULE_SHIPPING_DHLGKAPI_PL_DESC);
                                    $dhl_smarty->assign('PL_TOOLTIP', MODULE_SHIPPING_DHLGKAPI_PL_TOOLTIP);

                                    $dhl_smarty->assign('PL_DATA',xtc_draw_input_field('PreferredLocation', (isset($_SESSION['dhlgkapi']['PreferredLocation']) ? $_SESSION['dhlgkapi']['PreferredLocation'] : null),'id="PreferredLocation" maxlength="80" onInput="checkempty();" placeholder="'.MODULE_SHIPPING_DHLGKAPI_PL_PLACEHOLDER.'"'));
                                }
                            }

                            if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED == 'True' && MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED == 'True') {
                                $dhl_smarty->assign('TEXT_OR', MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_OR);
                            }
                        }

                        if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED == 'True' || 
                            MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED == 'True' || 
                            MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED == 'True' || 
                            MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED == 'True')
                            $module_title = MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE; //NB 2.06

                    } else {

                        if (isset($_SESSION['dhlgkapi']['PreferredDay']) && $_SESSION['dhlgkapi']['PreferredDay']!='-1') { 


                            if (isset($order->customer['payment_unallowed']) && $order->customer['payment_unallowed']!='') {
                                $_SESSION['dhlgkapi']['payment_unallowed'] = $order->customer['payment_unallowed'];

                                //Zahlarten für Wunschtag ausschließen
                                $payment_exclude = explode(',', $order->customer['payment_unallowed']);
                                $dhlgkapi_exclude = explode(',',str_replace(' ','',MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_PAYMENT_EXCLUDE));  
                                $order->customer['payment_unallowed']=implode(',',$new_payment_exclude=array_unique(array_merge($payment_exclude, $dhlgkapi_exclude)));
                            }

                            $shipping_method_text_array[]='PD:'.$_SESSION['dhlgkapi']['PreferredDay'];
                            $service_cost = MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST;
                        }

                        if (isset($_SESSION['dhlgkapi']['PreferredTime']) && $_SESSION['dhlgkapi']['PreferredTime']!='-1') { 
                            $shipping_method_text_array[]='PT:'.$_SESSION['dhlgkapi']['PreferredTime'];
                            $service_cost = MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_COST;
                        }

                        if (isset($_SESSION['dhlgkapi']['PreferredDay']) && $_SESSION['dhlgkapi']['PreferredDay']!='-1' && $_SESSION['dhlgkapi']['PreferredTime'] && $_SESSION['dhlgkapi']['PreferredTime']!='-1') {
                            $service_cost = MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST;
                        }

                        if (isset($_SESSION['dhlgkapi']['PreferredNeighbour']) && !empty($_SESSION['dhlgkapi']['PreferredNeighbour'])) 
                            $shipping_method_text_array[]='PN:'.implode(', ',array_filter($_SESSION['dhlgkapi']['PreferredNeighbour']));

                        if (isset($_SESSION['dhlgkapi']['PreferredLocation']) && $_SESSION['dhlgkapi']['PreferredLocation']!='')    
                            $shipping_method_text_array[]='PL:'.$_SESSION['dhlgkapi']['PreferredLocation'];

                        if (!empty($shipping_method_text_array)) $shipping_method_text=' ['.implode('~',$shipping_method_text_array).']'; 

                    }

                }

                $shipping = -1;
                $zones_cost = constant('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST');

                $zones_table = preg_split('/[:,]/' , $zones_cost);
                $size = sizeof($zones_table);
                for ($i=0; $i<$size; $i+=2) {
                    if ($shipping_weight <= $zones_table[$i]) {
                        $shipping = $zones_table[$i+1];
                        //NB 1.17
                        $shipping_method = trim(MODULE_SHIPPING_DHLGKAPI_TEXT_WAY . ' ' . constant('MODULE_SHIPPING_DHLGKAPI_TYPE_'.$type.'_TITLE') . ' '. $dest_country . ' (' . ($shipping_num_boxes > 1 ? $shipping_num_boxes . ' x ' : '' ). $shipping_weight . ' ' . MODULE_SHIPPING_DHLGKAPI_TEXT_UNITS .') '. $shipping_method_text);
                        break;
                    }
                }

                if ($shipping == -1) {
                    $shipping_cost = 0;
                    $shipping_method = MODULE_SHIPPING_DHLGKAPI_UNDEFINED_RATE;
                } else {
                    //NB 1.06 $order->info['subtotal']
                    if (($_SESSION['cart']->total >= constant('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT')) && (constant('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT') > 0)) { 
                        $shipping_cost = 0.00;

                        //NB 2.10
                        if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_FREEAMOUNT_COST_ENABLED == 'True') {
                            $shipping_cost = $service_cost * $shipping_num_boxes; 
                        } else {
                            if (isset($dhl_smarty)) {
                                $dhl_smarty->clearAssign('PD_COST');
                                $dhl_smarty->clearAssign('PT_COST');
                                $dhl_smarty->clearAssign('PDPT_COST');
                            }
                        }
                    } else {
                        //NB 1.04 wrong constant used
                        //NB 1.17
                        $shipping_cost = (($shipping + $service_cost) * $shipping_num_boxes) + constant('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING');
                    }
                }

                //NB 2.10
                if (isset($dhl_smarty)) {
                    $shipping_method_addon = $dhl_smarty->fetch(CURRENT_TEMPLATE.'/module/dhlgkapi.html'); 
                }

                $shipping_methods[]=array('id' => $type,
                    'title' => $shipping_method . $shipping_method_addon_logo . $shipping_method_addon,
                    'cost' => $shipping_cost);
            }
        }

        $this->quotes = array('id' => $this->code,
            'module' => $module_title,
            'methods' => $shipping_methods);

        if ($this->tax_class > 0) {
            $this->quotes['tax'] = $tax;
        }

        if (xtc_not_null($this->icon)) $this->quotes['icon'] = xtc_image($this->icon, $this->title);

        if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_DHLGKAPI_INVALID_ZONE . $shipping_method_addon_logo; //NB 2.06

        return $this->quotes;    
    }

    function check() {
        if (!isset($this->_check)) {
            $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_DHLGKAPI_STATUS'");
            $this->_check = xtc_db_num_rows($check_query);
        }
        return $this->_check;
    }



    function install() {

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_STATUS', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_ALLOWED', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_DHLGKAPI_TAX_CLASS', '0', '6', '0', 'xtc_get_tax_class_title', 'xtc_cfg_pull_down_tax_classes(', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_SORT_ORDER', '0', '6', '0', now())");

        foreach ($this->dhl_types as $type) {
            $default_enabled = 'True';
            $retoure_attendance='0';

            switch ($type)  {
                case 'V01PAK':
                    $default_countries = 'DE';
                    $default_prices = '2:4.99,5:5.99,10:7.99,31.5:14.99';
                    $retoure_attendance='01';
                    break;

                case 'V53WPAK(Z1)':
                    $default_countries = 'AT,BE,BG,CZ,CY,DK,EE,FI,FR,GR,HR,HU,IE,IT,LT,LU,LV,MC,MT,NL,PL,PT,RO,SK,SI,ES,SE,GB';
                    $default_prices = '2:13.99,5:15.99,10:20.99,20:31.99,31.5:44.99';
                    break;

                case 'V53WPAK(Z2)':
                    $default_countries = 'AD,AL,AX,BA,BY,CH,EA,FO,GE,GG,GI,GL,IC,IS,JE,LI,MD,ME,MK,NO,RS,RU,SM,TR,UA,VA,XK';
                    $default_prices = '5:28.99,10:34.99,20:48.99,31.5:55.99';
                    break;

                case 'V53WPAK(Z3)':
                    $default_countries = 'AM,AZ,CA,DZ,EG,IL,JO,KZ,LB,LY,MA,PM,PS,SY,TN,US';
                    $default_prices = '5:34.99,10:48.99,20:68.99,31.5:95.99';
                    break;

                case 'V53WPAK(Z4)':
                    $default_countries = 'AE,AF,AG,AI,AO,AQ,AR,AS,AU,AW,BB,BD,BF,BH,BI,BJ,BL,BM,BN,BO,BQ,BR,BS,BT,BV,BW,BZ,CC,CD,CF,CG,CI,CK,CL,CM,CN,CO,CR,CU,CV,CW,CX,DJ,DM,DO,EC,EH,ER,ET,FJ,FK,FM,GA,GD,GF,GH,GM,GN,GP,GQ,GS,GT,GU,GW,GY,HK,HM,HN,HT,ID,IM,IN,IO,IQ,IR,JM,JP,KE,KG,KH,KI,KM,KN,KP,KR,KW,KY,LA,LC,LK,LR,LS,MF,MG,MH,ML,MM,MN,MO,MP,MQ,MR,MS,MU,MV,MW,MX,MY,MZ,NA,NC,NE,NF,NG,NI,NP,NR,NU,NZ,OM,PA,PE,PF,PG,PH,PK,PN,PR,PW,PY,QA,RE,RW,SA,SB,SC,SD,SG,SH,SJ,SL,SN,SO,SR,SS,ST,SV,SX,SZ,TC,TD,TF,TG,TH,TJ,TK,TL,TM,TO,TT,TV,TW,TZ,UG,UM,UY,UZ,VC,VE,VG,VI,VN,VU,WF,WS,YE,YT,ZA,ZM,ZW';
                    $default_prices = '5:42.99,10:58.99,20:94.99,31.5:125.99';
                    break;

                case 'V86PARCEL':
                    $default_countries = 'AT';
                    $default_prices = '20:7.49';
                    break;

                case 'V87PARCEL':                                                                                                                                                 
                    $default_countries = 'DE,BE,NL,LU,PL,CZ,SK';        
                    $default_prices = '20:20.99';
                    break;

                case 'V82PARCEL(Z1)':
                    $default_countries = 'BG,CY,DK,EE,FI,FR,GR,HR,HU,IE,IT,LT,LV,MC,MT,PT,RO,SI,ES,SE,GB';
                    $default_prices = '20:20.99';
                    break;

                case 'V82PARCEL(Z2)':                                                                                                                                                 
                    $default_countries = 'AD,AL,AX,BA,BY,CH,EA,FO,GE,GG,GI,GL,IC,IS,JE,LI,MD,ME,MK,NO,RS,RU,SM,TR,UA,VA,XK,'.
                    'AE,AF,AG,AI,AO,AQ,AR,AS,AU,AW,BB,BD,BF,BH,BI,BJ,BL,BM,BN,BO,BQ,BR,BS,BT,BV,BW,BZ,CC,CD,CF,CG,CI,CK,CL,CM,CN,CO,CR,CU,CV,CW,CX,DJ,DM,DO,EC,EH,ER,ET,FJ,FK,FM,GA,GD,GF,GH,GM,GN,GP,GQ,GS,GT,GU,GW,GY,HK,HM,HN,HT,ID,IM,IN,IO,IQ,IR,JM,JP,KE,KG,KH,KI,KM,KN,KP,KR,KW,KY,LA,LC,LK,LR,LS,MF,MG,MH,ML,MM,MN,MO,MP,MQ,MR,MS,MU,MV,MW,MX,MY,MZ,NA,NC,NE,NF,NG,NI,NP,NR,NU,NZ,OM,PA,PE,PF,PG,PH,PK,PN,PR,PW,PY,QA,RE,RW,SA,SB,SC,SD,SG,SH,SJ,SL,SN,SO,SR,SS,ST,SV,SX,SZ,TC,TD,TF,TG,TH,TJ,TK,TL,TM,TO,TT,TV,TW,TZ,UG,UM,UY,UZ,VC,VE,VG,VI,VN,VU,WF,WS,YE,YT,ZA,ZM,ZW';
                    $default_prices = '20:82.99';
                    break;

                default :
                    $default_countries = '';
                    $default_prices = '';
                    $default_enabled = 'False';
                    break;
            }

            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_ATTENDANCE', '01', '6', '0', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_COUNTRIES', '" . $default_countries . "', '6', '0', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_COST', '".$default_prices."', '6', '0', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_HANDLING', '0', '6', '0', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_FREEAMOUNT', '0', '6', '0', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_RETOURE_ATTENDANCE','".$retoure_attendance."', '6', '0', now())");                         
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_ENABLED', '".$default_enabled."', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ',now())");          
        }

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED', 'False', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_EMAIL_TIME', '16:00', '6', '0', now())");                    

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_EKP', '', '6', '0', now())"); 
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_USER', '', '6', '0', now())"); 
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_PASSWORD', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY', '".$this->store_country['countries_iso_code_2']."', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_RETURN_NAME', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_RETURN_CITY', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY', '".$this->store_country['countries_iso_code_2']."', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_COD_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE', 'cod', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE', '2', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME', '', '6', '0', now())");                        
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN', '', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC', '', '6', '0', now())");                                       
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED', '0', '6', '0', 'xtc_cfg_pull_down_order_statuses(', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED', '0', '6', '0', 'xtc_cfg_pull_down_order_statuses(', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_STOCK_CHECK', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");  
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_STATUS', '1', '6', '0', 'xtc_draw_pull_down_menu(\'configuration[MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_STATUS]\',xtc_get_shipping_status(), ', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_FREEAMOUNT_COST_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME', '12:00', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_PAYMENT_EXCLUDE', 'cash,moneyorder', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_PAYMENT_EXCLUDE', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_PAYMENT_EXCLUDE', 'klarna_invoice', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_PAYMENT_EXCLUDE', 'klarna_invoice', '6', '0', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_COST', '4.80', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST', '1.20', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST', '4.80', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_HOLIDAYS', '24.12.,01.01.', '6', '0', now())");                    
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_SHIPPING_DAYS', 'Mo,Di,Mi,Do,Fr,Sa', '6', '0', now())");      

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_PSF_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_UTF8_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");



        $admin_check_query = xtc_db_query("show columns from ".TABLE_ADMIN_ACCESS." where Field='dhlgkapi_print_label'");
        if (xtc_db_num_rows($admin_check_query)==0) {
            xtc_db_query("alter table " . TABLE_ADMIN_ACCESS . " add dhlgkapi_print_label INT(1) NOT NULL DEFAULT '1'");  
        }
        
        $carrier_check_query = xtc_db_query("select * from carriers where carrier_name='DHL'");
        if (xtc_db_num_rows($carrier_check_query)==0) {
            xtc_db_query("INSERT INTO `carriers` (`carrier_name`, `carrier_tracking_link`, `carrier_sort_order`, `carrier_date_added`, `carrier_last_modified`) VALUES
            ('DHL', 'http://nolp.dhl.de/nextt-online-public/set_identcodes.do?lang=$2&idc=$1', 10, 'now()', '0000-00-00 00:00:00');");
        }
    }

    function remove() {
        xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
        xtc_db_query("alter table " . TABLE_ADMIN_ACCESS . " drop dhlgkapi_print_label");
    }

    function keys() {
        $keys =array ('MODULE_SHIPPING_DHLGKAPI_STATUS',
            'MODULE_SHIPPING_DHLGKAPI_ALLOWED', 
            'MODULE_SHIPPING_DHLGKAPI_TAX_CLASS', 
            'MODULE_SHIPPING_DHLGKAPI_SORT_ORDER',
            'MODULE_SHIPPING_DHLGKAPI_PSF_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_UTF8_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_EMAIL_TIME',
            'MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_EKP',
            'MODULE_SHIPPING_DHLGKAPI_USER',
            'MODULE_SHIPPING_DHLGKAPI_PASSWORD',
            'MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME',
            'MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME',
            'MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER',
            'MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP',
            'MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY',
            'MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY',
            'MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON',
            'MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL',
            'MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE',
            'MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_RETURN_NAME',
            'MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME',
            'MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER',
            'MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP',
            'MODULE_SHIPPING_DHLGKAPI_RETURN_CITY',
            'MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY',
            'MODULE_SHIPPING_DHLGKAPI_COD_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE',
            'MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE',
            'MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER',
            'MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME',    
            'MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN',
            'MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC',
            'MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED',
            'MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED',
            'MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_STOCK_CHECK',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_STATUS',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_PAYMENT_EXCLUDE',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_COST',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_PAYMENT_EXCLUDE',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_PAYMENT_EXCLUDE',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_PAYMENT_EXCLUDE',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_FREEAMOUNT_COST_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_SHIPPING_DAYS',
            'MODULE_SHIPPING_DHLGKAPI_HOLIDAYS'

        );

        foreach ($this->dhl_types as $type) {
            $keys[] = 'MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED';
            $keys[] = 'MODULE_SHIPPING_DHLGKAPI_'.$type.'_ATTENDANCE';
            $keys[] = 'MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES';
            $keys[] = 'MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST';
            $keys[] = 'MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING';
            $keys[] = 'MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT';
            $keys[] = 'MODULE_SHIPPING_DHLGKAPI_'.$type.'_RETOURE_ATTENDANCE';      
        }

        return $keys;
    }

}
?>
