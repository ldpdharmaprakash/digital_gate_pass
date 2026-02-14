-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2026 at 04:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digital_gatepass`
--

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `college_name` varchar(255) NOT NULL,
  `college_code` varchar(255) NOT NULL,
  `college_type` enum('engineering','arts','polytechnic') NOT NULL,
  `gender_restriction` enum('coed','female_only','male_only') NOT NULL DEFAULT 'coed',
  `primary_color` varchar(7) NOT NULL DEFAULT '#3B82F6',
  `secondary_color` varchar(7) NOT NULL DEFAULT '#10B981',
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `college_name`, `college_code`, `college_type`, `gender_restriction`, `primary_color`, `secondary_color`, `address`, `phone`, `email`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Engineering College', 'ENG', 'engineering', 'coed', '#3B82F6', '#10B981', NULL, NULL, NULL, 1, '2026-02-08 13:24:12', '2026-02-08 13:24:12'),
(2, 'Arts & Science College', 'ARTS', 'arts', 'female_only', '#8B5CF6', '#F59E0B', NULL, NULL, NULL, 1, '2026-02-08 13:24:12', '2026-02-08 13:24:12'),
(3, 'Polytechnic College', 'POLY', 'polytechnic', 'coed', '#EF4444', '#FCA5A5', NULL, NULL, NULL, 1, '2026-02-08 13:24:12', '2026-02-08 13:24:12');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `head_name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `college_id`, `name`, `code`, `description`, `head_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Computer Science and Engineering', 'CSE', NULL, 'Dr. Ramesh Kumar', 1, '2026-01-03 04:52:05', '2026-02-14 13:23:06'),
(2, 1, 'Electronics and Communication Engineering', 'ECE', NULL, 'Dr. Priya Sharma', 1, '2026-01-03 04:52:05', '2026-02-14 13:23:06'),
(3, 1, 'Mechanical Engineering', 'MECH', NULL, 'Dr. Anand Patel', 1, '2026-01-03 04:52:05', '2026-02-14 13:23:06'),
(4, 1, 'Civil Engineering', 'CIVIL', NULL, 'Dr. Sunita Reddy', 1, '2026-01-03 04:52:05', '2026-02-14 13:23:06'),
(5, 1, 'Electrical and Electronics Engineering', 'EEE', NULL, 'Dr. Vijay Kumar', 1, '2026-01-03 04:52:05', '2026-02-14 13:23:06'),
(7, 1, 'Computer Science', 'CS', NULL, 'Dr. Lakshmi Devi', 1, '2026-01-10 15:35:48', '2026-01-10 15:35:48'),
(8, 1, 'Electronics', 'EL', NULL, 'Dr. Lakshmi Devi', 1, '2026-01-10 15:35:48', '2026-01-10 15:35:48'),
(9, 1, 'Mathematics', 'MAT', NULL, 'Dr. Lakshmi Devi', 1, '2026-01-10 15:35:48', '2026-01-10 15:35:48'),
(10, 1, 'Physics', 'PHY', NULL, 'Dr. Lakshmi Devi', 1, '2026-01-10 15:35:48', '2026-01-10 15:35:48'),
(11, 1, 'Chemistry', 'CHEM', NULL, 'Dr. Lakshmi Devi', 1, '2026-01-10 15:35:48', '2026-01-10 15:35:48'),
(12, 1, 'Biology', 'BIO', NULL, 'Dr. Lakshmi Devi', 1, '2026-01-10 15:35:48', '2026-01-10 15:35:48'),
(13, 1, 'Computer Engineering', 'CE', NULL, 'Dr. Ramesh Babu', 1, '2026-01-10 15:35:48', '2026-02-14 13:23:06'),
(15, 2, 'Computer Science', 'CS_ARTS', NULL, 'Dr. Lakshmi Devi', 1, '2026-01-10 15:39:15', '2026-01-10 15:39:15'),
(16, 1, 'Electronics', 'EL_ARTS', NULL, 'Dr. Lakshmi Devi', 1, '2026-01-10 15:39:15', '2026-01-10 15:39:15'),
(101, 1, 'B.A Tamil', 'BA-TAM', 'Bachelor of Arts in Tamil', 'Dr. R. Lakshmi', 1, '2026-01-10 17:18:10', '2026-02-14 13:23:06'),
(102, 1, 'B.A English', 'BA-ENG', 'Bachelor of Arts in English', 'Dr. S. Kavitha', 1, '2026-01-10 17:18:10', '2026-02-14 13:23:06'),
(103, 1, 'B.Sc Mathematics', 'BSC-MATH', 'Bachelor of Science in Mathematics', 'Dr. P. Murugan', 1, '2026-01-10 17:18:10', '2026-02-14 13:23:06'),
(104, 1, 'B.Sc Physics', 'BSC-PHY', 'Bachelor of Science in Physics', 'Dr. V. Arunkumar', 1, '2026-01-10 17:18:10', '2026-02-14 13:23:06'),
(105, 1, 'B.Sc Chemistry', 'BSC-CHEM', 'Bachelor of Science in Chemistry', 'Dr. K. Nirmala', 1, '2026-01-10 17:18:10', '2026-02-14 13:23:06'),
(106, 1, 'B.Sc Computer Science', 'BSC-CS', 'Bachelor of Science in Computer Science', 'Dr. J. Meenakshi', 1, '2026-01-10 17:18:10', '2026-02-14 13:23:06'),
(107, 1, 'B.Com', 'BCOM', 'Bachelor of Commerce', 'Dr. A. Prakash', 1, '2026-01-10 17:18:10', '2026-02-14 13:23:06'),
(108, 1, 'B.Com Computer Applications', 'BCOM-CA', 'B.Com with Computer Applications', 'Dr. S. Deepa', 1, '2026-01-10 17:18:10', '2026-02-14 13:23:06'),
(109, 1, 'BBA', 'BBA', 'Bachelor of Business Administration', 'Dr. M. Ramesh', 1, '2026-01-10 17:18:10', '2026-02-14 13:23:06'),
(110, 1, 'BCA', 'BCA', 'Bachelor of Computer Applications', 'Dr. N. Sudha', 1, '2026-01-10 17:18:10', '2026-02-14 13:23:06'),
(112, 1, 'Computer Engineering', 'CE_DIP', NULL, 'Dr. Ramesh Babu', 1, '2026-01-10 17:52:31', '2026-01-10 17:52:31'),
(113, 1, 'Electronics Engineering', 'EL_DIP', NULL, 'Dr. Ramesh Babu', 1, '2026-01-10 17:52:31', '2026-01-10 17:52:31'),
(114, 1, 'Mechanical Engineering', 'MECH_DIP', NULL, 'Dr. Ramesh Babu', 1, '2026-01-10 17:52:31', '2026-01-10 17:52:31'),
(115, 1, 'Civil Engineering', 'CIVIL_DIP', NULL, 'Dr. Ramesh Babu', 1, '2026-01-10 17:52:31', '2026-01-10 17:52:31'),
(116, 1, 'Electrical Engineering', 'EEE_DIP', NULL, 'Dr. Ramesh Babu', 1, '2026-01-10 17:52:31', '2026-01-10 17:52:31'),
(117, 2, 'Computer Science', 'CS_POLY', NULL, 'Dr. Anand Sharma', 1, '2026-01-10 17:56:13', '2026-01-10 17:56:13'),
(118, 2, 'Electronics', 'EL_POLY', NULL, 'Dr. Anand Sharma', 1, '2026-01-10 17:56:13', '2026-01-10 17:56:13'),
(119, 2, 'Mechanical', 'MECH_POLY', NULL, 'Dr. Anand Sharma', 1, '2026-01-10 17:56:13', '2026-01-10 17:56:13'),
(120, 1, 'Civil', 'CIVIL_POLY', NULL, 'Dr. Anand Sharma', 1, '2026-01-10 17:56:13', '2026-01-10 17:56:13'),
(121, 2, 'Information Technology', 'IT_POLY', NULL, 'Dr. Anand Sharma', 1, '2026-01-10 17:56:13', '2026-01-10 17:56:13'),
(122, 2, 'Master of Business Administration', 'MBA_MGMT', NULL, 'Dr. Priya Nair', 1, '2026-01-10 17:56:30', '2026-01-10 17:56:30'),
(123, 2, 'Finance', 'FIN_MGMT', NULL, 'Dr. Priya Nair', 1, '2026-01-10 17:56:30', '2026-01-10 17:56:30'),
(124, 2, 'Human Resources', 'HR_MGMT', NULL, 'Dr. Priya Nair', 1, '2026-01-10 17:56:30', '2026-01-10 17:56:30'),
(125, 2, 'Marketing', 'MKT_MGMT', NULL, 'Dr. Priya Nair', 1, '2026-01-10 17:56:30', '2026-01-10 17:56:30'),
(126, 2, 'Information Technology Management', 'IT_MGMT', NULL, 'Dr. Priya Nair', 1, '2026-01-10 17:56:30', '2026-01-10 17:56:30'),
(202, 3, 'Electronics Engineering', 'EE', 'Diploma in Electronics Engineering', 'Dr. Ramesh Babu', 1, '2026-02-14 13:23:06', '2026-02-14 13:23:06'),
(203, 3, 'Mechanical Engineering', 'ME', 'Diploma in Mechanical Engineering', 'Dr. Ramesh Babu', 1, '2026-02-14 13:23:06', '2026-02-14 13:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gatepasses`
--

