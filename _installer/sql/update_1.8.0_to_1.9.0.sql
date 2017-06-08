INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'SMTP_SECURE', '---', 12, 15, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'---\', \'ssl\', \'tls\'),');

UPDATE orders_status SET orders_status_name = 'Shipped' WHERE orders_status_id = '3' AND language_id = '1';

UPDATE database_version SET version = 'SH_1.9.0';
