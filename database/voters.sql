-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc38
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 04, 2024 at 04:13 AM
-- Server version: 10.5.23-MariaDB
-- PHP Version: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easyVote`
--

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

CREATE TABLE `voters` (
  `vid` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `lid` int(11) DEFAULT NULL,
  `citizenship_number` varchar(100) DEFAULT NULL,
  `front_image` varchar(100) DEFAULT NULL,
  `back_image` varchar(100) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `authentic` enum('yes','no') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`vid`, `name`, `email`, `password`, `lid`, `citizenship_number`, `front_image`, `back_image`, `photo`, `authentic`) VALUES
(1, 'Pratik Khanal', 'khanalprateek101@gmail.com', '55a6f3e9bd61006125ba266065f28ecb', NULL, NULL, '1709521451_cs_front_1.jpg', '1709521451_cs_back_1.jpg', '1709521451_me.jpg', NULL),
(2, 'Santosh Mahato', 'santosh@mahato.com', '46de911433c0cd709639ae505f0ecc36', NULL, NULL, '1709521573_random_1_f.jpg', '1709521573_random_1_b.jpg', '1709521573_random_pp_1.jpg', NULL),
(3, 'Manish Kumar Shrestha', 'manish@shrestha.com', '46de911433c0cd709639ae505f0ecc36', NULL, NULL, '1709521640_random_2_f.jpg', '1709521640_random_2_b.jpg', '1709521640_random_pp_1.jpg', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `voters`
--
ALTER TABLE `voters`
  ADD PRIMARY KEY (`vid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `lid` (`lid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
