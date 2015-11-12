<?php
/* -----------------------------------------------------------------------------------------
   $Id: easymarketing.php 6027 2013-11-07 11:48:21Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
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
        <!-- body_text //-->
        
                <div class='col-xs-12'>
                    <div class="col-xs-2 col-sm-1 text-right"><?php echo xtc_image(DIR_WS_ICONS.'heading_modules.gif'); ?></div>
                    <div class="col-xs-10 col-sm-11"><p class="h2">EASYMARKETING</p> Modules</div>
                </div>
                <div class='col-xs-12'><br></div>
                <div class='col-sm-3 col-xs-12 dataTableHeadingContent left_mobile'>
                      Vollautomatisierte Online-Werbung
                </div>
                <div class='col-sm-9 col-xs-12 dataTableHeadingContent left_mobile'>
                      <a href="<?php echo xtc_href_link('module_export.php', 'set=&module=easymarketing'); ?>"><u>Einstellungen</u></a>  
                </div>
                <div class='col-xs-12'>
                      
                      
                      <div class='col-xs-12 col-sm-6'><font color="#FF7A00"><strong>Vollautomatisiert und optimiert werben auf Google uvm.</strong></font></div>
                      <div class='col-xs-12 col-sm-6 text-right'><a href="https://easymarketing.de/analysis/new" target="_blank"><img src="images/easymarketing/logo-easymarketing.jpg"  /></a></div>
                      <font color="#FF7A00"><strong>In drei Schritten durchstarten:</strong></font>
                      <ul>
                        <li style="list-style-type: circle !important;">Auf easymarketing.de die Shop-URL eingeben</li>
                        <li style="list-style-type: circle !important;">Automatische und dauerhafte Optimierung</li>
                        <li style="list-style-type: circle !important;">Registrieren</li>
                      </ul>
                      EASYMARKETING crawlt Ihren Shop, erkennt dabei alle besonders performanten Keywords, erstellt automatisch aus mehreren 100 verschiedenen Keywords &uuml;ber
                      1.000 verschiedene AdWordsAnzeigen, ver&ouml;ffentlicht diese bei Google &amp; optimiert die Ergebnisse permanent. Dank des intelligenten Algorithmus ist
                      EASYMARKETING vielfach effizienter, als wenn der Online-H&auml;ndler die Anzeigenverwaltung manuell vornehmen w&uuml;rde, es wird sehr viel mehr Traffic und
                      somit Umsatz generiert. Sie sparen somit Zeit und auch Geld, weil EASYMARKETING f&uuml;r Sie vollautomatisch arbeitetet und Ihr Budget mit Ber&uuml;cksichtigung
                      Ihrer Konkurrenz auf Google optimal g&uuml;nstig aussteuert. Die CPC-Gebote werden also automatisch berechnet, so dass Sie als Werbetreibender nicht zu
                      viel zahlen.
                      <ul>
                        <li style="list-style-type: circle !important;">Maximale Effizienz &uuml;ber die Werbeaktivit&auml;ten</li>
                        <li style="list-style-type: circle !important;">Automatische und dauerhafte Optimierung</li>
                        <li style="list-style-type: circle !important;">Hohe Zeitersparnis, da Kampagnen automatisch erstellt und gepflegt werden</li>
                      </ul>
                      <br />
                      <a href="https://easymarketing.de/analysis/new" target="_blank"><span style="font-size:12px; color:#FF7A00;"><u><strong>Weitere Infos zu EASYMARKETING finden Sie unter www.easymarketing.de</strong></u></span></a>
                    
                </div>
                <div class='col-xs-12'><br></div>
                <div class='col-xs-12'>
                    <iframe style="background-color: transparent; border: 0px none transparent;padding: 0px; overflow: hidden;" seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true" width="300px" height="250px" src="http://api.easymarketing.de/demo_chart?website_url=<?php echo urlencode(HTTP_SERVER.DIR_WS_CATALOG); ?>&version=large"></iframe>
                </div>
</div>
        <!-- body_text_eof //-->
    <!-- body_eof //-->
    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
    <br />
  </body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>