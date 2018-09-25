<?php
/*
  $Id: backup.php,v 1.16 2002/03/16 21:30:02 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Gestionnaire de sauvegarde des bases de données');

define('TEXT_INFO_DO_BACKUP', 'La sauvegarde de la base de données est créée !');
define('TEXT_INFO_DO_BACKUP_OK', 'La sauvegarde de la base de données a été créée !');
define('TEXT_INFO_DO_GZIP', 'Le fichier de sauvegarde est emballé !');
define('TEXT_INFO_WAIT', 'S&apos;il vous plaît, attendez !');

define('TEXT_INFO_DO_RESTORE', 'La base de données sera restaurée !');
define('TEXT_INFO_DO_RESTORE_OK', 'La base de données a été restaurée !');
define('TEXT_INFO_DO_GUNZIP', 'Le fichier de sauvegarde est décompressé !');

define('ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST', 'Erreur : le répertoire de sauvegarde n&apos;existe pas. Veuillez corriger le bogue dans le fichier configure.php.');
define('ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE', 'Erreur : Vous ne pouvez pas écrire dans le répertoire de sauvegarde.');
define('ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE', 'Erreur : Le lien de téléchargement n&apos;est pas acceptable.');
define('ERROR_DECOMPRESSOR_NOT_AVAILABLE', 'Erreur: Aucun déballeur approprié n&apos;est disponible.');
define('ERROR_UNKNOWN_FILE_TYPE', 'Erreur : type de fichier inconnu.');
define('ERROR_RESTORE_FAILES', 'Erreur : Echec de la récupération.');
define('ERROR_DATABASE_SAVED', 'Erreur : La base de données n&apos;a pas pu être sauvegardée.');
define('ERROR_TEXT_PATH', 'Erreur : Le chemin vers mysqldump n&apos;a pas été trouvé ou spécifié !');

define('SUCCESS_LAST_RESTORE_CLEARED', 'Succès : La date de la dernière récupération a été modifiée.');
define('SUCCESS_DATABASE_SAVED', 'Succès : La base de données a été sauvegardée.');
define('SUCCESS_DATABASE_RESTORED', 'Succès : La base de données a été restaurée.');
define('SUCCESS_BACKUP_DELETED', 'Succès : La sauvegarde a été supprimée.');

define('TEXT_BACKUP_UNCOMPRESSED', 'Le fichier de sauvegarde a été décompressé :  ');

define('TEXT_SIMULATION', '<br>(Simulation avec fichier journal)');

?>