<?php
  /* --------------------------------------------------------------
   $Id: content_manager.php 4143 2012-12-18 14:55:48Z Tomcraft1980 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards www.oscommerce.com
   (c) 2003 nextcommerce (content_manager.php,v 1.18 2003/08/25); www.nextcommerce.org
   (c) 2006 XT-Commerce (content_manager.php 1304 2005-10-12)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once(DIR_FS_INC . 'xtc_format_filesize.inc.php');
  require_once(DIR_FS_INC . 'xtc_filesize.inc.php');
  require_once(DIR_FS_INC . 'xtc_wysiwyg.inc.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $special = (isset($_GET['special']) ? $_GET['special'] : '');
  $id = (isset($_GET['id']) ? $_GET['id'] : '');
  $g_coID = (isset($_GET['coID']) ? (int)$_GET['coID'] : '');
  $languages = xtc_get_languages();

  if ($special=='delete') {
    xtc_db_query("DELETE FROM ".TABLE_CONTENT_MANAGER." where content_id='".$g_coID."'");
    xtc_redirect(xtc_href_link(FILENAME_CONTENT_MANAGER));
  } // if get special


  if ($id=='update' or $id=='insert') {
    // set allowed c.groups
    $group_ids='';
    if(isset($_POST['groups'])) foreach($_POST['groups'] as $b){
      $group_ids .= 'c_'.$b."_group ,";
    }
    $customers_statuses_array=xtc_get_customers_statuses();
    if (strstr($group_ids,'c_all_group')) {
      $group_ids='c_all_group,';
      for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {
        $group_ids .='c_'.$customers_statuses_array[$i]['id'].'_group,';
      }
    }

    $content_title=xtc_db_prepare_input($_POST['cont_title']);
    $content_header=xtc_db_prepare_input($_POST['cont_heading']);
    $content_text=xtc_db_prepare_input($_POST['cont']);
    $coID=xtc_db_prepare_input($_POST['coID']);
    $upload_file=xtc_db_prepare_input($_POST['file_upload']);
    $content_status=xtc_db_prepare_input($_POST['status']);
    $content_language=xtc_db_prepare_input($_POST['language']);
    $select_file=xtc_db_prepare_input($_POST['select_file']);
    $file_flag=xtc_db_prepare_input($_POST['file_flag']);
    $parent_check=xtc_db_prepare_input($_POST['parent_check']);
    $parent_id=xtc_db_prepare_input($_POST['parent']);
    $time = xtc_db_prepare_input(date("Y-m-d H:i:s"));

    $content_query = xtc_db_query("SELECT MAX(content_group) AS content_group FROM ".TABLE_CONTENT_MANAGER."");
    $content_data = mysql_fetch_row($content_query);
    if ($_POST['content_group'] == '0' || $_POST['content_group'] == '') {
      $group_id = $content_data[0] + 1;
    } else {
      $group_id = xtc_db_prepare_input($_POST['content_group']);
    }

    $group_ids = $group_ids;
    $sort_order=xtc_db_prepare_input($_POST['sort_order']);
    $content_meta_title = xtc_db_prepare_input($_POST['cont_meta_title']);
    $content_meta_description = xtc_db_prepare_input($_POST['cont_meta_description']);
    $content_meta_keywords = xtc_db_prepare_input($_POST['cont_meta_keywords']);
    $content_meta_index = xtc_db_prepare_input($_POST['cont_meta_index']);

    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
      if ($languages[$i]['code']==$content_language) {
       $content_language=$languages[$i]['id'];
      }
    } // for

    $error=false; // reset error flag
    if (strlen($content_title) < 1) {
      $error = true;
      $messageStack->add(ERROR_TITLE,'error');
    }  // if

    if ($content_status=='yes'){
      $content_status=1;
    } else{
      $content_status=0;
    }  // if

    if ($parent_check=='yes'){
      $parent_id=$parent_id;
    } else{
      $parent_id='0';
    }  // if

    if ($error == false) {
      // file upload
      if ($select_file!='default') {
        $content_file_name=$select_file;
      }
      $accepted_file_upload_files_extensions = array("xls","xla","hlp","chm","ppt","ppz","pps","pot","doc","dot","pdf","rtf","swf","cab","tar","zip","au","snd","mp2","rpm","stream","wav","gif","jpeg","jpg","jpe","png","tiff","tif","bmp","csv","txt","rtf","tsv","mpeg","mpg","mpe","qt","mov","avi","movie","rar","7z");
      $accepted_file_upload_files_mime_types = array("application/msexcel","application/mshelp","application/mspowerpoint","application/msword","application/pdf","application/rtf","application/x-shockwave-flash","application/x-tar","application/zip","audio/basic","audio/x-mpeg","audio/x-pn-realaudio-plugin","audio/x-qt-stream","audio/x-wav","image/gif","image/jpeg","image/png","image/tiff","image/bmp","text/comma-separated-values","text/plain","text/rtf","text/tab-separated-values","video/mpeg","video/quicktime","video/x-msvideo","video/x-sgi-movie","application/x-rar-compressed","application/x-7z-compressed");
      if ($content_file = xtc_try_upload('file_upload', DIR_FS_CATALOG.'media/content/','644',$accepted_file_upload_files_extensions,$accepted_file_upload_files_mime_types)) {
        $content_file_name=$content_file->filename;
      }

      // update data in table
      $sql_data_array = array(
                            'languages_id' => $content_language,
                            'content_title' => $content_title,
                            'content_heading' => $content_header,
                            'content_text' => $content_text,
                            'content_file' => $content_file_name,
                            'content_status' => $content_status,
                            'parent_id' => $parent_id,
                            'group_ids' => $group_ids,
                            'content_group' => $group_id,
                            'sort_order' => $sort_order,
                            'file_flag' => $file_flag,
                            'content_meta_title' => $content_meta_title,
                            'content_meta_description' => $content_meta_description,
                            'content_meta_keywords' => $content_meta_keywords,
                            'content_meta_index' => $content_meta_index,
                            'change_date' => $time);
      if ($id=='update') {
        xtc_db_perform(TABLE_CONTENT_MANAGER, $sql_data_array, 'update', "content_id = '" . $coID . "'");
      } else {
        xtc_db_perform(TABLE_CONTENT_MANAGER, $sql_data_array);
      } // if get id
      xtc_redirect(xtc_href_link(FILENAME_CONTENT_MANAGER));
    } // if error
  } // if


require (DIR_WS_INCLUDES.'head.php');

  if (USE_WYSIWYG=='true') {
    $query=xtc_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
    $data=xtc_db_fetch_array($query);
    if ($action != 'new_products_content' && $action != '')
      echo xtc_wysiwyg('content_manager',$data['code']);
  }
?>
</head>
<body>
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php');?>
    <!-- header_eof //-->
    <!-- body //-->
    
    <div class="row">
        <div class="col-xs-12">
	<p class="h1"><?php echo HEADING_TITLE;?></p>
        </div>
        <div class='col-xs-12'><br /></div>
                      <?php
                        if (!$action) {
                          ?>
                          <div class="col-xs-12 pageHeading"><?php echo HEADING_CONTENT; ?></div>
                          <div class="col-xs-12 main"><?php echo CONTENT_NOTE; ?></div>
                          <?php
                          $total_space_media_content = xtc_spaceUsed(DIR_FS_CATALOG.'media/content/'); // DokuMan - 2011-09-06 - sum up correct filesize avoiding global variable
                          echo '<div class="col-xs-12 main">'.USED_SPACE.xtc_format_filesize($total_space_media_content).'</div>';
                          ?>
                          <?php
                          // Display Content
                          for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                            $content=array();
                            $content_query=xtc_db_query("SELECT
                                                                content_id,
                                                                categories_id,
                                                                parent_id,
                                                                group_ids,
                                                                languages_id,
                                                                content_title,
                                                                content_heading,
                                                                content_text,
                                                                sort_order,
                                                                file_flag,
                                                                content_file,
                                                                content_status,
                                                                content_group,
                                                                content_delete,
                                                                content_meta_title,
                                                                content_meta_description,
                                                                content_meta_keywords,
                                                                content_meta_index
                                                           FROM ".TABLE_CONTENT_MANAGER."
                                                          WHERE languages_id='".$languages[$i]['id']."'
                                                            AND parent_id='0'
                                                       ORDER BY content_group,sort_order
                                                         ");
                            while ($content_data=xtc_db_fetch_array($content_query)) {
                              $content[]=array(
                                               'CONTENT_ID' =>$content_data['content_id'] ,
                                               'PARENT_ID' => $content_data['parent_id'],
                                               'GROUP_IDS' => $content_data['group_ids'],
                                               'LANGUAGES_ID' => $content_data['languages_id'],
                                               'CONTENT_TITLE' => $content_data['content_title'],
                                               'CONTENT_HEADING' => $content_data['content_heading'],
                                               'CONTENT_TEXT' => $content_data['content_text'],
                                               'SORT_ORDER' => $content_data['sort_order'],
                                               'FILE_FLAG' => $content_data['file_flag'],
                                               'CONTENT_FILE' => $content_data['content_file'],
                                               'CONTENT_DELETE' => $content_data['content_delete'],
                                               'CONTENT_GROUP' => $content_data['content_group'],
                                               'CONTENT_STATUS' => $content_data['content_status'],
                                               'CONTENT_META_TITLE' => $content_data['content_meta_title'],
                                               'CONTENT_META_DESCRIPTION' => $content_data['content_meta_description'],
                                               'CONTENT_META_KEYWORDS' => $content_data['content_meta_keywords'],
                                               'CONTENT_META_INDEX' => $content_data['content_meta_index']);
                            } // while content_data
                            ?>
                        <div class='col-xs-12'><br /></div>
                            <div class="col-xs-12 main"><?php echo xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']).'&nbsp;&nbsp;'.$languages[$i]['name']; ?></div>
                            <div class="col-xs-12 main">
                            <table class="table">
                              <tr>
                                <th><?php echo TABLE_HEADING_CONTENT_ID; ?></th>
                                <th width="10" >&nbsp;</th>
                                <th width="30%" align="left"><?php echo TABLE_HEADING_CONTENT_TITLE; ?></th>
                                <th class='hidden-xs' width="1%" align="middle"><?php echo TABLE_HEADING_CONTENT_GROUP; ?></th>
                                <th class='hidden-xs' width="1%" align="middle"><?php echo TABLE_HEADING_CONTENT_SORT; ?></th>
                                <th class='hidden-xs' width="25%"align="left"><?php echo TABLE_HEADING_CONTENT_FILE; ?></th>
                                <th class='hidden-xs' nowrap width="5%" align="left"><?php echo TABLE_HEADING_CONTENT_STATUS; ?></th>
                                <th class='hidden-xs' nowrap width="" align="middle"><?php echo TABLE_HEADING_CONTENT_BOX; ?></th>
                                <th width="30%" align="middle"><?php echo TABLE_HEADING_CONTENT_ACTION; ?>&nbsp;</th>
                              </tr>
                              <?php
                              for ($ii = 0, $nn = sizeof($content); $ii < $nn; $ii++) {
                                $file_flag_sql = xtc_db_query("SELECT file_flag_name FROM " . TABLE_CM_FILE_FLAGS . " WHERE file_flag=" . $content[$ii]['FILE_FLAG']);
                                $file_flag_result = xtc_db_fetch_array($file_flag_sql);
                                echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
                                  if ($content[$ii]['CONTENT_FILE']=='') $content[$ii]['CONTENT_FILE']='database';
                                    ?>
                                    <td class="dataTableContent" align="left"><?php echo $content[$ii]['CONTENT_ID']; ?></td>
                                    <td bgcolor="<?php echo substr((6543216554/$content[$ii]['CONTENT_GROUP']),0,6); ?>" class="dataTableContent" align="left">&nbsp;</td>
                                    <td class="dataTableContent" align="left">
                                      <?php echo $content[$ii]['CONTENT_TITLE']; ?>
                                      <?php
                                      if ($content[$ii]['CONTENT_DELETE']=='0'){
                                        echo '<font color="#ff0000">*</font>';
                                      } ?>
                                    </td>
                                    <td class="dataTableContent hidden-xs" align="middle"><?php echo $content[$ii]['CONTENT_GROUP']; ?></td>
                                    <td class="dataTableContent hidden-xs" align="middle"><?php echo $content[$ii]['SORT_ORDER']; ?>&nbsp;</td>
                                    <td class="dataTableContent hidden-xs" align="left"><?php echo $content[$ii]['CONTENT_FILE']; ?></td>
                                    <td class="dataTableContent hidden-xs" align="middle"><?php if ($content[$ii]['CONTENT_STATUS']==0) { echo TEXT_NO; } else { echo TEXT_YES; } ?></td>
                                    <td class="dataTableContent hidden-xs" align="middle"><?php echo $file_flag_result['file_flag_name']; ?></td>
                                    <td class="dataTableContent" align="right">
                                      <a href="">
                                        <?php
                                        if ($content[$ii]['CONTENT_DELETE']=='1'){
                                          ?>
                                          <a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'special=delete&coID='.$content[$ii]['CONTENT_ID']); ?>" onclick="return confirm('<?php echo CONFIRM_DELETE; ?>')">
                                            <?php
                                            echo '<span class="glyphicon glyphicon-trash" onclick="return confirm(\''.DELETE_ENTRY.'\')"></span>'.'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';
                                        } // if content
                                        ?>
                                        <a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'action=edit&coID='.$content[$ii]['CONTENT_ID']); ?>">
                                          <?php
                                          echo '<span class="glyphicon glyphicon-pencil"></span>'.'  '.TEXT_EDIT.'</a>';
                                        ?>
                                        <a class='hidden-xs hidden-sm' style="cursor:pointer" onclick="javascript:window.open('<?php echo xtc_href_link(FILENAME_CONTENT_PREVIEW,'coID='.$content[$ii]['CONTENT_ID']); ?>', 'popup', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no, width=640, height=600')">
                                          <?php
                                          echo '<span class="glyphicon glyphicon-eye-open"></span>'.'&nbsp;&nbsp;'.TEXT_PREVIEW.'</a>';
                                        ?>
                                    </td>
                                  </tr>
                                    <?php
                                    $content_1=array();
                                    $content_1_query = xtc_db_query("SELECT
                                                                            content_id,
                                                                            categories_id,
                                                                            parent_id,
                                                                            group_ids,
                                                                            languages_id,
                                                                            content_title,
                                                                            content_heading,
                                                                            content_text,
                                                                            file_flag,
                                                                            content_file,
                                                                            content_status,
                                                                            content_delete,
                                                                            content_meta_title,
                                                                            content_meta_description,
                                                                            content_meta_keywords,
                                                                            content_meta_index
                                                                       FROM ".TABLE_CONTENT_MANAGER."
                                                                      WHERE languages_id='".$i."'
                                                                        AND parent_id='".$content[$ii]['CONTENT_ID']."'
                                                                   ORDER BY content_group,sort_order
                                                                     ");
                                    while ($content_1_data=xtc_db_fetch_array($content_1_query)) {
                                      $content_1[]=array(
                                                         'CONTENT_ID' =>$content_1_data['content_id'] ,
                                                         'PARENT_ID' => $content_1_data['parent_id'],
                                                         'GROUP_IDS' => $content_1_data['group_ids'],
                                                         'LANGUAGES_ID' => $content_1_data['languages_id'],
                                                         'CONTENT_TITLE' => $content_1_data['content_title'],
                                                         'CONTENT_HEADING' => $content_1_data['content_heading'],
                                                         'CONTENT_TEXT' => $content_1_data['content_text'],
                                                         'SORT_ORDER' => $content_1_data['sort_order'],
                                                         'FILE_FLAG' => $content_1_data['file_flag'],
                                                         'CONTENT_FILE' => $content_1_data['content_file'],
                                                         'CONTENT_DELETE' => $content_1_data['content_delete'],
                                                         'CONTENT_STATUS' => $content_1_data['content_status'],
                                                         'CONTENT_META_TITLE' => $content_1_data['content_meta_title'],
                                                         'CONTENT_META_DESCRIPTION' => $content_1_data['content_meta_description'],
                                                         'CONTENT_META_KEYWORDS' => $content_1_data['content_meta_keywords'],
                                                         'CONTENT_META_INDEX' => $content_1_data['content_meta_index']);
                                    }
                                    for ($a = 0, $x = sizeof($content_1); $a < $x; $a++) {
                                      if ($content_1[$a]!='') {
                                        $file_flag_sql = xtc_db_query("SELECT file_flag_name FROM " . TABLE_CM_FILE_FLAGS . " WHERE file_flag=" . $content_1[$a]['FILE_FLAG']);
                                        $file_flag_result = xtc_db_fetch_array($file_flag_sql);
                                        echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";

                                          if ($content_1[$a]['CONTENT_FILE']=='') $content_1[$a]['CONTENT_FILE']='database';
                                            ?>
                                            <td class="dataTableContent" align="left"><?php echo $content_1[$a]['CONTENT_ID']; ?></td>
                                            <td class="dataTableContent" align="left">--<?php echo $content_1[$a]['CONTENT_TITLE']; ?></td>
                                            <td class="dataTableContent" align="left"><?php echo $content_1[$a]['CONTENT_FILE']; ?></td>
                                            <td class="dataTableContent" align="middle"><?php if ($content_1[$a]['CONTENT_STATUS']==0) { echo TEXT_NO; } else { echo TEXT_YES; } ?></td>
                                            <td class="dataTableContent" align="middle"><?php echo $file_flag_result['file_flag_name']; ?></td>
                                            <td class="dataTableContent" align="right">
                                              <a href="">
                                                <?php
                                                if ($content_1[$a]['CONTENT_DELETE']=='1'){
                                                  ?>
                                                  <a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'special=delete&coID='.$content_1[$a]['CONTENT_ID']); ?>" onclick="return confirm('<?php echo CONFIRM_DELETE; ?>')">
                                                    <?php
                                                    echo xtc_image(DIR_WS_ICONS.'delete.gif', ICON_DELETE,'','','style="cursor:pointer" onclick="return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';
                                                } // if content
                                                ?>
                                                <a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'action=edit&coID='.$content_1[$a]['CONTENT_ID']); ?>">
                                                <?php
                                                echo xtc_image(DIR_WS_ICONS.'icon_edit.gif', ICON_EDIT,'','','style="cursor:pointer"').'  '.TEXT_EDIT.'</a>';
                                                ?>
                                                <a style="cursor:pointer" onclick="javascript:window.open('<?php echo xtc_href_link(FILENAME_CONTENT_PREVIEW,'coID='.$content_1[$a]['CONTENT_ID']); ?>', 'popup', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no, width=640, height=600')">
                                                  <?php
                                                  echo xtc_image(DIR_WS_ICONS.'preview.gif', ICON_PREVIEW,'','','style="cursor:pointer"').'&nbsp;&nbsp;'.TEXT_PREVIEW.'</a>';
                                                ?>
                                            </td>
                                          </tr>
                                          <?php
                                        }
                                      } // for content
                                    } // for language
                                    ?>
                                  </table>
                                </div>
                                  <?php
                          }
                        } else {
                          switch ($action) {
                            // Diplay Editmask
                            case 'new':
                            case 'edit':
                              if ($action != 'new') {
                                $content_query=xtc_db_query("SELECT
                                                                    content_id,
                                                                    categories_id,
                                                                    parent_id,
                                                                    group_ids,
                                                                    languages_id,
                                                                    content_title,
                                                                    content_heading,
                                                                    content_text,
                                                                    sort_order,
                                                                    file_flag,
                                                                    content_file,
                                                                    content_status,
                                                                    content_group,
                                                                    content_delete,
                                                                    content_meta_title,
                                                                    content_meta_description,
                                                                    content_meta_keywords,
                                                                    content_meta_index
                                                               FROM ".TABLE_CONTENT_MANAGER."
                                                              WHERE content_id='".$g_coID."'");
                                $content=xtc_db_fetch_array($content_query);
                              }
                              $languages_array = array();
                              for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                if ($languages[$i]['id']==$content['languages_id']) {
                                  $languages_selected=$languages[$i]['code'];
                                  $languages_id=$languages[$i]['id'];
                                }
                                $languages_array[] = array('id' => $languages[$i]['code'],
                                                         'text' => $languages[$i]['name']);
                              } // for
                              $query_string = '';
                              if (!empty($languages_id)) {
                                $query_string='languages_id='.$languages_id.' AND';
                              }
                              $categories_query=xtc_db_query("SELECT
                                                                     content_id,
                                                                     content_title
                                                                FROM ".TABLE_CONTENT_MANAGER."
                                                               WHERE ".$query_string." parent_id='0'
                                                                 AND content_id!='".$g_coID."'");
                              while ($categories_data=xtc_db_fetch_array($categories_query)) {
                                $categories_array[]=array('id'=>$categories_data['content_id'],
                                                          'text'=>$categories_data['content_title']);
                              }
                              ?>
                              <div class="col-xs-12">
                              <?php
                                if ($action != 'new') {
                                  echo xtc_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit&id=update&coID='.$g_coID,'post','enctype="multipart/form-data"').xtc_draw_hidden_field('coID',$g_coID);
                                } else {
                                  echo xtc_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit&id=insert','post','enctype="multipart/form-data"').xtc_draw_hidden_field('coID',$g_coID);
                                }
                              ?>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12" ><?php echo TEXT_LANGUAGE; ?></div>
                                    <div class="col-sm-10 col-xs-12" ><?php echo xtc_draw_pull_down_menu('language',$languages_array,$languages_selected); ?></div>
                                  </div>
                                  <?php
                                    if ($content['content_delete']!=0 or $action == 'new') {
                                      ?>
                                      <div class="col-xs-12">
                                        <div class="col-sm-2 col-xs-12" ><?php echo TEXT_GROUP; ?></div>
                                        <div class="col-sm-10 col-xs-12" ><?php echo xtc_draw_input_field('content_group',isset($content['content_group'])?$content['content_group']:'','size="5"'); ?><?php echo TEXT_GROUP_DESC; ?></div>
                                      </div>
                                      <?php
                                    } else {
                                      echo xtc_draw_hidden_field('content_group',$content['content_group']);
                                      ?>
                                      <div class="col-xs-12">
                                        <div class="col-sm-2 col-xs-12" ><?php echo TEXT_GROUP; ?></div>
                                        <div class="col-sm-10 col-xs-12" ><?php echo $content['content_group']; ?></div>
                                      </div>
                                      <?php
                                    }
                                    $file_flag_sql = xtc_db_query("SELECT file_flag as id, file_flag_name as text FROM " . TABLE_CM_FILE_FLAGS);
                                    while($file_flag = xtc_db_fetch_array($file_flag_sql)) {
                                      $file_flag_array[] = array('id' => $file_flag['id'], 'text' => $file_flag['text']);
                                    }
                                  ?>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12" ><?php echo TEXT_FILE_FLAG; ?></div>
                                    <div class="col-sm-10 col-xs-12" ><?php echo xtc_draw_pull_down_menu('file_flag',$file_flag_array,$content['file_flag']); ?></div>
                                  </div>
                                  <?php
                                    /*  build in not completed yet
                                    <div class="col-xs-12">
                                      <div class="col-sm-12 col-xs-12" ><?php echo TEXT_PARENT; ?></div>
                                      <div class="col-sm-12 col-xs-12" ><?php echo xtc_draw_pull_down_menu('parent',$categories_array,$content['parent_id']); ?><?php echo xtc_draw_checkbox_field('parent_check', 'yes',false).' '.TEXT_PARENT_DESCRIPTION; ?></div>
                                    </div>
                                    */
                                  ?>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12" ><?php echo TEXT_SORT_ORDER; ?></div>
                                    <div class="col-sm-10 col-xs-12" ><?php echo xtc_draw_input_field('sort_order',isset($content['sort_order'])?$content['sort_order']:'','size="5"'); ?></div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12" valign="top" ><?php echo TEXT_STATUS; ?></div>
                                    <div class="col-sm-10 col-xs-12" >
                                      <?php
                                        if (isset($content['content_status']) && $content['content_status']=='1') {
                                          echo xtc_draw_checkbox_field('status', 'yes',true).' '.TEXT_STATUS_DESCRIPTION;
                                        } else {
                                          echo xtc_draw_checkbox_field('status', 'yes',false).' '.TEXT_STATUS_DESCRIPTION;
                                        }
                                      ?>
                                      <br /><br />
                                    </div>
                                  </div>
                                  <?php
                                    if (GROUP_CHECK=='true') {
                                      $customers_statuses_array = xtc_get_customers_statuses();
                                      $customers_statuses_array=array_merge(array(array('id'=>'all','text'=>TXT_ALL)),$customers_statuses_array);
                                      ?>
                                      <div class="col-xs-12">
                                        <div class="col-sm-2 col-xs-12" valign="top" class="main" ><?php echo ENTRY_CUSTOMERS_STATUS; ?></div>
                                        <div class="col-sm-10 col-xs-12" class="main">
                                          <div style="width: 380px; border: 1px solid; border-right: 1px solid; border-color: #ff0000; background:#FFCC33;">
                                            <?php
                                            for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {
                                              if (strstr($content['group_ids'],'c_'.$customers_statuses_array[$i]['id'].'_group')) {
                                                $checked='checked ';
                                              } else {
                                                $checked='';
                                              }
                                              echo '<input type="checkbox" name="groups[]" value="'.$customers_statuses_array[$i]['id'].'"'.$checked.'> '.$customers_statuses_array[$i]['text'].'<br />';
                                              }
                                            ?>
                                          </div>
                                        </div>
                                      </div>
                                      <?php
                                    }
                                  ?>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12" ><?php echo TEXT_TITLE; ?></div>
                                    <div class="col-sm-10 col-xs-12" ><?php echo xtc_draw_input_field('cont_title',isset($content['content_title'])?$content['content_title']:'','size="60"'); ?></div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12" ><?php echo TEXT_HEADING; ?></div>
                                    <div class="col-sm-10 col-xs-12" ><?php echo xtc_draw_input_field('cont_heading',isset($content['content_heading'])?$content['content_heading']:'','size="60"'); ?></div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12" ><?php echo 'Meta Title'; ?></div>
                                    <div class="col-sm-10 col-xs-12" ><?php echo xtc_draw_input_field('cont_meta_title',isset($content['content_meta_title'])?$content['content_meta_title']:'','size="60"'); ?></div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12" ><?php echo 'Meta Description'; ?></div>
                                    <div class="col-sm-10 col-xs-12" ><?php echo xtc_draw_input_field('cont_meta_description',isset($content['content_meta_description'])?$content['content_meta_description']:'','size="60"'); ?></div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12" ><?php echo 'Meta Keywords'; ?></div>
                                    <div class="col-sm-10 col-xs-12" ><?php echo xtc_draw_input_field('cont_meta_keywords',isset($content['content_meta_keywords'])?$content['content_meta_keywords']:'','size="60"'); ?></div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12" ><?php echo 'Meta Index'; ?></div>
                                    <div class="col-sm-10 col-xs-12" ><?php echo xtc_draw_pull_down_menu('cont_meta_index',array(array('id'=> '0', 'text' => 'Index'), array('id'=> '1', 'text' => 'No Index')), ($content['content_meta_index'] == '1') ? $content['content_meta_index'] : '0'); ?></div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12"  valign="top"><?php echo TEXT_UPLOAD_FILE; ?></div>
                                    <div class="col-sm-10 col-xs-12" ><?php echo xtc_draw_file_field('file_upload').' '.TEXT_UPLOAD_FILE_LOCAL; ?></div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12"  valign="top"><?php echo TEXT_CHOOSE_FILE; ?></div>
                                    <div class="col-sm-10 col-xs-12" >
                                      <?php
                                        if ($dir= opendir(DIR_FS_CATALOG.'media/content/')){
                                          while (($file = readdir($dir)) !== false) {
                                            if (is_file( DIR_FS_CATALOG.'media/content/'.$file) and ($file !="index.html")){
                                              $files[]=array('id' => $file,
                                                           'text' => $file);
                                            }//if
                                          } // while
                                          closedir($dir);
                                          sort($files);// Tomcraft - 2010-06-17 - Sort files for media-content alphabetically in content manager
                                        }
                                        // set default value in dropdown!
                                        if (empty($content['content_file'])) {
                                          $default_array[]=array('id' => 'default','text' => TEXT_SELECT);
                                          $default_value='default';
                                          if (count($files) == 0) {
                                            $files = $default_array;
                                          } else {
                                            $files=array_merge($default_array,$files);
                                          }
                                        } else {
                                          $default_array[]=array('id' => 'default','text' => TEXT_NO_FILE);
                                          $default_value=$content['content_file'];
                                          if (count($files) == 0) {
                                            $files = $default_array;
                                          } else {
                                            $files=array_merge($default_array,$files);
                                          }
                                        }
                                        echo '<br />'.TEXT_CHOOSE_FILE_SERVER.'</br>';
                                        echo xtc_draw_pull_down_menu('select_file',$files,$default_value);
                                        if (!empty($content['content_file'])) {
                                          echo TEXT_CURRENT_FILE.' <b>'.$content['content_file'].'</b><br />';
                                        }
                                      ?>
                                    </div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12"  valign="top"></div>
                                    <div class="col-sm-10 col-xs-12" colspan="90%" valign="top"><br /><?php echo TEXT_FILE_DESCRIPTION; ?></div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-sm-2 col-xs-12"  valign="top"><?php echo TEXT_CONTENT; ?></div>
                                    <div class="col-sm-10 col-xs-12" >
                                      <?php
                                        echo xtc_draw_textarea_field('cont','','100%','35',isset($content['content_text'])?$content['content_text']:'');
                                      ?>
                                    </div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-xs-12" colspan="2" align="right" class="main"><?php echo '<input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_SAVE . '"/>'; ?><a class="btn btn-default" onclick="this.blur();" href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER); ?>"><?php echo BUTTON_BACK; ?></a></div>
                                  </div>
                              </form>
                                          </div>
                              <?php
                              break;
                          }
                        }
                        if (!$action) {
                          ?>
                        <div class="col-xs-12">
                          <a class="btn btn-default" onclick="this.blur();" href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'action=new'); ?>"><?php echo BUTTON_NEW_CONTENT; ?></a>
                        </div>
                          <?php
                        }
                      ?>

    </div>
    
    <!-- body_eof //-->
    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
  </body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
