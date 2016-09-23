INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('', 'SHOW_COOKIE_NOTE', 'false', '25', '1', NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('', 'COOKIE_NOTE_CONTENT_ID', '0', '25', '2', NOW(), NULL, NULL);
INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('', 'CONTACT_FORM_CONSENT', 'false', '25', '3', NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');

INSERT INTO configuration_group VALUES (25, 'Legal', 'Legal Options', 25, 1);

ALTER TABLE `manufacturers_info`
ADD `manufacturers_description` text COLLATE 'latin1_german1_ci' NOT NULL AFTER `manufacturers_url`,
ADD `manufacturers_description_more` text COLLATE 'latin1_german1_ci' NOT NULL AFTER `manufacturers_description`,
ADD `manufacturers_short_description` text COLLATE 'latin1_german1_ci' NOT NULL AFTER `manufacturers_description_more`;

ALTER TABLE `customers` ADD `customers_symbol` INT(11) DEFAULT 0 NOT NULL ;