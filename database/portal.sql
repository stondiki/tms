-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 20, 2019 at 07:17 AM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

DROP TABLE IF EXISTS `academic_years`;
CREATE TABLE IF NOT EXISTS `academic_years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year_span` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `year_span` (`year_span`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `year_span`) VALUES
(4, '2019-2020'),
(5, '2021-2022'),
(6, '2022-2023');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(60) NOT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `department_id`) VALUES
(1, 'actuarial science', 1),
(2, 'computer science', 2);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(60) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `faculty_id` (`faculty_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `faculty_id`) VALUES
(1, 'mathematics and actuarial science', 2),
(2, 'computer and information science', 2),
(3, 'community health and development', 2),
(4, 'natural sciences', 2),
(5, 'nursing', 2);

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

DROP TABLE IF EXISTS `faculties`;
CREATE TABLE IF NOT EXISTS `faculties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faculty_name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `faculty_name`) VALUES
(1, 'law'),
(2, 'science'),
(3, 'theology'),
(4, 'education'),
(5, 'business'),
(6, 'arts and social sciences'),
(7, 'library');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `user_type` enum('0','1','2','3','4','5','6','7','8') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `user_type`) VALUES
(1, 'Why does change password keep popping up?', 'The change password modal will pop up every time you navigate because you have not changed your password from the password that was sent to you via email.\r\nOnce you change your password, this will stop ', '7'),
(2, 'Why can i only navigate to home and the academic calendar?', 'You only have 2 navigation options, Home and Academic Calendar, because you are not logged in. Other features are only available for logged in users.', '0'),
(3, 'Why can\'t I see all the lecturers or venues or courses in the timetable filter?', 'The timetable filter only shows lecturers, venues and courses that are on the current timetable. The others will appear only if they are added to the timetable.', '3');

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

