UPDATE database_version SET version = 'SH_1.12.1';

INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'RECAPTCHA_SECRET_KEY', '', '5', '133', NULL, NOW(), NULL, NULL);
