ALTER TABLE `issue`
ADD `description` text NULL;

CREATE TABLE `file` (
`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
`name` varchar(255) NOT NULL
) ENGINE='InnoDB';

CREATE TABLE `issue_x_file` (
`issue_id` int(11) NOT NULL,
`file_id` int(11) NOT NULL,
FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE RESTRICT,
FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE RESTRICT
) ENGINE='InnoDB';

ALTER TABLE `file`
ADD `discr` varchar(255) COLLATE 'ascii_general_ci' NOT NULL;

ALTER TABLE `file`
ADD INDEX `discr` (`discr`);

ALTER TABLE `file`
ADD `width` int NULL,
ADD `height` int NULL AFTER `width`;
