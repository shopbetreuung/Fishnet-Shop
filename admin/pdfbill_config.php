<?php

require('includes/application_top.php');

define( FREEE_INFO, false );  // freies extrafeld, default verstecktes feature

require(DIR_FS_ADMIN.'includes/ipdfbill/pdfbill_lib.php');
require_once(DIR_FS_INC . 'xtc_add_tax.inc.php');
require_once (DIR_FS_INC.'xtc_get_subcategories.inc.php');
define('FPDF_FONTPATH',DIR_FS_ADMIN.'includes/ipdfbill/classes/fpdf/font/');
require_once(DIR_FS_ADMIN .'includes/ipdfbill/classes/pdfbill.php');

$error = 'false';
$profile             = array();              // default
$profile_categories  = array();

$helpwindows_text_arr = array();

if(isset($_POST['new_profile_name']) && !empty($_POST['new_profile_name']) && $_POST['new_profile_name'] != 'default'){
  $all_profiles = profile_list();
  $existing = false;
  foreach($all_profiles as $profile){
    if($profile['profile_name'] == $_POST['new_profile_name']) {
      $existing = true;
      break;
    }
  }
  if (!$existing){ 
      add_new_profile($_POST['new_profile_name']);
      $profile_name = $_POST['new_profile_name'];
  }
}

if( isset($_POST['profile']) ){
  if (isset($_POST['profile']['profile_name']) && $_POST['profile']['profile_name'] != 'default') {
    $profile_save_name = $_POST['profile']['profile_name'];
  } else {
    $profile_save_name = 'profile_'.$_POST['profile']['languages_code'].'_'.$_POST['profile']['typeofbill'];
  }
  
$rules = '';
if(isset($_POST['rules'])){
    $rules_build = '';
    foreach($_POST['rules'] as $rule => $values){
		$option = str_replace(' ', '', $values['option']);
        if(isset($values['active']) && !empty($option)){
            #Operation check
            $operation = '=';
            if($values['operation'] == '1'){
                $operation = '!=';
            }
            #Condition check
            $condition = 'AND';
            if($values['condition'] == '1'){
                $condition = 'OR';
            }
            $rules_build.= $rule.' '.$operation.' '.$option.' '.$condition.' ';
        }
    }
    #Remove last OR/AND
    $last_OR_pos = strrpos($rules_build, "OR");
    $last_AND_pos = strrpos($rules_build, "AND");
    $rules = ($last_AND_pos > $last_OR_pos) ? substr($rules_build, 0, $last_AND_pos-1) : substr($rules_build, 0, $last_OR_pos-1);
    #$rules.=';';
}
  
//echo "profile_save_name=$profile_save_name<br>\n";
  profile_save($profile_save_name, $_POST['profile'], $checked_ids, $rules);
  if( $_POST['profile']['default_profile']=='1' ) {
    profile_save('default', $_POST['profile'], $checked_ids, $rules);
  }
  $messageStack->add('Profile saved', 'ready');
}


if($_GET['del_sel_profile']!=''){     // del profile
  profile_delete($_GET['del_sel_profile']);
}


$profile_name = $_GET['profile_name'];
if( $profile_name=='' ) {
  if( $profile_save_name!='' ) {
    $profile_name=$profile_save_name; 
  } else {
    $profile_name='default';
  }
};



$p=profile_load_n($profile_name);
$rules = $p['rules'];
if($rules != ''){
    $rules_array = explode(' ', $rules);
    $rules_groups = array_chunk($rules_array, 4);
    $grouped = array();
    var_dump($rules_array);
    foreach($rules_groups as $group){
        $operation = 0;
        if($group[1] == '!='){
            $operation = 1;
        }
        $condition = 0;
        if($group[3] == 'OR'){
            $condition = 1;
        }
        $and_or = $group[1];
        
        $grouped[$group[0]]=array($operation, $group[2], $condition);     
    }
}
if( $p['profile_parameter_arr']['profile_name']=='' ) {
  $profile=default_profile();
  $profile_name='default';
} else {
  $profile = $p['profile_parameter_arr'];
}


if( isset($_POST['preview']) ) { 
  generate_bill($_POST['example_order_id']);
}


$languages_arr=get_languages();
//echo "<pre>"; print_r($languages_arr); echo "</pre>";
foreach( $languages_arr as $lang ) {
  if( $lang['default']==1 ) {
    $default_language=$lang;
  }
}

require (DIR_WS_INCLUDES.'head.php');

?>

<link rel="stylesheet" type="text/css" href="includes/ipdfbill/pdfbill.css">
<script type="text/javascript" src="includes/ipdfbill/movablewindow.js" language="javascript1.2"></script>
<script language="javascript" type="text/javascript">

function toggle_column() {
  var el = document.getElementById('tag_column').style;
  if (el.display == 'none') {
    el.display = 'block';
  } else {
    el.display = 'none';
  }
}
</script>
<script language="javascript" type="text/javascript">
<!-- 

 
  function SuchenUndErsetzen(QuellText, SuchText, ErsatzText){   // Erstellt von Ralf Pfeifer
    // Fehlerpruefung
    if ((QuellText == null) || (SuchText == null))           { return null; }
    if ((QuellText.length == 0) || (SuchText.length == 0))   { return QuellText; }

    // Kein ErsatzText ?
    if ((ErsatzText == null) || (ErsatzText.length == 0))    { ErsatzText = ""; }

    var LaengeSuchText = SuchText.length;
    var LaengeErsatzText = ErsatzText.length;
    var Pos = QuellText.indexOf(SuchText, 0);

    while (Pos >= 0)
    {
        QuellText = QuellText.substring(0, Pos) + ErsatzText + QuellText.substring(Pos + LaengeSuchText);
        Pos = QuellText.indexOf(SuchText, Pos + LaengeErsatzText);
    }
    return QuellText;
  }
  
  
  function product_hex_farbe_zeigen(A, name){
    if (A.length == 7) {
      A = SuchenUndErsetzen(A, '#', '')  
    }
    if (A.length == 6) {
      document.getElementById("hex_"+name).style.backgroundColor=A;
    }
  } 
    
//-->
</script>
<link rel="stylesheet" href="includes/ipdfbill/js_color_picker_v2.css" media="screen">
<script type="text/javascript" src="includes/ipdfbill/color_functions.js"></script>
<script type="text/javascript" src="includes/ipdfbill/js_color_picker_v2.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
   
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top">
        <table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="pageHeadingBill" rowspan="2" width="1%"><img border="0" src="includes/ipdfbill/images/pdf_logo.gif" width="44" height="41" vspace="10"></td>
                <td class="pageHeadingBill" rowspan="2" >&nbsp;<?php echo $texts['headline'] ?><br />&nbsp;<span class="BillSavedProfiles"><?php echo IPDFBILL_VERSION.' ('.IPDFBILL_DATE.')'; ?></span>&nbsp;</td>
            <td class="pageHeading" align="right"><?php echo xtc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
              </tr>
      
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><div class="createCat"><a id="HideShowColumn" onFocus="if(this.blur)this.blur()" href="javascript:void(0);" onclick="toggle_column()" class='btn btn-default'>Men&uuml;</a><div style="float:left;padding-top:4px;font-weight:bold;letter-spacing: 1px;"><?php echo PDFBILL_LOADED_PROFILE.'</div><div style="padding-top:4px">'.$profile_name ?></div><div style="clear:left"></div></div></td>
        </tr>
              <tr class="dataTableHeadingRow">
                
      
      

      <table  width="100%" cellspacing="0" cellpadding="0" class="BillOuterTable">
        <tr>
          <td width="90%" class="BillOuterTd">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        
<?php
/*
  reset($languages_arr);
  foreach( $languages_arr as $lang ) {
    echo $lang['name'].'  ';
  }
*/    
?>      <td valign="top" class="BillSavedProfiles" width="7%"><?php echo PDFBILL_LOAD_PROFILE; ?></td>
  <td>
<?php  
      $profile_list = profile_list();
      asort($profile_list);
      
      foreach( $profile_list as $p ) {
        ?>
            <a id="SelectCat" onFocus="if(this.blur)this.blur()" class='btn btn-default' href="<?php echo $PHP_SELF?>?profile_name=<?php echo $p['profile_name'] ?>">
              <?php echo $p['profile_name'] ?>
            </a>
            
            <?php if( $p['profile_name']!='default' ) {  ?>
            <a id="btnDelProfile" onFocus="if(this.blur)this.blur()" href="<?php echo $PHP_SELF?>?del_sel_profile=<?php echo $p['profile_id'] ?>"><img border="0" src="includes/ipdfbill/images/btnDelete.gif" width="17" height="17" alt="Profil l�schen" title="Profil l�schen" /></a>
            <?php }  ?>
            
        <?php
      }  
     
?>  
    <button onclick="javascript:ShowInputs();" id="selected" type="button" class="btn btn-default btn-sm glyphicon glyphicon-plus"></button>
    <?php echo xtc_draw_form('new_pdfbill_profile', 'pdfbill_config.php', '', 'post', 'style="display: inline-block;"');?>
      
        <input id="showtext" class="form-control" style="display:none" type="text" name="new_profile_name" autocomplete="false"/>
        <input id="showsubmit" class="btn btn-default" style="display:none;" type="submit" value="<?php echo TEXT_SUBMIT_NEW_PROFILE; ?>"/>
    </form>
            
      </td>
    </tr>    
    
    </tr>
 </table></tr>
 </table>
    
</tr>
<?php
/*
  reset($languages_arr);
  foreach( $languages_arr as $lang ) {
    echo $lang['name'].'  ';
  }
*/    
?>

    </table></td>

    </tr>
    </table></td>
    </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>

     
    <!--###-->
 <table  border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
      <td  class="BillMainOuterTd">
        <table cellspacing="0" cellpadding="0" width="100%">
          <tr>
            <form name="pdfkatalog" <?php echo 'action="' . xtc_href_link('pdfbill_config.php', '', 'NONSSL') . '"'; ?> method="post">
            <td class="BillMainOuterDiv" >
    
    
    
    <table  border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class='col-xs-12'>
        <div class='col-xs-12 col-sm-3'><div><img border="0" src="includes/ipdfbill/images/schema_01_top.png" width="190" height="234"></div><div class="gallerycontainerTop"><a class="thumbnail" href="#thumb"><img style="border:0px" src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_01_top_big.png" /></span></a></div></div>
        <div class='hidden-sm hidden-lg hidden-md' style='padding-top:10px; padding-bottom: 10px;'> - - - - - - - - - - - - - - - - - - - - - - - - - - - -  </div>
        <div class='col-xs-12 col-sm-3'><div><img border="0" src="includes/ipdfbill/images/schema_02_top.png" width="190" height="234"></div><div class="gallerycontainerTop"><a class="thumbnail" href="#thumb"><img style="border:0px" src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_02_top_big.png" /></span></a></div></div>
        <div class='hidden-sm hidden-lg hidden-md' style='padding-top:10px; padding-bottom: 10px;'> - - - - - - - - - - - - - - - - - - - - - - - - - - - -  </div>
        <div class='col-xs-12 col-sm-3'><div><img border="0" src="includes/ipdfbill/images/schema_03_top.png" width="190" height="236"></div><div class="gallerycontainerTop"><a class="thumbnail" href="#thumb"><img style="border:0px" src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_03_top_big.png" /></span></a></div></div>
        </div>
       </td>
    </tr>
    
