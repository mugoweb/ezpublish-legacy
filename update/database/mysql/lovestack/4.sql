# You may already have non-unique values in your ezuser database table.
# Use following SQL statement to test and identify those instances:
# SELECT login, COUNT(*) AS instances FROM ezuser GROUP BY login HAVING instances > 1;
# You would need to manually resolve those duplicate rows - for example by editing the login values
# Otherwise the following SQL statements will fail.
DROP INDEX ezuser_login on ezuser;
CREATE UNIQUE INDEX ezuser_login ON ezuser (login);

# Update data_text values to '' where data_text is null:
UPDATE ezcontentobject_attribute SET data_text = '' WHERE data_text IS NULL;

# add a new text column with a default:
ALTER TABLE `ezcontentobject_attribute` ADD `data_text_tmp` longtext NOT NULL DEFAULT (_utf8mb4'') COLLATE utf8mb4_general_ci;

# copy the existing data to that column:
UPDATE `ezcontentobject_attribute` SET `data_text_tmp` = `data_text`;

# drop the original data_text column:
ALTER TABLE `ezcontentobject_attribute` DROP `data_text`;

# rename the new column to data_text:
ALTER TABLE `ezcontentobject_attribute` RENAME COLUMN `data_text_tmp` TO `data_text`;
