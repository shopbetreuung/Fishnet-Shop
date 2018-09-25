<?php
/**
 * @version SOFORT Gateway 5.2.0 - $Date: 2012-09-06 14:27:56 +0200 (Thu, 06 Sep 2012) $
 * @author SOFORT AG (integration@sofort.com)
 * @link http://www.sofort.com/
 *
 * Copyright (c) 2012 SOFORT AG
 *
 * $Id: sofort_general.php 3751 2012-10-10 08:36:20Z gtb-modified $
 */

define('MODULE_PAYMENT_SOFORT_MULTIPAY_JS_LIBS', '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="'.DIR_WS_CATALOG.'callback/sofort/ressources/javascript/sofortbox.js"></script>');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_STATUS_TITLE', 'Activer sofort.de module');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_STATUS_DESC', 'Activates/deactivates the complete module');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_APIKEY_TITLE', 'configuration key');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_APIKEY_DESC', 'Assigned configuration key by SOFORT AG');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_AUTH_TITLE', 'test configuration key');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_AUTH_DESC', '<noscript>Please Activer Javascript</noscript><script src="../callback/sofort/ressources/javascript/testAuth.js"></script>');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_TITLE', 'Zone de paiement');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_DESC', 'When a zone is selected, the payment method applies only to this zone.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_REASON_1_TITLE', 'Raison 1');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_REASON_1_DESC', 'Pour le but 1, les options suivantes peuvent être sélectionnées');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_TEXT_REASON_2_TITLE', 'Reason 2');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_TEXT_REASON_2_DESC', 'Les espaces réservés suivants seront remplacés à l&apos;intérieur du motif (max 27 characters):<br />{{order_date}}<br />{{customer_id}}<br />{{customer_name}}<br />{{customer_company}}<br />{{customer_email}}');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_TEXT_ERROR_HEADING', 'Une erreur de suivi s&apos;est produite au cours du processus :');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_TEXT_ERROR_MESSAGE', 'Le paiement n&apos;est malheureusement pas possible ou a été annulé par le client. Veuillez choisir un autre mode de paiement.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_IMAGE_TITLE', 'Bannière ou texte dans la sélection des modes de paiement.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_IMAGE_DESC', 'Bannière ou texte dans la sélection des modes de paiement.');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_CHECK_STATUS_ID_TITLE', 'État de la commande pour l&apos;examen manuel');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_CHECK_STATUS_ID_DESC', 'État de la commande pour les ordres dont l&apos;exécution du paiement est inhabituelle, tels que les montants non valides, les paiements manquants, les retours de note de débit, etc. Ces ordonnances doivent être examinées manuellement.');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_ORDER_CANCELED', 'La commande a été annulée.'); //Die Bestellung wurde abgebrochen.

define('MODULE_PAYMENT_SOFORT_STATUS_NOT_CREDITED_YET', 'Commande avec {{paymentMethodStr}} soumis avec succès. Transaction-ID : {{tId}} {{time}}');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_CREDITED_TO_SELLER', 'Payment to the merchant account has been completed.');
define('MODULE_PAYMENT_SOFORT_STATUS_WAIT_FOR_MONEY', 'En attente de paiement. Transaction ID: {{tId}} {{time}}');

define('MODULE_PAYMENT_SOFORT_STATUS_PARTIALLY_CREDITED', '{{paymentMethodStr}} - Seul un montant partiel du montant initialement réclamé a été reçu. {{time}}');
define('MODULE_PAYMENT_SOFORT_STATUS_OVERPAYMENT', '{{paymentMethodStr}} - Un montant plus élevé que celui initialement réclamé a été reçu. Montant : {{received_amount}}. {{time}}');
define('MODULE_PAYMENT_SOFORT_STATUS_SV_COMPENSATION', 'Le montant de la facture sera partiellement remboursé. Montant total remboursé : {{refunded_amount}}. {{time}}');

define('MODULE_PAYMENT_SOFORT_STATUS_RECEIVED', '{{paymentMethodStr}} - L&apos;argent reçu. {{time}}');
define('MODULE_PAYMENT_SOFORT_STATUS_DEFAULT', '{{paymentMethod}} {{status}} {{statusReason}} {{time}}');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_TRANSACTION_ID', 'transaction ID');

define('MODULE_PAYMENT_SOFORT_ERROR_ORDER_NOT_FOUND', 'Erreur : l&apos;ordre n&apos;a pas été trouvé.\n');
define('MODULE_PAYMENT_SOFORT_SUCCESS_CALLBACK', 'L&apos;état de la commande a été mis à jour avec succès.');
define('MODULE_PAYMENT_SOFORT_ERROR_UNEXPECTED_STATUS', 'Erreur : Statut de paiement inconnu.');
define('MODULE_PAYMENT_SOFORT_ERROR_TERMINATED', 'Script terminé.');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_FORWARDING', 'Votre demande est en cours de vérification, attendez un moment et n&apos;annulez pas.<br />Le processus peut prendre jusqu&apos;à 30 secondes.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_VERSIONNUMBER', 'Version number');

define('MODULE_PAYMENT_SOFORT_KEYTEST_SUCCESS', 'API-Key validé avec succès');
define('MODULE_PAYMENT_SOFORT_KEYTEST_SUCCESS_DESC', 'Test OK on');
define('MODULE_PAYMENT_SOFORT_KEYTEST_ERROR', 'Impossible de valider la clé API !');
define('MODULE_PAYMENT_SOFORT_KEYTEST_ERROR_DESC', 'Note: API key error');
define('MODULE_PAYMENT_SOFORT_KEYTEST_DEFAULT', 'La clé API n&apos;a pas encore été testée');

