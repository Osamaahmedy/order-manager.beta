-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 06, 2026 at 01:17 PM
-- Server version: 8.0.44-0ubuntu0.24.04.2
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `photo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `phone`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Osama Ahmed', 'asasa@gmail.come', '$2y$12$7SYq3HyL/XWovmF0XesBEeC2FJ8BYaQ2feQSVhUcJg13E7r2fPpQm', '718323599', 'dKTxrkKAVnKXt8ixNZTsaNuc1fRs1TlapbYjRaunJQBJ4FKeV8PUAwMUl6GV', '2026-01-08 19:10:05', '2026-02-02 11:45:09'),
(2, 'mgd', 'mgd@gmail.com', '$2y$12$42ZQhoMv4.H9OmBZgIpC6epoxTxEGUPOE/mU9UVhe9enFM6Ec7.V2', '123123123', NULL, '2025-12-27 08:44:41', '2026-02-02 11:07:21'),
(3, 'Osama Ahmed5', 'asaamk4292@gmail.com', '$2y$12$bGQ1AZOFgs5DY7HEVf8r0eZMJTeV8J8q59sktp9MJXgJ0KT/1M.w.', '04718323599', NULL, '2026-01-29 12:08:31', '2026-01-30 09:09:00'),
(4, 'اسامه', 'os@gmail.com', '$2y$12$EmmbgMel1.UT/ZC8JfFOUOLfcYDYvvUFXUraplrZQOip3D57QAA8m', '777888666', 'ewhmeM7XwuJQS3uiwjO7sx4bVXbUS5jb6eWpsyb6G2tjdDvYOLQ2my1a2wv5', '2026-01-31 06:11:58', '2026-02-02 11:16:28'),
(5, '8', '8@gmail.com', '$2y$12$NeF6xlbWv2moRMR1wB7Ooe.ynZ2dW2rvhFutgfoMjkI97mG.QF5P2', '07718323599', 'zER4fMRPgo2tOXPX87ntykOdjBbGo5wsVsKE1VMOSWgNNa1jefnMLcnBl3w4', '2026-01-31 07:20:47', '2026-01-31 07:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `admin_branch`
--

CREATE TABLE `admin_branch` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `branch_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_branch`
--

INSERT INTO `admin_branch` (`id`, `admin_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(5, 1, 1, '2025-12-27 08:19:52', '2025-12-27 08:19:52'),
(6, 2, 3, '2025-12-27 08:44:41', '2025-12-27 08:44:41'),
(8, 1, 3, '2026-01-29 12:38:16', '2026-01-29 12:38:16'),
(9, 1, 4, '2026-01-29 13:05:30', '2026-01-29 13:05:30'),
(11, 4, 5, '2026-01-31 06:19:07', '2026-01-31 06:19:07'),
(18, 4, 2, '2026-02-03 09:12:45', '2026-02-03 09:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `location`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'فرع جدة', 'لحج - صبر', 1, '2026-01-08 19:09:04', '2026-02-02 05:31:18'),
(2, 'Osama Ahmed', 'عدن - المنصورة', 1, '2025-12-26 19:09:20', '2026-01-29 12:28:46'),
(3, 'فرع الرياض', '545', 1, '2025-12-27 08:44:04', '2026-02-02 05:31:35'),
(4, 'فرع مكة', 'س', 1, '2026-01-29 13:05:30', '2026-02-02 05:33:12'),
(5, 'فرع ينبع', 'عدن - الشيخ عثمان ', 1, '2026-01-31 06:12:36', '2026-02-02 05:33:46');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_356a192b7913b04c54574d18c28d46e6395428ab', 'i:2;', 1770130502),
('laravel_cache_356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1770130502;', 1770130502),
('laravel_cache_livewire-rate-limiter:91d5b1a7a5ea7c47b9f493cbac5cb1dd0ca2cfe7', 'i:1;', 1770043650),
('laravel_cache_livewire-rate-limiter:91d5b1a7a5ea7c47b9f493cbac5cb1dd0ca2cfe7:timer', 'i:1770043650;', 1770043650),
('laravel_cache_livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1770118775),
('laravel_cache_livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1770118775;', 1770118775),
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:38:{i:0;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:10:\"view users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:1;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"create users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:2;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"update users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:12:\"delete users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:10:\"view roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:5;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:12:\"create roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:6;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:12:\"update roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:12:\"delete roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:16:\"view permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:9;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:18:\"create permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:10;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:18:\"update permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:18:\"delete permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:10:\"view admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:12:\"create admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:12:\"delete admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:12:\"update admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:11:\"view Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:13:\"create Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:13:\"update Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:13:\"delete Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:13:\"view Resident\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:15:\"update Resident\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:15:\"delete Resident\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:15:\"create Resident\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:11:\"view orders\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:13:\"update orders\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:18:\"view Delivery Apps\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:20:\"create Delivery Apps\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:20:\"delete Delivery Apps\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:20:\"update Delivery Apps\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:19:\"create Subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:19:\"update Subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:19:\"delete Subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:17:\"view Subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:10:\"view plans\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:12:\"update plans\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:12:\"delete plans\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:12:\"create plans\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:3:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:6:\"normal\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:7:\"admin27\";s:1:\"c\";s:3:\"web\";}}}', 1770303267);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_apps`
--

CREATE TABLE `delivery_apps` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_apps`
--

INSERT INTO `delivery_apps` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'كاريند', '2026-01-30 18:24:45', '2026-01-30 18:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `collection_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(8, 'App\\Models\\Maintenance', 5, '5c7d074f-38d3-4d71-b569-20cd7a0d0b55', 'images', 'Screenshot from 2025-07-11 16-33-10', '01JZXAHCA6050M77MEV00CT8GJ.png', 'image/png', 'public', 'public', 267398, '[]', '[]', '[]', '[]', 1, '2025-07-11 15:04:08', '2025-07-11 15:04:08'),
(11, 'App\\Models\\Maintenance', 6, 'e994b4d3-e76f-4b5a-8760-593acf43fdd0', 'images', 'Screenshot from 2025-07-11 16-33-10', '01JZXAQ35AP09DN21DA3C0QCQ4.png', 'image/png', 'public', 'public', 267398, '[]', '[]', '[]', '[]', 1, '2025-07-11 15:07:16', '2025-07-11 15:07:16'),
(16, 'App\\Models\\Maintenance', 7, '480e856d-10c5-4955-8e74-a7700549d71a', 'images', 'Screenshot from 2025-07-11 15-48-50', '01JZZ3GR5YWX2XZHJVTFPX7QNR.png', 'image/png', 'public', 'public', 191594, '[]', '[]', '[]', '[]', 1, '2025-07-12 07:39:57', '2025-07-12 07:39:57'),
(17, 'App\\Models\\Maintenance', 8, '48d6c590-beb9-49dc-932d-613e11163ad4', 'images', 'Screenshot from 2025-07-11 15-48-50', '01JZZ46728QKRZJCE70S47Q7VD.png', 'image/png', 'public', 'public', 191594, '[]', '[]', '[]', '[]', 1, '2025-07-12 07:51:40', '2025-07-12 07:51:40'),
(20, 'App\\Models\\Maintenance', 9, '45a23258-e834-4495-9a42-66ba0be2ab69', 'images', 'Screenshot from 2025-07-11 15-48-50', '01JZZ4HTD3P4HXJQV4G2G8NKYN.png', 'image/png', 'public', 'public', 191594, '[]', '[]', '[]', '[]', 1, '2025-07-12 07:58:00', '2025-07-12 07:58:00'),
(21, 'App\\Models\\Maintenance', 10, 'da8af920-4fbc-4792-a6d4-92dc3a47a8fc', 'images', 'Screenshot from 2025-07-11 15-48-50', '01JZZ4JVK7VN9CDBG5XMZNFK4J.png', 'image/png', 'public', 'public', 191594, '[]', '[]', '[]', '[]', 1, '2025-07-12 07:58:34', '2025-07-12 07:58:34'),
(22, 'App\\Models\\Maintenance', 11, '00eecb8f-847c-4c88-a672-49fdb607a9d8', 'images', 'Screenshot from 2025-07-11 16-36-44', '01JZZ4S6G3465J6K63W8T4BRWY.png', 'image/png', 'public', 'public', 262406, '[]', '[]', '[]', '[]', 1, '2025-07-12 08:02:02', '2025-07-12 08:02:02'),
(28, 'App\\Models\\Maintenance', 12, 'b60ca1f5-6189-449f-ab1a-3e5d35e7a0b8', 'images', 'Screenshot from 2025-07-11 16-33-10', '01JZZXGJEYTTMJ294HT3WRWVXP.png', 'image/png', 'public', 'public', 267398, '[]', '[]', '[]', '[]', 1, '2025-07-12 15:14:14', '2025-07-12 15:14:14'),
(37, 'App\\Models\\Maintenance', 14, 'ce9d0e89-1882-45d2-a525-e42a704be1ec', 'images', 'Screenshot from 2025-07-11 15-48-50', '01K05BCFC4B1EM97PAWQAR1BFP.png', 'image/png', 'public', 'public', 191594, '[]', '[]', '[]', '[]', 1, '2025-07-14 17:52:52', '2025-07-14 17:52:52'),
(40, 'App\\Models\\Asset', 19, 'e4dad4ea-a877-4ca4-a6d3-60a4638a02e1', 'image', 'Screenshot from 2025-07-11 15-48-50', '01K0SE9G03G1DTRY76NEJAC4CK.png', 'image/png', 'public', 'public', 191594, '[]', '[]', '[]', '[]', 1, '2025-07-22 13:08:28', '2025-07-22 13:08:28'),
(41, 'App\\Models\\Asset', 19, 'e2dff7ae-a463-49ff-a9f7-c9b191767ece', 'document', 'Screenshot from 2025-06-29 21-00-06', '01K0SE9G23W4YMR7MHN2JMS007.png', 'image/png', 'public', 'public', 112787, '[]', '[]', '[]', '[]', 2, '2025-07-22 13:08:28', '2025-07-22 13:08:28'),
(42, 'App\\Models\\Maintenance', 18, '494811dc-9919-42e3-9fc3-e19ab996c720', 'images', 'Screenshot from 2025-07-11 15-48-50', '01K0SESV6KX9TK5K04Q0QCSJG5.png', 'image/png', 'public', 'public', 191594, '[]', '[]', '[]', '[]', 1, '2025-07-22 13:17:24', '2025-07-22 13:17:24'),
(43, 'App\\Models\\Maintenance', 19, '37aa3834-9f82-4d4c-b15c-9f98abef6ee2', 'images', 'Screenshot from 2025-07-11 16-33-10', '01K0SEVHT95TEPWBA88JB82001.png', 'image/png', 'public', 'public', 267398, '[]', '[]', '[]', '[]', 1, '2025-07-22 13:18:20', '2025-07-22 13:18:20'),
(44, 'App\\Models\\Order', 1, 'cb3b9b72-f244-4229-ba0f-5bd553e8eb8c', 'images', 'Logo Invert H', '01KDFFNRXF2H6QSK4A76B248VQ.png', 'image/png', 'public', 'public', 111621, '[]', '[]', '[]', '[]', 1, '2025-12-27 05:44:19', '2025-12-27 05:44:19'),
(45, 'App\\Models\\Order', 1, 'd87b378b-b178-4b97-8390-88305183c5e9', 'images', 'Logo Invert V', '01KDFFNRZVHNR6PE2A5C6DR39E.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 2, '2025-12-27 05:44:19', '2025-12-27 05:44:19'),
(46, 'App\\Models\\Order', 2, 'a8dd210c-7540-4d4a-b447-6b6a058dbca3', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 1, '2025-12-27 07:12:49', '2025-12-27 07:12:49'),
(47, 'App\\Models\\Order', 2, '42e392ff-3587-4d53-b69d-9a4926312f0e', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 2, '2025-12-27 07:12:49', '2025-12-27 07:12:49'),
(48, 'App\\Models\\Order', 3, 'b38e6df8-36e2-47df-a334-e4aa2d33c522', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 1, '2025-12-27 07:20:00', '2025-12-27 07:20:00'),
(49, 'App\\Models\\Order', 3, 'acfa665a-cd3d-4a1d-ac63-23b922ef2865', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 2, '2025-12-27 07:20:00', '2025-12-27 07:20:00'),
(50, 'App\\Models\\Order', 4, '357195b9-886d-4291-96a0-8cde2267a9dd', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 1, '2025-12-27 07:20:05', '2025-12-27 07:20:05'),
(51, 'App\\Models\\Order', 4, 'd8bb7c01-3534-4d5f-95f6-103678aa804b', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 2, '2025-12-27 07:20:05', '2025-12-27 07:20:05'),
(52, 'App\\Models\\Order', 5, '35c1655c-072c-4914-86b0-038eecb83e10', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 1, '2025-12-27 07:38:34', '2025-12-27 07:38:34'),
(53, 'App\\Models\\Order', 5, 'f13f89dd-0c13-42f7-a1b9-c42fa21f940d', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 2, '2025-12-27 07:38:34', '2025-12-27 07:38:34'),
(54, 'App\\Models\\Order', 6, 'a9a5613f-eecd-4aa7-8cb0-19ec1d72ee5c', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 1, '2025-12-27 08:54:26', '2025-12-27 08:54:26'),
(55, 'App\\Models\\Order', 6, '81f481ed-c6ca-4440-a446-9ef046defceb', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 3, '2025-12-27 08:54:26', '2026-01-29 11:57:42'),
(56, 'App\\Models\\Order', 6, '7450eb47-ab2f-47a4-b3f3-b59fcbc0d9fd', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 2, '2025-12-27 08:55:37', '2026-01-29 11:57:42'),
(57, 'App\\Models\\Order', 6, '2120efe9-3cbf-4513-9296-8f8ae7f4b85c', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 4, '2025-12-27 08:55:37', '2026-01-29 11:57:42'),
(58, 'App\\Models\\Order', 7, 'e12faf4f-16ec-4f75-8d61-9c34a31547cd', 'images', 'QuickDBD-Free Diagram (1)', '01KF18X25MME44DM3RN3VVK2DM.png', 'image/png', 'public', 'public', 408381, '[]', '[]', '[]', '[]', 1, '2026-01-15 13:47:59', '2026-01-15 13:47:59'),
(59, 'App\\Models\\Order', 7, 'e0934250-40ad-49cf-bf37-aff8dce24957', 'images', 'QuickDBD-Free Diagram', '01KF18X26S1SPKDNM0ZTJKCNJZ.png', 'image/png', 'public', 'public', 423981, '[]', '[]', '[]', '[]', 2, '2026-01-15 13:47:59', '2026-01-15 13:47:59'),
(60, 'App\\Models\\Order', 7, '9be7dd34-1762-412c-8858-0ae13d20e23e', 'images', 'Logo V', '01KF18X27GBKJCBRXNPWKP5X29.png', 'image/png', 'public', 'public', 241863, '[]', '[]', '[]', '[]', 3, '2026-01-15 13:47:59', '2026-01-15 13:47:59'),
(61, 'App\\Models\\Order', 7, '23d312f0-dd4c-4103-a204-b3a54318d15a', 'images', 'WhatsApp Image 2025-09-14 at 11.38.41 PM', '01KF18X282TWK33VJSAMWBABCE.jpeg', 'image/jpeg', 'public', 'public', 4786, '[]', '[]', '[]', '[]', 4, '2026-01-15 13:47:59', '2026-01-15 13:47:59'),
(62, 'App\\Models\\Order', 7, 'ced40f47-0ce4-4612-8340-5e39f497845b', 'images', 'Logo V', '01KF18X28KQE7MWTF6Q2M46PXV.png', 'image/png', 'public', 'public', 241863, '[]', '[]', '[]', '[]', 5, '2026-01-15 13:47:59', '2026-01-15 13:47:59'),
(63, 'App\\Models\\Order', 8, 'b511bb4b-6b1b-4df2-b751-af7ae8049681', 'images', 'Screenshot from 2025-07-11 21-07-13', 'Screenshot-from-2025-07-11-21-07-13.png', 'image/png', 'public', 'public', 200354, '[]', '[]', '[]', '[]', 1, '2026-01-25 11:43:08', '2026-01-25 11:43:08'),
(64, 'App\\Models\\Order', 9, '58b185d3-0c30-43b2-9bc7-8965cf59e9d0', 'images', 'Screenshot from 2025-07-11 17-31-06', 'Screenshot-from-2025-07-11-17-31-06.png', 'image/png', 'public', 'public', 307635, '[]', '[]', '[]', '[]', 1, '2026-01-29 13:14:55', '2026-01-29 13:14:55'),
(65, 'App\\Models\\Order', 9, '5aabcee7-353f-4914-b1bf-01c5026eecca', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 2, '2026-01-29 13:14:55', '2026-01-29 13:14:55'),
(66, 'App\\Models\\Order', 10, '629eccdb-f2fb-4427-813a-f6ea023c65d4', 'images', 'Screenshot from 2025-07-11 17-31-06', 'Screenshot-from-2025-07-11-17-31-06.png', 'image/png', 'public', 'public', 307635, '[]', '[]', '[]', '[]', 1, '2026-01-29 13:15:06', '2026-01-29 13:15:06'),
(67, 'App\\Models\\Order', 10, 'ec4a0769-2494-40a1-bcfe-7b0756bf9f3e', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 2, '2026-01-29 13:15:06', '2026-01-29 13:15:06'),
(68, 'App\\Models\\Order', 11, 'a8f74fc5-e04d-4638-b6ab-68aa53427d56', 'images', 'Screenshot from 2025-07-11 17-31-06', 'Screenshot-from-2025-07-11-17-31-06.png', 'image/png', 'public', 'public', 307635, '[]', '[]', '[]', '[]', 1, '2026-01-29 13:15:07', '2026-01-29 13:15:07'),
(69, 'App\\Models\\Order', 11, 'e361b5ff-9ceb-4fc0-9185-208ca2c5cd40', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 2, '2026-01-29 13:15:07', '2026-01-29 13:15:07'),
(70, 'App\\Models\\Order', 12, 'bcb1f7ce-0905-4157-9139-7f176496a5af', 'images', 'Screenshot from 2025-07-11 17-31-06', 'Screenshot-from-2025-07-11-17-31-06.png', 'image/png', 'public', 'public', 307635, '[]', '[]', '[]', '[]', 1, '2026-01-30 08:41:27', '2026-01-30 08:41:27'),
(71, 'App\\Models\\Order', 12, '39dcd7c5-332e-4b1a-b64d-9be64bdee1e4', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 2, '2026-01-30 08:41:27', '2026-01-30 08:41:27'),
(72, 'App\\Models\\SubscriptionRenewalRequest', 1, '5fc42759-8b55-4db6-9078-c037dc26c54a', 'transfer_image', 'Screenshot from 2025-07-11 21-06-11', 'Screenshot-from-2025-07-11-21-06-11.png', 'image/png', 'public', 'public', 142517, '[]', '[]', '[]', '[]', 1, '2026-01-30 09:01:27', '2026-01-30 09:01:27'),
(73, 'App\\Models\\SubscriptionRenewalRequest', 2, '1758e44b-8183-416c-ad75-10985753fefe', 'transfer_image', 'Screenshot from 2025-07-11 21-06-11', 'Screenshot-from-2025-07-11-21-06-11.png', 'image/png', 'public', 'public', 142517, '[]', '[]', '[]', '[]', 1, '2026-01-30 09:04:47', '2026-01-30 09:04:47'),
(74, 'App\\Models\\SubscriptionRenewalRequest', 4, '82df9142-1737-425a-9d48-0ac48042df91', 'transfer_image', 'Screenshot from 2025-07-11 21-06-11', 'Screenshot-from-2025-07-11-21-06-11.png', 'image/png', 'public', 'public', 142517, '[]', '[]', '[]', '[]', 1, '2026-01-30 09:09:38', '2026-01-30 09:09:38'),
(75, 'App\\Models\\Order', 13, '074ca2be-2930-43b7-baf0-91639ec0a395', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-30 18:43:20', '2026-01-30 18:43:20'),
(76, 'App\\Models\\Order', 14, '41b612b0-38a2-4d3f-b99c-f2c3d46baf8d', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-30 18:49:27', '2026-01-30 18:49:27'),
(77, 'App\\Models\\Order', 15, '10642bfa-a3f5-4189-bca2-3a8fe7d21f2c', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-30 18:49:54', '2026-01-30 18:49:54'),
(78, 'App\\Models\\Order', 16, '226f9642-244d-45e4-bbbb-3913923a15ad', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-30 19:52:53', '2026-01-30 19:52:53'),
(79, 'App\\Models\\Order', 17, '14b984c0-3e1c-4c29-ba2a-db691a63dd75', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-31 05:35:33', '2026-01-31 05:35:33'),
(80, 'App\\Models\\Order', 18, '4ad768c9-2070-4bf2-9062-3845520e429d', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-31 05:40:58', '2026-01-31 05:40:58'),
(81, 'App\\Models\\Order', 19, 'f25f3104-7862-43f3-8904-74a5f36dc948', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-31 05:43:32', '2026-01-31 05:43:32'),
(82, 'App\\Models\\Order', 20, 'f094e752-6c12-462a-8d44-c1f15f883fbd', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-31 05:43:47', '2026-01-31 05:43:47'),
(83, 'App\\Models\\Order', 21, 'ea01c243-2aa3-4798-b558-7c589507141b', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-31 05:52:47', '2026-01-31 05:52:47'),
(84, 'App\\Models\\Order', 22, '35c17bb2-71a4-4b3e-a4a1-f82e29bb60b7', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-31 05:53:36', '2026-01-31 05:53:36'),
(85, 'App\\Models\\Order', 23, '9c9eaf1a-c1e7-4321-9c7e-090e0d67970d', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-31 06:31:08', '2026-01-31 06:31:08'),
(86, 'App\\Models\\Order', 24, 'b5c81123-e7db-4a86-bad9-10f66310ca19', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-31 06:33:39', '2026-01-31 06:33:39'),
(87, 'App\\Models\\SubscriptionRenewalRequest', 5, 'ba2cd249-2c5e-41b1-b6eb-b98367fb75e0', 'transfer_image', 'Screenshot from 2025-07-11 21-06-11', 'Screenshot-from-2025-07-11-21-06-11.png', 'image/png', 'public', 'public', 142517, '[]', '[]', '[]', '[]', 1, '2026-01-31 09:35:43', '2026-01-31 09:35:43'),
(88, 'App\\Models\\Order', 33, '34ad504e-9be3-4921-9100-ec08029e1cf6', 'images', 'Screenshot from 2025-07-11 17-31-06', 'Screenshot-from-2025-07-11-17-31-06.png', 'image/png', 'public', 'public', 307635, '[]', '[]', '[]', '[]', 1, '2026-01-31 15:07:58', '2026-01-31 15:07:58'),
(89, 'App\\Models\\Order', 33, 'a7ecc10f-1d4b-4342-87d2-9f24c2250f89', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 2, '2026-01-31 15:07:58', '2026-01-31 15:07:58'),
(90, 'App\\Models\\Order', 34, 'adf284ea-a81c-4c38-9a00-56754a143265', 'images', 'Screenshot from 2025-07-11 17-31-06', 'Screenshot-from-2025-07-11-17-31-06.png', 'image/png', 'public', 'public', 307635, '[]', '[]', '[]', '[]', 1, '2026-01-31 15:17:22', '2026-01-31 15:17:22'),
(91, 'App\\Models\\Order', 34, '511b415e-32c9-431c-9735-c00b41bfa30b', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 2, '2026-01-31 15:17:22', '2026-01-31 15:17:22'),
(92, 'App\\Models\\Order', 35, '3dbab755-6717-4b77-947d-9af6b1ada50b', 'images', 'Screenshot from 2025-07-11 17-31-06', 'Screenshot-from-2025-07-11-17-31-06.png', 'image/png', 'public', 'public', 307635, '[]', '[]', '[]', '[]', 1, '2026-01-31 15:17:26', '2026-01-31 15:17:26'),
(93, 'App\\Models\\Order', 35, 'd00784ec-f469-4436-b06c-ef7073c6ab18', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 2, '2026-01-31 15:17:26', '2026-01-31 15:17:26'),
(94, 'App\\Models\\Order', 36, '35bef33d-2e9c-4fe0-acbf-42284ca6739b', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-31 15:17:34', '2026-01-31 15:17:34'),
(95, 'App\\Models\\Order', 37, 'f517d1b7-bd21-44b5-8b12-ca92d8855d01', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-31 15:17:38', '2026-01-31 15:17:38'),
(96, 'App\\Models\\Order', 38, '0d595a4c-a8a8-4fdf-998d-3506731fc971', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 1, '2026-01-31 15:17:39', '2026-01-31 15:17:39'),
(97, 'App\\Models\\Order', 39, '530e1425-c492-4664-adae-da6a14bf8742', 'images', 'Screenshot from 2025-07-11 17-31-06', 'Screenshot-from-2025-07-11-17-31-06.png', 'image/png', 'public', 'public', 307635, '[]', '[]', '[]', '[]', 1, '2026-02-01 11:29:55', '2026-02-01 11:29:55'),
(98, 'App\\Models\\Order', 39, 'a8467b8c-0f32-4508-afaa-3b52198fafa0', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 2, '2026-02-01 11:29:55', '2026-02-01 11:29:55'),
(99, 'App\\Models\\Order', 40, '5cca31a1-015a-452f-9a83-e9080adce71f', 'images', 'Screenshot from 2025-07-11 17-31-06', 'Screenshot-from-2025-07-11-17-31-06.png', 'image/png', 'public', 'public', 307635, '[]', '[]', '[]', '[]', 1, '2026-02-01 11:37:35', '2026-02-01 11:37:35'),
(100, 'App\\Models\\Order', 40, 'e0012ac2-4ff8-47ba-b096-b28e5ecc1eb0', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 2, '2026-02-01 11:37:35', '2026-02-01 11:37:35'),
(101, 'App\\Models\\Order', 41, 'b7365bb3-4b63-4424-a097-f9563c1c7060', 'images', 'Screenshot from 2025-07-11 17-31-06', 'Screenshot-from-2025-07-11-17-31-06.png', 'image/png', 'public', 'public', 307635, '[]', '[]', '[]', '[]', 1, '2026-02-01 11:38:21', '2026-02-01 11:38:21'),
(102, 'App\\Models\\Order', 41, '8b00b4da-acea-449c-ab75-a8ff16d922a1', 'images', 'Screenshot from 2025-07-11 21-07-27', 'Screenshot-from-2025-07-11-21-07-27.png', 'image/png', 'public', 'public', 111881, '[]', '[]', '[]', '[]', 2, '2026-02-01 11:38:21', '2026-02-01 11:38:21'),
(103, 'App\\Models\\SubscriptionRenewalRequest', 6, 'b859d416-c92c-4efa-a639-3d65e5c2be39', 'transfer_image', 'Screenshot from 2025-07-11 21-06-11', 'Screenshot-from-2025-07-11-21-06-11.png', 'image/png', 'public', 'public', 142517, '[]', '[]', '[]', '[]', 1, '2026-02-01 11:58:10', '2026-02-01 11:58:10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '0001_01_01_000000_create_users_table', 1),
(7, '0001_01_01_000001_create_cache_table', 1),
(8, '0001_01_01_000002_create_jobs_table', 1),
(9, '2025_06_01_101803_create_posts_table', 1),
(10, '2025_06_01_104622_create_news_table', 1),
(11, '2025_06_02_093521_create_news_post_table', 2),
(12, '2025_06_02_100917_change_title_and_content_columns_in_news_table', 3),
(13, '2025_06_02_123233_add_translated_columns_to_news_table', 3),
(14, '2025_06_08_170011_create_permission_tables', 4),
(15, '2025_06_15_071255_create_institutes_table', 5),
(16, '2025_06_15_071255_create_universities_table', 5),
(17, '2025_06_15_071255_create_university_majors_table', 5),
(18, '2025_06_15_073126_create_institute_majors_table', 5),
(19, '2025_06_23_070750_create_students_table', 5),
(20, '2025_07_11_164220_create_departments_table', 6),
(21, '2025_07_11_164307_create_assets_table', 6),
(22, '2025_07_11_164336_create_maintenances_table', 6),
(23, '2025_07_11_164401_create_activity_logs_table', 6),
(24, '2025_07_14_174010_create_notifications_table', 7),
(25, '2025_07_14_181812_create_department_user_table', 8),
(26, '2025_07_14_185103_create_asset_deletion_confirmations_table', 9),
(27, '2025_07_14_185243_create_asset_deletion_confirmations_table', 10),
(28, '2025_09_12_193342_create_staff_table', 11),
(29, '2025_12_26_213551_create_admins_table', 12),
(30, '2025_12_26_213608_create_branches_table', 12),
(31, '2025_12_26_213739_create_admin_branch_table', 12),
(32, '2025_12_26_220541_fix_admin_branch_table', 13),
(33, '2025_12_26_225647_create_residents_table', 14),
(34, '2025_12_26_230742_create_oauth_auth_codes_table', 15),
(35, '2025_12_26_230743_create_oauth_access_tokens_table', 15),
(36, '2025_12_26_230744_create_oauth_refresh_tokens_table', 15),
(37, '2025_12_26_230745_create_oauth_clients_table', 15),
(38, '2025_12_26_230746_create_oauth_device_codes_table', 15),
(39, '2025_12_27_083619_create_orders_table', 16),
(40, '2026_01_16_152232_create_plans_table', 17),
(41, '2026_01_29_150413_remove_unique_constraint_from_residents_branch_id', 18),
(42, 'subscription_renewal_requests', 19),
(43, '2026_01_30_211644_create_delivery_apps_table', 20),
(44, '2026_01_31_082559_add_created_by_to_orders_table', 21),
(48, '2026_01_31_172211_create_activity_log_table', 22),
(49, '2026_01_31_172212_add_event_column_to_activity_log_table', 22),
(50, '2026_01_31_172213_add_batch_uuid_column_to_activity_log_table', 22),
(51, '2026_02_01_194219_create_sliders_table', 23);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('006ebef5588857ec9cb60c8eec0e282bcc8c86bdaedb94f3291c150fa328908468ef0c0730e5c788', 5, '019b5d24-2e5f-71c6-b472-ff01043adb4f', 'resident-token', '[]', 0, '2026-01-29 12:32:20', '2026-01-29 12:32:20', '2027-01-29 15:32:20'),
('09f11834c97373c19b79344d41c6d6139c6c788e2a5a071813fe00ee2ee17c03420c4cb9811e4789', 1, '019b5d24-6f4d-73ae-8aeb-844821b59779', 'admin-token', '[]', 0, '2026-02-02 11:45:26', '2026-02-02 11:45:26', '2027-02-02 14:45:26'),
('1736c2222cf4d7d530738dd61f4c340d248c606fd64c49d1a3d5cd254b422086b5fa4675b1dd0e7e', 3, '019b5d24-2e5f-71c6-b472-ff01043adb4f', 'resident-token', '[]', 0, '2026-02-03 09:20:13', '2026-02-03 09:20:14', '2027-02-03 12:20:13'),
('272f6cd2f7f6286f31ce78136a1ccce262deba63ad344c10f80df3295dad767f5d070e7a4d10567e', 7, '019b5d24-2e5f-71c6-b472-ff01043adb4f', 'resident-token', '[]', 0, '2026-02-03 09:12:01', '2026-02-03 09:12:01', '2027-02-03 12:12:01'),
('29d2ea6a83fc6ee1a0a88cfa104c10c49309e874da00ee39e53c3f135fec84ba2e035cdb5b28d259', 2, '019b5d24-6f4d-73ae-8aeb-844821b59779', 'admin-token', '[]', 0, '2026-01-17 08:12:49', '2026-01-17 08:12:49', '2027-01-17 11:12:49'),
('6d4bcf978b35664ff4b3a54b7cffdc6a18aadfb8446be541b04e3ec0e1855eb9b44ae5790a026b81', 3, '019b5d24-6f4d-73ae-8aeb-844821b59779', 'admin-token', '[]', 0, '2026-01-30 09:06:41', '2026-01-30 09:06:41', '2027-01-30 12:06:41'),
('7a3395f3aa553aa7bdb2ea46fd03fd00059c5b80e04a2925830199dc688c86553a43818ee68e70fe', 2, '019b5d24-2e5f-71c6-b472-ff01043adb4f', 'resident-token', '[]', 0, '2025-12-27 07:37:30', '2025-12-27 07:37:30', '2026-12-27 10:37:30'),
('99c8657c061f498873d0983301d34946a454b1cbacc5ce69c7ed36a46b5660ed15256681a64ebc75', 4, '019b5d24-6f4d-73ae-8aeb-844821b59779', 'admin-token', '[]', 0, '2026-01-31 14:24:34', '2026-01-31 14:24:34', '2027-01-31 17:24:34'),
('dc41492d5ac7a6d3448b20feba3d6f84f979130eacd328c849f5a9cf27f0f952e424a9405fab0335', 6, '019b5d24-2e5f-71c6-b472-ff01043adb4f', 'resident-token', '[]', 0, '2026-01-29 13:11:02', '2026-01-29 13:11:02', '2027-01-29 16:11:02'),
('ec39d8429b7f0b202f211fc5d7345011b39b617ba97e7f64266b7eebcf69a3f08785a2ef70219574', 1, '019b5d24-2e5f-71c6-b472-ff01043adb4f', 'resident-token', '[]', 0, '2026-02-03 09:15:18', '2026-02-03 09:15:18', '2027-02-03 12:15:18');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_uris` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `grant_types` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `owner_type`, `owner_id`, `name`, `secret`, `provider`, `redirect_uris`, `grant_types`, `revoked`, `created_at`, `updated_at`) VALUES
('019b5ceb-d259-71b5-9aae-5fc0afe39da7', NULL, NULL, 'Laravel', '$2y$12$J/9tBPZiK2IA3te7mwMkb.fAJDVK3x8tNM7vLb07vo4WLcWQIr2tm', 'admins', '[]', '[\"personal_access\"]', 0, '2025-12-26 20:08:37', '2025-12-26 20:08:37'),
('019b5d24-2e5f-71c6-b472-ff01043adb4f', NULL, NULL, 'Resident Personal Access Client', '$2y$12$b0rAW72sHxrtjn/Posmq3uRPDu0LceVtq6vz33x8fAB6mTXPfYsPm', 'residents', '[]', '[\"personal_access\"]', 0, '2025-12-26 21:10:10', '2025-12-26 21:10:10'),
('019b5d24-6f4d-73ae-8aeb-844821b59779', NULL, NULL, 'Admin Personal Access Client', '$2y$12$X9TrzebbwzPLrK496Y64luroreXwC0F18OxNDBvZAAx3lNaoVwGYy', 'admins', '[]', '[\"personal_access\"]', 0, '2025-12-26 21:10:27', '2025-12-26 21:10:27');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_device_codes`
--

CREATE TABLE `oauth_device_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_code` char(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `user_approved_at` datetime DEFAULT NULL,
  `last_polled_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resident_id` bigint UNSIGNED DEFAULT NULL,
  `branch_id` bigint UNSIGNED NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delivery_app_id` bigint UNSIGNED DEFAULT NULL,
  `created_by_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `number`, `resident_id`, `branch_id`, `notes`, `submitted_at`, `created_at`, `updated_at`, `delivery_app_id`, `created_by_type`, `created_by_id`) VALUES
(1, 'ORD-20251227-0001', '', 1, 1, 'khkljhlkj', '2025-12-27 05:43:27', '2026-01-08 05:44:19', '2025-12-27 06:09:44', NULL, NULL, NULL),
(2, 'ORD-20251227-0002', '', 1, 1, 'ghghjg', '2025-12-27 07:12:49', '2026-01-13 07:12:49', '2025-12-27 07:12:49', NULL, NULL, NULL),
(3, 'ORD-20251227-0003', '1212', 1, 1, 'ghghjg', '2025-12-27 07:20:00', '2026-01-12 07:20:00', '2025-12-27 07:20:00', NULL, NULL, NULL),
(4, 'ORD-20251227-0004', '1212', 1, 1, 'ghghjg', '2025-12-27 07:20:05', '2026-01-02 07:20:05', '2025-12-27 07:20:05', NULL, NULL, NULL),
(5, 'ORD-20251227-0005', '1212', 3, 3, 'ghghjg', '2025-12-27 07:38:00', '2026-01-05 07:38:34', '2026-01-29 11:58:05', NULL, NULL, NULL),
(6, 'ORD-20251227-0006', '1212', 1, 1, 'ghghjg', '2025-12-27 08:54:00', '2026-01-10 08:54:26', '2026-01-29 11:57:42', NULL, NULL, NULL),
(7, 'ORD-20251227-0007', '1212', 3, 3, 'ghghjg', '2025-12-27 08:55:00', '2026-01-15 08:55:37', '2026-01-15 13:49:23', NULL, NULL, NULL),
(8, 'ORD-20260125-0001', '26546', 1, 1, NULL, '2026-01-25 11:43:08', '2026-01-25 11:43:08', '2026-01-25 11:43:08', NULL, NULL, NULL),
(9, 'ORD-20260129-0001', '1212', 6, 4, NULL, '2026-01-29 13:14:55', '2026-01-29 13:14:55', '2026-01-29 13:14:55', NULL, NULL, NULL),
(10, 'ORD-20260129-0002', '1212', 6, 4, NULL, '2026-01-29 13:15:06', '2026-01-29 13:15:06', '2026-01-29 13:15:06', NULL, NULL, NULL),
(11, 'ORD-20260129-0003', '1212', 6, 4, NULL, '2026-01-29 13:15:07', '2026-01-29 13:15:07', '2026-01-29 13:15:07', NULL, NULL, NULL),
(12, 'ORD-20260130-0001', '1212', 6, 4, 'س', '2026-01-30 08:41:00', '2026-01-30 08:41:27', '2026-01-30 18:25:23', 1, NULL, NULL),
(13, 'ORD-20260130-0002', '45646', 1, 3, '5555555jhi', '2026-01-30 18:43:20', '2026-01-30 18:43:20', '2026-01-30 18:43:20', NULL, NULL, NULL),
(14, 'ORD-20260130-0003', '45646', 1, 3, '5555555jhi', '2026-01-30 18:49:27', '2026-01-30 18:49:27', '2026-01-30 18:49:27', NULL, NULL, NULL),
(15, 'ORD-20260130-0004', '45646', 1, 3, '5555555jhi', '2026-01-30 18:49:54', '2026-01-30 18:49:54', '2026-01-30 18:49:54', 1, NULL, NULL),
(16, 'ORD-20260130-0005', '45646', 1, 3, '5555555jhi', '2026-01-30 19:52:53', '2026-01-30 19:52:53', '2026-01-30 19:52:53', 1, NULL, NULL),
(17, 'ORD-20260131-0001', '45646', 1, 3, '5555555jhi', '2026-01-31 05:35:33', '2026-01-31 05:35:33', '2026-01-31 05:35:33', 1, 'App\\Models\\Resident', 1),
(18, 'ORD-20260131-0002', '45646', NULL, 3, '5555555jhi', '2026-01-31 05:40:58', '2026-01-31 05:40:58', '2026-01-31 05:40:58', 1, 'App\\Models\\Admin', 1),
(19, 'ORD-20260131-0003', '45646', NULL, 4, '5555555jhi', '2026-01-31 05:43:32', '2026-01-31 05:43:32', '2026-01-31 05:43:32', 1, 'App\\Models\\Admin', 1),
(20, 'ORD-20260131-0004', '45646', NULL, 3, '5555555jhi', '2026-01-31 05:43:47', '2026-01-31 05:43:47', '2026-01-31 05:43:47', 1, 'App\\Models\\Admin', 1),
(21, 'ORD-20260131-0005', '45646', NULL, 1, '5555555jhi', '2026-01-31 05:52:47', '2026-01-31 05:52:47', '2026-01-31 05:52:47', 1, 'App\\Models\\Admin', 1),
(22, 'ORD-20260131-0006', '45646', 1, 1, '5555555jhi', '2026-01-31 05:53:35', '2026-01-31 05:53:35', '2026-01-31 05:53:35', 1, 'App\\Models\\Resident', 1),
(23, 'ORD-20260131-0007', '45646', 7, 5, '5555555jhi', '2026-01-31 06:31:08', '2026-01-31 06:31:08', '2026-01-31 06:31:08', 1, 'App\\Models\\Resident', 7),
(24, 'ORD-20260131-0008', '45646', NULL, 5, '5555555jhi', '2026-01-31 06:33:39', '2026-01-31 06:33:39', '2026-01-31 06:33:39', 1, 'App\\Models\\Admin', 4),
(25, 'ORD-20260131-0009', '45646', NULL, 5, '5555555jhi', '2026-01-31 14:24:48', '2026-01-31 14:24:48', '2026-01-31 14:24:48', 1, 'App\\Models\\Admin', 4),
(26, NULL, '454', NULL, 5, '5555555jhi', '2026-01-31 14:58:11', '2026-01-31 14:58:11', '2026-01-31 14:58:11', 1, 'App\\Models\\Admin', 4),
(27, NULL, '454', NULL, 5, '5555555jhi', '2026-01-31 14:59:01', '2026-01-31 14:59:01', '2026-01-31 14:59:01', 1, 'App\\Models\\Admin', 4),
(28, 'ORD-2026-000028', '454', NULL, 5, '5555555jhi', '2026-01-31 15:00:18', '2026-01-31 15:00:18', '2026-01-31 15:00:18', 1, 'App\\Models\\Admin', 4),
(29, 'ORD-2026-000029', '454', NULL, 5, '5555555jhi', '2026-01-31 15:01:00', '2026-01-31 15:01:00', '2026-01-31 15:01:00', 1, 'App\\Models\\Admin', 4),
(30, 'ORD-2026-000030', '1212', 6, 1, NULL, '2026-01-31 15:02:04', '2026-01-31 15:02:04', '2026-01-31 15:02:04', NULL, 'App\\Models\\Resident', 6),
(31, 'ORD-2026-000031', '1212', 6, 1, NULL, '2026-01-31 15:02:16', '2026-01-31 15:02:16', '2026-01-31 15:02:16', NULL, 'App\\Models\\Resident', 6),
(32, NULL, '1212', 6, 1, NULL, '2026-01-31 15:06:05', '2026-01-31 15:06:05', '2026-01-31 15:06:05', NULL, 'App\\Models\\Resident', 6),
(33, NULL, '1212', 6, 1, NULL, '2026-01-31 15:07:58', '2026-01-31 15:07:58', '2026-01-31 15:07:58', NULL, 'App\\Models\\Resident', 6),
(34, 'ORD-2026-000034', '1212', 6, 1, NULL, '2026-01-31 15:17:22', '2026-01-31 15:17:22', '2026-01-31 15:17:22', NULL, 'App\\Models\\Resident', 6),
(35, 'ORD-2026-000035', '1212', 6, 1, NULL, '2026-01-31 15:17:26', '2026-01-31 15:17:26', '2026-01-31 15:17:26', NULL, 'App\\Models\\Resident', 6),
(36, 'ORD-2026-000036', '454', NULL, 5, '5555555jhi', '2026-01-31 15:17:34', '2026-01-31 15:17:34', '2026-01-31 15:17:34', 1, 'App\\Models\\Admin', 4),
(37, 'ORD-2026-000037', '454', NULL, 5, '5555555jhi', '2026-01-31 15:17:38', '2026-01-31 15:17:38', '2026-01-31 15:17:38', 1, 'App\\Models\\Admin', 4),
(38, 'ORD-2026-000038', '454', NULL, 5, '5555555jhi', '2026-01-31 15:17:39', '2026-01-31 15:17:39', '2026-01-31 15:17:39', 1, 'App\\Models\\Admin', 4),
(39, 'ORD-2026-000039', '1212', 6, 1, NULL, '2026-02-01 11:29:55', '2026-02-01 11:29:55', '2026-02-01 11:29:55', NULL, 'App\\Models\\Resident', 6),
(40, 'ORD-2026-000040', '1212', 6, 1, NULL, '2026-02-01 11:37:35', '2026-02-01 11:37:35', '2026-02-01 11:37:35', NULL, 'App\\Models\\Resident', 6),
(41, 'ORD-2026-000041', '1212', 6, 1, NULL, '2026-02-01 11:38:21', '2026-02-01 11:38:21', '2026-02-01 11:38:21', 1, 'App\\Models\\Resident', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(6, 'view users', 'web', '2025-06-08 16:07:48', '2025-06-08 16:07:48'),
(7, 'create users', 'web', '2025-06-08 16:08:00', '2025-06-08 16:08:00'),
(8, 'update users', 'web', '2025-06-08 16:08:12', '2025-06-08 16:08:12'),
(9, 'delete users', 'web', '2025-06-08 16:08:26', '2025-06-08 16:08:26'),
(10, 'view roles', 'web', '2025-06-08 16:11:27', '2025-06-08 16:11:27'),
(11, 'create roles', 'web', '2025-06-08 16:11:40', '2025-06-08 16:11:40'),
(12, 'update roles', 'web', '2025-06-08 16:11:50', '2025-06-08 16:11:50'),
(13, 'delete roles', 'web', '2025-06-08 16:12:02', '2025-06-08 16:12:02'),
(18, 'view permissions', 'web', '2025-06-08 16:28:43', '2025-06-08 16:28:43'),
(19, 'create permissions', 'web', '2025-06-08 16:28:54', '2025-06-08 16:28:54'),
(20, 'update permissions', 'web', '2025-06-08 16:29:04', '2025-06-08 16:29:04'),
(21, 'delete permissions', 'web', '2025-06-08 16:29:16', '2025-06-08 16:29:16'),
(45, 'view admin', 'web', '2025-12-27 08:33:48', '2025-12-27 08:33:48'),
(46, 'create admin', 'web', '2025-12-27 08:34:10', '2025-12-27 08:34:10'),
(47, 'delete admin', 'web', '2025-12-27 08:34:18', '2025-12-27 08:34:18'),
(48, 'update admin', 'web', '2025-12-27 08:34:35', '2025-12-27 08:34:35'),
(49, 'view Branch', 'web', '2025-12-27 08:38:38', '2025-12-27 08:38:38'),
(50, 'create Branch', 'web', '2025-12-27 08:38:44', '2025-12-27 08:38:44'),
(51, 'update Branch', 'web', '2025-12-27 08:38:53', '2025-12-27 08:38:53'),
(52, 'delete Branch', 'web', '2025-12-27 08:38:59', '2025-12-27 08:38:59'),
(53, 'view Resident', 'web', '2025-12-27 08:40:57', '2025-12-27 08:40:57'),
(54, 'update Resident', 'web', '2025-12-27 08:41:24', '2025-12-27 08:41:24'),
(55, 'delete Resident', 'web', '2025-12-27 08:41:30', '2025-12-27 08:41:30'),
(56, 'create Resident', 'web', '2025-12-27 08:41:36', '2025-12-27 08:41:36'),
(57, 'view orders', 'web', '2026-01-31 09:45:02', '2026-01-31 09:45:24'),
(58, 'update orders', 'web', '2026-01-31 09:45:42', '2026-01-31 09:45:42'),
(59, 'view Delivery Apps', 'web', '2026-01-31 12:35:55', '2026-01-31 12:35:55'),
(60, 'create Delivery Apps', 'web', '2026-01-31 12:36:08', '2026-01-31 12:36:08'),
(61, 'delete Delivery Apps', 'web', '2026-01-31 12:36:15', '2026-01-31 12:36:15'),
(62, 'update Delivery Apps', 'web', '2026-01-31 12:36:35', '2026-01-31 12:37:19'),
(63, 'create Subscription', 'web', '2026-01-31 12:39:12', '2026-01-31 12:39:12'),
(64, 'update Subscription', 'web', '2026-01-31 12:39:20', '2026-01-31 12:39:20'),
(65, 'delete Subscription', 'web', '2026-01-31 12:39:27', '2026-01-31 12:39:27'),
(67, 'view Subscription', 'web', '2026-01-31 14:05:08', '2026-01-31 14:05:08'),
(68, 'view plans', 'web', '2026-01-31 14:07:26', '2026-01-31 14:07:26'),
(69, 'update plans', 'web', '2026-01-31 14:07:33', '2026-01-31 14:07:33'),
(70, 'delete plans', 'web', '2026-01-31 14:07:39', '2026-01-31 14:07:39'),
(71, 'create plans', 'web', '2026-01-31 14:07:46', '2026-01-31 14:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `interval` enum('monthly','yearly','lifetime') COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_branches` int DEFAULT NULL,
  `max_residents` int DEFAULT NULL,
  `max_orders_per_month` int DEFAULT NULL,
  `features` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `trial_days` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `description`, `price`, `interval`, `max_branches`, `max_residents`, `max_orders_per_month`, `features`, `is_active`, `trial_days`, `created_at`, `updated_at`) VALUES
(1, 'Osama Ahmed', 'التا', 500.00, 'monthly', NULL, NULL, NULL, '[]', 1, 5, '2026-01-16 15:51:42', '2026-01-17 08:41:31'),
(2, 'سنويه', 'جيده', 5555555.00, 'yearly', NULL, NULL, NULL, NULL, 1, 1, '2026-01-31 06:17:01', '2026-01-31 06:17:01'),
(3, 'f', 'f', 65.00, 'monthly', NULL, NULL, NULL, NULL, 1, 0, '2026-01-31 14:22:37', '2026-01-31 14:22:37'),
(4, 'c', NULL, 5.00, 'monthly', NULL, NULL, NULL, NULL, 0, 0, '2026-01-31 14:23:43', '2026-01-31 14:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `name`, `phone`, `password`, `branch_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Osama Ahmed', '441', '$2y$12$lX600KNNNXlbMeVGHIRvuO1A27fjSnyuXOGdNf7qphNnpkWz22nB.', 1, 1, '2025-12-26 20:04:18', '2026-02-03 09:10:05'),
(3, 'mgd', '7183232599', '$2y$12$RtNCrJJeoFQjFUl6TNizluu/ICySYPryzKQX3q2moC8t9E6pHnVQG', 3, 1, '2025-12-27 08:45:57', '2026-02-03 06:16:14'),
(5, 'Osama 56', '8956556666666', '$2y$12$8uz1S424bL2bVplIHej.0el8y8RvlFsub6x86nW.vI1ONLa1WbC2a', 1, 1, '2026-01-29 12:00:54', '2026-01-31 05:55:47'),
(6, 'mgd', '4455555', '$2y$12$l6/HJYGM/yljAJ4J4bM8yeEyMg2BN9S2PFgX8BCSdf/9GdbHyBHX6', 4, 1, '2026-01-29 13:06:22', '2026-01-31 05:55:47'),
(7, 'osvu', '718323599', '$2y$12$odUF2E1bnDBh2Kyfjam4juRkdhy3X1aK0fijUb8bl1Hu5JAQarxve', 5, 1, '2026-01-31 06:28:25', '2026-02-03 09:11:57'),
(8, 'mgd', '777888555', '$2y$12$MK3lheBQHpojEyZviyCQHeL2OzqsODTsvcteCrPQSGfumRwgR2qHC', 3, 1, '2026-02-02 10:57:58', '2026-02-02 10:57:58');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-06-08 14:40:14', '2025-06-08 14:40:14'),
(2, 'admin2', 'web', '2025-06-08 14:59:24', '2025-06-08 14:59:24'),
(3, 'normal', 'web', '2025-06-23 07:06:02', '2025-06-23 07:06:02'),
(5, 'admin27', 'web', '2025-07-22 13:28:07', '2025-07-22 13:28:07');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(6, 3),
(10, 3),
(18, 3),
(7, 5),
(11, 5),
(19, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('OLA39LEQOzLFWMIS26JrPNZ6fGJkglG2njPG2zvr', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidmhrbWdHVGtVcXMwMzdwd3MxRERqQzE4ZVpCeUhKdklOUm53MHQ5WSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFFCWEdJTFkzVGtId2c3NXdHM2ouQk9KV1M5OG1ndTVYeUpkMjFTUy5uVDRvTElLTml6WEVPIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAxL2FkbWluL3BsYW5zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770216953),
('Yw6Hu5uBH48womne6Wu1DotpADKmeaNVgKeIUBks', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiS2xRMUlUN1ZvUWZWOHBIb1Z1M0RKOGZEQmRYUlRQTVJUYTdXdmdoNCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFFCWEdJTFkzVGtId2c3NXdHM2ouQk9KV1M5OG1ndTVYeUpkMjFTUy5uVDRvTElLTml6WEVPIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3NsaWRlcnMvMS9lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo4OiJmaWxhbWVudCI7YTowOnt9fQ==', 1770130504);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'sliders/01KGHZZM7YQVSZ0J3MZZE6DAE7.webp', 1, '2026-02-01 16:47:33', '2026-02-03 11:54:53'),
(2, 'sliders/01KGHZY4F62SCDM3WA8JH1EDCB.webp', 1, '2026-02-01 16:47:52', '2026-02-03 11:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Test Staff', 'staff@test.com', '$2y$12$QKI8wOL4PeWtsVXKLGuq.ePw5S3HYK/wqlZrG8gR/2ffLPQq0dXlq', '2025-09-12 16:37:35', '2025-09-12 16:37:35'),
(2, 'اسامه', 'os@test.com', '$2y$12$.R5UMexBRpT3T6pi1dNGaefPL21jWGaVo/OCXXBW1kYS8uaqPqGIu', '2025-09-12 16:47:49', '2025-09-12 16:47:49');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `plan_id` bigint UNSIGNED NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `starts_at` timestamp NOT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `canceled_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','canceled','expired','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `admin_id`, `plan_id`, `trial_ends_at`, `starts_at`, `ends_at`, `canceled_at`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(14, 1, 1, '2026-01-18 08:41:10', '2026-01-17 08:41:10', '2026-02-17 08:41:10', '2026-01-17 08:48:20', 'canceled', '2026-01-17 08:41:10', '2026-01-17 08:48:20', NULL),
(15, 1, 1, '2026-01-22 08:48:29', '2026-01-17 08:48:29', '2026-02-17 08:48:29', NULL, 'suspended', '2026-01-17 08:48:29', '2026-01-17 08:54:51', NULL),
(16, 1, 1, NULL, '2026-01-17 08:54:58', '2026-02-17 08:54:58', NULL, 'suspended', '2026-01-17 08:54:58', '2026-01-25 11:43:46', NULL),
(17, 1, 1, '2026-01-30 11:51:36', '2026-01-25 11:51:36', '2026-02-25 11:51:36', '2026-01-25 11:52:41', 'canceled', '2026-01-25 11:51:36', '2026-01-25 11:52:41', NULL),
(18, 1, 1, '2026-01-30 12:51:48', '2026-01-25 12:51:48', '2026-02-25 12:51:48', NULL, 'suspended', '2026-01-25 12:51:48', '2026-01-29 12:11:03', NULL),
(19, 3, 1, '2026-02-03 12:09:37', '2026-01-29 12:09:37', '2026-03-01 12:09:37', '2026-01-29 12:10:12', 'canceled', '2026-01-29 12:09:37', '2026-01-29 12:10:12', NULL),
(20, 3, 1, NULL, '2026-01-29 12:10:42', '2026-03-01 12:10:42', NULL, 'suspended', '2026-01-29 12:10:42', '2026-01-29 12:10:55', NULL),
(21, 1, 1, NULL, '2026-01-29 12:12:37', '2026-03-01 12:12:37', NULL, 'suspended', '2026-01-29 12:12:37', '2026-01-29 12:13:47', NULL),
(22, 1, 1, NULL, '2026-01-29 12:15:02', '2026-03-01 12:15:02', '2026-01-29 12:18:23', 'canceled', '2026-01-29 12:15:02', '2026-01-29 12:18:23', NULL),
(23, 1, 1, NULL, '2026-01-29 12:28:45', '2026-03-01 12:28:45', NULL, 'suspended', '2026-01-29 12:28:45', '2026-01-29 12:54:51', NULL),
(24, 1, 1, NULL, '2026-01-29 12:55:28', '2026-03-01 12:55:28', '2026-01-29 12:56:18', 'canceled', '2026-01-29 12:55:28', '2026-01-29 12:56:18', NULL),
(25, 1, 1, NULL, '2026-01-29 12:57:20', '2026-03-01 12:57:20', NULL, 'suspended', '2026-01-29 12:57:20', '2026-01-29 13:13:25', NULL),
(26, 1, 1, '2026-02-03 13:18:29', '2026-01-29 13:18:29', '2026-03-01 13:18:29', NULL, 'suspended', '2026-01-29 13:18:29', '2026-01-30 08:52:48', NULL),
(27, 2, 1, NULL, '2026-01-29 13:18:37', '2026-03-01 13:18:37', NULL, 'active', '2026-01-29 13:18:37', '2026-01-29 13:18:37', NULL),
(28, 3, 1, NULL, '2026-01-29 13:18:45', '2026-03-01 13:18:45', '2026-01-31 07:19:38', 'canceled', '2026-01-29 13:18:45', '2026-01-31 07:19:38', NULL),
(29, 1, 1, NULL, '2026-01-30 08:56:41', '2026-03-02 08:56:41', NULL, 'suspended', '2026-01-30 08:56:41', '2026-01-31 05:55:31', NULL),
(30, 1, 1, '2026-02-05 05:55:47', '2026-01-31 05:55:47', '2026-03-03 05:55:47', NULL, 'active', '2026-01-31 05:55:47', '2026-01-31 05:55:47', NULL),
(31, 4, 2, NULL, '2026-01-31 06:17:32', '2027-01-31 06:17:32', '2026-01-31 06:17:42', 'canceled', '2026-01-31 06:17:32', '2026-01-31 06:17:42', NULL),
(32, 4, 2, '2025-11-01 06:17:55', '2025-12-03 06:17:55', '2025-12-02 06:17:55', NULL, 'expired', '2026-01-31 06:17:55', '2026-01-31 06:36:26', NULL),
(33, 4, 2, NULL, '2026-01-31 07:04:18', '2027-01-31 07:04:18', NULL, 'expired', '2026-01-31 07:04:18', '2026-01-31 07:04:18', NULL),
(34, 4, 2, '2026-02-01 07:04:58', '2026-01-31 07:04:58', '2027-01-31 07:04:58', NULL, 'expired', '2026-01-31 07:04:58', '2026-01-31 07:04:58', NULL),
(35, 4, 1, '2026-02-05 07:05:36', '2026-01-31 07:05:36', '2026-03-03 07:05:36', NULL, 'suspended', '2026-01-31 07:05:36', '2026-01-31 07:11:56', NULL),
(36, 4, 1, NULL, '2026-01-31 07:12:09', '2026-03-03 07:12:09', '2026-01-31 07:12:59', 'canceled', '2026-01-31 07:12:09', '2026-01-31 07:12:59', NULL),
(37, 4, 2, NULL, '2026-01-31 07:19:04', '2027-01-31 07:19:04', '2026-01-31 07:22:10', 'canceled', '2026-01-31 07:19:04', '2026-01-31 07:22:10', NULL),
(38, 5, 1, NULL, '2026-01-31 07:21:33', '2026-03-03 07:21:33', NULL, 'active', '2026-01-31 07:21:33', '2026-01-31 07:21:33', NULL),
(39, 4, 2, NULL, '2026-01-31 07:30:49', '2027-01-31 07:30:49', NULL, 'active', '2026-01-31 07:30:49', '2026-01-31 07:30:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_renewal_requests`
--

CREATE TABLE `subscription_renewal_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `transfer_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_renewal_requests`
--

INSERT INTO `subscription_renewal_requests` (`id`, `admin_id`, `transfer_number`, `notes`, `status`, `reviewed_at`, `reviewed_by`, `created_at`, `updated_at`) VALUES
(1, 1, '454544545', NULL, 'rejected', '2026-01-30 09:01:57', 1, '2026-01-30 09:01:27', '2026-01-30 09:02:08'),
(2, 1, '454544545', NULL, 'approved', '2026-01-30 09:09:22', 1, '2026-01-30 09:04:47', '2026-01-30 09:09:22'),
(3, 3, '454545', NULL, 'approved', '2026-01-30 09:09:17', 1, '2026-01-30 09:07:51', '2026-01-30 09:09:17'),
(4, 1, '454544545', 'JGYJGYJHFGYHJFYUJF', 'rejected', '2026-01-30 09:10:09', 1, '2026-01-30 09:09:38', '2026-01-30 09:10:09'),
(5, 4, '545645', NULL, 'approved', '2026-01-31 12:34:34', 4, '2026-01-31 09:35:43', '2026-01-31 12:34:34'),
(6, 4, '545645', 'fyufy', 'pending', NULL, NULL, '2026-02-01 11:58:10', '2026-02-01 11:58:10');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_usage`
--

CREATE TABLE `subscription_usage` (
  `id` bigint UNSIGNED NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `feature` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `used` int NOT NULL DEFAULT '0',
  `reset_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'asaam4292@gmail.com', NULL, '$2y$12$QBXGILY3TkHwg75wG3j.BOJWS98mgu5XyJd21SS.nT4oLIKNizXEO', '9nG9wsBz3yQZbHysssDMk8AK6735BL1IaoGn2BgnIDl9o6aKdye54TxdPuIi', '2025-06-01 08:33:16', '2025-07-11 12:34:10'),
(4, 'news editor', 'asasa2@gmail.come', NULL, '$2y$12$JzObJysDBlmbmjOeX1faV.XR5gFLGC2vL9bJfPSd6Jye0iB2B0H6G', 'nN1YuywA3Dhp7x8IDZi0NBKmCCz8dKzq9OyAsbrijnV93HlMQ2WMRZkt77qE', '2025-06-08 14:48:56', '2026-01-31 12:34:09'),
(5, 'mgd', 'mgd@admin.com', NULL, '$2y$12$gBoxbIq4dLC9DEPZEYRASuqU65WtmjgWzI3MEiV1tdm9LnvobnLFm', 'iy9pIhqEQwTi2Foy1ALbYFoUIsOiKSpiF7tafuDm0rxt12XvIOtHCfIxkaii', '2025-06-23 07:07:12', '2025-06-23 07:07:12'),
(6, 'Admin', 'admin@example.com', NULL, '$2y$12$I9BrrJ9SBOxnrbbtpTiyBuaJb03Yfg/RDbKfga0VSD35Jt7rrjPci', NULL, '2025-07-11 12:14:40', '2025-07-11 12:14:40'),
(7, 'user2', 'user2@asest.com', NULL, '$2y$12$xbW7rn.c6itfWGkyEyM60OFjMpkkgvW6vJkaqPCOsWajj7cKeTzsK', NULL, '2025-07-22 13:26:09', '2025-07-22 13:26:09'),
(8, 'user', 'user@gmail.come', NULL, '$2y$12$qMa4uW23UhOjVqYqlYwkZeGlhsLSki9g3pJMezl09kG4P9dTw.p7e', NULL, '2025-07-25 09:28:57', '2025-07-25 09:28:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_branch`
--
ALTER TABLE `admin_branch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_branch_admin_id_foreign` (`admin_id`),
  ADD KEY `admin_branch_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `delivery_apps`
--
ALTER TABLE `delivery_apps`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_owner_type_owner_id_index` (`owner_type`,`owner_id`);

--
-- Indexes for table `oauth_device_codes`
--
ALTER TABLE `oauth_device_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oauth_device_codes_user_code_unique` (`user_code`),
  ADD KEY `oauth_device_codes_user_id_index` (`user_id`),
  ADD KEY `oauth_device_codes_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_resident_id_foreign` (`resident_id`),
  ADD KEY `orders_branch_id_foreign` (`branch_id`),
  ADD KEY `orders_created_by_type_created_by_id_index` (`created_by_type`,`created_by_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `residents_branch_id_index` (`branch_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_email_unique` (`email`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_admin_id_foreign` (`admin_id`),
  ADD KEY `subscriptions_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `subscription_renewal_requests`
--
ALTER TABLE `subscription_renewal_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_renewal_requests_reviewed_by_foreign` (`reviewed_by`),
  ADD KEY `subscription_renewal_requests_admin_id_status_index` (`admin_id`,`status`),
  ADD KEY `subscription_renewal_requests_created_at_index` (`created_at`);

--
-- Indexes for table `subscription_usage`
--
ALTER TABLE `subscription_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_usage_subscription_id_foreign` (`subscription_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admin_branch`
--
ALTER TABLE `admin_branch`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery_apps`
--
ALTER TABLE `delivery_apps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `subscription_renewal_requests`
--
ALTER TABLE `subscription_renewal_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subscription_usage`
--
ALTER TABLE `subscription_usage`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_branch`
--
ALTER TABLE `admin_branch`
  ADD CONSTRAINT `admin_branch_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_branch_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_resident_id_foreign` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `residents`
--
ALTER TABLE `residents`
  ADD CONSTRAINT `residents_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscription_renewal_requests`
--
ALTER TABLE `subscription_renewal_requests`
  ADD CONSTRAINT `subscription_renewal_requests_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscription_renewal_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `subscription_usage`
--
ALTER TABLE `subscription_usage`
  ADD CONSTRAINT `subscription_usage_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;