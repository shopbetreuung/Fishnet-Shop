<?php
/* --------------------------------------------------------------
   $Id: mail.php 4255 2013-01-11 16:04:14Z web28 $   

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(mail.php,v 1.30 2002/03/16 01:07:28); www.oscommerce.com 
   (c) 2003	 nextcommerce (mail.php,v 1.11 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'class.phpmailer.php');
  require_once(DIR_FS_INC . 'xtc_php_mail.inc.php');
  require_once(DIR_FS_INC . 'xtc_wysiwyg.inc.php'); 

  if ( ($_GET['action'] == 'send_email_to_user') && ($_POST['customers_email_address']) && (!$_POST['back_x']) ) {
    switch ($_POST['customers_email_address']) {
      case '***':
        $mail_query = xtc_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS);
        $mail_sent_to = TEXT_ALL_CUSTOMERS;
        break;

      case '**D':
        $mail_query = xtc_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_newsletter = '1'");
        $mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
        break;

      default:
        if (is_numeric($_POST['customers_email_address'])) {
          $mail_query = xtc_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_status = " . $_POST['customers_email_address']);
          $sent_to_query = xtc_db_query("select customers_status_name from " . TABLE_CUSTOMERS_STATUS . " WHERE customers_status_id = '" . $_POST['customers_email_address'] . "' AND language_id='" . $_SESSION['languages_id'] . "'");
          $sent_to = xtc_db_fetch_array($sent_to_query);
          $mail_sent_to = $sent_to['customers_status_name'];
        } else {
          $customers_email_address = xtc_db_prepare_input($_POST['customers_email_address']);
          $mail_query = xtc_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_email_address = '" . xtc_db_input($customers_email_address) . "'");
          $mail_sent_to = $_POST['customers_email_address'];
        }
        break;
    }

    $from = xtc_db_prepare_input($_POST['from']);
    $subject = xtc_db_prepare_input($_POST['subject']);
    $message = xtc_db_prepare_input($_POST['message']);


    while ($mail = xtc_db_fetch_array($mail_query)) {

      xtc_php_mail(EMAIL_SUPPORT_ADDRESS,
               EMAIL_SUPPORT_NAME,
               $mail['customers_email_address'] ,
               $mail['customers_firstname'] . ' ' . $mail['customers_lastname'] ,
               '',
               EMAIL_SUPPORT_REPLY_ADDRESS,
               EMAIL_SUPPORT_REPLY_ADDRESS_NAME,
                '',
                '',
                $subject,
                $message,
                $message);
    }



    xtc_redirect(xtc_href_link(FILENAME_MAIL, 'mail_sent_to=' . urlencode($mail_sent_to)));
  }

  if ( ($_GET['action'] == 'preview') && (!$_POST['customers_email_address']) ) {
    $messageStack->add(ERROR_NO_CUSTOMER_SELECTED, 'error');
  }

  if ($_GET['mail_sent_to']) {
    $messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $_GET['mail_sent_to']), 'notice');
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<?php
require (DIR_WS_INCLUDES.'head.php');
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<div class="row">
<!-- body_text //-->
    <div class='col-xs-12'>
        <p class="h2">
            <?php echo HEADING_TITLE; ?>
        </p>
        Configuration
    </div>
<div class='col-xs-12'><br></div>
<?php
  if ( ($_GET['action'] == 'preview') && ($_POST['customers_email_address']) ) {
    switch ($_POST['customers_email_address']) {
      case '***':
        $mail_sent_to = TEXT_ALL_CUSTOMERS;
        break;

      case '**D':
        $mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
        break;

      default:
        if (is_numeric($_POST['customers_email_address'])) {
          echo "hier bin ich";
          $sent_to_query = xtc_db_query("select customers_status_name from " . TABLE_CUSTOMERS_STATUS . " WHERE customers_status_id = '" . $_POST['customers_email_address'] . "' AND language_id='" . $_SESSION['languages_id'] . "'");
          $sent_to = xtc_db_fetch_array($sent_to_query);
          $mail_sent_to = $sent_to['customers_status_name'];
        } else {
          $mail_sent_to = $_POST['customers_email_address'];
        }
        break;
    }
?>
          <?php echo xtc_draw_form('mail', FILENAME_MAIL, 'action=send_email_to_user'); ?>
             <div  class="col-xs-12">
              <div  class="col-xs-12">
                <br>
              </div>
              <div  class="col-xs-12">
                <div  class="smallText col-xs-12 col-sm-12"><b><?php echo TEXT_CUSTOMER; ?></b><br /><?php echo $mail_sent_to; ?></div>
              </div>
              <div  class="col-xs-12">
                <br>
              </div>
              <div  class="col-xs-12">
                <div  class="smallText col-xs-12 col-sm-12"><b><?php echo TEXT_FROM; ?></b><br /><?php echo encode_htmlspecialchars(stripslashes($_POST['from'])); ?></div>
              </div>
              <div  class="col-xs-12">
                <br>
              </div>
              <div  class="col-xs-12">
                <div  class="smallText col-xs-12 col-sm-12"><b><?php echo TEXT_SUBJECT; ?></b><br /><?php echo encode_htmlspecialchars(stripslashes($_POST['subject'])); ?></div>
              </div>
              <div  class="col-xs-12">
                <br>
              </div>
              <div  class="col-xs-12">
                <div  class="smallText col-xs-12 col-sm-12"><b><?php echo TEXT_MESSAGE; ?></b><br /><?php echo nl2br(encode_htmlspecialchars(stripslashes($_POST['message']))); ?></div>
              </div>
              <div  class="col-xs-12">
                <br>
              </div><?php
    // Re-Post all POST'ed variables
    reset($_POST);
    while (list($key, $value) = each($_POST)) {
      if (!is_array($_POST[$key])) {
        echo xtc_draw_hidden_field($key, encode_htmlspecialchars(stripslashes($value)));
      }
    }
?>
                  <div  class="col-xs-12">
                    <div class="col-sm-6 col-xs-6"><input type="submit" class="btn btn-default" onclick="return confirm('<?php echo SAVE_ENTRY; ?>')" value="<?php echo BUTTON_BACK; ?>" name="back"></div>
                    <div class="col-sm-6 col-xs-6 text-right"><?php echo '<a class="btn btn-default" href="' . xtc_href_link(FILENAME_MAIL) . '">' . BUTTON_CANCEL . '</a> <input type="submit" class="btn btn-default" value="'.BUTTON_SEND_EMAIL.'">' ?></div>
                  </div>
            </div>
          </form>
<?php
  } else {
?>
          <?php echo xtc_draw_form('mail', FILENAME_MAIL, 'action=preview'); ?>
            <div  class="col-xs-12">
              <div  class="col-xs-12">
                <br>
              </div>
<?php
    $customers = array();
    $customers[] = array('id' => '', 'text' => TEXT_SELECT_CUSTOMER);
    $customers[] = array('id' => '***', 'text' => TEXT_ALL_CUSTOMERS);
    $customers[] = array('id' => '**D', 'text' => TEXT_NEWSLETTER_CUSTOMERS);
    // Customers Status 1.x
//    $customers_statuses_array = xtc_get_customers_statuses();
    $customers_statuses_array = xtc_db_query("select customers_status_id , customers_status_name from " . TABLE_CUSTOMERS_STATUS . " WHERE language_id='" . $_SESSION['languages_id'] . "' order by customers_status_name");
    while ($customers_statuses_value = xtc_db_fetch_array($customers_statuses_array)) {
      $customers[] = array('id' => $customers_statuses_value['customers_status_id'],
                           'text' => $customers_statuses_value['customers_status_name']);
    }
    // End customers Status 1.x
    $mail_query = xtc_db_query("select customers_email_address, customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " order by customers_lastname");
    while($customers_values = xtc_db_fetch_array($mail_query)) {
      $customers[] = array('id' => $customers_values['customers_email_address'],
                           'text' => $customers_values['customers_lastname'] . ', ' . $customers_values['customers_firstname'] . ' (' . $customers_values['customers_email_address'] . ')');
    }
?>
              <div  class="col-xs-12">
                <div class="col-sm-2 col-xs-12" class="main"><?php echo TEXT_CUSTOMER; ?></div>
                <div class="col-sm-10 col-xs-12"><?php echo xtc_draw_pull_down_menu('customers_email_address', $customers, $_GET['customer']);?></div>
              </div>
              <div  class="col-xs-12">
                <br>
              </div>
              <div  class="col-xs-12">
                <div class="col-sm-2 col-xs-12" class="main"><?php echo TEXT_FROM; ?></div>
                <div class="col-sm-10 col-xs-12"><?php echo xtc_draw_input_field('from', EMAIL_FROM); ?></div>
              </div>
              <div  class="col-xs-12">
                <br>
              </div>
              <div  class="col-xs-12">
                <div class="col-sm-2 col-xs-12" class="main"><?php echo TEXT_SUBJECT; ?></div>
                <div class="col-sm-10 col-xs-12"><?php echo xtc_draw_input_field('subject'); ?></div>
              </div>
              <div  class="col-xs-12">
                <br>
              </div>
              <div  class="col-xs-12">
                <div class="col-sm-2 col-xs-12" valign="top" class="main"><?php echo TEXT_MESSAGE; ?></div>
                <div class="col-sm-10 col-xs-12"><?php echo xtc_draw_textarea_field('message', 'soft', '100%', '30'); ?></div>
              </div>
              <div  class="col-xs-12">
                <br>
              </div>
              <div  class="col-xs-12">
                <div class="col-sm-12 col-xs-12 text-right"><input type="submit" class="btn btn-default" value="<?php echo BUTTON_SEND_EMAIL; ?>"></div>
              </div>
            </div>
          </form>
<?php
  }
?>
<!-- body_text_eof //-->
</div>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
<?php
if (USE_WYSIWYG=='true') {
	if (!isset($_GET['action'])) {
	$query=xtc_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
	$data=xtc_db_fetch_array($query);
	echo xtc_wysiwyg('mail',$data['code']);
	}
}
?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
