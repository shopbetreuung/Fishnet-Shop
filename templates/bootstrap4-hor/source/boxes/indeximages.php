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
  require_once(DIR_FS_INC.'xtc_get_categories_name.inc.php');
  require_once(DIR_FS_INC.'xtc_get_products_name.inc.php');
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

  
  if(!$box_smarty->is_cached(CURRENT_TEMPLATE.'/boxes/box_indeximages.html', $cache_id) || !$cache){
    
    $language_id = $_SESSION['languages_id'];
    
    $main_image_query = xtc_db_query("select sorting, indeximages_title, indeximages_alt, indeximages_url, indeximages_url_target, indeximages_url_type, indeximages_description, indeximages_image from ".TABLE_INDEXIMAGES." LEFT JOIN ".TABLE_INDEXIMAGES_INFO." ON ".TABLE_INDEXIMAGES.".indeximages_id=".TABLE_INDEXIMAGES_INFO.".indeximages_id where status = '0' and languages_id = '".$language_id."' ORDER BY sorting ASC ");
    
    $images_html = '';
    while($indeximage_row = xtc_db_fetch_array($main_image_query)){

      $target = '';
      switch ($indeximage_row['indeximages_url_target']) {
        case '1':
          $target = 'target="_blank"';
          break;
        case '2':
          $target = 'target="_top"';
          break;
        case '3':
          $target = 'target="_self"';
          break;
        case '4':
          $target = 'target="_parent"';
          break;
      }

      if ($indeximage_row['indeximages_url_type'] == '0') {
        $url = $indeximage_row['indeximages_url'];
      } elseif ($indeximage_row['indeximages_url_type'] == '1') {
        $url = xtc_href_link($indeximage_row['indeximages_url']);
      } elseif ($indeximage_row['indeximages_url_type'] == '2') {
        $url = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link((int)$indeximage_row['indeximages_url'],xtc_get_products_name((int)$indeximage_row['indeximages_url'])));
      } elseif ($indeximage_row['indeximages_url_type'] == '3') {
        $url = xtc_href_link(FILENAME_DEFAULT, xtc_category_link((int)$indeximage_row['indeximages_url'],xtc_get_categories_name((int)$indeximage_row['indeximages_url'])));
      } elseif ($indeximage_row['indeximages_url_type'] == '4') {
        $content_querys = "SELECT content_title FROM ".TABLE_CONTENT_MANAGER." WHERE languages_id='".(int) $_SESSION['languages_id']."' and content_group = '".(int)$indeximage_row['indeximages_url']."' and content_status=1 order by sort_order";
        $content_querys = xtDBquery($content_querys);
        $content_title = xtc_db_fetch_array($content_querys,true);        
        $SEF = '';
        if (SEARCH_ENGINE_FRIENDLY_URLS == 'true'){
          $SEF = '&content='.xtc_cleanName($content_title['content_title']);
        }
        $url = xtc_href_link(FILENAME_CONTENT, 'coID='.(int)$indeximage_row['indeximages_url'].$SEF);
      }     

      $class = '';
      $css = '';
      switch ($indeximage_row['sorting']){
        case '1':
        case '3':
        case '5':
          $images_html .= '<div class="d-inline-block col-md-6 col-sm-12" style="width:100%;">';
          if(!empty($indeximage_row['indeximages_url'])){
            $images_html .= '<a href="'.$url.'" title="'.$indeximage_row['indeximages_title'].'" '.$target.' class="indeximages_link" >';
          }
          $images_html .= '<div class="index_images_box">
                            <img src='.DIR_WS_IMAGES.$indeximage_row['indeximages_image'].' class="img-fluid" title="'.$indeximage_row['indeximages_title'].'" alt="'.$indeximage_row['indeximages_alt'].'">
                            '.$indeximage_row['indeximages_description'].'
                          </div>';
          if(!empty($indeximage_row['indeximages_url'])){
            $images_html .= '</a>';
          }
          $images_html .= '</div>';
          break;
        case '2': 
        case '4': 
          $class = '';
          $images_html .= '<div class="d-inline-block col-md-3 col-sm-12" style="width:100%;">';
          if(!empty($indeximage_row['indeximages_url'])){
            $images_html .= '<a href="'.$url.'" title="'.$indeximage_row['indeximages_title'].'" '.$target.' class="indeximages_link" > ';
          }
          $images_html .= '<div class="index_images_box">
                  <img src='.DIR_WS_IMAGES.$indeximage_row['indeximages_image'].' class="img-fluid" title="'.$indeximage_row['indeximages_title'].'" alt="'.$indeximage_row['indeximages_alt'].'">
                  '.$indeximage_row['indeximages_description'].'
                </div>';
          if(!empty($indeximage_row['indeximages_url'])){
            $images_html .= '</a>';
          }
          $images_html .= '</div>';
          break;
      }
    }

    $box_smarty->assign('BOX_CONTENT', $images_html);
  }
  
  if (!$cache) {
    $box_indeximages = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_indeximages.html');
  } else {
    $box_indeximages = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_indeximages.html', $cache_id);
  }
  //EOF - DokuMan - 2010-02-28 - fix Smarty cache error on unlink
  $smarty->assign('box_INDEXIMAGES', $box_indeximages);


?>