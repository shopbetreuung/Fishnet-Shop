<?php
  
class cell_cluster_start extends cell_cluster {
  
  function cell_cluster_start( &$products_data, &$parameter_arr, &$pdf ) {
    $this->products_data = $products_data;
    $this->parameter_arr = $parameter_arr;
    $this->pdf = $pdf;
    
    
    $this->dataobjects = array( 
     new data_cell_textblock(     'headtext',     $products_data, $this->parameter_arr),
     new data_cell_addressblock(  'addressblock', $products_data, $this->parameter_arr),
     new data_cell_image(         'image',        $products_data, $this->parameter_arr),
     new data_cell_datafields(    'datafields',   $products_data, $this->parameter_arr),
     new data_cell_text(          'billhead',     $products_data, $this->parameter_arr),
     new data_cell_text(          'freeinfo',     $products_data, $this->parameter_arr),
    );
    
    $this->verbinde();
    
  }
  
}


class cell_cluster_list extends cell_cluster {

  function cell_cluster_list( &$products_data, &$parameter_arr, &$pdf ) {
    $this->products_data = $products_data;
    $this->parameter_arr = $parameter_arr;
    $this->pdf = $pdf;
    
    
    $this->dataobjects = array( 
      new data_cell_text(          'listhead',     $products_data, $this->parameter_arr),
      new data_cell_poslist(       'poslist',      $products_data, $this->parameter_arr)
    );
    
    $this->dataobjects[0]->indexnumber = 1;           
    $this->dataobjects[1]->parent_indexnumber = 1;
    
    $this->verbinde();
    
  }
  
  
  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {
    $this->dataobjects[0]->outbuffer($pdf, $offset_x, $offset_y );
    $this->dataobjects[1]->outbuffer($pdf, $offset_x, $offset_y );
    if( $this->dataobjects[1]->finish == false ) {
      $this->dataobjects[0]->rel_y=0;
      $this->verbinde();
      
      while( $this->dataobjects[1]->finish == false ) {
        $pdf->AddPage();
        $this->dataobjects[0]->outbuffer($pdf, $offset_x, $offset_y );
        $this->dataobjects[1]->outbuffer($pdf, $offset_x, $offset_y );
      }
    }
      
  }  
  
}



class cell_cluster_end extends cell_cluster {
  
  function cell_cluster_end( &$products_data, &$parameter_arr, &$pdf ) {
    $this->products_data = $products_data;
    $this->parameter_arr = $parameter_arr;
    $this->pdf = $pdf;
    
    
    $this->dataobjects = array( 
     new data_cell_resumefields(    'resumefields', $products_data, $this->parameter_arr),
     new data_cell_textblock(            'subtext',      $products_data, $this->parameter_arr),
    );
    
    $this->verbinde();
    
  }
  
  
  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {
    $ly=$this->calc_y_dimension( $offset_y, $pdf );
    if( $ly>$pdf->PageBreakTrigger ) {
      $pdf->AddPage();
      $offset_y=$pdf->GetY();
    }
    
    $this->dataobjects[0]->outbuffer($pdf, $offset_x, $offset_y );
    $this->dataobjects[1]->outbuffer($pdf, $offset_x, $offset_y );
  }  
  
  
}

/* --------------------------------------------------------------------------------------------------
     class cell_cluster           - Verwaltungsobjekt zusammengehörender data_cell-Objekte
   -------------------------------------------------------------------------------------------------- */
class cell_cluster {
   var $products_data,
       $parameter_arr,
       $pdf,
       
       $dataobjects;

  
  function cell_cluster( &$products_data, &$parameter_arr, &$pdf ) {
    $this->products_data = $products_data;
    $this->parameter_arr = $parameter_arr;
    $this->pdf = $pdf;
    
    
    $this->dataobjects = array();
//    $this->verbinde();
  }
  
  function reinit( &$products_data ) {
    for( $i=0; $i<sizeof($this->dataobjects); $i++) {                          // objekte mit prod.daten bestuecken
      $this->dataobjects[$i]->reinit( $products_data, $this->parameter_arr);     
    }
    $this->verbinde();
  }
  
  
  function calc_y_dimension( $offset_y=0, &$pdf ) {
    $y_next=0;                                                         // platzbedarf ermitteln
    for( $i=0; $i<sizeof($this->dataobjects); $i++) {
       $y = $this->dataobjects[$i]->calc_y_dimension($offset_y, $pdf);
       $y_next = $y>$y_next ? $y : $y_next ;
    }
    
    return $y_next;
  }
  
  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {

    for( $i=0; $i<sizeof($this->dataobjects); $i++) {                          
      $this->dataobjects[$i]->outbuffer($pdf, $offset_x, $offset_y );
    }
  }
  
  function _find_indexnumber( $indexnumber ) {
    $ret = -1;
    for( $i=0; $i<sizeof($this->dataobjects); $i++) {                          
      if( $this->dataobjects[$i]->display==false ) {
        continue;
      }
      if( $this->dataobjects[$i]->indexnumber == $indexnumber ) {
        $ret = $i;
        break;
      }
    }
    
    return $ret;
  }
  
  function verbinde() {
    for( $i=0; $i<sizeof($this->dataobjects); $i++) {
      if( $this->dataobjects[$i]->parent_indexnumber>0 ) {
        $pi = $this->_find_indexnumber($this->dataobjects[$i]->parent_indexnumber);
        if( $pi>=0 ) {
          $this->dataobjects[$i]->rel_x = $this->dataobjects[$pi]->rel_x;
          $this->dataobjects[$i]->rel_y = $this->dataobjects[$pi]->calc_y_dimension( 0, $this->pdf );
        }
      }
    }
    
  }
  
}




/* --------------------------------------------------------------------------------------------------
     class data_cell_image           - Grafik
     
     Parameterauswertung:
       <feldname>                       1/0 - Darstellung Ja/Nein
       <feldname>_horizontal            relative x-Position
       <feldname>_vertical              relative y-Position
       <feldname>_width                 Breite
       <feldname>_height                Hoehe
       
       <feldname>_link                  1/0 Bilder verlinken nach product_info.php
   -------------------------------------------------------------------------------------------------- */
class data_cell_image extends data_cell {
  
  function reinit( &$products_data, &$parameter_arr) {
    $this->data_cell_image( $this->fieldname, $products_data, $parameter_arr );
  }
      
  function data_cell_image( $fieldname, &$products_data, &$parameter_arr) {
    $this->data_cell( $fieldname, $products_data, $parameter_arr );
    
    $this->rel_x         = $this->parameter_arr[$fieldname.'_horizontal']==''  ?  0 : $this->parameter_arr[$fieldname.'_horizontal'];
    $this->rel_y         = $this->parameter_arr[$fieldname.'_vertical']  ==''  ?  0 : $this->parameter_arr[$fieldname.'_vertical']  ;
    $this->width         = $this->parameter_arr[$fieldname.'_width'] == '' ? 0 : $this->parameter_arr[$fieldname.'_width'] ;
    $this->height        = $this->parameter_arr[$fieldname.'_height']  == '' ? 0  : $this->parameter_arr[$fieldname.'_height'] ;
    
    $this->imagelink     = $this->parameter_arr[$fieldname.'_link'] == '1' ? true:false;
  } 
  
  function _content() {
    $ret = PDF_IMAGE_DIR.$this->parameter_arr[$this->fieldname.'_image'];
//echo "<pre>"; print_r($this->parameter_arr); echo "</pre>";

    return $ret;
  }
  
