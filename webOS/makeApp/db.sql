-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
--
-- Host: 10.0.23.22
-- Generation Time: Aug 14, 2010 at 02:14 PM
-- Server version: 5.1.45
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `repo`
--

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
  `pathto` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
