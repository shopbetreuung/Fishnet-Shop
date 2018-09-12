<?php
/* --------------------------------------------------------------
      $Id: french.php 3569 2012-08-30 15:39:18Z web28 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(french.php,v 1.99 2003/05/28); www.oscommerce.com
   (c) 2003 nextcommerce (french.php,v 1.24 2003/08/24); www.nextcommerce.org
   (c) 2006 XT-Commerce (french.php)
   Released under the GNU General Public License 
   --------------------------------------------------------------*/

// --- bof -- ipdfbill --------
define('BOX_PDFBILL_CONFIG', 'Configuration de la facture PDF');                 // pdfbill
define('ENTRY_BILLING', 'Numéro de facture :');       // ibillnr      
// --- eof -- ipdfbill --------

// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat6.0 I used 'de_DE'
// on FreeBSD 4.0 I use 'de_DE.ISO_8859-1'
// this may not work under win32 environments..

setlocale(LC_TIME, 'de_DE@euro', 'de_DE', 'de-DE', 'de', 'ge', 'de_DE.ISO_8859-1', 'German','de_DE.ISO_8859-15');
define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('PHP_DATE_TIME_FORMAT', 'd.m.Y H:i:s'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function xtc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" xml:lang="de"');


// page title
define('TITLE', defined('PROJECT_VERSION') ? PROJECT_VERSION : 'undefined');

// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Administration');
define('HEADER_TITLE_SUPPORT_SITE', 'page de support');
define('HEADER_TITLE_ONLINE_CATALOG', 'Catalogue en ligne');
define('HEADER_TITLE_ADMINISTRATION', 'Administration');

// text for gender
define('MALE', 'monsieur');
define('FEMALE', 'madame');

// text for date of birth example
define('DOB_FORMAT_STRING', 'jj.mm.aaaa');

// configuration box text in includes/boxes/configuration.php

define('BOX_HEADING_CONFIGURATION', 'configuration');
define('BOX_HEADING_MODULES', 'module');
define('BOX_HEADING_ZONE', 'pays /impôt-tax');
define('BOX_HEADING_CUSTOMERS', 'clients');
define('BOX_HEADING_PRODUCTS', 'Le catalogue article');
define('BOX_HEADING_STATISTICS', 'Statistiques');
define('BOX_HEADING_TOOLS', 'programmes auxiliaires/Utilitaires');
define('BOX_HEADING_LOCALIZATION', 'Langues / Devises');
define('BOX_HEADING_TEMPLATES','Templates');
define('BOX_HEADING_LOCATION_AND_TAXES', 'Pays / Taxe');
define('BOX_HEADING_CATALOG', 'Catalogue');
define('BOX_MODULE_NEWSLETTER','Bulletin d&apos;information');

define('BOX_CONTENT','Content Manager');
define('BOX_EMAIL','E-Mail Manager');
define('TEXT_ALLOWED', 'permission');
define('TEXT_ACCESS', 'Zones d&apos;accès');
define('BOX_CONFIGURATION', 'Préférences');
define('BOX_CONFIGURATION_1', 'Ma boutique');
define('BOX_CONFIGURATION_2', 'Des valeurs minimales');
define('BOX_CONFIGURATION_3', 'Valeurs maximales');
define('BOX_CONFIGURATION_4', 'Options Image');
define('BOX_CONFIGURATION_5', 'Détails sur le client');
define('BOX_CONFIGURATION_6', 'Options Module');
define('BOX_CONFIGURATION_7', 'Options d&apos;expédition');
define('BOX_CONFIGURATION_8', 'Listes de produits Options');
define('BOX_CONFIGURATION_9', 'Options de gestion des entrepôts');
define('BOX_CONFIGURATION_10', 'Options de journalisation');
define('BOX_CONFIGURATION_11', 'Options de mise en cache');
define('BOX_CONFIGURATION_12', 'Options de courriel');
define('BOX_CONFIGURATION_13', 'Options de téléchargement');
define('BOX_CONFIGURATION_14', 'Compression Gzip');
define('BOX_CONFIGURATION_15', 'Sessions');
define('BOX_CONFIGURATION_16', 'Meta tags / moteurs de recherche');
define('BOX_CONFIGURATION_17', 'Modules complémentaires');
define('BOX_CONFIGURATION_18', 'ID de taxe');
define('BOX_CONFIGURATION_19', 'Partenaires');
define('BOX_CONFIGURATION_22', 'Options de recherche');
define('BOX_CONFIGURATION_24', 'PIWIK &amp; Google Analytics');
define('BOX_CONFIGURATION_25', 'Questions juridiques');
define('BOX_CONFIGURATION_40', 'POptions de la fenêtre contextuelle');
define('BOX_CONFIGURATION_1000', 'Options de la zone d&apos;administration');

define('BOX_CREDITS', 'En savoir plus sur shophelfer');
define('BOX_LOGOUT', 'se désabonner');
define('BOX_TO_SHOP', 'accéder à la boutique');
define('BOX_SEND_FEEDBACK', 'envoyer un retour d&apos;information');
define('BOX_MODULES', 'Modules de paiement, d&apos;expédition et de facturation');
define('BOX_PAYMENT', 'options de paiement');
define('BOX_SHIPPING', 'mode d&apos;expédition');
define('BOX_ORDER_TOTAL', 'récapitulatif de commande');
define('BOX_CATEGORIES', 'Catégories / Produits');
define('BOX_PRODUCTS_CONTENT', 'Contenu du produit');
define('BOX_WASTE_PAPER_BIN', 'poubelle');
define('BOX_PRODUCTS_ATTRIBUTES', 'Création d&apos;attributs');
define('BOX_MANUFACTURERS', 'créateur');
define('BOX_WHOLESALERS', 'Grossistes');
define('BOX_REVIEWS', 'critiques d&apos;articles');
define('BOX_CAMPAIGNS', 'campagnes');
define('BOX_XSELL_PRODUCTS', 'intercommercialisation');
define('BOX_SPECIALS', 'ententes spéciales');
define('BOX_PRODUCTS_EXPECTED', 'futurs articles');
define('BOX_CUSTOMERS', 'mécènes');
define('BOX_ACCOUNTING', 'Gestion des droits d&apos;administration');
define('BOX_CUSTOMERS_STATUS','groupes de clients');
define('BOX_ORDERS', 'ordres d&apos;achat');
define('BOX_COUNTRIES', 'nation');
define('BOX_ZONES', 'États fédéraux');
define('BOX_GEO_ZONES', 'zones fiscales');
define('BOX_TAX_CLASSES', 'catégories fiscales');
define('BOX_TAX_RATES', 'taux de taxation');
define('BOX_HEADING_REPORTS', 'statistiques');
define('BOX_PRODUCTS_VIEWED', 'Produits visités');
define('BOX_STOCK_WARNING','rapport sur les stocks');
define('BOX_PRODUCTS_PURCHASED', 'Produits vendus');
define('BOX_STATS_CUSTOMERS', 'Statistiques des commandes des clients');
define('BOX_BACKUP', 'Gestionnaire de base de données');
define('BOX_BANNER_MANAGER', 'Gestionnaire de bannière');
define('BOX_CACHE', 'Contrôle de l&apos;antémémoire');
define('BOX_DEFINE_LANGUAGE', 'Définir les langues');
define('BOX_FILE_MANAGER', 'Gestionnaire du dossier');
define('BOX_MAIL', 'Envoyer un courriel');
define('BOX_NEWSLETTERS', 'Gestionnaire du bulletin d&apos;information');
define('BOX_SERVER_INFO', 'Informations sur le serveur');
define('BOX_BLZ_UPDATE', 'Mise à jour des codes bancaires');
define('BOX_WHOS_ONLINE', 'Qui est en ligne');
define('BOX_TPL_BOXES','Séquence de boîtes');
define('BOX_CURRENCIES', 'Monnaies');
define('BOX_LANGUAGES', 'Langues');
define('BOX_ORDERS_STATUS', 'Statut de commande');
define('BOX_ATTRIBUTES','Adjuvants');
define('BOX_ATTRIBUTES_MANAGER','Modifier les attributs');
define('BOX_SHIPPING_STATUS','Statut de livraison');
define('BOX_SALES_REPORT','Statistiques du chiffre d&apos;affaires');
define('BOX_MODULE_EXPORT','Module');
define('BOX_HEADING_GV_ADMIN', 'Bons / Coupons');
define('BOX_HEADING_GV', 'Bons');
define('BOX_GV_ADMIN_QUEUE', 'Bons de sortie');
define('BOX_GV_ADMIN_MAIL', 'Envoyer des bons');
define('BOX_GV_ADMIN_SENT', 'bons envoyés');
define('BOX_HEADING_COUPON_ADMIN','Coupons de réduction');
define('BOX_COUPON_ADMIN','Coupons de réduction');
define('BOX_TOOLS_BLACKLIST','liste noire des cartes de crédit');
define('BOX_IMPORT_EXPORT','Importation / Exportation');
define('BOX_IMPORT','Importation / Exportation');
define('BOX_PRODUCTS_VPE','unité de conditionnement');
define('BOX_CAMPAIGNS_REPORT','Rapport de campagne');
define('BOX_ORDERS_XSELL_GROUP','Groupes de marketing croisé');
define('BOX_IMAGESLIDERS','Diaporama d&apos;images'); // Imageslider (c)2008 by Hetfield -www.MerZ-IT-SerVice.de
define('BOX_BLACKLIST_LOGS', 'Registres de la liste noire');
define('BOX_REMOVEOLDPICS','Suppression d&apos;anciennes images'); // Remove old pictures - franky_n - 20110105
define('BOX_JANOLAW','janolaw AGB Hosting'); // Tomcraft - 2011-06-17 - Added janolaw AGB hosting service
define('BOX_HAENDLERBUND','H&auml;ndlerbund AGB Service'); // Tomcraft - 2012-12-08 - Added haendlerbund AGB interface
define('BOX_SAFETERMS','Safeterms - AGB Service'); // Tomcraft - 2013-06-21 - Safeterms AGB interface
define('BOX_IT_RECHT_KANZLEI', 'IT Recht Kanzlei');
define('BOX_LAW','Questions juridiques');
define('BOX_PARCEL_CARRIERS', 'Service de colis');
define('BOX_INVENTORY', 'Inventaire');
define('BOX_INVOICED_ORDERS', 'Factures sortantes');
define('BOX_OUTSTANDING_ORDERS', 'Postes non soldés');
define('BOX_INVENTORY_TURNOVER', 'Taux de rotation des stocks');
define('BOX_STOCK_RANGE', 'Gamme de stockage');
define('BOX_DSGVO_CUSTOMER_EXPORT','Client export RGPD');

define('TXT_GROUPS','<b>regroupements</b>:');
define('TXT_SYSTEM','régime');
define('TXT_CUSTOMERS','Clients / Commandes');
define('TXT_PRODUCTS','Produits / Catégories');
define('TXT_STATISTICS','Outils statistiques');
define('TXT_TOOLS','Programmes complémentaires');
define('TEXT_ACCOUNTING','Paramètres d&apos;accès pour :');

// javascript messages
define('JS_ERROR', 'Des erreurs se sont produites lors de la saisie!\nVeuillez corriger ce qui suit :\n\n');

define('JS_OPTIONS_VALUE_PRICE', '* Vous devez affecter un prix à cette valeur.\n');
define('JS_OPTIONS_VALUE_PRICE_PREFIX', '* Vous devez saisir un signe pour le prix (+/-)\n');

define('JS_PRODUCTS_NAME', '* Le nouvel article doit avoir un nom.\n');
define('JS_PRODUCTS_DESCRIPTION', '* Le nouvel article doit avoir une description.\n');
define('JS_PRODUCTS_PRICE', '* Le nouvel article doit avoir un prix.\n');
define('JS_PRODUCTS_WEIGHT', '* Le nouvel article doit avoir une spécification de poids.\n');
define('JS_PRODUCTS_QUANTITY', '* Vous devez affecter une quantité disponible au nouvel article.\n');
define('JS_PRODUCTS_MODEL', '* Vous devez attribuer un numéro d&apos;article au nouvel article.\n');
define('JS_PRODUCTS_IMAGE', '* Vous devez affecter une image à l&apos;article.\n');

define('JS_SPECIALS_PRODUCTS_PRICE', '* Un nouveau prix doit être fixé pour cet article.\n');

define('JS_GENDER', '* La formule de \'salutation \' doit être choisie.\n');
define('JS_FIRST_NAME', '* Le \'prénom \' doit comporter au moins ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' caractères.\n');
define('JS_LAST_NAME', '* Le \'nom\' doit comporter au moins ' . ENTRY_LAST_NAME_MIN_LENGTH . ' caractères.\n');
define('JS_DOB', '* Le \'Date de naissance\' doit avoir le format suivant: xx.xx.xxxx (Jour/Mois/Année).\n');
define('JS_EMAIL_ADDRESS', '* L&apos; \'adresse e-mail\' doit comporter au moins ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' caractères.\n');
define('JS_ADDRESS', '* La  \'rue\' doit comporter au moins ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' caractères.\n');
define('JS_POST_CODE', '* Le \'code postal\' doit comporter au moins ' . ENTRY_POSTCODE_MIN_LENGTH . ' caractères.\n');
define('JS_CITY', '* La \'ville\' doit comporter au moins ' . ENTRY_CITY_MIN_LENGTH . ' caractères.\n');
define('JS_STATE', '* L&apos; \'État\' doit être sélectionné.\n');
define('JS_STATE_SELECT', '-- Sélectionnez ci-dessus --');
define('JS_ZONE', '* L&apos; \'État\' doit être sélectionné dans la liste pour ce pays.');
define('JS_COUNTRY', '* Le  \'pays\' doit être sélectionné.\n');
define('JS_TELEPHONE', '* Le \'Numéro de téléphone\' doit être composé d&apos;au moins  ' . ENTRY_TELEPHONE_MIN_LENGTH . ' caractères.\n');
define('JS_PASSWORD', '* Le \'Mot de passe\' et le \'Confirmation du mot de passe\' doivent correspondre et se composer d&apos;au moins' . ENTRY_PASSWORD_MIN_LENGTH . ' caractères.\n');

define('JS_ORDER_DOES_NOT_EXIST', 'Le numéro de commande %s n&apos;existe pas !');

define('CATEGORY_PERSONAL', 'Renseignements personnels');
define('CATEGORY_ADDRESS', 'adresse municipale');
define('CATEGORY_CONTACT', 'Contact');
define('CATEGORY_COMPANY', 'entreprise ');
define('CATEGORY_OPTIONS', 'Autres options');

define('ENTRY_GENDER', 'Salutation :');
define('ENTRY_GENDER_ERROR', '&nbsp;<span class="errorText">entrée nécessaire</span>');
define('ENTRY_FIRST_NAME', 'Prénom :');
define('ENTRY_FIRST_NAME_ERROR', '&nbsp;<span class="errorText">au moins ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' lettres</span>');
define('ENTRY_LAST_NAME', 'Nom de famille:');
define('ENTRY_LAST_NAME_ERROR', '&nbsp;<span class="errorText">au moins ' . ENTRY_LAST_NAME_MIN_LENGTH . ' lettres</span>');
define('ENTRY_DATE_OF_BIRTH', 'Date de naissance:');
define('ENTRY_DATE_OF_BIRTH_ERROR', '&nbsp;<span class="errorText">(z.B. 21.05.1970)</span>');
define('ENTRY_EMAIL_ADDRESS', 'Adresse électronique :');
define('ENTRY_EMAIL_ADDRESS_ERROR', '&nbsp;<span class="errorText">au moins ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' lettres</span>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '&nbsp;<span class="errorText">adresse e-mail invalide !</span>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '&nbsp;<span class="errorText">Cette adresse e-mail existe déjà !</span>');
define('ENTRY_COMPANY', 'Nom de l&apos;entreprise ::');
define('ENTRY_STREET_ADDRESS', 'Rue:');
define('ENTRY_STREET_ADDRESS_ERROR', '&nbsp;<span class="errorText">au moins ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' lettres</span>');
define('ENTRY_SUBURB', 'adresse supplémentaire :');
define('ENTRY_POST_CODE', 'Code postal:');
define('ENTRY_POST_CODE_ERROR', '&nbsp;<span class="errorText">au moins ' . ENTRY_POSTCODE_MIN_LENGTH . ' numéros</span>');
define('ENTRY_CITY', 'Stadt:');
define('ENTRY_CITY_ERROR', '&nbsp;<span class="errorText">au moins ' . ENTRY_CITY_MIN_LENGTH . ' lettres</span>');
define('ENTRY_STATE', 'Bundesland:');
define('ENTRY_STATE_ERROR', '&nbsp;<span class="errorText">entrée nécessaire</font></small>');
define('ENTRY_COUNTRY', 'Pays:');
define('ENTRY_TELEPHONE_NUMBER', 'Numéro de téléphone:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '&nbsp;<span class="errorText">au moins ' . ENTRY_TELEPHONE_MIN_LENGTH . ' numéros</span>');
define('ENTRY_FAX_NUMBER', 'Numéro de fax:');
define('ENTRY_NEWSLETTER', 'Bulletin d&apos;information:');
define('ENTRY_CUSTOMERS_STATUS', 'Groupe de clients:');
define('ENTRY_NEWSLETTER_YES', 'abonnée');
define('ENTRY_NEWSLETTER_NO', 'non abonnée');
define('ENTRY_MAIL_ERROR','&nbsp;<span class="errorText">Veuillez faire une sélection</span>');
define('ENTRY_PASSWORD','Mot de passe (créé automatiquement)');
define('ENTRY_PASSWORD_ERROR','&nbsp;<span class="errorText">Votre mot de passe doit comporter au moins ' . ENTRY_PASSWORD_MIN_LENGTH . ' caractères.</span>');
define('ENTRY_MAIL_COMMENTS','Texte de courriel supplémentaire :');

define('ENTRY_MAIL','Envoyer un e-mail avec mot de passe au client ?');
define('YES','oui');
define('NO','non');
define('SAVE_ENTRY','Sauvegarder Modifications?');
define('TEXT_CHOOSE_INFO_TEMPLATE','Gabarit pour les détails du produit');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','Gabarit pour les options de produit');
define('TEXT_SELECT','-- Veuillez choisir --');

// BOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons
// Icons
define('ICON_ARROW_RIGHT','marqué');
define('ICON_BIG_WARNING','Attention !');
define('ICON_CROSS', 'Faux');
define('ICON_CURRENT_FOLDER', 'Dossier courant');
define('ICON_DELETE', 'Supprimer ');
define('ICON_EDIT','Modifier ');
define('ICON_ERROR', 'Erreur');
define('ICON_FILE', 'Fichier');
define('ICON_FILE_DOWNLOAD', 'Télécharger ');
define('ICON_FOLDER', 'Dossier');
define('ICON_LOCKED', 'Bloqué');
define('ICON_POPUP','Aperçu de la bannière');
define('ICON_PREVIOUS_LEVEL', 'Niveau précédent');
define('ICON_PREVIEW', 'Avant-première');
define('ICON_STATISTICS', 'Statistiques');
define('ICON_SUCCESS', 'Succès ');
define('ICON_TICK', 'Vrai ');
define('ICON_UNLOCKED', 'déverrouillé');
define('ICON_WARNING', 'Attention');
// EOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Page %s de %d');
define('TEXT_DISPLAY_NUMBER_OF_BANNERS', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> a)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> Pays)');
define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> clients )');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> monnaies)');
define('TEXT_DISPLAY_NUMBER_OF_LANGUAGES', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> langues)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> fabricants)');
define('TEXT_DISPLAY_NUMBER_OF_WHOLESALERS', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> grossistes)');
define('TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> lettres d&apos;information)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> ordres d&apos;achat)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> statuts des commandes)');
define('TEXT_DISPLAY_NUMBER_OF_XSELL_GROUP', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> Groupes de marketing croisé)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> unités de conditionnement)');
define('TEXT_DISPLAY_NUMBER_OF_SHIPPING_STATUS', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> statuts de livraison)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> produits)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_EXPECTED', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> produits potentiels)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> évaluations)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> offres spéciales)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> catégories fiscales)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> zones fiscales)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> taux de taxation)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', 'Affichés sont <b>%d</b> - <b>%d</b> (sur <b>%d</b> États fédéraux)');

define('PREVNEXT_BUTTON_PREV', '&lt;&lt;');
define('PREVNEXT_BUTTON_NEXT', '&gt;&gt;');

define('TEXT_DEFAULT', 'Standard');
define('TEXT_SET_DEFAULT', 'Définir comme valeur par défaut');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* * Erforderlich</span>');

define('ERROR_NO_DEFAULT_CURRENCY_DEFINED', 'Erreur : Aucune devise par défaut n&apos;a été définie. Veuillez définir une devise par défaut sous Configuration -> Pays/Tax -> Devise');

define('TEXT_CACHE_CATEGORIES', 'Catégories Boîte');
define('TEXT_CACHE_MANUFACTURERS', 'Fabricant Boîte');
define('TEXT_CACHE_ALSO_PURCHASED', 'Également acheté Module');

define('TEXT_NONE', '--aucun--');
define('TEXT_AUTO_PROPORTIONAL', '--auto proportionnel--');
define('TEXT_AUTO_MAX', '--auto max--');
define('TEXT_TOP', 'Top');

define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Erreur : l&apos;emplacement n&apos;existe pas.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Erreur : Impossible d&apos;écrire à l&apos;emplacement.');
define('ERROR_FILE_NOT_SAVED', 'Erreur : Le fichier n&apos;a pas été sauvegardé.');
define('ERROR_FILETYPE_NOT_ALLOWED', 'Erreur : Le type de fichier n&apos;est pas autorisé.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Succès : Le fichier téléchargé a été sauvegardé avec succès.');
define('WARNING_NO_FILE_UPLOADED', 'Attention : Aucun fichier n&apos;a été téléchargé.');

define('DELETE_ENTRY','Supprimer entrée ?');
define('TEXT_PAYMENT_ERROR','<b>ATTENTION:</b> Veuillez activer un module de paiement !');
define('TEXT_SHIPPING_ERROR','<b>ATTENTION:</b> Veuillez activer un module d&apos;expédition !');
define('TEXT_PAYPAL_CONFIG','<b>ATTENTION:</b> Veuillez configurer les paramètres de paiement PayPal pour le "Live Mode" sous : <a href="%s"><strong>Partner -> PayPal<strong></a>'); //DokuMan - 2012-05-31 - show warning if PayPal payment module activated, but not configured for live mode yet

define('TEXT_NETTO','Net: ');

define('ENTRY_CID','Numéro de client:');
define('IP','Commande IP :');
define('CUSTOMERS_MEMO','Mémos:');
define('DISPLAY_MEMOS','afficher / écrire');
define('TITLE_MEMO','Mémo sur le client');
define('ENTRY_LANGUAGE','Langue:');
define('CATEGORIE_NOT_FOUND','Catégorie non disponible');

// BOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons
// Image Icons
define('IMAGE_RELEASE', 'échanger un bon d&apos;achat');
define('IMAGE_ICON_STATUS_GREEN_STOCK','en stock');
define('IMAGE_ICON_STATUS_GREEN','actif ');
define('IMAGE_ICON_STATUS_GREEN_LIGHT','activer');
define('IMAGE_ICON_STATUS_RED','inactif');
define('IMAGE_ICON_STATUS_RED_LIGHT','désactiver');
define('IMAGE_ICON_INFO','choisir');
// EOF - Tomcraft - 2009-06-10 - added some missing alternative text on admin icons

define('_JANUARY', 'Janvier');
define('_FEBRUARY', 'Février');
define('_MARCH', 'Mars');
define('_APRIL', 'Avril');
define('_MAY', 'Mai');
define('_JUNE', 'Juin');
define('_JULY', 'Juillet');
define('_AUGUST', 'Août');
define('_SEPTEMBER', 'Septembre');
define('_OCTOBER', 'Octobre');
define('_NOVEMBER', 'Novembre');
define('_DECEMBER', 'Décembre');

// Beschreibung f&uuml;r Abmeldelink im Newsletter
define('TEXT_NEWSLETTER_REMOVE', 'Pour vous désabonner de notre newsletter, cliquez ici :');

define('TEXT_DISPLAY_NUMBER_OF_GIFT_VOUCHERS', 'Affichés sont <b>%d</b> bis <b>%d</b> (sur <b>%d</b> Bons d&apos;achat)');
define('TEXT_DISPLAY_NUMBER_OF_COUPONS', 'Affichés sont <b>%d</b> bis <b>%d</b> (sur <b>%d</b> Coupons)');
define('TEXT_VALID_PRODUCTS_LIST', 'liste des articles');
define('TEXT_VALID_PRODUCTS_ID', 'ID de l&apos;article');
define('TEXT_VALID_PRODUCTS_NAME', 'nom de l&apos;article');
define('TEXT_VALID_PRODUCTS_MODEL', 'N° d&apos;article');

define('TEXT_VALID_CATEGORIES_LIST', 'liste des catégories');
define('TEXT_VALID_CATEGORIES_ID', 'Catégorie ID');
define('TEXT_VALID_CATEGORIES_NAME', 'nom de catégorie');

define('SECURITY_CODE_LENGTH_TITLE', 'Longueur du code de bon d&apos;achat');
define('SECURITY_CODE_LENGTH_DESC', 'Entrez ici la longueur du code de bon d&apos;achat. (max. 16 caractères)');

define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_TITLE', 'Chèque-cadeau de bienvenue, Valeur');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_DESC', 'Chèque-cadeau de bienvenue, Valeur: Si vous ne voulez pas envoyer un bon d&apos;achat dans votre e-mail de bienvenue, entrez 0 ici, sinon entrez la valeur du bon d&apos;achat, par exemple 10.00 ou 50.00, mais pas de symboles monétaires.');
define('NEW_SIGNUP_DISCOUNT_COUPON_TITLE', 'Code de coupon de réduction de bienvenue');
define('NEW_SIGNUP_DISCOUNT_COUPON_DESC', 'Code de coupon de réduction de bienvenue: Si vous ne voulez pas envoyer un coupon dans votre courriel de bienvenue, laissez ce champ vide, sinon entrez le code du coupon que vous voulez utiliser.');

