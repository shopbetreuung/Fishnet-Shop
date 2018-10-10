<?php
/* -----------------------------------------------------------------------------------------
$Id: print_intraship_label.php v1.10 20.11.2013 nb $   

Autor: Nico Bauer (c) 2010-2013 Amber Holding GmbH for DHL Vertriebs GmbH & Co. OHG

Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html] 
-----------------------------------------------------------------------------------------
based on:

zones.php

(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(zones.php,v 1.19 2003/02/05); www.oscommerce.com 
(c) 2003     nextcommerce (zones.php,v 1.7 2003/08/24); www.nextcommerce.org

Released under the GNU General Public License 
-----------------------------------------------------------------------------------------*/

define('NUMBER_OF_ZONES',3); 

define('MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE', 'Frais d&apos;expédition');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_DESCRIPTION', 'Expédition par DHL Allemagne');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_WAY', '');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_DHLGKAPI_INVALID_ZONE', 'Il n&apos;y a pas de livraison possible dans ce pays !');
define('MODULE_SHIPPING_DHLGKAPI_UNDEFINED_RATE', 'Les frais d&apos;expédition ne peuvent pas être calculés pour le moment.');

define('MODULE_SHIPPING_DHLGKAPI_STATUS_TITLE' , 'Activer DHLGKAPI');
define('MODULE_SHIPPING_DHLGKAPI_STATUS_DESC' , 'Souhaitez-vous proposer la livraison par DHLGKAPI ?');
define('MODULE_SHIPPING_DHLGKAPI_ALLOWED_TITLE' , 'Zones d&apos;expédition autorisées');
define('MODULE_SHIPPING_DHLGKAPI_ALLOWED_DESC' , 'Précisez <b>individuellement </b> les zones dans lesquelles l&apos;expédition devrait être possible. (p.ex. AT,DE (laissez ce champ vide si vous voulez autoriser toutes les zones))');
define('MODULE_SHIPPING_DHLGKAPI_TAX_CLASS_TITLE' , 'Catégorie fiscale');
define('MODULE_SHIPPING_DHLGKAPI_TAX_CLASS_DESC' , 'Appliquez la classe de taxe suivante aux frais d&apos;expédition');
define('MODULE_SHIPPING_DHLGKAPI_SORT_ORDER_TITLE' , 'Ordre de classement');
define('MODULE_SHIPPING_DHLGKAPI_SORT_ORDER_DESC' , 'Séquence d&apos;affichage');

define('MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_DE', serialize(array('V01PAK', 'V53WPAK(Z1)', 'V53WPAK(Z2)', 'V53WPAK(Z3)', 'V53WPAK(Z4)')));
define('MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_AT', serialize(array('V86PARCEL', 'V87PARCEL', 'V82PARCEL')));

define('MODULE_SHIPPING_DHLGKAPI_DAYNAMES', serialize(array('Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa')));
define('MODULE_SHIPPING_DHLGKAPI_NO_PREFERENCE', 'égal');

