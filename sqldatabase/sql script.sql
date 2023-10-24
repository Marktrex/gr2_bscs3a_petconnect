-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2023 at 05:03 PM
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
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `details` mediumtext NOT NULL,
  `image` varchar(250) NOT NULL,
  `date_published` datetime NOT NULL,
  `is_featured` tinyint(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `title`, `details`, `image`, `date_published`, `is_featured`, `user_id`) VALUES
(2, 'testicle', '123456', '65378bf8c08c8.png', '0000-00-00 00:00:00', 1, 1);

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
(1, '1', 'Dog', 'Shih Tzu', 'Female', '10-20 lbs', '5 to 10 years', '2023-10-24', 'wkwwdwdwdwdwdwd', 'image_6537711b43fa1.png', 0, '1'),
(2, 'pogi si marc', 'Cat', 'Siberian Husky', 'Female', 'over 50 lbs', 'over 10 years', '2023-10-24', 'pogi', '653767f482f49.png', 1, '2'),
(3, '113', 'Dog', 'Shih Tzu', 'Female', '10-20 lbs', '6 months to 5 years', '2023-10-24', 'nuibba', '6537698da6859.png', 1, '3'),
(5, 'test', 'Dog', 'Shih Tzu', 'Male', '5-10 lbs', '5 to 10 years', '2023-10-24', 'barabida omsim', '65376a772b8f3.png', 1, '0'),
(6, 'wew', 'Cat', 'Rottweiler', 'Female', 'Less than 5 lbs', 'Less than 6 months', '2023-10-24', 'sheesh pogi ni aries', '65376a95c15e7.png', 1, '0');

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
(2, 'marc', 'david', 'marc@gmail.com', '123', '2', '2023-10-24 05:02:46'),
(3, 'tset123', '123', '123@gmail.com', '123', '2', '2023-10-24 08:29:55'),
(5, 'test', 'test', '532432@gmail.com', '123', '1', '2023-10-24 08:45:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`);

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
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pets_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
