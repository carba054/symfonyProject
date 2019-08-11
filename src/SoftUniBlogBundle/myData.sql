-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.40-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table symfony_opit.heroes
CREATE TABLE IF NOT EXISTS `heroes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateAdded` datetime NOT NULL,
  `viewCount` int(11) NOT NULL DEFAULT '0',
  `ownerId` int(11) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `strength` int(11) NOT NULL DEFAULT '20',
  `agility` int(11) NOT NULL DEFAULT '20',
  `intelligence` int(11) NOT NULL DEFAULT '20',
  `luck` int(11) NOT NULL DEFAULT '20',
  `weapon` int(11) DEFAULT NULL,
  `shield` int(11) DEFAULT NULL,
  `money` int(11) NOT NULL DEFAULT '500',
  `wins` int(11) NOT NULL DEFAULT '0',
  `losses` int(11) NOT NULL DEFAULT '0',
  `draws` int(11) NOT NULL DEFAULT '0',
  `typeId` int(11) DEFAULT NULL,
  `experience` int(11) NOT NULL DEFAULT '100',
  `maxHealth` int(11) NOT NULL DEFAULT '100',
  `currentHealth` int(11) NOT NULL DEFAULT '100',
  `dmg` int(11) NOT NULL,
  `armor` decimal(10,0) NOT NULL,
  `miss` decimal(10,0) NOT NULL,
  `bonusMoney` decimal(10,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_578C8FC7E05EFD25` (`ownerId`),
  KEY `IDX_578C8FC79BF49490` (`typeId`),
  CONSTRAINT `FK_578C8FC79BF49490` FOREIGN KEY (`typeId`) REFERENCES `types` (`id`),
  CONSTRAINT `FK_578C8FC7E05EFD25` FOREIGN KEY (`ownerId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table symfony_opit.heroes: ~2 rows (approximately)
/*!40000 ALTER TABLE `heroes` DISABLE KEYS */;
INSERT INTO `heroes` (`id`, `name`, `dateAdded`, `viewCount`, `ownerId`, `level`, `strength`, `agility`, `intelligence`, `luck`, `weapon`, `shield`, `money`, `wins`, `losses`, `draws`, `typeId`, `experience`, `maxHealth`, `currentHealth`, `dmg`, `armor`, `miss`, `bonusMoney`) VALUES
	(55, '3', '2019-08-10 18:39:41', 1, 20, 2, 20, 20, 20, 20, NULL, NULL, 609, 4, 2, 14, 1, 217, 100, 31, 8, 10, 2, 4),
	(56, 'asdasf', '2019-08-11 00:26:00', 2, 25, 1, 20, 20, 20, 20, NULL, NULL, 500, 0, 0, 0, 2, 100, 100, 100, 8, 10, 2, 4),
	(57, 'asdasd', '2019-08-11 00:54:42', 0, 19, 1, 20, 20, 20, 20, NULL, NULL, 500, 0, 0, 0, 2, 100, 100, 100, 8, 10, 2, 4);
/*!40000 ALTER TABLE `heroes` ENABLE KEYS */;

-- Dumping structure for table symfony_opit.heroes_magics
CREATE TABLE IF NOT EXISTS `heroes_magics` (
  `hero_id` int(11) NOT NULL,
  `magic_id` int(11) NOT NULL,
  PRIMARY KEY (`hero_id`,`magic_id`),
  KEY `IDX_FA724E2E45B0BCD` (`hero_id`),
  KEY `IDX_FA724E2E324D4343` (`magic_id`),
  CONSTRAINT `FK_FA724E2E324D4343` FOREIGN KEY (`magic_id`) REFERENCES `magics` (`id`),
  CONSTRAINT `FK_FA724E2E45B0BCD` FOREIGN KEY (`hero_id`) REFERENCES `heroes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table symfony_opit.heroes_magics: ~2 rows (approximately)
/*!40000 ALTER TABLE `heroes_magics` DISABLE KEYS */;
INSERT INTO `heroes_magics` (`hero_id`, `magic_id`) VALUES
	(55, 1),
	(55, 2),
	(56, 3),
	(57, 4);
/*!40000 ALTER TABLE `heroes_magics` ENABLE KEYS */;

-- Dumping structure for table symfony_opit.magics
CREATE TABLE IF NOT EXISTS `magics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dmg` int(11) NOT NULL,
  `percentChance` int(11) NOT NULL,
  `armor` int(11) NOT NULL,
  `dodge` int(11) NOT NULL,
  `heal` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `critical` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C7D1C42DBBC2C8AC` (`img`),
  UNIQUE KEY `UNIQ_C7D1C42D5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table symfony_opit.magics: ~6 rows (approximately)
/*!40000 ALTER TABLE `magics` DISABLE KEYS */;
INSERT INTO `magics` (`id`, `img`, `dmg`, `percentChance`, `armor`, `dodge`, `heal`, `name`, `critical`, `description`, `type`) VALUES
	(1, 'https://cdn.datdota.com/images/ability/phantom_assassin_coup_de_grace.png', 5, 10, 0, 0, 0, 'critical strike', 20, '', 1),
	(2, 'https://gamepedia.cursecdn.com/dota2_gamepedia/5/58/Healing_Ward_icon.png?version=3af1336a77e1d418e556462a2922987d', 0, 10, 0, 0, 5, 'heals totem', 0, '', 0),
	(3, 'https://gamepedia.cursecdn.com/dota2_gamepedia/8/8a/Bristleback_ability_icon.png?version=00f4a50dc9b838f152af100020cbd355', 7, 15, 0, 0, 0, 'DMG bonus', 0, '', 1),
	(4, 'https://gamepedia.cursecdn.com/dota2_gamepedia/d/db/Fate%27s_Edict_icon.png?version=888d6ae0c84d05403c2a1bc729b549aa', 0, 10, 5, 0, 0, 'armor ability', 0, '', 0),
	(5, 'https://ru.dotabuff.com/assets/skills/keeper-of-the-light-blinding-light-5476-a74b74a31ef87e3a3b2209d847d3cd7cabbfe2dfe3ef7ca404f0dd0bc004e641.jpg', 0, 10, 0, 15, 0, 'miss chance', 0, '', 0),
	(6, 'https://gamepedia.cursecdn.com/dota2_gamepedia/a/ae/Last_Word_icon.png', 10, 10, 0, 0, 0, 'Crit', 15, '', 1);
/*!40000 ALTER TABLE `magics` ENABLE KEYS */;

-- Dumping structure for table symfony_opit.reports
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `round1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attackerId` int(11) DEFAULT NULL,
  `defenderId` int(11) DEFAULT NULL,
  `round2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `round3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `round4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `round5` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `round6` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `round7` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `winner` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F11FA74525509C70` (`attackerId`),
  KEY `IDX_F11FA7458CDD974C` (`defenderId`),
  CONSTRAINT `FK_F11FA74525509C70` FOREIGN KEY (`attackerId`) REFERENCES `heroes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_F11FA7458CDD974C` FOREIGN KEY (`defenderId`) REFERENCES `heroes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table symfony_opit.reports: ~0 rows (approximately)
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;

-- Dumping structure for table symfony_opit.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B63E2EC75E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table symfony_opit.roles: ~2 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`) VALUES
	(2, 'ROLE_ADMIN'),
	(1, 'ROLE_USER');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table symfony_opit.types
CREATE TABLE IF NOT EXISTS `types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_593089305E237E06` (`name`),
  UNIQUE KEY `UNIQ_59308930BBC2C8AC` (`img`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table symfony_opit.types: ~2 rows (approximately)
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` (`id`, `name`, `img`) VALUES
	(1, 'strenght', 'https://dotawallpaper.org/wp-content/uploads/2016/03/Centaur%20Hero%20Dota%202.jpg'),
	(2, 'agility', 'https://i.pinimg.com/originals/ca/2a/5a/ca2a5adb2258c7a7a13240dd0df10ad3.jpg'),
	(3, 'intelligence', 'https://steemitimages.com/640x0/http://www.wallpapers13.com/wp-content/uploads/2017/07/Invoker-magic-fighter-flame-Dota-2-Video-Game-Desktop-Wallpaper-download-free-1920x1080-1366x768.jpg');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;

-- Dumping structure for table symfony_opit.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hero_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`),
  UNIQUE KEY `UNIQ_1483A5E945B0BCD` (`hero_id`),
  CONSTRAINT `FK_1483A5E945B0BCD` FOREIGN KEY (`hero_id`) REFERENCES `heroes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table symfony_opit.users: ~16 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `password`, `fullName`, `hero_id`) VALUES
	(1, '1@abv', '$2y$10$lvd8hTIpiwwrgME/P5MuVO6g8sVWSYFs7oeWsSSOwyQUMoQ9eK6Tu', 'Admina', NULL),
	(19, '2@abv.bg', '$2y$10$S0TRHCrtl5CgZi8eYczecunZ2Sp1msm4JxuDZkjw8uZlMZSYBLr..', 'vtoriq user', 57),
	(20, '3@abv.bg', '$2y$10$CmBpvOIFs7HXrMFUgx4ZhOOUPEwVA4UGApmBhfu8YNKbEvuydJZ8K', 'tretiq user', 55),
	(21, '4@abv.bg', '$2y$10$LdBpGdbrUyL/kNhrTSDWB..sWP3Rx9FoH1X55gP9NpWmP3m3uuhMu', '4etvurtiq user', NULL),
	(22, '5@abv.bg', '$2y$10$dpZY3HisSlGD/tvfN18hjOfmTwVX0qUm8AXODTwcB3PC/6n5nMlhm', 'petiq user', NULL),
	(23, '6@abv.bg', '$2y$10$JmVw9r.ECltd8qGeKDgV.uIhoiiuyMV5A8jfFYpWdGYg6dxtvDSva', 'shestiq user', NULL),
	(24, '7@mail.bg', '$2y$10$0u9puqsDh0mo3MU.OLXecOpkNIm4zAptOihdH07n/B6IImax/ET42', 'sedmiq user', NULL),
	(25, '8@abv.bg', '$2y$10$8tJtDDkbU/IBpqBoI9Hhx..SVM9qaMkdFXmAZp83/HeVQRb3Zd/im', 'osmiq user', 56);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table symfony_opit.users_roles
CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_51498A8EA76ED395` (`user_id`),
  KEY `IDX_51498A8ED60322AC` (`role_id`),
  CONSTRAINT `FK_51498A8EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_51498A8ED60322AC` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table symfony_opit.users_roles: ~8 rows (approximately)
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES
	(1, 2),
	(19, 1),
	(20, 1),
	(21, 1),
	(22, 1),
	(23, 1),
	(24, 1),
	(25, 1);
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
