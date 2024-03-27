-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2023 at 06:50 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id20799918_webapplication`
--
CREATE DATABASE IF NOT EXISTS `id20799918_webapplication` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `id20799918_webapplication`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

CREATE TABLE `tbl_accounts` (
  `account_id` int(5) NOT NULL,
  `account_name` varchar(15) NOT NULL,
  `account_surname` varchar(15) NOT NULL,
  `account_email` varchar(50) NOT NULL,
  `account_password` varchar(100) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `account_picture` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_accounts`
--

INSERT INTO `tbl_accounts` (`account_id`, `account_name`, `account_surname`, `account_email`, `account_password`, `account_number`, `account_picture`) VALUES
(21, 'Daniel', 'Buhagiar', 'danielbuhagiar14@gmail.com', '$2y$10$fuqIfRBSTj3Nah.Hjt3Dk.ZmuZQqMTo6pICv9T.p3dFgaGW1Wqglu', '79023706', 'images/flower.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_anime`
--

CREATE TABLE `tbl_anime` (
  `anime_id` int(5) NOT NULL,
  `anime_title` varchar(30) NOT NULL,
  `anime_studio` varchar(30) NOT NULL,
  `anime_score` int(2) NOT NULL,
  `anime_watched_eps` int(5) NOT NULL,
  `anime_total_eps` int(5) NOT NULL,
  `account_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_anime`
--

INSERT INTO `tbl_anime` (`anime_id`, `anime_title`, `anime_studio`, `anime_score`, `anime_watched_eps`, `anime_total_eps`, `account_id`) VALUES
(50, 'Show 1', 'Studio 1', 7, 12, 12, 21),
(51, 'Show 2', 'Studio 2', 10, 1, 1, 21),
(52, 'Show 3', 'Studio 3', 9, 1, 8, 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `tbl_anime`
--
ALTER TABLE `tbl_anime`
  ADD PRIMARY KEY (`anime_id`),
  ADD KEY `account_animes` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  MODIFY `account_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_anime`
--
ALTER TABLE `tbl_anime`
  MODIFY `anime_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_anime`
--
ALTER TABLE `tbl_anime`
  ADD CONSTRAINT `account_animes` FOREIGN KEY (`account_id`) REFERENCES `tbl_accounts` (`account_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
