<?php
if (!defined('TABLE_CARRIERS')) define('TABLE_CARRIERS','carriers');
if (!defined('TABLE_ORDERS_TRACKING')) define('TABLE_ORDERS_TRACKING','orders_tracking');

define('MODULE_SHIPPING_DHLGKAPI_EMAILTEXT','Dein Paket wird heute mit DHL versendet.');
define('MODULE_SHIPPING_DHLGKAPI_EMAILTEXT_TOMORROW','Dein Paket wird am n&auml;chsten Werktag mit DHL versendet.');
define('MODULE_SHIPPING_DHLGKAPI_CANCELTEXT','Der Versand per DHL wurde storniert.');
define('MODULE_SHIPPING_DHLGKAPI_TRACKINGID_ERROR','Keine Sendungsnummer vorhanden.');
define('MODULE_SHIPPING_DHLGKAPI_ORDERERROR','Falsche Bestellnummer!');
define('MODULE_SHIPPING_DHLGKAPI_BUTTON_STORNO','Sendung stornieren');
define('MODULE_SHIPPING_DHLGKAPI_BUTTON_GETLABEL','Label anfordern');
define('MODULE_SHIPPING_DHLGKAPI_EU_COUNTRIES','DE,AT,BE,BG,CZ,CY,DK,EE,FI,FR,GR,HR,HU,IE,IT,LT,LU,LV,MC,MT,NL,PL,PT,RO,SK,SI,ES,SE,GB');

define('MODULE_SHIPPING_DHLGKAPI_SHIPMENTS','Sendung(en)');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER','Absender');
define('MODULE_SHIPPING_DHLGKAPI_RECEIVER','Empf&auml;nger');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPINGDATE','Versanddatum');
define('MODULE_SHIPPING_DHLGKAPI_EKP_TEXT','DHL EKP');
define('MODULE_SHIPPING_DHLGKAPI_PRODUCT','DHL Produkt');
define('MODULE_SHIPPING_DHLGKAPI_ATTENDANCE','DHL Teilnahme');
define('MODULE_SHIPPING_DHLGKAPI_WEIGHT','Gewicht');
define('MODULE_SHIPPING_DHLGKAPI_EMAIL_TEXT','eMail');
define('MODULE_SHIPPING_DHLGKAPI_PHONE','Telefon');
define('MODULE_SHIPPING_DHLGKAPI_SERVICES','Services');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_PREMIUM_TEXT','Paket wird bevorzugt');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_CASHONDELIVERY_TEXT','Nachnahme');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_ADDITIONALINSURANCE_TEXT','Zusatzversicherung');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_BULKYGOODS_TEXT','Sperrgut');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_NOTICEOFNONDELIVERABILITY_TEXT','Unzustellbarkeitsnachricht');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_PERSONALLY_TEXT','Eigenh&auml;ndig');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_NONEIGHBOURDELIVERY_TEXT','keine Nachbarschaftszustellung');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_NAMEDPERSONONLY_TEXT','pers&ouml;nliche &Uuml;bergabe');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_RETURN_TEXT','Retoure-Etikett erstellen');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_PRINTONLYIFCODEABLE_TEXT','nur erstellen, wenn Leitkodierbar');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_VISUALCHECKOFAGE_TEXT','Alterssichtpr&uuml;fung');
define('MODULE_SHIPPING_DHLGKAPI_SERVICE_IDENTCHECK_TEXT','Identit&auml;tspr&uuml;fung');

define('MODULE_SHIPPING_DHLGKAPI_CUSTOMS','Zollerkl&auml;rung');
define('MODULE_SHIPPING_DHLGKAPI_TERMSOFTRADE','Handelsklausel');
define('MODULE_SHIPPING_DHLGKAPI_TERMSOFTRADE_DESC','incoterms codes:<br />DDP (Delivery Duty Paid)<br />DXV (Delivery duty paid (eXcl. VAT ))<br />DDU (DDU - Delivery Duty Unpaid)<br />DDX (Delivery duty paid (excl. Duties, taxes and VAT)');
define('MODULE_SHIPPING_DHLGKAPI_INVOICENUMBER','Rechnungsnummer');
define('MODULE_SHIPPING_DHLGKAPI_ADDITIONALFEE','Zollgeb&uuml;hr');
define('MODULE_SHIPPING_DHLGKAPI_CUSTOMSTARIFFNUMBER','Zolltarifnummer');
define('MODULE_SHIPPING_DHLGKAPI_NETWEIGHTINKG','Nettogewicht in kg');
define('MODULE_SHIPPING_DHLGKAPI_CUSTOMSVALUE','Zollwert');

