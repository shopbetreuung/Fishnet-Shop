<?php
/* --------------------------------------------------------------
  $Id: install_database_step.php 3072 2012-06-18 15:01:13Z hhacker $

  modified eCommerce Shopsoftware
  http://www.modified-shop.org

  Copyright (c) 2009 - 2013 [www.modified-shop.org]
  --------------------------------------------------------------
  based on:
  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
  (c) 2002-2003 osCommerce(install.php,v 1.7 2002/08/14); www.oscommerce.com
  (c) 2003 nextcommerce (install_step1.php,v 1.10 2003/08/17); www.nextcommerce.org
  (c) 2006 XT-Commerce www.xt-commerce.com

  Released under the GNU General Public License
  -------------------------------------------------------------- */

require('includes/application.php');

require_once(DIR_FS_CATALOG . '/includes/database_tables.php');
require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
require_once(DIR_FS_INC . 'xtc_db_query.inc.php');

// include needed functions
require_once(DIR_FS_INC . 'xtc_image.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_separator.inc.php');
require_once(DIR_FS_INC . 'xtc_redirect.inc.php');
require_once(DIR_FS_INC . 'xtc_href_link.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_form.inc.php');

include('language/' . $lang . '.php');

if (!$script_filename = str_replace('\\', '/', getenv('PATH_TRANSLATED')))
{
    $script_filename = getenv('SCRIPT_FILENAME');
}
$script_filename = str_replace('//', '/', $script_filename);

if (!$request_uri = getenv('REQUEST_URI'))
{
    if (!$request_uri = getenv('PATH_INFO'))
    {
        $request_uri = getenv('SCRIPT_NAME');
    }

    if (getenv('QUERY_STRING'))
    {
        $request_uri .= '?' . getenv('QUERY_STRING');
    }
}

$dir_fs_www_root_array = explode('/', dirname($script_filename));
$dir_fs_www_root = array();
for ($i = 0; $i < sizeof($dir_fs_www_root_array) - 2; $i++)
{
    $dir_fs_www_root[] = $dir_fs_www_root_array[$i];
}
$dir_fs_www_root = implode('/', $dir_fs_www_root);

//DIR_WS_CATALOG
$dir_ws_www_root_array = explode('/', dirname($request_uri));
$dir_ws_www_root = array();
for ($i = 0; $i < sizeof($dir_ws_www_root_array) - 1; $i++)
{
    if ($dir_ws_www_root_array[$i] != '.' && $dir_ws_www_root_array[$i] != '..')
    { // web28 - 2010-03-18 - Fix Dir
        $dir_ws_www_root[] = $dir_ws_www_root_array[$i];
    }
}
$dir_ws_www_root = implode('/', $dir_ws_www_root);

//BOF - web28 - 2010-03-18 - RESTORE POST  & GET DATA
$inst_db = true;
$config = true;
if (isset($_POST['DB_SERVER']))
{
    if ($_POST['install_db'] != 1)
    {
        $inst_db = false;
    }

    if ($_POST['install_cfg'] != 1)
    {
        $config = false;
    }
}
//EOF - web28 - 2010-03-18 - RESTORE POST  & GET DATA

if (!$script_filename = str_replace('\\', '/', getenv('PATH_TRANSLATED')))
{
    $script_filename = getenv('SCRIPT_FILENAME');
}
$script_filename = str_replace('//', '/', $script_filename);

if (!$request_uri = getenv('REQUEST_URI'))
{
    if (!$request_uri = getenv('PATH_INFO'))
    {
        $request_uri = getenv('SCRIPT_NAME');
    }
    if (getenv('QUERY_STRING'))
        $request_uri .= '?' . getenv('QUERY_STRING');
}

$dir_fs_www_root_array = explode('/', dirname($script_filename));
$dir_fs_www_root = array();
for ($i = 0; $i < sizeof($dir_fs_www_root_array) - 2; $i++)
{
    $dir_fs_www_root[] = $dir_fs_www_root_array[$i];
}
$dir_fs_www_root = implode('/', $dir_fs_www_root);

$dir_ws_www_root_array = explode('/', dirname($request_uri));
$dir_ws_www_root = array();
for ($i = 0; $i < sizeof($dir_ws_www_root_array) - 1; $i++)
{
    $dir_ws_www_root[] = $dir_ws_www_root_array[$i];
}
$dir_ws_www_root = implode('/', $dir_ws_www_root);

unset($_SESSION['db']);
unset($_SESSION['configure']);
$_SESSION['db'] = array();
$_SESSION['configure'] = array();

