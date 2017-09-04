INSERT IGNORE INTO `user_perms` ( `name`, `group`, `role`, `about` ) VALUES
    ( 'read_quote',   'Quote', 'Management', 'Allow user to view quote' ),
    ( 'update_quote', 'Quote', 'Management', 'Allow user to update exists quote' ),
    ( 'remove_quote', 'Quote', 'Management', 'Allow user to remove exists quote' ),
    ( 'create_quote', 'Quote', 'Management', 'Allow user to create new quote' );

CREATE TABLE IF NOT EXISTS `quote` (
    `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user` INTEGER NOT NULL,
    `group` VARCHAR(50),
    `title` VARCHAR(150),
    `text` TEXT,
    `image` VARCHAR(150),
    `sources` VARCHAR(150),
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX `by_group` ON `quote` ( `group` );
