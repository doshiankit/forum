-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2017 at 08:11 PM
-- Server version: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-Customer,1-Administrator',
  `creation_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0-Active,1-Inactive',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-Not Delete, 1- Deleted',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `first_name`, `last_name`, `password`, `email`, `type`, `creation_date`, `status`, `deleted`) VALUES
(1, 'admin', 'ankit', 'doshi', 'drwcmIaIlzzUaQ9PwgOGRn2KcKmSq44tWvKGgHfkpl0', 'ankitdoshi2011@gmail.com', -1, '2017-01-01', 0, 0),
(11, 'anki', 'ankit ', 'doshi', 'EEqQLyjDjfDI1c7Y6GBcKcKdbTsGyW0mGNTaoOY1F8M', 'ankitdoshi2011@gmail.com', 0, '2017-01-28', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
  `thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`thread_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`thread_id`, `account_id`, `subject`, `creation_date`, `last_modified_date`) VALUES
(16, 1, '23432', '2017-01-28 19:36:35', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `thread_details`
--

CREATE TABLE IF NOT EXISTS `thread_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `thread_details` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `thread_details`
--

INSERT INTO `thread_details` (`id`, `thread_id`, `account_id`, `thread_details`, `creation_date`, `last_modified_date`) VALUES
(18, 16, 1, 'qasdsada', '2017-01-28 19:36:35', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
