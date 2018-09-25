<?php
  /* -----------------------------------------------------------------------------------------
   $Id: categories.php 4200 2013-01-10 19:47:11Z Tomcraft1980 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com
   (c) 2003 nextcommerce (categories.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2006 XT-Commerce

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3          Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
  // reset var
  $box_smarty = new smarty;
  $box_content = '';
  //$rebuild = false; //DokuMan - 2010-02-28 - fix Smarty cache error on unlink

  $box_smarty->assign('language', $_SESSION['language']);
  // set cache ID
  if (!CacheCheck()) {
    $cache=false;
    $box_smarty->caching = 0;
    $cache_id = null; //DokuMan - 2010-02-26 - Undefined variable: cache_id
  } else {
    $cache=true;
    $box_smarty->caching = 1;
    $box_smarty->cache_lifetime = CACHE_LIFETIME;
    $box_smarty->cache_modified_check = CACHE_CHECK;
    $cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'].'-'.$cPath;
  }

  if(!$box_smarty->is_cached(CURRENT_TEMPLATE.'/boxes/box_categories.html', $cache_id) || !$cache){
    //BOF - GTB - 2010-08-03 - Security Fix - Base
    $box_smarty->assign('tpl_path',DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE.'/');
    //$box_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
    //EOF - GTB - 2010-08-03 - Security Fix - Base
    //$rebuild=true; //DokuMan - 2010-02-28 - fix Smarty cache error on unlink

    // include needed functions
    require_once (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/inc/xtc_show_category.inc.php');
    require_once (DIR_FS_INC.'xtc_has_category_subcategories.inc.php');
    require_once (DIR_FS_INC.'xtc_count_products_in_category.inc.php');

    $categories_string = '';
    if (GROUP_CHECK == 'true') {
      $group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
    }

    function xtc_get_category_array($parent_id = '0', $spacing = 0, $exclude = '', $category_tree_array = array(), $group_check = '', $include_itself = false) {

      $categories_query = xtc_db_query("select c.categories_id,
                                    cd.categories_name,
                                    c.categories_image,
                                    c.parent_id
                               from ".TABLE_CATEGORIES." c,
                                    ".TABLE_CATEGORIES_DESCRIPTION." cd
                              where c.categories_status = '1'
                                and c.parent_id = '".$parent_id."'
                                    ".$group_check."
                                and c.categories_id = cd.categories_id
                                and cd.language_id='".$_SESSION['languages_id']."'
                                and trim(cd.categories_name) != ''
                              order by sort_order, cd.categories_name");
      while ($categories = xtc_db_fetch_array($categories_query)) {
        $in_while = true;
        if ($exclude != $categories['categories_id'])
        $category_tree_array[$categories['categories_id']] = array ('id' => $categories['categories_id'], 'text' => $categories['categories_name'], 'parent_id' => $parent_id, 'image' => $categories['categories_image']);
        $index = count($category_tree_array);
        $children = xtc_get_category_array($categories['categories_id'], $spacing+1, $exclude, $category_tree_array[$index], $group_check);
        if ($children) {
          if ($children[$categories['categories_id']]) {
            unset($children[$categories['categories_id']]);
          }
          $category_tree_array[$categories['categories_id']]['children'] = $children;
        }
        
      }

      if ($in_while) {
        return $category_tree_array;
      } else {
        return NULL;
      }
    }

    $categoryArray = xtc_get_category_array('0',0,'0',array(),$group_check);

    //BOF - DokuMan - 2011-01-21 - Fix a notice when there is no category
    xtc_show_category($first_element);
    //BOF - DokuMan - 2011-01-21 - Fix a notice when there is no category

    $box_smarty->assign('BOX_CONTENT', $categories_string); //DokuMan - 2010-03-02 - BOX_CONTENT on wrong position
  }

  // set cache ID
  //BOF - DokuMan - 2010-02-28 - fix Smarty cache error on unlink
  /*
  if (!$cache || $rebuild) {
    $box_smarty->assign('BOX_CONTENT', $categories_string);
    if ($rebuild) $box_smarty->clear_cache(CURRENT_TEMPLATE.'/boxes/box_categories.html', $cache_id);
    $box_categories = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_categories.html',$cache_id);
  } else {
    $box_categories = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_categories.html', $cache_id);
  }
  */
  if (!$cache) {
    $box_categories = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_categories.html');
  } else {
    $box_categories = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_categories.html', $cache_id);
  }
  //EOF - DokuMan - 2010-02-28 - fix Smarty cache error on unlink
  $smarty->assign('box_CATEGORIES', $box_categories);

?>