define('TXT_ALL','Tout');

// UST ID
define('HEADING_TITLE_VAT','N° TVA');
define('ENTRY_VAT_ID','N° TVA:');
define('ENTRY_CUSTOMERS_VAT_ID', 'N° TVA.:');
define('TEXT_VAT_FALSE','<span class="messageStackError">Testé / TVA n&apos;est pas valide !</span>');
define('TEXT_VAT_TRUE','<span class="messageStackSuccess">Testé / TVA est valide !</span>');
define('TEXT_VAT_UNKNOWN_COUNTRY','<span class="messageStackError">Non vérifié / pays inconnu !</span>');
define('TEXT_VAT_INVALID_INPUT','<span class="messageStackError">Non vérifié / Le code de pays transféré n&apos;est pas valide ou la TVA est vide!</span>');
define('TEXT_VAT_SERVICE_UNAVAILABLE','<span class="messageStackError">Non coché / Le service SOAP n&apos;est pas disponible, réessayez plus tard !</span>');
define('TEXT_VAT_MS_UNAVAILABLE','<span class="messageStackError">Non vérifié / Le service de l&apos;état membre n&apos;est pas disponible, réessayez plus tard ou avec un autre état membre !</span>');
define('TEXT_VAT_TIMEOUT','<span class="messageStackError">Non vérifié / Le service de l&apos;état membre n&apos;a pas pu être atteint (timeout), réessayez plus tard ou avec un autre état membre !</span>');
define('TEXT_VAT_SERVER_BUSY','<span class="messageStackError">Non vérifié / Le service ne peut pas traiter votre demande. Réessayez plus tard !</span>');
define('TEXT_VAT_NO_PHP5_SOAP_SUPPORT','<span class="messageStackError">Non coché / le support de PHP5 SOAP n&apos;est pas disponible !</span>');
define('TEXT_VAT_CONNECTION_NOT_POSSIBLE','<span class="messageStackError">ERREUR : La connexion au service web n&apos;est pas possible (ERREUR SOAP) !</span>');

