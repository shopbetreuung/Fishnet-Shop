<?php
define(IPDFBILL_VERSION, 'V1.9.6'); 
define(IPDFBILL_DATE, '20.08.2009');

require_once(DIR_FS_CATALOG.'admin/includes/ipdfbill/classes/fpdf/fpdf.php');

  
class PDF_Clipping extends FPDF
{

  
  function ClippingText($x, $y, $txt, $outline=false)
  {
      $op=$outline ? 5 : 7;
      $this->_out(sprintf('q BT %.2f %.2f Td %d Tr (%s) Tj 0 Tr ET',
          $x*$this->k,
          ($this->h-$y)*$this->k,
          $op,
          $this->_escape($txt)));
  }

  function ClippingRect($x, $y, $w, $h, $outline=false)
  {
      $op=$outline ? 'S' : 'n';
      $this->_out(sprintf('q %.2f %.2f %.2f %.2f re W %s',
          $x*$this->k,
          ($this->h-$y)*$this->k,
          $w*$this->k, -$h*$this->k,
          $op));
  }

  function ClippingEllipse($x, $y, $rx, $ry, $outline=false)
  {
      $op=$outline ? 'S' : 'n';
      $lx=4/3*(M_SQRT2-1)*$rx;
      $ly=4/3*(M_SQRT2-1)*$ry;
      $k=$this->k;
      $h=$this->h;
      $this->_out(sprintf('q %.2f %.2f m %.2f %.2f %.2f %.2f %.2f %.2f c',
          ($x+$rx)*$k, ($h-$y)*$k,
          ($x+$rx)*$k, ($h-($y-$ly))*$k,
          ($x+$lx)*$k, ($h-($y-$ry))*$k,
          $x*$k, ($h-($y-$ry))*$k));
      $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c',
          ($x-$lx)*$k, ($h-($y-$ry))*$k,
          ($x-$rx)*$k, ($h-($y-$ly))*$k,
          ($x-$rx)*$k, ($h-$y)*$k));
      $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c',
          ($x-$rx)*$k, ($h-($y+$ly))*$k,
          ($x-$lx)*$k, ($h-($y+$ry))*$k,
          $x*$k, ($h-($y+$ry))*$k));
      $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c W %s',
          ($x+$lx)*$k, ($h-($y+$ry))*$k,
          ($x+$rx)*$k, ($h-($y+$ly))*$k,
          ($x+$rx)*$k, ($h-$y)*$k,
          $op));
  }

  function UnsetClipping()
  {
      $this->_out('Q');
  }

  function ClippedCell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='')
  {
      if($border || $fill || $this->y+$h>$this->PageBreakTrigger)
      {
          $this->Cell($w, $h, '', $border, 0, '', $fill);
          $this->x-=$w;
      }
      $this->ClippingRect($this->x, $this->y, $w, $h);
      $this->Cell($w, $h, $txt, '', $ln, $align, 0, $link);
      $this->UnsetClipping();
  }


  function ClippedMultiCell($w, $h=0, $lh=4, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='')
  {
      if($border || $fill || $this->y+$h>$this->PageBreakTrigger)
      {
          $this->Cell($w, $h, '', $border, 0, '', $fill);
          $this->x-=$w;
      }
      $this->ClippingRect($this->x, $this->y, $w, $h);
      $this->MultiCell($w, $lh, $txt, $border, $align);
      $this->UnsetClipping();
  }

}






  
class pdfbill_closed extends PDF_Clipping {
	
	/**
	 * Variablen zu TOC
	 *
	 */
   
  var $parameter_arr     = array();    // profile 
  var $orders_id ;  
  var $data = array();
  var $demomode = false;
	
