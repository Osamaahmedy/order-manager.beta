-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 17, 2026 at 12:22 PM
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
(1, 'Osama Ahmed', 'asasa@gmail.come', '$2y$12$4UGg10unBowaLk18UUOD4OxW4nxqPVYNZ57Eu/.WbcHztPe9/KMXi', '0718323599', '5sJjU6kMCIjJV4jj9bt2XtnYGXDeTHeHvlJL08a4y01abwYE6ZpNwmZHDyXy', '2026-01-08 19:10:05', '2026-01-17 08:29:55'),
(2, 'mgd', 'mgd@gmail.com', '$2y$12$/6jvu./GxuL6CEMJYwFXDOhS46vphCswOJ1vViwNe9ZAkU.dbCgjW', '123123123', NULL, '2025-12-27 08:44:41', '2026-01-17 08:12:39');

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
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `location`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'اثار', 'لحج - صبر', 1, '2026-01-08 19:09:04', '2026-01-17 08:54:58'),
(2, 'Osama Ahmed', 'عدن - المنصورة', 1, '2025-12-26 19:09:20', '2026-01-17 08:54:58'),
(3, 'gta', '545', 0, '2025-12-27 08:44:04', '2026-01-16 16:05:13');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(56, 'App\\Models\\Order', 6, '7450eb47-ab2f-47a4-b3f3-b59fcbc0d9fd', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 1, '2025-12-27 08:55:37', '2025-12-27 08:55:37'),
(57, 'App\\Models\\Order', 6, '2120efe9-3cbf-4513-9296-8f8ae7f4b85c', 'images', 'Logo Invert V', 'Logo-Invert-V.png', 'image/png', 'public', 'public', 228991, '[]', '[]', '[]', '[]', 2, '2025-12-27 08:55:37', '2025-12-27 08:55:37'),
(58, 'App\\Models\\Order', 7, 'e12faf4f-16ec-4f75-8d61-9c34a31547cd', 'images', 'QuickDBD-Free Diagram (1)', '01KF18X25MME44DM3RN3VVK2DM.png', 'image/png', 'public', 'public', 408381, '[]', '[]', '[]', '[]', 1, '2026-01-15 13:47:59', '2026-01-15 13:47:59'),
(59, 'App\\Models\\Order', 7, 'e0934250-40ad-49cf-bf37-aff8dce24957', 'images', 'QuickDBD-Free Diagram', '01KF18X26S1SPKDNM0ZTJKCNJZ.png', 'image/png', 'public', 'public', 423981, '[]', '[]', '[]', '[]', 2, '2026-01-15 13:47:59', '2026-01-15 13:47:59'),
(60, 'App\\Models\\Order', 7, '9be7dd34-1762-412c-8858-0ae13d20e23e', 'images', 'Logo V', '01KF18X27GBKJCBRXNPWKP5X29.png', 'image/png', 'public', 'public', 241863, '[]', '[]', '[]', '[]', 3, '2026-01-15 13:47:59', '2026-01-15 13:47:59'),
(61, 'App\\Models\\Order', 7, '23d312f0-dd4c-4103-a204-b3a54318d15a', 'images', 'WhatsApp Image 2025-09-14 at 11.38.41 PM', '01KF18X282TWK33VJSAMWBABCE.jpeg', 'image/jpeg', 'public', 'public', 4786, '[]', '[]', '[]', '[]', 4, '2026-01-15 13:47:59', '2026-01-15 13:47:59'),
(62, 'App\\Models\\Order', 7, 'ced40f47-0ce4-4612-8340-5e39f497845b', 'images', 'Logo V', '01KF18X28KQE7MWTF6Q2M46PXV.png', 'image/png', 'public', 'public', 241863, '[]', '[]', '[]', '[]', 5, '2026-01-15 13:47:59', '2026-01-15 13:47:59');

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
(40, '2026_01_16_152232_create_plans_table', 17);

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
('29d2ea6a83fc6ee1a0a88cfa104c10c49309e874da00ee39e53c3f135fec84ba2e035cdb5b28d259', 2, '019b5d24-6f4d-73ae-8aeb-844821b59779', 'admin-token', '[]', 0, '2026-01-17 08:12:49', '2026-01-17 08:12:49', '2027-01-17 11:12:49'),
('7a3395f3aa553aa7bdb2ea46fd03fd00059c5b80e04a2925830199dc688c86553a43818ee68e70fe', 2, '019b5d24-2e5f-71c6-b472-ff01043adb4f', 'resident-token', '[]', 0, '2025-12-27 07:37:30', '2025-12-27 07:37:30', '2026-12-27 10:37:30'),
('7bf3e6f7879878fbb9989a62cf33dcc6901304db32cd9693fb9dbdcb2949f8b5fbaf6a0acfe83fe9', 1, '019b5d24-6f4d-73ae-8aeb-844821b59779', 'admin-token', '[]', 0, '2026-01-17 08:12:14', '2026-01-17 08:12:14', '2027-01-17 11:12:14'),
('90f148498d874313177158ef70c09e1b7ec061961cdc7b8b31a1ddc7e45ab186f45aacdf18749231', 1, '019b5d24-2e5f-71c6-b472-ff01043adb4f', 'resident-token', '[]', 0, '2026-01-17 08:37:30', '2026-01-17 08:37:30', '2027-01-17 11:37:30');

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
(1, 'ORD-20251227-0001', '', 1, 1, 'khkljhlkj', '2025-12-27 05:43:27', '2026-01-08 05:44:19', '2025-12-27 06:09:44'),
(2, 'ORD-20251227-0002', '', 1, 1, 'ghghjg', '2025-12-27 07:12:49', '2026-01-13 07:12:49', '2025-12-27 07:12:49'),
(3, 'ORD-20251227-0003', '1212', 1, 1, 'ghghjg', '2025-12-27 07:20:00', '2026-01-12 07:20:00', '2025-12-27 07:20:00'),
(4, 'ORD-20251227-0004', '1212', 1, 1, 'ghghjg', '2025-12-27 07:20:05', '2026-01-02 07:20:05', '2025-12-27 07:20:05'),
(5, 'ORD-20251227-0005', '1212', 1, 1, 'ghghjg', '2025-12-27 07:38:34', '2026-01-05 07:38:34', '2025-12-27 07:38:34'),
(6, 'ORD-20251227-0006', '1212', 1, 1, 'ghghjg', '2025-12-27 08:54:26', '2026-01-10 08:54:26', '2025-12-27 08:54:26'),
(7, 'ORD-20251227-0007', '1212', 3, 3, 'ghghjg', '2025-12-27 08:55:00', '2026-01-15 08:55:37', '2026-01-15 13:49:23');

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
(1, 'Osama Ahmed', 'التا', 500.00, 'monthly', NULL, NULL, NULL, '[]', 1, 5, '2026-01-16 15:51:42', '2026-01-17 08:41:31');

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
(1, 'Osama Ahmed', '441', '$2y$12$zkQspkQIpZ2.LFNr6nssu.kZyoUh2A9ZvdH52calf70/iHtGeZ1y6', 1, 1, '2025-12-26 20:04:18', '2026-01-17 08:54:58'),
(3, 'mgd', '7183232599', '$2y$12$ty3Q1Y.s1ux8oT6Yzsw6Uu0yB4S6X7owZMQaMDM7mi9IlTETuajiG', 3, 0, '2025-12-27 08:45:57', '2026-01-16 16:05:13');

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
('4YhPL1eeU3UuLisOjiZaHpgACEhheAGeKWFjhofS', NULL, '127.0.0.1', 'PostmanRuntime/7.49.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYU10d1JpYjNqTU1rQjhGMHZ5QUk2TWpmVHBZRGIxaGF0eVVCU2tvOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768590831),
('eDxSnIb1OLBqJpdzK9eidrO3mktHTglUyCSA07OB', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoieGVSZERYdXRvcjliN1c3aXhwbWVsaW5UaUJBVE5lNXRJMGNDZ1dUNSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbWFuYWdlcnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUzOiJsb2dpbl9hZG1pbnNfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjA6InBhc3N3b3JkX2hhc2hfYWRtaW5zIjtzOjYwOiIkMnkkMTIkSlZRZDBadm5HbGMuSzRLOUU3VDRST01STlh1NlFka2pXRWJudU1Ib0tjYWQ3ZnFvbnk2Vk8iO30=', 1768592383),
('FyB7RmMbPzYLCXtHR2t8PCvTR1RlA0CuZZQALrSP', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidW5GbWtMSUw2Nm53UEdnTVhRQmRQVmZKamhoa3pMRFhNOTlyVzcydiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJFFCWEdJTFkzVGtId2c3NXdHM2ouQk9KV1M5OG1ndTVYeUpkMjFTUy5uVDRvTElLTml6WEVPIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3BsYW5zLzEvZWRpdCI7fXM6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1768592559),
('GXq3m06U7QLXAF4tz1lw6Uqlr0fTyySerPHNo4ve', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUHQyaHA5NnZxcjRkVTFIT0RkZ0hxTW5jTXJYRVpsS0VnNmgxa1JKdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hZG1pbnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkUUJYR0lMWTNUa0h3Zzc1d0czai5CT0pXUzk4bWd1NVh5SmQyMVNTLm5UNG9MSUtOaXpYRU8iO3M6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1768651042),
('MklFddl2lsWfyUgs48E9keAihjKboMcO0X6jllRH', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYnFKWWl5M1kwNFh4eW9sZXJxbXQ0bEFhbmVrMWxGMzV2eUNIMGk2NyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYW5hZ2Vycy9vcmRlcnMiO31zOjUzOiJsb2dpbl9hZG1pbnNfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjA6InBhc3N3b3JkX2hhc2hfYWRtaW5zIjtzOjYwOiIkMnkkMTIkNFVHZzEwdW5Cb3dhTGsxOFVVT0Q0T3hXNG54cVBWWU5aNTdFdS8uV2JjSHp0UGU5L0tNWGkiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1768651965),
('poqCJSFGOVFc0PJ78Ah2yfTGHqwpTVBSyCM2sGA6', NULL, '127.0.0.1', 'PostmanRuntime/7.49.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWFFDbXZNYjQ4cVdCSVRhSHlDZ1Jhc2lKRTg4TmZKZlFUWjJ2RjFEQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768649781);

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
(16, 1, 1, NULL, '2026-01-17 08:54:58', '2026-02-17 08:54:58', NULL, 'active', '2026-01-17 08:54:58', '2026-01-17 08:54:58', NULL);

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
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_admin_id_foreign` (`admin_id`),
  ADD KEY `subscriptions_plan_id_foreign` (`plan_id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
-- Constraints for table `subscription_usage`
--
ALTER TABLE `subscription_usage`
  ADD CONSTRAINT `subscription_usage_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
