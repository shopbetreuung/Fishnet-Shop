<?php

require('includes/application.php');

require_once(DIR_FS_CATALOG . '/includes/database_tables.php');
require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
require_once(DIR_FS_INC . 'xtc_db_query.inc.php');

// include needed functions
require_once(DIR_FS_INC . 'xtc_redirect.inc.php');
require_once(DIR_FS_INC . 'xtc_href_link.inc.php');

include('language/' . $lang . '.php');

$inst_db = trim(stripslashes($_GET['inst_db']));
$config = trim(stripslashes($_GET['config']));

if (isset($inst_db) && $inst_db == 1)
{
    $db_link = xtc_db_connect_installer($_SESSION['db']['DB_SERVER'], $_SESSION['db']['DB_SERVER_USERNAME'], $_SESSION['db']['DB_SERVER_PASSWORD'], $_SESSION['db']['DB_DATABASE']);
    $sql = 'ALTER DATABASE `' . $_SESSION['db']['DB_DATABASE'] . '` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;';
    xtc_db_query($sql);
    $sql = 'SET NAMES utf8 COLLATE utf8_general_ci;';
    xtc_db_query($sql);
    $db_error = false;
    $sql_file = DIR_FS_CATALOG . DIR_SHOPHELFER_INSTALLER . '/' . SHOPHELFER_SQL;
    xtc_db_install($_SESSION['db']['DB_DATABASE'], $sql_file);
}
if (isset($config) && $config == 1)
{
    //create  includes/configure.php
    include ('includes/templates/configure.php');
    $fp = fopen(DIR_FS_CATALOG . 'includes/configure.php', 'w');
    fputs($fp, $file_contents);
    fclose($fp);

    //create  admin/includes/configure.php
    include ('includes/templates/configure_admin.php');
    $fp = fopen(DIR_FS_CATALOG . 'admin/includes/configure.php', 'w');
    fputs($fp, $file_contents);
    fclose($fp);
}
if (!$db_error)
{
    xtc_redirect(xtc_href_link('install_shopinfo_step.php', '', 'NONSSL'));
}
?>
