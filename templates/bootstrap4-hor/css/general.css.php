<?php
/* -----------------------------------------------------------------------------------------
   $Id: general.js.php 1262 2005-09-30 10:00:32Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

   // Put CSS-Definitions here, these CSS-files will be loaded at the TOP of every page
?>
<link rel="stylesheet" href="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/css/bootstrap-add.css" type="text/css" />
<link rel="stylesheet" href="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/css/fontawesome.css" type="text/css" />
<link rel="stylesheet" href="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/css/ekko-lightbox.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo 'templates/'.CURRENT_TEMPLATE; ?>/stylesheet.css" type="text/css" />

<?php
if ($_SESSION['customers_status']['customers_status_id'] == 0) {
?>
<style type="text/css">
body { margin-top: 66px; }
</style>
<?php	
}
?>


