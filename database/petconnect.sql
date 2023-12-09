-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2023 at 03:51 PM
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
(1, 'Adopt', '2023-12-20', 'Morning Session', 2, 'Accepted', NULL),
(2, 'Adopt', '2023-12-20', 'Afternoon Session', 15, 'Accepted', NULL),
(3, 'Adopt', '2023-12-21', 'Morning Session', 2, 'Accepted', NULL),
(5, 'Donate', '2023-12-18', 'Morning Session', 3, 'Disabled', '8bb61ecc0da234a26eba7c3aaf9532de'),
(6, 'Donate', '2024-01-01', 'Morning Session', 3, 'Disabled', 'bc0a4bf9fc3982630848e872f8847b07'),
(7, 'Donate', '2023-12-25', 'Morning Session', 3, 'Disabled', '824a9b2cd7e73d31279d9f3c1b028421'),
(8, 'Donate', '2023-12-26', 'Afternoon Session', 3, 'Disabled', 'd0c684b8e2289e8bb70bea926ae30c2c'),
(9, 'Donate', '2023-12-26', 'Morning Session', 3, 'Disabled', 'd4dfa75e9da3932e1aad02248cecc5a3'),
(10, 'Donate', '2023-12-27', 'Morning Session', 3, 'Disabled', '71c7f91d73c31320b34eedcc0f2a8a47'),
(11, 'Donate', '2023-12-28', 'Morning Session', 3, 'Accepted', '936c25891186d13d8f6fb778c5a12e3c'),
(12, 'Adopt', '2023-12-22', 'Morning Session', 3, 'Disabled', 'd67c501b423e8d18ccfc88a9e0e45c79'),
(13, 'Adopt', '2023-12-29', 'Morning Session', 3, 'Disabled', '7c62f251b9047a41431ae39fe907ba56'),
(14, 'Adopt', '2023-12-29', 'Afternoon Session', 3, 'Pending', 'd07ce32261f19d05f08838c5e81b1029');

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
(126, 3, 'INSERT', '2023-12-08 12:14:50', 'None', 'All', 'APPOINTMENT', 3, 'All');

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
(42, 'channel_6573001038b27', 1, 1);

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
(211, 3, 4, 'this is a call', '2023-12-08 04:37:52', 'Yes', 'call', 42);

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
  `user_id` int(11) NOT NULL,
  `is_featured` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`pets_id`, `name`, `type`, `breed`, `sex`, `weight`, `age`, `date`, `about`, `image`, `user_id`, `is_featured`) VALUES
(1, '1', 'Cat', 'Shih Tzu', 'Female', '10-20 lbs', '5 to 10 years', '2023-10-24', 'wkwwdwdwdwdwdwd', 'image_6554fbe161043.png', 0, '0'),
(5, 'test', 'Dog', 'Shih Tzu', 'Male', '5-10 lbs', '5 to 10 years', '2023-10-24', 'barabida omsim', '65376a772b8f3.png', 1, '2'),
(6, 'wew', 'Cat', 'Rottweiler', 'Female', 'Less than 5 lbs', 'Less than 6 months', '2023-10-24', 'sheesh pogi ni aries', '65376a95c15e7.png', 1, '3'),
(7, 'admin1', 'Dog', 'Bulldog', 'Male', '10-20 lbs', '6 months to 5 years', '1212-12-12', 'something', 'image_6554fc2b82705.jpg', 1, '0'),
(8, 'admi', 'Cat', 'Shih Tzu', 'Female', 'Less than 5 lbs', 'Less than 6 months', '0222-02-22', '23333333', 'image_656db90821050.png', 1, '0');

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
  `user_verification_code` varchar(250) NOT NULL,
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

INSERT INTO `user` (`user_id`, `fname`, `lname`, `email`, `password`, `user_type`, `created_at`, `user_verification_code`, `user_status`, `user_login_status`, `user_token`, `user_connection_id`, `photo`, `home_address`, `mobile_number`) VALUES
(3, 'sanoke2', 'sanoke2', 'ajtagle12@gmail.com', '$2y$10$IxqaDi3zkg3LKE9ajtkocO.Me2M1Re52dd9zlYz3kXoyiladcboc2', '2', '2023-12-08 11:37:28', '', 'Enabled', 'Login', '42b4884c7a189244a1ccb4edb546f955', 104, 'image_656ecf8bd02c2.jpg', '123123', '23123'),
(4, 'admin', 'admin1', 'admin@sample', '$2y$10$wFFacnx5J3VQSeCGC1XYMOtMgs6B0uZHef1uiXm7CpmfG.MwK2Cy6', '1', '2023-12-08 11:37:10', '', 'Enabled', 'Login', 'a640131f23fe94977aa5e10a9cd5da6b', 93, NULL, NULL, ''),
(26, 'mark', 'kevin', 'sinicchi123@gmail.com', '$2y$10$wFFacnx5J3VQSeCGC1XYMOtMgs6B0uZHef1uiXm7CpmfG.MwK2Cy6', '2', '2023-12-08 02:46:45', '', 'Disabled', 'Login', '81ac20d0c3b7aa8817aa9b7cd88d8719', 0, NULL, NULL, ''),
(27, 'aras', 'aras', '1233@sample', '123', '1', '2023-12-04 10:13:22', '', '', 'Logout', '', 0, NULL, NULL, ''),
(29, '12', '12', '222@sample', '$2y$10$SC2jZScWWkAiY3BSqL3Ik.haX4lWicUNObLqIK33gM/f3Z3caz2HW', '2', '2023-12-04 11:57:42', '', 'Disabled', 'Logout', '', 0, NULL, NULL, '');

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
  MODIFY `adoption_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `call_table`
--
ALTER TABLE `call_table`
  MODIFY `call_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pets_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
