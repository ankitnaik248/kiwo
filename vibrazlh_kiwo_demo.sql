-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 11, 2021 at 01:45 AM
-- Server version: 5.7.23-23
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vibrazlh_kiwo_demo`
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
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `department_name` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1: Active, 2: Deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `department_name`, `date_added`, `status`) VALUES
(1, 'I T', '2020-12-31 11:08:53', 1),
(2, 'ACCOUNTS', '2020-12-31 11:09:07', 1),
(3, 'PURCHASE', '2020-12-31 11:09:28', 1),
(4, 'PROJECTS', '2020-12-31 11:09:43', 1),
(5, 'HR ADMIN', '2020-12-31 11:10:03', 1),
(6, 'SALES', '2020-12-31 11:10:21', 1),
(7, 'MARCOM', '2020-12-31 11:10:42', 1),
(8, 'WAREHOUSE', '2020-12-31 11:11:00', 1),
(9, 'CENTRAL SERVICE', '2020-12-31 11:11:19', 1),
(10, 'CUSTOMER CARE', '2020-12-31 11:11:34', 1),
(11, 'ADMIN', '2020-12-31 11:17:16', 2),
(12, 'PRODUCTION', '2020-12-31 11:21:05', 1),
(13, 'AUDIT', '2021-01-11 06:55:38', 1),
(14, 'MAINTENANCE', '2021-02-11 06:43:16', 1),
(15, 'DISPATCH', '2021-02-11 06:46:10', 1),
(16, 'QUALITY CHECK', '2021-02-11 06:48:39', 1),
(17, 'STORES', '2021-02-11 07:31:51', 1);

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
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `emp_name`, `emp_email`, `emp_password`, `emp_mobile`, `emp_dept`, `emp_type`, `emp_pic`, `date_added`, `status`) VALUES
(1, 'test', 'test@gmail.com', '65fa62ec47c9a35e257ae07d63fc9eb8', '9246360155', 1, 1, '', '0000-00-00 00:00:00', 1),
(14, 'G S Kishan', 'kishan@furnitureworldindia.com', '65fa62ec47c9a35e257ae07d63fc9eb8', '9246360155', 1, 1, '', '2021-01-01 09:17:52', 1),
(15, 'Srikanth', 'tech-support@furnitureworldindia.com', '81dc9bdb52d04dc20036dbd8313ed055', '8885758943', 1, 2, '', '2021-01-01 09:19:14', 1),
(16, 'Mujahid', 'erp-support@furnitureworldindia.com', '81dc9bdb52d04dc20036dbd8313ed055', '9700711781', 1, 2, '', '2021-01-01 09:37:17', 1),
(17, 'GACHIBOWLI', 'gachibowli@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '9246260891', 6, 2, '', '2021-01-06 10:56:53', 1),
(18, 'Sandeep', 'sandeep@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '9246260891', 6, 2, '', '2021-01-06 10:57:44', 1),
(19, 'Gurinder', 'gurinder@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9676030808', 3, 1, '', '2021-01-08 13:27:13', 1),
(20, 'ChandraMouli', 'chandramouli@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9246248437', 2, 1, '', '2021-01-08 13:33:53', 1),
(21, 'A S RAO NAGAR', 'asraonagar@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '9154845006', 6, 2, '', '2021-01-11 05:40:21', 1),
(22, 'Toufeeq', 'toufeeq@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '9154845006', 6, 2, '', '2021-01-11 05:41:09', 1),
(23, 'KARKHANA', 'karkhana@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '7702156555', 6, 2, '', '2021-01-11 05:43:10', 1),
(24, 'Srikanth', 'srikanth@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '7702156555', 6, 2, '', '2021-01-11 05:44:16', 1),
(25, 'Vijaya', 'accounts@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '7893230646', 2, 2, '', '2021-01-11 05:45:55', 1),
(26, 'Siva ACCOUNTS', 'siva@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9848337069', 2, 2, '', '2021-01-11 05:48:31', 1),
(27, 'Arun ACCOUNTS', 'arun@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9441819236', 2, 2, '', '2021-01-11 05:50:02', 1),
(28, 'Satish ACCOUNTS', 'satish@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9397933555', 2, 2, '', '2021-01-11 05:51:45', 1),
(29, 'Ramesh PAYROLL', 'payroll@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9100073924', 5, 1, '', '2021-01-11 06:00:48', 1),
(30, 'Khaja ADMIN', 'admin@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '7993323620', 5, 2, '', '2021-01-11 06:05:30', 1),
(31, 'GL Ramesh', 'ramesh.hr@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9100900877', 5, 1, '', '2021-01-11 06:16:11', 1),
(32, 'NAGOLE', 'nagole@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '7674835111', 6, 2, '', '2021-01-11 06:17:16', 1),
(33, 'Adarsh', 'adarsh@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '7674835111', 6, 2, '', '2021-01-11 06:18:55', 1),
(34, 'ATTAPUR', 'attapur@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '7702213331', 6, 2, '', '2021-01-11 06:20:28', 1),
(35, 'Chandramohan', 'chandu@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '7702213331', 6, 2, '', '2021-01-11 06:21:01', 1),
(36, 'MIYAPUR', 'miyapur@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '9246360154', 6, 2, '', '2021-01-11 08:04:59', 1),
(37, 'Shiva FWD', 'shiva@gofwd.in', '827ccb0eea8a706c4c34a16891f84e7b', '9246360154', 6, 2, '', '2021-01-11 08:06:15', 1),
(38, 'Hussaini', 'manager-banjara@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9701362954', 6, 2, '', '2021-01-11 08:18:49', 1),
(39, 'Junaid', 'billing@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9100034372', 6, 2, '', '2021-01-11 08:20:48', 1),
(40, 'Mounika', 'delivery@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9652594400', 8, 2, '', '2021-01-11 08:27:57', 1),
(41, 'Ravikiran', 'ravi@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9246260886', 6, 2, '', '2021-01-11 08:30:41', 1),
(42, 'MG ROAD', 'mgroad@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '7674063222', 6, 2, '', '2021-01-11 09:14:31', 1),
(43, 'NATRAJ', 'natraj@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9246260890', 6, 2, '', '2021-01-11 09:15:34', 1),
(44, 'VIZAG', 'vizag@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9701362950', 6, 2, '', '2021-01-11 09:16:58', 1),
(45, 'MAAYAS', 'zoaib@maayas.co.in', '827ccb0eea8a706c4c34a16891f84e7b', '9652594411', 6, 2, '', '2021-01-11 10:55:30', 1),
(46, 'Pavan', 'pavan@lifestylesofas.com', '827ccb0eea8a706c4c34a16891f84e7b', '9294001185', 12, 1, '', '2021-01-13 07:22:27', 1),
(47, 'Anil Sunerker', 'anil@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9246360150', 4, 1, '', '2021-02-02 12:00:22', 1),
(48, 'Vinay', 'vinay@lifestylesofas.com', '827ccb0eea8a706c4c34a16891f84e7b', '8639460869', 3, 2, '', '2021-02-11 06:25:33', 1),
(49, 'K Sai Ram', 'sairam@lifestylesofas.com', '827ccb0eea8a706c4c34a16891f84e7b', '8897979922', 12, 2, '', '2021-02-11 06:27:03', 1),
(50, 'Sachin', 'it@lifestylesofas.com', '827ccb0eea8a706c4c34a16891f84e7b', '8123530170', 1, 2, '', '2021-02-11 06:29:28', 1),
(51, 'T P MALLAIAH', 'hr@lifestylesofas.com', '827ccb0eea8a706c4c34a16891f84e7b', '8639174581', 5, 2, '', '2021-02-11 06:31:30', 1),
(52, 'T NAGESH', 'nagesh@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9246360156', 2, 2, '', '2021-02-11 06:35:45', 1),
(53, 'J Amarnath', 'amar@furnitureworldindia.com', '827ccb0eea8a706c4c34a16891f84e7b', '9550880408', 12, 2, '', '2021-02-11 06:39:15', 1),
(54, 'Maintenance Team', 'pmd@lifestylesofas.com', '827ccb0eea8a706c4c34a16891f84e7b', '8297646789', 14, 2, '', '2021-02-11 06:44:54', 1),
(55, 'G Rajesh', 'dispatch@lifestylesofas.com', '827ccb0eea8a706c4c34a16891f84e7b', '9701001827', 15, 2, '', '2021-02-11 06:47:05', 1),
(56, 'CH RAVI TEJA', 'ppc@lifestylesofas.com', '827ccb0eea8a706c4c34a16891f84e7b', '7032251431', 12, 2, '', '2021-02-11 06:50:18', 1),
(57, 'YESUDASU', 'qc_panel@lifestylesofas.com', '827ccb0eea8a706c4c34a16891f84e7b', '8500413104', 16, 2, '', '2021-02-11 07:10:41', 1),
(58, 'D Sai Baba', 'store@lifestylesofas.com', '827ccb0eea8a706c4c34a16891f84e7b', '9581837148', 17, 2, '', '2021-02-11 07:32:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `escalations`
--

CREATE TABLE `escalations` (
  `esc_id` int(11) NOT NULL,
  `time_set` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL COMMENT '1: Active, 2: Not Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(30) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0:Active, 1:Inactive',
  `is_deleted` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`level_id`, `level_name`, `date_added`, `status`, `is_deleted`) VALUES
(1, 'Level 2', '2021-03-02 16:17:17', 1, 1),
(2, 'Level 1', '2021-03-02 18:52:52', 1, 1),
(3, 'Level 3', '2021-03-05 11:17:42', 1, 1);

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
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requesttype`
--

