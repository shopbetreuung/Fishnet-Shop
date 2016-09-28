<?php
/* --------------------------------------------------------------
  $Id: index.php 3426 2012-08-13 15:39:17Z web28 $

  modified eCommerce Shopsoftware
  http://www.modified-shop.org

  Copyright (c) 2009 - 2013 [www.modified-shop.org]
  ----------------------------------------------------------------
  based on:
  (c) 2003 nextcommerce (index.php,v 1.18 2003/08/17); www.nextcommerce.org
  (c) 2006 xt:Commerce (index.php 1220 2005-09-16); www.xtcommerce.com

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

//BOF - web28 - 2010.02.11 - NEW LANGUAGE HANDLING IN application.php
//include('language/english.php');
include('language/' . $lang . '.php');
//BOF - web28 - 2010.02.11 - NEW LANGUAGE HANDLING IN application.php
define('HTTP_SERVER', '');
define('HTTPS_SERVER', '');
define('DIR_WS_CATALOG', '');
define('DIR_WS_BASE', ''); //web28 - 2010-12-13 - FIX for $messageStack icons

if (isset($_SESSION['db'])) {
    unset($_SESSION['db']);
}

if (isset($_SESSION['configure'])) {
    unset($_SESSION['configure']);
}

$messageStack = new messageStack();
$process = false;

if (isset($_POST['LANGUAGE']))
{
    $process = true;
    $_SESSION['language'] = xtc_db_prepare_input($_POST['LANGUAGE']);
    $error = false;
    if (($_SESSION['language'] != 'german') && ($_SESSION['language'] != 'english'))
    {
        $error = true;
        $messageStack->add('index', SELECT_LANGUAGE_ERROR);
    }
    if ($error == false)
    {
        xtc_redirect(xtc_href_link('install_requirements_step.php?lg=' . xtc_db_prepare_input($_POST['LANGUAGE']), '', 'NONSSL'));
    }
}
else
{
    $error = true;
    $messageStack->add('index', SELECT_LANGUAGE_ERROR);
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
                    <a href="http://www.shophelfer.com/" target="_blank"><img src="images/logo.png" alt="shophelfer.com" /></a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 nopad">
                    <p class="blue text-center"><?php echo TITLE_INSTALLATION_PROCESS; ?></p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%; min-width: 2%;">
                            0% <?php echo TEXT_COMPLETE ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center welcome">
                    <?php echo TEXT_WELCOME; ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 well">
                    <p><?php echo TEXT_WELCOME_INDEX; ?></p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <form name="language" action="index.php" method="post">
                    <div class="col-xs-12">
                        <strong><?php echo TITLE_SELECT_LANGUAGE; ?></strong> <br />
                        <?php //xtc_draw_form('language', 'index.php');  ?>                    
                        <?php echo xtc_draw_radio_field_installer('LANGUAGE', 'german', true); ?>
                        <img src="images/icons/icon-deu.gif" alt="gerflag" /><br />
                        <?php echo xtc_draw_radio_field_installer('LANGUAGE', 'english'); ?>
                        <img src="images/icons/icon-eng.gif" alt="engflag" />                    
                    </div>                
                    <div class="col-xs-2 pull-right text-right">
                        <input type="submit" class="btn btn-primary" value="<?php echo TEXT_CONTINUE_BUTTON; ?>" />                    
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
