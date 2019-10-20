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
	`session` varchar(255) NOT NULL,
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
	`title` varchar(255) NOT NULL,
	`content` blob NOT NULL,
	`date` date NOT NULL,
	`ip` char(25) NOT NULL,
	`author` char(20) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `id` (`id`),
	KEY `id_2` (`id`)
) COMMENT='Posts for class1';

/*Admin record*/
INSERT INTO `users` 
		(`id`, `role`, `username`, `name`, `email`, `password`, `ip`) 
	VALUES 
		('1', 'administrator', 'Admin', 'Administrator', 'test@test.com', PASSWORD('Administrator'), '');

/*Post for classroom 1*/
INSERT INTO `class1` (`id`, `title`, `content`, `date`, `ip`, `author`) VALUES(0, 'Errore', 0x51756573746120706167696e61206e6f6e20636f6e7469656e65206e756c6c61206d692064697370696163652e2e2e20506f73746120706572207072696d6f212056697375616c697a7a61206c6120677569646120e29e9c203c6120687265663d222e2e2f61646d696e2f67756964652e706870223e7064663c2f613e, '2000-1-1', '', 'Admin');
INSERT INTO `classrooms` (`id`, `name`, `members`, `can_students_post`) VALUES (NULL, 'class1', '{"teachers":["Admin"],"students":[]}', '1');";
