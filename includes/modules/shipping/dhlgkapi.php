<?php
/* ---------------------------------------------------------------------------------------
$Id: dhlgkapi.php v1.05 30.10.2017 nb $

Autor: Nico Bauer (c) 2016 Dörfelt GmbH for DHL Paket GmbH

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


        if (isset($_POST['PreferredNeighbour'])) {
            $_SESSION['dhlgkapi']['PreferredNeighbour']=$_POST['PreferredNeighbour'];
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


        switch ($this->store_country['countries_iso_code_2']) {
            case 'DE':
                $this->dhl_types = array('V01PAK', 'V53WPAK(Z1)', 'V53WPAK(Z2)', 'V53WPAK(Z3)', 'V53WPAK(Z4)');
                break;

            case 'AT':
                $this->dhl_types = array('V86PARCEL', 'V87PARCEL', 'V82PARCEL(Z1)', 'V82PARCEL(Z2)');
                break;

            default:
                $this->enabled = false;
        }
    }


    function quote($method = '') {
        global $xtPrice, $order, $shipping_weight;

        $dest_country = $order->delivery['country']['iso_code_2'];
        $dest_zones = array();
        $error = false;

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

        if (!$dest_zones) {
            $error = true;
        } else {
            $shipping_methods=array();
            foreach ($dest_zones as $type) {

                $shipping_method_addon='';
                $shipping_method_text='';
                $shipping_method_text_array=array();

                if ($type=='V01PAK' && MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_ENABLED=='True') {
                    if ($method=='' && strstr($_SERVER["PHP_SELF"],'checkout_shipping')) {

                        $dhl_smarty=new Smarty();
                        $dhl_smarty->assign('tpl_path',DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE.'/');
                        $dhl_smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
                        $dhl_smarty->assign('language', $_SESSION['language']); //NB 1.04;
                        $dhl_smarty->caching = false;
                        $dhl_smarty->template_dir = DIR_FS_CATALOG.'templates';
                        $dhl_smarty->compile_dir = DIR_FS_CATALOG.'templates_c';
                        $dhl_smarty->config_dir = DIR_FS_CATALOG.'lang';

                        $dhl_smarty->assign('WUNSCHPAKET_TEXT_TITLE', MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_TITLE);
                        $dhl_smarty->assign('WUNSCHPAKET_TEXT_DESC', MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_DESC);
                        $dhl_smarty->assign('PD_TITLE', MODULE_SHIPPING_DHLGKAPI_PD_TITLE);
                        $dhl_smarty->assign('PD_DESC', MODULE_SHIPPING_DHLGKAPI_PD_DESC);
                        $dhl_smarty->assign('PD_TOOLTIP', MODULE_SHIPPING_DHLGKAPI_PD_TOOLTIP);
                        $dhl_smarty->assign('PT_TITLE', MODULE_SHIPPING_DHLGKAPI_PT_TITLE);
                        $dhl_smarty->assign('PT_DESC', MODULE_SHIPPING_DHLGKAPI_PT_DESC);
                        $dhl_smarty->assign('PT_TOOLTIP', MODULE_SHIPPING_DHLGKAPI_PT_TOOLTIP);
                        $dhl_smarty->assign('PN_TITLE', MODULE_SHIPPING_DHLGKAPI_PN_TITLE);
                        $dhl_smarty->assign('PN_DESC', MODULE_SHIPPING_DHLGKAPI_PN_DESC);
                        $dhl_smarty->assign('PN_TOOLTIP', MODULE_SHIPPING_DHLGKAPI_PN_TOOLTIP);
                        $dhl_smarty->assign('PL_TITLE', MODULE_SHIPPING_DHLGKAPI_PL_TITLE);
                        $dhl_smarty->assign('PL_DESC', MODULE_SHIPPING_DHLGKAPI_PL_DESC);
                        $dhl_smarty->assign('PL_TOOLTIP', MODULE_SHIPPING_DHLGKAPI_PL_TOOLTIP);
                        $dhl_smarty->assign('BUTTON_PSF', '<a href="'.xtc_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, null, 'SSL').'">'.MODULE_SHIPPING_DHLGKAPI_PSF_BUTTON.'</a>');
                        $dhl_smarty->assign('PSF_TITLE', MODULE_SHIPPING_DHLGKAPI_PSF_TITLE);
                        $dhl_smarty->assign('PSF_DESC', MODULE_SHIPPING_DHLGKAPI_PSF_DESC);


                        $days=0;
                        $count=2;
                        if (time() > strtotime(MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME)) {
                            $count=3;
                        }
                        $daynames=unserialize(MODULE_SHIPPING_DHLGKAPI_DAYNAMES);

                        $pd_data=array();
                        
                        while($days<6) {
                            $date=strtotime('+'.$count.' days');
                            $delivery_date=date('d.m.y', $date);
                            $delivery_date_shown=date('d', $date);
                            $weekday=date('w', $date);
                            if ($weekday!=0) {
                                $pd_data[]=xtc_draw_checkbox_field('PreferredDay',$delivery_date,null,'id="PreferredDay'.$delivery_date.'" onClick="clear_select(\'PreferredDay\',\'PreferredDay'.$delivery_date.'\')"').'<label for="PreferredDay'.$delivery_date.'">'.$delivery_date_shown.'<br>'.$daynames[$weekday].'</label>';
                                $days++;
                            }
                            $count++;
                        }
                        $dhl_smarty->assign('PD_DATA', $pd_data);

                        $pt_data=array(); 
                        $pt_data[]=xtc_draw_checkbox_field('PreferredTime','18002000',null,'id="PreferredTime18002000" onClick="clear_select(\'PreferredTime\',\'PreferredTime18002000\')"').
                        '<label for="PreferredTime18002000">18 - 20</label>';
                        $pt_data[]=xtc_draw_checkbox_field('PreferredTime','19002100',null,'id="PreferredTime19002100" onClick="clear_select(\'PreferredTime\',\'PreferredTime19002100\')"').
                        '<label for="PreferredTime19002100">19 - 21</label>';

                        $dhl_smarty->assign('PT_DATA', $pt_data);

						if (MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED == 'True' && MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED == 'True' && MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST > 0) {
								$dhl_smarty->assign('PDPT_COST', $xtPrice->xtcFormat(xtc_add_tax(MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST, $tax), true, 0, true)); //NB 2.04
								$dhl_smarty->assign('PDPT_HINT', MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_HINT);
							}
                        $dhl_smarty->assign('PL_DATA',xtc_draw_input_field('PreferredLocation',null,'id="PreferredLocation" maxlength="32" onInput="checkempty();" placeholder="'.MODULE_SHIPPING_DHLGKAPI_PL_PLACEHOLDER.'"'));

                        $shipping_method_addon = $dhl_smarty->fetch(CURRENT_TEMPLATE.'/module/dhlgkapi.html'); 
                    } else {
                        if (isset($_SESSION['dhlgkapi']['PreferredDay']) && $_SESSION['dhlgkapi']['PreferredDay']!='') 
                            $shipping_method_text_array[]='PD:'.$_SESSION['dhlgkapi']['PreferredDay'];

                        if (isset($_SESSION['dhlgkapi']['PreferredTime']) && $_SESSION['dhlgkapi']['PreferredTime']!='') 
                            $shipping_method_text_array[]='PT:'.$_SESSION['dhlgkapi']['PreferredTime'];

                        if (isset($_SESSION['dhlgkapi']['PreferredNeighbour']) && $_SESSION['dhlgkapi']['PreferredNeighbour']!='') 
                            $shipping_method_text_array[]='PN:'.$_SESSION['dhlgkapi']['PreferredNeighbour'];

                        if (isset($_SESSION['dhlgkapi']['PreferredNeighbour']) && $_SESSION['dhlgkapi']['PreferredLocation']!='')    
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
                        //$shipping_method = trim(MODULE_SHIPPING_DHLGKAPI_TEXT_WAY . ' ' . constant('MODULE_SHIPPING_DHLGKAPI_TYPE_'.$type.'_TITLE') . ' (' .$type. ') ' . $dest_country . ' : ' . $shipping_weight . ' ' . MODULE_SHIPPING_DHLGKAPI_TEXT_UNITS . $shipping_method_text);
                        $shipping_method = trim(MODULE_SHIPPING_DHLGKAPI_TEXT_WAY . ' ' . constant('MODULE_SHIPPING_DHLGKAPI_TYPE_'.$type.'_TITLE') . ' '. $dest_country . ' ' . $shipping_weight . ' ' . MODULE_SHIPPING_DHLGKAPI_TEXT_UNITS . $shipping_method_text);
                        break;
                    }
                }

                if ($shipping == -1) {
                    $shipping_cost = 0;
                    $shipping_method = MODULE_SHIPPING_DHLGKAPI_UNDEFINED_RATE;
                } else {
                    //NB 1.06 
                    if (($_SESSION['cart']->total >= constant('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT')) && (constant('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT') > 0)) { 
                        $shipping_cost = 0.00; 
                    } else {
                        //NB 1.04 wrong constant used
                        $shipping_cost = ($shipping + constant('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING'));
                    }
                }

                $shipping_methods[]=array('id' => $type,
                    'title' => $shipping_method.$shipping_method_addon,
                    'cost' => $shipping_cost);
            }
        }

        $this->quotes = array('id' => $this->code,
            'module' => MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE,
            'methods' => $shipping_methods);

        if ($this->tax_class > 0) {
            $this->quotes['tax'] = xtc_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        }

        if (xtc_not_null($this->icon)) $this->quotes['icon'] = xtc_image($this->icon, $this->title);

        if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_DHLGKAPI_INVALID_ZONE;



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
            }

            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_ATTENDANCE', '01', '6', '0', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_COUNTRIES', '" . $default_countries . "', '6', '0', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_COST', '".$default_prices."', '6', '0', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_HANDLING', '0', '6', '0', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_FREEAMOUNT', '0', '6', '0', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_RETOURE_ATTENDANCE','".$retoure_attendance."', '6', '0', now())");                         
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_DHLGKAPI_".$type."_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ',now())");          
        }

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED', 'False', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
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
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_ENABLED', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME', '14:00', '6', '0', now())");                    


        $admin_check_query = xtc_db_query("show columns from ".TABLE_ADMIN_ACCESS." where Field='dhlgkapi_print_label'");
        if (xtc_db_num_rows($admin_check_query)==0) {
            xtc_db_query("alter table " . TABLE_ADMIN_ACCESS . " add dhlgkapi_print_label INT(1) NOT NULL DEFAULT '0'");  
        }
        xtc_db_query("update " . TABLE_ADMIN_ACCESS . " set dhlgkapi_print_label = '1' where customers_id = '1'");

        xtc_db_query("CREATE TABLE IF NOT EXISTS carriers (
            carrier_id int(11) NOT NULL AUTO_INCREMENT,
            carrier_name varchar(80) COLLATE latin1_german1_ci NOT NULL,
            carrier_tracking_link varchar(512) COLLATE latin1_german1_ci NOT NULL,
            carrier_sort_order int(11) NOT NULL,
            carrier_date_added datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            carrier_last_modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            primary key (carrier_id)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");

        $carrier_check_query = xtc_db_query("select * from carriers where carrier_name='DHL'");
        if (xtc_db_num_rows($carrier_check_query)==0) {
            xtc_db_query("INSERT INTO `carriers` (`carrier_name`, `carrier_tracking_link`, `carrier_sort_order`, `carrier_date_added`, `carrier_last_modified`) VALUES
            ('DHL', 'http://nolp.dhl.de/nextt-online-public/set_identcodes.do?lang=$2&idc=$1', 10, 'now()', '0000-00-00 00:00:00');");
        }

        xtc_db_query("CREATE TABLE IF NOT EXISTS orders_tracking (
            tracking_id int(11) NOT NULL AUTO_INCREMENT,
            orders_id int(11) NOT NULL,
            carrier_id int(11) NOT NULL,
            parcel_id varchar(80) COLLATE latin1_german1_ci NOT NULL,
            primary key (tracking_id)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;");
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

            'MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED',
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
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_ENABLED',
            'MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME',
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
