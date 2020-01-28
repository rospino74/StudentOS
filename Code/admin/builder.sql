/*User table*/
CREATE TABLE users (
	`id` int(3) NOT NULL AUTO_INCREMENT,
	`role` char(45) NOT NULL,
	`username` char(20) NOT NULL,
	`name` char(255) NOT NULL,
	`email` char(255) NOT NULL,
	`password` char(255) NOT NULL,
	`icon` blob DEFAULT NULL,
	`ip` char(25) NOT NULL,
	`session` char(255) DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `id` (`id`),
	KEY `id_2` (`id`)
);
/*Classroom table*/
CREATE TABLE `classrooms` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` char(25) NOT NULL,
	`members` blob NOT NULL,
	`can_students_post` tinyint(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE KEY `id` (`id`),
	KEY `id_2` (`id`)
);
/*Classroom 1 table*/
CREATE TABLE `class1` (
	`id` int(4) NOT NULL AUTO_INCREMENT,
	`title` char(255) NOT NULL,
	`content` blob NOT NULL,
	`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`ip` char(25) NOT NULL,
	`author_id` int(4),
	PRIMARY KEY (`id`),
	UNIQUE KEY `id` (`id`),
	KEY `id_2` (`id`)
) COMMENT='Posts for class1';

CREATE TABLE `comments-class1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` blob NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`),
	UNIQUE KEY `id` (`id`),
	KEY `id_2` (`id`)
) COMMENT='Comments for class1';

/*Admin record*/
INSERT INTO `users` 
		(`id`, `role`, `username`, `name`, `email`, `password`, `session`, `ip`) 
	VALUES 
		('1', 'administrator', 'Admin', 'Administrator', 'test@test.com', PASSWORD('Administrator'), '0', '');

/*Post for classroom 1*/
INSERT INTO `class1` (`id`, `title`, `content`, `date`, `ip`, `author_id`) VALUES(0, 'Errore', 0x51756573746120706167696e61206e6f6e20636f6e7469656e65206e756c6c61206d692064697370696163652e2e2e20506f73746120706572207072696d6f212056697375616c697a7a61206c6120677569646120e29e9c203c6120687265663d222e2e2f61646d696e2f67756964652e706870223e7064663c2f613e, '2000-0-0 00:00:00', '', 1);
INSERT INTO `classrooms` (`id`, `name`, `members`, `can_students_post`) VALUES (NULL, 'class1', '{"teachers":["Admin"],"students":[]}', '1');
/*Comments*/
INSERT INTO `comments-class1` (`id`, `parent_id`, `author_id`, `content`, `date`) VALUES
(1, 0, 1, "i'm a comment", '2000-00-00 00:00:00')