<?php
// ------------------------------------------------------------------------------------------------------
//    main options
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['profile_options'];
  
  tr_headline( $texts_tmp['headline'] );
  tr_singlecheck(     'pdfdebug',           $texts_tmp['pdfdebug'],         $profile['pdfdebug']          );
  tr_singlecheck(     'grids',              $texts_tmp['grids'],            $profile['grids']             );


  
// ------------------------------------------------------------------------------------------------------
//   bgimage (10)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['bgimage'];
  $fn = 'bgimage';
  
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_10.png" border="0" width="150" height="91" alt="Hintergrund"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_10_big.png" /></span></a></div>

      </td>
    </tr>
<?php
  tr_display(     $fn.'_display',      $texts_tmp[$fn.'_display'],    $profile[$fn.'_display']     );
  tr_image_select($fn.'_image',        $texts_tmp[$fn.'_image'],      $profile[$fn.'_image']     );


// ------------------------------------------------------------------------------------------------------
//   headtext (5)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['headtext'];
  $fn = 'headtext';
    
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img  src="includes/ipdfbill/images/schema_5.png" border="0" width="150" height="91" alt="Kopftext"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_5_big.png" /></span></a></div>
      </td>
    </tr>
<?php

  tr_display(     $fn.'_display',      $texts_tmp[$fn.'_display'],    $profile[$fn.'_display']     );
//  tr_input(       $fn.'_text',         $texts_tmp[$fn.'_text'],       $profile[$fn.'_text'], 40  );
  tr_textarea(    $fn.'_text',         $texts_tmp[$fn.'_text'],       $profile[$fn.'_text'], 40  );
  tr_align(       $fn.'_position',     $texts_tmp[$fn.'_position'],   $profile[$fn.'_position']    );
  tr_color(       $fn.'_font_color',   $texts_tmp[$fn.'_font_color'], $profile[$fn.'_font_color']  );
  tr_font_type(   $fn.'_font_type',    $texts_tmp[$fn.'_font_type'],  $profile[$fn.'_font_type']   );
  tr_font_style(  $fn.'_font_style',   $texts_tmp[$fn.'_font_style'], $profile[$fn.'_font_style']  );
  tr_font_size(   $fn.'_font_size',    $texts_tmp[$fn.'_font_size'],  $profile[$fn.'_font_size']   );
  tr_dimensions(  $fn.'_horizontal',
                  $fn.'_vertical',
                  $fn.'_width',
                  $fn.'_height',
                                                $texts_tmp[$fn.'_dimensions'],
                                                                                        $profile[$fn.'_horizontal'],
                                                                                        $profile[$fn.'_vertical'],
                                                                                        $profile[$fn.'_width'],
                                                                                        $profile[$fn.'_height']        );
// ------------------------------------------------------------------------------------------------------
//   addressblock (1)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['addressblock'];
  $fn = 'addressblock';
    
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_1.png" border="0" width="150" height="91" alt="Addressblock"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_1_big.png" /></span></a></div>
      
      </td>
    </tr>
<?php
  tr_display(     $fn.'_display',      $texts_tmp[$fn.'_display'],    $profile[$fn.'_display']     );

  tr_trennzeile(  $texts_tmp[$fn.'_trenn'] );
  tr_input(       $fn.'_text',         $texts_tmp[$fn.'_text'],       $profile[$fn.'_text'], 40    );
  tr_align(       $fn.'_position',     $texts_tmp[$fn.'_position'],   $profile[$fn.'_position']    );
  tr_color(       $fn.'_font_color',   $texts_tmp[$fn.'_font_color'], $profile[$fn.'_font_color']  );
  tr_font_type(   $fn.'_font_type',    $texts_tmp[$fn.'_font_type'],  $profile[$fn.'_font_type']   );
  tr_font_style(  $fn.'_font_style',   $texts_tmp[$fn.'_font_style'], $profile[$fn.'_font_style']  );
  tr_font_size(   $fn.'_font_size',    $texts_tmp[$fn.'_font_size'],  $profile[$fn.'_font_size']   );

  tr_trennzeile(  $texts_tmp[$fn.'_trenn2'] );
  tr_align(       $fn.'_position2',     $texts_tmp[$fn.'_position2'],   $profile[$fn.'_position2']    );
  tr_color(       $fn.'_font_color2',   $texts_tmp[$fn.'_font_color2'], $profile[$fn.'_font_color2']  );
  tr_font_type(   $fn.'_font_type2',    $texts_tmp[$fn.'_font_type2'],  $profile[$fn.'_font_type2']   );
  tr_font_style(  $fn.'_font_style2',   $texts_tmp[$fn.'_font_style2'], $profile[$fn.'_font_style2']  );
  tr_font_size(   $fn.'_font_size2',    $texts_tmp[$fn.'_font_size2'],  $profile[$fn.'_font_size2']   );

  tr_dimensions(  $fn.'_horizontal',
                  $fn.'_vertical',
                  $fn.'_width',
                  $fn.'_height',
                                                $texts_tmp[$fn.'_dimensions'],
                                                                                        $profile[$fn.'_horizontal'],
                                                                                        $profile[$fn.'_vertical'],
                                                                                        $profile[$fn.'_width'],
                                                                                        $profile[$fn.'_height']       , 'XYW' );

// ------------------------------------------------------------------------------------------------------
//   image (3)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['image'];
  $fn = 'image';
  
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_3.png" border="0" width="150" height="91" alt="Decobild"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_3_big.png" /></span></a>
      </div>
      </td>
    </tr>
<?php
  tr_display(     $fn.'_display',      $texts_tmp[$fn.'_display'],    $profile[$fn.'_display']     );
  tr_image_select($fn.'_image',        $texts_tmp[$fn.'_image'],      $profile[$fn.'_image']     );
  tr_dimensions(  $fn.'_horizontal',
                  $fn.'_vertical',
                  $fn.'_width',
                  $fn.'_height',
                                                $texts_tmp[$fn.'_dimensions'],
                                                                                        $profile[$fn.'_horizontal'],
                                                                                        $profile[$fn.'_vertical'],
                                                                                        $profile[$fn.'_width'],
                                                                                        $profile[$fn.'_height']        );

// ------------------------------------------------------------------------------------------------------
//   datafields (9)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['datafields'];
  $fn = 'datafields';
    
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_9.png" border="0" width="150" height="91" alt="Datenfelder"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_9_big.png" /></span></a></div>
      
      </td>
    </tr>
<?php
  tr_display(     $fn.'_display',      $texts_tmp[$fn.'_display'],    $profile[$fn.'_display']     );
  tr_trennzeile(  $texts_tmp[$fn.'_trenn1'] );
  tr_align(       $fn.'_position',     $texts_tmp[$fn.'_position'],   $profile[$fn.'_position']    );
  tr_color(       $fn.'_font_color',   $texts_tmp[$fn.'_font_color'], $profile[$fn.'_font_color']  );
  tr_font_type(   $fn.'_font_type',    $texts_tmp[$fn.'_font_type'],  $profile[$fn.'_font_type']   );
  tr_font_style(  $fn.'_font_style',   $texts_tmp[$fn.'_font_style'], $profile[$fn.'_font_style']  );
  tr_font_size(   $fn.'_font_size',    $texts_tmp[$fn.'_font_size'],  $profile[$fn.'_font_size']   );

  tr_trennzeile(  $texts_tmp[$fn.'_trenn2'] );
  tr_align(       $fn.'_position2',    $texts_tmp[$fn.'_position2'],   $profile[$fn.'_position2']    );
  tr_color(       $fn.'_font_color2',  $texts_tmp[$fn.'_font_color2'], $profile[$fn.'_font_color2']  );
  tr_font_type(   $fn.'_font_type2',   $texts_tmp[$fn.'_font_type2'],  $profile[$fn.'_font_type2']   );
  tr_font_style(  $fn.'_font_style2',  $texts_tmp[$fn.'_font_style2'], $profile[$fn.'_font_style2']  );
  tr_font_size(   $fn.'_font_size2',   $texts_tmp[$fn.'_font_size2'],  $profile[$fn.'_font_size2']   );


  tr_input_2l(      array( $fn.'_text_1', $fn.'_value_1' ),
                                               $texts_tmp[$fn.'_linetexts_1'],
                                                                 array( 'value_1'  => $profile[$fn.'_text_1'], 
                                                                        'value_2'  => $profile[$fn.'_value_1']  ), 
                    array( 20, 20 )
            );
  tr_input_2l(      array( $fn.'_text_2', $fn.'_value_2' ),
                                               $texts_tmp[$fn.'_linetexts_2'],
                                                                 array( 'value_1'  => $profile[$fn.'_text_2'], 
                                                                        'value_2'  => $profile[$fn.'_value_2']  ), 
                    array( 20, 20 )
            );
  tr_input_2l(      array( $fn.'_text_3', $fn.'_value_3' ),
                                               $texts_tmp[$fn.'_linetexts_3'],
                                                                 array( 'value_1'  => $profile[$fn.'_text_3'], 
                                                                        'value_2'  => $profile[$fn.'_value_3']  ), 
                    array( 20, 20 )
            );
  tr_input_2l(      array( $fn.'_text_4', $fn.'_value_4' ),
                                               $texts_tmp[$fn.'_linetexts_4'],
                                                                 array( 'value_1'  => $profile[$fn.'_text_4'], 
                                                                        'value_2'  => $profile[$fn.'_value_4']  ), 
                    array( 20, 20 )
            );
  tr_input_2l(      array( $fn.'_text_5', $fn.'_value_5' ),
                                               $texts_tmp[$fn.'_linetexts_5'],
                                                                 array( 'value_1'  => $profile[$fn.'_text_5'], 
                                                                        'value_2'  => $profile[$fn.'_value_5']  ), 
                    array( 20, 20 )
            );
  tr_input_2l(      array( $fn.'_text_6', $fn.'_value_6' ),
                                               $texts_tmp[$fn.'_linetexts_6'],
                                                                 array( 'value_1'  => $profile[$fn.'_text_6'], 
                                                                        'value_2'  => $profile[$fn.'_value_6']  ), 
                    array( 20, 20 )
            );
  tr_dimensions(  $fn.'_horizontal',
                  $fn.'_vertical',
                  $fn.'_width',
                  $fn.'_height',
                                                $texts_tmp[$fn.'_dimensions'],
                                                                                        $profile[$fn.'_horizontal'],
                                                                                        $profile[$fn.'_vertical'],
                                                                                        $profile[$fn.'_width'],
                                                                                        $profile[$fn.'_height']      , 'XYW'  );



