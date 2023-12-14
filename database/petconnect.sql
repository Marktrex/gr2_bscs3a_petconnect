-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2023 at 07:40 PM
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
-- Table structure for table `adoption`
--

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
(12, 36, 17, 'Enter Jane, a software developer on a quest for a dynamic duo. Her expectation was simple: a pet to keep her company through the labyrinth of late-night coding. Venturing into a local animal shelter, she met Max, a Labrador mix with soulful eyes.\r\n\r\nMax exceeded all expectations, evolving into more than just a pet. Their bond grew, and Max\'s tail wagged in sync with Jane\'s coding triumphs. Together, they formed an unbeatable team, proving that the best coding companions often have fur and a wet nose.', NULL),
(13, 36, 12, 'David, a web developer immersed in the digital realm, sought a pet companion who shared his tech enthusiasm. At the local shelter, he found Pixel, a tech-savvy cat with a penchant for virtual mice.\r\n\r\nPixel seamlessly integrated into David\'s coding routine, perching on his desk and adding a touch of feline charm to his workspace. Their journey from bytes to barks showcased a unique bond, demonstrating that coding joy could be enhanced by a furry friend.', NULL),
(14, 36, 15, 'Emily, a creative web developer, envisioned a pet that would infuse inspiration into her design projects. Luna, a gentle mixed-breed dog, turned out to be the perfect muse.\r\n\r\nLuna\'s unexpected knack for design aesthetics brought a new dimension to Emily\'s workspace. As they navigated tight deadlines together, Luna\'s presence became a calming force. Emily found herself explaining design concepts to Luna, creating a harmonious work environment. This story proves that the best pet companions not only bring joy but also contribute to the creative flow.', NULL),
(15, 36, 16, 'Meet Alex, a software developer with a heart set on finding a feline friend to share the coding journey. The expectation was clear: a companion to bring warmth to the lines of code. A local shelter introduced Alex to Whiskers, a playful and curious cat.\r\n\r\nWhiskers turned out to be the missing piece in Alex\'s coding puzzle. The gentle purring became the soundtrack to late-night coding sessions, and Whiskers\' antics provided much-needed breaks. Together, they crafted a purrfect code harmony, proving that sometimes the ideal coding companion is one with a fluffy tail and a penchant for purrs.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

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
(25, 'Adopt', '2023-12-11', 'Morning Session', 31, 'Pending', 'be7e90ac6a6895ec07c37365492d9f4b'),
(29, 'Donate', '2023-12-13', 'Afternoon Session', 31, 'Pending', 'dd46f98d60d07872e92e296548fae80c'),
(30, 'Adopt', '2023-12-22', 'Morning Session', 36, 'Accepted', 'd552edc02efab1cfb9a590619dc3fdf2'),
(31, 'Adopt', '2023-12-23', 'Morning Session', 36, 'Declined', 'd552edc02efab1cfb9a590619dc3fdf2');

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
(158, 31, 'INSERT', '2023-12-12 15:46:51', 'None', 'All', 'APPOINTMENT', 31, 'All'),
(159, 4, 'UPDATE', '2023-12-12 21:08:50', 'Pending', 'Accepted', 'APPOINTMENT', 22, 'status'),
(160, 4, 'UPDATE', '2023-12-12 21:11:39', 'Pending', 'Accepted', 'APPOINTMENT', 22, 'status'),
(161, 4, 'UPDATE', '2023-12-12 21:14:13', 'Pending', 'Accepted', 'APPOINTMENT', 22, 'status'),
(162, 4, 'UPDATE', '2023-12-12 21:17:12', 'Pending', 'Accepted', 'APPOINTMENT', 22, 'status'),
(163, 4, 'UPDATE', '2023-12-12 21:17:50', 'Pending', 'Accepted', 'APPOINTMENT', 22, 'status'),
(164, 4, 'UPDATE', '2023-12-12 21:18:48', 'Accepted', 'Cancelled', 'APPOINTMENT', 22, 'status'),
(165, 4, 'UPDATE', '2023-12-12 21:19:26', 'Pending', 'Declined', 'APPOINTMENT', 22, 'status'),
(166, 4, 'UPDATE', '2023-12-12 21:26:23', 'Pending', 'Declined', 'APPOINTMENT', 22, 'status'),
(167, 4, 'UPDATE', '2023-12-12 21:48:58', 'Accepted', 'Cancelled', 'APPOINTMENT', 22, 'status'),
(168, 31, 'INSERT', '2023-12-13 10:37:15', 'None', 'All', 'APPOINTMENT', 31, 'All'),
(169, 31, 'INSERT', '2023-12-13 10:41:45', 'None', 'All', 'APPOINTMENT', 31, 'All'),
(170, 31, 'INSERT', '2023-12-13 10:47:35', 'None', 'All', 'APPOINTMENT', 31, 'All'),
(171, 31, 'UPDATE', '2023-12-13 15:09:09', 'sanoke2', 'sanoke', 'USER', 31, 'fname'),
(172, 31, 'UPDATE', '2023-12-13 15:09:10', 'sanoke2', 'sanoke', 'USER', 31, 'lname'),
(173, 31, 'UPDATE', '2023-12-13 15:12:07', 'sanoke', 'sanoke1', 'USER', 31, 'fname'),
(174, 31, 'UPDATE', '2023-12-13 15:12:07', 'sanoke', 'sanoke1', 'USER', 31, 'lname'),
(175, 31, 'UPDATE', '2023-12-13 15:12:07', '123', '1232', 'USER', 31, 'home_address'),
(176, 31, 'UPDATE', '2023-12-13 15:12:08', '123', '1232', 'USER', 31, 'mobile_number'),
(177, 31, 'UPDATE', '2023-12-13 15:12:14', NULL, 'image_6579594ed3be0.png', 'USER', 31, 'photo'),
(178, 31, 'UPDATE', '2023-12-13 15:13:46', 'SECRET', 'SECRET', 'USER', 31, 'password'),
(179, 31, 'UPDATE', '2023-12-13 15:13:52', 'SECRET', 'SECRET', 'USER', 31, 'password'),
(180, 31, 'UPDATE', '2023-12-13 15:14:45', 'SECRET', 'SECRET', 'USER', 31, 'password'),
(181, 31, 'UPDATE', '2023-12-13 15:14:50', 'SECRET', 'SECRET', 'USER', 31, 'password'),
(182, 32, 'INSERT', '2023-12-13 18:47:22', 'None', 'None', 'USER', 32, 'All'),
(183, 33, 'INSERT', '2023-12-13 18:50:49', 'None', 'None', 'USER', 33, 'All'),
(184, 34, 'INSERT', '2023-12-13 19:28:03', 'None', 'None', 'USER', 34, 'All'),
(185, 35, 'INSERT', '2023-12-14 09:03:26', 'None', 'None', 'USER', 35, 'All'),
(186, 36, 'INSERT', '2023-12-14 09:14:13', 'None', 'None', 'USER', 36, 'All'),
(187, 36, 'UPDATE', '2023-12-14 09:47:01', 'Aries', 'Aries Joseph', 'USER', 36, 'fname'),
(188, 36, 'UPDATE', '2023-12-14 09:47:01', 'Tagle', 'Tagle2', 'USER', 36, 'lname'),
(189, 36, 'UPDATE', '2023-12-14 09:47:01', NULL, 'San Juan', 'USER', 36, 'home_address'),
(190, 36, 'UPDATE', '2023-12-14 09:47:01', '', '09276375907', 'USER', 36, 'mobile_number'),
(191, 36, 'INSERT', '2023-12-14 09:47:05', 'None', 'All', 'APPOINTMENT', 36, 'All'),
(192, 4, 'UPDATE', '2023-12-14 10:53:01', 'Pending', 'Accepted', 'APPOINTMENT', 30, 'status'),
(193, 4, 'INSERT', '2023-12-14 11:35:44', NULL, NULL, 'ADOPTION', 9, 'ALL'),
(194, 4, 'UPDATE', '2023-12-14 11:35:44', '0', '1', 'PETS', 1, 'isAdopted'),
(195, 4, 'UPDATE', '2023-12-14 11:40:17', NULL, '5613c7edd7f384f64eb5387319d565525607e7f5901247d667550313dc74754fb7c63c99824ac84f8150014d1c3acbc3cfd3', 'ADOPTION', 9, 'token'),
(196, 4, 'UPDATE', '2023-12-14 11:49:57', '5613c7edd7f384f64eb5387319d565525607e7f5901247d667550313dc74754fb7c63c99824ac84f8150014d1c3acbc3cfd3', 'a742969b3ea20dac630d96fcd62efb714038746ce0d0300e24fc949d73430a069ca841de84d2ef40b29cd62f24d1e3b705a5', 'ADOPTION', 9, 'token'),
(197, 4, 'INSERT', '2023-12-14 11:55:14', NULL, NULL, 'ADOPTION', 10, 'ALL'),
(198, 4, 'UPDATE', '2023-12-14 11:55:15', '0', '1', 'PETS', 8, 'isAdopted'),
(199, 4, 'INSERT', '2023-12-14 11:55:53', NULL, NULL, 'ADOPTION', 11, 'ALL'),
(200, 4, 'UPDATE', '2023-12-14 11:55:53', '0', '1', 'PETS', 6, 'isAdopted'),
(201, 4, 'delete', '2023-12-14 11:56:04', 'All', 'All', 'adoption', 10, 'All'),
(202, 4, 'delete', '2023-12-14 11:56:06', 'All', 'All', 'adoption', 11, 'All'),
(203, 4, 'delete', '2023-12-14 11:56:08', 'All', 'All', 'adoption', 9, 'All'),
(204, 4, 'INSERT', '2023-12-15 01:27:46', 'None', 'None', 'PET', 12, 'All'),
(205, 4, 'INSERT', '2023-12-15 01:28:19', 'None', 'None', 'PET', 13, 'All'),
(206, 4, 'INSERT', '2023-12-15 01:29:29', 'None', 'None', 'PET', 14, 'All'),
(207, 4, 'INSERT', '2023-12-15 02:17:15', 'None', 'None', 'PET', 15, 'All'),
(208, 4, 'INSERT', '2023-12-15 02:17:45', 'None', 'None', 'PET', 16, 'All'),
(209, 4, 'INSERT', '2023-12-15 02:18:13', 'None', 'None', 'PET', 17, 'All'),
(210, 4, 'DELETE', '2023-12-15 02:19:43', 'Null', 'Null', 'PET', 6, 'ALL'),
(211, 4, 'INSERT', '2023-12-15 02:20:40', 'None', 'None', 'PET', 18, 'All'),
(212, 4, 'INSERT', '2023-12-15 02:21:11', 'None', 'None', 'PET', 19, 'All'),
(213, 4, 'INSERT', '2023-12-15 02:21:43', NULL, NULL, 'ADOPTION', 12, 'ALL'),
(214, 4, 'UPDATE', '2023-12-15 02:21:43', '0', '1', 'PETS', 17, 'isAdopted'),
(215, 4, 'INSERT', '2023-12-15 02:21:50', NULL, NULL, 'ADOPTION', 13, 'ALL'),
(216, 4, 'UPDATE', '2023-12-15 02:21:50', '0', '1', 'PETS', 12, 'isAdopted'),
(217, 4, 'INSERT', '2023-12-15 02:22:17', NULL, NULL, 'ADOPTION', 14, 'ALL'),
(218, 4, 'UPDATE', '2023-12-15 02:22:17', '0', '1', 'PETS', 15, 'isAdopted'),
(219, 4, 'INSERT', '2023-12-15 02:22:26', NULL, NULL, 'ADOPTION', 15, 'ALL'),
(220, 4, 'UPDATE', '2023-12-15 02:22:26', '0', '1', 'PETS', 16, 'isAdopted');

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
  `isAdopted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`pets_id`, `name`, `type`, `breed`, `sex`, `weight`, `age`, `date`, `about`, `image`, `isAdopted`) VALUES
(1, 'Master', 'Cat', 'Shih Tzu', 'Female', '10-20 lbs', '5 to 10 years', '2023-10-24', 'I was a lonely cat', '646af0c07149d.jpg', 0),
(5, 'Dogma', 'Dog', 'Shih Tzu', 'Male', '5-10 lbs', '5 to 10 years', '2023-10-24', 'I like chocolates', '646ae9b514fc8.jpg', 0),
(7, 'Hat', 'Dog', 'Bulldog', 'Male', '10-20 lbs', '6 months to 5 years', '1212-12-12', 'I like hotdogs', '646ae47825387.jpg', 0),
(8, 'Nath', 'Cat', 'Shih Tzu', 'Female', 'Less than 5 lbs', 'Less than 6 months', '0222-02-22', 'I can be your friend', '646aefe7498dd.jpg', 0),
(12, 'Briar', 'Cat', 'Puspin', 'Female', '10-20 lbs', '5 to 10 years', '2023-12-26', 'I love hotdogs', '657b3b128b4c5.png', 1),
(13, 'Eren', 'Cat', 'Maine Coon', 'Male', '20-50 lbs', '6 months to 5 years', '2022-12-13', 'I want to fly', '657b3b33871d2.jpg', 0),
(14, 'Cheese', 'Dog', 'Golden Retriever', 'Male', '10-20 lbs', '5 to 10 years', '2023-11-21', 'My name is Cheese even though I dont like Cheese', '657b3b7971dfb.jpg', 0),
(15, 'August', 'Cat', 'Scottish Fold', 'Male', '5-10 lbs', '6 months to 5 years', '2023-12-27', 'I am a furry', '657b46ab2a27c.jpg', 1),
(16, 'Rizzler', 'Cat', 'Ragdoll', 'Male', '5-10 lbs', '6 months to 5 years', '2023-11-29', 'You want some Rizz baby gurl?', '657b46c8f34ba.jpg', 1),
(17, 'Sussy Dog', 'Dog', 'Pomeranian', 'Male', '10-20 lbs', 'Less than 6 months', '2023-11-29', 'What you doing?', '657b46e5050e9.jpg', 1),
(18, 'Gold', 'Dog', 'Golden Retriever', 'Female', '5-10 lbs', '6 months to 5 years', '1999-03-12', 'I like you', '657b477887789.jpeg', 0),
(19, 'Terry', 'Dog', 'Labrador Retriever', 'Male', '5-10 lbs', '6 months to 5 years', '2023-12-06', 'hello my guy', '657b4797d1b4f.jpg', 0);

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
(4, 'admin', 'admin1', 'admin@sample', '$2y$10$wFFacnx5J3VQSeCGC1XYMOtMgs6B0uZHef1uiXm7CpmfG.MwK2Cy6', '1', '2023-12-14 18:24:05', 'Enabled', 'Logout', '855d298f89ca7362771f8bfd75fb7718', 924, 'image_656d8e78e69f4.png', NULL, ''),
(26, 'mark', 'kevin', 'sinicchi123@gmail.com', '$2y$10$wFFacnx5J3VQSeCGC1XYMOtMgs6B0uZHef1uiXm7CpmfG.MwK2Cy6', '2', '2023-12-08 02:46:45', 'Disabled', 'Login', '81ac20d0c3b7aa8817aa9b7cd88d8719', 0, NULL, NULL, ''),
(27, 'aras', 'aras', '1233@sample', '123', '1', '2023-12-04 10:13:22', '', 'Logout', '', 0, NULL, NULL, ''),
(29, '12', '12', '222@sample', '$2y$10$SC2jZScWWkAiY3BSqL3Ik.haX4lWicUNObLqIK33gM/f3Z3caz2HW', '2', '2023-12-04 11:57:42', 'Disabled', 'Logout', '', 0, NULL, NULL, ''),
(36, 'Aries Joseph', 'Tagle2', 'ajtagle12@gmail.com', '$2y$10$dQ0W2YKUUSgrkpyinoQYROgc7y58Z0E03zKkHQ1A0Qr4Pt.pA7s8W', '2', '2023-12-14 18:29:31', 'Enabled', 'Login', '17ce00e94c11bb6aa7bdf6e3b0bdc729', 1013, NULL, 'San Juan', '09276375907');

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
  MODIFY `adoption_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `call_table`
--
ALTER TABLE `call_table`
  MODIFY `call_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pets_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