  var $max_height = PAGE_HEIGHT;  

  
  function pdfbill_closed( $parameter_arr, $orders_id, $demomode=false ) {
    parent::PDF_Clipping();
    $this->parameter_arr     = $parameter_arr;
    $this->orders_id         = $orders_id;
    $this->demomode          = $demomode;
    
    $this->AliasNbPages('{np}');
    //$this->AddFont('bauhaus93','','');
    //$this->AddFont('arialroundedmtbold','','');
  }
  

  function MultiCell_ycalc($w,$h,$txt,$border=0,$align='J',$fill=0)
  {
    $yyy1=$this->y; 
    $ysize = 0;
     
	    //Output text with automatic or explicit line breaks
	    $cw=&$this->CurrentFont['cw'];
	    if($w==0)
		    $w=$this->w-$this->rMargin-$this->x;
	    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	    $s=str_replace("\r",'',$txt);
	    $nb=strlen($s);
	    if($nb>0 && $s[$nb-1]=="\n")
		    $nb--;
	    $b=0;
	    if($border)
	    {
		    if($border==1)
		    {
			    $border='LTRB';
			    $b='LRT';
			    $b2='LR';
		    }
		    else
		    {
			    $b2='';
			    if(strpos($border,'L')!==false)
				    $b2.='L';
			    if(strpos($border,'R')!==false)
				    $b2.='R';
			    $b=(strpos($border,'T')!==false) ? $b2.'T' : $b2;
		    }
	    }
	    $sep=-1;
	    $i=0;
	    $j=0;
	    $l=0;
	    $ns=0;
	    $nl=1;
	    while($i<$nb)
	    {
		    //Get next character
		    $c=$s{$i};
		    if($c=="\n")
		    {
			    //Explicit line break
			    if($this->ws>0)
			    {
				    $this->ws=0;
    //				$this->_out('0 Tw');
			    }
    //			$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
    $this->y += $h;
    if( ($ysize+$h) > $this->max_height ) break;
    $ysize += $h;
			    $i++;
			    $sep=-1;
			    $j=$i;
			    $l=0;
			    $ns=0;
			    $nl++;
			    if($border && $nl==2)
				    $b=$b2;
			    continue;
		    }
		    if($c==' ')
		    {
			    $sep=$i;
			    $ls=$l;
			    $ns++;
		    }
		    $l+=$cw[$c];
		    if($l>$wmax)
		    {
			    //Automatic line break
			    if($sep==-1)
			    {
				    if($i==$j)
					    $i++;
				    if($this->ws>0)
				    {
					    $this->ws=0;
    //					$this->_out('0 Tw');
				    }
    //				$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
    $this->y += $h;
    if( ($ysize+$h) > $this->max_height ) break;
    $ysize += $h;
			    }
			    else
			    {
				    if($align=='J')
				    {
					    $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
    //					$this->_out(sprintf('%.3f Tw',$this->ws*$this->k));
				    }
    //				$this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
    $this->y += $h;
    $ysize += $h;
				    $i=$sep+1;
			    }
			    $sep=-1;
			    $j=$i;
			    $l=0;
			    $ns=0;
			    $nl++;
			    if($border && $nl==2)
				    $b=$b2;
		    }
		    else
			    $i++;
	    }
	    //Last chunk
	    if($this->ws>0)
	    {
		    $this->ws=0;
//		    $this->_out('0 Tw');
	    }
	    if($border && strpos($border,'B')!==false)
		    $b.='B';
    //	$this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
    $this->y += $h;
    $ysize += $h;
	    $this->x=$this->lMargin;

    $yyy2 = $this->y;
    return $yyy2-$yyy1;  
  }
  
  
  
