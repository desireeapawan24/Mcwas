-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2025 at 01:47 PM
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
-- Database: `db_laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disconnection_requests`
--

CREATE TABLE `disconnection_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `assigned_plumber_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','assigned','completed','cancelled') NOT NULL DEFAULT 'pending',
  `due_since` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meter_readings`
--

CREATE TABLE `meter_readings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `plumber_id` bigint(20) UNSIGNED NOT NULL,
  `reading_date` date NOT NULL,
  `previous_reading` decimal(12,4) NOT NULL,
  `present_reading` decimal(12,4) NOT NULL,
  `used_cubic_meters` decimal(12,4) NOT NULL,
  `period` enum('mid','end') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meter_readings`
--

INSERT INTO `meter_readings` (`id`, `customer_id`, `plumber_id`, `reading_date`, `previous_reading`, `present_reading`, `used_cubic_meters`, `period`, `created_at`, `updated_at`) VALUES
(1, 7, 10, '2025-09-29', 0.0000, 19.9530, 19.9530, 'mid', '2025-09-29 01:13:15', '2025-09-29 01:13:15');

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
(4, '2025_08_15_132954_add_portal_and_approved_to_users_table', 2),
(5, '2025_08_15_152552_add_portal_and_approved_to_users_table', 3),
(16, '0001_01_01_000000_create_users_table', 4),
(17, '0001_01_01_000001_create_cache_table', 4),
(18, '0001_01_01_000002_create_jobs_table', 4),
(19, '0001_01_01_000003_create_water_rates_table', 4),
(20, '0001_01_01_000004_create_water_connections_table', 4),
(21, '0001_01_01_000005_create_water_bills_table', 4),
(22, '0001_01_01_000006_create_payments_table', 4),
(23, '0001_01_01_000007_create_setup_requests_table', 4),
(24, '2025_09_04_000001_add_plain_password_to_users_table', 4),
(25, '2025_09_04_000002_create_meter_readings_table', 4),
(26, '2025_09_04_000003_add_late_fee_to_water_bills', 4),
(27, '2025_09_04_000004_create_disconnection_requests_table', 4),
(28, '2025_09_28_114514_add_customer_number_to_users_table', 5),
(29, '2025_09_28_115417_create_notifications_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('f2614e03-0db7-4f84-b777-689375365ef5', 'App\\Notifications\\PlumberAssignedNotification', 'App\\Models\\User', 5, '{\"type\":\"plumber_assigned\",\"customer_id\":6,\"customer_name\":\"Test Customer\",\"customer_number\":\"2025-0003\",\"customer_address\":\"Customer Address, Test City\",\"customer_phone\":\"0987654321\",\"customer_email\":\"testcustomer2@example.com\",\"message\":\"You have been assigned to customer Test Customer (#2025-0003) for water connection setup.\",\"action_url\":\"\\/plumber\\/dashboard\"}', NULL, '2025-09-28 03:56:10', '2025-09-28 03:56:10');

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
('as@gmail.com', '$2y$12$0cx/aZ.8.v6qqV4i74SSHODNktlyj8U0i9eFRHi.D7yZWfk5JAFUK', '2025-09-29 00:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `water_bill_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `accountant_id` bigint(20) UNSIGNED NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('NjWwjPtzhRfi0l9TK4bppAeMEQFh1V0t9jxvZbFn', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM1BEbU85dHV6QjhuM2phQ0hpS3dzeWVPajJVSWxncUhqcjRRaExWZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wbHVtYmVyL2N1c3RvbWVyLWhpc3RvcnkiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDt9', 1759230043),
('ydssJPZMT1TqRBsIZOh1aheHt4LXHLYcOnL9e8Mj', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRHpUQXZ2VWd4TFF3WnJPSlpqdlZJWWRvM25TM253Wjl4bHc0dEtmZiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1759233945);

-- --------------------------------------------------------

--
-- Table structure for table `setup_requests`
--

CREATE TABLE `setup_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setup_requests`
--

INSERT INTO `setup_requests` (`id`, `customer_id`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 7, 'approved', 'Customer requested water setup', '2025-09-29 00:26:53', '2025-09-29 01:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_number` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `plain_password` varchar(255) DEFAULT NULL,
  `role` enum('admin','plumber','accountant','customer') NOT NULL,
  `age` int(11) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `national_id` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` enum('pending','active','inactive') NOT NULL DEFAULT 'pending',
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `customer_number`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `plain_password`, `role`, `age`, `phone_number`, `photo`, `national_id`, `address`, `status`, `is_available`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, '2025-0001', 'Admin', 'User', 'macwas@gmail.com', NULL, '$2y$12$DteaXhwF.aSgZUzWCHrpBep4hZ/CiOF6s3W16D/N89zPEbL9B69f2', NULL, 'admin', 18, 'N/A', NULL, 'ADMIN-68d920db583b6', 'N/A', 'active', 1, NULL, '2025-09-28 03:49:47', '2025-09-28 03:49:47'),
(7, '2025-0002', 'annial', 'ss', 'as@gmail.com', NULL, '$2y$12$auu6zvRJG6oJFMrEspGjU.ZxZKQngE0IoCDsvkYodSVCKXTBfgdmS', NULL, 'customer', 32, '09638223912', NULL, 'AUTO-68d922a70ae19', 'mancilang, madridejos, cebu', 'active', 0, NULL, '2025-09-28 03:57:27', '2025-09-28 03:57:27'),
(10, '2025-0003', 'Web', 'cam', 'pp@gmail.com', NULL, '$2y$12$Qv3YYUqhm4I31U3LQQI9A.xJLbf/5tAzih4EFtjIBn3itjLSzNyQm', NULL, 'plumber', 43, '45424352', 'user-photos/pia4XQSAE5GovnkPjwptJYDbtzqdBFbUY5oKfU6F.png', '7876856342', 'mancilang, madridejos, cebu', 'active', 1, NULL, '2025-09-28 23:32:51', '2025-09-29 01:09:11'),
(11, '2025-0004', 'AA', 'AA', 'aa@gmail.com', NULL, '$2y$12$7LKslBzfp1H9Sc7QbO2CuOtYe4lQ.0CKIm8amSpdW7ep/cX0OCPm6', NULL, 'accountant', 46, '45424352', 'user-photos/V0PdlxzLVyFxxAAhwJmmLRiEUH43QxcbBp1Yrb5T.png', 'fdgfsd', 'mancilang, madridejos, cebu', 'active', 0, NULL, '2025-09-28 23:35:18', '2025-09-28 23:35:42');

-- --------------------------------------------------------

--
-- Table structure for table `water_bills`
--

CREATE TABLE `water_bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `accountant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cubic_meters_used` decimal(10,2) NOT NULL,
  `rate_per_cubic_meter` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(10,2) NOT NULL,
  `late_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `late_fee_applied` tinyint(1) NOT NULL DEFAULT 0,
  `billing_month` date NOT NULL,
  `due_date` date NOT NULL,
  `paid_date` date DEFAULT NULL,
  `status` enum('unpaid','partially_paid','paid') NOT NULL DEFAULT 'unpaid',
  `payment_receipt` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `water_bills`
--

INSERT INTO `water_bills` (`id`, `customer_id`, `accountant_id`, `cubic_meters_used`, `rate_per_cubic_meter`, `total_amount`, `amount_paid`, `balance`, `late_fee`, `late_fee_applied`, `billing_month`, `due_date`, `paid_date`, `status`, `payment_receipt`, `created_at`, `updated_at`) VALUES
(1, 7, NULL, 19.95, 5.33, 213.08, 0.00, 213.08, 0.00, 0, '2025-09-01', '2025-10-01', NULL, 'unpaid', NULL, '2025-09-29 01:09:11', '2025-09-29 01:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `water_connections`
--

CREATE TABLE `water_connections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `plumber_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `connection_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `water_connections`
--

INSERT INTO `water_connections` (`id`, `customer_id`, `plumber_id`, `status`, `connection_date`, `completion_date`, `notes`, `created_at`, `updated_at`) VALUES
(2, 7, 10, 'completed', '2025-09-29', '2025-09-29', NULL, '2025-09-29 00:40:04', '2025-09-29 01:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `water_rates`
--

CREATE TABLE `water_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rate_per_cubic_meter` decimal(10,2) NOT NULL,
  `effective_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `disconnection_requests`
--
ALTER TABLE `disconnection_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disconnection_requests_customer_id_foreign` (`customer_id`),
  ADD KEY `disconnection_requests_requested_by_foreign` (`requested_by`),
  ADD KEY `disconnection_requests_assigned_plumber_id_foreign` (`assigned_plumber_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meter_readings`
--
ALTER TABLE `meter_readings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meter_readings_customer_id_foreign` (`customer_id`),
  ADD KEY `meter_readings_plumber_id_foreign` (`plumber_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_water_bill_id_foreign` (`water_bill_id`),
  ADD KEY `payments_customer_id_foreign` (`customer_id`),
  ADD KEY `payments_accountant_id_foreign` (`accountant_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `setup_requests`
--
ALTER TABLE `setup_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setup_requests_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_national_id_unique` (`national_id`),
  ADD UNIQUE KEY `users_customer_number_unique` (`customer_number`);

--
-- Indexes for table `water_bills`
--
ALTER TABLE `water_bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `water_bills_customer_id_foreign` (`customer_id`),
  ADD KEY `water_bills_accountant_id_foreign` (`accountant_id`);

--
-- Indexes for table `water_connections`
--
ALTER TABLE `water_connections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `water_connections_customer_id_foreign` (`customer_id`),
  ADD KEY `water_connections_plumber_id_foreign` (`plumber_id`);

--
-- Indexes for table `water_rates`
--
ALTER TABLE `water_rates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disconnection_requests`
--
ALTER TABLE `disconnection_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meter_readings`
--
ALTER TABLE `meter_readings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setup_requests`
--
ALTER TABLE `setup_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `water_bills`
--
ALTER TABLE `water_bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `water_connections`
--
ALTER TABLE `water_connections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `water_rates`
--
ALTER TABLE `water_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disconnection_requests`
--
ALTER TABLE `disconnection_requests`
  ADD CONSTRAINT `disconnection_requests_assigned_plumber_id_foreign` FOREIGN KEY (`assigned_plumber_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `disconnection_requests_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disconnection_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meter_readings`
--
ALTER TABLE `meter_readings`
  ADD CONSTRAINT `meter_readings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meter_readings_plumber_id_foreign` FOREIGN KEY (`plumber_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_water_bill_id_foreign` FOREIGN KEY (`water_bill_id`) REFERENCES `water_bills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `setup_requests`
--
ALTER TABLE `setup_requests`
  ADD CONSTRAINT `setup_requests_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `water_bills`
--
ALTER TABLE `water_bills`
  ADD CONSTRAINT `water_bills_accountant_id_foreign` FOREIGN KEY (`accountant_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `water_bills_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `water_connections`
--
ALTER TABLE `water_connections`
  ADD CONSTRAINT `water_connections_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `water_connections_plumber_id_foreign` FOREIGN KEY (`plumber_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
