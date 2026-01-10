-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2026 at 01:18 PM
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
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `departments` (`id`, `name`, `code`, `description`, `head_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Computer Science and Engineering', 'CSE', NULL, 'Dr. Ramesh Kumar', 1, '2026-01-03 04:52:05', '2026-01-03 04:52:05'),
(2, 'Electronics and Communication Engineering', 'ECE', NULL, 'Dr. Priya Sharma', 1, '2026-01-03 04:52:05', '2026-01-03 04:52:05'),
(3, 'Mechanical Engineering', 'MECH', NULL, 'Dr. Anand Patel', 1, '2026-01-03 04:52:05', '2026-01-03 04:52:05'),
(4, 'Civil Engineering', 'CIVIL', NULL, 'Dr. Sunita Reddy', 1, '2026-01-03 04:52:05', '2026-01-03 04:52:05'),
(5, 'Electrical and Electronics Engineering', 'EEE', NULL, 'Dr. Vijay Kumar', 1, '2026-01-03 04:52:05', '2026-01-03 04:52:05');

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

INSERT INTO `gatepasses` (`id`, `student_id`, `gatepass_date`, `out_time`, `in_time`, `reason`, `status`, `staff_remarks`, `hod_remarks`, `warden_remarks`, `staff_approved_at`, `hod_approved_at`, `warden_approved_at`, `final_approved_at`, `staff_approved_by`, `hod_approved_by`, `warden_approved_by`, `qr_code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-12-11', '10:39:00', '17:26:00', 'Competition participation', 'final_approved', NULL, NULL, NULL, '2025-12-11 06:52:15', '2025-12-11 09:52:15', '2025-12-11 11:52:15', '2025-12-11 11:52:15', 8, 2, 7, 'GP-6958EDD7B4785', 1, '2026-01-03 04:52:15', '2026-01-03 04:52:15'),
(2, 1, '2025-12-25', '08:58:00', '17:49:00', 'Family function', 'final_approved', NULL, NULL, NULL, '2025-12-25 05:52:15', '2026-01-03 09:57:29', '2026-01-04 03:52:36', '2026-01-04 03:52:36', 10, 2, 7, 'GP-695A315C1786E', 1, '2026-01-03 04:52:15', '2026-01-04 03:52:36'),
(3, 1, '2025-12-12', '08:10:00', '16:41:00', 'Personal work', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-12 07:52:15', NULL, NULL, NULL, 8, NULL, NULL, NULL, 1, '2026-01-03 04:52:15', '2026-01-03 04:52:15'),
(4, 1, '2025-12-05', '10:46:00', '16:58:00', 'Interview', 'final_approved', NULL, NULL, NULL, '2025-12-05 05:52:15', '2026-01-03 09:57:55', '2026-01-04 03:52:42', '2026-01-04 03:52:42', 10, 2, 7, 'GP-695A31628BA30', 1, '2026-01-03 04:52:15', '2026-01-04 03:52:42'),
(5, 2, '2025-12-14', '10:39:00', '18:36:00', 'Library research', 'final_approved', NULL, NULL, NULL, '2025-12-14 06:52:16', '2025-12-14 08:52:16', '2025-12-14 11:52:16', '2025-12-14 11:52:16', 8, 2, 7, 'GP-6958EDD81FCDF', 1, '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(6, 2, '2025-12-22', '08:25:00', '16:07:00', 'Medical appointment', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-22 07:52:16', NULL, NULL, NULL, 9, NULL, NULL, NULL, 1, '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(7, 2, '2025-12-10', '09:34:00', '19:06:00', 'Medical appointment', 'warden_rejected', NULL, NULL, NULL, '2025-12-10 05:52:16', '2026-01-03 09:57:39', '2026-01-04 03:52:28', NULL, 10, 2, 7, NULL, 1, '2026-01-03 04:52:16', '2026-01-04 03:52:28'),
(8, 3, '2025-12-07', '10:19:00', '16:46:00', 'Project work', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-07 06:52:16', '2025-12-07 07:52:16', NULL, NULL, 10, 2, NULL, NULL, 1, '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(9, 3, '2025-12-07', '08:29:00', '18:08:00', 'Document submission', 'warden_rejected', NULL, NULL, NULL, '2025-12-07 06:52:16', '2026-01-03 09:57:51', '2026-01-04 03:52:30', NULL, 8, 2, 7, NULL, 1, '2026-01-03 04:52:16', '2026-01-04 03:52:30'),
(10, 3, '2025-12-23', '08:13:00', '18:47:00', 'Library research', 'final_approved', NULL, NULL, NULL, '2025-12-23 07:52:16', '2025-12-23 09:52:16', '2025-12-23 12:52:16', '2025-12-23 12:52:16', 10, 2, 7, 'GP-6958EDD87CA55', 1, '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(11, 4, '2025-12-13', '10:05:00', '17:24:00', 'Interview', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-13 07:52:16', '2025-12-13 08:52:16', NULL, NULL, 8, 2, NULL, NULL, 1, '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(12, 4, '2025-12-10', '11:25:00', '19:04:00', 'Interview', 'final_approved', NULL, NULL, NULL, '2025-12-10 06:52:16', '2026-01-03 09:57:27', '2026-01-04 04:02:40', '2026-01-04 04:02:40', 10, 2, 7, 'GP-695A33B8683D9', 1, '2026-01-03 04:52:16', '2026-01-04 04:02:40'),
(13, 5, '2025-12-13', '10:41:00', '18:36:00', 'Library research', 'final_approved', NULL, NULL, NULL, '2025-12-13 05:52:17', '2025-12-13 07:52:17', NULL, '2025-12-13 07:52:17', 10, 2, NULL, 'GP-6958EDD93E8C4', 1, '2026-01-03 04:52:17', '2026-01-03 04:52:17'),
(14, 5, '2025-12-11', '08:11:00', '18:13:00', 'Interview', 'final_approved', NULL, NULL, NULL, '2025-12-11 06:52:17', '2026-01-03 09:57:35', NULL, '2026-01-03 09:57:35', 10, 2, NULL, NULL, 1, '2026-01-03 04:52:17', '2026-01-03 09:57:35'),
(15, 5, '2025-12-30', '10:27:00', '16:45:00', 'Competition participation', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-30 07:52:17', NULL, NULL, NULL, 10, NULL, NULL, NULL, 1, '2026-01-03 04:52:17', '2026-01-03 04:52:17'),
(16, 5, '2025-12-25', '10:49:00', '19:50:00', 'Library research', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-25 05:52:17', '2025-12-25 07:52:17', NULL, NULL, 10, 2, NULL, NULL, 1, '2026-01-03 04:52:17', '2026-01-03 04:52:17'),
(17, 5, '2025-12-11', '08:27:00', '18:07:00', 'Project work', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-11 06:52:17', '2025-12-11 07:52:17', NULL, NULL, 9, 2, NULL, NULL, 1, '2026-01-03 04:52:17', '2026-01-03 04:52:17'),
(18, 6, '2025-12-14', '11:21:00', '19:47:00', 'Interview', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-14 06:52:17', '2025-12-14 09:52:17', NULL, NULL, 9, 2, NULL, NULL, 1, '2026-01-03 04:52:17', '2026-01-03 04:52:17'),
(19, 6, '2025-12-07', '09:41:00', '18:44:00', 'Competition participation', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-07 05:52:17', '2025-12-07 08:52:17', NULL, NULL, 9, 2, NULL, NULL, 1, '2026-01-03 04:52:17', '2026-01-03 04:52:17'),
(20, 7, '2025-12-28', '10:50:00', '19:59:00', 'Medical appointment', 'final_approved', NULL, NULL, NULL, '2025-12-28 05:52:18', '2026-01-03 09:57:16', NULL, '2026-01-03 09:57:16', 9, 2, NULL, NULL, 1, '2026-01-03 04:52:18', '2026-01-03 09:57:16'),
(21, 7, '2025-12-07', '09:42:00', '16:49:00', 'Competition participation', 'final_approved', NULL, NULL, NULL, '2025-12-07 07:52:18', '2025-12-07 08:52:18', NULL, '2025-12-07 08:52:18', 10, 2, NULL, 'GP-6958EDDA24774', 1, '2026-01-03 04:52:18', '2026-01-03 04:52:18'),
(22, 7, '2025-12-15', '10:51:00', '18:20:00', 'Project work', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-15 06:52:18', '2025-12-15 08:52:18', NULL, NULL, 9, 2, NULL, NULL, 1, '2026-01-03 04:52:18', '2026-01-03 04:52:18'),
(23, 7, '2025-12-30', '11:23:00', '17:10:00', 'Project work', 'final_approved', NULL, NULL, NULL, '2025-12-30 06:52:18', '2026-01-03 09:57:23', NULL, '2026-01-03 09:57:23', 9, 2, NULL, NULL, 1, '2026-01-03 04:52:18', '2026-01-03 09:57:23'),
(24, 7, '2025-12-27', '08:05:00', '19:50:00', 'Family function', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-27 06:52:18', '2025-12-27 07:52:18', NULL, NULL, 10, 2, NULL, NULL, 1, '2026-01-03 04:52:18', '2026-01-03 04:52:18'),
(25, 8, '2025-12-26', '11:54:00', '16:41:00', 'Interview', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-26 05:52:18', '2025-12-26 06:52:18', NULL, NULL, 10, 2, NULL, NULL, 1, '2026-01-03 04:52:18', '2026-01-03 04:52:18'),
(26, 8, '2025-12-26', '10:13:00', '17:13:00', 'Document submission', 'final_approved', NULL, NULL, NULL, '2025-12-26 06:52:18', '2025-12-26 09:52:18', NULL, '2025-12-26 09:52:18', 10, 2, NULL, 'GP-6958EDDA9EAF0', 1, '2026-01-03 04:52:18', '2026-01-03 04:52:18'),
(27, 8, '2025-12-31', '11:14:00', '17:01:00', 'Document submission', 'hod_approved', NULL, NULL, NULL, '2025-12-31 05:52:18', '2025-12-31 06:52:18', NULL, NULL, 8, 2, NULL, NULL, 1, '2026-01-03 04:52:18', '2026-01-03 04:52:18'),
(28, 8, '2025-12-16', '11:58:00', '17:10:00', 'Interview', 'final_approved', NULL, NULL, NULL, '2025-12-16 07:52:18', '2025-12-16 08:52:18', NULL, '2025-12-16 08:52:18', 10, 2, NULL, 'GP-6958EDDAA17C2', 1, '2026-01-03 04:52:18', '2026-01-03 04:52:18'),
(29, 8, '2025-12-16', '11:37:00', '19:34:00', 'Interview', 'final_approved', NULL, NULL, NULL, '2025-12-16 06:52:18', '2026-01-03 09:57:32', NULL, '2026-01-03 09:57:32', 10, 2, NULL, NULL, 1, '2026-01-03 04:52:18', '2026-01-03 09:57:32'),
(30, 9, '2025-12-29', '08:25:00', '16:51:00', 'Medical appointment', 'hod_approved', NULL, NULL, NULL, '2025-12-29 06:52:19', '2025-12-29 08:52:19', NULL, NULL, 8, 2, NULL, NULL, 1, '2026-01-03 04:52:19', '2026-01-03 04:52:19'),
(31, 9, '2025-12-31', '10:40:00', '16:33:00', 'Personal work', 'final_approved', NULL, NULL, NULL, '2025-12-31 05:52:19', '2025-12-31 08:52:19', NULL, '2025-12-31 08:52:19', 9, 2, NULL, 'GP-6958EDDB21870', 1, '2026-01-03 04:52:19', '2026-01-03 04:52:19'),
(32, 9, '2025-12-10', '08:22:00', '19:53:00', 'Competition participation', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-10 06:52:19', NULL, NULL, NULL, 9, NULL, NULL, NULL, 1, '2026-01-03 04:52:19', '2026-01-03 04:52:19'),
(33, 10, '2025-12-15', '08:20:00', '19:37:00', 'Project work', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:19', '2026-01-03 04:52:19'),
(34, 10, '2025-12-06', '09:32:00', '18:46:00', 'Document submission', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:19', '2026-01-03 04:52:19'),
(35, 10, '2025-12-04', '09:03:00', '19:32:00', 'Competition participation', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-04 07:52:19', NULL, NULL, NULL, 10, NULL, NULL, NULL, 1, '2026-01-03 04:52:19', '2026-01-03 04:52:19'),
(36, 11, '2025-12-18', '10:12:00', '19:31:00', 'Personal work', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-18 06:52:20', NULL, NULL, NULL, 11, NULL, NULL, NULL, 1, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(37, 11, '2025-12-20', '09:30:00', '16:33:00', 'Medical appointment', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-20 05:52:20', '2025-12-20 06:52:20', NULL, NULL, 12, 3, NULL, NULL, 1, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(38, 11, '2025-12-06', '10:04:00', '18:53:00', 'Project work', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-06 07:52:20', NULL, NULL, NULL, 12, NULL, NULL, NULL, 1, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(39, 11, '2025-12-13', '09:38:00', '16:13:00', 'Interview', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-13 06:52:20', NULL, NULL, NULL, 11, NULL, NULL, NULL, 1, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(40, 12, '2025-12-27', '11:49:00', '18:17:00', 'Document submission', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(41, 12, '2025-12-09', '10:46:00', '16:58:00', 'Library research', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-09 06:52:20', '2025-12-09 09:52:20', NULL, NULL, 13, 3, NULL, NULL, 1, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(42, 12, '2025-12-07', '09:05:00', '18:45:00', 'Competition participation', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-07 06:52:20', NULL, NULL, NULL, 11, NULL, NULL, NULL, 1, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(43, 13, '2025-12-29', '09:23:00', '17:28:00', 'Personal work', 'staff_approved', NULL, NULL, NULL, '2025-12-29 07:52:20', NULL, NULL, NULL, 13, NULL, NULL, NULL, 1, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(44, 13, '2025-12-08', '08:36:00', '17:01:00', 'Medical appointment', 'staff_approved', NULL, NULL, NULL, '2025-12-08 07:52:20', NULL, NULL, NULL, 12, NULL, NULL, NULL, 1, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(45, 13, '2026-01-02', '09:09:00', '18:11:00', 'Competition participation', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2026-01-02 07:52:20', '2026-01-02 10:52:20', NULL, NULL, 12, 3, NULL, NULL, 1, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(46, 14, '2026-01-01', '09:41:00', '17:24:00', 'Document submission', 'final_approved', NULL, NULL, NULL, '2026-01-01 06:52:21', '2026-01-01 08:52:21', '2026-01-03 10:04:52', '2026-01-03 10:04:52', 12, 3, 7, 'GP-6959371CE3973', 1, '2026-01-03 04:52:21', '2026-01-03 10:04:52'),
(47, 14, '2025-12-06', '11:37:00', '17:32:00', 'Interview', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-06 07:52:21', '2025-12-06 10:52:21', NULL, NULL, 11, 3, NULL, NULL, 1, '2026-01-03 04:52:21', '2026-01-03 04:52:21'),
(48, 14, '2025-12-04', '08:40:00', '17:00:00', 'Project work', 'warden_rejected', NULL, NULL, NULL, '2025-12-04 06:52:21', '2025-12-04 08:52:21', '2026-01-04 03:52:07', NULL, 11, 3, 7, NULL, 1, '2026-01-03 04:52:21', '2026-01-04 03:52:07'),
(49, 14, '2025-12-20', '11:00:00', '19:28:00', 'Personal work', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-20 05:52:21', '2025-12-20 07:52:21', NULL, NULL, 13, 3, NULL, NULL, 1, '2026-01-03 04:52:21', '2026-01-03 04:52:21'),
(50, 14, '2025-12-22', '10:27:00', '18:33:00', 'Personal work', 'warden_rejected', NULL, NULL, NULL, '2025-12-22 05:52:21', '2025-12-22 07:52:21', '2026-01-04 03:52:15', NULL, 11, 3, 7, NULL, 1, '2026-01-03 04:52:21', '2026-01-04 03:52:15'),
(51, 15, '2025-12-07', '10:21:00', '16:37:00', 'Personal work', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:21', '2026-01-03 04:52:21'),
(52, 15, '2025-12-15', '09:46:00', '16:35:00', 'Interview', 'final_approved', NULL, NULL, NULL, '2025-12-15 07:52:21', '2025-12-15 08:52:21', NULL, '2025-12-15 08:52:21', 13, 3, NULL, 'GP-6958EDDDC2F9B', 1, '2026-01-03 04:52:21', '2026-01-03 04:52:21'),
(53, 16, '2025-12-30', '11:37:00', '17:46:00', 'Medical appointment', 'staff_approved', NULL, NULL, NULL, '2025-12-30 07:52:22', NULL, NULL, NULL, 13, NULL, NULL, NULL, 1, '2026-01-03 04:52:22', '2026-01-03 04:52:22'),
(54, 16, '2025-12-30', '09:06:00', '16:02:00', 'Document submission', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:22', '2026-01-03 04:52:22'),
(55, 16, '2025-12-18', '09:31:00', '16:27:00', 'Document submission', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-18 07:52:22', '2025-12-18 09:52:22', NULL, NULL, 11, 3, NULL, NULL, 1, '2026-01-03 04:52:22', '2026-01-03 04:52:22'),
(56, 17, '2025-12-12', '11:15:00', '18:04:00', 'Project work', 'staff_approved', NULL, NULL, NULL, '2025-12-12 05:52:22', NULL, NULL, NULL, 11, NULL, NULL, NULL, 1, '2026-01-03 04:52:22', '2026-01-03 04:52:22'),
(57, 17, '2025-12-14', '08:49:00', '19:47:00', 'Document submission', 'staff_approved', NULL, NULL, NULL, '2025-12-14 05:52:22', NULL, NULL, NULL, 11, NULL, NULL, NULL, 1, '2026-01-03 04:52:22', '2026-01-03 04:52:22'),
(58, 17, '2025-12-17', '10:15:00', '19:00:00', 'Family function', 'hod_approved', NULL, NULL, NULL, '2025-12-17 05:52:22', '2025-12-17 07:52:22', NULL, NULL, 11, 3, NULL, NULL, 1, '2026-01-03 04:52:22', '2026-01-03 04:52:22'),
(59, 18, '2025-12-11', '09:55:00', '18:40:00', 'Medical appointment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:23', '2026-01-03 04:52:23'),
(60, 18, '2025-12-06', '09:59:00', '18:48:00', 'Library research', 'hod_approved', NULL, NULL, NULL, '2025-12-06 06:52:23', '2025-12-06 09:52:23', NULL, NULL, 12, 3, NULL, NULL, 1, '2026-01-03 04:52:23', '2026-01-03 04:52:23'),
(61, 18, '2025-12-11', '09:32:00', '18:56:00', 'Project work', 'staff_approved', NULL, NULL, NULL, '2025-12-11 05:52:23', NULL, NULL, NULL, 12, NULL, NULL, NULL, 1, '2026-01-03 04:52:23', '2026-01-03 04:52:23'),
(62, 19, '2025-12-14', '08:13:00', '17:40:00', 'Medical appointment', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-14 07:52:23', '2025-12-14 10:52:23', NULL, NULL, 11, 3, NULL, NULL, 1, '2026-01-03 04:52:23', '2026-01-03 04:52:23'),
(63, 19, '2025-12-12', '11:00:00', '18:25:00', 'Library research', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-12 05:52:23', NULL, NULL, NULL, 11, NULL, NULL, NULL, 1, '2026-01-03 04:52:23', '2026-01-03 04:52:23'),
(64, 19, '2025-12-26', '11:25:00', '17:01:00', 'Library research', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-26 06:52:23', '2025-12-26 09:52:23', NULL, NULL, 12, 3, NULL, NULL, 1, '2026-01-03 04:52:23', '2026-01-03 04:52:23'),
(65, 20, '2025-12-26', '08:22:00', '17:22:00', 'Medical appointment', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-26 05:52:24', '2025-12-26 06:52:24', NULL, NULL, 11, 3, NULL, NULL, 1, '2026-01-03 04:52:24', '2026-01-03 04:52:24'),
(66, 20, '2025-12-21', '11:09:00', '16:40:00', 'Family function', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-21 05:52:24', '2025-12-21 06:52:24', NULL, NULL, 13, 3, NULL, NULL, 1, '2026-01-03 04:52:24', '2026-01-03 04:52:24'),
(67, 20, '2025-12-16', '11:25:00', '19:10:00', 'Personal work', 'hod_rejected', NULL, NULL, NULL, '2025-12-16 05:52:24', '2026-01-03 10:01:35', NULL, NULL, 13, 3, NULL, NULL, 1, '2026-01-03 04:52:24', '2026-01-03 10:01:35'),
(68, 20, '2025-12-04', '09:59:00', '19:12:00', 'Interview', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-04 05:52:24', '2025-12-04 08:52:24', NULL, NULL, 12, 3, NULL, NULL, 1, '2026-01-03 04:52:24', '2026-01-03 04:52:24'),
(69, 21, '2025-12-27', '08:50:00', '19:45:00', 'Document submission', 'final_approved', NULL, NULL, NULL, '2025-12-27 06:52:24', '2025-12-27 09:52:24', '2025-12-27 12:52:24', '2025-12-27 12:52:24', 16, 4, 7, 'GP-6958EDE07D845', 1, '2026-01-03 04:52:24', '2026-01-03 04:52:24'),
(70, 21, '2025-12-18', '10:19:00', '18:57:00', 'Project work', 'staff_approved', NULL, NULL, NULL, '2025-12-18 06:52:24', NULL, NULL, NULL, 15, NULL, NULL, NULL, 1, '2026-01-03 04:52:24', '2026-01-03 04:52:24'),
(71, 21, '2025-12-13', '08:57:00', '16:34:00', 'Personal work', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-13 07:52:24', NULL, NULL, NULL, 16, NULL, NULL, NULL, 1, '2026-01-03 04:52:24', '2026-01-03 04:52:24'),
(72, 22, '2026-01-01', '11:59:00', '19:46:00', 'Library research', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2026-01-01 05:52:25', NULL, NULL, NULL, 16, NULL, NULL, NULL, 1, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(73, 22, '2025-12-24', '10:37:00', '17:15:00', 'Document submission', 'final_approved', NULL, NULL, NULL, '2025-12-24 06:52:25', '2025-12-24 08:52:25', '2025-12-24 09:52:25', '2025-12-24 09:52:25', 14, 4, 7, 'GP-6958EDE112FFD', 1, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(74, 22, '2025-12-19', '10:45:00', '18:54:00', 'Interview', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(75, 23, '2025-12-14', '08:51:00', '17:35:00', 'Library research', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-14 05:52:25', '2025-12-14 07:52:25', NULL, NULL, 15, 4, NULL, NULL, 1, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(76, 23, '2025-12-07', '09:27:00', '16:33:00', 'Medical appointment', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-07 06:52:25', '2025-12-07 07:52:25', NULL, NULL, 16, 4, NULL, NULL, 1, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(77, 24, '2025-12-20', '09:20:00', '19:28:00', 'Project work', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(78, 24, '2025-12-22', '09:57:00', '17:39:00', 'Medical appointment', 'staff_approved', NULL, NULL, NULL, '2025-12-22 05:52:25', NULL, NULL, NULL, 16, NULL, NULL, NULL, 1, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(79, 24, '2025-12-31', '11:01:00', '16:28:00', 'Library research', 'staff_approved', NULL, NULL, NULL, '2025-12-31 07:52:25', NULL, NULL, NULL, 14, NULL, NULL, NULL, 1, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(80, 24, '2025-12-12', '11:23:00', '16:10:00', 'Competition participation', 'staff_approved', NULL, NULL, NULL, '2025-12-12 06:52:25', NULL, NULL, NULL, 16, NULL, NULL, NULL, 1, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(81, 24, '2025-12-28', '10:26:00', '19:05:00', 'Medical appointment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(82, 25, '2025-12-30', '11:17:00', '16:03:00', 'Competition participation', 'hod_approved', NULL, NULL, NULL, '2025-12-30 07:52:26', '2025-12-30 10:52:26', NULL, NULL, 16, 4, NULL, NULL, 1, '2026-01-03 04:52:26', '2026-01-03 04:52:26'),
(83, 25, '2025-12-22', '09:31:00', '18:08:00', 'Interview', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-22 05:52:26', NULL, NULL, NULL, 14, NULL, NULL, NULL, 1, '2026-01-03 04:52:26', '2026-01-03 04:52:26'),
(84, 26, '2025-12-24', '08:32:00', '18:00:00', 'Document submission', 'final_approved', NULL, NULL, NULL, '2025-12-24 07:52:26', '2025-12-24 09:52:26', NULL, '2025-12-24 09:52:26', 14, 4, NULL, 'GP-6958EDE2A1FC2', 1, '2026-01-03 04:52:26', '2026-01-03 04:52:26'),
(85, 26, '2025-12-30', '10:56:00', '17:08:00', 'Medical appointment', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-30 05:52:26', '2025-12-30 08:52:26', NULL, NULL, 16, 4, NULL, NULL, 1, '2026-01-03 04:52:26', '2026-01-03 04:52:26'),
(86, 26, '2025-12-13', '10:59:00', '17:16:00', 'Family function', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-13 05:52:26', '2025-12-13 06:52:26', NULL, NULL, 15, 4, NULL, NULL, 1, '2026-01-03 04:52:26', '2026-01-03 04:52:26'),
(87, 26, '2025-12-20', '11:12:00', '16:05:00', 'Document submission', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:26', '2026-01-03 04:52:26'),
(88, 26, '2025-12-05', '11:09:00', '17:59:00', 'Interview', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-05 05:52:26', NULL, NULL, NULL, 15, NULL, NULL, NULL, 1, '2026-01-03 04:52:26', '2026-01-03 04:52:26'),
(89, 27, '2025-12-19', '11:57:00', '18:17:00', 'Personal work', 'staff_approved', NULL, NULL, NULL, '2025-12-19 06:52:27', NULL, NULL, NULL, 14, NULL, NULL, NULL, 1, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(90, 27, '2025-12-12', '11:04:00', '18:44:00', 'Interview', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-12 07:52:27', NULL, NULL, NULL, 14, NULL, NULL, NULL, 1, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(91, 27, '2025-12-31', '10:54:00', '16:49:00', 'Personal work', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(92, 27, '2025-12-20', '08:10:00', '18:39:00', 'Family function', 'staff_approved', NULL, NULL, NULL, '2025-12-20 06:52:27', NULL, NULL, NULL, 15, NULL, NULL, NULL, 1, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(93, 27, '2025-12-08', '10:38:00', '18:44:00', 'Personal work', 'hod_approved', NULL, NULL, NULL, '2025-12-08 07:52:27', '2025-12-08 09:52:27', NULL, NULL, 14, 4, NULL, NULL, 1, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(94, 28, '2025-12-25', '11:20:00', '18:27:00', 'Library research', 'hod_approved', NULL, NULL, NULL, '2025-12-25 07:52:27', '2025-12-25 08:52:27', NULL, NULL, 16, 4, NULL, NULL, 1, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(95, 28, '2025-12-31', '10:35:00', '18:00:00', 'Competition participation', 'hod_approved', NULL, NULL, NULL, '2025-12-31 07:52:27', '2025-12-31 10:52:27', NULL, NULL, 15, 4, NULL, NULL, 1, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(96, 28, '2025-12-14', '11:05:00', '17:56:00', 'Family function', 'staff_approved', NULL, NULL, NULL, '2025-12-14 06:52:27', NULL, NULL, NULL, 16, NULL, NULL, NULL, 1, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(97, 28, '2025-12-28', '10:41:00', '18:51:00', 'Medical appointment', 'hod_approved', NULL, NULL, NULL, '2025-12-28 05:52:27', '2025-12-28 07:52:27', NULL, NULL, 16, 4, NULL, NULL, 1, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(98, 29, '2025-12-28', '09:06:00', '16:55:00', 'Medical appointment', 'hod_approved', NULL, NULL, NULL, '2025-12-28 05:52:28', '2025-12-28 06:52:28', NULL, NULL, 15, 4, NULL, NULL, 1, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(99, 29, '2025-12-14', '10:40:00', '17:38:00', 'Competition participation', 'final_approved', NULL, NULL, NULL, '2025-12-14 06:52:28', '2025-12-14 09:52:28', NULL, '2025-12-14 09:52:28', 16, 4, NULL, 'GP-6958EDE40468A', 1, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(100, 30, '2025-12-08', '09:35:00', '17:54:00', 'Competition participation', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(101, 30, '2025-12-22', '10:32:00', '16:22:00', 'Document submission', 'staff_approved', NULL, NULL, NULL, '2025-12-22 05:52:28', NULL, NULL, NULL, 16, NULL, NULL, NULL, 1, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(102, 30, '2025-12-18', '09:24:00', '17:54:00', 'Interview', 'hod_approved', NULL, NULL, NULL, '2025-12-18 06:52:28', '2025-12-18 07:52:28', NULL, NULL, 16, 4, NULL, NULL, 1, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(103, 30, '2025-12-14', '09:47:00', '17:28:00', 'Personal work', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(104, 31, '2025-12-30', '10:26:00', '16:33:00', 'Project work', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-30 05:52:28', NULL, NULL, NULL, 17, NULL, NULL, NULL, 1, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(105, 31, '2025-12-18', '10:02:00', '19:26:00', 'Medical appointment', 'staff_approved', NULL, NULL, NULL, '2025-12-18 07:52:28', NULL, NULL, NULL, 18, NULL, NULL, NULL, 1, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(106, 31, '2025-12-18', '08:22:00', '17:18:00', 'Project work', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-18 05:52:28', NULL, NULL, NULL, 17, NULL, NULL, NULL, 1, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(107, 31, '2025-12-25', '08:47:00', '16:17:00', 'Project work', 'final_approved', NULL, NULL, NULL, '2025-12-25 07:52:28', '2025-12-25 08:52:28', '2025-12-25 09:52:28', '2025-12-25 09:52:28', 17, 5, 7, 'GP-6958EDE4DA16F', 1, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(108, 31, '2025-12-27', '08:34:00', '19:22:00', 'Project work', 'final_approved', NULL, NULL, NULL, '2025-12-27 06:52:28', '2025-12-27 07:52:28', '2025-12-27 10:52:28', '2025-12-27 10:52:28', 17, 5, 7, 'GP-6958EDE4DBBDD', 1, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(109, 32, '2025-12-07', '11:45:00', '18:28:00', 'Medical appointment', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-07 07:52:29', '2025-12-07 10:52:29', NULL, NULL, 17, 5, NULL, NULL, 1, '2026-01-03 04:52:29', '2026-01-03 04:52:29'),
(110, 32, '2025-12-22', '11:54:00', '19:37:00', 'Medical appointment', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-22 07:52:29', NULL, NULL, NULL, 19, NULL, NULL, NULL, 1, '2026-01-03 04:52:29', '2026-01-03 04:52:29'),
(111, 32, '2025-12-13', '10:45:00', '19:27:00', 'Document submission', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-13 06:52:29', NULL, NULL, NULL, 17, NULL, NULL, NULL, 1, '2026-01-03 04:52:29', '2026-01-03 04:52:29'),
(112, 32, '2025-12-29', '09:06:00', '16:45:00', 'Library research', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:29', '2026-01-03 04:52:29'),
(113, 33, '2025-12-15', '09:17:00', '17:43:00', 'Project work', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-15 07:52:29', '2025-12-15 08:52:29', NULL, NULL, 17, 5, NULL, NULL, 1, '2026-01-03 04:52:29', '2026-01-03 04:52:29'),
(114, 33, '2025-12-05', '11:15:00', '16:29:00', 'Competition participation', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:29', '2026-01-03 04:52:29'),
(115, 34, '2025-12-16', '09:34:00', '19:06:00', 'Library research', 'staff_approved', NULL, NULL, NULL, '2025-12-16 05:52:30', NULL, NULL, NULL, 19, NULL, NULL, NULL, 1, '2026-01-03 04:52:30', '2026-01-03 04:52:30'),
(116, 34, '2026-01-02', '08:26:00', '17:29:00', 'Family function', 'warden_rejected', NULL, NULL, NULL, '2026-01-02 05:52:30', '2026-01-02 08:52:30', '2026-01-03 10:04:03', NULL, 17, 5, 7, NULL, 1, '2026-01-03 04:52:30', '2026-01-03 10:04:03'),
(117, 35, '2025-12-29', '11:28:00', '19:44:00', 'Medical appointment', 'hod_approved', NULL, NULL, NULL, '2025-12-29 05:52:30', '2025-12-29 06:52:30', NULL, NULL, 19, 5, NULL, NULL, 1, '2026-01-03 04:52:30', '2026-01-03 04:52:30'),
(118, 35, '2025-12-20', '11:12:00', '16:08:00', 'Family function', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-20 06:52:30', '2025-12-20 07:52:30', NULL, NULL, 17, 5, NULL, NULL, 1, '2026-01-03 04:52:30', '2026-01-03 04:52:30'),
(119, 36, '2025-12-12', '10:03:00', '17:37:00', 'Family function', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(120, 36, '2025-12-06', '08:47:00', '16:21:00', 'Medical appointment', 'final_approved', NULL, NULL, NULL, '2025-12-06 07:52:31', '2025-12-06 08:52:31', NULL, '2025-12-06 08:52:31', 17, 5, NULL, 'GP-6958EDE71EA50', 1, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(121, 36, '2025-12-29', '08:10:00', '17:34:00', 'Family function', 'final_approved', NULL, NULL, NULL, '2025-12-29 07:52:31', '2025-12-29 08:52:31', NULL, '2025-12-29 08:52:31', 18, 5, NULL, 'GP-6958EDE7202EA', 1, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(122, 37, '2025-12-11', '08:05:00', '18:02:00', 'Personal work', 'hod_approved', NULL, NULL, NULL, '2025-12-11 06:52:31', '2025-12-11 09:52:31', NULL, NULL, 18, 5, NULL, NULL, 1, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(123, 37, '2025-12-27', '09:06:00', '19:53:00', 'Project work', 'staff_approved', NULL, NULL, NULL, '2025-12-27 07:52:31', NULL, NULL, NULL, 19, NULL, NULL, NULL, 1, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(124, 37, '2025-12-23', '08:00:00', '19:46:00', 'Document submission', 'hod_approved', NULL, NULL, NULL, '2025-12-23 07:52:31', '2025-12-23 09:52:31', NULL, NULL, 17, 5, NULL, NULL, 1, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(125, 37, '2025-12-30', '08:27:00', '19:54:00', 'Competition participation', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-30 07:52:31', '2025-12-30 08:52:31', NULL, NULL, 19, 5, NULL, NULL, 1, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(126, 37, '2025-12-19', '10:24:00', '18:57:00', 'Medical appointment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(127, 38, '2026-01-02', '11:59:00', '17:28:00', 'Project work', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(128, 38, '2025-12-12', '09:57:00', '18:25:00', 'Project work', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-12 05:52:32', NULL, NULL, NULL, 19, NULL, NULL, NULL, 1, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(129, 39, '2025-12-28', '11:01:00', '17:16:00', 'Competition participation', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-28 05:52:32', '2025-12-28 07:52:32', NULL, NULL, 18, 5, NULL, NULL, 1, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(130, 39, '2025-12-13', '08:16:00', '16:51:00', 'Project work', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-13 06:52:32', NULL, NULL, NULL, 17, NULL, NULL, NULL, 1, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(131, 39, '2025-12-05', '08:07:00', '17:12:00', 'Competition participation', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-05 07:52:32', NULL, NULL, NULL, 17, NULL, NULL, NULL, 1, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(132, 39, '2025-12-15', '11:37:00', '16:12:00', 'Family function', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-15 07:52:32', '2025-12-15 08:52:32', NULL, NULL, 17, 5, NULL, NULL, 1, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(133, 39, '2025-12-12', '09:50:00', '18:19:00', 'Competition participation', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(134, 40, '2025-12-18', '10:03:00', '18:50:00', 'Family function', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(135, 40, '2025-12-14', '11:45:00', '16:21:00', 'Library research', 'hod_approved', NULL, NULL, NULL, '2025-12-14 05:52:32', '2025-12-14 07:52:32', NULL, NULL, 19, 5, NULL, NULL, 1, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(136, 40, '2025-12-06', '08:21:00', '16:07:00', 'Interview', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-06 06:52:32', '2025-12-06 07:52:32', NULL, NULL, 19, 5, NULL, NULL, 1, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(137, 40, '2025-12-18', '09:49:00', '16:04:00', 'Library research', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(138, 41, '2025-12-20', '11:32:00', '17:03:00', 'Competition participation', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-20 06:52:33', NULL, NULL, NULL, 22, NULL, NULL, NULL, 1, '2026-01-03 04:52:33', '2026-01-03 04:52:33'),
(139, 41, '2026-01-02', '11:04:00', '19:19:00', 'Competition participation', 'final_approved', NULL, NULL, NULL, '2026-01-02 06:52:33', '2026-01-02 08:52:33', '2026-01-02 11:52:33', '2026-01-02 11:52:33', 20, 6, 7, 'GP-6958EDE95CB59', 1, '2026-01-03 04:52:33', '2026-01-03 04:52:33'),
(140, 41, '2025-12-04', '08:38:00', '17:23:00', 'Library research', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-04 05:52:33', NULL, NULL, NULL, 22, NULL, NULL, NULL, 1, '2026-01-03 04:52:33', '2026-01-03 04:52:33'),
(141, 42, '2025-12-09', '11:19:00', '18:28:00', 'Library research', 'staff_approved', NULL, NULL, NULL, '2025-12-09 06:52:33', NULL, NULL, NULL, 21, NULL, NULL, NULL, 1, '2026-01-03 04:52:33', '2026-01-03 04:52:33'),
(142, 42, '2025-12-13', '11:16:00', '16:55:00', 'Personal work', 'final_approved', NULL, NULL, NULL, '2025-12-13 07:52:33', '2025-12-13 08:52:33', '2026-01-03 10:03:43', '2026-01-03 10:03:43', 22, 6, 7, 'GP-695936D73C0F3', 1, '2026-01-03 04:52:33', '2026-01-03 10:03:43'),
(143, 42, '2025-12-14', '09:22:00', '19:31:00', 'Document submission', 'staff_approved', NULL, NULL, NULL, '2025-12-14 05:52:33', NULL, NULL, NULL, 21, NULL, NULL, NULL, 1, '2026-01-03 04:52:33', '2026-01-03 04:52:33'),
(144, 43, '2025-12-30', '10:51:00', '19:55:00', 'Project work', 'final_approved', NULL, NULL, NULL, '2025-12-30 07:52:34', '2025-12-30 08:52:34', '2025-12-30 11:52:34', '2025-12-30 11:52:34', 20, 6, 7, 'GP-6958EDEA33508', 1, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(145, 43, '2025-12-17', '08:11:00', '19:25:00', 'Project work', 'staff_approved', NULL, NULL, NULL, '2025-12-17 06:52:34', NULL, NULL, NULL, 20, NULL, NULL, NULL, 1, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(146, 43, '2025-12-16', '11:50:00', '18:18:00', 'Document submission', 'final_approved', NULL, NULL, NULL, '2025-12-16 06:52:34', '2025-12-16 09:52:34', '2025-12-16 10:52:34', '2025-12-16 10:52:34', 20, 6, 7, 'GP-6958EDEA49544', 1, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(147, 43, '2025-12-23', '10:44:00', '16:40:00', 'Document submission', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-23 05:52:34', NULL, NULL, NULL, 20, NULL, NULL, NULL, 1, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(148, 43, '2025-12-26', '10:01:00', '19:08:00', 'Document submission', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(149, 44, '2025-12-15', '10:54:00', '18:31:00', 'Personal work', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-15 07:52:34', '2025-12-15 09:52:34', NULL, NULL, 22, 6, NULL, NULL, 1, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(150, 44, '2025-12-12', '08:15:00', '18:41:00', 'Library research', 'staff_approved', NULL, NULL, NULL, '2025-12-12 06:52:34', NULL, NULL, NULL, 21, NULL, NULL, NULL, 1, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(151, 44, '2025-12-19', '11:32:00', '16:03:00', 'Library research', 'staff_approved', NULL, NULL, NULL, '2025-12-19 06:52:34', NULL, NULL, NULL, 22, NULL, NULL, NULL, 1, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(152, 45, '2025-12-05', '08:18:00', '17:29:00', 'Medical appointment', 'staff_approved', NULL, NULL, NULL, '2025-12-05 07:52:35', NULL, NULL, NULL, 21, NULL, NULL, NULL, 1, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(153, 45, '2025-12-08', '11:27:00', '17:03:00', 'Library research', 'hod_approved', NULL, NULL, NULL, '2025-12-08 07:52:35', '2025-12-08 08:52:35', NULL, NULL, 21, 6, NULL, NULL, 1, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(154, 45, '2025-12-19', '10:29:00', '16:43:00', 'Library research', 'hod_approved', NULL, NULL, NULL, '2025-12-19 05:52:35', '2025-12-19 08:52:35', NULL, NULL, 22, 6, NULL, NULL, 1, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(155, 45, '2025-12-19', '09:08:00', '19:59:00', 'Document submission', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(156, 45, '2025-12-05', '10:11:00', '16:21:00', 'Project work', 'hod_approved', NULL, NULL, NULL, '2025-12-05 05:52:35', '2025-12-05 06:52:35', NULL, NULL, 21, 6, NULL, NULL, 1, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(157, 46, '2025-12-19', '10:00:00', '19:02:00', 'Family function', 'hod_approved', NULL, NULL, NULL, '2025-12-19 06:52:35', '2025-12-19 07:52:35', NULL, NULL, 21, 6, NULL, NULL, 1, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(158, 46, '2025-12-23', '11:57:00', '19:48:00', 'Family function', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-23 05:52:35', '2025-12-23 07:52:35', NULL, NULL, 22, 6, NULL, NULL, 1, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(159, 46, '2025-12-31', '10:40:00', '18:22:00', 'Project work', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-31 05:52:35', '2025-12-31 06:52:35', NULL, NULL, 22, 6, NULL, NULL, 1, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(160, 47, '2025-12-23', '10:27:00', '19:15:00', 'Family function', 'staff_approved', NULL, NULL, NULL, '2025-12-23 07:52:36', NULL, NULL, NULL, 20, NULL, NULL, NULL, 1, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(161, 47, '2025-12-05', '08:20:00', '19:10:00', 'Personal work', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-05 05:52:36', NULL, NULL, NULL, 22, NULL, NULL, NULL, 1, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(162, 47, '2025-12-04', '08:04:00', '16:45:00', 'Interview', 'final_approved', NULL, NULL, NULL, '2025-12-04 05:52:36', '2025-12-04 08:52:36', NULL, '2025-12-04 08:52:36', 20, 6, NULL, 'GP-6958EDEC11DF2', 1, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(163, 47, '2025-12-19', '08:53:00', '17:55:00', 'Project work', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-19 07:52:36', '2025-12-19 10:52:36', NULL, NULL, 22, 6, NULL, NULL, 1, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(164, 48, '2025-12-09', '09:23:00', '18:18:00', 'Competition participation', 'staff_rejected', 'Remarks from staff', NULL, NULL, '2025-12-09 05:52:36', NULL, NULL, NULL, 22, NULL, NULL, NULL, 1, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(165, 48, '2025-12-22', '08:25:00', '17:26:00', 'Competition participation', 'staff_approved', NULL, NULL, NULL, '2025-12-22 07:52:36', NULL, NULL, NULL, 20, NULL, NULL, NULL, 1, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(166, 48, '2025-12-22', '08:36:00', '19:46:00', 'Personal work', 'final_approved', NULL, NULL, NULL, '2025-12-22 05:52:36', '2025-12-22 08:52:36', NULL, '2025-12-22 08:52:36', 22, 6, NULL, 'GP-6958EDEC77161', 1, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(167, 48, '2025-12-24', '09:00:00', '17:09:00', 'Document submission', 'final_approved', NULL, NULL, NULL, '2025-12-24 06:52:36', '2025-12-24 08:52:36', NULL, '2025-12-24 08:52:36', 22, 6, NULL, 'GP-6958EDEC787BA', 1, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(168, 49, '2025-12-31', '11:52:00', '16:50:00', 'Family function', 'staff_approved', NULL, NULL, NULL, '2025-12-31 07:52:36', NULL, NULL, NULL, 20, NULL, NULL, NULL, 1, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(169, 49, '2025-12-16', '09:56:00', '18:51:00', 'Interview', 'hod_approved', NULL, NULL, NULL, '2025-12-16 07:52:36', '2025-12-16 09:52:36', NULL, NULL, 21, 6, NULL, NULL, 1, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(170, 50, '2026-01-02', '10:57:00', '19:36:00', 'Competition participation', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2026-01-02 07:52:37', '2026-01-02 08:52:37', NULL, NULL, 21, 6, NULL, NULL, 1, '2026-01-03 04:52:37', '2026-01-03 04:52:37'),
(171, 50, '2025-12-15', '09:12:00', '17:43:00', 'Personal work', 'hod_approved', NULL, NULL, NULL, '2025-12-15 05:52:37', '2025-12-15 08:52:37', NULL, NULL, 22, 6, NULL, NULL, 1, '2026-01-03 04:52:37', '2026-01-03 04:52:37'),
(172, 50, '2025-12-11', '08:52:00', '16:22:00', 'Personal work', 'hod_rejected', 'Remarks from staff', 'Remarks from HOD', NULL, '2025-12-11 07:52:37', '2025-12-11 10:52:37', NULL, NULL, 22, 6, NULL, NULL, 1, '2026-01-03 04:52:37', '2026-01-03 04:52:37'),
(173, 1, '2026-01-03', '08:54:00', '20:55:00', 'going to home', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 09:55:23', '2026-01-03 09:55:23'),
(174, 1, '2026-01-04', '00:50:00', '10:49:00', 'Quia dolor aliquip ut omnis non reiciendis praesentium voluptas odit sapiente sed blanditiis voluptas', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-04 03:14:20', '2026-01-04 03:14:20'),
(175, 1, '2026-01-17', '16:49:00', '19:52:00', 'Rerum omnis sit qui excepteur expedita dolor duis eius quo sit obcaecati est', 'hod_approved', NULL, NULL, NULL, '2026-01-04 06:37:16', '2026-01-04 06:40:25', NULL, NULL, 9, 2, NULL, NULL, 1, '2026-01-04 06:07:46', '2026-01-04 06:40:25'),
(176, 1, '2026-01-22', '17:27:00', '23:05:00', 'Voluptatem voluptatibus nesciunt unde sed tempora mollitia elit', 'staff_rejected', NULL, NULL, NULL, '2026-01-04 06:36:53', NULL, NULL, NULL, 9, NULL, NULL, NULL, 1, '2026-01-04 06:36:16', '2026-01-04 06:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `hods`
--

CREATE TABLE `hods` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `hods` (`id`, `user_id`, `department_id`, `employee_id`, `qualifications`, `appointment_date`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'HOD0001', NULL, '2024-01-03', '2026-01-03 04:52:06', '2026-01-03 04:52:06'),
(2, 3, 2, 'HOD0002', NULL, '2024-01-03', '2026-01-03 04:52:06', '2026-01-03 04:52:06'),
(3, 4, 3, 'HOD0003', NULL, '2024-01-03', '2026-01-03 04:52:07', '2026-01-03 04:52:07'),
(4, 5, 4, 'HOD0004', NULL, '2024-01-03', '2026-01-03 04:52:07', '2026-01-03 04:52:07'),
(5, 6, 5, 'HOD0005', NULL, '2024-01-03', '2026-01-03 04:52:08', '2026-01-03 04:52:08');

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
(11, '2024_01_03_000007_modify_users_table_add_roles', 1);

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

INSERT INTO `staff` (`id`, `user_id`, `department_id`, `employee_id`, `designation`, `type`, `qualifications`, `joining_date`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 'STF000101', 'Senior Lecturer', 'teaching', NULL, '2025-03-03', '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(2, 9, 1, 'STF000102', 'Lecturer', 'teaching', NULL, '2024-08-03', '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(3, 10, 1, 'STF000103', 'Lecturer', 'teaching', NULL, '2024-03-03', '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(4, 11, 2, 'STF000201', 'Senior Lecturer', 'teaching', NULL, '2024-09-03', '2026-01-03 04:52:10', '2026-01-03 04:52:10'),
(5, 12, 2, 'STF000202', 'Lecturer', 'teaching', NULL, '2025-05-03', '2026-01-03 04:52:10', '2026-01-03 04:52:10'),
(6, 13, 2, 'STF000203', 'Lecturer', 'teaching', NULL, '2024-06-03', '2026-01-03 04:52:11', '2026-01-03 04:52:11'),
(7, 14, 3, 'STF000301', 'Senior Lecturer', 'teaching', NULL, '2025-02-03', '2026-01-03 04:52:11', '2026-01-03 04:52:11'),
(8, 15, 3, 'STF000302', 'Lecturer', 'teaching', NULL, '2025-03-03', '2026-01-03 04:52:12', '2026-01-03 04:52:12'),
(9, 16, 3, 'STF000303', 'Lecturer', 'teaching', NULL, '2025-07-03', '2026-01-03 04:52:12', '2026-01-03 04:52:12'),
(10, 17, 4, 'STF000401', 'Senior Lecturer', 'teaching', NULL, '2024-03-03', '2026-01-03 04:52:13', '2026-01-03 04:52:13'),
(11, 18, 4, 'STF000402', 'Lecturer', 'teaching', NULL, '2024-03-03', '2026-01-03 04:52:13', '2026-01-03 04:52:13'),
(12, 19, 4, 'STF000403', 'Lecturer', 'teaching', NULL, '2025-02-03', '2026-01-03 04:52:14', '2026-01-03 04:52:14'),
(13, 20, 5, 'STF000501', 'Senior Lecturer', 'teaching', NULL, '2024-09-03', '2026-01-03 04:52:14', '2026-01-03 04:52:14'),
(14, 21, 5, 'STF000502', 'Lecturer', 'teaching', NULL, '2024-06-03', '2026-01-03 04:52:14', '2026-01-03 04:52:14'),
(15, 22, 5, 'STF000503', 'Lecturer', 'teaching', NULL, '2024-10-03', '2026-01-03 04:52:15', '2026-01-03 04:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `students` (`id`, `user_id`, `department_id`, `register_number`, `semester`, `section`, `hosteller`, `parent_name`, `parent_phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 23, 1, 'CSE0001', '7', 'B', 'yes', 'Parent of Student 1', '987654325101', NULL, '2026-01-03 04:52:15', '2026-01-03 04:52:15'),
(2, 24, 1, 'CSE0002', '7', 'C', 'yes', 'Parent of Student 2', '987654325102', NULL, '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(3, 25, 1, 'CSE0003', '7', 'A', 'yes', 'Parent of Student 3', '987654325103', NULL, '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(4, 26, 1, 'CSE0004', '2', 'B', 'yes', 'Parent of Student 4', '987654325104', NULL, '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(5, 27, 1, 'CSE0005', '6', 'C', 'no', 'Parent of Student 5', '987654325105', NULL, '2026-01-03 04:52:17', '2026-01-03 04:52:17'),
(6, 28, 1, 'CSE0006', '5', 'A', 'no', 'Parent of Student 6', '987654325106', NULL, '2026-01-03 04:52:17', '2026-01-03 04:52:17'),
(7, 29, 1, 'CSE0007', '1', 'B', 'no', 'Parent of Student 7', '987654325107', NULL, '2026-01-03 04:52:18', '2026-01-03 04:52:18'),
(8, 30, 1, 'CSE0008', '4', 'C', 'no', 'Parent of Student 8', '987654325108', NULL, '2026-01-03 04:52:18', '2026-01-03 04:52:18'),
(9, 31, 1, 'CSE0009', '2', 'A', 'no', 'Parent of Student 9', '987654325109', NULL, '2026-01-03 04:52:19', '2026-01-03 04:52:19'),
(10, 32, 1, 'CSE0010', '7', 'B', 'no', 'Parent of Student 10', '987654325110', NULL, '2026-01-03 04:52:19', '2026-01-03 04:52:19'),
(11, 33, 2, 'ECE0001', '3', 'B', 'yes', 'Parent of Student 1', '987654325201', NULL, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(12, 34, 2, 'ECE0002', '6', 'C', 'yes', 'Parent of Student 2', '987654325202', NULL, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(13, 35, 2, 'ECE0003', '5', 'A', 'yes', 'Parent of Student 3', '987654325203', NULL, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(14, 36, 2, 'ECE0004', '4', 'B', 'yes', 'Parent of Student 4', '987654325204', NULL, '2026-01-03 04:52:21', '2026-01-03 04:52:21'),
(15, 37, 2, 'ECE0005', '3', 'C', 'no', 'Parent of Student 5', '987654325205', NULL, '2026-01-03 04:52:21', '2026-01-03 04:52:21'),
(16, 38, 2, 'ECE0006', '8', 'A', 'no', 'Parent of Student 6', '987654325206', NULL, '2026-01-03 04:52:22', '2026-01-03 04:52:22'),
(17, 39, 2, 'ECE0007', '5', 'B', 'no', 'Parent of Student 7', '987654325207', NULL, '2026-01-03 04:52:22', '2026-01-03 04:52:22'),
(18, 40, 2, 'ECE0008', '3', 'C', 'no', 'Parent of Student 8', '987654325208', NULL, '2026-01-03 04:52:23', '2026-01-03 04:52:23'),
(19, 41, 2, 'ECE0009', '8', 'A', 'no', 'Parent of Student 9', '987654325209', NULL, '2026-01-03 04:52:23', '2026-01-03 04:52:23'),
(20, 42, 2, 'ECE0010', '6', 'B', 'no', 'Parent of Student 10', '987654325210', NULL, '2026-01-03 04:52:24', '2026-01-03 04:52:24'),
(21, 43, 3, 'MECH0001', '2', 'B', 'yes', 'Parent of Student 1', '987654325301', NULL, '2026-01-03 04:52:24', '2026-01-03 04:52:24'),
(22, 44, 3, 'MECH0002', '3', 'C', 'yes', 'Parent of Student 2', '987654325302', NULL, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(23, 45, 3, 'MECH0003', '1', 'A', 'yes', 'Parent of Student 3', '987654325303', NULL, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(24, 46, 3, 'MECH0004', '8', 'B', 'yes', 'Parent of Student 4', '987654325304', NULL, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(25, 47, 3, 'MECH0005', '6', 'C', 'no', 'Parent of Student 5', '987654325305', NULL, '2026-01-03 04:52:26', '2026-01-03 04:52:26'),
(26, 48, 3, 'MECH0006', '6', 'A', 'no', 'Parent of Student 6', '987654325306', NULL, '2026-01-03 04:52:26', '2026-01-03 04:52:26'),
(27, 49, 3, 'MECH0007', '6', 'B', 'no', 'Parent of Student 7', '987654325307', NULL, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(28, 50, 3, 'MECH0008', '4', 'C', 'no', 'Parent of Student 8', '987654325308', NULL, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(29, 51, 3, 'MECH0009', '7', 'A', 'no', 'Parent of Student 9', '987654325309', NULL, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(30, 52, 3, 'MECH0010', '1', 'B', 'no', 'Parent of Student 10', '987654325310', NULL, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(31, 53, 4, 'CIVIL0001', '7', 'B', 'yes', 'Parent of Student 1', '987654325401', NULL, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(32, 54, 4, 'CIVIL0002', '6', 'C', 'yes', 'Parent of Student 2', '987654325402', NULL, '2026-01-03 04:52:29', '2026-01-03 04:52:29'),
(33, 55, 4, 'CIVIL0003', '4', 'A', 'yes', 'Parent of Student 3', '987654325403', NULL, '2026-01-03 04:52:29', '2026-01-03 04:52:29'),
(34, 56, 4, 'CIVIL0004', '1', 'B', 'yes', 'Parent of Student 4', '987654325404', NULL, '2026-01-03 04:52:30', '2026-01-03 04:52:30'),
(35, 57, 4, 'CIVIL0005', '4', 'C', 'no', 'Parent of Student 5', '987654325405', NULL, '2026-01-03 04:52:30', '2026-01-03 04:52:30'),
(36, 58, 4, 'CIVIL0006', '4', 'A', 'no', 'Parent of Student 6', '987654325406', NULL, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(37, 59, 4, 'CIVIL0007', '6', 'B', 'no', 'Parent of Student 7', '987654325407', NULL, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(38, 60, 4, 'CIVIL0008', '5', 'C', 'no', 'Parent of Student 8', '987654325408', NULL, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(39, 61, 4, 'CIVIL0009', '6', 'A', 'no', 'Parent of Student 9', '987654325409', NULL, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(40, 62, 4, 'CIVIL0010', '1', 'B', 'no', 'Parent of Student 10', '987654325410', NULL, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(41, 63, 5, 'EEE0001', '7', 'B', 'yes', 'Parent of Student 1', '987654325501', NULL, '2026-01-03 04:52:33', '2026-01-03 04:52:33'),
(42, 64, 5, 'EEE0002', '7', 'C', 'yes', 'Parent of Student 2', '987654325502', NULL, '2026-01-03 04:52:33', '2026-01-03 04:52:33'),
(43, 65, 5, 'EEE0003', '6', 'A', 'yes', 'Parent of Student 3', '987654325503', NULL, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(44, 66, 5, 'EEE0004', '6', 'B', 'yes', 'Parent of Student 4', '987654325504', NULL, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(45, 67, 5, 'EEE0005', '7', 'C', 'no', 'Parent of Student 5', '987654325505', NULL, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(46, 68, 5, 'EEE0006', '3', 'A', 'no', 'Parent of Student 6', '987654325506', NULL, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(47, 69, 5, 'EEE0007', '1', 'B', 'no', 'Parent of Student 7', '987654325507', NULL, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(48, 70, 5, 'EEE0008', '3', 'C', 'no', 'Parent of Student 8', '987654325508', NULL, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(49, 71, 5, 'EEE0009', '5', 'A', 'no', 'Parent of Student 9', '987654325509', NULL, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(50, 72, 5, 'EEE0010', '1', 'B', 'no', 'Parent of Student 10', '987654325510', NULL, '2026-01-03 04:52:37', '2026-01-03 04:52:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','staff','hod','warden','admin') NOT NULL DEFAULT 'student',
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `phone`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'System Administrator', 'admin', 'ldharmaprakash2002@gmail.com', NULL, '$2y$12$eN6awLEFhjxgfl4lH951tui1o3GddZgj2T01r00.ouwcbbqLx7uBu', 'admin', '9876543210', 1, 'fliiQ2ScS7GLusMvAIay3tsk3HsEELokc9ys2qonsmedG8PXcTQWmlWwsfgQ', '2026-01-03 04:52:06', '2026-01-03 04:52:06'),
(2, 'Dr. Ramesh Kumar', 'hod_cse', 'hod.cse@college.edu', NULL, '$2y$12$oULHM4HH0Jj.ucqoeDbQkuA2V/hbtb52/40DOEh1zEQSMJ13LXta.', 'hod', '9876543211', 1, NULL, '2026-01-03 04:52:06', '2026-01-03 04:52:06'),
(3, 'Dr. Priya Sharma', 'hod_ece', 'hod.ece@college.edu', NULL, '$2y$12$5uvM7g9uPaIk9vxJ.LAdxunfEbL3MGrLKWWlcwJrPwtnUZFgXARyO', 'hod', '9876543212', 1, NULL, '2026-01-03 04:52:06', '2026-01-03 04:52:06'),
(4, 'Dr. Anand Patel', 'hod_mech', 'hod.mech@college.edu', NULL, '$2y$12$RYKOukcro5kNbJODLEJbhu8LHnXhSCMRej6p9eHZGZplsLL9rDBMe', 'hod', '9876543213', 1, NULL, '2026-01-03 04:52:07', '2026-01-03 04:52:07'),
(5, 'Dr. Sunita Reddy', 'hod_civil', 'hod.civil@college.edu', NULL, '$2y$12$b6ziK61a3nD8ILtXW8UcoemQHhhzxYsC4tmaNy5f4hyuG4yXxOk3C', 'hod', '9876543214', 1, NULL, '2026-01-03 04:52:07', '2026-01-03 04:52:07'),
(6, 'Dr. Vijay Kumar', 'hod_eee', 'hod.eee@college.edu', NULL, '$2y$12$YXDzoHcgSnOpGnO6K.I5eOK9RDTv04FoK153b63nmR9QIJh/YJOwO', 'hod', '9876543215', 1, NULL, '2026-01-03 04:52:08', '2026-01-03 04:52:08'),
(7, 'Dr. Satish Kumar', 'warden_boys', 'warden.boys@college.edu', NULL, '$2y$12$HI17cFiZHDloInmCg54v8.ezjXKkxPNpyCoK.FsL6iM7WVezEPcGG', 'warden', '9876543220', 1, NULL, '2026-01-03 04:52:08', '2026-01-03 04:52:08'),
(8, 'Staff 1 - Computer Science and Engineering', 'staff_cse_1', 'staff.cse.1@college.edu', NULL, '$2y$12$wK8WR0knsTuYoQdxW4NlcOePJaYR2vS1UKEda8MoHQKkanXkBhmZS', 'staff', '98765432311', 1, NULL, '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(9, 'Staff 2 - Computer Science and Engineering', 'staff_cse_2', 'staff.cse.2@college.edu', NULL, '$2y$12$JHBzpfqowqgIDpBj7PJPB.kgB/uI8vjTHFd0JWxMdndCmE7D3j9V2', 'staff', '98765432312', 1, NULL, '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(10, 'Staff 3 - Computer Science and Engineering', 'staff_cse_3', 'staff.cse.3@college.edu', NULL, '$2y$12$qxPNSnCVLNASnWzGrv3z/OjBEssJ9Bm6gZFa1uspdG55NNf0MjI5i', 'staff', '98765432313', 1, NULL, '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(11, 'Staff 1 - Electronics and Communication Engineering', 'staff_ece_1', 'staff.ece.1@college.edu', NULL, '$2y$12$g38iEEhoNswUZBbz1rJZgeMjuov1yn2L7CGGwRIVWJGB1HSsrtjya', 'staff', '98765432321', 1, NULL, '2026-01-03 04:52:10', '2026-01-03 04:52:10'),
(12, 'Staff 2 - Electronics and Communication Engineering', 'staff_ece_2', 'staff.ece.2@college.edu', NULL, '$2y$12$iSxIPLuWaJOZ6s4lroa.KOyLcECmvrUuqcIID1fVVeSugzwbnUTni', 'staff', '98765432322', 1, NULL, '2026-01-03 04:52:10', '2026-01-03 04:52:10'),
(13, 'Staff 3 - Electronics and Communication Engineering', 'staff_ece_3', 'staff.ece.3@college.edu', NULL, '$2y$12$bCbcQxMbsjLEL4KJgSqFPODNiC16eVeW6KV0qMCjvX0mrAKAYkD.i', 'staff', '98765432323', 1, NULL, '2026-01-03 04:52:11', '2026-01-03 04:52:11'),
(14, 'Staff 1 - Mechanical Engineering', 'staff_mech_1', 'staff.mech.1@college.edu', NULL, '$2y$12$aKevI9pmEnLpCWDo37sQMuvMdAPa17wm5sy2gjV1h/LHIjI4UDtxK', 'staff', '98765432331', 1, NULL, '2026-01-03 04:52:11', '2026-01-03 04:52:11'),
(15, 'Staff 2 - Mechanical Engineering', 'staff_mech_2', 'staff.mech.2@college.edu', NULL, '$2y$12$HAqSBplfpP824YxpUen9AeW5AvR/N67PY3041NKNK.aLm2XnwAT6i', 'staff', '98765432332', 1, NULL, '2026-01-03 04:52:12', '2026-01-03 04:52:12'),
(16, 'Staff 3 - Mechanical Engineering', 'staff_mech_3', 'staff.mech.3@college.edu', NULL, '$2y$12$uMxAIJ0IeIbjl16Za7TLOuzg9nxOsuZrFBx/uwGioFZUL6on4luyC', 'staff', '98765432333', 1, NULL, '2026-01-03 04:52:12', '2026-01-03 04:52:12'),
(17, 'Staff 1 - Civil Engineering', 'staff_civil_1', 'staff.civil.1@college.edu', NULL, '$2y$12$MCNwleXKpuz4GeUbrpocie.kkvKGyPAPsAT2ifKegGnEAWfK5DZT2', 'staff', '98765432341', 1, NULL, '2026-01-03 04:52:13', '2026-01-03 04:52:13'),
(18, 'Staff 2 - Civil Engineering', 'staff_civil_2', 'staff.civil.2@college.edu', NULL, '$2y$12$GeQ98jxr.EWBzYrwRvf.7ut4.tNmBI4Sasoq81yzDqm3TipTV1vKq', 'staff', '98765432342', 1, NULL, '2026-01-03 04:52:13', '2026-01-03 04:52:13'),
(19, 'Staff 3 - Civil Engineering', 'staff_civil_3', 'staff.civil.3@college.edu', NULL, '$2y$12$5OePkbXt7LeoW/GuDrNkM.S.nCzFTaygkQNioj/9w7wpD2nbhGJrS', 'staff', '98765432343', 1, NULL, '2026-01-03 04:52:14', '2026-01-03 04:52:14'),
(20, 'Staff 1 - Electrical and Electronics Engineering', 'staff_eee_1', 'staff.eee.1@college.edu', NULL, '$2y$12$Od9I0oXG/uVioN9xXQu4mOSSri8kk1K.xTLgJMCVcG/Ek4oKaolM.', 'staff', '98765432351', 1, NULL, '2026-01-03 04:52:14', '2026-01-03 04:52:14'),
(21, 'Staff 2 - Electrical and Electronics Engineering', 'staff_eee_2', 'staff.eee.2@college.edu', NULL, '$2y$12$OfsZaxCeu4p65oS2Jx8XMOZpq0X.3Bwnp44ph2b47vdhSeJlvMLai', 'staff', '98765432352', 1, NULL, '2026-01-03 04:52:14', '2026-01-03 04:52:14'),
(22, 'Staff 3 - Electrical and Electronics Engineering', 'staff_eee_3', 'staff.eee.3@college.edu', NULL, '$2y$12$GpW/VHW1BZ3fNjDDB.c0dOgm.Ng6oNYKiiwFVAZoUOOQ5NoDg9hU2', 'staff', '98765432353', 1, NULL, '2026-01-03 04:52:15', '2026-01-03 04:52:15'),
(23, 'Student 1 - Computer Science and Engineering', 'student_cse_1', 'student.cse.1@college.edu', NULL, '$2y$12$KSfyP6kkwkGlD6nIIK3ONuEXdTio.Q7Mv1fjZ1vSeI0sT0CzIxbXi', 'student', '987654324101', 1, NULL, '2026-01-03 04:52:15', '2026-01-03 04:52:15'),
(24, 'Student 2 - Computer Science and Engineering', 'student_cse_2', 'student.cse.2@college.edu', NULL, '$2y$12$QZPDL0E/xlBTWI6hdJeZYuXTRXDKDXuXW4zn0CKnRbIjsIwwFtTea', 'student', '987654324102', 1, NULL, '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(25, 'Student 3 - Computer Science and Engineering', 'student_cse_3', 'student.cse.3@college.edu', NULL, '$2y$12$58d/OBgR6ymJNfeLGYrrgeO3/C84QhgAeUZJsroxZumeqe85m/jXa', 'student', '987654324103', 1, NULL, '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(26, 'Student 4 - Computer Science and Engineering', 'student_cse_4', 'student.cse.4@college.edu', NULL, '$2y$12$gaq1/JgVwQpRBVBkaCSZq.l9D9a1qsmixFYCKtMLoUmW3mj3uipCa', 'student', '987654324104', 1, NULL, '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(27, 'Student 5 - Computer Science and Engineering', 'student_cse_5', 'student.cse.5@college.edu', NULL, '$2y$12$PwKJYtn2s23333QUUay30OC9UX7qk6Nn9kD6T4A3KTTlcXW/EgPuq', 'student', '987654324105', 1, NULL, '2026-01-03 04:52:17', '2026-01-03 04:52:17'),
(28, 'Student 6 - Computer Science and Engineering', 'student_cse_6', 'student.cse.6@college.edu', NULL, '$2y$12$qYQOynmIkZOq5rzEHSbpHuzkdvP/zyshniRpMkJRCNQgWw6ri.SMi', 'student', '987654324106', 1, NULL, '2026-01-03 04:52:17', '2026-01-03 04:52:17'),
(29, 'Student 7 - Computer Science and Engineering', 'student_cse_7', 'student.cse.7@college.edu', NULL, '$2y$12$2ZFJrShDsHCuxe0AcYPG4uA4RPGQNG83FPzxui5r2Og.reSTHWchK', 'student', '987654324107', 1, NULL, '2026-01-03 04:52:18', '2026-01-03 04:52:18'),
(30, 'Student 8 - Computer Science and Engineering', 'student_cse_8', 'student.cse.8@college.edu', NULL, '$2y$12$V6Xscz47..43tULBNM8Gje1BeuaM1jGV0TN.NC4C4Y9P9dBGMHQ1m', 'student', '987654324108', 1, NULL, '2026-01-03 04:52:18', '2026-01-03 04:52:18'),
(31, 'Student 9 - Computer Science and Engineering', 'student_cse_9', 'student.cse.9@college.edu', NULL, '$2y$12$lmwbP1l7pmmZWT.2D3al5.gL91V/hK4cqC4naFb7giI00uHi.1nu6', 'student', '987654324109', 1, NULL, '2026-01-03 04:52:19', '2026-01-03 04:52:19'),
(32, 'Student 10 - Computer Science and Engineering', 'student_cse_10', 'student.cse.10@college.edu', NULL, '$2y$12$j0JKG9rALjYOiQwgU.1Ca.Wc25DPTlZ2BCc9Qyne5jMICb/iDTs2y', 'student', '987654324110', 1, NULL, '2026-01-03 04:52:19', '2026-01-03 04:52:19'),
(33, 'Student 1 - Electronics and Communication Engineering', 'student_ece_1', 'student.ece.1@college.edu', NULL, '$2y$12$jrif8/v0yPkMluufz8HusO7qROfTNt1ZvEdknqXOZbTNfyQVprB8i', 'student', '987654324201', 1, NULL, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(34, 'Student 2 - Electronics and Communication Engineering', 'student_ece_2', 'student.ece.2@college.edu', NULL, '$2y$12$BdJXQ39u6LdNh6aKOycNkOLC0vCWZqjgfNHUYc3EuNl5PLVpR9Bq2', 'student', '987654324202', 1, NULL, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(35, 'Student 3 - Electronics and Communication Engineering', 'student_ece_3', 'student.ece.3@college.edu', NULL, '$2y$12$ZYik1saKAJBWu7HYw5Toq.s1dWqr3LjqKWrQb1IiMI5q2ZjOW17lO', 'student', '987654324203', 1, NULL, '2026-01-03 04:52:20', '2026-01-03 04:52:20'),
(36, 'Student 4 - Electronics and Communication Engineering', 'student_ece_4', 'student.ece.4@college.edu', NULL, '$2y$12$GbbU43SyfgyH85OusKC.c.TTPpbueA3DtC985724IBnLvCL1BNr7y', 'student', '987654324204', 1, NULL, '2026-01-03 04:52:21', '2026-01-03 04:52:21'),
(37, 'Student 5 - Electronics and Communication Engineering', 'student_ece_5', 'student.ece.5@college.edu', NULL, '$2y$12$YfRBiBzLXajbINZ22zBqbeIMav1xB9K0K0s5yVBiATibGbD60l/32', 'student', '987654324205', 1, NULL, '2026-01-03 04:52:21', '2026-01-03 04:52:21'),
(38, 'Student 6 - Electronics and Communication Engineering', 'student_ece_6', 'student.ece.6@college.edu', NULL, '$2y$12$Hu.7qExDRt/qzMDD5EZ/gOr0ZH6/8iZXJx6mlsmN9taqzf2ywnL/m', 'student', '987654324206', 1, NULL, '2026-01-03 04:52:22', '2026-01-03 04:52:22'),
(39, 'Student 7 - Electronics and Communication Engineering', 'student_ece_7', 'student.ece.7@college.edu', NULL, '$2y$12$oAB8NeibS4ZHegfHK.nqPeHc9goin6M8fWtb6f2yBz5Ef90Ov0YIC', 'student', '987654324207', 1, NULL, '2026-01-03 04:52:22', '2026-01-03 04:52:22'),
(40, 'Student 8 - Electronics and Communication Engineering', 'student_ece_8', 'student.ece.8@college.edu', NULL, '$2y$12$.wVS67aypJr4Cgn3ECt3O.1MpUpoaOARqeVjTxtrEPhxj9fKn/X2.', 'student', '987654324208', 1, NULL, '2026-01-03 04:52:23', '2026-01-03 04:52:23'),
(41, 'Student 9 - Electronics and Communication Engineering', 'student_ece_9', 'student.ece.9@college.edu', NULL, '$2y$12$Xhf0ZSg7BfaOBHPdjIxKRuehjEokvxyv38gYuKZy2aajLGCWWZMlS', 'student', '987654324209', 1, NULL, '2026-01-03 04:52:23', '2026-01-03 04:52:23'),
(42, 'Student 10 - Electronics and Communication Engineering', 'student_ece_10', 'student.ece.10@college.edu', NULL, '$2y$12$pGhtzi28T.Dhy186RYgUOuaiEpp7LTijO7DF7UO1mTf2eVYCrGLfq', 'student', '987654324210', 1, NULL, '2026-01-03 04:52:24', '2026-01-03 04:52:24'),
(43, 'Student 1 - Mechanical Engineering', 'student_mech_1', 'student.mech.1@college.edu', NULL, '$2y$12$dHVAouy4cGLKPIdJ3OiB7.JW6ML9Sm.koZLXCcj4UNBxerNg7KquK', 'student', '987654324301', 1, NULL, '2026-01-03 04:52:24', '2026-01-03 04:52:24'),
(44, 'Student 2 - Mechanical Engineering', 'student_mech_2', 'student.mech.2@college.edu', NULL, '$2y$12$.jW7RbUupi3hX/ysOAEnmOHrDvTgszxkU.I5Wu8RcO2SOzd./1yjm', 'student', '987654324302', 1, NULL, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(45, 'Student 3 - Mechanical Engineering', 'student_mech_3', 'student.mech.3@college.edu', NULL, '$2y$12$x9szmD8iLxB4L2BC.sbL7OiTHH7pJOiVPfEZTAbCvi4O459BivREW', 'student', '987654324303', 1, NULL, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(46, 'Student 4 - Mechanical Engineering', 'student_mech_4', 'student.mech.4@college.edu', NULL, '$2y$12$/SthRI7COlA9wmVrWl5CgupR7WASMz3Hzmp4ymKOYiA2FoQ7qEy2C', 'student', '987654324304', 1, NULL, '2026-01-03 04:52:25', '2026-01-03 04:52:25'),
(47, 'Student 5 - Mechanical Engineering', 'student_mech_5', 'student.mech.5@college.edu', NULL, '$2y$12$4ayJZ7xx616BD4REgyIZeeuntBAClIBqSc/IkvZ3P4DyfjsZ4Yh.i', 'student', '987654324305', 1, NULL, '2026-01-03 04:52:26', '2026-01-03 04:52:26'),
(48, 'Student 6 - Mechanical Engineering', 'student_mech_6', 'student.mech.6@college.edu', NULL, '$2y$12$NxrOg1FLx9zeovs0EZmlquy95D6dBvunv69Ou/clwaMGqEBCE8cja', 'student', '987654324306', 1, NULL, '2026-01-03 04:52:26', '2026-01-03 04:52:26'),
(49, 'Student 7 - Mechanical Engineering', 'student_mech_7', 'student.mech.7@college.edu', NULL, '$2y$12$xylh9jZ7Jgz.CmqfDkSYGuS/YyCaJJfU/rWkLMX6jTa1UbuDc7FPa', 'student', '987654324307', 1, NULL, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(50, 'Student 8 - Mechanical Engineering', 'student_mech_8', 'student.mech.8@college.edu', NULL, '$2y$12$y.umBlaSgtWgbc0RhB9TKur37UGMnEstnQpTZAWfr56NY2Ttmdvfy', 'student', '987654324308', 1, NULL, '2026-01-03 04:52:27', '2026-01-03 04:52:27'),
(51, 'Student 9 - Mechanical Engineering', 'student_mech_9', 'student.mech.9@college.edu', NULL, '$2y$12$ijF/cSIG60KEA8hrDYpgTOV34yJQMDs6VNauhMKslsn4ZZPZR2vyW', 'student', '987654324309', 1, NULL, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(52, 'Student 10 - Mechanical Engineering', 'student_mech_10', 'student.mech.10@college.edu', NULL, '$2y$12$TGLqhLBq3iY.g4XuUVKBH.jTnrquEp2hmnNMKeR91DQzcmfGyppHO', 'student', '987654324310', 1, NULL, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(53, 'Student 1 - Civil Engineering', 'student_civil_1', 'student.civil.1@college.edu', NULL, '$2y$12$MAr7OsBnqxujzU6yqyLVxuS/b2ucPWVtaNPvNBRDvK0UUco24tnjW', 'student', '987654324401', 1, NULL, '2026-01-03 04:52:28', '2026-01-03 04:52:28'),
(54, 'Student 2 - Civil Engineering', 'student_civil_2', 'student.civil.2@college.edu', NULL, '$2y$12$29MndgvAd7mSGGwt4iiPkuKeYJcCbVcpjdiQBTUJ6Os2bSc2/sbf.', 'student', '987654324402', 1, NULL, '2026-01-03 04:52:29', '2026-01-03 04:52:29'),
(55, 'Student 3 - Civil Engineering', 'student_civil_3', 'student.civil.3@college.edu', NULL, '$2y$12$hYyxM4rAgR3TTeUhKsk85eYYEpyk6hEk6G8pkRn1oe3JLBjga2O/q', 'student', '987654324403', 1, NULL, '2026-01-03 04:52:29', '2026-01-03 04:52:29'),
(56, 'Student 4 - Civil Engineering', 'student_civil_4', 'student.civil.4@college.edu', NULL, '$2y$12$JziACtgxfrD4MzRWlzyUw.BiNLumtjRZcikgrqO8I8W.vQwH0vk3q', 'student', '987654324404', 1, NULL, '2026-01-03 04:52:30', '2026-01-03 04:52:30'),
(57, 'Student 5 - Civil Engineering', 'student_civil_5', 'student.civil.5@college.edu', NULL, '$2y$12$p5zFj3nRVBaDD7JajZ01DurnPfUoqLIkzI4LGLt/KVgG5myjeX6aO', 'student', '987654324405', 1, NULL, '2026-01-03 04:52:30', '2026-01-03 04:52:30'),
(58, 'Student 6 - Civil Engineering', 'student_civil_6', 'student.civil.6@college.edu', NULL, '$2y$12$ckEaT/ImVy9OEiC87nfSO.kkml.Y2DLmebNqyovh080vzyd.DPz52', 'student', '987654324406', 1, NULL, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(59, 'Student 7 - Civil Engineering', 'student_civil_7', 'student.civil.7@college.edu', NULL, '$2y$12$vlkGDyiuM8Cb0Ly/ozOhMe2OnuNFi7gLYwSgV/R1PbHQI6Qj1fI5S', 'student', '987654324407', 1, NULL, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(60, 'Student 8 - Civil Engineering', 'student_civil_8', 'student.civil.8@college.edu', NULL, '$2y$12$DSILPnWeGrloTk2wxC.y.ebLmGMhmX.2z6kr.HWYxE3DF/foGOgPK', 'student', '987654324408', 1, NULL, '2026-01-03 04:52:31', '2026-01-03 04:52:31'),
(61, 'Student 9 - Civil Engineering', 'student_civil_9', 'student.civil.9@college.edu', NULL, '$2y$12$ooC1746NDirBPX5O2djmKe5IqEtAfSRfAUBH7TPKVrnNA9WVHFneS', 'student', '987654324409', 1, NULL, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(62, 'Student 10 - Civil Engineering', 'student_civil_10', 'student.civil.10@college.edu', NULL, '$2y$12$N0pY0bbhqJY9lugOUFRNwuZqsFyOeVuiKbYhKW7lBAY6VP9bZZoVG', 'student', '987654324410', 1, NULL, '2026-01-03 04:52:32', '2026-01-03 04:52:32'),
(63, 'Student 1 - Electrical and Electronics Engineering', 'student_eee_1', 'student.eee.1@college.edu', NULL, '$2y$12$whu7G6VI/on6Np1gD6l0pe9N5BHtJxdhJz/D5P1X0EB1SljUV6zl.', 'student', '987654324501', 1, NULL, '2026-01-03 04:52:33', '2026-01-03 04:52:33'),
(64, 'Student 2 - Electrical and Electronics Engineering', 'student_eee_2', 'student.eee.2@college.edu', NULL, '$2y$12$cyMwW0D/FLsJTGXXtoC5sOcTA6rpfvYyRnC4zEHAzO5iBZddrneDW', 'student', '987654324502', 1, NULL, '2026-01-03 04:52:33', '2026-01-03 04:52:33'),
(65, 'Student 3 - Electrical and Electronics Engineering', 'student_eee_3', 'student.eee.3@college.edu', NULL, '$2y$12$vR7fVLjrfvqzIHVQWnM0m.ufWgR.wf8yrb2brnM3awC35YHJxhGm.', 'student', '987654324503', 1, NULL, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(66, 'Student 4 - Electrical and Electronics Engineering', 'student_eee_4', 'student.eee.4@college.edu', NULL, '$2y$12$i9y7joQYacUlyqQ8BQJHEugosMyscUTHgLiQGtxV4Lf1bQh1/Q60G', 'student', '987654324504', 1, NULL, '2026-01-03 04:52:34', '2026-01-03 04:52:34'),
(67, 'Student 5 - Electrical and Electronics Engineering', 'student_eee_5', 'student.eee.5@college.edu', NULL, '$2y$12$6LPWStL9SeAXznn1afYP3uahZTZx0lMAM.n1PAkuRMvpxsOTJqD0S', 'student', '987654324505', 1, NULL, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(68, 'Student 6 - Electrical and Electronics Engineering', 'student_eee_6', 'student.eee.6@college.edu', NULL, '$2y$12$lbiHC5oZ2x6KeRMmpi3Xj.RU71F0uJO6E8.yeSQwwRt6f32HRP4MK', 'student', '987654324506', 1, NULL, '2026-01-03 04:52:35', '2026-01-03 04:52:35'),
(69, 'Student 7 - Electrical and Electronics Engineering', 'student_eee_7', 'student.eee.7@college.edu', NULL, '$2y$12$Y3G6mQAoQJV8pE0XaU/b3eFq6cz3KCN9pYQQp1ZEV0zWBtwmekoDK', 'student', '987654324507', 1, NULL, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(70, 'Student 8 - Electrical and Electronics Engineering', 'student_eee_8', 'student.eee.8@college.edu', NULL, '$2y$12$9la0imigQQi/PEw1ssPtBubQlmbKVeiBAt2ZChd0RSSuxpnQYhTLq', 'student', '987654324508', 1, NULL, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(71, 'Student 9 - Electrical and Electronics Engineering', 'student_eee_9', 'student.eee.9@college.edu', NULL, '$2y$12$AJU2Fnje.tQmeqv00d0K5O6JO2rvj6KjHXRx7qD9W32NEsifXMJcS', 'student', '987654324509', 1, NULL, '2026-01-03 04:52:36', '2026-01-03 04:52:36'),
(72, 'Student 10 - Electrical and Electronics Engineering', 'student_eee_10', 'student.eee.10@college.edu', NULL, '$2y$12$7fKBHVzVory5kL97HNabu.3l8rkVQtARgnhtU3Y90UkiObIFQxVg2', 'student', '987654324510', 1, NULL, '2026-01-03 04:52:37', '2026-01-03 04:52:37');

-- --------------------------------------------------------

--
-- Table structure for table `wardens`
--

CREATE TABLE `wardens` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `wardens` (`id`, `user_id`, `employee_id`, `hostel_type`, `qualifications`, `appointment_date`, `created_at`, `updated_at`) VALUES
(1, 7, 'WRD0001', 'boys', NULL, '2025-01-03', '2026-01-03 04:52:08', '2026-01-03 04:52:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`);

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
  ADD KEY `gatepasses_warden_approved_by_foreign` (`warden_approved_by`);

--
-- Indexes for table `hods`
--
ALTER TABLE `hods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hods_employee_id_unique` (`employee_id`),
  ADD KEY `hods_user_id_foreign` (`user_id`),
  ADD KEY `hods_department_id_foreign` (`department_id`);

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
  ADD KEY `staff_department_id_foreign` (`department_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_register_number_unique` (`register_number`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_department_id_foreign` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `wardens`
--
ALTER TABLE `wardens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wardens_employee_id_unique` (`employee_id`),
  ADD KEY `wardens_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gatepasses`
--
ALTER TABLE `gatepasses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `hods`
--
ALTER TABLE `hods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `wardens`
--
ALTER TABLE `wardens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gatepasses`
--
ALTER TABLE `gatepasses`
  ADD CONSTRAINT `gatepasses_hod_approved_by_foreign` FOREIGN KEY (`hod_approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gatepasses_staff_approved_by_foreign` FOREIGN KEY (`staff_approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gatepasses_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gatepasses_warden_approved_by_foreign` FOREIGN KEY (`warden_approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `hods`
--
ALTER TABLE `hods`
  ADD CONSTRAINT `hods_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wardens`
--
ALTER TABLE `wardens`
  ADD CONSTRAINT `wardens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
