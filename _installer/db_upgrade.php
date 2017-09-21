<?php
/* --------------------------------------------------------------
  $Id$

  modified eCommerce Shopsoftware
  http://www.modified-shop.org

  Copyright (c) 2009 - 2013 [www.modified-shop.org]
  Released under the GNU General Public License
  -------------------------------------------------------------- */

require('includes/application.php');
require_once('../includes/configure.php');
require_once(DIR_FS_CATALOG . '/includes/database_tables.php');
require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
require_once(DIR_FS_INC . 'xtc_db_query.inc.php');
require_once(DIR_FS_INC . 'xtc_db_fetch_array.inc.php');
require_once(DIR_FS_INC . 'xtc_redirect.inc.php');

if (!$_POST && (!isset($_GET['upgrade_redir']) || $_GET['upgrade_redir'] != 1))
{
    xtc_redirect('./', '', 'NONSSL');
}

define('XTCOMMERCE304_FILE', 'update_xtc3.0.4sp2.1_to_1.0.1.0.sql');
$restore_query = '';
$used_files_display = '';

//get browser language
// preg_match('/^([a-z]+)-?([^,;]*)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang);
include('language/' . $lang . '.php');

// get DB version and size
xtc_db_connect() or die('Unable to connect to database server!');
$version_query = xtc_db_query("SELECT version FROM " . TABLE_DATABASE_VERSION);
$version_array = xtc_db_fetch_array($version_query);
if (substr($version_array['version'], 0, 3) == 'SH_')
{
    $db_version_update = 'update_' . substr($version_array['version'], 3);
    if ($version_array['version'] == "SH_1.0.0")
    {
        $db_version_update = '';
        $version_array['version'] = 'Shophelfer 1.0.0';
    }
}
elseif (substr($version_array['version'], 0, 4) == 'MOD_')
{
    $db_version_update = '';
    $version_array['version'] = 'modified eCommerce';
}
else
{
    $db_version_update = '';
    $version_array['version'] = 'unbekannt';
}
$initialDBSize = get_db_size();

// get all SQL update_files
$pfad = './sql/';
$ordner = opendir($pfad);
while ($datei = readdir($ordner))
{
    if (preg_match('/^update_[0-9]{1,2}.[0-9]{1,2}.[0-9]{1,2}/i', $datei)) //This should be preg_match which matches two-digit numbers
    { //accept only sql files that start(!) with scheme "update_x.x.x.x"
        $farray[] = $pfad . $datei;
    }
}
closedir($ordner);
//sort($farray);
natsort($farray); //We need natural sortig, because system take last one from array as update (it's because of two-digit numbers)

//DB seems to be an old xtCommerce installation, so include XTCOMMERCE304_FILE here
if ($db_version_update == '')
{
    unset($farray);
    $farray = array();
}

// drop unnecessary SQL update_files less than "$db_version"
foreach ($farray as $key => $item)
{
    if (preg_match("/$db_version_update/", $item))
    {
        break;
    }
    else
    {
        unset($farray[$key]);
    }
}

// Load and process all remaining SQL files
foreach ($farray as $sqlFileToExecute)
{
    $used_files_display .= $sqlFileToExecute . '<br />';
    $f = fopen($sqlFileToExecute, 'rb');
    $restore_query .= fread($f, filesize($sqlFileToExecute));
    fclose($f);
}

// SQL parsing taken from xtc_db_install.inc.php
$sql_array = array();
$sql_length = strlen($restore_query);
$pos = strpos($restore_query, ';');
for ($i = $pos; $i < $sql_length; $i++)
{
    if ($restore_query[0] == '#')
    {
        $restore_query = ltrim(substr($restore_query, strpos($restore_query, "\n")));
        $sql_length = strlen($restore_query);
        $i = strpos($restore_query, ';') - 1;
        continue;
    }
    if ($restore_query[($i + 1)] == "\n")
    {
        $next = '';
        for ($j = ($i + 2); $j < $sql_length; $j++)
        {
            if (trim($restore_query[$j]) != '')
            {
                $next = substr($restore_query, $j, 6);
                if ($next[0] == '#')
                {
                    // find out where the break position is so we can remove this line (#comment line)
                    for ($k = $j; $k < $sql_length; $k++)
                    {
                        if ($restore_query[$k] == "\n")
                            break;
                    }
                    $query = substr($restore_query, 0, $i + 1);
                    $restore_query = substr($restore_query, $k);
                    // join the query before the comment appeared, with the rest of the dump
                    $restore_query = $query . $restore_query;
                    $sql_length = strlen($restore_query);
                    $i = strpos($restore_query, ';') - 1;
                    continue 2;
                }
                break;
            }
        }
        if (empty($next))
        { // get the last insert query
            $next = 'insert';
        }

        // compare first 6 letters, if it fits an SQL statement to start a new line
        if ((strtoupper($next) == 'DROP T') || (strtoupper($next) == 'CREATE') || (strtoupper($next) == 'INSERT') || (strtoupper($next) == 'DELETE') || (strtoupper($next) == 'ALTER ') || (strtoupper($next) == 'TRUNCA') || (strtoupper($next) == 'UPDATE'))
        {
            $next = '';
            $sql_query = substr($restore_query, 0, $i);
            $sql_array[] = trim($sql_query);
            $restore_query = ltrim(substr($restore_query, $i + 1));
            $sql_length = strlen($restore_query);
            $i = strpos($restore_query, ';') - 1;
        }
    }
}

