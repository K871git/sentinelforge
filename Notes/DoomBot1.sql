-- how to create an mysql user and give all the credential to that user ?
-- CREATE USER 'username'@'host' IDENFIFIED BY 'password';
CREATE USER 'santinel' @'localhost' IDENTIFIED BY 'santineldoom';

select user, HOST from mysql.user;

GRANT ALL PRIVILEGES on sentinelforge.* to 'santinel' @'localhost';

show GRANTS for 'santinel' @'localhost';

-- for removing the privileges :
-- REVOKE privilege ON database_name.table name (or *) from 'username'@'host';

# Delete User :
DROP USER 'user'@'host';