CREATE TABLE `gatepasses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `gatepass_date` date NOT NULL,
  `out_time` time NOT NULL,
  `in_time` time NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','staff_approved','staff_rejected','hod_approved','hod_rejected','warden_approved','warden_rejected','final_approved','final_rejected') NOT NULL DEFAULT 'pending',
  `staff_remarks` text DEFAULT NULL,
  `hod_remarks` text DEFAULT NULL,
  `warden_remarks` text DEFAULT NULL,
  `staff_approved_at` timestamp NULL DEFAULT NULL,
  `hod_approved_at` timestamp NULL DEFAULT NULL,
  `warden_approved_at` timestamp NULL DEFAULT NULL,
  `final_approved_at` timestamp NULL DEFAULT NULL,
  `staff_approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `hod_approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `warden_approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gatepasses`
--

INSERT INTO `gatepasses` (`id`, `college_id`, `student_id`, `gatepass_date`, `out_time`, `in_time`, `reason`, `status`, `staff_remarks`, `hod_remarks`, `warden_remarks`, `staff_approved_at`, `hod_approved_at`, `warden_approved_at`, `final_approved_at`, `staff_approved_by`, `hod_approved_by`, `warden_approved_by`, `qr_code`, `is_active`, `created_at`, `updated_at`) VALUES
(182, 1, 21, '2026-02-14', '09:00:00', '17:00:00', 'Medical appointment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:38:01', '2026-02-14 15:38:01'),
(183, 1, 22, '2026-02-14', '10:30:00', '16:30:00', 'Library research', 'staff_approved', 'Approved by staff', NULL, NULL, '2026-02-14 15:38:01', NULL, NULL, NULL, 86, NULL, NULL, NULL, 1, '2026-02-14 15:38:01', '2026-02-14 15:38:01'),
(184, 1, 23, '2026-02-14', '08:45:00', '18:00:00', 'Project work', 'staff_rejected', 'Insufficient details', NULL, NULL, '2026-02-14 15:38:01', NULL, NULL, NULL, 87, NULL, NULL, NULL, 1, '2026-02-14 15:38:01', '2026-02-14 15:38:01'),
(185, 1, 24, '2026-02-14', '11:00:00', '15:00:00', 'Family function', 'hod_approved', 'Approved by staff', 'Approved by HOD', NULL, '2026-02-14 15:38:01', '2026-02-14 15:38:01', NULL, NULL, 86, 81, NULL, NULL, 1, '2026-02-14 15:38:01', '2026-02-14 15:38:01'),
(186, 1, 25, '2026-02-14', '09:30:00', '17:30:00', 'Interview', 'hod_rejected', 'Approved by staff', 'Rejected by HOD - urgent work', NULL, '2026-02-14 15:38:01', '2026-02-14 15:38:01', NULL, NULL, 88, 82, NULL, NULL, 1, '2026-02-14 15:38:01', '2026-02-14 15:38:01'),
(188, 1, 21, '2026-02-14', '09:00:00', '17:00:00', 'Medical appointment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:39:18', '2026-02-14 15:39:18'),
(189, 1, 22, '2026-02-14', '10:30:00', '16:30:00', 'Library research', 'staff_approved', 'Approved by staff', NULL, NULL, '2026-02-14 15:39:18', NULL, NULL, NULL, 86, NULL, NULL, NULL, 1, '2026-02-14 15:39:18', '2026-02-14 15:39:18'),
(190, 1, 23, '2026-02-14', '08:45:00', '18:00:00', 'Project work', 'staff_rejected', 'Insufficient details', NULL, NULL, '2026-02-14 15:39:18', NULL, NULL, NULL, 87, NULL, NULL, NULL, 1, '2026-02-14 15:39:18', '2026-02-14 15:39:18'),
(191, 1, 24, '2026-02-14', '11:00:00', '15:00:00', 'Family function', 'hod_approved', 'Approved by staff', 'Approved by HOD', NULL, '2026-02-14 15:39:18', '2026-02-14 15:39:18', NULL, NULL, 86, 81, NULL, NULL, 1, '2026-02-14 15:39:18', '2026-02-14 15:39:18'),
(192, 1, 25, '2026-02-14', '09:30:00', '17:30:00', 'Interview', 'hod_rejected', 'Approved by staff', 'Rejected by HOD - urgent work', NULL, '2026-02-14 15:39:18', '2026-02-14 15:39:18', NULL, NULL, 88, 82, NULL, NULL, 1, '2026-02-14 15:39:18', '2026-02-14 15:39:18'),
(194, 1, 21, '2026-02-14', '09:00:00', '17:00:00', 'Medical appointment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(195, 1, 22, '2026-02-14', '10:30:00', '16:30:00', 'Library research', 'staff_approved', 'Approved by staff', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, 86, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(196, 1, 23, '2026-02-14', '08:45:00', '18:00:00', 'Project work', 'staff_rejected', 'Insufficient details', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, 87, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(197, 1, 24, '2026-02-14', '11:00:00', '15:00:00', 'Family function', 'hod_approved', 'Approved by staff', 'Approved by HOD', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, 86, 81, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(198, 1, 25, '2026-02-14', '09:30:00', '17:30:00', 'Interview', 'hod_rejected', 'Approved by staff', 'Rejected by HOD - urgent work', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, 88, 82, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(199, 1, 26, '2026-02-14', '08:00:00', '19:00:00', 'Competition participation', 'final_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', 89, 83, NULL, 'GP-ENG-001', 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(200, 1, 27, '2026-02-14', '10:00:00', '16:00:00', 'Document submission', 'warden_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, 90, 84, NULL, 'GP-ENG-002', 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(201, 1, 28, '2026-02-14', '09:15:00', '17:15:00', 'Personal work', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(202, 1, 29, '2026-02-14', '11:30:00', '14:30:00', 'Medical appointment', 'staff_approved', 'Medical emergency approved', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, 86, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(203, 1, 30, '2026-02-14', '08:30:00', '18:30:00', 'Project work', 'hod_approved', 'Valid project reason', 'Approved for academic work', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, 87, 81, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(204, 2, 41, '2026-02-14', '09:00:00', '17:00:00', 'Medical appointment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(205, 2, 42, '2026-02-14', '10:30:00', '16:30:00', 'Library research', 'staff_approved', 'Academic purpose approved', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, 100, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(206, 2, 43, '2026-02-14', '08:45:00', '18:00:00', 'Project work', 'staff_rejected', 'Need more project details', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, 101, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(207, 2, 44, '2026-02-14', '11:00:00', '15:00:00', 'Family function', 'hod_approved', 'Approved by staff', 'Family emergency approved', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, 102, 91, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(208, 2, 45, '2026-02-14', '09:30:00', '17:30:00', 'Interview', 'hod_rejected', 'Approved by staff', 'Interview not verified', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, 103, 92, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(209, 2, 46, '2026-02-14', '08:00:00', '19:00:00', 'Competition participation', 'final_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', 104, 93, NULL, 'GP-WOM-001', 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(210, 2, 47, '2026-02-14', '10:00:00', '16:00:00', 'Document submission', 'warden_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, 100, 94, NULL, 'GP-WOM-002', 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(211, 2, 48, '2026-02-14', '09:15:00', '17:15:00', 'Personal work', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(212, 2, 49, '2026-02-14', '11:30:00', '14:30:00', 'Medical appointment', 'staff_approved', 'Medical emergency approved', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, 101, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(213, 2, 50, '2026-02-14', '08:30:00', '18:30:00', 'Project work', 'hod_approved', 'Valid project reason', 'Approved for academic work', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, 102, 91, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(214, 3, 61, '2026-02-14', '09:00:00', '17:00:00', 'Medical appointment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(215, 3, 62, '2026-02-14', '10:30:00', '16:30:00', 'Library research', 'staff_approved', 'Academic purpose approved', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, 110, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(216, 3, 63, '2026-02-14', '08:45:00', '18:00:00', 'Project work', 'staff_rejected', 'Need more project details', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, 111, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(217, 3, 64, '2026-02-14', '11:00:00', '15:00:00', 'Family function', 'hod_approved', 'Approved by staff', 'Family emergency approved', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, 112, 105, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(218, 3, 65, '2026-02-14', '09:30:00', '17:30:00', 'Interview', 'hod_rejected', 'Approved by staff', 'Interview not verified', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, 113, 106, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(219, 3, 66, '2026-02-14', '08:00:00', '19:00:00', 'Competition participation', 'final_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', 114, 107, NULL, 'GP-POLY-001', 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(220, 3, 67, '2026-02-14', '10:00:00', '16:00:00', 'Document submission', 'warden_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, 110, 108, NULL, 'GP-POLY-002', 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(221, 3, 68, '2026-02-14', '09:15:00', '17:15:00', 'Personal work', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(222, 3, 69, '2026-02-14', '11:30:00', '14:30:00', 'Medical appointment', 'staff_approved', 'Medical emergency approved', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, 111, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(223, 3, 70, '2026-02-14', '08:30:00', '18:30:00', 'Project work', 'hod_approved', 'Valid project reason', 'Approved for academic work', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, 112, 105, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25');

-- --------------------------------------------------------

--
-- Table structure for table `hods`
--

CREATE TABLE `hods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `qualifications` text DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hods`
--

INSERT INTO `hods` (`id`, `college_id`, `user_id`, `department_id`, `employee_id`, `qualifications`, `appointment_date`, `created_at`, `updated_at`) VALUES
(1, 1, 81, 1, 'HOD_CSE_001', 'PhD in Computer Science', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(2, 1, 82, 2, 'HOD_ECE_001', 'PhD in Electronics', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(3, 1, 83, 3, 'HOD_MECH_001', 'PhD in Mechanical', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(4, 1, 84, 4, 'HOD_CIVIL_001', 'PhD in Civil', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(5, 1, 85, 5, 'HOD_EEE_001', 'PhD in Electrical', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(6, 2, 91, 101, 'HOD_TAMIL_001', 'PhD in Tamil Literature', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(7, 2, 92, 102, 'HOD_ENG_001', 'PhD in English Literature', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(8, 2, 93, 103, 'HOD_MATH_001', 'PhD in Mathematics', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(9, 2, 94, 104, 'HOD_PHY_001', 'PhD in Physics', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(10, 2, 95, 105, 'HOD_CHEM_001', 'PhD in Chemistry', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(11, 2, 96, 106, 'HOD_CS_001', 'PhD in Computer Science', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(12, 2, 97, 107, 'HOD_COM_001', 'PhD in Commerce', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(13, 2, 98, 108, 'HOD_BCA_001', 'PhD in Computer Applications', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(14, 2, 99, 110, 'HOD_BBA_001', 'PhD in Business Administration', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(15, 3, 105, 112, 'HOD_CE_001', 'PhD in Computer Engineering', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(16, 3, 106, 113, 'HOD_EE_001', 'PhD in Electronics Engineering', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(17, 3, 107, 114, 'HOD_ME_001', 'PhD in Mechanical Engineering', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_03_000001_create_departments_table', 1),
(6, '2024_01_03_000002_create_students_table', 1),
(7, '2024_01_03_000003_create_staff_table', 1),
(8, '2024_01_03_000004_create_hods_table', 1),
(9, '2024_01_03_000005_create_wardens_table', 1),
(10, '2024_01_03_000006_create_gatepasses_table', 1),
(11, '2024_01_03_000007_modify_users_table_add_roles', 1),
(12, '2024_02_08_000000_add_qr_token_to_users_table', 2),
(13, '2024_02_09_000001_create_colleges_table_and_add_college_id', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('ldharmaprakash2002@gmail.com', '$2y$12$ZpomuhmXqGrYXji/6oKoKuo0XFq/60BQ5b0S7EhFQg0c9PplIR47O', '2026-01-04 04:27:15'),
('warden.boys@college.edu', '$2y$12$OeaW5/EqwmK6brSS4MChSeTUjsgKrxbXZIAKEk4dXb09aiag5DIXu', '2026-01-04 04:25:28');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `type` enum('teaching','non_teaching') NOT NULL DEFAULT 'teaching',
  `qualifications` text DEFAULT NULL,
  `joining_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `college_id`, `user_id`, `department_id`, `employee_id`, `designation`, `type`, `qualifications`, `joining_date`, `created_at`, `updated_at`) VALUES
