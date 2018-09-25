<?php
/* -----------------------------------------------------------------------------------------
   $Id: billsafe_2.php 4200 2013-01-10 19:47:11Z Tomcraft1980 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   Copyright (c) 2013 PayPal SE and Bernd Blazynski

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

/*
* id = billsafe_2.php
* location = /lang/french/modules/payment
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 2, as
* published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* @package BillSAFE_2
* @copyright (C) 2013 Bernd Blazynski
* @license GPLv2
*/

define('MODULE_PAYMENT_BILLSAFE_2_TEXT_TITLE', 'Achat sur compte avec BillSAFE');
define('MODULE_PAYMENT_BILLSAFE_2_CHECKOUT_TEXT_INFO', 'Payez facilement par facture. Simple et non bureaucratique avec BillSAFE, un service de PayPal.');
define('MODULE_PAYMENT_BILLSAFE_2_SCHG_TEXT_INFO', 'Pour ce mode de paiement, nous facturons un supplément de : ');
define('MODULE_PAYMENT_BILLSAFE_2_ERROR_MESSAGE_COMMON', 'Malheureusement, l&apos;achat de facture via BillSAFE n&apos;est pas possible. Veuillez choisir un autre mode de paiement.');
define('MODULE_PAYMENT_BILLSAFE_2_ERROR_MESSAGE_101', 'BillSAFE n&apos;est actuellement pas disponible, veuillez choisir un autre mode de paiement.');
define('MODULE_PAYMENT_BILLSAFE_2_ERROR_MESSAGE_102', 'Une erreur s&apos;est produite lors de la transmission des données. N&apos;hésitez pas à nous contacter.');
define('MODULE_PAYMENT_BILLSAFE_2_ERROR_MESSAGE_215', 'Il manquait des paramètres lors du traitement des données. N&apos;hésitez pas à nous contacter.');
define('MODULE_PAYMENT_BILLSAFE_2_ERROR_MESSAGE_216', 'Il y avait des paramètres invalides pendant le traitement des données. N&apos;hésitez pas à nous contacter.');
define('MODULE_PAYMENT_BILLSAFE_2_ERROR_MESSAGE_COMPANY', 'Le paiement via BillSAFE n&apos;est malheureusement possible que pour les particuliers.');
define('MODULE_PAYMENT_BILLSAFE_2_ERROR_MESSAGE_ADDRESS', 'Le paiement via BillSAFE n&apos;est malheureusement pas possible avec une autre adresse de livraison.');
define('MODULE_PAYMENT_BILLSAFE_2_STATUS_TEXT', 'Status');
define('MODULE_PAYMENT_BILLSAFE_2_TRANSACTIONID', 'ID de transaction BillSAFE');
define('MODULE_PAYMENT_BILLSAFE_2_CODE_TEXT', 'Code');
define('MODULE_PAYMENT_BILLSAFE_2_MESSAGE_TEXT', 'Message');
define('MODULE_PAYMENT_BILLSAFE_2_TEXT_DESCRIPTION', '<img src="images/icon_popup.gif" border="0">&nbsp;<a href="https://www.billsafe.de" target="_blank" rel="noopener" style="text-decoration: underline; font-weight: bold;" />Visitez le site Web de BillSAFE</a>');
define('MODULE_PAYMENT_BILLSAFE_2_STATUS_TITLE', 'Activer le module BillSAFE ?');
define('MODULE_PAYMENT_BILLSAFE_2_STATUS_DESC', 'Voulez-vous accepter les factures BillSAFE ?');
define('MODULE_PAYMENT_BILLSAFE_2_MERCHANT_ID_TITLE', 'Merchant ID');
define('MODULE_PAYMENT_BILLSAFE_2_MERCHANT_ID_DESC', 'L&apos;identifiant du commerçant à utiliser pour le service API BillSAFE.');
define('MODULE_PAYMENT_BILLSAFE_2_MERCHANT_LICENSE_TITLE', 'Merchant License');
define('MODULE_PAYMENT_BILLSAFE_2_MERCHANT_LICENSE_DESC', 'La licence commerçant à utiliser pour le service de l&apos;API BillSAFE.');
define('MODULE_PAYMENT_BILLSAFE_2_MIN_ORDER_TITLE', 'Valeur minimale de commande');
define('MODULE_PAYMENT_BILLSAFE_2_MIN_ORDER_DESC', 'BillSAFE Valeur minimale de commande');
define('MODULE_PAYMENT_BILLSAFE_2_MAX_ORDER_TITLE', 'Valeur maximale de commande');
define('MODULE_PAYMENT_BILLSAFE_2_MAX_ORDER_DESC', 'BillSAFE Valeur maximale de commande');
define('MODULE_PAYMENT_BILLSAFE_2_BILLSAFE_LOGO_URL_DESC', 'BillSAFE Logo URL');
define('MODULE_PAYMENT_BILLSAFE_2_BILLSAFE_LOGO_URL_TITLE', 'BillSAFE Logo URL');
define('MODULE_PAYMENT_BILLSAFE_2_SHOP_LOGO_URL_DESC', 'Shop Logo URL');
define('MODULE_PAYMENT_BILLSAFE_2_SHOP_LOGO_URL_TITLE', 'Shop Logo URL');
define('MODULE_PAYMENT_BILLSAFE_2_SHOP_LOGO_URL_DESC', 'Emplacement du logo de la boutique.');
define('MODULE_PAYMENT_BILLSAFE_2_SERVER_TITLE', 'BillSAFE Server');
define('MODULE_PAYMENT_BILLSAFE_2_SERVER_DESC', 'Utiliser le serveur de passerelle en direct ou de test (sandbox) pour traiter les factures ?');
define('MODULE_PAYMENT_BILLSAFE_2_ZONE_TITLE', 'Zone de paiement');
define('MODULE_PAYMENT_BILLSAFE_2_ZONE_DESC', 'Si une zone est sélectionnée, n&apos;activez ce mode de paiement que pour cette zone.');
define('MODULE_PAYMENT_BILLSAFE_2_ORDER_STATUS_ID_TITLE', 'Définir le statut de commande');
define('MODULE_PAYMENT_BILLSAFE_2_ORDER_STATUS_ID_DESC', 'Définissez le statut des commandes passées avec ce module de paiement à cette valeur.');
define('MODULE_PAYMENT_BILLSAFE_2_SORT_ORDER_TITLE', 'Ordre de tri de l&apos;affichage.');
define('MODULE_PAYMENT_BILLSAFE_2_SORT_ORDER_DESC', 'Ordre de tri de l&apos;affichage. Le plus bas est affiché en premier.');
define('MODULE_PAYMENT_BILLSAFE_2_ALLOWED_TITLE', 'Zones autorisées');
define('MODULE_PAYMENT_BILLSAFE_2_ALLOWED_DESC', 'Veuillez entrer séparément les zones qui devraient être autorisées à utiliser ce module (par exemple DE, AT (laissez vide si vous voulez autoriser toutes les zones)).');
define('MODULE_PAYMENT_BILLSAFE_2_MESSAGE_FSHIPMENT', 'L&apos;expédition complète a été couronnée de succès.');
define('MODULE_PAYMENT_BILLSAFE_2_MESSAGE_PSHIPMENT', 'L&apos;expédition partielle a été couronnée de succès.');
define('MODULE_PAYMENT_BILLSAFE_2_MESSAGE_FSTORNO', 'L&apos;annulation complète a été couronnée de succès');
define('MODULE_PAYMENT_BILLSAFE_2_MESSAGE_PSTORNO', 'L&apos;annulation partielle a été couronnée de succès.');
define('MODULE_PAYMENT_BILLSAFE_2_MESSAGE_FRETOURE', 'Les retours complets ont été couronnés de succès');
define('MODULE_PAYMENT_BILLSAFE_2_MESSAGE_PRETOURE', 'Les retours partiels ont été couronnés de succès');
define('MODULE_PAYMENT_BILLSAFE_2_MESSAGE_VOUCHER', 'Le crédit a été couronné de succès');
define('MODULE_PAYMENT_BILLSAFE_2_MESSAGE_PAUSETRANSACTION', 'La transaction de pause a été couronnée de succès');
define('MODULE_PAYMENT_BILLSAFE_2_DETAILS', 'BillSAFE détails');
define('MODULE_PAYMENT_BILLSAFE_2_BADDRESS', 'Adresse de facturation  (BillSAFE)');
define('MODULE_PAYMENT_BILLSAFE_2_SADDRESS', 'Adresse de livraison');
define('MODULE_PAYMENT_BILLSAFE_2_EMAIL', 'E-mail');
define('MODULE_PAYMENT_BILLSAFE_2_BANK_DETAILS', 'Détails du banc');
define('MODULE_PAYMENT_BILLSAFE_2_BANK_CODE', 'numéro d&apos;identification bancaire');
define('MODULE_PAYMENT_BILLSAFE_2_BANK_NAME', 'Nom de la banque');
define('MODULE_PAYMENT_BILLSAFE_2_ACCOUNT_NUMBER', 'numéro de compte bancaire');
define('MODULE_PAYMENT_BILLSAFE_2_RECIPIENT', 'Destinataire du paiement');
define('MODULE_PAYMENT_BILLSAFE_2_BIC', 'BIC');
define('MODULE_PAYMENT_BILLSAFE_2_IBAN', 'IBAN');
define('MODULE_PAYMENT_BILLSAFE_2_REFERENCE', 'usage prévu');
define('MODULE_PAYMENT_BILLSAFE_2_REFERENCE2', 'usage prévu 2');
define('MODULE_PAYMENT_BILLSAFE_2_NOTE', 'Indice');
define('MODULE_PAYMENT_BILLSAFE_2_AMOUNT', 'Montant à payer');
define('MODULE_PAYMENT_BILLSAFE_2_PRODUCTS', 'Produits');
define('MODULE_PAYMENT_BILLSAFE_2_MODEL', 'N° d&apos;article');
define('MODULE_PAYMENT_BILLSAFE_2_TAX', 'TVA');
define('MODULE_PAYMENT_BILLSAFE_2_PRICE_EX', 'Prix (excl.)');
define('MODULE_PAYMENT_BILLSAFE_2_PRICE_INC', 'Prix (incl.)');
define('MODULE_PAYMENT_BILLSAFE_2_CHECK', 'Sélection');
define('MODULE_PAYMENT_BILLSAFE_2_INC', 'incl. ');
define('MODULE_PAYMENT_BILLSAFE_2_TOTAL', 'montant global');
define('MODULE_PAYMENT_BILLSAFE_2_FREPORT_SHIPMENT', 'livraison complète');
define('MODULE_PAYMENT_BILLSAFE_2_PREPORT_SHIPMENT', 'livraison partielle');
define('MODULE_PAYMENT_BILLSAFE_2_UPDATEARTICLELISTSTORNOFULL', 'annulation totale');
define('MODULE_PAYMENT_BILLSAFE_2_UPDATEARTICLELISTSTORNOPART', 'Annulation partielle');
define('MODULE_PAYMENT_BILLSAFE_2_UPDATEARTICLELISTRETOUREFULL', 'Retours complets');
define('MODULE_PAYMENT_BILLSAFE_2_UPDATEARTICLELISTRETOUREPART', 'Retours partiels');
define('MODULE_PAYMENT_BILLSAFE_2_UPDATEARTICLELISTVOUCHER', 'crédit fournisseur');
define('MODULE_PAYMENT_BILLSAFE_2_PREPORT_METHOD', 'méthode');
define('MODULE_PAYMENT_BILLSAFE_2_PREPORT_DATE', 'Date');
define('MODULE_PAYMENT_BILLSAFE_2_JALERT', 'Veuillez sélectionner au moins un produit pour une expédition partielle.');
define('MODULE_PAYMENT_BILLSAFE_2_NO_ORDERID', 'ID de commande non trouvé.');
define('MODULE_PAYMENT_BILLSAFE_2_VAT', '% TVA');
define('MODULE_PAYMENT_BILLSAFE_2_VALUE', 'sous-total');
define('MODULE_PAYMENT_BILLSAFE_2_LOG_TITLE', 'Activer l&apos;enregistrement');
define('MODULE_PAYMENT_BILLSAFE_2_LOG_DESC', 'Utilisez les réponses du serveur BillSAFE pour le dépannage.');
define('MODULE_PAYMENT_BILLSAFE_2_LOG_TYPE_TITLE', 'Type de journal : Echo, envoyer le journal par e-mail ou enregistrer sous forme de fichier dans le chemin "/export".');
define('MODULE_PAYMENT_BILLSAFE_2_LOG_TYPE_DESC', '<b>Indice</b>: "Echo"  à des fins de test dans la zone d&apos;administration uniquement. Aucune commande possible !</b>');
define('MODULE_PAYMENT_BILLSAFE_2_LOG_ADDR_TITLE', 'Adresse(s) électronique(s) où envoyer le journal de bord');
define('MODULE_PAYMENT_BILLSAFE_2_LOG_ADDR_DESC', 'Pour plus d&apos;une adresse e-mail séparée par ",".');
define('MODULE_PAYMENT_BILLSAFE_2_PAUSETRANSACTION', 'pause Transaction');
define('MODULE_PAYMENT_BILLSAFE_2_PAUSEDAYS', 'jours');
define('MODULE_PAYMENT_BILLSAFE_2_SCHG_TITLE', 'Supplément de paiement');
define('MODULE_PAYMENT_BILLSAFE_2_SCHG_DESC', 'Supplément pour paiement via BillSAFE. Laisser vide pour aucun, fixer le montant net de la surtaxe, pourcentage de la surtaxe avec "%" (e. g. 3%). <b>Remarque : Les honoraires doivent être convenus avec BillSAFE et ne doivent pas dépasser la valeur convenue !</b>');
define('MODULE_PAYMENT_BILLSAFE_2_SCHGTAX_TITLE', 'Taux d&apos;imposition de la surtaxe de paiement');
define('MODULE_PAYMENT_BILLSAFE_2_SCHGTAX_DESC', 'Choisissez le taux d&apos;imposition désiré');
define('MODULE_PAYMENT_BILLSAFE_2_MP', 'Site marchand');
define('MODULE_PAYMENT_BILLSAFE_2_BUTTON', 'Aller à BillSAFE');
define('MODULE_PAYMENT_BILLSAFE_2_DPAYMENT', 'Paiement direct par le client');
define('MODULE_PAYMENT_BILLSAFE_2_REPORT_DPAYMENT', 'Transmettre le paiement direct maintenant');
define('MODULE_PAYMENT_BILLSAFE_2_MESSAGE_DPAYMENT', 'La transmission du paiement direct a été couronnée de succès');
define('MODULE_PAYMENT_BILLSAFE_2_DAY', 'Jour');
define('MODULE_PAYMENT_BILLSAFE_2_MONTH', 'Mois');
define('MODULE_PAYMENT_BILLSAFE_2_YEAR', 'Année');
define('MODULE_PAYMENT_BILLSAFE_2_LAYER_TITLE', 'Couche de paiement');
define('MODULE_PAYMENT_BILLSAFE_2_LAYER_DESC', 'Souhaitez-vous activer le mode couche pour les paiements via BillSAFE ?<b>Il est absolument nécessaire de désactiver<i>Force Cookie Use</i> dans les réglages <i>Sessions</i> !</b>');
?>
