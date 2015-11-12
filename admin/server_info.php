<?php
/* --------------------------------------------------------------
   $Id: server_info.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(server_info.php,v 1.4 2003/03/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (server_info.php,v 1.7 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

require('includes/application_top.php');

if (isset($_REQUEST['phpInfo'])) {
  phpinfo();
  exit;
}

$system = xtc_get_system_information();
require (DIR_WS_INCLUDES.'head.php');
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<div class='row'>
    
<!-- body_text //-->
   
    <div class='col-xs-12'>
    <p class="h2">
        <?php echo HEADING_TITLE; ?>
    </p>
    </div>
    <div class='col-xs-12'>
        <div class='col-xs-12 col-md-6'>
            <div class='col-xs-4'><strong><?php echo TITLE_SERVER_HOST; ?></strong></div>
            <div class='col-xs-8'><?php echo $system['host'] . ' (' . $system['ip'] . ')'; ?></div>
            
            
            <div class='col-xs-4'><strong><?php echo TITLE_SERVER_OS; ?></strong></div>
            <div class='col-xs-8'><?php echo $system['system'] . ' ' . $system['kernel']; ?></div>
            
            
            <div class='col-xs-4'><strong><?php echo TITLE_SERVER_DATE; ?></strong></div>
            <div class='col-xs-8'><?php echo $system['db_version']; ?></div>
            
            
            <div class='col-xs-4'><strong><?php echo TITLE_SERVER_UP_TIME; ?></strong></div>
            <div class='col-xs-8'><?php echo $system['uptime']; ?></div>
            
            
            <div class='col-xs-4'><strong><?php echo TITLE_HTTP_SERVER; ?></strong></div>
            <div class='col-xs-8'><?php echo $system['http_server']; ?></div>
            
            
            <div class='col-xs-4'><strong><?php echo TITLE_PHP_VERSION; ?></strong></div>
            <div class='col-xs-8'><?php echo $system['php'] . ' (' . TITLE_ZEND_VERSION . ' ' . $system['zend'] . ')'; ?></div>
        </div>
        <div class='col-xs-12 col-md-6'>
            <div class='col-xs-4'><strong><?php echo TITLE_DATABASE_HOST; ?></strong></div>
            <div class='col-xs-8 smallText'><?php echo $system['db_server'] . ' (' . $system['db_ip'] . ')'; ?></div>
            
            <div class='col-xs-4'><strong><?php echo TITLE_DATABASE; ?></strong></div>
            <div class='col-xs-8 smallText'><?php echo $system['db_version']; ?></div>
            
            <div class='col-xs-4'><strong><?php echo TITLE_DATABASE_DATE; ?></strong></div>
            <div class='col-xs-8 smallText'><?php echo $system['db_date']; ?></div>
        </div>
    </div>

    <div class='col-xs-12'><br></div>
    <div class='col-xs-12'>
           <iframe src="?phpInfo" width="100%" height="700" style="border: solid 1px #a3a3a3;">
           <p>Der verwendete Browser kann leider nicht mit inline Frames (iframe)
             umgehen:
             <a href="?phpInfo" target="_blank">Hier geht es zur phpinfo()
             Seite vom System</a>
           </p>
         </iframe>
    </div>

<!-- body_text_eof //-->
</div>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
