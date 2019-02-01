<?php
/* -----------------------------------------------------------------------------------------
$Id: dhlgkapi_print_label.php v2.0 23.11.2017 nb $   

Autor: Nico Bauer (c) 2016-2017 Dörfelt GmbH for DHL Paket GmbH

Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html]
-----------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE', 'DHL incl. package');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE_NO_WS', 'DHL');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_DESCRIPTION', 'DHL Sending incl. Recipient Services');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_WAY', '');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_DHLGKAPI_INVALID_ZONE', 'It is not possible to ship to this country');
define('MODULE_SHIPPING_DHLGKAPI_UNDEFINED_RATE', 'Shipping costs cannot be calculated at the moment');

define('MODULE_SHIPPING_DHLGKAPI_STATUS_TITLE' , 'Enable DHLGKAPI');
define('MODULE_SHIPPING_DHLGKAPI_STATUS_DESC' , 'Do you want to offer the shipping method DHLGKAPI?');
define('MODULE_SHIPPING_DHLGKAPI_ALLOWED_TITLE' , 'Allowed shipping zones');
define('MODULE_SHIPPING_DHLGKAPI_ALLOWED_DESC' , 'Specify <b>individual</b> the zones to which shipping should be possible. (e.g. AT,DE (leave this field empty if you want to allow all zones))');
define('MODULE_SHIPPING_DHLGKAPI_TAX_CLASS_TITLE' , 'Tax class');
define('MODULE_SHIPPING_DHLGKAPI_TAX_CLASS_DESC' , 'Apply the following tax class to shipping costs');
define('MODULE_SHIPPING_DHLGKAPI_SORT_ORDER_TITLE' , 'Sort sequence');
define('MODULE_SHIPPING_DHLGKAPI_SORT_ORDER_DESC' , 'Display sequence');

define('MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_DE', serialize(array('V01PAK', 'V53WPAK(Z1)', 'V53WPAK(Z2)', 'V53WPAK(Z3)', 'V53WPAK(Z4)', 'V53WPAK(Z5)', 'V53WPAK(Z6)')));
define('MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_AT', serialize(array('V86PARCEL', 'V87PARCEL', 'V82PARCEL(Z1)', 'V82PARCEL(Z2)', 'V82PARCEL(Z3)', 'V82PARCEL(Z4)')));

define('MODULE_SHIPPING_DHLGKAPI_DAYNAMES', serialize(array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa')));
define('MODULE_SHIPPING_DHLGKAPI_DAYNAMES_SHOWN', serialize(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat')));
define('MODULE_SHIPPING_DHLGKAPI_NO_PREFERENCE', 'N/A');

//Deutschland
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V01PAK_TITLE', 'DHL Paket National');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z1)_TITLE', 'DHL Paket International Zone 1 (EU)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z2)_TITLE', 'DHL Paket International Zone 2 (Europe without EU)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z3)_TITLE', 'DHL Paket International Zone 3 (World 1)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z4)_TITLE', 'DHL Paket International Zone 4 (World 2)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z5)_TITLE', 'DHL Paket International Zone 5 (World 3)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z6)_TITLE', 'DHL Paket International Zone 5 (World 4)');

//Texte für Frontend
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_TITLE', 'Your recipient services');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_DESC', 'You decide when and where you want to receive your parcels with the recipient services of DHL. Please choose your preferred delivery option:');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_OR', 'or');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_ADDRESS_CHANGE', 'The shipping address has been changed. Please choose your preferred delivery option again.');
define('MODULE_SHIPPING_DHLGKAPI_PL_TITLE', 'Preferred location: delivery to your preferred drop-off location');
define('MODULE_SHIPPING_DHLGKAPI_PL_DESC', '');
define('MODULE_SHIPPING_DHLGKAPI_PL_TOOLTIP', 'Choose a weather-protected and non-visible place on your property,&#10;where we can deposit the parcel in your absence.');
define('MODULE_SHIPPING_DHLGKAPI_PL_PLACEHOLDER', 'e.g. garage, terrace');
define('MODULE_SHIPPING_DHLGKAPI_PN_TITLE', 'Preferred neighbour: delivery to a neighbour of your choice');
define('MODULE_SHIPPING_DHLGKAPI_PN_DESC', '');
define('MODULE_SHIPPING_DHLGKAPI_PN_TOOLTIP', 'Determine a person in your immediate neighbourhood whom we can&#10;hand out your parcel in your absence. This person should live in the&#10;same building, directly opposite or next door.');
define('MODULE_SHIPPING_DHLGKAPI_PN_PLACEHOLDER1', 'first name, last name of neighbour');
define('MODULE_SHIPPING_DHLGKAPI_PN_PLACEHOLDER2', 'street, number, postal code, city');
define('MODULE_SHIPPING_DHLGKAPI_PT_TITLE', 'Preferred time: delivery during your preferred time slot');
define('MODULE_SHIPPING_DHLGKAPI_PT_DESC', 'For this service there is a surcharge of:');
define('MODULE_SHIPPING_DHLGKAPI_PT_TOOLTIP', 'Indicate a preferred time, which suits you best for your parcel delivery&#10;by choosing one of the displayed time windows.');
define('MODULE_SHIPPING_DHLGKAPI_PD_TITLE', 'Preferred day: delivery at your preferred day');
define('MODULE_SHIPPING_DHLGKAPI_PD_DESC', 'For this service there is a surcharge of:');
define('MODULE_SHIPPING_DHLGKAPI_PD_TOOLTIP', 'Choose one of the displayed days as your preferred day for your parcel delivery.&#10;Other days are not possible due to delivery processes.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_HINT', 'For a booking of preferred day and preferred time in combination there is a surcharge of:');
define('MODULE_SHIPPING_DHLGKAPI_PSF_TITLE', 'Locate a Parcelstation or Post Office');
define('MODULE_SHIPPING_DHLGKAPI_PSF_DESC', 'Or choose a DHL Packstation or a branch as an alternative delivery address.');
define('MODULE_SHIPPING_DHLGKAPI_PSF_BUTTON', 'Or choose a DHL Packstation or a branch as an alternative delivery address.');

//Österreich
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V86PARCEL_TITLE', 'DHL Paket Austria');                                                                                    
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V87PARCEL_TITLE', 'DHL Paket Connect Europa');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z1)_TITLE', 'DHL Paket International EU');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z2)_TITLE', 'DHL Paket International World 1');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z3)_TITLE', 'DHL Paket International World 2');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z4)_TITLE', 'DHL Paket International World 3');

foreach (unserialize(MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_DE) as $type) {
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED_TITLE' , '<br /><br /><u>Versandzone '.constant('MODULE_SHIPPING_DHLGKAPI_TYPE_'.$type.'_TITLE').' (API Product: '.preg_replace("/\([\w]*\)/","",$type).')</u><br /><br />Zone allowed');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED_DESC' , '');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ATTENDANCE_TITLE' , 'attendance');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ATTENDANCE_DESC' , '2 digits, to Procedure (product): '.substr(preg_replace("/[^0-9]/","",$type),0,2));
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES_TITLE' , 'countries');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES_DESC' , 'Comma separated list of ISO 3166-1 alpha-2 country codes (2 characters).');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST_TITLE' , 'shipping costs');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST_DESC' , 'Shipping costs by zone '.$type.' Destinations, based on a group of max. order weights. Example: 3:8.50,7:10.50,... Weight less than or equal to 3 would be 8.50 for the zone '.$type.' Destination cost.');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING_TITLE' , 'Handling fee');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING_DESC' , 'Handling of the container for this shipping zone');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT_TITLE' , 'Free shipping');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT_DESC' , 'from this amount');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_RETOURE_ATTENDANCE_TITLE' , 'Participation for returns');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_RETOURE_ATTENDANCE_DESC' , '2-digit (0 = no returns for this product)');
}


define('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED_TITLE','<u>Sending eMail Notifications</u><br /><br />Shop eMail');
define('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED_DESC','Notify customer when shipping');

define('MODULE_SHIPPING_DHLGKAPI_EMAIL_TIME_TITLE','Shipping eMail cut-off time');
define('MODULE_SHIPPING_DHLGKAPI_EMAIL_TIME_DESC','Labels printed up to this time will be sent on the same day.');

define('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED_TITLE','DHL eMail');
define('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED_DESC','DHL sends status message');
define('MODULE_SHIPPING_DHLGKAPI_EKP_TITLE','<u>Access data business customer portal</u><br><br>EKP');
define('MODULE_SHIPPING_DHLGKAPI_EKP_DESC','Enter your EKP (customer number) here');
define('MODULE_SHIPPING_DHLGKAPI_USER_TITLE','Username');
define('MODULE_SHIPPING_DHLGKAPI_USER_DESC','for the business customer portal');
define('MODULE_SHIPPING_DHLGKAPI_PASSWORD_TITLE','Password');
define('MODULE_SHIPPING_DHLGKAPI_PASSWORD_DESC','for the business customer portal');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME_TITLE','<u>Sender</u><br><br>Name');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME_TITLE','Street');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER_TITLE','House number');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP_TITLE','Postcode');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY_TITLE','City');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY_TITLE','Country');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY_DESC','ISO 3166-1 alpha-2 country code');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED_TITLE','<a class="button" href="#" onClick="window.location.href = \'dhlgkapi_print_label.php?testlabel=on&oID=0\'">test configuration</a>&nbsp;<span class=""><br />(Must be saved beforehand.<br />Evtl. still adjust participation V01PAK.)</span><br /><br /><u>Create send label</u>');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_NAME_TITLE','R&uuml;cksendeadresse<br><br>Name');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_NAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME_TITLE','Street');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER_TITLE','House number');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP_TITLE','Postcode');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_CITY_TITLE','City');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_CITY_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY_TITLE','Country');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY_DESC','ISO 3166-1 alpha-2 country code');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON_TITLE','contact person');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL_TITLE','eMail');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE_TITLE','Phone');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_COD_ENABLED_TITLE','<u>Cash on delivery</u><br /><br />Cash on delivery allowed');
define('MODULE_SHIPPING_DHLGKAPI_COD_ENABLED_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE_TITLE','Payment module for cash on delivery');
define('MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE_DESC','internal module name');
define('MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE_TITLE','delivery charge');
define('MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE_DESC','charged by DHL');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER_TITLE','account data for cash on delivery<br><br>account holder');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME_TITLE','Bank name');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME_DESC','');        
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN_TITLE','IBAN');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC_TITLE','BIC');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED_TITLE','<u>Status&change of purchase order</u><br><br>Shipped');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED_DESC' , 'Status of purchase order after creation of shipping label'); 

define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED_TITLE' , 'Cancellation');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED_DESC' , 'Status of purchase order after cancellation of shipping label');

define('MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED_TITLE', '<u>Packet control API</u><br /><br />>use API');
define('MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED_DESC', 'Check available services online by delivery postal code');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED_TITLE', '<u>Wish package</u><br /><br />Wish day allowed');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED_DESC', 'activates the service Wish day');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST_DESC', 'Enter a surcharge for the desired service day here.<br />Enter 0 to offer the service free of charge. Use . as decimal sign.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST_DESC', 'Surcharge for desired day');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_PAYMENT_EXCLUDE_TITLE', 'Wish day excluded payment methods');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_PAYMENT_EXCLUDE_DESC', 'These payment methods are no longer displayed in the checkout when the desired day is selected.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_STOCK_CHECK_TITLE', 'Desired day Consider inventory');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_STOCK_CHECK_DESC', 'Only if the stock of all articles in the shopping cart is at least equal to the order quantity, the desired day will be offered..');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_TITLE', 'Desired day Consider delivery time');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_DESC', 'Only if the delivery time of all articles in the shopping basket corresponds to the following delivery time information, the desired day is offered.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_STATUS_TITLE', 'Desired day Delivery time');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_STATUS_DESC', 'Delivery status of articles');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED_TITLE', 'Desired time allowed');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED_DESC', 'Activates the service Desired time');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_COST_TITLE', 'Desired time Costs');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_COST_DESC', 'Enter a surcharge for the service Wunschzeit here.<br />Enter 0 to offer the service free of charge. Use . as decimal sign.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_PAYMENT_EXCLUDE_TITLE', 'Desired time excluded payment methods');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_PAYMENT_EXCLUDE_DESC', 'These payment methods are no longer displayed in the checkout when the desired time is selected.');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST_TITLE', 'Desired day / Desired time Costs');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST_DESC', 'Enter a surcharge here for the combination of the services desired time and day.<br />Enter 0 to offer the service free of charge. Use . as decimal sign.');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED_TITLE', 'Neighbour allowed');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED_DESC', 'Activates the service Desired Neighbor');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_PAYMENT_EXCLUDE_TITLE', 'Neighbouring excluded payment methods');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_PAYMENT_EXCLUDE_DESC', 'These payment methods are no longer displayed in the checkout when you select a neighbor.');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED_TITLE', 'Storage location of choice permitted');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED_DESC', 'Activates the service Desired storage location');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_PAYMENT_EXCLUDE_TITLE', 'Storage location of choice Excluded payment methods');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_PAYMENT_EXCLUDE_DESC', 'These payment methods are no longer displayed in the checkout when you select the desired storage location.');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME_TITLE', 'Shipping time cut-off');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME_DESC', 'Up to this order time packages are still sent on the same day.<br />Important for the day of your choice!');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_BLACKLIST','"paketbox","packstation","postfach","postfiliale","filiale","postfiliale direkt","filiale direkt","paketkasten","dhl","p-a-c-k-s-t-a-t-i-o-n","paketstation","pack station","p.a.c.k.s.t.a.t.i.o.n.","pakcstation","paackstation","pakstation","backstation","bakstation","p a c k s t a t i o n","wunschfiliale","deutsche post","\'","\"","\/","[<>;+]"');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_FREEAMOUNT_COST_ENABLED_TITLE','Always add costs to your desired package');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_FREEAMOUNT_COST_ENABLED_DESC','The costs for the desired package will also be added for free shipping.');

define('MODULE_SHIPPING_DHLGKAPI_HOLIDAYS_TITLE', 'Holidays DHL');
define('MODULE_SHIPPING_DHLGKAPI_HOLIDAYS_DESC', 'Comma-separated list of dates in the form: TT.MM.<br />There will be no pick-up or delivery by DHL on these days.');

define('MODULE_SHIPPING_DHLGKAPI_SHIPPING_DAYS_TITLE', 'shipping days');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPING_DAYS_DESC', 'These are the days of regular shipping.');

define('MODULE_SHIPPING_DHLGKAPI_PSF_ENABLED_TITLE','Activate Parcelshopfinder');
define('MODULE_SHIPPING_DHLGKAPI_PSF_ENABLED_DESC','Shows the link to the Parcelshopfinder in the frontend when entering a new shipping address..');

define('MODULE_SHIPPING_DHLGKAPI_UTF8_ENABLED_TITLE','Enable UTF-8');
define('MODULE_SHIPPING_DHLGKAPI_UTF8_ENABLED_DESC','Enable if the character encoding of the database is UTF-8.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST_TITLE', 'Desired day Costs');

?>
