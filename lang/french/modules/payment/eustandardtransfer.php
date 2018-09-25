<?php
/* -----------------------------------------------------------------------------------------
   $Id: eustandardtransfer.php 998 2005-07-07 14:18:20Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ptebanktransfer.php,v 1.4.1 2003/09/25 19:57:14); www.oscommerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_EUTRANSFER_TEXT_TITLE', 'Virement bancaire standard de l&apos;UE');
  define('MODULE_PAYMENT_EUSTANDARDTRANSFER_TEXT_TITLE', 'Virement bancaire');
  define('MODULE_PAYMENT_EUTRANSFER_TEXT_DESCRIPTION', 
          '<br />La méthode de paiement la moins chère et la plus simple au sein de l&apos;UE est le virement bancaire standard de l&apos;UE utilisant l&apos;IBAN et le BIC.' .
          '<br />Veuillez utiliser les détails suivants pour transférer la valeur totale de votre commande :<br />' .
          '<br />Nom de la banque: ' . MODULE_PAYMENT_EUTRANSFER_BANKNAM .
          '<br />Nom du compte :  ' . MODULE_PAYMENT_EUTRANSFER_BRANCH .
          '<br />IBAN:: ' . MODULE_PAYMENT_EUTRANSFER_ACCIBAN .
          '<br />BIC/SWIFT: ' . MODULE_PAYMENT_EUTRANSFER_BANKBIC .
//        '<br />Sort Code: ' . MODULE_PAYMENT_EUTRANSFER_SORTCODE .
          '<br /><br />Votre commande ne sera pas expédiée tant que nous n&apos;aurons pas reçu votre paiement dans le compte ci-dessus.<br />');

  define('MODULE_PAYMENT_EUTRANSFER_TEXT_INFO','Veuillez transférer le montant total de la facture sur notre compte. Les données de compte vous seront envoyées par e-mail après acceptation de votre commande.');
  define('MODULE_PAYMENT_EUTRANSFER_STATUS_TITLE','Autoriser le paiement par virement bancaire');
  define('MODULE_PAYMENT_EUTRANSFER_STATUS_DESC','Acceptez-vous les virements bancaires ?');
  define('MODULE_PAYMENT_EUTRANSFER_TEXT_INFO','');
  define('MODULE_PAYMENT_EUTRANSFER_BRANCH_TITLE','Nom du compte bancaire');
  define('MODULE_PAYMENT_EUTRANSFER_BRANCH_DESC','Le bénéficiaire du transfert.');

  define('MODULE_PAYMENT_EUTRANSFER_BANKNAM_TITLE','Nom de la banque');
  define('MODULE_PAYMENT_EUTRANSFER_BANKNAM_DESC','Le nom complet de la banque');

  define('MODULE_PAYMENT_EUTRANSFER_ACCIBAN_TITLE','Bank Account IBAN');
  define('MODULE_PAYMENT_EUTRANSFER_ACCIBAN_DESC','ID de compte international.<br />(demandez à votre banque si vous ne le connaissez pas)');

  define('MODULE_PAYMENT_EUTRANSFER_BANKBIC_TITLE','Bank Bic');
  define('MODULE_PAYMENT_EUTRANSFER_BANKBIC_DESC','International bank id.<br />(demandez à votre banque si vous ne le connaissez pas)');

  define('MODULE_PAYMENT_EUTRANSFER_SORT_ORDER_TITLE','Module Ordre de tri de l&apos;affichage.');
  define('MODULE_PAYMENT_EUTRANSFER_SORT_ORDER_DESC','Ordre de tri de l&apos;affichage. Le plus bas est affiché en premier.');

  define('MODULE_PAYMENT_EUSTANDARDTRANSFER_ALLOWED_TITLE' , 'Zones autorisées');
  define('MODULE_PAYMENT_EUSTANDARDTRANSFER_ALLOWED_DESC' , 'Veuillez entrer les zones <b>séparément </b> qui devrait être autorisé à utiliser ce module (par ex. AT,DE (laisser vide si vous voulez autoriser toutes les zones)).');

?>
