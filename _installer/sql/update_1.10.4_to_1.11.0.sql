UPDATE database_version SET version = 'SH_1.11.0';

ALTER TABLE admin_access ADD inventory INT(1) NOT NULL DEFAULT '0';
UPDATE admin_access SET inventory = '1' WHERE customers_id = '1';

ALTER TABLE admin_access ADD invoiced_orders INT(1) NOT NULL DEFAULT '0';
UPDATE admin_access SET invoiced_orders = '1' WHERE customers_id = '1';

