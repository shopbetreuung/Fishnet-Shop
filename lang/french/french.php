<?php
/* -----------------------------------------------------------------------------------------
   $Id: french.php 1308 2005-10-15 14:22:18Z hhgag $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(french.php,v 1.119 2003/05/19); www.oscommerce.com
   (c) 2003 nextcommerce (french.php,v 1.25 2003/08/25); www.nextcommerce.org
   (c) 2006 XT-Commerce
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

/*
 * 
 *  DATE / TIME
 * 
 */
 
// --- bof -- ipdfbill --------
define( 'PDFBILL_DOWNLOAD_INVOICE', 'Facture PDF Download' );   // ipdfbill
// --- eof -- ipdfbill --------


define('TITLE', STORE_NAME);
define('HEADER_TITLE_TOP', 'Page d&apos;accueil');    
define('HEADER_TITLE_CATALOG', 'catalogue');
define('HTML_PARAMS','dir="ltr" lang="fr"');
@setlocale(LC_TIME, 'fr_FR@euro', 'fr_FR', 'fr-FR', 'fr', 'fr', 'fr_FR.ISO_8859-1', 'French','fr_FR.ISO_8859-15');

define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('DOB_FORMAT_STRING', 'tt.mm.jjjj');

function xtc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'EUR');

define('MALE', 'Monsieur');
define('FEMALE', 'Madame');

/*
 * 
 *  BOXES
 * 
 */

// text for gift voucher redeeming
define('IMAGE_REDEEM_GIFT','utiliser votre bon!');

define('BOX_TITLE_STATISTICS','statistiques:');
define('BOX_ENTRY_CUSTOMERS','clients');
define('BOX_ENTRY_PRODUCTS','article');
define('BOX_ENTRY_REVIEWS','estimations');
define('TEXT_VALIDATING','pas confirm&eacute;');

// manufacturer box text
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s page d&apos;accueil');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'autres produits');

define('BOX_HEADING_ADD_PRODUCT_ID','mettre dans le panier');
  
define('BOX_LOGINBOX_STATUS','Groupe clients:');
define('BOX_LOGINBOX_DISCOUNT','Article en promotion');
define('BOX_LOGINBOX_DISCOUNT_TEXT','remise');
define('BOX_LOGINBOX_DISCOUNT_OT','');

// reviews box text in includes/boxes/reviews.php
define('BOX_REVIEWS_WRITE_REVIEW', '&eacute;valuer cet article!');
define('BOX_REVIEWS_NO_WRITE_REVIEW', 'Pas d&apos;&eacute;valuation possible');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s de 5 &eacute;toiles');

// pull down default text
define('PULL_DOWN_DEFAULT', 'veuillez choisir');

// javascript messages
define('JS_ERROR', 'd&apos;importantes informations sont manquantes! veuillez bien renseigner les champs\n\n');

define('JS_REVIEW_TEXT', '* Le texte doit comporter au minimums ' . REVIEW_TEXT_MIN_LENGTH . ' caract&egrave;res.\n\n');
define('JS_REVIEW_RATING', '* veuillez saisir votre &eacute;valuation.\n\n');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* veuillez choisir un mode de paiement pour votre commande.\n');
define('JS_ERROR_SUBMITTED', 'Cette page a d&eacute;j&agrave; &eacute;t&eacute; confirm&eacute;. Cliquez sur OK et attendez la fin du processus');
define('ERROR_NO_PAYMENT_MODULE_SELECTED', '* veuilllez choisir votre mode de paiement pour votre commande.');

/*
 * 
 * ACCOUNT FORMS
 * 
 */