define('ERROR_GIF_MERGE','il manque le support GDlib gif, pas de filigrane (fusion) possible');
define('ERROR_GIF_UPLOAD','Support GDlib Gif manquant, pas de téléchargement d&apos;images GIF possible.');

define('TEXT_REFERER','Référent : ');

// BOF - Tomcraft - 2009-06-17 Google Sitemap
define('BOX_GOOGLE_SITEMAP', 'Google Sitemap');
// EOF - Tomcraft - 2009-06-17 Google Sitemap

// BOF - Tomcraft - 2009-10-03 - Paypal Express Modul
define('BOX_PAYPAL','PayPal');
// EOF - Tomcraft - 2009-10-03 - Paypal Express Modul

// BOF - Dokuman - 2009-10-02 - added moneybookers payment module version 2.4
define('_PAYMENT_MONEYBOOKERS_EMAILID_TITLE','Adresse e-mail de Moneybookers');
define('_PAYMENT_MONEYBOOKERS_EMAILID_DESC','Adresse e-mail avec laquelle vous êtes enregistré sur Moneybookers.com.<br/>Si vous n&apos;avez pas encore de compte, <b>registrez-vous maintenant avec <a href="https://www.moneybookers.com/app/register.pl" target="_blank" rel="noopener"><b>Moneybookers</b>Moneybookers</b></a><b>graduite</b>');
define('_PAYMENT_MONEYBOOKERS_MERCHANTID_TITLE','Moneybookers Merchant  ID');
define('_PAYMENT_MONEYBOOKERS_MERCHANTID_DESC','Votre Moneybookers.com Merchant ID');
define('_PAYMENT_MONEYBOOKERS_PWD_TITLE','Moneybookers Mot de passe');
define('_PAYMENT_MONEYBOOKERS_PWD_DESC','En entrant le mot secret, la connexion est cryptée pendant le processus de paiement. Ceci garantit le plus haut niveau de sécurité. Entrez votre mot de passe Moneybookers (ce n&apos;est pas votre mot de passe !). Le mot secret ne peut être composé que de lettres minuscules et de chiffres. Vous pouvez définir votre mot de passe <b><font color="red">après activation</b></font> dans votre compte Moneybookers (paramètres pays).<br /><br /><font color="red">Pour activer votre compte Moneybookers.com pour le traitement des paiements !</font><br /><br /><br />Envoyer un email avec:<br/>- votre domaine de boutique <br/>- votre adresse email Moneybookers <br /><br />Pour: <a href="mailto:ecommerce@moneybookers.com?subject=Fishnet Shopsoftware : Activation for Moneybookers Quick Checkout">ecommerce@moneybookers.com</a>');
define('_PAYMENT_MONEYBOOKERS_TMP_STATUS_ID_TITLE','Statut de la commande - processus de paiement');
define('_PAYMENT_MONEYBOOKERS_TMP_STATUS_ID_DESC',' Dès que le client appuie sur "Envoyer la commande" dans la boutique, une "commande temporaire" est créée. Ceci a l&apos;avantage qu&apos;une commande a été enregistrée pour les clients qui annulent le processus de paiement chez Moneybookes.');
define('_PAYMENT_MONEYBOOKERS_PROCESSED_STATUS_ID_TITLE','Etat de la commande - Paiement OK');
define('_PAYMENT_MONEYBOOKERS_PROCESSED_STATUS_ID_DESC','Apparaît lorsque le paiement a été confirmé par Moneybookers');
define('_PAYMENT_MONEYBOOKERS_PENDING_STATUS_ID_TITLE','Statut de la commande - paiement en attente');
define('_PAYMENT_MONEYBOOKERS_PENDING_STATUS_ID_DESC','Si le client n&apos;a pas de fonds sur son compte, le paiement restera en suspens jusqu&apos;à ce que le compte Moneybookers soit équilibré.');

