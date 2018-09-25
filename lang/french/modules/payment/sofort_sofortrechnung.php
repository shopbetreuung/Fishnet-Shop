<?php
/**
 * @version SOFORT Gateway 5.2.0 - $Date: 2012-09-13 16:24:37 +0200 (Thu, 13 Sep 2012) $
 * @author SOFORT AG (integration@sofort.com)
 * @link http://www.sofort.com/
 *
 * Copyright (c) 2012 SOFORT AG
 *
 * $Id: sofort_sofortrechnung.php 3751 2012-10-10 08:36:20Z gtb-modified $
 */


//include language-constants used in all Multipay Projects
require_once 'sofort_general.php';

define('MODULE_PAYMENT_SOFORT_SR_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGE', '');
define('MODULE_PAYMENT_SOFORT_SR_CHECKOUT_CONDITIONS', '
	<script type="text/javascript">
		function showSrConditions() {
			srOverlay = new sofortOverlay(jQuery(".srOverlay"), "callback/sofort/ressources/scripts/getContent.php", "https://documents.sofort.com/de/sr/privacy_de");
			srOverlay.trigger();
		}
		document.write(\'<a id="srNotice" href="javascript:void(0)" onclick="showSrConditions();">J&apos;ai lu la politique de confidentialité.</a>\');
	</script>
	
	<div style="display:none; z-index: 1001;filter: alpha(opacity=92);filter: progid :DXImageTransform.Microsoft.Alpha(opacity=92);-moz-opacity: .92;-khtml-opacity: 0.92;opacity: 0.92;background-color: black;position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;text-align: center;vertical-align: middle;" class="srOverlay">
		<div class="loader" style="z-index: 1002;position: relative;background-color: #fff;top: 40px;overflow: scroll;padding: 4px;border-radius: 7px;-moz-border-radius: 7px;-webkit-border-radius: 7px;margin: auto;width: 620px;height: 400px;overflow: scroll; overflow-x: hidden;">
			<div class="closeButton" style="position: fixed; top: 54px; background: url(callback/sofort/ressources/images/close.png) right top no-repeat;cursor:pointer;height: 30px;width: 30px;"></div>
			<div class="content"></div>
		</div>
	</div>
	<noscript>
		<a href="https://documents.sofort.com/de/sr/privacy_de" target="_blank">J&apos;ai lu la politique de confidentialité.</a>
	</noscript>
');

define('MODULE_PAYMENT_SOFORT_SR_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGEALT', 'checkout.sr.description');

define('MODULE_PAYMENT_SOFORT_SR_TEXT_TITLE', 'Facture par SOFORT <br /><img src="https://images.sofort.com/en/sr/logo_90x30.png"  alt="Logo Facture par SOFORT"/>');
define('MODULE_PAYMENT_SOFORT_SOFORTRECHNUNG_TEXT_TITLE', 'Achat sur compte');
define('MODULE_PAYMENT_SOFORT_SR_TEXT_ERROR_MESSAGE', 'Le paiement n&apos;est malheureusement pas possible ou a été annulé par le client. Veuillez choisir un autre mode de paiement.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_SR', 'Le paiement n&apos;est malheureusement pas possible ou a été annulé par le client. Veuillez choisir un autre mode de paiement.');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_SR_CHECKOUT_TEXT', '');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_CONFIRM_SR', 'Accusez réception de cette facture :');
define('MODULE_PAYMENT_SOFORT_SR_STATUS_TITLE', 'Activer sofort.de module');
define('MODULE_PAYMENT_SOFORT_SR_STATUS_DESC', 'Active/désactive le module complet.');
define('MODULE_PAYMENT_SOFORT_SR_SORT_ORDER_TITLE', 'séquence de tri');
define('MODULE_PAYMENT_SOFORT_SR_SORT_ORDER_DESC', 'Ordre d&apos;affichage. Le plus petit nombre apparaîtra en premier.');
define('MODULE_PAYMENT_SOFORT_SR_TEXT_DESCRIPTION', 'Acheter sur compte avec protection du consommateur');
define('MODULE_PAYMENT_SOFORT_SOFORTRECHNUNG_ALLOWED_TITLE', 'Zones autorisées');
define('MODULE_PAYMENT_SOFORT_SOFORTRECHNUNG_ALLOWED_DESC', 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
define('MODULE_PAYMENT_SOFORT_SR_ZONE_TITLE', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_TITLE);
define('MODULE_PAYMENT_SOFORT_SR_ZONE_DESC', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_DESC);
define('MODULE_PAYMENT_SOFORT_SR_ORDER_STATUS_ID_TITLE', 'Confirmed order status');
define('MODULE_PAYMENT_SOFORT_SR_ORDER_STATUS_ID_DESC', 'Statut de la commande après la transaction réussie et confirmée et l&apos;approbation de la facture par le détaillant.');
define('MODULE_PAYMENT_SOFORT_SR_UNCONFIRMED_STATUS_ID_TITLE', 'État de la commande non confirmé');
define('MODULE_PAYMENT_SOFORT_SR_UNCONFIRMED_STATUS_ID_DESC', 'Statut de la commande après paiement réussi. Le commerçant n&apos;a pas encore publié le projet de loi.');
define('MODULE_PAYMENT_SOFORT_SR_TMP_STATUS_ID_TITLE', 'Statut de commande temporaire');
define('MODULE_PAYMENT_SOFORT_SR_TMP_STATUS_ID_DESC', 'État de l&apos;ordre pour les transactions non exécutées. L&apos;ordre a été créé mais la transaction n&apos;a pas encore été confirmée par SOFORT AG.');
define('MODULE_PAYMENT_SOFORT_SR_CANCEL_STATUS_ID_TITLE', 'Statut de la commande au moment de l&apos;annulation complète');
define('MODULE_PAYMENT_SOFORT_SR_CANCEL_STATUS_ID_DESC', 'Statut de la commande annulée<br />Statut après une annulation complète de la facture.');

define('MODULE_PAYMENT_SOFORT_SR_PENDINIG_NOT_CONFIRMED_COMMENT', 'Commande avec paiement par facture soumise avec succès. Le commerçant n&apos;a pas encore accusé réception de la commande. Votre ID de transaction:');

define('MODULE_PAYMENT_SOFORT_SR_RECOMMENDED_PAYMENT_TITLE', 'recommander le mode de paiement');
define('MODULE_PAYMENT_SOFORT_SR_RECOMMENDED_PAYMENT_DESC', '"Cochez cette méthode de paiement comme "méthode de paiement recommandée". Sur la page de sélection de paiement, une note sera affichée juste derrière le mode de paiement."');
define('MODULE_PAYMENT_SOFORT_SR_RECOMMENDED_PAYMENT_TEXT', '(recommander le mode de paiement)');

define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_TIME', 'heure');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_DATE', 'date');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_AMOUNT', 'Montant');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_COMMENT', 'Commentaire');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_ORDER_HISTORY', 'Historique des commandes');
define('MODULE_PAYMENT_SOFORT_SR_PRICE_CHANGED_CUSTOMERINFO', 'Due to the rounding of the price, a new, slightly differing invoice amount has shown. Please note this on receipt of the invoice! New invoice Montant :');

