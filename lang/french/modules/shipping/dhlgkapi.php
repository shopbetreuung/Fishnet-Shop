<?php
/* -----------------------------------------------------------------------------------------
$Id: dhlgkapi_print_label.php v2.0 23.11.2017 nb $   

Autor: Nico Bauer (c) 2016-2017 D�rfelt GmbH for DHL Paket GmbH

Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html]
-----------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE', 'DHL y compris le forfait de votre choix');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_TITLE_NO_WS', 'DHL');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_DESCRIPTION', 'DHL Expédition, y compris les services aux destinataires');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_WAY', '');
define('MODULE_SHIPPING_DHLGKAPI_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_DHLGKAPI_INVALID_ZONE', 'Il n&apos;y a pas d&apos;expédition possible vers ce pays.!');
define('MODULE_SHIPPING_DHLGKAPI_UNDEFINED_RATE', 'Les frais d&apos;expédition ne peuvent pas être calculés pour le moment.');

define('MODULE_SHIPPING_DHLGKAPI_STATUS_TITLE' , 'Activer DHLGKAPI');
define('MODULE_SHIPPING_DHLGKAPI_STATUS_DESC' , 'Vous souhaitez proposer le mode d&apos;expédition DHLGKAPI ?');
define('MODULE_SHIPPING_DHLGKAPI_ALLOWED_TITLE' , 'Zones d&apos;expédition autorisées');
define('MODULE_SHIPPING_DHLGKAPI_ALLOWED_DESC' , 'Spécifiez <b>individuellement </b> les zones dans lesquelles l&apos;expédition doit être possible. (p.ex. AT,DE (laissez ce champ vide si vous voulez autoriser toutes les zones)))');
define('MODULE_SHIPPING_DHLGKAPI_TAX_CLASS_TITLE' , 'catégorie fiscale');
define('MODULE_SHIPPING_DHLGKAPI_TAX_CLASS_DESC' , 'Appliquez la classe de taxe suivante aux frais d&apos;expédition');
define('MODULE_SHIPPING_DHLGKAPI_SORT_ORDER_TITLE' , 'ordre de classement');
define('MODULE_SHIPPING_DHLGKAPI_SORT_ORDER_DESC' , 'Séquence d&apos;affichage');

define('MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_DE', serialize(array('V01PAK', 'V53WPAK(Z1)', 'V53WPAK(Z2)', 'V53WPAK(Z3)', 'V53WPAK(Z4)', 'V53WPAK(Z5)', 'V53WPAK(Z6)')));
define('MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_AT', serialize(array('V86PARCEL', 'V87PARCEL', 'V82PARCEL(Z1)', 'V82PARCEL(Z2)', 'V82PARCEL(Z3)', 'V82PARCEL(Z4)')));

define('MODULE_SHIPPING_DHLGKAPI_DAYNAMES', serialize(array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa')));
define('MODULE_SHIPPING_DHLGKAPI_DAYNAMES_SHOWN', serialize(array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa')));
define('MODULE_SHIPPING_DHLGKAPI_NO_PREFERENCE', 'aucun<br />énoncé');

//Deutschland
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V01PAK_TITLE', 'DHL Parcel National');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z1)_TITLE', 'DHL Paket International Zone 1 (EU)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z2)_TITLE', 'DHL Paket International Zone 2 (Europe without EU)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z3)_TITLE', 'DHL Paket International Zone 5 (World 1)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z4)_TITLE', 'DHL Paket International Zone 5 (World 2)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z5)_TITLE', 'DHL Paket International Zone 5 (World 3)');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V53WPAK(Z6)_TITLE', 'DHL Paket International Zone 5 (World 4)');

//Texte f�r Frontend
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_TITLE', 'Votre colis DHL <br />Envoyé comme demandé.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_DESC', 'Avec les services DHL Wunschpaket, vous décidez où et quand vous voulez recevoir vos colis. Sélectionnez votre option de livraison préférée:');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TEXT_OR', 'ou');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_ADDRESS_CHANGE', 'L&apos;adresse de livraison a été modifiée. Veuillez sélectionner à nouveau vos options de livraison préférées.');
define('MODULE_SHIPPING_DHLGKAPI_PL_TITLE', 'Emplacement souhaité : livraison à l&apos;emplacement de stockage souhaité');
define('MODULE_SHIPPING_DHLGKAPI_PL_DESC', '');
define('MODULE_SHIPPING_DHLGKAPI_PL_TOOLTIP', 'Déterminez un endroit à l&apos;épreuve des intempéries et invisible sur votre propriété où nous pouvons déposer le colis pendant votre absence..');
define('MODULE_SHIPPING_DHLGKAPI_PL_PLACEHOLDER', 'p.ex. garage, terrasse');
define('MODULE_SHIPPING_DHLGKAPI_PN_TITLE', 'Souhaite voisin : Livraison au voisin de votre choix');
define('MODULE_SHIPPING_DHLGKAPI_PN_DESC', '');
define('MODULE_SHIPPING_DHLGKAPI_PN_TOOLTIP', 'Identifiez une personne dans votre voisinage immédiat où nous pouvons déposer votre colis pendant votre absence, elle doit habiter dans la même maison, directement en face ou à côté.');
define('MODULE_SHIPPING_DHLGKAPI_PN_PLACEHOLDER1', 'Nom, prénom, prénom');
define('MODULE_SHIPPING_DHLGKAPI_PN_PLACEHOLDER2', 'Adresse, code postal, ville');
define('MODULE_SHIPPING_DHLGKAPI_PT_TITLE', 'Délai souhaité : livraison dans la fenêtre de temps souhaitée');
define('MODULE_SHIPPING_DHLGKAPI_PT_DESC', 'Pour ce service, il y a un supplément de prix:');
define('MODULE_SHIPPING_DHLGKAPI_PT_TOOLTIP', 'Afin que vous puissiez mieux planifier, vous avez la possibilité de sélectionner une heure souhaitée pour la livraison. Vous pouvez sélectionner l&apos;une des heures indiquées pour la livraison.');
define('MODULE_SHIPPING_DHLGKAPI_PD_TITLE', 'Jour désiré : Livraison le jour désiré');
define('MODULE_SHIPPING_DHLGKAPI_PD_DESC', 'Pour ce service, il y a un supplément de prix:');
define('MODULE_SHIPPING_DHLGKAPI_PD_TOOLTIP', 'Vous avez la possibilité de choisir l&apos;un des jours indiqués comme jour souhaité pour la livraison de vos marchandises. D&apos;autres jours ne sont actuellement pas possibles en raison des processus de livraison.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_HINT', 'Si vous réservez le jour et l&apos;heure désirés en combinaison, vous devrez payer des frais d&apos;expédition supplémentaires.:');
define('MODULE_SHIPPING_DHLGKAPI_PSF_TITLE', 'Trouver une gare postale ou une succursale postale');
define('MODULE_SHIPPING_DHLGKAPI_PSF_DESC', 'Ou choisissez la livraison à une station d&apos;emballage ou à une succursale..');
define('MODULE_SHIPPING_DHLGKAPI_PSF_BUTTON', 'Ou choisissez la livraison à une station d&apos;emballage ou à une succursale..');

//�sterreich
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V86PARCEL_TITLE', 'DHL Paket Autriche');                                                                                    
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V87PARCEL_TITLE', 'DHL Paket Connect Europe');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z1)_TITLE', 'DHL Paket International EU');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z2)_TITLE', 'DHL Paket International World 1');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z3)_TITLE', 'DHL Paket International World 2');
define('MODULE_SHIPPING_DHLGKAPI_TYPE_V82PARCEL(Z4)_TITLE', 'DHL Paket International World 3');

foreach (unserialize(MODULE_SHIPPING_DHLGKAPI_PRODUCTS_TYPES_DE) as $type) {
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED_TITLE' , '<br /><br /><u>zone de livraison '.constant('MODULE_SHIPPING_DHLGKAPI_TYPE_'.$type.'_TITLE').' (API Produkt: '.preg_replace("/\([\w]*\)/","",$type).')</u><br /><br />Zone erlaubt');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ENABLED_DESC' , '');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ATTENDANCE_TITLE' , 'fréquentation');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_ATTENDANCE_DESC' , '2 chiffres, jusqu&apos;à Procédure (produit): '.substr(preg_replace("/[^0-9]/","",$type),0,2).'<br />(Les deux derniers chiffres du numéro de facturation du produit.)');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES_TITLE' , 'L&auml;nder');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COUNTRIES_DESC' , 'Liste séparée par des virgules des sous-codes L&auml;ndercodes alpha-2 de l&apos;ISO 3166-1 (2 caractères).');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST_TITLE' , 'frais d&apos;expédition');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_COST_DESC' , 'Frais d&apos;expédition par zone '.$type.' Destinations, sur la base d&apos;un groupe de poids max. de commande. Exemple : 3:8.50,7:10.50,..... Poids inférieur ou égal à 3 serait de 8.50 pour la zone '.$type.' Coût de destination.');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING_TITLE' , 'Frais de manutention');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_HANDLING_DESC' , 'Manutention du conteneur pour cette zone d&apos;expédition');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT_TITLE' , 'Livraison gratuite');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_FREEAMOUNT_DESC' , 'de ce montant');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_RETOURE_ATTENDANCE_TITLE' , 'Participation pour les retours');
    define('MODULE_SHIPPING_DHLGKAPI_'.$type.'_RETOURE_ATTENDANCE_DESC' , '2-chiffre (0 = Aucun retour pour ce produit)');
}


define('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED_TITLE','<u>Envoi d&apos;avis par courriel</u><br /><br />Boutique eMail');
define('MODULE_SHIPPING_DHLGKAPI_EMAIL_ENABLED_DESC','Aviser le client au moment de l&apos;expédition');
define('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED_TITLE','DHL eMail');
define('MODULE_SHIPPING_DHLGKAPI_DHL_EMAIL_ENABLED_DESC','DHL envoie un message d&apos;état');

define('MODULE_SHIPPING_DHLGKAPI_EMAIL_TIME_TITLE','Heure limite d&apos;envoi des courriels');
define('MODULE_SHIPPING_DHLGKAPI_EMAIL_TIME_DESC','Les étiquettes imprimées jusqu&apos;à cette heure sont envoyées le jour même..');

define('MODULE_SHIPPING_DHLGKAPI_EKP_TITLE','<ul>Données d&apos;accès au portail clients d&apos;affaires </u>br><br><br>EKP');
define('MODULE_SHIPPING_DHLGKAPI_EKP_DESC','Entrez ici votre EKP (numéro de client)');
define('MODULE_SHIPPING_DHLGKAPI_USER_TITLE','nom d&apos;utilisateur');
define('MODULE_SHIPPING_DHLGKAPI_USER_DESC','pour le portail des entreprises clientes');
define('MODULE_SHIPPING_DHLGKAPI_PASSWORD_TITLE','Mot de passe');
define('MODULE_SHIPPING_DHLGKAPI_PASSWORD_DESC','pour le portail des entreprises clientes');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME_TITLE','<u>expéditeur</u><br><br>Nom');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_NAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME_TITLE','rue');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER_TITLE','numéro de maison');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_STREETNUMBER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP_TITLE','code postal');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_ZIP_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY_TITLE','ville');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_CITY_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY_TITLE','Terrain');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPER_COUNTRY_DESC','ISO 3166-1 alpha-2 L&auml;ndercode');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED_TITLE','<a class="button" href="#" onClick="window.location.href=\'dhlgkapi_print_label.php?testlabel=on&oID=0\'">Konfiguration testen</a>&nbsp;<span class=""><br />(Muss zuvor gespeichert werden.<br />Evtl. noch Teilnahme V01PAK anpassen.)</span><br /><br /><u>R&uuml;cksendeetikett erstellen</u>');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ENABLED_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_NAME_TITLE','R&uuml;cksendeadresse<br><br>Name');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_NAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME_TITLE','rue');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNAME_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER_TITLE','numéro de maison');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_STREETNUMBER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP_TITLE','code postal');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_ZIP_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_CITY_TITLE','ville');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_CITY_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY_TITLE','Terrain');
define('MODULE_SHIPPING_DHLGKAPI_RETURN_COUNTRY_DESC','ISO 3166-1 alpha-2 indicatif de pays');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON_TITLE','contacter');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PERSON_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL_TITLE','eMail');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_EMAIL_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE_TITLE','Téléphone');
define('MODULE_SHIPPING_DHLGKAPI_CONTACT_PHONE_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_COD_ENABLED_TITLE','<u>Paiement à la livraison </u><br /><br />Cash on delivery autorisé');
define('MODULE_SHIPPING_DHLGKAPI_COD_ENABLED_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE_TITLE','Module de paiement pour contre-remboursement');
define('MODULE_SHIPPING_DHLGKAPI_COD_PAYMENT_MODULE_DESC','nom du module interne');
define('MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE_TITLE','Frais de livraison');
define('MODULE_SHIPPING_DHLGKAPI_COD_DHL_FEE_DESC','est facturé par DHL');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER_TITLE','Données de compte pour paiement à la livraison<br><br><br>titulaire du compte');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_ACCOUNTOWNER_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME_TITLE','Nom de la banque');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BANKNAME_DESC','');        
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN_TITLE','IBAN');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_IBAN_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC_TITLE','BIC');
define('MODULE_SHIPPING_DHLGKAPI_BANKDATA_BIC_DESC','');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED_TITLE','<u>Statut&changement de la commande </u><br><br><br>shipped');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_SHIPPED_DESC' , 'Statut de la commande après la création de l&apos;étiquette d&apos;expédition');   
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED_TITLE' , 'Storno');
define('MODULE_SHIPPING_DHLGKAPI_ORDERSTATUS_CANCELED_DESC' , 'Statut de la commande après annulation de l&apos;étiquette d&apos;expédition');

define('MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED_TITLE', '<u>API de contrôle des paquets </u><br /><br /><br />>utiliser l&apos;API');
define('MODULE_SHIPPING_DHLGKAPI_STRG_ENABLED_DESC', 'Consultez les services disponibles en ligne par code postal de livraison');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED_TITLE', '<u>emballage de souhaits </u><br /><br />br />jour de souhaits autorisé');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_ENABLED_DESC', 'active le service Jour de vœux');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST_TITLE', 'Jour désiré Coûts');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_COST_DESC', 'Entrez ici un supplément pour le jour de service souhaité.<br />Entrer 0 pour offrir le service gratuitement. Utiliser . comme point décimal');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_PAYMENT_EXCLUDE_TITLE', 'Méthodes de paiement exclues du jour souhaité');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_PAYMENT_EXCLUDE_DESC', 'Ces modes de paiement ne sont plus affichés dans la caisse lorsque le jour souhaité est sélectionné.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_STOCK_CHECK_TITLE', 'Jour désiré Envisager l&apos;inventaire');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_STOCK_CHECK_DESC', 'Seulement si le stock de tous les articles dans le panier est au moins égal à la quantité commandée, le jour désiré sera offert..');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_TITLE', 'Jour désiré Tenir compte du délai de livraison');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_DESC', 'Seulement si le délai de livraison de tous les articles dans le panier correspond aux informations suivantes, le jour souhaité est proposé');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_STATUS_TITLE', 'Wunschtag Jour souhaité Délai de livraison');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PD_DELIVERY_CHECK_STATUS_DESC', 'Statut de livraison des articles');

define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED_TITLE', 'Délai souhaité');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_ENABLED_DESC', 'Active le service Heure souhaitée');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_COST_TITLE', 'Temps souhaité Coûts');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_COST_DESC', 'Saisissez ici un supplément pour le service Wunschzeit.<br />Entrer 0 pour offrir le service gratuitement. Utilisez . comme point décimal.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_PAYMENT_EXCLUDE_TITLE', 'Modes de paiement exclus selon le temps désiré');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PT_PAYMENT_EXCLUDE_DESC', 'Ces modes de paiement ne sont plus affichés dans la caisse lorsque l&apos;heure souhaitée est sélectionnée.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST_TITLE', 'Jour désiré / Temps désiré Coûts');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PDPT_COST_DESC', 'Saisissez ici un supplément pour la combinaison des services souhaités (heure et jour). <br />Taper 0 pour offrir le service gratuitement. Utiliser . comme point décimal.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED_TITLE', 'Voisin autorisé');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_ENABLED_DESC', 'Active le service Voisin désiré');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_PAYMENT_EXCLUDE_TITLE', 'Modes de paiement exclus voisins');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PN_PAYMENT_EXCLUDE_DESC', 'Ces modes de paiement ne sont plus affichés dans la caisse lorsque vous sélectionnez un voisin.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED_TITLE', 'Choix du lieu de stockage autorisé');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_ENABLED_DESC', 'Active le service Emplacement de stockage souhaité');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_PAYMENT_EXCLUDE_TITLE', 'Lieu de stockage de votre choix Modes de paiement exclus');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_PL_PAYMENT_EXCLUDE_DESC', 'Ces modes de paiement ne sont plus affichés dans la caisse lorsque vous sélectionnez le magasin souhaité.');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME_TITLE', 'Heure limite d&apos;expédition');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_TIME_DESC', 'Jusqu&apos;à cette commande, les colis sont toujours envoyés le jour même. <br />Important pour le jour de votre choix!');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_BLACKLIST','"paketbox","packstation","postfach","postfiliale","filiale","postfiliale direkt","filiale direkt","paketkasten","dhl","p-a-c-k-s-t-a-t-i-o-n","paketstation","pack station","p.a.c.k.s.t.a.t.i.o.n.","pakcstation","paackstation","pakstation","backstation","bakstation","p a c k s t a t i o n","wunschfiliale","deutsche post","\'","\"","\/","[<>;+]"');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_FREEAMOUNT_COST_ENABLED_TITLE','Ajoutez toujours des coûts à votre forfait désiré');
define('MODULE_SHIPPING_DHLGKAPI_WUNSCHPAKET_FREEAMOUNT_COST_ENABLED_DESC','Les frais pour le colis désiré seront également ajoutés pour une livraison gratuite.');
define('MODULE_SHIPPING_DHLGKAPI_HOLIDAYS_TITLE', 'Vacances DHL');
define('MODULE_SHIPPING_DHLGKAPI_HOLIDAYS_DESC', 'Liste de dates séparées par des virgules dans le formulaire : TT.MM.<br />Il n&apos;y aura pas d&apos;enlèvement ou de livraison par DHL ces jours-là.');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPING_DAYS_TITLE', 'Jours de livraison');
define('MODULE_SHIPPING_DHLGKAPI_SHIPPING_DAYS_DESC', 'C&apos;est l&apos;époque de l&apos;expédition régulière.');
define('MODULE_SHIPPING_DHLGKAPI_PSF_ENABLED_TITLE','Recherche de colis aktivieren aktivieren');
define('MODULE_SHIPPING_DHLGKAPI_PSF_ENABLED_DESC','Affiche le lien vers l&apos;outil de recherche de colis dans l&apos;interface lors de la saisie d&apos;une nouvelle adresse de livraison.');
define('MODULE_SHIPPING_DHLGKAPI_UTF8_ENABLED_TITLE','UTF-8 aktivieren aktivieren');
define('MODULE_SHIPPING_DHLGKAPI_UTF8_ENABLED_DESC','Activé si le codage des caractères de la base de données est UTF-8.');

?>
