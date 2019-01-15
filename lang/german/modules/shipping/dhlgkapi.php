<?php
/* -----------------------------------------------------------------------------------------
$Id: print_intraship_label.php v1.10 20.11.2013 nb $   

Autor: Nico Bauer (c) 2010-2013 Amber Holding GmbH for DHL Vertriebs GmbH & Co. OHG

Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html] 
-----------------------------------------------------------------------------------------
based on:

zones.php

(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(zones.php,v 1.19 2003/02/05); www.oscommerce.com 
(c) 2003     nextcommerce (zones.php,v 1.7 2003/08/24); www.nextcommerce.org

Released under the GNU General Public License 
-----------------------------------------------------------------------------------------*/

define('NUMBER_OF_ZONES',3); 

define('MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE', 'Versandkosten');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_DESCRIPTION', 'Versand per DHL Germany');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_WAY', '');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_DHLGKAPI_INVALID_ZONE', 'Es ist kein Versand in dieses Land m&ouml;glich!');
define('MODULE_SHIPPING_DHLGKAPI_UNDEFINED_RATE', 'Die Versandkosten können im Moment nicht berechnet werden.');

define('MODULE_SHIPPING_DHLGKAPI_STATUS_TITLE' , 'DHLGKAPI aktivieren');
define('MODULE_SHIPPING_DHLGKAPI_STATUS_DESC' , 'Möchten Sie die Versandart DHLGKAPI anbieten?');
define('MODULE_SHIPPING_DHLGKAPI_ALLOWED_TITLE' , 'Erlaubte Versandzonen');
define('MODULE_SHIPPING_DHLGKAPI_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand möglich sein soll. (z.B. AT,DE (lassen Sie dieses Feld leer, wenn Sie alle Zonen erlauben wollen))');
define('MODULE_SHIPPING_DHLGKAPI_TAX_CLASS_TITLE' , 'Steuerklasse');
define('MODULE_SHIPPING_DHLGKAPI_TAX_CLASS_DESC' , 'Folgende Steuerklasse an Versandkosten anwenden');
define('MODULE_SHIPPING_DHLGKAPI_SORT_ORDER_TITLE' , 'Sortierreihenfolge');
define('MODULE_SHIPPING_DHLGKAPI_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige');

define('MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_DE', serialize(array('V01PAK', 'V53WPAK(Z1)', 'V53WPAK(Z2)', 'V53WPAK(Z3)', 'V53WPAK(Z4)')));
define('MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_AT', serialize(array('V86PARCEL', 'V87PARCEL', 'V82PARCEL')));

