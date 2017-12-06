<?php
  /* --------------------------------------------------------------
   $Id: email_manager.php 4143 2012-12-18 14:55:48Z Tomcraft1980 $

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
  // Removed email_manager wysiwyg editor because of the conflicts with Smarty template engine
  //require_once(DIR_FS_INC . 'xtc_wysiwyg.inc.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $special = (isset($_GET['special']) ? $_GET['special'] : '');
  $id = (isset($_GET['id']) ? $_GET['id'] : '');
  $g_coID = (isset($_GET['coID']) ? (int)$_GET['coID'] : '');
  $languages = xtc_get_languages();

  if ($special=='delete') {
    xtc_db_query("UPDATE ".TABLE_EMAILS_MANAGER." set em_delete = '1' where em_id='".$g_coID."'");
    #xtc_db_query("DELETE FROM ".TABLE_EMAILS_MANAGER." where em_id='".$g_coID."'");
    xtc_redirect(xtc_href_link(FILENAME_EMAIL_MANAGER));
  } // if get special
####
  
$path = DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/mail';
$all_email_html_templates = glob($path.'/*/*.*');
#Check for email template files
$email_temlates_query=xtc_db_query("SELECT em_id ,em_name FROM ".TABLE_EMAILS_MANAGER."");
$names_array = array() ;
while ($email_temlate=xtc_db_fetch_array($email_temlates_query)) {
    $names_array[] = $email_temlate['em_name'];
}

foreach($all_email_html_templates as $email_template_path){
    $path_details = pathinfo($email_template_path);
    if($path_details['extension'] == 'html'){
        $full_path = $email_template_path;
        $txt_path = str_replace('.html', '.txt', $email_template_path);
        $email_template_path = str_replace($path, '', $email_template_path);
        $email_template_path = str_replace('.html', '', $email_template_path);
        foreach($languages as $language){
            if(strpos($email_template_path,'/'.$language['directory'].'/') === 0){
                $file_name = str_replace('/'.$language['directory'].'/', '', $email_template_path);
                if(!in_array($file_name, $names_array)){
                    $txt_email="";
                    if(in_array($txt_path, $all_email_html_templates)){
                        $txt_email = file_get_contents($txt_path);
                    }
                    $insert_data = array('em_name' => $file_name,
                                         'em_language' => $language['id'], 
                                         'em_body' => file_get_contents($full_path), 
                                         'em_type' => 'mail',
                                         'em_body_txt' => $txt_email);
                    xtc_db_perform(TABLE_EMAILS_MANAGER, $insert_data);
                    echo "New template added: ".$email_template_path;
                }
            }
        }
    }
}

####
  if ($id=='update' or $id=='insert') {

    $content_title=xtc_db_prepare_input($_POST['cont_title']);
    $content_type=xtc_db_prepare_input($_POST['cont_type']);
    $content_subject = xtc_db_prepare_input($_POST['cont_subject']);
    $content_html=xtc_db_prepare_input($_POST['cont']);
    $content_text=xtc_db_prepare_input($_POST['cont_txt']);
    $coID=xtc_db_prepare_input($_POST['coID']);
    $content_language=xtc_db_prepare_input($_POST['language']);

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

   if ($error == false) {
      // update data in table
      $sql_data_array = array(
                            'em_name' => $content_title,
                            'em_language' => $content_language,
                            'em_body' => $content_html,
                            'em_subject' => $content_subject,
                            'em_body_txt' => $content_text,
                            'em_type' => $content_type);
      if ($id=='update') {
        xtc_db_perform(TABLE_EMAILS_MANAGER, $sql_data_array, 'update', "em_id = '" . $coID . "'");
      } else {
        xtc_db_perform(TABLE_EMAILS_MANAGER, $sql_data_array);
      } // if get id
      xtc_redirect(xtc_href_link(FILENAME_EMAIL_MANAGER));
    } // if error
  } // if


require (DIR_WS_INCLUDES.'head.php');

?>
</head>
<body>
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php');?>
    <!-- header_eof //-->
    <!-- body //-->
    <div class="row">
            <div class='col-xs-12'>
        <p class="h2">
            <?php echo HEADING_TITLE; ?>
        </p>
    </div>
<div class='col-xs-12'><br></div>

