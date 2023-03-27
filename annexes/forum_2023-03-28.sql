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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table basile_forum.category : ~4 rows (environ)
DELETE FROM `category`;
INSERT INTO `category` (`id_category`, `name`) VALUES
	(1, 'Jeux'),
	(2, 'Actualités'),
	(3, 'Films'),
	(4, 'Politique');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table basile_forum.post : ~2 rows (environ)
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
	(11, 'gsrgsr', '2023-03-28 00:00:32', 1, 13);

-- Listage de la structure de table basile_forum. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '',
  `status` tinyint NOT NULL DEFAULT '1',
  `creationdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `FK_topic_category` (`category_id`),
  KEY `FK_topic_users` (`user_id`),
  CONSTRAINT `FK_topic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_topic_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table basile_forum.topic : ~1 rows (environ)
DELETE FROM `topic`;
INSERT INTO `topic` (`id_topic`, `title`, `status`, `creationdate`, `user_id`, `category_id`) VALUES
	(2, 'Les médecins le détestent, la 11ème va vous surprendre', 1, '2023-03-27 09:01:35', 2, 4),
	(3, 'ChatGPT écrit des articles sur ChatGPT', 1, '2023-03-27 10:30:36', 2, 2),
	(4, 'ChatGPT: la fin des développeurs Le 15ème va vous surprendre', 1, '2023-03-27 11:02:38', 1, 2),
	(9, 'testTitle', 1, '2023-03-27 14:19:59', 1, 3),
	(10, 'testLastInsertedId Politique', 1, '2023-03-27 14:22:43', 1, 4),
	(11, 'testRedirection', 1, '2023-03-27 14:23:37', 1, 4),
	(12, 'testTitle', 0, '2023-03-27 14:32:00', 1, 1),
	(13, 'Test Redirection after create', 1, '2023-03-27 23:52:17', 1, 1);

-- Listage de la structure de table basile_forum. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'user',
  `signInDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint DEFAULT '1',
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table basile_forum.user : ~9 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `role`, `signInDate`, `status`) VALUES
	(1, 'xX_DarkSasuke_Xx', '1234', 'darksasuke@gmail.com', 'user', '2023-03-24 14:52:16', 1),
	(2, 'Benoi', '1234', 'benoi.benoi@benoi.com', 'user', '2023-03-24 15:01:28', 1),
	(22, 'basile', '$2y$10$uzQpMK8dcBIPWYyoaRu7R.X6/CXYhlDALvooVH0VndxTBb.ABxGna', 'basile08@hotmail.fr', 'user', '2023-03-27 23:27:11', 1),
	(23, 'dazdaz', '$2y$10$E7s.n7swOt.txp5BMEwVBugwWtjzxL83lr4QgKDjuyg0QnsxJEjlu', 'dazd@azdazd.fr', 'user', '2023-03-27 23:37:14', 1),
	(24, 'fezqfe', '$2y$10$x.uZJfxauf8tROVqEFXfiux5fMpuBs0Z9PTenEAZDd9vrtDsRoOSC', 'fzefzef@fzefz.fr', 'user', '2023-03-27 23:41:07', 1),
	(25, 'dadazdaz', '$2y$10$dOrEMuz3bczuzOj4Le34fepZLjg8.Peurfr0w3PBHIwfPA8EgOwb6', 'dazdazd@azdazd.fr', 'user', '2023-03-27 23:43:43', 1),
	(26, 'qgrqgre', '$2y$10$eJEX14JstMelHCJKsXFlVukhBs.RntrGcToN2hE4YgUvAwCLuO9.e', 'gqegezgq@qgef.fr', 'user', '2023-03-27 23:47:41', 1),
	(27, 'fzqfeqzef', '$2y$10$pzQjrj7D2nALUiYQCPSv2ePpQpEikNLab5U3XmnLbcRD77Wa.Tx1y', 'fqzefqzef', 'user', '2023-03-28 00:06:02', 1),
	(28, 'efqsef', '$2y$10$cksff4kNDtFa.3XcyqzXJ.xx.wmuuBPf9X8xN2OjweL0KJ28KF7ga', 'qefezsf@gdsg.fr', 'user', '2023-03-28 00:15:38', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
