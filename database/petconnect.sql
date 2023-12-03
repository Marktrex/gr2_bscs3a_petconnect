-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1

-- Generation Time: Dec 02, 2023 at 01:13 AM

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
  `short_description` text DEFAULT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `responsible_id`, `type`, `short_description`, `date_time`) VALUES
(1, 1, '0', '0', '2023-11-13 01:15:57'),
(2, 1, 'login', 'User has logged in', '2023-11-13 01:17:01'),
(3, 2, 'login', 'User has logged in', '2023-11-13 01:17:30'),
(4, 13, 'register', 'new registration of user', '2023-11-13 01:29:26'),
(5, 14, 'register', 'new registration of user', '2023-11-13 01:34:46'),
(6, 1, 'login', 'User has logged in', '2023-11-13 01:37:27'),
(7, 1, 'Logout', 'User has logged out', '2023-11-13 01:42:52'),
(8, 1, 'login', 'User has logged in', '2023-11-13 01:51:52'),
(9, 1, 'user promotion', 'admin promoted 2 to admin', '2023-11-13 02:00:54'),
(10, 1, 'user demotion', 'admin demoted 2 to admin', '2023-11-13 02:00:59'),
(11, 1, 'user promotion', 'admin promoted id:2 to admin', '2023-11-13 02:01:40'),
(12, 1, 'admin modified user', 'admin change the content of user: marc123 id: 2', '2023-11-13 02:01:45'),
(13, 1, 'admin modified user', 'admin change the content of user: 123123123 id: 14', '2023-11-13 02:04:26'),
(14, 1, 'Logout', 'User has logged out', '2023-11-13 02:07:07'),
(15, 1, 'login', 'User has logged in', '2023-11-13 02:07:12'),
(16, 1, 'admin deletes account', 'admin deletes account:14', '2023-11-13 02:10:07'),
(17, 1, 'admin modified pet', 'admin change the content of pet: pogi si marc21 id: ', '2023-11-13 18:39:40'),
(18, 1, 'admin modified pet', 'admin change the content of pet: pogi si marc id: 2', '2023-11-13 18:40:28'),
(19, 1, 'admin deleted a pet', 'admin deleted id: 2', '2023-11-13 18:41:28'),
(20, 1, 'admin deleted a pet', 'admin deleted id: 3', '2023-11-13 18:41:40'),
(21, 1, 'add pets', 'admin added pets named:admin123 on 1212-12-12', '2023-11-13 18:45:14'),
(22, 1, 'add news', 'admin added news sample', '2023-11-13 18:46:25'),
(23, 1, 'admin set headline', 'admin has set news id: 4 to headline', '2023-11-13 18:51:37'),
(24, 1, 'admin deletes news', 'admin deleted news id: 4', '2023-11-13 18:51:56'),
(25, 1, 'admin update news', 'admin updated news titled: testicle2 and id: 2', '2023-11-13 18:52:10'),
(26, 15, 'login', 'User has logged in', '2023-11-13 21:40:57'),
(27, 15, 'register', 'new registration of user', '2023-11-15 21:07:02'),
(28, 15, 'login', 'User has logged in', '2023-11-15 21:07:12'),
(29, 15, 'Logout', 'User has logged out', '2023-11-15 21:40:50'),
(30, 15, 'login', 'User has logged in', '2023-11-15 21:40:58'),
(31, 15, 'Logout', 'User has logged out', '2023-11-15 22:01:04'),
(32, 15, 'login', 'User has logged in', '2023-11-15 22:01:33'),
(33, 15, 'Logout', 'User has logged out', '2023-11-15 22:05:40'),
(34, 15, 'login', 'User has logged in', '2023-11-15 22:05:47'),
(35, 15, 'Logout', 'User has logged out', '2023-11-15 22:17:50'),
(36, 1, 'Logout', 'User has logged out', '2023-11-15 22:42:50'),
(37, 19, 'appointment', 'admin Accepted appointment of 2', '2023-11-15 22:51:39'),
(38, 1, 'add pets', 'admin added pets named:negneg on 2023-11-15', '2023-11-15 23:07:48'),
(39, 1, 'admin set featured pets', 'admin has set featured pets:9 , 5 , 6,  ', '2023-11-15 23:08:12'),
(40, 1, 'admin modified user', 'admin change the content of user: marc id: 19', '2023-11-15 23:10:07'),
(41, 1, 'admin modified user', 'admin change the content of user: marc id: 19', '2023-11-15 23:15:50'),
(42, 1, 'admin modified user', 'admin change the content of user: marc id: 19', '2023-11-15 23:29:34'),
(43, 1, 'Logout', 'User has logged out', '2023-11-15 23:47:54'),
(44, 19, 'Logout', 'User has logged out', '2023-11-15 23:49:41'),
(45, 1, 'Logout', 'User has logged out', '2023-11-16 00:16:08'),
(46, 1, 'Logout', 'User has logged out', '2023-11-16 00:16:29'),
(47, 19, 'Logout', 'User has logged out', '2023-11-16 00:18:53'),
(48, 1, 'admin modified user', 'admin change the content of user: fionaxd id: 2', '2023-11-16 00:28:24'),
(49, 2, 'Logout', 'User has logged out', '2023-11-16 00:32:03'),
(50, 1, 'admin modified pet', 'admin change the content of pet: 1 id: 1', '2023-11-16 01:05:41'),
(51, 1, 'admin modified user', 'admin change the content of user: Fiona id: 2', '2023-11-16 01:06:04'),
(52, 1, 'admin modified user', 'admin change the content of user: Fiona id: 2', '2023-11-16 01:06:47'),
(53, 1, 'admin modified user', 'admin change the content of user: Fiona id: 2', '2023-11-16 01:07:15'),
(54, 2, 'Logout', 'User has logged out', '2023-11-16 01:07:58'),
(55, 1, 'admin set featured pets', 'admin has set featured pets:9 , 5 , 6,  ', '2023-11-16 01:11:16'),
(56, 1, 'admin modified pet', 'admin change the content of pet: 1 id: 1', '2023-11-16 01:12:01'),
(57, 1, 'admin modified pet', 'admin change the content of pet: admin123 id: 7', '2023-11-16 01:13:15'),
(58, 1, 'admin modified pet', 'admin change the content of pet: admin123 id: 8', '2023-11-16 01:13:24'),
(59, 1, 'Logout', 'User has logged out', '2023-11-16 01:22:16'),
(60, 18, 'Logout', 'User has logged out', '2023-11-29 23:46:13'),
(61, 3, 'Register', 'Created a new user account', '2023-11-29 23:46:56'),
(62, 4, 'Register', 'Created a new user account', '2023-11-29 23:47:14'),
(63, 3, 'Login', 'Admin Logged In', '2023-11-29 23:50:41'),
(64, 3, 'Logout', 'User has logged out', '2023-11-30 00:08:15'),
(65, 3, 'Login', 'Admin Logged In', '2023-11-30 00:08:24'),
(66, 3, 'Logout', 'User has logged out', '2023-11-30 00:17:01'),
(67, 4, 'Login', 'User Logged In', '2023-11-30 00:17:10'),
(68, 4, 'Logout', 'User has logged out', '2023-11-30 00:22:11'),
(69, 3, 'Login', 'Admin Logged In', '2023-11-30 00:22:21'),
(70, 3, 'Logout', 'User has logged out', '2023-11-30 00:25:44'),
(71, 3, 'Login', 'Admin Logged In', '2023-11-30 00:25:53'),
(72, 4, 'Login', 'User Logged In', '2023-11-30 00:26:39'),
(73, 4, 'Logout', 'User has logged out', '2023-11-30 00:27:15'),
(74, 4, 'Login', 'User Logged In', '2023-11-30 00:27:29'),
(75, 3, 'Logout', 'User has logged out', '2023-11-30 00:30:44'),
(76, 3, 'Login', 'Admin Logged In', '2023-11-30 00:31:11');

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

