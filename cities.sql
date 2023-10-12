-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 18, 2023 at 07:09 AM
-- Server version: 5.7.33
-- PHP Version: 8.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asfarco`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name_en`, `name_ar`, `created_at`, `updated_at`) VALUES
(1, 'Dibba Al-Fujairah', 'دبا الفجيرة', NULL, NULL),
(2, 'Umm al Qaywayn', 'أم القيوين', NULL, NULL),
(3, 'Dibba Al-Hisn', 'دبا الحصن', NULL, NULL),
(4, 'Al Ain', 'العين', NULL, NULL),
(5, 'Khawr Fakkān', 'خورفكان', NULL, NULL),
(6, 'Muzayri‘', 'المزيرعي', NULL, NULL),
(7, 'Adh Dhayd', 'اد الذيد', NULL, NULL),
(8, 'Ajman', 'عجمان', NULL, NULL),
(9, 'Sharjah', 'الشارقة', NULL, NULL),
(10, 'Dubai', 'دبي', NULL, NULL),
(11, 'Al Fujayrah', 'الفجيرة', NULL, NULL),
(12, 'Ras al-Khaimah', 'رأس الخيمة', NULL, NULL),
(13, 'Ar Ruways', 'الرويس', NULL, NULL),
(14, 'Abu Dhabi', 'أبو ظبي', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
