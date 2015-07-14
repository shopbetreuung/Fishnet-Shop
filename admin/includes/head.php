<?php
  /* --------------------------------------------------------------
   $Id: head.php 4387 2013-02-01 12:20:50Z web28 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce, www.oscommerce.com
   (c) 2003  nextcommerce, www.nextcommerce.org
   (c) 2006      xt:Commerce, www.xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/
  defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
  
  define('NEW_ADMIN_STYLE',true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php echo HTML_PARAMS; ?>>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
	<title><?php echo TITLE; ?></title>  

	<link rel="stylesheet" type="text/css" href="includes/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="includes/css/bootstrap-submenu.min.css">
	<link rel="stylesheet" type="text/css" href="includes/css/toggle-switch.css">
	<link rel="stylesheet" type="text/css" href="includes/css/bootstrap-theme.css"> 
	<link rel="stylesheet" type="text/css" href="includes/css/gridstack.min.css"> 
	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.0/jquery-ui.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.5.0/lodash.min.js"></script>
	<script type="text/javascript" src="includes/javascript/gridstack.min.js"></script>
	<script type="text/javascript" src="includes/javascript/bootstrap.min.js"></script>
	<script type="text/javascript" src="includes/javascript/bootstrap-submenu.min.js"></script>
	
	<script type="text/javascript" src="includes/general.js"></script>
	<script type="text/javascript">
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$('.dropdown-submenu > a').submenupicker();
		})
	</script>

    
	
	
