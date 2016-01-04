-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2015 at 04:45 PM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `msrms`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievement`
--

CREATE TABLE IF NOT EXISTS `achievement` (
`id` int(11) NOT NULL,
  `title` varchar(140) DEFAULT NULL,
  `description` varchar(850) DEFAULT NULL,
  `achieved_date` date DEFAULT NULL,
  `player_involved_in_sport_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `authorizing_officer`
--

CREATE TABLE IF NOT EXISTS `authorizing_officer` (
`id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `contact_nu` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
`id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
`id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(450) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `equipment_borrowed_by_player`
--

CREATE TABLE IF NOT EXISTS `equipment_borrowed_by_player` (
  `equipment_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `borrowed_time` datetime DEFAULT NULL,
  `due_time` datetime DEFAULT NULL,
  `returned_time` datetime DEFAULT NULL,
  `issue_details` varchar(850) DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `equipment_reserved_by_player`
--

CREATE TABLE IF NOT EXISTS `equipment_reserved_by_player` (
  `equipment_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `authorizing_officer_id` int(11) NOT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
`id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_number_auth_officer`
--

CREATE TABLE IF NOT EXISTS `phone_number_auth_officer` (
`number` int(11) NOT NULL,
  `authorizing_officer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_number_player`
--

CREATE TABLE IF NOT EXISTS `phone_number_player` (
`number` int(11) NOT NULL,
  `player_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
`id` int(11) NOT NULL,
  `name` varchar(140) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `blood_type` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `player_involved_in_sport`
--

CREATE TABLE IF NOT EXISTS `player_involved_in_sport` (
  `player_id` int(11) NOT NULL,
  `sport_id` int(11) NOT NULL,
  `started_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `resource`
--

CREATE TABLE IF NOT EXISTS `resource` (
`id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(450) DEFAULT NULL,
  `instructor_name` varchar(128) DEFAULT NULL,
  `location` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE IF NOT EXISTS `sport` (
`id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(450) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sport_has_equipment`
--

CREATE TABLE IF NOT EXISTS `sport_has_equipment` (
  `equipment_id` int(11) NOT NULL,
  `sport_id` int(11) NOT NULL,
  `authorizing_officer_id` int(11) NOT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sport_has_resource`
--

CREATE TABLE IF NOT EXISTS `sport_has_resource` (
  `sport_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `authorizing_officer_id` int(11) NOT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `time_slot_equipment`
--

CREATE TABLE IF NOT EXISTS `time_slot_equipment` (
`id` int(11) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `sport_has_equipment_id` int(11) NOT NULL,
  `day` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `time_slot_resource`
--

CREATE TABLE IF NOT EXISTS `time_slot_resource` (
`id` int(11) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `day` varchar(25) DEFAULT NULL,
  `sport_has_resource_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievement`
--
ALTER TABLE `achievement`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_achievement_player_involved_in_sport1_idx` (`player_involved_in_sport_id`);

--
-- Indexes for table `authorizing_officer`
--
ALTER TABLE `authorizing_officer`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_department_faculty1_idx` (`faculty_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment_borrowed_by_player`
--
ALTER TABLE `equipment_borrowed_by_player`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_equipment_has_player_player2_idx` (`player_id`), ADD KEY `fk_equipment_has_player_equipment2_idx` (`equipment_id`);

--
-- Indexes for table `equipment_reserved_by_player`
--
ALTER TABLE `equipment_reserved_by_player`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_equipment_has_player_player1_idx` (`player_id`), ADD KEY `fk_equipment_has_player_equipment1_idx` (`equipment_id`), ADD KEY `fk_equipment_reserved_by_player_authorizing_officer1_idx` (`authorizing_officer_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_number_auth_officer`
--
ALTER TABLE `phone_number_auth_officer`
 ADD PRIMARY KEY (`number`), ADD KEY `fk_phone_number_auth_officer_authorizing_officer1_idx` (`authorizing_officer_id`);

--
-- Indexes for table `phone_number_player`
--
ALTER TABLE `phone_number_player`
 ADD PRIMARY KEY (`number`), ADD KEY `fk_phone_number_player_player1_idx` (`player_id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_player_department1_idx` (`department_id`);

--
-- Indexes for table `player_involved_in_sport`
--
ALTER TABLE `player_involved_in_sport`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_player_has_sport_sport1_idx` (`sport_id`), ADD KEY `fk_player_has_sport_player1_idx` (`player_id`);

--
-- Indexes for table `resource`
--
ALTER TABLE `resource`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sport_has_equipment`
--
ALTER TABLE `sport_has_equipment`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_equipment_has_sport_sport1_idx` (`sport_id`), ADD KEY `fk_equipment_has_sport_equipment1_idx` (`equipment_id`), ADD KEY `fk_sport_has_equipment_authorizing_officer1_idx` (`authorizing_officer_id`);

--
-- Indexes for table `sport_has_resource`
--
ALTER TABLE `sport_has_resource`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_sport_has_resource_resource1_idx` (`resource_id`), ADD KEY `fk_sport_has_resource_sport1_idx` (`sport_id`), ADD KEY `fk_sport_has_resource_authorizing_officer1_idx` (`authorizing_officer_id`);

--
-- Indexes for table `time_slot_equipment`
--
ALTER TABLE `time_slot_equipment`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_time_slot_equipment_sport_has_equipment1_idx` (`sport_has_equipment_id`);

--
-- Indexes for table `time_slot_resource`
--
ALTER TABLE `time_slot_resource`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_time_slot_resource_sport_has_resource1_idx` (`sport_has_resource_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievement`
--
ALTER TABLE `achievement`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `authorizing_officer`
--
ALTER TABLE `authorizing_officer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `equipment_borrowed_by_player`
--
ALTER TABLE `equipment_borrowed_by_player`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `equipment_reserved_by_player`
--
ALTER TABLE `equipment_reserved_by_player`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `phone_number_auth_officer`
--
ALTER TABLE `phone_number_auth_officer`
MODIFY `number` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `phone_number_player`
--
ALTER TABLE `phone_number_player`
MODIFY `number` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `player_involved_in_sport`
--
ALTER TABLE `player_involved_in_sport`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource`
--
ALTER TABLE `resource`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sport`
--
ALTER TABLE `sport`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sport_has_equipment`
--
ALTER TABLE `sport_has_equipment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sport_has_resource`
--
ALTER TABLE `sport_has_resource`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `time_slot_equipment`
--
ALTER TABLE `time_slot_equipment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `time_slot_resource`
--
ALTER TABLE `time_slot_resource`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievement`
--
ALTER TABLE `achievement`
ADD CONSTRAINT `fk_achievement_player_involved_in_sport1` FOREIGN KEY (`player_involved_in_sport_id`) REFERENCES `player_involved_in_sport` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
ADD CONSTRAINT `fk_department_faculty1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `equipment_borrowed_by_player`
--
ALTER TABLE `equipment_borrowed_by_player`
ADD CONSTRAINT `fk_equipment_has_player_equipment2` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_equipment_has_player_player2` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `equipment_reserved_by_player`
--
ALTER TABLE `equipment_reserved_by_player`
ADD CONSTRAINT `fk_equipment_has_player_equipment1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_equipment_has_player_player1` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_equipment_reserved_by_player_authorizing_officer1` FOREIGN KEY (`authorizing_officer_id`) REFERENCES `authorizing_officer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `phone_number_auth_officer`
--
ALTER TABLE `phone_number_auth_officer`
ADD CONSTRAINT `fk_phone_number_auth_officer_authorizing_officer1` FOREIGN KEY (`authorizing_officer_id`) REFERENCES `authorizing_officer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `phone_number_player`
--
ALTER TABLE `phone_number_player`
ADD CONSTRAINT `fk_phone_number_player_player1` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `player`
--
ALTER TABLE `player`
ADD CONSTRAINT `fk_player_department1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `player_involved_in_sport`
--
ALTER TABLE `player_involved_in_sport`
ADD CONSTRAINT `fk_player_has_sport_player1` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_player_has_sport_sport1` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sport_has_equipment`
--
ALTER TABLE `sport_has_equipment`
ADD CONSTRAINT `fk_equipment_has_sport_equipment1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_equipment_has_sport_sport1` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_sport_has_equipment_authorizing_officer1` FOREIGN KEY (`authorizing_officer_id`) REFERENCES `authorizing_officer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sport_has_resource`
--
ALTER TABLE `sport_has_resource`
ADD CONSTRAINT `fk_sport_has_resource_authorizing_officer1` FOREIGN KEY (`authorizing_officer_id`) REFERENCES `authorizing_officer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_sport_has_resource_resource1` FOREIGN KEY (`resource_id`) REFERENCES `resource` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_sport_has_resource_sport1` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `time_slot_equipment`
--
ALTER TABLE `time_slot_equipment`
ADD CONSTRAINT `fk_time_slot_equipment_sport_has_equipment1` FOREIGN KEY (`sport_has_equipment_id`) REFERENCES `sport_has_equipment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `time_slot_resource`
--
ALTER TABLE `time_slot_resource`
ADD CONSTRAINT `fk_time_slot_resource_sport_has_resource1` FOREIGN KEY (`sport_has_resource_id`) REFERENCES `sport_has_resource` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
