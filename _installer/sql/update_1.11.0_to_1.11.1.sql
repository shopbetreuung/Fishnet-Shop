UPDATE database_version SET version = 'SH_1.11.1';

INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'USE_SEARCH_ORDER_REDIRECT', 'false', '1000', '134', NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

