<?php
/* -----------------------------------------------------------------------------------------
   $Id: content_preview.php 1304 2005-10-12 18:04:43Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (content_preview.php,v 1.2 2003/08/25); www.nextcommerce.org
   
    Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
require('includes/application_top.php');

$content_query=xtc_db_query("SELECT em_body 
                                FROM ".TABLE_EMAILS_MANAGER."
                                WHERE em_id='".(int)$_GET['coID']."'");

$content_data=xtc_db_fetch_array($content_query);

echo $content_data['em_body'];        
?>