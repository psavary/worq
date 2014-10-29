-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 29. Okt 2014 um 23:53
-- Server Version: 5.6.16
-- PHP-Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `worq`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `region`
--

INSERT INTO `region` (`id`, `region`) VALUES
(1, 'Ostschweiz'),
(2, 'Westschweiz'),
(3, 'Zentralschweiz'),
(4, 'Tessin'),
(5, 'Wallis');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` char(50) NOT NULL,
  `lastname` char(50) NOT NULL,
  `study` int(11) NOT NULL,
  `region` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `students`
--

INSERT INTO `students` (`id`, `firstname`, `lastname`, `study`, `region`) VALUES
(1, 'Lorena', 'Sutter', 1, 2),
(2, 'Margrith', 'Meier', 1, 1),
(3, 'Susanne', 'Lötscher', 2, 1),
(4, 'Fabienne', 'Kramer', 2, 2),
(5, 'Caroline', 'Fleischer', 2, 3),
(6, 'Corinne', 'Mettler', 3, 1),
(7, 'Corinne', 'Blocher', 3, 2),
(8, 'Martin', 'Fleischer', 3, 1),
(9, 'Claudio', 'Kramer', 1, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `study`
--

CREATE TABLE IF NOT EXISTS `study` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `study` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `study`
--

INSERT INTO `study` (`id`, `study`) VALUES
(1, 'Informatik'),
(2, 'Psychologie'),
(3, 'Wirtschaft'),
(4, 'Journalismus');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
