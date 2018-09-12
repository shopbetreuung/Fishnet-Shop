<?php
require_once('mcp_prepay.php');
define('MODULE_PAYMENT_MCP_SERVICE_STATUS_TITLE','(global) Status');
define('MODULE_PAYMENT_MCP_SERVICE_STATUS_DESC','(global) Activer le module micropayment&trade;');
define('MODULE_PAYMENT_MCP_SERVICE_SORT_ORDER_TITLE','Positionnement');
define('MODULE_PAYMENT_MCP_SERVICE_SORT_ORDER_DESC','Position dans la liste');
define('MODULE_PAYMENT_MCP_SERVICE_ACCOUNT_ID_TITLE','(global) Account-ID');
define('MODULE_PAYMENT_MCP_SERVICE_ACCOUNT_ID_DESC','ID de compte de micropayment&trade;');
define('MODULE_PAYMENT_MCP_SERVICE_ACCESS_KEY_TITLE','Access-Key');
define('MODULE_PAYMENT_MCP_SERVICE_ACCESS_KEY_DESC','Accès - Clé de micropayment&trade;');
define('MODULE_PAYMENT_MCP_SERVICE_PROJECT_CODE_TITLE','Code projet');
define('MODULE_PAYMENT_MCP_SERVICE_PROJECT_CODE_DESC','Code projet de micropayment&trade;');
define('MODULE_PAYMENT_MCP_SERVICE_PAYTEXT_TITLE','Texte de paiement');
define('MODULE_PAYMENT_MCP_SERVICE_PAYTEXT_DESC','Texte utilisé pour l&apos;identification.');

define('MODULE_PAYMENT_MCP_SERVICE_THEME_TITLE','thème');
define('MODULE_PAYMENT_MCP_SERVICE_THEME_DESC','Thème pour les fenêtres de paiement, la valeur par défaut est x1.');

define('MODULE_PAYMENT_MCP_SERVICE_GFX_TITLE','Logo-Code');
define('MODULE_PAYMENT_MCP_SERVICE_GFX_DESC','Veuillez insérer votre Logo-Code ici.');

define('MODULE_PAYMENT_MCP_SERVICE_BGGFX_TITLE','Background image parameter');
define('MODULE_PAYMENT_MCP_SERVICE_BGGFX_DESC','Please insert your Background image parameter here.');

define('MODULE_PAYMENT_MCP_SERVICE_BGCOLOR_TITLE','Couleur d&apos;arrière-plan');
define('MODULE_PAYMENT_MCP_SERVICE_BGCOLOR_DESC','Veuillez insérer votre couleur d&apos;arrière-plan dans HEX ici.');

define('MODULE_PAYMENT_MCP_SERVICE_SECRET_FIELD_TITLE','Nom du champ de sécurité');
define('MODULE_PAYMENT_MCP_SERVICE_SECRET_FIELD_DESC','Pour plus de sécurité dans les communications de serveur à serveur, veuillez entrer un nom que vous seul connaissez.');
define('MODULE_PAYMENT_MCP_SERVICE_SECRET_FIELD_VALUE_TITLE','Security field value');
define('MODULE_PAYMENT_MCP_SERVICE_SECRET_FIELD_VALUE_DESC','Veuillez entrer un code de sécurité privé qui ne doit pas être transmis aux clients. Le serveur micropayment&trade; traitera ce code à chaque notification pour une meilleure sécurité.');
define('MODULE_PAYMENT_MCP_SERVICE_ORDER_STATUS_PENDING_PAYMENT_ID_TITLE','Statut de la commande : en cours de traitement');
define('MODULE_PAYMENT_MCP_SERVICE_ORDER_STATUS_PENDING_PAYMENT_ID_DESC','Le client paie la commande.');
define('MODULE_PAYMENT_MCP_SERVICE_ORDER_STATUS_PROCESSING_ID_TITLE','État de la commande : payé');
define('MODULE_PAYMENT_MCP_SERVICE_ORDER_STATUS_PROCESSING_ID_DESC','Le client a payé avec succès.');
define('MODULE_PAYMENT_MCP_SERVICE_ORDER_STATUS_CANCELLED_ID_TITLE','État de la commande : Annulé / Erreur');
define('MODULE_PAYMENT_MCP_SERVICE_ORDER_STATUS_CANCELLED_ID_DESC','Si une écriture rétroactive se produit, ce statut est activé.');

define('MODULE_PAYMENT_MCP_SERVICE_ALLOWED_IP_ADDRESSES','193.159.183.234;193.159.183.235;193.159.183.236');

define('MODULE_PAYMENT_MCP_SERVICE_SUCCESS_TRANSACTION','La commande a été payée. Le code d&apos;authentification est : %s');
define('MODULE_PAYMENT_MCP_SERVICE_IP_NOT_ALLOWED','L&apos;adresse IP n&apos;est pas valide.');
define('MODULE_PAYMENT_MCP_SERVICE_ERROR_TERMINATED','La demande n&apos;est pas valide.');
define('MODULE_PAYMENT_MCP_SERVICE_ERROR_UNKNOWN_ORDER_ID','Cet ordre n&apos;existe pas');
define('MODULE_PAYMENT_MCP_SERVICE_ERROR_SECRET_FIELD_MISSMATCH','Champ de sécurité erroné !');
define('MODULE_PAYMENT_MCP_SERVICE_ERROR_AMOUNT_MISSMATCH','La somme ne correspond pas au montant payé ! Réel : %s  Solde dû : %s');
define('MODULE_PAYMENT_MCP_SERVICE_PAYIN_MESSAGE','%s %s a été payé.');

define('MODULE_PAYMENT_MCP_SERVICE_PENDING_PAYMENT','Paiement en attente. Annulation automatique %s');
define('MODULE_PAYMENT_MCP_PREPAY_EXPIRED','Pas de reçu de paiement, annulation automatique');

define('MODULE_PAYMENT_MCP_SERVICE_NO_ACCOUNT','%s<div class="mcp_notice_register">Afin d&apos;assurer la fonctionnalité des modules de micropaiement, veuillez d&apos;abord enregistrer un compte et créer un projet.<a href="%s" target="blank">Cliquez ici pour vous inscrire.</a></div>');
define('MODULE_PAYMENT_MCP_SERVICE_CSS','
<style type="text/css">
.mcp_notice_register {
    margin-bottom: 5px;
    background-image: url("../images/micropayment/logo_small.png");
	background-position: 10px 10px;
	background-color: #ffdede;
    background-repeat: no-repeat;
    background-size: 100px;
    height: 40px;
	padding-left:130px;
	padding-top: 18px;
	border: 1px #cdcdcd solid;
}
</style>
');
?>