//Deutschland
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V01PAK_TITLE', 'DHL Paket National');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z1)_TITLE', 'DHL Paket International Zone 1 (EU)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z2)_TITLE', 'DHL Paket International Zone 2 (Europa ohne EU)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z3)_TITLE', 'DHL Paket International Zone 3 (Welt)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z4)_TITLE', 'DHL Paket International Zone 4 (Rest Welt)');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_TITLE', 'Votre colis DHL <br />transporté comme vous le souhaitez.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_DESC', 'Avec les services DHL Wunschpaket, vous décidez où et quand vous voulez recevoir vos colis. Sélectionnez l&apos;option de livraison que vous préférez :');
define('MODULE_SHIPPING_DHLGKAPI_PL_TITLE', '<u>oder</u><br /><br />Emplacement souhaité');
define('MODULE_SHIPPING_DHLGKAPI_PL_DESC', 'Livraison au lieu de stockage');
define('MODULE_SHIPPING_DHLGKAPI_PL_TOOLTIP', 'Déterminez un endroit protégé contre les intempéries et invisible sur votre propriété &#10;où nous pouvons déposer le colis pendant votre absence.');
define('MODULE_SHIPPING_DHLGKAPI_PL_PLACEHOLDER', 'Nom,rue,numéro maison');
define('MODULE_SHIPPING_DHLGKAPI_PN_TITLE', 'Voisin de votre choix');
define('MODULE_SHIPPING_DHLGKAPI_PN_DESC', 'Livrez le colis au voisin de votre choix.');
define('MODULE_SHIPPING_DHLGKAPI_PN_TOOLTIP', 'Choisissez une personne dans votre voisinage immédiat où nous pouvons déposer votre colis &#10 ; Cette personne devrait vivre dans la même maison, directement en face ou à côté.');
define('MODULE_SHIPPING_DHLGKAPI_PN_PLACEHOLDER', 'p.ex. garage, terrasse');
define('MODULE_SHIPPING_DHLGKAPI_PT_TITLE', 'l&apos;heure que vous préférez ');
define('MODULE_SHIPPING_DHLGKAPI_PT_DESC', 'Livraison dans les délais souhaités');
define('MODULE_SHIPPING_DHLGKAPI_PT_TOOLTIP', 'Pour vous aider à mieux planifier, vous avez la possibilité de choisir l&apos;heure de livraison souhaitée.&#10;Vous pouvez choisir l&apos;une des heures indiquées pour la livraison.');
define('MODULE_SHIPPING_DHLGKAPI_PD_TITLE', 'Jour souhaité');
define('MODULE_SHIPPING_DHLGKAPI_PD_DESC', 'Livraison le jour souhaité');
define('MODULE_SHIPPING_DHLGKAPI_PD_TOOLTIP', 'Vous avez la possibilité de choisir l&apos;un des jours affichés comme jour souhaité pour la livraison de vos marchandises. &#10 ; D&apos;autres jours ne sont actuellement pas possibles en raison des processus de livraison. ');
define('MODULE_SHIPPING_DHLGKAPI_PSF_TITLE', 'Trouver une gare postale ou une succursale postale');
define('MODULE_SHIPPING_DHLGKAPI_PSF_DESC', 'Ou choisissez la livraison à un magasin de colis ou à une succursale postale.');
define('MODULE_SHIPPING_DHLGKAPI_PSF_BUTTON', 'Ou choisissez la livraison à un magasin de colis ou à une succursale postale.');

//Österreich
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V86PARCEL_TITLE', 'DHL Paket Austria');                                                                                    
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V87PARCEL_TITLE', 'DHL Paket Connect Europa');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z1)_TITLE', 'DHL Paket International EU');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z2)_TITLE', 'DHL Paket International Welt');

foreach (unserialize(MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_DE) as $type) {
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED_TITLE' , '<br /><br /><u>Versandzone '.constant('MODULE_SHIPPING_DHLGKAPI_TYPE_'.$type.'_TITLE').' (API Produkt: '.preg_replace("/\([\w]*\)/","",$type).')</u><br /><br />Zone erlaubt');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED_DESC' , '');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ATTENDANCE_TITLE' , 'Participation');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ATTENDANCE_DESC' , '2 chiffres, pour la procédure (produit) : '.substr(preg_replace("/[^0-9]/","",$type),0,2));
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES_TITLE' , 'États');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES_DESC' , 'Liste séparée par des virgules des codes de pays ISO 3166-1 alpha-2 (2 caractères).');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST_TITLE' , 'Frais d&apos;expédition');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST_DESC' , 'Frais d&apos;expédition par zone '.$type.' Destinations, sur la base d&apos;un groupe de poids max. de commande. Exemple : 3:8.50,7:10.50,..... Un poids inférieur ou égal à 3 équivaudrait à 8.50 pour la zone. '.$type.' .');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING_TITLE' , 'Frais de manutention');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING_DESC' , 'Frais de manutention pour cette zone d&apos;expédition');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT_TITLE' , 'Livraison gratuite');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT_DESC' , 'à partir de ce montant');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_RETOURE_ATTENDANCE_TITLE' , 'Participation pour Retoure');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_RETOURE_ATTENDANCE_DESC' , '2 chiffres (0 = pas Retoure pour ce produit)');
}


