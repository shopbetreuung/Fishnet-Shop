UPDATE database_version SET version = 'SH_1.17.0';

ALTER TABLE products_description ADD content_meta_index TINYINT(1) NULL DEFAULT NULL;
ALTER TABLE products_description ADD canonical_link TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
UPDATE countries SET countries_name = 'Republic North-Macedonia' WHERE countries_id = 126;
ALTER TABLE customers CHANGE customers_password customers_password VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

