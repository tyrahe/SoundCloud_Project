CREATE DATABASE myDB;

USE myDB;
CREATE TABLE `TEST2` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `existence` tinyint(1) NOT NULL DEFAULT '0',
  `track1` int(11) NOT NULL DEFAULT '0',
  `track2` int(11) NOT NULL DEFAULT '0',
  `track3` int(11) NOT NULL DEFAULT '0',
  `track4` int(11) NOT NULL DEFAULT '0',
  `track5` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
)