-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2023 at 02:28 PM
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
(1, 'Adopt', '2023-11-02', 'Morning Session', '1', '1', '1', '1', '1', '1@gmail.com', 2, 'Accepted', 'Good Day, Ma\'am/Sir,\n\nYour appointment is confirmed. Kindly message us within 24 hours if you would like to reschedule or cancel your appointment. Thank you!\n\nVery truly yours,\nRePaw City');

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
(25, 1, 'admin update news', 'admin updated news titled: testicle2 and id: 2', '2023-11-13 18:52:10');

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
  `status` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(8, 22, 20, 'hello', '2023-11-09 18:05:07', 'Yes'),
(9, 21, 22, 'g', '2023-11-09 18:12:06', 'Yes'),
(10, 1, 20, 'hey', '2023-11-09 18:23:04', 'Yes'),
(11, 1, 20, 'hey', '2023-11-09 18:24:02', 'Yes'),
(12, 1, 23, 'hello', '2023-11-09 18:54:09', 'Yes'),
(13, 23, 1, 'huh', '2023-11-09 19:03:05', 'Yes'),
(14, 21, 1, 'bug', '2023-11-09 19:03:15', 'Yes'),
(15, 1, 23, 'ewan ko', '2023-11-09 19:03:34', 'Yes'),
(16, 23, 1, 'what is status', '2023-11-09 19:07:58', 'Yes'),
(17, 1, 23, 'test', '2023-11-09 19:18:11', 'Yes'),
(18, 1, 23, 'owshee', '2023-11-09 19:20:48', 'Yes'),
(19, 21, 1, 'hey', '2023-11-09 20:18:19', 'Yes'),
(20, 21, 1, 'heeu', '2023-11-09 20:18:25', 'Yes'),
(21, 23, 1, 'heuy', '2023-11-09 20:18:29', 'Yes'),
(22, 21, 1, 'hey', '2023-11-09 20:19:15', 'Yes'),
(23, 23, 1, 'hello', '2023-11-09 20:21:54', 'Yes'),
(24, 21, 1, 'bakit ayaw lumitaw', '2023-11-09 20:22:33', 'Yes'),
(25, 21, 1, 'eu', '2023-11-09 20:27:40', 'Yes'),
(26, 1, 23, 'what', '2023-11-09 20:27:48', 'Yes'),
(27, 23, 1, 'what', '2023-11-09 20:28:23', 'Yes'),
(28, 21, 1, 'eu', '2023-11-09 20:30:28', 'Yes'),
(29, 21, 1, 'hel', '2023-11-09 20:31:20', 'Yes'),
(30, 23, 1, 'oi', '2023-11-09 20:31:24', 'Yes'),
(31, 21, 23, 'heuy', '2023-11-09 20:31:58', 'Yes'),
(32, 21, 23, 'what', '2023-11-09 20:32:03', 'Yes'),
(33, 1, 23, 'hey', '2023-11-09 20:34:57', 'Yes'),
(34, 21, 23, 'test', '2023-11-09 20:46:45', 'Yes'),
(35, 21, 23, 'test', '2023-11-09 20:47:04', 'Yes'),
(36, 1, 23, 'test', '2023-11-09 20:47:11', 'Yes'),
(37, 1, 23, 'test naman', '2023-11-09 20:47:32', 'Yes'),
(38, 1, 23, 'heu', '2023-11-09 20:49:32', 'Yes'),
(39, 23, 1, 'gey', '2023-11-09 20:51:07', 'Yes'),
(40, 1, 23, 'hello', '2023-11-09 20:56:15', 'Yes'),
(41, 23, 1, 'hoy', '2023-11-09 20:59:18', 'Yes'),
(42, 1, 21, 'test', '2023-11-09 21:22:01', 'Yes'),
(43, 23, 1, 'test', '2023-11-10 19:02:09', 'Yes'),
(44, 21, 1, 'hey', '2023-11-10 19:02:14', 'Yes'),
(45, 1, 21, 'what', '2023-11-10 19:02:23', 'Yes'),
(46, 23, 21, 'seeshg', '2023-11-10 19:02:26', 'No'),
(47, 23, 1, 'ey', '2023-11-10 19:32:38', 'No'),
(48, 21, 1, 'ey', '2023-11-10 19:32:50', 'Yes'),
(49, 1, 21, 'what', '2023-11-10 19:32:59', 'Yes'),
(50, 1, 21, 'test', '2023-11-10 19:33:12', 'Yes'),
(51, 21, 1, 'whgat', '2023-11-10 19:33:18', 'Yes'),
(52, 21, 1, 'what', '2023-11-10 19:33:24', 'Yes'),
(53, 1, 21, 'nothing', '2023-11-10 19:33:31', 'Yes'),
(54, 21, 1, 'tes', '2023-11-10 19:50:38', 'Yes'),
(55, 21, 1, 'hey', '2023-11-10 19:56:01', 'Yes'),
(56, 1, 21, 'hello', '2023-11-10 19:56:09', 'Yes'),
(57, 21, 1, 'hey', '2023-11-10 20:02:17', 'Yes'),
(58, 21, 1, 'ey', '2023-11-11 23:36:02', 'Yes'),
(59, 1, 28, 'low', '2023-11-11 23:36:12', 'Yes'),
(60, 1, 28, 'hey', '2023-11-12 22:34:22', 'Yes'),
(61, 29, 1, 'hy', '2023-11-12 22:48:17', 'Yes'),
(62, 29, 1, 'geuy', '2023-11-12 22:48:28', 'Yes'),
(63, 1, 29, 'low', '2023-11-12 22:48:34', 'Yes'),
(64, 1, 30, 'hello', '2023-11-13 00:10:36', 'Yes'),
(65, 30, 1, 'fuck u', '2023-11-13 00:10:42', 'Yes'),
(66, 1, 30, 'tagninamo', '2023-11-13 00:27:03', 'Yes'),
(67, 30, 1, 'guk', '2023-11-13 00:27:21', 'Yes'),
(68, 1, 30, 'test', '2023-11-13 01:02:10', 'Yes'),
(69, 30, 1, 'hey', '2023-11-13 01:02:33', 'Yes'),
(70, 1, 30, 'ewa', '2023-11-13 01:03:09', 'Yes'),
(71, 1, 30, 'haha', '2023-11-13 01:03:16', 'Yes'),
(72, 30, 1, 'sheesh', '2023-11-13 01:03:39', 'Yes'),
(73, 1, 30, 'a', '2023-11-13 01:20:26', 'Yes'),
(74, 1, 31, 'test', '2023-11-13 02:10:54', 'Yes'),
(75, 31, 1, 'ay', '2023-11-13 02:11:00', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `chat_user_table`
--

CREATE TABLE `chat_user_table` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_status` enum('Disabled','Enable') NOT NULL,
  `user_created_on` datetime NOT NULL,
  `user_verification_code` varchar(100) NOT NULL,
  `user_login_status` enum('Logout','Login') NOT NULL,
  `user_token` varchar(100) NOT NULL,
  `user_connection_id` int(5) NOT NULL,
  `user_type` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_user_table`
--

INSERT INTO `chat_user_table` (`user_id`, `user_name`, `user_email`, `user_password`, `user_status`, `user_created_on`, `user_verification_code`, `user_login_status`, `user_token`, `user_connection_id`, `user_type`) VALUES
(1, 'Admin', 'admin@gmail.com', '123', 'Enable', '2023-11-10 13:46:19', 'e0f9cddd1c75be5c3da989a5ea97be5a', 'Logout', 'f8b55d9b67322854ba63eaddbe9da8ae', 88, 'Admin'),
(31, 'marc', 'marc@gmail.com', '123', 'Enable', '0000-00-00 00:00:00', '', 'Login', '6ee282bfd79be87a3a0874cf32fd7856', 51, 'User');

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
(1, '1', 'Dog', 'Shih Tzu', 'Female', '10-20 lbs', '5 to 10 years', '2023-10-24', 'wkwwdwdwdwdwdwd', 'image_6551fc2589b86.jpg', 0, '0'),
(5, 'test', 'Dog', 'Shih Tzu', 'Male', '5-10 lbs', '5 to 10 years', '2023-10-24', 'barabida omsim', '65376a772b8f3.png', 1, '0'),
(6, 'wew', 'Cat', 'Rottweiler', 'Female', 'Less than 5 lbs', 'Less than 6 months', '2023-10-24', 'sheesh pogi ni aries', '65376a95c15e7.png', 1, '0'),
(7, 'admin123', 'Dog', 'Shih Tzu', 'Male', '10-20 lbs', '6 months to 5 years', '1212-12-12', 'something', '6551fdb6e11e3.jpg', 1, ''),
(8, 'admin123', 'Dog', 'Shih Tzu', 'Male', '10-20 lbs', '6 months to 5 years', '1212-12-12', 'something', '6551fe3a50a53.jpg', 1, '');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `lname`, `email`, `password`, `user_type`, `created_at`) VALUES
(1, 'tester', 'testtest', 'admin@gmail.com', '123', '1', '2023-10-24 08:12:20'),
(2, 'marc123', 'david', 'marc@gmail.com', '123', '1', '2023-11-12 18:01:45'),
(3, 'tset123', '123', '123@gmail.com', '123', '2', '2023-10-24 08:29:55'),
(5, 'test', 'test', '532432@gmail.com', '123', '1', '2023-10-24 08:45:28'),
(13, 'sample', 'sample', 'sample@sample', '123', '2', '2023-11-12 17:29:26');

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
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `chat_user_table`
--
ALTER TABLE `chat_user_table`
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `chat_user_table`
--
ALTER TABLE `chat_user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pets_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;