DELETE FROM `configuration` WHERE `configuration_key` = 'USE_ADMIN_TOP_MENU';

DROP TABLE IF EXISTS carriers;
CREATE TABLE IF NOT EXISTS carriers (
  carrier_id int(11) NOT NULL AUTO_INCREMENT,
  carrier_name varchar(80) NOT NULL,
  carrier_tracking_link varchar(512) NOT NULL,
  carrier_sort_order int(11) NOT NULL,
  carrier_date_added DATETIME NOT NULL,
  carrier_last_modified DATETIME NOT NULL,
  PRIMARY KEY (carrier_id)
);

INSERT INTO carriers (carrier_name, carrier_tracking_link, carrier_sort_order) VALUES
('DHL', 'http://nolp.dhl.de/nextt-online-public/set_identcodes.do?lang=de&idc=$1', 20),
('DPD', 'https://extranet.dpd.de/cgi-bin/delistrack?pknr=$1+&typ=1&lang=de', 30),
('GLS', 'http://www.gls-group.eu/276-I-PORTAL-WEB/content/GLS/DE03/DE/5004.htm?txtRefNo=$1&txtAction=71000', 40);

DROP TABLE IF EXISTS orders_tracking;
CREATE TABLE IF NOT EXISTS orders_tracking (
  ortra_id int(11) NOT NULL AUTO_INCREMENT,
  ortra_order_id int(11) NOT NULL,
  ortra_carrier_id int(11) NOT NULL,
  ortra_parcel_id varchar(80) NOT NULL,
  PRIMARY KEY (ortra_id),
  KEY ortra_order_id (ortra_order_id)
);

ALTER TABLE admin_access ADD parcel_carriers INT(1) NOT NULL DEFAULT '0' AFTER wholesalers_list;

UPDATE database_version SET version = 'SH_1.3.0';
