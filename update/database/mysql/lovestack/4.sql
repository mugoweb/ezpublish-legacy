# You may already have non-unique values in your ezuser database table.
# Use following SQL statement to test and identify those instances:
# SELECT login, COUNT(*) AS instances FROM ezuser GROUP BY login HAVING instances > 1;
# You would need to manually resolve those duplicate rows - for example by editing the login values
# Otherwise the following SQL statements will fail.
DROP INDEX ezuser_login on ezuser;
CREATE UNIQUE INDEX ezuser_login ON ezuser (login);
