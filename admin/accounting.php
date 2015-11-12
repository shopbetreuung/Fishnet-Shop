<?php
/* --------------------------------------------------------------
   $Id: accounting.php 1167 2005-08-22 00:43:01Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards www.oscommerce.com 
   (c) 2003	 nextcommerce (accounting.php,v 1.27 2003/08/24); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'save':


      // reset values before writing
       $admin_access_query = xtc_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . (int)$_GET['cID'] . "'");
       $admin_access = xtc_db_fetch_array($admin_access_query);

       $fields = mysql_list_fields(DB_DATABASE, TABLE_ADMIN_ACCESS);
       $columns = mysql_num_fields($fields);

		for ($i = 0; $i < $columns; $i++) {
             $field=mysql_field_name($fields, $i);
                    if ($field!='customers_id') {

                    xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET
                                  ".$field."=0 where customers_id='".(int)$_GET['cID']."'");
    		}
        }



      $access_ids='';
        if(isset($_POST['access'])) foreach($_POST['access'] as $key){

        xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET ".$key."=1 where customers_id='".(int)$_GET['cID']."'");

        }

        xtc_redirect(xtc_href_link(FILENAME_CUSTOMERS, 'cID=' . (int)$_GET['cID'], 'NONSSL'));
        break;
      }
    }
    if ($_GET['cID'] != '') {
      if ($_GET['cID'] == 1) {
        xtc_redirect(xtc_href_link(FILENAME_CUSTOMERS, 'cID=' . (int)$_GET['cID'], 'NONSSL'));
      } else {
        $allow_edit_query = xtc_db_query("select customers_status, customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$_GET['cID'] . "'");
        $allow_edit = xtc_db_fetch_array($allow_edit_query);
        if ($allow_edit['customers_status'] != 0 || $allow_edit == '') {
          xtc_redirect(xtc_href_link(FILENAME_CUSTOMERS, 'cID=' . (int)$_GET['cID'], 'NONSSL'));
        }
      }
    }
require (DIR_WS_INCLUDES.'head.php');
?>
<!-- BOF - web28 - 2010.05.30 - set all checkboxes -->
<script type="text/javascript">
function set_checkbox (set) {
  if (set == 1) {
    for (var i = 0; i < document.getElementsByName("access[]").length; ++i)
		document.getElementsByName("access[]")[i].checked = true;    
  }
  if (set == 0) {
    for (var i = 0; i < document.getElementsByName("access[]").length; ++i)
		document.getElementsByName("access[]")[i].checked = false; 
  }
  
}
</script>
<!-- EOF - web28 - 2010.05.30 - set all checkboxes -->

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<div class ="row">
    
<!--                            <div class=""></div>                             -->
<!-- body_text //-->
    <div class="col-xs-12">
        <div class="col-xs-12"><p class="h2"><?php echo TEXT_ACCOUNTING.' '.$allow_edit['customers_lastname'].' '.$allow_edit['customers_firstname']; ?></p><br /></div>  
    </div>

    <div class="col-xs-12">
        <div class="col-xs-3">
            <table class="table table-striped">
      <tr>
                    <td  bgcolor="FF6969" ><?php echo xtc_draw_separator('pixel_trans.gif',15, 15); ?></td>
                    <td  class="main"><?php echo TXT_SYSTEM; ?></td>
      </tr>
      <tr>
                    <td bgcolor="69CDFF" ><?php echo xtc_draw_separator('pixel_trans.gif',10, 15); ?></td>
                    <td  class="main"><?php echo TXT_CUSTOMERS; ?></td>
      </tr>
      <tr>
                    <td bgcolor="6BFF7F" ><?php echo xtc_draw_separator('pixel_trans.gif',15, 15); ?></td>
                    <td  class="main"><?php echo TXT_PRODUCTS; ?></td>
      </tr>
      <tr>
                    <td bgcolor="BFA8FF" ><?php echo xtc_draw_separator('pixel_trans.gif',15, 15); ?></td>
                    <td  class="main"><?php echo TXT_STATISTICS; ?></td>
      </tr>
      <tr>
                    <td bgcolor="FFE6A8" ><?php echo xtc_draw_separator('pixel_trans.gif',15, 15); ?></td>
                    <td  class="main"><?php echo TXT_TOOLS; ?></td>
      </tr>
      </table>
            <br /><br />
        </div>
    </div>
    <div class="col-xs-12">
	   <!-- BOF - web28 - 2010.05.30 - set all checkboxes -->
       <a class="btn btn-default" href="#" onclick="set_checkbox(1);"><?php echo BUTTON_SET; ?></a>
       &nbsp;&nbsp;&nbsp;<a class="btn btn-default" href="#" onclick="set_checkbox(0);"><?php echo BUTTON_UNSET; ?></a>
	  <br /><br />
	  <!-- EOF - web28 - 2010.05.30 - set all checkboxes -->
    </div>
    <div class="col-xs-12">
        <table class="table table-striped">
            <thead>
      <tr>
            <td class="dataTableHeadingContent"><?php echo TEXT_ACCESS; ?></td>
            <td class="dataTableHeadingContent"><?php echo TEXT_ALLOWED; ?></td>
          </tr>
            </thead>
            <tbody>
<?php
 echo xtc_draw_form('accounting', FILENAME_ACCOUNTING, 'cID=' . $_GET['cID']  . '&action=save', 'post', 'enctype="multipart/form-data"');

   $admin_access='';
    $customers_id = xtc_db_prepare_input($_GET['cID']);
    $admin_access_query = xtc_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . (int)$_GET['cID'] . "'");
    $admin_access = xtc_db_fetch_array($admin_access_query);

    $group_query=xtc_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = 'groups'");
    $group_access = xtc_db_fetch_array($group_query);
    if ($admin_access == '') {
      xtc_db_query("INSERT INTO " . TABLE_ADMIN_ACCESS . " (customers_id) VALUES ('" . (int)$_GET['cID'] . "')");
      $admin_access_query = xtc_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . (int)$_GET['cID'] . "'");
      $group_query=xtc_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = 'groups'");
      $group_access = xtc_db_fetch_array($admin_access_query);
      $admin_access = xtc_db_fetch_array($admin_access_query);
    }

$fields = mysql_list_fields(DB_DATABASE, TABLE_ADMIN_ACCESS);
$columns = mysql_num_fields($fields);

for ($i = 0; $i < $columns; $i++) {
    $field=mysql_field_name($fields, $i);
    if ($field!='customers_id') {
    $checked='';
    if ($admin_access[$field] == '1') $checked='checked';

    // colors
    switch ($group_access[$field]) {
            case '1':
            $color='#FF6969';
            break;
            case '2':
            $color='#69CDFF';
            break;
            case '3':
            $color='#6BFF7F';
            break;
            case '4':
            $color='#BFA8FF';
            break;
            case '5':
            $color='#FFE6A8';

    }
    echo '<tr>
    <td width="10" bgcolor="'.$color.'" >'.xtc_draw_separator('pixel_trans.gif',15, 15).'</td>
        <td class="dataTableContentRow">
        <input type="checkbox" name="access[]" value="'.$field.'"'.$checked.'>
        '.$field.'</td>
        </tr>';
    }
}
?>
    </tbody>
    </table>
    </div>
<input type="submit" class="btn btn-default" onclick="return confirm('<?php echo SAVE_ENTRY; ?>')" value="<?php echo BUTTON_SAVE; ?>">

<!-- body_text_eof //-->
</div>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
