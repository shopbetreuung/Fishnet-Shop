<?php
/* -----------------------------------------------------------------------------------------
   $Id: billsafe_2hp.php 4200 2013-01-10 19:47:11Z Tomcraft1980 $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   Copyright (c) 2013 PayPal SE and Bernd Blazynski

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

/*
* id = billsafe_2hp.php
* location = /lang/english/modules/payment
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

define('MODULE_PAYMENT_BILLSAFE_2HP_TEXT_TITLE', 'vente à tempérament');
define('MODULE_PAYMENT_BILLSAFE_2HP_CHECKOUT_TEXT_INFO', 'Achetez confortablement et rapidement en %d à partir de  %s Euro per month. <br />(taux d&apos;intérêt annuel effectif : %s%%)');
define('MODULE_PAYMENT_BILLSAFE_2HP_ERROR_MESSAGE_COMMON', 'Désolé, vente à tempérament n&apos;est pas possible. Veuillez choisir un autre mode de paiement.');
define('MODULE_PAYMENT_BILLSAFE_2HP_ERROR_MESSAGE_101', 'L&apos;achat à tempérament n&apos;est pas possible pour l&apos;instant, veuillez sélectionner un autre mode de paiement.');
define('MODULE_PAYMENT_BILLSAFE_2HP_ERROR_MESSAGE_102', 'Une erreur s&apos;est produite lors du traitement des données. N&apos;hésitez pas à nous contacter.');
define('MODULE_PAYMENT_BILLSAFE_2HP_ERROR_MESSAGE_215', 'Il manquait des paramètres lors du traitement des données. N&apos;hésitez pas à nous contacter.');
define('MODULE_PAYMENT_BILLSAFE_2HP_ERROR_MESSAGE_216', 'Il y avait des paramètres invalides pendant le traitement des données. N&apos;hésitez pas à nous contacter.');
define('MODULE_PAYMENT_BILLSAFE_2HP_ERROR_MESSAGE_COMPANY', 'Vente à tempérament n&apos;est malheureusement possible que pour les particuliers.');
define('MODULE_PAYMENT_BILLSAFE_2HP_ERROR_MESSAGE_ADDRESS', 'Vente à tempérament n&apos;est malheureusement pas possible avec une autre adresse de livraison.');
define('MODULE_PAYMENT_BILLSAFE_2HP_STATUS_TEXT', 'Status');
define('MODULE_PAYMENT_BILLSAFE_2HP_TRANSACTIONID', 'ID de transaction BillSAFE');
define('MODULE_PAYMENT_BILLSAFE_2HP_CODE_TEXT', 'Code');
define('MODULE_PAYMENT_BILLSAFE_2HP_MESSAGE_TEXT', 'Message');
define('MODULE_PAYMENT_BILLSAFE_2HP_TEXT_DESCRIPTION', '<img src="images/icon_popup.gif" border="0">&nbsp;<a href="https://www.billsafe.de" target="_blank" rel="noopener" style="text-decoration: underline; font-weight: bold;" />Visitez le site Web de BillSAFE</a>');
define('MODULE_PAYMENT_BILLSAFE_2HP_STATUS_TITLE', 'Activer le module vente à tempérament BillSAFE');
define('MODULE_PAYMENT_BILLSAFE_2HP_STATUS_DESC', 'Voulez-vous accepter vente à tempérament avec BillSAFE ?');
define('MODULE_PAYMENT_BILLSAFE_2HP_MERCHANT_ID_TITLE', 'Merchant ID');
define('MODULE_PAYMENT_BILLSAFE_2HP_MERCHANT_ID_DESC', 'L&apos;identifiant du commerçant à utiliser pour le service API BillSAFE.');
define('MODULE_PAYMENT_BILLSAFE_2HP_MERCHANT_LICENSE_TITLE', 'Merchant License');
define('MODULE_PAYMENT_BILLSAFE_2HP_MERCHANT_LICENSE_DESC', 'La licence commerçant à utiliser pour le service de l&apos;API BillSAFE.');
define('MODULE_PAYMENT_BILLSAFE_2HP_MIN_ORDER_TITLE', 'Valeur minimale de commande');
define('MODULE_PAYMENT_BILLSAFE_2HP_MIN_ORDER_DESC', 'BillSAFE Valeur minimale de commande');
define('MODULE_PAYMENT_BILLSAFE_2HP_MAX_ORDER_TITLE', 'Valeur maximale de commande');
define('MODULE_PAYMENT_BILLSAFE_2HP_MAX_ORDER_DESC', 'BillSAFE Valeur maximale de commande');
define('MODULE_PAYMENT_BILLSAFE_2HP_BILLSAFE_LOGO_URL_DESC', 'BillSAFE Logo URL');
define('MODULE_PAYMENT_BILLSAFE_2HP_BILLSAFE_LOGO_URL_TITLE', 'BillSAFE Logo URL');
define('MODULE_PAYMENT_BILLSAFE_2HP_SHOP_LOGO_URL_DESC', 'Shop Logo URL');
define('MODULE_PAYMENT_BILLSAFE_2HP_SHOP_LOGO_URL_TITLE', 'Shop Logo URL');
define('MODULE_PAYMENT_BILLSAFE_2HP_SHOP_LOGO_URL_DESC', 'Emplacement du logo de la boutique.');
define('MODULE_PAYMENT_BILLSAFE_2HP_SERVER_TITLE', 'BillSAFE Server');
define('MODULE_PAYMENT_BILLSAFE_2HP_SERVER_DESC', 'Utiliser le serveur de passerelle en direct ou de test (sandbox) pour traiter les factures ?');
define('MODULE_PAYMENT_BILLSAFE_2HP_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_BILLSAFE_2HP_ZONE_DESC', 'Si une zone est sélectionnée, n&apos;activez ce mode de paiement que pour cette zone.');
define('MODULE_PAYMENT_BILLSAFE_2HP_ORDER_STATUS_ID_TITLE', 'Définissez le statut des commandes ');
define('MODULE_PAYMENT_BILLSAFE_2HP_ORDER_STATUS_ID_DESC', 'Définissez le statut des commandes passées avec ce module de paiement à cette valeur.');
define('MODULE_PAYMENT_BILLSAFE_2HP_SORT_ORDER_TITLE', 'Ordre de tri de l&apos;affichage. ');
define('MODULE_PAYMENT_BILLSAFE_2HP_SORT_ORDER_DESC', 'Ordre de tri de l&apos;affichage. Le plus bas est affiché en premier.');
define('MODULE_PAYMENT_BILLSAFE_2HP_ALLOWED_TITLE', 'Zones autorisées');
define('MODULE_PAYMENT_BILLSAFE_2HP_ALLOWED_DESC', 'Veuillez entrer séparément les zones qui devraient être autorisées à utiliser ce module (par exemple DE, AT (laissez vide si vous voulez autoriser toutes les zones)).');
define('MODULE_PAYMENT_BILLSAFE_2HP_MESSAGE_FSHIPMENT', 'L&apos;expédition complète a été couronnée de succès.');
define('MODULE_PAYMENT_BILLSAFE_2HP_MESSAGE_PSHIPMENT', 'L&apos;expédition partielle a été couronnée de succès.');
define('MODULE_PAYMENT_BILLSAFE_2HP_MESSAGE_FSTORNO', 'L&apos;annulation complète a été couronnée de succès');
define('MODULE_PAYMENT_BILLSAFE_2HP_MESSAGE_PSTORNO', 'L&apos;annulation partielle a été couronnée de succès.');
define('MODULE_PAYMENT_BILLSAFE_2HP_MESSAGE_FRETOURE', 'Les retours complets ont été couronnés de succès');
define('MODULE_PAYMENT_BILLSAFE_2HP_MESSAGE_PRETOURE', 'Les retours partiels ont été couronnés de succès');
define('MODULE_PAYMENT_BILLSAFE_2HP_MESSAGE_VOUCHER', 'Le crédit a été couronné de succès');
define('MODULE_PAYMENT_BILLSAFE_2HP_MESSAGE_PAUSETRANSACTION', 'La pause de paiement a été couronnée de succès');
define('MODULE_PAYMENT_BILLSAFE_2HP_DETAILS', 'BillSAFE details');
define('MODULE_PAYMENT_BILLSAFE_2HP_BADDRESS', 'Adresse de facturation (BillSAFE)');
define('MODULE_PAYMENT_BILLSAFE_2HP_SADDRESS', 'Adresse de livraison');
define('MODULE_PAYMENT_BILLSAFE_2HP_EMAIL', 'E-mail');
define('MODULE_PAYMENT_BILLSAFE_2HP_PDETAILS', 'Détails de l&apos;achat de vente à tempérament');
define('MODULE_PAYMENT_BILLSAFE_2HP_NOTE', 'Note');
define('MODULE_PAYMENT_BILLSAFE_2HP_PRODUCTS', 'Produits');
define('MODULE_PAYMENT_BILLSAFE_2HP_MODEL', 'N° d&apos;article');
define('MODULE_PAYMENT_BILLSAFE_2HP_TAX', 'TVA');
define('MODULE_PAYMENT_BILLSAFE_2HP_PRICE_EX', 'Prix (excl.)');
define('MODULE_PAYMENT_BILLSAFE_2HP_PRICE_INC', 'Prix (incl.)');
define('MODULE_PAYMENT_BILLSAFE_2HP_CHECK', 'Choisir');
define('MODULE_PAYMENT_BILLSAFE_2HP_INC', 'incl. ');
define('MODULE_PAYMENT_BILLSAFE_2HP_FREPORT_SHIPMENT', 'Rapporter l&apos;expédition complète');
define('MODULE_PAYMENT_BILLSAFE_2HP_PREPORT_SHIPMENT', 'Déclarer un envoi partiel');
define('MODULE_PAYMENT_BILLSAFE_2HP_UPDATEARTICLELISTSTORNOFULL', 'Annulation complète');
define('MODULE_PAYMENT_BILLSAFE_2HP_UPDATEARTICLELISTSTORNOPART', 'Annulation partielle');
define('MODULE_PAYMENT_BILLSAFE_2HP_UPDATEARTICLELISTRETOUREFULL', 'Retours complets');
define('MODULE_PAYMENT_BILLSAFE_2HP_UPDATEARTICLELISTRETOUREPART', 'Retours partiels');
define('MODULE_PAYMENT_BILLSAFE_2HP_UPDATEARTICLELISTVOUCHER', 'Crédit');
define('MODULE_PAYMENT_BILLSAFE_2HP_PREPORT_METHOD', 'méthode');
define('MODULE_PAYMENT_BILLSAFE_2HP_PREPORT_DATE', 'Date');
define('MODULE_PAYMENT_BILLSAFE_2HP_JALERT', 'Veuillez sélectionner au moins un produit pour une expédition partielle.');
define('MODULE_PAYMENT_BILLSAFE_2HP_NO_ORDERID', 'ID de commande non trouvé.');
define('MODULE_PAYMENT_BILLSAFE_2HP_VAT', '% VAT');
define('MODULE_PAYMENT_BILLSAFE_2HP_VALUE', 'sous-total');
define('MODULE_PAYMENT_BILLSAFE_2HP_LOG_TITLE', 'Activer l&apos;enregistrement');
define('MODULE_PAYMENT_BILLSAFE_2HP_LOG_DESC', 'Utilisez les réponses du serveur BillSAFE pour le dépannage.');
define('MODULE_PAYMENT_BILLSAFE_2HP_LOG_TYPE_TITLE', 'Type de journal : Echo, envoyer le journal par e-mail ou enregistrer sous forme de fichier dans le chemin d&apos;accès "/export".');
define('MODULE_PAYMENT_BILLSAFE_2HP_LOG_TYPE_DESC', '<b>Note</b>: "Echo" à des fins de test dans la zone admin seulement. <b>Aucune commande possible !</b>');
define('MODULE_PAYMENT_BILLSAFE_2HP_LOG_ADDR_TITLE', 'Adresse(s) électronique(s) où envoyer le fichier journal');
define('MODULE_PAYMENT_BILLSAFE_2HP_LOG_ADDR_DESC', 'Pour plus d&apos;une adresse e-mail séparée par  ",".');
define('MODULE_PAYMENT_BILLSAFE_2HP_MP', 'Site marchand');
define('MODULE_PAYMENT_BILLSAFE_2HP_BUTTON', 'Aller à BillSAFE');
define('MODULE_PAYMENT_BILLSAFE_2HP_LAYER_TITLE', 'Couche de paiement');
define('MODULE_PAYMENT_BILLSAFE_2HP_LAYER_DESC', 'Souhaitez-vous activer le mode couche pour les paiements via BillSAFE ? <b>Note:  Il est absolument nécessaire de désactiver <i>Force Cookie Use</i> dans les paramètres de Sessions !!</b>');
?>