define('MODULE_SHIPPING_DHLGKAPI_DAYNAMES', serialize(array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa')));
define('MODULE_SHIPPING_DHLGKAPI_NO_PREFERENCE', 'egal');

//Deutschland
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V01PAK_TITLE', 'DHL Paket National');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z1)_TITLE', 'DHL Paket International Zone 1 (EU)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z2)_TITLE', 'DHL Paket International Zone 2 (Europa ohne EU)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z3)_TITLE', 'DHL Paket International Zone 3 (Welt)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z4)_TITLE', 'DHL Paket International Zone 4 (Rest Welt)');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_TITLE', 'Ihr DHL Wunschpaket<br />Gebracht wie gewünscht.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_DESC', 'Mit den Services von DHL Wunschpaket entscheiden Sie, wann und wo Sie Ihre Pakete empfangen. Wählen Sie Ihre bevorzugte Lieferoption aus:');
define('MODULE_SHIPPING_DHLGKAPI_PL_TITLE', '<u>oder</u><br /><br />Wunschort');
define('MODULE_SHIPPING_DHLGKAPI_PL_DESC', 'Lieferung an den gewünschten Ablageort');
define('MODULE_SHIPPING_DHLGKAPI_PL_TOOLTIP', 'Bestimmen Sie einen wettergeschützten und nicht einsehbaren Platz auf Ihrem Grundstück,&#10;an dem wir das Paket während Ihrer Abwesenheit hinterlegen dürfen.');
define('MODULE_SHIPPING_DHLGKAPI_PL_PLACEHOLDER', 'Name, Straße und Hausnr.');
define('MODULE_SHIPPING_DHLGKAPI_PN_TITLE', 'Wunschnachbar');
define('MODULE_SHIPPING_DHLGKAPI_PN_DESC', 'Lieferung an den Nachbarn Ihrer Wahl');
define('MODULE_SHIPPING_DHLGKAPI_PN_TOOLTIP', 'Bestimmen Sie eine Person in Ihrer unmittelbaren Nachbarschaft, bei der wir Ihr Paket abgeben dürfen.&#10;Diese sollte im gleichen Haus, direkt gegenüber oder nebenan wohnen.');
define('MODULE_SHIPPING_DHLGKAPI_PN_PLACEHOLDER', 'z.B. Garage, Terrasse');
define('MODULE_SHIPPING_DHLGKAPI_PT_TITLE', 'Wunschzeit');
define('MODULE_SHIPPING_DHLGKAPI_PT_DESC', 'Lieferung im gewünschten Zeitfenster');
define('MODULE_SHIPPING_DHLGKAPI_PT_TOOLTIP', 'Damit Sie besser planen können, haben Sie die Möglichkeit eine Wunschzeit für die Lieferung auszuwählen.&#10;Sie können eine der dargestellten Zeiten für die Lieferung auswählen.');
define('MODULE_SHIPPING_DHLGKAPI_PD_TITLE', 'Wunschtag');
define('MODULE_SHIPPING_DHLGKAPI_PD_DESC', 'Lieferung zum gewünschten Tag');
define('MODULE_SHIPPING_DHLGKAPI_PD_TOOLTIP', 'Sie haben die Möglichkeit einen der angezeigten Tage als Wunschtag für die Lieferung Ihrer Waren  auszuwählen.&#10;Andere Tage sind aufgrund der Lieferprozesse aktuell nicht möglich.');
define('MODULE_SHIPPING_DHLGKAPI_PSF_TITLE', 'Packstation oder Postfiliale finden');
define('MODULE_SHIPPING_DHLGKAPI_PSF_DESC', 'Oder wählen Sie die Lieferung an einen Paketshop oder eine Postfiliale');
define('MODULE_SHIPPING_DHLGKAPI_PSF_BUTTON', 'Oder wählen Sie die Lieferung an einen Paketshop oder eine Postfiliale');

//Österreich
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V86PARCEL_TITLE', 'DHL Paket Austria');                                                                                    
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V87PARCEL_TITLE', 'DHL Paket Connect Europa');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z1)_TITLE', 'DHL Paket International EU');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z2)_TITLE', 'DHL Paket International Welt');

foreach (unserialize(MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_DE) as $type) {
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED_TITLE' , '<br /><br /><u>Versandzone '.constant('MODULE_SHIPPING_DHLGKAPI_TYPE_'.$type.'_TITLE').' (API Produkt: '.preg_replace("/\([\w]*\)/","",$type).')</u><br /><br />Zone erlaubt');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED_DESC' , '');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ATTENDANCE_TITLE' , 'Teilnahme');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ATTENDANCE_DESC' , '2-stellig, zu Verfahren (Produkt): '.substr(preg_replace("/[^0-9]/","",$type),0,2));
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES_TITLE' , 'L&auml;nder');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES_DESC' , 'Durch Komma getrennte Liste von ISO 3166-1 alpha-2 Ländercodes (2 Zeichen).');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST_TITLE' , 'Versandkosten');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST_DESC' , 'Versandkosten nach Zone '.$type.' Bestimmungsorte, basierend auf einer Gruppe von max. Bestellgewichten. Beispiel: 3:8.50,7:10.50,... Gewicht von kleiner oder gleich 3 w&uuml;rde 8.50 für die Zone '.$type.' Bestimmungsl&auml;nder kosten.');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING_TITLE' , 'Handling Gebühr');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING_DESC' , 'Handling Gebühr für diese Versandzone');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT_TITLE' , 'Versandkostenfrei');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT_DESC' , 'ab diesem Betrag');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_RETOURE_ATTENDANCE_TITLE' , 'Teilnahme für Retoure');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_RETOURE_ATTENDANCE_DESC' , '2-stellig (0 = Keine Retoure zu diesem Produkt)');
}


