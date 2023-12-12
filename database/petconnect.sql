-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2023 at 10:23 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petconnect`
--
DROP DATABASE IF EXISTS `petconnect`;
CREATE DATABASE IF NOT EXISTS `petconnect` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `petconnect`;

-- --------------------------------------------------------

--
-- Table structure for table `adoption`
--

DROP TABLE IF EXISTS `adoption`;
CREATE TABLE `adoption` (
  `adoption_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pets_id` int(11) NOT NULL,
  `story` text DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption`
--

INSERT INTO `adoption` (`adoption_id`, `user_id`, `pets_id`, `story`, `token`) VALUES
(6, 4, 1, '123', '6ecf8b7e61f694562b2af24f8460da5f6d782b408964b82ca82ab9e148d2e09514c9238ce2d9245fa1174a16a506ed00028a');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE `appointment` (
  `appointment_id` int(11) NOT NULL,
  `appointment_type` varchar(250) NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `time_slot` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `appointment_type`, `appointment_date`, `time_slot`, `user_id`, `status`, `token`) VALUES
(19, 'Adopt', '2023-12-12', 'Morning Session', 3, 'Disabled', '8bc04b0c5341c8a652d760046927a4a9'),
(20, 'Adopt', '2023-12-12', 'Afternoon Session', 3, 'Disabled', '297c4c21f881b4dc86f26c316d1063e2'),
(21, 'Adopt', '2023-12-13', 'Morning Session', 3, 'Disabled', '6d1ec4c06f6442096f2c1513b4c8cf60'),
(22, 'Adopt', '2023-12-13', 'Afternoon Session', 3, 'Pending', '027f68a4c05833f5f8c7cdeb81a4049e'),
(25, 'Adopt', '2023-12-11', 'Morning Session', 31, 'Pending', 'be7e90ac6a6895ec07c37365492d9f4b');

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

