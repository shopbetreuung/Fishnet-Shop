UPDATE database_version SET version = 'SH_1.15.0';

ALTER TABLE `orders` ADD `ibn_secondreminderpdfnotifydate` DATE NOT NULL ;
ALTER TABLE `categories_description` ADD `categorie_image_title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `categories_meta_description` ,	ADD `categorie_image_alt` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `categorie_image_title` ;
ALTER TABLE `orders` MODIFY shipping_method VARCHAR(128); //NB DHLGKAPI shipping_method field length 32 --> 128