define('_PAYMENT_MONEYBOOKERS_CANCELED_STATUS_ID_TITLE','Statut de la commande - Paiement annulé');
define('_PAYMENT_MONEYBOOKERS_CANCELED_STATUS_ID_DESC','S&apos;affichera si, par exemple, une carte de crédit a été refusée.');
define('MB_TEXT_MBDATE', 'Dernière mise à jour :');
define('MB_TEXT_MBTID', 'TR ID:');
define('MB_TEXT_MBERRTXT', 'Status:');
define('MB_ERROR_NO_MERCHANT','Il n&apos;y a pas de compte Moneybookers.com avec cette adresse email !');
define('MB_MERCHANT_OK','Moneybookers.com compte correctement, les commerçants ID %s de Moneybookers.com reçu et enregistré.');
define('MB_INFO','<img src="../images/icons/moneybookers/MBbanner.jpg" /><br> Vous pouvez maintenant accepter les cartes de crédit, les domiciliations, les virements bancaires, Giropay et toutes les autres options de paiement locales importantes directement, avec une simple activation dans la boutique. Avec Moneybookers comme solution tout-en-un, vous n&apos;avez pas besoin de signer des contrats individuels par méthode de paiement. Tout ce dont vous avez besoin est un <a href="https://www.moneybookers.com/app/register.pl" target="_blank" rel="noopener"><b>free Moneybookers Account</b></b></a>pour accepter toutes les principales options de paiement dans votre boutique. Les méthodes de paiement supplémentaires sont gratuites, le module ne comprend <b>aucun coût fixe mensuel ou frais d&apos;installation</b>.<br/><br/><br/><b>Vos avantages:</b><br/>acceptation des options de paiement les plus importantes augmente votre chiffre d&apos;affaires <br/>un fournisseur réduit vos dépenses et vos coûts <br />Votre client paie directement et sans procédure d&apos;enregistrement <br/>activation et intégration <br />très attractif <a href="http://www.moneybookers.com/app/help.pl ?s=m_fees" target="_blank" rel="noopener"><b>conditions</b></b></a> <br/>- confirmation immédiate du paiement et vérification des données clients <br/> traitement des paiements également à l&apos;étranger et sans frais supplémentaires <br/>-6 millions de clients dans le monde entier Moneybookers');
// EOF - Dokuman - 2009-10-02 - added moneybookers payment module version 2.4

