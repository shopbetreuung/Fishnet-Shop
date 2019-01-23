<?php
/* -----------------------------------------------------------------------------------------
$Id: dhlgkapi_print_label.php v2.0 23.11.2017 nb $   

Autor: Nico Bauer (c) 2016-2017 Dörfelt GmbH for DHL Paket GmbH

Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html]
-----------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE', 'DHL inkl. Wunschpaket');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE_NO_WS', 'DHL');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_DESCRIPTION', 'DHL Versenden inkl. Empf&auml;ngerservices');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_WAY', '');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_DHLGKAPI_INVALID_ZONE', 'Es ist kein Versand in dieses Land m&ouml;glich!');
define('MODULE_SHIPPING_DHLGKAPI_UNDEFINED_RATE', 'Die Versandkosten k&ouml;nnen im Moment nicht berechnet werden.');

define('MODULE_SHIPPING_DHLGKAPI_STATUS_TITLE' , 'DHLGKAPI aktivieren');
define('MODULE_SHIPPING_DHLGKAPI_STATUS_DESC' , 'M&ouml;chten Sie die Versandart DHLGKAPI anbieten?');
define('MODULE_SHIPPING_DHLGKAPI_ALLOWED_TITLE' , 'Erlaubte Versandzonen');
define('MODULE_SHIPPING_DHLGKAPI_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand m&ouml;glich sein soll. (z.B. AT,DE (lassen Sie dieses Feld leer, wenn Sie alle Zonen erlauben wollen))');
define('MODULE_SHIPPING_DHLGKAPI_TAX_CLASS_TITLE' , 'Steuerklasse');
define('MODULE_SHIPPING_DHLGKAPI_TAX_CLASS_DESC' , 'Folgende Steuerklasse an Versandkosten anwenden');
define('MODULE_SHIPPING_DHLGKAPI_SORT_ORDER_TITLE' , 'Sortierreihenfolge');
define('MODULE_SHIPPING_DHLGKAPI_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige');

define('MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_DE', serialize(array('V01PAK', 'V53WPAK(Z1)', 'V53WPAK(Z2)', 'V53WPAK(Z3)', 'V53WPAK(Z4)', 'V53WPAK(Z5)', 'V53WPAK(Z6)')));
define('MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_AT', serialize(array('V86PARCEL', 'V87PARCEL', 'V82PARCEL(Z1)', 'V82PARCEL(Z2)', 'V82PARCEL(Z3)', 'V82PARCEL(Z4)')));

define('MODULE_SHIPPING_DHLGKAPI_DAYNAMES', serialize(array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa')));
define('MODULE_SHIPPING_DHLGKAPI_DAYNAMES_SHOWN', serialize(array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa')));
define('MODULE_SHIPPING_DHLGKAPI_NO_PREFERENCE', 'keine<br />Angabe');

//Deutschland
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V01PAK_TITLE', 'DHL Paket National');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z1)_TITLE', 'DHL Paket International Zone 1 (EU)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z2)_TITLE', 'DHL Paket International Zone 2 (Europa ohne EU)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z3)_TITLE', 'DHL Paket International Zone 3 (Welt 1)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z4)_TITLE', 'DHL Paket International Zone 4 (Welt 2)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z5)_TITLE', 'DHL Paket International Zone 5 (Welt 3)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z6)_TITLE', 'DHL Paket International Zone 5 (Welt 4)');

//Texte für Frontend
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_TITLE', 'Ihr DHL Wunschpaket<br />Gebracht wie gew&uuml;nscht.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_DESC', 'Mit den Services von DHL Wunschpaket entscheiden Sie, wann und wo Sie Ihre Pakete empfangen. W&auml;hlen Sie Ihre bevorzugte Lieferoption aus:');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_OR', 'oder');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_ADDRESS_CHANGE', 'Die Versandadresse wurde ge&auml;ndert. Bitte w&auml;hlen Sie erneut Ihre bevorzugten Lieferoptionen.');
define('MODULE_SHIPPING_DHLGKAPI_PL_TITLE', 'Wunschort: Lieferung an den gew&uuml;nschten Ablageort');
define('MODULE_SHIPPING_DHLGKAPI_PL_DESC', '');
define('MODULE_SHIPPING_DHLGKAPI_PL_TOOLTIP', 'Bestimmen Sie einen wettergesch&uuml;tzten und nicht einsehbaren Platz auf Ihrem Grundst&uuml;ck,&#10;an dem wir das Paket w&auml;hrend Ihrer Abwesenheit hinterlegen d&uuml;rfen.');
define('MODULE_SHIPPING_DHLGKAPI_PL_PLACEHOLDER', 'z.B. Garage, Terrasse');
define('MODULE_SHIPPING_DHLGKAPI_PN_TITLE', 'Wunschnachbar: Lieferung an den Nachbarn Ihrer Wahl');
define('MODULE_SHIPPING_DHLGKAPI_PN_DESC', '');
define('MODULE_SHIPPING_DHLGKAPI_PN_TOOLTIP', 'Bestimmen Sie eine Person in Ihrer unmittelbaren Nachbarschaft,&#10;bei der wir Ihr Paket w&auml;hrend Ihrer Abwesenheit abgeben d&uuml;rfen.&#10;Diese sollte im gleichen Haus, direkt gegen&uuml;ber oder nebenan wohnen.');
define('MODULE_SHIPPING_DHLGKAPI_PN_PLACEHOLDER1', 'Nachname, Vorname');
define('MODULE_SHIPPING_DHLGKAPI_PN_PLACEHOLDER2', 'Adresse, PLZ, Ort');
define('MODULE_SHIPPING_DHLGKAPI_PT_TITLE', 'Wunschzeit: Lieferung im gew&uuml;nschten Zeitfenster');
define('MODULE_SHIPPING_DHLGKAPI_PT_DESC', 'F&uuml;r diesen Service f&auml;llt ein Aufpreis an:');
define('MODULE_SHIPPING_DHLGKAPI_PT_TOOLTIP', 'Damit Sie besser planen k&ouml;nnen, haben Sie die M&ouml;glichkeit eine Wunschzeit f&uuml;r die&#10;Lieferung auszuw&auml;hlen. Sie k&ouml;nnen eine der dargestellten Zeiten f&uuml;r die Lieferung ausw&auml;hlen.');
define('MODULE_SHIPPING_DHLGKAPI_PD_TITLE', 'Wunschtag: Lieferung zum gew&uuml;nschten Tag');
define('MODULE_SHIPPING_DHLGKAPI_PD_DESC', 'F&uuml;r diesen Service f&auml;llt ein Aufpreis an:');
define('MODULE_SHIPPING_DHLGKAPI_PD_TOOLTIP', 'Sie haben die M&ouml;glichkeit einen der angezeigten Tage als Wunschtag f&uuml;r die Lieferung Ihrer&#10;Waren  auszuw&auml;hlen. Andere Tage sind aufgrund der Lieferprozesse aktuell nicht m&ouml;glich.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_HINT', 'Bei einer Buchung von Wunschtag und Wunschzeit in Kombination, fallen zus&auml;tzliche Versandkosten an:');
define('MODULE_SHIPPING_DHLGKAPI_PSF_TITLE', 'Packstation oder Postfiliale finden');
define('MODULE_SHIPPING_DHLGKAPI_PSF_DESC', 'Oder w&auml;hlen Sie die Lieferung an eine Packstation oder Filiale.');
define('MODULE_SHIPPING_DHLGKAPI_PSF_BUTTON', 'Oder w&auml;hlen Sie die Lieferung an eine Packstation oder Filiale.');

//Österreich
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V86PARCEL_TITLE', 'DHL Paket Austria');                                                                                    
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V87PARCEL_TITLE', 'DHL Paket Connect Europa');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z1)_TITLE', 'DHL Paket International EU');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z2)_TITLE', 'DHL Paket International Welt 1');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z3)_TITLE', 'DHL Paket International Welt 2');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z4)_TITLE', 'DHL Paket International Welt 3');

foreach (unserialize(MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_DE) as $type) {
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED_TITLE' , '<br /><br /><u>Versandzone '.constant('MODULE_SHIPPING_DHLGKAPI_TYPE_'.$type.'_TITLE').' (API Produkt: '.preg_replace("/\([\w]*\)/","",$type).')</u><br /><br />Zone erlaubt');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED_DESC' , '');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ATTENDANCE_TITLE' , 'Teilnahme');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ATTENDANCE_DESC' , '2-stellig, zu Verfahren (Produkt): '.substr(preg_replace("/[^0-9]/","",$type),0,2).'<br />(Die letzten beiden Stellen der Abrechnungsnummer zum Produkt.)');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES_TITLE' , 'L&auml;nder');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES_DESC' , 'Durch Komma getrennte Liste von ISO 3166-1 alpha-2 L&auml;ndercodes (2 Zeichen).');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST_TITLE' , 'Versandkosten');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST_DESC' , 'Versandkosten nach Zone '.$type.' Bestimmungsorte, basierend auf einer Gruppe von max. Bestellgewichten. Beispiel: 3:8.50,7:10.50,... Gewicht von kleiner oder gleich 3 w&uuml;rde 8.50 f&uuml;r die Zone '.$type.' Bestimmungsl&auml;nder kosten.');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING_TITLE' , 'Handling Geb&uuml;hr');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING_DESC' , 'Handling Geb&uuml;hr f&uuml;r diese Versandzone');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT_TITLE' , 'Versandkostenfrei');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT_DESC' , 'ab diesem Betrag');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_RETOURE_ATTENDANCE_TITLE' , 'Teilnahme f&uuml;r Retoure');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_RETOURE_ATTENDANCE_DESC' , '2-stellig (0 = Keine Retoure zu diesem Produkt)');
}


define('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED_TITLE','<u>Versand von eMail Benachrichtigungen</u><br /><br />Shop eMail');
define('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED_DESC','Kunde bei Versand benachrichtigen');
define('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED_TITLE','DHL eMail');
define('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED_DESC','DHL sendet Statusnachricht');

define('MODULE_SHIPPING_DHLGKAPI_EMAIL_TIME_TITLE','Versand eMail cut-off Zeit');
define('MODULE_SHIPPING_DHLGKAPI_EMAIL_TIME_DESC','Bis zu dieser Zeit ausgedruckte Labels werden am gleichen Tag versendet.');

define('MODULE_SHIPPING_DHLGKAPI_EKP_TITLE','<u>Zugangsdaten Gesch&auml;ftskundenportal</u><br><br>EKP');
define('MODULE_SHIPPING_DHLGKAPI_EKP_DESC','Geben Sie hier ihre EKP (Kundennummer) ein');
define('MODULE_SHIPPING_DHLGKAPI_USER_TITLE','Benutzername');
define('MODULE_SHIPPING_DHLGKAPI_USER_DESC','f&uuml;r das Gesch&auml;ftskundenportal');
define('MODULE_SHIPPING_DHLGKAPI_PASSWORD_TITLE','Passwort');
define('MODULE_SHIPPING_DHLGKAPI_PASSWORD_DESC','f&uuml;r das Gesch&auml;ftskundenportal');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME_TITLE','<u>Absender</u><br><br>Name');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME_TITLE','Stra&szlig;e');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER_TITLE','Hausnummer');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP_TITLE','Postleitzahl');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY_TITLE','Stadt');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY_TITLE','Land');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY_DESC','ISO 3166-1 alpha-2 L&auml;ndercode');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED_TITLE','<a class="button" href="#" onClick="window.location.href=\'dhlgkapi_print_label.php?testlabel=on&oID=0\'">Konfiguration testen</a>&nbsp;<span class=""><br />(Muss zuvor gespeichert werden.<br />Evtl. noch Teilnahme V01PAK anpassen.)</span><br /><br /><u>R&uuml;cksendeetikett erstellen</u>');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_NAME_TITLE','R&uuml;cksendeadresse<br><br>Name');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_NAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME_TITLE','Stra&szlig;e');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER_TITLE','Hausnummer');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP_TITLE','Postleitzahl');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_CITY_TITLE','Stadt');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_CITY_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY_TITLE','Land');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY_DESC','ISO 3166-1 alpha-2 L&auml;ndercode');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON_TITLE','Kontaktperson');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL_TITLE','eMail');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE_TITLE','Telefon');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_COD_ENABLED_TITLE','<u>Nachnahme</u><br /><br />Nachnahme erlaubt');
define('MODULE_SHIPPING_DHLGKAPI_COD_ENABLED_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE_TITLE','Zahlungsmodul f&uuml;r Nachnahme');
define('MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE_DESC','interner Modulname');
define('MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE_TITLE','Zustellgeb&uuml;hr');
define('MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE_DESC','wird von DHL erhoben');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER_TITLE','Kontodaten f&uuml;r Nachnahme<br><br>Kontoinhaber');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME_TITLE','Bankname');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME_DESC','');        
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN_TITLE','IBAN');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC_TITLE','BIC');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED_TITLE','<u>Status&auml;nderung der Bestellung</u><br><br>Versendet');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED_DESC' , 'Status der Bestellung nach Versandlabelerstellung');   
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED_TITLE' , 'Storno');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED_DESC' , 'Status der Bestellung nach Stornierung des Versandlabels');

define('MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED_TITLE', '<u>Paketsteuerung API</u><br /><br />API verwenden');
define('MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED_DESC', '&uuml;berpr&uuml;ft zur Verf&uuml;gung stehende Services online nach Liefer PLZ');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED_TITLE', '<u>Wunschpaket</u><br /><br />Wunschtag erlaubt');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED_DESC', 'aktiviert den Service Wunschtag');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST_TITLE', 'Wunschtag Kosten');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST_DESC', 'Geben Sie hier einen Aufpreis f&uuml;r den Service Wunschtag an.<br />Geben Sie 0 ein, um den Service konstenfrei anzubieten. Nutzen Sie . als Dezimalzeichen.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_PAYMENT_EXCLUDE_TITLE', 'Wunschtag ausgeschlossene Zahlarten');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_PAYMENT_EXCLUDE_DESC', 'Diese Zahlarten werden im Checkout bei Auswahl Wunschtag nicht mehr angezeigt');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_STOCK_CHECK_TITLE', 'Wunschtag Lagerbestand ber&uuml;cksichtigen');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_STOCK_CHECK_DESC', 'Nur wenn der Lagerbestand aller Artikel im Warenkorb mindestens gleich der Bestellmenge ist, wird der Wunschtag angeboten.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_TITLE', 'Wunschtag Lieferzeit ber&uuml;cksichtigen');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_DESC', 'Nur wenn die Lieferzeit aller Artikel im Warenkorb der folgenden Lieferzeitangabe entspricht, wird der Wunschtag angeboten.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_STATUS_TITLE', 'Wunschtag Lieferzeit');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_STATUS_DESC', 'Lieferstatus der Artikel');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED_TITLE', 'Wunschzeit erlaubt');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED_DESC', 'aktiviert den Service Wunschzeit');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_COST_TITLE', 'Wunschzeit Kosten');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_COST_DESC', 'Geben Sie hier einen Aufpreis f&uuml;r den Service Wunschzeit an.<br />Geben Sie 0 ein, um den Service konstenfrei anzubieten. Nutzen Sie . als Dezimalzeichen.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_PAYMENT_EXCLUDE_TITLE', 'Wunschzeit ausgeschlossene Zahlarten');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_PAYMENT_EXCLUDE_DESC', 'Diese Zahlarten werden im Checkout bei Auswahl Wunschzeit nicht mehr angezeigt');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST_TITLE', 'Wunschtag / Wunschzeit Kosten');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST_DESC', 'Geben Sie hier einen Aufpreis f&uuml;r die Kombination aus den Services Wunschzeit und -tag an.<br />Geben Sie 0 ein, um den Service konstenfrei anzubieten. Nutzen Sie . als Dezimalzeichen.');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED_TITLE', 'Wunschnachbar erlaubt');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED_DESC', 'aktiviert den Service Wunschnachbar');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_PAYMENT_EXCLUDE_TITLE', 'Wunschnachbar ausgeschlossene Zahlarten');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_PAYMENT_EXCLUDE_DESC', 'Diese Zahlarten werden im Checkout bei Auswahl Wunschnachbar nicht mehr angezeigt');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED_TITLE', 'Wunschablageort erlaubt');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED_DESC', 'aktiviert den Service Wunschablageort');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_PAYMENT_EXCLUDE_TITLE', 'Wunschablageort ausgeschlossene Zahlarten');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_PAYMENT_EXCLUDE_DESC', 'Diese Zahlarten werden im Checkout bei Auswahl Wunschablageort nicht mehr angezeigt');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME_TITLE', 'Versandzeit cut-off');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME_DESC', 'Bis zu dieser Bestellzeit werden Pakete noch am selben Tag verschickt.<br />Wichtig f&uuml;r den Wunschtag!');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_BLACKLIST','"paketbox","packstation","postfach","postfiliale","filiale","postfiliale direkt","filiale direkt","paketkasten","dhl","p-a-c-k-s-t-a-t-i-o-n","paketstation","pack station","p.a.c.k.s.t.a.t.i.o.n.","pakcstation","paackstation","pakstation","backstation","bakstation","p a c k s t a t i o n","wunschfiliale","deutsche post","\'","\"","\/","[<>;+]"');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_FREEAMOUNT_COST_ENABLED_TITLE','Wunschpaket Kosten immer addieren');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_FREEAMOUNT_COST_ENABLED_DESC','Die Kosten f&uuml;r das Wunschpaket werden auch bei kostenlosem Versand hinzuaddiert.');

define('MODULE_SHIPPING_DHLGKAPI_HOLIDAYS_TITLE', 'Feiertage DHL');
define('MODULE_SHIPPING_DHLGKAPI_HOLIDAYS_DESC', 'Durch Komma getrennte Liste von Datumsangaben in der Form: TT.MM.<br />An diesen Tagen erfolgt keine Abholung oder Zustellung seitens DHL.');

define('MODULE_SHIPPING_DHLGKAPI_SHIPPING_DAYS_TITLE', 'Versandtage');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPING_DAYS_DESC', 'An diesen Tagen wird regul&auml;r versendet.');

define('MODULE_SHIPPING_DHLGKAPI_PSF_ENABLED_TITLE','Parcelshopfinder aktivieren');
define('MODULE_SHIPPING_DHLGKAPI_PSF_ENABLED_DESC','Zeigt den Link zum Parcelshopfinder im Frontend bei der Eingabe einer neuen Versandadresse.');

define('MODULE_SHIPPING_DHLGKAPI_UTF8_ENABLED_TITLE','UTF-8 aktivieren');
define('MODULE_SHIPPING_DHLGKAPI_UTF8_ENABLED_DESC','Aktivieren, wenn die Zeichenkodierung der Datenbank UTF-8 ist.');
?>
