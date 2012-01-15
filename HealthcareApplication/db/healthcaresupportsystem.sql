-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 02, 2010 at 04:36 PM
-- Server version: 5.1.50
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `healthcaresupportsystem`
--
DROP DATABASE IF EXISTS `healthcaresupportsystem`;
CREATE DATABASE `healthcaresupportsystem` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `healthcaresupportsystem`;
-- --------------------------------------------------------

--
-- Table structure for table `discussion`
--

CREATE TABLE IF NOT EXISTS `discussion` (
  `discussionId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `discussionSubject` tinytext NOT NULL,
  `discussionContent` text NOT NULL,
  `dateTime` datetime NOT NULL,
  `recordId` int(10) unsigned NOT NULL,
  `postedBy` int(10) unsigned NOT NULL,
  `postedTo` int(10) unsigned NOT NULL,
  `isViewed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`discussionId`),
  KEY `recordId` (`recordId`),
  KEY `postedBy` (`postedBy`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `discussion`
--


-- --------------------------------------------------------

--
-- Table structure for table `medicalrecord`
--

CREATE TABLE IF NOT EXISTS `medicalrecord` (
  `recordId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `personId` int(10) unsigned NOT NULL,
  `dateTime` datetime NOT NULL,
  `temperature` float NOT NULL,
  PRIMARY KEY (`recordId`),
  KEY `personId` (`personId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2889 ;

--
-- Dumping data for table `medicalrecord`
--


-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `personId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `docId` int(10) unsigned DEFAULT NULL,
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `mobileNumber` varchar(20) NOT NULL,
  `emailAddress` varchar(80) NOT NULL,
  `street` varchar(40) NOT NULL,
  `suburb` varchar(40) NOT NULL,
  `city` varchar(40) NOT NULL,
  `state` varchar(40) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `personType` enum('p','d','a') NOT NULL,
  `password` varchar(32) NOT NULL,
  `dob` datetime NOT NULL,
  `sex` enum('m','f') NOT NULL,
  `accepted` enum('a','r','n') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`personId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`personId`, `docId`, `firstName`, `lastName`, `phoneNumber`, `mobileNumber`, `emailAddress`, `street`, `suburb`, `city`, `state`, `postcode`, `personType`, `password`, `dob`, `sex`, `accepted`) VALUES
(32, NULL, 'Administrator', '', '', '', 'admin@hss.com', '', '', '', '', '', 'a', '21232f297a57a5a743894a0e4a801fc3', '2010-12-02 16:32:13', 'm', 'n');
