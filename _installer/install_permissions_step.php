<?php
/* --------------------------------------------------------------
  $Id: install_permissions_step.php 3072 2012-06-18 15:01:13Z hhacker $

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

include ('includes/check_permissions.php');

$inst_db = trim(stripslashes($_GET['inst_db']));
$config = trim(stripslashes($_GET['config']));
if ($error_flag == false) {
        xtc_redirect(xtc_href_link('install_database.php?inst_db='. xtc_db_prepare_input($inst_db).'&config='. xtc_db_prepare_input($config), '', 'NONSSL'));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>shophelfer.com Installer</title>
        <link rel="stylesheet" type="text/css" href="includes/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css" />
    </head>
    <body>
        <div class="container nopad">
            <div class="row">
                <div class="col-xs-12 nopad">
                    <a href="http://www.shophelfer.com/" target="_blank" rel="noopener"><img src="images/logo.png" alt="shophelfer.com" /></a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 nopad">
                    <p class="blue text-center"><?php echo TITLE_INSTALLATION_PROCESS; ?></p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 33%; min-width: 2%;">
                            33% <?php echo TEXT_COMPLETE ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center welcome">
                    <?php echo TEXT_WELCOME_PERMISSIONS_STEP; ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <?php
                if ($error_flag == true)
                {
                    ?>
                    <div class="well">
                        <h2><?php echo TEXT_CHMOD_REMARK_HEADLINE; ?></h2>
                        <?php echo TEXT_CHMOD_REMARK; ?>:<br />
                        <div class="alert alert-danger" role="alert"><?php echo $message; ?></div>

                        <?php
                        if ($folder_flag || $file_flag)
                        {
                            $host = isset($_POST['path']) ? $_POST['host'] : rtrim(getenv('HTTP_HOST'), '/');
                            $path = isset($_POST['path']) ? $_POST['path'] : basename(DIR_FS_CATALOG) . '/';
                            $port = isset($_POST['port']) ? $_POST['port'] : '21';
                            $login = isset($_POST['login']) ? $_POST['login'] : '';
                            ?>
                            <div>
                                <?php if (!empty($ftp_message)) echo $ftp_message; ?>
                                <div class="left" >
                                    <?php echo FTP_CHANGE_PERM_EXPLAIN; ?><br /><br />
                                </div>
                                <div>
                                    <form name="ftp" action="install_permissions_step.php" method="post">
                                        <label for="host"><?php echo FTP_HOST; ?>:</label><br />
                                        <?php echo xtc_draw_input_field_installer('host', $host, '', 'id="host"'); ?><br />
                                        <label for="port"><?php echo FTP_PORT; ?>:</label><br />
                                        <?php echo xtc_draw_input_field_installer('port', $port, '', 'id="port"'); ?><br />
                                        <label for="path"><?php echo FTP_PATH; ?>:</label><br />
                                        <?php echo xtc_draw_input_field_installer('path', $path, '', 'id="path"'); ?><br />
                                        <label for="login"><?php echo FTP_LOGIN; ?>:</label><br />
                                        <?php echo xtc_draw_input_field_installer('login', $login, '', 'id="login"'); ?><br />
                                        <label for="password"><?php echo FTP_PASSWORD; ?>:</label><br />
                                        <?php echo xtc_draw_password_field_installer('password', $password, '', 'id="password"'); ?><br />
                                        <?php echo xtc_draw_hidden_field_installer('action', 'ftp'); ?><br />
                                        <input type="submit" class="btn btn-primary" value="<?php echo CONNECT_FTP; ?>" />
                                    </form>
                                </div>
                            </div>
                            <?php
                        }
                        // EOC flth new permission fix system
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="row">
                <div class="col-xs-2 pull-right text-right nopad">
                    <br />
                    <a class="btn btn-primary" href="install_permissions_step.php" /><?php echo TEXT_RECHECK_PERMISSIONS; ?></a>
                </div>
            </div>
        </div>
    </form>
</body>
</html>