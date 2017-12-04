UPDATE database_version SET version = 'SH_1.11.0';

ALTER TABLE admin_access ADD inventory INT(1) NOT NULL DEFAULT '0';
UPDATE admin_access SET inventory = '1' WHERE customers_id = '1';

ALTER TABLE admin_access ADD invoiced_orders INT(1) NOT NULL DEFAULT '0';
UPDATE admin_access SET invoiced_orders = '1' WHERE customers_id = '1';

ALTER TABLE admin_access ADD outstanding INT(1) NOT NULL DEFAULT '0';
UPDATE admin_access SET outstanding = '1' WHERE customers_id = '1';

ALTER TABLE admin_access ADD inventory_turnover INT(1) NOT NULL DEFAULT '0';
UPDATE admin_access SET inventory_turnover = '1' WHERE customers_id = '1';

ALTER TABLE admin_access ADD globaledit INT(1) NOT NULL DEFAULT '0';
UPDATE admin_access SET globaledit = '1' WHERE customers_id = '1';

ALTER TABLE admin_access ADD stock_range INT(1) NOT NULL DEFAULT '0';
UPDATE admin_access SET stock_range = '1' WHERE customers_id = '1';

INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'SAVE_IP_IN_DATABASE', 'false', 17, 8, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\', \'shortened\'),');