(1, 1, 86, 1, 'STAFF_CSE_001', 'Assistant Professor', 'teaching', 'M.Tech Computer Science', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(2, 1, 87, 2, 'STAFF_ECE_001', 'Assistant Professor', 'teaching', 'M.Tech Electronics', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(3, 1, 88, 3, 'STAFF_MECH_001', 'Assistant Professor', 'teaching', 'M.Tech Mechanical', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(4, 1, 89, 4, 'STAFF_CIVIL_001', 'Assistant Professor', 'teaching', 'M.Tech Civil', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(5, 1, 90, 5, 'STAFF_EEE_001', 'Assistant Professor', 'teaching', 'M.Tech Electrical', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(6, 2, 100, 101, 'STAFF_TAMIL_001', 'Lecturer', 'teaching', 'M.A Tamil Literature', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(7, 2, 101, 102, 'STAFF_ENG_001', 'Lecturer', 'teaching', 'M.A English Literature', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(8, 2, 102, 103, 'STAFF_MATH_001', 'Lecturer', 'teaching', 'M.Sc Mathematics', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(9, 2, 103, 104, 'STAFF_PHY_001', 'Lecturer', 'teaching', 'M.Sc Physics', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(10, 2, 104, 105, 'STAFF_CHEM_001', 'Lecturer', 'teaching', 'M.Sc Chemistry', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(11, 3, 110, 112, 'STAFF_CE_001', 'Instructor', 'teaching', 'B.E Computer Engineering', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(12, 3, 111, 112, 'STAFF_CE_002', 'Instructor', 'teaching', 'B.E Computer Engineering', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(13, 3, 112, 113, 'STAFF_EE_001', 'Instructor', 'teaching', 'B.E Electronics Engineering', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(14, 3, 113, 113, 'STAFF_EE_002', 'Instructor', 'teaching', 'B.E Electronics Engineering', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(15, 3, 114, 114, 'STAFF_ME_001', 'Instructor', 'teaching', 'B.E Mechanical Engineering', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(16, 3, 115, 114, 'STAFF_ME_002', 'Instructor', 'teaching', 'B.E Mechanical Engineering', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `register_number` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `section` varchar(255) DEFAULT NULL,
  `hosteller` enum('yes','no') NOT NULL DEFAULT 'no',
  `parent_name` varchar(255) NOT NULL,
  `parent_phone` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `college_id`, `user_id`, `department_id`, `register_number`, `semester`, `section`, `hosteller`, `parent_name`, `parent_phone`, `address`, `created_at`, `updated_at`) VALUES
(21, 1, 21, 1, 'ENG2024001', '1', 'A', 'yes', 'Arun Father', '9876543221', '123 Main St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(22, 1, 22, 1, 'ENG2024002', '1', 'B', 'no', 'Priya Father', '9876543222', '456 Cross St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(23, 1, 23, 2, 'ENG2024003', '1', 'A', 'yes', 'Ramesh Father', '9876543223', '789 North St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(24, 1, 24, 1, 'ENG2024004', '1', 'B', 'no', 'Kavitha Father', '9876543224', '321 South St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(25, 1, 25, 3, 'ENG2024005', '1', 'A', 'yes', 'Mohan Father', '9876543225', '654 East St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(26, 1, 26, 1, 'ENG2024006', '1', 'B', 'no', 'Divya Father', '9876543226', '987 West St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(27, 1, 27, 2, 'ENG2024007', '1', 'A', 'yes', 'Suresh Father', '9876543227', '147 Central St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(28, 1, 28, 1, 'ENG2024008', '1', 'B', 'no', 'Anjali Father', '9876543228', '258 Park St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(29, 1, 29, 3, 'ENG2024009', '1', 'A', 'yes', 'Vijay Father', '9876543229', '369 Lake St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(30, 1, 30, 1, 'ENG2024010', '1', 'B', 'no', 'Meena Father', '9876543230', '741 Garden St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(31, 1, 31, 4, 'ENG2024011', '1', 'A', 'yes', 'Rajesh Father', '9876543231', '852 Hill St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(32, 1, 32, 1, 'ENG2024012', '1', 'B', 'no', 'Sangeetha Father', '9876543232', '963 River St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(33, 1, 33, 5, 'ENG2024013', '1', 'A', 'yes', 'Karthik Father', '9876543233', '174 Forest St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(34, 1, 34, 1, 'ENG2024014', '1', 'B', 'no', 'Nandhini Father', '9876543234', '285 Mountain St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(35, 1, 35, 3, 'ENG2024015', '1', 'A', 'yes', 'Anand Father', '9876543235', '396 Ocean St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(36, 1, 36, 1, 'ENG2024016', '1', 'B', 'no', 'Revathi Father', '9876543236', '417 Desert St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(37, 1, 37, 2, 'ENG2024017', '1', 'A', 'yes', 'Murali Father', '9876543237', '528 Valley St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(38, 1, 38, 1, 'ENG2024018', '1', 'B', 'no', 'Gayathri Father', '9876543238', '639 Island St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(39, 1, 39, 5, 'ENG2024019', '1', 'A', 'yes', 'Sathish Father', '9876543239', '750 Beach St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(40, 1, 40, 1, 'ENG2024020', '1', 'B', 'no', 'Bhavani Father', '9876543240', '861 Port St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(41, 2, 41, 101, 'WOM2024001', '1', 'A', 'yes', 'Saraswathi Father', '9876543241', '123 Main St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(42, 2, 42, 101, 'WOM2024002', '1', 'B', 'no', 'Lakshmi Father', '9876543242', '456 Cross St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(43, 2, 43, 102, 'WOM2024003', '1', 'A', 'yes', 'Meena Father', '9876543243', '789 North St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(44, 2, 44, 102, 'WOM2024004', '1', 'B', 'no', 'Kavitha Father', '9876543244', '321 South St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(45, 2, 45, 103, 'WOM2024005', '1', 'A', 'yes', 'Priya Father', '9876543245', '654 East St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(46, 2, 46, 103, 'WOM2024006', '1', 'B', 'no', 'Revathi Father', '9876543246', '987 West St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(47, 2, 47, 104, 'WOM2024007', '1', 'A', 'yes', 'Anjali Father', '9876543247', '147 Central St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(48, 2, 48, 104, 'WOM2024008', '1', 'B', 'no', 'Divya Father', '9876543248', '258 Park St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(49, 2, 49, 105, 'WOM2024009', '1', 'A', 'yes', 'Sangeetha Father', '9876543249', '369 Lake St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(50, 2, 50, 105, 'WOM2024010', '1', 'B', 'no', 'Nandhini Father', '9876543250', '741 Garden St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(51, 2, 51, 106, 'WOM2024011', '1', 'A', 'yes', 'Malathi Father', '9876543251', '852 Hill St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(52, 2, 52, 106, 'WOM2024012', '1', 'B', 'no', 'Vijayalakshmi Father', '9876543252', '963 River St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(53, 2, 53, 107, 'WOM2024013', '1', 'A', 'yes', 'Sowmiya Father', '9876543253', '174 Forest St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(54, 2, 54, 107, 'WOM2024014', '1', 'B', 'no', 'Gayathri Father', '9876543254', '285 Mountain St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(55, 2, 55, 108, 'WOM2024015', '1', 'A', 'yes', 'Bhavani Father', '9876543255', '396 Ocean St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(56, 2, 56, 108, 'WOM2024016', '1', 'B', 'no', 'Anuradha Father', '9876543256', '417 Desert St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(57, 2, 57, 103, 'WOM2024017', '1', 'A', 'yes', 'Chitra Father', '9876543257', '528 Valley St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(58, 2, 58, 103, 'WOM2024018', '1', 'B', 'no', 'Sujatha Father', '9876543258', '639 Island St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(59, 2, 59, 102, 'WOM2024019', '1', 'A', 'yes', 'Radhika Father', '9876543259', '750 Beach St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(60, 2, 60, 102, 'WOM2024020', '1', 'B', 'no', 'Meenakshi Father', '9876543260', '861 Port St, Chennai', '2026-02-14 12:56:58', '2026-02-14 13:00:56'),
(61, 3, 61, 112, 'POLY2024001', '1', 'A', 'yes', 'Rajesh Father', '9876543261', '123 Main St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(62, 3, 62, 112, 'POLY2024002', '1', 'B', 'no', 'Kumar Father', '9876543262', '456 Cross St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(63, 3, 63, 113, 'POLY2024003', '1', 'A', 'yes', 'Mohan Father', '9876543263', '789 North St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(64, 3, 64, 113, 'POLY2024004', '1', 'B', 'no', 'Vijay Father', '9876543264', '321 South St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(65, 3, 65, 114, 'POLY2024005', '1', 'A', 'yes', 'Arun Father', '9876543265', '654 East St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(66, 3, 66, 114, 'POLY2024006', '1', 'B', 'no', 'Priya Father', '9876543266', '987 West St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(67, 3, 67, 115, 'POLY2024007', '1', 'A', 'yes', 'Divya Father', '9876543267', '147 Central St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(68, 3, 68, 115, 'POLY2024008', '1', 'B', 'no', 'Meena Father', '9876543268', '258 Park St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(69, 3, 69, 112, 'POLY2024009', '1', 'A', 'yes', 'Kavitha Father', '9876543269', '369 Lake St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(70, 3, 70, 112, 'POLY2024010', '1', 'B', 'no', 'Anjali Father', '9876543270', '741 Garden St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(71, 3, 71, 113, 'POLY2024011', '1', 'A', 'yes', 'Suresh Father', '9876543271', '852 Hill St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(72, 3, 72, 113, 'POLY2024012', '1', 'B', 'no', 'Ramesh Father', '9876543272', '963 River St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(73, 3, 73, 114, 'POLY2024013', '1', 'A', 'yes', 'Mohan Father', '9876543273', '174 Forest St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(74, 3, 74, 114, 'POLY2024014', '1', 'B', 'no', 'Vijay Father', '9876543274', '285 Mountain St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(75, 3, 75, 115, 'POLY2024015', '1', 'A', 'yes', 'Arun Father', '9876543275', '396 Ocean St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(76, 3, 76, 115, 'POLY2024016', '1', 'B', 'no', 'Priya Father', '9876543276', '417 Desert St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(77, 3, 77, 112, 'POLY2024017', '1', 'A', 'yes', 'Divya Father', '9876543277', '528 Valley St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(78, 3, 78, 112, 'POLY2024018', '1', 'B', 'no', 'Meena Father', '9876543278', '639 Island St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(79, 3, 79, 113, 'POLY2024019', '1', 'A', 'yes', 'Kavitha Father', '9876543279', '750 Beach St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(80, 3, 80, 113, 'POLY2024020', '1', 'B', 'no', 'Anjali Father', '9876543280', '861 Port St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56');

-- --------------------------------------------------------

--
-- Stand-in structure for view `unified_departments`
-- (See below for the actual view)
--
CREATE TABLE `unified_departments` (
`id` bigint(21) unsigned
,`name` varchar(255)
,`code` varchar(255)
,`description` mediumtext
,`head_name` varchar(255)
,`is_active` tinyint(4)
,`created_at` timestamp
,`updated_at` timestamp
,`institute_id` int(1)
,`institute_name` varchar(30)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `unified_users`
-- (See below for the actual view)
--
CREATE TABLE `unified_users` (
`id` bigint(21) unsigned
,`name` varchar(255)
,`username` varchar(255)
,`email` varchar(255)
,`password` varchar(255)
,`role` varchar(7)
,`phone` varchar(255)
,`is_active` tinyint(4)
,`remember_token` varchar(100)
,`created_at` timestamp
,`updated_at` timestamp
,`institute_id` int(1)
,`institute_name` varchar(30)
,`institute_short_name` varchar(4)
,`theme_color` varchar(7)
,`logo` varchar(17)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','staff','hod','warden','admin') NOT NULL DEFAULT 'student',
  `institute_id` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `phone` varchar(255) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `qr_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `college_id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `institute_id`, `phone`, `gender`, `is_active`, `remember_token`, `qr_token`, `created_at`, `updated_at`) VALUES
(21, 1, 'Arun Kumar', 'arunkumar', 'arun.kumar@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543221', 'male', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(22, 1, 'Priya Sharma', 'priyasharma', 'priya.sharma@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543222', 'female', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(23, 1, 'Ramesh Babu', 'rameshbabu', 'ramesh.babu@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543223', 'male', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(24, 1, 'Kavitha R', 'kavithar', 'kavitha.r@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543224', 'female', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(25, 1, 'Mohan Reddy', 'mohanreddy', 'mohan.reddy@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543225', 'male', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(26, 1, 'Divya S', 'divyas', 'divya.s@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543226', 'female', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(27, 1, 'Suresh Kumar', 'sureshkumar', 'suresh.kumar@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543227', 'male', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(28, 1, 'Anjali Devi', 'anjalidevi', 'anjali.devi@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543228', 'female', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(29, 1, 'Vijay Kumar', 'vijaykumar', 'vijay.kumar@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543229', 'male', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(30, 1, 'Meena Lakshmi', 'meenalakshmi', 'meena.lakshmi@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543230', 'female', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(31, 1, 'Rajesh M', 'rajeshm', 'rajesh.m@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543231', 'male', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(32, 1, 'Sangeetha R', 'sangeethar', 'sangeetha.r@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543232', 'female', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(33, 1, 'Karthik S', 'karthiks', 'karthik.s@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543233', 'male', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(34, 1, 'Nandhini K', 'nandhinik', 'nandhini.k@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543234', 'female', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(35, 1, 'Anand Babu', 'anandbabu', 'anand.babu@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543235', 'male', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(36, 1, 'Revathi S', 'revathis', 'revathi.s@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543236', 'female', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(37, 1, 'Murali Krishna', 'muralikrishna', 'murali.krishna@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543237', 'male', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(38, 1, 'Gayathri Devi', 'gayathridevi', 'gayathri.devi@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543238', 'female', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(39, 1, 'Sathish Kumar', 'sathishkumar', 'sathish.kumar@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543239', 'male', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(40, 1, 'Bhavani R', 'bhavanir', 'bhavani.r@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543240', 'female', 1, NULL, NULL, '2026-02-14 12:53:29', '2026-02-14 12:53:29'),
(41, 2, 'Saraswathi R', 'saraswathir', 'saraswathi.r@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543241', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(42, 2, 'Lakshmi S', 'lakshmis', 'lakshmi.s@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543242', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(43, 2, 'Meena K', 'meenak', 'meena.k@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543243', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(44, 2, 'Kavitha R', 'kavithar2', 'kavitha.r2@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543244', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(45, 2, 'Priya M', 'priyam', 'priya.m@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543245', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(46, 2, 'Revathi S', 'revathis2', 'revathi.s2@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543246', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(47, 2, 'Anjali K', 'anjalik', 'anjali.k@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543247', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(48, 2, 'Divya R', 'divyar2', 'divya.r2@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543248', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(49, 2, 'Sangeetha M', 'sangeetham', 'sangeetha.m@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543249', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(50, 2, 'Nandhini S', 'nandhinis2', 'nandhini.s2@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543250', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(51, 2, 'Malathi R', 'malathir', 'malathi.r@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543251', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(52, 2, 'Vijayalakshmi K', 'vijayalakshmik', 'vijayalakshmi.k@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543252', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(53, 2, 'Sowmiya R', 'sowmiyar', 'sowmiya.r@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543253', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(54, 2, 'Gayathri S', 'gayathris2', 'gayathri.s2@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543254', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(55, 2, 'Bhavani M', 'bhavanim', 'bhavani.m@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543255', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(56, 2, 'Anuradha R', 'anuradhar', 'anuradha.r@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543256', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(57, 2, 'Chitra S', 'chitras', 'chitra.s@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543257', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(58, 2, 'Sujatha K', 'sujathak', 'sujatha.k@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543258', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(59, 2, 'Radhika S', 'radhikas', 'radhika.s@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543259', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(60, 2, 'Meenakshi R', 'meenakshir', 'meenakshi.r@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543260', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 12:55:54'),
(61, 3, 'Rajesh K', 'rajeshk', 'rajesh.k@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543261', 'male', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(62, 3, 'Kumar S', 'kumars', 'kumar.s@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543262', 'male', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(63, 3, 'Mohan R', 'mohanr', 'mohan.r@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543263', 'male', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(64, 3, 'Vijay K', 'vijayk', 'vijay.k@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543264', 'male', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(65, 3, 'Arun S', 'aruns', 'arun.s@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543265', 'male', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(66, 3, 'Priya R', 'priyar', 'priya.r@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543266', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(67, 3, 'Divya S', 'divyas2', 'divya.s2@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543267', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(68, 3, 'Meena K', 'meenak2', 'meena.k2@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543268', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(69, 3, 'Kavitha R', 'kavithar3', 'kavitha.r3@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543269', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(70, 3, 'Anjali M', 'anjalim', 'anjali.m@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543270', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(71, 3, 'Suresh K', 'sureshk', 'suresh.k@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543271', 'male', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(72, 3, 'Ramesh S', 'rameshs', 'ramesh.s@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543272', 'male', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(73, 3, 'Mohan M', 'mohanm', 'mohan.m@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543273', 'male', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(74, 3, 'Vijay R', 'vijayr', 'vijay.r@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543274', 'male', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(75, 3, 'Arun M', 'arunm', 'arun.m@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543275', 'male', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(76, 3, 'Priya S', 'priyas', 'priya.s@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543276', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(77, 3, 'Divya M', 'divyam', 'divya.m@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543277', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(78, 3, 'Meena S', 'meenas', 'meena.s@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543278', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(79, 3, 'Kavitha K', 'kavithak', 'kavitha.k@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543279', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(80, 3, 'Anjali R', 'anjalir', 'anjali.r@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 1, '9876543280', 'female', 1, NULL, NULL, '2026-02-14 12:55:54', '2026-02-14 13:11:49'),
(81, 1, 'Dr. Ramesh Kumar', 'hod_cse_eng', 'hod.cse@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543281', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(82, 1, 'Dr. Priya Sharma', 'hod_ece_eng', 'hod.ece@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543282', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(83, 1, 'Dr. Anand Patel', 'hod_mech_eng', 'hod.mech@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543283', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(84, 1, 'Dr. Sunita Reddy', 'hod_civil_eng', 'hod.civil@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543284', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(85, 1, 'Dr. Vijay Kumar', 'hod_eee_eng', 'hod.eee@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543285', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(86, 1, 'Rajesh M', 'staff_cse1', 'rajesh.cse@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543286', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(87, 1, 'Kavitha R', 'staff_ece1', 'kavitha.ece@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543287', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(88, 1, 'Mohan S', 'staff_mech1', 'mohan.mech@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543288', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(89, 1, 'Divya S', 'staff_civil1', 'divya.civil@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543289', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(90, 1, 'Arun K', 'staff_eee1', 'arun.eee@engcollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543290', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(91, 2, 'Dr. R. Lakshmi', 'hod_tamil_women', 'hod.tamil@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543291', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(92, 2, 'Dr. S. Kavitha', 'hod_english_women', 'hod.english@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543292', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(93, 2, 'Dr. P. Murugan', 'hod_math_women', 'hod.math@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543293', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(94, 2, 'Dr. V. Arunkumar', 'hod_physics_women', 'hod.physics@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543294', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(95, 2, 'Dr. K. Nirmala', 'hod_chem_women', 'hod.chem@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543295', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(96, 2, 'Dr. J. Meenakshi', 'hod_cs_women', 'hod.cs@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543296', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(97, 2, 'Dr. A. Prakash', 'hod_com_women', 'hod.com@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543297', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(98, 2, 'N. Sudha', 'hod_bca_women', 'hod.bca@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543298', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(99, 2, 'Dr. M. Ramesh', 'hod_bba_women', 'hod.bba@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543299', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(100, 2, 'Priya Rani', 'staff_tamil1', 'priya.tamil@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543300', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(101, 2, 'Kavitha S', 'staff_english1', 'kavitha.english@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543301', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(102, 2, 'Meena K', 'staff_math1', 'meena.math@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543302', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(103, 2, 'Revathi S', 'staff_physics1', 'revathi.physics@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543303', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(104, 2, 'Anjali M', 'staff_chem1', 'anjali.chem@womenscollege.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543304', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(105, 3, 'Dr. Anand Sharma', 'hod_ce_poly', 'hod.ce@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543305', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(106, 3, 'Dr. Ramesh Babu', 'hod_ee_poly', 'hod.ee@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543306', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(107, 3, 'Dr. Ramesh Babu', 'hod_me_poly', 'hod.me@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543307', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(108, 3, 'Dr. Ramesh Babu', 'hod_civil_poly', 'hod.civil@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543308', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(109, 3, 'Dr. Ramesh Babu', 'hod_eee_poly', 'hod.eee@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hod', 1, '9876543309', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(110, 3, 'R. Kumar', 'staff_ce1', 'kumar.ce@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543310', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(111, 3, 'S. Rani', 'staff_ce2', 'rani.ce@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543311', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(112, 3, 'P. Kumar', 'staff_ee1', 'kumar.ee@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543312', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(113, 3, 'M. Devi', 'staff_ee2', 'devi.ee@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543313', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(114, 3, 'K. Babu', 'staff_me1', 'babu.me@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543314', 'male', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51'),
(115, 3, 'L. Rani', 'staff_me2', 'rani.me@polytechnic.edu', NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '9876543315', 'female', 1, NULL, NULL, '2026-02-14 13:02:51', '2026-02-14 13:02:51');

-- --------------------------------------------------------

--
-- Table structure for table `wardens`
--

CREATE TABLE `wardens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `hostel_type` enum('boys','girls','mixed') NOT NULL DEFAULT 'boys',
  `qualifications` text DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `unified_departments`
--
DROP TABLE IF EXISTS `unified_departments`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `unified_departments`  AS SELECT `departments`.`id` AS `id`, `departments`.`name` AS `name`, `departments`.`code` AS `code`, `departments`.`description` AS `description`, `departments`.`head_name` AS `head_name`, `departments`.`is_active` AS `is_active`, `departments`.`created_at` AS `created_at`, `departments`.`updated_at` AS `updated_at`, 1 AS `institute_id`, 'Engineering College' AS `institute_name` FROM `departments`union all select `womens_college_gatepass`.`departments`.`id` + 1000 AS `id`,`womens_college_gatepass`.`departments`.`name` AS `name`,`womens_college_gatepass`.`departments`.`code` AS `code`,`womens_college_gatepass`.`departments`.`description` AS `description`,`womens_college_gatepass`.`departments`.`head_name` AS `head_name`,`womens_college_gatepass`.`departments`.`is_active` AS `is_active`,`womens_college_gatepass`.`departments`.`created_at` AS `created_at`,`womens_college_gatepass`.`departments`.`updated_at` AS `updated_at`,2 AS `institute_id`,'Arts & Science College (Women)' AS `institute_name` from `womens_college_gatepass`.`departments` union all select `polytechnic_gatepass`.`departments`.`id` + 2000 AS `id`,`polytechnic_gatepass`.`departments`.`name` AS `name`,`polytechnic_gatepass`.`departments`.`code` AS `code`,`polytechnic_gatepass`.`departments`.`description` AS `description`,`polytechnic_gatepass`.`departments`.`head_name` AS `head_name`,`polytechnic_gatepass`.`departments`.`is_active` AS `is_active`,`polytechnic_gatepass`.`departments`.`created_at` AS `created_at`,`polytechnic_gatepass`.`departments`.`updated_at` AS `updated_at`,3 AS `institute_id`,'Polytechnic College' AS `institute_name` from `polytechnic_gatepass`.`departments`  ;

-- --------------------------------------------------------

--
-- Structure for view `unified_users`
--
DROP TABLE IF EXISTS `unified_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `unified_users`  AS SELECT `users`.`id` AS `id`, `users`.`name` AS `name`, `users`.`username` AS `username`, `users`.`email` AS `email`, `users`.`password` AS `password`, `users`.`role` AS `role`, `users`.`phone` AS `phone`, `users`.`is_active` AS `is_active`, `users`.`remember_token` AS `remember_token`, `users`.`created_at` AS `created_at`, `users`.`updated_at` AS `updated_at`, 1 AS `institute_id`, 'Engineering College' AS `institute_name`, 'ENG' AS `institute_short_name`, '#3B82F6' AS `theme_color`, 'fa-cogs' AS `logo` FROM `users`union all select `womens_college_gatepass`.`users`.`id` + 10000 AS `id`,`womens_college_gatepass`.`users`.`name` AS `name`,`womens_college_gatepass`.`users`.`username` AS `username`,`womens_college_gatepass`.`users`.`email` AS `email`,`womens_college_gatepass`.`users`.`password` AS `password`,`womens_college_gatepass`.`users`.`role` AS `role`,`womens_college_gatepass`.`users`.`phone` AS `phone`,`womens_college_gatepass`.`users`.`is_active` AS `is_active`,`womens_college_gatepass`.`users`.`remember_token` AS `remember_token`,`womens_college_gatepass`.`users`.`created_at` AS `created_at`,`womens_college_gatepass`.`users`.`updated_at` AS `updated_at`,2 AS `institute_id`,'Arts & Science College (Women)' AS `institute_name`,'ARTS' AS `institute_short_name`,'#EC4899' AS `theme_color`,'fa-graduation-cap' AS `logo` from `womens_college_gatepass`.`users` union all select `polytechnic_gatepass`.`users`.`id` + 20000 AS `id`,`polytechnic_gatepass`.`users`.`name` AS `name`,`polytechnic_gatepass`.`users`.`username` AS `username`,`polytechnic_gatepass`.`users`.`email` AS `email`,`polytechnic_gatepass`.`users`.`password` AS `password`,`polytechnic_gatepass`.`users`.`role` AS `role`,`polytechnic_gatepass`.`users`.`phone` AS `phone`,`polytechnic_gatepass`.`users`.`is_active` AS `is_active`,`polytechnic_gatepass`.`users`.`remember_token` AS `remember_token`,`polytechnic_gatepass`.`users`.`created_at` AS `created_at`,`polytechnic_gatepass`.`users`.`updated_at` AS `updated_at`,3 AS `institute_id`,'Polytechnic College' AS `institute_name`,'POLY' AS `institute_short_name`,'#10B981' AS `theme_color`,'fa-tools' AS `logo` from `polytechnic_gatepass`.`users`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `colleges_college_code_unique` (`college_code`),
  ADD KEY `colleges_is_active_index` (`is_active`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`),
  ADD KEY `departments_college_id_index` (`college_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gatepasses`
--
ALTER TABLE `gatepasses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gatepasses_qr_code_unique` (`qr_code`),
  ADD KEY `gatepasses_student_id_foreign` (`student_id`),
  ADD KEY `gatepasses_staff_approved_by_foreign` (`staff_approved_by`),
  ADD KEY `gatepasses_hod_approved_by_foreign` (`hod_approved_by`),
  ADD KEY `gatepasses_warden_approved_by_foreign` (`warden_approved_by`),
  ADD KEY `gatepasses_college_id_index` (`college_id`);

--
-- Indexes for table `hods`
--
ALTER TABLE `hods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hods_employee_id_unique` (`employee_id`),
  ADD KEY `hods_user_id_foreign` (`user_id`),
  ADD KEY `hods_department_id_foreign` (`department_id`),
  ADD KEY `hods_college_id_index` (`college_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_employee_id_unique` (`employee_id`),
  ADD KEY `staff_user_id_foreign` (`user_id`),
  ADD KEY `staff_department_id_foreign` (`department_id`),
  ADD KEY `staff_college_id_index` (`college_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_register_number_unique` (`register_number`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_department_id_foreign` (`department_id`),
  ADD KEY `students_college_id_index` (`college_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_qr_token_unique` (`qr_token`),
  ADD KEY `users_college_id_index` (`college_id`);

--
-- Indexes for table `wardens`
--
ALTER TABLE `wardens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wardens_employee_id_unique` (`employee_id`),
  ADD KEY `wardens_user_id_foreign` (`user_id`),
  ADD KEY `wardens_college_id_index` (`college_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gatepasses`
--
ALTER TABLE `gatepasses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `hods`
--
ALTER TABLE `hods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500;

--
-- AUTO_INCREMENT for table `wardens`
--
ALTER TABLE `wardens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gatepasses`
--
ALTER TABLE `gatepasses`
  ADD CONSTRAINT `gatepasses_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gatepasses_hod_approved_by_foreign` FOREIGN KEY (`hod_approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gatepasses_staff_approved_by_foreign` FOREIGN KEY (`staff_approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gatepasses_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gatepasses_warden_approved_by_foreign` FOREIGN KEY (`warden_approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `hods`
--
ALTER TABLE `hods`
  ADD CONSTRAINT `hods_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hods_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wardens`
--
ALTER TABLE `wardens`
  ADD CONSTRAINT `wardens_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wardens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
