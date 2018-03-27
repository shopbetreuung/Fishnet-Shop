<?php
define( PDFBILL_LOADED_PROFILE, 'Geladenes Profil: ');
define( PDFBILL_LOAD_PROFILE, 'Lade Profil: ');
define( PDFBILL_PROFILE_LANG, 'Profil für Sprache: ');


$help_var_orderdata = kl('
  *date_order* = Bestelldatum      <br />
  *date_invoice* = Rechnungsdatum  <br />
  *orders_id_sys* = Bestellnummer <br />
  *orders_id* = Rechnungsnummer        <br />
  *customers_id* = Kunden ID       <br />
  *ust_id* = Kunden UST ID       <br />
  *payment_method* = Zahlungsweise <br />
  <br />
  *date_delivery* = Lieferdatum    <br />
  (Einzutragen in Bestellverwaltung)

');

$help_var_posdata = kl('
  *p_model* = Artikelnummer                                       <br />  
  *p_model_att* = Artikelnummer Attribute (sofern vorhanden)      <br />  
  *p_model_org* = Artikelnummer Hauptartikel                      <br />  
  *p_name* = Artikelname                                          <br />  
  *p_single_price* = Artikel Einzelpreis                          <br />  
  *p_price* = Preis der Position (Menge x Einzelpreis)            <br />  
  *p_qty* = Menge                                                 <br />  
');                                                              


  $dimensions_helptext = kl('
<span class="help-headline"><strong>Eingabe der Position und Gr&ouml;&szlig;e
des
Textes</strong></span><br>
<br>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr valign="top" class="help-text">
    <td><strong>Horizontal</strong></td>
    <td>Abstand nach links
    innerhalb des Datenbereichs</td>
  </tr>
  <tr valign="top" class="help-text">
    <td><strong>Vertikal</strong></td>
    <td>Abstand nach oben Elementes innerhalb des Datenbereichs</td>
  </tr>
  <tr valign="top" class="help-text">
    <td><strong>Breite</strong></td>
    <td>Breite des Objektes</td>
  </tr>
  <tr valign="top" class="help-text">
    <td><strong>H&ouml;he</strong></td>
    <td>H&ouml;he des Objektes</td>
  </tr>
</table>
');


  $dimensions_helptext_image = kl('
<span class="help-headline"><strong>Eingabe der Position und Gr&ouml;&szlig;e
des
Textes</strong></span><br>
<br>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr valign="top" class="help-text">
    <td><strong>Horizontal</strong></td>
    <td>Abstand nach links
    innerhalb des Datenbereichs</td>
  </tr>
  <tr valign="top" class="help-text">
    <td><strong>Vertikal</strong></td>
    <td>Abstand nach oben Elementes innerhalb des Datenbereichs</td>
  </tr>
  <tr valign="top" class="help-text">
    <td><strong>Breite</strong></td>
    <td>Breite des Objektes</td>
  </tr>
  <tr valign="top" class="help-text">
    <td><strong>H&ouml;he</strong></td>
    <td>H&ouml;he des Objektes</td>
  </tr>
</table>

<p class="help-text"><strong>Bei der Breite von Bildern gilt folgendes:</strong></p>
<p class="help-text">1. Angabe von Breite und H&ouml;he: <br>
  Das Bild wird in die angegebenen Dimensionen skaliert. Falls das Bild andere
    Proportionen besitzt wird es verzerrt.</p>
<p><span class="help-text">2. Angabe nur von Breite (H&ouml;he blebt leer) oder nur von H&ouml;he (Breite bleibt
  leer)<br>
  Das Bild wird proportional skaliert auf die angegebene Breite der H&ouml;he. Die
  Proportionen bleiben erhalten</span>.</p>
<p class="help-text">3. Keine Angabe von Breite oder H&ouml;he<br>
  Das Bild wird in Originalgr&ouml;&szlig;e eingef&uuml;gt
</p>
');


$bind_helptext = kl('
  <span class="help-headline"><strong>Indexwert und Bindung</strong></span>
  <br>
  <br>
  <span class="help-text">Wenn ein folgendes Objekt unmittelbar an ein vorhergehendes
  Objekt anschlie&szlig;en
soll.<br>
<br>
<strong>Beispiel:</strong> Unmittelbar unter einem Textobjekt soll ein anderer
Datenwert stehen. Der Text ist variabel lang. Bei einer absoluten Positionierung
(feste Positionsdaten)
ist entweder zwischen Text und Datenwert unn&ouml;tig viel Platz oder der Text &uuml;berschreibt
den Datenwert.
</p>
  </span>
<p><span class="help-text">Hier kann man nun angeben, da&szlig; der Datenwert
      unmittelbar unter dem Text positioniert
werden soll.<br>
<br>
&nbsp;&nbsp;Beschreibungstext bekommt <strong>Indexwert</strong>: 123<br>
&nbsp;&nbsp;Preisangabe bekommt <strong>Bindung</strong> 123<br>
<br>
Der Preisangabe ist nun unmittelbar unter den Beschreibungstext gebunden.</span>
<p><img src="images/ipdfcat/pdf-help-img1.gif" width="400" height="220"><br>
  <span class="help-text">Oben: variabel langer Beschreibungstext, statisch positioniertes Preisobjekt<br>
  Unten: 
  variabel langer Beschreibungstext, Preisobjekt gebunden an Beschreibungstext</span><br>

');


$header_helptext = kl('
<p class="help-headline">Kategorie&uuml;berschriften</p>
<p class="help-text">Jedes Seite erh&auml;lt eine &Uuml;berschrift mit dem Kategorienamen. <br>
  <br>
Bei der Folge der Auflistung der Artikel wird, wenn eine Kategorie vollst&auml;ndig
dargestellt ist und der folgende Artikel einer neuen Kategorie angeh&ouml;rt, eine
neue Seite begonnen</p>
');


function kl($txt) {                            // del linefeeds
  return preg_replace("/\r|\n/s", " ", $txt);
}

function texts_html( $texts ) {
  if( is_array($texts) ) {
    for($i=0; $i<sizeof($texts); $i++) {
      if( strpos('helptext', $i)===false ) {    // labels with 'helptext' no proceed
        $texts[$i]=texts_html($str);
      }
    } 
    return $texts;
  } else {
    return htmlentities($texts);
  }
}


  $text_std_dimensions = array( 
                 'question'                               => 'Dimension:',
                 'pos_x'                                  => 'Horizontal',
                 'pos_y'                                  => 'Vertikal',
                 'width'                                  => 'Breite',
                 'height'                                 => 'Höhe',
                 'help'                                   => $dimensions_helptext );
  $text_std_dimensions_rellist = array( 
                 'question'                               => 'Dimension:',
                 'pos_x'                                  => 'Horizontal relativ',
                 'pos_y'                                  => 'Vertikal relativ',
                 'width'                                  => 'Breite',
                 'height'                                 => 'Höhe',
                 'help'                                   => $dimensions_helptext );
  $text_std_dimensions_image = array( 
                 'question'                               => 'Dimension:',
                 'pos_x'                                  => 'Horizontal',
                 'pos_y'                                  => 'Vertikal',
                 'width'                                  => 'Breite',
                 'height'                                 => 'Höhe',
                 'help'                                   => $dimensions_helptext_image );
  $txt_std_position = array( 
                 'question'                               => 'Ausrichtung:',
                 'chk_text_l'                             => 'Linksbündig',
                 'chk_text_c'                             => 'Zentriert',
                 'chk_text_r'                             => 'Rechtsbündig',
                 'chk_text_j'                             => 'Blocksatz'    );
  $txt_std_color = array( 
                 'question'                               => 'Schriftfarbe:',
                 'button_text'                            => 'Auswählen' );
  $txt_std_font_style = array( 
                 'question'                               => 'Schriftstil:',
                 'text_bold'                              => 'Fett',           
                 'text_italic'                            => 'Kursiv',         
                 'text_underlined'                        => 'Unterstrichen' );
  $txt_std_bind = array( 
                 'question'                               => 'Bindungen:',
                 'indexnumber'                            => 'Indexnummer',
                 'parent_indexnumber'                     => 'unten gebunden an Indexnummer',
                 'help'                                   => $bind_helptext );
                 

  $texts = array(
             'headline'                                   => 'PDF-Rechnungs-Designer',
             
             // Frage ob es ein Lieferschein oder Rechnungsprofil sein soll
             'typeofbill' => array( 
               'question'                                 => 'Profil für:',
               'text_1'                                   => 'Rechnung',
               'text_2'                                   => 'Lieferschein',
               'text_3'                                   => 'Reminder',
               'text_4'                                   => 'Second reminder'),
             // Frage ob es ein Lieferschein oder Rechnungsprofil sein soll
             'language' => array( 
               'question'                                 => 'Sprache' ),
             'default_profile' => array( 
               'question'                               => 'Default',
               'chk_text'                               => 'Dieses Profil ist gültig wenn kein Profil gewählt' ),
               

             'profile_options' => array(   
               'headline' => array( 
                 'headline'                               => 'Optionen:' ),
               'pdfdebug'                                 => 'Debuginformationen einblenden (nur in Vorschau)',
               'grids'                                    => 'Gitterlinien einblenden (nur in Vorschau)'
               ),
             'button_generate'                            => 'Profil speichern',
             'preview_at_example'                         => 'Vorschau am Beispiel Bestellung Nummer:',

             'headtext' => array(                    // Sektion Kopftext
               'headline' => array( 
                 'headline'                               => 'Kopftext (5)' ),
               'headtext_display' => array( 
                 'question'                               => 'Anzeige',
                 'chk_text'                               => 'anzeigen' ),
               'headtext_text' => array( 
                 'question'                               => 'Text:',
                 'fieldtext'                              => '' ),               
               'headtext_position'                        => $txt_std_position,
               'headtext_font_color'                      => $txt_std_color,
               'headtext_font_type' => array( 
                 'question'                               => 'Schriftart:'),
               'headtext_font_style'                      => $txt_std_font_style,
               'headtext_font_size' => array(     
                 'question'                               => 'Schriftgröße:' ),
               'headtext_dimensions'                      => $text_std_dimensions
               ),
  
             'addressblock' => array(                    // Sektion Adressblock
               'headline' => array( 
                 'headline'                               => 'Addressblock (1)' ),
               'addressblock_display' => array( 
                 'question'                               => 'Anzeige',
                 'chk_text'                               => 'anzeigen' ),

               'addressblock_trenn'                       => 'Absenderzeile',
               'addressblock_text' => array( 
                 'question'                               => 'Absenderzeile:',
                 'fieldtext'                              => '' ),               
               'addressblock_position'                    => $txt_std_position,
               'addressblock_font_color'                  => $txt_std_color,
               'addressblock_font_type' => array( 
                 'question'                               => 'Schriftart:'),
               'addressblock_font_style'                  => $txt_std_font_style,
               'addressblock_font_size' => array(     
                 'question'                               => 'Schriftgröße:' ),

               'addressblock_trenn2'                      => 'Empfängeradresse',
               'addressblock_position2'                   => $txt_std_position,
               'addressblock_font_color2'                 => $txt_std_color,
               'addressblock_font_type2' => array( 
                 'question2'                              => 'Schriftart:'),
               'addressblock_font_style2'                 => $txt_std_font_style,
               'addressblock_font_size2' => array(     
                 'question'                               => 'Schriftgröße:' ),

               'addressblock_dimensions'                  => $text_std_dimensions,
               'addressblock_bind'                        => $txt_std_bind 
               ),
  
             'image' => array(                    // Decoimage (3)
               'headline' => array( 
                 'headline'                               => 'Bild (3):' ),
               'image_display' => array( 
                 'question'                               => 'Anzeige',
                 'chk_text'                               => 'anzeigen' ),
               'image_image'                              => 'Bilddatei',
               'image_dimensions'                         => $text_std_dimensions_image 
               ),

             'bgimage' => array(                    // Bachgroundimage (10)
               'headline' => array( 
                 'headline'                               => 'Hintergrund (10):' ),
               'bgimage_display' => array( 
                 'question'                               => 'Anzeige',
                 'chk_text'                               => 'anzeigen' ),
               'bgimage_image'                            => 'Bilddatei'
               ),

             'datafields' => array(                    // Sektion Datenfelder
               'headline' => array( 
                 'headline'                               => 'Datenfelder (9)' ),
               'datafields_display' => array( 
                 'question'                               => 'Anzeige',
                 'chk_text'                               => 'anzeigen' ),

               'datafields_trenn1'                       => 'Linke Spalte',
               'datafields_position'                      => $txt_std_position,
               'datafields_font_color'                    => $txt_std_color,
               'datafields_font_type' => array( 
                 'question'                               => 'Schriftart:'),
               'datafields_font_style'                    => $txt_std_font_style,
               'datafields_font_size' => array(     
                 'question'                               => 'Schriftgröße:' ),

               'datafields_trenn2'                       => 'Rechte Spalte',
               'datafields_position2'                      => $txt_std_position,
               'datafields_font_color2'                    => $txt_std_color,
               'datafields_font_type2' => array( 
                 'question'                               => 'Schriftart:'),
               'datafields_font_style2'                    => $txt_std_font_style,
               'datafields_font_size2' => array(     
                 'question'                               => 'Schriftgröße:' ),

               'datafields_dimensions'                    => $text_std_dimensions,
               'datafields_bind'                          => $txt_std_bind,
               
               'datafields_linetexts_1' => array( 
                 'question'                               => 'Datenzeile 1',
                 'fieldtext_1'                            => 'Textvorsatz',
                 'fieldtext_2'                            => 'Variable',
                 'help'                                   => $help_var_orderdata ), 
               'datafields_linetexts_2' => array( 
                 'question'                               => 'Datenzeile 2',
                 'fieldtext_1'                            => 'Textvorsatz',
                 'fieldtext_2'                            => 'Variable' ), 
               'datafields_linetexts_3' => array( 
                 'question'                               => 'Datenzeile 3',
                 'fieldtext_1'                            => 'Textvorsatz',
                 'fieldtext_2'                            => 'Variable' ), 
               'datafields_linetexts_4' => array( 
                 'question'                               => 'Datenzeile 4',
                 'fieldtext_1'                            => 'Textvorsatz',
                 'fieldtext_2'                            => 'Variable' ),
               'datafields_linetexts_5' => array( 
                 'question'                               => 'Datenzeile 5',
                 'fieldtext_1'                            => 'Textvorsatz',
                 'fieldtext_2'                            => 'Variable' ),
               'datafields_linetexts_6' => array( 
                 'question'                               => 'Datenzeile 6',
                 'fieldtext_1'                            => 'Textvorsatz',
                 'fieldtext_2'                            => 'Variable' ) 
               ),
  

             'billhead' => array(                    // billhead (4)
               'headline' => array( 
                 'headline'                               => 'Rechnungsüberschrift (4)' ),
               'billhead_display' => array( 
                 'question'                               => 'Anzeige',
                 'chk_text'                               => 'anzeigen' ),
               'billhead_text' => array( 
                 'question'                               => 'Text:',
                 'fieldtext'                              => '' ),               
               'billhead_position'                        => $txt_std_position,
               'billhead_font_color'                      => $txt_std_color,
               'billhead_font_type' => array( 
                 'question'                               => 'Schriftart:'),
               'billhead_font_style'                      => $txt_std_font_style,
               'billhead_font_size' => array(     
                 'question'                               => 'Schriftgröße:' ),
               'billhead_dimensions'                      => $text_std_dimensions
               ),


               
               
               
             'freeinfo' => array(                    // freeinfo (4a)
               'headline' => array( 
                 'headline'                            => 'Freie Infozeile (4a)' ),
               'freeinfo_display' => array( 
                 'question'                            => 'Anzeige',
                 'chk_text'                            => 'anzeigen' ),
               'freeinfo_text' => array( 
                 'question'                            => 'Text:',
                 'fieldtext'                           => '',               
                 'help'                                => $help_var_orderdata ), 
               'freeinfo_position'                     => $txt_std_position,
               'freeinfo_font_color'                   => $txt_std_color,
               'freeinfo_font_type' => array( 
                 'question'                            => 'Schriftart:'),
               'freeinfo_font_style'                   => $txt_std_font_style,
               'freeinfo_font_size' => array(     
                 'question'                            => 'Schriftgröße:' ),
               'freeinfo_dimensions'                   => $text_std_dimensions
               ),

               
               
               
               
               
               
             'listhead' => array(                    // listhead (2)
               'headline' => array( 
                 'headline'                               => 'Listenüberschrift (2)' ),
               'listhead_display' => array( 
                 'question'                               => 'Anzeige',
                 'chk_text'                               => 'anzeigen' ),
               'listhead_text' => array( 
                 'question'                               => 'Text:',
                 'fieldtext'                              => '' ),               
               'listhead_position'                        => $txt_std_position,
               'listhead_font_color'                      => $txt_std_color,
               'listhead_font_type' => array( 
                 'question'                               => 'Schriftart:'),
               'listhead_font_style'                      => $txt_std_font_style,
               'listhead_font_size' => array(     
                 'question'                               => 'Schriftgröße:' ),
               'listhead_dimensions'                      => $text_std_dimensions
               ),                 


             'poslist' => array(                    // poslist (7)
               'headline' => array( 
                 'headline'                               => 'Positionslisten (7)' ),
               'poslist_font_color'                      => $txt_std_color,
               'poslist_font_type' => array( 
                 'question'                               => 'Schriftart:'),
               'poslist_font_style'                      => $txt_std_font_style,
               'poslist_font_size' => array(     
                 'question'                               => 'Schriftgröße:' ),
               'poslist_texts' => array( 
                 'question'        => 'Datenspalte',
                 'text_a'          => 'Überschrift',
                 'text_b'          => 'Wert',
                 'text_c'          => 'Breite',
                 'pos_left'        => 'links',
                 'pos_center'      => 'mitte',
                 'pos_right'       => 'rechts',
                 'help'            => $help_var_posdata 
                        ),
               'poslist_dimensions'                    => $text_std_dimensions,
                        
               ),  


             'resumefields' => array(                    // Sektion Summenfelder
               'headline' => array( 
                 'headline'                               => 'Summenfelder (12)' ),
               'resumefields_display' => array( 
                 'question'                               => 'Anzeige',
                 'chk_text'                               => 'anzeigen' ),

               'resumefields_trenn1'                       => 'Linke Spalte',
               'resumefields_position'                      => $txt_std_position,
               'resumefields_font_color'                    => $txt_std_color,
               'resumefields_font_type' => array( 
                 'question'                               => 'Schriftart:'),
               'resumefields_font_style'                    => $txt_std_font_style,
               'resumefields_font_size' => array(     
                 'question'                               => 'Schriftgröße:' ),
                                  
               'resumefields_trenn2'                       => 'Rechte Spalte',
               'resumefields_position2'                      => $txt_std_position,
               'resumefields_font_color2'                    => $txt_std_color,
               'resumefields_font_type2' => array( 
                 'question'                               => 'Schriftart:'),
               'resumefields_font_style2'                    => $txt_std_font_style,
               'resumefields_font_size2' => array(     
                 'question'                               => 'Schriftgröße:' ),

               'resumefields_dimensions'                    => $text_std_dimensions_rellist,
               
               'resumefields_linetexts_1' => array( 
                 'question'                               => 'Datenzeile 1',
                 'fieldtext_1'                            => 'Textvorsatz',
                 'fieldtext_2'                            => 'Variable' ), 
               'resumefields_linetexts_2' => array( 
                 'question'                               => 'Datenzeile 2',
                 'fieldtext_1'                            => 'Textvorsatz',
                 'fieldtext_2'                            => 'Variable' ), 
               'resumefields_linetexts_3' => array( 
                 'question'                               => 'Datenzeile 3',
                 'fieldtext_1'                            => 'Textvorsatz',
                 'fieldtext_2'                            => 'Variable' ),
               'resumefields_linetexts_4' => array( 
                 'question'                               => 'Datenzeile 3',
                 'fieldtext_1'                            => 'Textvorsatz',
                 'fieldtext_2'                            => 'Variable' ) 
               ),
               
             'subtext' => array(                    // Sektion subtext
               'headline' => array( 
                 'headline'                               => 'Untertext (8)' ),
               'subtext_display' => array( 
                 'question'                               => 'Anzeige',
                 'chk_text'                               => 'anzeigen' ),
               'subtext_display_comments' => array( 
                 'question'                               => 'Anzeige Kommentar?',
                 'chk_text'                               => 'anzeigen' ),
               'subtext_text' => array( 
                 'question'                               => 'Text:',
                 'fieldtext'                              => '' ),               
               'subtext_position'                         => $txt_std_position,
               'subtext_font_color'                       => $txt_std_color,
               'subtext_font_type' => array( 
                 'question'                               => 'Schriftart:'),
               'subtext_font_style'                       => $txt_std_font_style,
               'subtext_font_size' => array(     
                 'question'                               => 'Schriftgröße:' ),
               'subtext_dimensions'                       => $text_std_dimensions_rellist
               ),
  
             'footer' => array(                    // Sektion footer
               'headline' => array( 
                 'headline'                               => 'Fusstexte (6)' ),
               'footer_display' => array( 
                 'question'                               => 'Anzeige',
                 'chk_text'                               => 'anzeigen' ),
               'footer_font_color'                        => $txt_std_color,
               'footer_font_type' => array( 
                 'question'                               => 'Schriftart:'),
               'footer_font_style'                        => $txt_std_font_style,
               'footer_font_size' => array(     
                 'question'                               => 'Schriftgröße:' ),
                 
               'footer_display_1' => array( 
                 'question'                               => 'Block Anzeigen',
                 'chk_text'                               => 'anzeigen' ),
               'footer_position_1'                        => $txt_std_position,
               'footer_text_1' => array( 
                 'question'                               => 'Text:',
                 'fieldtext'                              => '' ),

               'footer_display_2' => array( 
                 'question'                               => 'Block Anzeigen',
                 'chk_text'                               => 'anzeigen' ),
               'footer_position_2'                        => $txt_std_position,
               'footer_text_2' => array( 
                 'question'                               => 'Text:',
                 'fieldtext'                              => '' ),

               'footer_display_3' => array( 
                 'question'                               => 'Block Anzeigen',
                 'chk_text'                               => 'anzeigen' ),
               'footer_position_3'                        => $txt_std_position,
               'footer_text_3' => array( 
                 'question'                               => 'Text:',
                 'fieldtext'                              => '' ),

               'footer_display_4' => array( 
                 'question'                               => 'Block Anzeigen',
                 'chk_text'                               => 'anzeigen' ),
               'footer_position_4'                        => $txt_std_position,
               'footer_text_4' => array( 
                 'question'                               => 'Text:',
                 'fieldtext'                              => '' ),
                 
               ),
  
             'terms' => array(                    // Sektion Anlage
               'headline' => array( 
                 'headline'                               => 'Anlage (11)' ),
               'terms_display' => array( 
                 'question'                               => 'Anzeige',
                 'chk_text'                               => 'anzeigen' ),
               'terms_formtext' => array( 
                 'question'                               => 'Überschrift:',
                 'fieldtext'                              => ''),               
               'terms_head_position'              => array( 
                 'question'                               => 'Ausrichtung Überschrift:',
                 'chk_text_l'                             => 'Linksbündig',
                 'chk_text_c'                             => 'Zentriert',
                 'chk_text_r'                             => 'Rechtsbündig' ),
               'terms_head_font_style'            => array( 
                 'question'                               => 'Schriftstil Überschrift:',
                 'text_bold'                              => 'Fett',           
                 'text_italic'                            => 'Kursiv',         
                 'text_underlined'                        => 'Unterstrichen' ),
               'terms_head_font_size' => array( 
                 'question'                               => 'Schriftgröße Überschift:' ),

               'terms_font_color'                         => $txt_std_color,
               'terms_font_type' => array( 
                 'question'                               => 'Schriftart:'),
               'terms_font_style'                         => $txt_std_font_style,
               'terms_font_size' => array( 
                 'question'                               => 'Schriftgröße:' )
               ),
             
             'profile_save' => array(                    // Sektion Staffelpreise
               'headline' => array( 
                 'headline'                               => 'Profil speichern' )
               )
               
  // -------------------------------------------------------

             );  

$texts = texts_html($texts);             

define('TEXT_SELECT_INVOICE_PROFILE', 'Select this invoice profile if:');
define('TEXT_ACTIVATE', 'Activate');
define('TEXT_SELECTOR', 'Selector');
define('TEXT_OPERATION', 'Operation');
define('TEXT_VALUE', 'Value');
define('TEXT_CONDITIONS', 'Conditions');
define('TEXT_BILLING_COUNTRY', 'Billing country');
define('TEXT_SHIPPING_METHOD', 'Shipping method');
define('TEXT_PAYMENT_METHOD', 'Payment method');
define('TEXT_ORDER_STATUS', 'Order status');
define('TEXT_CUSTOMERS_STATUS', 'Customers status');
define('TEXT_MULTIPLE_OPTIONS', '*multiple option values separate with comma(<b>,</b>).');
define('TEXT_AND', 'AND');
define('TEXT_OR', 'OR');
define('TEXT_EQUAL', 'EQUAL');
define('TEXT_NOT_EQUAL', 'NOT EQUAL');
define('TEXT_SUBMIT_NEW_PROFILE','Submit new profile');


?>
