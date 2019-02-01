UPDATE database_version SET version = 'SH_1.15.0';

ALTER TABLE `orders` ADD `ibn_secondreminderpdfnotifydate` DATE NOT NULL ;
ALTER TABLE `categories_description` ADD `categorie_image_title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `categories_meta_description` ,	ADD `categorie_image_alt` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `categorie_image_title` ;
ALTER TABLE `orders` MODIFY shipping_method VARCHAR(128);
ALTER TABLE `products_description` ADD `products_main_image_title` VARCHAR( 255 ) NOT NULL , ADD `products_main_image_alt` VARCHAR( 255 ) NOT NULL ;

DROP TABLE IF EXISTS products_images_description;
CREATE TABLE products_images_description (
  image_id int(11) NOT NULL,
  image_nr smallint(6) NOT NULL,
  language_id tinyint(4) NOT NULL,
  image_title varchar(255) NOT NULL,
  image_alt varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