DROP TABLE IF EXISTS `audit_log`;
CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL,
  `responsible_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `table_affected` varchar(255) NOT NULL,
  `id_affected` int(11) NOT NULL,
  `column_affected` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `responsible_id`, `type`, `date_time`, `old_value`, `new_value`, `table_affected`, `id_affected`, `column_affected`) VALUES
(108, 29, 'INSERT', '2023-12-04 19:57:42', 'None', 'None', 'USER', 29, 'All'),
(109, 4, 'UPDATE', '2023-12-05 15:10:04', 'sanoke', 'sanoke2', 'USER', 3, 'fname'),
(110, 4, 'UPDATE', '2023-12-05 15:10:05', 'sample', 'sample2', 'USER', 3, 'lname'),
(111, 4, 'UPDATE', '2023-12-05 15:10:05', 'image_656dbad249834.png', 'image_656eccccd2256.png', 'USER', 3, 'photo'),
(112, 4, 'UPDATE', '2023-12-05 15:10:10', '2', '1', 'USER', 3, 'user_type'),
(113, 4, 'UPDATE', '2023-12-05 15:10:15', '1', '2', 'USER', 3, 'user_type'),
(114, 4, 'UPDATE', '2023-12-05 15:21:47', 'sanoke2', 'sanoke', 'USER', 3, 'fname'),
(115, 4, 'UPDATE', '2023-12-05 15:21:48', 'sample2', 'sample', 'USER', 3, 'lname'),
(116, 4, 'UPDATE', '2023-12-05 15:21:48', 'user@sample', 'user1@sample', 'USER', 3, 'email'),
(117, 4, 'UPDATE', '2023-12-05 15:21:48', 'image_656eccccd2256.png', 'image_656ecf8bd02c2.jpg', 'USER', 3, 'photo'),
(118, 4, 'UPDATE', '2023-12-05 15:21:56', '2', '1', 'USER', 3, 'user_type'),
(119, 4, 'UPDATE', '2023-12-05 15:21:59', '1', '2', 'USER', 3, 'user_type'),
(120, 3, 'UPDATE', '2023-12-06 21:17:28', 'sanoke', 'sanoke2', 'USER', 3, 'fname'),
(121, 4, 'UPDATE', '2023-12-07 12:55:30', 'Pending', 'Accepted', 'APPOINTMENT', 11, 'status'),
(122, 4, 'UPDATE', '2023-12-07 12:56:46', 'Pending', 'Accepted', 'APPOINTMENT', 11, 'status'),
(123, 4, 'UPDATE', '2023-12-07 12:57:58', 'Pending', 'Accepted', 'APPOINTMENT', 11, 'status'),
(124, 3, 'INSERT', '2023-12-08 12:11:45', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(125, 3, 'INSERT', '2023-12-08 12:13:43', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(126, 3, 'INSERT', '2023-12-08 12:14:50', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(127, 3, 'INSERT', '2023-12-10 12:12:45', NULL, NULL, 'ADOPTION', 1, 'ALL'),
(128, 3, 'INSERT', '2023-12-10 12:13:03', NULL, NULL, 'ADOPTION', 2, 'ALL'),
(129, 3, 'INSERT', '2023-12-10 12:13:09', NULL, NULL, 'ADOPTION', 3, 'ALL'),
(130, 3, 'INSERT', '2023-12-10 12:13:58', NULL, NULL, 'ADOPTION', 4, 'ALL'),
(131, 4, 'INSERT', '2023-12-10 12:17:45', NULL, NULL, 'ADOPTION', 5, 'ALL'),
(132, 4, 'INSERT', '2023-12-10 12:20:32', NULL, NULL, 'ADOPTION', 6, 'ALL'),
(133, 4, 'UPDATE', '2023-12-10 12:20:32', '0', '1', 'USER', 1, 'isAdopted'),
(134, 4, 'INSERT', '2023-12-10 12:58:32', NULL, NULL, 'ADOPTION', 7, 'ALL'),
(135, 4, 'UPDATE', '2023-12-10 12:58:32', '0', '1', 'USER', 6, 'isAdopted'),
(136, 4, 'INSERT', '2023-12-10 12:58:43', NULL, NULL, 'ADOPTION', 8, 'ALL'),
(137, 4, 'UPDATE', '2023-12-10 12:58:43', '0', '1', 'USER', 7, 'isAdopted'),
(138, 4, 'delete', '2023-12-10 14:19:39', 'All', 'All', 'adoption', 8, 'All'),
(139, 4, 'UPDATE', '2023-12-10 14:22:57', NULL, '332f846e8a9095771143d6440923b54d5707ae749e822be39e4fcfbc7a50e30e600eeea98bcef9489240130034ebea2f0e0d', 'ADOPTION', 6, 'token'),
(140, 4, 'UPDATE', '2023-12-10 14:24:30', '332f846e8a9095771143d6440923b54d5707ae749e822be39e4fcfbc7a50e30e600eeea98bcef9489240130034ebea2f0e0d', '08a9d6b188181eccd42be6f2898e381581d17493a25b395a21d3afd782ae528b19f30d53ef78ca1b8cfe32fafe121ae51718', 'ADOPTION', 6, 'token'),
(141, 4, 'UPDATE', '2023-12-10 14:26:13', '08a9d6b188181eccd42be6f2898e381581d17493a25b395a21d3afd782ae528b19f30d53ef78ca1b8cfe32fafe121ae51718', '6ecf8b7e61f694562b2af24f8460da5f6d782b408964b82ca82ab9e148d2e09514c9238ce2d9245fa1174a16a506ed00028a', 'ADOPTION', 6, 'token'),
(142, 3, 'INSERT', '2023-12-10 16:37:19', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(143, 3, 'INSERT', '2023-12-10 17:58:46', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(144, 3, 'INSERT', '2023-12-11 12:16:15', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(145, 3, 'INSERT', '2023-12-11 12:56:29', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(146, 3, 'INSERT', '2023-12-11 12:59:19', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(147, 3, 'INSERT', '2023-12-11 13:01:22', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(148, 3, 'INSERT', '2023-12-11 13:01:58', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(149, 3, 'INSERT', '2023-12-11 13:02:44', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(150, 3, 'INSERT', '2023-12-11 13:03:44', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(151, 3, 'INSERT', '2023-12-11 13:07:49', 'None', 'All', 'APPOINTMENT', 3, 'All'),
(152, 30, 'INSERT', '2023-12-11 21:02:04', 'None', 'None', 'USER', 30, 'All'),
(153, 31, 'INSERT', '2023-12-11 21:02:48', 'None', 'None', 'USER', 31, 'All'),
(154, 31, 'UPDATE', '2023-12-11 21:13:07', 'sample', 'sanoke2', 'USER', 31, 'lname'),
(155, 31, 'UPDATE', '2023-12-11 21:13:07', NULL, '123', 'USER', 31, 'home_address'),
(156, 31, 'UPDATE', '2023-12-11 21:13:07', '', '123', 'USER', 31, 'mobile_number'),
(157, 31, 'INSERT', '2023-12-11 21:13:11', 'None', 'All', 'APPOINTMENT', 31, 'All'),
(158, 31, 'INSERT', '2023-12-12 15:46:51', 'None', 'All', 'APPOINTMENT', 31, 'All');

-- --------------------------------------------------------

--
-- Table structure for table `call_table`
--

DROP TABLE IF EXISTS `call_table`;
CREATE TABLE `call_table` (
  `call_id` int(11) NOT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `from_has_join` tinyint(1) NOT NULL DEFAULT 0,
  `receiver_has_join` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `call_table`
--

INSERT INTO `call_table` (`call_id`, `channel`, `from_has_join`, `receiver_has_join`) VALUES
(9, 'channel_656ace6cc8b2b', 1, 0),
(10, 'channel_656acef2a31ed', 1, 0),
(11, 'channel_656acfdf11d01', 0, 1),
(12, 'channel_65727d7b4b724', 0, 0),
(13, 'channel_65727e5153891', 1, 0),
(14, 'channel_657281d5047f9', 1, 0),
(15, 'channel_6572c9462c005', 0, 0),
(16, 'channel_6572c956cf648', 0, 0),
(17, 'channel_6572cdcf0ef2c', 0, 0),
(18, 'channel_6572d45a2c7aa', 1, 0),
(19, 'channel_6572d80d5a944', 0, 0),
(20, 'channel_6572d8303e250', 0, 0),
(21, 'channel_6572d8896f7e8', 0, 0),
(22, 'channel_6572d8b28def0', 0, 0),
(23, 'channel_6572d8b6b07ae', 0, 0),
(24, 'channel_6572dd4f7add8', 0, 0),
(25, 'channel_6572dd6f20db8', 1, 0),
(26, 'channel_6572dd72c4b5a', 1, 0),
(27, 'channel_6572dd8bb77e3', 1, 0),
(28, 'channel_6572ddd256d4a', 0, 0),
(29, 'channel_6572ddd99a8b0', 1, 0),
(30, 'channel_6572e00c1488c', 1, 0),
(31, 'channel_6572e034b9ca6', 1, 0),
(32, 'channel_6572e09081c09', 1, 1),
(33, 'channel_6572f89fdb39a', 0, 0),
(34, 'channel_6572f8abaefb6', 1, 0),
(35, 'channel_6572f9b845958', 1, 0),
(36, 'channel_6572f9f811ed8', 1, 0),
(37, 'channel_6572fa1ca88e1', 1, 0),
(38, 'channel_6572fae40edfb', 1, 0),
(39, 'channel_6572ffe315a95', 0, 0),
(40, 'channel_6572ffec34761', 1, 0),
(41, 'channel_6572fffc77b5a', 1, 0),
(42, 'channel_6573001038b27', 1, 1),
(43, 'channel_65769bc868c71', 0, 0),
(44, 'channel_65769c221d844', 0, 0),
(45, 'channel_65769c7ce5406', 0, 0),
(46, 'channel_65769c8c55cbb', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

DROP TABLE IF EXISTS `chat_message`;
CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` mediumtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Yes','No') NOT NULL,
  `message_type` enum('message','call') NOT NULL DEFAULT 'message',
  `call_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`, `message_type`, `call_id`) VALUES
