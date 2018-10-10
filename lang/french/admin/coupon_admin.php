<?php
/* -----------------------------------------------------------------------------------------
   coupon_admin.php

   Fishnet Services
   https://fishnet-services.com

   Copyright (c) 2018 Fishnet Services
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce
   (c) 2003	 Xt Commerce
   
   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('TOP_BAR_TITLE', 'Statistiques');
define('HEADING_TITLE', 'Coupons de réduction');
define('HEADING_TITLE_STATUS', 'Statut : ');
define('TEXT_CUSTOMER', 'Client:');
define('TEXT_COUPON', 'Nom du coupon');
define('TEXT_COUPON_ALL', 'Tous les coupons');
define('TEXT_COUPON_ACTIVE', 'Coupons actifs');
define('TEXT_COUPON_INACTIVE', 'Coupons inactifs');
define('TEXT_SUBJECT', 'Sujet:');
define('TEXT_FROM', 'De:');
define('TEXT_FREE_SHIPPING', 'Livraison gratuite');
define('TEXT_MESSAGE', 'Message:');
define('TEXT_SELECT_CUSTOMER', 'Sélectionnez Client');
define('TEXT_ALL_CUSTOMERS', 'Tous les clients');
define('TEXT_NEWSLETTER_CUSTOMERS', 'À tous les abonnés du bulletin d&apos;information');
define('TEXT_CONFIRM_DELETE', 'En cliquant sur <b>Confirmer</b> le coupon sélectionné sera réglé sur <b>inactif</b>. Note : Ce coupon ne peut pas être réactivé pour une utilisation ultérieure. <br /><br />Voulez-vous vraiment désactiver ce coupon ?');

define('TEXT_TO_REDEEM', 'Vous pouvez échanger ce coupon lors de la validation de votre commande. Il suffit d&apos;entrer le code dans la case prévue à cet effet et de cliquer sur le bouton d&apos;échange.');
define('TEXT_IN_CASE', '  au cas où vous auriez des problèmes. ');
define('TEXT_VOUCHER_IS', 'Le code coupon est  ');
define('TEXT_REMEMBER', 'Ne perdez pas le code de bon de réduction, assurez-vous de le conserver en lieu sûr afin de pouvoir bénéficier de cette offre spéciale.');
define('TEXT_VISIT', 'lorsque vous visitez ' . HTTP_SERVER . DIR_WS_CATALOG);
define('TEXT_ENTER_CODE', ' et entrez le code ');

define('TABLE_HEADING_ACTION', 'Action');

define('CUSTOMER_ID', 'Identifiant client');
define('CUSTOMER_NAME', 'Nom du client');
define('REDEEM_DATE', 'Date de rachat');
define('IP_ADDRESS', 'Adresse IP');

define('TEXT_REDEMPTIONS', 'Rachats');
define('TEXT_REDEMPTIONS_TOTAL', 'Au total');
define('TEXT_REDEMPTIONS_CUSTOMER', 'Pour ce client');
define('TEXT_NO_FREE_SHIPPING', 'Pas de livraison gratuite');

define('NOTICE_EMAIL_SENT_TO', 'Avis : courriel envoyé à: %s');
define('ERROR_NO_CUSTOMER_SELECTED', 'Erreur : Aucun client n&apos;a été sélectionné.');
define('COUPON_NAME', 'Nom du coupon');
define('COUPON_AMOUNT', 'Montant du coupon');
define('COUPON_CODE', 'Code du coupon');
define('COUPON_STARTDATE', 'Date de début');
define('COUPON_FINISHDATE', 'Date de fin');
define('COUPON_FREE_SHIP', 'Livraison gratuite');
define('COUPON_DESC', 'Description du coupon');
define('COUPON_MIN_ORDER', 'Coupon minimum de commande');
define('COUPON_USES_COUPON', 'Utilisations par Coupon');
define('COUPON_USES_USER', 'Utilisations par client');
define('COUPON_PRODUCTS', 'Liste des produits valides');
define('COUPON_CATEGORIES', 'Liste des catégories valides');
define('VOUCHER_NUMBER_USED', 'Nombre utilisé');
define('DATE_CREATED', 'Date de création');
define('DATE_MODIFIED', 'Date de modification');
define('TEXT_HEADING_NEW_COUPON', 'Créer un nouveau coupon');
define('TEXT_NEW_INTRO', 'Veuillez remplir les informations suivantes pour le nouveau coupon.<br />');


define('COUPON_NAME_HELP', 'Un nom court pour le coupon.');
define('COUPON_AMOUNT_HELP', 'La valeur de la remise pour le coupon, soit fixe, soit ajouter un % à la fin pour un pourcentage de remise.');
define('COUPON_CODE_HELP', 'Vous pouvez entrer votre propre code ici, ou laisser vide pour un code généré automatiquement.');
define('COUPON_STARTDATE_HELP', 'La date à laquelle le coupon sera valide à partir du');
define('COUPON_FINISHDATE_HELP', 'La date d&apos;expiration du coupon');
define('COUPON_FREE_SHIP_HELP', 'Le coupon donne droit à la livraison gratuite sur une commande. Note. Ceci remplace le montant du coupon mais respecte la valeur minimale de commande.');
define('COUPON_DESC_HELP', 'Une description du coupon pour le client');
define('COUPON_MIN_ORDER_HELP', 'Le montant minimum de commande avant que le coupon ne soit valide');
define('COUPON_USES_COUPON_HELP', 'Le nombre maximum de fois où le coupon peut être utilisé, laissez vide si vous ne voulez pas de limite.');
define('COUPON_USES_USER_HELP', 'Nombre de fois qu&apos;un utilisateur peut utiliser le coupon, laissez vide sans limite.');
define('COUPON_PRODUCTS_HELP', 'Une liste séparée par des virgules de product_ids avec laquelle ce coupon peut être utilisé. Ne rien indiquer pour aucune restriction.');
define('COUPON_CATEGORIES_HELP', 'Une liste de chemins (cPath) séparés par des virgules avec lesquels ce coupon peut être utilisé, laissez vide pour aucune restriction.');

define('COUPON_ID', 'cID');
define('BUTTON_DELETE_NO_CONFIRM', 'Supprimer sans confirmation');
define('TEXT_NONE', 'aucune restriction');
define('TEXT_COUPON_DELETE', 'Supprimer');
define('TEXT_COUPON_STATUS', 'Statut');
define('TEXT_COUPON_DETAILS', 'Détails du coupon');
define('TEXT_COUPON_EMAIL', 'envoyer un courriel');
define('TEXT_COUPON_OVERVIEW', 'Vue d&apos;ensemble');
define('TEXT_COUPON_EMAIL_PREVIEW', 'Confirmation');
define('TEXT_COUPON_MINORDER', 'min. valeur de commande');
define('TEXT_VIEW', 'Vue de liste');
define('TEXT_VIEW_SHORT', 'Montrer');

//BOF - web28 - 2011-04-13 - ADD Coupon message infos
define('COUPON_MINORDER_INFO', "\nCoupon Commande minimum: ");
define('COUPON_RESTRICT_INFO', "\nCe coupon n&apos;est valable que pour certains produits !"); 
define('COUPON_INFO', "\nMontant du coupon: "); 
define('COUPON_FREE_SHIPPING', 'Livraison gratuite');
define('COUPON_LINK_TEXT', '\n\nDetails');
define('COUPON_CATEGORIES_RESTRICT', '\nValable pour ces catégories');
define('COUPON_PRODUCTS_RESTRICT', '\nValable pour ces produits');
define('COUPON_NO_RESTRICT', '\nValable pour tous les produits');; 
//EOF - web28 - 2011-04-13 - ADD Coupon message infos

//BOF - web28 - 2011-07-05 - ADD error message
define('ERROR_NO_COUPON_NAME', 'ERREUR : Aucun coupon Nom  ');
define('ERROR_NO_COUPON_AMOUNT', 'ERREUR : Aucun coupon Montant ');
//EOF - web28 - 2011-07-05 - ADD error message
?>