/////////////////////////////////////////////////
//////// Seller-Backend and callback.php ////////
/////////////////////////////////////////////////

define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_BACK', 'en arrière');

define('MODULE_PAYMENT_SOFORT_SR_CONFIRM_INVOICE', 'Confirmer la facture');
define('MODULE_PAYMENT_SOFORT_SR_CANCEL_INVOICE', 'annuler la facture');
define('MODULE_PAYMENT_SOFORT_SR_CANCEL_CONFIRMED_INVOICE', 'crédit de facture');
define('MODULE_PAYMENT_SOFORT_SR_CANCEL_INVOICE_QUESTION', 'Êtes-vous vraiment sûr de vouloir annuler la facture ? Ce processus ne peut pas être annulé.');
define('MODULE_PAYMENT_SOFORT_SR_CANCEL_CONFIRMED_INVOICE_QUESTION', 'Are you sure you want to credit the invoice? This action can not be undone.');

define('MODULE_PAYMENT_SOFORT_SR_DOWNLOAD_INVOICE', 'télécharger la facture');
define('MODULE_PAYMENT_SOFORT_SR_DOWNLOAD_INVOICE_HINT', 'Vous pouvez télécharger le document approprié (aperçu de facture, facture, note de crédit) ici.');
define('MODULE_PAYMENT_SOFORT_SR_DOWNLOAD_CREDIT_MEMO', 'download credit note');
define('MODULE_PAYMENT_SOFORT_SR_DOWNLOAD_INVOICE_PREVIEW', 'télécharger la facture prévisualisation');