define('MODULE_PAYMENT_SOFORT_REFRESH_INFO', 'Si vous venez de confirmer, d&apos;ajuster, d&apos;annuler ou de créditer cette commande, il se peut que vous ayez besoin de {{refresh}} cette page pour voir tous les changements.');
define('MODULE_PAYMENT_SOFORT_REFRESH_PAGE', 'Cliquez ici pour recharger la page');

//definition of error-codes that can resolve by calling the SOFORT-API
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_0',		'Une erreur inconnue s&apos;est produite.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8002',		'Une erreur de validation s&apos;est produite.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010',		'Les données sont incomplètes ou incorrectes. Veuillez corriger ou contacter le marchand en ligne.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8011',		'Pas dans la plage des valeurs valides.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8012',		'La valeur doit être positive.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8013',		'Pour le moment, seules les commandes en euros sont prises en charge. Veuillez corriger cela et réessayer.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8015',		'Le montant total est trop grand ou trop petit, veuillez le corriger ou contacter le propriétaire du magasin.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8017',		'Caractères inconnus.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8018',		'Nombre maximum de caractères dépassés (max. 27).');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8019',		'La commande ne peut pas être complétée en raison d&apos;une adresse e-mail incorrecte. Veuillez corriger cela et réessayer.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8020',		'La commande ne peut pas être complétée en raison d&apos;un numéro de téléphone incorrect. Veuillez corriger cela et réessayer.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8021',		'Le code du comté n&apos;est pas supporté, veuillez contacter votre marchand.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8022',		'Le BIC fourni n&apos;est pas valide.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8023',		'La commande ne peut pas être exécutée en raison d&apos;un BIC incorrect. (Bank Identifier Code). Veuillez corriger cela et réessayer.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8024',		'La commande ne peut pas être exécutée en raison d&apos;un code de pays incorrect. L&apos;adresse de livraison / facturation doit être en Allemagne. Veuillez corriger cela et réessayer.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8029',		'Nous ne pouvons soutenir que les comptes allemands. Veuillez corriger cela ou essayer une autre méthode de paiement.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8033',		'Le montant total est trop élevé. Veuillez corriger cela et réessayer.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8034',		'Le montant total est trop faible. Veuillez corriger cela et réessayer.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8041',		'La valeur pour la TVA est incorrecte. Valeurs valides : 0, 7,19.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8046',		'La validation du compte bancaire et du numéro d&apos;acheminement bancaire a échoué.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8047',		'Le nombre maximum de 255 caractères a été dépassé.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8051',		'La requête contenait les positions non valides des chariots. Veuillez corriger cela ou contacter le propriétaire du magasin.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8058',		'Veuillez entrer, au moins, le titulaire du compte et réessayer.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8061',		'Une transaction avec les informations que vous avez soumises existe déjà.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8068',		'L&apos;achat sur compte n&apos;est disponible que pour les clients privés pour le moment.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10001', 	'Veuillez remplir les champs numéro de compte, code de tri et titulaire du compte en entier.'); //LS: holder and bankdata missing
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10002',	'Veuillez accepter la politique de confidentialité.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10003',	'Malheureusement, le mode de paiement choisi ne peut pas être utilisé pour le paiement d&apos;articles tels que les téléchargements ou les chèques-cadeaux.');  //RBS and virtual content is not allowed
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10004',	'Une erreur inconnue s&apos;est produite.');  //order could not be saved in table sofort_orders
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10005',	'Une erreur inconnue s&apos;est produite.');  //saving of order (after successful payment-process) MAYBE failed, seller informed
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10006',	'Une erreur inconnue s&apos;est produite.');  //saving of order (after successful payment-process) REALLY failed, seller informed

//check for empty fields failed (code 8010 = 'must not be empty')
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.EMAIL_CUSTOMER',				'L&apos;adresse e-mail ne peut pas être vide.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.PHONE_CUSTOMER',				'Le numéro de téléphone ne peut pas être vide.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.FIRSTNAME',	'Le prénom de l&apos;adresse de facturation ne peut pas être vide.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.FIRSTNAME',	'Le prénom de l&apos;adresse de livraison ne peut pas être vide.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.LASTNAME',	'Le nom de famille de l&apos;adresse de facturation ne peut pas être vide.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.LASTNAME',	'The lastname of the shipping address can not be empty.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.STREET',		'La rue et le numéro de maison doivent être séparés par un espace.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.STREET',		'La rue et le numéro de maison de l&apos;adresse d&apos;expédition ne peuvent pas être vides.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.STREET_NUMBER',	'La rue et le numéro de maison de l&apos;adresse d&apos;expédition ne peuvent pas être vides.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.STREET_NUMBER',	'La rue et le numéro de maison de l&apos;adresse d&apos;expédition ne peuvent pas être vides.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.ZIPCODE',		'Le code postal de l&apos;adresse de facturation ne peut pas être vide.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.ZIPCODE',	'Le code postal de l&apos;adresse de livraison ne peut pas être vide..');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.CITY',		'Le nom de la ville de l&apos;adresse de facturation ne peut pas être vide.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.CITY',		'Le nom de la ville de l&apos;adresse de livraison ne peut pas être vide.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.COUNTRY_CODE',	'Le code pays de l&apos;adresse de facturation ne peut pas être vide.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.COUNTRY_CODE',	'Le code pays de l&apos;adresse de livraison ne peut pas être vide.');