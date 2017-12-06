<?php
require('includes/application.php');
require('../admin/includes/configure.php');

require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
require_once(DIR_FS_INC . 'xtc_validate_email.inc.php');
require_once(DIR_FS_INC . 'xtc_db_input.inc.php');
require_once(DIR_FS_INC . 'xtc_db_num_rows.inc.php');
require_once(DIR_FS_INC . 'xtc_redirect.inc.php');
require_once(DIR_FS_INC . 'xtc_href_link.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_pull_down_menu.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_input_field.inc.php');
require_once(DIR_FS_INC . 'xtc_get_country_list.inc.php');
require_once(DIR_FS_INC . 'xtc_get_country_name.inc.php');


include('language/' . $lang . '.php');

// connect do database
xtc_db_connect() or die('Unable to connect to database server!');

$messageStack = new messageStack();
$process = false;

if (isset($_POST['action']) && ($_POST['action'] == 'process'))
{
    $process = true;

    $store_name = xtc_db_prepare_input($_POST['STORE_NAME']);
    $email_from = xtc_db_prepare_input($_POST['EMAIL_ADRESS_FROM']);
    $zone_setup = xtc_db_prepare_input($_POST['ZONE_SETUP']);
    $blz_setup = xtc_db_prepare_input($_POST['BLZ_SETUP']);
    $company = xtc_db_prepare_input($_POST['COMPANY']);
    $street_address = xtc_db_prepare_input($_POST['STREET_ADRESS']);
    $postcode = xtc_db_prepare_input($_POST['POST_CODE']);
    $city = xtc_db_prepare_input($_POST['CITY']);
    $country = xtc_db_prepare_input($_POST['COUNTRY']);
    $telephone_number = xtc_db_prepare_input($_POST['TELEPHONE']);

    $error = false;

    if (strlen($store_name) < '3')
    {
        $error = true;
        $messageStack->add('install_shopinfo_step', ENTRY_STORE_NAME_ERROR);
    }

    if (strlen($company) < '2')
    {
        $error = true;
        $messageStack->add('install_shopinfo_step', ENTRY_COMPANY_NAME_ERROR);
    }

    if (strlen($email_from) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH)
    {
        $error = true;
        $messageStack->add('install_shopinfo_step', ENTRY_EMAIL_ADDRESS_FROM_ERROR);
    }
    elseif (xtc_validate_email($email_from) == false)
    {
        $error = true;
        $messageStack->add('install_shopinfo_step', ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH)
    {
        $error = true;
        $messageStack->add('install_shopinfo_step', ENTRY_POST_CODE_ERROR);
    }
    
    if (strlen($street_address) < '3') 
    {
        $error = true;
        $messageStack->add('install_shopinfo_step', ENTRY_STREET_ADDRESS_ERROR);
    }
    
   if (strlen($telephone_number) < '6') 
   {
        $error = true;
        $messageStack->add('install_shopinfo_step', ENTRY_TELEPHONE_NUMBER_ERROR);
    }

    if (($zone_setup != 'yes') && ($zone_setup != 'no'))
    {
        $error = true;
        $messageStack->add('install_shopinfo_step', SELECT_ZONE_SETUP_ERROR);
    }
    
    if (($blz_setup != 'yes') && ($blz_setup != 'no'))
    {
        $error = true;
        $messageStack->add('install_shopinfo_step', SELECT_BLZ_SETUP_ERROR);
    }


    if ($error == false)
    {
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($email_from) . "' WHERE configuration_key = 'STORE_OWNER_EMAIL_ADDRESS'");
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($store_name) . "' WHERE configuration_key = 'STORE_NAME'");
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($email_from) . "' WHERE configuration_key = 'EMAIL_FROM'");
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($country) . "' WHERE configuration_key = 'SHIPPING_ORIGIN_COUNTRY'");
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($postcode) . "' WHERE configuration_key = 'SHIPPING_ORIGIN_ZIP'");
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($company) . "' WHERE configuration_key = 'STORE_OWNER'");
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($email_from) . "' WHERE configuration_key = 'EMAIL_BILLING_FORWARDING_STRING'");
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($email_from) . "' WHERE configuration_key = 'EMAIL_BILLING_ADDRESS'");
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($email_from) . "' WHERE configuration_key = 'CONTACT_US_EMAIL_ADDRESS'");
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($email_from) . "' WHERE configuration_key = 'EMAIL_SUPPORT_ADDRESS'");
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($email_from) . "' WHERE configuration_key = 'EMAIL_SUPPORT_REPLY_ADDRESS'");
        $store_name_address = $store_name.'\n'.$street_address.'\n'.$postcode.' '.$city.'\n'.xtc_get_country_name($country).'\n'.$telephone_number;
        xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . ($store_name_address) . "' WHERE configuration_key = 'STORE_NAME_ADDRESS'");
        


        if ($zone_setup == 'yes')
        {
            // Steuersätze des jeweiligen Landes einstellen!
            $tax_normal = '';
            $tax_normal_text = '';
            $tax_special = '';
            $tax_special_text = '';
            switch ($country)
            {
                case '14':
                    // Austria
                    $tax_normal = '20.0000';
                    $tax_normal_text = 'UST 20%';
                    $tax_special = '10.0000';
                    $tax_special_text = 'UST 10%';
                    break;
                case '21':
                    // Belgien
                    $tax_normal = '21.0000';
                    $tax_normal_text = 'UST 21%';
                    $tax_special = '6.0000';
                    $tax_special_text = 'UST 6%';
                    break;
                case '57':
                    // Dänemark
                    $tax_normal = '25.0000';
                    $tax_normal_text = 'UST 25%';
                    $tax_special = '25.0000';
                    $tax_special_text = 'UST 25%';
                    break;
                case '72':
                    // Finnland
                    $tax_normal = '22.0000';
                    $tax_normal_text = 'UST 22%';
                    $tax_special = '8.0000';
                    $tax_special_text = 'UST 8%';
                    break;
                case '73':
                    // Frankreich
                    $tax_normal = '19.6000';
                    $tax_normal_text = 'UST 19.6%';
                    $tax_special = '2.1000';
                    $tax_special_text = 'UST 2.1%';
                    break;
                case '81':
                    // Deutschland
                    $tax_normal = '19.0000';
                    $tax_normal_text = 'MwSt. 19%';
                    $tax_special = '7.0000';
                    $tax_special_text = 'MwSt. 7%';
                    break;
                case '84':
                    // Griechenland
                    $tax_normal = '18.0000';
                    $tax_normal_text = 'UST 18%';
                    $tax_special = '4.0000';
                    $tax_special_text = 'UST 4%';
                    break;
                case '103':
                    // Irland
                    $tax_normal = '21.0000';
                    $tax_normal_text = 'UST 21%';
                    $tax_special = '4.2000';
                    $tax_special_text = 'UST 4.2%';
                    break;
                case '105':
                    // Italien
                    $tax_normal = '20.0000';
                    $tax_normal_text = 'UST 20%';
                    $tax_special = '4.0000';
                    $tax_special_text = 'UST 4%';
                    break;
                case '124':
                    // Luxemburg
                    $tax_normal = '15.0000';
                    $tax_normal_text = 'UST 15%';
                    $tax_special = '3.0000';
                    $tax_special_text = 'UST 3%';
                    break;
                case '150':
                    // Niederlande
                    $tax_normal = '19.0000';
                    $tax_normal_text = 'UST 19%';
                    $tax_special = '6.0000';
                    $tax_special_text = 'UST 6%';
                    break;
                case '171':
                    // Portugal
                    $tax_normal = '17.0000';
                    $tax_normal_text = 'UST 17%';
                    $tax_special = '5.0000';
                    $tax_special_text = 'UST 5%';
                    break;
                case '195':
                    // Spain
                    $tax_normal = '16.0000';
                    $tax_normal_text = 'UST 16%';
                    $tax_special = '4.0000';
                    $tax_special_text = 'UST 4%';
                    break;
                case '203':
                    // Schweden
                    $tax_normal = '25.0000';
                    $tax_normal_text = 'UST 25%';
                    $tax_special = '6.0000';
                    $tax_special_text = 'UST 6%';
                    break;
                case '204':
                    // Schweiz
                    $tax_normal = '7.6000';
                    $tax_normal_text = 'UST 7,6%';
                    $tax_special = '2.4000';
                    $tax_special_text = 'UST 2,4%';
                    break;
                case '222':
                    // UK
                    $tax_normal = '17.5000';
                    $tax_normal_text = 'UST 17.5%';
                    $tax_special = '5.0000';
                    $tax_special_text = 'UST 5%';
                    break;
            }

            // Steuersätze / tax_rates
            xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (1, 5, 1, 1, '" . $tax_normal . "', '" . $tax_normal_text . "', '', '') ON DUPLICATE KEY UPDATE tax_zone_id = 5, tax_class_id = 1, tax_priority = 1, tax_rate = '" . $tax_normal . "', tax_description = '" . $tax_normal_text . "',  last_modified = '', date_added = '' ");
            xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (2, 5, 2, 1, '" . $tax_special . "', '" . $tax_special_text . "', '', '') ON DUPLICATE KEY UPDATE tax_zone_id = 5, tax_class_id = 2, tax_priority = 1, tax_rate = '" . $tax_speciall . "', tax_description = '" . $tax_special_text . "',  last_modified = '', date_added = ''");
            xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (3, 6, 1, 1, '0.0000', 'EU-AUS-UST 0%', '', '') ON DUPLICATE KEY UPDATE tax_zone_id = 6, tax_class_id = 1, tax_priority = 1, tax_rate = ' 0.0000 ', tax_description = ' EU-AUS-UST 0% ',  last_modified = '', date_added = '' ");
            xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (4, 6, 2, 1, '0.0000', 'EU-AUS-UST 0%', '', '') ON DUPLICATE KEY UPDATE tax_zone_id = 6, tax_class_id = 2, tax_priority = 1, tax_rate = ' 0.0000 ', tax_description = ' EU-AUS-UST 0% ',  last_modified = '', date_added = '' ");

            // Steuerklassen
            xtc_db_query("INSERT INTO tax_class (tax_class_id, tax_class_title, tax_class_description, last_modified, date_added) VALUES (1, 'Standardsatz', '', '', now()) ON DUPLICATE KEY UPDATE tax_class_title = 'Standardsatz', tax_class_description = '',  last_modified = '', date_added = now() ");
            xtc_db_query("INSERT INTO tax_class (tax_class_id, tax_class_title, tax_class_description, last_modified, date_added) VALUES (2, 'erm&auml;&szlig;igter Steuersatz', '', NULL, now()) ON DUPLICATE KEY UPDATE tax_class_title = 'erm&auml;&szlig;igter Steuersatz', tax_class_description = '',  last_modified = NULL, date_added = now() ");

            // Steuersätze
            xtc_db_query("INSERT INTO geo_zones (geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added) VALUES (6, 'Steuerzone EU-Ausland', '', '', now()) ON DUPLICATE KEY UPDATE geo_zone_name = 'Steuerzone EU-Ausland', geo_zone_description = '',  last_modified = '', date_added = now() ");
            xtc_db_query("INSERT INTO geo_zones (geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added) VALUES (5, 'Steuerzone EU', 'Steuerzone f&uuml;r die EU', '', now()) ON DUPLICATE KEY UPDATE geo_zone_name = 'Steuerzone f&uuml;r die EU', geo_zone_description = '',  last_modified = '', date_added = now() ");
            xtc_db_query("INSERT INTO geo_zones (geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added) VALUES (7, 'Steuerzone B2B', '', NULL, now()) ON DUPLICATE KEY UPDATE geo_zone_name = 'Steuerzone B2B', geo_zone_description = '',  last_modified = NULL, date_added = now() ");

            // EU-Steuerzonen Stand 01.01.2007
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (14, 14, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 14, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (21, 21, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 21, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            //BOF - Dokuman 2009-08-20 - Added Bulgaria to EU Zones (since 01.01.2007)
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (33, 33, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 33, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            //EOF - Dokuman 2009-08-20 - Added Bulgaria to EU Zones (since 01.01.2007)
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (55, 55, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 55, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (56, 56, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 56, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (57, 57, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 57, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (67, 67, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 67, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (72, 72, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 72, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (73, 73, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 73, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (81, 81, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 81, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (84, 84, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 84, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (97, 97, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 97, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (103, 103, 0, 5, NULL,now()) ON DUPLICATE KEY UPDATE zone_country_id = 103, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (105, 105, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 105, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (117, 117, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 117, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (123, 123, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 123, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (124, 124, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 124, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (132, 132, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 132, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (150, 150, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 150, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (170, 170, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 170, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (171, 171, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 171, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            //BOF - Dokuman 2009-08-20 - Added Romania to EU Zones (since 01.01.2007)
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (175, 175, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 175, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            //EOF - Dokuman 2009-08-20 - Added Romania to EU Zones (since 01.01.2007)
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (189, 189, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 189, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (190, 190, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 190, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (195, 195, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 195, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (203, 203, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 203, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (222, 222, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 222, zone_id = 0, geo_zone_id = 5, last_modified = NULL, date_added = now() ");

            // Rest der Welt
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (1, 1, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 1, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (2, 2, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 2, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (3, 3, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 3, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (4, 4, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 4, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (5, 5, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 5, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (6, 6, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 6, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (7, 7, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 7, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (8, 8, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 8, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (9, 9, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 9, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (10, 10, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 10, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (11, 11, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 11, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (12, 12, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 12, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (13, 13, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 13, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (15, 15, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 15, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (16, 16, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 16, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (17, 17, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 17, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (18, 18, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 18, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (19, 19, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 19, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (20, 20, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 20, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (22, 22, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 22, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (23, 23, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 23, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (24, 24, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 24, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (25, 25, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 25, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (26, 26, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 26, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (27, 27, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 27, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (28, 28, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 28, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (29, 29, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 29, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (30, 30, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 30, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (31, 31, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 31, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (32, 32, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 32, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (34, 34, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 34, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (35, 35, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 35, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (36, 36, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 36, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (37, 37, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 37, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (38, 38, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 38, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (39, 39, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 39, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (40, 40, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 40, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (41, 41, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 41, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (42, 42, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 42, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (43, 43, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 43, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (44, 44, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 44, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (45, 45, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 45, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (46, 46, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 46, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (47, 47, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 47, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (48, 48, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 48, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (49, 49, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 49, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (50, 50, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 50, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (51, 51, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 51, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (52, 52, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 52, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (53, 53, 0, 5, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 53, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (54, 54, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 54, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (58, 58, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 58, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (59, 59, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 59, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (60, 60, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 60, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (61, 61, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 61, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (62, 62, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 62, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (63, 63, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 63, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (64, 64, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 64, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (65, 65, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 65, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (66, 66, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 66, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (68, 68, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 68, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (69, 69, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 69, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (70, 70, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 70, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (71, 71, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 71, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (74, 74, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 74, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (75, 75, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 75, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (76, 76, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 76, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (77, 77, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 77, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (78, 78, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 78, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (79, 79, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 79, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (80, 80, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 80, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (82, 82, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 82, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (83, 83, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 83, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (85, 85, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 85, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (86, 86, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 86, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (87, 87, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 87, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (88, 88, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 88, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (89, 89, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 89, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (90, 90, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 90, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (91, 91, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 91, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (92, 92, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 92, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (93, 93, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 93, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (94, 94, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 94, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (95, 95, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 95, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (96, 96, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 96, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (98, 98, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 98, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (99, 99, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 99, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (100, 100, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 100, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (101, 101, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 101, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (102, 102, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 102, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (104, 104, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 104, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (106, 106, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 106, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (107, 107, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 107, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (108, 108, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 108, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (109, 109, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 109, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (110, 110, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 110, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (111, 111, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 111, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (112, 112, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 112, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (113, 113, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 113, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (114, 114, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 114, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (115, 115, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 115, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (116, 116, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 116, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (118, 118, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 118, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (119, 119, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 119, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (120, 120, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 120, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (121, 121, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 121, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (122, 122, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 122, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (125, 125, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 125, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (126, 126, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 126, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (127, 127, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 127, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (128, 128, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 128, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (129, 129, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 129, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (130, 130, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 130, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (131, 131, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 131, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (133, 133, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 133, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (134, 134, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 134, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (135, 135, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 135, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (136, 136, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 136, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (137, 137, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 137, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (138, 138, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 138, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (139, 139, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 139, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (140, 140, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 140, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (141, 141, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 141, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (142, 142, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 142, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (143, 143, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 143, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (144, 144, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 144, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (145, 145, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 145, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (146, 146, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 146, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (147, 147, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 147, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (148, 148, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 148, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (149, 149, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 149, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (151, 151, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 151, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (152, 152, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 152, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (153, 153, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 153, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (154, 154, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 154, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (155, 155, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 155, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (156, 156, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 156, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (157, 157, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 157, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (158, 158, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 158, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (159, 159, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 159, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (160, 160, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 160, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (161, 161, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 161, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (162, 162, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 162, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (163, 163, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 163, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (164, 164, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 164, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (165, 165, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 165, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (166, 166, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 166, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (167, 167, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 167, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (168, 168, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 168, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (169, 169, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 169, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (172, 172, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 172, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (173, 173, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 173, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (174, 174, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 174, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (176, 176, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 176, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (177, 177, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 177, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (178, 178, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 178, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (179, 179, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 179, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (180, 180, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 180, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (181, 181, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 181, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (182, 182, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 182, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (183, 183, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 183, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (184, 184, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 184, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (185, 185, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 185, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (186, 186, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 186, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (187, 187, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 187, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (188, 188, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 188, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (191, 191, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 191, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (192, 192, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 192, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (193, 193, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 193, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (194, 194, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 194, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (196, 196, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 196, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (197, 197, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 197, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (198, 198, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 198, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (199, 199, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 199, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (200, 200, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 200, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (201, 201, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 201, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (202, 202, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 202, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (204, 204, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 204, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (205, 205, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 205, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (206, 206, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 206, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (207, 207, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 207, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (208, 208, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 208, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (209, 209, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 209, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (210, 210, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 210, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (211, 211, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 211, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (212, 212, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 212, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (213, 213, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 213, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (214, 214, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 214, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (215, 215, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 215, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (216, 216, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 216, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (217, 217, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 217, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (218, 218, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 218, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (219, 219, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 219, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (220, 220, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 220, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (221, 221, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 221, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (223, 223, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 223, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (224, 224, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 224, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (225, 225, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 225, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (226, 226, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 226, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (227, 227, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 227, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (228, 228, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 228, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (229, 229, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 229, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (230, 230, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 230, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (231, 231, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 231, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (232, 232, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 232, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (233, 233, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 233, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (234, 234, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 234, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (235, 235, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 235, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (236, 236, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 236, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (237, 237, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 237, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (238, 238, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 238, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
            xtc_db_query("INSERT INTO zones_to_geo_zones VALUES (239, 239, 0, 6, NULL, now()) ON DUPLICATE KEY UPDATE zone_country_id = 239, zone_id = 0, geo_zone_id = 6, last_modified = NULL, date_added = now() ");
        }
        
        if ($blz_setup == 'yes') {
            $lines = array();
            $banktransfer = array();
            $blz = array();
            
            $handle = @fopen("http://www.bundesbank.de/Redaktion/DE/Downloads/Aufgaben/Unbarer_Zahlungsverkehr/Bankleitzahlen/2017_06_04/blz_2017_03_06_txt.txt?__blob=publicationFile", "r");
            if ($handle) {
                while (!feof($handle)) {
                    $line = stream_get_line($handle, 65535, "\n");
                    $lines[]= $line;
                }
                fclose($handle);
                foreach ($lines as $line) {
                    // to avoid dublettes, the unique flag
                    // "bankleitzahlführender Zahlungsdienstleister" will be queried
                    if (substr($line, 8, 1) == '1') {                //leading payment provider for bank code number (only one per bank code)
                        $blz['blz'] = substr($line, 0, 8);             //bank code number(8)
                        $blz['bankname'] = trim(substr($line, 9, 58)); //bank name(58)
                        $blz['prz'] = substr($line, 150, 2);           //checksum(2)
                        $blz['aenderungskennzeichen'] = substr($line, 158, 1); //change code(1)

                        /*
                        // check the change code of the bank code number
                        // "A" = Addition
                        // "D" = Deletion (do not import bank code numbers with this flag)
                        // "M" = Modified
                        // "U" = Unchanged
                        */
                        if ($blz['aenderungskennzeichen']!= 'D' && ($blz['aenderungskennzeichen']== 'A' || $blz['aenderungskennzeichen'] == 'U' || $blz['aenderungskennzeichen'] == 'M')) {
                          // Add the bank code number to the import array
                          $banktransfer[] = $blz;
                        }
                    }
                }
            
                if (count($banktransfer) > 1) {
                    // clear table banktransfer_blz
                    xtc_db_query("delete from ".TABLE_BANKTRANSFER_BLZ);
                    // and fill it with the the content from the downloaded file
                    foreach ($banktransfer as $rec) {
                        $sql = sprintf('insert into banktransfer_blz (blz, bankname, prz) values (%s, \'%s\', \'%s\')',(int)$rec['blz'], xtc_db_input(utf8_encode($rec['bankname'])), xtc_db_input($rec['prz']));
                        xtc_db_query($sql);
                    }
                }
            }   
        }

        xtc_redirect(xtc_href_link('install_admin_step.php', '', 'NONSSL'));
    }
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
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 62%; min-width: 2%;">
                            62% <?php echo TEXT_COMPLETE ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center welcome">
                    <?php echo TITLE_SHOP_CONFIG; ?>
                </div>
            </div>
            <?php
            if ($messageStack->size('install_shopinfo_step') > 0)
            {
                ?>
                <div class="row">
                    <div class="col-xs-12 danger"><?php echo $messageStack->output('install_shopinfo_step'); ?></div>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <form name="install" action="install_shopinfo_step.php" method="post">
                    <div class="well">
                        <?php echo xtc_draw_hidden_field_installer('action', 'process'); ?>
                        <p>
                            <b><?php echo TEXT_STORE; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('STORE_NAME', '', 'text', 'style="width: 30%;" '); ?>* <?php echo TEXT_STORE_LONG; ?><br />
                            <b><?php echo TEXT_COMPANY; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('COMPANY', '', 'text', 'style="width: 30%;" '); ?>* <br />
                            <b><?php echo TEXT_EMAIL_FROM; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('EMAIL_ADRESS_FROM', '', 'text', 'style="width: 30%;" '); ?>* <?php echo TEXT_EMAIL_FROM_LONG; ?><br />
                            <b><?php echo TEXT_STREET; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('STREET_ADRESS', '', 'text', 'style="width: 30%;" '); ?>* <br />
                            <b><?php echo TEXT_POSTCODE; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('POST_CODE', '', 'text', 'style="width: 30%;" '); ?>* <br />
                            <b><?php echo TEXT_CITY; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('CITY', '', 'text', 'style="width: 30%;" '); ?>* <br />
                            <b><?php echo TEXT_COUNTRY; ?></b><br />
                            <?php echo xtc_get_country_list('COUNTRY', 81); ?>* <?php echo TEXT_COUNTRY_LONG; ?><br />
                            <b><?php echo TEXT_TEL; ?></b><br />
                            <?php echo xtc_draw_input_field_installer('TELEPHONE', '', 'text', 'style="width: 30%;" '); ?>* <br />
                        </p>
                    </div>
                    <div class="well">
                        <p>
                            <b><?php echo TEXT_ZONE; ?></b><br />
                            <?php echo  TEXT_ZONE_YES; ?>
                            <?php echo xtc_draw_radio_field_installer('ZONE_SETUP', 'yes', 'true'); ?>
                            <?php echo  TEXT_ZONE_NO; ?>
                            <?php echo xtc_draw_radio_field_installer('ZONE_SETUP', 'no'); ?>
                          </p>
                    </div>
                    <div class="well">
                        <p>
                            <b><?php echo TEXT_BLZ; ?></b><br />
                            <?php echo  TEXT_BLZ_YES; ?>
                            <?php echo xtc_draw_radio_field_installer('BLZ_SETUP', 'yes', 'true'); ?>
                            <?php echo  TEXT_BLZ_NO; ?>
                            <?php echo xtc_draw_radio_field_installer('BLZ_SETUP', 'no'); ?>
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