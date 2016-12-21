<?php


define( PDFBILL_FOLDER, 'pdf_invoices/' );
define( PDFBILL_PREFIX, 'pdf_invoice_' );
define( PDF_INVOICE_NAME, '%s.pdf' );   // filename of email pdf-attachment invoice


define( LSM_CONFIG_FILE, 'lsm_config.txt');

function lsm_infos() {
  $lines_arr = file(LSM_CONFIG_FILE);
  $ret=array();
  
  for($i=0; $i<sizeof($lines_arr); $i++) {
    $line=trim(substr($lines_arr[$i],0,strpos($lines_arr[$i],'//')));
    $line1=trim(substr($lines_arr[$i+1],0,strpos($lines_arr[$i+1],'//')));
    $line2=trim(substr($lines_arr[$i+2],0,strpos($lines_arr[$i+2],'//')));
    $line3=trim(substr($lines_arr[$i+3],0,strpos($lines_arr[$i+3],'//')));
    
    if( preg_match('/\[([0-9]*)\]/', $line, $matches) ) {
      $products_id = $matches[1];
      $ret[$products_id] = array( 'products_id' => $products_id,
                                  'email'       => $line1,
                                  'packing' => $line2,
                                  'bill'    => $line3  );
      $i+=3;
    }
  }
  return $ret;
}

function lsm_mailinfos($order, $lsm_infos) {
  $count_bill=0;
  $count_packing=0;
  $emails = array();
  $success=false;
  
  foreach( $order->products as $pdata ) {
    $products_id=$pdata['id'];
    if( isset($lsm_infos[$products_id] ) ) {
// addition Werte
//      $count_packing += $lsm_infos[$products_id]['packing'];
//      $count_bill    += $lsm_infos[$products_id]['bill'];

// maximum Werte
      $count_packing = max($lsm_infos[$products_id]['packing'], $count_packing);
      $count_bill    = max($lsm_infos[$products_id]['bill'], $count_bill);
      
      
      $emails[] = $lsm_infos[$products_id]['email'];
      $success=true;
    }
  }
  
  $emails = array_unique($emails);
  
  if( $success ) {
    return array( 'packing' => $count_packing,
                  'bill'    => $count_bill,
                  'emails'  => implode(',',$emails )       );
  } else {
    return false; 
  }
  
}

function get_languages() {
  $ret = array();
  $languages_query_raw = "select languages_id, name, code, image, directory, sort_order,language_charset from " . TABLE_LANGUAGES . " order by sort_order";
  $languages_query = xtc_db_query($languages_query_raw);

  while ($languages = xtc_db_fetch_array($languages_query)) {
    if( DEFAULT_LANGUAGE == $languages['code'] ) {
      $languages['default']=1;
    }
    $ret[]=$languages;
  }
  
  return $ret;
}

function get_language_code($lang_name) {
  $languages_query_raw = "select code from " . TABLE_LANGUAGES . " where directory='".$lang_name."'";
  $languages_query = xtc_db_query($languages_query_raw);

  if ($data = xtc_db_fetch_array($languages_query)) {
    return $data['code'];
  }
  
  return '';
}



function pdfbill_invoice_exists( $oid ) {
  $filename=PDFBILL_FOLDER.PDFBILL_PREFIX.($oid).'.pdf'; 
  return (file_exists($filename));
}

function pdfbill_delnote_exists( $oid ) {
  $filename=PDFBILL_FOLDER.'pdf_delnote_'.($oid).'.pdf'; 
  return (file_exists($filename));
}


function get_pdf_invoice_filename( $ordes_id ) {
  return PDFBILL_FOLDER.PDFBILL_PREFIX.($ordes_id.'.pdf');
}

function get_pdf_delnote_filename( $ordes_id ) {
  return PDFBILL_FOLDER.'pdf_delnote_'.($ordes_id.'.pdf');
}

function get_pdf_invoice_download_filename( $ordes_id ) {
	$check_status_query = xtc_db_query("select ibn_billdate, ibn_billnr from ".TABLE_ORDERS." where orders_id = '".$ordes_id."'");
 	$check_status = xtc_db_fetch_array($check_status_query);

  $billnr = make_billnr( $check_status['ibn_billdate'], $check_status['ibn_billnr'] );
  return sprintf(PDF_INVOICE_NAME, $billnr);

}



