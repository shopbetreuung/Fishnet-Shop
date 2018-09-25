<?php
/**
 * @version SOFORT Gateway 5.2.0 - $Date: 2012-09-13 11:51:22 +0200 (Thu, 13 Sep 2012) $
 * @author SOFORT AG (integration@sofort.com)
 * @link http://www.sofort.com/
 *
 * Copyright (c) 2012 SOFORT AG
 *
 * $Id: sofort_sofortvorkasse.php 3751 2012-10-10 08:36:20Z gtb-modified $
 */
//include language-constants used in all Multipay Projects
require_once 'sofort_general.php';

define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_CONDITIONS', '
	<script type="text/javascript">
		function showSvConditions() {
			svOverlay = new sofortOverlay(jQuery(".svOverlay"), "callback/sofort/ressources/scripts/getContent.php", "https://documents.sofort.com/de/sv/privacy_de");
			svOverlay.trigger();
		}
		document.write(\'<a id="svNotice" href="javascript:void(0)" onclick="showSvConditions()">J&apos;ai lu la politique de confidentialité.</a>\');
	</script>
	<div style="display:none; z-index: 1001;filter: alpha(opacity=92);filter: progid :DXImageTransform.Microsoft.Alpha(opacity=92);-moz-opacity: .92;-khtml-opacity: 0.92;opacity: 0.92;background-color: black;position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;text-align: center;vertical-align: middle;" class="svOverlay">
		<div class="loader" style="z-index: 1002;position: relative;background-color: #fff;border: 5px solid #C0C0C0;top: 40px;overflow: scroll;padding: 4px;border-radius: 7px;-moz-border-radius: 7px;-webkit-border-radius: 7px;margin: auto;width: 620px;height: 400px;overflow: scroll; overflow-x: hidden;">
			<div class="closeButton" style="position: fixed; top: 54px; background: url(callback/sofort/ressources/images/close.png) right top no-repeat;cursor:pointer;height: 30px;width: 30px;"></div>
			<div class="content"></div>
		</div>
	</div>
	<noscript>
		<a href="https://documents.sofort.com/de/sv/privacy_de" target="_blank">J&apos;ai lu la politique de confidentialité.</a>
	</noscript>
');
define('MODULE_PAYMENT_SOFORT_SV_TEXT_TITLE', 'Vorkasse by SOFORT <br /> <img src="https://images.sofort.com/en/sv/logo_90x30.png" alt="Logo Vorkasse by SOFORT"/>');
define('MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_TEXT_TITLE', 'Vorkasse (pay in advance)');
define('MODULE_PAYMENT_SOFORT_SV_KS_TEXT_TITLE', 'Paiement à l&apos;avance avec protection du consommateur');
define('MODULE_PAYMENT_SOFORT_SV_TEXT_ERROR_MESSAGE', 'Le paiement n&apos;est malheureusement pas possible ou a été annulé par le client. Veuillez choisir un autre mode de paiement.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_SV', 'Le paiement n&apos;est malheureusement pas possible ou a été annulé par le client. Veuillez choisir un autre mode de paiement.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_SV_CHECKOUT_TEXT', '');
define('MODULE_PAYMENT_SOFORT_SV_STATUS_TITLE', 'Activer sofort.de module');
define('MODULE_PAYMENT_SOFORT_SV_STATUS_DESC', 'Active/désactive le module complet.');
define('MODULE_PAYMENT_SOFORT_SV_TEXT_DESCRIPTION', 'Paiement à l&apos;avance avec rapprochement automatique.');
define('MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_ALLOWED_TITLE', 'Zones autorisées');
define('MODULE_PAYMENT_SOFORT_SOFORTVORKASSE_ALLOWED_DESC', 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
define('MODULE_PAYMENT_SOFORT_SV_ZONE_TITLE', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_TITLE);
define('MODULE_PAYMENT_SOFORT_SV_ZONE_DESC', MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_DESC);
define('MODULE_PAYMENT_SOFORT_SV_SORT_ORDER_TITLE', 'séquence de tri');
define('MODULE_PAYMENT_SOFORT_SV_SORT_ORDER_DESC', 'Ordre d&apos;affichage. Le plus petit nombre apparaîtra en premier.');
define('MODULE_PAYMENT_SOFORT_SV_TMP_COMMENT', 'Paiement à l&apos;avance selon le mode de paiement choisi. La transaction n&apos;est pas encore terminée.');
define('MODULE_PAYMENT_SOFORT_SV_REASON_2_TITLE','Raison 2');
define('MODULE_PAYMENT_SOFORT_SV_REASON_2_DESC','Les espaces réservés suivants seront remplacés à l&apos;intérieur du motif (27 caractères maximum):<br />{{transaction_id}}<br />{{order_date}}<br />{{customer_id}}<br />{{customer_name}}<br />{{customer_company}}<br />{{customer_email}}');

define('MODULE_PAYMENT_SOFORT_SV_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGE', '');



define('MODULE_PAYMENT_SOFORT_SV_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGEALT', 'Payment avec Vorkasse par SOFORT: Aucune inscription n&apos;est requise. Vous effectuez le paiement vous-même auprès de votre banque.');

define('MODULE_PAYMENT_SOFORT_SV_ORDER_STATUS_ID_TITLE', 'Confirmed order status');
define('MODULE_PAYMENT_SOFORT_SV_ORDER_STATUS_ID_DESC', 'Confirmed Order <br /> Order after payment.');
define('MODULE_PAYMENT_SOFORT_SV_TMP_STATUS_ID_TITLE', 'Temporary order status');
define('MODULE_PAYMENT_SOFORT_STATUS_SV_LOSS', 'Up till now the payment could not be confirmed. {{time}}');
define('MODULE_PAYMENT_SOFORT_SV_TMP_STATUS_ID_DESC', 'Order state for non-completed transactions. The order has been created but the transaction has not yet been confirmed by SOFORT AG.');

define('MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT_TITLE', 'recommander le mode de paiement');
define('MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT_DESC', '"Cochez cette méthode de paiement comme "méthode de paiement recommandée". Sur la page de sélection de paiement, une note sera affichée juste derrière le mode de paiement."');
define('MODULE_PAYMENT_SOFORT_SV_RECOMMENDED_PAYMENT_TEXT', '(recommander le mode de paiement)');

define('MODULE_PAYMENT_SOFORT_SV_KS_STATUS_TITLE', 'Protection du client activée');
define('MODULE_PAYMENT_SOFORT_SV_KS_STATUS_DESC', 'Activer customer protection for  Vorkasse by SOFORT');
define('MODULE_PAYMENT_SOFORT_SV_KS_STATUS_TEXT', 'Protection du client activée');

define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_HEADING_TEXT', 'compte bancaire');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_TEXT', 'Veuillez utiliser les données de compte suivantes.:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_HOLDER_TEXT', 'titulaire du compte :');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_ACCOUNT_NUMBER_TEXT', 'numéro de compte :');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BANK_CODE_TEXT', 'Numéro de code de la banque :');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_IBAN_TEXT', 'IBAN:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_BIC_TEXT', 'BIC:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_AMOUNT_TEXT', 'Montant :');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_1_TEXT', 'usage prévu:');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_2_TEXT', '');
define('MODULE_PAYMENT_SOFORT_SV_CHECKOUT_REASON_HINT','Veuillez vous assurer d&apos;utiliser le but indiqué lorsque vous transférez l&apos;argent, afin que nous puissions égaler votre paiement correctement.');


?>