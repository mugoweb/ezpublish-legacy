SET storage_engine=InnoDB;
ALTER TABLE ezuser CHANGE password_hash password_hash VARCHAR(255) default NULL;
