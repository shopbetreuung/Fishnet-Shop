ALTER TABLE imagesliders_info DROP PRIMARY KEY;
ALTER TABLE imagesliders_info ADD PRIMARY KEY( imagesliders_id, languages_id); 

UPDATE database_version SET version = 'SH_1.1.1';