function make_billnr( $ibn_billdate, $ibn_billnr ) {
/*  
  $raw_date = $ibn_billdate;
  $year = substr($raw_date, 0, 4);
  $month = (int)substr($raw_date, 5, 2);
  $day = (int)substr($raw_date, 8, 2);

  if (@date('Y', mktime($hour, $minute, $second, $month, $day, $year)) == $year) {
    $r=date('d-m-Y', mktime($hour, $minute, $second, $month, $day, $year));
  } else {
    $r=ereg_replace('2037' . '$', $year, date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, 2037)));
  }
  
  $d=$ibn_billnr.'-'.$r;
*/
  $raw_date = $ibn_billdate;
  $year = substr($raw_date, 0, 4);
  $month = (int)substr($raw_date, 5, 2);
  $day = (int)substr($raw_date, 8, 2);

  $year = substr('0000'.$year, -4);
  $month = substr('00'.$month, -2);
  $day = substr('00'.$day, -2);
  
  $d=IBN_BILLNR_FORMAT;
  $d=str_replace('{n}', $ibn_billnr, $d);
  $d=str_replace('{d}', $day, $d);
  $d=str_replace('{m}', $month, $d);
  $d=str_replace('{y}', $year, $d);
  
  
  return $d;
  
}


function hex2rgb ( $hex )
{
    $hex = preg_replace("/[^a-fA-F0-9]/", "", $hex);
    $rgb = array();
    if ( strlen ( $hex ) == 3 )
    {
        $rgb[0] = hexdec ( $hex[0] . $hex[0] );
        $rgb[1] = hexdec ( $hex[1] . $hex[1] );
        $rgb[2] = hexdec ( $hex[2] . $hex[2] );
    }
    elseif ( strlen ( $hex ) == 6 )
    {
        $rgb[0] = hexdec ( $hex[0] . $hex[1] );
        $rgb[1] = hexdec ( $hex[2] . $hex[3] );
        $rgb[2] = hexdec ( $hex[4] . $hex[5] );
    }
    else
    {
        return "ERR: Incorrect colorcode, expecting 3 or 6 chars (a-f, A-F, 0-9)";
    }
    return $rgb;
}

function order_nr_list() {
  $ret = array();
  $order_query = xtc_db_query("SELECT orders_id FROM " . TABLE_ORDERS . " order by orders_id desc");
  while ($data = xtc_db_fetch_array($order_query)) {
    $ret[]=$data['orders_id'];
  }
  return $ret;
}

function profile_save( $profile_name, $parameter_arr, $checked_ids = '', $rules = '' ) {
  $sql = "select 
            profile_id
          from ".
            TABLE_PDFBILL_PROFILE."
          where
            profile_name = '$profile_name'";    
  $sql=xtDBquery($sql);
  
  $parameter_list      = profile_serialize($parameter_arr);
  
  
  if( xtc_db_num_rows($sql)>0 ) {  // if profile exists
    $data=xtc_db_fetch_array($sql);
    $sql = "update ".
              TABLE_PDFBILL_PROFILE."
            set
              profile_parameter = '$parameter_list',
              rules = '$rules'
            where 
              profile_id = '".$data['profile_id']."'";
  } else {              // profile not exists
    $sql = "insert into ".
              TABLE_PDFBILL_PROFILE."
            ( profile_name,
              profile_parameter,
              rules)
            values (
              '$profile_name',
              '$parameter_list',
              '$rules')";
  }    
  xtDBquery($sql);
}


function add_new_profile($profile_name){
  $sql = "insert into ". TABLE_PDFBILL_PROFILE. " (profile_name) values ('$profile_name')";
  xtDBquery($sql);
}

function profile_load( $profile_id ) {
  $sql = "select * from ".TABLE_PDFBILL_PROFILE." where profile_id = '$profile_id'";    
  $sql = xtDBquery($sql);
  $ret=array();
  if( $data = xtc_db_fetch_array($sql) ) {
    $ret = $data;
    $ret['profile_parameter_arr']  = profile_unserialize($data['profile_parameter']);
  }
  
  $ret['profile_parameter_arr']['profile_name'] = $data['profile_name'];
  
  return $ret;
  
}

function profile_load_n( $profile_name ) {
  $sql = "select * from ".TABLE_PDFBILL_PROFILE." where profile_name = '$profile_name'";    
  $sql = xtDBquery($sql);
  $ret=array();
  if( $data = xtc_db_fetch_array($sql) ) {
    $ret = $data;
    $ret['profile_parameter_arr']  = profile_unserialize($data['profile_parameter']);
  }
  
  $ret['profile_parameter_arr']['profile_name'] = $data['profile_name'];
  
  return $ret;
  
}  

function profile_list() {
  $sql = "select profile_id, profile_name, rules, profile_parameter from ".TABLE_PDFBILL_PROFILE;    
  $sql = xtDBquery($sql);
  $ret = array();
  while( $data = xtc_db_fetch_array($sql) ) {
    $profile_parameters = array();
    $profile_parameters = explode(',', $data['profile_parameter']);
    foreach ($profile_parameters as $profile_parameter) {
      if (strstr($profile_parameter, 'typeofbill')) {
        $typeofbill_array = explode('=', $profile_parameter);
        $data['typeofbill'] = $typeofbill_array[1];
      }
    }
    unset($data['profile_parameter']);
    $ret[] = $data;
  }
  return $ret;
}
  
  
function profile_delete( $profile_id ) {
  $sql = "delete from ".TABLE_PDFBILL_PROFILE." where profile_id = '$profile_id'";    
  xtDBquery($sql);
}

