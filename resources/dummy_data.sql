--
-- Dumping data for table `sport`
--
INSERT INTO `sport` (`id`, `name`, `description`) VALUES
(1, 'Table Tennis', 'Table Tennis Description.');


-- Auth officer
INSERT INTO `authorizing_officer` (`id`, `name`, `contact_nu`, `username`, `password`, `email`, `is_active`) VALUES
(4, 'Ravindu Hasantha', '0771111111', 'ravi', '1234', 'ravindu@gmail.com', 1);


--
-- Dumping data for table `equipment`
--
INSERT INTO `equipment` (`id`, `name`, `description`, `amount`) VALUES
(1, 'TT rubbers and paddles', 'Table Tennis equipment', 10);




--
-- Dumping data for table `resource`
--

INSERT INTO `resource` (`id`, `name`, `description`, `instructor_name`, `location`) VALUES
(1, 'Ground', 'Main ground of the university.', 'Mr. Keet Sugathapala', 'University of Moratuwa');

--
-- Dumping data for table `faculty`
--
INSERT INTO `faculty` (`id`, `name`) VALUES
(1, 'Engineering'),
(2, 'IT'),
(3, 'Architecture ');


-- ------------------------------------------------------------------------------------------------------
-- -------------------------------------------------------- Related data





INSERT INTO `department` (`id`, `name`, `faculty_id`) VALUES
(1, 'Computer Science and Engineering ', 1),
(2, 'Mechanical', 1);




--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `name`, `department_id`, `year`, `date_of_birth`, `address`, `blood_type`, `index_number`) VALUES
(1, 'Shanika Ediriweera', 1, 2, '1916-04-01', '128/A Gedara, Home Town.', 'A+', '130147J'),
(2, 'Nadun Indunil', 2, 3, '1993-10-07', 'Kottawa', 'AB+', '130130X');



--
-- Dumping data for table `player_involved_in_sport`
--

INSERT INTO `player_involved_in_sport` (`player_id`, `sport_id`, `started_date`, `end_date`, `position`, `id`) VALUES
(1, 1, '2016-01-14', NULL, 'Captain', 1),
(2, 1, '2016-01-14', NULL, 'Vice Captain', 2);



--
-- Dumping data for table `equipment_borrowed_by_player`
--

INSERT INTO `equipment_borrowed_by_player` (`equipment_id`, `player_id`, `amount`, `borrowed_time`, `due_time`, `returned_time`, `issue_details`, `id`) VALUES
(1, 1, 1, '2016-01-14 05:50:00', '2016-02-01 00:00:00', NULL, NULL, 1);









