-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2020 at 01:33 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kiwo_ci`
--

-- --------------------------------------------------------

--
-- Table structure for table `approval_status`
--

CREATE TABLE `approval_status` (
  `approval_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `forward_to` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `approval_status`
--

INSERT INTO `approval_status` (`approval_id`, `ticket_id`, `approved_by`, `forward_to`, `remarks`, `date_added`, `status`) VALUES
(1, 1, 1, 0, 'Test', '2020-11-30 15:20:46', 1),
(2, 1, 1, 0, 'Test dddd', '2020-11-30 15:21:20', 1),
(3, 1, 1, 0, 'Test dddd', '2020-11-30 15:21:56', 1),
(4, 1, 1, 0, 'Test dddd', '2020-11-30 15:22:07', 1),
(5, 1, 1, 0, 'Test dddd', '2020-11-30 15:25:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `department_name` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1: Active, 2: Deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `department_name`, `date_added`, `status`) VALUES
(2, 'fdfsdfsfs', '2020-11-25 14:34:00', 1),
(3, 'TTTTTTT', '2020-11-25 14:34:31', 1),
(4, 'dfdsfgfd', '2020-11-25 14:36:28', 2);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `emp_name` varchar(50) NOT NULL,
  `emp_email` varchar(50) NOT NULL,
  `emp_password` varchar(50) NOT NULL,
  `emp_mobile` varchar(50) NOT NULL,
  `emp_dept` int(11) NOT NULL,
  `emp_type` int(11) NOT NULL COMMENT '1: admin, 2: user',
  `emp_pic` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `emp_name`, `emp_email`, `emp_password`, `emp_mobile`, `emp_dept`, `emp_type`, `emp_pic`, `date_added`, `status`) VALUES
(1, 'test', 'test@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '9874563212', 2, 1, '', '0000-00-00 00:00:00', 1),
(2, 'test test', 'administrator1@gmail.com', '934b535800b1cba8f96a5d72f72f1611', '9874563211', 3, 1, '', '0000-00-00 00:00:00', 1),
(3, 'ankit', 'ankit@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '8879581492', 3, 2, '', '2020-11-26 17:19:18', 1),
(4, 'team', 'team@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '9875641232', 2, 2, '', '2020-11-26 17:19:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `escalations`
--

CREATE TABLE `escalations` (
  `esc_id` int(11) NOT NULL,
  `time_set` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL COMMENT '1: Active, 2: Not Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mail_logs`
--

CREATE TABLE `mail_logs` (
  `mail_id` int(11) NOT NULL,
  `ticket_no` int(11) NOT NULL,
  `sent_by` int(11) NOT NULL,
  `sent_to` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` varchar(500) NOT NULL,
  `date_added` datetime NOT NULL,
  `satus` int(11) NOT NULL COMMENT '1: sent, 2: failed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `requesttype`
--

CREATE TABLE `requesttype` (
  `request_id` int(11) NOT NULL,
  `req_name` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requesttype`
--

INSERT INTO `requesttype` (`request_id`, `req_name`, `date_added`, `status`) VALUES
(1, 'test request', '2020-11-26 17:26:35', 1),
(2, 'test request 1', '2020-11-26 17:26:35', 1),
(3, 'Testing Testing test', '2020-11-30 17:35:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `ticket_no` int(11) NOT NULL,
  `req_type` int(11) NOT NULL,
  `ticket_remark` varchar(500) NOT NULL,
  `ticket_added_by` int(11) NOT NULL,
  `ticket_added_by_dept` int(11) NOT NULL,
  `ticket_assigned_to` int(11) NOT NULL,
  `ticket_closure` int(11) NOT NULL DEFAULT 1 COMMENT '1: Active, 2: Closed',
  `login_emp` int(11) NOT NULL,
  `file_attach` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `closed_at` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1:Active, 2: Not Active',
  `behalf` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `ticket_no`, `req_type`, `ticket_remark`, `ticket_added_by`, `ticket_added_by_dept`, `ticket_assigned_to`, `ticket_closure`, `login_emp`, `file_attach`, `created_at`, `closed_at`, `status`, `behalf`) VALUES
(1, 2402, 1, 'Test', 1, 2, 2, 1, 1, '6b5cec9f343a428d1b5a56a4b829cda9.jpg', '2020-11-30 11:06:09', '0000-00-00 00:00:00', 1, 1),
(2, 1518, 2, 'Test 2', 4, 2, 2, 1, 1, 'd7bbc546e183dfbecdd00a5616ea3275.jpg', '2020-11-30 11:15:03', '0000-00-00 00:00:00', 1, 0),
(3, 7230, 2, 'TEst2q', 1, 2, 3, 1, 1, '', '2020-11-30 11:16:55', '0000-00-00 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_logs`
--

CREATE TABLE `ticket_logs` (
  `tckt_log_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `ticket_remark` varchar(500) NOT NULL,
  `remark_by` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1: Active, 2: Deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approval_status`
--
ALTER TABLE `approval_status`
  ADD PRIMARY KEY (`approval_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `mail_logs`
--
ALTER TABLE `mail_logs`
  ADD PRIMARY KEY (`mail_id`);

--
-- Indexes for table `requesttype`
--
ALTER TABLE `requesttype`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `ticket_logs`
--
ALTER TABLE `ticket_logs`
  ADD PRIMARY KEY (`tckt_log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approval_status`
--
ALTER TABLE `approval_status`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mail_logs`
--
ALTER TABLE `mail_logs`
  MODIFY `mail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requesttype`
--
ALTER TABLE `requesttype`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket_logs`
--
ALTER TABLE `ticket_logs`
  MODIFY `tckt_log_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