function profile_delete_all( ) {
  $sql = "delete from ".TABLE_PDFBILL_PROFILE;    
  xtDBquery($sql);
}


function profile_serialize( $parameter_arr ) {
  foreach( $parameter_arr as $n => $v ) {
    if( is_array($v) ) {
      $v='{'.implode(';',$v).'}';
    }
    $v=str_replace(',', '#/K', $v);
    
    $parameter_arr[$n] = "$n=$v";
  }
   
  return implode(',', $parameter_arr);
}

function profile_unserialize( $parameter_list ) {
  $par1 = explode(',', $parameter_list);
  
  $parameter = array();
  foreach( $par1 as $vp1 ) {
    $vp1 = explode('=', $vp1);
    
    if( $vp1[1][0] == '{' ) {
      
      $vp1[1] = substr($vp1[1], 1, strlen($vp1[1])-2);
      $vp1[1] = explode(';', $vp1[1]);
    }
    $vp1[1] = str_replace('#/K', ',', $vp1[1]);
    
    $parameter[$vp1[0]] = $vp1[1];
  }
   
  return $parameter;
}





function default_profile() {
  $profile['bgimage_display'] = '1';
  $profile['bgimage_image'] = 'hintergrund.png';
  $profile['headtext_display'] = '1';
  $profile['headtext_text'] = 'Muster GBR Unterhaltungselektronik';
  $profile['headtext_font_color'] = '#0000CC';
  $profile['headtext_font_type'] = 'arial';
  $profile['headtext_font_style'] = 'BI';
  $profile['headtext_font_size'] = '18';
  $profile['headtext_horizontal'] = '15';
  $profile['headtext_vertical'] = '0';
  $profile['headtext_width'] = '';
  $profile['headtext_height'] = '';
  $profile['addressblock_display'] = '1';
  $profile['addressblock_text'] = 'Muster GBR, Postfach 4711, 12345 Flümme';
  $profile['addressblock_position'] = 'L';
  $profile['addressblock_font_color'] = '';
  $profile['addressblock_font_type'] = 'arial';
  $profile['addressblock_font_style'] = 'BU';
  $profile['addressblock_font_size'] = '6';
  $profile['addressblock_position2'] = 'R';
  $profile['addressblock_font_color2'] = '';
  $profile['addressblock_font_type2'] = 'arial';
  $profile['addressblock_font_style2'] = 'BI';
  $profile['addressblock_font_size2'] = '10';
  $profile['addressblock_horizontal'] = '15';
  $profile['addressblock_vertical'] = '15';
  $profile['addressblock_width'] = '50';
  $profile['image_display'] = '1';
  $profile['image_image'] = 'muster.jpg';
  $profile['image_horizontal'] = '150';
  $profile['image_vertical'] = '0';
  $profile['image_width'] = '';
  $profile['image_height'] = '';
  $profile['datafields_display'] = '1';
  $profile['datafields_position'] = 'L';
  $profile['datafields_font_color'] = '';
  $profile['datafields_font_type'] = 'arial';
  $profile['datafields_font_size'] = '10';
  $profile['datafields_position2'] = 'R';
  $profile['datafields_font_color2'] = '';
  $profile['datafields_font_type2'] = 'arial';
  $profile['datafields_font_style2'] = 'B';
  $profile['datafields_font_size2'] = '10';
  $profile['datafields_text_1'] = 'Rechnungsdatum';
  $profile['datafields_value_1'] = '*date*';
  $profile['datafields_text_2'] = 'Kundennummer';
  $profile['datafields_value_2'] = '*customers_id*';
  $profile['datafields_text_3'] = 'Rechnungsnummer';
  $profile['datafields_value_3'] = '*orders_id*';
  $profile['datafields_horizontal'] = '110';
  $profile['datafields_vertical'] = '80';
  $profile['datafields_width'] = '40,30';
  $profile['billhead_display'] = '1';
  $profile['billhead_text'] = 'Rechnung Nr: *orders_id*';
  $profile['billhead_position'] = 'L';
  $profile['billhead_font_color'] = '';
  $profile['billhead_font_type'] = 'arial';
  $profile['billhead_font_style'] = 'BIU';
  $profile['billhead_font_size'] = '12';
  $profile['billhead_horizontal'] = '15';
  $profile['billhead_vertical'] = '80';
  $profile['billhead_width'] = '';
  $profile['billhead_height'] = '';
  $profile['listhead_display'] = '1';
  $profile['listhead_text'] = 'Rechnungspositionen';
  $profile['listhead_font_color'] = '';
  $profile['listhead_font_type'] = 'arial';
  $profile['listhead_font_style'] = 'B';
  $profile['listhead_font_size'] = '8';
  $profile['listhead_horizontal'] = '15';
  $profile['listhead_vertical'] = '100';
  $profile['listhead_width'] = '';
  $profile['listhead_height'] = '';
  $profile['poslist_font_color'] = '';
  $profile['poslist_font_type'] = 'arial';
  $profile['poslist_font_size'] = '6';
  $profile['poslist_head_1'] = 'Pos.';
  $profile['poslist_value_1'] = '*pos_nr*';
  $profile['poslist_width_1'] = '5';
  $profile['poslist_align_1'] = 'C';
  $profile['poslist_head_2'] = 'Art.Nr.';
  $profile['poslist_value_2'] = '*p_model*';
  $profile['poslist_width_2'] = '20';
  $profile['poslist_align_2'] = 'C';
  $profile['poslist_head_3'] = 'Artikel';
  $profile['poslist_value_3'] = '*p_name*';
  $profile['poslist_width_3'] = '105';
  $profile['poslist_align_3'] = 'L';
  $profile['poslist_head_4'] = 'qty';
  $profile['poslist_value_4'] = '*p_qty*';
  $profile['poslist_width_4'] = '5';
  $profile['poslist_align_4'] = 'C';
  $profile['poslist_head_5'] = 's_price';
  $profile['poslist_value_5'] = '*p_single_price*';
  $profile['poslist_width_5'] = '15';
  $profile['poslist_align_5'] = 'R';
  $profile['poslist_head_6'] = 'total';
  $profile['poslist_value_6'] = '*p_price*';
  $profile['poslist_width_6'] = '15';
  $profile['poslist_align_6'] = 'R';
  $profile['poslist_head_7'] = '';
  $profile['poslist_value_7'] = '';
  $profile['poslist_width_7'] = '';
  $profile['poslist_align_7'] = 'C';
  $profile['poslist_horizontal'] = '15';
  $profile['poslist_vertical'] = '';
  $profile['resumefields_display'] = '1';
  $profile['resumefields_position'] = 'L';
  $profile['resumefields_font_color'] = '';
  $profile['resumefields_font_type'] = 'arial';
  $profile['resumefields_font_size'] = '10';
  $profile['resumefields_position2'] = 'R';
  $profile['resumefields_font_color2'] = '';
  $profile['resumefields_font_type2'] = 'arial';
  $profile['resumefields_font_size2'] = '10';
  $profile['resumefields_horizontal'] = '60';
  $profile['resumefields_vertical'] = '5';
  $profile['resumefields_width'] = '80,40';
  $profile['subtext_display'] = '1';
  $profile['subtext_text'] = 'Die Ware bleibt bis zur vollständigen Bezahlung Eigentum der Muster GBR ';
  $profile['subtext_font_color'] = '';
  $profile['subtext_font_type'] = 'arial';
  $profile['subtext_font_size'] = '8';
  $profile['subtext_horizontal'] = '15';
  $profile['subtext_vertical'] = '25';
  $profile['subtext_width'] = '';
  $profile['subtext_height'] = '';
  $profile['footer_display'] = '1';
  $profile['footer_font_color'] = '';
  $profile['footer_font_type'] = 'arial';
  $profile['footer_font_size'] = '6';
  $profile['footer_display_1'] = '1';
  $profile['footer_position_1'] = 'L';
  $profile['footer_text_1'] = 'Muster GbR Beispielstrasse 123 12345 Flümme';
  $profile['footer_display_2'] = '1';
  $profile['footer_position_2'] = 'C';
  $profile['footer_text_2'] = 'Konto: 1234567 BLZ 222 333 44 Beispielbank';
  $profile['footer_display_3'] = '1';
  $profile['footer_position_3'] = 'R';
  $profile['footer_text_3'] = 'HGR 32344424 AmtsG. Flümme StNr. 5545594';
  $profile['footer_position_4'] = 'L';
  $profile['footer_text_4'] = '';
  $profile['terms_display'] = '1';
  $profile['terms_formtext'] = 'Allgemeine Geschäftsbedingungen (AGB)';
  $profile['terms_head_position'] = 'L';
  $profile['terms_head_font_style'] = 'B';
  $profile['terms_head_font_size'] = '10';
  $profile['terms_font_color'] = '';
  $profile['terms_font_type'] = 'arial';
  $profile['terms_font_size'] = '6';
  return $profile;
}  
  
?>
