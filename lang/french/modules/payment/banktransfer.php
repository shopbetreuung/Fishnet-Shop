<?php
/* -----------------------------------------------------------------------------------------
   $Id: banktransfer.php 998 2005-07-07 14:18:20Z mz $   

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banktransfer.php,v 1.9 2003/02/18 19:22:15); www.oscommerce.com 
   (c) 2003	 nextcommerce (banktransfer.php,v 1.5 2003/08/13); www.nextcommerce.org
   (c) 2006 xt:Commerce; www.xt-commerce.com

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   OSC German Banktransfer v0.85a       	Autor:	Dominik Guder <osc@guder.org>
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
define('MODULE_PAYMENT_TYPE_PERMISSION', 'bt');

define('MODULE_PAYMENT_BANKTRANSFER_TEXT_TITLE', 'Prélèvement automatique.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_DESCRIPTION', 'Paiement par prélèvement automatique.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_INFO','');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK', 'Paiement par prélèvement automatique.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_EMAIL_FOOTER', 'Note : Vous pouvez télécharger notre formulaire de fax: ' . HTTP_SERVER . DIR_WS_CATALOG . MODULE_PAYMENT_BANKTRANSFER_URL_NOTE . ' et le remplir et nous l&apos;envoyer.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_INFO', 'En spécifiant IBAN/BIC, vous pouvez utiliser le système de domiciliation dans toute l&apos;UE.<br/> Les champs marqués d&apos;un astérisque (*) sont obligatoires.  Pour un IBAN allemand, la spécification d&apos;un BIC est facultative..<br/><br/>');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_OWNER', 'Propriétaire du compte:*');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_OWNER_EMAIL', 'Propriétaire du compte de courrier électronique* : ');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_NUMBER', 'Numéro de compte:*');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_IBAN', 'IBAN:*');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_BLZ', 'Code de la banque :*');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_BIC', 'BIC:*');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_NAME', 'Nom de la banque :');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_FAX', 'Virement bancaire Le paiement sera confirmé par fax.');

// Note these MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_X texts appear also in the URL, so no html-entities are allowed here
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR', 'ERREUR:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_1', 'Le numéro de compte et le code bancaire ne conviennent pas ! Veuillez vérifier à nouveau.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_2', 'Aucune méthode de contrôle de plausibilité n&apos;est disponible pour ce code bancaire !');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_3', 'Le numéro de compte ne peut pas être vérifié !');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_4', 'Le numéro de compte ne peut pas être vérifié ! Veuillez vérifier à nouveau.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_5', 'BIC n&apos;a pas été trouvé ! Veuillez vérifier à nouveau.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_8', 'Code bancaire incorrect ou aucun code bancaire saisi.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_9', 'Aucun numéro de compte indiqué.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_10', 'Aucun titulaire de compte indiqué.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_11', 'Aucun BIC indiqué.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_12', 'Aucun IBAN valide n&apos;est indiqué.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_13', 'adresse e-mail invalide pour informer le titulaire du compte.');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_BANK_ERROR_14', 'Aucun pays valide pour le SEPA.');

define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE', 'Indice:');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE2', 'Si vous ne souhaitez pas envoyer <br/>vos données de compte par Internet, vous pouvez télécharger notre ');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE3', 'formulaire Fax');
define('MODULE_PAYMENT_BANKTRANSFER_TEXT_NOTE4', ' et nous le renvoyer.');

define('JS_BANK_BLZ', '* Veuillez entrer le BIC de votre banque !\n\n');
define('JS_BANK_NAME', '* Veuillez entrer le nom de votre banque !\n\n');
define('JS_BANK_NUMBER', '* Veuillez entrer votre IBAN !\n\n');
define('JS_BANK_OWNER', '* Veuillez entrer le nom du titulaire du compte !\n\n');
define('JS_BANK_OWNER_EMAIL', '* Veuillez entrer l&apos;adresse e-mail du titulaire du compte !\n\n');

define('MODULE_PAYMENT_BANKTRANSFER_DATABASE_BLZ_TITLE' , 'Utiliser la recherche dans la base de données pour le contrôle du code bancaire ?');
define('MODULE_PAYMENT_BANKTRANSFER_DATABASE_BLZ_DESC', 'Utilisez-vous la base de données pour le contrôle de plausibilité des codes bancaires ("true")?<br/>Assurez-vous que les codes bancaires de la base de données sont à jour !<br/><a href="'.xtc_href_link(defined('FILENAME_BLZ_UPDATE')?FILENAME_BLZ_UPDATE:'').'" target="_blank" rel="noopener"><strong>Link: --> BLZ UPDATE <-- </strong></a><br/><br/>Si vous choisissez "false", le système utilisera le fichier blz.csv qui contient éventuellement des entrées obsolètes !');
define('MODULE_PAYMENT_BANKTRANSFER_URL_NOTE_TITLE' , 'URL du fax');
define('MODULE_PAYMENT_BANKTRANSFER_URL_NOTE_DESC' , 'Le fichier de confirmation de fax. Il doit se situer dans le catalogue-dir');
define('MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION_TITLE' , 'Autoriser la confirmation par fax ?');
define('MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION_DESC' , 'Voulez-vous autoriser la confirmation par fax ?');
define('MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER_TITLE' , 'séquence de présentation');
define('MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER_DESC' , 'Séquence d&apos;affichage. Le plus petit chiffre est affiché en premier.');
define('MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID_TITLE' , 'Définir le statut de l&apos;ordre. ');
define('MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID_DESC' , 'Définir les commandes passées avec ce module à ce statut.');
define('MODULE_PAYMENT_BANKTRANSFER_ZONE_TITLE' , 'zone de paiement');
define('MODULE_PAYMENT_BANKTRANSFER_ZONE_DESC' , 'Si une zone est sélectionnée, le mode de paiement ne s&apos;applique qu&apos;à cette zone.');
define('MODULE_PAYMENT_BANKTRANSFER_ALLOWED_TITLE' , 'Zones autorisées');
define('MODULE_PAYMENT_BANKTRANSFER_ALLOWED_DESC' , 'Spécifiez <b>individuel</b> les zones qui devraient être autorisées pour ce module. (p. ex. AT,DE (si vide, toutes les zones sont autorisées)).');
define('MODULE_PAYMENT_BANKTRANSFER_STATUS_TITLE' , 'Autoriser les paiements par Paiement par prélèvement automatique.?');
define('MODULE_PAYMENT_BANKTRANSFER_STATUS_DESC' , 'Autorisez-vous les paiements par Paiement par prélèvement automatique. ?');
define('MODULE_PAYMENT_BANKTRANSFER_MIN_ORDER_TITLE' , 'Ordres nécessaires');
define('MODULE_PAYMENT_BANKTRANSFER_MIN_ORDER_DESC' , 'Le nombre minimum de commandes qu&apos;un client doit avoir pour que l&apos;option soit disponible.');
define('MODULE_PAYMENT_BANKTRANSFER_NEG_SHIPPING_TITLE', 'Exclusion pour les modules d&apos;expédition');
define('MODULE_PAYMENT_BANKTRANSFER_NEG_SHIPPING_DESC', 'Désactiver ce module de paiement si le module d&apos;expédition est sélectionné (liste séparée par des virgules)');
define('MODULE_PAYMENT_BANKTRANSFER_IBAN_ONLY_TITLE', 'IBAN Mode');
define('MODULE_PAYMENT_BANKTRANSFER_IBAN_ONLY_DESC', 'Autorisez-vous uniquement les paiements IBAN ?');

// SEPA
define('MODULE_PAYMENT_BANKTRANSFER_CI_TITLE', 'Numéro d&apos;identification du créancier (CI)');
define('MODULE_PAYMENT_BANKTRANSFER_CI_DESC', 'Saisissez ici votre numéro de créancier SEPA.');
define('MODULE_PAYMENT_BANKTRANSFER_REFERENCE_PREFIX_TITLE', 'Préfixe pour la référence du mandat (facultatif)');
define('MODULE_PAYMENT_BANKTRANSFER_REFERENCE_PREFIX_DESC', 'Saisissez un préfixe pour la référence du mandat.');
define('MODULE_PAYMENT_BANKTRANSFER_DUE_DELAY_TITLE', 'Date d&apos;échéance de la note de débit :');
define('MODULE_PAYMENT_BANKTRANSFER_DUE_DELAY_DESC', 'Saisissez la période (en jours) après laquelle vous voulez exécuter la note de débit.');
?>