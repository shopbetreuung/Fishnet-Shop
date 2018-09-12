<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_payment.php 3481 2012-08-22 07:07:50Z dokuman $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   based on:
   (C) 2007 Estelco - Ebusiness & more - http://www.estelco.de
   (C) 2004 IT eSolutions Andreas Zimmermann - http://www.it-esolutions.de

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$num = 3; //Nombre de barèmes de remise

define('MODULE_ORDER_TOTAL_PAYMENT_HELP_LINK', ' <a onclick="window.open(\'popup_help.php?type=order_total&modul=ot_payment&lng=french\', \'AIDE\', \'scrollbars=yes,resizable=yes,menubar=yes,width=800,height=600\'); return false" target="_blank" rel="noopener" href="popup_help.php?type=order_total&modul=ot_payment&lng=french"><b>[AIDE]</b></a>');
define('MODULE_ORDER_TOTAL_PAYMENT_HELP_TEXT', '<h2>Escompte et surtaxe sur les modes de paiement</h2>
S&apos;il y a plus d&apos;échelle de rabais requis (par défaut est <b>3</b>), la valeur de la variable $num (fichiers de langue) et $this->num (fichier de module) doit être changée à la valeur désirée.
Une augmentation ultérieure nécessite une désinstallation/réinstallation du module ou une correction manuelle de la base de données !
<hr>
<h3>Champs échelle d&apos;escompte</h3>
<p class="red">Attention : l&apos;adresse de livraison est cruciale pour les codes de pays. Si une remise ou une surcharge doit être valable pour tous les pays, le code 00 doit être utilisé ou le code du pays doit être complètement omis (y compris le &quot;||&quot ;)!</p>
<h4>Pour les rabais, utilisez l&apos;annotation suivante :</h4>
<pre>   <span class="blue">DE</span>|<span class="green">100</span>:<span class="red">4</span>,<span class="green">200</span>:<span class="red">5</span></pre>
<p>Ce qui veut dire:</p>
<p>Pour les clients de <span class="blue">Allemagne</span>  avec un volume de commande à partir de <span class="green">100&euro;</span> un rabais de <span class="red">4%</span> sera accordé, à partir de <span class="green">200&euro;</span> un rabais de <span class="red">5%</span> sera accordé.</p>
<pre>   <span class="green">100</span>:<span class="red">2</span>,<span class="green">200</span>:<span class="red">3</span></pre>
<p>Ce qui veut dire:</p>
<p>Pour les clients de all countries avec un volume de commande à partir de <span class="green">100&euro;</span> un rabais de <span class="red">2%</span>sera accordé, à partir de <span class="green">200&euro;</span> un rabais de <span class="red">3%</span> sera accordé.</p>
<h4>Pour les suppléments, utilisez la notation suivante:</h4>
<pre>   <span class="blue">DE</span>|<span class="green">100</span>:<span class="red">-3</span></pre>
<p>Ce qui veut dire:</p>
<p>Pour les clients de <span class="blue">Allemagne</span> avec un volume de commande à partir de <span class="green">100&euro;</span> un supplément de <span class="red">3%</span> sera ajouté.</p>
<h4>Exemple pour Paypal</h4>
1. échelle de remise
<pre>   <span class="blue">DE</span>|<span class="green">0</span>:<span class="red">-1.9</span>&amp;<span class="lila">-0.35</span></pre>
2. échelle de remise
<pre>   <span class="blue">00</span>|<span class="green">0</span>:<span class="red">-3.4</span>&amp;<span class="lila">-0.35</span></pre>
<p>Ce qui veut dire:</p>
<p>Pour les clients de <span class="blue">Allemagne</span> avec un volume de commande à partir de <span class="green">0&euro;</span> (c.-à-d. toujours) un supplément de <span class="red">1,9%</span> plus <span class="lila">0,35&euro;</span> sera ajouté.</p>
<p>Pour les clients de <span class="blue">all other countries (00=all)</span> avec un volume de commande à partir de <span class="green">0&euro;</span> un supplément de <span class="red">3,4%</span> plus <span class="lila">0,35&euro;</span> sera ajouté.</p>
<p>Important est la séquence des entrées (tous les autres pays toujours à la fin) et que &quot;Multiple calculation&quot ; est réglé sur &quot;false&quot ;, sinon les deux surcharges SERA ajouté.</p>
<h4>Exemple pour les montants fixes</h4>
<pre>   <span class="green">0</span>:<span class="red">0</span>&amp;<span class="lila">-2</span></pre>
<p>Ce qui veut dire:</p>
<p>Pour les clients de all countries avec un volume de commande à partir de <span class="green">0&euro;</span> (c.-à-d. toujours) un supplément de <span class="red">0%</span> (so no percentage surcharge) plus <span class="lila">2,00&euro;</span> (fixed surcharge) sera ajouté.</p>
<hr>
<h3>Champs Type de paiement</h3>
<p>Entrez le code d&apos;utilisation <b>interne</b> du type de paiement, par exemple <b>eustandardtransfer</b> pour Virement SEPA / Paiement anticipé ou <b>cod</b> pour Contre-remboursement. Si vous spécifiez plusieurs modes de paiement, ils doivent être séparés par des virgules.</p>
Voir aussiModules -&gt; Systèmes de paiement -&gt; colonne  &quot;Nom du module (pour usage interne)&quot;.<br/><br/>
<hr>
<h3>afficher dans le paiement à la caisse pendant le processus de commande</h3>
Si l&apos;escompte approprié doit être affiché pendant le processus de commande lorsqu&apos;un paiement doit être sélectionné, définissez l&apos;option &quot;Display in payment types&quot; sur &quot;true&quot;. <br/><br/>
En outre, vous pouvez définir le type d&apos;affichage avec l&apos;option &quot;Type d&apos;affichage dans le processus de commande pour la sélection de paiement&quot; :
<p> -- default: pourcentage ou montant, en fonction des entrées dans l&apos;échelle de remises.</p>
<p> -- price: toujours indiquer le montant réel</p>'
);