define('MODULE_SHIPPING_DHLGKAPI_PT_DESC_BACKEND','In der Form "1800200" und "19002100" f&uuml;r das entsprechende Zeitfenster.');
define('MODULE_SHIPPING_DHLGKAPI_PD_DESC_BACKEND','In der Form "yyyy-mm-dd" im Bereich Einlieferungstag +2 bis +6 Werktage.');
define('MODULE_SHIPPING_DHLGKAPI_PN_DESC_BACKEND','');
define('MODULE_SHIPPING_DHLGKAPI_PL_DESC_BACKEND','');

define('MODULE_SHIPPING_DHLGKAPI_MINIMUMAGE','Mindestalter:');

define('MODULE_SHIPPING_DHLGKAPI_TEST_OKAY','Test wurde erfolgreich durchgef&uuml;hrt!');
define('MODULE_SHIPPING_DHLGKAPI_TEST_NOT_OKAY','Nicht erfolgreich!<br />Bitte &uuml;berpr&uuml;fen Sie die eingegebenen Daten!');

define('MODULE_SHIPPING_DHLGKAPI_BACKEND_MODIFIED','Order wurde im Backend bearbeitet! Label kann nun gedruckt werden...<br />Neu ermitteltes DHL Produkt: ');

define('MODULE_SHIPPING_DHLGKAPI_WEIGHT_WARNING','Das Versandgewicht &uuml;berschreitet das konfigurierte maximale Paketgewicht! <br />Bitte mehrere Label erzeugen und tats&auml;chliches Versandgewicht angeben!');

define('MODULE_SHIPPING_DHLGKAPI_PSF_HEADING', 'DHL Parcelshopfinder');
define('MODULE_SHIPPING_DHLGKAPI_PSF_TEXT', 'Finden Sie eine Packstation oder eine Filiale in Ihrer N&auml;he und die Bestellung wird direkt dorthin geliefert.<br /><strong>Ihre Postnummer (DHL Kundennummer) tragen Sie im Feld Stadtteil ein.</strong>');
define('MODULE_SHIPPING_DHLGKAPI_PSF_BUTTON2', 'DHL Packstation / Filiale finden');

define('MODULE_SHIPPING_DHLGKAPI_REPLACE_SEARCH', '"PD:", "PT:", "PN:", "PL:","10001200", "12001400", "14001600", "16001800", "18002000", "19002100", "~", "\\\\[", "\\\\]"');
define('MODULE_SHIPPING_DHLGKAPI_REPLACE_REPLACE', '"Wunschtag: ", "Wunschzeit: ", "Wunschnachbar: ", "Wunschort: ", "10:00 - 12:00 Uhr", "12:00 - 14:00 Uhr", "14:00 - 16:00 Uhr", "16:00 - 18:00 Uhr", "18:00 - 20:00 Uhr", "19:00 - 21:00 Uhr", "<br />", "<br />", ""');


$valid_services=array();
$valid_services['V01PAK']=array(
    'DayOfDelivery' => '0',
    'DeliveryTimeframe' => '0', 
    'PreferredTime' => '1',
    'IndividualSenderRequirement' => '1', 
    'PackagingReturn' => '1', 
    'ReturnImmediately' => '0', 
    'NoticeOfNonDeliverability' => '1', 
    'ShipmentHandling' => '0', 
    'Endorsement' => '0', 
    'VisualCheckOfAge' => '1', 
    'PreferredLocation' => '1', 
    'PreferredNeighbour' => '1', 
    'PreferredDay' => '1',
    'GoGreen' => '1', 
    'Perishables' => '0', 
    'Personally' => '1', 
    'NoNeighbourDelivery' => '1',
    'NamedPersonOnly' => '1', 
    'ReturnReceipt' => '0', 
    'Premium' => '0', 
    'CashOnDelivery' => '1', 
    'AdditionalInsurance' => '1', 
    'BulkyGoods' => '1', 
    'IdentCheck' => '1',
    'Return' => '1',
    'PrintOnlyIfCodeable' => '1'
);

$valid_services['V53WPAK']=array(
    'DayOfDelivery' => '0',
    'DeliveryTimeframe' => '0', 
    'PreferredTime' => '0',
    'IndividualSenderRequirement' => '0', 
    'PackagingReturn' => '0', 
    'ReturnImmediately' => '0', 
    'NoticeOfNonDeliverability' => '0', 
    'ShipmentHandling' => '0', 
    'Endorsement' => '1', 
    'VisualCheckOfAge' => '0', 
    'PreferredLocation' => '0', 
    'PreferredNeighbour' => '0', 
    'PreferredDay' => '0',
    'GoGreen' => '1', 
    'Perishables' => '0', 
    'Personally' => '0', 
    'NoNeighbourDelivery' => '0',
    'NamedPersonOnly' => '0', 
    'ReturnReceipt' => '1', 
    'Premium' => '1', 
    'CashOnDelivery' => '1', 
    'AdditionalInsurance' => '1', 
    'BulkyGoods' => '1', 
    'IdentCheck' => '0',
    'Return' => '0',
    'PrintOnlyIfCodeable' => '1'
);

