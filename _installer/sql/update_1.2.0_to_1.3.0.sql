DELETE FROM `configuration` WHERE `configuration_key` = 'USE_ADMIN_TOP_MENU';

UPDATE database_version SET version = 'SH_1.3.0';