  function calc_y_dimension( $offset_y=0, &$pdf ) {
    $ret = $offset_y;
    $img = $this->_content();
    if( !file_exists($img) ) {   // image not exists
      return $ret;               // interrupt, no height 
    }

    if($this->display) {                                        // if displayed
      if( ($this->height==0) && ($this->width==0)) {
       	$a=@GetImageSize($img);
        if( $a[1]==0 ) {
          $h=0;
          $this->display=false;
        } else {
          $h=$a[1]/$pdf->k;
        }
      } else if( ($this->height==0) && ($this->width>0)) {
       	$a=@GetImageSize($img);
        $w=$a[0];
        $h=$a[1];
        if( $w==0 ) { 
          $h=0; 
          $this->display=false;
        } else {
          $h= $h * ($this->width/$w) / $pdf->k;
        }
      } else {
        $h=$this->height/$pdf->k;
      }
      $ret += $this->rel_y + $h;

    }
    return $ret;
  }


  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {
    if(!$this->display) {                                        // if not to display
      return;
    }

    $img = $this->_content();
//echo "$img<br>\n";
    if( file_exists($img) ) {   // image exists
//echo "$img exists<br>\n";
    
      if( $this->imagelink ) {
        $link = HTTP_CATALOG_SERVER . DIR_WS_CATALOG;
        $link .= 'product_info.php?info=p'.$this->products_data['products_id'];
      }
      
      $w = $this->width/$pdf->k;
      $h = $this->height/$pdf->k;
      
      $pdf->Image( $img, $offset_x + $this->rel_x, $offset_y + $this->rel_y, $w, $h, '', $link );
    }
              
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $this->_debuginfo( $pdf, $offset_x, $offset_y );
    }

    
  }
  
}








  

  
  



/* --------------------------------------------------------------------------------------------------
     class data_cell_text       - Text 
     
     Parameterauswertung:
       <feldname>_display            1/0 - Darstellung Ja/Nein
       <feldname>_horizontal         relative x-Position
       <feldname>_vertical           relative y-Position
       <feldname>_width              Breite
       <feldname>_height               Hoehe
       
       <feldname>_text               Inhaltstext
       
       <feldname>_color              RGB Schriftfarbe (z.B. "#AA22CC")
       <feldname>_position           Ausrichtung ('L', 'C', 'R' )
       <feldname>_font_type          Schriftart (z.B. "arial")
       <feldname>_font_style         Array, Schriftstil (z.B. array('B', 'I', 'U') )
       <feldname>_font_size          Schriftgroesse
   -------------------------------------------------------------------------------------------------- */
class data_cell_text extends data_cell{
  var $position,
      $font_color,
      $font_type,
      $font_style,
      $font_size;
 
      
  function data_cell_text( $fieldname, &$products_data, &$parameter_arr) {
//echo "<pre>"; print_r($products_data); echo "</pre>";
//die;
    
    $this->data_cell( $fieldname, $products_data, $parameter_arr );
    
    $this->text          = $this->parameter_arr[$fieldname.'_text'];

    $this->position      = $this->parameter_arr[$fieldname.'_position']    == '' ? DATA_CELL_POSITION : $this->parameter_arr[$fieldname.'_position'] ;
    $this->font_color    = $this->parameter_arr[$fieldname.'_font_color']  == '' ? DATA_CELL_FONT_COLOR : $this->parameter_arr[$fieldname.'_font_color'] ;
    $this->font_type     = $this->parameter_arr[$fieldname.'_font_type']   == '' ? DATA_CELL_FONT_TYPE  : $this->parameter_arr[$fieldname.'_font_type'] ;
    $this->font_style    = $this->parameter_arr[$fieldname.'_font_style']  == '' ? DATA_CELL_FONT_STYLE : $this->parameter_arr[$fieldname.'_font_style'] ;
    $this->font_size     = $this->parameter_arr[$fieldname.'_font_size']   == '' ? DATA_CELL_FONT_SIZE  : $this->parameter_arr[$fieldname.'_font_size'] ;

    // if no height than height in relation of fontsize
    $this->height        = $this->parameter_arr[$fieldname.'_height']  == '' ? s2h($this->font_size)  : $this->parameter_arr[$fieldname.'_height'] ;
  } 
  
  function _content() {
    $ret = $this->replace_data( $this->text);

    return $ret;
  }
  
  
  function format_text(&$pdf) {
    $col = hex2rgb($this->font_color);
	  $pdf->SetTextColor($col[0],$col[1],$col[2]);
    
    if( is_array($this->font_style) ) {
      $fs=implode('', $this->font_style);
    }
		$pdf->SetFont($this->font_type,$fs,$this->font_size);
	}
    
    
  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {
//echo "mk1 displ=".$this->display."<br>\n";    
//echo "ccc<pre>"; print_r($this); echo "</pre>ddd";
    if(!$this->display) {                                        // if displayed
      return;
    }
//echo "mk2";    
    
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $col = hex2rgb($this->_border_color);
	    $pdf->SetDrawColor($col[0],$col[1],$col[2]);
      $this->_border = 1;
    }
    
//echo "mk2 cont=".$this->_content()."    bord=".$this->_border."<br>\n";    
 	  $this->format_text($pdf);
		$pdf->SetXY( $offset_x + $this->rel_x, $offset_y + $this->rel_y); 
		$pdf->Cell( $this->width, $this->height,
                $this->_content(), $this->_border, 0,
                $this->position );
                
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $this->_debuginfo( $pdf, $offset_x, $offset_y );
    }
  }
  
    
}  



/* --------------------------------------------------------------------------------------------------
     class data_cell_textblock       - Textblock 
     
     Parameterauswertung:
       <feldname>                    1/0 - Darstellung Ja/Nein
       <feldname>_horizontal         relative x-Position
       <feldname>_vertical           relative y-Position
       <feldname>_width              Breite
       <feldname>_height             Hoehe
       
       <feldname>_floatsize          wenn '1' wird Text nicht abgeschnitten, 
                                     <feldname>_height wird ignoriert
       
       <feldname>_color              RGB Schriftfarbe (z.B. "#AA22CC")
       <feldname>_font_type          Schriftart (z.B. "arial")
       <feldname>_font_style         Array, Schriftstil (z.B. array('B', 'I', 'U') )
       <feldname>_font_size          Schriftgroesse
   -------------------------------------------------------------------------------------------------- */
class data_cell_textblock extends data_cell_text{
  var $font_color,
      $font_type,
      $font_style,
      $font_size;

  function data_cell_textblock( $fieldname, &$products_data, &$parameter_arr) {
    $this->data_cell_text( $fieldname, $products_data, $parameter_arr );
    
    $this->font_color    = $this->parameter_arr[$fieldname.'_font_color']  == '' ? DATA_CELL_FONT_COLOR : $this->parameter_arr[$fieldname.'_font_color'] ;
    $this->font_type     = $this->parameter_arr[$fieldname.'_font_type']   == '' ? DATA_CELL_FONT_TYPE  : $this->parameter_arr[$fieldname.'_font_type'] ;
    $this->font_style    = $this->parameter_arr[$fieldname.'_font_style']  == '' ? DATA_CELL_FONT_STYLE : $this->parameter_arr[$fieldname.'_font_style'] ;
    $this->font_size     = $this->parameter_arr[$fieldname.'_font_size']   == '' ? DATA_CELL_FONT_SIZE  : $this->parameter_arr[$fieldname.'_font_size'] ;
    
  } 
  
  function _content() {
    $ret=$this->text;
    $new_link = "";
    if ($this->text != '') {
      $new_line = "\n\n\n";
    }
    if ($this->fieldname == 'subtext' && $this->parameter_arr['subtext_display_comments']) {
      $ret.=$new_line."Kunden Kommentar: ".$this->products_data['COMMENT'];
    }
    return $ret;        
  }
  
  
  function format_text(&$pdf) {
    $col = hex2rgb($this->font_color);
	  $pdf->SetTextColor($col[0],$col[1],$col[2]);
    
    if( is_array($this->font_style) ) {
      $fs=implode('', $this->font_style);
    }
		$pdf->SetFont($this->font_type,$fs,$this->font_size);
	}
  
