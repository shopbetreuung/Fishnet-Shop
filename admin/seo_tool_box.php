<?php
require('includes/application_top.php');
require (DIR_WS_INCLUDES.'head.php');
?>

<body>
<?php require(DIR_WS_INCLUDES . 'header.php'); 

$seo_tool_box_dropdown = array(array('id'=> 0, 'text'=> SEO_TOOL_BOX_DEFAULT_VALUE));
$seo_tool_box_dropdown_array = array(
                                        array('id'=> 1, 'text'=> SEO_TOOL_BOX_PRODUCTS_WITHOUT_META_TITLE),
                                        array('id'=> 2, 'text'=> SEO_TOOL_BOX_PRODUCTS_WITH_META_TITLE),
                                        array('id'=> 3, 'text'=> SEO_TOOL_BOX_PRODUCTS_WITHOUT_META_DESCRIPTION),
                                        array('id'=> 4, 'text'=> SEO_TOOL_BOX_WITH_META_DESCRIPTION),    
                                        array('id'=> 5, 'text'=> SEO_TOOL_BOX_WITHOUT_DESCRIPTION),    
                                        array('id'=> 6, 'text'=> SEO_TOOL_BOX_PRODUCTS_NEVER_SOLD),    
                                        array('id'=> 7, 'text'=> SEO_TOOL_BOX_PRODUCTS_WITHOUT_MAIN_IMAGE_DESCRIPTION),    
                                        array('id'=> 8, 'text'=> SEO_TOOL_BOX_PRODUCTS_WITHOUT_MAIN_IMAGE_ALT_TEXT),    
                                        array('id'=> 9, 'text'=> SEO_TOOL_BOX_PRODUCTS_WITHOUT_IMAGE_DESCRIPTION),    
                                        array('id'=> 10, 'text'=> SEO_TOOL_BOX_PRODUCTS_WITHOUT_IMAGE_ALT_TEXT),    
                                        array('id'=> 11, 'text'=> SEO_TOOL_BOX_PRODUCTS_WITH_SAME_META_TITLE),                                    
                                        array('id'=> 12, 'text'=> SEO_TOOL_BOX_PRODUCTS_WITH_SAME_META_DESCRIPTION),                                    
                                    );

$seo_tool_box_select_array = array_merge($seo_tool_box_dropdown,$seo_tool_box_dropdown_array);

$seo_tool_box_action = (isset($_GET['seo_tool_box']))? $_GET['seo_tool_box'] : 0 ;

switch($seo_tool_box_action) {
    case 1:
        $seo_tool_box_where = " AND pd.products_meta_title = '' ";
        break;
    case 2:
        $seo_tool_box_where = " AND LENGTH(pd.products_meta_title) > 70 ";
        break;
    case 3:
        $seo_tool_box_where = " AND pd.products_meta_description = '' ";
        break;
    case 4:
        $seo_tool_box_where = " AND LENGTH(pd.products_meta_description) > 160 ";
        break;
    case 5:
        $seo_tool_box_where = " AND pd.products_description = '' ";
        break;
    case 6:
        $seo_tool_box_where = " AND pd.products_id NOT IN (SELECT op.products_id FROM ".TABLE_ORDERS_PRODUCTS." op ) ";
        break;
    case 7:
        $seo_tool_box_where = " AND p.products_image_title = '' ";
        break;
    case 8:
        $seo_tool_box_where = " AND p.products_image_alt = '' ";
        break;
    case 9:
        $seo_tool_box_where = " AND pi.image_title = '' ";
        break;
    case 10:
        $seo_tool_box_where = " AND pi.image_alt = '' ";
        break;
    case 11:
        
        $products_meta_title_query = xtc_db_query("SELECT pd.products_meta_title FROM ".TABLE_PRODUCTS_DESCRIPTION." pd WHERE pd.language_id = ".$_SESSION['languages_id']." GROUP BY products_meta_title HAVING ( COUNT(*) > 1) ");
        $product_meta_title_array = array();
        
        while ($products_meta_title_array = xtc_db_fetch_array($products_meta_title_query)) {
            $product_meta_title_array[] = "'".addslashes($products_meta_title_array['products_meta_title'])."'";
        }

        $seo_tool_box_where = " AND pd.products_meta_title IN (".implode(',',$product_meta_title_array).") AND pd.products_meta_title != '' ORDER BY pd.products_meta_title ";
        break;
    case 12:

        $products_meta_description_query = xtc_db_query("SELECT pd.products_meta_description FROM ".TABLE_PRODUCTS_DESCRIPTION." pd WHERE pd.language_id = ".$_SESSION['languages_id']." GROUP BY products_meta_description HAVING ( COUNT(*) > 1) ");
        $product_meta_description_array = array();
        
        while ($products_meta_description_array = xtc_db_fetch_array($products_meta_description_query)) {
            $product_meta_description_array[] = "'".addslashes($products_meta_description_array['products_meta_description'])."'";
        }

        $seo_tool_box_where = " AND pd.products_meta_description IN (".implode(',',$product_meta_description_array).") AND pd.products_meta_description != '' ORDER BY pd.products_meta_description ";

    break;

    
}

