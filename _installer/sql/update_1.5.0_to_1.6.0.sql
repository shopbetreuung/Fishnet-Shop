INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('', 'SHOW_COOKIE_NOTE', 'false', '25', '1', NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('', 'COOKIE_NOTE_CONTENT_ID', '0', '25', '2', NOW(), NULL, NULL);

INSERT INTO configuration_group VALUES (25, 'Legal', 'Legal Options', 25, 1);