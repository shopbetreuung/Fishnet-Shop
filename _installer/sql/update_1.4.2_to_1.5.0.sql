INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'CATEGORY_IMAGE_WIDTH', '160', 4, '6', NULL, NOW(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'CATEGORY_IMAGE_HEIGHT', '160', 4, '6', NULL, NOW(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'CATEGORY_IMAGE_BEVEL', '', 4, '12', NULL, NOW(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'CATEGORY_IMAGE_GREYSCALE', '', 4, '12', NULL, NOW(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'CATEGORY_IMAGE_ELLIPSE', '', 4, '12', NULL, NOW(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'CATEGORY_IMAGE_ROUND_EDGES', '', 4, '12', NULL, NOW(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'CATEGORY_IMAGE_MERGE', '', 4, '12', NULL, NOW(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'CATEGORY_IMAGE_FRAME', '', 4, '12', NULL, NOW(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'CATEGORY_IMAGE_DROP_SHADDOW', '', 4, '12', NULL, NOW(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'CATEGORY_IMAGE_MOTION_BLUR', '', 4, '12', NULL, NOW(), NULL, NULL);

ALTER TABLE products ADD products_image_title VARCHAR(255) NOT NULL AFTER products_image;
ALTER TABLE products ADD products_image_alt VARCHAR(255) NOT NULL AFTER products_image_title;
ALTER TABLE products_images ADD image_title VARCHAR(255) NOT NULL AFTER image_name;
ALTER TABLE products_images ADD image_alt VARCHAR(255) NOT NULL AFTER image_title;

UPDATE database_version SET version = 'SH_1.5.0';