// BOF - Tomcraft - 2009-11-02 - set global customers-group-permissions
define('BOX_CUSTOMERS_GROUP','Groupes de clients - Autorisations');
// EOF - Tomcraft - 2009-11-02 - set global customers-group-permissions

// BOF - Tomcraft - 2009-11-02 - New admin top menu
define('TEXT_ADMIN_START', 'Page d&apos;accueil');
define('BOX_HEADING_CONFIGURATION2','Configuration avancée');
// EOF - Tomcraft - 2009-11-02 - New admin top menu

//BOF - web28 - 2010-04-10 - ADMIN SEARCH BAR
define('ASB_QUICK_SEARCH_CUSTOMER','Client : ');
define('ASB_QUICK_SEARCH_ORDER_ID','Numéro de commande: ');
define('ASB_QUICK_SEARCH_ARTICLE','Produit: ');
define('ASB_QUICK_SEARCH_EMAIL', 'Adresse électronique: ');
//EOF - web28 - 2010-04-10 - ADMIN SEARCH BAR

//BOF - web28 - 2010.05.30 - accounting - set all checkboxes , countries - set all flags
define('BUTTON_SET','Activer tous');
define('BUTTON_UNSET','Désactiver tout');
//EOF - web28 - 2010.05.30 - accounting - set all checkboxes 

