<?php

/*------------------------------------------------------------------------------
   $Id: newsletter.php,v 1.0 

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce www.oscommerce.com 
   (c) 2003	 nextcommerce www.nextcommerce.org
   
   XTC-NEWSLETTER_RECIPIENTS RC1 - Contribution for XT-Commerce http://www.xt-commerce.com
   by Matthias Hinsche http://www.gamesempire.de
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');

// create smarty elements
$smarty = new SmartyBC;

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'verify_recaptcha.inc.php');
require_once (DIR_FS_INC.'xtc_random_charcode.inc.php');
require_once (DIR_FS_INC.'xtc_encrypt_password.inc.php');
require_once (DIR_FS_INC.'xtc_validate_password.inc.php');
require_once (DIR_FS_INC.'xtc_validate_email.inc.php');

$inp = 'true';
$del = '';
$info_message = '';
$success_message = '';

if (isset ($_GET['action']) && ($_GET['action'] == 'process')) {    
	
	$vlcode = xtc_random_charcode(32);
	$link = xtc_href_link(FILENAME_NEWSLETTER, 'action=activate&email='.xtc_db_input($_POST['email']).'&key='.$vlcode, 'SSL'); // web28 - 2010-09-21 - change NONSSL -> SSL 

	// assign language to template for caching
	$smarty->assign('language', $_SESSION['language']);
	$smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	$smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

	// assign vars
	$smarty->assign('EMAIL', xtc_db_input($_POST['email']));
	$smarty->assign('LINK', $link);
	// dont allow cache
	$smarty->caching = false;

	// create mails
	$html_mail = $smarty->fetch('db:newsletter_mail.html');
	$txt_mail = $smarty->fetch('db:newsletter_mail.txt');
        $subject = $smarty->fetch('db:newsletter_mail.subject');

	// Check if email exists 
  //BOF - web28 - 2010-02-09: NEWSLETTER ERROR HANDLING
	if (xtc_validate_email(trim($_POST['email'])) && (isset($_POST['add'])) && empty($_POST['contact_data']) && (bool) $_POST['contact_data'] === FALSE) {
  //BOF - web28 - 2010-02-09: NEWSLETTER ERROR HANDLING

		$check_mail_query = xtc_db_query("select customers_email_address, mail_status from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address = '".xtc_db_input($_POST['email'])."'");
		if (!xtc_db_num_rows($check_mail_query)) {

			if (isset ($_SESSION['customer_id'])) {
				$customers_id = $_SESSION['customer_id'];
				$customers_status = $_SESSION['customers_status']['customers_status_id'];
				$customers_firstname = $_SESSION['customer_first_name'];
				$customers_lastname = $_SESSION['customer_last_name'];
			} else {

				$check_customer_mail_query = xtc_db_query("select customers_id, customers_status, customers_firstname, customers_lastname, customers_email_address from ".TABLE_CUSTOMERS." where customers_email_address = '".xtc_db_input($_POST['email'])."'");
				if (!xtc_db_num_rows($check_customer_mail_query)) {
					$customers_id = '0';
					$customers_status = '1';
					$customers_firstname = TEXT_CUSTOMER_GUEST;
					$customers_lastname = '';
				} else {
					$check_customer = xtc_db_fetch_array($check_customer_mail_query);
					$customers_id = $check_customer['customers_id'];
					$customers_status = $check_customer['customers_status'];
					$customers_firstname = $check_customer['customers_firstname'];
					$customers_lastname = $check_customer['customers_lastname'];
				}

			}

			$sql_data_array = array ('customers_email_address' => xtc_db_input($_POST['email']), 'customers_id' => xtc_db_input($customers_id), 'customers_status' => xtc_db_input($customers_status), 'customers_firstname' => xtc_db_input($customers_firstname), 'customers_lastname' => xtc_db_input($customers_lastname), 'mail_status' => '0', 'mail_key' => xtc_db_input($vlcode), 'date_added' => 'now()');
			xtc_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);

                        if (trim(INSERT_RECAPTCHA_KEY) != '' && trim(RECAPTCHA_SECRET_KEY) != '') {                         
                            if (isset($_POST['g-recaptcha-response']) && !empty( $_POST['g-recaptcha-response']) && verify_recaptcha($_POST['g-recaptcha-response'], RECAPTCHA_SECRET_KEY) === false) {
                                $success_message = TEXT_EMAIL_INPUT;
                                
                                if (SEND_EMAILS == true) {
                                    xtc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, xtc_db_input($_POST['email']), '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', $subject, $html_mail, $txt_mail);
                                }
                            
                            } else {
                                $info_message .= TEXT_LOGIN_ERROR_NO_CAPTCHA."<br />";
                            }        
                        } else {
                            $success_message = TEXT_EMAIL_INPUT;
                            if (SEND_EMAILS == true) {
                                xtc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, xtc_db_input($_POST['email']), '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', $subject, $html_mail, $txt_mail);
                            }  
                        }

		} else {
                    $check_mail = xtc_db_fetch_array($check_mail_query);
                    
                    if ($check_mail['mail_status'] == '0') {
                        
                        xtc_db_query("UPDATE ".TABLE_NEWSLETTER_RECIPIENTS." SET mail_key = '".xtc_db_input($vlcode)."' WHERE customers_email_address='".$_POST['email']."'");

                        if (trim(INSERT_RECAPTCHA_KEY) != '' && trim(RECAPTCHA_SECRET_KEY) != '') {
                            if (isset($_POST['g-recaptcha-response']) && !empty( $_POST['g-recaptcha-response']) && verify_recaptcha($_POST['g-recaptcha-response'], RECAPTCHA_SECRET_KEY) === false) {
                                $info_message = TEXT_EMAIL_EXIST_NO_NEWSLETTER;
                                
                                if (SEND_EMAILS == true) {
                                    xtc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, xtc_db_input($_POST['email']), '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', $subject, $html_mail, $txt_mail);
                                }
                            } else {
                                $info_message .= TEXT_LOGIN_ERROR_NO_CAPTCHA."<br />";
                            }
                        } else {
                            $info_message = TEXT_EMAIL_EXIST_NO_NEWSLETTER;
                            if (SEND_EMAILS == true) {
                                xtc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, xtc_db_input($_POST['email']), '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', $subject, $html_mail, $txt_mail);
                            }
                        }

                    } else {
                        if (trim(INSERT_RECAPTCHA_KEY) != '' && trim(RECAPTCHA_SECRET_KEY) != '') {
                            if (isset($_POST['g-recaptcha-response']) && !empty( $_POST['g-recaptcha-response']) && verify_recaptcha($_POST['g-recaptcha-response'], RECAPTCHA_SECRET_KEY) === false) {
                                $info_message = TEXT_EMAIL_EXIST_NEWSLETTER;
                            } else {
                                $info_message .= TEXT_LOGIN_ERROR_NO_CAPTCHA."<br />";
                            }
                        } else {
                            $info_message = TEXT_EMAIL_EXIST_NEWSLETTER;
                        }
                    }
                }

	} else {
	    //BOF - web28 - 2010-02-09: NEWSLETTER ERROR HANDLING
	    //$info_message = TEXT_WRONG_CODE;
	    if (!xtc_validate_email(trim($_POST['email']))) $info_message .= ERROR_EMAIL;
		//EOF - web28 - 2010-02-09: NEWSLETTER ERROR HANDLING
            if (!empty($_POST['contact_data']) && (bool) $_POST['contact_data'] === TRUE) $err_msg .= ERROR_HONEYPOT;
	}

  //BOF - web28 - 2010-02-09: NEWSLETTER ERROR HANDLING
	if (xtc_validate_email(trim($_POST['email'])) && (isset($_POST['delete'])) && empty($_POST['contact_data']) && (bool) $_POST['contact_data'] === FALSE) {
  //EOF - web28 - 2010-02-09: NEWSLETTER ERROR HANDLING

            $check_mail_query = xtc_db_query("select customers_email_address from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address = '".xtc_db_input($_POST['email'])."'");
            if (!xtc_db_num_rows($check_mail_query)) {
                 if (trim(INSERT_RECAPTCHA_KEY) != '' && trim(RECAPTCHA_SECRET_KEY) != '') {
                    if (isset($_POST['g-recaptcha-response']) && !empty( $_POST['g-recaptcha-response']) && verify_recaptcha($_POST['g-recaptcha-response'], RECAPTCHA_SECRET_KEY) === false) {
                        $info_message = TEXT_EMAIL_NOT_EXIST;
                    } else {
                        $info_message .= TEXT_LOGIN_ERROR_NO_CAPTCHA."<br />";
                    }
                } else {
                    $info_message = TEXT_EMAIL_NOT_EXIST;
                }

            } else {                
                if (trim(INSERT_RECAPTCHA_KEY) != '' && trim(RECAPTCHA_SECRET_KEY) != '') {
                    if (isset($_POST['g-recaptcha-response']) && !empty( $_POST['g-recaptcha-response']) && verify_recaptcha($_POST['g-recaptcha-response'], RECAPTCHA_SECRET_KEY) === false) {
                        $del_query = xtc_db_query("delete from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address ='".xtc_db_input($_POST['email'])."'");
                        $success_message = TEXT_EMAIL_DEL;
                    } else {
                        $info_message .= TEXT_LOGIN_ERROR_NO_CAPTCHA."<br />";
                    }
                } else {
                    $del_query = xtc_db_query("delete from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address ='".xtc_db_input($_POST['email'])."'");
                    $success_message = TEXT_EMAIL_DEL;
                }
            }	
	}	
}

// Accountaktivierung per Emaillink
if (isset ($_GET['action']) && ($_GET['action'] == 'activate')) {
	$check_mail_query = xtc_db_query("select mail_key from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address = '".xtc_db_input($_GET['email'])."'");
	if (!xtc_db_num_rows($check_mail_query)) {
		$info_message = TEXT_EMAIL_NOT_EXIST;
	} else {	    
		$check_mail = xtc_db_fetch_array($check_mail_query);
		//BOF - web28 - 2009-02-09 : FIX WRONG ACTIVATE HANDLING
		//if (!$check_mail['mail_key'] == $_GET['key']) {
		if ($check_mail['mail_key'] != $_GET['key']) {
		//EOF - web28 - 2009-02-09 : FIX WRONG ACTIVATE HANDLING
			$info_message = TEXT_EMAIL_ACTIVE_ERROR;
		} else {
			xtc_db_query("update ".TABLE_NEWSLETTER_RECIPIENTS." set mail_status = '1' where customers_email_address = '".xtc_db_input($_GET['email'])."'");
			
			$success_message = TEXT_EMAIL_ACTIVE;
		}
	}
}

// Accountdeaktivierung per Emaillink
if (isset ($_GET['action']) && ($_GET['action'] == 'remove')) {
	$check_mail_query = xtc_db_query("select customers_email_address,
                                           mail_key
                                    from ".TABLE_NEWSLETTER_RECIPIENTS."
                                    where customers_email_address = '".xtc_db_input($_GET['email'])."' 
                                    and mail_key = '".xtc_db_input($_GET['key'])."'");
	if (!xtc_db_num_rows($check_mail_query)) {
		$info_message = TEXT_EMAIL_NOT_EXIST;
	} else {
		$check_mail = xtc_db_fetch_array($check_mail_query);
		//BOF - web28 - 2009-02-09 : FIX WRONG DEACTIVATE HANDLING
		//if (!xtc_validate_password($check_mail['customers_email_address'], $_GET['key'])) {
		if ($check_mail['mail_key'] != $_GET['key']) {
		//EOF - web28 - 2009-02-09 : FIX WRONG DEACTIVATE HANDLING
			$info_message = TEXT_EMAIL_DEL_ERROR;
		} else {
			$del_query = xtc_db_query("delete from ".TABLE_NEWSLETTER_RECIPIENTS." where  customers_email_address ='".xtc_db_input($_GET['email'])."' and mail_key = '".xtc_db_input($_GET['key'])."'");
			
			$success_message = TEXT_EMAIL_DEL;
		}
	}
}

$breadcrumb->add(NAVBAR_TITLE_NEWSLETTER, xtc_href_link(FILENAME_NEWSLETTER, '', 'SSL')); // web28 - 2010-09-21 - change NONSSL -> SSL 

require (DIR_WS_INCLUDES.'header.php');

$smarty->assign('text_newsletter', TEXT_NEWSLETTER);
$smarty->assign('info_message', $info_message);
$smarty->assign('success_message', $success_message);
$smarty->assign('FORM_ACTION', xtc_draw_form('sign', xtc_href_link(FILENAME_NEWSLETTER, 'action=process', 'SSL'))); // web28 - 2010-09-21 - change NONSSL -> SSL 
//BOF - web28 - 2010-02-09: SHOW EMAIL  IN INPUT FIELD
//$smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', xtc_db_input($_POST['email'])));
$smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', ((isset($_GET['email']) && xtc_db_input($_GET['email'])!='') ? xtc_db_input($_GET['email']):((isset($_POST['email']) && xtc_db_input($_POST['email']))?xtc_db_input($_POST['email']):''))));
//EOF - web28 - 2010-02-09: SHOW EMAIL IN INPUT FIELD
//BOF - web28 - 2010-02-09: NEWSLETTER ERROR HANDLING

// captcha
if (trim(INSERT_RECAPTCHA_KEY) != '' && trim(RECAPTCHA_SECRET_KEY) != '') {
    $smarty->assign('RECAPTCHA','<div class="g-recaptcha" data-sitekey="'. trim(INSERT_RECAPTCHA_KEY).'"></div>');
}

$smarty->assign('HONEY_TRAP',xtc_draw_checkbox_field('contact_data','1',false,'style="display:none !important" tabindex="-1" autocomplete="off"'));

if(isset($_POST['check']) && $_POST['add'] == '') {$inp = 'true'; $del = '';}
if(isset($_POST['check']) && $_POST['delete'] == '') {$inp = ''; $del = 'true';}	
#$smarty->assign('CHECK_INP', xtc_draw_radio_field('check', 'inp', $inp));
//EOF - web28 - 2010-02-09: NEWSLETTER ERROR HANDLING
#$smarty->assign('CHECK_DEL', xtc_draw_radio_field('check', 'del', $del));

//privacy link
$shop_content_data = $main->getContentData(2);
$smarty->assign('PRIVACY_LINK', $main->getContentLink(2, $shop_content_data['content_title'],'SSL'));

$smarty->assign('BUTTON_SEND', xtc_image_submit('button_send.gif', IMAGE_BUTTON_LOGIN_NEWSLETTER, "name=add"));
$smarty->assign('BUTTON_UNSUB', xtc_image_submit('button_delete.gif', IMAGE_BUTTON_UNSUBSCRIBE_NEWSLETTER, "name=delete"));
$smarty->assign('FORM_END', '</form>');

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/newsletter.html');
$smarty->assign('main_content', $main_content);
$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
if (!defined('RM'))
	/*$smarty->load_filter('output', 'note')*/;
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>