define('MODULE_PAYMENT_SOFORT_SR_EDIT_CART', 'Modifier le panier');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_CART', 'enregistrer le panier');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_CART_QUESTION', 'Voulez-vous vraiment mettre à jour le panier ?');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_CART_ERROR', 'Une erreur s&apos;est produite lors de la mise à jour du panier.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_CART_HINT', 'Sauvegardez vos changements de panier ici. Lors de la mise à jour d&apos;une facture confirmée, la réduction de la quantité ou la suppression d&apos;un article entraînera un crédit.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_DISCOUNTS_HINT', 'Vous pouvez ajuster les remises et les majorations. Les frais supplémentaires ne peuvent pas être augmentés et les montants de l&apos;escompte doivent être supérieurs à zéro. Le montant total de la facture ne peut être augmenté par l&apos;ajustement.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_DISCOUNTS_GTZERO_HINT', 'Les remises ne peuvent pas avoir un montant supérieur à zéro.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_QUANTITY', 'ajuster la quantité');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_QUANTITY_HINT', 'Vous pouvez ajuster le nombre d&apos;éléments par position. Les montants peuvent être diminués, mais ne doivent pas être augmentés.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_QUANTITY_TOTAL_GTZERO', 'La quantité du poste ne peut pas être diminuée, car le montant total de la facture ne doit pas être négatif.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_QUANTITY_ZERO_HINT', 'La quantité doit être supérieure à 0. Pour supprimer un article, veuillez marquer l&apos;article à la fin de la ligne.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_PRICE', 'adjust price');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_PRICE_HINT', 'Vous pouvez ajuster le prix de chaque article par position. Les prix peuvent être diminués, mais ne doivent pas être augmentés.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_PRICE_TOTAL_GTZERO', 'Le prix ne peut pas être baissé, car le montant total de la facture ne doit pas être négatif.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_PRICE_AND_QUANTITY_HINT', 'Price and quantity mustn\'t be adjusted at the same time.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_PRICE_AND_QUANTITY_NAN', 'Vous avez saisi des caractères non valides. Ces ajustements ne permettent que des chiffres.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_VALUE_LTZERO_HINT', 'La valeur doit être supérieure à zéro.');

define('MODULE_PAYMENT_SOFORT_SR_UPDATE_CONFIRMED_INVOICE', 'Veuillez entrer un commentaire');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_CONFIRMED_INVOICE_HINT', 'Lors de l&apos;ajustement d&apos;une facture confirmée, une raison appropriée doit être fournie. Cette raison apparaîtra plus tard sur la note de crédit comme un commentaire à l&apos;article.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_SHIPPING_HINT', 'Vous pouvez ajuster le prix d&apos;expédition. Vous pouvez seulement réduire le montant, pas l&apos;augmenter.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_SHIPPING_COSTS_HINT', 'Pour les retours, les frais d&apos;expédition ne sont pas autorisés en tant qu&apos;article autonome sur une facture.');
define('MODULE_PAYMENT_SOFORT_SR_UPDATE_SHIPPING_TOTAL_GTZERO', 'Les frais d&apos;expédition ne peuvent pas être réduits, car le montant total de la facture ne doit pas être négatif.');