define('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED_TITLE','<u>Versand von eMail Benachrichtigungen</u><br /><br />Shop eMail');
define('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED_DESC','Kunde bei Versand benachrichtigen');
define('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED_TITLE','DHL eMail');
define('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED_DESC','DHL sendet Statusnachricht');
define('MODULE_SHIPPING_DHLGKAPI_EKP_TITLE','<u>Zugangsdaten Geschäftskundenportal</u><br><br>EKP');
define('MODULE_SHIPPING_DHLGKAPI_EKP_DESC','Geben Sie hier ihre EKP (Kundennummer) ein');
define('MODULE_SHIPPING_DHLGKAPI_USER_TITLE','Benutzername');
define('MODULE_SHIPPING_DHLGKAPI_USER_DESC','für das Geschäftskundenportal');
define('MODULE_SHIPPING_DHLGKAPI_PASSWORD_TITLE','Passwort');
define('MODULE_SHIPPING_DHLGKAPI_PASSWORD_DESC','für das Geschäftskundenportal');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME_TITLE','<u>Absender</u><br><br>Name');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME_TITLE','Straße');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER_TITLE','Hausnummer');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP_TITLE','Postleitzahl');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY_TITLE','Stadt');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY_TITLE','Land');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY_DESC','ISO 3166-1 alpha-2 Ländercode');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED_TITLE','<a class="button" href="#" onClick="window.open(\'dhlgkapi_print_label.php?testlabel=on&oID=0\',\'_blank\',\'toolbar=0,location=0,directories=0,status=1,menubar=0,titlebar=0,scrollbars=1,resizable=1,width=600,height=400\')">Konfiguration testen</a>&nbsp;<span class="">(müssen zuvor gespeichert werden)</span><br /><br /><u>Rücksendeetikett erstellen</u>');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_NAME_TITLE','Rücksendeadresse<br><br>Name');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_NAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME_TITLE','Straße');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER_TITLE','Hausnummer');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP_TITLE','Postleitzahl');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_CITY_TITLE','Stadt');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_CITY_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY_TITLE','Land');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY_DESC','ISO 3166-1 alpha-2 Ländercode');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON_TITLE','Kontaktperson');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL_TITLE','eMail');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE_TITLE','Telefon');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_COD_ENABLED_TITLE','<u>Nachnahme</u><br /><br />Nachnahme erlaubt');
define('MODULE_SHIPPING_DHLGKAPI_COD_ENABLED_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE_TITLE','Zahlungsmodul für Nachnahme');
define('MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE_DESC','interner Modulname');
define('MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE_TITLE','Zustellgebühr');
define('MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE_DESC','wird von DHL erhoben');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER_TITLE','Kontodaten für Nachnahme<br><br>Kontoinhaber');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME_TITLE','Bankname');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME_DESC','');        
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN_TITLE','IBAN');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC_TITLE','BIC');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED_TITLE','<u>Statusänderung der Bestellung</u><br><br>Versendet');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED_DESC' , 'Status der Bestellung nach Versandlabelerstellung');   
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED_TITLE' , 'Storno');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED_DESC' , 'Status der Bestellung nach Stornierung des Versandlabels');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_ENABLED_TITLE', '<u>Wunschpaket</u><br /><br />Wunschpaket erlaubt');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_ENABLED_DESC', 'aktiviert die Services Wunschtag, Wunschzeit, Wunschort und Wunschnachbar');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME_TITLE', 'Wunschpaket Versandzeit');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME_DESC', 'Bis zu dieser Bestellzeit werden Pakete noch am selben Tag verschickt');
?>
