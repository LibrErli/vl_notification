-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 01. April 2016 um 15:33
-- Server Version: 5.1.66
-- PHP-Version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `TUW`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vl_journal`
--

CREATE TABLE IF NOT EXISTS `vl_journal` (
  `vl_journal` varchar(5) NOT NULL,
  `journal_name` varchar(255) NOT NULL,
  `journal_mail` varchar(255) NOT NULL,
  `journal_pass` varchar(50) NOT NULL,
  PRIMARY KEY (`vl_journal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vl_notification_mails`
--

CREATE TABLE IF NOT EXISTS `vl_notification_mails` (
  `vl_mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `vl_journal` varchar(10) NOT NULL,
  `mail` text NOT NULL,
  `subject` varchar(255) NOT NULL,
  `datum` datetime NOT NULL,
  PRIMARY KEY (`vl_mail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vl_notific_maildata`
--

CREATE TABLE IF NOT EXISTS `vl_notific_maildata` (
  `vl_notific_maildata_id` int(11) NOT NULL AUTO_INCREMENT,
  `vl_journal` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `vorname` char(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  PRIMARY KEY (`vl_notific_maildata_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vl_wiki`
--

CREATE TABLE IF NOT EXISTS `vl_wiki` (
  `vl_wiki_id` int(11) NOT NULL AUTO_INCREMENT,
  `vl_wiki` varchar(255) NOT NULL,
  `vl_wiki_journal` varchar(10) NOT NULL,
  `vl_wiki_html` text NOT NULL,
  `vl_wiki_lang` varchar(10) NOT NULL,
  PRIMARY KEY (`vl_wiki_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;
