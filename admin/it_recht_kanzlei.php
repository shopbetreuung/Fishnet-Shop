<?php
/* -----------------------------------------------------------------------------------------
   $Id: it_recht_kanzlei.php 2011-11-24 modified-shop $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com
   (c) 2003   nextcommerce (configuration.php,v 1.16 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: configuration.php 1125 2005-07-28 09:59:44Z novalis $)
   (c) 2008 Gambio OHG (gm_trusted_info.php 2008-08-10 gambio)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require('includes/application_top.php');
require (DIR_WS_INCLUDES.'head.php');
?>
  </head>
  <body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->
    <!-- body //-->
    <div class="row">
        
    <div class='col-xs-12'>
        <div class="col-xs-3 col-sm-1 text-right"><?php echo xtc_image(DIR_WS_ICONS.'heading_modules.gif'); ?></div>
        <div class="col-xs-9 col-sm-11"><p class="h2">IT-Recht Kanzlei</p> Modules</div>
    </div>
    <div class='col-xs-12'><br></div>
    <div class='col-sm-3 col-xs-12 dataTableHeadingContent'>
                      Update-Service
    </div>
    <div class='col-sm-9 col-xs-12 dataTableHeadingContent'>
                      <a href="<?php echo xtc_href_link('module_export.php', 'set=&module=it_recht_kanzlei'); ?>"><u>Einstellungen</u></a>  
    </div>
    <div style="background-color: #FFFFFF; border: 1px solid #dddddd; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify" class='col-xs-12'>
        
        <div class='col-xs-12'>
            <div class='col-sm-10'>
                
                      <font color="#2B7AC4"><strong>Schnittstellenmodul der IT-Recht Kanzlei M&uuml;nchen: Entspannter e-Commerce.</strong></font><br />
                      <img src="images/it_recht_kanzlei/it_recht_kanzlei.png" class='img-responsive' />
                      <br />
                      <br />
                      
                      Das modified eCommerce Schnittstellen-Modul f&uuml;r den e-Commerce in Deutschland aktualisiert automatisch ihre Rechtstexte &ndash; so bleiben Sie 
                      dauerhaft vor Abmahnungen gesch&uuml;tzt und k&ouml;nnen sich ganz entspannt ihrem operativen Gesch&auml;ft widmen.<br />
                      <br />
                      <br />
                      Das Modul stellt Ihnen die folgenden Rechtstexte zur Verf&uuml;gung:
                      <ul>
                        <li style="list-style-type: circle !important;"><strong>AGB</strong></li>
                        <li style="list-style-type: circle !important;"><strong>Widerrufsbelehrung</strong></li>
                        <li style="list-style-type: circle !important;"><strong>Datenschutzerkl&auml;rung</strong></li>
                        <li style="list-style-type: circle !important;"><strong>Impressum</strong></li>
                      </ul>
                      <br />
                      Die Einbindung funktioniert ganz einfach: Sie beantworten online ein paar Fragen zu Ihren Unternehmen. Anhand ihrer Angaben werden f&uuml;r 
                      Ihren Shop optimierte Rechtstexte erstellt und mittels des Schnittstellenmoduls der IT-Recht Kanzlei automatisch an den richtigen Positionen 
                      dargestellt. Sobald die Rechtslage sich &auml;ndert, aktualisieren die Anw&auml;lte der IT-Recht Kanzlei alle betroffenen Texte; die &Auml;nderungen 
                      werden dann automatisch in ihrem Webshop und ihren eMails eingepflegt.<br />Und wie f&uuml;r Anwaltskanzleien &uuml;blich, haftet die IT-Recht Kanzlei 
                      auch f&uuml;r die Richtigkeit ihrer Texte. So unterst&uuml;tzen wir Sie nicht nur mit dauerhaft aktuellen Texten, sondern auch durch ein minimales 
                      finanzielles Risiko. Das gibt ihnen die Sicherheit, optimal vor Abmahnungen gesch&uuml;tzt zu sein und sich in Ruhe dem operativen Gesch&auml;ft widmen 
                      zu k&ouml;nnen.
                      <br /><br />
                      Ihre Vorteile auf einen Blick:
                      <br />
                      <ul>
                        <li style="list-style-type: circle !important;"><strong>Anwaltlich erstellte Dokumente f&uuml;r Ihren Webshop</strong></li>
                        <li style="list-style-type: circle !important;"><strong>St&auml;ndige und automatisierte Aktualisierung f&uuml;r dauerhafte Rechtssicherheit</strong></li>
                        <li style="list-style-type: circle !important;"><strong>Bequeme Integration durch das Schnittstellen-Modul</strong></li>
                        <li style="list-style-type: circle !important;"><strong>Selbstverst&auml;ndlich: Haftung f&uuml;r die Richtigkeit der Texte</strong></li>
                      </ul>
                      <p align="left">
                        <br />
                        <a href="http://www.it-recht-kanzlei.de/Service/agb-online-shop.php" target="_blank"><font size="3" color="#893769"><u><strong>Jetzt den Update-Service der IT-Recht Kanzlei buchen.</strong></u></font></a> 
                      </p>
            </div>
            <div class='col-sm-2'>
                <br><br>
                <img src="images/it_recht_kanzlei/pruefzeichen-partner3.png" align="right" class='img-responsive' />
                <br>
                <img src="images/it_recht_kanzlei/schutzpaket_grafik.png" align="right" />
            </div>
            
            <br />
                      
        </div>
    </div>

    </div>
    <!-- body_eof //-->
    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
    <br />
  </body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>