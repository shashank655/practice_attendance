-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2019 at 06:40 PM
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
(1, 'class 1', '2019-04-26 16:52:53'),
(2, 'class 2', '2019-04-03 06:27:25'),
(4, 'class 4', '2019-04-03 06:27:31'),
(5, 'class 6', '2019-04-22 08:46:19'),
(6, 'class 8', '2019-04-27 15:54:32'),
(7, 'Class 10', '2019-04-28 06:29:43');

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
(3, 'Thursday', '2019-04-03 00:00:00', '2019-04-04 00:00:00');

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
(11, 5, 10, '29/06/2019', 'Computer', '2019-05-01 14:43:05');

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
  `reason_to_leave` varchar(200) DEFAULT NULL,
  `leave_status` varchar(100) NOT NULL DEFAULT '0' COMMENT '0->pending, 1->approve, 2->rejected',
  `notify_status` varchar(100) NOT NULL DEFAULT '0' COMMENT '0->unread , 1->read',
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leaves_request`
--

INSERT INTO `leaves_request` (`id`, `userId`, `leave_type_id`, `number_of_days`, `effective_from`, `reason_to_leave`, `leave_status`, `notify_status`, `createdDate`) VALUES
(1, 4, 3, '4', '22/05/2019', 'going out of town.', '1', '1', '2019-05-03 15:50:28'),
(2, 4, 2, '1', '30/05/2019', 'Getting married.', '0', '1', '2019-05-03 15:09:04'),
(4, 4, 4, '1', '30/05/2019', 'going out of town.', '1', '1', '2019-05-03 15:09:04'),
(5, 4, 5, '1', '25/05/2019', 'going out of town.', '1', '1', '2019-05-03 15:09:04'),
(6, 5, 3, '4', '29/05/2019', 'going out of town.', '2', '1', '2019-05-03 15:09:04'),
(7, 5, 5, '4', '27/05/2019', 'Getting married.', '2', '1', '2019-05-03 15:09:04'),
(8, 4, 6, '1', '23/05/2019', 'due to 15 August', '2', '1', '2019-05-03 15:50:55'),
(9, 4, 3, '2', '30/05/2019', 'due to fever', '1', '1', '2019-05-03 15:25:53'),
(10, 4, 2, '2', '23/05/2019', 'New Leave from Shashank Garg', '2', '1', '2019-05-03 15:55:21'),
(11, 5, 2, '2', '17/05/2019', 'New Leave from Megha Gupta', '2', '1', '2019-05-03 15:54:00'),
(12, 4, 3, '1', '14/05/2019', 'Again Shashank Applied.', '2', '1', '2019-05-03 15:56:29');

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
(4, 2, 'Section A', '2019-04-03 06:27:58'),
(5, 2, 'Section B', '2019-04-03 06:28:04'),
(9, 5, 'Section A', '2019-04-22 08:46:19'),
(10, 5, 'Section B', '2019-04-22 08:46:19'),
(11, 5, 'Section C', '2019-04-22 08:46:19'),
(18, 1, 'Section A', '2019-04-26 16:52:53'),
(19, 1, 'Section B', '2019-04-26 16:52:54'),
(20, 1, 'Section C', '2019-04-26 16:52:54'),
(21, 1, 'Section D', '2019-04-26 16:52:54'),
(26, 4, 'Sec F', '2019-04-26 16:57:04'),
(27, 6, 'Sec A', '2019-04-27 15:54:32'),
(28, 6, 'Sec B', '2019-04-27 15:54:32'),
(29, 7, 'Section A', '2019-04-28 06:29:43'),
(30, 7, 'Section B', '2019-04-28 06:29:43'),
(31, 7, 'Section E', '2019-04-28 06:29:43');

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
  `student_id` varchar(200) DEFAULT NULL,
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

INSERT INTO `students` (`id`, `first_name`, `last_name`, `email_address`, `gender`, `dob`, `class_id`, `section_id`, `religion`, `date_of_joining`, `mobile_number`, `admission_no`, `student_id`, `fathers_name`, `fathers_occupation`, `parents_mobile_number`, `present_address`, `mothers_name`, `mothers_occupation`, `nationality`, `permanent_address`, `student_profile_image`, `parents_profile_image`, `createdDate`) VALUES
(1, 'Student one', 'two', 'student@gmail.com', 'male', '24/04/2019', 1, 7, 'hindu', '19/04/2019', '123456789', '123456', '111111111', 'sp garg', 'ca', '0123456789', '872\r\nSaraswati soni marg\r\nLaxma chowkasasasas', 'rashmi garg', 'HW', 'India', 'asasas asas', '15556543621461078568_postimage.2.jpg', '1555654362accounat.2.jpe', '2019-05-10 15:27:11'),
(2, 'dadassasas', 'sasasas', 'studenttwo@gmail.com', 'male', '02/05/2019', 1, 18, 'hindu', '30/04/2019', '12345678', '1234567', '123434555', 'SP garg', 'CA', '12345567', 'test test', 'Rashmi garg', 'HW', 'indian', 'test test', '1556359628win_20190423_20_54_49_pro.jpg', '1556359628win_20190423_20_54_49_pro.jpg', '2019-05-10 16:47:53');

-- --------------------------------------------------------

--
-- Table structure for table `students_attendance`
--

CREATE TABLE `students_attendance` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `date_of_attendance` varchar(200) NOT NULL,
  `attendance` varchar(50) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students_attendance`
--

INSERT INTO `students_attendance` (`id`, `class_id`, `student_id`, `teacher_id`, `date_of_attendance`, `attendance`, `createdDate`) VALUES
(1, 1, 1, 4, '2019-05-10', 'A', '2019-05-10 16:48:52'),
(2, 1, 2, 4, '2019-05-10', 'P', '2019-05-10 16:48:52'),
(7, 1, 1, 4, '2019-05-13', 'A', '2019-05-13 15:11:09'),
(8, 1, 2, 4, '2019-05-13', 'P', '2019-05-13 15:33:16');

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
(1, 'Computer', '2019-04-26 15:35:00'),
(2, 'Science', '2019-04-02 09:45:45'),
(3, 'Maths', '2019-04-02 09:45:47'),
(4, 'Hindi', '2019-04-02 09:45:50'),
(5, 'English', '2019-04-02 09:45:54'),
(6, 'Social Science', '2019-04-02 09:45:56'),
(8, 'Hindi 2', '2019-04-26 15:23:48');

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
(1, 4, '', '08/05/2019', 1, '', '24/04/2019', '12345678', '3', '123456', 20, 'tes test test', '1556359262win_20190423_20_54_49_pro.jpg', NULL),
(2, 5, 'female', '23/05/2019', 5, '1', '29/05/2019', '987654321', '4', '987654', 10, '87/2 Saraswati Soni marg, laxman chowk', '', NULL);

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
(1, '1234', '2019-04-27 10:21:20');

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
(1, 'Shashank', 'Garg', NULL, 'shashankgarg655@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1', '1556721736win_20190423_20_54_49_pro.jpg', 'SGRR', '1234567889', '87/2 S.Sony marg', 'Principle', 1, NULL),
(4, 'shashank', 'garg', NULL, 'shashank.garg@evontech.com', '81dc9bdb52d04dc20036dbd8313ed055', '2', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(5, 'Megha', 'Gupta', NULL, 'meghagupta698@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2', NULL, NULL, NULL, NULL, NULL, 0, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exams_list`
--
ALTER TABLE `exams_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leaves_request`
--
ALTER TABLE `leaves_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students_attendance`
--
ALTER TABLE `students_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teachers_password`
--
ALTER TABLE `teachers_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
