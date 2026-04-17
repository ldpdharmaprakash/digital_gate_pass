-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2026 at 08:04 PM
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
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `target_type` varchar(255) DEFAULT NULL,
  `target_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `college_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` enum('present','late') NOT NULL DEFAULT 'present',
  `method` enum('qr','manual') NOT NULL DEFAULT 'qr',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `target_type` varchar(255) NOT NULL,
  `target_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `theme_color` varchar(255) NOT NULL DEFAULT '#1e40af',
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

INSERT INTO `colleges` (`id`, `college_name`, `college_code`, `college_type`, `gender_restriction`, `primary_color`, `secondary_color`, `theme_color`, `address`, `phone`, `email`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Engineering College', 'ENG', 'engineering', 'coed', '#3B82F6', '#10B981', '#3B82F6', NULL, NULL, NULL, 1, '2026-02-08 13:24:12', '2026-02-08 13:24:12'),
(2, 'Arts & Science College', 'ARTS', 'arts', 'female_only', '#8B5CF6', '#F59E0B', '#3B82F6', NULL, NULL, NULL, 1, '2026-02-08 13:24:12', '2026-02-08 13:24:12'),
(3, 'Polytechnic College', 'POLY', 'polytechnic', 'coed', '#EF4444', '#FCA5A5', '#3B82F6', NULL, NULL, NULL, 1, '2026-02-08 13:24:12', '2026-02-08 13:24:12');

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
  `staff_rejected_at` timestamp NULL DEFAULT NULL,
  `hod_rejected_at` timestamp NULL DEFAULT NULL,
  `warden_rejected_at` timestamp NULL DEFAULT NULL,
  `final_approved_at` timestamp NULL DEFAULT NULL,
  `staff_approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `hod_approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `warden_approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `staff_rejected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `hod_rejected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `warden_rejected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `qr_code` longtext DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gatepasses`
--

INSERT INTO `gatepasses` (`id`, `college_id`, `student_id`, `gatepass_date`, `out_time`, `in_time`, `reason`, `status`, `staff_remarks`, `hod_remarks`, `warden_remarks`, `staff_approved_at`, `hod_approved_at`, `warden_approved_at`, `staff_rejected_at`, `hod_rejected_at`, `warden_rejected_at`, `final_approved_at`, `staff_approved_by`, `hod_approved_by`, `warden_approved_by`, `staff_rejected_by`, `hod_rejected_by`, `warden_rejected_by`, `qr_code`, `is_active`, `created_at`, `updated_at`) VALUES
(182, 1, 21, '2026-02-14', '09:00:00', '17:00:00', 'Medical appointment', 'staff_approved', NULL, NULL, NULL, '2026-02-25 10:52:07', NULL, NULL, NULL, NULL, NULL, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:38:01', '2026-02-25 10:52:07'),
(183, 1, 22, '2026-02-14', '10:30:00', '16:30:00', 'Library research', 'staff_approved', 'Approved by staff', NULL, NULL, '2026-02-14 15:38:01', NULL, NULL, NULL, NULL, NULL, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:38:01', '2026-02-14 15:38:01'),
(184, 1, 23, '2026-02-14', '08:45:00', '18:00:00', 'Project work', 'staff_rejected', 'Insufficient details', NULL, NULL, '2026-02-14 15:38:01', NULL, NULL, NULL, NULL, NULL, NULL, 87, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:38:01', '2026-02-14 15:38:01'),
(185, 1, 24, '2026-02-14', '11:00:00', '15:00:00', 'Family function', 'hod_approved', 'Approved by staff', 'Approved by HOD', NULL, '2026-02-14 15:38:01', '2026-02-14 15:38:01', NULL, NULL, NULL, NULL, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:38:01', '2026-02-14 15:38:01'),
(186, 1, 25, '2026-02-14', '09:30:00', '17:30:00', 'Interview', 'hod_rejected', 'Approved by staff', 'Rejected by HOD - urgent work', NULL, '2026-02-14 15:38:01', '2026-02-14 15:38:01', NULL, NULL, NULL, NULL, NULL, 88, 82, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:38:01', '2026-02-14 15:38:01'),
(188, 1, 21, '2026-02-14', '09:00:00', '17:00:00', 'Medical appointment', 'staff_approved', NULL, NULL, NULL, '2026-02-22 00:55:43', NULL, NULL, NULL, NULL, NULL, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:39:18', '2026-02-22 00:55:43'),
(189, 1, 22, '2026-02-14', '10:30:00', '16:30:00', 'Library research', 'staff_approved', 'Approved by staff', NULL, NULL, '2026-02-14 15:39:18', NULL, NULL, NULL, NULL, NULL, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:39:18', '2026-02-14 15:39:18'),
(190, 1, 23, '2026-02-14', '08:45:00', '18:00:00', 'Project work', 'staff_rejected', 'Insufficient details', NULL, NULL, '2026-02-14 15:39:18', NULL, NULL, NULL, NULL, NULL, NULL, 87, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:39:18', '2026-02-14 15:39:18'),
(191, 1, 24, '2026-02-14', '11:00:00', '15:00:00', 'Family function', 'hod_approved', 'Approved by staff', 'Approved by HOD', NULL, '2026-02-14 15:39:18', '2026-02-14 15:39:18', NULL, NULL, NULL, NULL, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:39:18', '2026-02-14 15:39:18'),
(192, 1, 25, '2026-02-14', '09:30:00', '17:30:00', 'Interview', 'hod_rejected', 'Approved by staff', 'Rejected by HOD - urgent work', NULL, '2026-02-14 15:39:18', '2026-02-14 15:39:18', NULL, NULL, NULL, NULL, NULL, 88, 82, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:39:18', '2026-02-14 15:39:18'),
(194, 1, 21, '2026-02-14', '09:00:00', '17:00:00', 'Medical appointment', 'hod_approved', NULL, NULL, NULL, '2026-02-22 00:55:43', '2026-04-16 11:17:58', NULL, NULL, NULL, NULL, NULL, 86, 525, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-04-16 11:17:58'),
(195, 1, 22, '2026-02-14', '10:30:00', '16:30:00', 'Library research', 'hod_rejected', 'Approved by staff', NULL, NULL, '2026-02-14 15:42:25', '2026-02-14 10:52:57', NULL, NULL, NULL, NULL, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 10:52:57'),
(196, 1, 23, '2026-02-14', '08:45:00', '18:00:00', 'Project work', 'staff_rejected', 'Insufficient details', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, NULL, 87, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(197, 1, 24, '2026-02-14', '11:00:00', '15:00:00', 'Family function', 'hod_approved', 'Approved by staff', 'Approved by HOD', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(198, 1, 25, '2026-02-14', '09:30:00', '17:30:00', 'Interview', 'hod_rejected', 'Approved by staff', 'Rejected by HOD - urgent work', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, 88, 82, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(199, 1, 26, '2026-02-14', '08:00:00', '19:00:00', 'Competition participation', 'final_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, '2026-02-14 15:42:25', 89, 83, NULL, NULL, NULL, NULL, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsAQMAAABDsxw2AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAACKElEQVRoge2aPZKDMAyFlUlBmSNwFB/NORpH4QgpU2Si1Z+Nk52dWQTlU7HD4o8GK09PMkSnRmEPqsv8aDdvz+ub+E5zLC7AfmGL3r8IxuuNX3JdmR8TO+YPVmB5TF71yzAJwfheFJNQbPINAnYUo7JKbntSP0iSXALYeVjcNOlQDTFVAXYUGzTk6Yqh0nHhv6UG2P8xT2uvgJOJyXARi8CyWI+q/3sFlFKoFXBcBZbF5qiAi9g2MjEh02p7UO84DyyDFUtpatIhBoN5JdJSqE6D4kFgOaz5CtuO2AWVjncsWf4vwLJYK3NmMMIeG+YV0LaDgCWxEnbCJVpfvjkNt8dE02v7LQDbj7WX7xrSsz1GE90eA0tiZaW4Dg1xn6z2uPiwwn4LwFJYMV9h6c69y+PAxGD4vgBLYhRuTUxaK3wf0kGxWcBymCW59Rqzjys13B5b2gM7hNFQAftqb+6iiQaWxUKHuxnu22Hjd7oysANYiTmPrVITk82/uU8GlsX6uNIGPj6R8Kl7bU20zd+ApbAYTsa4kjbpcGX28TuwNObZrKtDT8f+8sPaEbA0FhpivcbHNLga+wZ2AOtR2xHGnb6yHVgeK742HihLbnOricAOYov+9Za5T92bkXODsUk0sP3YPJwZ2TytcBi5vkEE7DCm/q19F0FjKQR2BmbSQfGBX5zXdx5YFhs0ZIov/ThON5g/bR6w3VgXirJGK2c93feRHLAUdmr8APZQvTLcHPt+AAAAAElFTkSuQmCC', 1, '2026-02-14 15:42:25', '2026-02-23 04:34:36'),
(200, 1, 27, '2026-02-14', '10:00:00', '16:00:00', 'Document submission', 'warden_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, 90, 84, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-23 02:04:35'),
(201, 1, 28, '2026-02-14', '09:15:00', '17:15:00', 'Personal work', 'staff_approved', NULL, NULL, NULL, '2026-02-22 00:55:34', NULL, NULL, NULL, NULL, NULL, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-22 00:55:34'),
(202, 1, 29, '2026-02-14', '11:30:00', '14:30:00', 'Medical appointment', 'staff_approved', 'Medical emergency approved', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(203, 1, 30, '2026-02-14', '08:30:00', '18:30:00', 'Project work', 'hod_approved', 'Valid project reason', 'Approved for academic work', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, 87, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(204, 2, 41, '2026-02-14', '09:00:00', '17:00:00', 'Medical appointment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(205, 2, 42, '2026-02-14', '10:30:00', '16:30:00', 'Library research', 'staff_approved', 'Academic purpose approved', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, NULL, 100, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(206, 2, 43, '2026-02-14', '08:45:00', '18:00:00', 'Project work', 'staff_rejected', 'Need more project details', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, NULL, 101, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(207, 2, 44, '2026-02-14', '11:00:00', '15:00:00', 'Family function', 'hod_approved', 'Approved by staff', 'Family emergency approved', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, 102, 91, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(208, 2, 45, '2026-02-14', '09:30:00', '17:30:00', 'Interview', 'hod_rejected', 'Approved by staff', 'Interview not verified', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, 103, 92, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(209, 2, 46, '2026-02-14', '08:00:00', '19:00:00', 'Competition participation', 'final_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, '2026-02-14 15:42:25', 104, 93, NULL, NULL, NULL, NULL, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsAQMAAABDsxw2AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAACLUlEQVRoge2aO3aDQAxFlZOCkiWwlFkaXhpLYQkuKXys6DcCkpPCgvKpcMjMJcVIefqMiW61xm40L9OzL47b95v4QVNsLsD+YIuufwnG68gveZ6ZnwM75i/OwOqYHPXLMDHB+NEUE1NscAcBu4pRWyW2PaifJEEuBuw+TBRDMRUT2XuTqQqwq9iuITRokLNgm6z8KzXAPsA8rD0DDiYmh4fYBFbF0maVDjKJFndoBjzuAqtioSESyaPGti6NLiZy/hbtxgOrYM1C+ugFFjEhTYVaaVC8CKyG9brCH3xFZeNN+4o4CFgR62mOWmTAhwQ5Z/dh7iBgRaxFOWFnzj3xbV4eEw2v/F8AVsBcov3wTTr0R44msjwGVsT08NkiOdyhMwovj5sPK+wvACthzeoKohhN9C7PMfZ2j4BVMYpqzXo6T3x0lA7q8Q+shO29xuTjSrWcUWzALmHNhu0xtzxNfqw3iSYaWBGjqNayGE53eD/yzcCuYNHB2S51MbH6TXfjdgNYETtkQK80ItpjLBwvAitjqhhdOnpRt2fAcAewKua/6lH3piNLjnAQEbAy5jN27zVO0+DZ3PMGdgFL80WOe2S/PPpVJwP7GGuxaU8W5Brb2uV5pQHsGrboZ3pEdzkLOS8wdokG9jk28WFcyZwTtjT3ArBrWP+ulM3hcywM7CbMpIPiC3794r7zwKqYfvq4Mq8+maN35nOZB+xjLIWirV06Vms6zldywErYrfYDt3/FEiPMzRYAAAAASUVORK5CYII=', 1, '2026-02-14 15:42:25', '2026-02-23 04:34:37'),
(210, 2, 47, '2026-02-14', '10:00:00', '16:00:00', 'Document submission', 'warden_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, 100, 94, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-23 02:04:35'),
(211, 2, 48, '2026-02-14', '09:15:00', '17:15:00', 'Personal work', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(212, 2, 49, '2026-02-14', '11:30:00', '14:30:00', 'Medical appointment', 'staff_approved', 'Medical emergency approved', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, NULL, 101, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(213, 2, 50, '2026-02-14', '08:30:00', '18:30:00', 'Project work', 'hod_approved', 'Valid project reason', 'Approved for academic work', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, 102, 91, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(214, 3, 61, '2026-02-14', '09:00:00', '17:00:00', 'Medical appointment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(215, 3, 62, '2026-02-14', '10:30:00', '16:30:00', 'Library research', 'staff_approved', 'Academic purpose approved', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, NULL, 110, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(216, 3, 63, '2026-02-14', '08:45:00', '18:00:00', 'Project work', 'staff_rejected', 'Need more project details', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, NULL, 111, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(217, 3, 64, '2026-02-14', '11:00:00', '15:00:00', 'Family function', 'hod_approved', 'Approved by staff', 'Family emergency approved', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, 112, 105, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(218, 3, 65, '2026-02-14', '09:30:00', '17:30:00', 'Interview', 'hod_rejected', 'Approved by staff', 'Interview not verified', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, 113, 106, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(219, 3, 66, '2026-02-14', '08:00:00', '19:00:00', 'Competition participation', 'final_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, '2026-02-14 15:42:25', 114, 107, NULL, NULL, NULL, NULL, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsAQMAAABDsxw2AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAACHElEQVRoge2aMZLDMAhFtZPCZY7go+hoztF8FB8hZYrMsvBBkrOZ2dlgl58io6CXRpAvwC7lVKviVpZ1vjfn9XH5LnIrc2yuxN6w1fxfisl2laeuF5H7JI75DxdieUyP+glMTTG5VcPUDJs8QMSOYqVqFMIQBTVi52HDqbmtGoIFsaPYLw2BMj/U87fUEPsfFnntZw4x2S1ik1gW67bYd78Bt2JJ/rJLLIvNcQPCidxWu4jfich28MQyWEVKexSgGOrdgKHSgLyoEcthVlc87MyLNR3NIygwbMscFiBiOaxdc+ospsx2+CK9+0A4CrEkVtEy7+47LKx3hk3P8V8g9jlmuY2LDxa7fTTRy2NiSSw65VKiKkad7OVx7QUzsSRmzZ3rsGV4dHnRfaiYNPUmlsM8pQ2BhrxLRwSLWAqro9eYfVxphsNfIkDE8pgXGDG37LsoMKw3mXpjQiyFoTzeFcM9HN6PXITYEazVwLKOxU5MvE4mlsTq6tVaDHxEQkNiLBw/JJbGZmzEuNLP/ir9BnSeWBrzry7ILbfb4cewohBLYz5j916jXXywBeH5JnYA6wbnMx4VWbaPAoNYGqshyrZuBYZriFcaxI5hq33uBLlLx1CVLtHEPsfm9raJj9/9WUarNFqAiB3GZLwX0QaYZSJ2EraW8TpEeAZPLIt1DRmPPkWid5bXMo/Yx1gXirq15m5zrX55JEcshZ1qPx8AgBi8QH36AAAAAElFTkSuQmCC', 1, '2026-02-14 15:42:25', '2026-02-23 04:34:40'),
(220, 3, 67, '2026-02-14', '10:00:00', '16:00:00', 'Document submission', 'warden_approved', 'Approved by staff', 'Approved by HOD', 'Approved by Warden', '2026-02-14 15:42:25', '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, 110, 108, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-23 02:04:35'),
(221, 3, 68, '2026-02-14', '09:15:00', '17:15:00', 'Personal work', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(222, 3, 69, '2026-02-14', '11:30:00', '14:30:00', 'Medical appointment', 'staff_approved', 'Medical emergency approved', NULL, NULL, '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, NULL, 111, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(223, 3, 70, '2026-02-14', '08:30:00', '18:30:00', 'Project work', 'hod_approved', 'Valid project reason', 'Approved for academic work', NULL, '2026-02-14 15:42:25', '2026-02-14 15:42:25', NULL, NULL, NULL, NULL, NULL, 112, 105, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 15:42:25', '2026-02-14 15:42:25'),
(224, 1, 23, '2026-02-27', '09:42:00', '21:43:00', 'testing', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-14 10:40:09', '2026-02-14 10:40:09'),
(225, 1, 21, '2026-02-23', '11:53:00', '17:53:00', 'testing eng1', 'final_approved', NULL, NULL, NULL, '2026-02-22 00:55:20', '2026-02-22 00:57:24', '2026-02-22 01:13:26', NULL, NULL, NULL, '2026-02-22 01:13:26', 86, NULL, 503, NULL, NULL, NULL, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsAQMAAABDsxw2AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAACH0lEQVRoge2asXXDMAxE6ZdCpUbQKBxNHk2jaASXLvyMEDiAlF9SJJDKQ2Ez4mcKgjkeoJRyaVRBlHVbHvFwfn69i9zL4pMbsR/Yps9vDZN9llcbryKPSYBh4Uosj7WtfhnWomFyr4q1UGxCgoidxUrd29nGobYstCB2HeaKoWLSvohdhB005AnFWORZsPB3qSH2dwzHGjfgZGJyGPgksSzWY23SgVHdS1GDcZwllsVcQ9pJnv1sF9NquxP1CXhiGazakY4s2OaLZqF9qdMovpBYDgtfMTYfV+Hbp+z8b8SyWFxzsBNvs8eGofqwdBRiSayGnVANQXG3oXa2mF79b4FYAmsxo6bzPdd0SLQmuj0mlsSanbBKWXo6zCffVKL3+A3Eklg1X2HHXUaV51gzGK7exHJY8YvPsuAl84d0eLKI5bBRa/gNqAF7bMee2BlM7XHptUbMmsHQ2sSLaGJJDPb4YIZ7OrweEWJnMHcRNutmGAbDZv3tBrEkVnu7UvZDRyJUpUC9iWUxb052QXbPHDegp4NYFsOPutWjpovNd2tXiKUx9Ni11oBiiC/EO1B3dMRyWA/zFeDFOpnDYBBLY1UQOu4GA7zEyyNieWzTz8P7TVvkPAzGkGhi/8eW8d8m6EhENzgCWSB2EtM22tFXaEzELsK20R+OJ8sjeGJZTD9dQ+LVp4jXzvJp84j9G+tCYR02G+9otXUxuRPLYpfGN7rCfEyEUDz+AAAAAElFTkSuQmCC', 1, '2026-02-22 00:53:47', '2026-02-23 04:34:42'),
(226, 1, 23, '2026-03-04', '10:26:00', '12:26:00', 'testing mail', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-25 10:27:08', '2026-02-25 10:27:08'),
(227, 1, 21, '2026-03-11', '09:46:00', '16:46:00', 'testing mail', 'hod_approved', NULL, NULL, NULL, '2026-02-25 10:51:57', '2026-02-25 10:52:27', NULL, NULL, NULL, NULL, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-02-25 10:46:38', '2026-02-25 10:52:27'),
(228, 2, 48, '2026-03-19', '10:15:00', '22:16:00', 'testing 11 diva arts physics', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-01 11:16:30', '2026-03-01 11:16:30'),
(229, 2, 48, '2026-03-21', '00:05:00', '12:05:00', 'testing 2', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-03-01 13:05:16', '2026-03-01 13:05:16'),
(230, 1, 504, '2026-04-16', '10:43:00', '14:43:00', 'first test for mail', 'final_approved', NULL, NULL, NULL, '2026-04-15 21:44:18', '2026-04-15 21:46:35', NULL, NULL, NULL, NULL, '2026-04-15 21:46:35', 522, 525, NULL, NULL, NULL, NULL, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAEsAQMAAABDsxw2AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAACIElEQVRoge2ZMW7DMAxFWXTwmCP4KDqaczQfJUfImCEoK/KTsoMARUN7/BoCRXrOYDJfn5TIqaMphizrfM/Fy+P7R/Qqc2yuxN6w1da/Oqa3iz77fFG9TwoMDy7E6lh/1U/H+uiYXpthfRg2IUDEjmLSbj23kdQeBU97YmdhqRgmHaYhxE7B3jRk9+BfUkPsPxhePU7AycVkN4lNYlVsjMW+m0Sr3kTMYOx3iVWxOU5AX/TcFtdqf/DRV8ATq2DNUxpRcMXAs3YUmtPIB4nVsPQVHg4/+GxFNSYPQyxAxGpYHnM2mWCPgaH68HAIsSJm/u0hWX2EK45w9DE9x3+BWAHrI22buHRIZvtLcUesiHlK5276ZD/4PNs97YVYEevVh+uwp/io8gLrBgNxIVbEJNxa9xUzNMTGTjoiWMRKWNtqjRntShuwx67exA5hK1wEao3cdYNhPjmKaGJlDBoyzPAIB+qRbyV2AJOGue+GGd77N/hkYkWsaVZwGl13XGqEqsQvEKti0ZyMdiVaE+7fEAa034mVMXz13SjuRPLlh7wIsTKGHrvVGhI3cZJpr5qOjlgNG2NcYVxly/ZXn0zsY6xhT322lSFPb7bH5RGxOrba576UUx1GTkbaE6ti87gzioZPdoN1BEiIHcb8vh6dn7ts9pjYOdgq2aUcKxtPrIoNDdmuPlWjdtZXm0fsY2wIRfdvIR03tNperuSIlbBTxy9NqOO63+bqOgAAAABJRU5ErkJggg==', 1, '2026-04-15 21:43:50', '2026-04-15 21:47:02'),
(231, 1, 504, '2026-04-17', '08:57:00', '20:57:00', 'testing 2', 'final_approved', NULL, NULL, 'approved', '2026-04-15 21:58:14', '2026-04-15 21:58:34', '2026-04-15 22:31:27', NULL, NULL, NULL, '2026-04-15 22:31:27', 522, 525, 518, NULL, NULL, NULL, 'GP-69E05F174829D', 1, '2026-04-15 21:57:55', '2026-04-15 22:31:27'),
(232, 1, 504, '2026-04-24', '10:34:00', '22:29:00', 'mail test', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-15 23:29:53', '2026-04-15 23:29:53'),
(233, 1, 504, '2026-04-30', '00:35:00', '10:37:00', 'mail testing', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-15 23:34:41', '2026-04-15 23:34:41'),
(234, 1, 21, '2026-04-17', '10:00:00', '12:00:00', 'Test email notification system', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-15 23:42:40', '2026-04-15 23:42:40'),
(235, 1, 504, '2026-05-01', '01:48:00', '22:48:00', '12345', 'staff_approved', NULL, NULL, NULL, '2026-04-16 11:27:58', NULL, NULL, NULL, NULL, NULL, NULL, 522, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-04-15 23:48:42', '2026-04-16 11:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `gatepass_scans`
--

CREATE TABLE `gatepass_scans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gatepass_id` bigint(20) UNSIGNED NOT NULL,
  `college_id` bigint(20) UNSIGNED NOT NULL,
  `scanned_by` varchar(100) DEFAULT NULL,
  `scan_type` varchar(20) NOT NULL,
  `scan_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `location` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `device_info` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(17, 3, 107, 114, 'HOD_ME_001', 'PhD in Mechanical Engineering', '2025-01-01', '2026-02-14 13:03:09', '2026-02-14 13:03:09'),
(101, 1, 108, 202, 'HOD_EE_108', 'PhD in Electronics Engineering', '2025-01-01', '2026-02-22 01:20:50', '2026-02-22 01:20:50'),
(102, 1, 109, 202, 'HOD_EE_109', 'PhD in Electronics Engineering', '2025-01-01', '2026-02-22 01:20:50', '2026-02-22 01:20:50'),
(103, 1, 525, 1, '', NULL, '0000-00-00', '2026-04-16 03:16:20', '2026-04-16 03:16:20');

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
(13, '2024_02_09_000001_create_colleges_table_and_add_college_id', 3),
(14, '2024_02_14_000005_fix_college_columns', 4),
(15, '2024_02_20_000001_create_attendance_records_table', 5),
(16, '2024_02_22_000001_create_gatepass_scans_table', 6),
(17, '2024_02_23_000001_add_theme_color_to_colleges_table', 7),
(18, '2026_03_01_000002_fix_super_admin_migration', 8),
(19, '2026_03_01_000003_create_audit_logs_table', 9),
(20, '2026_03_02_000001_create_activity_logs_table', 10),
(21, '2026_04_15_164748_add_rejection_tracking_to_gatepasses_table', 11),
(22, '2026_04_15_165804_add_department_id_to_users_table', 12);

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
('arun.kumar@engcollege.edu', '$2y$12$p5nO58c30dOhyKx1fch5C.k7noohhEDEiXXRI3ueZSfmtPGdVoXba', '2026-02-23 10:46:48'),
('ldharmaprakash2002@gmail.com', '$2y$12$/OsLgIwrXxaumWl9yA74FOvotpeMHiAFW5In.hfgO0iK.Vtrc2apW', '2026-04-15 11:05:40'),
('ldpdharma@gmail.com', '$2y$12$//HajS.tWpSnJ1VJsDBFsOLmqaz52nvwu9mrGxjtGdUqs4Kks/Qou', '2026-04-15 23:51:49'),
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
(16, 3, 115, 114, 'STAFF_ME_002', 'Instructor', 'teaching', 'B.E Mechanical Engineering', '2025-01-01', '2026-02-14 13:03:10', '2026-02-14 13:03:10'),
(101, 1, 522, 1, '', '', 'teaching', NULL, '0000-00-00', '2026-04-16 03:02:54', '2026-04-16 03:02:54');

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
(80, 3, 80, 113, 'POLY2024020', '1', 'B', 'no', 'Anjali Father', '9876543280', '861 Port St, Chennai', '2026-02-14 13:00:56', '2026-02-14 13:00:56'),
(500, 1, 500, 1, 'REG000500', '1', 'A', 'no', 'Parent Name', '9876543210', 'Test Address', '2026-02-22 01:20:18', '2026-02-22 01:20:18'),
(501, 1, 501, 15, 'REG000501', '1', 'A', 'no', 'Parent Name', '9876543210', 'Test Address', '2026-02-22 01:20:18', '2026-02-22 01:20:18'),
(502, 1, 502, 202, 'REG000502', '1', 'A', 'no', 'Parent Name', '9876543210', 'Test Address', '2026-02-22 01:20:18', '2026-02-22 01:20:18'),
(503, 1, 503, 1, 'TEMP503', '1', 'A', 'no', 'Pending', '0000000000', 'Pending', '2026-04-15 06:24:11', '2026-04-15 06:24:11'),
(504, 1, 524, 1, 'TEMP524', '1', 'A', 'yes', 'Pending', '0000000000', 'Pending', '2026-04-15 21:25:00', '2026-04-15 21:25:00');

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
,`role` varchar(11)
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
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','staff','hod','warden','admin','super_admin','security') DEFAULT NULL,
  `institute_id` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `phone` varchar(255) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `qr_token` char(36) DEFAULT NULL,
  `qr_token_generated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `college_id`, `department_id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `institute_id`, `phone`, `gender`, `is_active`, `remember_token`, `qr_token`, `qr_token_generated_at`, `created_at`, `updated_at`) VALUES
