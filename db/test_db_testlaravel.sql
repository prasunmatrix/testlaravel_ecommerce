-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2023 at 05:06 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_db_testlaravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_slug` varchar(255) NOT NULL,
  `category_photo` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_slug`, `category_photo`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Fresh Meat', 'fresh-meat', '1598294071.jpg', 1, 0, '2020-08-22 09:07:38', '2023-07-18 07:59:09'),
(2, 'Vegetables', 'vegetables', '1598107355.jpg', 1, 0, '2020-08-22 09:12:35', '2021-06-30 09:21:06'),
(3, 'Fresh Fruit', 'fresh-fruit', '1624015255.jpg', 1, 0, '2021-06-18 05:50:55', '2021-06-30 09:35:47'),
(4, 'Drink Fruits', 'drink-fruits', '1625062587.jpg', 1, 0, '2021-06-30 08:46:27', '2021-07-22 02:21:18'),
(5, 'abcd', 'abcd', '1625064923.jpg', 1, 1, '2021-06-30 09:25:23', '2021-06-30 09:25:57');

-- --------------------------------------------------------

--
-- Table structure for table `categories_bkp30jun2021`
--

CREATE TABLE `categories_bkp30jun2021` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_photo` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories_bkp30jun2021`
--

INSERT INTO `categories_bkp30jun2021` (`category_id`, `category_name`, `category_photo`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Fresh Meat', '1598294071.jpg', 1, 0, '2020-08-22 09:07:38', '2021-06-14 11:08:36'),
(2, 'Vegetables', '1598107355.jpg', 1, 0, '2020-08-22 09:12:35', '2020-10-07 09:21:29'),
(3, 'Fresh-Fruit', '1624015255.jpg', 1, 0, '2021-06-18 05:50:55', '2021-06-21 09:22:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `is_popular` int(11) NOT NULL DEFAULT 0,
  `sku_code` varchar(256) DEFAULT NULL,
  `product_name` varchar(256) DEFAULT NULL,
  `product_slug` varchar(256) DEFAULT NULL,
  `feature_image` varchar(256) DEFAULT NULL,
  `product_stock` int(11) DEFAULT NULL,
  `short_desc` text DEFAULT NULL,
  `long_desc` longtext DEFAULT NULL,
  `aditional_info` text DEFAULT NULL,
  `usd_price` double(10,2) NOT NULL,
  `usd_offer_price` double(10,2) DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `is_popular`, `sku_code`, `product_name`, `product_slug`, `feature_image`, `product_stock`, `short_desc`, `long_desc`, `aditional_info`, `usd_price`, `usd_offer_price`, `meta_title`, `meta_keywords`, `meta_description`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, '36520', 'Potato', 'potato', '1624014596.jpg', NULL, '<p>testing</p>', '<p>testing</p>', '<p>testing</p>', 10.00, 8.00, 'Meta Title 3456', 'Meta Description', 'Meta Description', 1, 0, '2020-10-14 08:57:41', '2021-06-30 09:38:50'),
(2, 1, '36500', 'tomato', 'tomato', '1602738925.jpg', NULL, '<p>testing</p>', '<p>testing</p>', '<p>testing</p>', 5.00, 4.00, 'Meta Title', 'Meta Description', 'Meta Description', 1, 0, '2020-10-14 23:45:25', '2021-06-18 10:54:38');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT 'foreign key of products table id',
  `category` int(11) NOT NULL COMMENT 'foreign key of categories table category_id',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `product_id`, `category`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(6, 2, 1, 1, 0, '2021-06-17 11:10:25', '2021-06-18 10:54:21'),
(7, 2, 2, 1, 0, '2021-06-17 11:10:25', '2021-06-18 10:54:27'),
(18, 1, 1, 1, 0, '2021-06-30 09:38:50', '2021-06-30 09:38:50'),
(19, 1, 2, 1, 0, '2021-06-30 09:38:50', '2021-06-30 09:38:50'),
(20, 1, 3, 1, 0, '2021-06-30 09:38:50', '2021-06-30 09:38:50');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2020-10-05 18:02:00', '2020-10-05 18:02:00'),
(2, 'customer', '2020-10-05 18:02:00', '2020-10-05 18:02:00');

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
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL COMMENT 'foreign key of roles table id',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'PRASUN KUNDU', 'unified.prasun@gmail.com', NULL, '$2y$10$qVfzjCREyEjRv5PyRRxi/.f89as6PprdrQzImQz8Mty8UnVI5TRHe', NULL, 1, 1, 0, '2020-08-13 01:49:53', '2020-08-13 01:49:53');

-- --------------------------------------------------------

--
-- Table structure for table `users_bkp05oct2020`
--

CREATE TABLE `users_bkp05oct2020` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_bkp05oct2020`
--

INSERT INTO `users_bkp05oct2020` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'PRASUN KUNDU', 'unified.prasun@gmail.com', NULL, '$2y$10$qVfzjCREyEjRv5PyRRxi/.f89as6PprdrQzImQz8Mty8UnVI5TRHe', NULL, '2020-08-13 01:49:53', '2020-08-13 01:49:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `categories_bkp30jun2021`
--
ALTER TABLE `categories_bkp30jun2021`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_bkp05oct2020`
--
ALTER TABLE `users_bkp05oct2020`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories_bkp30jun2021`
--
ALTER TABLE `categories_bkp30jun2021`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_bkp05oct2020`
--
ALTER TABLE `users_bkp05oct2020`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