<div class='col-xs-12'>
                      <?php
                        if (!$action) {
                          // Display Content
                          for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                            $content=array();
                            $content_query=xtc_db_query("SELECT
                                                                em_id,
                                                                em_name,
                                                                em_type,
                                                                em_delete
                                                           FROM ".TABLE_EMAILS_MANAGER."
                                                          WHERE em_language='".$languages[$i]['id']."'
                                                            AND em_delete = '0'
                                                       ORDER BY em_name
                                                         ");
                            while ($content_data=xtc_db_fetch_array($content_query)) {
                              $content[]=array(
                                               'CONTENT_ID' =>$content_data['em_id'] ,
                                               'EMAIL_TITLE' => $content_data['em_name'],
                                               'EMAIL_TYPE' => $content_data['em_type'],
                                               'EMAIL_DELETED' => $content_data['em_delete']);
                            } // while content_data
                            ?>
    <br>
                            <div class="main"><?php echo xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']).'&nbsp;&nbsp;'.$languages[$i]['name']; ?></div>
                            <table class="table">
                              <tr>
                                <th><?php echo TABLE_HEADING_CONTENT_ID; ?></th>
                                <th width="30%" align="left"><?php echo TABLE_HEADING_CONTENT_TITLE; ?></th>
                                <th class='hidden-xs' width="30%" align="middle"><?php echo TABLE_HEADING_CONTENT_TYPE; ?></th>
                                <!--<th width="15%" align="middle"><?php echo TABLE_HEADING_CONTENT_AVALIABLE; ?></th>-->
                                <th width="30%" align="middle"><?php echo TABLE_HEADING_CONTENT_ACTION; ?>&nbsp;</th>
                              </tr>
                              <?php
                              for ($ii = 0, $nn = sizeof($content); $ii < $nn; $ii++) {
                                    ?>
                                <tr>
                                    <td class="dataTableContent" align="left"><?php echo $content[$ii]['CONTENT_ID']; ?></td>
                                    <td class="dataTableContent" align="middle"><?php echo $content[$ii]['EMAIL_TITLE']; ?></td>
                                    <td class="dataTableContent hidden-xs" align="middle"><?php echo $content[$ii]['EMAIL_TYPE']; ?></td>
                                    <!--<td class="dataTableContent" align="middle"><?php #if ($content[$ii]['EMAIL_DELETED']==1) { echo TEXT_NO; } else { echo TEXT_YES; } ?></td>-->
                                    <td class="dataTableContent" align="right">
                                      <a href="">
                                        <?php
                                        if ($content[$ii]['EMAIL_DELETED']=='0'){
                                          ?>
                                          <a href="<?php echo xtc_href_link(FILENAME_EMAIL_MANAGER,'special=delete&coID='.$content[$ii]['CONTENT_ID']); ?>" onclick="return confirm('<?php echo CONFIRM_DELETE; ?>')">
                                            <?php
                                            echo '<span class="glyphicon glyphicon-trash" onclick="return confirm(\''.DELETE_ENTRY.'\')"></span>'.'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';
                                        } // if content
                                        ?>
                                        <a href="<?php echo xtc_href_link(FILENAME_EMAIL_MANAGER,'action=edit&coID='.$content[$ii]['CONTENT_ID']); ?>">
                                          <?php
                                          echo '<span class="glyphicon glyphicon-pencil"></span>'.'  '.TEXT_EDIT.'</a>';
                                        ?>
                                        <a class='hidden-xs hidden-sm' style="cursor:pointer" onclick="javascript:window.open('<?php echo xtc_href_link(FILENAME_EMAIL_PREVIEW,'coID='.$content[$ii]['CONTENT_ID']); ?>', 'popup', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no, width=640, height=600')">
                                          <?php
                                          echo '<span class="glyphicon glyphicon-eye-open"></span>'.'&nbsp;&nbsp;'.TEXT_PREVIEW.'</a>';
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </table>
                                  <?php
                          }
                        } else {
                          switch ($action) {
                            // Diplay Editmask
                            case 'new':
                            case 'edit':
                              if ($action != 'new') {
                                $content_query=xtc_db_query("SELECT *
                                                               FROM ".TABLE_EMAILS_MANAGER."
                                                              WHERE em_id='".$g_coID."'");
                                $content=xtc_db_fetch_array($content_query);
                              }
                              $languages_array = array();
                              for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                if ($languages[$i]['id']==$content['em_language']) {
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
                              ?>
                              <br /><br />
                              <?php
                                if($content['em_name'] == 'change_order_mail' || $content['em_name'] == 'order_mail'){
                                    echo '<div class="col-sm-12" style="margin-bottom: 15px;">'.TEXT_USEABLE_VARIABLES_1.'</div>';
                                }
                                if($content['em_name'] == 'invoice_mail'){
                                    echo '<div class="col-sm-12" style="margin-bottom: 15px;">'.TEXT_USEABLE_VARIABLES_2.'</div>';
                                }
                                if ($action != 'new') {
                                  echo xtc_draw_form('edit_content',FILENAME_EMAIL_MANAGER,'action=edit&id=update&coID='.$g_coID,'post','enctype="multipart/form-data"').xtc_draw_hidden_field('coID',$g_coID);
                                } else {
                                  echo xtc_draw_form('edit_content',FILENAME_EMAIL_MANAGER,'action=edit&id=insert','post','enctype="multipart/form-data"').xtc_draw_hidden_field('coID',$g_coID);
                                }
                              ?>
                                  <div class="col-xs-12">
                                    <div class="col-xs-12 col-sm-2"><?php echo TEXT_LANGUAGE; ?></div>
                                    <div class="col-xs-12 col-sm-10"><?php echo xtc_draw_pull_down_menu('language',$languages_array,$languages_selected); ?></div>
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-xs-12 col-sm-2"><?php echo TEXT_TITLE; ?></div>
                                    <?php 
                                    if ($action != 'new') { 
                                      $readonly = 'readonly';
                                    }else{
                                        $readonly = '';
                                    }
                                    ?>
                                    <div class="col-xs-12 col-sm-10"><?php echo xtc_draw_input_field('cont_title',isset($content['em_name'])?$content['em_name']:'','size="60"'.$readonly); ?></div>
                                    
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="col-xs-12 col-sm-2"><?php echo TEXT_TYPE; ?></div>
                                    <div class="col-xs-12 col-sm-10"><?php echo xtc_draw_input_field('cont_type',isset($content['em_type'])?$content['em_type']:'','size="60"'); ?></div>
                                <?php if ($content['em_name'] != 'sepa_info' && $content['em_name'] != 'signatur'){?>
                                    <div class="col-xs-12 col-sm-2"><?php echo TEXT_SUBJECT; ?></div>
                                    <div class="col-xs-12 col-sm-10"><?php echo xtc_draw_input_field('cont_subject',isset($content['em_subject']) && !empty($content['em_subject']) ? $content['em_subject'] : '','size="60"'); ?></div>
                                <?php } ?>
                                    <div class="col-xs-12 col-sm-2"  ><?php echo TEXT_CONTENT; ?></div>
                                    <div class="col-xs-12 col-sm-10">
                                      <?php
                                        echo xtc_draw_textarea_field('cont','','100%','35',isset($content['em_body'])?$content['em_body']:'');
                                      ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-2"  ><?php echo TEXT_CONTENT_TXT; ?></div>
                                    <div class="col-xs-12 col-sm-10">
                                      <?php
                                        echo xtc_draw_textarea_field('cont_txt','','100%','10',isset($content['em_body_txt'])?$content['em_body_txt']:'');
                                      ?>
                                    </div>
                                  <div class="col-xs-12 buttons-space">
                                    <?php echo '<input type="submit" class="btn btn-default" onclick="this.blur();" value="' . BUTTON_SAVE . '"/>'; ?><a class="btn btn-default" onclick="this.blur();" href="<?php echo xtc_href_link(FILENAME_EMAIL_MANAGER); ?>"><?php echo BUTTON_BACK; ?></a>
                                  </div>
                              </form>
                              <?php
                              break;
                          }
                        }
                        if (!$action) {
                          ?>
                          <br/>
                          <a class="btn btn-default" onclick="this.blur();" href="<?php echo xtc_href_link(FILENAME_EMAIL_MANAGER,'action=new'); ?>"><?php echo BUTTON_NEW_CONTENT; ?></a>
                          <?php
                        }
                      ?>
        </div>
    </div>
    <!-- body_eof //-->
    <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
    <?php
    // Removed email_manager wysiwyg editor because of the conflicts with Smarty template engine
    /*  
      if (USE_WYSIWYG=='true') {
        $query=xtc_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
        $data=xtc_db_fetch_array($query);
        if ($action != 'new_products_content' && $action != '')
          echo xtc_wysiwyg('email_manager',$data['code']);
      }
      */
    ?>
  </body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
