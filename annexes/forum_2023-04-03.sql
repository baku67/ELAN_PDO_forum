-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour basile_forum
CREATE DATABASE IF NOT EXISTS `basile_forum` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `basile_forum`;

-- Listage de la structure de table basile_forum. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table basile_forum.category : ~4 rows (environ)
DELETE FROM `category`;
INSERT INTO `category` (`id_category`, `name`) VALUES
	(1, 'Jeux'),
	(2, 'Actualités'),
	(3, 'Films'),
	(4, 'Politique'),
	(5, 'Test');

-- Listage de la structure de table basile_forum. liking_post
CREATE TABLE IF NOT EXISTS `liking_post` (
  `id_liking_post` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  PRIMARY KEY (`id_liking_post`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `FK__post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id_post`),
  CONSTRAINT `FK__user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table basile_forum.liking_post : ~15 rows (environ)
DELETE FROM `liking_post`;
INSERT INTO `liking_post` (`id_liking_post`, `user_id`, `post_id`) VALUES
	(39, 29, 55),
	(40, 30, 54),
	(41, 30, 53),
	(43, 29, 3),
	(48, 29, 50),
	(49, 29, 16),
	(51, 29, 51),
	(52, 29, 15),
	(54, 29, 49),
	(55, 30, 52),
	(56, 30, 51),
	(57, 29, 52),
	(58, 29, 2),
	(59, 29, 60),
	(60, 29, 61);

-- Listage de la structure de table basile_forum. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `text` text,
  `creationdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `topic_id` int DEFAULT NULL,
  PRIMARY KEY (`id_post`),
  KEY `user_id` (`user_id`),
  KEY `topic_id` (`topic_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table basile_forum.post : ~23 rows (environ)
DELETE FROM `post`;
INSERT INTO `post` (`id_post`, `text`, `creationdate`, `user_id`, `topic_id`) VALUES
	(1, 'Salut les amis, je m\'inquiète quant à l\'avancée fulgurante ', '2023-03-24 15:00:16', 1, 2),
	(2, 'Oui on va etre au chomage dans 2ans max, tout le monde, tout les métiers, c\'est la fin, ouin ouin', '2023-03-24 15:01:09', 2, 2),
	(3, 'testMessage', '2023-03-27 14:32:00', 1, 12),
	(4, 'testMsg', '2023-03-27 15:32:46', 1, 12),
	(5, 'test Msg2', '2023-03-27 15:33:29', 1, 12),
	(6, 'test 1 postMsg', '2023-03-27 15:33:42', 1, 11),
	(7, 'testRedirect', '2023-03-27 23:50:52', 1, 11),
	(8, 'testConntenu 1er message', '2023-03-27 23:52:17', 1, 13),
	(15, 'Test nouveau topic content firstMessage', '2023-03-28 01:18:42', 1, 16),
	(16, 'Replay After redirect ', '2023-03-28 01:18:53', 1, 16),
	(49, 'Aaa', '2023-03-29 04:17:46', 33, 33),
	(50, 'Re', '2023-03-29 04:20:34', 33, 33),
	(51, 'fisrtMessage', '2023-03-29 16:04:51', 29, 34),
	(52, 'test message 2 lik&eacute;', '2023-03-29 16:31:30', 29, 34),
	(53, 'retest', '2023-03-29 17:23:20', 29, 34),
	(54, 'Mon message ', '2023-03-29 20:15:17', 29, 34),
	(55, 'Test heure publish', '2023-03-29 20:26:15', 29, 33),
	(56, 'Hhhj', '2023-04-03 21:33:32', 29, 34),
	(57, 'Hhhj', '2023-04-03 21:33:33', 29, 34),
	(58, 'Hhj', '2023-04-03 21:33:51', 29, 34),
	(59, 'Jvh', '2023-04-03 21:33:58', 29, 34),
	(60, 'Jvh', '2023-04-03 21:33:59', 29, 34),
	(61, 'Jvh', '2023-04-03 21:33:59', 29, 34);

-- Listage de la structure de table basile_forum. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '',
  `status` tinyint NOT NULL DEFAULT '1',
  `creationdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `lastPostId` int DEFAULT NULL,
  `lastPostMsg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id_topic`),
  KEY `FK_topic_category` (`category_id`),
  KEY `FK_topic_users` (`user_id`),
  CONSTRAINT `FK_topic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_topic_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table basile_forum.topic : ~11 rows (environ)
DELETE FROM `topic`;
INSERT INTO `topic` (`id_topic`, `title`, `status`, `creationdate`, `user_id`, `category_id`, `lastPostId`, `lastPostMsg`) VALUES
	(2, 'Les médecins le détestent, la 11ème va vous surprendre', 0, '2023-03-27 09:01:35', 2, 4, NULL, 'fzefzef'),
	(3, 'ChatGPT écrit des articles sur ChatGPT', 1, '2023-03-27 10:30:36', 2, 2, NULL, 'fzefzef'),
	(4, 'ChatGPT: la fin des développeurs Le 15ème va vous surprendre', 1, '2023-03-27 11:02:38', 1, 2, NULL, 'fzefzef'),
	(9, 'testTitle', 1, '2023-03-27 14:19:59', 1, 3, NULL, 'fzefzef'),
	(10, 'testLastInsertedId Politique', 1, '2023-03-27 14:22:43', 1, 4, NULL, 'fzefzef'),
	(11, 'testRedirection', 1, '2023-03-27 14:23:37', 1, 4, NULL, 'fzefzef'),
	(12, 'testTitle', 1, '2023-03-27 14:32:00', 1, 1, NULL, 'fzefzef'),
	(13, 'Test Redirection after create', 1, '2023-03-27 23:52:17', 1, 1, NULL, 'fzefzef'),
	(16, 'Test nouveau topic title', 1, '2023-03-28 01:18:42', 1, 1, 16, 'fzefzef'),
	(33, 'Aaa', 1, '2023-03-29 04:17:46', 33, 1, 55, 'Test heure publish'),
	(34, 'Topic Basile', 1, '2023-03-29 16:04:51', 29, 2, 61, 'Jvh');

-- Listage de la structure de table basile_forum. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'ROLE_USER',
  `signInDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint DEFAULT '1',
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table basile_forum.user : ~7 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `role`, `signInDate`, `status`) VALUES
	(1, 'xX_DarkSasuke_Xx', '1234', 'darksasuke@gmail.com', 'ROLE_USER', '2023-03-24 14:52:16', 0),
	(2, 'Benoi', '1234', 'benoi.benoi@benoi.com', 'ROLE_ADMIN', '2023-03-24 15:01:28', 1),
	(29, 'basile', '$2y$10$xe3SygvizqOUoKAtbF7yD.wbsn054m/Vue1lfDtFS2mOnbrDGjKEO', 'basile08@hotmail.fr', 'ROLE_USER', '2023-03-28 09:05:25', 0),
	(30, 'user', '$2y$10$9iCPvfNrPLT4GOHdoYFG/ugRB.hC3QqjA9X7m5lel5lHzEdyAG.hS', 'user@user.fr', 'ROLE_USER', '2023-03-28 14:06:54', 1),
	(31, 'srgqsrg', '$2y$10$v7dODZuV2gPh.zqn4j4b3.xc.YmAI6ofv0hnd/vmzRfJD8wCz95ge', 'test@test.fr', 'ROLE_USER', '2023-03-29 02:53:09', 0),
	(32, 'testt', '$2y$10$nNStNJp3FF4Nt0gElSZY5.j4NT2cYQndAUGRkBEIP4qQKZ6BxgCju', 'testt@testt.fr', 'ROLE_USER', '2023-03-29 02:57:06', 0),
	(33, 'Aaa', '$2y$10$fr1lK0hG.xmOF2ur.qm8VuIBY3uk2pjYJbl19yJ6gTQK3cMJNysUi', 'Aaa@aaa.fr', 'ROLE_ADMIN', '2023-03-29 04:16:33', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
