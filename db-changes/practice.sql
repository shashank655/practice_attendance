-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2019 at 04:14 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `practice`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes_name`
--

CREATE TABLE `classes_name` (
  `id` int(11) NOT NULL,
  `class_name` varchar(220) DEFAULT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes_name`
--

INSERT INTO `classes_name` (`id`, `class_name`, `createdDate`) VALUES
(1, 'class 1', '2019-04-26 11:22:53'),
(2, 'class 2', '2019-04-03 00:57:25'),
(4, 'class 4', '2019-04-03 00:57:31'),
(5, 'class 6', '2019-04-22 03:16:19'),
(6, 'class 8', '2019-04-27 10:24:32'),
(7, 'Class 10', '2019-04-28 00:59:43'),
(8, 'Class 9', '2019-05-04 03:04:21'),
(9, 'class 3', '2019-05-17 04:18:04'),
(10, 'Nursery', '2019-05-17 04:20:56'),
(11, 'Kindergarten', '2019-05-17 04:21:28'),
(12, 'Class 5', '2019-05-17 04:22:03'),
(13, 'Class 7', '2019-05-17 04:22:34'),
(14, 'Class 11', '2019-05-17 04:23:22'),
(15, 'Class 12', '2019-05-17 04:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `start_event`, `end_event`) VALUES
(1, 'Test Event', '2019-05-01 00:00:00', '2019-05-02 00:00:00'),
(2, 'Test 2 event', '2019-04-01 00:00:00', '2019-04-02 00:00:00'),
(3, 'Thursday', '2019-04-03 00:00:00', '2019-04-04 00:00:00'),
(4, 'Diwali', '2019-05-16 00:00:00', '2019-05-17 00:00:00'),
(5, 'Eid', '2019-05-13 00:00:00', '2019-05-14 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `exams_list`
--

CREATE TABLE `exams_list` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `date_of_exam` varchar(200) NOT NULL,
  `exam_name` varchar(200) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exams_list`
--

INSERT INTO `exams_list` (`id`, `class_id`, `section_id`, `date_of_exam`, `exam_name`, `createdDate`) VALUES
(7, 6, 27, '26/04/2019', 'Hindi', '2019-04-28 06:20:42'),
(8, 5, 11, '18/04/2019', 'Maths', '2019-04-28 06:19:05'),
(10, 7, 31, '30/04/2019', 'EVS', '2019-04-28 06:30:02'),
(11, 5, 10, '29/06/2019', 'Computer', '2019-05-01 14:43:05'),
(12, 2, 4, '23/05/2019', 'Hindi edit', '2019-05-17 15:38:07'),
(13, 2, 4, '31/05/2019', 'Hindi edit', '2019-05-17 15:38:19'),
(14, 1, 36, '29/05/2019', 'dsdsdsdsdsdsdsds', '2019-05-25 07:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(11) NOT NULL,
  `holiday_name` varchar(255) DEFAULT NULL,
  `holiday_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `holiday_name`, `holiday_date`) VALUES
(1, 'Test Holiday', '25/04/2019'),
(2, 'Diwali', '30/04/2019');

-- --------------------------------------------------------

--
-- Table structure for table `leaves_request`
--

CREATE TABLE `leaves_request` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `number_of_days` varchar(100) DEFAULT NULL,
  `effective_from` varchar(100) DEFAULT NULL,
  `effective_to` varchar(100) DEFAULT NULL,
  `reason_to_leave` varchar(200) DEFAULT NULL,
  `send_note` varchar(255) DEFAULT NULL,
  `leaveAttachmentName` text,
  `leave_status` varchar(100) NOT NULL DEFAULT '0' COMMENT '0->pending, 1->approve, 2->rejected',
  `notify_status` varchar(100) NOT NULL DEFAULT '0' COMMENT '0->unread , 1->read',
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leaves_request`
--

INSERT INTO `leaves_request` (`id`, `userId`, `leave_type_id`, `number_of_days`, `effective_from`, `effective_to`, `reason_to_leave`, `send_note`, `leaveAttachmentName`, `leave_status`, `notify_status`, `createdDate`) VALUES
(1, 4, 3, '4', '22/05/2019', NULL, 'going out of town.', NULL, NULL, '1', '1', '2019-05-03 15:50:28'),
(2, 4, 2, '1', '30/05/2019', NULL, 'Getting married.', NULL, NULL, '0', '1', '2019-05-03 15:09:04'),
(4, 4, 4, '1', '30/05/2019', NULL, 'going out of town.', NULL, NULL, '1', '1', '2019-05-03 15:09:04'),
(5, 4, 5, '1', '25/05/2019', NULL, 'going out of town.', NULL, NULL, '1', '1', '2019-05-03 15:09:04'),
(6, 5, 3, '4', '29/05/2019', NULL, 'going out of town.', NULL, NULL, '2', '1', '2019-05-03 15:09:04'),
(7, 5, 5, '4', '27/05/2019', NULL, 'Getting married.', NULL, NULL, '2', '1', '2019-05-03 15:09:04'),
(8, 4, 6, '1', '23/05/2019', NULL, 'due to 15 August', NULL, NULL, '2', '1', '2019-05-03 15:50:55'),
(9, 4, 3, '2', '30/05/2019', NULL, 'due to fever', NULL, NULL, '1', '1', '2019-05-03 15:25:53'),
(10, 4, 2, '2', '23/05/2019', NULL, 'New Leave from Shashank Garg', NULL, NULL, '2', '1', '2019-05-03 15:55:21'),
(11, 5, 2, '2', '17/05/2019', NULL, 'New Leave from Megha Gupta', NULL, NULL, '2', '1', '2019-05-03 15:54:00'),
(12, 4, 3, '1', '14/05/2019', NULL, 'Again Shashank Applied.', NULL, NULL, '2', '1', '2019-05-03 15:56:29'),
(14, 4, 2, '1', '18/05/2019', '19/05/2019', 'Getting married.', NULL, NULL, '2', '1', '2019-05-18 05:54:15'),
(15, 6, 3, '1', '19/05/2019', '20/05/2019', 'due to 15 August', NULL, NULL, '2', '1', '2019-05-19 03:54:45'),
(16, 6, 5, '1', '22/05/2019', '22/05/2019', 'Getting married.', NULL, NULL, '1', '1', '2019-05-21 16:25:36'),
(17, 6, 2, '1', '26/05/2019', '27/05/2019', 'going out of town.', NULL, '1558849493download.jpg', '2', '1', '2019-05-26 05:47:48'),
(18, 6, 2, '1', '28/05/2019', '29/05/2019', 'stomack pain.', NULL, '1558849593images (1).jpg', '1', '1', '2019-05-26 05:47:48'),
(19, 6, 2, '1', '15/05/2019', '23/05/2019', 'stomack pain.', '', '1558849737download.jpg', '1', '1', '2019-05-26 13:51:42'),
(20, 6, 2, '1', '28/05/2019', '30/05/2019', 'going out of town.', 'You have approved.', '1558877971images (1).jpg', '1', '1', '2019-05-26 13:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int(11) NOT NULL,
  `leave_type` varchar(230) DEFAULT NULL,
  `days` varchar(100) DEFAULT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `leave_type`, `days`, `createdDate`) VALUES
(2, 'Casual Leave', '30', '2019-04-27 16:32:27'),
(3, 'Sick Leave', '20', '2019-04-27 16:33:48'),
(4, 'matertinity', '5', '2019-05-01 16:10:13'),
(5, 'P L ', '12', '2019-05-02 15:52:56'),
(6, 'National Holiday', '2', '2019-05-03 14:42:01');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_name` varchar(220) DEFAULT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `class_id`, `section_name`, `createdDate`) VALUES
(9, 5, 'Section A', '2019-04-22 03:16:19'),
(10, 5, 'Section B', '2019-04-22 03:16:19'),
(11, 5, 'Section C', '2019-04-22 03:16:19'),
(29, 7, 'Section A', '2019-04-28 00:59:43'),
(30, 7, 'Section B', '2019-04-28 00:59:43'),
(31, 7, 'Section E', '2019-04-28 00:59:43'),
(32, 2, 'Section A', '2019-05-17 04:18:41'),
(33, 2, 'Section B', '2019-05-17 04:18:41'),
(34, 2, 'Section C', '2019-05-17 04:18:41'),
(35, 1, 'Section A', '2019-05-17 04:18:55'),
(36, 1, 'Section B', '2019-05-17 04:18:55'),
(37, 1, 'Section C', '2019-05-17 04:18:55'),
(38, 1, '', '2019-05-17 04:18:55'),
(39, 4, 'Section A', '2019-05-17 04:19:20'),
(40, 4, 'Section B', '2019-05-17 04:19:20'),
(41, 4, 'Section C', '2019-05-17 04:19:20'),
(42, 6, 'Sec A', '2019-05-17 04:19:46'),
(43, 6, 'Sec B', '2019-05-17 04:19:46'),
(44, 6, 'Section C', '2019-05-17 04:19:46'),
(45, 8, 'Section A', '2019-05-17 04:20:08'),
(46, 8, 'Section B', '2019-05-17 04:20:08'),
(47, 8, 'Section C', '2019-05-17 04:20:08'),
(48, 9, 'Section A', '2019-05-17 04:20:28'),
(49, 9, 'Section B', '2019-05-17 04:20:28'),
(50, 9, 'Section C', '2019-05-17 04:20:28'),
(51, 10, 'Section A', '2019-05-17 04:20:56'),
(52, 10, 'Section B', '2019-05-17 04:20:56'),
(53, 10, 'Section C', '2019-05-17 04:20:56'),
(54, 11, 'Section A', '2019-05-17 04:21:28'),
(55, 11, 'Section B', '2019-05-17 04:21:28'),
(56, 11, 'Section C', '2019-05-17 04:21:28'),
(57, 12, 'Section A', '2019-05-17 04:22:03'),
(58, 12, 'Section B', '2019-05-17 04:22:03'),
(59, 12, 'Section C', '2019-05-17 04:22:03'),
(60, 13, 'Section A', '2019-05-17 04:22:34'),
(61, 13, 'Section B', '2019-05-17 04:22:34'),
(62, 13, 'Section C', '2019-05-17 04:22:34'),
(63, 14, 'Section A', '2019-05-17 04:23:22'),
(64, 14, 'Section B', '2019-05-17 04:23:22'),
(65, 14, 'Section C', '2019-05-17 04:23:22'),
(66, 15, 'Section A', '2019-05-17 04:23:44'),
(67, 15, 'Section B', '2019-05-17 04:23:44'),
(68, 15, 'Section C', '2019-05-17 04:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `dob` varchar(150) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `date_of_joining` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(200) DEFAULT NULL,
  `admission_no` varchar(200) DEFAULT NULL,
  `roll_number` varchar(200) DEFAULT NULL,
  `fathers_name` varchar(255) DEFAULT NULL,
  `fathers_occupation` varchar(200) DEFAULT NULL,
  `parents_mobile_number` varchar(255) DEFAULT NULL,
  `present_address` text,
  `mothers_name` varchar(255) DEFAULT NULL,
  `mothers_occupation` varchar(200) DEFAULT NULL,
  `nationality` varchar(200) DEFAULT NULL,
  `permanent_address` text,
  `student_profile_image` text,
  `parents_profile_image` text,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `email_address`, `gender`, `dob`, `class_id`, `section_id`, `religion`, `date_of_joining`, `mobile_number`, `admission_no`, `roll_number`, `fathers_name`, `fathers_occupation`, `parents_mobile_number`, `present_address`, `mothers_name`, `mothers_occupation`, `nationality`, `permanent_address`, `student_profile_image`, `parents_profile_image`, `createdDate`) VALUES
