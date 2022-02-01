-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 01, 2020 at 10:05 AM
-- Server version: 5.6.41-84.1
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
-- Database: `thedoos9_onermm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_payable`
--

CREATE TABLE `accounts_payable` (
  `id` bigint(20) NOT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `balance` float NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_receivable`
--

CREATE TABLE `accounts_receivable` (
  `id` bigint(20) NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `balance` float NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` bigint(20) NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `doctor_id` bigint(20) NOT NULL,
  `opd_room_id` bigint(20) NOT NULL,
  `appointment_time` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `source` enum('Phone Call','Walk In','Online') NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `queue_ticket_number` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `patient_id`, `doctor_id`, `opd_room_id`, `appointment_time`, `status`, `source`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`, `queue_ticket_number`) VALUES
(3, 1, 1, 1, '2020-10-29 12:20:00', 1, 'Walk In', 5, '2020-11-27 17:43:02', 0, '2020-11-27 17:43:02', '5fc13aa64ed7f'),
(4, 1, 1, 1, '2020-10-29 12:20:00', 1, 'Walk In', 5, '2020-11-27 18:59:13', 0, '2020-11-27 18:59:13', '0004271120'),
(5, 1, 1, 1, '2020-10-29 12:20:00', 1, 'Walk In', 5, '2020-11-27 18:59:16', 0, '2020-11-27 18:59:16', '0005271120'),
(6, 1, 1, 1, '2020-10-29 12:20:00', 1, 'Walk In', 5, '2020-11-27 18:59:18', 0, '2020-11-27 18:59:18', '0006271120'),
(8, 1, 1, -1, '2020-12-01 20:42:00', 0, 'Walk In', 5, '2020-11-29 14:12:42', 0, '2020-11-29 14:12:42', '0002291120');

-- --------------------------------------------------------

--
-- Table structure for table `assets_purchase`
--

CREATE TABLE `assets_purchase` (
  `id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `total_amount` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `status` int(1) NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `assets_purchase_item`
--

CREATE TABLE `assets_purchase_item` (
  `id` bigint(20) NOT NULL,
  `assets_purchase_id` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `quantity` float NOT NULL,
  `purchase_price` float NOT NULL,
  `amount` float NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint(20) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `time_in`, `time_out`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(3, 1, '2020-11-24 09:00:00', '2020-11-24 15:00:00', 5, '2020-11-24 09:06:08', 0, '2020-11-24 09:06:08');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` bigint(20) NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `patient_type` enum('Outpatient','Inpatient','Emergency') NOT NULL,
  `inpatient_care_id` bigint(20) DEFAULT NULL,
  `emergency_care_id` bigint(20) DEFAULT NULL,
  `appointment_id` bigint(20) DEFAULT NULL,
  `bill_date_time` datetime DEFAULT NULL,
  `discount` float DEFAULT '0',
  `tax_amount` float DEFAULT '0',
  `discharge_date_time` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0 = Unpaid, 1 = Paid',
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `patient_id`, `patient_type`, `inpatient_care_id`, `emergency_care_id`, `appointment_id`, `bill_date_time`, `discount`, `tax_amount`, `discharge_date_time`, `status`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(11, 2, 'Outpatient', 2, 1, 1, '2020-10-21 00:00:00', 1000, 100, '2020-10-24 00:00:00', 1, 5, '2020-11-09 16:22:24', 0, '2020-11-17 08:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `bill_receipt`
--

CREATE TABLE `bill_receipt` (
  `id` bigint(20) NOT NULL,
  `bill_id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `amount` float NOT NULL,
  `status` int(11) NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bill_receipt`
--

INSERT INTO `bill_receipt` (`id`, `bill_id`, `date`, `amount`, `status`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(2, 2, '2020-12-12 00:00:00', 5000, 1, 5, '2020-11-17 08:44:18', 0, '2020-11-17 08:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `bill_service_item`
--

CREATE TABLE `bill_service_item` (
  `id` bigint(20) NOT NULL,
  `bill_id` bigint(20) NOT NULL,
  `service_item_id` bigint(20) NOT NULL,
  `charge` float NOT NULL,
  `charge_type` enum('Service','Consultant') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bill_service_item`
--

INSERT INTO `bill_service_item` (`id`, `bill_id`, `service_item_id`, `charge`, `charge_type`) VALUES
(1, 2, 3, 5000, 'Service');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `description`) VALUES
(1, 'Dept3', 'Dept 3 Description'),
(2, 'Dept1', 'Dept 1 Description'),
(3, 'Dept2', 'Dept 2 Description');

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_item`
--

CREATE TABLE `diagnosis_item` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `diagnosis_type_id` bigint(20) NOT NULL,
  `charge` float DEFAULT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_report`
--

CREATE TABLE `diagnosis_report` (
  `id` bigint(20) NOT NULL,
  `diagnosis_request_id` bigint(20) NOT NULL,
  `date` datetime DEFAULT NULL,
  `doctor_id` bigint(20) NOT NULL COMMENT 'this doctor_id is the id of pathologist who make report',
  `notes` text,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_report_item`
--

CREATE TABLE `diagnosis_report_item` (
  `id` bigint(20) NOT NULL,
  `diagnosis_report_id` bigint(20) NOT NULL,
  `diagnosis_item_id` bigint(20) NOT NULL,
  `result` text,
  `remark` text,
  `file_attachment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_request`
--

CREATE TABLE `diagnosis_request` (
  `id` bigint(20) NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `doctor_id` bigint(20) NOT NULL,
  `status` varchar(25) NOT NULL COMMENT 'URGENT or REGULAR',
  `notes` text NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_request_item`
--

CREATE TABLE `diagnosis_request_item` (
  `id` bigint(20) NOT NULL,
  `diagnosis_request_id` bigint(20) NOT NULL,
  `diagnosis_item_id` bigint(20) NOT NULL,
  `charge` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_type`
--

CREATE TABLE `diagnosis_type` (
  `id` bigint(20) NOT NULL,
  `name` int(11) NOT NULL COMMENT '''Laboratory'', ''Radiology'', ''Endoscopy'', ...',
  `created_user_id` bigint(20) NOT NULL,
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `department_id` bigint(20) NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `opd_charge` float NOT NULL,
  `ipd_charge` float DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `name`, `phone`, `department_id`, `employee_id`, `opd_charge`, `ipd_charge`, `created_time`, `updated_time`) VALUES
(1, 'Doctor Ma Lay', '1213123', 1, 1, 5000, 10000, '2020-10-03 13:27:16', '2020-10-09 17:07:57'),
(2, 'Doctor 1', '1213123', 1, 1, 5000, 10000, '2020-10-06 11:07:30', '2020-10-06 11:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_care`
--

CREATE TABLE `emergency_care` (
  `id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `doctor_id` bigint(20) NOT NULL,
  `status` int(1) DEFAULT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` bigint(20) NOT NULL,
  `employee_identification_number` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(12) DEFAULT NULL,
  `education` text,
  `join_date` date DEFAULT NULL,
  `permanent_date` date DEFAULT NULL,
  `marital_status` enum('Single','Married','Divorced') DEFAULT NULL,
  `number_of_children` int(1) NOT NULL DEFAULT '0',
  `live_with_parent` enum('Yes','No') NOT NULL DEFAULT 'No',
  `live_with_spouse_parent` enum('Yes','No') NOT NULL DEFAULT 'No',
  `phone_number` varchar(25) DEFAULT NULL,
  `emergency_contact_phone` varchar(25) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `nrc_number` varchar(50) DEFAULT NULL,
  `bank_account_number` varchar(50) DEFAULT NULL,
  `tax_id` varchar(50) NOT NULL,
  `passport_number` varchar(50) NOT NULL,
  `address` text,
  `profile_image` longtext,
  `position_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '0 = Resigned, 1 = Probation, 2 = Permanent',
  `created_user_login_id` bigint(20) DEFAULT NULL,
  `updated_user_login_id` bigint(20) DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `employee_identification_number`, `name`, `gender`, `education`, `join_date`, `permanent_date`, `marital_status`, `number_of_children`, `live_with_parent`, `live_with_spouse_parent`, `phone_number`, `emergency_contact_phone`, `date_of_birth`, `nrc_number`, `bank_account_number`, `tax_id`, `passport_number`, `address`, `profile_image`, `position_id`, `department_id`, `status`, `created_user_login_id`, `updated_user_login_id`, `created_time`, `updated_time`) VALUES
(1, '10003', 'Nway Nway Acc', 'Female', NULL, NULL, NULL, 'Divorced', 0, 'Yes', 'No', NULL, NULL, '2019-09-23', NULL, NULL, '1', '10003', NULL, NULL, 1, 1, 0, NULL, NULL, '2020-09-25 20:11:04', '2020-11-10 15:34:24'),
(2, '10010', 'dd', 'Male', '', NULL, NULL, 'Single', 1, 'No', 'Yes', '', NULL, '2020-09-02', '123456', '', '1', '1111', '', NULL, 1, 2, 1, NULL, NULL, '2020-09-26 11:58:38', '2020-10-20 10:18:51'),
(4, '10004', 'Nway Nway Acc to Remove', 'Female', NULL, NULL, NULL, NULL, 0, 'No', 'No', NULL, NULL, NULL, NULL, NULL, '1', '10004', NULL, NULL, 1, 1, 1, NULL, NULL, '2020-11-27 17:17:08', '2020-11-27 17:17:08'),
(5, '10005', 'Nway Nway Acc to Remove', 'Female', NULL, NULL, NULL, NULL, 0, 'No', 'No', NULL, NULL, NULL, NULL, NULL, '0', '10005', NULL, NULL, 1, 1, 1, NULL, NULL, '2020-11-27 17:19:10', '2020-11-27 17:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `general_ledger_account`
--

CREATE TABLE `general_ledger_account` (
  `id` bigint(20) NOT NULL,
  `account_code` varchar(50) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `opening_balance` float NOT NULL DEFAULT '0',
  `closing_balance` float NOT NULL DEFAULT '0',
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `general_ledger_in`
--

CREATE TABLE `general_ledger_in` (
  `id` bigint(20) NOT NULL,
  `general_ledger_account_id` bigint(20) NOT NULL,
  `date` datetime DEFAULT NULL,
  `description` text,
  `amount` float NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `general_ledger_out`
--

CREATE TABLE `general_ledger_out` (
  `id` bigint(20) NOT NULL,
  `general_ledger_account_id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `amount` float NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inpatient_care`
--

CREATE TABLE `inpatient_care` (
  `id` bigint(20) NOT NULL,
  `admission_date` datetime NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `doctor_id` bigint(20) NOT NULL,
  `ipd_bed_id` bigint(20) NOT NULL,
  `discharge_date` datetime NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ipd_bed`
--

CREATE TABLE `ipd_bed` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `charge_amount` float DEFAULT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `leave_request`
--

CREATE TABLE `leave_request` (
  `id` bigint(20) NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `leave_type_id` bigint(20) NOT NULL,
  `leave_date` date NOT NULL,
  `comment` text NOT NULL,
  `day_period` enum('Full','Half') NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_request`
--

INSERT INTO `leave_request` (`id`, `employee_id`, `leave_type_id`, `leave_date`, `comment`, `day_period`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(3, 1, 1, '2020-11-23', 'Comment', 'Half', 5, '2020-11-24 10:16:17', 0, '2020-11-24 10:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `allowance_days_per_year` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`id`, `name`, `allowance_days_per_year`) VALUES
(3, 'Medical Leave', 15);

-- --------------------------------------------------------

--
-- Table structure for table `medical_record`
--

CREATE TABLE `medical_record` (
  `id` bigint(20) NOT NULL,
  `record_type` enum('Inpatient','Outpatient','Emergency') NOT NULL,
  `care_id` bigint(20) NOT NULL COMMENT 'care_id based on record_type.\r\nif record_type is ''Inpatient'', care_id is inpatient_care_id. If record_type is ''Outpatient'', care_id is outpatient_care_id. If record_type is ''Emergency'', care_id is emergency_care_id.',
  `doctor_notes` longtext,
  `attachment` longtext,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medical_record`
--

INSERT INTO `medical_record` (`id`, `record_type`, `care_id`, `doctor_notes`, `attachment`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(1, 'Outpatient', 1, 'Doctor Note', '', 5, '2020-10-19 15:28:28', 0, '2020-10-19 15:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `medical_record_diagnosis`
--

CREATE TABLE `medical_record_diagnosis` (
  `id` bigint(20) NOT NULL,
  `medical_record_id` bigint(20) NOT NULL,
  `diagnosis_request_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `medical_record_prescription`
--

CREATE TABLE `medical_record_prescription` (
  `id` bigint(20) NOT NULL,
  `medical_record_id` bigint(20) NOT NULL,
  `pharmacy_item_id` bigint(20) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `opd_room`
--

CREATE TABLE `opd_room` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `current_doctor_id` bigint(20) DEFAULT NULL,
  `current_queue_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `opd_room`
--

INSERT INTO `opd_room` (`id`, `name`, `location`, `current_doctor_id`, `current_queue_token`) VALUES
(1, '102', '102', 2, '1112'),
(3, 'asd', 'asd', 12, 'asd'),
(4, 'name', 'asdf', 2, '12345');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` text,
  `township` text,
  `region` text,
  `blood_group` varchar(12) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `name`, `phone`, `date_of_birth`, `address`, `township`, `region`, `blood_group`, `gender`, `status`, `created_time`, `updated_time`) VALUES
(1, 'Patient 1', '123123', '1980-09-12', 'Yangon', 'Yangon', 'Yangon', '0+', 'Male', 1, '2020-10-03 14:13:57', '2020-10-03 14:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` bigint(20) NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `basic_salary` float NOT NULL,
  `overtime_fee` float NOT NULL,
  `bonus` float NOT NULL,
  `tax` float NOT NULL,
  `deduction` float DEFAULT NULL,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `notes` text NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`id`, `employee_id`, `basic_salary`, `overtime_fee`, `bonus`, `tax`, `deduction`, `month`, `year`, `notes`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(3, 1, 100000, 2000, 1000, 10, 10, 1, 1, 'note', 5, '2020-11-24 09:41:57', 0, '2020-11-24 09:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_category`
--

CREATE TABLE `pharmacy_category` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_category`
--

INSERT INTO `pharmacy_category` (`id`, `name`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(1, 'PC2', 5, '2020-10-19 15:52:28', 0, '2020-10-19 15:52:28');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_inventory`
--

CREATE TABLE `pharmacy_inventory` (
  `id` bigint(20) NOT NULL,
  `pharmacy_item_id` bigint(20) NOT NULL,
  `pharmacy_warehouse_id` bigint(20) NOT NULL,
  `opening_balance` float NOT NULL,
  `closing_balance` float NOT NULL,
  `economic_order_quantity` float NOT NULL,
  `reorder_level` float NOT NULL,
  `minimum` float NOT NULL,
  `maximum` float NOT NULL,
  `batch` varchar(50) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_inventory`
--

INSERT INTO `pharmacy_inventory` (`id`, `pharmacy_item_id`, `pharmacy_warehouse_id`, `opening_balance`, `closing_balance`, `economic_order_quantity`, `reorder_level`, `minimum`, `maximum`, `batch`, `expired_date`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(3, 1, 1, 10000, 5000, 100, 1, 1, 10, '1', '2020-12-12', 5, '2020-11-17 13:05:39', 0, '2020-11-17 13:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_issue`
--

CREATE TABLE `pharmacy_issue` (
  `id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `issue_to` text NOT NULL,
  `total_amount` float NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_issue`
--

INSERT INTO `pharmacy_issue` (`id`, `date`, `issue_to`, `total_amount`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(4, '2020-12-12 00:00:00', '1', 1000, 5, '2020-11-17 09:46:31', 0, '2020-11-17 09:46:31');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_issue_item`
--

CREATE TABLE `pharmacy_issue_item` (
  `id` bigint(20) NOT NULL,
  `pharmacy_issue_id` bigint(20) NOT NULL,
  `pharmacy_item_id` bigint(20) NOT NULL,
  `quantity` float NOT NULL,
  `sale_price` float NOT NULL,
  `amount` float NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_issue_item`
--

INSERT INTO `pharmacy_issue_item` (`id`, `pharmacy_issue_id`, `pharmacy_item_id`, `quantity`, `sale_price`, `amount`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(3, 1, 1, 100, 1000, 1200, 5, '2020-11-17 10:14:17', 0, '2020-11-17 10:14:17');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_item`
--

CREATE TABLE `pharmacy_item` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pharmacy_category_id` bigint(20) NOT NULL,
  `universal_product_code` varchar(50) DEFAULT NULL COMMENT 'Barcode',
  `sale_price` float NOT NULL,
  `purchase_price` float NOT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_item`
--

INSERT INTO `pharmacy_item` (`id`, `name`, `pharmacy_category_id`, `universal_product_code`, `sale_price`, `purchase_price`, `supplier_id`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(1, 'PI 2', 2, '123124', 1200, 1000, 1, 5, '2020-10-19 16:32:39', 0, '2020-10-19 16:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_purchase`
--

CREATE TABLE `pharmacy_purchase` (
  `id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `total_amount` float NOT NULL,
  `discount` float NOT NULL,
  `status` int(1) DEFAULT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_purchase`
--

INSERT INTO `pharmacy_purchase` (`id`, `date`, `supplier_id`, `total_amount`, `discount`, `status`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(3, '2020-12-12 00:00:00', 1, 1000, 100, 1, 5, '2020-11-18 15:31:44', 0, '2020-11-18 15:31:44');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_purchase_item`
--

CREATE TABLE `pharmacy_purchase_item` (
  `id` bigint(20) NOT NULL,
  `pharmacy_purchase_id` bigint(20) NOT NULL,
  `pharmacy_item_id` bigint(20) NOT NULL,
  `quantity` float NOT NULL,
  `purchase_price` float NOT NULL,
  `amount` float NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_purchase_item`
--

INSERT INTO `pharmacy_purchase_item` (`id`, `pharmacy_purchase_id`, `pharmacy_item_id`, `quantity`, `purchase_price`, `amount`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(2, 1, 1, 100, 1000, 100000, 5, '2020-11-18 16:01:29', 0, '2020-11-18 16:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_purchase_payment`
--

CREATE TABLE `pharmacy_purchase_payment` (
  `id` bigint(20) NOT NULL,
  `pharmacy_purchase_id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `amount` float NOT NULL,
  `status` int(1) NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_purchase_payment`
--

INSERT INTO `pharmacy_purchase_payment` (`id`, `pharmacy_purchase_id`, `date`, `amount`, `status`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(3, 1, '2020-12-12 00:00:00', 10000, 1, 5, '2020-11-18 16:42:20', 0, '2020-11-18 16:42:20');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_sale`
--

CREATE TABLE `pharmacy_sale` (
  `id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `total_amount` float NOT NULL,
  `discount` float NOT NULL,
  `remark` text NOT NULL,
  `status` int(1) DEFAULT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_sale`
--

INSERT INTO `pharmacy_sale` (`id`, `date`, `patient_id`, `total_amount`, `discount`, `remark`, `status`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(2, '2020-12-12 00:00:00', 1, 1000, 100, 'Remark', 1, 5, '2020-11-17 13:36:54', 0, '2020-11-17 13:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_sale_item`
--

CREATE TABLE `pharmacy_sale_item` (
  `id` bigint(20) NOT NULL,
  `pharmacy_sale_id` bigint(20) NOT NULL,
  `pharmacy_item_id` bigint(20) NOT NULL,
  `quantity` float NOT NULL,
  `sale_price` float NOT NULL,
  `amount` float NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_sale_item`
--

INSERT INTO `pharmacy_sale_item` (`id`, `pharmacy_sale_id`, `pharmacy_item_id`, `quantity`, `sale_price`, `amount`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(3, 1, 1, 100, 2000, 2300, 5, '2020-11-18 15:21:01', 0, '2020-11-18 15:21:01');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_sale_receipt`
--

CREATE TABLE `pharmacy_sale_receipt` (
  `id` bigint(20) NOT NULL,
  `pharmacy_sale_id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `amount` float NOT NULL,
  `status` int(11) NOT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_sale_receipt`
--

INSERT INTO `pharmacy_sale_receipt` (`id`, `pharmacy_sale_id`, `date`, `amount`, `status`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(3, 1, '2020-12-12 00:00:00', 1000, 1, 5, '2020-11-17 14:02:29', 0, '2020-11-17 14:02:29');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_warehouse`
--

CREATE TABLE `pharmacy_warehouse` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text,
  `created_user_id` bigint(20) DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_warehouse`
--

INSERT INTO `pharmacy_warehouse` (`id`, `name`, `phone`, `address`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(4, 'Warehouse 1', '123123', 'Somewhere', 5, '2020-11-17 12:57:14', 0, '2020-11-17 12:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `name`, `description`) VALUES
(1, 'Position 3', 'Position 3 Description'),
(2, 'Position 3', 'Position 3 Description');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` bigint(20) NOT NULL,
  `name` int(11) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `id` bigint(20) NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `basic_monthly_rate` float NOT NULL,
  `overtime_hourly_rate` float DEFAULT NULL,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`id`, `employee_id`, `basic_monthly_rate`, `overtime_hourly_rate`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(3, 1, 100000, 1000, 5, '2020-11-24 08:39:59', 0, '2020-11-24 08:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `service_category`
--

CREATE TABLE `service_category` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_category`
--

INSERT INTO `service_category` (`id`, `name`, `description`) VALUES
(12, 'SCat 2', 'Desc');

-- --------------------------------------------------------

--
-- Table structure for table `service_item`
--

CREATE TABLE `service_item` (
  `id` bigint(20) NOT NULL,
  `service_category_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `charge_type` enum('Service','Consultant') NOT NULL COMMENT 'if charge_type is Consultant, charge value will be retrieved from doctor_charge table, otherwise value is standard_charge.\r\nrelated doctor id is get from patient bill_head',
  `standard_charge` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_item`
--

INSERT INTO `service_item` (`id`, `service_category_id`, `name`, `description`, `charge_type`, `standard_charge`) VALUES
(10, 1, 'Service Item 2', 'Description', 'Service', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text,
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `phone`, `address`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(1, 'Supplier 2', '123123', 'AAAABBB', 5, '2020-10-19 16:08:18', 0, '2020-10-19 16:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `level` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `login_attempt` int(1) NOT NULL DEFAULT '0',
  `created_user_id` bigint(20) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user_id` bigint(20) DEFAULT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='User Authentication';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `level`, `status`, `login_attempt`, `created_user_id`, `created_time`, `updated_user_id`, `updated_time`) VALUES
(1, 'admin', '$2y$10$vKy0FpV94fF.qCp/lYSvpej3esblLtHRWBzs6ana.HVOf0LfSCG0i', 'Administrator', 6, 1, 0, 0, '2020-09-10 09:29:59', 0, '2020-09-10 09:31:02'),
(2, 'akm', '$2y$10$4lvFdqm3vCKZrRcthJGlcekMdBdiHe5RKAYckjsEywEuD9ZllKxtO', 'Aung Kyaw Minn', 6, 1, 0, 1, '2020-09-11 04:45:27', 1, '2020-09-11 14:28:08'),
(3, 'user', '$2y$10$5VWTMMltap2roYAeooVATeS2q2nPyka5jxOR2akbC073ZBKke7H32', 'User Test', 6, 1, 0, 1, '2020-09-11 08:55:34', 9, '2020-09-26 05:45:02'),
(4, 'roman', '$2y$10$bp7u2xTZdlCgYwY/hAmNZ.YLC7Z7ewM5xohcnR3JTas/FdFM91AiS', 'Roman', 0, 0, 0, 0, '2020-09-20 19:20:04', 0, '2020-09-20 19:20:04'),
(5, 'roman1', '$2y$10$zTT3NE8rMzpYL7WzuY98mOPS8qHv6jpgeGIeh5Ym2k2SIhU8rcF4K', 'Roman', 6, 0, 0, 0, '2020-09-25 20:03:51', 0, '2020-09-25 20:03:51'),
(6, 'akkt', '$2y$10$PqhlM0Nj2UdHdyYGexZ6re0Y4IYaPu8R6QBIO.FCBojlkfGxPh.OO', 'Aung Ko Ko Thet', 0, 0, 0, 9, '2020-10-06 10:45:33', 0, '2020-10-06 10:45:33'),
(11, 'roman3', '$2y$10$FJjFXipXHkxCh3YJ3u.KKOE2ObXyKypBkHc25x9Zw7jQp7egnXyxa', 'Roman3', 0, 0, 0, 5, '2020-11-27 17:35:10', NULL, '2020-11-27 17:35:10');

-- --------------------------------------------------------

--
-- Table structure for table `user_employee`
--

CREATE TABLE `user_employee` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL COMMENT 'this field connect to user_login.id',
  `employee_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts_payable`
--
ALTER TABLE `accounts_payable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_accounts_payable_supplier` (`supplier_id`);

--
-- Indexes for table `accounts_receivable`
--
ALTER TABLE `accounts_receivable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets_purchase`
--
ALTER TABLE `assets_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets_purchase_item`
--
ALTER TABLE `assets_purchase_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_service_item`
--
ALTER TABLE `bill_service_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosis_report`
--
ALTER TABLE `diagnosis_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosis_report_item`
--
ALTER TABLE `diagnosis_report_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosis_request`
--
ALTER TABLE `diagnosis_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosis_request_item`
--
ALTER TABLE `diagnosis_request_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_care`
--
ALTER TABLE `emergency_care`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_ledger_account`
--
ALTER TABLE `general_ledger_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_ledger_in`
--
ALTER TABLE `general_ledger_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_ledger_out`
--
ALTER TABLE `general_ledger_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inpatient_care`
--
ALTER TABLE `inpatient_care`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipd_bed`
--
ALTER TABLE `ipd_bed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_request`
--
ALTER TABLE `leave_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_record`
--
ALTER TABLE `medical_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_record_prescription`
--
ALTER TABLE `medical_record_prescription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opd_room`
--
ALTER TABLE `opd_room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_category`
--
ALTER TABLE `pharmacy_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_inventory`
--
ALTER TABLE `pharmacy_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_issue`
--
ALTER TABLE `pharmacy_issue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_issue_item`
--
ALTER TABLE `pharmacy_issue_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_item`
--
ALTER TABLE `pharmacy_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_purchase`
--
ALTER TABLE `pharmacy_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_purchase_item`
--
ALTER TABLE `pharmacy_purchase_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_purchase_payment`
--
ALTER TABLE `pharmacy_purchase_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_sale`
--
ALTER TABLE `pharmacy_sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_sale_item`
--
ALTER TABLE `pharmacy_sale_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacy_warehouse`
--
ALTER TABLE `pharmacy_warehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_category`
--
ALTER TABLE `service_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_item`
--
ALTER TABLE `service_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_employee`
--
ALTER TABLE `user_employee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `diagnosis_report`
--
ALTER TABLE `diagnosis_report`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diagnosis_report_item`
--
ALTER TABLE `diagnosis_report_item`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diagnosis_request`
--
ALTER TABLE `diagnosis_request`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diagnosis_request_item`
--
ALTER TABLE `diagnosis_request_item`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `medical_record`
--
ALTER TABLE `medical_record`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medical_record_prescription`
--
ALTER TABLE `medical_record_prescription`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opd_room`
--
ALTER TABLE `opd_room`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pharmacy_category`
--
ALTER TABLE `pharmacy_category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pharmacy_item`
--
ALTER TABLE `pharmacy_item`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_employee`
--
ALTER TABLE `user_employee`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
