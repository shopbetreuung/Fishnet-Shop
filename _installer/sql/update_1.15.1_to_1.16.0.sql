UPDATE database_version SET version = 'SH_1.16.0';

ALTER TABLE `products` CHANGE `products_weight` `products_weight` DECIMAL(7,3) NOT NULL;

