-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 07:59 AM
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
CREATE DATABASE IF NOT EXISTS `petconnect` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `petconnect`;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(11) NOT NULL,
  `appointment_type` varchar(250) NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `time_slot` varchar(250) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(250) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `home_address` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `appointment_type`, `appointment_date`, `time_slot`, `first_name`, `middle_name`, `last_name`, `mobile_number`, `home_address`, `email_address`, `user_id`, `status`, `message`) VALUES
(1, 'Adopt', '2023-11-02', 'Morning Session', '1', '1', '1', '1', '1', '1@gmail.com', 2, 'Accepted', 'Good Day, Ma\'am/Sir,\n\nYour appointment is confirmed. Kindly message us within 24 hours if you would like to reschedule or cancel your appointment. Thank you!\n\nVery truly yours,\nRePaw City'),
(2, 'Adopt', '2023-11-15', 'Afternoon Session', '123', '123', '123', '123', '123', '123@gmail.com', 15, 'Accepted', 'Good Day, Ma\'am/Sir,\n\nYour appointment is confirmed. Kindly message us within 24 hours if you would like to reschedule or cancel your appointment. Thank you!\n\nVery truly yours,\nRePaw City');

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

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
(108, 29, 'INSERT', '2023-12-04 19:57:42', 'None', 'None', 'USER', 29, 'All');

-- --------------------------------------------------------

--
-- Table structure for table `call_table`
--

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
(11, 'channel_656acfdf11d01', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `details` mediumtext NOT NULL,
  `image` varchar(250) NOT NULL,
  `date_published` datetime NOT NULL DEFAULT current_timestamp(),
  `is_featured` tinyint(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `title`, `details`, `image`, `date_published`, `is_featured`, `user_id`) VALUES
(2, 'testicle2', '123456', '65378bf8c08c8.png', '0000-00-00 00:00:00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

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
(7, 'admin1', 'Dog', 'Shih Tzu', 'Male', '10-20 lbs', '6 months to 5 years', '1212-12-12', 'something', 'image_6554fc2b82705.jpg', 1, '0'),
(8, 'admi', 'Cat', 'Shih Tzu', 'Female', 'Less than 5 lbs', 'Less than 6 months', '0222-02-22', '23333333', 'image_656db90821050.png', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

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
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `email`, `password`, `user_type`, `created_at`, `user_verification_code`, `user_status`, `user_login_status`, `user_token`, `user_connection_id`, `photo`) VALUES
(3, 'sanoke', 'sample', 'user@sample', '$2y$10$GgCWeReImQYhoIFWr3Mv/.C.ukeU5FAEkLjN4qFDoDrkgUEpUji4G', '2', '2023-12-04 11:42:07', '', 'Disabled', 'Logout', '12d9531a332d39daf8010773a044719d', 92, 'image_656dbad249834.png'),
(4, 'admin', 'admin1', 'admin@sample', '$2y$10$wFFacnx5J3VQSeCGC1XYMOtMgs6B0uZHef1uiXm7CpmfG.MwK2Cy6', '1', '2023-12-04 11:55:37', '', 'Disabled', 'Logout', '9d90e833d765f0fdecdd28c63356687f', 88, NULL),
(26, 'mark', 'kevin', 'sinicchi123@gmail.com', '$2y$10$Fhk9/MQjYUMeVrq44H0uZO0veXRch59wmy4qMtNAl6wiqyxgeYsqm', '2', '2023-11-30 19:26:22', '', 'Enabled', 'Login', 'e986f62136b056817609fb25367191f7', 0, NULL),
(27, 'aras', 'aras', '1233@sample', '123', '1', '2023-12-04 10:13:22', '', '', 'Logout', '', 0, NULL),
(29, '12', '12', '222@sample', '$2y$10$SC2jZScWWkAiY3BSqL3Ik.haX4lWicUNObLqIK33gM/f3Z3caz2HW', '2', '2023-12-04 11:57:42', '', 'Disabled', 'Logout', '', 0, NULL);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

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
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `call_table`
--
ALTER TABLE `call_table`
  MODIFY `call_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