//BOF - DokuMan - 2010-08-12 - added possibility to reset admin statistics
define('TEXT_ROWS','Ligne');
define('TABLE_HEADING_RESET','Réinitialiser les statistiques');
//EOF - DokuMan - 2010-08-12 - added possibility to reset admin statistics

//BOF - web28 - 2010-11-13 - added BUTTON_CLOSE_WINDOW
define('BUTTON_CLOSE_WINDOW' , 'Fermer la fenêtre');
//EOF - web28 - 2010-11-13 - added BUTTON_CLOSE_WINDOW

//BOF - hendrik - 2011-05-14 - independent invoice number and date
define('ENTRY_INVOICE_NUMBER',  'Numéro de facture:'); 
define('ENTRY_INVOICE_DATE',    'Date de facturation:'); 
//EOF - hendrik - 2011-05-14 - independent invoice number and date  

//BOF - web28 - 2010-07-06 - added missing error text
define('ENTRY_VAT_ERROR', '&nbsp;<span class="errorText">Numéro d&apos;identification TVA incorrect.</span>');
//EOF - web28 - 2010-07-06 - added missing error text

define('CONFIG_INT_VALUE_ERROR', '"%s" ERREUR : Veuillez n&apos;entrer que des chiffres ! L&apos;entrée %s a été ignorée !');
define('CONFIG_MAX_VALUE_WARNING', '"%s" ATTENTION : L&apos;entrée %s a été ignorée ! [Maximum : %s]');
define('CONFIG_MIN_VALUE_WARNING', '"%s" ATTENTION : L&apos;entrée %s a été ignorée ! [Minimum : %s]');

