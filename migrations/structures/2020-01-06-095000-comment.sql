CREATE TABLE `comment` (
`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
`createdBy_id` int(11) NOT NULL,
`created` datetime NOT NULL,
`issue_id` int(11) NOT NULL,
FOREIGN KEY (`createdBy_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE RESTRICT
) ENGINE='InnoDB';

ALTER TABLE `comment`
ADD INDEX `created` (`created`);

CREATE TABLE `revision` (
`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
`comment_id` int(11) NOT NULL,
`text` text NULL,
`createdBy_id` int(11) NOT NULL,
`created` datetime NOT NULL,
FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE RESTRICT,
FOREIGN KEY (`createdBy_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT
) ENGINE='InnoDB';

ALTER TABLE `issue`
DROP `description`;
