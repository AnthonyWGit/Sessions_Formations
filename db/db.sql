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


-- Listage de la structure de la base pour elansessions
CREATE DATABASE IF NOT EXISTS `elansessions` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `elansessions`;

-- Listage de la structure de table elansessions. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table elansessions.categorie : ~5 rows (environ)
INSERT INTO `categorie` (`id`, `nom_categorie`) VALUES
	(1, 'Lifestyle'),
	(2, 'DéveloppementEdit'),
	(3, 'Langues'),
	(4, 'Sport'),
	(7, 'Politique'),
	(9, 'SomeCAT');

-- Listage de la structure de table elansessions. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table elansessions.doctrine_migration_versions : ~0 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230921113828', '2023-09-21 11:38:48', 496);

-- Listage de la structure de table elansessions. formateur
CREATE TABLE IF NOT EXISTS `formateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table elansessions.formateur : ~3 rows (environ)
INSERT INTO `formateur` (`id`, `nom`, `prenom`, `password`, `email`) VALUES
	(1, 'Puissant', 'Formateur', 'somepswd', 'email@email.fr'),
	(2, 'Incroyable', 'Formatrice', 'somepwd', 'mail@orange.fr'),
	(3, 'Médiocre', 'Enseignant', 'somepwd', 'mail@aol.com');

-- Listage de la structure de table elansessions. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intitule` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table elansessions.formation : ~3 rows (environ)
INSERT INTO `formation` (`id`, `intitule`) VALUES
	(1, 'Formation dev'),
	(2, 'Formation cuisine'),
	(3, 'Formation politicien');

-- Listage de la structure de table elansessions. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table elansessions.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table elansessions. module_session
CREATE TABLE IF NOT EXISTS `module_session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int DEFAULT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7B3FEBCDBCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_7B3FEBCDBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table elansessions.module_session : ~9 rows (environ)
INSERT INTO `module_session` (`id`, `categorie_id`, `nom`) VALUES
	(1, 3, 'Français'),
	(2, 3, 'Italien'),
	(3, 1, 'Instagram'),
	(4, 2, 'PHP'),
	(5, 2, 'Python'),
	(6, 2, 'Fortran'),
	(10, 4, 'Some moduleY'),
	(13, 7, 'Administration des territoires'),
	(15, 9, 'PROREDELEY'),
	(16, 2, 'Proba');

-- Listage de la structure de table elansessions. programme
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` int DEFAULT NULL,
  `module_session_id` int DEFAULT NULL,
  `nbjours` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DDCB9FF613FECDF` (`session_id`),
  KEY `IDX_3DDCB9FFF4DAC742` (`module_session_id`),
  CONSTRAINT `FK_3DDCB9FF613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_3DDCB9FFF4DAC742` FOREIGN KEY (`module_session_id`) REFERENCES `module_session` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table elansessions.programme : ~4 rows (environ)
INSERT INTO `programme` (`id`, `session_id`, `module_session_id`, `nbjours`) VALUES
	(1, 2, 1, 608),
	(3, 3, 6, 55),
	(11, 3, 4, 12),
	(12, 3, 16, 35);

-- Listage de la structure de table elansessions. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `formation_id` int DEFAULT NULL,
  `formateur_id` int DEFAULT NULL,
  `titre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_session_debut` date NOT NULL,
  `date_session_fin` date NOT NULL,
  `places` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D45200282E` (`formation_id`),
  KEY `IDX_D044D5D4155D8F51` (`formateur_id`),
  CONSTRAINT `FK_D044D5D4155D8F51` FOREIGN KEY (`formateur_id`) REFERENCES `formateur` (`id`),
  CONSTRAINT `FK_D044D5D45200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table elansessions.session : ~4 rows (environ)
INSERT INTO `session` (`id`, `formation_id`, `formateur_id`, `titre`, `date_session_debut`, `date_session_fin`, `places`) VALUES
	(1, 1, 3, 'Session de printemps', '2023-03-21', '2023-06-21', 20),
	(2, 2, 2, 'Session d\'été', '2023-06-22', '2023-09-25', 30),
	(3, 2, 1, 'Session d\'automne', '2023-09-23', '2023-12-21', 30),
	(4, 1, 1, 'Session d\'hiver', '2023-11-01', '2024-02-21', 30);

-- Listage de la structure de table elansessions. stagiaire
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_de_naissance` date NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table elansessions.stagiaire : ~9 rows (environ)
INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `date_de_naissance`, `email`) VALUES
	(1, 'Stqaire', 'Jean', '1990-01-01', 'jean@mail.fr'),
	(3, 'Ghe', 'Indira', '1992-03-22', 'ghe@mail.fr'),
	(4, 'Herbet', 'Hercé', '2013-09-22', 'hhverc@gmailcom'),
	(5, 'Bilboa', 'Stagiaire', '2024-09-10', 'bilbod@gmail.com'),
	(6, 'BTP', 'Course', '2019-04-06', 'Coursed@op.fr'),
	(7, 'Testy', 'Testy', '1972-07-10', 'Testal@gmail.com'),
	(8, 'Kolr', 'Harvard', '1980-12-05', 'hharvard@gmail.com'),
	(9, 'Nouveau stagiaire', 'Celine', '1994-02-15', 'celine.buisson@gmail.com'),
	(10, 'Ceciet', 'Mor', '1895-04-12', 'mor@gy.fr'),
	(12, 'Hedetet', 'Ho', '1996-03-15', 'edit@lop.fr'),
	(13, 'MAMEaopdeap', 'zfekfef', '1995-01-01', 'zrfze@fze.fr');

-- Listage de la structure de table elansessions. stagiaire_session
CREATE TABLE IF NOT EXISTS `stagiaire_session` (
  `stagiaire_id` int NOT NULL,
  `session_id` int NOT NULL,
  PRIMARY KEY (`stagiaire_id`,`session_id`),
  KEY `IDX_D32D02D4BBA93DD6` (`stagiaire_id`),
  KEY `IDX_D32D02D4613FECDF` (`session_id`),
  CONSTRAINT `FK_D32D02D4613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D32D02D4BBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table elansessions.stagiaire_session : ~12 rows (environ)
INSERT INTO `stagiaire_session` (`stagiaire_id`, `session_id`) VALUES
	(3, 3),
	(4, 3),
	(5, 2),
	(5, 3),
	(6, 2),
	(7, 2),
	(8, 2),
	(9, 4),
	(10, 4),
	(12, 3),
	(12, 4),
	(13, 3);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
