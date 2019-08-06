<?php
require('includes/application.php');
require('../includes/configure.php');

require_once(DIR_FS_INC . 'xtc_encrypt_password.inc.php');
require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
require_once(DIR_FS_INC . 'xtc_validate_email.inc.php');
require_once(DIR_FS_INC . 'xtc_db_input.inc.php');
require_once(DIR_FS_INC . 'xtc_db_num_rows.inc.php');
require_once(DIR_FS_INC . 'xtc_redirect.inc.php');
require_once(DIR_FS_INC . 'xtc_href_link.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_pull_down_menu.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_input_field.inc.php');
require_once(DIR_FS_INC . 'xtc_get_country_list.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_hidden_field_installer.inc.php');
require_once(DIR_FS_INC . 'xtc_db_insert_id.inc.php');

include('language/' . $lang . '.php');

// connect to database
xtc_db_connect() or die('Unable to connect to database server!');

// get configuration data
$configuration_query = xtc_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
while ($configuration = xtc_db_fetch_array($configuration_query))
{
    define($configuration['cfgKey'], $configuration['cfgValue']);
}

$messageStack = new messageStack();
$process = false;

if (isset($_POST['action']) && ($_POST['action'] == 'process'))
{
    $process = true;

    $gender = xtc_db_prepare_input($_POST['GENDER']);
    $firstname = xtc_db_prepare_input($_POST['FIRST_NAME']);
    $lastname = xtc_db_prepare_input($_POST['LAST_NAME']);
    $email_address = xtc_db_prepare_input($_POST['EMAIL_ADRESS']);
    $street_address = xtc_db_prepare_input($_POST['STREET_ADRESS']);
    $postcode = xtc_db_prepare_input($_POST['POST_CODE']);
    $city = xtc_db_prepare_input($_POST['CITY']);
    $zone_id = xtc_db_prepare_input($_POST['zone_id']);
    $state = xtc_db_prepare_input($_POST['STATE']);
    $country = xtc_db_prepare_input($_POST['COUNTRY']);
    $telephone = xtc_db_prepare_input($_POST['TELEPHONE']);
    $password = xtc_db_prepare_input($_POST['PASSWORD']);
    $confirmation = xtc_db_prepare_input($_POST['PASSWORD_CONFIRMATION']);

    $error = false;
    
    if (!isset($gender)) {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_GENDER_ERROR);
    }

    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH)
    {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH)
    {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_LAST_NAME_ERROR);
    }

    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH)
    {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_EMAIL_ADDRESS_ERROR);
    }
    elseif (xtc_validate_email($email_address) == false)
    {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    }

    if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH)
    {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH)
    {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_POST_CODE_ERROR);
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH)
    {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_CITY_ERROR);
    }

    if (is_numeric($country) == false)
    {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_COUNTRY_ERROR);
    }

    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH)
    {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_TELEPHONE_NUMBER_ERROR);
    }

    if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH)
    {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_PASSWORD_ERROR);
    }
    elseif ($password != $confirmation)
    {
        $error = true;
        $messageStack->add('install_admin_step', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
    }

    if ($error == false)
    {

        $first_admin_check_query = xtc_db_query("SELECT customers_id FROM " . TABLE_CUSTOMERS . " WHERE customers_id = 1 ");
        if (xtc_db_num_rows($first_admin_check_query) > 0)
        {
            xtc_db_query("insert into " . TABLE_CUSTOMERS . " (
                                customers_status,
                                customers_firstname,
                                customers_lastname,
                                customers_gender,
                                customers_email_address,
                                customers_telephone,
                                customers_password,
                                delete_user) VALUES
                                ('0',
                                '" . xtc_db_input($firstname) . "',
                                '" . xtc_db_input($lastname) . "',
                                '" . xtc_db_input($gender) . "',
                                '" . xtc_db_input($email_address) . "',
                                '" . xtc_db_input($telephone) . "',
                                '" . xtc_encrypt_password($password) . "',
                                '0')");
            $admin_id = xtc_db_insert_id();

            xtc_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (
                                customers_info_id,
                                customers_info_date_of_last_logon,
                                customers_info_number_of_logons,
                                customers_info_date_account_created,
                                customers_info_date_account_last_modified,
                                global_product_notifications) VALUES
                                ('" . $admin_id . "','','','now()','','')");

            xtc_db_query("insert into " . TABLE_ADDRESS_BOOK . " (
                                customers_id,
                                entry_gender,
                                entry_company,
                                entry_firstname,
                                entry_lastname,
                                entry_street_address,
                                entry_postcode,
                                entry_city,
                                entry_state,
                                entry_country_id,
                                entry_zone_id) VALUES
                                ('" . $admin_id . "',
                                '" . xtc_db_input($gender) . "',
                                '" . xtc_db_input($company) . "',
                                '" . xtc_db_input($firstname) . "',
                                '" . xtc_db_input($lastname) . "',
                                '" . xtc_db_input($street_address) . "',
                                '" . xtc_db_input($postcode) . "',
                                '" . xtc_db_input($city) . "',
                                '" . xtc_db_input($state) . "',
                                '" . xtc_db_input($country) . "',
                                '" . xtc_db_input($zone_id) . "'
                                )");
            
           // admin address connection
            $address_book_id = xtc_db_insert_id();
            xtc_db_query("UPDATE customers SET customers_default_address_id = '" . $address_book_id . "' WHERE customers_id = '" . $admin_id . "' ");
            

            // customers_status
            xtc_db_query("INSERT INTO " . TABLE_ADMIN_ACCESS . " (`customers_id`) VALUES ('" . $admin_id . "');");
            $aa_spalten_qry = xtc_db_query("SHOW COLUMNS FROM admin_access");
            while ($aa_spalten = xtc_db_fetch_array($aa_spalten_qry))
            {
                if ($aa_spalten['Type'] == 'int(1)')
                {
                    xtc_db_query("UPDATE admin_access SET " . $aa_spalten['Field'] . " = '1' WHERE customers_id = '" . $admin_id . "'");
                }
            }
            xtc_redirect(xtc_href_link('install_additional_admins.php', '', 'NONSSL'));
        }
        else
        {

            xtc_db_query("insert into " . TABLE_CUSTOMERS . " (
                                customers_id,
                                customers_status,
                                customers_firstname,
                                customers_lastname,
                                customers_gender,
                                customers_email_address,
                                customers_default_address_id,
                                customers_telephone,
                                customers_password,
                                delete_user) VALUES
                                ('1',
                                '0',
                                '" . xtc_db_input($firstname) . "',
                                '" . xtc_db_input($lastname) . "',
                                '" . xtc_db_input($gender) . "',
                                '" . xtc_db_input($email_address) . "',
                                '1',
                                '" . xtc_db_input($telephone) . "',
                                '" . xtc_encrypt_password($password) . "',
                                '0')");

            xtc_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (
                                customers_info_id,
                                customers_info_date_of_last_logon,
                                customers_info_number_of_logons,
                                customers_info_date_account_created,
                                customers_info_date_account_last_modified,
                                global_product_notifications) VALUES
                                ('1','','','now()','','')");
            xtc_db_query("insert into " . TABLE_ADDRESS_BOOK . " (
                                customers_id,
                                entry_gender,
                                entry_company,
                                entry_firstname,
                                entry_lastname,
                                entry_street_address,
                                entry_postcode,
                                entry_city,
                                entry_state,
                                entry_country_id,
                                entry_zone_id) VALUES
                                ('1',
                                '" . xtc_db_input($gender) . "',
                                '" . xtc_db_input($company) . "',
                                '" . xtc_db_input($firstname) . "',
                                '" . xtc_db_input($lastname) . "',
                                '" . xtc_db_input($street_address) . "',
                                '" . xtc_db_input($postcode) . "',
                                '" . xtc_db_input($city) . "',
                                '" . xtc_db_input($state) . "',
                                '" . xtc_db_input($country) . "',
                                '" . xtc_db_input($zone_id) . "'
                                )");

            // customers_status
            xtc_db_query("INSERT INTO " . TABLE_ADMIN_ACCESS . " (`customers_id`) VALUES ('1');");
            xtc_db_query("INSERT INTO " . TABLE_ADMIN_ACCESS . " (`customers_id`) VALUES ('groups');");
            $aa_spalten_qry = xtc_db_query("SHOW COLUMNS FROM admin_access");
            while ($aa_spalten = xtc_db_fetch_array($aa_spalten_qry))
            {
                if ($aa_spalten['Type'] == 'int(1)')
                {
                    xtc_db_query("UPDATE admin_access SET " . $aa_spalten['Field'] . " = '1' WHERE customers_id = '1'");
                    xtc_db_query("UPDATE admin_access SET " . $aa_spalten['Field'] . " = '2' WHERE customers_id = 'groups'");
                }
            }
            // groups
            $groups1_array = ['configuration', 'modules', 'countries', 'currencies', 'zones', 'geo_zones', 'tax_classes', 'tax_rates', 'cache', 'languages', 'define_language', 'orders_status', 'shipping_status', 'module_export', 'campaigns', 'coupon_admin', 'popup_image', 'products_vpe', 'cross_sell_groups', 'shop_offline', 'xajax', 'pdfbill_config', 'pdfbill_display', 'email_manager', 'email_preview'];
            $groups2_array = ['accounting', 'customers', 'create_account', 'customers_status', 'customers_group', 'orders', 'print_packingslip', 'print_order', 'popup_memo', 'mail', 'reviews', 'orders_edit', 'econda', 'sofortueberweisung_install', 'janolaw', 'haendlerbund', 'safeterms', 'it_recht_kanzlei', 'payone_config', 'payone_logs', 'wholesalers', 'wholesalers_list', 'parcel_carriers'];
            $groups3_array = ['listproducts', 'listcategories', 'validproducts', 'validcategories', 'categories', 'new_attributes', 'products_attributes', 'manufacturers', 'specials', 'products_expected', 'products_content', 'globaledit'];
            $groups4_array = ['gv_queue', 'gv_mail', 'gv_sent', 'stats_products_expected', 'stats_products_viewed', 'stats_products_purchased', 'stats_customers', 'stats_sales_report', 'stats_campaigns', 'stats_stock_warning', 'inventory', 'inventory_turnover', 'outstanding', 'invoiced_orders'];
            $groups5_array = ['backup', 'server_info', 'whos_online', 'banner_manager', 'banner_statistics', 'module_newsletter', 'content_manager', 'content_preview', 'blacklist', 'csv_backend', 'blz_update', 'removeoldpics', 'imagesliders', 'waste_paper_bin', 'stock_range', 'dsgvo_export', 'blacklist_logs', 'whitelist_logs', 'seo_tool_box', 'quick_stockupdate', 'index_images'];
            $groups6_array = ['start', 'credits'];

            
            foreach ($groups1_array as $group1) {
                xtc_db_query("UPDATE admin_access SET " . $group1 . " = '1' WHERE customers_id = 'groups'");    
            }
            
            foreach ($groups2_array as $group2) {
                xtc_db_query("UPDATE admin_access SET " . $group1 . " = '2' WHERE customers_id = 'groups'");    
            }
            
            foreach ($groups3_array as $group3) {
                xtc_db_query("UPDATE admin_access SET " . $group3 . " = '3' WHERE customers_id = 'groups'");    
            }
            
            foreach ($groups4_array as $group4) {
                xtc_db_query("UPDATE admin_access SET " . $group4 . " = '4' WHERE customers_id = 'groups'");    
            }
            
            foreach ($groups5_array as $group5) {
                xtc_db_query("UPDATE admin_access SET " . $group5 . " = '5' WHERE customers_id = 'groups'");    
            }
            
            foreach ($groups6_array as $group6) {
                xtc_db_query("UPDATE admin_access SET " . $group6 . " = '6' WHERE customers_id = 'groups'");    
            }
            
            xtc_redirect(xtc_href_link('install_additional_admins.php', '', 'NONSSL'));
        }
    }
}
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
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 75%; min-width: 2%;">
                            75% <?php echo TEXT_COMPLETE ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center welcome">
                    <?php echo TEXT_WELCOME_ADMIN; ?>
                </div>
            </div>
            <?php
            if ($messageStack->size('install_admin_step') > 0)
            {
                ?>
                <div class="row">
                    <div class="col-xs-12 danger"><?php echo $messageStack->output('install_admin_step'); ?></div>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <form name="install" action="install_admin_step.php" method="post">
                    <h2><?php echo TITLE_ADMIN_CONFIG; ?></h2>
                    <div class="well"><h5><?php echo TEXT_REQU_INFORMATION; ?></h5>
                        <?php echo xtc_draw_hidden_field_installer('action', 'process'); ?>
                        <p>
                            <b><?php echo TEXT_GENDER; ?></b><br />
                            <?php echo TEXT_MALE; echo xtc_draw_radio_field_installer('GENDER', 'm', true); ?> <?php echo TEXT_FEMALE; echo xtc_draw_radio_field_installer('GENDER', 'f', false); ?> * <br />
                            <b><?php echo TEXT_FIRSTNAME; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('FIRST_NAME', '', 'text', 'style="width: 30%;" '); ?>* <br />
                            <b><?php echo TEXT_LASTNAME; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('LAST_NAME', '', 'text', 'style="width: 30%;" '); ?>* <br />
                            <b><?php echo TEXT_EMAIL; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('EMAIL_ADRESS', '', 'text', 'style="width: 30%;" '); ?>* <?php echo TEXT_EMAIL_LONG; ?><br />
                            <b><?php echo TEXT_STREET; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('STREET_ADRESS', '', 'text', 'style="width: 30%;" '); ?>* <br />
                            <b><?php echo TEXT_POSTCODE; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('POST_CODE', '', 'text', 'style="width: 30%;" '); ?>* <br />
                            <b><?php echo TEXT_CITY; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('CITY', '', 'text', 'style="width: 30%;" '); ?>* <br />
                            <b><?php echo TEXT_COUNTRY; ?></b><br />
                            <?php echo xtc_get_country_list('COUNTRY', 81, 'style="width:30%"'); ?>* <?php echo TEXT_COUNTRY_LONG; ?><br />
                            <b><?php echo TEXT_TEL; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('TELEPHONE', '', 'text', 'style="width: 30%;" '); ?>* <br />
                            <b><?php echo TEXT_PASSWORD; ?></b><br />
                            <span class="dbpw"><?php echo xtc_draw_password_field_installer('PASSWORD'); ?></span>* <br />
                            <b><?php echo TEXT_PASSWORD_CONF; ?></b><br />
                            <span class="dbpw"><?php echo xtc_draw_password_field_installer('PASSWORD_CONFIRMATION'); ?></span>* <br />
                        </p>
                    </div>
                    <div class="col-xs-2 pull-right nopad">
                        <div class="pull-right">
                            <a class="btn btn-default" href="index.php"><?php echo TEXT_CANCEL_BUTTON; ?></a>
                            <input type="submit" class="btn btn-primary" value="<?php echo TEXT_CONTINUE_BUTTON; ?>" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>