define('MODULE_PAYMENT_SOFORT_SR_RECALCULATION', 'sera recalculé.');

define('MODULE_PAYMENT_SOFORT_SR_REMOVE_FROM_INVOICE_TOTAL_GTZERO','Ce poste ne peut pas être supprimé, car le total de la facture ne doit pas être négatif.');
define('MODULE_PAYMENT_SOFORT_SR_REMOVE_ARTICLE_FROM_INVOICE', 'Supprimer l&apos;élément');
define('MODULE_PAYMENT_SOFORT_SR_REMOVE_FROM_INVOICE', 'supprimer l&apos;article');
define('MODULE_PAYMENT_SOFORT_SR_REMOVE_FROM_INVOICE_QUESTION', 'Voulez-vous vraiment supprimer les articles suivants : %s ?');
define('MODULE_PAYMENT_SOFORT_SR_REMOVE_FROM_INVOICE_HINT', 'Sélectionnez les éléments à supprimer. La suppression d&apos;un article d&apos;une facture confirmée entraînera une note de crédit.');
define('MODULE_PAYMENT_SOFORT_SR_REMOVE_LAST_ARTICLE_HINT', 'En réduisant le nombre de tous ou en supprimant le dernier élément, la facture sera complètement annulée.');

define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_CANCELED', 'La facture a été annulée.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_CONFIRMED', 'Les marchandises sont préparées pour l&apos;expédition.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_PENDINIG_NOT_CONFIRMED', 'Mode de paiement Achat sur le compte choisi. La transaction n&apos;est pas terminée.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_CANCELED_REFUNDED', 'La facture a été annulée.Remboursement créé.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_REANIMATED', 'L&apos;annulation de la facture a été annulée.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_CANCEL_30_DAYS', 'La facture a été automatiquement annulée. Le délai de confirmation de 30 jours a expiré.');

define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CURRENT_TOTAL', 'facture en cours Montant :');
define('MODULE_PAYMENT_SOFORT_SR_SUCCESS_ADDRESS_UPDATED', 'Mise à jour réussie de l&apos;adresse de livraison et de facturation.');
define('MODULE_PAYMENT_SOFORT_SR_STATUSUPDATE_UNNECESSARY', 'la mise à jour du statut n&apos;est pas nécessaire');
define('MODULE_PAYMENT_SOFORT_SR_UNKNOWN_STATUS', 'Statut de paiement inconnu/facture trouvée.');

define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_DOWNLOAD_INVOICE', 'télécharger la facture');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_DOWNLOAD_INVOICE_CREDITMEMO', 'télécharger la facture');

define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CLOSE_WINDOW', 'fermer fenêtre');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CONFIRMATION_CANCEL', 'Êtes-vous vraiment sûr de vouloir annuler la facture ? Ce processus ne peut pas être annulé.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_YES', 'Oui');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_NO', 'Non');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_REFRESH_WINDOW', 'recharge la fenêtre');

define('MODULE_PAYMENT_SOFORT_SR_GLOBAL_ERROR', 'Erreur ! Veuillez contacter l&apos;administrateur.');

