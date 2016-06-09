ALTER TABLE `products` ADD `products_image_title` VARCHAR( 255 ) NOT NULL AFTER `products_image`;
ALTER TABLE `products` ADD `products_image_alt` VARCHAR( 255 ) NOT NULL AFTER `products_image`;
ALTER TABLE `products_images` ADD `image_title` VARCHAR( 255 ) NOT NULL AFTER `image_name`;
ALTER TABLE `products_images` ADD `image_alt` VARCHAR( 255 ) NOT NULL AFTER `image_name`;