// ------------------------------------------------------------------------------------------------------
//   billhead (4)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['billhead'];
  $fn = 'billhead';
    
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_4.png" border="0" width="150" height="91" alt="Rechnungs&uuml;berschrift"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_4_big.png" /></span></a></div>
      
      </td>
    </tr>
<?php
  tr_display(     $fn.'_display',      $texts_tmp[$fn.'_display'],    $profile[$fn.'_display']     );
  tr_input(       $fn.'_text',         $texts_tmp[$fn.'_text'],       $profile[$fn.'_text'], 40  );
  tr_align(       $fn.'_position',     $texts_tmp[$fn.'_position'],   $profile[$fn.'_position']    );
  tr_color(       $fn.'_font_color',   $texts_tmp[$fn.'_font_color'], $profile[$fn.'_font_color']  );
  tr_font_type(   $fn.'_font_type',    $texts_tmp[$fn.'_font_type'],  $profile[$fn.'_font_type']   );
  tr_font_style(  $fn.'_font_style',   $texts_tmp[$fn.'_font_style'], $profile[$fn.'_font_style']  );
  tr_font_size(   $fn.'_font_size',    $texts_tmp[$fn.'_font_size'],  $profile[$fn.'_font_size']   );
  tr_dimensions(  $fn.'_horizontal',
                  $fn.'_vertical',
                  $fn.'_width',
                  $fn.'_height',
                                                $texts_tmp[$fn.'_dimensions'],
                                                                                        $profile[$fn.'_horizontal'],
                                                                                        $profile[$fn.'_vertical'],
                                                                                        $profile[$fn.'_width'],
                                                                                        $profile[$fn.'_height'] );
                                                                                        


if( FREEE_INFO ) {
// ------------------------------------------------------------------------------------------------------
//   freeinfo (4a)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['freeinfo'];
  $fn = 'freeinfo';
    
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_4.png" border="0" width="150" height="91" alt="Rechnungs&uuml;berschrift"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_4_big.png" /></span></a></div>
      
      </td>
    </tr>
<?php
  tr_display(     $fn.'_display',      $texts_tmp[$fn.'_display'],    $profile[$fn.'_display']     );
  tr_input(       $fn.'_text',         $texts_tmp[$fn.'_text'],       $profile[$fn.'_text'], 40  );
  tr_align(       $fn.'_position',     $texts_tmp[$fn.'_position'],   $profile[$fn.'_position']    );
  tr_color(       $fn.'_font_color',   $texts_tmp[$fn.'_font_color'], $profile[$fn.'_font_color']  );
  tr_font_type(   $fn.'_font_type',    $texts_tmp[$fn.'_font_type'],  $profile[$fn.'_font_type']   );
  tr_font_style(  $fn.'_font_style',   $texts_tmp[$fn.'_font_style'], $profile[$fn.'_font_style']  );
  tr_font_size(   $fn.'_font_size',    $texts_tmp[$fn.'_font_size'],  $profile[$fn.'_font_size']   );
  tr_dimensions(  $fn.'_horizontal',
                  $fn.'_vertical',
                  $fn.'_width',
                  $fn.'_height',
                                                $texts_tmp[$fn.'_dimensions'],
                                                                                        $profile[$fn.'_horizontal'],
                                                                                        $profile[$fn.'_vertical'],
                                                                                        $profile[$fn.'_width'],
                                                                                        $profile[$fn.'_height'] );
                                                                                        
            

}
                                                                                        
// ------------------------------------------------------------------------------------------------------
//   listhead (2)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['listhead'];
  $fn = 'listhead';
    
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_2.png" border="0" width="150" height="91" alt="Listen�berschrift"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_2_big.png" /></span></a></div>
      
      </td>
    </tr>
<?php
  tr_display(     $fn.'_display',      $texts_tmp[$fn.'_display'],    $profile[$fn.'_display']     );
  tr_input(       $fn.'_text',         $texts_tmp[$fn.'_text'],       $profile[$fn.'_text'], 40  );
  tr_color(       $fn.'_font_color',   $texts_tmp[$fn.'_font_color'], $profile[$fn.'_font_color']  );
  tr_font_type(   $fn.'_font_type',    $texts_tmp[$fn.'_font_type'],  $profile[$fn.'_font_type']   );
  tr_font_style(  $fn.'_font_style',   $texts_tmp[$fn.'_font_style'], $profile[$fn.'_font_style']  );
  tr_font_size(   $fn.'_font_size',    $texts_tmp[$fn.'_font_size'],  $profile[$fn.'_font_size']   );
  tr_dimensions(  $fn.'_horizontal',
                  $fn.'_vertical',
                  $fn.'_width',
                  $fn.'_height',
                                                $texts_tmp[$fn.'_dimensions'],
                                                                                        $profile[$fn.'_horizontal'],
                                                                                        $profile[$fn.'_vertical'],
                                                                                        $profile[$fn.'_width'],
                                                                                        $profile[$fn.'_height']       );
// ------------------------------------------------------------------------------------------------------
//   poslist (7)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['poslist'];
  $fn = 'poslist';
    
  tr_headline( $texts_tmp['headline'] );  
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_7.png" border="0" width="150" height="91" alt="Positionslisten"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_7_big.png" /></span></a></div>
      
      </td>
    </tr>
<?php
  tr_color(       $fn.'_font_color',   $texts_tmp[$fn.'_font_color'], $profile[$fn.'_font_color']  );
  tr_font_type(   $fn.'_font_type',    $texts_tmp[$fn.'_font_type'],  $profile[$fn.'_font_type']   );
  tr_font_style(  $fn.'_font_style',   $texts_tmp[$fn.'_font_style'], $profile[$fn.'_font_style']  );
  tr_font_size(   $fn.'_font_size',    $texts_tmp[$fn.'_font_size'],  $profile[$fn.'_font_size']   );
  tr_input_3s_ml( array( array( $fn.'_head_1', $fn.'_value_1', $fn.'_width_1', $fn.'_align_1' ),
                         array( $fn.'_head_2', $fn.'_value_2', $fn.'_width_2', $fn.'_align_2' ),
                         array( $fn.'_head_3', $fn.'_value_3', $fn.'_width_3', $fn.'_align_3' ),
                         array( $fn.'_head_4', $fn.'_value_4', $fn.'_width_4', $fn.'_align_4' ),
                         array( $fn.'_head_5', $fn.'_value_5', $fn.'_width_5', $fn.'_align_5' ),
                         array( $fn.'_head_6', $fn.'_value_6', $fn.'_width_6', $fn.'_align_6' ),
                         array( $fn.'_head_7', $fn.'_value_7', $fn.'_width_7', $fn.'_align_7' )
                       ),
                  $texts_tmp[$fn.'_texts'],
                  array( array( $profile[$fn.'_head_1'],  $profile[$fn.'_value_1'],  $profile[$fn.'_width_1'],  $profile[$fn.'_align_1'] ),
                         array( $profile[$fn.'_head_2'],  $profile[$fn.'_value_2'],  $profile[$fn.'_width_2'],  $profile[$fn.'_align_2'] ),
                         array( $profile[$fn.'_head_3'],  $profile[$fn.'_value_3'],  $profile[$fn.'_width_3'],  $profile[$fn.'_align_3'] ),
                         array( $profile[$fn.'_head_4'],  $profile[$fn.'_value_4'],  $profile[$fn.'_width_4'],  $profile[$fn.'_align_4'] ),
                         array( $profile[$fn.'_head_5'],  $profile[$fn.'_value_5'],  $profile[$fn.'_width_5'],  $profile[$fn.'_align_5'] ),
                         array( $profile[$fn.'_head_6'],  $profile[$fn.'_value_6'],  $profile[$fn.'_width_6'],  $profile[$fn.'_align_6'] ),
                         array( $profile[$fn.'_head_7'],  $profile[$fn.'_value_7'],  $profile[$fn.'_width_7'],  $profile[$fn.'_align_7'] )
                       ),  
                  array( 20, 20, 5 )
               );
  tr_dimensions(  $fn.'_horizontal',
                  $fn.'_vertical',
                  $fn.'_width',
                  $fn.'_height',
                                                $texts_tmp[$fn.'_dimensions'],
                                                                                        $profile[$fn.'_horizontal'],
                                                                                        $profile[$fn.'_vertical'],
                                                                                        $profile[$fn.'_width'],
                                                                                        $profile[$fn.'_height']      , 'XY'  );
 
// ------------------------------------------------------------------------------------------------------
//   resumefields (12)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['resumefields'];
  $fn = 'resumefields';
    
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_12.png" border="0" width="150" height="91" alt="Summenfelder"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_12_big.png" /></span></a></div>
      
      </td>
    </tr>
<?php
  tr_display(     $fn.'_display',      $texts_tmp[$fn.'_display'],    $profile[$fn.'_display']     );

  tr_trennzeile(  $texts_tmp[$fn.'_trenn1'] );
  tr_align(       $fn.'_position',     $texts_tmp[$fn.'_position'],   $profile[$fn.'_position']    );
  tr_color(       $fn.'_font_color',   $texts_tmp[$fn.'_font_color'], $profile[$fn.'_font_color']  );
  tr_font_type(   $fn.'_font_type',    $texts_tmp[$fn.'_font_type'],  $profile[$fn.'_font_type']   );
  tr_font_style(  $fn.'_font_style',   $texts_tmp[$fn.'_font_style'], $profile[$fn.'_font_style']  );
  tr_font_size(   $fn.'_font_size',    $texts_tmp[$fn.'_font_size'],  $profile[$fn.'_font_size']   );

  tr_trennzeile(  $texts_tmp[$fn.'_trenn2'] );
  tr_align(       $fn.'_position2',    $texts_tmp[$fn.'_position2'],   $profile[$fn.'_position2']    );
  tr_color(       $fn.'_font_color2',  $texts_tmp[$fn.'_font_color2'], $profile[$fn.'_font_color2']  );
  tr_font_type(   $fn.'_font_type2',   $texts_tmp[$fn.'_font_type2'],  $profile[$fn.'_font_type2']   );
  tr_font_style(  $fn.'_font_style2',  $texts_tmp[$fn.'_font_style2'], $profile[$fn.'_font_style2']  );
  tr_font_size(   $fn.'_font_size2',   $texts_tmp[$fn.'_font_size2'],  $profile[$fn.'_font_size2']   );

  tr_dimensions(  $fn.'_horizontal',
                  $fn.'_vertical',
                  $fn.'_width',
                  $fn.'_height',
                                                $texts_tmp[$fn.'_dimensions'],
                                                                                        $profile[$fn.'_horizontal'],
                                                                                        $profile[$fn.'_vertical'],
                                                                                        $profile[$fn.'_width'],
                                                                                        $profile[$fn.'_height']      , 'XYW'  );