define('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED_TITLE','<u>Envoi d&apos;avis par courriel</u><br /><br />eMail par Boutique en ligne');
define('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED_DESC','Aviser le client au moment de l&apos;expédition');
define('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED_TITLE','DHL eMail');
define('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED_DESC','DHL envoie un message d&apos;état.');
define('MODULE_SHIPPING_DHLGKAPI_EKP_TITLE','<u>Données d&apos;accès au "DHL Geschäftskundenportal"</u><br><br>EKP');
define('MODULE_SHIPPING_DHLGKAPI_EKP_DESC','Entrez ici votre EKP (numéro de client)');
define('MODULE_SHIPPING_DHLGKAPI_USER_TITLE','Nom d&apos;utilisateur');
define('MODULE_SHIPPING_DHLGKAPI_USER_DESC','pour le DHL "Geschäftskundenportal"');
define('MODULE_SHIPPING_DHLGKAPI_PASSWORD_TITLE','Mot de passe');
define('MODULE_SHIPPING_DHLGKAPI_PASSWORD_DESC','pour le DHL "Geschäftskundenportal"');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME_TITLE','<u>Expéditeur</u><br><br>Nom');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME_TITLE','Rue');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER_TITLE','No. de maison');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP_TITLE','Code postal');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY_TITLE','Ville');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY_TITLE','Pays');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY_DESC','ISO 3166-1 alpha-2 Ländercode');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED_TITLE','<a class="button" href="#" onClick="window.open(\'dhlgkapi_print_label.php?testlabel=on&oID=0\',\'_blank\',\'toolbar=0,location=0,directories=0,status=1,menubar=0,titlebar=0,scrollbars=1,resizable=1,width=600,height=400\')">Tester la configuration</a>&nbsp;<span class="">(doivent être stockées au préalable)</span><br /><br /><u>Créer une étiquette de retour</u>');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_NAME_TITLE','Adresse de renvoi<br><br>Nom');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_NAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME_TITLE','Rue');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER_TITLE','No. de maison');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP_TITLE','Code postal');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_CITY_TITLE','Ville');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_CITY_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY_TITLE','Pays');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY_DESC','ISO 3166-1 alpha-2 Ländercode');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON_TITLE','Contact local');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL_TITLE','eMail');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE_TITLE','Téléphone');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_COD_ENABLED_TITLE','<u>Contre-remboursement</u><br /><br />Contre-remboursement autorisé');
define('MODULE_SHIPPING_DHLGKAPI_COD_ENABLED_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE_TITLE','Module de paiement pour contre-remboursement');
define('MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE_DESC','nom du module interne');
define('MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE_TITLE','Frais de livraison');
define('MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE_DESC','facturés par DHL');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER_TITLE','Données de compte pour contre-remboursement<br><br>Titulaire du compte');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME_TITLE','Nom de la banque');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME_DESC','');        
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN_TITLE','IBAN');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC_TITLE','BIC');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED_TITLE','<u>Modification du statut de la commande d&apos;achat</u><br><br>Versendet');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED_DESC' , 'Statut de la commande après la création de l&apos;étiquette d&apos;expédition');   
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED_TITLE' , 'Revirement');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED_DESC' , 'Statut de la commande après annulation de l&apos;étiquette d&apos;expédition');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_ENABLED_TITLE', '<u>Wunschpaket</u><br /><br />Wunschpaket permis');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_ENABLED_DESC', 'active les services Date de livraison, Heure de livraison, Lieu de livraison, Lieu de livraison, Livraison au voisin.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME_TITLE', 'Wunschpaket délai de livraison');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME_DESC', 'Jusqu&apos;à quelle heure de commande, les colis sont-ils expédiés le même jour ?');
?>
