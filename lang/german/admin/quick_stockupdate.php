<?php
/*
  $Id: quick_stock_update.php, v 3.9.3 2014/08/10 14:42:25
  MODIFIED by Günter Geisler / http://www.highlight-pc.de
  RE-WRITTEN by Azrin Aris / http://www.free-fliers.com
  ADAPTED AND STREAMLINED FOR modified Shopsoftware 1.06 by André  R. Kohl / http://www.sixtyseven.info

  Released under the GNU General Public License
*/

define('BOX_CATALOG_QUICK_STOCKUPDATE', 'Quick-Stock-Updater');
define('QUICK_HEAD1', 'Schnelle Lagerverwaltung');
define('QUICK_MODEL', 'Artikelnummer');
define('QUICK_EAN', 'EAN');
define('QUICK_IMAGE', 'Bild');
define('QUICK_ID', 'ID');
define('SORT_ID', 'Sortierung');
define('QUICK_NAME', 'Produktbeschreibung');
define('QUICK_NEW_STOCK', 'Hinzufügen');
define('QUICK_PRICE_NE', 'Preis  (netto)');
define('QUICK_PRICE_VK', 'Preis (brutto)');
define('QUICK_WEIGHT', 'Gewicht (Kg)');
define('QUICK_STOCK', 'Auf Lager');
define('QUICK_STATUS', 'Artikel Status');
define('QUICK_ACTIVE', 'Aktiv');
define('QUICK_INACTIVE', 'Inaktiv');
define('QUICK_TEXT', '<i>(Ein oder mehrere Artikel vorhanden = <font color="#009933"><b>Aktiv</b></font> / 0 oder weniger auf Lager = <font color="#ff0000"><b>Inaktiv</b></font>)</i>');
define('QUICK_UPDATE', 'Update Artikel');
define('QUICK_COPY', 'Zu Kategorie kopieren');
define('QUICK_MOVE', 'Zu Kategorie verschieben');
define('QUICK_DELETE', 'Artikel löschen');
define('QUICK_AUTOSTATUS', 'Auto Status');
define('QUICK_MODIFIED', '');
define('QUICK_CATEGORY','Kategorie');
define('QUICK_MANUFACTURER', 'Hersteller');
define('QUICK_CATEGORY_ID','Kategorie Id : ');
define('QUICK_MANUFACTURER_ID', 'Hersteller Id: ');

define('QUICK_MSG_SUCCESS','Erfolg:');
define('QUICK_MSG_WARNING','Warnung:');
define('QUICK_MSG_ERROR','Fehler:');
define('QUICK_MSG_NOITEMUPDATED','Kein Eintrag wurde geändert.');
define('QUICK_MSG_ITEMSUPDATED','%d Artikel wurden geändert.');
define('QUICK_MSG_UPDATETIME','Update Prozesszeit : %.4f Sekunden');
define('QUICK_MSG_UPDATEERROR','Update der Einträge nicht möglich - Bitte Verzeichnisvariablen und/oder Berechtigungen überprüfen');

// Addditions by sixtyseven
define('QUICK_SEARCH_FOR','Suche nach');
define('QUICK_SELECT_CATEGORY','Kategorie w&auml;hlen');
define('QUICK_SELECT_MANUFACTURER','H&auml;ndler w&auml;hlen');
define('QUICK_SELECT_LANG','Sprache w&auml;hlen');
define('QUICK_UPDATE_BUTTON','Artikel updaten');
define('QUICK_ACTIONBAR_HEADING','Aktion');
define('QUICK_NOTAVAILABLE','Nicht verfügbar');
define('QUICK_SIPPINGTIME', 'Lieferzeit');  