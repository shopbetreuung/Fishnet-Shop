<?PHP
/* --------------------------------------------------------------
   $Id: haendlerbund.php

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards (a typical file) www.oscommerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/
  //VERSION

$modulVersion = "1.0";
require('includes/application_top.php');
require('includes/haendlerbund/haendlerbund_importer.php');
  
if($_GET["api_konfiguration"] == 1) {
  $contentimporter = new haendlerbund_importer();
  echo $contentimporter->process(1);
} else {
  require (DIR_WS_INCLUDES.'head.php');
?>

<link href="includes/haendlerbund/css/main.css" rel="stylesheet" type="text/css" />
<link href="http://fonts.googleapis.com/css?family=Cuprum" rel="stylesheet" type="text/css" />

<script src="includes/haendlerbund/jquery-1.4.4.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/haendlerbund/jquery.smartWizard.min.js"></script>
<script type="text/javascript" src="includes/haendlerbund/custom.js"></script>

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
		<!-- header //-->
		<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
		<!-- header_eof //-->
		<!-- body //-->
                <div class='row'>
                    <div class='col-xs-12'>
                        	<a href="https://www.haendlerbund.de/" target="_blank"><img src="includes/haendlerbund/images/haendlerbund_logo.png" hspace="0" vspace="0" style="padding:10px" /></a>
                                <a href="https://www.haendlerbund.de/" target="_blank"><img src="includes/haendlerbund/images/groesster-onlinehandelsverband-europas.png" style="padding:10px" /></a>
				
						
                    </div>
                    <div class='col-xs-12'><div style="background-color:#387CB0; height:5px;"></div></div>
                    <div class='col-xs-12'>
								<br/>
								<?PHP
								$contentimporter = new haendlerbund_importer();
								echo $contentimporter->process(0);
								echo $contentimporter->getImportForm();
								?>
                    </div>
                </div>          
		<!-- body_eof //-->
		<!-- footer //-->
		<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
		<!-- footer_eof //-->
		<br />
	</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); 
}
?>