// ------------------------------------------------------------------------------------------------------
//   subtext (8)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['subtext'];
  $fn = 'subtext';
    
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_8.png" border="0" width="150" height="91" alt="Untertext"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_8_big.png" /></span></a></div>
      
      </td>
    </tr>
<?php
  tr_display(     $fn.'_display',      $texts_tmp[$fn.'_display'],    $profile[$fn.'_display']     );
  tr_display_comments(     $fn.'_display_comments',      $texts_tmp[$fn.'_display_comments'],    $profile[$fn.'_display_comments']     );
  tr_textarea(    $fn.'_text',         $texts_tmp[$fn.'_text'],       $profile[$fn.'_text'], 40  );
  tr_align(       $fn.'_position',     $texts_tmp[$fn.'_position'],   $profile[$fn.'_position']    );
  tr_color(       $fn.'_font_color',   $texts_tmp[$fn.'_font_color'], $profile[$fn.'_font_color']  );
  tr_font_type(   $fn.'_font_type',    $texts_tmp[$fn.'_font_type'],  $profile[$fn.'_font_type']   );
  tr_font_style(  $fn.'_font_style',   $texts_tmp[$fn.'_font_style'], $profile[$fn.'_font_style']  );
  tr_font_size(   $fn.'_font_size',    $texts_tmp[$fn.'_font_size'],  $profile[$fn.'_font_size']   );
  tr_dimensions(  $fn.'_horizontal',
                  $fn.'_vertical',
                  $fn.'_width',
                  $fn.'_height',
                                                $texts_tmp[$fn.'_dimensions'],
                                                                                        $profile[$fn.'_horizontal'],
                                                                                        $profile[$fn.'_vertical'],
                                                                                        $profile[$fn.'_width'],
                                                                                        $profile[$fn.'_height']        );
                                                                                        
// ------------------------------------------------------------------------------------------------------
//   footer (6)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['footer'];
  $fn = 'footer';
    
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_6.png" border="0" width="150" height="91" alt="Fusstexte"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_6_big.png" /></span></a></div>
      
      </td>
    </tr>
<?php
  tr_display(     $fn.'_display',      $texts_tmp[$fn.'_display'],    $profile[$fn.'_display']     );
  tr_color(       $fn.'_font_color',   $texts_tmp[$fn.'_font_color'], $profile[$fn.'_font_color']  );
  tr_font_type(   $fn.'_font_type',    $texts_tmp[$fn.'_font_type'],  $profile[$fn.'_font_type']   );
  tr_font_style(  $fn.'_font_style',   $texts_tmp[$fn.'_font_style'], $profile[$fn.'_font_style']  );
  tr_font_size(   $fn.'_font_size',    $texts_tmp[$fn.'_font_size'],  $profile[$fn.'_font_size']   );

  tr_display(     $fn.'_display_1',      $texts_tmp[$fn.'_display_1'],    $profile[$fn.'_display_1']     );
  tr_align(       $fn.'_position_1',     $texts_tmp[$fn.'_position_1'],   $profile[$fn.'_position_1']  );
  tr_textarea(    $fn.'_text_1',         $texts_tmp[$fn.'_text_1'],       $profile[$fn.'_text_1'], 40  );

  tr_display(     $fn.'_display_2',      $texts_tmp[$fn.'_display_2'],    $profile[$fn.'_display_2']     );
  tr_align(       $fn.'_position_2',     $texts_tmp[$fn.'_position_2'],   $profile[$fn.'_position_2']  );
  tr_textarea(    $fn.'_text_2',         $texts_tmp[$fn.'_text_2'],       $profile[$fn.'_text_2'], 40  );

  tr_display(     $fn.'_display_3',      $texts_tmp[$fn.'_display_3'],    $profile[$fn.'_display_3']     );
  tr_align(       $fn.'_position_3',     $texts_tmp[$fn.'_position_3'],   $profile[$fn.'_position_3']  );
  tr_textarea(    $fn.'_text_3',         $texts_tmp[$fn.'_text_3'],       $profile[$fn.'_text_3'], 40  );

  tr_display(     $fn.'_display_4',      $texts_tmp[$fn.'_display_4'],    $profile[$fn.'_display_4']     );
  tr_align(       $fn.'_position_4',     $texts_tmp[$fn.'_position_4'],   $profile[$fn.'_position_4']  );
  tr_textarea(    $fn.'_text_4',         $texts_tmp[$fn.'_text_4'],       $profile[$fn.'_text_4'], 40  );

                                                                                        




// ------------------------------------------------------------------------------------------------------
//   terms (11)
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['terms'];
  $fn = 'terms';
  
  tr_headline( $texts_tmp['headline'] );
?>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
        <div class="OuterDiv"><img src="includes/ipdfbill/images/schema_11.png" border="0" width="150" height="91" alt="Anlage"></div><div class="gallerycontainer"><a class="thumbnail" href="#thumb"><img src="includes/ipdfbill/images/zoom.gif" border="0" alt="zoom"><span><img src="includes/ipdfbill/images/schema_11_big.png" /></span></a></div>
      
      </td>
    </tr>
<?php
  tr_display(     $fn.'_display',         $texts_tmp[$fn.'_display'],         $profile[$fn.'_display']     );
  tr_input(       $fn.'_formtext',        $texts_tmp[$fn.'_formtext'],        $profile[$fn.'_formtext'], 40  );
  tr_align(       $fn.'_head_position',   $texts_tmp[$fn.'_head_position'],   $profile[$fn.'_head_position']    );
  tr_font_style(  $fn.'_head_font_style', $texts_tmp[$fn.'_head_font_style'], $profile[$fn.'_head_font_style']  );
  tr_font_size(   $fn.'_head_font_size',  $texts_tmp[$fn.'_head_font_size'],  $profile[$fn.'_head_font_size']   );
  tr_color(       $fn.'_font_color',           $texts_tmp[$fn.'_font_color'],           $profile[$fn.'_font_color']       );
  tr_font_type(   $fn.'_font_type',       $texts_tmp[$fn.'_font_type'],       $profile[$fn.'_font_type']   );
  tr_font_style(  $fn.'_font_style',      $texts_tmp[$fn.'_font_style'],      $profile[$fn.'_font_style']  );
  tr_font_size(   $fn.'_font_size',       $texts_tmp[$fn.'_font_size'],       $profile[$fn.'_font_size']   );

$conditions = array(
    array('id'=>'0', 'text'=> TEXT_AND),
    array('id'=>'1', 'text'=> TEXT_OR)
);
$operations = array(
    array('id'=>'0', 'text'=> TEXT_EQUAL),
    array('id'=>'1', 'text'=> TEXT_NOT_EQUAL)
);


  ?>
<tr>
    <td class="BillHeadLines" colspan="4">Regeln (12)</td>