  function calc_y_dimension( $offset_y=0, &$pdf ) {
    if( $this->parameter_arr[$this->fieldname.'_floatsize'] == '1' ) {  // Text nicht schneiden
      $ret = $offset_y;
      if($this->display) {                                        // if displayed
 	      $this->format_text($pdf);
        if( $this->parameter_arr['pdfdebug'] == '1' ) {
          $this->_border = 1;
        }
		    $y_size = $pdf->MultiCell_ycalc( $this->width, s2h($this->font_size),
                                         $this->_content(), 
                                         $this->_border, 
                                         $this->parameter_arr[$this->fieldname.'_position'] );
        $ret += $this->rel_y + $y_size;
      }
    } else {
      $ret = parent::calc_y_dimension( $offset_y, $pdf );
    }
    return $ret;
  }
  
    
    
  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {
    if(!$this->display) {                                        // if displayed
      return;
    }
    
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $col = hex2rgb($this->_border_color);
	    $pdf->SetDrawColor($col[0],$col[1],$col[2]);
      $this->_border = 1;
    }

 	  $this->format_text($pdf);
		$pdf->SetXY( $offset_x + $this->rel_x, $offset_y + $this->rel_y); 

    if( true) { //$this->parameter_arr[$this->fieldname.'_floatsize'] == '1' ) {  // Text nicht schneiden
		  $pdf->MultiCell( $this->width, s2h($this->font_size),
                  $this->_content(), 
                  $this->_border, 
                  $this->parameter_arr[$this->fieldname.'_position'] );
      // MultiCell(float w , float h , string txt [, mixed border] [, string align] [, integer fill])
    } else {
  		$pdf->ClippedMultiCell2( $this->width, $this->height,
                  s2h($this->font_size),
                  $this->_content(), 
                  $this->_border, 0, 
                  $this->parameter_arr[$this->fieldname.'_position'] );
    }
    //MultiCell(float w , float h , string txt [, mixed border] [, string align] [, integer fill])
                
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $this->_debuginfo( $pdf, $offset_x, $offset_y );
    }
  }
  
    
}
  





/* --------------------------------------------------------------------------------------------------
     class data_cell_addressblock       - Addressbfeld 
     
     Parameterauswertung:
       <feldname>_display            1/0 - Darstellung Ja/Nein
       <feldname>_horizontal         relative x-Position
       <feldname>_vertical           relative y-Position
       <feldname>_width              Breite
       <feldname>_height               Hoehe
       
     Absenderzeile:  
       <feldname>_text               Text Absenderszeile
       <feldname>_color              RGB Schriftfarbe (z.B. "#AA22CC")
       <feldname>_position           Ausrichtung ('L', 'C', 'R' )
       <feldname>_font_type          Schriftart (z.B. "arial")
       <feldname>_font_style         Array, Schriftstil (z.B. array('B', 'I', 'U') )
       <feldname>_font_size          Schriftgroesse

     Empfaenger:  
       <feldname>_color2             RGB Schriftfarbe (z.B. "#AA22CC")
       <feldname>_position2          Ausrichtung ('L', 'C', 'R' )
       <feldname>_font_type2         Schriftart (z.B. "arial")
       <feldname>_font_style2        Array, Schriftstil (z.B. array('B', 'I', 'U') )
       <feldname>_font_size2         Schriftgroesse
   -------------------------------------------------------------------------------------------------- */
class data_cell_addressblock extends data_cell_text{
  var $position2,
      $font_color2,
      $font_type2,
      $font_style2,
      $font_size2;
      
  function data_cell_addressblock( $fieldname, &$products_data, &$parameter_arr) {
    $this->data_cell_text( $fieldname, $products_data, $parameter_arr );

    $this->position2      = $this->parameter_arr[$fieldname.'_position2']    == '' ? DATA_CELL_POSITION : $this->parameter_arr[$fieldname.'_position2'] ;
    $this->font_color2    = $this->parameter_arr[$fieldname.'_font_color2']  == '' ? DATA_CELL_FONT_COLOR : $this->parameter_arr[$fieldname.'_font_color2'] ;
    $this->font_type2     = $this->parameter_arr[$fieldname.'_font_type2']   == '' ? DATA_CELL_FONT_TYPE  : $this->parameter_arr[$fieldname.'_font_type2'] ;
    $this->font_style2    = $this->parameter_arr[$fieldname.'_font_style2']  == '' ? DATA_CELL_FONT_STYLE : $this->parameter_arr[$fieldname.'_font_style2'] ;
    $this->font_size2     = $this->parameter_arr[$fieldname.'_font_size2']   == '' ? DATA_CELL_FONT_SIZE  : $this->parameter_arr[$fieldname.'_font_size2'] ;

    // if no height than height in relation of fontsize
    $cont=$this->_content();
    $lines = sizeof(preg_split("/(\n|\r|\r\n)/", $cont['receiver']));
    $this->height        = $this->parameter_arr[$fieldname.'_height']  == '' ? s2h($this->font_size)+$lines*s2h($this->font_size2)  : $this->parameter_arr[$fieldname.'_height'] ;
//    $this->height        = s2h($this->font_size)+$lines*s2h($this->font_size2);
//echo "mk1 h=".$this->height."    bord=".$this->_border."<br>\n";    
    
  } 
  
  function _content() {
    $ret['sender']   = $this->text;
    $ret['receiver'] = "\n".$this->products_data['address_label_payment']; // "\n"."Mustermeier\nBeispielweg 123\n12345 Sonstwo";
//echo "data data_cell_addressblock:<pre>"; print_r($this->products_data); echo "</pre>";    

    if( strpos($this->parameter_arr['profile_name'], 'delivnote')!==false ) {  // Wenn Lieferschein
      $ret['receiver'] = "\n".$this->products_data['address_label_shipping']; 
    }
//    
    
    return $ret;
  }
  
  
  function format_text2(&$pdf) {
//echo "<pre>"; print_r($this->parameter_arr); echo "</pre>";
    $col = hex2rgb($this->font_color2);
	  $pdf->SetTextColor($col[0],$col[1],$col[2]);
    
    if( is_array($this->font_style2) ) {
      $fs=implode('', $this->font_style2);
    }
		$pdf->SetFont($this->font_type2,$fs,$this->font_size2);
  
	}
    
    
  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {
//echo "mk1 displ=".$this->display."<br>\n";    
//echo "ccc<pre>"; print_r($pdf); echo "</pre>ddd";
    if(!$this->display) {                                        // if displayed
      return;
    }
//echo "mk2";    
    
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $col = hex2rgb($this->_border_color);
	    $pdf->SetDrawColor($col[0],$col[1],$col[2]);
      $this->_border = 1;
    }
    
//echo "mk2 cont=".$this->_content()."    bord=".$this->_border."<br>\n";    
    $content=$this->_content();
//echo "mk2 h=".$this->height ."    bord=".$this->_border."<br>\n";    
//echo "mk2 h=".$this->height - s2h($this->font_size)."    bord=".$this->_border."<br>\n";    