define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER_ERROR', 'veuillez choisir votre allocution.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME_ERROR', 'votre pr&eacute;nom doit comporter au minimum ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' caract&egrave;res.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME_ERROR', 'votre nom doit comporter au minimum ' . ENTRY_LAST_NAME_MIN_LENGTH . ' caract&egrave;res.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'votre date de naissance doit &ecirc;tre saisie dans le format jj.mm.aaaa (ex: 21.05.1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', ' (pe. 21.05.1970)');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'votre adresse email doit comporter au minimum ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' caract&egrave;res.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'votre adresse email est incorrecte, veuillez la v&eacute;rifier.');
define('ENTRY_EMAIL_ERROR_NOT_MATCHING', 'Vos adresses e-mail ne correspondent pas.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'votre adress email existe d&eacute;j&agrave;, veuillez la v&eacute;rifier.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS_ERROR', 'Rue/no. doit avoir des ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' caract&egrave;res minimum. Un num&eacute;ro de la maison est obligatoire. Si vous n&apos;avez pas de numéro de maison, s&apos;il vous pla&icirc;t entrer un 0 (z&eacute;ro) ');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE_ERROR', 'votre code postal doit comporter au minimum ' . ENTRY_POSTCODE_MIN_LENGTH . ' caract&egrave;res.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY_ERROR', 'la ville doit comporter au minimum ' . ENTRY_CITY_MIN_LENGTH . ' caract&egrave;res.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE_ERROR', 'votre r&eacute;gion doit comporter au minimum ' . ENTRY_STATE_MIN_LENGTH . ' caract&egrave;res.');
define('ENTRY_STATE_ERROR_SELECT', 'veuillez choisir une r&eacute;gion de cette liste.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY_ERROR', 'veuillez choisir un pays de cette liste.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'votre num&eacute;ro de t&eacute;l&eacute;phone soit comporter au minimum ' . ENTRY_TELEPHONE_MIN_LENGTH . ' caract&egrave;res.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_PASSWORD_ERROR', 'votre mot de passe doit comporter au minimum ' . ENTRY_PASSWORD_MIN_LENGTH . ' caract&egrave;res.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Vos mots de passe ne correspondent pas');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'votre mot de passe doit comporter au minimum ' . ENTRY_PASSWORD_MIN_LENGTH . ' caract&egrave;res.');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'votre nouveau mot de passe doit comporter au minimum ' . ENTRY_PASSWORD_MIN_LENGTH . ' caract&egrave;res.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Vos mots de passe ne correspondent pas.');
define('ENTRY_PASSWORD_NOT_COMPILANT', 'Votre mot de passe doit comporter au moins une lettre et au moins un chiffre.');


/*
 * 
 *  RESULT PAGES
 * 
 */
 
define('TEXT_RESULT_PAGE', 'Pages:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'afficher de <b>%d</b> &agrave; <b>%d</b> (sur un total de <b>%d</b> articles)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'afficher de <b>%d</b> &agrave; <b>%d</b> (sur un total de <b>%d</b> commandes)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'afficher de <b>%d</b> &agrave; <b>%d</b> (sur un total de <b>%d</b> commandes)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'afficher de <b>%d</b> &agrave; <b>%d</b> (sur un total de <b>%d</b> nouveaux produits)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'afficher de <b>%d</b> &agrave; <b>%d</b> (sur un total de <b>%d</b> promotions)');

/*
 * 
 * SITE NAVIGATION
 * 
 */

define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'page pr&eacute;c&eacute;dente');
define('PREVNEXT_TITLE_NEXT_PAGE', 'page suivante');
define('PREVNEXT_TITLE_PAGE_NO', 'page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', '%d page prec&eacute;dente');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', '%d page suivante');

/*
 * 
 * PRODUCT NAVIGATION
 * 
 */

define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;&nbsp;pr&eacute;c&eacute;dent]');
define('PREVNEXT_BUTTON_NEXT', '[Suivant&gt;&gt;]');

/*
 * 
 * IMAGE BUTTONS
 * 
 */

define('IMAGE_BUTTON_ADD_ADDRESS', 'nouvelle adresse');
define('IMAGE_BUTTON_BACK', 'retour');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'changement d&apos;adresse');
define('IMAGE_BUTTON_CHECKOUT', 'Caisse');
define('IMAGE_BUTTON_CONFIRM', 'confirmer'); // Needed for PayPal
define('IMAGE_BUTTON_CONFIRM_ORDER', 'veuillez confirmer la commande');
define('IMAGE_BUTTON_CONTINUE', 'continuer');
define('IMAGE_BUTTON_DELETE', 'annuler');
define('IMAGE_BUTTON_LOGIN', 'se connecter');
define('IMAGE_BUTTON_LOGIN_NEWSLETTER', 'Abonnez-vous ');
define('IMAGE_BUTTON_UNSUBSCRIBE_NEWSLETTER', 'Se d&eacute;sabonner');
define('IMAGE_BUTTON_IN_CART', 'dans le panier');
define('IMAGE_BUTTON_SEARCH', 'chercher');
define('IMAGE_BUTTON_UPDATE', 'recharger');
define('IMAGE_BUTTON_UPDATE_CART', 'recharger le panier');
define('IMAGE_BUTTON_WRITE_REVIEW', '&eacute;crire une &eacute;valuation');
define('IMAGE_BUTTON_ADMIN', 'Admin'); 
define('IMAGE_BUTTON_PRODUCT_EDIT', 'editer le produit');


define('IMAGE_BUTTON_PRODUCT_MORE', 'Details');
// BOF - vr - 2010-02-20 removed double definition 
// define('IMAGE_BUTTON_LOGIN', 'Anmelden');
// EOF - vr - 2010-02-20 removed double definition 
define('IMAGE_BUTTON_SEND', 'Envoyer'); //DokuMan - 2010-03-15 - Added button description for contact form
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Continuer les achats'); //Hendrik - 2010-11-12 - used in default template ...shopping_cart.html
define('IMAGE_BUTTON_CHECKOUT_START_PAGE', 'Page d&apos;accueil');

define('SMALL_IMAGE_BUTTON_DELETE', 'annuler');
define('SMALL_IMAGE_BUTTON_EDIT', 'changer');
define('SMALL_IMAGE_BUTTON_VIEW', 'afficher');

define('ICON_ARROW_RIGHT', 'montrer plus');
define('ICON_CART', 'dans le panier');
define('ICON_SUCCESS', 'succ&egrave;s');
define('ICON_WARNING', 'attention');
define('ICON_ERROR', 'Erreur ');

define('TEXT_PRINT', 'imprimer'); //DokuMan - 2009-05-26 - Added description for 'account_history_info.php'


/*
 * 
 *  GREETINGS
 * 
 */