(171, 3, 4, '23', '2023-12-07 19:20:41', 'Yes', 'message', NULL),
(172, 3, 4, 'this is a call', '2023-12-07 19:20:43', 'Yes', 'call', 12),
(173, 3, 4, '123', '2023-12-07 19:24:14', 'Yes', 'message', NULL),
(174, 3, 4, 'this is a call', '2023-12-07 19:24:17', 'Yes', 'call', 13),
(175, 4, 3, '123', '2023-12-07 19:25:55', 'Yes', 'message', NULL),
(176, 26, 4, 'this is a call', '2023-12-07 19:39:17', 'No', 'call', 14),
(177, 3, 4, '13', '2023-12-07 19:43:25', 'Yes', 'message', NULL),
(178, 3, 4, '123', '2023-12-08 00:42:04', 'Yes', 'message', NULL),
(179, 26, 4, '2', '2023-12-08 00:43:08', 'No', 'message', NULL),
(180, 3, 4, '2', '2023-12-08 00:44:04', 'Yes', 'message', NULL),
(181, 3, 4, 'this is a call', '2023-12-08 00:44:06', 'Yes', 'call', 15),
(182, 3, 4, 'this is a call', '2023-12-08 00:44:23', 'Yes', 'call', 16),
(183, 3, 4, '123', '2023-12-08 00:44:45', 'Yes', 'message', NULL),
(184, 3, 4, '123123', '2023-12-08 00:45:29', 'Yes', 'message', NULL),
(185, 3, 4, '2', '2023-12-08 00:45:36', 'Yes', 'message', NULL),
(186, 3, 4, 'this is a call', '2023-12-08 01:03:27', 'Yes', 'call', 17),
(187, 3, 4, 'this is a call', '2023-12-08 01:31:22', 'Yes', 'call', 18),
(188, 3, 4, 'this is a call', '2023-12-08 01:47:09', 'Yes', 'call', 19),
(189, 3, 4, 'this is a call', '2023-12-08 01:47:44', 'Yes', 'call', 20),
(190, 3, 4, 'this is a call', '2023-12-08 01:49:13', 'Yes', 'call', 21),
(191, 3, 4, 'this is a call', '2023-12-08 01:49:54', 'Yes', 'call', 22),
(192, 3, 4, 'this is a call', '2023-12-08 01:49:58', 'Yes', 'call', 23),
(193, 3, 4, 'this is a call', '2023-12-08 02:09:35', 'Yes', 'call', 24),
(194, 3, 4, 'this is a call', '2023-12-08 02:10:07', 'Yes', 'call', 25),
(195, 3, 4, 'this is a call', '2023-12-08 02:10:10', 'Yes', 'call', 26),
(196, 3, 4, 'this is a call', '2023-12-08 02:10:35', 'Yes', 'call', 27),
(197, 3, 4, 'this is a call', '2023-12-08 02:11:46', 'Yes', 'call', 28),
(198, 3, 4, 'this is a call', '2023-12-08 02:11:53', 'Yes', 'call', 29),
(199, 3, 4, 'this is a call', '2023-12-08 02:21:16', 'Yes', 'call', 30),
(200, 3, 4, 'this is a call', '2023-12-08 02:21:56', 'Yes', 'call', 31),
(201, 3, 4, 'this is a call', '2023-12-08 02:23:28', 'Yes', 'call', 32),
(202, 3, 4, 'this is a call', '2023-12-08 04:06:08', 'Yes', 'call', 33),
(203, 3, 4, 'this is a call', '2023-12-08 04:06:19', 'Yes', 'call', 34),
(204, 3, 4, 'this is a call', '2023-12-08 04:10:48', 'Yes', 'call', 35),
(205, 3, 4, 'this is a call', '2023-12-08 04:11:52', 'Yes', 'call', 36),
(206, 3, 4, 'this is a call', '2023-12-08 04:12:28', 'Yes', 'call', 37),
(207, 3, 4, 'this is a call', '2023-12-08 04:15:48', 'Yes', 'call', 38),
(208, 3, 4, 'this is a call', '2023-12-08 04:37:07', 'Yes', 'call', 39),
(209, 3, 4, 'this is a call', '2023-12-08 04:37:16', 'Yes', 'call', 40),
(210, 3, 4, 'this is a call', '2023-12-08 04:37:32', 'Yes', 'call', 41),
(211, 3, 4, 'this is a call', '2023-12-08 04:37:52', 'Yes', 'call', 42),
(212, 27, 3, '123', '2023-12-10 22:18:49', 'Yes', 'message', NULL),
(213, 4, 3, '231', '2023-12-10 22:18:52', 'Yes', 'message', NULL),
(214, 27, 3, 'this is a call', '2023-12-10 22:19:04', 'Yes', 'call', 43),
(215, 27, 3, 'this is a call', '2023-12-10 22:20:34', 'Yes', 'call', 44),
(216, 27, 3, 'this is a call', '2023-12-10 22:22:05', 'Yes', 'call', 45),
(217, 27, 3, 'this is a call', '2023-12-10 22:22:20', 'Yes', 'call', 46);

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