 	  $this->format_text($pdf);
		$pdf->SetXY( $offset_x + $this->rel_x, $offset_y + $this->rel_y); 
		$pdf->Cell( $this->width, s2h($this->font_size),
                $content['sender'] , $this->_border, 0,
                $this->parameter_arr[$this->fieldname.'_position'] );
 	  $this->format_text2($pdf);
		$pdf->SetXY( $offset_x + $this->rel_x, $offset_y + $this->rel_y + s2h($this->font_size) ); 
/*
		$pdf->Cell( $this->width, $this->height - s2h($this->font_size),
                $content['receiver'] , $this->_border, 0,
                $this->parameter_arr[$this->fieldname.'_position'] );
*/              
//MultiCell(float w , float h , string txt [, mixed border] [, string align] [, integer fill])                
    $pdf->MultiCell( $this->width, s2h($this->font_size2), 
                     $content['receiver'] , $this->_border, 
                     $this->parameter_arr[$this->fieldname.'_position'] );
                
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $this->_debuginfo( $pdf, $offset_x, $offset_y );
    }
  }
  
    
}
  

  
  
  

    

    
/* --------------------------------------------------------------------------------------------------
     class data_cell_price       - Preis 
     
     Parameterauswertung:
       <feldname>                    1/0 - Darstellung Ja/Nein
       <feldname>_horizontal         relative x-Position
       <feldname>_vertical           relative y-Position
       <feldname>_width              Breite
       
       <feldname>_pretext            Textvorsatz vor Datenwert (z.B. "Artikelnummer:")
       
       <feldname>_color              RGB Schriftfarbe (z.B. "#AA22CC")
       <feldname>_font_type          Schriftart (z.B. "arial")
       <feldname>_font_style         Array, Schriftstil (z.B. array('B', 'I', 'U') )
       <feldname>_font_size          Schriftgroesse

       <feldname>_subtext            Text unter Datenwert (z.B. "inkl mwst")
       <feldname>_subtext_font_style Array, Schriftstil (z.B. array('B', 'I', 'U') )
       <feldname>_subtext_font_size  Schriftgroesse
   -------------------------------------------------------------------------------------------------- */
class data_cell_price extends data_cell_text{
  var $subtext='',
      $subtext_font_style,
      $subtext_font_size;
      
  function data_cell_price( $fieldname, &$products_data, &$parameter_arr) {
    $this->data_cell_text( $fieldname, $products_data, $parameter_arr );
    
    $this->subtext               = $this->parameter_arr[$fieldname.'_subtext'];
    $this->subtext_font_style    = $this->parameter_arr[$fieldname.'_subtext_font_style']  == '' ? DATA_CELL_FONT_STYLE : $this->parameter_arr[$fieldname.'_subtext_font_style'] ;
    $this->subtext_font_size     = $this->parameter_arr[$fieldname.'_subtext_font_size']   == '' ? DATA_CELL_FONT_SIZE  : $this->parameter_arr[$fieldname.'_subtext_font_size'] ;
    
    $this->height = s2h($this->font_size)+s2h($this->subtext_font_size);
  } 
  
  function _content($subtext=false) {
    global $texts;
    
    if( $subtext ) {
      return $this->subtext;
    }
    
    switch( $this->fieldname ) {
      case 'product_price':
        $ret = $this->products_data['products_price_formated'];     
        if( $this->products_data['marker_from'] ) {     // if attributes with additional prices
          $ret = $texts['from'].$ret;                   // set "from" before
        }
        break;
      default:
        $ret = '???';                                // error
    }
    
    if( $this->parameter_arr[$this->fieldname.'_pretext']!='' ) {
      $ret = $this->parameter_arr[$this->fieldname.'_pretext'].' '.$ret;
    }

    return $ret;
  }
  
  function subtext_format_text(&$pdf) {
    $col = hex2rgb($this->font_color);
	  $pdf->SetTextColor($col[0],$col[1],$col[2]);
    
    if( is_array($this->subtext_font_style) ) {
      $fs=implode('', $this->subtext_font_style);
    }
		$pdf->SetFont($this->subtext_font_type,$fs,$this->subtext_font_size);
	}
  
    
  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {
    if(!$this->display) {                                        // if displayed
      return;
    }
    
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $col = hex2rgb($this->_border_color);
	    $pdf->SetDrawColor($col[0],$col[1],$col[2]);
      $this->_border = 1;
    }
    
 	  $this->format_text($pdf);
		$pdf->SetXY( $offset_x + $this->rel_x, $offset_y + $this->rel_y); 
		$pdf->Cell( $this->width, s2h($this->font_size),
                $this->_content(), $this->_border, 2,
                $this->parameter_arr[$this->fieldname.'_position'] );
                
 	  $this->subtext_format_text($pdf);
		$pdf->Cell( $this->width, s2h($this->subtext_font_size),
                $this->_content(true), $this->_border, 0,
                $this->parameter_arr[$this->fieldname.'_position'] );

    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $this->_debuginfo( $pdf, $offset_x, $offset_y );
    }
  }
  
    
}
    

    
/* --------------------------------------------------------------------------------------------------
     class data_cell_poslist            - Positionszeilen  (7)
     

     Parameterauswertung:
       <feldname>_display            1/0 - Darstellung Ja/Nein
       <feldname>_horizontal         relative x-Position
       <feldname>_vertical           relative y-Position
       <feldname>_width              Breite
       
       <feldname>_text               Inhaltstext
       
      Linke Spalte: 
       <feldname>_color              RGB Schriftfarbe (z.B. "#AA22CC")
       <feldname>_position           Ausrichtung ('L', 'C', 'R' )
       <feldname>_font_type          Schriftart (z.B. "arial")
       <feldname>_font_style         Array, Schriftstil (z.B. array('B', 'I', 'U') )
       <feldname>_font_size          Schriftgroesse
       
     Vars:
       $cols                         Anzahl Spalten
       $finish                       Gibt nach Aufruf outbuffer()) an ob Ausgabe Liste 
                                     abgeschlossen (=true) 
                                     oder wegen Seitenende unterbrochen (=false)

   -------------------------------------------------------------------------------------------------- */