define('TEXT_GREETING_PERSONAL', 'Heureux de vous revoir, <span class="greetUser">%s!</span> Souhaitez vous voir nos <a style="text-decoration:underline;" href="%s">nouveaux articles</a>?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Si vous n&apos;&ecirc;tes pas %s , veuillez vous identifier<a style="text-decoration:underline;" href="%s">ici</a> avec votre nom</small>');
define('TEXT_GREETING_GUEST', 'Bienvenue <span class="greetUser">client</span>. Souhaitez vous <a style="text-decoration:underline;" href="%s"> vous connecter</a>? ou bien souhaitez vous <a style="text-decoration:underline;" href="%s">ouvrir</a> un compte?');

define('TEXT_SORT_PRODUCTS', 'le calssement de l&apos;article est ');
define('TEXT_DESCENDINGLY', 'en descendant');
define('TEXT_ASCENDINGLY', 'en montant');
define('TEXT_BY', ' vers ');
define('TEXT_OF_5_STARS', '%s de 5 étoiles!');
define('TEXT_REVIEW_BY', 'de %s');
define('TEXT_REVIEW_WORD_COUNT', '%s mots');
define('TEXT_REVIEW_RATING', '&eacute;valuation: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'rajouter &agrave;: %s');
define('TEXT_NO_REVIEWS', 'Il n&apos;existe pas encore d &eacute;valuation.');
define('TEXT_NO_NEW_PRODUCTS', 'pour le moment, il n&apos;existe pas de nouveaux articles.');
define('TEXT_UNKNOWN_TAX_RATE', 'Taux d&apos;imposition inconnu');

/*
 * 
 * WARNINGS
 * 
 */

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Attention : Le r&eacute;pertoire d&apos;installation existe toujours sur %s. Veuillez effacer le r&eacute;pertoire pour des raisons de s&eacute;curit&eacute; !');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Attention : Le logiciel de boutique peut &eacute;crire dans le fichier de configuration: %s. Ceci repr&eacute;sente un risque possible pour la s&eacute;curit&eacute; - veuillez corriger les permissions d&apos;utilisateur pour ce fichier !');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Attention : Le r&eacute;pertoire des sessions n&apos;existe pas ' . xtc_session_save_path() . '. Les sessions ne fonctionneront pas tant que le r&eacute;pertoire n&apos;est pas cr&eacute;&eacute; !');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Attention: Le logiciel de boutique ne peut pas &eacute;crire dans le r&eacute;pertoire Sessions: ' . xtc_session_save_path() . '. Les sessions ne fonctionneront pas tant que les permissions d&apos;utilisateur correctes n&apos;auront pas &eacute;t&eacute; d&eacute;finies !');
define('WARNING_SESSION_AUTO_START', 'Attention: session.auto_start est activ&eacute;- Veuillez d&apos;sactiver cette fonction PHP dans php.ini et red&eacute;marrer le serveur web !');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Attention: Le r&eacute;pertoire de t&eacute;l&eacute;chargement des articles n&apos;existe pas :: ' . DIR_FS_DOWNLOAD . '. Cette fonction ne fonctionnera pas tant que le r&eacute;pertoire n&apos;est pas cr&eacute;&eacute; !');

define('SUCCESS_ACCOUNT_UPDATED', 'Votre compte a &eacute;t&eacute; actualis&eacute; avec succ&egrave;s.');
define('SUCCESS_PASSWORD_UPDATED', 'Votre mot de passe a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s!');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'Le mot de passe que vous venez de saisir ne correspond pas avec votre mot de passe enregistr&eacute;. Veuillez r&eacute;ssayer.');
define('TEXT_MAXIMUM_ENTRIES', 'Remarque: vous disposez de %s donn&eacute;es dans votre carnet d&apos;adresse!');
define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', 'Votre demande a &eacute;t&eacute; annuler avec succ&egrave;s.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', 'Votre carnet d&apos;adresse a &eacute;t&eacute; actualis&eacute; avec succ&egrave;s!');
define('WARNING_PRIMARY_ADDRESS_DELETION', 'L&apos;adresse standard ne peux &ecirc;tre annul&eacute;e. Veuillez d&eacute;finir une autre adresse standard au pr&eacute;alable. Ensuite l&apos;ancienne pourra &ecirc;tre annul&eacute;.');
define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', 'Cette inscription dans le carnet d&apos;adresse n&apos;est pas disponible.');
define('ERROR_ADDRESS_BOOK_FULL', 'Votre carnet d&apos;adresses ne peut contenir plus d&apos;adresses. Veuillez annuler une adresse que vous n&apos;utilisez plus. Ensuite vous pourrez en enregistrer une nouvelle.');
define('ERROR_CHECKOUT_SHIPPING_NO_METHOD', 'Aucun type d&apos;exp&eacute;dition n&apos;a &eacute;t&eacute; s&eacute;lectionn&eacute;.');
define('ERROR_CHECKOUT_SHIPPING_NO_MODULE', 'Il n&apos;y a pas de type d&apos;exp&eacute;dition.');

//  conditions check

define('ERROR_CONDITIONS_NOT_ACCEPTED', '* tant que vous n&apos;acceptez pas nos conditions g&eacute;n&eacute;rale de vente, nous ne pourrons traiter votre commande!\n\n');
define('ERROR_AGREE_DOWNLOAD_NOT_ACCEPTED', '* Si vous ne sp&eacute;cifiez pas le d&eacute;but souhait&eacute; de l&apos;ex&eacute;cution du contrat dans les t&eacute;l&eacute;chargements, \n Malheureusement, nous ne sommes pas en mesure d&apos;accepter votre commande !!\n\n');

define('SUB_TITLE_OT_DISCOUNT','remise:');