(1, 'Sunil', 'Chatterji', 'sunilchatterji@gmail.com', 'male', '11/04/1989', 11, 54, 'Hindi', '12/03/2019', '8970235587', 'sdf', '45678', 'Pawan Chatterji', 'Self employed', '9149228094', 'WEISESTR 10', 'Beena Chatterji', 'House Wife', 'India', '73/2 Dharampur 1\r\nP/O Araghar', '1556958807seeds-germinate-soil_m.jpg', '1556958807pro3.jpg', '2019-05-19 06:07:35'),
(2, 'Sophia', 'Lily', 'sophia@gmail.com', 'female', '17/06/2009', 6, 0, 'Christian', '06/05/2019', '8970235587', '455566', '22', 'Jonathan', 'self employeed', '8970235587', 'WEISESTR 10', 'Claudia', 'House Wife', 'Italian', '82\r\nNeshvilla road,', '1558090299screenshot 2019-05-09 at 6.06.25 pm.png', '', '2019-05-17 05:21:39'),
(3, 'Abhinav', 'Gupta', 'viveksnghbb007@gmail.com', 'male', '08/06/2005', 6, 43, 'Hindu', '06/05/2019', '9998889087', 'sdf', 'sdfs', 'Rajesh', 'Government Employee', '9998889087', '1703', 'Gupta', 'Teacher', 'Indian', 'WEISESTR 10', '1558159208download.jpg', '', '2019-05-18 06:00:08'),
(4, 'Archana', 'Dehal', 'archana@gmail.com', 'female', '23/08/2000', 6, 43, 'Hindu', '12/02/2019', '92827262524', 'sfsgg', 'sggge', 'Arun', 'Engineer', '92827262524', '24 Araghar', 'Dehal', 'House Wife', 'Indian', '24 Araghar', '1558091670logo.png', '', '2019-05-20 16:43:04'),
(5, 'Ankesh', 'Gupta', 'brijesh@gmail.com', 'male', '14/01/2003', 15, 0, 'Hindu', '11/07/2016', '90008972330', 'jkjkg', 'heertd', 'Brijesh Gupta', 'Municipal Corporate', '90008972330', '73/2 Dharampur 1, Haridwar road', 'Urmila Gupta', 'Doctor', 'India', '82\r\nNeshvilla road,', '1558092162cashew.png', '', '2019-05-17 05:52:42'),
(6, 'Tiara', 'Wason', 'tiara@gmail.com', 'female', '15/05/2013', 11, 54, 'Hindu', '14/02/2018', '9897090909', 'sggjww', 'dgsfsf', 'Varun Wason', 'Bank manager', '9897090909', '89 Race course, Near Rita ice cream factory', 'Ankita Wason', 'Teacher', 'Indian', '89 Race course, Near Rita ice cream factory', '1558093519story-slider-1.jpg', '', '2019-05-19 06:08:02'),
(7, 'Devansh', 'Aggarwal', 'devansh@gmail.com', 'male', '14/06/2012', 6, 44, 'Hindu', '13/06/2017', '9719233488', 'llsoss', '78', 'Vikram Aggarwal', 'Business Owner', '9719233488', '56 Rajupur Road opp Astley Hall', 'Megha Arora', 'Business Owner', 'Indian', 'Winlass Residency, nehru road', '1558093776story-slider-2.jpg', '', '2019-05-17 06:19:36'),
(8, 'Akash', 'Tomar', 'akash@virtuaal.in', 'male', '16/06/2005', 5, 10, 'Hindu', '15/07/2014', '7409441630', 'yuifjj', 'kjssjss', 'Jayant Tomar', 'Professional writer', '7409441630', '82\r\nNeshvilla road,', 'Neelam Tomar', 'Activist', 'Indian', '82\r\nNeshvilla road,', '1558094335logo.png', '', '2019-05-17 06:28:55'),
(9, 'Rohit ', 'Kanaujia', 'rohitkanaujia@yahoo.in', 'male', '19/03/2008', 4, 40, 'Hindu', '24/02/2016', '8970235587', 'bbnwwr', 'rwwnbb', 'Yogesh Kanaujia', 'Army', '8970235587', 'WEISESTR 10', 'Mamta Kanujia', 'House Wife', 'Indian', '82\r\nNeshvilla road,', '1558094486b-product-30.jpg', '', '2019-05-17 06:31:26'),
(10, 'Preeti', 'Chaudhary', 'preeti@yahoo.in', 'female', '15/05/2019', 6, 43, 'Hindu', '13/02/2018', '09149228094', 'lpoi', 'juih', 'Akhilesh Chaudhary', '', '09149228094', '82\r\nNeshvilla Road, Chukkuwala', 'Nootan Chaudhary', '', 'India', '82\r\nNeshvilla road,', '1558095056product-4.jpg', '', '2019-05-17 06:40:56'),
(11, 'Vandhana', 'Chauhan', 'vandana@gmail.com', 'female', '20/09/2000', 11, 54, 'Hindu', '14/02/2017', '8970235587', 'oooii', 'iiooo', 'Mamchand Chauhan', 'Government Employee', '8970235587', 'WEISESTR 10', 'Momita Chauhan', 'House Wife', 'Indian', '73/2 Dharampur 1\r\nP/O Araghar', '1558096548b-product-36.jpg', '', '2019-05-19 06:08:28'),
(12, 'Sarah', 'Kamal', 'sarah@gmail.com', 'female', '21/08/2008', 12, 58, 'Muslim', '12/06/2017', '09149228094', 'tuee', 'eeut', 'Hussain Kamal', 'Self Employeed', '09149228094', '82\r\nNeshvilla Road, Chukkuwala', 'Bushra Kamal', 'Doctor', 'India', '1703', '1558096876b-product-28.jpg', '', '2019-05-17 07:11:16'),
(13, 'Sagar', 'Malhotra', 'deep@yahoo.in', 'male', '06/07/2000', 15, 67, 'Hindu', '11/06/2018', '8970235587', 'bbdfg', 'swrs', ' Deep Malhotra', 'Business Owner', '8970235587', 'WEISESTR 10', 'Swati Malhotra', 'Government employee', 'Indian', '82\r\nNeshvilla road,', '1558097287b-product-24.jpg', '', '2019-05-17 07:18:07'),
(14, 'Ashima', 'Khan', 'ashima@gmail.com', 'female', '16/06/2004', 2, 33, 'Muslim', '18/02/2008', '09149228094', 'fffs', 'gwrwr', 'Farhan', 'Self Employeed', '9149228094', '82\r\nNeshvilla Road, Chukkuwala', 'Khan', 'House Wife', 'India', '82\r\nNeshvilla road,', '1558097441b-product-32.jpg', '', '2019-05-17 07:20:41'),
(15, 'Priya', 'Bhist', 'priya@gmail.com', 'female', '08/06/2004', 15, 67, 'Hindu', '13/02/2007', '8970235587', 'uughh', 'hhraa', 'Girish Bhist', 'Teacher', '914228075', 'WEISESTR 10', 'Urvashi Bhist', 'Doctor', 'India', 'Dehradun, Uttarakhand, India', '1558097615b-product-31.jpg', '', '2019-05-17 07:23:35'),
(16, 'Tim', 'Ingall', 'tim@gmail.com', 'male', '24/05/2007', 11, 54, 'Hindu', '15/02/2010', '8970235587', 'hhhh', 'ddd', 'Chris Ingall', 'Industrialist', '9149228094', 'WEISESTR 10', 'Martha Ingall', 'Business Owner', 'England', '73/2 Dharampur 1\r\nP/O Araghar', '1558097811product-3.jpg', '', '2019-05-19 06:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `students_attendance`
--

CREATE TABLE `students_attendance` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `date_of_attendance` varchar(200) NOT NULL,
  `attendance` varchar(50) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students_attendance`
--

INSERT INTO `students_attendance` (`id`, `class_id`, `section_id`, `student_id`, `teacher_id`, `date_of_attendance`, `attendance`, `createdDate`) VALUES
(1, 1, 20, 1, 4, '2019-05-10', 'A', '2019-05-15 14:40:22'),
(2, 1, 20, 2, 4, '2019-05-10', 'P', '2019-05-15 14:40:25'),
(7, 1, 20, 1, 4, '2019-05-13', 'A', '2019-05-15 14:40:31'),
(8, 1, 20, 2, 4, '2019-05-13', 'P', '2019-05-15 14:40:28'),
(9, 1, 20, 1, 4, '2019-05-14', 'P', '2019-05-15 14:40:34'),
(10, 1, 20, 3, 4, '2019-05-14', 'A', '2019-05-15 14:40:36'),
(11, 1, 20, 1, 4, '2019-05-15', 'P', '2019-05-15 15:12:01'),
(12, 1, 20, 2, 4, '2019-05-15', 'A', '2019-05-15 15:12:53'),
(13, 1, 20, 3, 4, '2019-05-15', 'P', '2019-05-15 15:12:01'),
(14, 5, 10, 4, 5, '2019-05-15', 'P', '2019-05-15 15:39:04'),
(15, 1, 20, 1, 4, '2019-05-16', 'P', '2019-05-16 16:09:10'),
(16, 1, 20, 2, 4, '2019-05-16', 'A', '2019-05-16 16:09:10'),
(17, 1, 20, 3, 4, '2019-05-16', 'P', '2019-05-16 16:09:10'),
(18, 1, 20, 1, 4, '2019-05-17', 'P', '2019-05-17 15:16:28'),
(19, 1, 20, 2, 4, '2019-05-17', 'A', '2019-05-17 15:16:28'),
(20, 1, 20, 3, 4, '2019-05-17', 'P', '2019-05-17 15:16:28'),
(23, 6, 43, 3, 10, '2019-05-18', 'A', '2019-05-18 06:08:23'),
(24, 6, 43, 1, 10, '2019-05-18', 'A', '2019-05-18 06:08:23'),
(25, 5, 10, 8, 6, '2019-05-19', 'P', '2019-05-19 03:45:01'),
(34, 11, 54, 1, 8, '2019-05-19', 'P', '2019-05-19 06:30:53'),
(35, 11, 54, 6, 8, '2019-05-19', 'A', '2019-05-19 06:30:53'),
(36, 11, 54, 11, 8, '2019-05-19', 'A', '2019-05-19 06:30:53'),
(37, 11, 54, 16, 8, '2019-05-19', 'P', '2019-05-19 06:30:54'),
(45, 6, 43, 3, 10, '2019-05-20', 'P', '2019-05-20 16:02:19'),
(46, 6, 43, 10, 10, '2019-05-20', 'A', '2019-05-20 16:02:19'),
(47, 5, 10, 8, 6, '2019-05-21', 'A', '2019-05-21 16:15:00'),
(48, 5, 10, 8, 6, '2019-05-22', 'P', '2019-05-22 14:31:07'),
(49, 6, 43, 3, 10, '2019-05-22', 'P', '2019-05-22 14:32:32'),
(50, 6, 43, 4, 10, '2019-05-22', 'P', '2019-05-22 14:32:32'),
(51, 6, 43, 10, 10, '2019-05-22', 'P', '2019-05-22 14:32:32'),
(52, 6, 43, 3, 10, '2019-05-26', 'A', '2019-05-26 05:32:55'),
(53, 6, 43, 4, 10, '2019-05-26', 'A', '2019-05-26 05:32:55'),
(54, 6, 43, 10, 10, '2019-05-26', 'A', '2019-05-26 05:32:55'),
(55, 5, 10, 8, 6, '2019-05-26', 'P', '2019-05-26 13:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(230) DEFAULT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `createdDate`) VALUES
(1, 'Computer', '2019-04-26 10:05:00'),
(2, 'Science', '2019-04-02 04:15:45'),
(3, 'Maths', '2019-04-02 04:15:47'),
(4, 'Hindi', '2019-04-02 04:15:50'),
(5, 'English', '2019-04-02 04:15:54'),
(6, 'Social Science', '2019-04-02 04:15:56'),
(8, 'Hindi 2', '2019-04-26 09:53:48'),
(9, 'biology', '2019-04-30 07:36:02'),
(10, 'Chemistry', '2019-05-04 03:04:34'),
(11, 'Art', '2019-05-17 04:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `dob` varchar(200) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `is_class_teacher` varchar(50) DEFAULT NULL,
  `joining_date` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `subject_id` varchar(100) DEFAULT NULL,
  `teacher_id` varchar(255) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `permanent_address` varchar(255) DEFAULT NULL,
  `profile_image` text,
  `createdDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `gender`, `dob`, `class_id`, `is_class_teacher`, `joining_date`, `mobile_number`, `subject_id`, `teacher_id`, `section_id`, `permanent_address`, `profile_image`, `createdDate`) VALUES
