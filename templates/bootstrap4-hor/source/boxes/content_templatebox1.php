<?php

/* -----------------------------------------------------------------------------------------
   $Id: content_templatebox1.php 

   shophelfer.com Shopsoftware
   http://www.shophelfer.com

   Copyright (c) 2014 - 2015 [www.shophelfer.com]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	$box_smarty = new smarty;
	$box_content = '';

	$box_smarty->assign('language', $_SESSION['language']);
	// set cache ID
	if (!CacheCheck()) {
	  $cache = false;
	  $box_smarty->caching = 0;
	} else {
	  $cache = true;
	  $box_smarty->caching = 1;
	  $box_smarty->cache_lifetime = CACHE_LIFETIME;
	  $box_smarty->cache_modified_check = CACHE_CHECK;
	  $cache_id = $_SESSION['language'] . (isset($_GET['manufacturers_id']) ? (int)$_GET['manufacturers_id'] : 0);
	}

	if (!$box_smarty->isCached(CURRENT_TEMPLATE.'/boxes/box_content_templatebox1.html', $cache_id) || !$cache) {

	  $box_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

	  $content_manager_qry = xtDBquery("SELECT content_title, content_heading, content_text FROM ".TABLE_CONTENT_MANAGER." WHERE content_group = '12' AND languages_id = '".$_SESSION["languages_id"]."'");
	  $content_manager_ary = xtc_db_fetch_array($content_manager_qry);

	  $box_smarty->assign('BOX_TITLE', (!empty($content_manager_ary["content_heading"]))?$content_manager_ary["content_heading"]:$content_manager_ary["content_title"]);
	  $box_smarty->assign('BOX_CONTENT', $content_manager_ary["content_text"]);
	
	  }

	// set cache ID
	if (!$cache) {
	  $box_content_templatebox1 = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_content_templatebox1.html');
	} else {
	  $box_content_templatebox1 = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_content_templatebox1.html', $cache_id);
	}
	$smarty->assign('box_CONTENT_TEMPLATEBOX1', $box_content_templatebox1);

?>
