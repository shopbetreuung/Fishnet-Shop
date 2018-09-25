<?php
require('includes/application_top.php');
?>
<html>
<head>
    <?php
    require (DIR_WS_INCLUDES.'head.php');
    ?>
</head>
<body style="margin: 0; background-color: #FFFFFF">
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->
    
    <?php
    $confirm_save_entry = 'onclick="return confirm(\''. SAVE_ENTRY .'\')"';
    $pPath_array = explode('_', $_GET['pPath']);
    $cPath_array = explode('_', $_GET['cPath']);
    ?>
    <!-- CHANGE CATEGORIES START -->
    <div class="col-sm-6" style="min-height: 500px;">
        <p class="h2"> <?php echo TEXT_CHANGE_CATEGORIES; ?> </p>
        <div class="col-sm-12" style="border-top: 1px solid #e7e7e7;">&nbsp;</div>
        <div class="col-xs-12">
            <?php 
            if($_GET['cPath'] != ''){
                if(isset($_POST['search_replace_categories']) && isset($_POST['search_categories']) && isset($_POST['replace_categories']) && !empty($_POST['search_categories']) && !empty($_POST['replace_categories'])){
                    switch ($_POST['search_replace_categories']){
                        case '1':
                            foreach($cPath_array as $id){
                                xtc_db_query("UPDATE " . TABLE_CATEGORIES_DESCRIPTION . " SET categories_name = REPLACE(categories_name, '".$_POST['search_categories']."', '".$_POST['replace_categories']."') WHERE language_id = '" . (int)$_SESSION['languages_id']."' AND categories_id = '" . $id . "'");
                            }
                        break;
                        case '2':
                            foreach($cPath_array as $id){
                                xtc_db_query("UPDATE " . TABLE_CATEGORIES_DESCRIPTION . " SET categories_description = REPLACE(categories_description, '".$_POST['search_categories']."', '".$_POST['replace_categories']."') WHERE language_id = '" . (int)$_SESSION['languages_id']."' AND categories_id = '" . $id . "'");
                            }
                        break;
                    }
                    echo '<p class="alert alert-success">'.TEXT_SUCCESS.'</p>';
                }else if(isset($_POST['categories_change']) && (empty($_POST['search_categories']) || empty($_POST['replace_categories']))){
                    echo '<p class="alert alert-danger">'.TEXT_ERROR.'</p>';
                }
                $categories_change = array(
                    array('id' => '1', 'text' => ENTRY_NAME), 
                    array('id' => '2', 'text' => ENTRY_DESCRIPTION)
                );
                ?>
                <?php
                echo xtc_draw_form("change_categories", "globaledit.php?pPath=".$_GET['pPath'].'&cPath='.$_GET['cPath'],"","post","id=change_categories");
                    echo TEXT_CHOOSE.xtc_draw_pull_down_menu('search_replace_categories', $categories_change).'<br />';
                    echo TEXT_SEARCH.xtc_draw_input_field('search_categories', '' ,'style="width: 200px !important"').'<br />';
                    echo TEXT_REPLACE.xtc_draw_input_field('replace_categories', '' ,'style="width: 200px !important"').'<br />';
                ?>
                <input type="submit" class="btn btn-default" name="categories_change" value="<?php echo BUTTON_SAVE; ?>" <?php echo $confirm_save_entry;?>>
                </form>

                <?php
            
                function getAllChilds($cid) {
                    $all_child_categories = array($cid);

                    $all_child_categories_query = xtc_db_query ("SELECT categories_id, parent_id FROM categories WHERE parent_id = '".$cid."'");

                    foreach($all_child_categories_query as $row) {
                        $all_child_categories = array_merge($all_child_categories, getAllChilds($row["categories_id"]));
                    }

                    return $all_child_categories;
                }

                if ($_GET['cPath'] != '') {
                    if (isset($_POST['products_discount_allowed']) && !empty($_POST['products_discount_allowed'])) {
                        foreach ($cPath_array as $cid) {
                            
                            $all_categories_ids_array = getAllChilds($cid);
                            
                            foreach ($all_categories_ids_array as $categories_id) {
                                $get_product_ids_query = xtc_db_query("SELECT products_id FROM ".TABLE_PRODUCTS_TO_CATEGORIES." WHERE categories_id = ".$categories_id."");
                                
                                while ($products_id = xtc_db_fetch_array($get_product_ids_query)) {
                                    foreach($products_id as $pid) {
                                        xtc_db_query("UPDATE ".TABLE_PRODUCTS." SET products_discount_allowed = '".$_POST['products_discount_allowed']."', products_last_modified = NOW() WHERE products_id = ".$pid."");
                                    }
                                }
                            } 
                        }
                        echo '<p class="alert alert-success">'.TEXT_SUCCESS.'</p>';   
                    } elseif (isset($_POST['products_discount_allowed']) && empty($_POST['products_discount_allowed'])) {
                        echo '<p class="alert alert-danger">'.TEXT_ERROR_MAX_DISCOUNT.'</p>';
                    }
                    echo xtc_draw_form("change_categories_max_discount", "globaledit.php?pPath=".$_GET['pPath'].'&cPath='.$_GET['cPath'],"","post","id=change_categories_max_discount");
                    echo '<b>'.TEXT_MAX_DISCOUNT_WARRNING.'</b><br />';
                    echo TEXT_MAX_DISCOUNT.xtc_draw_input_field('products_discount_allowed', '' ,'style="width: 200px !important"').'<br />';
                } 
            ?>
            <input type="submit" class="btn btn-default" name="change_categories_max_discount" value="<?php echo BUTTON_SAVE; ?>" <?php echo $confirm_save_entry;?>>
            </form>

                <p class="h4"> <?php echo TEXT_LIST_CATEGORIES; ?> </p>
     <?php } ?>
            <ul class="list-group">
            <?php 
            foreach($cPath_array as $categories_id){
                $categories_query = xtc_db_query("SELECT categories_name FROM " . TABLE_CATEGORIES_DESCRIPTION . " WHERE categories_id = '" . $categories_id . "' AND language_id = '" . (int)$_SESSION['languages_id']."' ");
                while($categories_array = xtc_db_fetch_array($categories_query)){?>
                    <li class="list-group-item"><?php echo $categories_array['categories_name']; ?></li>
                <?php }?>
            <?php }?>
            </ul>
        </div>
    </div>
    <!-- CHANGE CATEGORIES END -->
    
    <!-- CHANGE PRODUCTS START -->
    <div class="col-sm-6" style="border-left: 1px solid #e7e7e7; min-height: 500px;">
        <p class="h2"> <?php echo TEXT_CHANGE_PRODUCTS; ?> </p>
        <div class="col-sm-12" style="border-top: 1px solid #e7e7e7;">&nbsp;</div>
        <div class="col-xs-12">
            <?php 
            if($_GET['pPath'] != ''){
                if(isset($_POST['search_replace_products']) && isset($_POST['search_products']) && isset($_POST['replace_products']) && !empty($_POST['search_products']) && !empty($_POST['replace_products'])){
                    switch ($_POST['search_replace_products']){
                        case '1':
                            foreach($pPath_array as $id){
                                xtc_db_query("UPDATE " . TABLE_PRODUCTS_DESCRIPTION . " SET products_name = REPLACE(products_name, '".$_POST['search_products']."', '".$_POST['replace_products']."') WHERE language_id = '" . (int)$_SESSION['languages_id']."' AND products_id = '" . $id . "'");
                            }
                        break;
                        case '2':
                            foreach($pPath_array as $id){
                                xtc_db_query("UPDATE " . TABLE_PRODUCTS_DESCRIPTION . " SET products_description = REPLACE(products_description, '".$_POST['search_products']."', '".$_POST['replace_products']."') WHERE language_id = '" . (int)$_SESSION['languages_id']."' AND products_id = '" . $id . "'");
                            }
                        break;
                        case '3':
                            foreach($pPath_array as $id){
                                xtc_db_query("UPDATE " . TABLE_PRODUCTS_DESCRIPTION . " SET products_short_description = REPLACE(products_short_description, '".$_POST['search_products']."', '".$_POST['replace_products']."') WHERE language_id = '" . (int)$_SESSION['languages_id']."' AND products_id = '" . $id . "'");
                            }
                        break;
                        case '4':
                            foreach($pPath_array as $id){
                                xtc_db_query("UPDATE " . TABLE_PRODUCTS_DESCRIPTION . " SET products_order_description = REPLACE(products_order_description, '".$_POST['search_products']."', '".$_POST['replace_products']."') WHERE language_id = '" . (int)$_SESSION['languages_id']."' AND products_id = '" . $id . "'");
                            }
                        break;
                    }
                    echo '<p class="alert alert-success">'.TEXT_SUCCESS.'</p>';
                }else if(isset($_POST['products_change']) && (empty($_POST['search_products']) || empty($_POST['replace_products']))){
                    echo '<p class="alert alert-danger">'.TEXT_ERROR.'</p>';
                }
                
                $products_change = array(
                    array('id' => '1', 'text' => ENTRY_NAME), 
                    array('id' => '2', 'text' => ENTRY_DESCRIPTION),
                    array('id' => '3', 'text' => ENTRY_SHORT_DESCRIPTION),
                    array('id' => '4', 'text' => ENTRY_ORDER_DESCRIPTION)
                );
                ?>
                <?php
                echo xtc_draw_form("change_products", "globaledit.php?pPath=".$_GET['pPath'].'&cPath='.$_GET['cPath'],"","post","id=change_products");
                    echo TEXT_CHOOSE.xtc_draw_pull_down_menu('search_replace_products', $products_change).'<br />';
                    echo TEXT_SEARCH.xtc_draw_input_field('search_products', '' ,'style="width: 200px !important"').'<br />';
                    echo TEXT_REPLACE.xtc_draw_input_field('replace_products', '' ,'style="width: 200px !important"').'<br />';
                ?>
                <input type="submit" class="btn btn-default" name="products_change" value="<?php echo BUTTON_SAVE; ?>" <?php echo $confirm_save_entry;?>>
                </form>
                <p class="h4"> <?php echo TEXT_LIST_PRODUCTS; ?> </p>
     <?php } ?>
            
            <ul class="list-group">
            <?php 
            foreach($pPath_array as $products_id){
                $products_query = xtc_db_query("SELECT products_name FROM " . TABLE_PRODUCTS_DESCRIPTION . " WHERE products_id = '" . $products_id . "' AND language_id = '" . (int)$_SESSION['languages_id']."' ");
                while($products_array = xtc_db_fetch_array($products_query)){?>
                    <li class="list-group-item"><?php echo $products_array['products_name']; ?></li>
                <?php }?>
            <?php }?>
            </ul>
        </div>
    </div>
    <!-- CHANGE PRODUCTS END -->