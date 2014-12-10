-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 04. Nov 2014 um 23:40
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
-- Tabellenstruktur für Tabelle `languageDiploma`
--

CREATE TABLE IF NOT EXISTS `languageDiploma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `languageId` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `languageDiploma`
--

INSERT INTO `languageDiploma` (`id`, `languageId`, `name`) VALUES
(1, 1, 'first'),
(2, 1, 'advanced'),
(3, 3, 'Delf1'),
(4, 3, 'Delf2'),
(5, 2, 'Deutsch basic'),
(6, 2, 'Deutsch fortgeschritten'),
(7, 4, 'tschinggeli'),
(8, 4, 'italiono');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `languages`
--

INSERT INTO `languages` (`id`, `name`) VALUES
(1, 'Englisch'),
(2, 'Deutsch'),
(3, 'Franzoesisch'),
(4, 'Italienisch');

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
-- Tabellenstruktur für Tabelle `studentAddress`
--

CREATE TABLE IF NOT EXISTS `studentAddress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentId` int(11) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `streetno` varchar(10) DEFAULT NULL,
  `zip` varchar(8) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `studentAddress`
--

INSERT INTO `studentAddress` (`id`, `studentId`, `street`, `streetno`, `zip`, `city`) VALUES
(1, NULL, 's', 'n', 'z', 'c'),
(2, NULL, 's', 'n', 'z', 'c'),
(3, NULL, 's', 'n', 'z', 'c'),
(4, NULL, 's', 'n', 'z', 'c'),
(5, NULL, 's', 'n', 'z', 'c'),
(6, NULL, 's', 'n', 'z', 'c'),
(7, 26, 's', 'n', 'z', 'c'),
(8, 26, 's', 'n', 'z', 'c'),
(9, 26, 's', 'n', 'z', 'c');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` char(50) NOT NULL,
  `lastname` char(50) NOT NULL,
  `gender` int(11) DEFAULT NULL,
  `study` int(11) NOT NULL,
  `minor` int(11) DEFAULT NULL,
  `region` int(11) NOT NULL,
  `university` int(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `address` int(11) DEFAULT NULL,
  `telephone` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Daten für Tabelle `students`
--

INSERT INTO `students` (`id`, `firstname`, `lastname`, `gender`, `study`, `minor`, `region`, `university`, `email`, `password`, `address`, `telephone`) VALUES
(1, 'Lorena', 'Sutter', NULL, 1, NULL, 2, NULL, NULL, NULL, 0, ''),
(2, 'Margrith', 'Meier', NULL, 1, NULL, 1, NULL, NULL, NULL, 0, ''),
(3, 'Susanne', 'Lötscher', NULL, 2, NULL, 1, NULL, NULL, NULL, 0, ''),
(4, 'Fabienne', 'Kramer', NULL, 2, NULL, 2, NULL, NULL, NULL, 0, ''),
(5, 'Caroline', 'Fleischer', NULL, 2, NULL, 3, NULL, NULL, NULL, 0, ''),
(6, 'Corinne', 'Mettler', NULL, 3, NULL, 1, NULL, NULL, NULL, 0, ''),
(7, 'Corinne', 'Blocher', NULL, 3, NULL, 2, NULL, NULL, NULL, 0, ''),
(8, 'Martin', 'Fleischer', NULL, 3, NULL, 1, NULL, NULL, NULL, 0, ''),
(9, 'Claudio', 'Kramer', NULL, 1, NULL, 2, NULL, NULL, NULL, 0, ''),
(10, 'first', 'last', 0, 0, NULL, 0, NULL, '0', '0', NULL, 'tel'),
(26, 'a', 'b', 0, 1, 1, 0, 1, 'a@b.ch', 'pass', NULL, 't'),
(27, 'a', 'b', 0, 0, NULL, 0, NULL, 'a@b.ch', 'pass', NULL, 't');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `study`
--

CREATE TABLE IF NOT EXISTS `study` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `study`
--

INSERT INTO `study` (`id`, `name`) VALUES
(1, 'Informatik'),
(2, 'Psychologie'),
(3, 'Wirtschaft'),
(4, 'Journalismus');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `universities`
--

CREATE TABLE IF NOT EXISTS `universities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `universities`
--

INSERT INTO `universities` (`id`, `name`) VALUES
(1, 'ZHAW'),
(2, 'ETH'),
(3, 'Uni ZH'),
(4, 'Uni Fribourg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
