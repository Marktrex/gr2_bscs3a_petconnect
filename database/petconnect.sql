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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