/*   
class data_cell_poslist extends data_cell_text {
  var $cols=0,
      $_content_counter=0,
      $finish = false;
      
  function data_cell_poslist( $fieldname, &$products_data, &$parameter_arr) {
    $this->data_cell_text( $fieldname, $products_data, $parameter_arr );

    $this->position2      = $this->parameter_arr[$fieldname.'_position2']    == '' ? DATA_CELL_POSITION : $this->parameter_arr[$fieldname.'_position2'] ;
    $this->font_color2    = $this->parameter_arr[$fieldname.'_font_color2']  == '' ? DATA_CELL_FONT_COLOR : $this->parameter_arr[$fieldname.'_font_color2'] ;
    $this->font_type2     = $this->parameter_arr[$fieldname.'_font_type2']   == '' ? DATA_CELL_FONT_TYPE  : $this->parameter_arr[$fieldname.'_font_type2'] ;
    $this->font_style2    = $this->parameter_arr[$fieldname.'_font_style2']  == '' ? DATA_CELL_FONT_STYLE : $this->parameter_arr[$fieldname.'_font_style2'] ;
    $this->font_size2     = $this->parameter_arr[$fieldname.'_font_size2']   == '' ? DATA_CELL_FONT_SIZE  : $this->parameter_arr[$fieldname.'_font_size2'] ;

//echo "<pre>"; print_r($this->parameter_arr); echo "</pre>";
    $i=1;
    $this->cols=0;
    while( $this->parameter_arr[$this->fieldname.'_width_'.$i] > 0 ) {
//echo "this->fieldname.'_head_'.i=".$this->fieldname.'_head_'.$i."<br>\n";                                  
//echo "this->parameter_arr[this->fieldname.'_head_'.i]=".$this->parameter_arr[$this->fieldname.'_head_'.$i]."<br>\n";                                  
      $this->cols++;
      $i++;
    }

    $this->_border=1;
    
  } 
  

  
  
  function _content() {
//echo "<pre>"; print_r($this->parameter_arr); echo "</pre>";
//echo "<pre>"; print_r($this->products_data); echo "</pre>";
                
    $ret=array();
    for($dc=0; $dc<sizeof($this->products_data['order_data']); $dc++) {
      $ds=array();
      for( $i=1; $i<=$this->cols; $i++ ) {
        $val = $this->parameter_arr[$this->fieldname.'_value_'.$i];
        $val = $this->replace_posdata($val, $dc );
        $ds[] = $val;
      }
      $ret[]=$ds;
    }                 
    
    return $ret;
  }
  
  function replace_posdata( $txt, $pos_inx ) {
//echo "<pre>"; print_r($this->products_data['order_data'][$pos_inx]); echo "</pre>";
//echo "this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL']=".$this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL']."<br>\n";
    $txt = str_replace( '*pos_nr*',    ($pos_inx+1), $txt );

//echo "this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL']=".$this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL']."<br>\n";
    if( $this->products_data['order_data'][$pos_inx]['PRODUCTS_ATTRIBUTES_MODEL'] != '' ) {
      $txt = str_replace( '*p_model*',   $this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL'].$this->products_data['order_data'][$pos_inx]['PRODUCTS_ATTRIBUTES_MODEL'], $txt );
    } else {
      $txt = str_replace( '*p_model*',   $this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL'], $txt );
    }
    
    $txt = str_replace( '*p_model_att*', $this->products_data['order_data'][$pos_inx]['PRODUCTS_ATTRIBUTES_MODEL'], $txt );
    $txt = str_replace( '*p_model_org*', $this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL'], $txt );
    
    $txt = str_replace( '*p_name*',         $this->products_data['order_data'][$pos_inx]['PRODUCTS_NAME'].$this->products_data['order_data'][$pos_inx]['PRODUCTS_ATTRIBUTES'], $txt );
    $txt = str_replace( '*p_price*',        $this->products_data['order_data'][$pos_inx]['PRODUCTS_PRICE'], $txt );
    $txt = str_replace( '*p_single_price*', $this->products_data['order_data'][$pos_inx]['PRODUCTS_SINGLE_PRICE'], $txt );
    $txt = str_replace( '*p_qty*',          $this->products_data['order_data'][$pos_inx]['PRODUCTS_QTY'], $txt );
//echo "txt2=$txt<br>\n";

    return $txt;
  }  
  
  
  function calc_y_dimension( $offset_y=0, &$pdf ) {
    $ret = $offset_y + s2h($this->font_size);
    return $ret;
  }
  
  
  function max_lines( $content_arr ) {
return 1;    
    $lines=1;
    for( $i=0; $i<$this->cols; $i++ ) {
      $lines = max($lines, sizeof(preg_split("/(\n|\r|\r\n)/", $content_arr[$i])) );
//echo "lines=$lines content_arr[$i]=$content_arr[$i]<br>\n";      
    }
    return $lines;
  }
  
  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {

    
//echo "mk1<br>\n";    
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $col = hex2rgb($this->_border_color);
	    $pdf->SetDrawColor($col[0],$col[1],$col[2]);
      $this->_border = 1;
    }
    
    $line_h = s2h($this->font_size);

    $x = $offset_x + $this->rel_x;
    $y = $offset_y + $this->rel_y;
    $lc=0;
    
    $pdf->SetXY( $x ,$y );
    $this->format_text($pdf);
//echo "tc=".$this->cols."<br>\n";                                  
    for( $i=1; $i<=$this->cols; $i++ ) {
      $text=$this->parameter_arr[$this->fieldname.'_head_'.$i];
//echo "i= $i txt=".$text."<br>\n";                                  
      $pdf->SetXY( $x ,$y );
      $width = $this->parameter_arr[$this->fieldname.'_width_'.$i]; 
      $pdf->Cell( $width, $line_h, $text, $this->_border, 2, $this->position );
      
      $x+=$width;
    }
    $y+=$line_h;
    
    $content_arr_arr = $this->_content();
    
    $this->finish=true; // default
    for( $ds = $this->_content_counter; $ds < sizeof($content_arr_arr); $ds++ ) {
      $content_arr=$content_arr_arr[$ds];
      $x = $offset_x + $this->rel_x;
      $lines=$this->max_lines($content_arr);
      for( $i=0; $i<$this->cols; $i++ ) {
        $align = $this->parameter_arr[$this->fieldname.'_align_'.($i+1)];

        $pdf->SetXY( $x ,$y );
        $width = $this->parameter_arr[$this->fieldname.'_width_'.($i+1)];
        
        $txt = $content_arr[$i];
        $lc = sizeof(preg_split("/(\n|\r|\r\n)/", $txt));
        //$txt.= str_repeat("\n ", $lines-$lc);
//echo "lines=$lines lc=$lc txt=$txt<br>\n";      
         
        $pdf->ClippedCell( $width , $line_h, $txt, $this->_border, $align );
//            MultiCell(float w , float h, string txt     , mixed border  , string align, integer fill)
        $x+=$width;
      }
      $y+=$lines*$line_h;

      if( isset($content_arr_arr[$ds+1])) {
        $lines=$this->max_lines($content_arr_arr[$ds+1]);
        if( ($y+($lines*$line_h))>$pdf->PageBreakTrigger ) {
          $this->finish=false; // default
          break;
        }
      }
//echo "weiter y=$y<br>";      
    }
    
    $this->_content_counter = $ds;
    
                
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $this->_debuginfo( $pdf, $offset_x, $offset_y );
    }
  }
  

  
}    
    
*/
class data_cell_poslist extends data_cell_text {
  var $cols=0,
      $_content_counter=0,
      $finish = false;
      
  function data_cell_poslist( $fieldname, &$products_data, &$parameter_arr) {
    $this->data_cell_text( $fieldname, $products_data, $parameter_arr );

    $this->position2      = $this->parameter_arr[$fieldname.'_position2']    == '' ? DATA_CELL_POSITION : $this->parameter_arr[$fieldname.'_position2'] ;
    $this->font_color2    = $this->parameter_arr[$fieldname.'_font_color2']  == '' ? DATA_CELL_FONT_COLOR : $this->parameter_arr[$fieldname.'_font_color2'] ;
    $this->font_type2     = $this->parameter_arr[$fieldname.'_font_type2']   == '' ? DATA_CELL_FONT_TYPE  : $this->parameter_arr[$fieldname.'_font_type2'] ;
    $this->font_style2    = $this->parameter_arr[$fieldname.'_font_style2']  == '' ? DATA_CELL_FONT_STYLE : $this->parameter_arr[$fieldname.'_font_style2'] ;
    $this->font_size2     = $this->parameter_arr[$fieldname.'_font_size2']   == '' ? DATA_CELL_FONT_SIZE  : $this->parameter_arr[$fieldname.'_font_size2'] ;

//echo "<pre>"; print_r($this->parameter_arr); echo "</pre>";
    $i=1;
    $this->cols=0;
    while( $this->parameter_arr[$this->fieldname.'_width_'.$i] > 0 ) {
//echo "this->fieldname.'_head_'.i=".$this->fieldname.'_head_'.$i."<br>\n";                                  
//echo "this->parameter_arr[this->fieldname.'_head_'.i]=".$this->parameter_arr[$this->fieldname.'_head_'.$i]."<br>\n";                                  
      $this->cols++;
      $i++;
    }

    $this->_border=1;
    
  } 
  

  
  
  function _content() {
//echo "<pre>"; print_r($this->parameter_arr); echo "</pre>";
//echo "<pre>"; print_r($this->products_data); echo "</pre>";
                
    $ret=array();
    for($dc=0; $dc<sizeof($this->products_data['order_data']); $dc++) {
      $ds=array();
      for( $i=1; $i<=$this->cols; $i++ ) {
        $val = $this->parameter_arr[$this->fieldname.'_value_'.$i];
        $val = $this->replace_posdata($val, $dc );
        $ds[] = $val;
      }
      $ret[]=$ds;
    }                 
    
    return $ret;
  }
  