define('MODULE_ORDER_TOTAL_PAYMENT_TITLE', 'Type de paiement escompte et surtaxe');
define('MODULE_ORDER_TOTAL_PAYMENT_DESCRIPTION', 'Type de paiement escompte et surtaxe '.MODULE_ORDER_TOTAL_PAYMENT_HELP_LINK);

define('MODULE_ORDER_TOTAL_PAYMENT_STATUS_TITLE', 'Afficher la remise');
define('MODULE_ORDER_TOTAL_PAYMENT_STATUS_DESC', 'Voulez-vous activer la remise de commande ?');

define('MODULE_ORDER_TOTAL_PAYMENT_SORT_ORDER_TITLE', '<hr>ordre de tri');
define('MODULE_ORDER_TOTAL_PAYMENT_SORT_ORDER_DESC', 'séquence de présentation');

for ($j=1; $j<=$num; $j++) {
  define('MODULE_ORDER_TOTAL_PAYMENT_PERCENTAGE' . $j . '_TITLE', $j . '. Pourcentage d&apos;escompte');
  define('MODULE_ORDER_TOTAL_PAYMENT_PERCENTAGE' . $j . '_DESC', 'Montant de la remise (pays|value:pourcentage&frais)');
  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE' . $j . '_TITLE', $j . '. Type de paiement');
  define('MODULE_ORDER_TOTAL_PAYMENT_TYPE' . $j . '_DESC', 'Type de paiement pour obtenir un escompte');
}

define('MODULE_ORDER_TOTAL_PAYMENT_INC_SHIPPING_TITLE', '<hr>Inclure les frais d&apos;expédition');
define('MODULE_ORDER_TOTAL_PAYMENT_INC_SHIPPING_DESC', 'Inclure l&apos;expédition dans le calcul');

define('MODULE_ORDER_TOTAL_PAYMENT_INC_TAX_TITLE', '<hr>TVA comprise');
define('MODULE_ORDER_TOTAL_PAYMENT_INC_TAX_DESC', 'Inclure la taxe dans le calcul');

define('MODULE_ORDER_TOTAL_PAYMENT_CALC_TAX_TITLE', '<hr>Calculer la TVA');
define('MODULE_ORDER_TOTAL_PAYMENT_CALC_TAX_DESC', 'recalculer le total de la TVA');

define('MODULE_ORDER_TOTAL_PAYMENT_ALLOWED_TITLE', '<hr>Zone autorisée');
define('MODULE_ORDER_TOTAL_PAYMENT_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément</b> qui devrait être autorisé à utiliser ce module (par exemple AT,DE (laisser vide si vous voulez autoriser toutes les zones))');

define('MODULE_ORDER_TOTAL_PAYMENT_DISCOUNT', 'rabais');
define('MODULE_ORDER_TOTAL_PAYMENT_FEE', 'frais supplémentaire');

define('MODULE_ORDER_TOTAL_PAYMENT_TAX_CLASS_TITLE','<hr>Classe fiscale');
define('MODULE_ORDER_TOTAL_PAYMENT_TAX_CLASS_DESC','Utilisez la classe d&apos;imposition suivante pour les frais de commande petite.');

define('MODULE_ORDER_TOTAL_PAYMENT_BREAK_TITLE','<hr>Calcul multiple');
define('MODULE_ORDER_TOTAL_PAYMENT_BREAK_DESC','Des calculs multiples devraient-ils être possibles ? Si le calcul erroné sera arrêté après le premier réglage de montage.');

define('MODULE_ORDER_TOTAL_PAYMENT_SHOW_IN_CHECKOUT_PAYMENT_TITLE', '<hr>Affichage dans les types de paiement');
define('MODULE_ORDER_TOTAL_PAYMENT_SHOW_IN_CHECKOUT_PAYMENT_DESC', 'Affichage pendant le processus de paiement à la caisse.');

define('MODULE_ORDER_TOTAL_PAYMENT_SHOW_TYPE_TITLE', '<hr>Mode d&apos;affichage des types de paiement');
define('MODULE_ORDER_TOTAL_PAYMENT_SHOW_TYPE_DESC', 's&apos;affiche dans le processus de commande à la caisse.  <br /> - par défaut : pourcentage ou montant, en fonction des entrées à escompte. <br /> - price: il indiquera toujours le montant réel');


?>