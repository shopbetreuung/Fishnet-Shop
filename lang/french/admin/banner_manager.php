<?php
/* --------------------------------------------------------------
   $Id: banner_manager.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner_manager.php,v 1.25 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (banner_manager.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Gestionnaire de bannière');

define('TABLE_HEADING_BANNERS', 'Bannières');
define('TABLE_HEADING_GROUPS', 'Groupes');
define('TABLE_HEADING_STATISTICS', 'Affichages / Clics');
define('TABLE_HEADING_STATUS', 'Statut');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_BANNERS_TITLE', 'Titre de la bannière:');
define('TEXT_BANNERS_URL', 'URL de la bannière:');
define('TEXT_BANNERS_GROUP', 'Groupe de bannières:');
define('TEXT_BANNERS_NEW_GROUP', ', ou entrez un nouveau groupe de bannières ci-dessous');
define('TEXT_BANNERS_IMAGE', 'Image:');
define('TEXT_BANNERS_IMAGE_LOCAL', ', ou entrez le fichier local ci-dessous');
define('TEXT_BANNERS_IMAGE_TARGET', 'Cible de l&apos;image (Enregistrer sous) :');
define('TEXT_BANNERS_HTML_TEXT', 'HTML Text:');
define('TEXT_BANNERS_EXPIRES_ON', 'expire le:');
define('TEXT_BANNERS_OR_AT', ', ou à');
define('TEXT_BANNERS_IMPRESSIONS', 'impressions/vues.');
define('TEXT_BANNERS_SCHEDULED_AT', 'Programmé à :');
define('TEXT_BANNERS_BANNER_NOTE', '<b>Notes de bannière:</b><ul><li>Utilisez une image ou un texte HTML pour la bannière - pas les deux.</li><li>Le texte html a priorité sur une image</li></ul>');
define('TEXT_BANNERS_INSERT_NOTE', '<b>Notes sur les images :</b><ul><li>Le téléchargement de répertoires doit avoir les permissions d&apos;utilisateur (écriture) appropriées !</li><li>Ne remplissez pas le champ  \'Enregistrer dans\' field si vous ne téléchargez pas une image sur le serveur Web (c&apos;est-à-dire que vous utilisez une image locale (côté serveur)).</li><li>Le champ \'Enregistrer dans\' doit être un répertoire existant avec une barre oblique de fin (par exemple, bannières/).</li></ul>');
define('TEXT_BANNERS_EXPIRCY_NOTE', '<b>Notes d&apos;expiration:</b><ul><li>Un seul des deux champs doit être soumis</li><li>Si la bannière ne doit pas expirer automatiquement, laissez ces champs vides.</li></ul>');
define('TEXT_BANNERS_SCHEDULE_NOTE', '<b>Notes de l&apos;annexe:</b><ul><li>Si un horaire est établi, la bannière sera activée à cette date.</li><li>Toutes les bannières programmées sont marquées comme désactivées jusqu&apos;à leur date d&apos;arrivée, à laquelle elles seront alors marquées comme actives.</li></ul>');

define('TEXT_BANNERS_DATE_ADDED', 'Date d&apos;ajout ::');
define('TEXT_BANNERS_SCHEDULED_AT_DATE', 'Programmé à : <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_DATE', 'Expire à : <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_IMPRESSIONS', 'Expire à: <b>%s</b> impressions');
define('TEXT_BANNERS_STATUS_CHANGE', 'Changement de statut : %s');

define('TEXT_BANNERS_DATA', 'D<br />A<br />T<br />A');
define('TEXT_BANNERS_LAST_3_DAYS', '3 derniers jours');
define('TEXT_BANNERS_BANNER_VIEWS', 'Vues de bannière');
define('TEXT_BANNERS_BANNER_CLICKS', 'Clics de bannière');

define('TEXT_INFO_DELETE_INTRO', 'Êtes-vous sûr de vouloir supprimer cette bannière ?');
define('TEXT_INFO_DELETE_IMAGE', 'Supprimer l&apos;image de la bannière');

define('SUCCESS_BANNER_INSERTED', 'Succès: La bannière a été insérée.');
define('SUCCESS_BANNER_UPDATED', 'Succès: La bannière a été mise à jour.');
define('SUCCESS_BANNER_REMOVED', 'Succès: La bannière a été retirée.');
define('SUCCESS_BANNER_STATUS_UPDATED', 'Succès: Le statut de la bannière a été mis à jour.');

define('ERROR_BANNER_TITLE_REQUIRED', 'Erreur : Titre de la bannière requis.');
define('ERROR_BANNER_GROUP_REQUIRED', 'Erreur:Groupe de bannière requis.');
define('ERROR_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Erreur:Le répertoire cible n&apos;existe pas: %s');
define('ERROR_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Erreur:Le répertoire cible n&apos;est pas inscriptible: %s');
define('ERROR_IMAGE_DOES_NOT_EXIST', 'Erreur:L&apos;image n&apos;existe pas.');
define('ERROR_IMAGE_IS_NOT_WRITEABLE', 'Erreur:L&apos;image ne peut pas être supprimée.');
define('ERROR_UNKNOWN_STATUS_FLAG', 'Erreur:Drapeau de statut inconnu.');

define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'Erreur:Le répertoire Graphs n&apos;existe pas. S&apos;il vous plaît, créez un répertoire \'graphs\' à l&apos;intérieur de \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', 'Erreur:Le répertoire Graphs n&apos;est pas inscriptible.');

// BOF - Tomcraft - 2009-11-06 - Use variable TEXT_BANNERS_DATE_FORMAT
define('TEXT_BANNERS_DATE_FORMAT', 'JJJJ-MM-TT');
// EOF - Tomcraft - 2009-11-06 - Use variable TEXT_BANNERS_DATE_FORMAT
?>