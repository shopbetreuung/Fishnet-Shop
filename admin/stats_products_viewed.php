<?php
/* --------------------------------------------------------------
   $Id: stats_products_viewed.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(stats_products_viewed.php,v 1.27 2003/01/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (stats_products_viewed.php,v 1.9 2003/08/18); www.nextcommerce.org

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

<!-- body //-->
<div class='row'>
                <div class='col-xs-12'>
                    <div class="col-xs-3 col-sm-1 text-right"><?php echo xtc_image(DIR_WS_ICONS.'heading_statistic.gif'); ?></div>
                    <div class="col-xs-9 col-sm-11"><p class="h2"><?php echo HEADING_TITLE; ?></p> Statistics</div>
                </div>
                <div class='col-xs-12'><br></div>
                <div class='table-responsive col-xs-12'>
<table class='table table-bordered'>
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent hidden-xs"><?php echo TABLE_HEADING_NUMBER; ?></td>
                    <td class="dataTableHeadingContent hidden-xs"><?php echo TABLE_HEADING_MODEL; ?></td>
                    <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                    <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_VIEWED; ?>&nbsp;</td>
                  </tr>
                  <?php
                  $rows = (isset($_GET['page']) && $_GET['page'] > 1) ? $_GET['page'] * $maxrows - $maxrows : 0;  
                  $products_query_raw = "select p.products_id,
                                                p.products_model,                  
                                                pd.products_name, 
                                                pd.products_viewed, 
                                                l.name 
                                           from " . TABLE_PRODUCTS . " p, 
                                                " . TABLE_PRODUCTS_DESCRIPTION . " pd, 
                                                " . TABLE_LANGUAGES . " l 
                                          where p.products_id = pd.products_id 
                                            and l.languages_id = pd.language_id 
                                       order by pd.products_viewed DESC";
                  $products_split = new splitPageResults($_GET['page'], '20', $products_query_raw, $products_query_numrows);
                  $products_query = xtc_db_query($products_query_raw);
                  while ($products = xtc_db_fetch_array($products_query)) {
                    $rows++;
                    if (strlen($rows) < 2) {
                      $rows = '0' . $rows;
                    }
                  ?>                  
                  <tr class="dataTableRow" onmouseover="this.className='dataTableRowOver';this.style.cursor='pointer'" onmouseout="this.className='dataTableRow'" onclick="document.location.href='<?php echo xtc_href_link(FILENAME_CATEGORIES, 'action=new_product_preview&read=only&pID=' . $products['products_id'] . '&origin=' . FILENAME_STATS_PRODUCTS_PURCHASED . '?page=' . $_GET['page'], 'NONSSL'); ?>'">
                    <td class="dataTableContent hidden-xs"><?php echo $rows; ?>.</td>
                    <td class="dataTableContent hidden-xs"><?php echo $products['products_model']; ?></td>
                    <td class="dataTableContent"><?php echo  $products['products_name'] . ' (' . $products['name'] . ')'; ?></td>
                    <td class="dataTableContent" align="center"><?php echo $products['products_viewed']; ?>&nbsp;</td>
                  </tr>
                <?php
                  }
                ?>
                </table>
                </div>
                
                    <div class='col-xs-12'>
                      <div class="smallText col-xs-6" ><?php echo $products_split->display_count($products_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></div>
                      <div class="smallText col-xs-6 text-right" ><?php echo $products_split->display_links($products_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></div>
                    </div>
                
</div>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>