<?php
  /* --------------------------------------------------------------
   $Id: english.php 3072 2012-06-18 15:01:13Z hhacker $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   --------------------------------------------------------------
   based on:
   (c) 2003 nextcommerce (install_step7.php,v 1.26 2003/08/17); www.nextcommerce.org
   (c) 2006 XT-Commerce www.xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/
  // Box names
  define('BOX_LANGUAGE','Language');
  define('BOX_DB_CONNECTION','DB Connection') ;
  define('BOX_WEBSERVER_SETTINGS','Webserver Settings');
  define('BOX_DB_IMPORT','DB Import');
  define('BOX_WRITE_CONFIG','Write config files');
  define('BOX_ADMIN_CONFIG','Administrator config');
  define('BOX_USERS_CONFIG','User config');
  define('PULL_DOWN_DEFAULT','Please select a Country!');

  // Error messages
  // index.php
  define('SELECT_LANGUAGE_ERROR','Please select a language!');
  // install_step2,5.php
  define('TEXT_CONNECTION_ERROR','The test connect to the database was NOT successful.');
  define('TEXT_CONNECTION_SUCCESS','The test connect to the database was successful.');
  define('TEXT_DB_DATA_NOT_CORRECT', 'The connection to the database was not successful, please check your data');
  define('TEXT_DB_DATA_NOT_ENTERED_ERROR', 'Please enter all database data');
  define('TEXT_DB_ERROR','The error message returned is:');
  define('TEXT_DB_ERROR_1','Please click on the <i>Back</i> graphic to review your database server settings.');
  define('TEXT_DB_ERROR_2','If you require help with your database server settings, please consult your hosting company.');
  // BOF - web28 - 2010.12.13 - NEW db-upgrade
  define('TEXT_DB_UPGRADE','<strong>Only perform database upgrade on already installed shophelfer.com Shopsoftware</strong>!');
  // BOF - web28 - 2010.12.13 - NEW db-upgrade
  // BOF - vr - 2010-01-14 - check MySQL *server* version
  define('TEXT_DB_SERVER_VERSION_ERROR','Your MySQL version is too old. The shop requires at least version: ');
  define('TEXT_DB_SERVER_VERSION','Your MySQL version: ');
  // EOF - vr - 2010-01-14 - check MySQL *server* version
  // BOF - vr - 2010-01-14 - check MySQL *client* version
  define('TEXT_DB_CLIENT_VERSION_WARNING','Your MySQL version is too old. The shop requires at least version: 4.1.2 </br></br>You can continue the installation.</br>If the installation can not be correctly carried out, ask your provider for an update!');
  define('TEXT_DB_CLIENT_VERSION','Your MySQL version: ');
  // EOF - vr - 2010-01-14 - check MySQL *client* version
  define('TEXT_DB_DATA_NOT_ENTERED_ERROR', 'Please enter all database data');
  // BOF - web28 - 2010-02-1014 - check FILE PATH
  define('TEXT_PATH_ERROR','<h1>Invalid path</h1>');
  define('TEXT_PATH_ERROR2','Regard! You have entered an invalid file path!');
  define('TEXT_PATH_ERROR3','Please check your settings!');
  // EOF - web28 - 2010-02-1014 - check FILE PATH
  // BOF - DokuMan - 2010-08-16 - language dependent definitions for index.php
  define('TEXT_WRONG_FILE_PERMISSION','WRONG FILE PERMISSIONS ');
  define('TEXT_WRONG_FOLDER_PERMISSION','WRONG FOLDER PERMISSIONS ');
  define('TEXT_FILE_PERMISSION_STATUS','FILE PERMISSIONS ');
  define('TEXT_FOLDER_PERMISSION_STATUS','FOLDER PERMISSIONS ');
  define('TEXT_ERROR','ERROR');
  define('TEXT_WARNING','WARNING');
  define('TEXT_PHPVERSION_TOO_OLD','ATTENTION! Your PHP version is too old. The shop requires at least version %s!<br /><br />Your PHP version: ');
  define('TEXT_ERROR_PHP_MAX','ACHTUNG! Your PHP version is not supported. The shop only works up to version %s.<br /><br />Your PHP version: ');
  // BOF - h-h-h - 2011-04-14 - check fsockopen
  define('TEXT_FSOCKOPEN_NOT_SUPPORTED','FSOCKOPEN IS NOT SUPPORTED. Some third-pary modules require fsockopen. They will not work without fsockopen support!');
  // EOF - h-h-h - 2011-04-14 - check fsockopen
  // BOF - DokuMan - 2012-06-11 - check cURL
  define('TEXT_CURL_NOT_SUPPORTED','CURL IS NOT SUPPORTED. Some third-pary modules require cURL. They will not work without cURL support!');
  // EOF - DokuMan - 2012-06-11 - check cURL
  define('TEXT_NO_GDLIB_FOUND',': GDLIB NOT FOUND!');
  define('TEXT_GDLIBV2_SUPPORT','if GDlib version &lt; 2+ , please contact the support!');
  define('TEXT_GDLIB_MISSING_GIF_SUPPORT','You do not have GIF support in GDlib. Therefo using GIF images and GIF watermarks is not possible!');
  define('TEXT_GDLIB_GIF_VERSION','GDlib GIF support');
  define('TEXT_CHMOD_REMARK_HEADLINE','Attention');
  define('TEXT_CHMOD_REMARK','The following files and folders require write permission ( CHMOD 0777 )');
  define('TEXT_CHECKING','Checking');
  define('TEXT_INSTALLATION_NOT_POSSIBLE','Due to missing requirements the installation process cannot proceed! Please correct the issues and try again!');
  // EOF - DokuMan - 2010-08-16 - language dependent definitions for index.php

  // index.php
  define('TITLE_SELECT_LANGUAGE','Select your language :');
  define('TEXT_WELCOME','Welcome');
  define('TEXT_WELCOME_INDEX','<b>Welcome to shophelfer.com Shopsoftware</b><br /><br />The shophelfer.com Shopsoftware is an open source e-commerce solution that is constantly developed by Fishnet Services<br />Its out-of-the-box installation allows the shop owner to install, run and manage his online shop with a minimum of effort and expense.<br /><br />The shophelfer.com Shopsoftware runs on any system that provides a PHP environment (starting with PHP 5.0) and MySQL, such as Linux, Solaris, BSD, and Microsoft Windows.<br /><br />The shophelfer.com Shopsoftware is an OpenSource project - we always look forward to help.');
  define('TEXT_WELCOME_REQUIREMENTS_STEP', '<b>Requirements</b>');
  define('TEXT_WELCOME_DBCONNECTION_STEP', 'Database Connection');
  define('TEXT_WELCOME_PERMISSIONS_STEP', 'Permissions check');
  define('TEXT_WELCOME_STEP1','<b>Main database and webserver settings</b><br /><br />Please enter your Database and webserver settings.<br />');
  define('TEXT_WELCOME_STEP2','<b>Install database</b><br /><br />The shophelfer.com Shopsoftware installer will automatically install the shophelfer.com Shopsoftware database.');
  // BOF - web28 - 2010.02.20 - NEW STEP2-4 Handling
  define('TEXT_WELCOME_STEP2A','<b>Database installation has been disabled</b><br /><br />The installation of the shophelfer.com Shopsoftware database in Step3 is skipped.');
  // EOF - web28 - 2010.02.20 - NEW STEP2-4 Handling
  define('TEXT_WELCOME_ADMIN', 'Admin account configuration');
  define('TEXT_WELCOME_ADD_ADMIN', 'Additional admins');
  define('TEXT_WELCOME_STEP3','<b>Database import.</b><br /><br />');
  define('TEXT_WELCOME_STEP4','<b>Configure shophelfer.com Shopsoftware main files</b><br /><br /><b>If there are old configure files from a further installation, the shophelfer.com Shopsoftware will delete them</b><br /><br />The installer will set up the configuration files with the main parameters for database and file structur.<br /><br />You can choose between different session handling systems.');
  define('TEXT_WELCOME_STEP5','<b>Webserver Configuration</b><br /><br />');
  define('TEXT_WELCOME_STEP6','<b>Basic shop configuration</b><br /><br />The installer will create the admin account and will perform some db actions.<br /> The given information for <b>Country</b> and <b>Post Code</b> are used for shipping and tax callculations.<br /><br />If you wish, the shophelfer.com Shopsoftware can automatically setup the zones,tax-rates and tax-classes for delivering/selling within the European Union.<br />Just set <b>setup zones for EU</b> to <b>YES</b>.');
  define('TEXT_WELCOME_STEP7','<b>Guest and default customers setup</b><br /><br />The shophelfer.com Shopsoftware group- and pricesystem got nearly infinite possibilities of different prices.<br /><br />
    <b>% discount on single product</b><br />
    %max can be set for every single product, and single customers group<br />
    if %max at product = 10.00% and %max for group = 5% -> 5% discount on product<br />
    if %max at product = 10.00% and %max for group = 15% -> 10% discount on product<br /><br />
    <b>% discount on order total</b><br />
    % discount on total order sum (after tax and currencies calculations)<br /><br />
    <b>Graduated price</b><br />
    You also can set infinite graduated prices for a single product and single customers group.<br />
    you also are able to combine any of those systems, like:<br />
    user group 1 -> graduated prices on product Y<br />
    user group 2 -> 10% discount on product Y<br />
    user group 3 -> a special group price on product Y<br />
    user group 4 -> netto price on product Y<br />
  ');
  define('TEXT_WELCOME_FINISHED1','<b>The shophelfer.com Shopsoftware installation was successful!</b>');
  define('TEXT_WELCOME_FINISHED2', 'The installer has now set up the basic functions of your shop. Log in to the shop with your admin account and go to the admin area to complete the configuration of your shop.');
  define('TEXT_CONTINUE_BUTTON','Continue');
  define('TEXT_CANCEL_BUTTON', 'Cancel');
  define('TEXT_NO', 'No');
  define('TEXT_YES','Yes');
  define('TITLE_INSTALLATION_PROCESS','Installation process');
  define('TEXT_COMPLETE','Complete');
  define('TEXT_ADD_ADDITIONAL_ADMINS', 'Do you want to add additional admins to your shop?');

  // install_step1.php
  define('TITLE_CUSTOM_SETTINGS','Custom Settings');
  define('TEXT_IMPORT_DB','Install the shophelfer.com Shopsoftware Database');
  define('TEXT_IMPORT_DB_LONG','Install the shophelfer.com Shopsoftware database structure which includes tables and sample data. <b>(Mandatory on initial setup!)</b>');
  define('TEXT_AUTOMATIC','Automatic Configuration');
  define('TEXT_AUTOMATIC_LONG','The information you submit regarding the web server and database server will be automatically saved into both shophelfer.com Shopsoftware and Administration Tool configuration files.');
  define('TITLE_DATABASE_SETTINGS','Database Settings');
  define('TEXT_DATABASE_SERVER','Database Server');
  define('TEXT_DATABASE_SERVER_LONG','The database server can be in the form of a hostname, such as <i>db1.myserver.com</i>, or as an IP address, such as <i>192.168.0.1</i>.');
  define('TEXT_USERNAME','Username');
  define('TEXT_USERNAME_LONG','The username is used to connect to the database server. An example username is <i>mysql_10</i>.<br /><br />Note: If the shophelfer.com Shopsoftware Database is to be imported (selected above), the account used to connect to the database server needs to have Create and Drop permissions.');
  define('TEXT_PASSWORD','Password');
  define('TEXT_PASSWORD_LONG','The password is used together with the username, which forms the database user account.');
  define('TEXT_DATABASE','Database');
  define('TEXT_DATABASE_LONG','The database used to hold the catalog data.<br /><b>ATTENTION:</b> You need an empty Database to perform the installation.');
  define('TITLE_WEBSERVER_SETTINGS','Webserver Settings');
  define('TEXT_WS_ROOT','Webserver Root Directory');
  define('TEXT_WS_ROOT_LONG','The directory where your web pages are being served from, usually <i>/home/myname/public_html</i>.');
  define('TEXT_WS_XTC','Webserver Shop Directory');
  define('TEXT_WS_XTC_LONG','The directory where your catalog pages are being served from (from the webserver root directory), usually <i>/home/myname/public_html<b>/modified-shop/</b></i>.');
  define('TEXT_WS_ADMIN','Webserver Administration Tool Directory');
  define('TEXT_WS_ADMIN_LONG','The directory where your administration tool pages are being served from (from the webserver root directory), usually <i>/home/myname/public_html<b>/modified-shop/admin/</b></i>.');
  define('TEXT_WS_CATALOG','WWW Catalog Directory');
  define('TEXT_WS_CATALOG_LONG','The virtual directory where the shophelfer.com Shopsoftware Catalog module resides, usually <i>/modified-shop/</i>.');
  define('TEXT_WS_ADMINTOOL','WWW Administration Tool Directory');
  define('TEXT_WS_ADMINTOOL_LONG','The virtual directory where the shophelfer.com Shopsoftware Administration Tool resides, usually <i>/modified-shop/admin/</i>');
  //BOF WEBSERVER INFO
  define('TITLE_WEBSERVER_INFO','The default paths should be altered only in exceptional cases!');
  define('TEXT_WS_ROOT_INFO','The path is automatically determined');
  //EOF WEBSERVER INFO
  define('TEXT_RECHECK_REQUIREMENTS', 'ReCheck Requirements');
  define('TEXT_RECHECK_PERMISSIONS', 'ReCheck Permissions');

  // install_step2.php
  define('TEXT_PROCESS_1','Please continue the installation process to execute the database import procedure.');
  define('TEXT_PROCESS_2','It is important this procedure is not interrupted, otherwise the database may end up corrupt.');
  define('TEXT_PROCESS_3','The file to import must be located and named at: ');

  // install_step3.php
  define('TEXT_TITLE_ERROR','The following error has occurred:');
  define('TEXT_TITLE_SUCCESS','The database import was successful!');

  // install_step4.php
  define('TITLE_WEBSERVER_CONFIGURATION','Webserver Configuration:');
  define('TITLE_STEP4_ERROR','The following error has occurred:');
  define('TEXT_STEP4_ERROR','<b>The configuration files do not exist, or permission levels are not set.</b><br /><br />Please perform the following actions: ');
  define('TEXT_STEP4_ERROR_1','If <i>chmod 706</i> does not work, please try <i>chmod 777</i>.');
  define('TEXT_STEP4_ERROR_2','If you are running this installation procedure under a Microsoft Windows environment, try renaming the existing configuration file so a new file can be created.');
  define('TEXT_VALUES','The following configuration values will be written to:');
  define('TITLE_CHECK_CONFIGURATION','Please check your web-server information');
  define('TEXT_HTTP','HTTP Server');
  define('TEXT_HTTP_LONG','The web server can be in the form of a hostname, such as <i>http://www.myserver.com</i>, or as an IP address, such as <i>http://192.168.0.1</i>.');
  define('TEXT_HTTPS','HTTPS Server');
  define('TEXT_HTTPS_LONG','The secure web server can be in the form of a hostname, such as  <i>https://www.myserver.com</i>, or as an IP address, such as <i>https://192.168.0.1</i>.');
  define('TEXT_SSL','Enable SSL Connections');
  define('TEXT_SSL_LONG','Enable Secure Connections With SSL (HTTPS)');
  define('TITLE_CHECK_DATABASE','Please check your database-server information');
  define('TEXT_PERSIST','Enable Persistent Connections');
  define('TEXT_PERSIST_LONG','Enable persistent database connections. Please disable this if you are on a shared server.');
  define('TEXT_SESS_FILE','Store Sessions as Files');
  define('TEXT_SESS_DB','Store Sessions in the Database');
  define('TEXT_SESS_LONG','The location to store PHPs sessions files.');
  define('TITLE_CHECK_FILES','Please check your file information');
  //BOF - web28 - 2010-03-02 - New SSL-PROXY info
  define('TEXT_SSL_PROXY_LONG','<b>* Enable SSL Proxy: </b><br />When using a SSL Proxy adjust the path to <b>HTTPS server</b>!');
  //BOF - GTB - 2010-08-31 - Layout correction
  define('TEXT_SSL_PROXY_EXP','<b>SSL Proxy examples of some providers: </b><br /><br /><div class="prov">Hosteurope: </div><div class="proxy">https://ssl.webpack.de/nureinbeispiel.de</div><div class="clear">&nbsp;</div><div class="prov">ALL-INKL.COM: </div><div class="proxy">https://ssl-account.com/nureinbeispiel.de</div><div class="clear">&nbsp;</div><div class="prov">1und1: </div><div class="proxy">https://ssl.kundenserver.de/nureinbeispiel.de</div><div class="clear">&nbsp;</div><div class="prov">Strato: </div><div class="proxy">https://www.ssl-id.de/nureinbeispiel.de</div><div class="clear">&nbsp;</div><div class="prov">domainFactory: </div><div class="proxy">https://sslsites.de/nureinbeispiel.de</div><div class="clear">&nbsp;</div>');
  //EOF - GTB - 2010-08-31 - Layout correction
  //EOF - web28 - 2010-03-02 - New SSL-PROXY info

  // install_step5.php
  define('TEXT_WS_CONFIGURATION_SUCCESS','The <strong>shophelfer.com Shopsoftware</strong> Webserver configuration was successful');

  // install_step6.php
  define('TITLE_ADMIN_CONFIG','Administrator configuration');
  define('TEXT_REQU_INFORMATION','* required information');
  define('TEXT_GENDER', 'Gender:');
  define('TEXT_MALE', 'Male');
  define('TEXT_FEMALE', 'Female');
  define('TEXT_FIRSTNAME','First Name:');
  define('TEXT_LASTNAME','Last Name:');
  define('TEXT_EMAIL','E-Mail Address:');
  define('TEXT_EMAIL_LONG','(for receiving orders)');
  define('TEXT_STREET','Street Address:');
  define('TEXT_POSTCODE','Post Code:');
  define('TEXT_CITY','City:');
  define('TEXT_STATE','State/Province:');
  define('TEXT_COUNTRY','Country:');
  define('TEXT_COUNTRY_LONG','Will be used for shipping and tax');
  define('TEXT_TEL','Telephone  Number:');
  define('TEXT_PASSWORD_CONF','Password Confirmation:');
  define('TITLE_SHOP_CONFIG','Shop configuration');
  define('TEXT_STORE','Store Name:');
  define('TEXT_STORE_LONG','(The name of my store)');
  define('TEXT_EMAIL_FROM','E-Mail From');
  define('TEXT_EMAIL_FROM_LONG','(The e-mail adress used in (sent) e-mails)');
  define('TITLE_ZONE_CONFIG','Zone configuration');
  define('TEXT_ZONE','Set up zones for EU?');
  define('TITLE_ZONE_CONFIG_NOTE','*Note: The shophelfer.com Shopsoftware can automatically setup the right Zone-Setup if your store is located within the EU.');
  define('TITLE_SHOP_CONFIG_NOTE','*Note: Information for basic Shop configuration');
  define('TITLE_ADMIN_CONFIG_NOTE','*Note: Information for Admin/Superuser');
  define('TEXT_ZONE_NO','No');
  define('TEXT_ZONE_YES','Yes');
  define('TEXT_COMPANY','Company name');
  define('ENTRY_GENDER_ERROR', 'Please select gender for this admin');
  define('ENTRY_FIRST_NAME_ERROR','Firstname too short');
  define('ENTRY_LAST_NAME_ERROR','Lastname too short');
  define('ENTRY_EMAIL_ADDRESS_ERROR','Email too short');
  define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR','Check Email Format');
  define('ENTRY_STREET_ADDRESS_ERROR','Street too short');
  define('ENTRY_POST_CODE_ERROR','Post Code too short');
  define('ENTRY_CITY_ERROR','City too short');
  define('ENTRY_COUNTRY_ERROR','Check Country');
  define('ENTRY_STATE_ERROR','Check State');
  define('ENTRY_TELEPHONE_NUMBER_ERROR','Telephone number too short');
  define('ENTRY_PASSWORD_ERROR','Check Password');
  define('ENTRY_STORE_NAME_ERROR','Store name too short');
  define('ENTRY_COMPANY_NAME_ERROR','Company name too short');
  define('ENTRY_EMAIL_ADDRESS_FROM_ERROR','Email-From too short');
  define('ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR','Check Email-From Format');
  define('SELECT_ZONE_SETUP_ERROR','Select Zone setup');

  // install_step7
  define('TITLE_GUEST_CONFIG','Guest configuration');
  define('TITLE_GUEST_CONFIG_NOTE','*Note; Settings for standard user (non-regristrated customer)');
  define('TITLE_CUSTOMERS_CONFIG','Default customers configuration');
  define('TITLE_CUSTOMERS_CONFIG_NOTE','*Note; Settings for standard user (regristrated customer)');
  define('TEXT_STATUS_DISCOUNT','Product discount');
  define('TEXT_STATUS_DISCOUNT_LONG','discount on products <i>(in percent, like 10.00 , 20.00)</i>');
  define('TEXT_STATUS_OT_DISCOUNT_FLAG','Discount on order total');
  define('TEXT_STATUS_OT_DISCOUNT_FLAG_LONG','allow guest to get discount on total order price');
  define('TEXT_STATUS_OT_DISCOUNT','Discount on order total');
  define('TEXT_STATUS_OT_DISCOUNT_LONG','discount on order total <i>(in percent, like 10.00 , 20.00)</i>');
  define('TEXT_STATUS_GRADUATED_PRICE','Graduated price');
  define('TEXT_STATUS_GRADUATED_PRICE_LONG','allow user to see gratuated prices');
  define('TEXT_STATUS_SHOW_PRICE','Show price');
  define('TEXT_STATUS_SHOW_PRICE_LONG','allow user to see product-price in shop');
  define('TEXT_STATUS_SHOW_TAX','Show tax');
  define('TEXT_STATUS_SHOW_TAX_LONG','Display prices with tax included (Yes) or without any tax (No)');
  define('TEXT_STATUS_COD_PERMISSION','Cash on Delivery');
  define('TEXT_STATUS_COD_PERMISSION_LONG','Allows the customer to order by cash on delivery.');
  define('TEXT_STATUS_BT_PERMISSION','Debit');
  define('TEXT_STATUS_BT_PERMISSION_LONG','Allows the customer to order by bank move.');
  define('ENTRY_DISCOUNT_ERROR','Product discount -Guest');
  define('ENTRY_OT_DISCOUNT_ERROR','Discount on ot -Guest');
  define('SELECT_OT_DISCOUNT_ERROR','Discount on ot -Guest');
  define('SELECT_GRADUATED_ERROR','Graduated Prices -Guest');
  define('SELECT_PRICE_ERROR','Show Price -Guest');
  define('SELECT_TAX_ERROR','Show Tax -Guest');
  define('ENTRY_DISCOUNT_ERROR2','Product discount -Default');
  define('ENTRY_OT_DISCOUNT_ERROR2','Discount on ot -Default');
  define('SELECT_OT_DISCOUNT_ERROR2','Discount on ot -Default');
  define('SELECT_GRADUATED_ERROR2','Graduated Prices -Default');
  define('SELECT_PRICE_ERROR2','Show Price -Default');
  define('SELECT_TAX_ERROR2','Show Tax -Default');

  // install_finished.php
  define('TEXT_SHOP_CONFIG_SUCCESS','The <strong>shophelfer.com Shopsoftware</strong> Shop configuration was successful.');
  define('TEXT_TEAM','Thank you for chosing the shophelfer.com Shopsoftware. Please visit the <a href="http://www.shophelfer.com">shophelfer.com Shopsoftware Community</a>.');
  define('TEXT_VISIT_SHOP', 'Visit your new Shophelfer shop');

  // BOC flth new permission change system
  define ('FTP_CHANGE_PERM_EXPLAIN', 'To set the file and directory permissions, you can either use your FTP program or enter your FTP information here to have set the required access permissions automatically.');
         // Depending on the server configuration, you can try it directly on PHP, for this please click <a href="index.php?action=fixperms"> here </ a>. <br />
         // If the voting rights it still is not always the only solution method via FTP right. ');
  define ('LOGIN_NOT_POSSIBLE', 'Wrong FTP path, Host unreachable');
  define ('CHMOD_WAS_NOT_SUCCESSFUL', 'Change the directory permissions was NOT successful');
  define ('FTP_HOST', 'FTP host (automatically detected) ');
  define ('FTP_PORT', 'FTP port (default: 21)');
  define ('FTP_PATH', 'FTP path (usually / public_html or / htdocs, possibly sub-directory)');
  define ('FTP_LOGIN', 'FTP username');
  define ('FTP_PASSWORD', 'FTP password');
  define ('CONNECT_FTP', 'FTP connect');
  // EOC flth new permission change system
  
  //db_upgrade.php
  define('TITLE_UPGRADE','<strong><h1>Database upgrade process</h1></strong>');
  define('TEXT_SUBMIT_BUTTON', 'Execute database operation');
  define('TEXT_PROCEED', 'Proceed to shop');
  define('CANCEL', 'Cancel');
  define('SUCCESS_MESSAGE', '<br /><br /><strong><font style="color: green;">Database operation successful!</font></strong><br /><br />');
  define('UPGRADE_NOT_NECESSARY', '<font style="color: green;">Database upgrade not necessary, you are up to date!</font>');
  define('UPGRADE_NOT_POSSIBLE', '<font style="color: red;">No automatic update possible for your shopversion!</font>');
  define('USED_FILES', '<br /><br />The following files will be used for the upgrade to the newest database version:<br /><br />');
  define('CURRENT_DB_VERSION', '<br />Your current database version is: ');
  define('TEXT_TITLE','Shophelfer Shopsoftware database upgrade process');