DROP TABLE IF EXISTS `pets`;
CREATE TABLE `pets` (
  `pets_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `type` varchar(250) NOT NULL,
  `breed` varchar(250) NOT NULL,
  `sex` varchar(250) NOT NULL,
  `weight` varchar(250) NOT NULL,
  `age` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `about` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `isAdopted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`pets_id`, `name`, `type`, `breed`, `sex`, `weight`, `age`, `date`, `about`, `image`, `isAdopted`) VALUES
(1, 'aye', 'Cat', 'Shih Tzu', 'Female', '10-20 lbs', '5 to 10 years', '2023-10-24', 'wkwwdwdwdwdwdwd', 'image_6554fbe161043.png', 1),
(5, 'test', 'Dog', 'Shih Tzu', 'Male', '5-10 lbs', '5 to 10 years', '2023-10-24', 'barabida omsim', '65376a772b8f3.png', 1),
(6, 'wew', 'Cat', 'Rottweiler', 'Female', 'Less than 5 lbs', 'Less than 6 months', '2023-10-24', 'sheesh pogi ni aries', '65376a95c15e7.png', 1),
(7, 'admin1', 'Dog', 'Bulldog', 'Male', '10-20 lbs', '6 months to 5 years', '1212-12-12', 'something', 'image_6554fc2b82705.jpg', 1),
(8, 'admi', 'Cat', 'Shih Tzu', 'Female', 'Less than 5 lbs', 'Less than 6 months', '0222-02-22', '23333333', 'BichonFrise.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(250) NOT NULL,
  `lname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `user_type` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_status` varchar(25) NOT NULL,
  `user_login_status` enum('Logout','Login') NOT NULL,
  `user_token` varchar(100) NOT NULL,
  `user_connection_id` int(5) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `home_address` text DEFAULT NULL,
  `mobile_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `email`, `password`, `user_type`, `created_at`, `user_status`, `user_login_status`, `user_token`, `user_connection_id`, `photo`, `home_address`, `mobile_number`) VALUES
(4, 'admin', 'admin1', 'admin@sample', '$2y$10$wFFacnx5J3VQSeCGC1XYMOtMgs6B0uZHef1uiXm7CpmfG.MwK2Cy6', '1', '2023-12-12 07:46:14', 'Enabled', 'Logout', '572a69fcb5744a8fbfb438af52fbed89', 93, NULL, NULL, ''),
(26, 'mark', 'kevin', 'sinicchi123@gmail.com', '$2y$10$wFFacnx5J3VQSeCGC1XYMOtMgs6B0uZHef1uiXm7CpmfG.MwK2Cy6', '2', '2023-12-08 02:46:45', 'Disabled', 'Login', '81ac20d0c3b7aa8817aa9b7cd88d8719', 0, NULL, NULL, ''),
(27, 'aras', 'aras', '1233@sample', '123', '1', '2023-12-04 10:13:22', '', 'Logout', '', 0, NULL, NULL, ''),
(29, '12', '12', '222@sample', '$2y$10$SC2jZScWWkAiY3BSqL3Ik.haX4lWicUNObLqIK33gM/f3Z3caz2HW', '2', '2023-12-04 11:57:42', 'Disabled', 'Logout', '', 0, NULL, NULL, ''),
(31, 'sanoke2', 'sanoke2', 'ajtagle12@gmail.com', '$2y$10$apyJ5EDOSXF2QiSTqmsTGOxJg0L.ILV9iqv3TzdPC3rX5m8rHICj2', '2', '2023-12-12 08:42:10', 'Enabled', 'Login', '86c0c27dea9896cc4d7143e5c9bf5064', 129, NULL, '123', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption`
--
ALTER TABLE `adoption`
  ADD PRIMARY KEY (`adoption_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `call_table`
--
ALTER TABLE `call_table`
  ADD PRIMARY KEY (`call_id`);

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`pets_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption`
--
ALTER TABLE `adoption`
  MODIFY `adoption_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `call_table`
--
ALTER TABLE `call_table`
  MODIFY `call_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pets_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