  function MultiCell_xx($w,$h,$txt,$border=0,$align='J',$fill=0)
  {
    $ysize=$this->y;
    $breakstop=false;
	  //Output text with automatic or explicit line breaks
	  $cw=&$this->CurrentFont['cw'];
	  if($w==0)
		  $w=$this->w-$this->rMargin-$this->x;
	  $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	  $s=str_replace("\r",'',$txt);
	  $nb=strlen($s);
	  if($nb>0 && $s[$nb-1]=="\n")
		  $nb--;
	  $b=0;
	  if($border)
	  {
		  if($border==1)
		  {
			  $border='LTRB';
			  $b='LRT';
			  $b2='LR';
		  }
		  else
		  {
			  $b2='';
			  if(strpos($border,'L')!==false)
				  $b2.='L';
			  if(strpos($border,'R')!==false)
				  $b2.='R';
			  $b=(strpos($border,'T')!==false) ? $b2.'T' : $b2;
		  }
	  }
	  $sep=-1;
	  $i=0;
	  $j=0;
	  $l=0;
	  $ns=0;
	  $nl=1;
	  while($i<$nb)
	  {
		  //Get next character
		  $c=$s{$i};
		  if($c=="\n")
		  {
			  //Explicit line break
			  if($this->ws>0)
			  {
				  $this->ws=0;
				  $this->_out('0 Tw');
			  }
        if( ($ysize+2*$h) > $this->PageBreakTrigger ) {
	        if($border && strpos($border,'B')!==false)
		        $b.='B';
	        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
          $breakstop = true;
          break;
        } else {
          $ysize += $h;
			        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
        }
			  $i++;
			  $sep=-1;
			  $j=$i;
			  $l=0;
			  $ns=0;
			  $nl++;
			  if($border && $nl==2)
				  $b=$b2;
			  continue;
		  }
		  if($c==' ')
		  {
			  $sep=$i;
			  $ls=$l;
			  $ns++;
		  }
		  $l+=$cw[$c];
		  if($l>$wmax)
		  {
			  //Automatic line break
			  if($sep==-1)
			  {
				  if($i==$j)
					  $i++;
				  if($this->ws>0)
				  {
					  $this->ws=0;
					  $this->_out('0 Tw');
				  }
          if( ($ysize+2*$h) > $this->PageBreakTrigger ) {
	          if($border && strpos($border,'B')!==false)
		          $b.='B';
	          $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
            $breakstop = true;
            break;
          } else {
            $ysize += $h;
				          $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
          }

			  }
			  else
			  {
				  if($align=='J')
				  {
					  $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
					  $this->_out(sprintf('%.3f Tw',$this->ws*$this->k));
				  }
          if( ($ysize+2*$h) > $this->PageBreakTrigger ) {
	          if($border && strpos($border,'B')!==false)
		          $b.='B';
	          $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
            $breakstop = true;
            break;
          } else {
            $ysize += $h;
				          $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
          }
				  $i=$sep+1;
			  }
			  $sep=-1;
			  $j=$i;
			  $l=0;
			  $ns=0;
			  $nl++;
			  if($border && $nl==2)
				  $b=$b2;
		  }
		  else
			  $i++;
	  }
	  //Last chunk
	  if($this->ws>0)
	  {
		  $this->ws=0;
		  $this->_out('0 Tw');
	  }
    if( !$breakstop ) {
	    if($border && strpos($border,'B')!==false)
		    $b.='B';
	    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
    }  
	  $this->x=$this->lMargin; 
  }
  


