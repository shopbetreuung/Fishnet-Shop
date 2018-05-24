UPDATE database_version SET version = 'SH_1.13.0';

DELETE FROM `configuration` WHERE `configuration_key` = 'PRIVACY_STATEMENT_ID';

INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'DISPLAY_PRIVACY', 'true', 17, 18, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'PRIVACY_ID', '2', 17, 19, NULL, NOW(), NULL, NULL);