</tr>
    <tr align="left">
      <td colspan="4" class="BilldataTableContent">
          <div class="col-xs-12">
              <p class="h3"><?php echo TEXT_SELECT_INVOICE_PROFILE; ?></p>
          </div>
        <!--  <div class="col-xs-12 table table-bordered">
            <div class="col-xs-12 row" style="font-weight:bold;">
                <div class="col-xs-1">Activate</div>
                <div class="col-xs-2">Selector</div>
                <div class="col-xs-3">Operation</div>
                <div class="col-xs-3">Value</div>
                <div class="col-xs-3">Conditions</div>
            </div>
            <div class="col-xs-12 row">
                <div class="col-xs-1"><?php /* echo xtc_draw_checkbox_field("rules[country][active]", '',((isset($grouped['country']))? 1 : 0)); ?></div>
                <div class="col-xs-2">Billing country</div>
                <div class="col-xs-3"><?php echo xtc_draw_pull_down_menu("rules[country][operation]", $operations,((isset($grouped['country']))? $grouped['country'][0] : 0)); ?></div>
                <div class="col-xs-3"><?php echo xtc_draw_input_field("rules[country][option]",((isset($grouped['country']))? $grouped['country'][1] : '')); ?></div>
                <div class="col-xs-3"><?php echo xtc_draw_pull_down_menu("rules[country][condition]", $conditions,((isset($grouped['country']))? $grouped['country'][2] : 0)); ?></div>
            </div>
              
            <div class="col-xs-12 row">
                <div class="col-xs-1"><?php echo xtc_draw_checkbox_field('rules[shipping][active]', '',((isset($grouped['shipping']))? 1 : 0)); ?></div>
                <div class="col-xs-2">Shipping method</div>
                <div class="col-xs-3"><?php echo xtc_draw_pull_down_menu('rules[shipping][operation]', $operations,((isset($grouped['shipping']))? $grouped['shipping'][0] : 0)); ?></div>
                <div class="col-xs-3"><?php echo xtc_draw_input_field('rules[shipping][option]',((isset($grouped['shipping']))? $grouped['shipping'][1] : '')); ?></div>
                <div class="col-xs-3"><?php echo xtc_draw_pull_down_menu('rules[shipping][condition]', $conditions,((isset($grouped['shipping']))? $grouped['shipping'][2] : 0)); ?></div>
            </div>
              
            <div class="col-xs-12 row">
                <div class="col-xs-1"><?php echo xtc_draw_checkbox_field('rules[payment][active]', '',((isset($grouped['payment']))? 1 : 0)); ?></div>
                <div class="col-xs-2">Payment method</div>
                <div class="col-xs-3"><?php echo xtc_draw_pull_down_menu('rules[payment][operation]', $operations,((isset($grouped['payment']))? $grouped['payment'][0] : 0)); ?></div>
                <div class="col-xs-3"><?php echo xtc_draw_input_field('rules[payment][option]',((isset($grouped['payment']))? $grouped['payment'][1] : '')); ?></div>
                <div class="col-xs-3"><?php echo xtc_draw_pull_down_menu('rules[payment][condition]', $conditions,((isset($grouped['payment']))? $grouped['payment'][2] : 0)); ?></div>
            </div>
              
            <div class="col-xs-12 row">
                <div class="col-xs-1"><?php echo xtc_draw_checkbox_field('rules[order][active]', '',((isset($grouped['order']))? 1 : 0)); ?></div>
                <div class="col-xs-2">Order status</div>
                <div class="col-xs-3"><?php echo xtc_draw_pull_down_menu('rules[order][operation]', $operations,((isset($grouped['order']))? $grouped['order'][0] : 0)); ?></div>
                <div class="col-xs-3"><?php echo xtc_draw_input_field('rules[order][option]',((isset($grouped['order']))? $grouped['order'][1] : '')); ?></div>
                <div class="col-xs-3"><?php echo xtc_draw_pull_down_menu('rules[order][condition]', $conditions,((isset($grouped['order']))? $grouped['order'][2] : 0)); ?></div>
            </div>

            <div class="col-xs-12 row">
                <div class="col-xs-1"><?php echo xtc_draw_checkbox_field('rules[customer][active]', '',((isset($grouped['customer']))? 1 : 0)); ?></div>
                <div class="col-xs-2">Customers status</div>
                <div class="col-xs-3"><?php echo xtc_draw_pull_down_menu('rules[customer][operation]', $operations,((isset($grouped['customer']))? $grouped['customer'][0] : 0)); ?></div>
                <div class="col-xs-3"><?php echo xtc_draw_input_field('rules[customer][option]',((isset($grouped['customer']))? $grouped['customer'][1] : '')); ?></div>
                <div class="col-xs-3"><?php echo xtc_draw_pull_down_menu('rules[customer][condition]', $conditions,((isset($grouped['customer']))? $grouped['customer'][2] : 0));*/ ?></div>
            </div>
            </div> -->
          
            <div class="col-xs-12 table table-bordered">
            <div class="col-xs-12 col-md-4  row" style="font-weight:bold; border-left:1px solid #bab9b9"  >
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_ACTIVATE; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_checkbox_field("rules[country][active]", '',((isset($grouped['country']))? 1 : 0)); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_SELECTOR; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo TEXT_BILLING_COUNTRY; ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_OPERATION; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_pull_down_menu("rules[country][operation]", $operations,((isset($grouped['country']))? $grouped['country'][0] : 0)); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_VALUE; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_input_field("rules[country][option]",((isset($grouped['country']))? $grouped['country'][1] : '')); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_CONDITIONS; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_pull_down_menu("rules[country][condition]", $conditions,((isset($grouped['country']))? $grouped['country'][2] : 0)); ?></div>
                </div>
            </div>
                <div class="col-xs-12 hidden-lg hidden-md" style="border-bottom:1px solid #bab9b9; margin-top:10px; margin-bottom: 10px;"></div> 
            <div class="col-xs-12 col-md-4 row" style="font-weight:bold; border-left:1px solid #bab9b9">
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_ACTIVATE; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_checkbox_field('rules[shipping][active]', '',((isset($grouped['shipping']))? 1 : 0)); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_SELECTOR; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo TEXT_SHIPPING_METHOD; ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_OPERATION; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_pull_down_menu('rules[shipping][operation]', $operations,((isset($grouped['shipping']))? $grouped['shipping'][0] : 0)); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_VALUE; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_input_field('rules[shipping][option]',((isset($grouped['shipping']))? $grouped['shipping'][1] : '')); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_CONDITIONS; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_pull_down_menu('rules[shipping][condition]', $conditions,((isset($grouped['shipping']))? $grouped['shipping'][2] : 0)); ?></div>
                </div>
            </div>
                <div class="col-xs-12 hidden-lg hidden-md" style="border-bottom:1px solid #bab9b9;margin-top:10px; margin-bottom: 10px;"></div> 
            <div class="col-xs-12 col-md-4 row" style="font-weight:bold; border-left:1px solid #bab9b9">
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_ACTIVATE; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_checkbox_field('rules[payment][active]', '',((isset($grouped['payment']))? 1 : 0)); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_SELECTOR; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo TEXT_PAYMENT_METHOD; ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_OPERATION; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_pull_down_menu('rules[payment][operation]', $operations,((isset($grouped['payment']))? $grouped['payment'][0] : 0)); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_VALUE; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_input_field('rules[payment][option]',((isset($grouped['payment']))? $grouped['payment'][1] : '')); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_CONDITIONS; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_pull_down_menu('rules[payment][condition]', $conditions,((isset($grouped['payment']))? $grouped['payment'][2] : 0)); ?></div>
                </div>
            </div>
                <div class="col-xs-12" style="border-bottom:1px solid #bab9b9;margin-top:10px; margin-bottom: 10px;"></div> 
            <div class="col-xs-12 col-md-6 row" style="font-weight:bold; border-left:1px solid #bab9b9">
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_ACTIVATE; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_checkbox_field('rules[order][active]', '',((isset($grouped['order']))? 1 : 0)); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_SELECTOR; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo TEXT_ORDER_STATUS; ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_OPERATION; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_pull_down_menu('rules[order][operation]', $operations,((isset($grouped['order']))? $grouped['order'][0] : 0)); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_VALUE; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_input_field('rules[order][option]',((isset($grouped['order']))? $grouped['order'][1] : '')); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_CONDITIONS; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_pull_down_menu('rules[order][condition]', $conditions,((isset($grouped['order']))? $grouped['order'][2] : 0)); ?></div>
                </div>
            </div>
                <div class="col-xs-12 hidden-lg hidden-md" style="border-bottom:1px solid #bab9b9;margin-top:10px; margin-bottom: 10px;"></div> 
            <div class="col-xs-12 col-md-6 row" style="font-weight:bold; border-left:1px solid #bab9b9">
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_ACTIVATE; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_checkbox_field('rules[customer][active]', '',((isset($grouped['customer']))? 1 : 0)); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_SELECTOR; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo TEXT_CUSTOMERS_STATUS; ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_OPERATION; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_pull_down_menu('rules[customer][operation]', $operations,((isset($grouped['customer']))? $grouped['customer'][0] : 0)); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_VALUE; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_input_field('rules[customer][option]',((isset($grouped['customer']))? $grouped['customer'][1] : '')); ?></div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6 col-sm-2 col-md-5"><?php echo TEXT_CONDITIONS; ?></div>
                    <div class="col-xs-6 col-sm-10 col-md-7"><?php echo xtc_draw_pull_down_menu('rules[customer][condition]', $conditions,((isset($grouped['customer']))? $grouped['customer'][2] : 0)); ?></div>
                </div>
            </div>
            </div>
          <div class="col-xs-12">
              <p class="small"><?php echo TEXT_MULTIPLE_OPTIONS; ?></p>
          </div>
      </td>
    </tr>
<?php
                                                                                        
// ------------------------------------------------------------------------------------------------------
//    profile_save
// ------------------------------------------------------------------------------------------------------
  $texts_tmp = $texts['profile_save'];
  
  tr_headline( $texts_tmp['headline'] );
  tr_check1( 'default_profile', $texts['default_profile'] );
  tr_radio_n( 'typeofbill', $texts['typeofbill'], $profile['typeofbill'], array('invoice', 'delivnote', 'reminder', '2ndreminder') );
  reset($languages_arr);
  $values=array();
  $i=1;
  foreach( $languages_arr as $lang ) {
    $values[]=$lang['code'];
    $texts['language']['text_'.$i]=$lang['name'];
    $i++;
  }
  
  tr_radio_n( 'languages_code', $texts['language'], $profile['languages_code'], $values);
  
  
  
  
  
  
?>
  <tr align="left">
     <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><input type="hidden" name="profile[profile_name]" value="<?php echo $profile_name; ?>"><input type="button" name="saveprofile" id="SelectColor" class="btn btn-default" onclick="pdfkatalog.submit();" value="<?php echo $texts['button_generate'] ?>"></div>
            <div class='col-xs-12 col-sm-11'>
      <input type="checkbox" name="preview"><?php echo $texts['preview_at_example'] ?> 
                        <select name="example_order_id" class="form-control">
<?php
  $oid_arr=order_nr_list();
  foreach( $oid_arr as $oid ) {
?>
           <option value="<?php echo $oid ?>"><?php echo $oid ?></option>
<?php
  }
?>
         </select><br />
<?php
/*
  echo PDFBILL_PROFILE_LANG;        
  reset($languages_arr);
  foreach( $languages_arr as $lang ) {
    $chk='';
    if( $profile_name==$lang['name'] ) {
      $chk=' checked';
    }
    echo '  <input type="radio"  name="profile_name" value="'.$lang['name'].'"'.$chk.'>'.$lang['name'].'&nbsp';
//    echo $lang['name'].'  ';
  }
  
*/  
  
  
?>
            </div>
	    <div class='col-xs-12'><br></div>
        </div>
      </th>
  </tr>
</table>
</td>
          </tr>
        </table>

      </td>
      </tr>
      </table>
      </form>
    </td>
  </tr>
</table>
<!-- body_text_eof //-->
<!-- body_eof //-->


<script type="text/javascript">
  colorfields = new Array( <?php echo "'".implode("','", $js_colorfields)."'" ?> );
      
  function chooseColor_display_color() {
      for( i=0; i<colorfields.length; i++) {
        o = document.getElementById(colorfields[i]);
        product_hex_farbe_zeigen( o.value, colorfields[i] );
      }
  }

  chooseColor_display_color();

</script> 




<!-- footer //-->
<?php 
  helpwindows();
  require(DIR_WS_INCLUDES . 'footer.php'); 
?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); 








function n2p( $name ) {
  
//  return $name;
  return "profile[$name]";
}


/*
  tr_headline( array( 'headline' => '5. W�hlen Sie die gew&uuml;nschten Optionen f�r die Anzeige der Produktnamen:' ) );
*/
function tr_headline( $text_arr ) {
?>
    <tr>
      <td colspan="4" class="BillHeadLines"><?php echo $text_arr['headline'] ?></td>
    </tr>
<?php
}  
  

  
/*
  tr_display( 'product_name',
               array( 'question' => 'Artikelname Anzeige',
                     'chk_text' => 'anzeigen' ),
              $profile_product_names 
            );
*/
function tr_check1( $fieldname, $text_arr, $check='0' ) {
  tr_display( $fieldname, $text_arr, $check );
}  
function tr_display( $fieldname, $text_arr, $check='0' ) {
  if( $check=='1' ) {
    $checked='checked ';
  }
?>
    <tr align="left">
      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question']; echo helpwindows_add($text_arr['help']); ?></div>
            <div class='col-xs-12 col-sm-11'><input type="checkbox" name="<?php echo n2p($fieldname) ?>" value="1" <?php  echo $checked ?>><?php echo $text_arr['chk_text'] ?></div>
            <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}


function tr_display_comments( $fieldname, $text_arr, $check='0' ) {
  if( $check=='1' ) {
    $checked='checked ';
  }
?>
    <tr align="left">
      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question']; echo helpwindows_add($text_arr['help']); ?></div>
            <div class='col-xs-12 col-sm-11'><input type="checkbox" name="<?php echo n2p($fieldname) ?>" value="1" <?php  echo $checked ?>><?php echo $text_arr['chk_text'] ?></div>
            <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}
/*
  tr_trennzeile( 'Absender:' );
            );
*/
function tr_trennzeile_xxx( $text ) {
?>
    <tr align="left">
      <th width="15%" class="BilldataTableContent"><?php echo $text; ?></th>
      <td colspan="3" class="BilldataTableContent">
        &nbsp;
      </td>
    </tr>
<?php
}

function tr_trennzeile( $text ) {
?>
    <tr align="left">
      <td class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
        ---------------------- <?php echo $text; ?> ------------------------------
	    <div class='col-xs-12'><br></div>
        </div>
      </td>
    </tr>
<?php
}


