DROP TABLE IF EXISTS `quote`;

DELETE FROM `user_perms_chain` WHERE `user_perms` IN (
    SELECT `id` FROM `user_perms` WHERE `group` = 'Quote'
);

DELETE FROM `user_perms` WHERE `group` = 'Quote';