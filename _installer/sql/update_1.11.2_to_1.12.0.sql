UPDATE database_version SET version = 'SH_1.12.0';

INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'REQUIRED_PHONE_NUMBER', 'false', 1, 99, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');  


