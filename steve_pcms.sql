-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 09, 2014 at 08:18 PM
-- Server version: 5.1.61
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `steve_pcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `oc_config`
--

CREATE TABLE IF NOT EXISTS `oc_config` (
  `page_moduleComponentId` int(11) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oc_config`
--

INSERT INTO `oc_config` (`page_moduleComponentId`, `key`, `value`) VALUES
(1, 'Extra', 'Yes'),
(1, 'food_coupon', 'Yes'),
(1, 'L', 'Yes'),
(1, 'M', 'Yes'),
(1, 'S', 'Yes'),
(1, 'XL', 'No'),
(1, 'XXL', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `oc_form_reg`
--

CREATE TABLE IF NOT EXISTS `oc_form_reg` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `page_moduleComponentId` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` text NOT NULL,
  `amount` int(11) NOT NULL,
  `Tshirt_size` text NOT NULL,
  `updated_time` datetime NOT NULL,
  `oc_tshirt_distributed` enum('Yes','No') NOT NULL DEFAULT 'No',
  `oc_food_coupon_distributed` enum('Yes','No') NOT NULL DEFAULT 'No',
  `oc_extra_distributed` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `oc_form_reg`
--

INSERT INTO `oc_form_reg` (`Id`, `page_moduleComponentId`, `user_id`, `name`, `amount`, `Tshirt_size`, `updated_time`, `oc_tshirt_distributed`, `oc_food_coupon_distributed`, `oc_extra_distributed`) VALUES
(1, 1, '9', 'Shrirm', 500, 'S', '2013-12-28 16:49:56', 'No', 'Yes', 'No'),
(6, 1, '13', 'Deepak', 700, 'S', '2013-12-30 13:11:14', 'No', 'No', 'No'),
(7, 1, '14', 'Kathambari', 700, 'L', '2013-12-30 13:12:10', 'No', 'No', 'No'),
(10, 1, '12', 'SomNath AmEr', 700, 'L', '2013-12-30 13:37:16', 'No', 'No', 'No'),
(12, 1, '11', 'sarangan', 700, 'L', '2014-01-08 12:38:50', 'Yes', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `oc_valid_emails`
--

CREATE TABLE IF NOT EXISTS `oc_valid_emails` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `page_moduleComponentId` int(11) NOT NULL,
  `oc_name` text NOT NULL,
  `oc_valid_email` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `oc_valid_email` (`oc_valid_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `oc_valid_emails`
--

INSERT INTO `oc_valid_emails` (`Id`, `page_moduleComponentId`, `oc_name`, `oc_valid_email`) VALUES
(5, 1, 'Sarangan', '114110099@nitt.edu'),
(6, 1, 'Shriram', '106110100@nitt.edu'),
(7, 1, 'jonny', '102110023@nitt.edu'),
(8, 1, 'Gowtham', '102110063@nitt.edu');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