define('MODULE_PAYMENT_SOFORT_SR_INVOICE_CONFIRMED', 'La facture a été confirmée.');
define('MODULE_PAYMENT_SOFORT_SR_INVOICE_CANCELED', 'La facture a été annulée.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_DETAILS', 'Détails de la facture');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_TRANSACTION_ID', 'transaction ID');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_ORDER_NUMBER', 'numéro de commande');
define('MODULE_PAYMENT_SOFORT_SR_ADMIN_TITLE', 'Facture par SOFORT');
define('MODULE_PAYMENT_SOFORT_SR_CONFIRM_CANCEL', 'Êtes-vous vraiment sûr de vouloir annuler la facture ? Ce processus ne peut pas être annulé.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_REMINDER', 'Niveau de relance {{d}}');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_DELCREDERE', 'Transfert de collection');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CREDITED_TO_SELLER', 'Payment to the merchant account has been completed.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CREDITED_TO_SELLER_CUSTOMER_PENDING', 'Payment to merchant account is done. Customer payment outstanding.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CANCELED_REFUNDED', 'La facture a été annulée.Remboursement créé. {{time}}');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_RECEIVED', 'Received.');
define('MODULE_PAYMENT_SOFORT_SR_PENDINIG_NOT_CONFIRMED_COMMENT_ADMIN', 'Ordre d&apos;achat avec achat sur compte transmis avec succès. La confirmation du commerçant n&apos;a pas encore eu lieu.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CART_EDITED', 'Le panier a été modifié.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_CART_RESET', 'Le panier a été remis à zéro.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_CONFIRMED_SELLER', 'Statut de la transaction : La facture a été confirmée.. Waiting for payment. Statut de la facture: Facture en attente.');
define('MODULE_PAYMENT_SOFORT_SR_TRANSLATE_INVOICE_CANCELED_REFUNDED_SELLER', 'Statut de la transaction : The money will be refunded. Statut de la facture: The invoice will be refunded.');
define('MODULE_PAYMENT_SOFORT_SR_PENDING_NOT_CREDITED_YET_RECEIVED_SELLER', 'Statut de la transaction : La facture a été confirmée.. Waiting for payment. Statut de la facture: le client a payé le reçu.');
define('MODULE_PAYMENT_SOFORT_SR_RECEIVED_CREDITED_RECEIVED_SELLER', 'Statut de la transaction : La facture a été payée. Statut de la facture: le client a payé le reçu.');
define('MODULE_PAYMENT_SOFORT_SR_PENDING_NOT_CREDITED_YET_REMINDER_SELLER', 'Statut de la transaction : La facture a été confirmée.. Waiting for payment. Statut de la facture: Niveau de relance {{d}}');
define('MODULE_PAYMENT_SOFORT_SR_RECEIVED_CREDITED_REMINDER_SELLER', 'Statut de la transaction : La facture a été payée. Statut de la facture: Niveau de relance {{d}}');
define('MODULE_PAYMENT_SOFORT_SR_PENDING_NOT_CREDITED_YET_DELCREDERE_SELLER', 'Statut de la transaction : La facture a été confirmée.. Waiting for payment. Statut de la facture: Transfert de collection');
define('MODULE_PAYMENT_SOFORT_SR_RECEIVED_CREDITED_DELCREDERE_SELLER', 'Statut de la transaction : La facture a été payée. Statut de la facture: Transfert de collection');
define('MODULE_PAYMENT_SOFORT_SR_RECEIVED_CREDITED_PENDING_SELLER', 'Statut de la transaction : La facture a été payée. Statut de la facture: Paiement client en attente.');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9000', 'Aucune transaction de facture n&apos;a été trouvée.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9001', 'La facture n&apos;a pas pu être confirmée.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9002', 'Le montant de la facture fournie dépasse la limite de crédit.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9003', 'La facture n&apos;a pas pu être annulée.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9004', 'La demande contenait des positions de chariot non valides.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9005', 'Le panier ne pouvait pas être modifié.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9006', 'L&apos;accès à l&apos;interface n&apos;est plus possible 30 jours après réception du paiement.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9007', 'La facture a déjà été annulée.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9008', 'Le montant de la taxe prévue est trop élevé.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9009', 'Les montants donnés aux taux de TVA des articles se rapportent les uns aux autres en conflit.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9010', 'Il n&apos;est pas possible de modifier le panier.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9011', 'Aucun commentaire n&apos;a été fourni sur la mise à jour du panier.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9012', 'Vous ne pouvez pas ajouter des positions au panier. De même, le montant par poste de facture ne peut pas être augmenté.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9013', 'Il n&apos;y a que des articles non affacturables dans votre panier.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9014', 'Le numéro de facture fourni est déjà utilisé.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9015', 'Le numéro de crédit fourni est déjà utilisé.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9016', 'Le numéro de commande fourni est déjà utilisé.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9017', 'La facture a déjà été confirmée.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_9018', 'Il n&apos;y avait pas de données mises à jour de la facture.');