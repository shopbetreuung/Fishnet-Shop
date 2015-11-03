<?php
  /* --------------------------------------------------------------
   $Id: header.php 2638 2012-01-30 16:47:35Z hhacker $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce, www.oscommerce.com
   (c) 2003      nextcommerce; www.nextcommerce.org
   (c) 2006      xt:Commerce; www.xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/
  defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }
  
  //define with and height for xtc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT)
  define('HEADING_IMAGE_WIDTH',57);
  define('HEADING_IMAGE_HEIGHT',40);
  
  ((strip_tags($_GET['search']) != $_GET['search']) ? $_GET['search']=NULL : false);
  ((strip_tags($_GET['search_email']) != $_GET['search_email']) ? $_GET['search_email']=NULL : false);
  
  // Admin Language Switch
  if (!isset($lng) || (isset($lng) && !is_object($lng))) {
    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language;
  }
  $languages_string = '';
  if (!isset($_GET['action']) || $_GET['action'] == 'edit') {
    reset($lng->catalog_languages);
    if (count($lng->catalog_languages) > 1) {
      while (list($key, $value) = each($lng->catalog_languages)) {
        if ( $value['status'] != 0 ){
          $languages_string .= '&nbsp;<a href="' . xtc_href_link($current_page, xtc_get_all_get_params(array('language', 'currency')).'language=' . $key, 'NONSSL') . '">' . xtc_image('../lang/' .  $value['directory'] .'/admin/images/' . $value['image'], $value['name']) . '</a>';
        }
      }
    }
  }

  $page_filename = basename($_SERVER['SCRIPT_FILENAME']);
  $search_cus = '';
  $search_email = '';
  $search_ord = '';
  $search_cat = '';
  if (strpos($page_filename, 'customers.php') !== false) {
    $search_cus = htmlentities(isset($_GET['search']) ? $_GET['search'] : ''); //DokuMan - 2010-09-08 - set undefined index
    $search_email = htmlentities(isset($_GET['search_email']) ? $_GET['search_email'] : ''); //DokuMan - 2010-09-08 - set undefined index
  }
  if (strpos($page_filename, 'orders.php') !== false) {
    $search_ord = htmlentities(isset($_GET['oID']) ? $_GET['oID'] : ''); //DokuMan - 2010-09-08 - set undefined index
  }
  if (strpos($page_filename, 'categories.php') !== false){
    $search_cat = htmlentities(isset($_GET['search']) ? $_GET['search'] : ''); //DokuMan - 2010-09-08 - set undefined index
  }

?>
          
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo xtc_href_link('start.php', '', 'NONSSL') ; ?>"><img class="img-responsive" style="height: 40px;" src="images/shophelferlogo.png" /></a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">

				<li class="topicon"><a href="<?php echo xtc_href_link('orders.php', '', 'NONSSL') ; ?>" data-toggle="tooltip" data-placement="bottom" title=" <?php echo (BOX_ORDERS) ; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a></li>
				<li class="topicon"><a href="<?php echo xtc_href_link('customers.php', '', 'NONSSL') ; ?>" data-toggle="tooltip" data-placement="bottom" title=" <?php echo (BOX_CUSTOMERS) ; ?>"><span class="glyphicon glyphicon-user"></span></a></li>


			</ul>
			
			<form class="navbar-form navbar-left hidden-xs hidden-sm" role="search" action="<?php echo xtc_href_link('orders.php'); ?>" method="get">
				<div class="form-group">
					<input name="oID" type="text" value="<?php echo $search_ord;?>" class="form-control" placeholder="Bestellnummer" style="width: 200px !important;" />
					<input type="hidden" name="action" value="search" />
					<input name="<?php echo xtc_session_name(); ?>" type="hidden" value="<?php echo xtc_session_id(); ?>" />
				</div>
			</form>
			<form class="navbar-form navbar-left hidden-xs hidden-sm" role="search" action="<?php echo xtc_href_link('customers.php'); ?>" method="get">
				<div class="form-group">
					<input name="search" type="text" value="<?php echo $search_cus;?>" class="form-control" placeholder="Kunde" style="width: 200px !important;" />
					<input name="<?php echo xtc_session_name(); ?>" type="hidden" value="<?php echo xtc_session_id(); ?>" />						
				</div>
			</form>
			<form class="navbar-form navbar-left hidden-xs hidden-sm" role="search" action="<?php echo xtc_href_link('categories.php'); ?>" method="get">
				<div class="form-group">
			        <input name="search" type="text" value="<?php echo $search_cat;?>" class="form-control" placeholder="Kategorie / Produkt" style="width: 200px !important;" />
					<input name="<?php echo xtc_session_name(); ?>" type="hidden" value="<?php echo xtc_session_id(); ?>" />
				</div>
			</form>
			
			<ul class="hidden-xs hidden-sm hidden-md nav navbar-nav navbar-right">
				<li class="topicon"><a href="<?php echo xtc_href_link('../index.php', '', 'NONSSL') ; ?>" data-toggle="tooltip" data-placement="bottom" title="zum Shop"><span class="glyphicon glyphicon-globe"></span></a></li>			
				<li class="topicon"><a href="<?php echo xtc_href_link('credits.php', '', 'NONSSL') ; ?>" data-toggle="tooltip" data-placement="bottom" title=" <?php echo (BOX_CREDITS) ; ?>"><span class="glyphicon glyphicon-info-sign"></span></a></li>
				<li class="topicon"><a href="http://www.shophelfer.com/wiki/index.php" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Wiki"><span class="glyphicon glyphicon-book"></span></a></li>
				<li class="topicon"><a href="<?php echo xtc_href_link('../logoff.php', '', 'NONSSL') ; ?>" data-toggle="tooltip" data-placement="bottom" title=" <?php echo (BOX_LOGOUT) ; ?>"><span class="glyphicon glyphicon-log-out"></span></a></li>
			</ul>
		</div>
		<?php

		require(DIR_WS_INCLUDES . "column_left.php");

		?>
	</div>
</nav>

<div class="container-fluid"><div class="row"><div class="col-xs-12">
