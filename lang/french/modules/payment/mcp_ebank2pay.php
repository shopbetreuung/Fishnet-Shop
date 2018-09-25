<?php
require_once('mcp_service.php');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_DESCRIPTION', 'micropayment&trade; module de banque directe');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_TITLE', 'micropayment&trade; banque directe<br /><img src="http://www.micropayment.de/resources/?what=img&group=eb2p&show=type-h.4" />');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_TITLE_EXTERN', 'banque directe');
define('MODULE_PAYMENT_MCP_EBANK2PAY_TEXT_INFO', '
<div style="margin:10px;">
<div style="float:right;"><img src="./images/micropayment/logo_small.png" width="150"/></div><div style="float:left;">
Your advantages:<br />
- Certified Payment Provider<br />
- Secure data transfer (128-Bit SSL)<br />
- No registration required<br /><br />
</div>
<div style="clear:both;"></div>
Vous êtes redirigé vers micropayment&trade;. Votre commande sera traitée immédiatement après que le processus de paiement a été complété avec succès !
</div>
');

define('MODULE_PAYMENT_MCP_EBANK2PAY_STATUS_TITLE','banque directe');
define('MODULE_PAYMENT_MCP_EBANK2PAY_STATUS_DESC','banque directe module by micropayment&trade;');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MINIMUM_AMOUNT_TITLE','Montant minimum');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MINIMUM_AMOUNT_DESC','montant minimum pour ce mode de paiement');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MAXIMUM_AMOUNT_TITLE','Montant maximum');
define('MODULE_PAYMENT_MCP_EBANK2PAY_MAXIMUM_AMOUNT_DESC','Montant maximum pour ce mode de paiement');
define('MODULE_PAYMENT_MCP_EBANK2PAY_SORT_ORDER_TITLE','Positionnement');
define('MODULE_PAYMENT_MCP_EBANK2PAY_SORT_ORDER_DESC','Positionnement dans la sélection du mode de paiement');
define('MODULE_PAYMENT_MCP_EBANK2PAY_ALLOWED_TITLE','Sélection du pays');
define('MODULE_PAYMENT_MCP_EBANK2PAY_ALLOWED_DESC','N&apos;autoriser que les commandes en provenance de ces pays (liste séparée par des virgules DE,EN).');

?>