-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              5.6.14-log - MySQL Community Server (GPL)
-- S.O. server:                  Win32
-- HeidiSQL Versione:            9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dump della struttura di tabella kalories_motork.daily_goal
CREATE TABLE IF NOT EXISTS `daily_goal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `number_of_calories` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_key_user_goal_date` (`user_id`,`date`),
  CONSTRAINT `FK_daily_goal_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella kalories_motork.daily_goal: ~4 rows (circa)
/*!40000 ALTER TABLE `daily_goal` DISABLE KEYS */;
INSERT INTO `daily_goal` (`id`, `user_id`, `date`, `number_of_calories`) VALUES
	(1, 2, '2017-03-03', 160),
	(2, 2, '2017-03-04', 500),
	(3, 2, '2017-03-05', 123),
	(4, 2, '2017-03-06', 6000);
/*!40000 ALTER TABLE `daily_goal` ENABLE KEYS */;


-- Dump della struttura di tabella kalories_motork.meals
CREATE TABLE IF NOT EXISTS `meals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time DEFAULT NULL,
  `text` varchar(50) DEFAULT NULL,
  `number_of_calories` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_meals_user` (`user_id`),
  CONSTRAINT `FK_meals_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella kalories_motork.meals: ~12 rows (circa)
/*!40000 ALTER TABLE `meals` DISABLE KEYS */;
INSERT INTO `meals` (`id`, `user_id`, `date`, `time`, `text`, `number_of_calories`) VALUES
	(1, 2, '2017-03-02', '23:34:00', 'Nut', 590),
	(2, 2, '2017-03-02', '10:11:00', 'Dark Chocolate', 598),
	(3, 2, '2017-03-09', '16:54:00', 'Avocado', 160),
	(4, 2, '2017-03-03', '01:22:00', 'Beef', 902),
	(5, 2, '2017-03-03', '02:18:00', 'Milk', 452),
	(6, 2, '2017-03-03', '06:09:00', 'Fish', 262),
	(7, 2, '2017-03-03', '07:43:00', 'Meat', 358),
	(8, 2, '2017-02-28', '11:32:00', 'Banana', 89),
	(9, 2, '2017-02-24', '12:59:00', 'Beer', 144),
	(10, 2, '2017-03-06', '17:32:00', 'Red Wine', 91),
	(11, 2, '2017-03-03', '18:45:00', 'White Wine', 86),
	(14, 2, '2017-03-03', '23:03:00', 'test', 123);
/*!40000 ALTER TABLE `meals` ENABLE KEYS */;


-- Dump della struttura di tabella kalories_motork.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_superadmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- Dump dei dati della tabella kalories_motork.user: ~3 rows (circa)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `active`, `login`, `password`, `is_superadmin`) VALUES
	(1, 1, 'admin', '7eea35b402bd0b2d301be479e769c02b', 1),
	(2, 1, 'user1', 'bbfb4b2e2bb05c9f2dbca635ecd1582e', 0),
	(3, 1, 'user2', 'a1be3bcea3d2a85ee4bbb89137046160', 0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
