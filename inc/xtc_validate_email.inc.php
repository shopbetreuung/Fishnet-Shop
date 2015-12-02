<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_validate_email.inc.php 2085 2011-08-03 15:25:38Z web28 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(validations.php,v 1.11 2003/02/11); www.oscommerce.com
   (c) 2003 nextcommerce (xtc_validate_email.inc.php,v 1.5 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce (xtc_validate_email.inc.php 899 2005-04-29)
   (c) 2010 osCommerce (validations.php)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function xtc_validate_email($email) {

	//BOF - web28 - 2011-07-31 - SQL nullbyte injection fix 16.02.2011
	if (strpos($email,"\0")!== false) {return false;}
	if (strpos($email,"\x00")!== false) {return false;}
	if (strpos($email,"\u0000")!== false) {return false;}
	if (strpos($email,"\000")!== false) {return false;}
	//EOF - web28 - 2011-07-31 - SQL nullbyte injection fix 16.02.2011

	$email = trim($email);
	$valid_address = false;
	
	if (strlen($email) > 255) {
		return false;  
	} else {

		// Check for one @
		if (substr_count($email, '@') !== 1 ) {
			return false;
		}  

		$valid_address = true;
	}

	if ($valid_address && ENTRY_EMAIL_ADDRESS_CHECK == 'true') {
		$domain = explode('@', $email);
		if (!checkdnsrr($domain[1], "MX") && !checkdnsrr($domain[1], "A")) {
			$valid_address = false;
		}
	}    
	
	return $valid_address;
}

?>