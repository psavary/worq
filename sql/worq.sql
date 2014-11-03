-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 03. Nov 2014 um 08:39
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
-- Tabellenstruktur für Tabelle `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(100) DEFAULT NULL,
  `streetno` varchar(10) DEFAULT NULL,
  `zip` varchar(8) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
-- Tabellenstruktur für Tabelle `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` char(50) NOT NULL,
  `lastname` char(50) NOT NULL,
  `gender` int(11) DEFAULT NULL,
  `study` int(11) NOT NULL,
  `region` int(11) NOT NULL,
  `university` int(11) DEFAULT NULL,
  `email` int(11) DEFAULT NULL,
  `password` int(11) DEFAULT NULL,
  `address` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `students`
--

INSERT INTO `students` (`id`, `firstname`, `lastname`, `gender`, `study`, `region`, `university`, `email`, `password`, `address`) VALUES
(1, 'Lorena', 'Sutter', NULL, 1, 2, NULL, NULL, NULL, 0),
(2, 'Margrith', 'Meier', NULL, 1, 1, NULL, NULL, NULL, 0),
(3, 'Susanne', 'Lötscher', NULL, 2, 1, NULL, NULL, NULL, 0),
(4, 'Fabienne', 'Kramer', NULL, 2, 2, NULL, NULL, NULL, 0),
(5, 'Caroline', 'Fleischer', NULL, 2, 3, NULL, NULL, NULL, 0),
(6, 'Corinne', 'Mettler', NULL, 3, 1, NULL, NULL, NULL, 0),
(7, 'Corinne', 'Blocher', NULL, 3, 2, NULL, NULL, NULL, 0),
(8, 'Martin', 'Fleischer', NULL, 3, 1, NULL, NULL, NULL, 0),
(9, 'Claudio', 'Kramer', NULL, 1, 2, NULL, NULL, NULL, 0);

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
