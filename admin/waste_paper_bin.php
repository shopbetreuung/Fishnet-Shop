<?php

require('includes/application_top.php');
?>
<html>
<head>
    <?php
    require (DIR_WS_INCLUDES.'head.php');
    ?>
    <script type="text/javascript" language="JavaScript">

    function checkCheckBoxes(theForm) {
            if (theForm.if_checked.checked == false)
            {
                    alert ('You didn\'t choose any of the checkboxes!');
                    return false;
            } else {
                return confirm('Sind Sie sicher? \n Are you sure?');
            }
    }
</script> 
</head>
<body style="margin: 0; background-color: #FFFFFF">
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->

    <?php 
    if( defined('USE_ADMIN_THUMBS_IN_LIST_STYLE')) {
    $admin_thumbs_size = 'style="'.USE_ADMIN_THUMBS_IN_LIST_STYLE.'"';
    } else {
      $admin_thumbs_size = 'style="max-width: 40px; max-height: 40px;"';
    }
    $icon_padding = 'style="padding-right:8px;"';
    require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'xtcPrice.php');
    $xtPrice = new xtcPrice(DEFAULT_CURRENCY,1);
    $products_rows = 0;
    $query = xtc_db_query("SELECT * FROM " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON p.products_id = pd.products_id LEFT JOIN products_to_categories ptc ON p.products_id = ptc.products_id WHERE p.waste_paper_bin = '1' AND pd.language_id = '" . (int)$_SESSION['languages_id']."' ");
    
    ?>
    <p class="h2"> <?php echo HEADER_WASTE_PAPER_BIN; ?> </p><br />
    <div id ="responsive_table" class="table-responsive pull-left col-sm-12">
        <table class="table table-bordered table-striped">
                <tr class="dataTableHeadingRow">
                     <td class="dataTableHeadingContent" width="4%" align="center">
                        <?php echo TABLE_HEADING_CHECK; ?><br />
                    </td>
                    <?php
                    if( USE_ADMIN_THUMBS_IN_LIST=='true' ) {
                      ?>
                      <td class="dataTableHeadingContent" width="10%" align="center">
                        <?php echo TABLE_HEADING_IMAGE ?>
                      </td>
                      <?php
                    }
                    ?>
                    <td class="dataTableHeadingContent" width="10%" align="center">
                      <?php echo TABLE_HEADING_NAME ?>
                    </td>
                    <td class="dataTableHeadingContent" align="center" width="10%">
                      <?php echo TABLE_HEADING_PRICE; ?>
                    </td>
                    <td class="dataTableHeadingContent" align="center" width="10%">
                      <?php echo TABLE_HEADING_ADDED; ?>
                    </td>
                     <td class="dataTableHeadingContent" align="center" width="10%">
                      <?php echo TABLE_HEADING_LAST_MODIFIED; ?>
                    </td>
                    <td class="dataTableHeadingContent" align="center" width="10%">
                      <?php echo TABLE_HEADING_EDIT; ?>
                    </td>
                </tr>
    <form action="<?php echo HTTP_CATALOG_SERVER.DIR_WS_ADMIN.FILENAME_WASTE_PAPER_BIN; ?>" method="post" onsubmit="return checkCheckBoxes(this);">
    <?php 
    
    while($products = xtc_db_fetch_array($query)){
        $products_rows++;
                 echo '<tr class="dataTableRow">' . "\n";
                 ?>
                
                 <td class="categories_view_data">
                   <input type="checkbox" name="multi_products[]" id= "if_checked" value="<?php echo $products['products_id']; ?>"/>
                 </td>
                 
                 <?php
                 if( USE_ADMIN_THUMBS_IN_LIST=='true' ) { ?>
                   <td class="categories_view_data" style="text-align: center;">
                     <?php
                     echo xtc_product_thumb_image($products['products_image'], $products['products_name'], '','',$admin_thumbs_size);
                     ?>
                   </td>
                   <?php
                 }
                 ?>
                 
                 <?php
                 if ($products['products_name'] !='' ){
                   ?>
                   <td class="categories_view_data ">
                     <?php echo $products['products_name']; ?>
                   </td>
                   <?php
                 } else {
                   ?>
                   <td class="categories_view_data " width="22">--</td>
                   <?php
                 }
                 ?>
                 
                 <?php
                 if ($products['products_price'] !='' ){
                   ?>
                   <td class="categories_view_data">
                     <?php 
                     echo $xtPrice->xtcFormat($products['products_price'], true);
                     ?>
                   </td>
                   <?php
                 } else {
                   ?>
                   <td class="categories_view_data" width="22">--</td>
                   <?php
                 }
                 ?>
                  
                <?php
                 if ($products['products_date_added'] !='' ){
                   ?>
                   <td class="categories_view_data">
                     <?php echo $products['products_date_added']; ?>
                   </td>
                   <?php
                 } else {
                   ?>
                   <td class="categories_view_data" width="22">--</td>
                   <?php
                 }
                 ?>
                   
                 <?php
                 if ($products['products_last_modified'] !='' ){
                   ?>
                   <td class="categories_view_data">
                     <?php echo $products['products_last_modified']; ?>
                   </td>
                   <?php
                 } else {
                   ?>
                   <td class="categories_view_data" width="22">--</td>
                   <?php
                 }
                 ?>
                   <td class="categories_view_data">
                       <?php echo '<a href="'. xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $products['categories_id'] . '&pID=' . $products['products_id'] ) . '&action=new_product' . '">' . xtc_image(DIR_WS_ICONS . 'icon_edit.gif', ICON_EDIT, '', '', $icon_padding). '</a>'; ?>
                   </td>
                 
            </tr>
    <?php
   }
   ?>
            
        </table>
    </div>
    <?php 
    if (is_array($_POST['multi_products']) && isset($_POST['multi_products'])) {
        foreach($_POST['multi_products'] as $product){
            if(isset($_POST['put_out_of_wastebin'])){
                xtc_db_query("UPDATE products SET waste_paper_bin = '0' WHERE products_id = '".$product."'");
            }elseif($_POST['delete_permanently']){
                // get content of product
                $product_content_query = xtc_db_query("SELECT content_file FROM ".TABLE_PRODUCTS_CONTENT." WHERE products_id = '".$product."'");
                // check if used elsewhere, delete db-entry + file if not
                while ($product_content = xtc_db_fetch_array($product_content_query)) {
                   $duplicate_content_query = xtc_db_query("SELECT count(*) AS total FROM ".TABLE_PRODUCTS_CONTENT." WHERE content_file = '".xtc_db_input($product_content['content_file'])."' AND products_id != '".$product."'");
                   $duplicate_content = xtc_db_fetch_array($duplicate_content_query);
                   if ($duplicate_content['total'] == 0) {
                     @unlink(DIR_FS_DOCUMENT_ROOT.'media/products/'.$product_content['content_file']);
                   }
                   //delete DB-Entry
                   xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_CONTENT." WHERE products_id = '".$product."' AND (content_file = '".$product_content['content_file']."' OR content_file = '')");
                }

                $product_image_query = xtc_db_query("SELECT products_image FROM ".TABLE_PRODUCTS." WHERE products_id = '".$product."'");
                $product_image = xtc_db_fetch_array($product_image_query);

                $duplicate_image_query = xtc_db_query("SELECT count(*) AS total FROM ".TABLE_PRODUCTS." WHERE products_image = '".xtc_db_input($product_image['products_image'])."'");
                $duplicate_image = xtc_db_fetch_array($duplicate_image_query);

                if ($duplicate_image['total'] < 2) {
                  xtc_del_image_file($product_image['products_image']);
                }

                //delete more images
                $mo_images_query = xtc_db_query("SELECT image_name FROM ".TABLE_PRODUCTS_IMAGES." WHERE products_id = '".$product."'");
                while ($mo_images_values = xtc_db_fetch_array($mo_images_query)) {
                  $duplicate_more_image_query = xtc_db_query("SELECT count(*) AS total FROM ".TABLE_PRODUCTS_IMAGES." WHERE image_name = '".$mo_images_values['image_name']."'");
                  $duplicate_more_image = xtc_db_fetch_array($duplicate_more_image_query);
                  if ($duplicate_more_image['total'] < 2) {
                    xtc_del_image_file($mo_images_values['image_name']);
                  }
                }
                xtc_db_query("DELETE FROM ".TABLE_SPECIALS." WHERE products_id = '".$product."'");
                xtc_db_query("DELETE FROM ".TABLE_PRODUCTS." WHERE products_id = '".$product."'");
                xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_IMAGES." WHERE products_id = '".$product."'");
                xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_TO_CATEGORIES." WHERE products_id = '".$product."'");
                xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_DESCRIPTION." WHERE products_id = '".$product."'");
                xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_ATTRIBUTES." WHERE products_id = '".$product."'");
                xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_BASKET . " WHERE products_id = '" . $product . "' OR products_id LIKE '" . $product . "{%'"); //GTB - 2010-09-15 - delete also Products with attribs
                xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " WHERE products_id = '" . $product . "' OR products_id LIKE '" . $product . "{%'"); //GTB - 2010-09-15 - delete also Products with attribs
                xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_TO_CATEGORIES." WHERE products_id   = '".xtc_db_input($product_id)."'");
                
                $customers_statuses_array = xtc_get_customers_statuses();
                for ($i = 0, $n = sizeof($customers_statuses_array); $i < $n; $i ++) {
                  if (isset($customers_statuses_array[$i]['id']))
                    xtc_db_query("delete from personal_offers_by_customers_status_".$customers_statuses_array[$i]['id']." where products_id = '".$product."'");
                }

                $product_reviews_query = xtc_db_query("select reviews_id from ".TABLE_REVIEWS." where products_id = '".$product."'");
                while ($product_reviews = xtc_db_fetch_array($product_reviews_query)) {
                  xtc_db_query("delete from ".TABLE_REVIEWS_DESCRIPTION." where reviews_id = '".$product_reviews['reviews_id']."'");
                }
                xtc_db_query("delete from ".TABLE_REVIEWS." where products_id = '".$product."'");

                if (USE_CACHE == 'true') {
                  xtc_reset_cache_block('categories');
                  xtc_reset_cache_block('also_purchased');
                }
            }
        }
        xtc_redirect(FILENAME_WASTE_PAPER_BIN);
        
    }
    /*if((isset($_POST['put_out_of_wastebin']) || isset($_POST['delete_permanently'])) && !isset($_POST['multi_products'])){
        echo '<div class="col-sm-12">';
        echo '<div class="alert alert-danger">'.TEXT_NO_CHECK.'</div>';
        echo '</div>';
    }*/
    ?>
    <div class="col-sm-6">
        <input class="btn btn-default" type="submit" name ="put_out_of_wastebin" value="<?php echo BUTTON_OUT_OF_WASTE_BIN; ?>"/> 
        &nbsp;<input type ="submit" class="btn btn-default" name ="delete_permanently" id ="confirm_it" value= "<?php echo DELETE_PERMANENTLY; ?>"/>
    </form>
    </div>
    <div class="smallText col-sm-6 pull-left" style="text-align: right;">
          <?php echo TEXT_PRODUCTS . '&nbsp;' . $products_rows; ?>
    </div>
    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
