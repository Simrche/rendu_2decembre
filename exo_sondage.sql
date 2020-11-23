-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2020 at 02:13 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exo_sondage`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(10) UNSIGNED NOT NULL,
  `chat_sondage_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `listeamis`
--

CREATE TABLE `listeamis` (
  `amis_id` int(10) UNSIGNED NOT NULL,
  `amis_users_id` varchar(255) NOT NULL,
  `amis_users_id2` varchar(255) NOT NULL,
  `amis_anti_double` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `message_chat`
--

CREATE TABLE `message_chat` (
  `msg_id` int(10) UNSIGNED NOT NULL,
  `msg_chat_id` int(11) NOT NULL,
  `msg_message` varchar(255) NOT NULL,
  `msg_pseudo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `part_id` int(10) UNSIGNED NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `part_sondage_id` int(11) NOT NULL,
  `part_reponse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reponses`
--

CREATE TABLE `reponses` (
  `rep_id` int(10) UNSIGNED NOT NULL,
  `rep_name` varchar(255) NOT NULL,
  `rep_sondage_id` int(11) NOT NULL,
  `rep_nombre` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sondage`
--

CREATE TABLE `sondage` (
  `sond_id` int(10) UNSIGNED NOT NULL,
  `sond_question` varchar(255) NOT NULL,
  `sond_lien` varchar(255) NOT NULL,
  `sond_time` int(11) NOT NULL,
  `sond_debut` int(11) NOT NULL,
  `sond_enCours` tinyint(1) NOT NULL DEFAULT '1',
  `sond_createur` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(10) UNSIGNED NOT NULL,
  `users_pseudo` varchar(255) NOT NULL,
  `users_mdp` varchar(255) NOT NULL,
  `users_email` varchar(255) NOT NULL,
  `users_enligne` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `listeamis`
--
ALTER TABLE `listeamis`
  ADD PRIMARY KEY (`amis_id`),
  ADD UNIQUE KEY `amis_anti_double` (`amis_anti_double`),
  ADD KEY `users` (`amis_users_id`),
  ADD KEY `users2` (`amis_users_id2`);

--
-- Indexes for table `message_chat`
--
ALTER TABLE `message_chat`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`part_id`);

--
-- Indexes for table `reponses`
--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`rep_id`);

--
-- Indexes for table `sondage`
--
ALTER TABLE `sondage`
  ADD PRIMARY KEY (`sond_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`),
  ADD UNIQUE KEY `users_pseudo` (`users_pseudo`),
  ADD UNIQUE KEY `users_email` (`users_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listeamis`
--
ALTER TABLE `listeamis`
  MODIFY `amis_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_chat`
--
ALTER TABLE `message_chat`
  MODIFY `msg_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `participant`
--
ALTER TABLE `participant`
  MODIFY `part_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reponses`
--
ALTER TABLE `reponses`
  MODIFY `rep_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sondage`
--
ALTER TABLE `sondage`
  MODIFY `sond_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `listeamis`
--
ALTER TABLE `listeamis`
  ADD CONSTRAINT `users` FOREIGN KEY (`amis_users_id`) REFERENCES `users` (`users_pseudo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users2` FOREIGN KEY (`amis_users_id2`) REFERENCES `users` (`users_pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
