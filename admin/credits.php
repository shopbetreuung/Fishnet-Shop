<?php
/* --------------------------------------------------------------
  $Id: credits.php 4200 2013-01-10 19:47:11Z Tomcraft1980 $

  modified eCommerce Shopsoftware
  http://www.modified-shop.org

  Copyright (c) 2009 - 2013 [www.modified-shop.org]
  --------------------------------------------------------------
  based on:
  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
  (c) 2002-2003 osCommercecoding standards (a typical file) www.oscommerce.com
  (c) 2003 nextcommerce (start.php,v 1.6 2003/08/19); www.nextcommerce.org
  (c) 2006 XT-Commerce (credits.php 1263 2005-09-30)

  Released under the GNU General Public License
--------------------------------------------------------------*/

require('includes/application_top.php');
require (DIR_WS_INCLUDES.'head.php');
?>
  </head>
  <body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->

			
	<h1><?php echo HEADING_TITLE; ?> <small><?php echo HEADING_SUBTITLE; ?></small></h1>
				
	<font color="3774E3"><strong><?php echo PROJECT_VERSION.'<br />'.TEXT_DB_VERSION.' "'.DB_VERSION.'"'; ?></strong></font><br />
	<br />
	<?php echo TEXT_HEADING_GPL; ?><br /><br />
	<?php echo TEXT_INFO_GPL; ?><br /><br />
	<p><?php echo TEXT_INFO_DISCLAIMER; ?></p>

	<hr />
	<h3><?php echo TEXT_HEADING_BASED_ON; ?></h3>
	<dl>
	  <dd>
		<ul style="list-style: none; padding-left: 0px;">
		  <li><?php echo '&copy; 2015-'.date('Y').'&nbsp;'; echo PROJECT_VERSION; ?> | http://www.shophelfer.com/ </li>
		  <li>&copy; 2015 modified eCommerce Shopsoftware | http://www.modified-shop.org/</li>
		  <li>&copy; 2006 xt:Commerce V3.0.4 SP2.1 | http://www.xtcommerce.de/</li>
		  <li>&copy; 2003 neXTCommerce</li>
		  <li>&copy; 2002-2003 osCommerce (Milestone2) by Harald Ponce de Leon | http://www.oscommerce.com/</li>
		  <li>&copy; 2000-2001 The Exchange Project by Harald Ponce de Leon | http://www.oscommerce.com/</li>
		</ul>
	  </dd>
	</dl>
	
    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
  </body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