define('TAX_ADD_TAX','incl. ');
define('TAX_NO_TAX','en sus ');

define('NOT_ALLOWED_TO_SEE_PRICES','vous ne pouvez pas conculter nos prix en tant que visiteur (tout du moins avec votre statut actuel');
define('NOT_ALLOWED_TO_SEE_PRICES_TEXT','Vous n&apos;avez pas la possiblit&eacute; de consulter nos prix. Veuillez ouvrir un compte client.');

define('TEXT_DOWNLOAD','t&eacute;l&eacute;charger');
define('TEXT_VIEW','Afficher');

define('TEXT_BUY', '1 x \'');
define('TEXT_NOW', '\' Commander');
define('TEXT_GUEST','Invit&eacute;');
define('TEXT_SEARCH_ENGINE_AGENT','moteur de recherche');

/*
 * 
 * ADVANCED SEARCH
 * 
 */

define('TEXT_ALL_CATEGORIES', 'toutes cat&eacute;gories');
define('TEXT_ALL_MANUFACTURERS', 'Tous les producteur');
define('JS_AT_LEAST_ONE_INPUT', '* Un de ces champs doit &ecirc;tre renseign&eacute;:\n   mots clefs\n    prix &agrave; partir de\n      prix jusqu&apos;&agrave;\n' );
define('AT_LEAST_ONE_INPUT', 'Un de ces champs doit &ecirc;tre renseign&eacute;:, <br />mots clefs avec au minimum trois caract&egrave;res<br  />prix &agrave; partir de<br  />prix jusqu &agrave;<br />');
define('TEXT_SEARCH_TERM','Votre recherche pour: ');
define('JS_INVALID_FROM_DATE', '* date erron&eacute;e (de)\n');
define('JS_INVALID_TO_DATE', '* date erron&eacute;e (&agrave;)\n');
define('JS_TO_DATE_LESS_THAN_FROM_DATE', '* la date (de) doit &ecirc;tre plus importante ou &eacute;gale &agrave; la date (jusqu&apos;&agrave;)\n');
define('JS_PRICE_FROM_MUST_BE_NUM', '* \"Prix &agrave; partir de, \" doit &ecirc;tre un chiffre\n\n');
define('JS_PRICE_TO_MUST_BE_NUM', '* \"Prix jusqu &agrave;, \" doit &ecirc;tre un chiffre\n\n');
define('JS_PRICE_TO_LESS_THAN_PRICE_FROM', '* le prix doit &ecirc;tre plus important  ou &eacute;gal au prix jusqu&apos;&agrave;.\n');
define('JS_INVALID_KEYWORDS', '* Mot clef non reconnu\n');
define('TEXT_LOGIN_ERROR', '<font color="#ff0000"><b>Erreur:,  </b></font> Vos \'adresses mail, \' et/ou le \'mot de passe\'ne correspondent pas.' );
define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<font color="#ff0000"><b>ACHTUNG:, Attention: </b></font> l&apos;adresse email renseign&eacute;e n&apos;est pas registr&eacute;e . Veuillez r&eacute;essayer.');
define('TEXT_LOGIN_ERROR_NO_CAPTCHA', '<font color="#ff0000"><strong>ERREUR:</strong></font> reCaptcha vérification a échoué, veuillez réessayer.');
define('TEXT_PASSWORD_SENT', 'un nouveau mot de passe vous a &eacute;t&eacute; envoy&eacute; par mail.');
define('TEXT_PRODUCT_NOT_FOUND', 'article non trouv&eacute;!');
define('TEXT_MORE_INFORMATION', 'veuillez visiter,  <a style="text-decoration:underline;" href="%s" onclick="window.open(this.href); return false;">le page</a> de cet article.');
define('TEXT_DATE_ADDED', 'Nous avons ajout&eacute; cette article dans notre catalogue le %s.');
define('TEXT_DATE_AVAILABLE', '<font color="#ff0000">Cet article sera de nouveau disponible le %s.</font>');
define('SUB_TITLE_SUB_TOTAL', 'Sous total:');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'Les articles marqu&eacute;s ,' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' ne sont malheureusement pas disponibles dans la quantit&eacute; souhait&eacute;e., <br />veuillez r&eacute;duire votre quantit&eacute; command&eacute;e sur les articles d&eacute;sign&eacute;s. Merci');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'Les articles marqu&eacute;s, ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' ne sont malheureusement pas disponibles dans la quantit&eacute; souhait&eacute;e, .<br />La quantit&eacute; command&eacute;e vous sera livr&eacute; prochainement, si vous le souhaitez, nous pouvons effectuer une livraison partielle.');

define('MINIMUM_ORDER_VALUE_NOT_REACHED_1', 'Vous n&apos;avez pas encore atteint, votre valeur minumum de commande qui est de: ');
define('MINIMUM_ORDER_VALUE_NOT_REACHED_2', ' Veuilllez commander pour plus de ');
define('MAXIMUM_ORDER_VALUE_REACHED_1', 'Vous avez d&eacute;pass&eacute; la valeur maximum de commande de: ');
define('MAXIMUM_ORDER_VALUE_REACHED_2', '<br /> veuillez r&eacute;duire votre commande au minimum de:  ');

define('ERROR_INVALID_PRODUCT', 'L&apos;article choisi n&apos;a pas &eacute;t&eacute; trouv&eacute;!');

