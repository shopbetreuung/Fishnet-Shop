<?php
require_once('mcp_service.php');
define('MODULE_PAYMENT_MCP_carte de crédit_TEXT_DESCRIPTION', 'Module carte de crédit <br />Données de test des cartes de crédit :<br /><br />CC#: 4111111111111111<br />Valable jusqu&apos;au : à tout moment<br />CVC#: 666');
define('MODULE_PAYMENT_MCP_carte de crédit_TEXT_TITLE', 'micropayment&trade; carte de crédit<br /><img src="http://www.micropayment.de/resources/?what=img&group=cc&show=type-h.4" />');
define('MODULE_PAYMENT_MCP_carte de crédit_TEXT_TITLE_EXTERN', 'carte de crédit');
define('MODULE_PAYMENT_MCP_carte de crédit_TEXT_INFO', '
<div style="margin:10px;">
<div style="float:right;"><img src="./images/micropayment/logo_small.png" width="150"/></div><div style="float:left;">
Your advantages:<br />
- Certified Payment Provider<br />
- Secure data transfer (128-Bit SSL)<br />
- No registration required<br /><br />
</div>
<div style="clear:both;"></div>
You are being forwarded to micropayment&trade;. Your order will be processed immediately after the payment process has been successfully completed!
</div>
');
define('MODULE_PAYMENT_MCP_carte de crédit_STATUS_TITLE','carte de crédit');
define('MODULE_PAYMENT_MCP_carte de crédit_STATUS_DESC','carte de crédit module de micropayment&trade;');
define('MODULE_PAYMENT_MCP_carte de crédit_MINIMUM_montant_TITLE','montant minimum');
define('MODULE_PAYMENT_MCP_carte de crédit_MINIMUM_montant_DESC','montant minimum');
define('MODULE_PAYMENT_MCP_carte de crédit_MAXIMUM_montant_TITLE','montant maximum');
define('MODULE_PAYMENT_MCP_carte de crédit_MAXIMUM_montant_DESC','montant maximum');
define('MODULE_PAYMENT_MCP_carte de crédit_SORT_ORDER_TITLE','Positionnement');
define('MODULE_PAYMENT_MCP_carte de crédit_SORT_ORDER_DESC','Positionnement dans la sélection du mode de paiement');
define('MODULE_PAYMENT_MCP_carte de crédit_ALLOWED_TITLE','Sélection du pays');
define('MODULE_PAYMENT_MCP_carte de crédit_ALLOWED_DESC','N&apos;autoriser que les commandes en provenance de ces pays (liste séparée par des virgules DE,EN).');

?>
