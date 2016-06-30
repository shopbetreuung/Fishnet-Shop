UPDATE email_manager SET em_body = REPLACE(em_body, '&quot;', '"');

UPDATE database_version SET version = 'SH_1.3.2';