/*
 * 
 * NAVBAR TITLE
 * 
 */

define('NAVBAR_TITLE_ACCOUNT', 'votre compte');
define('NAVBAR_TITLE_1_ACCOUNT_EDIT', 'votre comte');
define('NAVBAR_TITLE_2_ACCOUNT_EDIT', 'vos donn&eacute;es personnelles');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY', 'votre compte');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY', 'vos commandes en cours');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO', 'votre compte');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO', 'commandes en cours');
define('NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO', 'num&eacute;ro de commande %s');
define('NAVBAR_TITLE_1_ACCOUNT_PASSWORD', 'votre compte');
define('NAVBAR_TITLE_2_ACCOUNT_PASSWORD', 'modifiez votre mot de passe');
define('NAVBAR_TITLE_1_ADDRESS_BOOK', 'votre compte');
define('NAVBAR_TITLE_2_ADDRESS_BOOK', 'carnet d&apos;adresses');
define('NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS', 'votre compte');
define('NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS', 'carnet d&apos;adresses');
define('NAVBAR_TITLE_ADD_ENTRY_ADDRESS_BOOK_PROCESS', 'nouvelle entr&eacute;e');
define('NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS', 'entr&eacute;e modifi&eacute;e');
define('NAVBAR_TITLE_DELETE_ENTRY_ADDRESS_BOOK_PROCESS', 'entr&eacute;e annul&eacute;e');
define('NAVBAR_TITLE_ADVANCED_SEARCH', 'recherche avanc&eacute;e');
define('NAVBAR_TITLE1_ADVANCED_SEARCH', 'recherche avanc&eacute;e');
define('NAVBAR_TITLE2_ADVANCED_SEARCH', 'r&eacute;sultat de la recherche');
define('NAVBAR_TITLE_1_CHECKOUT_AGREE_DOWNLOAD', 'caisse');
define('NAVBAR_TITLE_2_CHECKOUT_AGREE_DOWNLOAD', 'Contenu digital');
define('NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION', 'paiement');
define('NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION', 'confirmation');
define('NAVBAR_TITLE_1_CHECKOUT_PAYMENT', 'paiement');
define('NAVBAR_TITLE_2_CHECKOUT_PAYMENT', 'mode de paiement');
define('NAVBAR_TITLE_1_PAYMENT_ADDRESS', 'paiement');
define('NAVBAR_TITLE_2_PAYMENT_ADDRESS', 'modifiez votre adresse de facturation');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING', 'paiement');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING', 'Informations d&apos;envoi');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING_ADDRESS', 'paiement');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING_ADDRESS', 'mofifiez votre adresse de livraison');
define('NAVBAR_TITLE_1_CHECKOUT_SUCCESS', 'paiement');
define('NAVBAR_TITLE_2_CHECKOUT_SUCCESS', 'succ&egrave;s');
define('NAVBAR_TITLE_CREATE_ACCOUNT', 'cr&eacute;ation d&apos;un compte');
if (isset($navigation) && $navigation->snapshot['page'] == FILENAME_CHECKOUT_SHIPPING) {
  define('NAVBAR_TITLE_LOGIN', 'commander');
} else {
  define('NAVBAR_TITLE_LOGIN', 'se connecter');
}
define('NAVBAR_TITLE_LOGOFF','Au revoir');
define('NAVBAR_TITLE_PRODUCTS_NEW', 'nouvel article');
define('NAVBAR_TITLE_SHOPPING_CART', 'panier');

define('NAVBAR_TITLE_SPECIALS', 'offres');
define('NAVBAR_TITLE_COOKIE_USAGE', 'Utilisation des cookies');
define('NAVBAR_TITLE_PRODUCT_REVIEWS', '&eacute;valuations');
define('NAVBAR_TITLE_REVIEWS_WRITE', '&eacute;valuations');
define('NAVBAR_TITLE_REVIEWS','&eacute;valuations');
define('NAVBAR_TITLE_SSL_CHECK', 'conseil de s&eacute;curit&eacute;s');
define('NAVBAR_TITLE_CREATE_GUEST_ACCOUNT','cr&eacute;ation d un compte');
define('NAVBAR_TITLE_PASSWORD_DOUBLE_OPT','mot de passe oubli&eacute;?');
define('NAVBAR_TITLE_NEWSLETTER','lettre d&apos;information');
define('NAVBAR_GV_REDEEM', 'utiliser votre bon');
define('NAVBAR_GV_SEND', 'envoyer le bon');

/*
 * 
 *  MISC
 * 
 */

define('TEXT_NEWSLETTER','vous souhaitez toujours rester inform&eacute;?, <br />Pas de probl&egrave;me. Inscriver vous &agrave; notre newsletter et vous serez toujours au courrant de notre actualit&eacute; ');
define('TEXT_EMAIL_INPUT','Votre adresse email a &eacute;t&eacute; saisie dans notre syst&egrave;me.<br />Par la m&ecirc;me occasion un email vous a &eacute;t&eacute; envoy&eacute; avec un lien pour activer. Veuillez cliquez sur ce lien d&egrave;s r&eacute;ception afin de confirmer votre adh&eacute;sion. Sinon, vous ne recevrez pas de newsletter');

