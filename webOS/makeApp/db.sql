-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: 10.0.23.22
-- Generation Time: Aug 14, 2010 at 10:00 PM
-- Server version: 5.1.45
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `repo`
--

-- --------------------------------------------------------

--
-- Table structure for table `opt`
--

CREATE TABLE IF NOT EXISTS `opt` (
  `opt` varchar(25) NOT NULL,
  `val` varchar(768) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pkgs`
--

CREATE TABLE IF NOT EXISTS `pkgs` (
  `appid` varchar(255) NOT NULL,
  `ver` varchar(10) NOT NULL,
  `section` varchar(40) NOT NULL,
  `arch` varchar(5) NOT NULL,
  `maintainer` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  `title` varchar(25) NOT NULL,
  `icon` varchar(14) NOT NULL,
  `path` varchar(255) NOT NULL,
  `pathto` varchar(255) NOT NULL,
  `support` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `opt` (`opt`, `val`) VALUES
('support', 'http://supporturl/;;;support@email.com;;;support email subject OR #{-appName} to replace with app name'),
('supportResource', 'web;;;Link Name;;;http://link.url/');