if (isset($_GET['process']) && $_GET['process'] == 'true'){
    //connect to database
    $db = array();
    $db['DB_SERVER'] = trim(stripslashes($_POST['DB_SERVER']));
    $db['DB_SERVER_USERNAME'] = trim(stripslashes($_POST['DB_SERVER_USERNAME']));
    $db['DB_SERVER_PASSWORD'] = trim(stripslashes($_POST['DB_SERVER_PASSWORD']));
    $db['DB_DATABASE'] = trim(stripslashes($_POST['DB_DATABASE']));

    $db_error = false;
    $db_warning = '';
    if (isset($db['DB_SERVER']) && !empty($db['DB_SERVER']) && isset($db['DB_SERVER_USERNAME']) && !empty($db['DB_SERVER_USERNAME']) && isset($db['DB_SERVER_PASSWORD']) && !empty($db['DB_SERVER_PASSWORD']) && isset($db['DB_DATABASE']) && !empty($db['DB_DATABASE'])) {
        $conn = xtc_db_connect_installer($db['DB_SERVER'], $db['DB_SERVER_USERNAME'], $db['DB_SERVER_PASSWORD'], $db['DB_DATABASE']);
        if ($conn) {
            $sql = 'ALTER DATABASE ' . $db['DB_DATABASE'] . ' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;';
            @mysqli_query($sql);
            $sql = 'SET NAMES utf8 COLLATE utf8_general_ci;';
            @mysqli_query($sql);

            $_SESSION['db']['DB_SERVER'] = $db['DB_SERVER'];
            $_SESSION['db']['DB_SERVER_USERNAME'] = $db['DB_SERVER_USERNAME'];
            $_SESSION['db']['DB_SERVER_PASSWORD'] = $db['DB_SERVER_PASSWORD'];
            $_SESSION['db']['DB_DATABASE'] = $db['DB_DATABASE'];
        } else {
            $db_error = true;
            $db_warning = '<strong>'. TEXT_DB_DATA_NOT_CORRECT .'</strong>';
        }
    } else {
            $db_error = true;
            $db_warning = '<br /><strong>' . TEXT_DB_DATA_NOT_ENTERED_ERROR . '</strong>';
    }

    //check MySQL *server* version
    if (!$db_error)
    {
        if (function_exists('version_compare'))
        {
            if (version_compare(mysqli_get_server_info($conn), "4.1.2", "<") && strpos(strtolower(mysqli_get_server_info($conn)), 'native') === false)
            {
                $db_warning = '<br /><strong>' . TEXT_DB_SERVER_VERSION_ERROR . ' 4.1.2. <br /><br />' . TEXT_DB_SERVER_VERSION . mysqli_get_server_info() . '</strong>.';
            }
        }
    }
    //check MySQL *client* version
    if (!$db_error)
    {
        if (function_exists('version_compare'))
        {
            preg_match("/[0-9]\.[0-9]\.[0-9]/", mysqli_get_client_info($conn), $client_info);
            if (version_compare($client_info[0], "4.1.2", "<") && strpos(strtolower(mysqli_get_client_info($conn)), 'native') === false)
            {
                $db_warning = '<br /><strong>' . TEXT_DB_CLIENT_VERSION_WARNING . '<br /><br />' . TEXT_DB_CLIENT_VERSION . mysqli_get_client_info() . '</strong>.';
            }
        }
    }
    //check db permission
    if (!$db_error)
    {
        xtc_db_test_create_db_permission($db['DB_DATABASE']);
    }

    $_SESSION['configure']['HTTP_SERVER'] = trim(stripslashes($_POST['HTTP_SERVER']));
    $_SESSION['configure']['HTTPS_SERVER'] = trim(stripslashes($_POST['HTTPS_SERVER']));
    $_SESSION['configure']['ENABLE_SSL'] = trim(stripslashes($_POST['ENABLE_SSL']));
    $_SESSION['configure']['USE_SSL_PROXY'] = trim(stripslashes($_POST['USE_SSL_PROXY']));
    $_SESSION['configure']['DIR_WS_CATALOG'] = trim(stripslashes($_POST['DIR_WS_CATALOG']));

    if (!$db_error)
    {
        xtc_redirect(xtc_href_link('install_permissions_step.php?inst_db=' . xtc_db_prepare_input($_POST["install_db"]) . '&config=' . xtc_db_prepare_input($_POST['install_cfg']), '', 'NONSSL'));
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
        <title>Fishnet Shop Installer</title>
        <link rel="stylesheet" type="text/css" href="includes/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css" />
    </head>
    <body>
        <div class="container nopad">
            <div class="row">
                <div class="col-xs-12 nopad">
                    <a href="http://www.fishnet-shop.com/" target="_blank" rel="noopener"><img src="images/logo.png" alt="fishnetshop" /></a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 nopad">
                    <p class="blue text-center"><?php echo TITLE_INSTALLATION_PROCESS; ?></p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 25%; min-width: 2%;">
                            25% <?php echo TEXT_COMPLETE ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($db_error && $db_warning != '') {?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 bg-danger text-danger">
                    <?php echo $db_warning; ?>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center welcome">
                    <?php echo TEXT_WELCOME_DBCONNECTION_STEP; ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="well"><?php echo TEXT_WELCOME_STEP1; ?></div>
            </div>
        </div>
        <form name="install" method="post" action="install_database_step.php?process=true">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 nopad">
                        <h2><?php echo TITLE_CUSTOM_SETTINGS; ?></h2>
                        <div class="well">
                            <p><?php echo xtc_draw_checkbox_field_installer('install_db', 1, $inst_db); ?>
                                <b><?php echo TEXT_IMPORT_DB; ?></b><br />
                                <?php echo TEXT_IMPORT_DB_LONG; ?></p>
                            <p><?php echo xtc_draw_checkbox_field_installer('install_cfg', 1, $config); ?>
                                <b><?php echo TEXT_AUTOMATIC; ?></b><br />
                                <?php echo TEXT_AUTOMATIC_LONG; ?></p>
                        </div>
                        <h2><?php echo TITLE_DATABASE_SETTINGS; ?></h2>
                        <div class="well">
                            <p><b><?php echo TEXT_DATABASE_SERVER; ?></b><br />
                                <?php echo xtc_draw_input_field_installer('DB_SERVER', '', 'text', 'value="localhost" style="width: 30%;"'); ?><br />
                                <?php echo TEXT_DATABASE_SERVER_LONG; ?></p>
                            <p><b><?php echo TEXT_USERNAME; ?></b><br />
                                <?php echo xtc_draw_input_field_installer('DB_SERVER_USERNAME', '', 'text', 'style="width: 30%;"'); ?><br />
                                <?php echo TEXT_USERNAME_LONG; ?></p>
                            <p class="dbpw"><b><?php echo TEXT_PASSWORD; ?></b><br />
                                <?php echo xtc_draw_password_field_installer('DB_SERVER_PASSWORD'); ?><br />
                                <?php echo TEXT_PASSWORD_LONG; ?></p>
                            <p><b><?php echo TEXT_DATABASE; ?></b><br />
                                <?php echo xtc_draw_input_field_installer('DB_DATABASE', '', 'text', 'style="width: 30%;"'); ?><br />
                                <?php echo TEXT_DATABASE_LONG; ?></p>
                        </div>
                        <h2><?php echo TITLE_WEBSERVER_SETTINGS; ?> </h2>
                        <div class="well">
                            <p><b><?php echo TEXT_WS_ROOT; ?></b></p>
                            <?php echo xtc_draw_hidden_field_installer('DIR_FS_DOCUMENT_ROOT', DIR_FS_DOCUMENT_ROOT); ?>
                            <?php echo xtc_draw_input_field_installer('documentRoot', DIR_FS_DOCUMENT_ROOT, '', 'style="width: 30%;" disabled'); ?>
                            <p><?php echo TEXT_WS_ROOT_INFO; ?></p>
                            <p><b><?php echo TEXT_WS_CATALOG; ?></b></p>
                            <?php echo xtc_draw_hidden_field_installer('DIR_WS_CATALOG', $dir_ws_www_root . '/'); ?>
                            <?php echo xtc_draw_input_field_installer('wwwRoot', $dir_ws_www_root, '', 'style="width: 30%;" disabled'); ?>
                            <p><?php echo TEXT_WS_ROOT_INFO; ?></p>
                            <p>
                                <b><?php echo TEXT_HTTP; ?></b><br />
                                <?php echo xtc_draw_input_field_installer('HTTP_SERVER', 'http://' . rtrim(getenv('HTTP_HOST'), '/'), '', 'style="width: 30%;"'); ?><br />
                                <?php echo TEXT_HTTP_LONG; ?>
                            </p>
                            <p>
                                <b><?php echo TEXT_HTTPS; ?>*</b><br />
                                <?php echo xtc_draw_input_field_installer('HTTPS_SERVER', 'https://' . rtrim(getenv('HTTP_HOST'), '/'), '', 'style="width: 30%;"'); ?> <br />
                                <?php echo TEXT_HTTPS_LONG; ?>
                            </p>
                            <p>
                                <?php echo xtc_draw_checkbox_field_installer('ENABLE_SSL', 'true'); ?>
                                <b><?php echo TEXT_SSL; ?></b><br />
                                <?php echo TEXT_SSL_LONG; ?>
                            </p>
                            <p>
                                <?php echo xtc_draw_checkbox_field_installer('USE_SSL_PROXY', 'true') . TEXT_SSL_PROXY_LONG; ?>
                            </p>                    
                            <div style="border: #a3a3a3 1px solid; padding: 3px; background-color: #f4f4f4;">
                                <?php echo TEXT_SSL_PROXY_EXP; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2 pull-right nopad">
                        <div class="pull-right">
                            <a class="btn btn-default" href="index.php"><?php echo TEXT_CANCEL_BUTTON; ?></a>
                            <input type="submit" class="btn btn-primary" value="<?php echo TEXT_CONTINUE_BUTTON; ?>" /> 
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>