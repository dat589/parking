-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 21, 2023 at 01:01 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `level` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_name`, `username`, `password`, `email`, `level`) VALUES
(1, 'Văn Đạt', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'nguyenvandat4797@gmail.com', '0'),
(3, 'Tester', 'vandat', 'e10adc3949ba59abbe56e057f20f883e', 'tester10029@gmail.com', '0');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(50) NOT NULL,
  `number_plate` varchar(10) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `time` varchar(10) NOT NULL,
  `regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `parking_fee` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `owner`, `number_plate`, `mobile`, `time`, `regdate`, `parking_fee`) VALUES
(1, 'Văn Đạt', '34B99999', '0984696247', '2023-06', '2023-05-31 03:16:12', 1600000),
(2, 'Hoang Trung', '30G56789', '0984696123', '2023-06', '2023-06-02 09:23:02', 1600000),
(9, 'Thanh Xuan', '30A88888', '0123456789', '2023-06', '2023-05-29 23:44:59', 1600000),
(12, 'Hoang Trung', '30G56789', '0984696123', '2023-06', '2023-05-23 01:03:49', 1600000),
(18, 'Van Cao', '50D12345', '0987664535', '2023-07', '2023-06-03 01:39:47', 1600000),
(19, 'Hoang Trung', '30G56789', '0984696123', '2023-07', '2023-06-03 11:34:31', 1600000),
(20, 'Mai Huong', '29F43742', '0932738492', '2023-06', '2023-07-01 07:20:58', 4000000),
(21, 'Mai Huong', '29F43742', '0932738492', '2023-07', '2023-07-01 07:20:58', 0),
(22, 'Mai Huong', '29F43742', '0932738492', '2023-08', '2023-07-01 07:20:58', 0),
(23, 'Van Tien', '25E43265', '0894836736', '2023-08', '2023-07-01 07:34:50', 4000000),
(24, 'Van Tien', '25E43265', '0894836736', '2023-09', '2023-07-01 07:34:50', 0),
(25, 'Van Tien', '25E43265', '0894836736', '2023-07', '2023-07-01 07:34:50', 0),
(26, 'Văn Đạt', '34B99999', '0984696247', '2023-05', '2023-04-27 07:17:32', 1600000);

-- --------------------------------------------------------

--
-- Table structure for table `parking_fee`
--

DROP TABLE IF EXISTS `parking_fee`;
CREATE TABLE IF NOT EXISTS `parking_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t1` int(11) NOT NULL,
  `t2` int(11) NOT NULL,
  `t3` int(11) NOT NULL,
  `m1` int(11) NOT NULL,
  `m3` int(11) NOT NULL,
  `redate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parking_fee`
--