$valid_services['V86PARCEL']=array(
    'DayOfDelivery' => '0',
    'DeliveryTimeframe' => '0', 
    'PreferredTime' => '0',
    'IndividualSenderRequirement' => '0', 
    'PackagingReturn' => '0', 
    'ReturnImmediately' => '0', 
    'NoticeOfNonDeliverability' => '0', 
    'ShipmentHandling' => '0', 
    'Endorsement' => '0', 
    'VisualCheckOfAge' => '0', 
    'PreferredLocation' => '0', 
    'PreferredNeighbour' => '0', 
    'PreferredDay' => '0',
    'GoGreen' => '0', 
    'Perishables' => '0', 
    'Personally' => '0', 
    'NoNeighbourDelivery' => '0',
    'NamedPersonOnly' => '0', 
    'ReturnReceipt' => '0', 
    'Premium' => '0', 
    'CashOnDelivery' => '1', 
    'AdditionalInsurance' => '1', 
    'BulkyGoods' => '1', 
    'IdentCheck' => '0',
    'Retoure' => '0',
    'PrintOnlyIfCodeable' => '1'
);

$valid_services['V87PARCEL']=array(
    'DayOfDelivery' => '0',
    'DeliveryTimeframe' => '0', 
    'PreferredTime' => '0',
    'IndividualSenderRequirement' => '0', 
    'PackagingReturn' => '0', 
    'ReturnImmediately' => '0', 
    'NoticeOfNonDeliverability' => '0', 
    'ShipmentHandling' => '0', 
    'Endorsement' => '0', 
    'VisualCheckOfAge' => '0', 
    'PreferredLocation' => '0', 
    'PreferredNeighbour' => '0', 
    'PreferredDay' => '0',
    'GoGreen' => '0', 
    'Perishables' => '0', 
    'Personally' => '0', 
    'NoNeighbourDelivery' => '0',
    'NamedPersonOnly' => '0', 
    'ReturnReceipt' => '0', 
    'Premium' => '0', 
    'CashOnDelivery' => '1', 
    'AdditionalInsurance' => '1', 
    'BulkyGoods' => '1', 
    'IdentCheck' => '0',
    'Return' => '0',
    'PrintOnlyIfCodeable' => '1'
);

$valid_services['V82PARCEL']=array(
    'DayOfDelivery' => '0',
    'DeliveryTimeframe' => '0', 
    'PreferredTime' => '0',
    'IndividualSenderRequirement' => '0', 
    'PackagingReturn' => '0', 
    'ReturnImmediately' => '0', 
    'NoticeOfNonDeliverability' => '0', 
    'ShipmentHandling' => '0', 
    'Endorsement' => '0', 
    'VisualCheckOfAge' => '0', 
    'PreferredLocation' => '0', 
    'PreferredNeighbour' => '0', 
    'PreferredDay' => '0',
    'GoGreen' => '0', 
    'Perishables' => '0', 
    'Personally' => '0', 
    'NoNeighbourDelivery' => '0',
    'NamedPersonOnly' => '0', 
    'ReturnReceipt' => '0', 
    'Premium' => '0', 
    'CashOnDelivery' => '0', 
    'AdditionalInsurance' => '1', 
    'BulkyGoods' => '1', 
    'IdentCheck' => '0',
    'Return' => '0',
    'PrintOnlyIfCodeable' => '1'
);

define('MODULE_SHIPPING_DHLGKAPI_VALID_SERVICES',serialize($valid_services));

define('MODULE_SHIPPING_DHLGKAPI_DISPLAY_SERVICES',serialize(array(
    'NoticeOfNonDeliverability', 
    'Personally',
    'NamedPersonOnly', 
    'NoNeighbourDelivery', 
    'Premium', 
    'CashOnDelivery', 
    'AdditionalInsurance', 
    'BulkyGoods',
    'VisualCheckOfAge',
    'IdentCheck',
    'Return',
    'PrintOnlyIfCodeable'
)));

define('MODULE_SHIPPING_DHLGKAPI_RETOURE_PRODUCTS',serialize(array(
    'V01PAK' => '07',
    'V06PAK' => '07',
    'V86PARCEL' => '83',
    'V87PARCEL' => '85'
)));
?>
