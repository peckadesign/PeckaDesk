CREATE TABLE `issue` (
`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
`name` varchar(255) NOT NULL,
`project_id` int NOT NULL
) ENGINE='InnoDB';

ALTER TABLE `issue`
ADD FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
