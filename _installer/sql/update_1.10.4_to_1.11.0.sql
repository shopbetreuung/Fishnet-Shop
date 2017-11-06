UPDATE database_version SET version = 'SH_1.11.0';

ALTER TABLE admin_access ADD inventory INT(1) NOT NULL DEFAULT '0';
ALTER TABLE admin_access ADD invoiced_orders INT(1) NOT NULL DEFAULT '0';

