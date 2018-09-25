<?php
/* --------------------------------------------------------------
   $Id: backup.php 899 2005-04-29 02:40:57Z hhgag $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(backup.php,v 1.21 2002/06/15); www.oscommerce.com
   (c) 2003	 nextcommerce (backup.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Gestionnaire de sauvegarde des bases de données');

define('TABLE_HEADING_TITLE', 'Titre');
define('TABLE_HEADING_FILE_DATE', 'Date');
define('TABLE_HEADING_FILE_SIZE', 'Taille');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_HEADING_NEW_BACKUP', 'Nouvelle sauvegarde');
define('TEXT_INFO_HEADING_RESTORE_LOCAL', 'Restaurer locale');
define('TEXT_INFO_NEW_BACKUP', 'N&apos;interrompez pas le processus de sauvegarde qui peut prendre quelques minutes.');
define('TEXT_INFO_UNPACK', '<br /><br />(après avoir décompressé le fichier de l&apos;archive)');
define('TEXT_INFO_RESTORE', 'N&apos;interrompez pas le processus de restauration.<br/><br/>Plus la sauvegarde est importante, plus ce processus est long !<br /><br />Si possible, utilisez le client mysql.<br /><br />Par exemple :<br /><br /><b>mysql -h' . DB_SERVER . ' -u' . DB_SERVER_USERNAME . ' -p ' . DB_DATABASE . ' < %s </b> %s');
define('TEXT_INFO_RESTORE_LOCAL', 'N&apos;interrompez pas le processus de restauration.<br/><br/>Plus la sauvegarde est grande, plus ce processus prend du temps !');
define('TEXT_INFO_RESTORE_LOCAL_RAW_FILE', 'Le fichier téléchargé doit être un fichier sql brut (texte).');
define('TEXT_INFO_DATE', 'Date:');
define('TEXT_INFO_SIZE', 'Taille:');
define('TEXT_INFO_COMPRESSION', 'Compression:');
define('TEXT_INFO_USE_GZIP', 'Utiliser GZIP');
define('TEXT_INFO_USE_ZIP', 'Utiliser ZIP');
define('TEXT_INFO_USE_NO_COMPRESSION', 'Pas de compression (Pure SQL)');
define('TEXT_INFO_DOWNLOAD_ONLY', 'Télécharger seulement (ne pas stocker côté serveur)');
define('TEXT_INFO_BEST_THROUGH_HTTPS', 'Le mieux serait une connexion HTTPS.');

define('TEXT_NO_EXTENSION', 'Aucun');
define('TEXT_BACKUP_DIRECTORY', 'Répertoire de sauvegarde :');
define('TEXT_LAST_RESTORATION', 'Dernière restauration:');
define('TEXT_FORGET', '(<u>oubliez</u>)');
define('TEXT_DELETE_INTRO', 'Êtes-vous sûr de vouloir supprimer cette sauvegarde ?');

define('ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST', 'Erreur : Le répertoire de sauvegarde n&apos;existe pas. Veuillez le définir dans le fichier configure.php.');
define('ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE', 'Erreur : Le répertoire de sauvegarde n&apos;est pas inscriptible.');
define('ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE', 'Erreur : Le lien de téléchargement n&apos;est pas acceptable.');

define('SUCCESS_LAST_RESTORE_CLEARED', 'Succès : La dernière date de restauration a été effacée.');
define('SUCCESS_DATABASE_SAVED', 'Succès : La base de données a été sauvegardée.');
define('SUCCESS_DATABASE_RESTORED', 'Succès : La base de données a été restaurée.');
define('SUCCESS_BACKUP_DELETED', 'succès : La sauvegarde a été supprimée.');

//TEXT_COMPLETE_INSERTS
define('TEXT_COMPLETE_INSERTS', "<b>Complete 'INSERT's</b><br> - les noms de champs sont entrés dans chaque ligneINSERT (sauvegarde accrue)");

?>