DROP TABLE IF EXISTS `logins`;
CREATE TABLE IF NOT EXISTS `logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(60) NOT NULL,
  `user_password` varchar(60) NOT NULL DEFAULT 'pass',
  `first_password` enum('yes','no') NOT NULL DEFAULT 'yes',
  `user_role` enum('student','lecturer','staff') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`id`, `user_email`, `user_password`, `first_password`, `user_role`) VALUES
(2, 'b@gmail.com', '$2y$10$Hbof2SUaFOp5ONgmmcgVo.UGFD2I1VYKv/oRI9h2Avip1/r1UzDk2', 'yes', 'lecturer'),
(3, 'c@gmail.com', '$2y$10$YGoH.tZDHA7Sjo3wui3.RuzwoXaZLNUbjsZT7blW9rrTBUlc12BJa', 'no', 'staff'),
(8, 'f@gmail.com', '$2y$10$Hbof2SUaFOp5ONgmmcgVo.UGFD2I1VYKv/oRI9h2Avip1/r1UzDk2', 'yes', 'lecturer'),
(10, 'h@gmail.com', '$2y$10$Hbof2SUaFOp5ONgmmcgVo.UGFD2I1VYKv/oRI9h2Avip1/r1UzDk2', 'yes', 'staff'),
(11, 'i@gmail.com', '$2y$10$Hbof2SUaFOp5ONgmmcgVo.UGFD2I1VYKv/oRI9h2Avip1/r1UzDk2', 'yes', 'staff'),
(13, 'k@gmail.com', '$2y$10$Hbof2SUaFOp5ONgmmcgVo.UGFD2I1VYKv/oRI9h2Avip1/r1UzDk2', 'yes', 'student'),
(14, 'l@gmail.com', '$2y$10$Hbof2SUaFOp5ONgmmcgVo.UGFD2I1VYKv/oRI9h2Avip1/r1UzDk2', 'yes', 'staff'),
(15, 'm@gmail.com', '$2y$10$Hbof2SUaFOp5ONgmmcgVo.UGFD2I1VYKv/oRI9h2Avip1/r1UzDk2', 'yes', 'student'),
(22, 'test@gmail.com', '$2y$10$Hbof2SUaFOp5ONgmmcgVo.UGFD2I1VYKv/oRI9h2Avip1/r1UzDk2', 'yes', 'student'),
(23, 'jim@gmail.com', '$2y$10$Hbof2SUaFOp5ONgmmcgVo.UGFD2I1VYKv/oRI9h2Avip1/r1UzDk2', 'yes', 'student'),
(24, 'oliver@gmail.com', '$2y$10$Hbof2SUaFOp5ONgmmcgVo.UGFD2I1VYKv/oRI9h2Avip1/r1UzDk2', 'yes', 'student'),
(25, 'lex@gmail.com', '$2y$10$Hbof2SUaFOp5ONgmmcgVo.UGFD2I1VYKv/oRI9h2Avip1/r1UzDk2', 'yes', 'student'),
(27, 'malone@gmail.com', '$2y$10$ezW.TNh/uodHGTjf/RyluO5a6cA0mVqWOCR3yaqcSa5GHzx/rSACO', 'yes', 'lecturer');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
CREATE TABLE IF NOT EXISTS `registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `semester_id` (`semester_id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `student_id`, `semester_id`, `registration_date`) VALUES
(46, 10, 6, '2019-09-03 11:32:56'),
(47, 49, 6, '2019-09-03 13:08:55');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

DROP TABLE IF EXISTS `semesters`;
CREATE TABLE IF NOT EXISTS `semesters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` enum('September-December','January-April','May-August') DEFAULT NULL,
  `sem_start` date NOT NULL,
  `sem_end` date NOT NULL,
  `academic_year` int(11) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'no',
  `registration` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `academic_year` (`academic_year`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `semester`, `sem_start`, `sem_end`, `academic_year`, `active`, `registration`) VALUES
(6, 'May-August', '2020-05-04', '2020-08-28', 4, 'yes', 'yes'),
(5, 'January-April', '2020-01-06', '2020-04-24', 4, 'no', 'no'),
(4, 'September-December', '2019-09-02', '2019-12-20', 4, 'no', 'no'),
(7, 'September-December', '2021-09-01', '2021-12-24', 5, 'no', 'no'),
(8, 'January-April', '2022-01-02', '2022-04-29', 5, 'no', 'no'),
(9, 'May-August', '2022-05-02', '2022-08-26', 5, 'no', 'no'),
(10, 'September-December', '2022-09-08', '2022-12-28', 6, 'no', 'no'),
(11, 'January-April', '2023-01-02', '2023-04-21', 6, 'no', 'no'),
(12, 'May-August', '2023-05-02', '2023-08-25', 6, 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `semester_events`
--

DROP TABLE IF EXISTS `semester_events`;
CREATE TABLE IF NOT EXISTS `semester_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` int(11) NOT NULL,
  `event_description` text NOT NULL,
  `s_date` date NOT NULL,
  `e_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `semester` (`semester`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester_events`
--

INSERT INTO `semester_events` (`id`, `semester`, `event_description`, `s_date`, `e_date`) VALUES
(1, 6, 'Presentation of projects', '2019-08-14', '2019-08-14'),
(2, 6, 'Trimester Exams', '2019-07-22', '2019-07-31'),
(3, 6, 'Entering of semester results', '2019-08-28', '2019-08-29'),
(4, 6, 'Test event', '2019-09-02', '2019-09-02'),
(5, 5, 'Opening', '2020-01-01', '2020-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_details_id` int(11) NOT NULL,
  `course` int(11) DEFAULT '2',
  `ac_level` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`student_id`),
  KEY `user_id` (`user_details_id`),
  KEY `course` (`course`)
) ENGINE=MyISAM AUTO_INCREMENT=1000015 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_details_id`, `course`, `ac_level`) VALUES
(1000001, 11, 2, 2),
(1000002, 15, 2, 3),
(1000006, 20, 2, 4),
(1000007, 21, 2, 5),
(1000008, 22, 2, 6),
(1000009, 23, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `system_log`
--

DROP TABLE IF EXISTS `system_log`;
CREATE TABLE IF NOT EXISTS `system_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` int(11) DEFAULT NULL,
  `system_event` enum('login','logout','navigation','action') DEFAULT NULL,
  `clicked_element` varchar(60) DEFAULT NULL,
  `clicked_page` varchar(60) DEFAULT NULL,
  `ip_address` varchar(120) DEFAULT NULL,
  `action_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`usr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1631 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_log`
--

