<?php
require('includes/application.php');

require_once(DIR_FS_INC . 'xtc_href_link.inc.php');

include('language/' . $lang . '.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 87%; min-width: 2%;">
                            87% <?php echo TEXT_COMPLETE ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center welcome">
                    <?php echo TEXT_WELCOME_ADD_ADMIN; ?>
                </div>
            </div>
            <div class="row">
                <div class="well"><?php echo TEXT_ADD_ADDITIONAL_ADMINS; ?></div>
            </div>
            <div class="row">
                <div class="col-xs-2 pull-right nopad">
                    <div class="pull-right">
                        <a class="btn btn-default" href="install_congratulations_step.php"><?php echo TEXT_NO; ?></a>
                        <a class="btn btn-primary" href="install_admin_step.php"><?php echo TEXT_YES; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>