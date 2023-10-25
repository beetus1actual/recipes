CREATE TABLE `users`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `firstname` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `updated_at` DATETIME NOT NULL,
    `created_at` DATETIME NOT NULL,
    `groupId` BIGINT NOT NULL
);
ALTER TABLE
    `users` ADD UNIQUE `users_email_unique`(`email`);
CREATE TABLE `recipe_groups`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL
);
CREATE TABLE `user_group`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL
);
ALTER TABLE
    `user_group` ADD UNIQUE `user_group_name_unique`(`name`);
CREATE TABLE `recipes`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `userId` BIGINT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    `groupId` BIGINT NOT NULL
);
ALTER TABLE
    `recipes` ADD CONSTRAINT `recipes_userid_foreign` FOREIGN KEY(`userId`) REFERENCES `users`(`id`);
ALTER TABLE
    `users` ADD CONSTRAINT `users_groupid_foreign` FOREIGN KEY(`groupId`) REFERENCES `user_group`(`id`);
ALTER TABLE
    `recipes` ADD CONSTRAINT `recipes_groupid_foreign` FOREIGN KEY(`groupId`) REFERENCES `recipe_groups`(`id`);