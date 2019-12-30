CREATE TABLE `user` (
`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
`email` varchar(255) COLLATE 'ascii_general_ci' NOT NULL,
`firstName` varchar(255) NOT NULL,
`lastName` varchar(255) NOT NULL,
`peckanotesToken` text COLLATE 'ascii_general_ci' NULL
) ENGINE='InnoDB';

ALTER TABLE `user`
ADD UNIQUE `email` (`email`);

CREATE TABLE `persistentLogin` (
`user_id` int(11) NOT NULL,
`token` varchar(32) COLLATE 'ascii_general_ci' NOT NULL,
`ip` varchar(15) COLLATE 'ascii_general_ci' NOT NULL,
FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE='InnoDB';

ALTER TABLE `persistentLogin`
ADD UNIQUE `token_user_id` (`token`, `user_id`);
