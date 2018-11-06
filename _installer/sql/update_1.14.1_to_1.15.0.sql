UPDATE database_version SET version = 'SH_1.15.0';

ALTER TABLE `orders` ADD `ibn_secondreminderpdfnotifydate` DATE NOT NULL ;