INSERT INTO `system_log` (`id`, `usr_id`, `system_event`, `clicked_element`, `clicked_page`, `ip_address`, `action_time`) VALUES
(1630, 3, 'navigation', 'Lecturers', 'http://localhost/tms/tms/#', '::1', '2019-09-20 06:45:38'),
(1629, 3, 'navigation', 'Students', 'http://localhost/tms/tms/lecturer-reports.php#', '::1', '2019-09-20 06:45:19'),
(1628, 3, 'navigation', 'Lecturers', 'http://localhost/tms/tms/venue-reports.php#', '::1', '2019-09-20 06:45:13'),
(1627, 3, 'navigation', 'Venues', 'http://localhost/tms/tms/users.php#', '::1', '2019-09-20 06:44:56'),
(1626, 3, 'action', 'Submit delete user', 'http://localhost/tms/tms/users.php', '::1', '2019-09-20 06:43:27'),
(1625, 3, 'action', 'Open delete user James Macharia modal', 'http://localhost/tms/tms/users.php', '::1', '2019-09-20 06:43:26'),
(1624, 3, 'action', 'Submit delete user', 'http://localhost/tms/tms/users.php', '::1', '2019-09-20 06:43:20'),
(1623, 3, 'action', 'Open delete user Philip Njuru modal', 'http://localhost/tms/tms/users.php', '::1', '2019-09-20 06:43:19'),
(1622, 3, 'action', 'Submit delete user', 'http://localhost/tms/tms/users.php', '::1', '2019-09-20 06:43:17'),
(1621, 3, 'action', 'Open delete user kioko edward modal', 'http://localhost/tms/tms/users.php', '::1', '2019-09-20 06:43:15'),
(1620, 3, 'action', 'Submit delete user', 'http://localhost/tms/tms/users.php', '::1', '2019-09-20 06:43:12'),
(1619, 3, 'action', 'Open delete user Terence Amunga modal', 'http://localhost/tms/tms/users.php', '::1', '2019-09-20 06:43:10'),
(1618, 3, 'navigation', 'Users', 'http://localhost/tms/tms/index.php', '::1', '2019-09-20 06:42:48'),
(1617, 3, 'login', 'login', 'login', '::1', '2019-09-20 06:42:27'),
(1615, 3, 'login', 'login', 'login', '::1', '2019-09-16 05:44:29'),
(1616, 3, 'navigation', 'System Logs', 'http://localhost/tms/index.php', '::1', '2019-09-16 05:44:31');

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

DROP TABLE IF EXISTS `timeslots`;
CREATE TABLE IF NOT EXISTS `timeslots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slot_day` enum('monday','tuesday','wednesday','thursday','friday') NOT NULL,
  `slot_start_time` varchar(30) NOT NULL,
  `slot_end_time` varchar(30) NOT NULL,
  `slot_duration` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`id`, `slot_day`, `slot_start_time`, `slot_end_time`, `slot_duration`) VALUES
(36, 'friday', '2pm', '5pm', '3hrs'),
(35, 'friday', '11am', '2pm', '3hrs'),
(34, 'friday', '8am', '11am', '3hrs'),
(33, 'thursday', '2pm', '5pm', '3hrs'),
(32, 'thursday', '8am', '11am', '3hrs'),
(31, 'wednesday', '2pm', '5pm', '3hrs'),
(30, 'wednesday', '11am', '2pm', '3hrs'),
(29, 'wednesday', '8am', '11am', '3hrs'),
(28, 'tuesday', '2pm', '5pm', '3hrs'),
(27, 'tuesday', '11am', '2pm', '3hrs'),
(26, 'tuesday', '8am', '11am', '3hrs'),
(25, 'monday', '2pm', '5pm', '3hrs'),
(24, 'monday', '11am', '2pm', '3hrs'),
(23, 'monday', '8am', '11am', '3hrs');

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