INSERT INTO `requesttype` (`request_id`, `req_name`, `date_added`, `status`) VALUES
(1, 'ERP Support', '2021-01-01 10:01:57', 1),
(2, 'System related issues', '2021-01-01 10:02:27', 1),
(3, 'Require Price Tags', '2021-01-18 07:01:20', 1),
(4, 'Code Generation in ERP', '2021-01-29 05:37:26', 1),
(5, 'Price Update in ERP', '2021-01-29 05:37:55', 1),
(6, 'QR Code Labels', '2021-01-29 06:15:49', 1),
(7, 'Discounting Invoice ', '2021-01-29 06:18:17', 1),
(8, 'Internet issues', '2021-01-29 06:21:30', 1),
(9, 'Manual Bill for invoice not generated in ERP', '2021-01-29 06:23:58', 1),
(10, 'CC TV Issue', '2021-01-29 06:27:36', 1),
(11, 'New Mobile', '2021-01-29 06:28:03', 1),
(12, 'New PC or Laptop', '2021-01-29 06:28:31', 1),
(13, 'New Mail ID', '2021-01-29 06:28:56', 1),
(14, 'Password Reset ', '2021-01-29 06:30:01', 1),
(15, 'Mobile issues', '2021-01-29 06:32:05', 1),
(16, 'Vendor Payment', '2021-01-29 06:34:14', 1),
(17, 'Part Delivery', '2021-01-29 06:35:04', 1),
(18, 'Stock Refill', '2021-01-29 06:36:22', 1),
(19, 'Stock Shuffle', '2021-01-29 06:37:40', 1),
(20, 'Way Bill', '2021-01-29 06:38:38', 1),
(21, 'House Keeping', '2021-01-29 06:39:43', 1),
(22, 'Helpers', '2021-01-29 06:39:54', 1),
(23, 'Stationary', '2021-01-29 06:40:26', 1),
(24, 'Security', '2021-01-29 06:40:37', 1),
(25, 'Petty Cash', '2021-01-29 06:41:01', 1),
(26, 'Salary Advance', '2021-01-29 06:41:36', 1),
(27, 'ID Card', '2021-01-29 06:42:29', 1),
(28, 'Visiting Card', '2021-01-29 06:42:55', 1),
(29, 'Sales Executive', '2021-01-29 06:44:09', 1),
(30, 'Installation Technician', '2021-01-29 06:44:57', 1),
(31, 'Swiping Machine', '2021-01-29 06:45:36', 1),
(32, 'Electricity', '2021-01-29 06:46:09', 1),
(33, 'Plumber', '2021-01-29 06:46:26', 1),
(34, 'Uniform', '2021-01-29 06:47:51', 1),
(35, 'Land Line', '2021-01-29 07:26:39', 1),
(36, 'In Store Branding', '2021-01-29 08:14:05', 1),
(37, 'Out Store Branding', '2021-01-29 08:14:56', 1),
(38, 'Cheque Clearance Confirmation', '2021-01-29 08:38:30', 1),
(39, 'Wire Transfer Confirmation', '2021-01-29 08:38:46', 1),
(40, 'Delivery of Products', '2021-02-02 11:44:50', 1),
(41, 'Raw Material Requirement', '2021-02-20 05:41:37', 1),
(42, 'Local Purchase', '2021-02-20 05:42:29', 1),
(43, 'Polish Work', '2021-02-20 05:43:13', 1),
(44, 'Quality Check', '2021-02-20 05:44:01', 1),
(45, 'Manpower Requirement', '2021-02-20 05:48:04', 1),
(46, 'Payslip', '2021-02-20 05:48:21', 1),
(47, 'Packing', '2021-02-20 05:52:29', 1),
(48, 'AC Repair', '2021-02-20 07:12:35', 1),
(49, 'Lift Maintenance', '2021-02-20 07:12:51', 1),
(50, 'Generator Maintenance or Repair', '2021-02-20 07:13:39', 1),
(51, 'Civil Work', '2021-02-20 07:14:07', 1),
(52, 'Machinery Repair', '2021-02-20 07:14:19', 1),
(53, 'Compressor Issue', '2021-02-20 07:15:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_department`
--

CREATE TABLE `sub_department` (
  `sub_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `sub_name` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:Active, 0:In Active',
  `is_deleted` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_department`
--

INSERT INTO `sub_department` (`sub_id`, `dept_id`, `sub_name`, `date_added`, `status`, `is_deleted`) VALUES
(1, 1, 'ERP', '2021-03-05 12:39:34', 1, 1),
(2, 1, 'SYSTEMS & NETWORKING', '2021-03-05 12:39:34', 1, 1),
(3, 5, 'PAYROLL', '2021-03-05 12:40:08', 1, 1),
(4, 5, 'RECRUITMENT', '2021-03-05 12:40:08', 1, 1),
(5, 5, 'ADMIN', '2021-03-05 12:40:08', 1, 1),
(6, 12, 'PANEL', '2021-03-06 06:08:16', 1, 1),
(7, 12, 'SOFA', '2021-03-06 06:08:16', 1, 1);

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
  `ticket_closure` int(11) NOT NULL DEFAULT '1' COMMENT '1: Active, 2: Closed',
  `login_emp` int(11) NOT NULL,
  `file_attach` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `closed_at` datetime NOT NULL,
  `closed_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:Active, 2: Not Active',
  `behalf` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `ticket_no`, `req_type`, `ticket_remark`, `ticket_added_by`, `ticket_added_by_dept`, `ticket_assigned_to`, `ticket_closure`, `login_emp`, `file_attach`, `created_at`, `closed_at`, `closed_by`, `status`, `behalf`, `start_date`, `end_date`, `total_days`) VALUES
(1, 6725, 0, 'Mujahid,\r\n   Need to create FW ERP Codes in FWD ERP  brand wise ', 1, 1, 1, 1, 1, '', '2021-01-01 09:52:05', '0000-00-00 00:00:00', 0, 1, 0, '2021-01-01', '2021-01-31', 30),
(2, 4742, 1, 'Need to insert images of newly received products and create codes', 1, 1, 1, 1, 1, '', '2021-01-27 11:16:44', '0000-00-00 00:00:00', 0, 1, 0, '2021-01-27', '2021-01-31', 4);

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
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1: Active, 2: Deactive'
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
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`level_id`);

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
-- Indexes for table `sub_department`
--
ALTER TABLE `sub_department`
  ADD PRIMARY KEY (`sub_id`);

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
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mail_logs`
--
ALTER TABLE `mail_logs`
  MODIFY `mail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requesttype`
--
ALTER TABLE `requesttype`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `sub_department`
--
ALTER TABLE `sub_department`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ticket_logs`
--
ALTER TABLE `ticket_logs`
  MODIFY `tckt_log_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
