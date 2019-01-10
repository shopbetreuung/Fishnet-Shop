<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_php_mail.inc.php 3072 2012-06-18 15:01:13Z hhacker $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003 nextcommerce (xtc_php_mail.inc.php,v 1.17 2003/08/24); www.nextcommerce.org
   (c) 2006 XT-Commerce (xtc_php_mail.inc.php)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
/*
  Dieses Skript enthaelt Ergaenzungen und Aenderungen von hpzeller <info@xos-shop.com> 
  Update PHPMailer v2.0.4 nach PHPMailer v5.2.9 / 2014-10-24
*/   
// include the mail classes
function xtc_php_mail($from_email_address, $from_email_name,
                      $to_email_address, $to_name, $forwarding_to,
                      $reply_address, $reply_address_name,
                      $path_to_attachments, $path_to_more_attachments,
                      $email_subject, $message_body_html, $message_body_plain
                     )
{
  global $mail_error;

//*********************************************************************************************
// Signatur für E-Mails
// by Dipl.-Ing. Daniel Wallas für www.tuvino.de
//*********************************************************************************************
  $mailsmarty= new SmartyBC;
  $mailsmarty->compile_dir = DIR_FS_CATALOG.'templates_c';

  $html_signatur = '<br />' .$mailsmarty->fetch('db:signatur.html'); //web28 - 2011-06-10 - ADD Linebreak
  $txt_signatur = "\n" . $mailsmarty->fetch('db:signatur.txt'); //web28 - 2011-06-10 - ADD Linebreak

  //Platzhalter [SIGNATUR] durch Signatur Text ersetzen
  if (strpos($message_body_html,'[SIGNATUR]') !== false) {
    $message_body_html = str_replace('[SIGNATUR]', $html_signatur, $message_body_html);
    $html_signatur = '';
  }
  if (strpos($message_body_plain,'[SIGNATUR]') !== false) {
    $message_body_plain = str_replace('[SIGNATUR]', $txt_signatur, $message_body_plain);
    $txt_signatur = '';
  }
  //EOF - web28 - 2010-06-05 - Widerruf in Email

//**********************************************************************************************
	require_once(DIR_FS_CATALOG.'includes/classes/phpmailer/PHPMailer.php');
	require_once(DIR_FS_CATALOG.'includes/classes/phpmailer/SMTP.php');
	require_once(DIR_FS_CATALOG.'includes/classes/phpmailer/Exception.php');

  // --- bof -- language mail subject in mailtemplate -- h.koch@hen-vm68.com -- 01.2015 ------------------------ 

  // Ist Betreff in Mailtext vorhanden?
  if( preg_match('/<mailsubject>(.*)<\/mailsubject>/', $message_body_html, $matches) ) {
    $email_subject = $matches[1];                                             // Betreff auslesen

    $message_body_html = str_replace($matches[0], '', $message_body_html);    // aus Text löschen

                                                                              // Falls Aufruf als order_mail
    global $order, $insert_id;
    if( $insert_id>0 && is_object($order) ) {                                 // ist das eine order_mail?
                                                                              // Variablen ersetzen
      $email_subject = str_replace('[$nr]', $insert_id, $email_subject);
      $email_subject = str_replace('[$date]', xtc_date_long($order->info['date_purchased']), $email_subject); // Tomcraft - 2011-12-28 - Use date_puchased instead of current date in E-Mail subject
      $email_subject = str_replace('[$lastname]', $order->customer['lastname'], $email_subject);
      $email_subject = str_replace('[$firstname]', $order->customer['firstname'], $email_subject);
    }  

  }

  // im ascii-Mailtext Betreff-Def. suchen und löschen (hier zählt das nicht)
  if( preg_match('/<mailsubject>(.*)<\/mailsubject>/', $message_body_plain, $matches) ) {
    $message_body_plain = str_replace($matches[0], '', $message_body_plain);
  }
  // --- eof -- language mail subject in mailtemplate -- h.koch@hen-vm68.com -- 01.2015 ------------------------ 	
	
  $mail = new PHPMailer();
  $mail->PluginDir = DIR_FS_CATALOG.'includes/classes/'; // hpzeller - 2014-10-24 - Update PHPMailer v5.2.9

  if (isset ($_SESSION['language_charset'])) {
    $mail->setLanguage($_SESSION['language_code'], DIR_FS_CATALOG.'includes/classes/'); // hpzeller - 2014-10-24 - Update PHPMailer v5.2.9 
    $lang_code = $_SESSION['language_code'];
  } else {
    $lang_query = "SELECT * FROM ".TABLE_LANGUAGES." WHERE code = '".DEFAULT_LANGUAGE."'";
    $lang_query = xtc_db_query($lang_query);
    $lang_data = xtc_db_fetch_array($lang_query);
    $mail->setLanguage(DEFAULT_LANGUAGE, DIR_FS_CATALOG.'includes/classes/'); // hpzeller - 2014-10-24 - Update PHPMailer v5.2.9
    $lang_code = DEFAULT_LANGUAGE;
  }
  
  $mail->CharSet = 'utf-8';
  $charset = 'utf-8';

	if (EMAIL_TRANSPORT == 'smtp') {
    
	    $mail->IsSMTP();
	    $mail->SMTPKeepAlive = true;
	    $mail->SMTPAuth = (SMTP_AUTH == 'true') ? true : false;
	    $mail->SMTPSecure = (defined('SMTP_SECURE') && SMTP_SECURE != 'none') ? SMTP_SECURE : '';
	    $mail->Port = SMTP_PORT;
	    $mail->Username = SMTP_USERNAME;
	    $mail->Password = SMTP_PASSWORD;
	    $mail->Host = SMTP_MAIN_SERVER.';'.SMTP_BACKUP_SERVER;
	    $mail->SMTPAutoTLS = (defined('SMTP_AUTO_TLS') && SMTP_AUTO_TLS == 'true') ? true : false;
	    $mail->SMTPDebug = (defined('SMTP_DEBUG')) ? (int)SMTP_DEBUG : 0;
	    $mail->SMTPOptions = array(
	      'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
	      )
	    );
	  }

	  if (EMAIL_TRANSPORT == 'sendmail') {
	    $mail->isSendmail();
	    $mail->Sendmail = SENDMAIL_PATH;
	  }

	  if (EMAIL_TRANSPORT == 'mail') {
	    $mail->isMail();
	  }

  //BOF  - web28 - 2010-08-27 -  decode html2txt
  $html_array = array('<br />', '<br/>', '<br>');
  $txt_array = array(" \n", " \n", " \n");
  $message_body_plain = str_replace($html_array, $txt_array, $message_body_plain.$txt_signatur);//DPW Signatur ergänzt.
  // remove html tags
  $message_body_plain = strip_tags($message_body_plain);
  $message_body_plain = html_entity_decode($message_body_plain, ENT_NOQUOTES, $charset);
  //EOF  - web28 - 2010-08-27 -  decode html2txt

  if (EMAIL_USE_HTML == 'true') { // set email format to HTML
    $mail->isHTML(true); // hpzeller - 2014-10-24 - Update PHPMailer v5.2.9
    $mail->Body = $message_body_html.$html_signatur;//DPW Signatur ergänzt.
    $mail->AltBody = $message_body_plain;
  } else {
    $mail->isHTML(false); // hpzeller - 2014-10-24 - Update PHPMailer v5.2.9
    $mail->Body = $message_body_plain;
  }

  $mail->From = $from_email_address;
  $mail->Sender = $from_email_address;
  $mail->FromName = $from_email_name;
  $mail->addAddress($to_email_address, $to_name); // hpzeller - 2014-10-24 - Update PHPMailer v5.2.9
  if ($forwarding_to != '') {
    $mail->addBCC($forwarding_to); // hpzeller - 2014-10-24 - Update PHPMailer v5.2.9
  }
  $mail->addReplyTo($reply_address, $reply_address_name); // hpzeller - 2014-10-24 - Update PHPMailer v5.2.9

  $mail->WordWrap = 50; // set word wrap to 50 characters
  //create attachments array for better handling
  $attachments = attachments_array($path_to_attachments,$path_to_more_attachments);
  // add attachments
  for( $i = 0, $n = count($attachments); $i < $n; $i++) {
    $mail->addAttachment($attachments[$i]); // hpzeller - 2014-10-24 - Update PHPMailer v5.2.9
  }
  $mail->Subject = $email_subject;

  if (!$mail->send()) { // hpzeller - 2014-10-24 - Update PHPMailer v5.2.9
    echo "Message was not sent <p>";
    echo "Mailer Error: ".$mail->ErrorInfo."</p>";
    exit;
  }
}

function attachments_array($path_to_attachments,$path_to_more_attachments)
{
  $attachments = array();
  $attachments = check_attachments($attachments,$path_to_attachments);
  $attachments = check_attachments($attachments,$path_to_more_attachments);
  return $attachments;
}

function check_attachments($attachments, $path_to_attachments)
{
  if ($path_to_attachments != '') {
    $path_to_attachments = is_array($path_to_attachments) ? $path_to_attachments : explode(',',$path_to_attachments);
    $num = count($path_to_attachments);
    for($i=0; $i <$num; $i++) {
      $path_to_attachments[$i] = ((strpos($path_to_attachments[$i], DIR_FS_DOCUMENT_ROOT)===false) ? DIR_FS_DOCUMENT_ROOT:'') . trim($path_to_attachments[$i]);
      if (file_exists($path_to_attachments[$i])) {
        $attachments[] = $path_to_attachments[$i];
      }
    }
  }
  return $attachments;
}
?>