DROP TABLE IF EXISTS `timetables`;
CREATE TABLE IF NOT EXISTS `timetables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_year` int(11) NOT NULL,
  `unit_semester` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `timeslot_id` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `unit_id` (`unit_id`),
  KEY `semester_id` (`semester_id`),
  KEY `venue_id` (`venue_id`),
  KEY `timeslot_id` (`timeslot_id`),
  KEY `lecturer_id` (`lecturer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=494 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`id`, `course_id`, `unit_id`, `unit_year`, `unit_semester`, `semester_id`, `venue_id`, `timeslot_id`, `lecturer_id`) VALUES
(493, 2, 6, 1, 1, 6, 3, 29, 2),
(492, 2, 5, 1, 1, 6, 8, 34, 2),
(491, 2, 4, 1, 1, 6, 4, 33, 2),
(490, 2, 3, 1, 1, 6, 1, 31, 2),
(489, 2, 2, 1, 1, 6, 4, 23, 2),
(488, 2, 1, 1, 1, 6, 3, 26, 2);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(60) NOT NULL,
  `unit_code` varchar(10) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `unit_duration` varchar(10) NOT NULL DEFAULT '3hrs',
  `unit_branch` varchar(60) DEFAULT NULL,
  `unit_year` enum('1','2','3','4') DEFAULT NULL,
  `unit_semester` enum('1','2') DEFAULT NULL,
  `preferred_venue` enum('hall','lab','room','open') DEFAULT 'room',
  `fee` int(11) NOT NULL DEFAULT '15530',
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`, `unit_code`, `course_id`, `unit_duration`, `unit_branch`, `unit_year`, `unit_semester`, `preferred_venue`, `fee`) VALUES
(1, 'Christian Ethics and Formation of Moral Maturity', 'GS 100', 2, '3hrs', 'general', '1', '1', 'room', 15530),
(2, 'Discrete Mathematics', 'MAT 111', 2, '3hrs', 'compulsory', '1', '1', 'room', 15530),
(3, 'Fundamentals of Computing', 'CMT 102', 2, '3hrs', 'compulsory', '1', '1', 'lab', 15530),
(4, 'Physics for Computer Science I', 'CMT 100', 2, '3hrs', 'compulsory', '1', '1', 'room', 15530),
(5, 'Introduction to Web Development', 'CMT 108', 2, '3hrs', 'compulsory', '1', '1', 'lab', 15530),
(6, 'Elements of Accounting', 'CMT 106', 2, '3hrs', 'compulsory', '1', '1', 'room', 15530),
(7, 'Entrepreneurship', 'CMT 104', 2, '3hrs', 'compulsory', '1', '1', 'room', 15530),
(8, 'Communication Skills', 'GS 101', 2, '3hrs', 'general', '1', '2', 'room', 15530),
(9, 'Introduction to the Bible', 'GS 103', 2, '3hrs', 'general', '1', '2', 'room', 15530),
(10, 'Elements of Linear Algebra', 'MAT 104', 2, '3hrs', 'compulsory', '1', '2', 'room', 15530),
(11, 'Hardware and Software Maintenance', 'CMT 101', 2, '3hrs', 'compulsory', '1', '2', 'lab', 15530),
(12, 'Programming Methodology', 'CMT 110', 2, '3hrs', 'compulsory', '1', '2', 'lab', 15530),
(13, 'Computer Networks', 'CMT 107', 2, '3hrs', 'compulsory', '1', '2', 'lab', 15530),
(14, 'Database Systems', 'CMT 109', 2, '3hrs', 'compulsory', '1', '2', 'lab', 15530),
(15, 'Environmental Studies', 'GS 104', 2, '3hrs', 'general', '2', '1', 'room', 15530),
(16, 'Differential Calculus', 'MAT 101', 2, '3hrs', 'compulsory', '2', '1', 'room', 15530),
(17, 'Semi-Conductor Theory', 'CMT 200', 2, '3hrs', 'compulsory', '2', '1', 'room', 15530),
(18, 'Object Oriented Programming I', 'CMT 210', 2, '3hrs', 'compulsory', '2', '1', 'lab', 15530),
(19, 'Introduction to System Administration', 'CMT 203', 2, '3hrs', 'compulsory', '2', '1', 'lab', 15530),
(20, 'Computer Architecture', 'CMT 205', 2, '3hrs', 'compulsory', '2', '1', 'room', 15530),
(21, 'Introduction to Artificial Intelligence', 'CMT 208', 2, '3hrs', 'compulsory', '2', '1', 'lab', 15530),
(22, 'Integral Calculus', 'MAT 200', 2, '3hrs', 'compulsory', '2', '2', 'room', 15530),
(23, 'Probability & Statistics', 'MAT 262', 2, '3hrs', 'compulsory', '2', '2', 'room', 15530),
(24, 'Logic Circuits', 'CMT 201', 2, '3hrs', 'compulsory', '2', '2', 'room', 15530),
(25, 'Operating Systems', 'CMT 206', 2, '3hrs', 'compulsory', '2', '2', 'room', 15530),
(26, 'Web Development', 'CMT 209', 2, '3hrs', 'compulsory', '2', '2', 'lab', 15530),
(27, 'Object Oriented Programming II', 'CMT 211', 2, '3hrs', 'compulsory', '2', '2', 'lab', 15530),
(28, 'Data Communications', 'CMT 300', 2, '3hrs', 'compulsory', '3', '1', 'room', 15530),
(29, 'Advanced Database Systems', 'CMT 302', 2, '3hrs', 'compulsory', '3', '1', 'lab', 15530),
(30, 'Data Structures', 'CMT 304', 2, '3hrs', 'compulsory', '3', '1', 'lab', 15530),
(31, 'Distributed Systems', 'CMT 308', 2, '3hrs', 'compulsory', '3', '1', 'lab', 15530),
(32, 'Object Oriented System Analysis and Design', 'CMT 310', 2, '3hrs', 'compulsory', '3', '1', 'lab', 15530),
(33, 'Mobile Application Development', 'CMT 314', 2, '3hrs', 'compulsory', '3', '1', 'lab', 15530),
(34, 'Research Methodology', 'CMT 301', 2, '3hrs', 'compulsory', '3', '2', 'room', 15530),
(35, '.NET Programming', 'CMT 307', 2, '3hrs', 'compulsory', '3', '2', 'lab', 15530),
(36, 'Design and Analysis of Algorithms', 'CMT 309', 2, '3hrs', 'compulsory', '3', '2', 'lab', 15530),
(37, 'Fundamentals of Software Engineering', 'CMT 311', 2, '3hrs', 'compulsory', '3', '2', 'lab', 15530),
(38, 'Computer Graphics', 'CMT 313', 2, '3hrs', 'compulsory', '3', '2', 'lab', 15530),
(39, 'Human Computer Interface', 'CMT 316', 2, '3hrs', 'compulsory', '3', '2', 'lab', 15530),
(40, 'Industrial Attachment', 'CMT 312', 2, '3hrs', 'compulsory', '3', '2', 'open', 15530),
(41, 'Research Project', 'CMT 400', 2, '3hrs', 'compulsory', '4', '1', 'open', 15530),
(42, 'ICT & Society', 'CMT 406', 2, '3hrs', 'compulsory', '4', '1', 'room', 15530),
(43, 'Software Project Management', 'CMT 408', 2, '3hrs', 'compulsory', '4', '1', 'lab', 15530),
(44, 'Network Programming', 'CMT 410', 2, '3hrs', 'distributed systems', '4', '1', 'lab', 15530),
(45, 'Distributed Operating System', 'CMT 412', 2, '3hrs', 'distributed systems', '4', '1', 'lab', 15530),
(46, 'Network Design and Administration', 'CMT 413', 2, '3hrs', 'distributed systems', '4', '1', 'lab', 15530),
(47, 'Client Server Systems and Computing', 'CMT 416', 2, '3hrs', 'distributed systems', '4', '1', 'lab', 15530),
(48, 'Accounting Information Systems', 'CMT 414', 2, '3hrs', 'software engineering', '4', '1', 'lab', 15530),
(49, 'CAD/CAM Techniques', 'CMT 415', 2, '3hrs', 'software engineering', '4', '1', 'lab', 15530),
(50, 'Multimedia Systems', 'CMT 418', 2, '3hrs', 'software engineering', '4', '1', 'lab', 15530),
(51, 'Software Engineering Techniques', 'CMT 422', 2, '3hrs', 'software engineering', '4', '1', 'lab', 15530),
(52, 'Sysetms Programming', 'CMT 420', 2, '3hrs', 'computer architecture', '4', '1', 'lab', 15530),
(53, 'Advanced Computer Architecture', 'CMT 430', 2, '3hrs', 'computer architecture', '4', '1', 'lab', 15530),
(54, 'Simulations and Modeling', 'CMT 431', 2, '3hrs', 'computer architecture', '4', '1', 'lab', 15530),
(55, 'Compiler Construction', 'CMT 433', 2, '3hrs', 'computer architecture', '4', '1', 'lab', 15530),
(56, 'Decision Support Systems', 'CMT 411', 2, '3hrs', 'artificial intelligence', '4', '1', 'lab', 15530),
(57, 'Natural Language Processing', 'CMT 424', 2, '3hrs', 'artificial intelligence', '4', '1', 'lab', 15530),
(58, 'Knowledge Based System', 'CMT 427', 2, '3hrs', 'artificial intelligence', '4', '1', 'lab', 15530),
(59, 'Advanced Artificial Intelligence', 'CMT 440', 2, '3hrs', 'artificial intelligence', '4', '1', 'lab', 15530),
(60, 'Game Programming', 'CMT 444', 2, '3hrs', 'graphics and visual computing', '4', '1', 'lab', 15530),
(61, 'Information Systems Management', 'CMT 403', 2, '3hrs', 'compulsory', '4', '2', 'lab', 15530),
(62, 'Information Systems Security', 'CMT 405', 2, '3hrs', 'compulsory', '4', '2', 'lab', 15530),
(63, 'Advanced Web Development', 'CMT 417', 2, '3hrs', 'distributed systems', '4', '2', 'lab', 15530),
(64, 'Parallel Computing', 'CMT 421', 2, '3hrs', 'distributed systems', '4', '2', 'lab', 15530),
(65, 'Information Systems Audit', 'CMT 446', 2, '3hrs', 'distributed systems', '4', '2', 'lab', 15530),
(66, 'Web Application Security', 'CMT 447', 2, '3hrs', 'distributed systems', '4', '2', 'lab', 15530),
(67, 'Electronic Commerce', 'CMT 423', 2, '3hrs', 'software engineering', '4', '2', 'lab', 15530),
(68, 'Statistical Data Analysis', 'CMT 425', 2, '3hrs', 'software engineering', '4', '2', 'lab', 15530),
(69, 'Business Intelligence', 'CMT 445', 2, '3hrs', 'software engineering', '4', '2', 'lab', 15530),
(70, 'Automata and Languages', 'CMT 435', 2, '3hrs', 'computer architecture', '4', '2', 'lab', 15530),
(71, 'Signal Processing', 'CMT 442', 2, '3hrs', 'computer architecture', '4', '2', 'lab', 15530),
(72, 'Assembly Language Programming', 'CMT 425', 2, '3hrs', 'computer architecture', '4', '2', 'lab', 15530),
(73, 'Logic Programming', 'CMT 441', 2, '3hrs', 'artificial intelligence', '4', '2', 'lab', 15530),
(74, 'Neural Networks', 'CMT 442', 2, '3hrs', 'artificial intelligence', '4', '2', 'lab', 15530),
(75, 'Data Mining', 'CMT 443', 2, '3hrs', 'artificial intelligence', '4', '2', 'lab', 15530),
(84, 'ordinary differential equations', 'MAT 363', 1, '3hrs', 'math', '3', '2', 'room', 15530);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_id` int(11) NOT NULL,
  `first_name` varchar(60) DEFAULT NULL,
  `last_name` varchar(60) DEFAULT NULL,
  `other_names` varchar(60) DEFAULT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `user_img` varchar(255) NOT NULL DEFAULT 'images/default_user.jpg',
  PRIMARY KEY (`id`),
  KEY `login_id` (`login_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `login_id`, `first_name`, `last_name`, `other_names`, `phone_number`, `user_img`) VALUES