--
-- Dumping data for table `chat_message`
--




-- --------------------------------------------------------

--
-- Table structure for table `chat_user_table`
--


--
-- Dumping data for table `chat_user_table`
--




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
(7, 'admin123', 'Dog', 'Shih Tzu', 'Male', '10-20 lbs', '6 months to 5 years', '1212-12-12', 'something', 'image_6554fc2b82705.jpg', 1, '0'),
(8, 'admin123', 'Dog', 'Shih Tzu', 'Male', '10-20 lbs', '6 months to 5 years', '1212-12-12', 'something', 'image_6554fc342f8ff.png', 1, '0'),
(9, 'negneg', 'Cat', 'Labrador Retriever', 'Female', '20-50 lbs', '5 to 10 years', '2023-11-15', 'xd', '6554dec40c41e.jpg', 1, '1');

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
  `user_connection_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `email`, `password`, `user_type`, `created_at`, `user_verification_code`, `user_status`, `user_login_status`, `user_token`, `user_connection_id`) VALUES
(3, 'sanoke', 'sample', 'user@sample', '$2y$10$GgCWeReImQYhoIFWr3Mv/.C.ukeU5FAEkLjN4qFDoDrkgUEpUji4G', '2', '2023-12-01 15:21:25', '', 'Disabled', 'Login', '311e51959613dc62a38e0d4be7e8b41a', 92),
(4, 'admin', 'admin1', 'admin@sample', '$2y$10$wFFacnx5J3VQSeCGC1XYMOtMgs6B0uZHef1uiXm7CpmfG.MwK2Cy6', '1', '2023-12-01 15:21:23', '', 'Disabled', 'Login', '1e5d8907d06713b3b5a8010975ad61f0', 88),
(26, 'mark', 'kevin', 'sinicchi123@gmail.com', '$2y$10$Fhk9/MQjYUMeVrq44H0uZO0veXRch59wmy4qMtNAl6wiqyxgeYsqm', '2', '2023-11-30 19:26:22', '', 'Enabled', 'Login', 'e986f62136b056817609fb25367191f7', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

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
-- AUTO_INCREMENT for table `chat_user_table`
--

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pets_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--

-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