?>
    <div class='row'>
        <div class='col-xs-12'>
            <p class="h2">
                <?php echo SEO_TOOL_BOX_HEADING_TITLE; ?>
            </p>           
        </div>
        <br />
        <div class='col-xs-12'>
            <?php  
                echo xtc_draw_form('seo_tool_box_form', FILENAME_SEO_TOOL_BOX,'','get');
                echo SEO_TOOL_BOX_SEARCH.' '.xtc_draw_pull_down_menu('seo_tool_box',$seo_tool_box_select_array, (!isset($_GET['seo_tool_box'])) ? 0 : $_GET['seo_tool_box']);
                echo xtc_button(SEO_TOOL_BOX_SEARCH_BUTTON, 'submit');
            ?>
            </form>
            
            <div class='col-xs-12'> <br /> </div>
            <?php
            if (isset($_GET['seo_tool_box']) && $seo_tool_box_action != 0) {
            ?>
            <table class='table table-bordered'>  
                <tr>
                    <td> <?php echo '<strong>'.SEO_TOOL_BOX_TABLE_PRODUCTS_NAME.'</strong>'; ?> </td> 

                </tr>
                <?php
                
                switch ($seo_tool_box_action) {
                    case 7:
                    case 8:
                        $seo_tool_box_select = "SELECT pd.products_id, pd.products_name FROM ".TABLE_PRODUCTS_DESCRIPTION." pd JOIN ".TABLE_PRODUCTS." p ON pd.products_id = p.products_id WHERE pd.language_id = ".$_SESSION['languages_id'].$seo_tool_box_where."";
                        break;
                    case 9:
                    case 10:
                        $seo_tool_box_select = "SELECT DISTINCT pd.products_id, pd.products_name FROM ".TABLE_PRODUCTS_DESCRIPTION." pd JOIN ".TABLE_PRODUCTS_IMAGES." pi ON pd.products_id = pi.products_id WHERE pd.language_id = ".$_SESSION['languages_id'].$seo_tool_box_where."";
                        break;
                    case 11:
                        $seo_tool_box_select = "SELECT pd.products_id, pd.products_name, pd.products_meta_title FROM ".TABLE_PRODUCTS_DESCRIPTION." pd WHERE pd.language_id = ".$_SESSION['languages_id'].$seo_tool_box_where."";
                        $product_meta_title_value = null;
                        break;
                    case 12:
                        $seo_tool_box_select = "SELECT pd.products_id, pd.products_name, pd.products_meta_description FROM ".TABLE_PRODUCTS_DESCRIPTION." pd WHERE pd.language_id = ".$_SESSION['languages_id'].$seo_tool_box_where."";
                        $products_meta_description_value = null;
                        break;
                    default:
                        $seo_tool_box_select = "SELECT pd.products_id, pd.products_name FROM ".TABLE_PRODUCTS_DESCRIPTION." pd WHERE pd.language_id = ".$_SESSION['languages_id'].$seo_tool_box_where."";
                        break;
                }
                
                $seo_tool_box_split = new splitPageResults($_GET['page'], '30', $seo_tool_box_select, $seo_tool_box_query_numrows,'pd.products_id');
                $seo_tool_box_query = xtc_db_query($seo_tool_box_select);

                while ($seo_tool_box_array = xtc_db_fetch_array($seo_tool_box_query)) {

                    echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'pointer\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\''.xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array ('pID', 'action')).'pID='.$seo_tool_box_array['products_id'].'&action=new_product').'\'">'."\n";
                
                    switch($seo_tool_box_action) {
                        case 11:
                            if (!isset($product_meta_title_value)) {
                                $product_meta_title_value = $seo_tool_box_array['products_meta_title'];
                            }
                            
                            if ($product_meta_title_value == $seo_tool_box_array['products_meta_title']) {
                            ?>
                                <td class="dataTableContent" align="right" width="25%" style="color:#007bff;"><?php echo $seo_tool_box_array['products_name']; ?>&nbsp;</td>  
                            <?php
                            } else {
                            ?>
                                <td class="dataTableContent" align="right" width="25%" style="border-top: 2px solid #aaa1a1; color:#007bff;"><?php echo $seo_tool_box_array['products_name']; ?>&nbsp;</td>  
                            <?php
                                unset($product_meta_title_value);
                            }
                            
                            break;
                        case 12:
                            if (!isset($products_meta_description_value)) {
                                $products_meta_description_value = $seo_tool_box_array['products_meta_description'];
                            }
                            
                            if ($products_meta_description_value == $seo_tool_box_array['products_meta_description']) {
                            ?>
                                <td class="dataTableContent" align="right" width="25%" style="color:#007bff;"><?php echo $seo_tool_box_array['products_name']; ?>&nbsp;</td>  
                            <?php
                            } else {
                            ?>
                                <td class="dataTableContent" align="right" width="25%" style="border-top: 2px solid #aaa1a1; color:#007bff;"><?php echo $seo_tool_box_array['products_name']; ?>&nbsp;</td>  
                            <?php
                                unset($products_meta_description_value);
                            }
                            
                            break;
                        default:
                
                ?>
                    <td class="dataTableContent" align="right" width="25%" style="color:#007bff;"><?php echo $seo_tool_box_array['products_name']; ?>&nbsp;</td>                   
                
                <?php
                        break;
                    }
                    echo '</tr> ';
                }

                ?>

            </table>
            <div class='col-xs-12'>
                <div class="smallText col-xs-6"><?php echo $seo_tool_box_split->display_count($seo_tool_box_query_numrows, '30', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SEO_TOOL_BOX); ?></div>
                <div class="smallText col-xs-6 text-right"><?php echo $seo_tool_box_split->display_links($seo_tool_box_query_numrows, '30', MAX_DISPLAY_PAGE_LINKS,$_GET['page'], xtc_get_all_get_params(array('page'))); ?></div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>