  function replace_posdata( $txt, $pos_inx ) {
//echo "<pre>"; print_r($this->products_data['order_data'][$pos_inx]); echo "</pre>";
//echo "this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL']=".$this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL']."<br>\n";
    $txt = str_replace( '*pos_nr*',    ($pos_inx+1), $txt );

//echo "this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL']=".$this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL']."<br>\n";
    if( $this->products_data['order_data'][$pos_inx]['PRODUCTS_ATTRIBUTES_MODEL'] != '' ) {
      $txt = str_replace( '*p_model*',   $this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL'].$this->products_data['order_data'][$pos_inx]['PRODUCTS_ATTRIBUTES_MODEL'], $txt );
    } else {
      $txt = str_replace( '*p_model*',   $this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL'], $txt );
    }
    
    $txt = str_replace( '*p_model_att*', $this->products_data['order_data'][$pos_inx]['PRODUCTS_ATTRIBUTES_MODEL'], $txt );
    $txt = str_replace( '*p_model_org*', $this->products_data['order_data'][$pos_inx]['PRODUCTS_MODEL'], $txt );
    
    $txt = str_replace( '*p_name*',         $this->products_data['order_data'][$pos_inx]['PRODUCTS_NAME'].$this->products_data['order_data'][$pos_inx]['PRODUCTS_ATTRIBUTES'], $txt );
    $txt = str_replace( '*p_price*',        $this->products_data['order_data'][$pos_inx]['PRODUCTS_PRICE'], $txt );
    $txt = str_replace( '*p_single_price*', $this->products_data['order_data'][$pos_inx]['PRODUCTS_SINGLE_PRICE'], $txt );
    $txt = str_replace( '*p_qty*',          $this->products_data['order_data'][$pos_inx]['PRODUCTS_QTY'], $txt );
//echo "txt2=$txt<br>\n";

    return $txt;
  }  
  
  
  function calc_y_dimension( $offset_y=0, &$pdf ) {
    $ret = $offset_y + s2h($this->font_size);
echo "aaa";    
    return $ret;
  }
  
  
  function max_lines( $content_arr ) {
return 1;    
    $lines=1;
    for( $i=0; $i<$this->cols; $i++ ) {
      $lines = max($lines, sizeof(preg_split("/(\n|\r|\r\n)/", $content_arr[$i])) );
//echo "lines=$lines content_arr[$i]=$content_arr[$i]<br>\n";      
    }
    return $lines;
  }
  
  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {

    
//echo "mk1<br>\n";    
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $col = hex2rgb($this->_border_color);
	    $pdf->SetDrawColor($col[0],$col[1],$col[2]);
      $this->_border = 1;
    }
    
    $line_h = s2h($this->font_size);

    $x = $offset_x + $this->rel_x;
    $y = $offset_y + $this->rel_y;
    $lc=0;
    
    $pdf->SetXY( $x ,$y );
    $this->format_text($pdf);
//echo "tc=".$this->cols."<br>\n";                                  
    for( $i=1; $i<=$this->cols; $i++ ) {
      $text=$this->parameter_arr[$this->fieldname.'_head_'.$i];
//echo "i= $i txt=".$text."<br>\n";                                  
      $pdf->SetXY( $x ,$y );
      $width = $this->parameter_arr[$this->fieldname.'_width_'.$i]; 
      $pdf->Cell( $width, $line_h, $text, $this->_border, 2, $this->position );
      
      $x+=$width;
    }
    $y+=$line_h;
    
    $content_arr_arr = $this->_content();
    
    $this->finish=true; // default
    for( $ds = $this->_content_counter; $ds < sizeof($content_arr_arr); $ds++ ) {
      $content_arr=$content_arr_arr[$ds];
      $x = $offset_x + $this->rel_x;
      $lines=1; //$this->max_lines($content_arr);
      for( $i=0; $i<$this->cols; $i++ ) {
        $align = $this->parameter_arr[$this->fieldname.'_align_'.($i+1)];
        $pdf->SetXY( $x ,$y );
        $width = $this->parameter_arr[$this->fieldname.'_width_'.($i+1)];
        
        $txt = $content_arr[$i];
        $cl=$pdf->MultiCell_ycalc($width,$line_h,$txt,$this->_border,$align)/$line_h;
        $lines=max( $lines, $cl);
//        $x+=$width;
      }
      
      if( isset($content_arr_arr[$ds+1])) {
//        $lines=$this->max_lines($content_arr_arr[$ds+1]);
        if( ($y+($lines*$line_h))>$pdf->PageBreakTrigger ) {
          $this->finish=false; // default
          break;
        }
      }
      
            
      for( $i=0; $i<$this->cols; $i++ ) {
        $align = $this->parameter_arr[$this->fieldname.'_align_'.($i+1)];

        $pdf->SetXY( $x ,$y );
        $width = $this->parameter_arr[$this->fieldname.'_width_'.($i+1)];
        
        $txt = $content_arr[$i];

        $pdf->MultiCell( $width , $line_h, $txt,0 /*$this->_border*/, $align );
        if( $this->_border ) {
          $pdf->rect($x, $y, $width, $line_h*$lines);
        }
//            MultiCell(float w , float h, string txt, mixed border  , string align, integer fill)
        $x+=$width;
      }      
      
      $y+=$lines*$line_h;


//echo "weiter y=$y<br>";      
    }
    
    $this->_content_counter = $ds;
    $pdf->SetY( $y );
                
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $this->_debuginfo( $pdf, $offset_x, $offset_y );
    }
  }
    

  
}    
    
    
    
    
    
    
/* --------------------------------------------------------------------------------------------------
     class data_cell_datafields            - Datenfelder (9)
     
     class data_cell_text       - Text 
     
     Parameterauswertung:
       <feldname>_display            1/0 - Darstellung Ja/Nein
       <feldname>_horizontal         relative x-Position
       <feldname>_vertical           relative y-Position
       <feldname>_width              Breite
       
       <feldname>_text               Inhaltstext
       
      Linke Spalte: 
       <feldname>_color              RGB Schriftfarbe (z.B. "#AA22CC")
       <feldname>_position           Ausrichtung ('L', 'C', 'R' )
       <feldname>_font_type          Schriftart (z.B. "arial")
       <feldname>_font_style         Array, Schriftstil (z.B. array('B', 'I', 'U') )
       <feldname>_font_size          Schriftgroesse

      Rechte Spalte: 
       <feldname>_color2             RGB Schriftfarbe (z.B. "#AA22CC")
       <feldname>_position2          Ausrichtung ('L', 'C', 'R' )
       <feldname>_font_type2         Schriftart (z.B. "arial")
       <feldname>_font_style2        Array, Schriftstil (z.B. array('B', 'I', 'U') )
       <feldname>_font_size2         Schriftgroesse
   -------------------------------------------------------------------------------------------------- */
class data_cell_datafields extends data_cell_text {
  var $position2,
      $font_color2,
      $font_type2,
      $font_style2,
      $font_size2;
      