INSERT INTO `parking_fee` (`id`, `t1`, `t2`, `t3`, `m1`, `m3`, `redate`) VALUES
(1, 30000, 10000, 75000, 16000000, 4000000, '2023-06-29 02:33:27'),
(2, 20000, 8000, 65000, 15000000, 3800000, '2022-06-29 02:33:27'),
(3, 20000, 8000, 65000, 15000000, 3800000, '2023-06-30 17:00:00'),
(4, 30000, 10000, 75000, 1600000, 4000000, '2023-07-01 06:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `parking_place`
--

DROP TABLE IF EXISTS `parking_place`;
CREATE TABLE IF NOT EXISTS `parking_place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parking_number` varchar(10) NOT NULL,
  `class` enum('A','B','C','D','E') NOT NULL,
  `number_plate` varchar(10) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parking_place`
--

INSERT INTO `parking_place` (`id`, `parking_number`, `class`, `number_plate`, `status`) VALUES
(1, 'A1', 'A', NULL, '0'),
(2, 'A2', 'A', NULL, '0'),
(3, 'A3', 'A', NULL, '0'),
(4, 'A4', 'A', '25E43265', '1'),
(5, 'A5', 'A', NULL, '0'),
(6, 'A6', 'A', NULL, '0'),
(7, 'A7', 'A', NULL, '0'),
(8, 'A8', 'A', NULL, '0'),
(9, 'A9', 'A', NULL, '0'),
(10, 'A10', 'A', NULL, '0'),
(11, 'A11', 'A', NULL, '0'),
(12, 'A12', 'A', NULL, '0'),
(13, 'A13', 'A', NULL, '0'),
(14, 'A14', 'A', NULL, '0'),
(15, 'A15', 'A', '50D12345', '1'),
(16, 'A16', 'A', NULL, '0'),
(17, 'A17', 'A', NULL, '0'),
(18, 'A18', 'A', NULL, '0'),
(19, 'A19', 'A', NULL, '0'),
(20, 'A20', 'A', NULL, '0'),
(21, 'B1', 'B', NULL, '0'),
(22, 'B2', 'B', NULL, '0'),
(23, 'B3', 'B', '67U45346', '1'),
(24, 'B4', 'B', NULL, '0'),
(25, 'B5', 'B', '30G56789', '1'),
(26, 'B6', 'B', NULL, '0'),
(27, 'B7', 'B', NULL, '0'),
(28, 'B8', 'B', NULL, '0'),
(29, 'B9', 'B', NULL, '0'),
(30, 'B10', 'B', NULL, '0'),
(31, 'B11', 'B', NULL, '0'),
(32, 'B12', 'B', NULL, '0'),
(33, 'B13', 'B', NULL, '0'),
(34, 'B14', 'B', NULL, '0'),
(35, 'B15', 'B', NULL, '0'),
(36, 'B16', 'B', NULL, '0'),
(37, 'B17', 'B', NULL, '0'),
(38, 'B18', 'B', NULL, '0'),
(39, 'B19', 'B', '75U64225', '1'),
(40, 'B20', 'B', NULL, '0'),
(41, 'C1', 'C', NULL, '0'),
(42, 'C2', 'C', NULL, '0'),
(43, 'C3', 'C', NULL, '0'),
(44, 'C4', 'C', NULL, '0'),
(45, 'C5', 'C', NULL, '0'),
(46, 'C6', 'C', NULL, '0'),
(47, 'C7', 'C', NULL, '0'),
(48, 'C8', 'C', NULL, '0'),
(49, 'C9', 'C', NULL, '0'),
(50, 'C10', 'C', NULL, '0'),
(51, 'C11', 'C', '34B99999', '1'),
(52, 'C12', 'C', NULL, '0'),
(53, 'C13', 'C', NULL, '0'),
(54, 'C14', 'C', NULL, '0'),
(55, 'C15', 'C', NULL, '0'),
(56, 'C16', 'C', NULL, '0'),
(57, 'C17', 'C', NULL, '0'),
(58, 'C18', 'C', '29F43742', '1'),
(59, 'C19', 'C', NULL, '0'),
(60, 'C20', 'C', NULL, '0'),
(61, 'D1', 'D', NULL, '0'),
(62, 'D2', 'D', NULL, '0'),
(63, 'D3', 'D', NULL, '0'),
(64, 'D4', 'D', NULL, '0'),
(65, 'D5', 'D', NULL, '0'),
(66, 'D6', 'D', NULL, '0'),
(67, 'D7', 'D', NULL, '0'),
(68, 'D8', 'D', NULL, '0'),
(69, 'D9', 'D', NULL, '0'),
(70, 'D10', 'D', NULL, '0'),
(71, 'D11', 'D', NULL, '0'),
(72, 'D12', 'D', NULL, '0'),
(73, 'D13', 'D', NULL, '0'),
(74, 'D14', 'D', NULL, '0'),
(75, 'D15', 'D', NULL, '0'),
(76, 'D16', 'D', NULL, '0'),
(77, 'D17', 'D', NULL, '0'),
(78, 'D18', 'D', NULL, '0'),
(79, 'D19', 'D', NULL, '0'),
(80, 'D20', 'D', NULL, '0'),
(81, 'E1', 'E', NULL, '0'),
(82, 'E2', 'E', NULL, '0'),
(83, 'E3', 'E', NULL, '0'),
(84, 'E4', 'E', NULL, '0'),
(85, 'E5', 'E', NULL, '0'),
(86, 'E6', 'E', NULL, '0'),
(87, 'E7', 'E', NULL, '0'),
(88, 'E8', 'E', NULL, '0'),
(89, 'E9', 'E', NULL, '0'),
(90, 'E10', 'E', NULL, '0'),
(91, 'E11', 'E', NULL, '0'),
(92, 'E12', 'E', NULL, '0'),
(93, 'E13', 'E', NULL, '0'),
(94, 'E14', 'E', NULL, '0'),
(95, 'E15', 'E', NULL, '0'),
(96, 'E16', 'E', NULL, '0'),
(97, 'E17', 'E', NULL, '0'),
(98, 'E18', 'E', NULL, '0'),
(99, 'E19', 'E', NULL, '0'),
(100, 'E20', 'E', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number_plate` varchar(10) NOT NULL,
  `parking_number` varchar(10) NOT NULL,
  `in_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `out_time` timestamp NULL DEFAULT NULL,
  `parking_fee` int(6) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `number_plate`, `parking_number`, `in_time`, `out_time`, `parking_fee`, `status`) VALUES
(1, '34B99999', 'A1', '2023-05-31 08:05:10', '2023-05-31 08:26:15', 30000, '1'),
(2, '34B88888', 'A2', '2023-05-31 08:45:48', '2023-06-02 02:33:45', 400000, '1'),
(3, '34B77777', 'A4', '2023-05-31 09:01:40', '2023-06-03 06:17:39', 550000, '1'),
(4, '29A88888', 'B1', '2023-06-01 01:42:17', '2023-06-01 08:24:19', 80000, '1'),
(5, '30A88888', 'A3', '2023-06-01 08:53:28', '2023-06-03 06:07:46', 0, '1'),
(6, '34B99999', 'A1', '2023-06-01 09:11:23', '2023-06-03 03:56:30', 0, '1'),
(7, '20B56789', 'A5', '2023-06-02 02:32:18', '2023-06-03 06:24:30', 325000, '1'),
(8, '50D12345', 'A9', '2023-06-03 06:33:20', '2023-06-03 11:39:22', 70000, '1'),
(9, '30G56789', 'A8', '2023-06-03 06:43:00', '2023-06-03 23:41:11', 0, '1'),
(11, '20B56789', 'A7', '2023-06-03 06:49:45', '2023-06-04 07:54:12', 325000, '1'),
(12, '30A88888', 'A6', '2023-06-03 11:41:02', '2023-06-04 07:54:47', 0, '1'),
(13, '21F45436', 'B13', '2023-06-03 12:20:08', '2023-06-07 01:14:13', 700000, '1'),
(14, '50D12345', 'C1', '2023-06-04 03:40:22', '2023-07-01 07:50:02', 0, '1'),
(15, '23C43656', 'A4', '2023-06-04 04:08:59', '2023-06-04 04:55:57', 30000, '1'),
(16, '56K43957', 'A1', '2023-06-04 05:22:35', '2023-06-05 00:10:14', 200000, '1'),
(17, '20B56789', 'A6', '2023-06-04 07:55:16', '2023-07-01 07:53:15', 4150000, '1'),
(18, '56B42057', 'D4', '2023-06-04 08:17:32', '2023-07-01 07:54:08', 4150000, '1'),
(19, '75U64225', 'D17', '2023-06-04 08:17:51', '2023-07-02 05:46:30', 4300000, '1'),
(20, '32J96784', 'D1', '2023-06-04 08:18:10', '2023-06-04 23:45:01', 170000, '1'),
(21, '30A88888', 'D5', '2023-06-04 11:51:55', '2023-06-05 00:10:00', 0, '1'),
(22, '25E43265', 'A4', '2023-06-07 01:00:09', '2023-06-07 04:16:38', 50000, '1'),
(23, '67U45346', 'D5', '2023-06-07 01:14:00', '2023-06-30 04:51:40', 3625000, '1'),
(24, '58Y55475', 'A2', '2023-06-07 04:14:49', '2023-07-06 03:02:46', 4450000, '1'),
(25, '30G56789', 'A3', '2023-06-07 04:17:27', '2023-06-07 04:17:32', 0, '1'),
(26, '25E43265', 'A4', '2023-06-30 04:52:09', NULL, NULL, '0'),
(27, '30G56789', 'B5', '2023-07-01 06:32:46', NULL, NULL, '0'),
(28, '29F43742', 'C18', '2023-06-28 11:33:55', NULL, NULL, '0'),
(29, '34B99999', 'C11', '2023-06-26 23:34:23', NULL, NULL, '0'),
(30, '50D12345', 'A15', '2023-07-02 00:22:51', NULL, NULL, '0'),
(31, '75U64225', 'B19', '2023-07-02 05:46:48', NULL, NULL, '0'),
(32, '67U45346', 'B3', '2023-07-05 00:09:01', NULL, NULL, '0');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
