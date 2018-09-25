<?php
/* --------------------------------------------------------------
   $Id: blz_update.php 3499 2012-08-23 09:12:40Z dokuman $

   Shophelfer Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------

   Released under the GNU General Public License
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Mise à jour des codes bancaires de la Bundesbank allemande');
define('BLZ_INFO_TEXT', '<p>Ce formulaire met à jour la table de base de données pour les numéros de code bancaire de cette boutique. La table des numéros de code bancaire est utilisée lors du processus de commande pour le contrôle croisé des détails du virement bancaire.<br/>La Bundesbank allemande fournit de nouveaux fichiers tous les 3 mois.</p><p><strong>Avis de mise à jour :</strong></p><p>Veuillez ouvrir la <a href="http://www.bundesbank.de/Redaktion/DE/Standardartikel/Aufgaben/Unbarer_Zahlungsverkehr/bankleitzahlen_download.html" target="_blank" rel="noopener"><strong>page de téléchargement des codes bancaires de la Bundesbank allemande </strong></a>  dans un onglet séparé du navigateur. Plus bas sur le site Web de la Bundesbank allemande après la manchette "Bankleitzahlendateien ungepackt"  il existe un lien de téléchargement pour la dernière révision du fichier des numéros de code bancaire au format texte (TXT).  Copiez ce lien (clic droit de la souris sur le lien, la copie du lien) et entrez le lien copié dans ce champ de saisie.</p><p>Le bouton "Mettre à jour" lance le processus de mise à jour.<br/>La mise à jour prendra quelques secondes.</p><p><i>Exemple de lien sur la période du 06.03.2017 au 04.06.2017 :</i></p>');
define('BLZ_LINK_NOT_GIVEN_TEXT', '<span class="messageStackError">Aucun lien vers le fichier des codes bancaires de la Bundesbank allemande n&apos;a été fourni !</span><br /><br />');
define('BLZ_LINK_INVALID_TEXT', '<span class="messageStackError">Lien Internet invalide vers le fichier des codes bancaires.<br/><br/>Only TXT-files from the webpage of the German Bundesbank (www.bundesbank.de) are allowed!</span><br /><br />');
define('BLZ_DOWNLOADED_COUNT_TEXT', 'Nombre de numéros de code de banque reconnus de<br/>');
define('BLZ_PHP_FILE_ERROR_TEXT', '<p><strong><span class="messageStackError">Le paramètre PHP "allow_url_fopen" est désactivé ("off"). Il est nécessaire pour la fonction PHP <i>file( )</i>. Pour automatiser le processus de mise à jour, vous devez activer le paramètre (réglé sur "on").</span></strong></p>');
define('BLZ_UPDATE_SUCCESS_TEXT', ' ensembles de données écrites dans la base de données avec succès !');
define('BLZ_UPDATE_ERROR_TEXT', 'Une erreur s&apos;est produite !');
define('BLZ_LINK_ERROR_TEXT', '<span class="messageStackError">Le lien de téléchargement fourni n&apos;existe pas ! Veuillez vérifier vos entrées dans le champ de saisie de la page précédente./span>');
define('BLZ_LINES_PROCESSED_TEXT',' jeux de données de codes bancaires traités.');
define('BLZ_SOURCE_TEXT','Source: ');
?>