define('TEXT_WRONG_CODE','<font color="FF0000">Votre code secret ne correspond pas......Veuillez r&eacute;essayer</font>');
define('TEXT_EMAIL_EXIST_NO_NEWSLETTER','<font color="008000">Cette adresse email existe d&eacute;j&agrave; dans notre base de donn&eacute;es, mais l&apos;aurorisation pour recevoir les newsletter n&apos;est pas encore confirm&eacute;e!</font>');
define('TEXT_EMAIL_EXIST_NEWSLETTER','<font color="FF0000">Cette adresse email existe d&eacute;j&agrave; dans notre base de donn&eacute;es et l&apos;autorisation pour recevoir des newsletters est confirm&eacute;e!</font>');
define('TEXT_EMAIL_NOT_EXIST','<font color="FF0000">cet email ne existe pa dans notre base de donn&eacute;es</font>');
define('TEXT_EMAIL_DEL','votre adresse email a &eacute;t&eacute; effac&eacute; de notre base de donn&eacute;es de Newsletter');
define('TEXT_EMAIL_DEL_ERROR','<font color="FF0000">une erreur est survenue, votre adresse email n a pas &eacute;t&eacute; effac&eacute;e</font>');
define('TEXT_EMAIL_ACTIVE','<font color="008000">Votre adresse email a &eacute;t&eacute; confirm&eacute; avec succ&egrave;s pour recevoir les newsletter!</font>');
define('TEXT_EMAIL_ACTIVE_ERROR','<font color="FF0000">une erreur est survenur, votre adresse email n a pas &eacute;t&eacute; dispos&eacute;e librement</font>');
define('TEXT_EMAIL_SUBJECT','votre adh&eacute;sion &agrave; la newsletter');

define('TEXT_CUSTOMER_GUEST','invit&eacute;');

define('TEXT_LINK_MAIL_SENDED','Vous devez d&apos;abord confirmer votre demande de nouveau mot de passe. Par conséquent, le système vous a envoyé un e-mail avec un lien de confirmation. Veuillez cliquer sur le lien après avoir reçu le courriel. Sinon, vous ne pouvez pas attribuer un nouveau mot de passe ! <br /><br /><br /><br /> Le lien de confirmation est valide pendant %s secondes.');
define('TEXT_PASSWORD_MAIL_SENDED','Un email avec votre noueau mot de passe pous a &eacute;t&eacute; envoy&eacute;.<br />Veuillez modifier votre mot de passe comme souhait&eacute; lors de votre prochaine connexion');
define('TEXT_CODE_ERROR','Veuiller de nouveau saisir votre adresse email et votre code secret <br />Veuillez faire attention aux fautes de frappe');
define('TEXT_EMAIL_ERROR','L&apos;adresse e-mail n&apos;est pas enregistrée dans notre boutique.<br/> Veuillez réessayer.');
define('TEXT_REQUEST_NOT_VALID', 'Ce lien n&apos;est pas valide. Veuillez demander un nouveau mot de passe.');
define('TEXT_RECAPTCHA_ERROR','reCaptcha check a échoué, veuillez réessayer.');
define('TEXT_NO_ACCOUNT','Melheureusement nous vous signalons que votre demande de changement de mot de passe est soit invalide ou bien est expir&eacute;e.<br />Veuillez &eacute;ssayer de nouveau.');
define('HEADING_PASSWORD_FORGOTTEN','Vous souhaitez modifier votre mot de passe?');
define('TEXT_PASSWORD_FORGOTTEN','Modifier votre mot de passe en trois &eacute;tapes simples.');
define('TEXT_EMAIL_PASSWORD_FORGOTTEN','Email de confirmation pour votre changement de mot de passe');
define('TEXT_EMAIL_PASSWORD_NEW_PASSWORD','votre nouveau mot de passe');
define('ERROR_MAIL','veuillez v&eacute;rifier vos donn&eacute;es dans ce formulaire');

define('CATEGORIE_NOT_FOUND','la cat&eacute;gorie n&apos;a pas &eacute;t&eacute; trouv&eacute;e');

define('GV_FAQ', 'bon FAQ');
define('ERROR_NO_REDEEM_CODE', 'Vous n&apos;avez malheureusement pas entr&eacute; de code.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Mauvais code pour le bon');
define('TABLE_HEADING_CREDIT', 'Avoir');
define('EMAIL_GV_TEXT_SUBJECT', 'un cadeau de %s ');
define('MAIN_MESSAGE', 'Vous avez souhait&eacute; envoyer un avoir d&apos;un montant de %s &agrave; %s dont l&apos;adresse email est %s.<br /><br />Le texte suivant apparait dans votre email:<br /><br />Hallo %s<br /><br />On voua a envoy&eacute; un avoir d un montant de %s durch %s geschickt.');
define('REDEEMED_AMOUNT','votre avoir vous a &eacute;t&eacute; cr&eacute;dit&eacute; avec succ&egrave;s. Valeur de l&apos;avoir:');
define('REDEEMED_COUPON','votre coupon a &eacute;t&eacute; comptabilis&eacute; avec succ&egrave;s et vous sera automatiquement d&eacute;duit lors de votre prochain achat.');