/*
  tr_align( 'product_names_position',
            array( 'question' => 'Ausrichtung:',
                   'chk_text_l' => 'Linksb&uuml;ndig',
                   'chk_text_c' => 'Zentriert',
                   'chk_text_r' => 'Rechtsb&uuml;ndig',
              ),
            $profile_product_names_position 
            );
*/
  
function tr_align(  $fieldname, $text_arr, $check ) {
  switch( $check ) {
    case 'L':
      $chk_l = 'checked';    break;
    case 'C':
      $chk_c = 'checked';    break;
    case 'R':
      $chk_r = 'checked';    break;
  }
?>
    <tr align="left">
      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question'] ?></div>
            <div class='col-xs-12 col-sm-11'>
                <input type="radio" class="radio-inline" name="<?php echo n2p($fieldname) ?>" value="L"
          <?php  echo $chk_l ?>>
          <?php echo $text_arr['chk_text_l'] ?>
                
                <input type="radio" class="radio-inline" name="<?php echo n2p($fieldname) ?>" value="C"
          <?php  echo $chk_c ?>>
          <?php echo $text_arr['chk_text_c'] ?>
                
                <input type="radio" class="radio-inline" name="<?php echo n2p($fieldname) ?>" value="R"
          <?php  echo $chk_r ?>>
          <?php echo $text_arr['chk_text_r'] ?>
            </div>
	    <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}

function tr_align4(  $fieldname, $text_arr, $check ) {
  switch( $check ) {
    case 'L':
      $chk_l = 'checked';    break;
    case 'C':
      $chk_c = 'checked';    break;
    case 'R':
      $chk_r = 'checked';    break;
    case 'J':
      $chk_j = 'checked';    break;
  }
?>
    <tr align="left">
      <th width="15%" class="BilldataTableContent"><?php echo $text_arr['question'] ?></th>
      <td width="10%" class="BilldataTableContent radio-inline">
        <input type="radio" name="<?php echo n2p($fieldname) ?>" value="L"
          <?php  echo $chk_l ?>>
          <?php echo $text_arr['chk_text_l'] ?>
      </td>
      <td width="10%" class="BilldataTableContent radio-inline">
        <input type="radio" name="<?php echo n2p($fieldname) ?>" value="C"
          <?php  echo $chk_c ?>>
          <?php echo $text_arr['chk_text_c'] ?>
      </td>
      <td class="BilldataTableContent radio-inline">
        <input type="radio" name="<?php echo n2p($fieldname) ?>" value="R"
          <?php  echo $chk_r ?>>
          <?php echo $text_arr['chk_text_r'] ?>
        &nbsp;&nbsp;
        <input type="radio" name="<?php echo n2p($fieldname) ?>" value="J"
          <?php  echo $chk_j ?>>
          <?php echo $text_arr['chk_text_j'] ?>
      </td>
    </tr>
<?php
}




/*
  tr_color( 'product_names_color',
            array( 'question'        => 'Schriftfarbe:',
                   'button_text'     => 'Ausw&auml;hlen' ),
            $profile_product_names 
            );
*/
  
function tr_color( $fieldname, $text_arr, $check ) {
  global $js_colorfields;
  global $profile;

  $js_colorfields[] = $fieldname;
?>
    <tr align="left">
      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question'] ?></div>
            <div class='col-xs-12 col-sm-11'>
        <div style="float:left;width:148px">
          <input type="button" id="SelectColor" value="<?php echo $text_arr['button_text'] ?>" 
            onclick="showColorPicker(this,document.forms['pdfkatalog'].<?php echo $fieldname ?>,'hex_'+'<?php echo $fieldname ?>')">
        </div>
         <div style="float:left;width:142px;padding-top:1px">
          <img src="includes/ipdfbill/images/spacer.gif" id="hex_<?php echo $fieldname ?>" width="80" height="20" style="border:1px solid #818181; background-color: <?php echo $check; ?>">
        </div>
         <div>
          <input type="text" class="bill" style="width:80px" size="8" value="<?php echo $check ?>" 
            name="<?php echo n2p($fieldname) ?>" id="<?php echo $fieldname ?>" 
            onBlur="product_hex_farbe_zeigen(document.forms['pdfkatalog'].<?php echo $fieldname ?>.value, '<?php echo $fieldname ?>')" 
            onKeyUp="product_hex_farbe_zeigen(document.forms['pdfkatalog'].<?php echo $fieldname ?>.value, '<?php echo $fieldname ?>')" 
            onfocus="product_hex_farbe_zeigen(document.forms['pdfkatalog'].<?php echo $fieldname ?>.value, '<?php echo $fieldname ?>')" 
            onchange="product_hex_farbe_zeigen(document.forms['pdfkatalog'].<?php echo $fieldname ?>.value, '<?php echo $fieldname ?>')">
        </div>
            </div>
	    <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}


/*
  tr_font_type( 'product_names_font_type',
                array( 'question'        => 'Schriftart:' ),
                $profile_product_names_font_type 
            );
*/
  
function tr_font_type( $fieldname, $text_arr, $check ) {
  switch( $check ) {
    case 'arial':
      $chk_1 = 'selected';    break;
    case 'times':
      $chk_2 = 'selected';    break;
    case 'helvetica':
      $chk_3 = 'selected';    break;
  }
?>
    <tr align="left">
      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question'] ?></div>
            <div class='col-xs-12 col-sm-11'>
              <select id="font" name="<?php echo n2p($fieldname) ?>" size="1" class="form-control">
           <option <?php  echo $chk_1 ?> value="arial">Arial</option>
           <option <?php  echo $chk_2 ?> value="times">Times New Roman</option>
           <option <?php  echo $chk_3 ?> value="helvetica">Helvetica</option>
         </select>
            </div>
	    <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}


/*
  tr_font_style( 'product_names_font_style',
                 array( 'question'        => 'Schriftstil:',
                        'text_bold'       => 'Fett' ),
                        'text_italic'     => 'Kursiv' ),
                        'text_underlined' => 'Unterstrichen' ),
                 $profile_product_names_font_style 
            );
*/
function tr_font_style( $fieldname, $text_arr, $check ) {
  if( is_array($check) ) {
    $check=implode('', $check);
  }
  if (strpos($check, "B") !== false)     $chk_b = 'checked';
  if (strpos($check, "I") !== false)     $chk_i = 'checked';
  if (strpos($check, "U") !== false)     $chk_u = 'checked';
?>
    <tr align="left">
        <th class="BilldataTableContent" colspan="4">
            <div class='col-xs-12'>
                <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question'] ?></div>
                <div class='col-xs-12 col-sm-11'>
        <input type="checkbox" name="<?php echo n2p($fieldname) ?>[0]" value="B" <?php  echo $chk_b ?>>
        <?php echo $text_arr['text_bold'] ?>
                    
        <input type="checkbox" name="<?php echo n2p($fieldname) ?>[1]" value="I" <?php  echo $chk_i ?>>
        <?php echo $text_arr['text_italic'] ?>
                    
        <input type="checkbox" name="<?php echo n2p($fieldname) ?>[2]" value="U" <?php  echo $chk_u ?>>
        <?php echo $text_arr['text_underlined'] ?>
                </div>
                <div class='col-xs-12'><br></div>
            </div>
        </th>
    </tr>
<?php
}




/*
  tr_font_size( 'product_names_font_size',
                 array( 'question'        => 'Schriftgr&ouml;&szlig;e:' ),
                 $profile_product_names_font_size 
            );
*/
function tr_font_size( $fieldname, $text_arr, $value ) {
?>
    <tr align="left">
        <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question'] ?></div>
            <div class='col-xs-12 col-sm-11'>
                
            <select id="FontSize" name="<?php echo n2p($fieldname) ?>" size="1" class="form-control">
<?php
  for($i=6; $i<=20; $i+=2 ) {
    $sel= $i==$value?'selected':'';
    echo "          <option value=\"$i\" $sel>$i</option>\n";
  }
?>
        </select>
            </div>
	    <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}


/*
  tr_image_select( 'image',
                   'Bilddatei:',
                   $profile_image 
            );
*/
function tr_image_select( $fieldname, $text, $default_file ) {
  $files=array();
  if ($dir= opendir(PDF_IMAGE_DIR)){
    while  (($file = readdir($dir)) !==false) {
      if (is_file(PDF_IMAGE_DIR.$file) and ($file !=".htaccess")) {
        $size=filesize(PDF_IMAGE_DIR.$file);
        $files[]=array( 'id' => $file,
                        'text' => $file.' | '.$size);
      }
    }
    closedir($dir);
  }
  
  
?>
    <tr align="left">
      <th colspan='4' class="BilldataTableContent">
    <div class='col-xs-12'>
        <div class='col-xs-12 col-sm-1'><?php echo $text ?></div>
        <div class='col-xs-12 col-sm-11'>
          <select name="<?php echo n2p($fieldname) ?>" size="1" class="form-control">
<?php
  foreach( $files as $f) {
    $sel= $f['id']==$default_file?'selected':'';
    echo "          <option value=\"".$f['id']."\" $sel>".$f['text']."</option>\n";
  }
?>
        </select>
        </div>
        <div class='col-xs-12'><br></div>
    </div>
        </th>
    </tr>
<?php
}



/*
  tr_followindexes( 'product_names_indexnumber',
                    'product_names_parent_indexnumber',
                    array( 'question'           => 'Bindungen:',
                           'indexnumber'        => 'Indexnummer',
                           'parent_indexnumber' => 'gebunden an vorhergehende Indexnummer' ),
                    $profile_product_names_indexnumber,
                    $profile_product_names_parent_indexnumber
            );
*/
function tr_followindexes( $fieldname_indexnumber, 
                           $fieldname_parent_indexnumber, 
                           $text_arr, 
                           $profile_product_names_indexnumber, 
                           $profile_product_names_parent_indexnumber ) {
?>
    <tr align="left">
      <th width="15%" class="BilldataTableContent"><?php echo $text_arr['question']; echo helpwindows_add($text_arr['help']); ?></th>
      <td colspan="3" class="BilldataTableContent"> 
        <div style="float:left;width:145px">
          <input class="bill" type="text" size="2" value="<?php echo $profile_product_names_indexnumber ?>" name="<?php echo n2p($fieldname_indexnumber) ?>"> 
          <?php echo $text_arr['indexnumber'] ?>
        </div>
        <div style="float:left">
          <input class="bill" type="text" size="2" value="<?php echo $profile_product_names_parent_indexnumber ?>" name="<?php echo n2p($fieldname_parent_indexnumber) ?>">
          <?php echo $text_arr['parent_indexnumber'] ?>
        </div>
      </td>
    </tr>
<?php
}










