<?php
/* --------------------------------------------------------------
   $Id: validations.php 950 2005-05-14 16:45:21Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(validations.php,v 1.1 2003/03/15); www.oscommerce.com 
   (c) 2003	 nextcommerce (validations.php,v 1.5 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  ////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // Function    : xtc_validate_email
  //
  // Arguments   : email   email address to be checked
  //
  // Return      : true  - valid email address
  //               false - invalid email address
  //
  // Description : function for validating email address that conforms to RFC 822 specs
  //
  //               This function is converted from a JavaScript written by
  //               Sandeep V. Tamhankar (stamhankar@hotmail.com). The original JavaScript
  //               is available at http://javascript.internet.com
  //
  // Sample Valid Addresses:
  //
  //    first.last@host.com
  //    firstlast@host.to
  //    "first last"@host.com
  //    "first@last"@host.com
  //    first-last@host.com
  //    first.last@[123.123.123.123]
  //
  // Invalid Addresses:
  //
  //    first last@host.com
  //
  //
  ////////////////////////////////////////////////////////////////////////////////////////////////
  defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
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