define('WHOS_ONLINE_TIME_LAST_CLICK_INFO', 'Durée d&apos;affichage en s : %s. Passé ce délai, les entrées seront effacées.');

define('LABEL_TRUE', 'Oui');
define('LABEL_FALSE', 'Non');

define ('BOX_BASIC_SETTINGS', 'réglages par défaut');
define ('BOX_SERVER_SETTINGS', 'paramètres du serveur');
define ('BOX_CONFIGURATION_9', 'réglage des roulements');
define ('BOX_SHIPPING_AND_PAYMENT', 'Expédition et paiement');
define ('BOX_MENU_PAYMENT', 'modalités de paiement');
define ('BOX_FRONTEND', 'vue du magasin');
define ('BOX_CONFIGURATION_2', 'Longueurs de champ client');
define ('BOX_MAINTAINANCE', 'entretien');
define ('BOX_SHOP_ON_OFF', 'Boutique en ligne / hors ligne');
define ('BOX_ATTRIBUTES','Attributs');
define ('BOX_IMPORT_EXPORT','Importation / Exportation');
define ('BOX_LAW','Clause de non-responsabilité');
define ('BOX_HEADING_GV', 'Vouchers');

#Menu main items
define ('BOX_MENU_CUSTOMERS', 'clients ');
define ('BOX_MENU_PRODUCTS', 'produits ');
define ('BOX_MENU_CONTENT', 'contenu');
define ('BOX_MENU_MARKETING', 'Marketing & SEO');
define ('BOX_MENU_CONFIGURATION', 'configuration ');

define('TEXT_PAYPAL_TAB_CONFIG', 'PayPal configuration ');
define('TEXT_PAYPAL_TAB_PROFILE', 'PayPal Profil');
define('TEXT_PAYPAL_TAB_WEBHOOK', 'PayPal Webhook');
define('TEXT_PAYPAL_TAB_MODULE', 'PayPal Module');
define('TEXT_PAYPAL_TAB_TRANSACTIONS', 'PayPal transactions ');

define('FEEDBACK_SENT', 'Rétroaction envoyée');
define('TEXT_DISPLAY_NUMBER_OF_DSGVO_EXPORT', 'Affichés sont <b>%d</b> - <b>%d</b> (de <b>%d</b> DSGVOstatus)');
define('CSRF_TOKEN_MANIPULATION', 'manipulation CSRFToken (pour des raisons de sécurité, il n&apos;est plus permis de travailler dans différents onglets de la zone d&apos;administration)');
define('CSRF_TOKEN_NOT_DEFINED', 'CSRFToken non défini (Pour des raisons de sécurité, il n&apos;est plus autorisé à travailler dans des onglets différents dans la zone d&apos;administration.)');
define('BOX_WHITELIST_LOGS', 'Whitelist logs');
?>