/*
  tr_dimensions( 'product_names_horizontal',
                 'product_names_vertical',
                 'product_names_width',
                 'product_names_height',
                 array( 'question'        => 'Verschiebung des Produktnamen:',
                        'pos_x'           => 'Horizontal',
                        'pos_y'           => 'Vertikal',
                        'width'           => 'Breite',
                        'height'          => 'H�he' ),
                 $profile_product_names_horizontal,
                 $profile_product_names_vertical,
                 0,
                 0 
            );
*/
function tr_dimensions( $fieldname_x, 
                        $fieldname_y, 
                        $fieldname_width, 
                        $fieldname_height, 
                        $text_arr, 
                        $pos_x, $pos_y, 
                        $width, $height, $xywh='XYWH' ) {
?>
    <tr align="left">
      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question']; echo helpwindows_add($text_arr['help']); ?></div>
            <div class='col-xs-12 col-sm-11'>
        <div style="float:left;width:145px">
<?php if(strpos($xywh, 'X')!==false) {  ?>
          <input class="bill" type="text" size="2" value="<?php echo $pos_x ?>" name="<?php echo n2p($fieldname_x) ?>"> 
          <?php echo $text_arr['pos_x'] ?>
<?php }  ?>&nbsp;
        </div>
        <div style="float:left;width:145px">
<?php if(strpos($xywh, 'Y')!==false) {  ?>
          <input class="bill" type="text" size="2" value="<?php echo $pos_y ?>" name="<?php echo n2p($fieldname_y) ?>">
          <?php echo $text_arr['pos_y'] ?>
<?php }  ?>&nbsp;
        </div>
        <div style="float:left;width:145px">
<?php if(strpos($xywh, 'W')!==false) {  ?>
          <input class="bill" type="text" size="2" value="<?php echo $width ?>" name="<?php echo n2p($fieldname_width) ?>">
          <?php echo $text_arr['width'] ?>
<?php }  ?>&nbsp;
        </div>
        <div style="float:left;width:145px">
<?php if(strpos($xywh, 'H')!==false) {  ?>
          <input class="bill" type="text" size="2" value="<?php echo $height ?>" name="<?php echo n2p($fieldname_height) ?>">
          <?php echo $text_arr['height'] ?>
<?php }  ?>&nbsp;
        </div>
            </div>
	    <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}



/*
  tr_dimensions_h( 'product_names_height',
                   array( 'question'        => 'Verschiebung des Produktnamen:',
                          'height'          => 'H�he' ),
                   $profile_product_names_height
              );
*/
function tr_dimensions_h( $fieldname_height, 
                          $text_arr, 
                          $height ) {
?>
    <tr align="left">
      <th width="15%" class="BilldataTableContent"><?php echo $text_arr['question'] ?></th>
      <td colspan="3" class="BilldataTableContent"> 
        <div style="float:left;width:145px">
          <input class="bill" type="text" size="2" value="<?php echo $height ?>" name="<?php echo n2p($fieldname_height) ?>">
          <?php echo $text_arr['height'] ?>
        </div>
      </td>
    </tr>
<?php
}


/*
  tr_radio2( 'product_price_tax',
              array( 'question'        => 'Preise:',
                     'text_1'          => 'Brutto Preise' ),
                     'text_2'          => 'Netto Preise' ),
              $profile_product_price_tax,
              array(1,0)
            );
*/

function tr_radio2( $fieldname, $text_arr, $check, $values=array(1,0) ) {
  if ( $check == $values[0] )      {    $chk_0 = 'checked'; }
  else if ( $check == $values[1] ) {    $chk_1 = 'checked'; }
  
  else                             {    $chk_0 = 'checked'; }
?>
    <tr align="left">
      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question'] ?></div>
            <div class='col-xs-12 col-sm-11'>
                <input type="radio" class='radio-inline' name="<?php echo n2p($fieldname) ?>" value="<?php echo $values[0] ?>" <?php echo $chk_0 ?>>
        <?php echo $text_arr['text_1'] ?>
                <input type="radio" class='radio-inline' name="<?php echo n2p($fieldname) ?>" value="<?php echo $values[1] ?>" <?php echo $chk_1 ?>>
        <?php echo $text_arr['text_2'] ?>
            </div>
	    <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}


function tr_radio_n( $fieldname, $text_arr, $check, $values=array() ) {
//echo "<pre>"; print_r($text_arr); echo "</pre>";
  
  $chk=array();
  for( $i=0; $i<sizeof($values); $i++ ) {
    if ( $check == $values[$i] )  {    
      $chk[$i] = ' checked'; 
      break;
    }
  }
  if( $i==sizeof($values) ) { // no default found 
    $chk[0] = ' checked';
  } 

?>
    <tr align="left">
      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question'] ?></div>
            <div class='col-xs-12 col-sm-11'>
<?php
  for( $i=0; $i<sizeof($values); $i++ ) {
?>
                          <input type="radio" class='radio-inline' name="<?php echo n2p($fieldname) ?>" value="<?php echo $values[$i] ?>" <?php echo $chk[$i] ?>>
        <?php echo $text_arr['text_'.($i+1)]; ?>
<?php
  }
?>
            </div>
	    <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}



/*
  tr_textarea( 'product_description_size',
                array( 'question'        => 'Zuschneidung des Textes:',
                       'fieldtext'       => 'Ab wieviel Zeichen soll abgeschnitten werden?' ),
                $profile_product_description_size,
             2
            );
*/
function tr_textarea( $fieldname, $text_arr, $value='', $size=2 ) {
?>
    <tr align="left">
      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question']; ?></div>
            <div class='col-xs-12 col-sm-11'>
                <textarea class="billarea form-control" name="<?php echo n2p($fieldname) ?>" cols="<?php echo $size ?>" rows="4"><?php echo $value ?></textarea>
        <?php echo $text_arr['fieldtext'] ?>
                
            </div>
            <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}



/*
  tr_input( 'product_description_size',
             array( 'question'        => 'Zuschneidung des Textes:',
                    'fieldtext'       => 'Ab wieviel Zeichen soll abgeschnitten werden?' ),
             $profile_product_description_size,
             2
            );
*/
function tr_input( $fieldname, $text_arr, $value='', $size=2 ) {
  if( isset($text_arr['help']) ) {
    $hw=helpwindows_add($text_arr['help']);
  }
  
  if ( $check == $values[0] )     $chk_0 = 'checked';
  if ( $check == $values[1] )     $chk_1 = 'checked';
?>
    <tr align="left">
      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question'].$hw; ?></div>
            <div class='col-xs-12 col-sm-11'>
        <input class="bill" type="text" size="<?php echo $size ?>" name="<?php echo n2p($fieldname) ?>" value="<?php echo $value ?>">
        <?php echo $text_arr['fieldtext'] ?>
            </div>
	    <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}




/*
  tr_input_2l( array( 'datafields_t1', 'datafields_v1' ),
               array( 'question'        => 'Datenzeile',
                      'fieldtext_1'     => 'Textvorsatz',
                      'fieldtext_2'     => 'Variable'       ),
               array( 'value_1'         => $profile_datafield_t1, 
                      'value_2'         => $profile_datafield_t2  ), 
               array( 40, 20 )
            );
*/
function tr_input_2l( $fieldname, $text_arr, $value=array(), $size=array() ) {
?>
    <tr align="left">
      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question']; echo helpwindows_add($text_arr['help']); ?></div>
            <div class='col-xs-12 col-sm-11'>
        <input class="bill" type="text" size="<?php echo $size[0] ?>" name="<?php echo n2p($fieldname[0]) ?>" value="<?php echo $value['value_1'] ?>">
        <?php echo $text_arr['fieldtext_1'] ?>

        <input class="bill" type="text" size="<?php echo $size[1] ?>" name="<?php echo n2p($fieldname[1]) ?>" value="<?php echo $value['value_2'] ?>">
        <?php echo $text_arr['fieldtext_2'] ?>
            </div>
	    <div class='col-xs-12'><br></div>
        </div>
      </th>
    </tr>
<?php
}



/*
  tr_input_3s_ml( array( array( 'poslist_head_1', 'poslist_value_1', 'poslist_width_1', 'poslist_align_1' ),
                         array( 'poslist_head_2', 'poslist_value_2', 'poslist_width_2', 'poslist_align_2' ),
                         array( 'poslist_head_3', 'poslist_value_3', 'poslist_width_3', 'poslist_align_3' ),
                         array( 'poslist_head_4', 'poslist_value_4', 'poslist_width_4', 'poslist_align_4' ),
                         array( 'poslist_head_5', 'poslist_value_5', 'poslist_width_5', 'poslist_align_5' )
                       ),
                  array( 'question'        => 'Datenspalte',
                         'text_a'          => '�berschrift',
                         'text_b'          => 'Wert',
                         'text_c'          => 'Breite',
                         'pos_left'        => 'links',
                         'pos_center'      => 'mitte',
                         'pos_right'       => 'rechts'
       ),
                  array( array( $profile_poslist_head_1,  $profile_poslist_value_1,  $poslist_width_1, $poslist_align_1 ),
                         array( $profile_poslist_head_2,  $profile_poslist_value_2,  $poslist_width_2, $poslist_align_2 ),
                         array( $profile_poslist_head_3,  $profile_poslist_value_3,  $poslist_width_3, $poslist_align_3 ),
                         array( $profile_poslist_head_4,  $profile_poslist_value_4,  $poslist_width_4, $poslist_align_4 ),
                         array( $profile_poslist_head_5,  $profile_poslist_value_5,  $poslist_width_5, $poslist_align_5 )
                       ),  
                  array( 40, 20, 10 )
               );
*/
function tr_input_3s_ml( $fieldname_arr_arr, $text_arr, $value_arr_arr=array(), $size_arr=array() ) {
  for( $i=0; $i<sizeof($fieldname_arr_arr); $i++ ) {    
    $chk_l = $chk_c = $chk_r = '';
    switch( $value_arr_arr[$i][3] ) {
      case 'L':
        $chk_l = 'checked';    break;
      case 'C':
        $chk_c = 'checked';    break;
      case 'R':
        $chk_r = 'checked';    break;
    }    
    
    ?>
    <tr align="left">

      <th class="BilldataTableContent" colspan="4">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-1'><?php echo $text_arr['question'].' '.($i+1); echo helpwindows_add($text_arr['help']);?></div>
            <div class='col-xs-12 col-sm-11'>
        <input class="bill" type="text" size="<?php echo $size_arr[0] ?>" name="<?php echo n2p($fieldname_arr_arr[$i][0]) ?>" value="<?php echo $value_arr_arr[$i][0] ?>">
        <?php echo $text_arr['text_a'] ?>&nbsp;
      
        <input class="bill" type="text" size="<?php echo $size_arr[1] ?>" name="<?php echo n2p($fieldname_arr_arr[$i][1]) ?>" value="<?php echo $value_arr_arr[$i][1] ?>">
        <?php echo $text_arr['text_b'] ?>&nbsp;

        <input class="bill" type="text" size="<?php echo $size_arr[2] ?>" name="<?php echo n2p($fieldname_arr_arr[$i][2]) ?>" value="<?php echo $value_arr_arr[$i][2] ?>">
        <?php echo $text_arr['text_c'] ?>&nbsp;&nbsp;
                <br class='hidden-sm hidden-md hidden-lg'>
                <input type="radio" class="radio-inline" name="<?php echo n2p($fieldname_arr_arr[$i][3]) ?>" value="L"  <?php  echo $chk_l ?>>
        <?php echo $text_arr['pos_left'] ?>
                <br class='hidden-sm hidden-md hidden-lg'>
                <input type="radio" class="radio-inline" name="<?php echo n2p($fieldname_arr_arr[$i][3]) ?>" value="C"  <?php  echo $chk_c ?>>
        <?php echo $text_arr['pos_center'] ?>
                <br class='hidden-sm hidden-md hidden-lg'>
                <input type="radio" class="radio-inline" name="<?php echo n2p($fieldname_arr_arr[$i][3]) ?>" value="R"  <?php  echo $chk_r ?>>
        <?php echo $text_arr['pos_right'] ?>
            </div>
	    <div class='col-xs-12'><br></div>
        </div>
      </th>        
  </tr>
<?php } 

}


