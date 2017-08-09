-- -----------------------------------------------------
-- Table `squads`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `squads` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `description` VARCHAR(1000) NULL,
  `status` TINYINT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  `status` TINYINT NULL DEFAULT 1,
  `password` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `description` VARCHAR(500) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `users_in_squads`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users_in_squads` (
  `squad` INT NOT NULL,
  `user` INT NOT NULL,
  `role` INT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`squad`, `user`),
  INDEX `fk_squads_has_users_users1_idx` (`user` ASC),
  INDEX `fk_squads_has_users_squads1_idx` (`squad` ASC),
  UNIQUE INDEX `squad_UNIQUE` (`squad` ASC),
  UNIQUE INDEX `user_UNIQUE` (`user` ASC),
  INDEX `fk_users_in_squads_roles1_idx` (`role` ASC),
  CONSTRAINT `fk_squads_has_users_squads1`
    FOREIGN KEY (`squad`)
    REFERENCES `squads` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_squads_has_users_users1`
    FOREIGN KEY (`user`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_in_squads_roles1`
    FOREIGN KEY (`role`)
    REFERENCES `roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `metadata`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `metadata` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `key` VARCHAR(500) NOT NULL,
  `value` VARCHAR(500) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `squad` INT NOT NULL,
  `user` INT NOT NULL,
  `title` VARCHAR(255) NULL,
  `content` VARCHAR(2000) NULL,
  `status` TINYINT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_posts_squads1_idx` (`squad` ASC),
  INDEX `fk_posts_users1_idx` (`user` ASC),
  CONSTRAINT `fk_posts_squads1`
    FOREIGN KEY (`squad`)
    REFERENCES `squads` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_posts_users1`
    FOREIGN KEY (`user`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `permissions_in_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `permissions_in_roles` (
  `roles_id` INT NOT NULL,
  `permissions_id` INT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`roles_id`, `permissions_id`),
  INDEX `fk_roles_has_permissions_permissions1_idx` (`permissions_id` ASC),
  INDEX `fk_roles_has_permissions_roles1_idx` (`roles_id` ASC),
  CONSTRAINT `fk_roles_has_permissions_roles1`
    FOREIGN KEY (`roles_id`)
    REFERENCES `roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_roles_has_permissions_permissions1`
    FOREIGN KEY (`permissions_id`)
    REFERENCES `permissions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `skills`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `skills` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `status` TINYINT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `skills_in_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `skills_in_users` (
  `users_id` INT NOT NULL,
  `skills_id` INT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`users_id`, `skills_id`),
  INDEX `fk_users_has_skills_skills1_idx` (`skills_id` ASC),
  INDEX `fk_users_has_skills_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_users_has_skills_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_skills_skills1`
    FOREIGN KEY (`skills_id`)
    REFERENCES `skills` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;