define('ERROR_INVALID_USES_USER_COUPON','Avec votre coupon, vous pouvez seulement');
define('ERROR_INVALID_USES_COUPON','Avec ce coupon, les clients peuvent seulement');
define('TIMES',' mal einl&ouml;sen.');
define('ERROR_INVALID_STARTDATE_COUPON','Votre coupon n&apos;est pas encore disponible.');
define('ERROR_INVALID_FINISDATE_COUPON','Votre coupon est d&eacute;j&agrave; &eacute;coul&eacute;.');
define('PERSONAL_MESSAGE', '%s &eacute;crit:');

//Popup Window
// BOF - DokuMan - 2010-02-25 removed double definition 
//define('TEXT_CLOSE_WINDOW', 'Fermer la fen&ecirc;tre.');
// EOF - DokuMan - 2010-02-25 removed double definition 

/*
 * 
 *  COUPON POPUP
 * 
 */
 
define('TEXT_CLOSE_WINDOW', 'Fermer la fen&ecirc;tre [x]');
define('TEXT_COUPON_HELP_HEADER', 'Votre avoir a &eacute;t&eacute; comptabilis&eacute; avec succ&egrave;s.');
define('TEXT_COUPON_HELP_NAME', '<br /><br />D&eacute;signation de votre avoir: %s');
define('TEXT_COUPON_HELP_FIXED', '<br /><br />Votre avoir est d&apos;un montant de: %s ');
define('TEXT_COUPON_HELP_MINORDER', '<br /><br />Le minimum de commande este de: %s ');
define('TEXT_COUPON_HELP_FREESHIP', '<br /><br />Bon pour des frais de port gratuits');
define('TEXT_COUPON_HELP_DESC', '<br /><br />D&eacute;signation du coupon: %s');
define('TEXT_COUPON_HELP_DATE', '<br /><br />ce coupon est valable du %s au %s');
define('TEXT_COUPON_HELP_RESTRICT', '<br /><br />article /cat&eacute;gorie: limit&eacute;s');
define('TEXT_COUPON_HELP_CATEGORIES', 'cat&eacute;gorie');
define('TEXT_COUPON_HELP_PRODUCTS', 'article');

//BOF - DokuMan - 2010-10-28 - Added text-constant for emailing voucher
define('ERROR_ENTRY_AMOUNT_CHECK', 'Montant du bon invalide');
define('ERROR_ENTRY_EMAIL_ADDRESS_CHECK', 'Adresse e-mail valide');
//EOF - DokuMan - 2010-10-28 - Added text-constant for emailing voucher

// VAT ID
define('ENTRY_VAT_TEXT', 'Seulement n&eacute;cessaire pour l&apos;Allemagne et l&apos;UE !');
define('ENTRY_VAT_ERROR', 'Votre num&eacute;ro d&rsquo;identification n&rsquo;est pas valable ou ne peut &ecirc;tre v&eacute;rifi&eacute; pour le moment. Veuillez renseigner avec le bon num&eacute;ro d&rsquo;identification ou laisser le champs libre.');
define('MSRP','UVP');
define('YOUR_PRICE','Votre prix ');
// BOF - Tomcraft - 2009-10-09 - Added text-constant for unit price
define('UNIT_PRICE','prix unitaire');
// EOF - Tomcraft - 2009-10-09 - Added text-constant for unit price
define('ONLY',' seulement ');
define('FROM','&agrave; partir de');
define('YOU_SAVE','vous &eacute;conomisez ');
define('INSTEAD','au lieu de ');
define('TXT_PER',' par ');
define('TAX_INFO_INCL','incl. %s TVA');
define('TAX_INFO_EXCL','excl. %s TVA');
define('TAX_INFO_ADD','TVA %s en sus');
define('SHIPPING_EXCL','excl.');
define('SHIPPING_COSTS','frais de transport');


// changes 3.0.4 SP2
define('SHIPPING_TIME','d&eacute;lai de livraison: ');
define('MORE_INFO','[plus]');
define('READ_INFO','[lire]');

// Privacy Stuff
define('ENTRY_PRIVACY_ERROR','S&acute;il vous pla&icirc;t acceptez notre politique de confidentialit&eacute;!');
define('COOKIE_NOTE_TEXT', 'En visitant notre site Web, vous acceptez l&apos;utilisation de cookies. De cette fa&ccedil;on, nous pouvons encore am&eacute;liorer le service pour vous.');
define('COOKIE_NOTE_MORE_TEXT', 'Plus d&apos;infos');
define('COOKIE_NOTE_DISMISS_TEXT', 'Compris');

define('TEXT_PAYMENT_FEE','Frais de m&eacute;thodes de paiement');

define('_MODULE_INVALID_SHIPPING_ZONE', 'Livraison dans ce pays n&acute;est pas possible');
define('_MODULE_UNDEFINED_SHIPPING_RATE', 'Le taux d&acute;exp&eacute;dition ne peut pas &ecirc;tre calcul&eacute;e &agrave; l&acute;instant');

//Dokuman - 2009-08-21 - Added 'delete account' functionality for customers
define('NAVBAR_TITLE_1_ACCOUNT_DELETE', 'Mon compte');
define('NAVBAR_TITLE_2_ACCOUNT_DELETE', 'Supprimer compte');
	
//contact-form error messages
define('ERROR_EMAIL','<p><b>Votre adresse e-mail:</b>Pas ou entr&eacute;e invalide!</p>');
define('ERROR_HONEYPOT','<p><b>Erreur de saisie:</b> Vous avez rempli un champ de formulaire cach&eacute;e !</p>');
define('ERROR_MSG_BODY','<p><b>Votre message: </b> Pas d&acute;entr&eacute;e!</p>');	