/*
  tr_dropdown(  'product_staffel_customer_group',
                array( 'question'        => 'Kundengruppe:',
                     ),
                array( array( 'id'   => 0, 'text' => 'gast' ),
                       array( 'id'   => 1, 'text' => 'neuer kunde' )
                     ),
                $profile_product_staffel_customer_group,
                0
            );
*/
function tr_dropdown( $fieldname, $text_arr, $value_arr, $default_value='' ) {
?>
    <tr align="left">
      <th width="15%" class="BilldataTableContent"><?php echo $text_arr['question'] ?></th>
      <td colspan="3" class="BilldataTableContent">
<?php
         echo xtc_draw_pull_down_menu( $fieldname, 
                                      $value_arr, 
                                      $default_value); 
?>
      </td>
    </tr>
<?php
}



/*
  tr_single_customersstatus( 'data_customers_status',
                       'Preise f�r Kundengruppe:',
                       $profile['data_customers_status']
            );
*/
function tr_single_customersstatus( $fieldname, $text, $value ) {
  if( $value=='' ) {
    $value=1;     // default "gast"
  }
  $customers_status_query_raw = "select 
                                   customers_status_id, 
                                   customers_status_name 
                                 from " . 
                                   TABLE_CUSTOMERS_STATUS . " 
                                 where 
                                   language_id = '" . $_SESSION['languages_id'] . "' 
                                 order by customers_status_id";
  $c_status_arr = array();
  $customers_status_query = xtc_db_query($customers_status_query_raw);
  while ($customers_status = xtc_db_fetch_array($customers_status_query)) {
    $c_status_arr[] = array( 'id'   => $customers_status['customers_status_id'],
                             'name' => $customers_status['customers_status_name'] );
  }
  
?>
    <tr align="left">
      <td colspan="4" width="15%" class="BilldataTableContent">
          <select name="<?php echo n2p($fieldname) ?>" size="1" class="form-control">
<?php
  foreach( $c_status_arr as $c_status ) {
    $sel= $c_status['id']==$value?'selected':'';
    echo "          <option value=\"".$c_status['id']."\" $sel>".$c_status['name']."</option>\n";
  }
?>
        </select>
        <?php echo $text ?>
      </td>
    </tr>
<?php
}


/*
  tr_single_language( 'data_language',
                       'Sprache der Ausgabetexte',
                       $profile['data_language']
            );
*/
function tr_single_language( $fieldname, $text, $value ) {
  if( $value=='' ) {
    $value=2;     // default "deutsch"
  }
  $query = "select 
              languages_id, 
              name 
            from " . 
              TABLE_LANGUAGES . " 
            order by languages_id";
  $c_lang_arr = array();
  $query = xtc_db_query($query);
  while ($data = xtc_db_fetch_array($query)) {
    $lang_arr[] = array( 'id'   => $data['languages_id'],
                         'name' => $data['name'] );
  }
  
?>
    <tr align="left">
      <td colspan="4" width="15%" class="BilldataTableContent">
          <select name="<?php echo n2p($fieldname) ?>" size="1" class="form-control">
<?php
  foreach( $lang_arr as $lang ) {
    $sel= $lang['id']==$value?'selected':'';
    echo "          <option value=\"".$lang['id']."\" $sel>".$lang['name']."</option>\n";
  }
?>
        </select>
        <?php echo $text ?>
      </td>
    </tr>
<?php
}

/*
  tr_single_currencie( 'data_currencie',
                       'W�hrung',
                       $profile['data_currencie']
            );
*/
function tr_single_currencie( $fieldname, $text, $value ) {
  if( $value=='' ) {
    $value=DEFAULT_CURRENCY;     // default
  }
  $query = "select 
              currencies_id,
              code, 
              title
            from " . TABLE_CURRENCIES . " 
              order by title";
  $curr_arr = array();
  $query = xtc_db_query($query);
  while ($data = xtc_db_fetch_array($query)) {
    $curr_arr[] = array( 'id'   => $data['currencies_id'],
                         'code' => $data['code'],
                         'name' => $data['title'] );
  }
  
?>
    <tr align="left">
      <td colspan="4" width="15%" class="BilldataTableContent">
          <select name="<?php echo n2p($fieldname) ?>" size="1" class="form-control">
<?php
  foreach( $curr_arr as $curr ) {
    $sel= $curr['code']==$value?'selected':'';
    echo "          <option value=\"".$curr['code']."\" $sel>".$curr['name']." (".$curr['code'].")</option>\n";
  }
?>
        </select>
        <?php echo $text ?>
      </td>
    </tr>
<?php
}




/*
  tr_singlecheck(  'deckblatt',
                'Deckblatt'
                $profile_product_staffel_customer_group,
            );
*/
function tr_singlecheck( $fieldname, $text, $check ) {
  if( $check ) {
    $check='checked ';
  }
?>
    <tr align="left">
      <td colspan="4" width="15%" class="BilldataTableContent">
        <div class='col-xs-12'>
            <div class='col-xs-12 col-sm-3'>
                <?php echo $text ?>
            </div>
            <div class='col-xs-12 col-sm-1'>
        <input type="checkbox" name="<?php echo n2p($fieldname) ?>" value="1" <?php echo $check ?>>
            </div>
        </div>
      </td>
    </tr>
<?php
}

function helpwindows_add( $text ) {
  global $helpwindows_text_arr;
  
  $ret='';
  if( $text!='' ) {
    
    $helpwindows_text_arr[]=$text;
    $i=sizeof($helpwindows_text_arr);
  
    $ret = " <a href=\"javascript: showMinWin('MWJminiwinMAX$i','MWJminiwinMIN$i');\"><img src=\"includes/ipdfbill/images/helpicon.gif\" border=\"0\" width=\"16\" height=\"16\" alt=\"help\"></a>";
    $ret = "<span style=\"text-align:right\" id=\"helplink$i\" >".$ret."</span>";
  }
  return $ret;
  
}
      

function helpwindows() {
  global $helpwindows_text_arr;
  
?>
<script type="text/javascript">

function getPosition(id)
/* der Aufruf dieser Funktion ermittelt die absoluten Koordinaten
   des Objekts element */
{
  var elem,
      tagname="",
      x=0,y=0;
  
  elem=document.getElementById(id);

  /* solange elem ein Objekt ist und die Eigenschaft offsetTop enthaelt
     wird diese Schleife fuer das Element und all seine Offset-Eltern ausgefuehrt */
  while ((typeof(elem)=="object")&&(typeof(elem.tagName)!="undefined"))
  {
    y+=elem.offsetTop;     /* Offset des jeweiligen Elements addieren */
    x+=elem.offsetLeft;    /* Offset des jeweiligen Elements addieren */
    tagname=elem.tagName.toUpperCase(); /* tag-Name ermitteln, Grossbuchstaben */

    /* wenn beim Body-tag angekommen elem fuer Abbruch auf 0 setzen */
    if (tagname=="BODY")
      break;

    /* wenn elem ein Objekt ist und offsetParent enthaelt Offset-Elternelement ermitteln */
    if (typeof(elem)=="object")
      if (typeof(elem.offsetParent)=="object")
        elem=elem.offsetParent;
  }

  /* Objekt mit x und y zurueckgeben */
  position=new Object();
  position.x=x;
  position.y=y;
// alert('id='+id+' x='+x+'  y='+y);    
  
  return position;
}


<?php
  foreach( $helpwindows_text_arr as $i => $text ) {
    $i++;
    $n="helplink$i";
    
?>
  a=getPosition('<?php echo $n ?>');
  
  var nameObject2 = createMiniWinLayer(
  '<?php echo $text; ?>', //The text to be written in the main part of the mini window (can contain HTML)
  'PDF Rechnung Helpdesk',  //The text to be written in the title bar of the mini window
  a.x,                    //Distance from the left edge of the page to start
  a.y,                    //Distance from the top edge of the page to start
  500,                    //Width of the mini window
  '#375766',              //The background colour of the title bar of the mini window
  '#cccaaa',              //The background colour of the main part of the mini window
  'includes/ipdfbill/images/mv_logo.gif',             //The location of the logo image in the top left corner (16px x 16px)
  'includes/ipdfbill/images/mv_minimise.gif',        //The location of the minimise image (16px x 16px)
  'includes/ipdfbill/images/mv_restore.gif',          //The location of the restore image (16px x 16px)
  'includes/ipdfbill/images/mv_close.gif',            //The location of the 'close window' image (16px x 16px)
  'includes/ipdfbill/images/mv_maximise.gif',         //The location of the maximise image (16px x 16px) - use '' for not maximisable
  '', //The location of the drag handle image (8px x 8px) - '' if not resizable
  0,                      //Initial window visibility (0 = hidden, 1 = maximised, 2 = minimised)
  false,                  //Dragable portion (true = entire window, false = title bar only)
                          //Some browsers may have problems using the minimise/maximise/close buttons
                          //if you use entire window.
  ''                      //Only used in DOM browsers - HTML to be put just above the main part of the window -
                          //this MUST NOT contain any 'div' elements - this is designed to be used along with my
                          //display based menu script to provide menus in the mini windows
);    

<?php
  } // foreach
?>
</script>

<script type="text/javascript">
  function ShowInputs(){
    if (document.getElementById('selected').onclick) {
        document.getElementById('showtext').style.display = 'inline-block';
        document.getElementById('showsubmit').style.display = 'inline-block';
        document.getElementById('selected').style.display = "none";
    }
  }
</script>
<?php  
  
}



function generate_bill( $order_id ) {
  global $profile;
//echo "<pre>"; print_r($profile); echo "</pre>";
  
    $pdf=new pdfbill( $profile, $order_id, true );

    $pdf->max_height=280;
    $pdf->doc_name  =  "catalog_".$_POST['profilename'];   //DokumentName
    
    $pdf->LoadData($order_id);
    $pdf->format();
    $pdf->Output($pdf->doc_name.".pdf", "D");
//    $pdf->Output();
die;
  }
  
  
  

?>