  function data_cell_datafields( $fieldname, &$products_data, &$parameter_arr) {
    $this->data_cell_text( $fieldname, $products_data, $parameter_arr );

    $this->position2      = $this->parameter_arr[$fieldname.'_position2']    == '' ? DATA_CELL_POSITION : $this->parameter_arr[$fieldname.'_position2'] ;
    $this->font_color2    = $this->parameter_arr[$fieldname.'_font_color2']  == '' ? DATA_CELL_FONT_COLOR : $this->parameter_arr[$fieldname.'_font_color2'] ;
    $this->font_type2     = $this->parameter_arr[$fieldname.'_font_type2']   == '' ? DATA_CELL_FONT_TYPE  : $this->parameter_arr[$fieldname.'_font_type2'] ;
    $this->font_style2    = $this->parameter_arr[$fieldname.'_font_style2']  == '' ? DATA_CELL_FONT_STYLE : $this->parameter_arr[$fieldname.'_font_style2'] ;
    $this->font_size2     = $this->parameter_arr[$fieldname.'_font_size2']   == '' ? DATA_CELL_FONT_SIZE  : $this->parameter_arr[$fieldname.'_font_size2'] ;

    $w_arr = explode( ',', $this->parameter_arr[$fieldname.'_width']);
    if( ($w_arr[0]>0) && ($w_arr[1]>0) ) {
      $this->width=$w_arr[0]+$w_arr[1];
      $this->w1=$w_arr[0];
      $this->w2=$w_arr[1];
    }
  } 
  
     
  function format_text2(&$pdf) {
//echo "<pre>"; print_r($this->parameter_arr); echo "</pre>";
    $col = hex2rgb($this->font_color2);
	  $pdf->SetTextColor($col[0],$col[1],$col[2]);
    
    if( is_array($this->font_style2) ) {
      $fs=implode('', $this->font_style2);
    }
		$pdf->SetFont($this->font_type2,$fs,$this->font_size2);
  
	}
  
  
  function _content() {
//echo "<pre>"; print_r($this->parameter_arr); echo "</pre>";
    $count=0;

    $ret = array();
    for($i=0; $this->parameter_arr[$this->fieldname.'_text_'.($i+1)] !=''; $i++) {
      $ret[$i]['text']=$this->parameter_arr[$this->fieldname.'_text_'.($i+1)];
      $ret[$i]['value']=$this->replace_data( $this->parameter_arr[$this->fieldname.'_value_'.($i+1)] );
    }
    
    return $ret;
  }
  
/*
  function calc_y_dimension_xxxxxxxxxxxxxxxxx( $offset_y=0, &$pdf ) {
    $ret = $offset_y;
    
    if($this->display) {                                        // if displayed
      $line_h = max(s2h($this->font_size), s2h($this->font_size2) );
      $ret += $this->rel_y + sizeof($this->_content()) * $line_h;
    }    
    return $ret;
  }
  
*/
  function calc_y_dimension( $offset_y=0, &$pdf ) {
    $ret = $offset_y;
    if(!$this->display) {                                        // if displayed
      return $ret;
    }
    
    $content = $this->_content();


    $x = $offset_x + $this->rel_x;
    $y = $offset_y + $this->rel_y;
    $lc=0;
    
    if( isset($this->w1) ) {
      $w1= $this->w1;
      $w2= $this->w2;
    } else {
      $w1= $this->width/2;
      $w2= $this->width/2;
    }
    reset( $content );
    $y=0;
		foreach( $content as $content_field ) {    
//echo "<pre>"; print_r($content_field); echo "</pre>";    
      if( $this->_border == 1 ) {
        $border1='L';
        $border2='R';
        if( $lc==0 ) {
          $border1.='T';
          $border2.='T';
        } else if ($lc==(sizeof($content)-1)) {
          $border1.='B';
          $border2.='B';
        }
      } else {
        $border1=0;
        $border2=0;
      }

      $sy1=$pdf->MultiCell_ycalc( $w1, $line_h, $content_field['text'], $border1, $this->position );
      $sy2=$pdf->MultiCell_ycalc( $w2, $line_h, $content_field['value'], $border2, $this->position2 );

      $y += max($sy1, $sy);
    }
    
    $ret+=$y;
    
    return $ret;
                

  }



  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {
    if(!$this->display) {                                        // if displayed
      return;
    }

    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $col = hex2rgb($this->_border_color);
	    $pdf->SetDrawColor($col[0],$col[1],$col[2]);
      $this->_border = 1;
    }
    
    $content = $this->_content();
    $line_h = max(s2h($this->font_size), s2h($this->font_size2) );

    $x = $offset_x + $this->rel_x;
    $y = $offset_y + $this->rel_y;
    $lc=0;
    
    if( isset($this->w1) ) {
      $w1= $this->w1;
      $w2= $this->w2;
    } else {
      $w1= $this->width/2;
      $w2= $this->width/2;
    }
    reset( $content );
		foreach( $content as $content_field ) {    
//echo "<pre>"; print_r($content_field); echo "</pre>";    
      if( $this->_border == 1 ) {
        $border1='L';
        $border2='R';
        if( $lc==0 ) {
          $border1.='T';
          $border2.='T';
        } else if ($lc==(sizeof($content)-1)) {
          $border1.='B';
          $border2.='B';
        }
      } else {
        $border1=0;
        $border2=0;
      }
      $sy1=$pdf->MultiCell_ycalc( $w1, $line_h, $content_field['text'], $border1, $this->position );
      $sy2=$pdf->MultiCell_ycalc( $w2, $line_h, $content_field['value'], $border2, $this->position2 );

      if( $sy1>$sy2 ) {
        $diff_lines = ($sy1-$sy2)/$line_h;
        $content_field['value'].=str_repeat("\n ", $diff_lines);
        $sy1=$pdf->MultiCell_ycalc( $w1, $line_h, $content_field['text'], $border1, $this->position );
        $sy2=$pdf->MultiCell_ycalc( $w2, $line_h, $content_field['value'], $border2, $this->position2 );
      } else if( $sy2>$sy1 ) {
        $diff_lines = ($sy2-$sy1)/$line_h;
        $content_field['text'].=str_repeat("\n ", $diff_lines);
        $sy1=$pdf->MultiCell_ycalc( $w1, $line_h, $content_field['text'], $border1, $this->position );
        $sy2=$pdf->MultiCell_ycalc( $w2, $line_h, $content_field['value'], $border2, $this->position2 );
      }

      
      $pdf->SetXY( $x ,$y ); 
 	    $this->format_text($pdf);
//		  $pdf->Cell( $w1, $line_h, $content_field['text'], $border1, 0, $this->position );
		  $pdf->MultiCell( $w1, $line_h, $content_field['text'], $border1, $this->position );

      $pdf->SetXY( $x+$w1 ,$y ); 
 	    $this->format_text2($pdf);
//		  $pdf->Cell( $w2, $line_h, $content_field['value'], $border2, 0, $this->position2 );
		  $pdf->MultiCell( $w2, $line_h, $content_field['value'], $border2, $this->position2 );
                
//      $y += $line_h;

      $y += max($sy1, $sy);
      $lc++;
    }
                
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $this->_debuginfo( $pdf, $offset_x, $offset_y );
    }
  }
  

  
}

    
    

    
/* --------------------------------------------------------------------------------------------------
     class data_cell_resumefields            - Summenfelder (12)
     
     class data_cell_text       - Text 
     
     Parameterauswertung:
       <feldname>_display            1/0 - Darstellung Ja/Nein
       <feldname>_horizontal         relative x-Position
       <feldname>_vertical           relative y-Position
       <feldname>_width              Breite
       
       <feldname>_text               Inhaltstext
       
      Linke Spalte: 
       <feldname>_color              RGB Schriftfarbe (z.B. "#AA22CC")
       <feldname>_position           Ausrichtung ('L', 'C', 'R' )
       <feldname>_font_type          Schriftart (z.B. "arial")
       <feldname>_font_style         Array, Schriftstil (z.B. array('B', 'I', 'U') )
       <feldname>_font_size          Schriftgroesse

      Rechte Spalte: 
       <feldname>_color2             RGB Schriftfarbe (z.B. "#AA22CC")
       <feldname>_position2          Ausrichtung ('L', 'C', 'R' )
       <feldname>_font_type2         Schriftart (z.B. "arial")
       <feldname>_font_style2        Array, Schriftstil (z.B. array('B', 'I', 'U') )
       <feldname>_font_size2         Schriftgroesse
   -------------------------------------------------------------------------------------------------- */
