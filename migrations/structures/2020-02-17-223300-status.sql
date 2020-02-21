CREATE TABLE `status` (
`issue_id` int(11) NOT NULL,
`status` char(255) COLLATE 'ascii_general_ci' NOT NULL,
`createdBy_id` int(11) NOT NULL,
`created` datetime NOT NULL,
FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE RESTRICT,
FOREIGN KEY (`createdBy_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT
) ENGINE='InnoDB';
