-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2023 at 11:27 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myinventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_id` bigint(20) UNSIGNED NOT NULL,
  `carton_quantity` int(11) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `address`, `phone_number`, `email`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Ping', '21 Stret 2012 AA', '01822913131', 'ping@ping.com', 4, '2023-04-03 22:44:03', '2023-04-03 22:44:03'),
(2, 'MyCompany', 'Toto 431 Jess y123', '0192813123', 'mycompany@company.com', 5, '2023-04-03 22:55:18', '2023-04-03 22:55:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_02_15_053453_create_bookcategories_table', 1),
(7, '2023_03_15_082513_create_products_table', 2),
(8, '2023_03_31_034842_create_companies_table', 3),
(9, '2023_03_31_035708_create_companies_table', 4),
(10, '2023_04_13_034048_create_orders_table', 5),
(11, '2023_04_18_074732_create_pickers_table', 6),
(12, '2023_05_08_021306_create_weights_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rack_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `rack_id`, `quantity`, `created_at`, `updated_at`) VALUES
(89, 3, 85, 1, 10, '2023-05-16 18:08:45', '2023-05-16 18:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pickers`
--

CREATE TABLE `pickers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rack_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pickers`
--

INSERT INTO `pickers` (`id`, `user_id`, `product_id`, `rack_id`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(70, 3, 85, 1, 10, 'Packing', '2023-05-16 18:07:02', '2023-05-16 18:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rack_id` bigint(20) UNSIGNED NOT NULL,
  `product_desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_image.jpg',
  `item_per_carton` int(11) NOT NULL,
  `carton_quantity` int(11) NOT NULL,
  `weight_per_item` decimal(10,2) NOT NULL,
  `weight_per_carton` decimal(10,2) NOT NULL,
  `product_dimensions` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_to_be_stored` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `company_id`, `product_name`, `rack_id`, `product_desc`, `product_image`, `item_per_carton`, `carton_quantity`, `weight_per_item`, `weight_per_carton`, `product_dimensions`, `date_to_be_stored`, `created_at`, `updated_at`) VALUES
(83, 5, 2, 'iPhone 13', 2, 'lol', '202305160300.jpg', 2, 2, 10.00, 20.00, '40x50x10', '2023-05-17', '2023-05-15 19:00:01', '2023-05-15 19:00:01'),
(85, 4, 1, 'Zen Hybrid', 1, 'Headphone', '202305160824.jpg', 15, 10, 1.00, 15.00, '10x10x10', '2023-05-19', '2023-05-16 00:24:18', '2023-05-16 00:24:18');

-- --------------------------------------------------------

--
-- Table structure for table `quantities`
--

CREATE TABLE `quantities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `sold_carton_quantity` int(11) NOT NULL,
  `sold_item_quantity` int(11) NOT NULL,
  `remaining_quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quantities`
--

INSERT INTO `quantities` (`id`, `product_id`, `total_quantity`, `sold_carton_quantity`, `sold_item_quantity`, `remaining_quantity`, `created_at`, `updated_at`) VALUES
(47, 83, 4, 0, 0, 4, '2023-05-15 19:00:01', '2023-05-15 19:00:01'),
(49, 85, 150, 0, 10, 140, '2023-05-16 00:24:18', '2023-05-16 18:07:02');

-- --------------------------------------------------------

--
-- Table structure for table `rack_locations`
--

CREATE TABLE `rack_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `occupied` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rack_locations`
--

INSERT INTO `rack_locations` (`id`, `location_code`, `capacity`, `occupied`, `created_at`, `updated_at`) VALUES
(1, 'A-1-L1', 200, 140.00, NULL, '2023-05-16 18:07:02'),
(2, 'A-1-L2', 200, 40.00, NULL, '2023-05-15 18:58:19'),
(3, 'A-1-L3', 200, 0.00, NULL, NULL),
(4, 'A-2-L1', 200, 0.00, NULL, '2023-05-05 00:07:45'),
(5, 'A-2-L2', 200, 0.00, NULL, NULL),
(6, 'A-2-L3', 200, 0.00, NULL, '2023-05-05 00:48:42'),
(7, 'A-3-L1', 200, 0.00, NULL, NULL),
(8, 'A-3-L2', 200, 0.00, NULL, '2023-05-09 23:29:28'),
(9, 'A-3-L3', 200, 0.00, NULL, NULL),
(10, 'A-4-L1', 200, 0.00, NULL, NULL),
(11, 'A-4-L2', 200, 0.00, NULL, NULL),
(12, 'A-4-L3', 200, 0.00, NULL, NULL),
(13, 'B-1-L1', 200, 0.00, NULL, NULL),
(14, 'B-1-L2', 200, 0.00, NULL, NULL),
(15, 'B-1-L3', 200, 0.00, NULL, NULL),
(16, 'B-2-L1', 200, 0.00, NULL, NULL),
(17, 'B-2-L2', 200, 0.00, NULL, NULL),
(18, 'B-2-L3', 200, 0.00, NULL, NULL),
(19, 'B-3-L1', 200, 0.00, NULL, NULL),
(20, 'B-3-L2', 200, 0.00, NULL, NULL),
(21, 'B-3-L3', 200, 0.00, NULL, NULL),
(22, 'B-4-L1', 200, 0.00, NULL, NULL),
(23, 'B-4-L2', 200, 0.00, NULL, NULL),
(24, 'B-4-L3', 200, 0.00, NULL, NULL),
(25, 'C-1-L1', 200, 0.00, NULL, NULL),
(26, 'C-1-L2', 200, 0.00, NULL, NULL),
(27, 'C-1-L3', 200, 0.00, NULL, NULL),
(28, 'C-2-L1', 200, 0.00, NULL, NULL),
(29, 'C-2-L2', 200, 0.00, NULL, NULL),
(30, 'C-2-L3', 200, 0.00, NULL, NULL),
(31, 'C-3-L1', 200, 0.00, NULL, NULL),
(32, 'C-3-L2', 200, 0.00, NULL, NULL),
(33, 'C-3-L3', 200, 0.00, NULL, NULL),
(34, 'C-4-L1', 200, 0.00, NULL, NULL),
(35, 'C-4-L2', 200, 0.00, NULL, NULL),
(36, 'C-4-L3', 200, 0.00, NULL, NULL),
(37, 'D-1-L1', 200, 0.00, NULL, NULL),
(38, 'D-1-L2', 200, 0.00, NULL, NULL),
(39, 'D-1-L3', 200, 0.00, NULL, NULL),
(40, 'D-2-L1', 200, 0.00, NULL, NULL),
(41, 'D-2-L2', 200, 0.00, NULL, NULL),
(42, 'D-2-L3', 200, 0.00, NULL, NULL),
(43, 'D-3-L1', 200, 0.00, NULL, NULL),
(44, 'D-3-L2', 200, 0.00, NULL, NULL),
(45, 'D-3-L3', 200, 0.00, NULL, NULL),
(46, 'D-4-L1', 200, 0.00, NULL, NULL),
(47, 'D-4-L2', 200, 0.00, NULL, NULL),
(48, 'D-4-L3', 200, 0.00, NULL, NULL),
(49, 'E-1-L1', 200, 0.00, NULL, NULL),
(50, 'E-1-L2', 200, 0.00, NULL, NULL),
(51, 'E-1-L3', 200, 0.00, NULL, NULL),
(52, 'E-2-L1', 200, 0.00, NULL, NULL),
(53, 'E-2-L2', 200, 0.00, NULL, NULL),
(54, 'E-2-L3', 200, 0.00, NULL, NULL),
(55, 'E-3-L1', 200, 0.00, NULL, NULL),
(56, 'E-3-L2', 200, 0.00, NULL, NULL),
(57, 'E-3-L3', 200, 0.00, NULL, NULL),
(58, 'E-4-L1', 200, 0.00, NULL, NULL),
(59, 'E-4-L2', 200, 0.00, NULL, NULL),
(60, 'E-4-L3', 200, 0.00, NULL, NULL),
(61, 'F-1-L1', 200, 0.00, NULL, NULL),
(62, 'F-1-L2', 200, 0.00, NULL, NULL),
(63, 'F-1-L3', 200, 0.00, NULL, NULL),
(64, 'F-2-L1', 200, 0.00, NULL, NULL),
(65, 'F-2-L2', 200, 0.00, NULL, NULL),
(66, 'F-2-L3', 200, 0.00, NULL, NULL),
(67, 'F-3-L1', 200, 0.00, NULL, NULL),
(68, 'F-3-L2', 200, 0.00, NULL, NULL),
(69, 'F-3-L3', 200, 0.00, NULL, NULL),
(70, 'F-4-L1', 200, 0.00, NULL, NULL),
(71, 'F-4-L2', 200, 0.00, NULL, NULL),
(72, 'F-4-L3', 200, 0.00, NULL, NULL),
(73, 'G-1-L1', 200, 0.00, NULL, NULL),
(74, 'G-1-L2', 200, 0.00, NULL, NULL),
(75, 'G-1-L3', 200, 0.00, NULL, NULL),
(76, 'G-2-L1', 200, 0.00, NULL, NULL),
(77, 'G-2-L2', 200, 0.00, NULL, NULL),
(78, 'G-2-L3', 200, 0.00, NULL, NULL),
(79, 'G-3-L1', 200, 0.00, NULL, NULL),
(80, 'G-3-L2', 200, 0.00, NULL, NULL),
(81, 'G-3-L3', 200, 0.00, NULL, NULL),
(82, 'G-4-L1', 200, 0.00, NULL, NULL),
(83, 'G-4-L2', 200, 0.00, NULL, NULL),
(84, 'G-4-L3', 200, 0.00, NULL, NULL),
(85, 'H-1-L1', 200, 0.00, NULL, NULL),
(86, 'H-1-L2', 200, 0.00, NULL, NULL),
(87, 'H-1-L3', 200, 0.00, NULL, NULL),
(88, 'H-2-L1', 200, 0.00, NULL, NULL),
(89, 'H-2-L2', 200, 0.00, NULL, NULL),
(90, 'H-2-L3', 200, 0.00, NULL, NULL),
(91, 'H-3-L1', 200, 0.00, NULL, NULL),
(92, 'H-3-L2', 200, 0.00, NULL, NULL),
(93, 'H-3-L3', 200, 0.00, NULL, NULL),
(94, 'H-4-L1', 200, 0.00, NULL, NULL),
(95, 'H-4-L2', 200, 0.00, NULL, NULL),
(96, 'H-4-L3', 200, 0.00, NULL, NULL),
(97, 'I-1-L1', 200, 0.00, NULL, NULL),
(98, 'I-1-L2', 200, 0.00, NULL, NULL),
(99, 'I-1-L3', 200, 0.00, NULL, NULL),
(100, 'I-2-L1', 200, 0.00, NULL, NULL),
(101, 'I-2-L2', 200, 0.00, NULL, NULL),
(102, 'I-2-L3', 200, 0.00, NULL, NULL),
(103, 'I-3-L1', 200, 0.00, NULL, NULL),
(104, 'I-3-L2', 200, 0.00, NULL, NULL),
(105, 'I-3-L3', 200, 0.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '3',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'einstein', 'ek@ek.com', NULL, '$2y$10$ckWK0eSeRTTWyOOJ0WY14ePDyH4jZFuC9g9rKO98e39hX79Xe6bA2', '1', NULL, '2023-03-15 17:23:05', '2023-03-15 17:23:05'),
(2, 'einstein', 'yilongmama@yilong.com', NULL, '$2y$10$73eTL.Cx6YSRtOTKWaNAB.BEVavsuUkJMczJYlcGJclWtv42jz0OS', '2', NULL, '2023-03-15 17:23:55', '2023-03-15 17:23:55'),
(3, 'Lola', 'man@man.com', NULL, '$2y$10$WajeAuE32ycRRx7U./C3m.jm57eUa5yxuN6c6U/5lhjWZeW0j2Fie', '2', NULL, '2023-03-16 17:39:28', '2023-03-16 17:39:28'),
(4, 'Manny', 'user1@user1.com', NULL, '$2y$10$k7oynlanF9WMBtqT62PegeFUyEcupR3pRcX3S0WJrWbshG5aulVjq', '3', NULL, '2023-03-23 19:53:18', '2023-03-23 19:53:18'),
(5, 'Einstein', 'admin@admin.com', NULL, '$2y$10$wfrudzKuYwG0mHn2afRA3ui5HVi7M/K5Ec4An5D.L.y9ndd6bIeB6', '3', NULL, '2023-04-03 17:08:05', '2023-04-03 17:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `weights`
--

CREATE TABLE `weights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `weight_of_product` double(8,2) NOT NULL,
  `rack_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weights`
--

INSERT INTO `weights` (`id`, `weight_of_product`, `rack_id`, `product_id`, `created_at`, `updated_at`) VALUES
(28, 40.00, 2, 83, '2023-05-15 19:00:02', '2023-05-15 19:00:02'),
(30, 140.00, 1, 85, '2023-05-16 00:24:18', '2023-05-16 18:07:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_quantity_id_foreign` (`quantity_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_product_id_foreign` (`product_id`),
  ADD KEY `orders_rack_id_foreign` (`rack_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
-- Indexes for table `pickers`
--
ALTER TABLE `pickers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pickers_user_id_foreign` (`user_id`),
  ADD KEY `pickers_product_id_foreign` (`product_id`),
  ADD KEY `pickers_rack_id_foreign` (`rack_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_company_id` (`company_id`),
  ADD KEY `fk_rack_id` (`rack_id`);

--
-- Indexes for table `quantities`
--
ALTER TABLE `quantities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quantities_product_id_foreign` (`product_id`);

--
-- Indexes for table `rack_locations`
--
ALTER TABLE `rack_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `weights`
--
ALTER TABLE `weights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weights_product_id_foreign` (`product_id`),
  ADD KEY `weights_rack_id_foreign` (`rack_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pickers`
--
ALTER TABLE `pickers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `quantities`
--
ALTER TABLE `quantities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `rack_locations`
--
ALTER TABLE `rack_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `weights`
--
ALTER TABLE `weights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_quantity_id_foreign` FOREIGN KEY (`quantity_id`) REFERENCES `quantities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_rack_id_foreign` FOREIGN KEY (`rack_id`) REFERENCES `rack_locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pickers`
--
ALTER TABLE `pickers`
  ADD CONSTRAINT `pickers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pickers_rack_id_foreign` FOREIGN KEY (`rack_id`) REFERENCES `rack_locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pickers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rack_id` FOREIGN KEY (`rack_id`) REFERENCES `rack_locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quantities`
--
ALTER TABLE `quantities`
  ADD CONSTRAINT `quantities_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `weights`
--
ALTER TABLE `weights`
  ADD CONSTRAINT `weights_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `weights_rack_id_foreign` FOREIGN KEY (`rack_id`) REFERENCES `rack_locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