(21, 1, NULL, 'Arun Kumar', 'arunkumar', 'ldharmaprakash2003@gmail.com', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543221', 'male', 1, NULL, 'ca3048d1-d99c-4054-825a-1fc41fcfa992', '2026-02-23 10:43:45', '2026-02-14 12:53:29', '2026-02-23 10:43:45'),
(22, 1, NULL, 'Priya Sharma', 'priyasharma', 'priya.sharma@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543222', 'female', 1, NULL, 'f1184290-73c0-48aa-86a1-01b319152447', '2026-04-15 10:08:55', '2026-02-14 12:53:29', '2026-04-15 10:08:55'),
(23, 1, NULL, 'Ramesh Babu', 'rameshbabu', 'rameshbabu@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543223', 'male', 1, 'k6zr4TeYWFXPCjkEbndUB2N1u33A4VP2pF4bNDFvJiQTB0Q2dmH2C0ZtdYsl', 'dcff0e32-5c6c-4759-837e-c1ff7dfb8546', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-25 07:34:58'),
(24, 1, NULL, 'Kavitha R', 'kavithar', 'kavitha.r@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543224', 'female', 1, NULL, 'd2c43628-0d28-4915-bd1b-af592a582fe1', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(25, 1, NULL, 'Mohan Reddy', 'mohanreddy', 'mohan.reddy@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543225', 'male', 1, NULL, '6e494487-e672-4dd3-a78e-fb2c78afdc30', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(26, 1, NULL, 'Divya S', 'divyas', 'divya.s@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543226', 'female', 1, NULL, '3b0c7cdd-6c4b-4cda-99a0-46a2d051bf3e', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(27, 1, NULL, 'Suresh Kumar', 'sureshkumar', 'suresh.kumar@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543227', 'male', 1, NULL, '03ffeb05-9d59-494e-af2d-001688fd5be1', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(28, 1, NULL, 'Anjali Devi', 'anjalidevi', 'anjali.devi@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543228', 'female', 1, NULL, '411fc995-47d8-470b-8427-0858fa3ea497', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(29, 1, NULL, 'Vijay Kumar', 'vijaykumar', 'vijay.kumar@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543229', 'male', 1, NULL, '300c80f6-8c39-4b55-86c3-e68b02f32b45', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(30, 1, NULL, 'Meena Lakshmi', 'meenalakshmi', 'meena.lakshmi@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543230', 'female', 1, NULL, 'e7e13143-2507-43f4-807c-744c556a2b9b', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(31, 1, NULL, 'Rajesh M', 'rajeshm', 'rajesh.m@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543231', 'male', 1, NULL, '0c756ba9-0d05-429a-9dd3-87b15378bd82', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(32, 1, NULL, 'Sangeetha R', 'sangeethar', 'sangeetha.r@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543232', 'female', 1, NULL, 'ad0e10c0-dedd-4142-af39-dacaaef4d655', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(33, 1, NULL, 'Karthik S', 'karthiks', 'karthik.s@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543233', 'male', 1, NULL, '4d81e624-7333-4642-b066-457f190d2b58', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(34, 1, NULL, 'Nandhini K', 'nandhinik', 'nandhini.k@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543234', 'female', 1, NULL, '59538bba-6b41-4074-a54f-17ec7a3abab4', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(35, 1, NULL, 'Anand Babu', 'anandbabu', 'anand.babu@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543235', 'male', 1, NULL, '1d57d4c6-17c2-4613-a9b6-73844fe3a780', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(36, 1, NULL, 'Revathi S', 'revathis', 'revathi.s@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543236', 'female', 1, NULL, 'dd4b0262-1034-4762-b337-cc33dfd0ec64', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(37, 1, NULL, 'Murali Krishna', 'muralikrishna', 'murali.krishna@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543237', 'male', 1, NULL, '79c59168-8f9f-4785-815e-ddca0162385e', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(38, 1, NULL, 'Gayathri Devi', 'gayathridevi', 'gayathri.devi@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543238', 'female', 1, NULL, '254ebd5d-5f15-4d0a-b839-efa6e7358769', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(39, 1, NULL, 'Sathish Kumar', 'sathishkumar', 'sathish.kumar@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543239', 'male', 1, NULL, 'd2121877-6d23-4b16-a64d-573033382c2d', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(40, 1, NULL, 'Bhavani R', 'bhavanir', 'bhavani.r@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543240', 'female', 1, NULL, '15ddd3cf-1436-4232-bfcf-9d61a91ff718', '2026-02-23 07:51:21', '2026-02-14 12:53:29', '2026-02-23 07:51:21'),
(41, 2, NULL, 'Saraswathi R', 'saraswathir', 'saraswathi.r@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543241', 'female', 1, NULL, '9f6be3ad-3fe6-407c-af1d-480e64150ada', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(42, 2, NULL, 'Lakshmi S', 'lakshmis', 'lakshmi.s@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543242', 'female', 1, NULL, 'e9bdd248-4af4-46d5-98b6-2110fe8f2208', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(43, 2, NULL, 'Meena K', 'meenak', 'meena.k@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543243', 'female', 1, NULL, '60609069-46b5-43b3-8124-16a760fc09ea', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(44, 2, NULL, 'Kavitha R', 'kavithar2', 'kavitha.r2@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543244', 'female', 1, NULL, 'd49e5b85-1ace-45b6-ac72-cfb8c462b83e', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(45, 2, NULL, 'Priya M', 'priyam', 'priya.m@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543245', 'female', 1, NULL, '05284656-9c31-477a-a250-385cc0a79ff3', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(46, 2, NULL, 'Revathi S', 'revathis2', 'revathi.s2@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543246', 'female', 1, NULL, '66022356-7483-4a59-947a-59c75539ed0e', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(47, 2, NULL, 'Anjali K', 'anjalik', 'anjali.k@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543247', 'female', 1, NULL, '8a16b1db-6a4f-46bd-a7f6-f8847e05fbb1', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(48, 2, NULL, 'Divya R', 'divyar2', 'divya.r2@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543248', 'female', 1, NULL, 'bf6333cc-827f-4377-b082-269a82bbe520', '2026-04-15 09:58:36', '2026-02-14 12:55:54', '2026-04-15 09:58:36'),
(49, 2, NULL, 'Sangeetha M', 'sangeetham', 'sangeetha.m@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543249', 'female', 1, NULL, '5b3e0c5a-63ea-4a34-8d4c-1ee5c2ed98f8', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(50, 2, NULL, 'Nandhini S', 'nandhinis2', 'nandhini.s2@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543250', 'female', 1, NULL, '9bb9f121-eac3-43ae-a307-735009f2b5bf', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(51, 2, NULL, 'Malathi R', 'malathir', 'malathi.r@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543251', 'female', 1, NULL, '98ace68b-8c8a-4c3d-9a0f-b16a6daadc1b', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(52, 2, NULL, 'Vijayalakshmi K', 'vijayalakshmik', 'vijayalakshmi.k@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543252', 'female', 1, NULL, '2f1cf8f5-a1d0-4971-a267-dad6bc063798', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(53, 2, NULL, 'Sowmiya R', 'sowmiyar', 'sowmiya.r@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543253', 'female', 1, NULL, '41b3b46e-1131-44ea-b1d8-1039aa50bd23', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(54, 2, NULL, 'Gayathri S', 'gayathris2', 'gayathri.s2@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543254', 'female', 1, NULL, 'be1f2bc6-3bbf-4126-b8e6-6626c1320d86', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(55, 2, NULL, 'Bhavani M', 'bhavanim', 'bhavani.m@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543255', 'female', 1, NULL, '0f869203-1572-475c-90f4-78dc02547f5e', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(56, 2, NULL, 'Anuradha R', 'anuradhar', 'anuradha.r@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543256', 'female', 1, NULL, 'c5e85328-a3b0-49c8-a652-9ae11b211044', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(57, 2, NULL, 'Chitra S', 'chitras', 'chitra.s@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543257', 'female', 1, NULL, 'edfd00ce-07ff-48d7-a277-666e27f047f3', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(58, 2, NULL, 'Sujatha K', 'sujathak', 'sujatha.k@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543258', 'female', 1, NULL, 'c7bd38b2-95c5-429c-bf51-ab31af918a65', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(59, 2, NULL, 'Radhika S', 'radhikas', 'radhika.s@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543259', 'female', 1, NULL, 'c239dd06-28bd-4561-998a-cbdff83d943f', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(60, 2, NULL, 'Meenakshi R', 'meenakshir', 'meenakshi.r@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543260', 'female', 1, NULL, 'ae161787-1083-4106-a34a-c5324f796500', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(61, 3, NULL, 'Rajesh K', 'rajeshk', 'rajesh.k@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543261', 'male', 1, NULL, '138fb8c5-e148-4e55-83a0-c6ded22432a7', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(62, 3, NULL, 'Kumar S', 'kumars', 'kumar.s@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543262', 'male', 1, NULL, '17a0ccac-ff72-43ef-b4c4-c6b9c9231550', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(63, 3, NULL, 'Mohan R', 'mohanr', 'mohan.r@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543263', 'male', 1, NULL, 'f321d91c-a421-438c-b732-5d8165c6ac99', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(64, 3, NULL, 'Vijay K', 'vijayk', 'vijay.k@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543264', 'male', 1, NULL, '78becaa1-00ef-409f-bc28-7e5c2464014d', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(65, 3, NULL, 'Arun S', 'aruns', 'arun.s@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543265', 'male', 1, NULL, 'd8d2d1ca-6e53-4fef-9585-08283e6faea6', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(66, 3, NULL, 'Priya R', 'priyar', 'priya.r@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543266', 'female', 1, NULL, 'a9c03238-6b9f-4ad4-ac60-dc7f101aab32', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(67, 3, NULL, 'Divya S', 'divyas2', 'divya.s2@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543267', 'female', 1, NULL, 'f000581c-2a62-446b-bbea-bf88e49b0875', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(68, 3, NULL, 'Meena K', 'meenak2', 'meena.k2@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543268', 'female', 1, NULL, 'b59e829a-6d92-4fae-8ac0-f11c21b6ca65', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(69, 3, NULL, 'Kavitha R', 'kavithar3', 'kavitha.r3@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543269', 'female', 1, NULL, '0c713d32-6924-4626-b39a-7211a4341fc2', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(70, 3, NULL, 'Anjali M', 'anjalim', 'anjali.m@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543270', 'female', 1, NULL, '6ef89410-c486-4d61-93c1-86c2f42c67f1', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(71, 3, NULL, 'Suresh K', 'sureshk', 'suresh.k@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543271', 'male', 1, NULL, '4037cb47-3d4d-49ec-9668-02b11ff86438', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(72, 3, NULL, 'Ramesh S', 'rameshs', 'ramesh.s@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543272', 'male', 1, NULL, '9cc44832-be05-432e-bd56-279f6599a36b', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(73, 3, NULL, 'Mohan M', 'mohanm', 'mohan.m@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543273', 'male', 1, NULL, '0bdfcf8d-74da-4058-a078-417d9c5e4e18', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(74, 3, NULL, 'Vijay R', 'vijayr', 'vijay.r@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543274', 'male', 1, NULL, '3cbeae2a-c8f3-4375-8c03-c5de77fba639', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(75, 3, NULL, 'Arun M', 'arunm', 'arun.m@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543275', 'male', 1, NULL, '52b9a282-bcb0-4b16-9536-f1f41d80290d', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(76, 3, NULL, 'Priya S', 'priyas', 'priya.s@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543276', 'female', 1, NULL, '0b77257b-86e4-4412-bf28-8dd222ea4015', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(77, 3, NULL, 'Divya M', 'divyam', 'divya.m@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543277', 'female', 1, NULL, '1ad9296d-e243-4869-9c85-7c82f9e230a3', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(78, 3, NULL, 'Meena S', 'meenas', 'meena.s@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543278', 'female', 1, NULL, '47b404dc-42e6-4d23-ba9a-a3b1421ee238', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(79, 3, NULL, 'Kavitha K', 'kavithak', 'kavitha.k@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543279', 'female', 1, NULL, '8fe819b8-de7c-443a-8e3b-6662772fd3e4', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(80, 3, NULL, 'Anjali R', 'anjalir', 'anjali.r@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543280', 'female', 1, NULL, 'e967feb6-24aa-4700-bf8d-a532eaf69698', '2026-02-23 07:51:21', '2026-02-14 12:55:54', '2026-02-23 07:51:21'),
(82, 1, NULL, 'Dr. Priya Sharma', 'hod_ece_eng', 'hod.ece@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543282', 'female', 1, NULL, 'b6657981-675e-4cc9-afa4-80bbfd1ae968', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(83, 1, NULL, 'Dr. Anand Patel', 'hod_mech_eng', 'hod.mech@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543283', 'male', 1, NULL, 'c7ac5fea-6cfb-4106-91ae-a16b6b72aed4', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(84, 1, NULL, 'Dr. Sunita Reddy', 'hod_civil_eng', 'hod.civil@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543284', 'female', 1, NULL, 'b6307ad2-2f7f-451b-8043-105704b3348d', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(85, 1, NULL, 'Dr. Vijay Kumar', 'hod_eee_eng', 'hod.eee@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543285', 'male', 1, NULL, '358c911c-b85e-412b-a463-ae9ef22bce07', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(86, 1, NULL, 'Rajesh M', 'staff_cse1', 'ldpdharma1@gmail.com', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543286', 'male', 1, NULL, 'bf859a3b-dc26-4182-9c06-b8cfb63da8dc', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(87, 1, NULL, 'Kavitha R', 'staff_ece1', 'kavitha.ece@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543287', 'female', 1, NULL, 'fed53271-c397-4f74-9104-87cbe8991676', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(88, 1, NULL, 'Mohan S', 'staff_mech1', 'mohan.mech@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543288', 'male', 1, NULL, '9b0a20cd-b61e-4292-b994-51e3760afdff', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(89, 1, NULL, 'Divya S', 'staff_civil1', 'divya.civil@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543289', 'female', 1, NULL, '1bf371e0-ae6b-47f2-be86-e778267e5bbe', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(90, 1, NULL, 'Arun K', 'staff_eee1', 'arun.eee@engcollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543290', 'male', 1, NULL, '5b2f5b9a-ee48-4d7e-974b-c7c6a9cfa454', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(91, 2, NULL, 'Dr. R. Lakshmi', 'hod_tamil_women', 'hod.tamil@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543291', 'female', 1, NULL, '8833c445-11a8-41b4-8c6c-662b53ceec6e', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(92, 2, NULL, 'Dr. S. Kavitha', 'hod_english_women', 'hod.english@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543292', 'female', 1, NULL, '19a52658-64ec-404f-ba7b-d9a0c0b296d3', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(93, 2, NULL, 'Dr. P. Murugan', 'hod_math_women', 'hod.math@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543293', 'female', 1, NULL, '1b347692-24f4-4e88-b3b9-a81ecffcc1cf', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(94, 2, NULL, 'Dr. V. Arunkumar', 'hod_physics_women', 'hod.physics@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543294', 'female', 1, NULL, 'd8a22716-5a4f-4b8a-a6a7-7a055082d71b', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(95, 2, NULL, 'Dr. K. Nirmala', 'hod_chem_women', 'hod.chem@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543295', 'female', 1, NULL, '590a151c-ce99-478e-9cc6-b91d7036bc55', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(96, 2, NULL, 'Dr. J. Meenakshi', 'hod_cs_women', 'hod.cs@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543296', 'female', 1, NULL, 'd35cd093-e817-46ea-833f-044401dd8811', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(97, 2, NULL, 'Dr. A. Prakash', 'hod_com_women', 'hod.com@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543297', 'female', 1, NULL, '0dbbed14-5697-40e1-96bd-29bf126de49a', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(98, 2, NULL, 'N. Sudha', 'hod_bca_women', 'hod.bca@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543298', 'female', 1, NULL, '11561215-f4bf-404f-b5d9-ea2b5da61c4e', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(99, 2, NULL, 'Dr. M. Ramesh', 'hod_bba_women', 'hod.bba@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543299', 'female', 1, NULL, '6f855305-e1d7-4e7c-a68b-93baa0b1368e', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(100, 2, NULL, 'Priya Rani', 'staff_tamil1', 'priya.tamil@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543300', 'female', 1, NULL, '2d22659d-1187-4876-a8a9-d014e3372128', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(101, 2, NULL, 'Kavitha S', 'staff_english1', 'kavitha.english@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543301', 'female', 1, NULL, '9ef0dc21-b9f6-4dcc-ae32-bda936a39f74', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(102, 2, NULL, 'Meena K', 'staff_math1', 'meena.math@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543302', 'female', 1, NULL, 'f1d6f5ae-d8ea-4526-adc6-1176f2ffb7c3', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(103, 2, NULL, 'Revathi S', 'staff_physics1', 'revathi.physics@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543303', 'female', 1, NULL, '8a45703a-8b4a-4ad8-9755-9cb40a7dabae', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(104, 2, NULL, 'Anjali M', 'staff_chem1', 'anjali.chem@womenscollege.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543304', 'female', 1, NULL, '6a603681-2361-4e3f-b2d5-82c65585d886', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(105, 3, NULL, 'Dr. Anand Sharma', 'hod_ce_poly', 'hod.ce@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543305', 'male', 1, NULL, '535b9e26-54be-4687-b642-4360dcf7bf6e', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(106, 3, NULL, 'Dr. Ramesh Babu', 'hod_ee_poly', 'hod.ee@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543306', 'male', 1, NULL, '932b5989-e018-4895-ae13-9610520f0be2', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(107, 3, NULL, 'Dr. Ramesh Babu', 'hod_me_poly', 'hod.me@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543307', 'male', 1, NULL, '9c69ec74-dbc4-4611-9d38-463b7bbab7b9', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(108, 3, NULL, 'Dr. Ramesh Babu', 'hod_civil_poly', 'hod.civil@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543308', 'male', 1, NULL, '79447f81-d5d2-4d74-accc-6e2709a923fd', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(109, 3, NULL, 'Dr. Ramesh Babu', 'hod_eee_poly', 'hod.eee@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543309', 'male', 1, NULL, 'dcd3c4d7-7164-42cd-8b39-0b9cf531767e', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(110, 3, NULL, 'R. Kumar', 'staff_ce1', 'kumar.ce@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543310', 'male', 1, NULL, 'd388f280-1802-4a64-aa18-32593cc58c11', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(111, 3, NULL, 'S. Rani', 'staff_ce2', 'rani.ce@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543311', 'female', 1, NULL, '4502be1e-af26-4a41-bad4-2e1119941bbb', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(112, 3, NULL, 'P. Kumar', 'staff_ee1', 'kumar.ee@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543312', 'male', 1, NULL, 'cd265181-71dd-41aa-be79-7a39b9556abd', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(113, 3, NULL, 'M. Devi', 'staff_ee2', 'devi.ee@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543313', 'female', 1, NULL, 'a2fd8548-97e1-416c-acff-918c107136ff', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(114, 3, NULL, 'K. Babu', 'staff_me1', 'babu.me@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543314', 'male', 1, NULL, '3e6cea52-09bb-4a11-9a8c-06a472d00f95', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(115, 3, NULL, 'L. Rani', 'staff_me2', 'rani.me@polytechnic.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9876543315', 'female', 1, NULL, 'c4f44cf9-4961-4a67-8de9-61dd7ae5f272', '2026-02-23 07:51:21', '2026-02-14 13:02:51', '2026-02-23 07:51:21'),
(500, 1, NULL, 'Engineering Student', 'engstudent', 'eng.student@test.com', NULL, '$2y$12$eMrhDLK5iXzCkMp0Z.IEO.moWHf27c6Pb4yXYZNxSYqYrnOZ3.k6e', 'student', 1, '9876543210', 'male', 1, NULL, 'df5fb8e5-a5c0-4724-806f-e13d029f20c1', '2026-02-23 07:51:21', '2026-02-14 12:27:07', '2026-02-23 07:51:21'),
(501, 2, NULL, 'Arts Student', 'artsstudent', 'arts.student@test.com', NULL, '$2y$12$7iEjiDZJQTMk1jZYXcFudOlxxn26up37uaAM3edoahUA0C101UR7u', 'student', 1, '9876543211', 'female', 1, NULL, '97d865a0-4876-4c77-a5ed-dd16930c576d', '2026-02-23 07:51:21', '2026-02-14 12:27:07', '2026-02-23 07:51:21'),
(502, 3, NULL, 'Polytechnic Student', 'polystudent', 'poly.student@test.com', NULL, '$2y$12$x8rRLN4kIsDs5SOfB9RpUe8soym6VnPGuKlzgnchSZMndRNl5WYyu', 'student', 1, '9876543212', 'male', 1, NULL, 'b1fdf797-a89c-45ad-9646-fe8066fa612b', '2026-02-23 07:51:21', '2026-02-14 12:27:07', '2026-02-23 07:51:21'),
(503, 1, NULL, 'Security Warden', 'security', 'security@college.edu', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'warden', 1, '9876543213', 'male', 1, NULL, '3a90f717-4fed-4ee7-bbb3-0b2b73d5cadb', '2026-02-23 07:51:21', '2026-02-14 12:27:07', '2026-04-16 12:29:08'),
(504, 1, NULL, 'Super Administrator', 'super_admin', 'superadmin@college.edu', NULL, '$2y$12$MYnyUFUDiHv1UCgQtLwu5.cnrSlHn2NjL7DIBvG5l8DS81OsHQFzG', '', 1, '9876543210', 'other', 1, NULL, '9def6cda-e77f-4f31-8d17-04b837636140', '2026-03-01 17:51:17', '2026-03-01 17:51:17', '2026-03-01 17:51:17'),
(505, 1, NULL, 'Super Administrator', 'superadmin', 'superadmin@system.com', '2026-03-02 07:28:06', '$2y$12$OoS72RAST/6EkO33yv5TUO9K5m3wCxXex0ODUGT/CuzaVUhztrZra', 'super_admin', 1, '1234567890', 'other', 1, NULL, '74ea7eb1-1637-11f1-aa93-cc28aa1741a9', '2026-03-02 07:28:06', '2026-03-02 07:28:06', '2026-03-02 07:28:06'),
(506, 1, NULL, 'System Administrator', 'admin', 'admin@college.edu', NULL, '$2y$12$OWHt5dGvawN96XGhy0xG/.0Mv3uB7GhLJ.1wwdhvC09LhkFkqePXC', 'admin', 1, '9876543210', NULL, 1, NULL, '18be01aa-839b-4260-bd4d-3dcc7d561f3f', '2026-03-02 10:46:45', '2026-03-02 10:46:45', '2026-03-02 10:46:45'),
(507, 1, NULL, 'Test Staff', 'teststaff', 'test.staff@example.com', NULL, '$2y$12$ISDrDNeHAFr6bGsKK0bmLOIzP.obvmcwofDbaHeXPdl6MV8WnOnE.', 'staff', 1, NULL, NULL, 1, NULL, '6911cbff-77df-4e8e-a66f-c2b209016478', '2026-04-15 11:15:52', '2026-04-15 11:15:52', '2026-04-15 11:15:52'),
(508, 1, 7, 'Dr. Ramesh Kumar', 'hod.cs', 'hod.cs@college.edu', NULL, '$2y$12$Q6L2YBvakyeW43mngRcy7.zyug2hqouT.ePoUBv..O0Gj44bjEZua', 'hod', 1, '9876543210', 'male', 1, NULL, 'a2ba3c8a-af6d-4371-9309-9dccdc7c0e79', '2026-04-15 11:30:13', '2026-04-15 11:30:13', '2026-04-15 11:30:13'),
(509, 1, 8, 'Dr. Priya Sharma', 'hod.ec', 'hod.ec@college.edu', NULL, '$2y$12$mwXLuoZ.xMX.Yn/3kZzzTeK0Eebu4w/mMa1vGvcaWp3oB/kVw.VQu', 'hod', 1, '9876543210', 'male', 1, NULL, '68b7c919-46a2-4b60-8dab-5a39ffe1a7bf', '2026-04-15 11:30:14', '2026-04-15 11:30:14', '2026-04-15 11:30:14'),
(510, 1, 119, 'Dr. Mahesh Patel', 'hod.me', 'hod.me@college.edu', NULL, '$2y$12$k2qiSarqZXWu/qk1XlURnu741b.WF1IfZm8bO4gm7EmtAiVA97hu.', 'hod', 1, '9876543210', 'male', 1, NULL, '9393c32c-5f78-4b8a-9dea-5e69c9a4e40f', '2026-04-15 11:30:14', '2026-04-15 11:30:14', '2026-04-15 11:30:14'),
(511, 1, 120, 'Dr. Sunita Rao', 'hod.ce', 'hod.ce@college.edu', NULL, '$2y$12$R70Ao/cn.0xgfiVpO65c..gBhChgJ4ukcdz.WI/BJrLD6M8m5NPTK', 'hod', 1, '9876543210', 'male', 1, NULL, '81477f87-bafa-4ba7-99a8-a08ac8c2c7da', '2026-04-15 11:30:14', '2026-04-15 11:30:14', '2026-04-15 11:30:14'),
(512, 1, NULL, 'Security Officer 1', 'security1', 'security1@college.edu', NULL, '$2y$12$H70XimUPjjRKkXPvPQqKeuXYD5RHEtKkL5Etc2k4qYii1NvRBnV8a', 'warden', 1, '9876543210', 'male', 1, NULL, 'e686717d-ba38-4c27-9df4-94b6195a8219', '2026-04-15 11:33:11', '2026-04-15 11:33:11', '2026-04-15 11:33:11'),
(513, 1, NULL, 'Security Officer 2', 'security2', 'security2@college.edu', NULL, '$2y$12$/GhZwgHrJaZ6VrhaipgPvuwF3EIt3IEKoQ.AM9eBiqEgulv.G9xC2', 'warden', 1, '9876543210', 'male', 1, NULL, 'ca70e103-cbac-464c-a9c3-aaf35a24b76c', '2026-04-15 11:33:11', '2026-04-15 11:33:11', '2026-04-15 11:33:11'),
(514, 1, NULL, 'Assistant Professor 1', 'staff1', 'staff1@college.edu', NULL, '$2y$12$V52u8Ux6fyv92dK.i/tsJ..V5QakKO63/RoUJUYkxy9ykP54VoDfm', 'staff', 1, '9876543210', 'male', 1, NULL, '8d25f9ce-c51e-427f-a250-cc166aae0fa3', '2026-04-15 11:33:12', '2026-04-15 11:33:12', '2026-04-15 11:33:12'),
(515, 1, NULL, 'Assistant Professor 2', 'staff2', 'staff2@college.edu', NULL, '$2y$12$kZC5fHq1i3LSWs8FNwhwWOyiAaVEqlGstgeP8MO79YSUiS9NlzMZi', 'staff', 1, '9876543210', 'male', 1, NULL, '82d45e4f-3b12-43b4-a78d-89b41a6a97d5', '2026-04-15 11:33:12', '2026-04-15 11:33:12', '2026-04-15 11:33:12'),
(518, 1, NULL, 'DHARMAPRAKASH WARDEN', 'warden_dharma', 'dharma.prakash@faceperp.in', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'warden', 1, '9999999993', 'male', 1, NULL, 'b69ca0bc-393c-11f1-8a35-cc28aa1741a9', '2026-04-16 02:33:54', '2026-04-16 02:33:54', '2026-04-16 02:33:54'),
(522, 1, NULL, 'DHARMAPRAKASH L', 'staff_dharma', 'ldpdharma@gmail.com', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'staff', 1, '9999999991', 'male', 1, NULL, 'e72e1212-393d-11f1-8a35-cc28aa1741a9', '2026-04-16 02:42:25', '2026-04-16 02:42:25', '2026-04-16 02:42:25'),
(524, 1, NULL, 'DHARMAPRAKASH STUDENT', 'student_dharma', 'ldharmaprakash2002@gmail.com', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'student', 1, '9999999994', 'male', 1, NULL, '94281397-393f-11f1-8a35-cc28aa1741a9', '2026-04-16 02:54:25', '2026-04-16 02:54:25', '2026-04-16 02:54:25'),
(525, 1, NULL, 'DHARMAPRAKASH HOD', 'hod_dharma', 'dharma.prakash@faceacademy.in', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'hod', 1, '9999999992', 'male', 1, NULL, '166c031e-3942-11f1-8a35-cc28aa1741a9', '2026-04-16 03:12:23', '2026-04-16 03:12:23', '2026-04-16 03:12:23'),
(527, 1, NULL, 'SECURITY OFFICER', 'security_dharma', 'security.dharma@gmail.com', NULL, '$2y$12$tHIEnRDjwOGKN/qsweHSxuOU5/DahWibXfRJXcznSKVlqWgoViQq2', 'security', 1, '9999999995', 'male', 1, NULL, 'ba9b0363-39bb-11f1-8a35-cc28aa1741a9', '2026-04-16 17:43:05', '2026-04-16 17:43:05', '2026-04-16 12:20:06');

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

--
-- Dumping data for table `wardens`
--

INSERT INTO `wardens` (`id`, `college_id`, `user_id`, `employee_id`, `hostel_type`, `qualifications`, `appointment_date`, `created_at`, `updated_at`) VALUES
(50, 1, 503, 'WARDEN_001', 'boys', 'M.Sc Computer Science', '2025-01-01', '2026-02-22 01:12:00', '2026-02-22 01:12:00'),
(51, 1, 518, '', 'boys', NULL, '0000-00-00', '2026-04-16 02:59:59', '2026-04-16 02:59:59');

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
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `activity_logs_action_created_at_index` (`action`,`created_at`),
  ADD KEY `activity_logs_target_type_target_id_index` (`target_type`,`target_id`),
  ADD KEY `activity_logs_college_id_index` (`college_id`);

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_daily_unique` (`student_id`,`date`,`college_id`),
  ADD KEY `attendance_records_user_id_foreign` (`user_id`),
  ADD KEY `attendance_records_college_id_date_index` (`college_id`,`date`),
  ADD KEY `attendance_records_date_status_index` (`date`,`status`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_target_type_target_id_index` (`target_type`,`target_id`),
  ADD KEY `audit_logs_user_id_action_index` (`user_id`,`action`);

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
  ADD UNIQUE KEY `gatepasses_qr_code_unique` (`qr_code`) USING HASH,
  ADD KEY `gatepasses_student_id_foreign` (`student_id`),
  ADD KEY `gatepasses_staff_approved_by_foreign` (`staff_approved_by`),
  ADD KEY `gatepasses_hod_approved_by_foreign` (`hod_approved_by`),
  ADD KEY `gatepasses_warden_approved_by_foreign` (`warden_approved_by`),
  ADD KEY `gatepasses_college_id_index` (`college_id`),
  ADD KEY `gatepasses_staff_rejected_by_foreign` (`staff_rejected_by`),
  ADD KEY `gatepasses_hod_rejected_by_foreign` (`hod_rejected_by`),
  ADD KEY `gatepasses_warden_rejected_by_foreign` (`warden_rejected_by`);

--
-- Indexes for table `gatepass_scans`
--
ALTER TABLE `gatepass_scans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gatepass_scans_gatepass_id_scan_type_index` (`gatepass_id`,`scan_type`),
  ADD KEY `gatepass_scans_college_id_scan_time_index` (`college_id`,`scan_time`),
  ADD KEY `gatepass_scans_scan_time_index` (`scan_time`);

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
  ADD KEY `users_college_id_index` (`college_id`),
  ADD KEY `users_qr_token_index` (`qr_token`),
  ADD KEY `users_department_id_foreign` (`department_id`);

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
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gatepasses`
--
ALTER TABLE `gatepasses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT for table `gatepass_scans`
--
ALTER TABLE `gatepass_scans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hods`
--
ALTER TABLE `hods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=506;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=528;

--
-- AUTO_INCREMENT for table `wardens`
--
ALTER TABLE `wardens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `attendance_records_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `gatepasses_hod_rejected_by_foreign` FOREIGN KEY (`hod_rejected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gatepasses_staff_approved_by_foreign` FOREIGN KEY (`staff_approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gatepasses_staff_rejected_by_foreign` FOREIGN KEY (`staff_rejected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gatepasses_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gatepasses_warden_approved_by_foreign` FOREIGN KEY (`warden_approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gatepasses_warden_rejected_by_foreign` FOREIGN KEY (`warden_rejected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gatepass_scans`
--
ALTER TABLE `gatepass_scans`
  ADD CONSTRAINT `gatepass_scans_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gatepass_scans_gatepass_id_foreign` FOREIGN KEY (`gatepass_id`) REFERENCES `gatepasses` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `users_college_id_foreign` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

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
