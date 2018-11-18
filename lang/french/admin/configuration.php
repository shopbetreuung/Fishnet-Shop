<?php
/* -----------------------------------------------------------------------------------------
   $Id: configuration.php  

   Fishnet Shopsoftware
   http://fishnet-shop.com

   Copyright (c) 2017 - 2019 [www.fishnet-shop.com]
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.8 2002/01/04); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/25); www.nextcommerce.org
   (c) 2006 XT-Commerce
   (c) 2013 Modified eCommerce (configuration.php 3130 2012-06-28 11:17:12Z Tomcraft1980 $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
// --- bof -- ipdfbill --------
define('IBN_BILLNR_TITLE', '[ibillnr] Numéro de facture suivant');       //ibillnr
define('IBN_BILLNR_DESC', 'Lorsqu&apos;une commande est facturée, ce numéro est ensuite attribué.'); 
define('IBN_BILLNR_FORMAT_TITLE', '[ibillnr] Invoicenumber Format');       //ibillnr
define('IBN_BILLNR_FORMAT_DESC', 'Format invoicenumber: {n}=number, {d}=day, {m}=month, {y}=year, <br>example. "100{n}-{d}-{m}-{y}" => "10099-28-02-2007"'); 
// --- eof -- ipdfbill --------    


define('TABLE_HEADING_CONFIGURATION_TITLE', 'Titre');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Valeur');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_EDIT_INTRO', 'Veuillez apporter tous les changements n&eacute;cessaires par l&rsquo;interm&eacute;diaire de');
define('TEXT_INFO_DATE_ADDED', 'ajoutées:');
define('TEXT_INFO_LAST_MODIFIED', 'dernière mise à jour:');

// language definitions for config
define('STORE_NAME_TITLE' , 'Nom Boutique');
define('STORE_NAME_DESC' , 'Le nom de cette boutique en ligne');
define('STORE_OWNER_TITLE' , 'Propriétaire');
define('STORE_OWNER_DESC' , 'Le nom du propriétaire de la boutique en ligne');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'Courrier électronique');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'L&apos;adresse e-mail du propriétaire de la boutique en ligne');

define('EMAIL_FROM_TITLE' , 'Courriel de');
define('EMAIL_FROM_DESC' , 'L&apos;adresse e-mail utilisée pour envoyer des e-mails..');

define('STORE_COUNTRY_TITLE' , 'Pays');
define('STORE_COUNTRY_DESC' , 'Le pays dans lequel mon magasin est situé  <br /><br /><b>Note : N&apos;oubliez pas de mettre à jour le district du magasin.</b>');
define('STORE_ZONE_TITLE' , 'Région');
define('STORE_ZONE_DESC' , 'e quartier où se trouve ma boutique en ligne.');

define('EXPECTED_PRODUCTS_SORT_TITLE' , 'Ordre de tri des produits attendus');
define('EXPECTED_PRODUCTS_SORT_DESC' , 'C&apos;est l&apos;ordre de tri utilisé dans la boîte des produits attendus.');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , 'Champ de tri des produits attendus');
define('EXPECTED_PRODUCTS_FIELD_DESC' , 'La colonne à trier dans la boîte des produits attendus.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , 'Passer à une devise spécifique à la langue');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC' , 'Passez automatiquement à une devise spécifique à la langue lorsque vous changez de langue.');

define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE' , 'Envoyez des copies des courriels de commande à:');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC' , 'Envoyez des copies des e-mails de commande aux adresses e-mail suivantes, comme: Nom1 &lt;e-mail@address1&gt;, Nom2 &lt;e-mail@address2&gt;');

define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE' , 'Utiliser des URL sûres pour les moteurs de recherche ?');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC' , 'Utilisez des URL conviviales pour tous les liens de site.<br /><br /><strong>Pour les URL optimisées pour les moteurs de recherche, le fichier _.htaccess dans le répertoire racine doit être activé, c&apos;est à dire renommé en .htaccess ! De plus, votre serveur web doit supporter le <a href="http://www.modrewrite.com/" target="_blank" rel="noopener">mod_rewrite</a> module!</strong> (Veuillez demander à votre hébergeur si vous ne savez pas comment vérifier cela.)');

define('DISPLAY_CART_TITLE' , 'Afficher le panier après avoir ajouté un produit ?');
define('DISPLAY_CART_DESC' , 'Afficher le panier après avoir ajouté un produit ou retourner au produit ?');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , 'Permettre aux invités d&apos;informer leurs connaissances par e-mail ?');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC' , 'Permettre aux invités de parler d&apos;un produit à un ami ?');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , 'Opérateur de recherche par défaut.');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC' , 'Opérateurs de recherche par défaut.');

define('STORE_NAME_ADDRESS_TITLE' , 'Adresse et numéro de téléphone du magasin');
define('STORE_NAME_ADDRESS_DESC' , 'Détails du magasin utilisés pour l&apos;affichage et l&apos;impression');

define('SHOW_COUNTS_TITLE' , 'Afficher le nombre de produits après le nom de la catégorie ?');
define('SHOW_COUNTS_DESC' , 'Afficher le nombre de produits après le nom de chaque catégorie, en comptant les produits récursivement');

define('DISPLAY_PRICE_WITH_TAX_TITLE' , 'Affichage des prix avec TVA');
define('DISPLAY_PRICE_WITH_TAX_DESC' , 'Afficher les prix toutes taxes comprises ou ajouter la taxe à la fin.');

define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE' , 'Statut de client des administrateurs');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC' , 'Sélectionnez le statut client par défaut pour les administrateurs.');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE' , 'Statut de client des invités');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC' , 'Choisissez le statut client par défaut pour les comptes invités');
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE' , 'Statut de client des nouveaux clients');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC' , 'Sélectionnez le statut client par défaut pour un nouveau client.');

define('ALLOW_ADD_TO_CART_TITLE' , 'Permettre ajouter au panier');
define('ALLOW_ADD_TO_CART_DESC' , 'Permettre aux clients d&apos;ajouter des produits dans le panier même si l&apos;option "Afficher les prix" est désactivée.');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE' , 'Autoriser une remise sur l&apos;attribut des produits ?');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC' , 'Permettre aux clients d&apos;obtenir une remise sur le prix d&apos;attribut (si le produit principal n&apos;est pas un produit "spécial")');
define('CURRENT_TEMPLATE_TITLE' , 'Jeu de modèles (Thème)');
define('CURRENT_TEMPLATE_DESC' , 'Sélectionnez un jeu de modèles (thème). Le thème doit avoir été préalablement enregistré dans le dossier suivant : www.Your-Domain.com/templates/');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , 'Prénom');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC' , 'Longueur minimale du prénom');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , 'Nom de famille');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC' , 'Longueur minimale du nom de famille');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , 'Date de naissance');
define('ENTRY_DOB_MIN_LENGTH_DESC' , 'Durée minimale de la date de naissance');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'Adresse de courrier électronique');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC' , 'Longueur minimale de l&apos;adresse e-mail');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , 'Rue');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC' , 'Longueur minimale de la rue  ');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , 'Entreprise');
define('ENTRY_COMPANY_MIN_LENGTH_DESC' , 'Durée minimale du nom de l&apos;entreprise');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , 'Code postal');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC' , 'Longueur minimale du code postal');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , 'Ville');
define('ENTRY_CITY_MIN_LENGTH_DESC' , 'Longueur minimale du nom de la ville');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , 'État');
define('ENTRY_STATE_MIN_LENGTH_DESC' , 'Longueur minimale du nom de l&apos;état');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , 'Numéro de téléphone');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC' , 'Longueur minimale du numéro de téléphone');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , 'Password');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC' , 'Longueur minimale du mot de passe');

define('REVIEW_TEXT_MIN_LENGTH_TITLE' , 'notations');
define('REVIEW_TEXT_MIN_LENGTH_DESC' , 'Longueur minimale de saisie de texte pour les évaluations');

define('MIN_DISPLAY_BESTSELLERS_TITLE' , 'Best-Seller');
define('MIN_DISPLAY_BESTSELLERS_DESC' , 'Nombre minimum de best-sellers à afficher');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , 'Aussi acheté');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC' , 'Nombre minimum de produits achetés à afficher dans la vue du produit.');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , 'Entrées du carnet d&apos;adresses');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC' , 'Nombre maximum d&apos;entrées du carnet d&apos;adresses par client');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , 'Résultats de recherche');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC' , 'Nombre d&apos;articles à afficher comme résultat de recherche');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , 'Liens de page');
define('MAX_DISPLAY_PAGE_LINKS_DESC' , 'Nombre de pages individuelles pour lesquelles un lien doit être affiché dans le menu de navigation de la page');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , 'Offres spéciales');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC' , 'Nombre maximum d&apos;offres spéciales à afficher');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , 'Module de présentation des nouveaux produits');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC' , 'Nombre maximum de nouveaux produits à afficher dans les catégories');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , 'Module de présentation des produits attendus');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC' , 'Nombre maximum de produits attendus à afficher dans les catégories');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , 'Liste des fabricants');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC' , 'Dans la boîte du fabricant; Si le nombre de fabricants dépasse ce seuil, une liste contextuelle s&apos;affiche à la place de la liste habituelle.');
define('MAX_MANUFACTURERS_LIST_TITLE' , 'Longueur du nom du fabricant');
define('MAX_MANUFACTURERS_LIST_DESC' , 'Used in manufacturers box; when this value is "1" the classic drop-down list will be used for the manufacturers box. Otherwise, a list-box with the specified number of rows will be displayed.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , 'Length of Manufacturers Name');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC' , 'Longueur maximale des noms dans la boîte du fabricant');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , 'Nouvelles évaluations');
define('MAX_DISPLAY_NEW_REVIEWS_DESC' , 'Nombre maximum de nouvelles évaluations à afficher');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , 'Sélection aléatoire d&apos;avis sur les produits');
define('MAX_RANDOM_SELECT_REVIEWS_DESC' , 'Parmi combien de notations les notations affichées au hasard dans la boîte doivent-elles être sélectionnées ?');
define('MAX_RANDOM_SELECT_NEW_TITLE' , 'Sélection aléatoire des nouveaux produits');
define('MAX_RANDOM_SELECT_NEW_DESC' , 'Parmi combien de nouveaux articles les nouveaux articles affichés au hasard dans la boîte doivent-ils être sélectionnés ?');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , 'Sélection aléatoire d&apos;offres spéciales');
define('MAX_RANDOM_SELECT_SPECIALS_DESC' , 'Parmi combien d&apos;offres spéciales les offres spéciales affichées au hasard dans la boîte doivent-elles être sélectionnées ?');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , 'Nombre de catégories par ligne');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC' , 'Nombre de catégories à afficher par ligne dans les &Uuml;aperçus. Minimum 1, Maximum 5 ');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , 'Liste des nouveaux produits ');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC' , 'ombre maximum de nouveaux produits à afficher dans la liste.');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , 'Best-Seller');
define('MAX_DISPLAY_BESTSELLERS_DESC' , 'Nombre maximum de best-sellers à afficher');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , 'Aussi acheté');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC' , 'Nombre maximum de produits achetés à afficher dans la vue du produit');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , 'Boîte de récapitulatif de commande');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC' , 'Nombre maximum de produits à afficher dans la boîte de récapitulatif de commande personnelle du client');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , 'Synthèse de commande ');
define('MAX_DISPLAY_ORDER_HISTORY_DESC' , 'nombre maximum de commandes à afficher dans la synthèse de commande dans l&apos;espace client de la boutique.');
define('MAX_PRODUCTS_QTY_TITLE', 'Nombre maximum d&apos;articles');
define('MAX_PRODUCTS_QTY_DESC', 'Nombre maximum de produits dans le panier');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_TITLE' , 'Nombre de jours pour les nouveaux produits');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_DESC' , 'Nombre maximum de jours pendant lesquels les nouveaux produits doivent être affichés.');

define('CATEGORY_IMAGE_WIDTH_TITLE' , 'Largeur des images de la catégorie');
define('CATEGORY_IMAGE_WIDTH_DESC' , 'Largeur maximale de la catégorie Images en pixels (par défaut: 150)');
define('CATEGORY_IMAGE_HEIGHT_TITLE' , 'Hauteur des images de la catégorie');
define('CATEGORY_IMAGE_HEIGHT_DESC' , 'Hauteur maximale de la catégorie Images en pixels (par défaut: 150)');

define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_TITLE' , 'Largeur des images des vignettes des produits');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_DESC' , 'Largeur des images des vignettes des produits (en pixels) (par défaut: 250).');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_TITLE' , 'Hauteur des vignettes des produits');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_DESC' , 'Maximum height of product thumbnails (en pixels) (par défaut: 187).');

define('PRODUCT_IMAGE_INFO_WIDTH_TITLE' , 'Largeur des images d&apos;information sur les produits');
define('PRODUCT_IMAGE_INFO_WIDTH_DESC' , 'Largeur maximale des images d&apos;information sur les produits (en pixels) (par défaut: 320).');
define('PRODUCT_IMAGE_INFO_HEIGHT_TITLE' , 'Height of Product Info Images');
define('PRODUCT_IMAGE_INFO_HEIGHT_DESC' , 'Maximum height of product info images (en pixels) (par défaut: 240).');

define('PRODUCT_IMAGE_POPUP_WIDTH_TITLE' , 'Largeur des images des produits-popupImages');
define('PRODUCT_IMAGE_POPUP_WIDTH_DESC' , 'Maximum width of popup images (en pixels) (par défaut: 1000).');
define('PRODUCT_IMAGE_POPUP_HEIGHT_TITLE' , 'Height of Popup Images');
define('PRODUCT_IMAGE_POPUP_HEIGHT_DESC' , 'Maximum height of popup images (en pixels) (par défaut: 750).');

define('SMALL_IMAGE_WIDTH_TITLE' , 'Largeur des images du produit');
define('SMALL_IMAGE_WIDTH_DESC' , 'Largeur maximale des images du produit en pixels (en pixels)');
define('SMALL_IMAGE_HEIGHT_TITLE' , 'Hauteur des images des produits');
define('SMALL_IMAGE_HEIGHT_DESC' , 'Hauteur maximale des images du produit (en pixels)');

define('HEADING_IMAGE_WIDTH_TITLE' , 'Largeur des images d&apos;en-tête');
define('HEADING_IMAGE_WIDTH_DESC' , 'Largeur maximale des images d&apos;en-tête (en pixels))');
define('HEADING_IMAGE_HEIGHT_TITLE' , 'Hauteur de l&apos;image d&apos;en-tête');
define('HEADING_IMAGE_HEIGHT_DESC' , 'Hauteur maximale des images d&apos;en-tête (en pixels)');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE' , 'Sous-catégorie Largeur de l&apos;image');
define('SUBCATEGORY_IMAGE_WIDTH_DESC' , 'Largeur des images de la sous-catégorie');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE' , 'Hauteur de l&apos;image de la sous-catégorie');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC' , 'Hauteur des images de la sous-catégorie (en pixels)');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , 'Calculer la taille de l&apos;image');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC' , 'Calculer la taille des images ?');

define('IMAGE_REQUIRED_TITLE' , 'Des photos sont-elles nécessaires ?');
define('IMAGE_REQUIRED_DESC' , 'Si vous réglez cette valeur sur "1", les images inexistantes seront affichées sous forme d&apos;images. Bon pour les développeurs.');

define('MO_PICS_TITLE','Nombre d&apos;images du produit');
define('MO_PICS_DESC','Nombre d&apos;images de produits qui seront disponibles en plus de l&apos;image principale du produit.');

// Category Image

define('CATEGORY_IMAGE_BEVEL_TITLE' , 'Catégories-Images:Bevel');
define('CATEGORY_IMAGE_BEVEL_DESC' , 'Catégories-Images:Bevel<br /><br />Default-values: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Usage:<br />(edge width, hex light colour, hex dark colour)');
define('CATEGORY_IMAGE_GREYSCALE_TITLE' , 'Catégories-Images:Greyscale');
define('CATEGORY_IMAGE_GREYSCALE_DESC' , 'Catégories-Images:Greyscale<br /><br />Default-values: (32,22,22)<br /><br />basic black n white<br />Usage:<br />(int red, int green, int blue)');
define('CATEGORY_IMAGE_ELLIPSE_TITLE' , 'Catégories-Images:Ellipse');
define('CATEGORY_IMAGE_ELLIPSE_DESC' , 'Catégories-Images:Ellipse<br /><br />Default-values: (FFFFFF)<br /><br />ellipse on bg colour<br />Usage:<br />(hex background colour)');
define('CATEGORY_IMAGE_ROUND_EDGES_TITLE' , 'Catégories-Images:Round-edges');
define('CATEGORY_IMAGE_ROUND_EDGES_DESC' , 'Catégories-Images:Round-edges<br /><br />Default-values: (5,FFFFFF,3)<br /><br />corner trimming<br />Usage:<br />( edge_radius, background colour, anti-alias width)');
define('CATEGORY_IMAGE_MERGE_TITLE' , 'Catégories-Images:Merge');
define('CATEGORY_IMAGE_MERGE_DESC' , 'Catégories-Images:Merge<br /><br />Default-values: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Usage:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('CATEGORY_IMAGE_FRAME_TITLE' , 'Catégories-Images:Frame');
define('CATEGORY_IMAGE_FRAME_DESC' , 'Catégories-Images:Frame<br /><br />Default-values: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Usage:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('CATEGORY_IMAGE_DROP_SHADDOW_TITLE' , 'Catégories-Images:Drop-Shadow');
define('CATEGORY_IMAGE_DROP_SHADDOW_DESC' , 'Catégories-Images:Drop-Shadow<br /><br />Default-values: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width,hex shadow colour,hex background colour)');
define('CATEGORY_IMAGE_MOTION_BLUR_TITLE' , 'Catégories-Images:Motion-Blur');
define('CATEGORY_IMAGE_MOTION_BLUR_DESC' , 'Catégories-Images:Motion-Blur<br /><br />Default-values: (4,FFFFFF)<br /><br />fading parallel lines<br />Usage:<br />(int number of lines,hex background colour)');

//This is for the Images showing your products for preview. All the small stuff.

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE' , 'Vignettes des produits:Bevel');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC' , 'Vignettes des produits:Bevel<br /><br />Default-values: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Usage:<br />(edge width,hex light colour,hex dark colour)');

define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , 'Vignettes des produits:Greyscale');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC' , 'Vignettes des produits:Greyscale<br /><br />Default-values: (32,22,22)<br /><br />basic black n white<br />Usage:<br />(int red,int green,int blue)');

define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , 'Vignettes des produits:Ellipse');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC' , 'Vignettes des produits:Ellipse<br /><br />Default-values: (FFFFFF)<br /><br />ellipse on bg colour<br />Usage:<br />(hex background colour)');

define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , 'Vignettes des produits:Round-edges');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , 'Vignettes des produits:Round-edges<br /><br />Default-values: (5,FFFFFF,3)<br /><br />corner trimming<br />Usage:<br />(edge_radius,background colour,anti-alias width)');

define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE' , 'Vignettes des produits:Merge');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC' , 'Vignettes des produits:Merge<br /><br />Default-values: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Usage:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity, transparent colour on merge image)');

define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE' , 'Vignettes des produits:Frame');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC' , 'Vignettes des produits:Frame<br /><br />Default-values: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Usage:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');

define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADOW_TITLE' , 'Vignettes des produits:Drop-Shadow');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADOW_DESC' , 'Vignettes des produits:Drop-Shadow<br /><br />Default-values: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width,hex shadow colour,hex background colour)');

define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , 'Vignettes des produits:Motion-Blur');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , 'Vignettes des produits:Motion-Blur<br /><br />Default-values: (4,FFFFFF)<br /><br />fading parallel lines<br />Usage:<br />(int number of lines,hex background colour)');

//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE' , 'Images des produits:Bevel');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC' , 'Images des produits:Bevel<br /><br />Default-values: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Usage:<br />(edge width, hex light colour, hex dark colour)');

define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE' , 'Images des produits:Greyscale');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC' , 'Images des produits:Greyscale<br /><br />Default-values: (32,22,22)<br /><br />basic black n white<br />Usage:<br />(int red, int green, int blue)');

define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE' , 'Images des produits:Ellipse');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC' , 'Images des produits:Ellipse<br /><br />Default-values: (FFFFFF)<br /><br />ellipse on bg colour<br />Usage:<br />(hex background colour)');

define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE' , 'Images des produits:Round-edges');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC' , 'Images des produits:Round-edges<br /><br />Default-values: (5,FFFFFF,3)<br /><br />corner trimming<br />Usage:<br />( edge_radius, background colour, anti-alias width)');

define('PRODUCT_IMAGE_INFO_MERGE_TITLE' , 'Images des produits:Merge');
define('PRODUCT_IMAGE_INFO_MERGE_DESC' , 'Images des produits:Merge<br /><br />Default-values: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Usage:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');

define('PRODUCT_IMAGE_INFO_FRAME_TITLE' , 'Images des produits:Frame');
define('PRODUCT_IMAGE_INFO_FRAME_DESC' , 'Images des produits:Frame<br /><br />Default-values: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Usage:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');

define('PRODUCT_IMAGE_INFO_DROP_SHADOW_TITLE' , 'Images des produits:Drop-Shadow');
define('PRODUCT_IMAGE_INFO_DROP_SHADOW_DESC' , 'Images des produits:Drop-Shadow<br /><br />Default-values: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width,hex shadow colour,hex background colour)');

define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE' , 'Images des produits:Motion-Blur');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC' , 'Images des produits:Motion-Blur<br /><br />Default-values: (4,FFFFFF)<br /><br />fading parallel lines<br />Usage:<br />(int number of lines,hex background colour)');

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE' , 'Images des fenêtres contextuelles des produits:Bevel');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC' , 'Images des fenêtres contextuelles des produits:Bevel<br /><br />Default-values: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Usage:<br />(edge width,hex light colour,hex dark colour)');

define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE' , 'Images des fenêtres contextuelles des produits:Greyscale');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC' , 'Images des fenêtres contextuelles des produits:Greyscale<br /><br />Default-values: (32,22,22)<br /><br />basic black n white<br />Usage:<br />(int red,int green,int blue)');

define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE' , 'Images des fenêtres contextuelles des produits:Ellipse');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC' , 'Images des fenêtres contextuelles des produits:Ellipse<br /><br />Default-values: (FFFFFF)<br /><br />ellipse on bg colour<br />Usage:<br />(hex background colour)');

define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE' , 'Images des fenêtres contextuelles des produits:Round-edges');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC' , 'Images des fenêtres contextuelles des produits:Round-edges<br /><br />Default-values: (5,FFFFFF,3)<br /><br />corner trimming<br />Usage:<br />(edge_radius,background colour,anti-alias width)');

define('PRODUCT_IMAGE_POPUP_MERGE_TITLE' , 'Images des fenêtres contextuelles des produits:Merge');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC' , 'Images des fenêtres contextuelles des produits:Merge<br /><br />Default-values: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Usage:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');

define('PRODUCT_IMAGE_POPUP_FRAME_TITLE' , 'Images des fenêtres contextuelles des produits:Frame');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC' , 'Images des fenêtres contextuelles des produits:Frame<br /><br />Default-values: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Usage:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');

define('PRODUCT_IMAGE_POPUP_DROP_SHADOW_TITLE' , 'Images des fenêtres contextuelles des produits:Drop-Shadow');
define('PRODUCT_IMAGE_POPUP_DROP_SHADOW_DESC' , 'Images des fenêtres contextuelles des produits:Drop-Shadow<br /><br />Default-values: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width,hex shadow colour,hex background colour)');

define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE' , 'Images des fenêtres contextuelles des produits:Motion-Blur');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC' , 'Images des fenêtres contextuelles des produits:Motion-Blur<br /><br />Default-values: (4,FFFFFF)<br /><br />fading parallel lines<br />Usage:<br />(int number of lines,hex background colour)');

define('IMAGE_MANIPULATOR_TITLE','GDlib processing');
define('IMAGE_MANIPULATOR_DESC','<br/><br/>Manipulateur d&apos;images pour GD2 ou GD1<br /><br /><b>NOTE:</b> image_manipulator_GD2_advanced.php supporte les images PNG transparentes');


define('ACCOUNT_GENDER_TITLE' , 'Salutation');
define('ACCOUNT_GENDER_DESC' , 'Afficher la salutation dans le compte client');
define('ACCOUNT_DOB_TITLE' , 'Date de naissance');
define('ACCOUNT_DOB_DESC' , 'Afficher date de naissance dans le compte client');
define('ACCOUNT_COMPANY_TITLE' , 'Société');
define('ACCOUNT_COMPANY_DESC' , 'Afficher société dans le compte client');
define('ACCOUNT_SUBURB_TITLE' , 'Banlieue');
define('ACCOUNT_SUBURB_DESC' , 'Afficher banlieue dans le compte client');
define('ACCOUNT_STATE_TITLE' , 'District');
define('ACCOUNT_STATE_DESC' , 'Afficher district dans le compte client');
define('PASSWORD_SECURITY_CHECK_TITLE','Vérification de la sécurité du mot de passe');
define('PASSWORD_SECURITY_CHECK_DESC','Obliger les nouveaux clients à s&apos;inscrire avec un mot de passe sécurisé (c&apos;est-à-dire avec au moins 1 caractère et 1 numéro). Voir la configuration minimale pour la longueur du mot de passe)');
define('DEFAULT_CURRENCY_TITLE' , 'Devise par défaut');
define('DEFAULT_CURRENCY_DESC' , 'Devise à utiliser par défaut');
define('DEFAULT_LANGUAGE_TITLE' , 'Langue par défaut');
define('DEFAULT_LANGUAGE_DESC' , 'Langue à utiliser par défaut');
define('DEFAULT_ORDERS_STATUS_ID_TITLE' , 'Statut de commande par défaut');
define('DEFAULT_ORDERS_STATUS_ID_DESC' , 'Etat de la commande par défaut lorsqu&apos;une nouvelle commande est passée.');

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , 'Pays d&apos;origine');
define('SHIPPING_ORIGIN_COUNTRY_DESC' , 'Sélectionnez le pays d&apos;origine à utiliser dans les devis d&apos;expédition.');
define('SHIPPING_ORIGIN_ZIP_TITLE' , 'Code Postal');
define('SHIPPING_ORIGIN_ZIP_DESC' , 'Entrez le code postal (ZIP) du magasin à utiliser dans les devis d&apos;expédition.');
define('SHIPPING_MAX_WEIGHT_TITLE' , 'Poids maximum pouvant être expédié en un seul colis.');
define('SHIPPING_MAX_WEIGHT_DESC' , 'Les partenaires d&apos;expédition (Poste/UPS, etc.) ont un poids de colis maximum. Saisissez-en une valeur.');
define('SHIPPING_BOX_WEIGHT_TITLE' , 'Poids de tare minimum');
define('SHIPPING_BOX_WEIGHT_DESC' , 'Poids de tare minimum qui est ajouté au poids total (net) de tous les produits. Par exemple 1,5 kg entrer 1.5. Attention, l&apos;entrée a des effets sur vos frais d&apos;expédition ! Recommandé : 0');
define('SHIPPING_BOX_PADDING_TITLE' , 'Emballages plus grands - augmentation en pourcentage.');
define('SHIPPING_BOX_PADDING_DESC' , 'Pour 10% entrez 10. Attention, l&apos;entrée a des effets sur vos frais d&apos;expédition ! Recommandé : 0');
define('SHOW_SHIPPING_TITLE' , 'Frais d&apos;expédition dans le panier d&apos;achat');
define('SHOW_SHIPPING_DESC' , 'Afficher le lien vers les frais d&apos;expédition dans le panier d&apos;achat');
define('SHIPPING_INFOS_TITLE' , 'ID d&apos;expédition');
define('SHIPPING_INFOS_DESC' , 'ID de groupe de langue des frais d&apos;expédition (par défaut 1) pour le lien.');
define('SHIPPING_DEFAULT_TAX_CLASS_METHOD_TITLE' , 'Méthode de calcul de la classe de taxe par défaut');
define('SHIPPING_DEFAULT_TAX_CLASS_METHOD_DESC' , 'none: ne pas montrer les frais d&apos;expédition tax<br />auto proportionnel :  Affiche les frais d&apos;expédition au prorata du bon de commande.<br />auto max: Affiche le taux de taxe du plus grand groupe de ventes comme taxe sur les frais d&apos;expédition.');

define('PRODUCT_LIST_FILTER_TITLE' , 'Vérification du stock disponible');
define('PRODUCT_LIST_FILTER_DESC' , 'Voulez-vous afficher le filtre Catégorie / Fabricant ?');

define('STOCK_CHECK_TITLE' , 'Vérification du stock disponible');
define('STOCK_CHECK_DESC' , 'Vérifiez s&apos;il y a encore assez de marchandises disponibles pour livrer les commandes.');

define('ATTRIBUTE_STOCK_CHECK_TITLE' , 'Vérification du stock disponible des attributs');
define('ATTRIBUTE_STOCK_CHECK_DESC' , 'Vérifier si un stock d&apos;attributs suffisant est disponible.');
define('STOCK_LIMITED_TITLE' , 'Soustraire quantité');
define('STOCK_LIMITED_DESC' , 'Soustraire la quantité de produit dans l&apos;ordre de la quantité de produits en stock');
define('STOCK_ALLOW_CHECKOUT_TITLE' , 'Permettre l&apos;achat de marchandises stockées');
define('STOCK_ALLOW_CHECKOUT_DESC' , 'Voulez-vous permettre de commander même si certaines marchandises ne sont pas disponibles en fonction du stock ?');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , 'Etiquetage des articles épuisés');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC' , 'Indiquez clairement au client quels articles ne sont plus disponibles.');
define('STOCK_REORDER_LEVEL_TITLE' , 'E-Mail à l&apos;administrateur si le stock est en dessous');
define('STOCK_REORDER_LEVEL_DESC' , 'Ci-dessous, quel stock le système doit-il envoyer un mail à l&apos;administrateur qu&apos;il doit commander à nouveau ? Si vous ne souhaitez pas recevoir d&apos;e-mail, saisissez la quantité -99999, par exemple.');
define('STORE_PAGE_PARSE_TIME_TITLE' , 'Mémoriser le temps d&apos;analyse des pages');
define('STORE_PAGE_PARSE_TIME_DESC' , 'Mémoire du temps nécessaire au calcul des scripts jusqu&apos;à la sortie de la page');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , 'Destination du fichier journal');
define('STORE_PAGE_PARSE_TIME_LOG_DESC' , 'Entrez l&apos;emplacement de stockage/le nom du fichier, où le temps d&apos;analyse de la page ainsi que les requêtes de la base de données seront stockés.<br/><strong>Caution : Le fichier peut devenir très gros en taille dans de longues sessions d&apos;enregistrement !</strong>.<br/><br/>Valeur par défaut "page_parse_time.log":<br/><strong>Frontend:</strong> Parse time and database queries in the shop frontend will be stored in the root directory in the file "<strong>page_parse_time.log</strong>".<br/><strong>Administration (Backend):</strong>Les requêtes de temps d&apos;analyse et de base de données dans le backend boutique seront stockées dans le fichier "<strong>admin/page_parse_time.log</strong>".');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , 'Format de la date du fichier journal');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC' , 'Le format de date (par défaut: %d/%m/%A %H:%M:%S)');

define('DISPLAY_PAGE_PARSE_TIME_TITLE' , 'Afficher les temps de calcul des pages');
define('DISPLAY_PAGE_PARSE_TIME_DESC' , 'Si l&apos;enregistrement des temps de calcul pour les pages est activé, ils peuvent être affichés dans le pied de page. Pratique pour les développeurs.');
define('STORE_DB_TRANSACTIONS_TITLE' , 'Sauvegarder les requêtes de la base de données');
define('STORE_DB_TRANSACTIONS_DESC' , 'Sauvegarde des requêtes individuelles de la base de données dans le fichier journal pour les temps de calcul. Pratique pour les développeurs.');

define('USE_CACHE_TITLE' , 'Utilisez Cache');
define('USE_CACHE_DESC' , 'Utiliser les fonctions de mise en cache');

define('DB_CACHE_TITLE','Mise en cache de la base de données');
define('DB_CACHE_DESC','Les requêtes SELECT peuvent être mises en cache dans la boutique pour réduire le nombre de requêtes dans la base de données et augmenter la vitesse..');

define('DB_CACHE_EXPIRE_TITLE','Durée de vie du cache de la base de données');
define('DB_CACHE_EXPIRE_DESC','Temps en secondes avant que les fichiers du cache ne soient automatiquement écrasés par les données de la base de données.');

define('DIR_FS_CACHE_TITLE' , 'Dossier cache');
define('DIR_FS_CACHE_DESC' , 'Le répertoire dans lequel les fichiers mis en cache sont sauvegardés');

define('ACCOUNT_OPTIONS_TITLE','Type de création de compte');
define('ACCOUNT_OPTIONS_DESC','Comment souhaitez-vous concevoir la procédure d&apos;enregistrement dans votre boutique?<br />Vous avez le choix entre des comptes clients réguliers et des "commandes uniques" sans créer de compte client (un compte est créé, mais il n&apos;est pas visible pour le client) ');

define('EMAIL_TRANSPORT_TITLE' , 'Méthode de transport des courriels');
define('EMAIL_TRANSPORT_DESC' , '<b>Recommandation : smtp</b> - Définit si le serveur utilise une connexion locale au "programme Sendmail" ou s&apos;il utilise une connexion SMTP sur TCP/IP. Les serveurs fonctionnant sous Windows ou MacOS doivent utiliser SMTP.');

define('EMAIL_LINEFEED_TITLE' , 'Flux d&apos;e-mails.');
define('EMAIL_LINEFEED_DESC' , 'Définit les caractères à utiliser pour séparer les en-têtes des messages. ');
define('EMAIL_USE_HTML_TITLE' , 'Utilisation de MIME HTML lors de l&apos;envoi d&apos;e-mails');
define('EMAIL_USE_HTML_DESC' , 'Envoyer des e-mails au format HTML');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , 'Vérification de l&apos;adresse e-mail via DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC' , 'Les adresses e-mail peuvent être vérifiées via un serveur DNS.');
define('SEND_EMAILS_TITLE' , 'Envoi d&apos;e-mails');
define('SEND_EMAILS_DESC' , 'Envoi d&apos;e-mails aux clients (pour les commandes, etc.)');
define('SENDMAIL_PATH_TITLE' , 'Le chemin d&apos;accès à sendmail');
define('SENDMAIL_PATH_DESC' , 'Si vous utilisez sendmail, veuillez indiquer le bon chemin (par défaut : /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE' , 'Adresse du serveur SMTP');
define('SMTP_MAIN_SERVER_DESC' , 'Veuillez entrer l&apos;adresse de votre serveur SMTP principal.');
define('SMTP_BACKUP_SERVER_TITLE' , 'Adresse du serveur de sauvegarde SMTP');
define('SMTP_BACKUP_SERVER_DESC' , 'Veuillez entrer l&apos;adresse de votre serveur SMTP de sauvegarde.');
define('SMTP_USERNAME_TITLE' , 'Nom d&apos;utilisateur SMTP');
define('SMTP_USERNAME_DESC' , 'Veuillez entrer le nom d&apos;utilisateur de votre compte SMTP.');
define('SMTP_PASSWORD_TITLE' , 'Mot de passe SMTP');
define('SMTP_PASSWORD_DESC' , 'Veuillez entrer le mot de passe de votre compte SMTP.');
define('SMTP_AUTH_TITLE' , 'SMTP AUTH');
define('SMTP_AUTH_DESC' , 'Activer l&apos;authentification sécurisée pour votre serveur SMTP');
define('SMTP_PORT_TITLE' , 'SMTP Port');
define('SMTP_PORT_DESC' , 'Veuillez entrer le port SMTP de votre serveur SMTP (par défaut: 25)');
define('SMTP_SECURE_TITLE', 'SMTP encryption method');
define('SMTP_SECURE_DESC', 'Sélectionnez la méthode \'ssl\' ou \'tls\' pour le cryptage des e-mails, ou sélectionnez \'---\' pour aucun cryptage.');

//DokuMan - 2011-09-20 - E-Mail SQL errors
define('EMAIL_SQL_ERRORS_TITLE','Envoyer des messages d&apos;erreur SQL au propriétaire de la boutique par e-mail');
define('EMAIL_SQL_ERRORS_DESC','Si "oui" un email sera envoyé à l&apos;adresse email du propriétaire de la boutique contenant le message d&apos;erreur SQL approprié.  Le message d&apos;erreur SQL lui-même sera caché au client.<br />Quand "non" le message d&apos;erreur SQL sera affiché directement et visible pour tous (par défaut). ');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , 'Contactez-nous - Adresse électronique');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , 'Veuillez entrer l&apos;adresse e-mail utilisée pour les messages "Contactez-nous');
define('CONTACT_US_NAME_TITLE' , 'Contactez-nous - Nom du courriel');
define('CONTACT_US_NAME_DESC' , 'Veuillez entrer un nom à utiliser pour les messages "Contactez-nous".');
define('CONTACT_US_FORWARDING_STRING_TITLE' , 'Contactez-nous - Adresses de réexpédition des courriels');
define('CONTACT_US_FORWARDING_STRING_DESC' , 'Entrez d&apos;autres adresses e-mail auxquelles les e-mails du formulaire "Contact" doivent être envoyés en plus (séparés par,).');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , 'Contactez-nous - Adresse électronique de réponse');
define('CONTACT_US_REPLY_ADDRESS_DESC' , 'Veuillez entrer une adresse e-mail à laquelle les clients peuvent répondre.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , 'Contactez-nous - nom de réponse');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , 'Veuillez entrer un nom à utiliser dans le champ de réponse des messages "Contactez-nous".');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , 'Contactez-nous - sujet de réponse');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , 'Veuillez entrer un sujet d&apos;e-mail pour les messages "Contactez-nous".');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , 'Support technique - Adresse électronique');
define('EMAIL_SUPPORT_ADDRESS_DESC' , 'Veuillez entrer une adresse e-mail pour envoyer des e-mails via le <b>Support System</b> (création de compte, mot de passe perdu).');
define('EMAIL_SUPPORT_NAME_TITLE' , 'Support technique - Nom du courriel');
define('EMAIL_SUPPORT_NAME_DESC' , 'Veuillez entrer un nom pour l&apos;envoi de courriels sur le <b>Support System</b> (création de compte, mot de passe perdu).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , 'Support technique - Adresses de réexpédition des courriels');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , 'Veuillez entrer les adresses de redirection pour les mails du <b>Support System</b> (séparées par, )');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , 'Support technique - adresse de réponse');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , 'Veuillez entrer une adresse e-mail pour les réponses de vos clients.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , 'Support technique - nom de réponse');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , 'Veuillez entrer un nom à utiliser dans le champ de réponse des e-mails d&apos;assistance.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , 'Support technique - sujet de réponse');
define('EMAIL_SUPPORT_SUBJECT_DESC' , 'Veuillez entrer un sujet d&apos;e-mail pour les messages <b>Support System</b>.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , 'Facturation - Adresse électronique');
define('EMAIL_BILLING_ADDRESS_DESC' , 'Veuillez entrer une adresse e-mail pour l&apos;envoi d&apos;e-mails via le <b>Système de facturation </b> (confirmations de commande, changements de statut, ....)');
define('EMAIL_BILLING_NAME_TITLE' , 'Facturation - Nom du courriel');
define('EMAIL_BILLING_NAME_DESC' , 'Veuillez entrer un nom pour l&apos;envoi d&apos;e-mails via le <b>Système de facturation </b> (confirmations de commande, changements de statut, ....)');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , 'Facturation - Adresses de réexpédition des courriels');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , 'Veuillez entrer les adresses de réexpédition pour les courriers du système de facturation <b>Facturation System</b> (séparées par, )');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , 'Facturation - adresse de réponse');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , 'Please enter an e-mail address for replies of your customers.');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE' , 'Facturation - nmom de réponse');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC' , 'Veuillez entrer un nom à utiliser dans le champ de réponse des e-mails de facturation.');
define('EMAIL_BILLING_SUBJECT_TITLE' , 'Facturation - sujet de réponse');
define('EMAIL_BILLING_SUBJECT_DESC' , 'Veuillez entrer un sujet d&apos;e-mail pour les messages <b>Facturation</b>.');
define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','Facturation - Objet de la commande courrier');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','Veuillez saisir un sujet pour les mails de commande générés par la boutique. (comme  <b>notre ordre {$nr},{$date}</b>). Vous pouvez utiliser, {$nr},{$date},{$firstname},{$lastname}');

define('DOWNLOAD_ENABLED_TITLE' , 'Activer le téléchargement');
define('DOWNLOAD_ENABLED_DESC' , 'Activez les fonctions de téléchargement des produits.');
define('DOWNLOAD_BY_REDIRECT_TITLE' , 'Téléchargement par Redirect');
define('DOWNLOAD_BY_REDIRECT_DESC' , 'Utilisez la redirection du navigateur pour le téléchargement. Désactivé sur les systèmes non-Unix.');
define('DOWNLOAD_MAX_DAYS_TITLE' , 'Délai d&apos;expiration (jours)');
define('DOWNLOAD_MAX_DAYS_DESC' , 'Définissez le nombre de jours avant l&apos;expiration du lien de téléchargement. 0 signifie aucune limite.');
define('DOWNLOAD_MAX_COUNT_TITLE' , 'Nombre maximum de téléchargements');
define('DOWNLOAD_MAX_COUNT_DESC' , 'Définissez le nombre maximum de téléchargements. 0 signifie qu&apos;aucun téléchargement n&apos;est autorisé.');

define('GZIP_COMPRESSION_TITLE' , 'Activer la compression GZip');
define('GZIP_COMPRESSION_DESC' , 'Activez la compression HTTP gzip.');
define('GZIP_LEVEL_TITLE' , 'Niveau de compression');
define('GZIP_LEVEL_DESC' , 'Réglez un niveau de compression de 0-9 (0 = minimum, 9 = maximum).');

define('SESSION_WARNING', '<br /><br /><font color="#FF0000"><strong>ATTENTION:</strong></font>
Cette caractéristique peut réduire l&apos;opérabilité du système de la boutique en ligne. Ne le modifiez que lorsque vous êtes conscient des conséquences suivantes et que votre serveur Web prend en charge la fonctionnalité correspondante.');

define('SESSION_WRITE_DIRECTORY_TITLE' , 'Répertoire des sessions');
define('SESSION_WRITE_DIRECTORY_DESC' , 'Si vous souhaitez enregistrer des sessions sous forme de fichiers, utilisez le dossier suivant.');
define('SESSION_FORCE_COOKIE_USE_TITLE' , 'Préférer l&apos;utilisation de cookies');
define('SESSION_FORCE_COOKIE_USE_DESC' , 'Démarrez la session si les cookies sont autorisés par le navigateur. (Valeur par défaut &quot;non&quot;)'.SESSION_WARNING);
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , 'Check SSL Session ID');
define('SESSION_CHECK_SSL_SESSION_ID_DESC' , 'Validez le SSL_SESSION_ID à chaque demande de page HTTPS sécurisée. (Valeur par défaut &quot;non&quot;)'.SESSION_WARNING);
define('SESSION_CHECK_USER_AGENT_TITLE' , 'Check User Agent');
define('SESSION_CHECK_USER_AGENT_DESC' , 'Valider l&apos;agent utilisateur du navigateur du client à chaque demande de page.  (Valeur par défaut &quot;non&quot;)'.SESSION_WARNING);
define('SESSION_CHECK_IP_ADDRESS_TITLE' , 'Vérifier l&apos;adresse IP');
define('SESSION_CHECK_IP_ADDRESS_DESC' , 'Valider l&apos;adresse IP du client à chaque demande de page. (Valeur par défaut &quot;non&quot;)'.SESSION_WARNING);
define('SESSION_RECREATE_TITLE' , 'Recréer une session.');
define('SESSION_RECREATE_DESC' , 'Recréez la session pour générer un nouvel ID de session lorsqu&apos;un client se connecte ou crée un compte (PHP >=4.1 nécessaire). (Valeur par défaut &quot;non&quot;)'.SESSION_WARNING);

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE' , 'Longueur minimale des méta-mots-clés');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC' , 'Afficher les modalités et conditions et demander l&apos;approbation à la caisse');

define('META_MIN_KEYWORD_LENGTH_TITLE' , 'Min. Meta-Keyword Length');
define('META_MIN_KEYWORD_LENGTH_DESC' , 'Longueur minimale des métamots-clés générés automatiquement (description de l&apos;article)');
define('META_KEYWORDS_NUMBER_TITLE' , 'Nombre de méta-mots-clés');
define('META_KEYWORDS_NUMBER_DESC' , 'Nombre de méta-mots-clés');
define('META_AUTHOR_TITLE' , 'Créateur');
define('META_AUTHOR_DESC' , '<meta name="author">');
define('META_PUBLISHER_TITLE' , 'Éditeur');
define('META_PUBLISHER_DESC' , '<meta name="publisher">');
define('META_COMPANY_TITLE' , 'Société');
define('META_COMPANY_DESC' , '<meta name="company">');
define('META_TOPIC_TITLE' , 'page thématiquec');
define('META_TOPIC_DESC' , '<meta name="page-topic">');
define('META_REPLY_TO_TITLE' , 'Répondre - À');
define('META_REPLY_TO_DESC' , '<meta name="reply-to">');
define('META_REVISIT_AFTER_TITLE' , 'Revisitez notre site web après');
define('META_REVISIT_AFTER_DESC' , '<meta name="revisit-after">');
define('META_ROBOTS_TITLE' , 'Robots');
define('META_ROBOTS_DESC' , '<meta name="robots">');
define('META_DESCRIPTION_TITLE' , 'Description');
define('META_DESCRIPTION_DESC' , '<meta name="description">');
define('META_KEYWORDS_TITLE' , 'Mots-clés');
define('META_KEYWORDS_DESC' , '<meta name="keywords">');

define('MODULE_PAYMENT_INSTALLED_TITLE' , 'Modules de paiement installés');
define('MODULE_PAYMENT_INSTALLED_DESC' , 'Liste des noms de fichiers du module de paiement séparés par des points-virgules. La liste est mise à jour automatiquement. Pas besoin d&apos;éditer. (Exemple: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE' , 'Modules de "Order Total" installés');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC' , 'Liste des noms de fichiers du module order_total séparés par un point-virgule. La liste est mise à jour automatiquement. Pas besoin d&apos;éditer.  (Exemple: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE' , 'Modules d&apos;expédition installés');
define('MODULE_SHIPPING_INSTALLED_DESC' , 'Liste des noms de fichiers du module d&apos;expédition séparés par un point-virgule. La liste est mise à jour automatiquement. Pas besoin d&apos;éditer. (Exemple: ups.php;flat.php;item.php)');

define('CACHE_LIFETIME_TITLE','Durée de vie du cache');
define('CACHE_LIFETIME_DESC','Le nombre de secondes de contenu mis en cache persiste.');
define('CACHE_CHECK_TITLE','Vérifier si Cache Modifié');
define('CACHE_CHECK_DESC','Si oui, alors avec du contenu mis en cache, les en-têtes If-Modified-Since sont pris en compte et les en-têtes HTTP appropriés sont envoyés. De cette façon, les clics répétés sur une page mise en cache n&apos;envoient pas la page entière au client à chaque fois.');

define('PRODUCT_REVIEWS_VIEW_TITLE','Critiques dans les détails du produit');
define('PRODUCT_REVIEWS_VIEW_DESC','Nombre de commentaires affichés sur la page de détails du produit ');

define('DELETE_GUEST_ACCOUNT_TITLE','Supprimer comptes invités');
define('DELETE_GUEST_ACCOUNT_DESC','Les comptes d&apos;invités peuvent-ils être supprimés après avoir passé commande ?  (Les données de la commande seront sauvegardées). Recommandé : oui ');

define('USE_WYSIWYG_TITLE','Activer l&apos;éditeur WYSIWYG');
define('USE_WYSIWYG_DESC','Activer l&apos;éditeur WYSIWYG pour CMS et produits');

define('PRICE_IS_BRUTTO_TITLE','Brut Admin');
define('PRICE_IS_BRUTTO_DESC','Utilisation des prix avec taxes dans l&apos;administration');

define('PRICE_PRECISION_TITLE','Précision brute/nette');
define('PRICE_PRECISION_DESC','Précision brute/net (n&apos;a pas d&apos;inluence sur l&apos;affichage dans la boutique, qui affiche toujours 2 décimales)');

define('CHECK_CLIENT_AGENT_TITLE','Éviter les sessions des moteurs de recherche');
define('CHECK_CLIENT_AGENT_DESC','Empêche les moteurs de recherche connus de démarrer une session.');
define('SHOW_IP_LOG_TITLE','IP-Log à la caisse?');
define('SHOW_IP_LOG_DESC','Afficher le texte "Votre IP sera sauvegardée", à la caisse ?');

define('SAVE_IP_IN_DATABASE_TITLE', 'Enregistrer l&apos;adresse IP dans la base de données ?');
define('SAVE_IP_IN_DATABASE_DESC', 'Concernant les adresses IPv4 uniquement');

define('ACTIVATE_GIFT_SYSTEM_TITLE','Activer le système de chèques-cadeaux');
define('ACTIVATE_GIFT_SYSTEM_DESC','Activer le système de chèques-cadeaux');

define('ACTIVATE_SHIPPING_STATUS_TITLE','Activer l&apos;affichage de l&apos;état d&apos;expédition ?');
define('ACTIVATE_SHIPPING_STATUS_DESC','Afficher l&apos;état d&apos;expédition ? (Différents délais d&apos;expédition peuvent être spécifiés pour des produits individuels. Si cette option est activée, un nouvel élément <b>Statut de livraison </b>est affiché à l&apos;entrée du produit).');

define('SECURITY_CODE_LENGTH_TITLE','Longueur du code de sécurité');
define('SECURITY_CODE_LENGTH_DESC','Longueur du code de sécurité (Chèque cadeau) ');

define('IMAGE_QUALITY_TITLE','Qualité des images');
define('IMAGE_QUALITY_DESC','Qualité d&apos;image (0= compression maximale, 100=qualité optimale)');

define('GROUP_CHECK_TITLE','Vérification du statut du clien');
define('GROUP_CHECK_DESC','Restreindre l&apos;accès aux catégories individuelles, aux produits et aux éléments de contenu à des groupes de clients spécifiques (après activation, les champs de saisie apparaîtront dans les catégories, les produits et le gestionnaire de contenu.');

define('ACTIVATE_REVERSE_CROSS_SELLING_TITLE', 'Vente croisée inversée');
define('ACTIVATE_REVERSE_CROSS_SELLING_DESC', 'Activer la vente croisée inversée ?');

define('ACTIVATE_NAVIGATOR_TITLE','Activer Product Navigator ?');
define('ACTIVATE_NAVIGATOR_DESC','activer/désactiver le navigateur de produit dans product_info, (désactiver pour de meilleures performances si de nombreux articles sont présents dans le système)');

define('QUICKLINK_ACTIVATED_TITLE','Activate Multilink / Copy Function');
define('QUICKLINK_ACTIVATED_DESC','Allows selection of multiple categories when performing "copy product to"');

define('DOWNLOAD_UNALLOWED_PAYMENT_TITLE', 'Modules de paiement par téléchargement non autorisés');
define('DOWNLOAD_UNALLOWED_PAYMENT_DESC', 'des modules de paiement <strong>INTERDITS</strong> pour les téléchargements. Liste séparée par des virgules, par exemple  {banktransfer,cod,invoice,moneyorder}');
define('DOWNLOAD_MIN_ORDERS_STATUS_TITLE', 'Statut de commande minimum');
define('DOWNLOAD_MIN_ORDERS_STATUS_DESC', 'Statut de commande minimum pour permettre le téléchargement des fichiers.');

// Vat Check
define('STORE_OWNER_VAT_ID_TITLE' , 'TVA du propriétaire');
define('STORE_OWNER_VAT_ID_DESC' , 'Numéro d&apos;identification TVA du propriétaire du magasin');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_TITLE' , 'Numéro d&apos;identification à la TVA approuvé par le groupe de clients (pays étranger)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_DESC' , 'Groupe de clients pour les clients dont le numéro d&apos;enregistrement TVA a été vérifié et approuvé, pays du magasin <> pays du client');
define('ACCOUNT_COMPANY_VAT_CHECK_TITLE' , 'Valider le numéro d&apos;identification TVA');
define('ACCOUNT_COMPANY_VAT_CHECK_DESC' , 'Les clients peuvent-ils saisir un numéro de TVA? Si non, la boîte disparaît.');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_TITLE' , 'Valider le numéro d&apos;identification TVA en ligne pour la plausibilité');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_DESC' , 'Valider le numéro d&apos;enregistrement TVA en ligne pour la plausibilité en utilisant le service web du portail fiscal de l&apos;UE. (<a href="http://ec.europa.eu/taxation_customs" style="font-style:italic">http://ec.europa.eu/taxation_customs</a>).<br/>Nécessite PHP5 avec le support "SOAP" activé !  <strong><span class="messageStackSuccess">Le support "PHP5 SOAP" est en fait '.(in_array ('soap', get_loaded_extensions()) ? '' : '<span class="messageStackError">PAS</span>').' active!</span></strong>');
define('ACCOUNT_COMPANY_VAT_GROUP_TITLE' , 'Personnaliser le groupe de clients selon UST ID Check ?');
define('ACCOUNT_COMPANY_VAT_GROUP_DESC' , 'En activant cette option, le groupe de clients est modifié après un contrôle UST ID positif.');
define('ACCOUNT_VAT_BLOCK_ERROR_TITLE' , 'Autoriser un numéro d&apos;identification TVA non valable ?');
define('ACCOUNT_VAT_BLOCK_ERROR_DESC' , 'Blocage de la saisie de numéros d&apos;identification TVA erronés ou non cochés ?');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_TITLE','Groupe de clients - Numéro d&apos;enregistrement TVA approuvé (Pays du magasin)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_DESC','Groupe de clients pour les clients dont le numéro de TVA a été vérifié et approuvé, pays du magasin = pays du client');

// Google Conversion
define('GOOGLE_CONVERSION_TITLE','Suivi de la conversion Google');
define('GOOGLE_CONVERSION_DESC','Suivre les mots-clés de conversion sur les commandes');
define('GOOGLE_CONVERSION_ID_TITLE','Conversion ID');
define('GOOGLE_CONVERSION_ID_DESC','Votre identifiant de conversion Google');
define('GOOGLE_LANG_TITLE','Langue Google');
define('GOOGLE_LANG_DESC','Code ISO de la langue utilisée');

// Afterbuy
define('AFTERBUY_ACTIVATED_TITLE','en service');
define('AFTERBUY_ACTIVATED_DESC','Activer le module afterbuy');
define('AFTERBUY_PARTNERID_TITLE','ID partenaire');
define('AFTERBUY_PARTNERID_DESC','Votre identifiant de partenaire Afterbuy');
define('AFTERBUY_PARTNERPASS_TITLE','Partner mot de passe');
define('AFTERBUY_PARTNERPASS_DESC','Votre mot de passe for Afterbuy XML module');
define('AFTERBUY_USERID_TITLE','numéro de client');
define('AFTERBUY_USERID_DESC','Votre numéro de client à Afterbuy');
define('AFTERBUY_ORDERSTATUS_TITLE','état de commande');
define('AFTERBUY_ORDERSTATUS_DESC','État de la commande pour les commandes exportées');
define('AFTERBUY_URL','Une description de Afterbuy peut être trouvée ici : <a href="http://www.afterbuy.de" target="new">http://www.afterbuy.de</a>');
define('AFTERBUY_DEALERS_TITLE', 'marquer comme revendeur');
define('AFTERBUY_DEALERS_DESC', 'saisissez les ID de groupe des commerçants à inclure dans Afterbuy en tant que commerçants. Exemple : <em>6,5,8</em>');
define('AFTERBUY_IGNORE_GROUPE_TITLE', 'Ignorer le groupe de clients');
define('AFTERBUY_IGNORE_GROUPE_DESC', 'Quels groupes de clients doivent être ignorés ? Exemple: <em>6,5,8</em>.');

// Search-Options
define('SEARCH_IN_DESC_TITLE','Rechercher dans la description des produits');
define('SEARCH_IN_DESC_DESC','Inclure les descriptions des produits lors de la recherche');
define('SEARCH_IN_ATTR_TITLE','Rechercher dans Attributs des produits');
define('SEARCH_IN_ATTR_DESC','Inclure les attributs des produits lors de la recherche');

define('REVOCATION_ID_TITLE','Revocation ID');
define('REVOCATION_ID_DESC','Content ID of revocation content');
define('DISPLAY_REVOCATION_ON_CHECKOUT_TITLE','Afficher right of revocation?');
define('DISPLAY_REVOCATION_ON_CHECKOUT_DESC','Afficher right of revocation on checkout_confirmation?');

// Paypal Express Script
define('PAYPAL_MODE_TITLE','Mode PayPal:');
define('PAYPAL_MODE_DESC','Live (par défaut) or Test (Sandbox).Selon le mode, vous devez d&apos;abord créer l&apos;accès à l&apos;API PayPal: <br/>Link: <a href="https://www.paypal.com/de/cgi-bin/webscr?cmd=_get-api-signature&generic-flow=true" target="_blank" rel="noopener"><strong>Créer un accès API pour le mode temps réel</strong></a><br/>Link: <a href="https://www.sandbox.paypal.com/de/cgi-bin/webscr?cmd=_get-api-signature&generic-flow=true" target="_blank" rel="noopener"><strong>Créer un accès API pour le mode bac à sable</strong></a><br/>Vous n&apos;avez toujours pas de compte PayPal? <a href="https://www.paypal.com/de/cgi-bin/webscr?cmd=_registration-run" target="_blank" rel="noopener"><strong>Cliquez ici pour en créer.</strong></a>');
define('PAYPAL_API_USER_TITLE','Utilisateur de l&apos;API PayPal (Live)');
define('PAYPAL_API_USER_DESC','Entrer le nom d&apos;utilisateur (live)');
define('PAYPAL_API_PWD_TITLE','PayPal API-Password (Live)');
define('PAYPAL_API_PWD_DESC','Mot de passe de l&apos;API PayPal (live)');
define('PAYPAL_API_SIGNATURE_TITLE','Signature de l&apos;API PayPal (Live)');
define('PAYPAL_API_SIGNATURE_DESC','Entrer la signature de l&apos;API PayPal (live)');
define('PAYPAL_API_SANDBOX_USER_TITLE','Utilisateur de l&apos;API PayPal (Sandbox)');
define('PAYPAL_API_SANDBOX_USER_DESC','Entrer le nom d&apos;utilisateur (sandbox)');
define('PAYPAL_API_SANDBOX_PWD_TITLE','Mot de passe de l&apos;API PayPal  (Sandbox)');
define('PAYPAL_API_SANDBOX_PWD_DESC','Entrer le mot de passe (sandbox)');
define('PAYPAL_API_SANDBOX_SIGNATURE_TITLE','Signature de l&apos;API PayPal (Sandbox)');
define('PAYPAL_API_SANDBOX_SIGNATURE_DESC','Entrer la signature de l&apos;API PayPal(sandbox)');
define('PAYPAL_API_VERSION_TITLE','PayPal API-Version');
define('PAYPAL_API_VERSION_DESC','Enter PayPal API version, e.g. 84.0');
define('PAYPAL_API_IMAGE_TITLE','PayPal boutique Logo');
define('PAYPAL_API_IMAGE_DESC','Veuillez entrer le nom du fichier logo à afficher avec PayPal.<br />Note : affiché uniquement si la boutique utilise SSL.<br />Largeur maximale : 750px, hauteur maximale : 90px.<br />Le fichier logo est appelé depuis :  '.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
define('PAYPAL_API_CO_BACK_TITLE','PayPal Couleur d&apos;arrière-plan');
define('PAYPAL_API_CO_BACK_DESC','Entrez une couleur de fond à afficher avec PayPal, par exemple FEE8B9.');
define('PAYPAL_API_CO_BORD_TITLE','PayPal Couleur frontière');
define('PAYPAL_API_CO_BORD_DESC','Entrez une couleur de bordure à afficher avec PayPal. ex. E4C558');
define('PAYPAL_ERROR_DEBUG_TITLE','Message d&apos;erreur PayPal');
define('PAYPAL_ERROR_DEBUG_DESC','Afficher le message d&apos;erreur PayPal ? par défaut = non');
define('PAYPAL_ORDER_STATUS_TMP_ID_TITLE','Statut de la commande "annuler"');
define('PAYPAL_ORDER_STATUS_TMP_ID_DESC','Sélectionner l&apos;état de la commande pour une transaction annulée (ex. : PayPal annulé)');
define('PAYPAL_ORDER_STATUS_SUCCESS_ID_TITLE','Etat de la commande OK');
define('PAYPAL_ORDER_STATUS_SUCCESS_ID_DESC','Sélectionnez le statut de la commande pour une transaction réussie (par exemple, en cours PP payé).');
define('PAYPAL_ORDER_STATUS_PENDING_ID_TITLE','Statut de la commande " en cours ".');
define('PAYPAL_ORDER_STATUS_PENDING_ID_DESC','Sélectionnez l&apos;état de la commande pour une transaction qui n&apos;a pas été entièrement traitée par PayPal (par ex. en attente de PP ouvert)');
define('PAYPAL_ORDER_STATUS_REJECTED_ID_TITLE','Statut de la commande " rejeté ".');
define('PAYPAL_ORDER_STATUS_REJECTED_ID_DESC','Sélectionnez l&apos;état de la commande pour une transaction rejetée (p. ex. PayPal rejeté).');
define('PAYPAL_COUNTRY_MODE_TITLE','Mode Pays PayPal');
define('PAYPAL_COUNTRY_MODE_DESC','Sélectionnez un mode pays. Certaines fonctions PayPal ne sont disponibles qu&apos;au Royaume-Uni (p. ex. DirectPayment).');
define('PAYPAL_EXPRESS_ADDRESS_CHANGE_TITLE','Données d&apos;adresse PayPal-Express');
define('PAYPAL_EXPRESS_ADDRESS_CHANGE_DESC','Permet de modifier les données d&apos;adresse transférées par PayPal.');
define('PAYPAL_EXPRESS_ADDRESS_OVERRIDE_TITLE','Ecraser l&apos;adresse de livraison');
define('PAYPAL_EXPRESS_ADDRESS_OVERRIDE_DESC','permet de modifier les données d&apos;adresse transmises par PayPal (compte existant)');
define('PAYPAL_INVOICE_TITLE','Connaisseur de la boutique pour le numéro de facture PayPal');
define('PAYPAL_INVOICE_DESC','Lettre(s) devant le numéro de commande en tant que connaisseurs de la boutique à définir et en tant que numéro de facture de PayPal à utiliser. Plusieurs magasins avec un compte PayPal peuvent travailler par différents connaisseurs de boutique, sans quoi il vient avec les mêmes numéros de commande aux mêmes numéros de facture dans le compte PayPal.');
// EOF - Tomcraft - 2009-10-03 - Paypal Express Modul

// BOF - Tomcraft - 2009-11-02 - Admin language tabs
define('USE_ADMIN_LANG_TABS_TITLE' , 'Onglets de langue pour les catégories/articles');
define('USE_ADMIN_LANG_TABS_DESC' , 'Activer les onglets de langue dans les champs de saisie des catégories/articles ?');
// EOF - Tomcraft - 2009-11-02 - Admin language tabs

// BOF - Hendrik - 2010-08-11 - Thumbnails in admin products list
define('USE_ADMIN_THUMBS_IN_LIST_TITLE' , 'Images de la liste des produits Admin');
define('USE_ADMIN_THUMBS_IN_LIST_DESC' , 'Afficher une colonne supplémentaire avec des images des catégories / articles dans la liste des articles de l&apos;administrateur ?');
define('USE_ADMIN_THUMBS_IN_LIST_STYLE_TITLE', 'Admin liste des produits images CSS-Style');
define('USE_ADMIN_THUMBS_IN_LIST_STYLE_DESC', 'Ici, des informations de style CSS simples à saisir - par exemple, la largeur maximale : largeur max : 90px ;');// EOF - Hendrik - 2010-08-11 - Thumbnails in admin products list
// EOF - Hendrik - 2010-08-11 - Thumbnails in admin products list

// BOF - Tomcraft - 2009-11-05 - Advanced contact form
define('USE_CONTACT_EMAIL_ADDRESS_TITLE' , 'Formulaire de contact - Option d&apos;envoi');
define('USE_CONTACT_EMAIL_ADDRESS_DESC' , 'Utilisez l&apos;adresse e-mail "Contactez-nous" pour envoyer le formulaire de contact (important pour certains hébergeurs comme Hosteurope)');
// EOF - Tomcraft - 2009-11-05 - Advanced contact form

// BOF - Dokuman - 2010-02-04 - delete cache files in admin section
define('DELETE_CACHE_SUCCESSFUL', 'Le cache a été supprimé avec succès.');
define('DELETE_TEMP_CACHE_SUCCESSFUL', 'Le cache des modèles a été supprimé avec succès.');
// EOF - Dokuman - 2010-02-04 - delete cache files in admin section

// BOF - DokuMan - 2010-08-13 - set Google RSS Feed in admin section
define('GOOGLE_RSS_FEED_REFID_TITLE' , 'Flux RSS Google - refID');
define('GOOGLE_RSS_FEED_REFID_DESC' , 'Entrez l&apos;ID de la campagne ici. Ceci est automatiquement ajouté à chaque lien dans le flux RSS de Google.');
// EOF - DokuMan - 2010-08-13 - set Google RSS Feed in admin section

// BOF - web28 - 2010-08-17 -  Image size calculation for smaller images
define('PRODUCT_IMAGE_NO_ENLARGE_UNDER_DEFAULT_TITLE','Mise à l&apos;échelle d&apos;images à basse résolution)');
define('PRODUCT_IMAGE_NO_ENLARGE_UNDER_DEFAULT_DESC','Activez le paramètre <strong>No</strong> pour éviter que les images d&apos;articles de résolution inférieure ne soient mises à l&apos;échelle aux valeurs par défaut définies pour la largeur et la hauteur. Si vous activez le paramètre <strong>Yes</strong>, les images à faible résolution seront également mises à l&apos;échelle à la taille d&apos;image par défaut. Dans ce cas, ces images peuvent être très floues et pixélisées.');
// EOF - web28 - 2010-08-17 -  Image size calculation for smaller images

//BOF - hendrik - 2011-05-14 - independent invoice number and date
define('IBN_BILLNR_TITLE', 'Numéro de facture suivant');
define('IBN_BILLNR_DESC', 'Lors de l&apos;attribution d&apos;un numéro de facture, ce numéro est ensuite attribué.');
define('IBN_BILLNR_FORMAT_TITLE', 'Format du numéro de facture');
define('IBN_BILLNR_FORMAT_DESC', 'Format du numéro de facture {n}=nombre, {d}=jour, {m}=mois , {y}=année´, <br>exemple. "100{n}-{d}-{m}-{y}" => "10099-28-02-2019"');
//EOF - hendrik - 2011-05-14 - independent invoice number and date

define('FAILED_LOGINS_LIMIT_TITLE', 'Limite pour les connexions échouées');
define('FAILED_LOGINS_LIMIT_DESC', 'Le nombre maximum de tentatives de connexion avant la validation du captcha est requis.');
define('VALID_REQUEST_TIME_TITLE', 'Délai pour demander une extension de mot de passe valide');
define('VALID_REQUEST_TIME_DESC', 'Définissez une heure pratique pour demander une extension de mot de passe en secondes pour laquelle le renouvellement du mot de passe est activé après l&apos;envoi d&apos;une demande (par défaut 3600 secondes).');
define('INSERT_RECAPTCHA_KEY_TITLE', 'Google reCaptcha api key');
define('INSERT_RECAPTCHA_KEY_DESC', 'Ici, vous pouvez entrer une clé API Google reCaptcha bon marché. (<strong><span style="color: #FF0000;">reCaptcha n&apos;est pas affiché si ce champ de saisie est vide !!</span></strong>) <br /> <br />  <a href="https://www.google.com/recaptcha/admin#list" target="_blank"> Cliquez ici pour obtenir une clé API Google reCaptcha.</a> <br /><br /> <strong>  Veillez à sélectionner reCAPTCHA V2 et la version "Je ne suis pas un robot" !<br /><br /> <span style="color: #FF0000;">Veuillez ne pas taper la clé de l&apos;API - il suffit de la copier et de la coller ici !</span></strong>');
define('RECAPTCHA_SECRET_KEY_TITLE', 'Google reCatpcha secret key');
define('RECAPTCHA_SECRET_KEY_DESC', 'Entrez ici la clé secrète appropriée. Lors de la copie, veillez à ne pas copier d&apos;espaces devant ou derrière.');


//BOC - h-h-h - 2011-12-23 - Button "Buy Now" optional - default off
define('SHOW_BUTTON_BUY_NOW_TITLE', 'Afficher "Acheter maintenant" dans les listes de produits');
define('SHOW_BUTTON_BUY_NOW_DESC', '<b>Précaution:</b><br /> Cette option est juridiquement critique si les clients ne peuvent pas voir toutes les informations importantes directement dans les listes de produits.');
//EOC - h-h-h - 2011-12-23 - Button "Buy Now" optional - default off

//split page results
define('MAX_DISPLAY_ORDER_RESULTS_TITLE', 'Nombre de commandes par page');
define('MAX_DISPLAY_ORDER_RESULTS_DESC', 'Nombre maximum de commandes à afficher dans la grille par page.');
define('MAX_DISPLAY_LIST_PRODUCTS_TITLE', 'Nombre de produits par page');
define('MAX_DISPLAY_LIST_PRODUCTS_DESC', 'Nombre maximum de produits qui doivent être affichés dans la grille par page.');
define('MAX_DISPLAY_LIST_CUSTOMERS_TITLE', 'Nombre de clients par page');
define('MAX_DISPLAY_LIST_CUSTOMERS_DESC', 'Nombre maximum de clients qui doivent être affichés dans la grille par page.');
define ('MAX_ROW_LISTS_ATTR_OPTIONS_TITLE', 'Options du produit : Nombre d&apos;options de produit par page');
define ('MAX_ROW_LISTS_ATTR_OPTIONS_DESC', 'Nombre maximum d&apos;options de produit à afficher par page.');
define ('MAX_ROW_LISTS_ATTR_VALUES_TITLE', 'Options du produit : Nombre de valeurs d&apos;option par page');
define ('MAX_ROW_LISTS_ATTR_VALUES_DESC', 'Nombre maximum de valeurs d&apos;option à afficher par page.');

// Whos online
define ('WHOS_ONLINE_TIME_LAST_CLICK_TITLE', 'Qui est en ligne - Durée d&apos;affichage en secondes');
define ('WHOS_ONLINE_TIME_LAST_CLICK_DESC', 'Chronométrage des utilisateurs en ligne dans le tableau "Who\'s Online", après quoi les entrées sont effacées (valeur minimale : 900)');

//Sessions
define ('SESSION_LIFE_ADMIN_TITLE', 'Session Lifetime Admin');
define ('SESSION_LIFE_ADMIN_DESC', 'temps en secondes après l&apos;expiration de l&apos;heure de session pour les administrateurs (déconnectés) - par défaut 7200');
define ('SESSION_LIFE_CUSTOMERS_TITLE', 'Session lifetime customer');
define ('SESSION_LIFE_CUSTOMERS_DESC', 'temps en secondes après l&apos;expiration de l&apos;heure de session pour les clients (déconnexion) - Par défaut 1440');

//checkout confirmation options
define ('CHECKOUT_USE_PRODUCTS_SHORT_DESCRIPTION_TITLE', 'Page de confirmation de commande : Description');
define ('CHECKOUT_USE_PRODUCTS_SHORT_DESCRIPTION_DESC', 'La description de l&apos;article doit-elle être affichée sur la page de confirmation de commande ? Note : La description courte sera affichée s'il n'y a AUCUNE description de commande d&apos;article. Avec Non, la description courte n&apos;est pas affichée !');
define ('CHECKOUT_SHOW_PRODUCTS_IMAGES_TITLE', 'Confirmation de commande : Images des produits');
define ('CHECKOUT_SHOW_PRODUCTS_IMAGES_DESC', 'Les photos de l&apos;article doivent-elles être affichées sur la page de confirmation de commande ?');
define ('CHECKOUT_SHOW_PRODUCTS_MODEL_TITLE', 'Confirmation de commande: Article no.');
define ('CHECKOUT_SHOW_PRODUCTS_MODEL_DESC', 'Les numéros d&apos;article doivent-ils être affichés sur la page de confirmation de commande ?');

// Billing email attachments
define ('EMAIL_BILLING_ATTACHMENTS_TITLE', 'Facturation - pièces jointes aux courriels pour les commandes');
define ('EMAIL_BILLING_ATTACHMENTS_DESC', 'Exemple de pièces jointes - les fichiers sont dans le répertoire de la boutique en ligne <b>/media/pdf</b>, séparez les pièces jointes multiples par des virgules et sans espace :<br /> /media/pdf/cgdv.pdf,/media/pdf/revocation.pdf.');

// email images
define ('SHOW_IMAGES_IN_EMAIL_TITLE', 'Images de produits en ordre - Insérer un courriel');
define ('SHOW_IMAGES_IN_EMAIL_DESC', 'Insérer des images d&apos;article dans l&apos;email de confirmation de commande HTML (augmente le risque que l&apos;email soit classé comme SPAM)');
define ('SHOW_IMAGES_IN_EMAIL_DIR_TITLE', 'Dossier d&apos;images de courriels');
define ('SHOW_IMAGES_IN_EMAIL_DIR_DESC', 'Sélectionner le dossier d&apos;images d&apos;email');
define ('SHOW_IMAGES_IN_EMAIL_STYLE_TITLE', 'Email images CSS style');
define ('SHOW_IMAGES_IN_EMAIL_STYLE_DESC', 'Ici, vous pouvez entrer des informations de style CSS simples - par exemple pour la largeur maximale : max-width:90px ;');

// Popup window configuration
define ('POPUP_SHIPPING_LINK_PARAMETERS_TITLE', 'Frais d&apos;expédition : Paramètres pour la fenêtre pop-up.');
define ('POPUP_SHIPPING_LINK_PARAMETERS_DESC', 'Vous pouvez saisir ici les paramètres URL par défaut: & Keep This = true & type = spare true & height = 400 & width = 600');
define ('POPUP_SHIPPING_LINK_CLASS_TITLE', 'Frais d&apos;expédition popup CSS class');
define ('POPUP_SHIPPING_LINK_CLASS_DESC', 'Ici, vous pouvez entrer des classes CSS - par défaut : thickbox');
define ('POPUP_CONTENT_LINK_PARAMETERS_TITLE', 'content pages, pop-up URL parameters');
define ('POPUP_CONTENT_LINK_PARAMETERS_DESC', 'Vous pouvez saisir ici les paramètres URL par défaut : & Keep This = true & type = spare true & height = 400 & width = 600');
define ('POPUP_CONTENT_LINK_CLASS_TITLE', 'content pages popup CSS class');
define ('POPUP_CONTENT_LINK_CLASS_DESC', 'Ici, vous pouvez entrer des classes CSS - par défaut :thickbox');
define ('POPUP_PRODUCT_LINK_PARAMETERS_TITLE', 'Product pages popup URL parameter');
define ('POPUP_PRODUCT_LINK_PARAMETERS_DESC', 'Vous pouvez saisir ici les paramètres URL par défaut : & Keep This = true & type = spare true & height = 450 & width = 750');
define ('POPUP_PRODUCT_LINK_CLASS_TITLE', 'Product pages popup CSS class');
define ('POPUP_PRODUCT_LINK_CLASS_DESC', 'Ici, vous pouvez entrer des classes CSS - par défaut :thickbox');
define ('POPUP_COUPON_HELP_LINK_PARAMETERS_TITLE', 'Fenêtre contextuelle d&apos;aide sur les coupons Paramètres URL');
define ('POPUP_COUPON_HELP_LINK_PARAMETERS_DESC', 'Vous pouvez saisir ici les paramètres URL par défaut : & Keep This = true & type = spare true & height = 450 & width = 750');
define ('POPUP_COUPON_HELP_LINK_CLASS_TITLE', 'Coupon Help popup CSS class');
define ('POPUP_COUPON_HELP_LINK_CLASS_DESC', 'Ici, vous pouvez entrer des classes CSS - par défaut :thickbox');

define ('POPUP_PRODUCT_PRINT_SIZE_TITLE', 'Produit Aperçu de l&apos;impression Taille et échelle de la fenêtre');
define ('POPUP_PRODUCT_PRINT_SIZE_DESC', 'Ici, vous pouvez définir la taille de la fenêtre popup - par défaut : width = 640, height = 600');
define ('POPUP_PRINT_ORDER_SIZE_TITLE', 'Taille de la fenêtre de l&apos;aperçu de la commande');
define ('POPUP_PRINT_ORDER_SIZE_DESC', 'Ici, vous pouvez définir la taille de la fenêtre popup - par défaut : width = 640, height = 600');

// BOF - Dokuman - 2012-08-27 - added entries for new google analytics & piwik tracking
define('TRACKING_COUNT_ADMIN_ACTIVE_TITLE' , 'Inclurer les pages vues de l&apos;exploitant du magasin en ligne');
define('TRACKING_COUNT_ADMIN_ACTIVE_DESC' , 'Si cette option est activée, tous les accès de l&apos;utilisateur administrateur de l&apos;exploitant de la boutique sont également inclus, qui (en raison des accès plus fréquents à la boutique) peut avoir les statistiques des visiteurs.');
define('TRACKING_GOOGLEANALYTICS_ACTIVE_TITLE' , 'Activer le suivi Google Analytics');
define('TRACKING_GOOGLEANALYTICS_ACTIVE_DESC' , 'Si cette option est activée, toutes les pages vues seront transmises à Google Analytics et pourront être évaluées ultérieurement. Cela nécessite la création préalable d&apos;un compte à <a href="http://www.google.com/analytics/" target="_blank" rel="noopener"><b>Google Analytics</b><</a>.');
define('TRACKING_GOOGLEANALYTICS_ID_TITLE' , 'Google Analytics account number');
define('TRACKING_GOOGLEANALYTICS_ID_DESC' , 'Entrez votre numéro de compte Google Analytics au format "UA-XXXXXXXXXXXX-X" que vous avez reçu après avoir créé un compte.');
define('TRACKING_GOOGLEANALYTICS_UNIVERSAL_TITLE' , 'Google Universal Analytics');
define('TRACKING_GOOGLEANALYTICS_UNIVERSAL_DESC' , 'Faut-il utiliser le code Google Universal Analytics ? <br/><br/><b>Veuillez noter:</b> Dès que vous changez votre compte Google Analytics pour le nouveau Google Universal Analytics Code, l&apos;ancien Google Analytics ne peut plus être utilisé !');
define('TRACKING_GOOGLEANALYTICS_DOMAIN_TITLE' , 'Google Universal Analytics Shop-URL');
define('TRACKING_GOOGLEANALYTICS_DOMAIN_DESC' , 'Entrez ici l&apos;URL standard de la boutique (exemple.fr ou www.exemple.fr). Fonctionne uniquement pour Google Universal Analytics.');
define('TRACKING_GOOGLE_LINKID_TITLE' , 'Google Universal Analytics LinkID');
define('TRACKING_GOOGLE_LINKID_DESC' , 'Vous pouvez voir des informations séparées sur plusieurs liens sur une page qui ont tous le même but. Par exemple, s&apos;il y a deux liens sur la même page qui mènent tous deux à la page Contact, vous verrez des informations de clic distinctes pour chaque lien. Fonctionne uniquement pour Google Universal Analytics.');
define('TRACKING_GOOGLE_DISPLAY_TITLE' , 'Google Universal Analytics Displayfeature');
define('TRACKING_GOOGLE_DISPLAY_DESC' , 'Les domaines sur la démographie et l&apos;intérêt comprennent un aperçu et de nouveaux rapports sur le rendement selon l&apos;âge, le sexe et les catégories d&apos;intérêt. Fonctionne uniquement pour Google Universal Analytics.');
define('TRACKING_GOOGLE_ECOMMERCE_TITLE' , 'Google E-Commerce Tracking');
define('TRACKING_GOOGLE_ECOMMERCE_DESC' , 'Utilisez le suivi du commerce électronique pour savoir ce que les visiteurs achètent par l&apos;intermédiaire de votre site Web ou de votre application. Vous recevrez également les informations suivantes:<br><br><strong>Produits:</strong> Produits achetés et les quantités et ventes générées avec ces produits:</strong>Transactions:</strong>Ventes, taxes, expédition et volume pour chaque transaction<br><strong>Temps à acheter:</strong>Nombre de jours et visites, depuis la campagne actuelle jusqu&apos;à la transaction.');
define('TRACKING_MATAMO_ACTIVE_TITLE' , 'Matomo (ex: Piwik)');
define('TRACKING_MATAMO_ACTIVE_DESC' , 'Pour utiliser MATAMO, vous devez d&apos;abord le télécharger et l&apos;installer sur votre espace web, voir aussi <a href="https://matomo.org/" target="_blank" rel="noopener"><b>MATAMO Web-Analytics</b><</a>a>. Contrairement à Google Analytics, les données sont stockées localement, c&apos;est-à-dire qu&apos;en tant qu&apos;exploitant de la boutique, vous avez la souveraineté des données.');
define('TRACKING_MATAMO_LOCAL_PATH_TITLE' , 'Chemin d&apos;installation MATAMO (sans "http://")');
define('TRACKING_MATAMO_LOCAL_PATH_DESC' , 'Saisissez le chemin d&apos;accès lorsque MATAMO a été installé avec succès. Le chemin complet du domaine doit être donné, mais sans "http://", par exemple "www.domain.de/matamo".');
define('TRACKING_MATAMO_ID_TITLE' , 'MATAMO page ID');
define('TRACKING_MATAMO_ID_DESC' , 'Dans l&apos;administration de MATAMO, un ID de page sera créé par domaine (généralement "1").');
define('TRACKING_MATAMO_GOAL_TITLE' , 'Numéro de campagne MATAMO (facultatif)');
define('TRACKING_MATAMO_GOAL_DESC' , 'Entrez votre numéro de campagne, si vous souhaitez suivre des objectifs prédéfinis. Pour plus de détails, voir <a href="https://matomo.org/docs/tracking-goals-web-analytics/" target="_blank" rel="noopener"><b>MATAMO: Tracking Goal Conversions</b></a>');
// EOF - Dokuman - 2012-08-27 - added entries for new google analytics & piwik tracking

define ('CONFIRM_SAVE_ENTRY_TITLE', 'Demande de confirmation lors de l&apos;enregistrement des produits / catégories');
define ('CONFIRM_SAVE_ENTRY_DESC', 'Faut-il effectuer une demande de confirmation lors de la sauvegarde des articles/catégories ? Valeur par défaut : Oui)');

define('WHOS_ONLINE_IP_WHOIS_SERVICE_TITLE', 'Who\'s Online - Whois Lookup URL');
define('WHOS_ONLINE_IP_WHOIS_SERVICE_DESC', 'http://www.utrace.de/?query= or http://whois.domaintools.com/');

define('STOCK_CHECKOUT_UPDATE_PRODUCTS_STATUS_TITLE', 'Après la commande - désactiver les articles épuisés?');
define('STOCK_CHECKOUT_UPDATE_PRODUCTS_STATUS_DESC', 'Un article épuisé (quantité en stock 0) doit-il être automatiquement désactivé à la fin de la commande ? L&apos;article n&apos;est alors plus visible dans la boutique!<br />Pour les articles qui seront à nouveau disponibles dans un futur proche, l&apos;option doit être réglée sur "Non".');

define('SHIPPING_STATUS_INFOS_TITLE', 'ID de délai de livraison');
define('SHIPPING_STATUS_INFOS_DESC', 'ID du contenu pour les délais de livraison');

define('SHOW_COOKIE_NOTE_TITLE', 'Afficher la note de Cookie ?');
define('SHOW_COOKIE_NOTE_DESC', '');

define('COOKIE_NOTE_CONTENT_ID_TITLE', 'Lier la note de cookie à l&apos;identifiant du contenu :');
define('COOKIE_NOTE_CONTENT_ID_DESC', '');

define('CONTACT_FORM_CONSENT_TITLE', 'Formulaire de contact Consentement');
define('CONTACT_FORM_CONSENT_DESC', 'Le formulaire de contact requiert le consentement au traitement des données.');

define('ENABLE_PDFBILL_TITLE', 'Activer la facture PDF');
define('ENABLE_PDFBILL_DESC', '');

define('USE_BOOTSTRAP_TITLE', 'Utiliser  Bootstrap');
define('USE_BOOTSTRAP_DESC', '');

define('PDFBILL_AUTOMATIC_INVOICE_TITLE', 'Profils de factures PDF automatiques');
define('PDFBILL_AUTOMATIC_INVOICE_DESC', '');

define('USE_ATTRIBUTES_IFRAME_TITLE', 'Modifier les attributs dans iframe');
define('USE_ATTRIBUTES_IFRAME_DESC', 'Ouvrir le Gestionnaire d&apos;attributs dans la vue Catégorie / Produit dans un iframe');

define('PRIVACY_STATEMENT_ID_TITLE','ID de la déclaration de confidentialité');
define('PRIVACY_STATEMENT_ID_DESC','ID du contenu de la déclaration de confidentialité');

define('USE_SEARCH_ORDER_REDIRECT_TITLE', 'Commande ouverte directement');
define('USE_SEARCH_ORDER_REDIRECT_DESC', 'après la recherche de l&apos;identifiant, la commande sera ouverte directement.');

define('REQUIRED_PHONE_NUMBER_TITLE','Numéro de téléphone');
define('REQUIRED_PHONE_NUMBER_DESC','Le numéro de téléphone devrait-il être un champ obligatoire ?');

define('CSRF_TOKEN_SYSTEM_TITLE', 'Système de jeton Admin token');
define('CSRF_TOKEN_SYSTEM_DESC', 'Le système de jetons doit-il être utilisé dans Admin ?<br/><b>Attention:</b> Le système de jetons a été introduit pour augmenter la sécurité.');

define('ADMIN_HEADER_X_FRAME_OPTIONS_TITLE', 'Protection contre le détournement de clic administrateur');
define('ADMIN_HEADER_X_FRAME_OPTIONS_DESC', 'Zone d&apos;administration avec l&apos;en-tête "X-Frame-Options : SAMEORIGIN".<br>Supported Browsers: FF 3.6.9+ Chrome 4.1.249.1042+ IE 8+ Safari 4.0+ Opera 10.50+ ');

//define('PRIVACY_STATEMENT_ID_TITLE','Privacy statement ID');
//define('PRIVACY_STATEMENT_ID_DESC','Content ID of privacy statement content');

// BOF - DM - 2018-04-14 - Added Privacy content to mail
define('PRIVACY_ID_TITLE', 'ID de confidentialité');
define('PRIVACY_ID_DESC', 'ID de contenu du contenu de confidentialité');
define('DISPLAY_PRIVACY_TITLE','Envoyer du contenu confidentiel dans le courrier de commande ?');
define('DISPLAY_PRIVACY_DESC','');
// EOF - DM - 2018-04-11 - Added Privacy content to mail

define('STOCK_ATTRIBUTE_REORDER_LEVEL_TITLE','Courriel à l&apos;administrateur si le stock d&apos;attributs est inférieur à');
define('STOCK_ATTRIBUTE_REORDER_LEVEL_DESC','Si le stock d&apos;un attribut de produit est inférieur à un certain nombre, l&apos;administrateur en sera informé.');

define('CLEVERREACH_API_CLIENT_ID_TITLE', 'Cleverreach Identifiant client');
define('CLEVERREACH_API_CLIENT_ID_DESC', 'Votre numéro de client Cleverreach');
define('CLEVERREACH_API_USERNAME_TITLE', 'Cleverreach Nom d&apos;utilisateur');
define('CLEVERREACH_API_USERNAME_DESC', 'Votre nom d&apos;utilisateur Cleverreach');
define('CLEVERREACH_API_PASSWORD_TITLE', 'Cleverreach Mot de passe');
define('CLEVERREACH_API_PASSWORD_DESC', 'Votre mot de passe Cleverreach');
define('CLEVERREACH_API_IMPORT_SUBSCRIBERS_TITLE', 'Cleverreach importer les abonnés à la newsletter ? ');
define('CLEVERREACH_API_IMPORT_SUBSCRIBERS_DESC', 'Exporter les abonnés de la newsletter de la boutique vers Cleverreach ?');
define('CLEVERREACH_API_IMPORT_BUYERS_TITLE', 'Cleverreach importer les acheteurs ?');
define('CLEVERREACH_API_IMPORT_BUYERS_DESC', 'Exporter les acheteurs de la boutique vers Cleverreach ?');
