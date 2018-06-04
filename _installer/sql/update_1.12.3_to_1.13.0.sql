UPDATE database_version SET version = 'SH_1.13.0';

DELETE FROM `configuration` WHERE `configuration_key` = 'PRIVACY_STATEMENT_ID';

INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'DISPLAY_PRIVACY', 'true', 17, 18, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO configuration (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'PRIVACY_ID', '2', 17, 19, NULL, NOW(), NULL, NULL);

ALTER TABLE `admin_access` ADD `whitelist_logs` INT( 1 ) NOT NULL ;

ALTER TABLE `content_manager` CHANGE `group_ids` `group_ids` LONGTEXT;
ALTER TABLE `content_manager` CHANGE `content_title` `content_title` LONGTEXT;
ALTER TABLE `content_manager` CHANGE `content_heading` `content_heading` LONGTEXT;
ALTER TABLE `content_manager` CHANGE `content_text` `content_text` LONGTEXT;
ALTER TABLE `content_manager` CHANGE `content_meta_title` `content_meta_title` LONGTEXT;
ALTER TABLE `content_manager` CHANGE `content_meta_description` `content_meta_description` LONGTEXT;
ALTER TABLE `content_manager` CHANGE `content_meta_keywords` `content_meta_keywords` LONGTEXT;


