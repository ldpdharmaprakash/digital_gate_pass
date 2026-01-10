-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2026 at 03:00 PM
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
-- Database: `womens_college_gatepass`
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
(1, 'English Literature', 'ENG', 'Department of English', 'Dr. Sarah Thomas', 1, '2026-01-03 04:52:05', '2026-01-03 04:52:05'),
(2, 'Commerce', 'COM', 'Department of Commerce', 'Dr. Lakshmi Iyer', 1, '2026-01-03 04:52:05', '2026-01-03 04:52:05'),
(3, 'Psychology', 'PSY', 'Department of Psychology', 'Dr. Meera Nambiar', 1, '2026-01-03 04:52:05', '2026-01-03 04:52:05'),
(4, 'Computer Science', 'CS', 'Department of Computer Science', 'Dr. Kavitha Rajan', 1, '2026-01-03 04:52:05', '2026-01-03 04:52:05'),
(5, 'Mathematics', 'MATH', 'Department of Mathematics', 'Dr. Anjali Gupta', 1, '2026-01-03 04:52:05', '2026-01-03 04:52:05'),
(6, 'Visual Communication', 'VISCOM', 'Department of Visual Communication', 'Dr. Renuka Menon', 1, '2026-01-03 04:52:05', '2026-01-03 04:52:05');

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
(1, 1, '2025-12-11', '10:30:00', '16:00:00', 'Seminar Participation', 'final_approved', NULL, NULL, NULL, '2025-12-11 06:52:15', '2025-12-11 09:52:15', '2025-12-11 11:52:15', '2025-12-11 11:52:15', 8, 2, 7, 'GP-ART-6958E', 1, '2026-01-03 04:52:15', '2026-01-03 04:52:15'),
(2, 2, '2025-12-25', '09:00:00', '18:00:00', 'Medical Checkup', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-01-03 04:52:15', '2026-01-04 03:52:36'),
(3, 3, '2025-12-15', '14:00:00', '18:00:00', 'Library Visit', 'staff_rejected', 'Complete assignment first', NULL, NULL, '2025-12-15 07:52:15', NULL, NULL, NULL, 8, NULL, NULL, NULL, 1, '2026-01-03 04:52:15', '2026-01-03 04:52:15'),
(4, 4, '2025-12-20', '10:00:00', '17:00:00', 'Family Function', 'final_approved', NULL, NULL, NULL, '2025-12-20 05:52:15', '2025-12-20 09:57:55', '2025-12-20 11:52:42', '2025-12-20 11:52:42', 10, 2, 7, 'GP-ART-695A3', 1, '2026-01-03 04:52:15', '2026-01-04 03:52:42');


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
(1, 2, 1, 'HOD_ENG_01', 'Ph.D. in English Lit', '2023-06-01', '2026-01-03 04:52:06', '2026-01-03 04:52:06'),
(2, 3, 2, 'HOD_COM_01', 'Ph.D. in Commerce', '2023-06-01', '2026-01-03 04:52:06', '2026-01-03 04:52:06'),
(3, 4, 3, 'HOD_PSY_01', 'Ph.D. in Psychology', '2023-06-01', '2026-01-03 04:52:07', '2026-01-03 04:52:07'),
(4, 5, 4, 'HOD_CS_01', 'Ph.D. in Computer Science', '2024-01-15', '2026-01-03 04:52:07', '2026-01-03 04:52:07');

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
(1, 8, 1, 'STF_ENG_01', 'Assistant Professor', 'teaching', 'MA English', '2024-06-15', '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(2, 9, 2, 'STF_COM_01', 'Associate Professor', 'teaching', 'M.Com, PhD', '2023-08-01', '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(3, 10, 3, 'STF_PSY_01', 'Assistant Professor', 'teaching', 'M.Sc Psychology', '2024-01-20', '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(4, 11, 4, 'STF_CS_01', 'Lab Instructor', 'non_teaching', 'B.Sc CS', '2024-03-10', '2026-01-03 04:52:10', '2026-01-03 04:52:10');


-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `register_number` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL COMMENT '1st, 2nd, 3rd Year',
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

INSERT INTO `students` (`id`, `user_id`, `department_id`, `register_number`, `year`, `section`, `hosteller`, `parent_name`, `parent_phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 12, 1, 'BA_ENG_001', '3rd', 'A', 'yes', 'Mrs. Devi', '9876543201', '123 Garden St', '2026-01-03 04:52:15', '2026-01-03 04:52:15'),
(2, 13, 2, 'BCOM_001', '2nd', 'B', 'yes', 'Mrs. Kamala', '9876543202', '456 River Rd', '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(3, 14, 3, 'BSC_PSY_001', '1st', 'A', 'no', 'Mr. Ravi', '9876543203', '789 Lake View', '2026-01-03 04:52:16', '2026-01-03 04:52:16'),
(4, 15, 4, 'BSC_CS_001', '3rd', 'C', 'yes', 'Mrs. Geetha', '9876543204', '321 Hill Top', '2026-01-03 04:52:16', '2026-01-03 04:52:16');


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
  `institute_id` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `institute_id`, `phone`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 'admin@womenscollege.edu', NULL, '$2y$12$eN6awLEFhjxgfl4lH951tui1o3GddZgj2T01r00.ouwcbbqLx7uBu', 'admin', 1, '9999999999', 1, NULL, '2026-01-03 04:52:06', '2026-01-03 04:52:06'),
(2, 'Dr. Sarah Thomas', 'hod_eng', 'hod.english@womenscollege.edu', NULL, '$2y$12$hash...', 'hod', 1, '9876543101', 1, NULL, '2026-01-03 04:52:06', '2026-01-03 04:52:06'),
(3, 'Dr. Lakshmi Iyer', 'hod_com', 'hod.commerce@womenscollege.edu', NULL, '$2y$12$hash...', 'hod', 1, '9876543102', 1, NULL, '2026-01-03 04:52:06', '2026-01-03 04:52:06'),
(4, 'Dr. Meera Nambiar', 'hod_psy', 'hod.psychology@womenscollege.edu', NULL, '$2y$12$hash...', 'hod', 1, '9876543103', 1, NULL, '2026-01-03 04:52:07', '2026-01-03 04:52:07'),
(5, 'Dr. Kavitha Rajan', 'hod_cs', 'hod.cs@womenscollege.edu', NULL, '$2y$12$hash...', 'hod', 1, '9876543104', 1, NULL, '2026-01-03 04:52:07', '2026-01-03 04:52:07'),
(7, 'Ms. Stella Mary', 'warden_main', 'warden@womenscollege.edu', NULL, '$2y$12$hash...', 'warden', 1, '9876543105', 1, NULL, '2026-01-03 04:52:08', '2026-01-03 04:52:08'),
(8, 'Ms. Anitha K', 'staff_eng_01', 'anitha.eng@womenscollege.edu', NULL, '$2y$12$hash...', 'staff', 1, '9876543106', 1, NULL, '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(9, 'Ms. Beena S', 'staff_com_01', 'beena.com@womenscollege.edu', NULL, '$2y$12$hash...', 'staff', 1, '9876543107', 1, NULL, '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(10, 'Ms. Charu L', 'staff_psy_01', 'charu.psy@womenscollege.edu', NULL, '$2y$12$hash...', 'staff', 1, '9876543108', 1, NULL, '2026-01-03 04:52:09', '2026-01-03 04:52:09'),
(11, 'Ms. Divya R', 'staff_cs_01', 'divya.cs@womenscollege.edu', NULL, '$2y$12$hash...', 'staff', 1, '9876543109', 1, NULL, '2026-01-03 04:52:10', '2026-01-03 04:52:10'),
(12, 'Student One', 'stu_eng_01', 's1.eng@womenscollege.edu', NULL, '$2y$12$hash...', 'student', 1, '9876543110', 1, NULL, '2026-01-03 04:52:15', '2026-01-03 04:52:15'),
(13, 'Student Two', 'stu_com_01', 's2.com@womenscollege.edu', NULL, '$2y$12$hash...', 'student', 1, '9876543111', 1, NULL, '2026-01-03 04:52:15', '2026-01-03 04:52:15'),
(14, 'Student Three', 'stu_psy_01', 's3.psy@womenscollege.edu', NULL, '$2y$12$hash...', 'student', 1, '9876543112', 1, NULL, '2026-01-03 04:52:15', '2026-01-03 04:52:15'),
(15, 'Student Four', 'stu_cs_01', 's4.cs@womenscollege.edu', NULL, '$2y$12$hash...', 'student', 1, '9876543113', 1, NULL, '2026-01-03 04:52:15', '2026-01-03 04:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `wardens`
--

CREATE TABLE `wardens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `hostel_type` enum('girls') NOT NULL DEFAULT 'girls',
  `qualifications` text DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wardens`
--

INSERT INTO `wardens` (`id`, `user_id`, `employee_id`, `hostel_type`, `qualifications`, `appointment_date`, `created_at`, `updated_at`) VALUES
(1, 7, 'WRD_MAIN_01', 'girls', 'M.A. Sociology', '2022-05-10', '2026-01-03 04:52:08', '2026-01-03 04:52:08');

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
-- AUTO_INCREMENT for table `gatepasses`
--
ALTER TABLE `gatepasses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hods`
--
ALTER TABLE `hods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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