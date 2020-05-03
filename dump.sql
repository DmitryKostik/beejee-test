-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table test_project.session
CREATE TABLE IF NOT EXISTS `session` (
  `id` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user_id` int(11) DEFAULT NULL,
  `expire` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table test_project.session: ~3 rows (approximately)
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` (`id`, `user_id`, `expire`) VALUES
	('8n0oohfaqaq8c8u9m55cj7ju49', 32, 1587251935),
	('9vp2dvdl3787l7l4p3brpqp4f9', NULL, 1588549313),
	('e7efka9e9n4s3t5a5l3grakoa1', NULL, 1587231492);
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

-- Dumping structure for table test_project.task
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) COLLATE utf8_bin NOT NULL,
  `username` varchar(250) COLLATE utf8_bin NOT NULL,
  `task` varchar(500) COLLATE utf8_bin NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_edited` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table test_project.task: ~4 rows (approximately)
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` (`id`, `email`, `username`, `task`, `is_active`, `is_edited`) VALUES
	(25, 'ironeman1@yandex.ru', 'd.kostik', 'Выполнить тестовое задание 23', 1, 1),
	(26, 'test@test.com', 'test2', 'test job', 1, 0),
	(27, 'test@test.com', 'test1', '<script>alert(\'test\');</script>s', 1, 1),
	(29, 'ironeman@yandex.ru1', 'admin', 'ww', 0, 0);
/*!40000 ALTER TABLE `task` ENABLE KEYS */;

-- Dumping structure for table test_project.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password_hash` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table test_project.user: ~1 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password_hash`) VALUES
	(2, 'admin', '$2y$15$x7WoaKDz/kVUlhExVXJo4ufDR..uVRXbLlVUIj8BvIRGcyhf35Dtm');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