(1, 2, '', '13/03/1990', 7, '', '01/04/2019', '8755097828', '3', '123456', 30, '73/2 Dharampur 1\r\nP/O Araghar', '1557132467pro2.jpg', NULL),
(2, 3, 'female', '19/02/1992', 11, '0', '12/05/2019', '8970235587', '4', '23456', 54, 'WEISESTR 10', '1558796303images.jpg', NULL),
(3, 4, '', '20/08/2018', 6, '', '13/06/2017', '09149228094', '5', '123456', 27, '82\r\nNeshvilla Road, Chukkuwala', '1557132418pro5.jpg', NULL),
(4, 5, '', '03/06/1981', 7, '', '16/06/2015', '8970235587', '6', '23456', 30, 'WEISESTR 10', '1557132906pro.jpg', NULL),
(5, 6, 'female', '15/07/1987', 5, '1', '15/11/2018', '9598973008', '9', '99909', 10, 'WEISESTR 10', '1558796239images (1).jpg', NULL),
(6, 7, 'male', '25/08/1991', 7, '0', '20/05/2017', '8126254945', '3', '123456', 30, '73/ Dharampur 1', '', NULL),
(7, 8, 'male', '25/08/1991', 11, '1', '30/05/2016', '7617777755', '5', '788889', 54, 'WEISESTR 10', '', NULL),
(8, 9, 'male', '17/05/2019', 7, '0', '02/07/2016', '8477999993', '1', '898844', 30, '18 Araghar', '', NULL),
(9, 10, 'female', '04/03/1975', 6, '1', '28/05/2016', '7579461538', '6', '90034', 43, '23 Rajpur Road', '1558795803download (1).jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers_attendance`
--

CREATE TABLE `teachers_attendance` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `date_of_attendance` varchar(200) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachers_attendance`
--

INSERT INTO `teachers_attendance` (`id`, `teacher_id`, `date_of_attendance`, `login_time`) VALUES
(1, 6, '2019-05-27', '2019-05-19 16:02:04'),
(2, 6, '2019-05-19', '2019-05-19 15:12:31'),
(3, 6, '2019-05-20', '2019-05-19 16:03:08'),
(4, 10, '2019-05-19', '2019-05-19 15:13:13'),
(5, 3, '2019-05-19', '2019-05-19 15:15:11'),
(6, 3, '2019-05-20', '2019-05-20 15:44:37'),
(7, 10, '2019-05-20', '2019-05-20 15:44:52'),
(8, 6, '2019-05-21', '2019-05-21 15:59:57'),
(9, 3, '2019-05-21', '2019-05-21 16:12:32'),
(10, 6, '2019-05-22', '2019-05-22 14:30:54'),
(11, 2, '2019-05-22', '2019-05-22 14:32:00'),
(12, 10, '2019-05-22', '2019-05-22 14:32:23'),
(13, 5, '2019-05-22', '2019-05-22 14:32:58'),
(14, 6, '2019-05-25', '2019-05-25 06:16:48'),
(15, 10, '2019-05-25', '2019-05-25 14:38:45'),
(16, 3, '2019-05-25', '2019-05-25 14:53:03'),
(17, 4, '2019-05-25', '2019-05-25 15:16:44'),
(18, 8, '2019-05-25', '2019-05-25 15:17:02'),
(19, 6, '2019-05-26', '2019-05-26 05:24:02'),
(20, 10, '2019-05-26', '2019-05-26 05:31:51'),
(21, 3, '2019-05-26', '2019-05-26 05:33:11');

-- --------------------------------------------------------

--
-- Table structure for table `teachers_password`
--

CREATE TABLE `teachers_password` (
  `id` int(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachers_password`
--

INSERT INTO `teachers_password` (`id`, `password`, `created`) VALUES
(1, 'Adhyay123*', '2019-05-18 05:36:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `user_name` varchar(200) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `password` text,
  `user_role` varchar(100) DEFAULT NULL,
  `admin_profile_image` text,
  `school_name` varchar(200) DEFAULT NULL,
  `phone_number` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `designation` varchar(200) DEFAULT NULL,
  `email_verification` int(11) DEFAULT '0',
  `createdDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `user_name`, `email_address`, `password`, `user_role`, `admin_profile_image`, `school_name`, `phone_number`, `address`, `designation`, `email_verification`, `createdDate`) VALUES
(1, 'Danny', 'Veigraj', NULL, 'dannyveigrajbb007@gmail.com', 'e13f8c488ac89c7363d7c5ca5c7f01dc', '1', '1558796211download (3).jpg', 'Doon School', '914922809400', '82, Neshvilla Road, Chukkuwala', 'Principal', 1, NULL),
(2, 'Shashank', 'Garg', NULL, 'shashankgarg655@gmail.com', '795a11e4944b8cabe54df2f7271063e8', '2', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(3, 'Vishakha', 'Vishakha', NULL, 'vishakha0412@gmail.com', '795a11e4944b8cabe54df2f7271063e8', '3', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(4, 'Akanksha ', 'Aggarwal', NULL, 'akankshaaggarwal01@gmail.com', '795a11e4944b8cabe54df2f7271063e8', '2', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(5, 'Vikram ', 'Aggarwal', NULL, 'vikramAggarwal@virtuaal.in', '795a11e4944b8cabe54df2f7271063e8', '2', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(6, 'Meenakshi', 'Shahani', NULL, 'meenakshi@virtuaal.in', '795a11e4944b8cabe54df2f7271063e8', '2', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(7, 'Kartik ', 'Veigraj', NULL, 'viveksnghbb007@gmail.com', '795a11e4944b8cabe54df2f7271063e8', '3', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(8, 'Hemant ', 'Pahwa', NULL, 'hemant@gmail.com', '795a11e4944b8cabe54df2f7271063e8', '2', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(9, 'Prashant ', 'Pahwa', NULL, 'prahsantpahwa@gmail.com', '795a11e4944b8cabe54df2f7271063e8', '3', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(10, 'Anita', 'Jain', NULL, 'ashraddheya@gmail.com', '795a11e4944b8cabe54df2f7271063e8', '2', NULL, NULL, NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `role` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `role`) VALUES
(1, 'superAdmin'),
(2, 'classTeacher'),
(3, 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes_name`
--
ALTER TABLE `classes_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams_list`
--
ALTER TABLE `exams_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves_request`
--
ALTER TABLE `leaves_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_attendance`
--
ALTER TABLE `students_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers_attendance`
--
ALTER TABLE `teachers_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers_password`
--
ALTER TABLE `teachers_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes_name`
--
ALTER TABLE `classes_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exams_list`
--
ALTER TABLE `exams_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leaves_request`
--
ALTER TABLE `leaves_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `students_attendance`
--
ALTER TABLE `students_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teachers_attendance`
--
ALTER TABLE `teachers_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `teachers_password`
--
ALTER TABLE `teachers_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