// BOF - web28 - 2010-05-07 - PayPal API Modul
define('NAVBAR_TITLE_PAYPAL_CHECKOUT','PayPal-Checkout');
define('PAYPAL_ERROR','PayPal Abbruch');
define('PAYPAL_NOT_AVIABLE','PayPal Express n&acute;est pas disponible actuellement. <br /> S&acute;il vous pla&icirc;t choisir une autre m&eacute;thode de paiement<br />ou r&eacute;essayez plus tard. <br/> Nous vous remercions de votre compr&eacute;hension.<br />');
define('PAYPAL_FEHLER','PayPal a signal&eacute; une erreur dans le traitement. <br /> Votre commande est enregistr&eacute;e, mais n&acute;est pas ex&eacute;cut&eacute;. <br /> S&acute;il vous pla&icirc;t entrer un nouvel ordre. <br />Nous vous remercions de votre compr&eacute;hension.<br />');
define('PAYPAL_WARTEN','PayPal a signal&eacute; une erreur dans le traitement. <br /> Vous devez une fois de plus &agrave; payer l&acute;ordre PayPal. <br /> Ci-dessous vous pouvez voir l&acute;ordre enregistr&eacute;. <br /> Merci pour votre compr&eacute;hension. <br /> S&acute;il vous pla&icirc;t appuyez sur le bouton PayPal Express.');
define('PAYPAL_NEUBUTTON','S&acute;il vous pla&icirc;t appuyez &agrave; nouveau pour payer la commande. <br /> Toute autre touche annule l&acute;ordre.');
define('ERROR_ADDRESS_NOT_ACCEPTED', '* Tant que vous n&acute;acceptez pas votre adresse de facturation et d&acute;exp&eacute;dition, \ n nous ne pouvons pas accepter votre commande!\n\n');
define('PAYPAL_GS','Bon/Coupon');
define('PAYPAL_TAX','TVA.');
define('PAYPAL_EXP_WARN','Attention! Les frais dacute;exp&eacute;dition applicables seront calcul&eacute;s d&eacute;finitivement dans la boutique.');
define('PAYPAL_EXP_VORL','frais provisoirement');
define('PAYPAL_EXP_VERS','0.00');
// 09.01.11
define('PAYPAL_ADRESSE','Le pays de votre adresse de livraison PayPal n&acute;est pas inscrit dans notre boutique.<br />S&acute;il vous pla&icirc;t contactez-nous.<br />Merci pour votre compr&eacute;hension.<br />Recu de Paypal: ');
// 17.09.11
define('PAYPAL_AMMOUNT_NULL','Le montant du contrat pr&eacute;vu (hors frais de port) est &eacute;gal &agrave; 0<,br />ce qui PayPal Express n&acute;est pas disponible<br />S&acute;il vous pla&icirc;t choisir une autre m&eacute;thode de paiement<br />Merci pour votre compr&eacute;hension.<br />');
// EOF - web28 - 2010-05-07 - PayPal API Modul
define('BASICPRICE_VPE_TEXT','dans ce volume seulement '); // Hetfield - 2009-11-26 - Added language definition for vpe at graduated prices
//web - 2010-07-11 - Price display for scale prices (largest scale)
define('GRADUATED_PRICE_MAX_VALUE', '&agrave; partir de');

//web28 - 2010-08-20 - SHIPPING COSTS SHOPPING CART
define('_SHIPPING_TO', 'Montrez-moi les méthodes d&apos;expédition possibles pour: ');

// BOF - DokuMan - 2011-09-20 - E-Mail SQL errors
define('ERROR_SQL_DB_QUERY','D&eacute;sol&eacute;, mais il y a une erreur de notre base de donn&eacute;es.');
define('ERROR_SQL_DB_QUERY_REDIRECT','Vous allez &ecirc;tre redirig&eacute; vers %s secondes sur notre page dacute;accueil');
// EOF - DokuMan - 2011-09-20 - E-Mail SQL errors

define('TEXT_AGB_CHECKOUT','termes et conditions et les informations clients %s <br/>politique de remboursement %s  <br /> politique de confidentialité %s');

define('_SHIPPING_FREE','T&eacute;l&eacute;chargement');

//google_sitemap.php
define('SITEMAP_FILE', 'fichier sitemap');
define('SITEMAP_INDEX_FILE', 'Fichier d&apos;index de plan Sitemap');
define('SITEMAP_CREATED', ' cr&eacute;&eacute;');
define('SITEMAP_CATEGORY','Cat&eacute;gories ');
define('SITEMAP_PRODUCT', 'produits');
define('SITEMAP_AND', 'et ');
define('SITEMAP_CONTENTPAGE', 'Pages de contenu');
define('SITEMAP_EXPORT', 'export&eacute;');

define('TEXT_EDIT_CATEGORIES', 'Modifier la cat&eacute;gorie');
define('TEXT_EDIT_CONTENT_MANAGER', 'Modifier le contenu');
define('ERROR_HONEYPOT','<p>Il y a eu un problème avec le formulaire de contact.</p>');


define('ERROR_MESSAGE_PRODUCT_NEGATIVE_AMOUNT', 'Montant négatif. Veuillez nous contacter pour un devis.');

define('TEXT_TO_CATEGORY', 'Zur Kategorie');

?>