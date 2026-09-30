-- how to create an mysql user and give all the credential to that user ?
-- CREATE USER 'username'@'host' IDENFIFIED BY 'password';

#legacy 5.3 user new
CREATE user 'sentinel_lg'@'localhost' IDENTIFIED BY 'sentinellgdoom';

select user, HOST from mysql.user;

GRANT ALL PRIVILEGES on iis_master.* to 'sentinel_lg' @'localhost';

show GRANTS for 'santinel' @'localhost';

-- for removing the privileges :
-- REVOKE privilege ON database_name.table name (or *) from 'username'@'host';

# Delete User :
DROP USER 'sentinel'@'localhost';

# Creating User for mysql 8.4 where i am gonna use this updated version of mysql in this project
CREATE USER 'santinel' @'localhost' IDENTIFIED BY 'santineldoom';

GRANT ALL PRIVILEGES on sentinelforge.* to 'santinel' @'localhost';

SELECT user from mysql.user;

