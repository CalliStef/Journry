# Database creation script

```sql

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `activation_token` varchar(250) DEFAULT NULL,
  `created` datetime NOT NULL,
  `active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);

CREATE TABLE IF NOT EXISTS `journals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL DEFAULT 'No title yet',
  `content` varchar(500) NOT NULL DEFAULT 'No content yet',
  `created_date` date NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `journals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);


CREATE TABLE `images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` longblob NOT NULL,
  `journal_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `journal_id` (`journal_id`),
  CONSTRAINT `images_ibfk_1` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`)
);



```
