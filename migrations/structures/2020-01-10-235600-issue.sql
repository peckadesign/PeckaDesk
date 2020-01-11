ALTER TABLE `issue`
ADD `createdBy_id` int(11) NOT NULL,
ADD `created` datetime NOT NULL AFTER `createdBy_id`,
ADD FOREIGN KEY (`createdBy_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT;

ALTER TABLE `issue_x_file`
DROP FOREIGN KEY `issue_x_file_ibfk_1`

ALTER TABLE `issue_x_file`
DROP INDEX `issue_id`;

ALTER TABLE `issue_x_file`
DROP `issue_id`;

ALTER TABLE `issue_x_file`
ADD `comment_id` int(11) NOT NULL,
ADD FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE RESTRICT;

ALTER TABLE `issue_x_file`
RENAME TO `comment_x_file`;
