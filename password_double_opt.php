<?php
/* -----------------------------------------------------------------------------------------
  $Id: password_double_opt.php 3072 2012-06-18 15:01:13Z hhacker $

  modified eCommerce Shopsoftware
  http://www.modified-shop.org

  Copyright (c) 2009 - 2013 [www.modified-shop.org]
  -----------------------------------------------------------------------------------------
  based on:
  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
  (c) 2002-2003 osCommerce www.oscommerce.com
  (c) 2003 nextcommerce www.nextcommerce.org
  (c) 2006 XT-Commerce (password_double_opt.php,v 1.0)

  Released under the GNU General Public License
  ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');

// create smarty elements
$smarty = new SmartyBC;

$request_time = is_numeric(VALID_REQUEST_TIME) ? VALID_REQUEST_TIME : '3600';

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'verify_recaptcha.inc.php');
require_once (DIR_FS_INC.'xtc_random_charcode.inc.php');
require_once (DIR_FS_INC.'xtc_encrypt_password.inc.php');
$case = 'double_opt';
$info_message = TEXT_PASSWORD_FORGOTTEN;

if (isset ($_GET['action']) && ($_GET['action'] == 'first_opt_in') && $_POST) {
  $check_customer_query = xtc_db_query("SELECT customers_email_address, 
                                               customers_id 
                                          FROM ".TABLE_CUSTOMERS." 
                                         WHERE customers_email_address = '".xtc_db_input($_POST['email'])."' 
                                           AND customers_status != ". DEFAULT_CUSTOMERS_STATUS_ID_GUEST);
  $check_customer = xtc_db_fetch_array($check_customer_query);

  $vlcode = xtc_random_charcode(32);
  $link = xtc_href_link(FILENAME_PASSWORD_DOUBLE_OPT, 'action=verified&customers_id='.$check_customer['customers_id'].'&key='.$vlcode, 'NONSSL');

  // assign language to template for caching
  $smarty->assign('language', $_SESSION['language']);
  $smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
  $smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

  // assign vars
  $smarty->assign('EMAIL', $check_customer['customers_email_address']);
  $smarty->assign('LINK', $link);
  // dont allow cache
  $smarty->caching = false;

  // create mails
  $html_mail = $smarty->fetch('db:password_verification_mail.html');
  $txt_mail = $smarty->fetch('db:password_verification_mail.txt');
  $subject = $smarty->fetch('db:password_verification_mail.subject');
  
  if (xtc_db_num_rows($check_customer_query)) {
    if ((trim(INSERT_RECAPTCHA_KEY) != '' && trim(RECAPTCHA_SECRET_KEY) != '') && (!isset($_POST['g-recaptcha-response']) || empty( $_POST['g-recaptcha-response']) || verify_recaptcha($_POST['g-recaptcha-response'], RECAPTCHA_SECRET_KEY) === true)) {
          $case = 'wrong_recaptcha';
          $info_message = TEXT_RECAPTCHA_ERROR; 
    } else {
        $case = 'first_opt_in';
        xtc_db_query("update ".TABLE_CUSTOMERS." set password_request_key = '".$vlcode."' , password_request_time = '".date('Y-m-d H:i:00')."' where customers_id = '".$check_customer['customers_id']."'");
        xtc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $check_customer['customers_email_address'], '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', $subject, $html_mail, $txt_mail);

      }
  } else {
      $case = 'wrong_mail';
      $info_message = TEXT_EMAIL_ERROR; 
    }
}

    // Verification
    if (isset ($_GET['action']) && ($_GET['action'] == 'verified') && isset($_GET['key']) && $_GET['key'] != '') {
      $case = 'second_opt_in';

      $check_customer_query = xtc_db_query("SELECT *
                                              FROM ".TABLE_CUSTOMERS." 
                                             WHERE customers_id = '".(int)$_GET['customers_id']."' AND password_request_key = '".$_GET['key']."' ");

      $check_customer_array = xtc_db_fetch_array($check_customer_query);
      
      if (!xtc_db_num_rows($check_customer_query) || $_GET['key'] == '') {
        $case = 'no_account';
        $info_message = TEXT_NO_ACCOUNT;        
      } elseif (time() > (strtotime($check_customer_array['password_request_time']) + $request_time)) {
        $case = 'double_opt';
        $info_message = TEXT_REQUEST_NOT_VALID;
      } else {  
        $error = false;
            
        $password = xtc_db_prepare_input($_POST['password_new']);
        $password_confirm = xtc_db_prepare_input($_POST['password_confirmation']);
            
        if(!empty($password)) {     

            if ($password != $password_confirm) {
                $error = true;
                $messageStack->add('password_double_opt_in', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
            }

            if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
                $error = true;        
                $messageStack->add('password_double_opt_in', ENTRY_PASSWORD_ERROR);
            }

            if(PASSWORD_SECURITY_CHECK == 'true') {

                $passwordLetter  = preg_match('/[a-zA-Z]/',    $password);
                $passwordDigit   = preg_match('/\d/',          $password);

                if (!$passwordLetter || !$passwordDigit) {
                        $error = true;
                        $messageStack->add('password_double_opt_in', ENTRY_PASSWORD_NOT_COMPILANT);
                }	
            }	

            if ($error == false) {
                  $crypted_password = xtc_encrypt_password($password);          
                  xtc_db_query("UPDATE ".TABLE_CUSTOMERS." set customers_password = '".$crypted_password."' WHERE customers_email_address = '".$check_customer_array['customers_email_address']."' ");
                  xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL')); 
            }           

        }  

      }
    }

$breadcrumb->add(NAVBAR_TITLE_PASSWORD_DOUBLE_OPT, xtc_href_link(FILENAME_PASSWORD_DOUBLE_OPT, '', 'NONSSL'));

require (DIR_WS_INCLUDES.'header.php');

switch ($case) {
  case 'first_opt_in' :
    $smarty->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
    //$smarty->assign('info_message', $info_message); //DokuMan - 2010-08-26 - unnecessary assign
    $smarty->assign('info_message', sprintf(TEXT_LINK_MAIL_SENDED, $request_time));
    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = 0;
    $main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/password_messages.html');
    break;

  case 'second_opt_in':
    if ($messageStack->size('password_double_opt_in') > 0) {
      $smarty->assign('error', $messageStack->output('password_double_opt_in'));
    }
    $smarty->assign('FORM_ACTION', xtc_draw_form('password_double_opt_in', xtc_href_link(FILENAME_PASSWORD_DOUBLE_OPT, xtc_get_all_get_params(), 'SSL'), 'post').xtc_draw_hidden_field('action', 'process'));
    $smarty->assign('INPUT_NEW', xtc_draw_password_fieldNote(array ('name' => 'password_new', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_PASSWORD_NEW_TEXT) ? '<span class="inputRequirement">'.ENTRY_PASSWORD_NEW_TEXT.'</span>' : ''))));
    $smarty->assign('INPUT_CONFIRM', xtc_draw_password_fieldNote(array ('name' => 'password_confirmation', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">'.ENTRY_PASSWORD_CONFIRMATION_TEXT.'</span>' : ''))));
    $smarty->assign('BUTTON_BACK', '<a href="'.xtc_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
    $smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
    $smarty->assign('FORM_END', '</form>');
    
    // dont allow cache
    $smarty->caching = 0;
    $smarty->assign('language', $_SESSION['language']);
    $main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/account_password.html');
    break;

  case 'code_error' :
    $smarty->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
    $smarty->assign('info_message', $info_message);
    $smarty->assign('message', TEXT_PASSWORD_FORGOTTEN);
    $smarty->assign('SHOP_NAME', STORE_NAME);
    $smarty->assign('FORM_ACTION', xtc_draw_form('sign', xtc_href_link(FILENAME_PASSWORD_DOUBLE_OPT, 'action=first_opt_in', 'SSL')));
    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = 0;
    // BOF - DokuMan - 2010-10-28 - added missing arguments for xtc_draw_input_field
    //$smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', xtc_db_input(isset($_POST['email']) ? $_POST['email'] : '')));
    $smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', xtc_db_input(isset($_POST['email']) ? $_POST['email'] : ''), '', 'text', false));
    // EOF - DokuMan - 2010-10-28 - added missing arguments for xtc_draw_input_field
    $smarty->assign('BUTTON_SEND', xtc_image_submit('button_send.gif', IMAGE_BUTTON_LOGIN));
    $smarty->assign('FORM_END', '</form>');
    $main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/password_double_opt_in.html');
    break;

  case 'wrong_mail' :
    $smarty->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
    $smarty->assign('info_message', $info_message);
    $smarty->assign('message', TEXT_PASSWORD_FORGOTTEN);
    $smarty->assign('SHOP_NAME', STORE_NAME);
    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = 0;
    $smarty->assign('FORM_ACTION', xtc_draw_form('sign', xtc_href_link(FILENAME_PASSWORD_DOUBLE_OPT, 'action=first_opt_in', 'SSL')));
    // BOF - DokuMan - 2010-10-28 - added missing arguments for xtc_draw_input_field
    //$smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', xtc_db_input(isset($_POST['email']) ? $_POST['email'] : '')));
    $smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', xtc_db_input(isset($_POST['email']) ? $_POST['email'] : ''), '', 'text', false));
    
    if (trim(INSERT_RECAPTCHA_KEY) != '' && trim(RECAPTCHA_SECRET_KEY) != '') {
        $smarty->assign('RECAPTCHA','<div class="g-recaptcha" data-sitekey="'.INSERT_RECAPTCHA_KEY.'"></div>');
    }
    
    // EOF - DokuMan - 2010-10-28 - added missing arguments for xtc_draw_input_field
    $smarty->assign('BUTTON_SEND', xtc_image_submit('button_send.gif', IMAGE_BUTTON_LOGIN));
    $smarty->assign('FORM_END', '</form>');
    $main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/password_double_opt_in.html');
    break;

  case 'wrong_recaptcha' :
    $smarty->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
    $smarty->assign('info_message', $info_message);
    $smarty->assign('message', TEXT_PASSWORD_FORGOTTEN);
    $smarty->assign('SHOP_NAME', STORE_NAME);
    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = 0;
    $smarty->assign('FORM_ACTION', xtc_draw_form('sign', xtc_href_link(FILENAME_PASSWORD_DOUBLE_OPT, 'action=first_opt_in', 'SSL')));
    // BOF - DokuMan - 2010-10-28 - added missing arguments for xtc_draw_input_field
    //$smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', xtc_db_input(isset($_POST['email']) ? $_POST['email'] : '')));
    $smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', xtc_db_input(isset($_POST['email']) ? $_POST['email'] : ''), '', 'text', false));
    
    if (trim(INSERT_RECAPTCHA_KEY) != '' && trim(RECAPTCHA_SECRET_KEY) != '') {
        $smarty->assign('RECAPTCHA','<div class="g-recaptcha" data-sitekey="'.trim(INSERT_RECAPTCHA_KEY).'"></div>');
    }
    
    // EOF - DokuMan - 2010-10-28 - added missing arguments for xtc_draw_input_field
    $smarty->assign('BUTTON_SEND', xtc_image_submit('button_send.gif', IMAGE_BUTTON_LOGIN));
    $smarty->assign('FORM_END', '</form>');
    $main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/password_double_opt_in.html');
    break;

  case 'no_account' :
    $smarty->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
    $smarty->assign('info_message', $info_message);
    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = 0;
    $main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/password_messages.html');
    break;

  case 'double_opt' :
    $smarty->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
    //$smarty->assign('info_message', $info_message);
    $smarty->assign('message', TEXT_PASSWORD_FORGOTTEN);
    $smarty->assign('SHOP_NAME', STORE_NAME);
    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = 0;
    $smarty->assign('FORM_ACTION', xtc_draw_form('sign', xtc_href_link(FILENAME_PASSWORD_DOUBLE_OPT, 'action=first_opt_in', 'SSL'), 'post'));
    // BOF - DokuMan - 2010-10-28 - added missing arguments for xtc_draw_input_field
    //$smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', xtc_db_input(isset($_POST['email']) ? $_POST['email'] : '')));
    $smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', xtc_db_input(isset($_POST['email']) ? $_POST['email'] : ''), '', 'text', false));
    
    if (trim(INSERT_RECAPTCHA_KEY) != '' && trim(RECAPTCHA_SECRET_KEY) != '') {
        $smarty->assign('RECAPTCHA','<div class="g-recaptcha" data-sitekey="'.trim(INSERT_RECAPTCHA_KEY).'"></div>');
    }
    
    // EOF - DokuMan - 2010-10-28 - added missing arguments for xtc_draw_input_field
    $smarty->assign('BUTTON_SEND', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
    $smarty->assign('FORM_END', '</form>');
    $main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/password_double_opt_in.html');
    break;
}

$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined('RM'))
  /*$smarty->load_filter('output', 'note')*/;
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>