class data_cell_resumefields extends data_cell_datafields {
  var $position2,
      $font_color2,
      $font_type2,
      $font_style2,
      $font_size2;


  

      
  function _content() {
//echo "<pre>"; print_r($this->parameter_arr); echo "</pre>";
/*
    $ret = array( 'field_1'  => array (
                    'text'     => $this->parameter_arr[$this->fieldname.'_text_1'],
                    'value'    => $this->parameter_arr[$this->fieldname.'_value_1'] ),
                  'field_2'  => array (
                    'text'     => $this->parameter_arr[$this->fieldname.'_text_2'],
                    'value'    => $this->parameter_arr[$this->fieldname.'_value_2'] ),  
                  'field_3'  => array (
                    'text'     => $this->parameter_arr[$this->fieldname.'_text_3'],
                    'value'    => $this->parameter_arr[$this->fieldname.'_value_3'] ),
                  'field_4'  => array (
                    'text'     => $this->parameter_arr[$this->fieldname.'_text_4'],
                    'value'    => $this->parameter_arr[$this->fieldname.'_value_4'] )
                 );
*/
    $ret = array();
//echo "<pre>"; print_r($this->products_data['order_total']); echo "</pre>";
    foreach( $this->products_data['order_total'] as $tot_line ) {
      $text = decode_entities($tot_line['TITLE']);
      
      $ret[] = array( 'text'    => strip_tags($text),
                      'value'   => strip_tags($tot_line['TEXT'])    );
    }
//echo "<pre>"; print_r($ret); echo "</pre>";
    
    return $ret;
  }
  
  
 


  
}
    
    
/* --------------------------------------------------------------------------------------------------
     class data_cell            - Basisklasse
     
     Parameterauswertung:
       <feldname>_display            1/0 - Darstellung Ja/Nein
       <feldname>_horizontal         relative x-Position
       <feldname>_vertical           relative y-Position
       <feldname>_width              Breite
       <feldname>_height               Hoehe
   -------------------------------------------------------------------------------------------------- */
class data_cell {
  var $fieldname,
      $products_data,
      $parameter_arr,
      
      $rel_x, $rel_y, 
      $width, $height,
      
      $indexnumber=0,
      $parent_indexnumber=0,
      
      $display=false;
      
  var $_border       = DEFAULT_BORDER,
      $_border_color = DEFAULT_BORDER_COLOR;
      
      
  function data_cell( $fieldname, &$products_data, &$parameter_arr) {
    $this->fieldname     = $fieldname;
    $this->products_data = &$products_data;
    $this->parameter_arr = &$parameter_arr;
    
    $this->rel_x         = $this->parameter_arr[$fieldname.'_horizontal']==''  ?  0 : $this->parameter_arr[$fieldname.'_horizontal'];
    $this->rel_y         = $this->parameter_arr[$fieldname.'_vertical']  ==''  ?  0 : $this->parameter_arr[$fieldname.'_vertical']  ;
    $this->width         = $this->parameter_arr[$fieldname.'_width'] == '' ? DATA_CELL_WIDTH : $this->parameter_arr[$fieldname.'_width'] ;
    $this->height        = $this->parameter_arr[$fieldname.'_height']  == '' ? DATA_CELL_HEIGHT  : $this->parameter_arr[$fieldname.'_height'] ;

    $this->display       = $this->parameter_arr[$fieldname.'_display'] == '1' ? true:false; // default visible

    $this->indexnumber        = (int) $this->parameter_arr[$fieldname.'_indexnumber'];
    $this->parent_indexnumber = (int) $this->parameter_arr[$fieldname.'_parent_indexnumber'];
    
  } 
  
  function reinit( &$products_data, &$parameter_arr) {
    $this->products_data = &$products_data;
//    $this->data_cell( $this->fieldname, $products_data, $parameter_arr );
  }
      
  function _content() {
    return '';
  }
  
  function replace_data( $txt ) {
//echo "<pre>"; print_r( $this->products_data ); echo "</pre>";   
    $billnr = make_billnr($this->products_data['ibn_billdate'], $this->products_data['ibn_billnr']);
    $date_now = date(DATE_FORMAT);
    
    
    $raw_date = $this->products_data['ibn_billdate'];
    $year = substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $date_invoice = date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
    
    $raw_date = $this->products_data['order']->info['date_purchased'];
    $year = substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $date_order = date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
    
    $txt = str_replace( '*date*',          $date_now, $txt );
    $txt = str_replace( '*date_order*',    $date_order, $txt );
    $txt = str_replace( '*date_invoice*',  $this->products_data['DATE_INVOICE'], $txt );
    $txt = str_replace( '*payment_method*',$this->products_data['PAYMENT_METHOD'], $txt );
    $txt = str_replace( '*vat_id*',        $this->products_data['order']->customer['vat_id'], $txt );
    $txt = str_replace( '*ust_id*',        $this->products_data['order']->customer['vat_id'], $txt );
//echo "<pre>"; print_r($this->products_data['oID']); echo "</pre>"; die;
    $txt = str_replace( '*date_delivery*',$this->products_data['delivery_date'], $txt );
    
    //    $txt = str_replace( '*orders_id*',     $this->products_data['oID'], $txt );
    $txt = str_replace( '*orders_id*',     $billnr, $txt );
    $txt = str_replace( '*orders_id_sys*', $this->products_data['oID'], $txt );
    $txt = str_replace( '*customers_id*',  $this->products_data['order']->customer['id'], $txt );
    
    $txt=strip_tags($txt);
    $txt=decode_entities($txt);
    
    return $txt;
  }
    
  function calc_y_dimension( $offset_y=0, &$pdf ) {
    $ret = $offset_y;
    if($this->display) {                                        // if displayed
      $ret += $this->rel_y + $this->height;
    }    
    return $ret;
  }
  
  function outbuffer( &$pdf, $offset_x=0, $offset_y=0 ) {
    if(!$this->display) {                                        // if displayed
      return;
    }
    
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $col = hex2rgb($this->_border_color);
	    $pdf->SetDrawColor($col[0],$col[1],$col[2]);
      $this->_border = 1;
    }
    
		$pdf->SetXY( $offset_x + $this->rel_x, $offset_y + $this->rel_y); 
		$pdf->Cell( $this->width, $this->height,
                $this->_content(), $this->_border, 0 );
                
    if( $this->parameter_arr['pdfdebug'] == '1' ) {
      $this->_debuginfo( $pdf, $offset_x, $offset_y );
    }
  }
  
  function _debuginfo( &$pdf, $offset_x=0, $offset_y=0 ) {    
    $org_x=$pdf->GetX();
    $org_y=$pdf->GetY();

    $a=$this->fieldname.' ';
    $a.= "x=".$this->rel_x."  y=".$this->rel_y."  w=".$this->width."  h=".$this->height;     
//    $a.=" o_x=".(int)$offset_x."  o_y=".(int)$offset_y;
//    $a.=" in=".$this->indexnumber."  pin=".$this->parent_indexnumber;
    
    $pdf->SetXY( $offset_x + $this->rel_x, $offset_y + $this->rel_y); 
		$pdf->SetFont('arial','',5);
  	$pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor( 255, 255, 0);
// Cell(float w [, float h] [, string txt] [, mixed border] [, integer ln] [, string align] [, integer fill] [, mixed link])
  	$pdf->Cell( 35, 3, $a, 1, 0, 'L', 1);

    $pdf->SetXY( $org_x, $org_y); 
  
  }
  
}


?>
