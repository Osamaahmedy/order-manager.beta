-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 27, 2025 at 12:02 PM
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
(1, 'Osama Ahmed', 'asasa@gmail.come', '$2y$12$JVQd0ZvnGlc.K4K9E7T4ROMRNXu6QdkjWEbnuMHoKcad7fqony6VO', '0718323599', NULL, '2025-12-26 19:10:05', '2025-12-26 19:10:05'),
(2, 'mgd', 'mgd@gmail.com', '$2y$12$mVeOeLFRh0lNmy6xuN8/iuDOCebt5YnspS.nYH70svAb4LTJy9bHO', '718323599', NULL, '2025-12-27 08:44:41', '2025-12-27 08:58:07');

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
(1, 1, 2, '2025-12-26 19:10:05', '2025-12-26 19:10:05'),
(5, 1, 1, '2025-12-27 08:19:52', '2025-12-27 08:19:52'),
(6, 2, 3, '2025-12-27 08:44:41', '2025-12-27 08:44:41');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `location`, `created_at`, `updated_at`) VALUES
(1, 'اثار', 'لحج - صبر', '2025-12-26 19:09:04', '2025-12-26 19:09:04'),
(2, 'Osama Ahmed', 'عدن - المنصورة', '2025-12-26 19:09:20', '2025-12-26 19:09:20'),
(3, 'gta', '545', '2025-12-27 08:44:04', '2025-12-27 08:44:04');

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
('laravel_cache_356a192b7913b04c54574d18c28d46e6395428ab', 'i:2;', 1766825089),
('laravel_cache_356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1766825089;', 1766825089),
('laravel_cache_livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1766836765),
('laravel_cache_livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1766836765;', 1766836765),
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:46:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:1;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:10:\"view users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:2;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"create users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:3;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"update users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:12:\"delete users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:10:\"view roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:6;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:12:\"create roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:7;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:12:\"update roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:12:\"delete roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:16:\"view permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:10;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:18:\"create permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:11;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:18:\"update permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:18:\"delete permissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:11:\"view assets\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:14;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:12:\"delete activ\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:15;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:10:\"view maint\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:16;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:12:\"delete maint\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:12:\"update maint\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:12:\"create maint\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:19;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:13:\"create assets\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:20;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:13:\"update assets\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:13:\"delete assets\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:22;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:9:\"view dept\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:23;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:11:\"create dept\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:24;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:11:\"update dept\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:11:\"delete dept\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:10:\"view activ\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:27;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:12:\"create activ\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:28;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:12:\"update activ\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:8:\"view nav\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:30;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:10:\"delete del\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:10:\"update del\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:8:\"view del\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:33;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:6:\"asest4\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:10:\"view admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:12:\"create admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:12:\"delete admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:12:\"update admin\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:11:\"view Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:13:\"create Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:13:\"update Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:13:\"delete Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:13:\"view Resident\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:15:\"update Resident\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:15:\"delete Resident\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:15:\"create Resident\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:3:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:7:\"admin27\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:6:\"normal\";s:1:\"c\";s:3:\"web\";}}}', 1766922108);

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
(55, 'App\\Models\\Order', 6, '81f481ed-c6ca-4440-a446-9ef046defceb', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 2, '2025-12-27 08:54:26', '2025-12-27 08:54:26'),
(56, 'App\\Models\\Order', 7, '7450eb47-ab2f-47a4-b3f3-b59fcbc0d9fd', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 1, '2025-12-27 08:55:37', '2025-12-27 08:55:37'),
(57, 'App\\Models\\Order', 7, '2120efe9-3cbf-4513-9296-8f8ae7f4b85c', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 2, '2025-12-27 08:55:37', '2025-12-27 08:55:37');

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
(39, '2025_12_27_083619_create_orders_table', 16);

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
(3, 'App\\Models\\User', 4),
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
('1d05b9c4f4453cb8d51324a69b29b1193edc0b24803a546f14fef5bc5a8dd037631513e2c3b97b64', 3, '019b5d24-2e5f-71c6-b472-ff01043adb4f', 'resident-token', '[]', 0, '2025-12-27 08:50:41', '2025-12-27 08:50:41', '2026-12-27 11:50:41'),
('6bd1cf77394851b94eec42c00a95383475af58cc6173783628072f0d45eadf03568e706410889a29', 1, '019b5d24-6f4d-73ae-8aeb-844821b59779', 'admin-token', '[]', 0, '2025-12-27 06:22:47', '2025-12-27 06:22:47', '2026-12-27 09:22:47'),
('7a3395f3aa553aa7bdb2ea46fd03fd00059c5b80e04a2925830199dc688c86553a43818ee68e70fe', 2, '019b5d24-2e5f-71c6-b472-ff01043adb4f', 'resident-token', '[]', 0, '2025-12-27 07:37:30', '2025-12-27 07:37:30', '2026-12-27 10:37:30'),
('bac2a4881aec6e82d1f7ee83aa05f9d16e62af2493b63ebc3dfcdf02ab061a63a159996a16732e7d', 1, '019b5d24-2e5f-71c6-b472-ff01043adb4f', 'resident-token', '[]', 0, '2025-12-27 07:37:55', '2025-12-27 07:37:55', '2026-12-27 10:37:55');

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
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resident_id` bigint UNSIGNED NOT NULL,
  `branch_id` bigint UNSIGNED NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `number`, `resident_id`, `branch_id`, `notes`, `submitted_at`, `created_at`, `updated_at`) VALUES
(1, 'ORD-20251227-0001', '', 1, 1, 'khkljhlkj', '2025-12-27 05:43:27', '2025-12-27 05:44:19', '2025-12-27 06:09:44'),
(2, 'ORD-20251227-0002', '', 1, 1, 'ghghjg', '2025-12-27 07:12:49', '2025-12-27 07:12:49', '2025-12-27 07:12:49'),
(3, 'ORD-20251227-0003', '1212', 1, 1, 'ghghjg', '2025-12-27 07:20:00', '2025-12-27 07:20:00', '2025-12-27 07:20:00'),
(4, 'ORD-20251227-0004', '1212', 1, 1, 'ghghjg', '2025-12-27 07:20:05', '2025-12-27 07:20:05', '2025-12-27 07:20:05'),
(5, 'ORD-20251227-0005', '1212', 1, 1, 'ghghjg', '2025-12-27 07:38:34', '2025-12-27 07:38:34', '2025-12-27 07:38:34'),
(6, 'ORD-20251227-0006', '1212', 1, 1, 'ghghjg', '2025-12-27 08:54:26', '2025-12-27 08:54:26', '2025-12-27 08:54:26'),
(7, 'ORD-20251227-0007', '1212', 3, 3, 'ghghjg', '2025-12-27 08:55:37', '2025-12-27 08:55:37', '2025-12-27 08:55:37');

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
(1, 'admin', 'web', '2025-06-08 14:40:25', '2025-06-08 14:40:25'),
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
(22, 'view assets', 'web', '2025-07-12 14:50:02', '2025-07-12 14:50:02'),
(23, 'delete activ', 'web', '2025-07-12 14:51:58', '2025-07-12 14:54:34'),
(24, 'view maint', 'web', '2025-07-12 14:57:50', '2025-07-12 14:57:50'),
(25, 'delete maint', 'web', '2025-07-12 14:58:53', '2025-07-12 14:59:18'),
(26, 'update maint', 'web', '2025-07-12 15:00:19', '2025-07-12 15:00:19'),
(27, 'create maint', 'web', '2025-07-12 15:00:53', '2025-07-12 15:00:53'),
(28, 'create assets', 'web', '2025-07-12 15:02:22', '2025-07-12 15:02:22'),
(29, 'update assets', 'web', '2025-07-12 15:02:43', '2025-07-12 15:02:43'),
(30, 'delete assets', 'web', '2025-07-12 15:03:09', '2025-07-12 15:03:09'),
(31, 'view dept', 'web', '2025-07-12 15:04:22', '2025-07-12 15:04:22'),
(32, 'create dept', 'web', '2025-07-12 15:04:46', '2025-07-12 15:04:46'),
(33, 'update dept', 'web', '2025-07-12 15:05:06', '2025-07-12 15:05:06'),
(34, 'delete dept', 'web', '2025-07-12 15:05:36', '2025-07-12 15:05:36'),
(35, 'view activ', 'web', '2025-07-12 15:06:32', '2025-07-12 15:06:32'),
(36, 'create activ', 'web', '2025-07-12 15:07:15', '2025-07-12 15:07:15'),
(37, 'update activ', 'web', '2025-07-12 15:07:40', '2025-07-12 15:07:40'),
(40, 'view nav', 'web', '2025-07-14 17:38:18', '2025-07-14 17:38:18'),
(41, 'delete del', 'web', '2025-07-14 17:38:52', '2025-07-14 17:39:33'),
(42, 'update del', 'web', '2025-07-14 17:40:05', '2025-07-14 17:40:05'),
(43, 'view del', 'web', '2025-07-14 17:40:38', '2025-07-14 17:40:38'),
(44, 'asest4', 'web', '2025-07-22 13:29:08', '2025-07-22 13:29:22'),
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
(56, 'create Resident', 'web', '2025-12-27 08:41:36', '2025-12-27 08:41:36');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `name`, `phone`, `password`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'Osama Ahmed', '441', '$2y$12$VZgZERb/xTdS1kqtQerYVuaWgs/5z./.iIq24iHKge7rV6UO4A0jC', 1, '2025-12-26 20:04:18', '2025-12-27 05:43:23'),
(3, 'mgd', '7183232599', '$2y$12$ty3Q1Y.s1ux8oT6Yzsw6Uu0yB4S6X7owZMQaMDM7mi9IlTETuajiG', 3, '2025-12-27 08:45:57', '2025-12-27 08:49:42');

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
(1, 1),
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
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
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
(6, 3),
(10, 3),
(18, 3),
(22, 3),
(24, 3),
(31, 3),
(35, 3),
(40, 3),
(43, 3),
(1, 5),
(7, 5),
(11, 5),
(19, 5),
(23, 5),
(27, 5),
(28, 5),
(30, 5),
(32, 5),
(35, 5),
(36, 5);

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
('Rti9nIfcmKuay9MHuYnzsNNcVURreFU43zaZADSv', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoib05FcHV5N2VFU2k2WjhtcDFtaEVObUdNSTlqQUhnWVY2c2dta28zeiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFFCWEdJTFkzVGtId2c3NXdHM2ouQk9KV1M5OG1ndTVYeUpkMjFTUy5uVDRvTElLTml6WEVPIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2FkbWlucy8yL2VkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjg6ImZpbGFtZW50IjthOjA6e319', 1766836694),
('zkwc0F7mK6InuUDIgAAYx2ADHVBzjJAhbnofzTSf', 2, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiamczWjROekdiVGRDZGhaTEpuN1MzVEQ2c3pvZjRSMkYzVHRJRzJFdyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYW5hZ2Vycy9vcmRlcnMvNyI7fXM6NTM6ImxvZ2luX2FkbWluc181OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoyMDoicGFzc3dvcmRfaGFzaF9hZG1pbnMiO3M6NjA6IiQyeSQxMiRtVmVPZUxGUmgwbE5teTZ4dU44L2l1RE9DZWJ0NVluc3BTLm5ZSDcwc3ZBYjRMVEp5OWJITyI7fQ==', 1766836759);

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
(4, 'news editor', 'asasa2@gmail.come', NULL, '$2y$12$.hDlD.aq.7xBUro4Uj1kFuRlxUSsRCiOKDfz/.OBVnlulpcDqLv0u', 'nN1YuywA3Dhp7x8IDZi0NBKmCCz8dKzq9OyAsbrijnV93HlMQ2WMRZkt77qE', '2025-06-08 14:48:56', '2025-06-08 16:33:02'),
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
  ADD KEY `orders_branch_id_foreign` (`branch_id`);

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
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `residents_branch_id_unique` (`branch_id`);

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
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_email_unique` (`email`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_branch`
--
ALTER TABLE `admin_branch`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