//get database size in bytes
function get_db_size()
{
    $result = xtc_db_query('SHOW TABLE STATUS');
    $dbsize = 0;
    while ($row = xtc_db_fetch_array($result, MYSQL_ASSOC))
    {
        $dbsize += $row['Data_length'] + $row['Index_length'];
    }
    return $dbsize;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title><?php echo TEXT_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>shophelfer.com Installer</title>
        <link rel="stylesheet" type="text/css" href="includes/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css" />
    </head>
    <body>
        <div class="container nopad">
            <div class="row">
                <div class="col-xs-12 nopad">
                    <a href="http://www.shophelfer.com/" target="_blank"><img src="images/logo.png" alt="shophelfer.com" /></a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center welcome">
                    <?php echo TITLE_UPGRADE; ?>
                </div>
            </div>
            <div class="row">
                <div class="well">
                    <?php
                    if (isset($_POST['submit']))
                    {
                        // Write SQL-statements to database if there are any
                        if (!empty($sql_array))
                        {
                            foreach ($sql_array as $stmt)
                            {

                                xtc_db_query($stmt);
                            }
                        }
                        // get new(!) DB-Version from the database itself
                        $version_query = xtc_db_query("SELECT version FROM " . TABLE_DATABASE_VERSION);
                        $version_array = xtc_db_fetch_array($version_query);
                        // BOF - Convert to UTF8
                        if ($version_array['version'] == "SH_1.2.0")
                        {
                            xtc_db_query('ALTER DATABASE ' . DB_DATABASE . ' CHARACTER SET utf8 COLLATE utf8_general_ci');
                            $sql = "SELECT CONCAT('ALTER TABLE `', t.`TABLE_SCHEMA`, '`.`', t.`TABLE_NAME`, '` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;') as FRST FROM `information_schema`.`TABLES` t WHERE t.`TABLE_SCHEMA` = '" . DB_DATABASE . "' AND t.`TABLE_COLLATION` NOT LIKE 'utf8_general_ci' ORDER BY 1";
                            $result = xtc_db_query($sql) or die(mysql_error());
                            while ($row = xtc_db_fetch_array($result))
                            {
                                xtc_db_query($row["FRST"]);
                            }
                            $sql = "SELECT CONCAT('ALTER TABLE `', t.`TABLE_SCHEMA`, '`.`', t.`TABLE_NAME`, '` CHARACTER SET utf8 COLLATE utf8_general_ci;') as FRST FROM `information_schema`.`TABLES` t WHERE t.`TABLE_SCHEMA` = '" . DB_DATABASE . "' AND t.`TABLE_COLLATION` NOT LIKE 'utf8_general_ci' ORDER BY 1";
                            $result = xtc_db_query($sql) or die(mysql_error());
                            while ($row = xtc_db_fetch_array($result))
                            {
                                xtc_db_query($row["FRST"]);
                            }
                        }
                        // EOF - Convert to UTF8
                        // BOF - Set Admin Flags
                        $aa_spalten_qry = xtc_db_query("SHOW COLUMNS FROM " . TABLE_ADMIN_ACCESS);
                        while ($aa_spalten = xtc_db_fetch_array($aa_spalten_qry))
                        {
                            if ($aa_spalten['Field'] != 'customers_id')
                            {
                                mysql_query("UPDATE admin_access SET " . $aa_spalten['Field'] . " = '1' WHERE customers_id = '1'");
                            }
                        }
                        // EOF - Set Admin Flags
                        echo CURRENT_DB_VERSION . ' <strong>' . $version_array['version'] . '</strong>';
                        echo SUCCESS_MESSAGE;
                        echo '<a class="btn btn-default" href="index.php">' . TEXT_CANCEL_BUTTON .'</a>';
                    }
                    else
                    {
                        echo CURRENT_DB_VERSION . ' <strong>' . $version_array['version'] . '</strong>';
                        echo USED_FILES;
                        echo '<div style="border:1px solid #ccc; background:#fff; padding:10px;">';
                        if ($used_files_display != '')
                        {
                            echo $used_files_display;
                        }
                        else if ($db_version_update !== '')
                        {
                            echo UPGRADE_NOT_NECESSARY;
                        }
                        else
                        {
                            echo UPGRADE_NOT_POSSIBLE;
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                <?php
                //HTML-input form
                if (!isset($_POST['submit']))
                {
                ?>
                    <div class="col-xs-3 pull-right nopad">
                        <div class="pull-right">
                            <form method="post">
                                <a class="btn btn-default" href="index.php"><?php echo TEXT_CANCEL_BUTTON; ?></a>
                                <input type="submit" name="submit" class="btn btn-primary" value="<?php echo TEXT_SUBMIT_BUTTON; ?>" />
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>