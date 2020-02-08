CREATE TABLE `user_x_project` (
`user_id` int NOT NULL,
`project_id` int NOT NULL,
`role` varchar(255) NOT NULL,
FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE RESTRICT
) ENGINE='InnoDB';

ALTER TABLE `user_x_project`
ADD UNIQUE `user_id_project_id` (`user_id`, `project_id`);