(2, 2, 'Lois', 'Lane', NULL, 56551816, 'images/default_user.jpg'),
(3, 3, 'Bruce', 'Wayne', NULL, 8151265, 'images/default_user.jpg'),
(6, 8, 'Diana', 'Prince', '', 852415, 'images/default_user.jpg'),
(9, 11, 'Tony', 'Stark', 'Iron Man', 752, 'images/default_user.jpg'),
(11, 13, 'Barry', 'Allen', '', 84168, 'images/default_user.jpg'),
(12, 14, 'Keanu', 'Reeves', 'John Wick', 55584646, 'images/default_user.jpg'),
(13, 15, 'Tom', 'Lang', 'Ant Man', 5454, 'images/default_user.jpg'),
(20, 22, 'Johnny', 'Test', '', 789456, 'images/default_user.jpg'),
(21, 23, 'Jim', 'Gordon', '', 85584, 'images/default_user.jpg'),
(22, 24, 'Oliver', 'Queen', 'Green Arrow', 65165165, 'images/default_user.jpg'),
(23, 25, 'Lex', 'Luther', '', 45, 'images/default_user.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

DROP TABLE IF EXISTS `venues`;
CREATE TABLE IF NOT EXISTS `venues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(30) NOT NULL,
  `venue_type` enum('hall','lab','room') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `venue_name`, `venue_type`) VALUES
(1, 'TH LAB A', 'lab'),
(2, 'TH LAB B', 'lab'),
(3, 'OH 14', 'room'),
(4, 'OH LAB', 'room'),
(5, 'JH Upper LAB', 'lab'),
(6, 'OH 22', 'room'),
(8, 'JH Lower LAB', 'lab'),
(9, 'LRC LAB', 'lab');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
