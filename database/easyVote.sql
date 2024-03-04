-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc38
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 04, 2024 at 04:23 AM
-- Server version: 10.5.23-MariaDB
-- PHP Version: 8.2.16

CREATE DATABASE IF NOT EXISTS easyVote;
USE easyVote;

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
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `cid` int(11) NOT NULL,
  `vid` int(11) DEFAULT NULL,
  `eid` int(11) DEFAULT NULL,
  `lid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `election`
--

CREATE TABLE `election` (
  `eid` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `lid` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `election_manager`
--

CREATE TABLE `election_manager` (
  `emid` int(11) NOT NULL,
  `vid` int(11) DEFAULT NULL,
  `eid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `election_type`
--

CREATE TABLE `election_type` (
  `etid` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `lid` int(11) NOT NULL,
  `location_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `pid` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `eid` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pinned_elections`
--

CREATE TABLE `pinned_elections` (
  `peid` int(11) NOT NULL,
  `vid` int(11) DEFAULT NULL,
  `eid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registered_voters`
--

CREATE TABLE `registered_voters` (
  `rvid` int(11) NOT NULL,
  `vid` int(11) DEFAULT NULL,
  `eid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `rid` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `eid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `vid` int(11) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `vid` (`vid`),
  ADD KEY `eid` (`eid`),
  ADD KEY `lid` (`lid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `election`
--
ALTER TABLE `election`
  ADD PRIMARY KEY (`eid`),
  ADD KEY `lid` (`lid`);

--
-- Indexes for table `election_manager`
--
ALTER TABLE `election_manager`
  ADD PRIMARY KEY (`emid`),
  ADD KEY `vid` (`vid`),
  ADD KEY `eid` (`eid`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `election_type`
--
ALTER TABLE `election_type`
  ADD PRIMARY KEY (`etid`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`lid`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `eid` (`eid`);

--
-- Indexes for table `pinned_elections`
--
ALTER TABLE `pinned_elections`
  ADD PRIMARY KEY (`peid`),
  ADD KEY `vid` (`vid`),
  ADD KEY `eid` (`eid`);

--
-- Indexes for table `registered_voters`
--
ALTER TABLE `registered_voters`
  ADD PRIMARY KEY (`rvid`),
  ADD KEY `vid` (`vid`),
  ADD KEY `eid` (`eid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `voters`
--
ALTER TABLE `voters`
  ADD PRIMARY KEY (`vid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `lid` (`lid`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eid` (`eid`),
  ADD KEY `cid` (`cid`),
  ADD KEY `vid` (`vid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `election`
--
ALTER TABLE `election`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `election_manager`
--
ALTER TABLE `election_manager`
  MODIFY `emid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `election_type`
--
ALTER TABLE `election_type`
  MODIFY `etid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pinned_elections`
--
ALTER TABLE `pinned_elections`
  MODIFY `peid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered_voters`
--
ALTER TABLE `registered_voters`
  MODIFY `rvid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
