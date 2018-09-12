<?php
require_once('mcp_service.php');
define('MODULE_PAYMENT_MCP_PREPAY_TEXT_DESCRIPTION', 'micropayment&trade; Prepay Module');
define('MODULE_PAYMENT_MCP_PREPAY_TEXT_TITLE', 'micropayment&trade; Prepay<br /><img src="http://www.micropayment.de/resources/?what=img&group=pp&show=type-h.4" />');
define('MODULE_PAYMENT_MCP_PREPAY_TEXT_TITLE_EXTERN', 'Prepay');
define('MODULE_PAYMENT_MCP_PREPAY_TEXT_INFO', '
<div style="margin:10px;">
<div style="float:right;"><img src="./images/micropayment/logo_small.png" width="150"/></div><div style="float:left;">
Vos avantages:<br />
- Fournisseur de paiement certifié<br />
- Transfert de données sécurisé (128-Bit SSL)<br />
- Aucune inscription requise<br /><br />
</div>
<div style="clear:both;"></div>
Vous êtes redirigé vers micropayment&trade;. Votre commande sera traitée immédiatement après que le processus de paiement a été complété avec succès !
</div>
');

define('MODULE_PAYMENT_MCP_PREPAY_STATUS_TITLE','Prepay');
define('MODULE_PAYMENT_MCP_PREPAY_STATUS_DESC','Prepay-Module by micropayment&trade;');
define('MODULE_PAYMENT_MCP_PREPAY_MINIMUM_AMOUNT_TITLE','Montant minimum');
define('MODULE_PAYMENT_MCP_PREPAY_MINIMUM_AMOUNT_DESC','montant minimum pour ce mode de paiement');
define('MODULE_PAYMENT_MCP_PREPAY_MAXIMUM_AMOUNT_TITLE','Montant maximum');
define('MODULE_PAYMENT_MCP_PREPAY_MAXIMUM_AMOUNT_DESC','Montant maximum pour ce mode de paiement');
define('MODULE_PAYMENT_MCP_PREPAY_SORT_ORDER_TITLE','Positionnement');
define('MODULE_PAYMENT_MCP_PREPAY_SORT_ORDER_DESC','Positionnement dans la sélection du mode de paiement');
define('MODULE_PAYMENT_MCP_PREPAY_ALLOWED_TITLE','Sélection du pays');
define('MODULE_PAYMENT_MCP_PREPAY_ALLOWED_DESC','N&apos;autoriser que les commandes en provenance de ces pays (liste séparée par des virgules DE,EN).');

define('MODULE_PAYMENT_MCP_PREPAY_COMMENT_INIT','Pending Payment. Expires on %s');
define('MODULE_PAYMENT_MCP_PREPAY_COMMENT_PAYIN','Paid in %s %s');
define('MODULE_PAYMENT_MCP_PREPAY_COMMENT_EXPIRED','Pas de dépôt');
?>