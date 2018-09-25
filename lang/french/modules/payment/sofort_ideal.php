<?php
/**
 * @version SOFORT Gateway 5.2.0 - $Date: 2012-09-06 14:27:56 +0200 (Thu, 06 Sep 2012) $
 * @author SOFORT AG (integration@sofort.com)
 * @link http://www.sofort.com/
 *
 * Copyright (c) 2012 SOFORT AG
 *
 * $Id: sofort_ideal.php 3751 2012-10-10 08:36:20Z gtb-modified $
 */

//include language-constants for used in all Multipay Projects - NOTICE: iDEAL is not Multipay
require_once 'sofort_general.php';

define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_TITLE', 'iDEAL <br /><img src="https://images.sofort.com/en/ideal/logo_90x30.png" alt="iDEAL logo"/>');
define('MODULE_PAYMENT_SOFORT_IDEAL_TEXT_TITLE', 'iDEAL');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_RECOMMENDED_PAYMENT_TEXT', '(recommander le mode de paiement)');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_DESCRIPTION', '<b>iDEAL</b><br />');

//alle im Shopsystem einstellbaren Params
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_STATUS_TITLE', 'Activer le module iDEAL');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_RECOMMENDED_PAYMENT_TITLE', 'recommander le mode de paiement');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_AUTH_TITLE', 'Touche de configuration pour le test');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_AUTH_DESC', "<script>function t(){k = document.getElementsByName(\"configuration[MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CONFIGURATION_KEY]\")[0].value;window.open(\"../callback/sofort/testAuth.php?k=\"+k);}</script><input type=\"button\" onclick=\"t()\" value=\"Test\" />");  //max 255 signs
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ZONE_TITLE' , MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_TITLE);
define('MODULE_PAYMENT_SOFORT_IDEAL_ALLOWED_TITLE' , 'Zone de paiement');
define('MODULE_PAYMENT_SOFORT_IDEAL_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TMP_STATUS_ID_TITLE' , 'Statut de commande temporaire');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ORDER_STATUS_ID_TITLE', 'Statut d&apos;une commande confirmée.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CANCELED_ORDER_STATUS_ID_TITLE', 'Order state at aborted payment');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_SORT_ORDER_TITLE', 'séquence de tri');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CONFIGURATION_KEY_TITLE', 'Assigned configuration key by SOFORT AG');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_PROJECT_PASSWORD_TITLE', 'project password');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_NOTIFICATION_PASSWORD_TITLE', 'notification password');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REASON_1_TITLE', 'Raison 1');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REASON_2_TITLE', 'Raison 2');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_IMAGE_TITLE', 'logo+text');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_STATUS_DESC', 'Active/désactive le module complet.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_RECOMMENDED_PAYMENT_DESC', 'Make iDEAL the recommended payment method');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ZONE_DESC', 'When a zone is selected, the payment method applies only to this zone.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TMP_STATUS_ID_DESC', 'État de l&apos;ordre pour les transactions non exécutées. L&apos;ordre a été créé mais la transaction n&apos;a pas encore été confirmée par SOFORT AG.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ORDER_STATUS_ID_DESC', 'Statut d&apos;une commande confirmée.<br />Statut de la commande après avoir complété avec succès une transaction.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CANCELED_ORDER_STATUS_ID_DESC', 'Statut de commande pour les commandes qui ont été annulées pendant le processus de commande.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_SORT_ORDER_DESC', 'Ordre d&apos;affichage. Le plus petit nombre apparaîtra en premier.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CONFIGURATION_KEY_DESC', 'Assigned configuration key by SOFORT AG');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_PROJECT_PASSWORD_DESC', 'Mot de passe de projet attribué par SOFORT AG');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_NOTIFICATION_PASSWORD_DESC', 'Mot de passe de notification attribué par SOFORT AG');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REASON_1_DESC', 'Raison 1');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_REASON_2_DESC', 'Raison 2');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_IMAGE_DESC', 'Bannière ou texte dans la sélection des modes de paiement.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CHECKOUT_TEXT', 'iDEAL.nl - Paiements en ligne pour le commerce électronique aux Pays-Bas. Pour le paiement par iDEAL, vous avez besoin d&apos;un compte auprès d&apos;une des banques listées. Recevez le virement directement à votre banque. Lorsque les services / marchandises disponibles peuvent être livrés ou expédiés IMMÉDIATEMENT !');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGEALT', 'iDEAL.nl - Paiements en ligne pour le commerce électronique aux Pays-Bas. Pour le paiement par iDEAL, vous avez besoin d&apos;un compte auprès d&apos;une des banques listées. Recevez le virement directement à votre banque. Lorsque les services / marchandises disponibles peuvent être livrés ou expédiés IMMÉDIATEMENT !');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TMP_COMMENT', 'Mode de paiement iDEAL choisi. La transaction n&apos;est pas terminée.');

//////////////////////////////////////////////////////////////////////////////////////////////

define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_PUBLIC_TITLE', 'SOFORT AG - iDEAL');


define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_TEXT', 'iDEAL.nl - Paiements en ligne pour le commerce électronique aux Pays-Bas. For payment by iDEAL you need an account with one of the banks listed. They will do the transfer directly to your bank. Services / goods are delivered or shipped when available IMMEDIATELY!');

define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_ERROR_HEADING', 'L&apos;erreur suivante s&apos;est produite au cours du processus:');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10000', 'Veuillez sélectionner une banque.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ERROR_ALL_CODES', 'Erreur de transmission, veuillez sélectionner une méthode de fabrication différente ou contacter le propriétaire du magasin en ligne.');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_ERROR_DEFAULT', 'Erreur de transmission, veuillez sélectionner une méthode de fabrication différente ou contacter le propriétaire du magasin en ligne.');

define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_IDEALSELECTED_PENDING' , 'Mode de paiement iDEAL choisi. La transaction n&apos;est pas terminée.');

define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_SELECTBOX_TITLE', 'Veuillez sélectionner votre banque');
define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_IMAGE', '
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><a href="http://www.ideal.nl" target="_blank">{{image}}</a></td>
        <td style="padding-left:30px;">' . MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_TEXT_DESCRIPTION_CHECKOUT_PAYMENT_SELECTBOX_TITLE . '{{selectbox}}</td>
      </tr>
      <tr>
      	<td colspan="2" class="main"><br />{{text}}</td>
      </tr>
    </table>');

define('MODULE_PAYMENT_SOFORT_IDEAL_CLASSIC_CHECKOUT_CONFIRMATION', '
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="main">
      	<p>Après avoir confirmé la commande, vous serez redirigé vers le système de paiement de la banque de votre choix, où ils peuvent effectuer le transfert en ligne.</p><p>Vous aurez besoin de vos données d&apos;accès eBanking, c&apos;est-à-dire les coordonnées bancaires, le numéro de compte, le code PIN et le TAN. Pour plus d&apos;informations, cliquez ici : <a href="http://www.ideal.nl" target="_blank">iDEAL.nl</a></p>
      </td>
    </tr>
  </table>');