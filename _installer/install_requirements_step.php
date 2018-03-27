<?php
/* --------------------------------------------------------------
  $Id: install_step1.php 3072 2012-06-18 15:01:13Z hhacker $

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

include ('includes/check_requirements.php');

if (!$req_show)
{
    xtc_redirect(xtc_href_link('install_database_step.php', '', 'NONSSL'));
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
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 12%; min-width: 2%;">
                            12% <?php echo TEXT_COMPLETE ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center welcome">
                    <?php echo TEXT_WELCOME_REQUIREMENTS_STEP; ?>
                </div>
            </div>
        </div>
        <?php
            ?>
            <?php
            if ($ok_message != '')
            {
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12" style="border: 1px solid; border-color: #4CC534; padding:10px;background-color: #C2FFB6;">
                            <strong><?php echo TEXT_CHECKING; ?>:</strong><br />
                            <?php echo $ok_message; ?>
                        </div>
                        <div class="col-xs-2 pull-right text-right nopad">
                            <br />
                            <a class="btn btn-primary" href="install_requirements_step.php" /><?php echo TEXT_RECHECK_REQUIREMENTS; ?></a>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?> 
    </body>
</html>