  function Image($file,$x,$y,$w=0,$h=0,$type='',$link='')
  {
	  //Put an image on the page
	  if(!isset($this->images[$file]))
	  {
		  //First use of image, get info
		  if($type=='')
		  {
			  $pos=strrpos($file,'.');
			  if(!$pos)
				  $this->Error('Image file has no extension and no type was specified: '.$file);
			  $type=substr($file,$pos+1);
		  }
		  $type=strtolower($type);
		  $mqr=get_magic_quotes_runtime();
		  //set_magic_quotes_runtime(0);
		  if($type=='jpg' || $type=='jpeg')
			  $info=$this->_parsejpg($file);
		  elseif($type=='png')
			  $info=$this->_parsepng($file);
		  else
		  {
			  //Allow for additional formats
			  $mtd='_parse'.$type;
			  if(method_exists($this,$mtd)) {
  			  $info=$this->$mtd($file);
        } else {
          return;
        }
		  }
		  //set_magic_quotes_runtime($mqr);
		  $info['i']=count($this->images)+1;
		  $this->images[$file]=$info;
	  }
	  else
		  $info=$this->images[$file];
	  //Automatic width and height calculation if needed
	  if($w==0 && $h==0)
	  {
		  //Put image at 72 dpi
		  $w=$info['w']/$this->k;
		  $h=$info['h']/$this->k;
	  }
	  if($w==0)
		  $w=$h*$info['w']/$info['h'];
	  if($h==0)
		  $h=$w*$info['h']/$info['w'];
	  $this->_out(sprintf('q %.2f 0 0 %.2f %.2f %.2f cm /I%d Do Q',$w*$this->k,$h*$this->k,$x*$this->k,($this->h-($y+$h))*$this->k,$info['i']));
	  if($link)
		  $this->Link($x,$y,$w,$h,$link);
  }
	
  
  function getAttributesCount($pID) {

		$products_attributes_query = xtDBquery("select count(*) as total from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".$pID."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."'");
		$products_attributes = xtc_db_fetch_array($products_attributes_query, true);
		return $products_attributes['total'];

	}
  
	function xtc_get_vpe_name($vpeID, $lang_id) {
   	
   	  $vpe_query="SELECT 
                    products_vpe_name 
                  FROM " . 
                    TABLE_PRODUCTS_VPE . " 
                  WHERE 
                    language_id='".$lang_id."' and 
                    products_vpe_id='".$vpeID."'";
   	  $vpe_query = xtDBquery($vpe_query);
   	  $vpe = xtc_db_fetch_array($vpe_query,true);
   	  return $vpe['products_vpe_name'];
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

 	/**
 	 * Seite formatieren und mit Werten aus dem Array data abfüllen
 	 *
 	 */
  function trennlinie() {
    $this->SetLineWidth(0.2);
  	$this->SetDrawColor(0,0,0);
		$this->line($this->lMargin,$this->GETY(),$this->w-$this->rMargin,$this->GETY());
  }
  
	function format_text($header_font_style,$header_color,$header_font_type,$header_font_size) {  /* Normaler Text */
    if( is_array($header_font_style) ) {
      $header_font_style=implode('',$header_font_style);
    }
    $header_color = $this->hex2rgb($header_color);
	  $this->SetTextColor($header_color[0],$header_color[1],$header_color[2]);
    $this->SetFont($header_font_type,$header_font_style,$header_font_size);
	}

  
  function AddPage( $orientation='', $header=false, $categories_name='' ) {
    parent::AddPage($orientation);
    if( $this->parameter_arr['bgimage_display']=='1' ) {
      $file = PDF_IMAGE_DIR.$this->parameter_arr['bgimage_image'];
      if( file_exists($file) ) {
        $i=getimagesize($file);
        $px=($this->w-$i[0]/$this->k)/2;
        $py=($this->h-$i[1]/$this->k)/2;
        if( $px<0 ) $px=0;
        if( $py<0 ) $py=0;
        $this->Image($file, $px, $py );
      } else {   // file not exists
        $this->format_text( '',
                            '#000000',                        
                            'arial',
                            10  );       
        $this->Cell(50, 30, 'Error: File '.DECKBLATT.' doesn\'t exists.' );
      }
    }
    if( $this->parameter_arr['grids'] == '1' ) {
      $this->draw_grids();
    }
    
    if( $this->demomode ) {
//      $this->demoinfo();
    }
    
  }
  
  function demoinfo() {
    $x_org = $this->GetX();
    $y_org = $this->GetY();

    $this->setXY(20, 80);
    $this->SetFont('Arial', 'B', 124);
    $col = hex2rgb('cccccc');
	  $this->SetTextColor($col[0],$col[1],$col[2]);     
    $this->Write(10, DEMOTEXT);
//    $this->Cell($w, $h, DEMOTEXT, 0, 0, 'C');
    
    
    $this->setXY($x_org, $y_org);
    
  }
  
  
  function draw_grids() {
    $x_org = $this->GetX();
    $y_org = $this->GetY();
    
    $this->SetDrawColor(200,200,200);
    for( $y=$y_org; $y<($this->h-$this->bMargin); $y+=10 ) {
      $this->line($this->lMargin,$y,$this->w-$this->rMargin,$y);
    }
    
    for( $x=$x_org; $x<$this->w; $x+=10 ) {
      $this->line($x, $y_org, $x, $this->h-$this->bMargin);
    }
  }
  
  
  function Footer() {
//    if( $this->numPageNo() == 0 ) {
//      return;
//    }
    $blocks = 0;
    for( $i=1; $i<=COUNT_FOOTERBLOCKS; $i++ ) {
      if( $this->parameter_arr['footer_display_'.$i]=='1' ) {
        $blocks++;
      }
    }
  
    if( ($this->parameter_arr['footer_display']=='1') && ($blocks>0) ) {
      //Go to 1.5 cm from bottom
      $block_w = ($this->w-$this->lMargin-$this->rMargin)/$blocks;
      $block_hl = s2h($this->parameter_arr['footer_font_size']);
      $block_h = $hl * $blocks;
      
      $this->SetY(-20);
      
      $x=$this->lMargin;
      $y=$this->getY();
      $this->format_text( $this->parameter_arr['footer_font_style'],
                          $this->parameter_arr['footer_font_color'],                        
                          $this->parameter_arr['footer_font_type'],
                          $this->parameter_arr['footer_font_size'] );

      for( $i=1; $i<=$blocks; $i++ ) {
        $text = $this->parameter_arr['footer_text_'.$i];
        $this->SetXY($x, $y);
        $this->MultiCell($block_w , $block_hl, 
                         $text, DEFAULT_BORDER, $this->parameter_arr['footer_position_'.$i] );
        $x+=$block_w;
      }
      
      return;

      $col = hex2rgb(DEFAULT_BORDER_COLOR);
      $this->SetDrawColor($col[0],$col[1],$col[2]);
      $this->Cell( 0, $this->parameter_arr['product_footer_height'], 
                   $text, 
                   DEFAULT_BORDER, 0, $this->parameter_arr['product_footer_position']  );
//      if($this->_numbering==false)
//        $this->_numberingFooter=false;
    }
  }
  
  function format() {
//defpr( $this->parameter_arr );
    $this->AddPage();                                // neue seite
    if( $this->demomode ) {
      $this->demoinfo();
    }
    
    $prod_start_x = $this->GetX();
    $prod_start_y = $this->GetY();
      
    $cluster_start = new cell_cluster_start( $this->data, $this->parameter_arr, $this );
    $cluster_list =  new cell_cluster_list( $this->data, $this->parameter_arr, $this );
    $cluster_end  =  new cell_cluster_end( $this->data, $this->parameter_arr, $this );

    $cluster_start->outbuffer($this, $prod_start_x, $prod_start_y );
    $cluster_list->outbuffer($this, $prod_start_x, $prod_start_y );
    $cluster_end->outbuffer($this, $this->lMargin, $this->GetY() );

    // --------------- Anlage ---------------------------------------
    if( $this->parameter_arr['terms_display']=='1' ) {
      $this->AddPage();                                // neue seite
      if( file_exists(ATTACHMENT_TXT) ) {
        // --- headline ---------                                                                                  
        $font_color    = $this->parameter_arr['terms_font_color']       == '' ? DATA_CELL_FONT_COLOR     : $this->parameter_arr['terms_font_color']          ;         
        $font_type     = $this->parameter_arr['terms_font_type']        == '' ? DATA_CELL_FONT_TYPE      : $this->parameter_arr['terms_font_type']      ;
        $font_style    = $this->parameter_arr['terms_head_font_style']  == '' ? DATA_CELL_FONT_STYLE     : $this->parameter_arr['terms_head_font_style'];
        $font_size     = $this->parameter_arr['terms_head_font_size']   == '' ? DATA_CELL_FONT_SIZE      : $this->parameter_arr['terms_head_font_size'] ;
        $position      = $this->parameter_arr['terms_head_position']    == '' ? DATA_CELL_FONT_POSITION  : $this->parameter_arr['terms_head_position']  ;
                                                                                                                   
	     //function format_text($header_font_style,$header_color,$header_font_type,$header_font_size) { 
        $this->format_text( $font_style,                                 
                            $font_color,                                           
                            $font_type,
                            $font_size  );       
//        Cell(float w [, float h] [, string txt] [, mixed border] [, integer ln] [, string align] [, integer fill] [, mixed link])
        $this->Cell( 0, 20, //s2h($font_size), 
                     $this->parameter_arr['terms_formtext'], DEFAULT_BORDER, 2, 
                     $position );

        // --- content ---------
//        $font_color    = $this->parameter_arr['product_terms_font_color']       == '' ? DATA_CELL_FONT_COLOR     : $this->parameter_arr['product_terms_font_color']          ;         
//        $font_type     = $this->parameter_arr['product_terms_font_type']   == '' ? DATA_CELL_FONT_TYPE      : $this->parameter_arr['product_terms_font_type']      ;
        $font_style    = $this->parameter_arr['terms_font_style']  == '' ? DATA_CELL_FONT_STYLE     : $this->parameter_arr['terms_font_style'];
        $font_size     = $this->parameter_arr['terms_font_size']   == '' ? DATA_CELL_FONT_SIZE      : $this->parameter_arr['terms_font_size'] ;
        $position      = $this->parameter_arr['terms_position']    == '' ? DATA_CELL_FONT_POSITION  : $this->parameter_arr['terms_position']  ;

        $this->format_text( $font_style,
                            $font_color,                        
                            $font_type,
                            $font_size  );       

        $txt = "\n".implode( '', file(ATTACHMENT_TXT) );

       // MultiCell(float w , float h , string txt [, mixed border] [, string align] [, integer fill])
//        $this->MultiCell( 0, s2h($font_size), 
//                          $txt, 0, 2, 
//                          $position );
                     
//        Write(float h , string txt [, mixed link])

        $this->Write( s2h($this->parameter_arr['terms_font_size']), $txt);
        
        
      } else {   // file not exists

        $this->format_text( '', '#000000', 'arial', 10  );       
        $this->Cell(50, 30, 'Error: File '.ATTACHMENT_TXT.' doesn\'t exists.' );
      }
    }
  
  }
  
  

  function format_old() {
    //defpr( $this->parameter_arr );
    
    // --------------- Deckblatt ---------------------------------------
    if( $this->parameter_arr['deckblatt']=='1' ) {
      $this->AddPage();                                // neue seite
      if( file_exists(DECKBLATT) ) {
        $i=getimagesize(DECKBLATT);
        $px=($this->w-$i[0]/$this->k)/2;
        $py=($this->h-$i[1]/$this->k)/2;
        if( $px<0 ) $px=0;
        if( $py<0 ) $py=0;
        $this->Image(DECKBLATT, $px, $py );
      } else {   // file not exists
        $this->format_text( '',
                            '#000000',                        
                            'arial',
                            10  );       
        $this->Cell(50, 30, 'Error: File '.DECKBLATT.' doesn\'t exists.' );
      }
    }
    

    // --------------- Pages ---------------------------------------
    $cluster = new cell_cluster( $product_data, $this->parameter_arr, $this );
    
    $this->format_sortData();
    $this->make_categorie_path_txt(21);
    
    $this->startPageNums();
 		foreach( $this->data as $ii => $product_data ) {
      $toc_entry = false;
      $new_page=false;

      $cluster->reinit( $product_data );                                 // Datenzellen Prod. Daten uebergeben

      if(  $categories_name != $product_data['categories_name'] ) {      // Kategoriewechesel und Ermittlung 1. Seite
        $new_page=true;
        $toc_entry = true;
      }
      $categories_name = $product_data['categories_name'];              
      
      $y_next=$cluster->calc_y_dimension(0, $this);    // unteres Ende bestimmen 
      if( ($y_next+$this->prod_start_y) > $this->PageBreakTrigger) {                                 // zu gross oder erste Seite 
        $new_page=true;
      }
      $y_next+=$this->prod_start_y;
      
      if( $new_page ) {                                                  // Kriterium neue Seite

        $cpt_arr = $this->make_categorie_path_txt( $product_data['categories_id']);     
        $cpi_arr = $this->make_categorie_path_id( $product_data['categories_id']);     

        $s= implode(' - ', $cpt_arr);
        
        $this->AddPage('', true, $s );                                // neue seite
        if( $toc_entry && ($this->parameter_arr['product_content']=='1') ) {
          $deep = sizeof($cp_arr)-1;
          $this->TOC_Entry($cpt_arr, $cpi_arr);
        }
        $this->prod_start_x = $this->GetX();
        $this->prod_start_y = $this->GetY();
        $y_next=$cluster->calc_y_dimension($this->prod_start_y, $this);     
      }
      
      $cluster->outbuffer($this, $this->prod_start_x, $this->prod_start_y );
      $this->SetXY($this->lMargin, $y_next);                           // index startpos. setzen
      $this->prod_start_x = $this->GetX();
      $this->prod_start_y = $this->GetY();
      $this->trennlinie();

    }
            
    // --------------- Inhalt ---------------------------------------
    if( $this->parameter_arr['product_content']=='1' ) {
      $this->insertTOC( $this->page+1,                                            // $location=1,                      
                        $this->parameter_arr["product_content_head_font_size"],   // $labelSize=20,
                        $this->parameter_arr["product_content_head_font_style"],// $labelstyle='B',                    
                        $this->parameter_arr["product_content_head_position"],    // $labelalign='C',
                        $this->parameter_arr["product_content_font_size"],        // $entrySize=14,                    
                        $this->parameter_arr["product_content_font_type"],        // $tocfont='Arial',                 
                        $this->parameter_arr["product_content_formtext"],         // $label='Inhaltsverzeichnis',      
                        $this->parameter_arr["product_content_font_color"],            // $product_content_font_color='#000000', 
                        $this->parameter_arr["product_content_font_style"],       // $product_content_font_style = '', 
                        15                                                        // $product_content_right = 15       
                      ); 
    }
  
    // --------------- Anlage ---------------------------------------
    if( $this->parameter_arr['product_terms']=='1' ) {
      $this->AddPage();                                // neue seite
      if( file_exists(ATTACHMENT_TXT) ) {
        // --- headline ---------                                                                                  
        $font_color    = $this->parameter_arr['product_terms_font_color']            == '' ? DATA_CELL_FONT_COLOR     : $this->parameter_arr['product_terms_font_color']          ;         
        $font_type     = $this->parameter_arr['product_terms_font_type']        == '' ? DATA_CELL_FONT_TYPE      : $this->parameter_arr['product_terms_font_type']      ;
        $font_style    = $this->parameter_arr['product_terms_head_font_style']  == '' ? DATA_CELL_FONT_STYLE     : $this->parameter_arr['product_terms_head_font_style'];
        $font_size     = $this->parameter_arr['product_terms_head_font_size']   == '' ? DATA_CELL_FONT_SIZE      : $this->parameter_arr['product_terms_head_font_size'] ;
        $position      = $this->parameter_arr['product_terms_head_position']    == '' ? DATA_CELL_FONT_POSITION  : $this->parameter_arr['product_terms_head_position']  ;
                                                                                                                   
	     //function format_text($header_font_style,$header_color,$header_font_type,$header_font_size) { 
        $this->format_text( $font_style,                                 
                            $font_color,                                           
                            $font_type,
                            $font_size  );       
//        Cell(float w [, float h] [, string txt] [, mixed border] [, integer ln] [, string align] [, integer fill] [, mixed link])
        $this->Cell( 0, 20, //s2h($font_size), 
                     $this->parameter_arr['product_terms_formtext'], DEFAULT_BORDER, 2, 
                     $position );

        // --- content ---------
//        $font_color    = $this->parameter_arr['product_terms_font_color']       == '' ? DATA_CELL_FONT_COLOR     : $this->parameter_arr['product_terms_font_color']          ;         
//        $font_type     = $this->parameter_arr['product_terms_font_type']   == '' ? DATA_CELL_FONT_TYPE      : $this->parameter_arr['product_terms_font_type']      ;
        $font_style    = $this->parameter_arr['product_terms_font_style']  == '' ? DATA_CELL_FONT_STYLE     : $this->parameter_arr['product_terms_font_style'];
        $font_size     = $this->parameter_arr['product_terms_font_size']   == '' ? DATA_CELL_FONT_SIZE      : $this->parameter_arr['product_terms_font_size'] ;
        $position      = $this->parameter_arr['product_terms_position']    == '' ? DATA_CELL_FONT_POSITION  : $this->parameter_arr['product_terms_position']  ;

        $this->format_text( $font_style,
                            $font_color,                        
                            $font_type,
                            $font_size  );       

        $txt = "\n".implode( '', file(ATTACHMENT_TXT) );

       // MultiCell(float w , float h , string txt [, mixed border] [, string align] [, integer fill])
//        $this->MultiCell( 0, s2h($font_size), 
//                          $txt, 0, 2, 
//                          $position );
                     
//        Write(float h , string txt [, mixed link])
        $this->Write( s2h($this->parameter_arr['product_terms_font_size']), $txt);
      } else {   // file not exists

        $this->format_text( '', '#000000', 'arial', 10  );       
        $this->Cell(50, 30, 'Error: File '.ATTACHMENT_TXT.' doesn\'t exists.' );
      }
    }


  } 
  

}
  
  
    
    
function s2h( $txt_size ) {
  switch($txt_size) {
    case 6:  $ret=3; break;
    case 7:  $ret=3; break;
    case 8:  $ret=3; break;
    case 9:  $ret=3; break;
    case 10: $ret=4; break;
    case 11: $ret=4; break;
    case 12: $ret=4; break;
    case 13: $ret=5; break;
    case 14: $ret=5; break;
    case 15: $ret=5; break;
    case 16: $ret=5; break;
    case 17: $ret=6; break;
    case 18: $ret=6; break;
    case 19: $ret=6; break;
    case 20: $ret=6; break;
    default: $ret=6;
  }
  
  return $ret;
}


function decode_entities($text, $quote_style = ENT_COMPAT) {
    if (function_exists('html_entity_decode')) {
        $text = html_entity_decode($text, $quote_style, 'ISO-8859-1'); // NOTE: UTF-8 does not work!
    }
    else {
        $trans_tbl = get_html_translation_table(HTML_ENTITIES, $quote_style);
        $trans_tbl = array_flip($trans_tbl);
        $text = strtr($text, $trans_tbl);
    }
    $text = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $text);
    $text = preg_replace('~&#([0-9]+);~e', 'chr("\\1")', $text);
    return $text;
}


function defpr( $profile ) {
  foreach( $profile as $i => $v ) {
    if( is_array($v) ) {
      $v=implode('', $v);
    }
    echo "\$profile['$i'] = '$v';<br>\n";
  }
  die;
}  
  
?>
