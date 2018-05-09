UPDATE database_version SET version = 'SH_1.12.3';

INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRIVACY_STATEMENT_ID', '2', '17', '24', NULL, NOW(), NULL, NULL);

