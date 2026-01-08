-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2026 at 01:33 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gmedaire`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `items_total` decimal(65,4) NOT NULL DEFAULT 0.0000,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `tags`, `descriptions`, `items_total`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'SPP', 'Supplies', '0.0000', 1, '2025-09-14 22:59:00', '2025-09-15 23:27:04'),
(2, 'SPS12', 'Spare Parts12', '0.0000', 1, '2025-09-15 15:10:12', '2025-09-16 01:21:10'),
(3, 'M2390', 'Machine Equipment', '0.0000', 1, '2025-09-15 23:34:38', '2025-09-16 01:21:02'),
(4, 'SP', 'Supplies', '0.0000', 0, '2025-09-16 01:21:25', '2025-09-16 01:21:25'),
(5, 'SPP', 'Spare Parts', '0.0000', 0, '2025-09-16 01:21:58', '2025-10-05 17:01:45'),
(6, 'example', 'example category', '0.0000', 1, '2025-10-05 17:02:03', '2025-10-05 17:04:44');

-- --------------------------------------------------------

--
-- Table structure for table `cylinders`
--

CREATE TABLE `cylinders` (
  `id` int(11) NOT NULL,
  `serial_no` varchar(255) NOT NULL DEFAULT '',
  `barcode` varchar(255) DEFAULT NULL,
  `types` int(11) DEFAULT 0,
  `capacity` decimal(18,4) NOT NULL DEFAULT 0.0000,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `unit_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `manufacture_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `inspection_date` date DEFAULT NULL,
  `hydrotest_date` date DEFAULT NULL,
  `location_id` int(11) DEFAULT 0,
  `status` enum('available','in used','under maintenance','returned','for inspection','for testing','empty') NOT NULL DEFAULT 'available',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cylinders`
--

INSERT INTO `cylinders` (`id`, `serial_no`, `barcode`, `types`, `capacity`, `customer_id`, `unit_id`, `category_id`, `manufacture_date`, `expiry_date`, `inspection_date`, `hydrotest_date`, `location_id`, `status`, `create_at`, `updated_at`, `deleted`) VALUES
(1, '900920292', 'CYL-20260107-900920292', 1, '122.0000', 0, 1, 1, '2026-01-07', '2026-01-07', NULL, NULL, 2, 'available', '2026-01-07 00:44:20', '2026-01-07 13:16:07', 1),
(3, 'cy9009202921', 'CYL-20260107-cy9009202921', 1, '1909.0000', 0, 3, 1, '2026-01-07', '2026-01-07', NULL, NULL, 2, 'available', '2026-01-07 00:45:34', '2026-01-07 00:45:34', 0),
(5, 'cy90092029212', 'CYL-20260107-cy90092029212', 1, '2213213.0000', 0, 2, 1, '2026-01-07', '2026-01-07', NULL, NULL, 2, 'available', '2026-01-07 00:46:07', '2026-01-07 00:46:07', 0),
(9, '9009202921', 'CYL-20260107-9009202921', 1, '321321.0000', 0, 1, 1, '2026-01-07', '2026-01-07', NULL, NULL, 2, 'available', '2026-01-07 13:29:41', '2026-01-07 13:29:41', 0),
(12, '90092029212', 'CYL-20260107-90092029212', 1, '3213213.0000', 0, 1, 1, '2026-01-07', '2026-01-07', NULL, NULL, 2, 'available', '2026-01-07 13:33:04', '2026-01-07 13:33:04', 0),
(18, '900920292132', 'CYL-20260107-900920292132', 1, '18000.0000', 0, 2, 1, '2026-01-07', '2026-01-07', NULL, NULL, 4, 'available', '2026-01-07 13:57:08', '2026-01-07 13:57:08', 0),
(27, '90092202921', 'CYL-20260107-900920292123', 1, '3213213213.0000', 0, 1, 1, '2026-01-07', '2026-01-07', NULL, NULL, 4, 'available', '2026-01-07 14:13:23', '2026-01-08 00:02:41', 1),
(28, '90092029214', 'CYL-20260107-90092029214', 2, '32323.0000', 0, 1, 1, '2026-01-07', '2026-01-07', NULL, NULL, 4, 'available', '2026-01-07 14:15:22', '2026-01-07 14:15:22', 0),
(29, '90092029215632', 'CYL-20260107-90092029215632', 2, '33432.0000', 0, 2, 2, '2026-01-07', '2030-01-07', NULL, NULL, 2, 'available', '2026-01-07 14:16:53', '2026-01-07 14:21:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cylinder_categories`
--

CREATE TABLE `cylinder_categories` (
  `id` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `items_total` decimal(65,4) NOT NULL DEFAULT 0.0000,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cylinder_categories`
--

INSERT INTO `cylinder_categories` (`id`, `tags`, `descriptions`, `items_total`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'cct-1', 'Industrial', '0.0000', 0, '2026-01-03 11:50:50', '2026-01-03 11:50:50'),
(2, 'cct-2', 'Medical/Clinical', '0.0000', 0, '2026-01-03 11:50:50', '2026-01-03 11:50:50'),
(3, 'dasdasd2', 'dasdasdas2', '0.0000', 1, '2026-01-06 13:55:48', '2026-01-06 13:55:56'),
(4, 'dsadasdwdsad', 'dsadasdsadd', '0.0000', 1, '2026-01-06 13:56:10', '2026-01-06 13:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `cylinder_locations`
--

CREATE TABLE `cylinder_locations` (
  `id` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `parents` int(11) NOT NULL DEFAULT 0,
  `is_parent` tinyint(1) NOT NULL DEFAULT 0,
  `warehouse` int(11) NOT NULL DEFAULT 0,
  `items_total` decimal(65,4) NOT NULL DEFAULT 0.0000,
  `default_1` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cylinder_locations`
--

INSERT INTO `cylinder_locations` (`id`, `tags`, `descriptions`, `parents`, `is_parent`, `warehouse`, `items_total`, `default_1`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'CS', 'Customers', 0, 0, 0, '0.0000', 0, 0, '2026-01-03 11:59:28', '2026-01-06 14:55:24'),
(2, 'SR', 'Storage Room', 0, 0, 0, '0.0000', 1, 0, '2026-01-03 11:59:28', '2026-01-06 14:56:09'),
(3, 'MR', 'Maintenance Room', 0, 0, 0, '0.0000', 0, 0, '2026-01-03 11:59:28', '2026-01-06 14:56:09'),
(4, 'RA', 'Recycle Area', 0, 0, 1, '0.0000', 0, 1, '2026-01-05 23:16:36', '2026-01-05 23:29:07'),
(5, 'RA', 'Recycle Area', 0, 0, 1, '0.0000', 0, 1, '2026-01-05 23:16:45', '2026-01-05 23:22:28'),
(6, 'RC-A', 'Receiving Area', 0, 0, 1, '0.0000', 0, 1, '2026-01-05 23:27:16', '2026-01-05 23:29:03'),
(7, 'sample', 'sample change on default', 0, 0, 1, '0.0000', 0, 1, '2026-01-05 23:43:37', '2026-01-05 23:45:19'),
(8, 'dasdasd', 'dasdasd', 0, 0, 1, '0.0000', 0, 1, '2026-01-06 00:01:46', '2026-01-06 00:04:14'),
(9, 'dasdasd', 'dasdas', 0, 0, 1, '0.0000', 0, 1, '2026-01-06 14:55:51', '2026-01-06 14:56:13');

-- --------------------------------------------------------

--
-- Table structure for table `cylinder_types`
--

CREATE TABLE `cylinder_types` (
  `id` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cylinder_types`
--

INSERT INTO `cylinder_types` (`id`, `tags`, `descriptions`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'ct-1', 'Steel', 0, '2026-01-03 19:48:59', '2026-01-03 19:48:59'),
(2, 'ct-2', 'Aluminum', 0, '2026-01-03 19:48:59', '2026-01-03 19:48:59'),
(3, 'ct-3', 'Composite', 0, '2026-01-03 19:48:59', '2026-01-03 19:48:59'),
(4, 'sample', 'samples', 1, '2026-01-06 21:39:26', '2026-01-06 21:40:06'),
(5, 'dasdsaddsad', 'dasdasddasdasd', 1, '2026-01-06 21:40:35', '2026-01-06 21:43:08'),
(6, 'dasdas232e', 'dasdasddasd2', 1, '2026-01-06 21:42:44', '2026-01-06 21:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `cylinder_units`
--

CREATE TABLE `cylinder_units` (
  `id` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `classification` varchar(10) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cylinder_units`
--

INSERT INTO `cylinder_units` (`id`, `tags`, `descriptions`, `classification`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'PSI', 'Pound per Square Inch', 'Major', 0, '2026-01-03 11:56:51', '2026-01-03 11:56:51'),
(2, 'LPM', 'Liters per Minute', 'Major', 0, '2026-01-03 11:56:51', '2026-01-03 11:56:51'),
(3, 'bar', 'Bar', 'Major', 0, '2026-01-03 11:56:51', '2026-01-03 11:56:51'),
(4, 'kPa', 'kiloPascals', 'Major', 0, '2026-01-03 11:56:51', '2026-01-03 11:56:51'),
(5, 'dsadasd2', 'dsadasd2', NULL, 1, '2026-01-06 14:02:59', '2026-01-06 14:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `descriptions` text DEFAULT NULL,
  `person` varchar(255) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'Active',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `tags`, `descriptions`, `person`, `contact`, `email`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'IT-Dept', 'Information technology department', 'Yukika Hiyoshi', '561-738-1155', 'YukikaHiyoshi@rhyta.com', 'Active', 0, '2025-10-08 15:21:04', '2025-10-08 15:30:26'),
(2, 'Acct-Dept', 'Finance & Accounting Department', 'Jermain Flores', '09202871234', 'jermainef@gmail.com', 'Active', 0, '2025-10-08 15:29:33', '2025-10-08 15:29:33');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(11) NOT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `percentage` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `discount`, `percentage`, `status`, `deleted`) VALUES
(1, 'Regular', '20.0000', 'active', 0),
(2, 'Supplier', '15.0000', 'active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `issued`
--

CREATE TABLE `issued` (
  `id` int(11) NOT NULL,
  `issued_no` varchar(255) DEFAULT NULL,
  `from_wh_id` int(11) DEFAULT NULL,
  `to_dept_id` int(11) DEFAULT NULL,
  `issued_date` date DEFAULT NULL,
  `issued_to` int(11) DEFAULT NULL,
  `total_qty` decimal(12,2) DEFAULT 0.00,
  `total_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_gross` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('draft','cancelled','issued') NOT NULL DEFAULT 'draft',
  `created_by` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `issued`
--

INSERT INTO `issued` (`id`, `issued_no`, `from_wh_id`, `to_dept_id`, `issued_date`, `issued_to`, `total_qty`, `total_cost`, `total_gross`, `status`, `created_by`, `remarks`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'ISS-2025-01', 1, 1, '2025-12-01', NULL, '0.00', '0.00', '0.00', 'issued', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2025-12-01 11:04:38', '2025-12-01 12:07:50', 0),
(2, 'ISS-2025-02', 1, 2, '2025-12-01', NULL, '0.00', '0.00', '0.00', 'draft', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2025-12-01 11:16:23', '2025-12-01 11:56:38', 1),
(3, 'ISS-2025-03', 2, 1, '2025-12-01', NULL, '0.00', '0.00', '0.00', 'draft', 1, NULL, '2025-12-01 13:26:56', '2025-12-01 13:26:56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `issued_items`
--

CREATE TABLE `issued_items` (
  `id` int(11) NOT NULL,
  `issued_id` int(11) DEFAULT NULL,
  `items_id` int(11) DEFAULT NULL,
  `qty` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gross` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `issued_items`
--

INSERT INTO `issued_items` (`id`, `issued_id`, `items_id`, `qty`, `cost`, `gross`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 1, 2, '3.00', '65.00', '0.00', '2025-11-21 06:51:02', '2025-11-21 06:51:16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `serial_no` varchar(100) DEFAULT NULL,
  `sku_no` varchar(100) DEFAULT NULL,
  `part_no` varchar(100) DEFAULT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `base_unit_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `vat_id` int(11) DEFAULT 0,
  `current_stock` decimal(18,4) DEFAULT 0.0000,
  `physical_count` decimal(18,4) DEFAULT 0.0000,
  `reorder_point` decimal(18,4) DEFAULT 0.0000,
  `cost` decimal(18,4) DEFAULT 0.0000,
  `expiry_date` date DEFAULT NULL,
  `status` varchar(10) DEFAULT 'active',
  `threshold` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `serial_no`, `sku_no`, `part_no`, `descriptions`, `barcode`, `brand`, `base_unit_id`, `category_id`, `location_id`, `vat_id`, `current_stock`, `physical_count`, `reorder_point`, `cost`, `expiry_date`, `status`, `threshold`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'dsadsa', 'dasdas', 'dasdasd', 'dasdasd', 'dasdasdsad', '---N/A---', 2, 4, 16, 1, '0.0000', '50.0000', '10.0000', '45.0000', NULL, 'inactive', 0, '2025-09-21 10:05:11', '2025-10-12 16:57:47', 1),
(2, '', 'SKU-SP-20250928-2', 'dasdas', 'dasdasd', '', NULL, 4, 4, 16, 0, '0.0000', '0.0000', '0.0000', '0.0000', NULL, 'inactive', 0, '2025-09-27 16:04:46', '2025-10-11 15:03:26', 1),
(3, 'SN-20250928-3', 'SKU-SP-20250928-3', '2903902-02', 'dasdasdasd', '543543450005', NULL, 4, 4, 15, 0, '0.0000', '0.0000', '23.0000', '52.0000', '0000-00-00', 'inactive', 0, '2025-09-27 16:07:41', '2025-10-11 15:03:22', 1),
(4, 'SN-20250928-4', 'SKU-SP-20250928-4', '290329-202', 'example t', '686634316252', NULL, 5, 4, 15, 0, '0.0000', '0.0000', '0.0000', '40.0000', '0000-00-00', 'inactive', 0, '2025-09-27 16:08:53', '2025-10-11 15:03:19', 1),
(5, 'SN-20250928-5', 'SKU-SP-20250928-5', '1232323', 'example 3', '905943983574', NULL, NULL, 4, 15, 0, '0.0000', '0.0000', '5.0000', '0.0000', NULL, 'inactive', 1, '2025-09-28 15:05:04', '2025-10-11 15:03:17', 1),
(6, 'SN-20250928-6', 'SKU-SP-20250928-6', '2312312', 'eqwewqe', '724421449520', NULL, NULL, 4, 15, 0, '0.0000', '0.0000', '0.0000', '0.0000', NULL, 'inactive', 0, '2025-09-28 15:08:12', '2025-10-11 15:03:15', 1),
(7, 'dsadsad', 'SKU-SP-20250928-7', 'dasd', 'dsadasd', '608665816273', NULL, NULL, 4, 15, 0, '0.0000', '0.0000', '0.0000', '0.0000', NULL, 'inactive', 0, '2025-09-28 15:10:49', '2025-10-11 15:03:24', 1),
(8, 'SN-20250928-8', 'SKU-SP-20250928-8', 'dsadsa', 'dasdasd', '676924257884', NULL, 3, 4, 15, 0, '0.0000', '0.0000', '0.0000', '0.0000', NULL, 'inactive', 0, '2025-09-28 15:25:12', '2025-10-11 15:03:12', 1),
(9, '321321', 'SKU-SP-20250928-9', '32131232', 'sample stocks2', '3213123123', 'SECA AUTO CARPORT', 4, 5, 15, 0, '25.0000', '0.0000', '202.0000', '32.0000', NULL, 'active', 1, '2025-09-28 15:40:14', '2025-12-01 11:23:57', 0),
(10, 'SN-20250929-10', 'SKU-SP-20250929-10', '23232', '32323232', '955218888134', '---N/A---', 2, 4, 15, 1, '20.0000', '0.0000', '3.0000', '3.0000', '2025-09-29', 'active', 0, '2025-09-29 03:25:48', '2025-12-01 11:19:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `items_expiry`
--

CREATE TABLE `items_expiry` (
  `id` int(11) UNSIGNED NOT NULL,
  `items_id` int(11) UNSIGNED DEFAULT NULL,
  `lot_no` varchar(255) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `quantity` decimal(12,4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `items_expiry`
--

INSERT INTO `items_expiry` (`id`, `items_id`, `lot_no`, `expiry`, `quantity`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 9, 'lot-9-01', '2025-10-18', '0.0000', '2025-10-12 17:27:21', '2025-10-12 17:27:21', 0),
(4, 9, 'lot-9-03', '2025-10-13', '0.0000', '2025-10-12 17:27:32', '2025-10-12 17:27:32', 0),
(6, 9, 'lot-9-05', '2025-10-15', '0.0000', '2025-10-12 17:28:20', '2025-10-13 12:44:04', 1),
(7, 9, '321232', '2025-10-25', '0.0000', '2025-10-12 17:28:32', '2025-10-13 12:44:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_unit_conversions`
--

CREATE TABLE `item_unit_conversions` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `multiplier` decimal(18,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `item_unit_conversions`
--

INSERT INTO `item_unit_conversions` (`id`, `item_id`, `unit_id`, `multiplier`) VALUES
(1, 8, 2, '50.0000'),
(2, 9, 5, '232.0000'),
(6, 10, 2, '3.0000'),
(9, 1, 2, '1.0000');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `parents` int(11) NOT NULL DEFAULT 0,
  `is_parent` tinyint(1) NOT NULL DEFAULT 0,
  `warehouse` int(11) NOT NULL DEFAULT 0,
  `items_total` decimal(65,4) NOT NULL DEFAULT 0.0000,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `tags`, `descriptions`, `parents`, `is_parent`, `warehouse`, `items_total`, `deleted`, `created_at`, `updated_at`) VALUES
(6, 'WH2/Z1', 'Zone 1', 0, 0, 2, '0.0000', 1, '2025-09-14 14:31:56', '2025-10-07 18:04:25'),
(8, 'WH1/Rack 12', 'Rack 12', 0, 0, 1, '0.0000', 1, '2025-09-14 14:33:15', '2025-10-08 12:56:54'),
(9, 'WH1/BIN 1', 'BIN 1', 0, 0, 1, '0.0000', 1, '2025-09-14 14:33:50', '2025-10-08 12:56:57'),
(10, 'WH1/Container 11', 'Container 11', 0, 0, 1, '0.0000', 1, '2025-09-16 14:30:41', '2025-10-08 12:56:59'),
(11, 'WH1/S2', 'Shelf2', 0, 0, 1, '0.0000', 1, '2025-09-16 21:54:50', '2025-10-08 12:57:01'),
(12, 'WH1/Stocks1', 'Stocks1', 0, 0, 1, '0.0000', 1, '2025-09-16 22:06:21', '2025-10-08 12:59:57'),
(13, 'WH1/Zone 1', 'Zone 1', 0, 0, 1, '0.0000', 1, '2025-09-16 22:18:04', '2025-10-08 13:01:43'),
(14, 'WH1-B1', 'Box1', 0, 0, 1, '0.0000', 1, '2025-09-16 22:18:29', '2025-10-07 18:05:56'),
(15, 'WH1/Stock 1', 'Stock 1', 0, 0, 1, '15.0000', 0, '2025-09-16 23:25:16', '2025-10-08 13:28:04'),
(16, 'WH1/Stock 1/Zone 1', 'Zone 1', 15, 0, 1, '0.0000', 0, '2025-09-16 23:33:34', '2025-10-08 13:06:32'),
(17, 'WH2/S2', 'Stock 2', 0, 0, 2, '0.0000', 1, '2025-09-16 23:37:06', '2025-10-07 18:05:01'),
(18, 'WH1/CH', 'Customer Holding', 0, 0, 1, '0.0000', 1, '2025-09-21 23:45:47', '2025-10-07 18:04:59'),
(19, 'WH1/CS', 'Cylinder Storage', 0, 0, 1, '0.0000', 1, '2025-09-21 23:46:42', '2025-10-07 18:04:57'),
(20, 'WH1/P', 'Plant', 0, 0, 1, '0.0000', 1, '2025-09-21 23:46:55', '2025-10-07 18:04:55'),
(21, 'WH1/Stock 1/example', 'example', 15, 0, 1, '0.0000', 0, '2025-10-08 12:51:02', '2025-10-08 13:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Philippines',
  `taxid` int(11) NOT NULL DEFAULT 0,
  `tin_id` varchar(255) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active' COMMENT 'active is 0, 1 is inactive',
  `is_what` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `tags`, `descriptions`, `contact_person`, `contact_no`, `email`, `address`, `city`, `state`, `zipcode`, `country`, `taxid`, `tin_id`, `status`, `is_what`, `deleted`, `created_at`, `updated_at`) VALUES
(2, 'SUPP1', 'CEBNET', 'Jose Jemson Lape', '09090290920', 'support@cebnet.com', '2nd Floor Veterans Bank Bldg., OsmeÃ±a Blvd.,', 'CEBU CITY', 'CEBU', '6119', 'Philippines', 0, NULL, 'active', 'supplier', 0, '2025-09-17 22:00:31', '2025-12-26 03:28:42'),
(4, 'CUS1', 'Ramon Gustilo Hospital', 'Ann S. Lamason', '090902290921', 'gustilohospital@gmail.com', 'Natl` Highway Brgy 1', 'Manapala', 'Negros Occidental', NULL, 'Philippines', 1, NULL, 'active', 'customer', 1, '2025-09-17 22:05:58', '2026-01-05 15:00:35'),
(5, 'CUS2', 'Ramon Gustilo Hospital', 'Ann S. Lamason', '909022909212', '', 'Natl` Highway Brgy 1', 'Manapala', 'Negros Occidental', '61192', 'Philippines', 1, NULL, 'active', 'customer', 0, '2025-09-17 22:06:02', '2026-01-05 16:08:19'),
(6, 'CUS3', 'example3', 'Anthony Cagaquit Posadas2', '099581261222', 'albaladejofelcon31@gmail.com', 'Brgy. Cadiz Viejo2', 'Cadiz City2', 'Negros Occidental2', NULL, 'Philippines2', 0, NULL, 'active', 'customer', 1, '2025-09-20 22:06:13', '2026-01-05 14:59:23'),
(7, 'SUPP2', 'Example 1', 'Anthony Cagaquit Posadas', '09958126122', 'email@mail.com', 'Ad', 'Cadiz City', 'Negros Occidental', '6119', 'Philippines', 0, NULL, 'active', 'supplier', 0, '2025-09-20 23:01:37', '2025-10-12 07:28:17'),
(8, 'MANUF1', 'IMed System Corp', 'Anthony Cagaquit Posadas', '09958126122', 'imedical@coop.com', 'Brgy. Cadiz Viejo', 'Cadiz City', 'Negros Occidental', NULL, 'Philippines', 0, NULL, 'active', 'manufacturer', 0, '2025-09-21 04:55:31', '2025-10-06 15:45:40'),
(9, 'SUPP3', 'Museum Company', 'Roger M. Montero', '917-364-7097', 'RogerMMontero@jourrapide.com', '456 Bicetown Road Whitestone, NY 11357', 'New York', 'USA', '33435', 'USA', 0, NULL, 'active', 'supplier', 0, '2025-10-03 14:33:35', '2025-10-12 07:28:20'),
(10, 'SUPP4', 'Chess King', 'Margaret R. Sheehan', '512-435-5306', 'MargaretRSheehan@rhyta.com', '3103 Bubby Drive Austin', 'Austin', 'Texas', '78701', 'USA', 0, NULL, 'active', 'supplier', 0, '2025-10-03 14:38:29', '2025-10-12 07:26:43'),
(11, 'CUS4', 'Felckie Interprise Incorporated', 'Anthony Cagaquit Posadas', '9958126122', 'support@cebnet.com', 'Brgy. Cadiz Viejo', 'Cadiz City', 'Negros Occidental', '6119', 'Philippines', 0, NULL, 'active', 'customer', 0, '2026-01-05 14:19:22', '2026-01-05 16:06:25'),
(12, 'CUS5', 'CEBNET LOCAL BRANCH', 'Felcon Albaladejo', '9958126122', 'support@cebnet.com', 'lopez jeana st.', 'victorias', 'Negros Occidental', '6119', 'Philippines', 0, NULL, 'active', 'customer', 0, '2026-01-05 14:23:11', '2026-01-05 16:16:32');

-- --------------------------------------------------------

--
-- Table structure for table `partners_locations`
--

CREATE TABLE `partners_locations` (
  `id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL DEFAULT 0,
  `address` text DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `partners_locations`
--

INSERT INTO `partners_locations` (`id`, `partner_id`, `address`, `contact_no`, `contact_person`, `email`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 4, 'dasd', 'dsad', 'dasd', 'dasd', '2025-09-27 04:27:38', '2025-09-27 04:41:04', 1),
(2, 4, 'dadasd', 'dsad', 'dasdasd', 'dasdad', '2025-09-27 04:27:38', '2025-09-27 04:41:04', 1),
(3, 4, 'Brgy. Cadiz Viejo2', 'dsad2', 'Anthony Cagaquit Posadas2', 'dasdasdsad2', '2025-09-27 04:40:53', '2025-09-27 04:44:47', 0),
(5, 4, 'dasdsad2', 'dsad2', 'adsa2', 'dasd2', '2025-09-27 04:44:02', '2025-09-27 04:44:35', 0),
(6, 2, '4250 Tuna Street Southfield, MI 48075', '810-937-3043', 'Lonnie I. Sullivan', 'LonnieISullivan@teleworm.us', '2025-09-27 13:24:22', '2025-10-04 15:27:32', 0),
(7, 8, 'Brgy. Cadiz Viejo', 'ewqewqe', 'Anthony Cagaquit Posadas', 'eqweqwewqe', '2025-09-27 13:25:07', '2025-09-27 13:25:07', 0),
(8, 8, 'eqwe', 'ewqewqe', 'eqwewq', 'ewqeqwe', '2025-09-27 13:25:07', '2025-09-27 13:25:07', 0),
(9, 2, '46 Happy Hollow Road Fayetteville, NC 28301', '910-609-7984', 'Frederick A. Cohen', 'FrederickACohen@dayrep.com', '2025-10-04 15:27:32', '2025-10-04 15:27:32', 0),
(10, 2, '1796 Stone Lane West Chester, PA 19382', '610-431-2900', 'Qiang Hsu', 'QiangHsu@jourrapide.com', '2025-10-04 15:41:41', '2025-10-05 10:56:31', 1),
(11, 7, '3319 Grim Avenue San Diego, CA 92111', '619-743-5821', 'Ella Brady', 'EllaBrady@rhyta.com', '2025-10-04 15:52:04', '2025-10-04 15:52:04', 0),
(12, 10, '2684 May Street Lexington, KY 40505', '606-334-1443', 'Dieter Kuhn', 'DieterKuhn@armyspy.com', '2025-10-05 10:56:13', '2025-10-12 15:00:23', 1),
(13, 7, 'Brgy. Cadiz Viejo', '', 'Anthony Cagaquit Posadas', '', '2025-10-12 14:54:28', '2025-10-12 15:08:03', 1),
(14, 7, 'lopez jeana st.', '', 'Felcon Albaladejo', '', '2025-10-12 14:56:26', '2025-10-12 15:08:03', 1),
(15, 7, 'lopez jeana st.', '', 'Felcon Albaladejo', '', '2025-10-12 14:57:21', '2025-10-12 15:08:03', 1),
(16, 10, 'Brgy. Cadiz Viejo', '', 'Anthony Cagaquit Posadas', '', '2025-10-12 15:00:56', '2025-10-12 15:00:56', 0),
(17, 7, 'lopez jeana st.', '', 'Felcon Albaladejo', '', '2025-10-12 15:07:46', '2025-10-12 15:08:03', 1),
(18, 5, 'Brgy. Cadiz Viejo', '2312423432', 'Anthony Cagaquit Posadas', '', '2026-01-05 15:11:42', '2026-01-05 15:11:42', 0),
(19, 5, 'Brgy. Cadiz Viejo', '4324324', 'Anthony Cagaquit Posadas', '', '2026-01-05 15:11:42', '2026-01-05 15:12:26', 1),
(20, 5, 'Brgy. Cadiz Viejo', '', 'Anthony Cagaquit Posadas', '', '2026-01-05 15:11:42', '2026-01-05 15:12:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `po`
--

CREATE TABLE `po` (
  `id` int(11) NOT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `po_due_date` date DEFAULT NULL,
  `status` enum('draft','closed','cancelled','') NOT NULL DEFAULT 'draft' COMMENT 'draft, closed, cancelled',
  `supplier_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `supplier_tag` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `supplier_person` varchar(255) DEFAULT NULL,
  `supplier_contact` varchar(255) DEFAULT NULL,
  `supplier_email` varchar(255) DEFAULT NULL,
  `supplier_address` text DEFAULT NULL,
  `supplier_cn` int(11) NOT NULL DEFAULT 0 COMMENT 'suppliers other contact information',
  `location_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `locations` varchar(255) DEFAULT NULL,
  `purchased` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `received` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `vat_type` enum('inclusive','exclusive','out-of-scope') NOT NULL DEFAULT 'inclusive',
  `disc_type` enum('percent','value') NOT NULL DEFAULT 'percent',
  `discount_id` int(11) NOT NULL DEFAULT 0,
  `discount_cent` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_vat` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(12,0) NOT NULL DEFAULT 0,
  `total_gross` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_netofvat` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `po`
--

INSERT INTO `po` (`id`, `po_no`, `po_date`, `po_due_date`, `status`, `supplier_id`, `supplier_tag`, `supplier_name`, `supplier_person`, `supplier_contact`, `supplier_email`, `supplier_address`, `supplier_cn`, `location_id`, `locations`, `purchased`, `received`, `vat_type`, `disc_type`, `discount_id`, `discount_cent`, `total_vat`, `total_discount`, `total_cost`, `total_gross`, `total_netofvat`, `total_amount`, `created_by`, `remarks`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'PO-2025-01', '2025-10-16', '2025-10-16', 'cancelled', 2, '', '', '', '', '', '', 6, 15, 'WH1/Stock 1', '0', '0', 'inclusive', 'percent', 0, '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0.00', 1, NULL, '2025-10-16 00:32:58', '2025-12-01 11:59:31', 1),
(9, 'PO-2025-02', '2025-10-16', '2025-10-16', 'draft', 10, '', '', '', '', '', '', 16, 15, 'WH1/Stock 1', '0', '0', 'inclusive', 'percent', 0, '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0.00', 1, NULL, '2025-10-16 12:30:18', '2025-10-18 16:21:39', 1),
(10, 'PO-2025-03', '2025-10-16', '2025-10-16', 'draft', 10, '', '', '', '', '', '', 16, 15, 'WH1/Stock 1', '0', '0', 'inclusive', 'percent', 0, '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0.00', 1, NULL, '2025-10-16 12:31:13', '2025-10-18 16:21:45', 1),
(11, 'PO-2025-04', '2025-10-16', '2025-10-16', 'closed', 9, 'SUPP3', 'Museum Company', 'Roger M. Montero', '917-364-7097', 'RogerMMontero@jourrapide.com', '456 Bicetown Road Whitestone, NY 11357, New York, USA, 33435, USA', 0, 15, 'WH1/Stock 1', '0', '0', 'inclusive', 'percent', 0, '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0.00', 1, NULL, '2025-10-16 12:42:57', '2025-10-18 16:21:51', 0),
(12, 'PO-2025-05', '2025-10-16', '2025-11-16', 'draft', 10, 'SUPP4', 'Chess King', 'Anthony Cagaquit Posadas', '512-435-5306', 'MargaretRSheehan@rhyta.com', 'Brgy. Cadiz Viejo', 16, 15, NULL, '7', '0', 'inclusive', 'percent', 1, '20.00', '91.46', '152.45', '257', '853.70', '762.24', '853.70', 1, 'Attach the barcode labels to each spare part or its packaging. The barcode should be placed\nin a visible location where itâ€™s easy to scan, but not likely to be damaged.', '2025-10-16 12:50:30', '2025-10-27 22:51:59', 0),
(13, 'PO-2025-06', '2025-12-26', '2026-01-31', 'draft', 2, '', '', '', '', '', '', 0, 15, 'WH1/Stock 1', '0', '0', 'inclusive', 'percent', 0, '0.00', '0.00', '0.00', '35', '0.00', '0.00', '0.00', 1, NULL, '2025-12-26 03:25:44', '2025-12-26 03:26:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `po_items`
--

CREATE TABLE `po_items` (
  `id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL DEFAULT 0,
  `items_id` int(11) NOT NULL DEFAULT 0,
  `purchased` decimal(12,2) NOT NULL DEFAULT 0.00,
  `received` decimal(12,2) NOT NULL DEFAULT 0.00,
  `vat_id` int(11) NOT NULL DEFAULT 0,
  `vat` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gross` decimal(12,2) NOT NULL DEFAULT 0.00,
  `netofvat` decimal(12,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `po_items`
--

INSERT INTO `po_items` (`id`, `po_id`, `items_id`, `purchased`, `received`, `vat_id`, `vat`, `discount`, `cost`, `gross`, `netofvat`, `amount`, `created_at`, `updated_at`, `deleted`) VALUES
(5, 12, 9, '0.00', '0.00', 0, '0.00', '0.00', '32.00', '0.00', '0.00', '0.00', '2025-10-21 15:35:43', '2025-10-23 00:39:14', 1),
(7, 12, 9, '0.00', '0.00', 0, '0.00', '0.00', '32.00', '0.00', '0.00', '0.00', '2025-10-21 15:36:28', '2025-10-23 00:41:13', 1),
(8, 12, 10, '0.00', '0.00', 0, '0.00', '0.00', '3.00', '0.00', '0.00', '0.00', '2025-10-21 15:36:28', '2025-10-23 00:41:13', 1),
(9, 12, 9, '0.00', '0.00', 1, '0.00', '0.00', '32.00', '0.00', '0.00', '0.00', '2025-10-23 13:45:22', '2025-10-23 23:04:11', 1),
(10, 12, 10, '0.00', '0.00', 1, '0.00', '0.00', '3.00', '0.00', '0.00', '0.00', '2025-10-23 13:45:22', '2025-10-23 14:45:15', 1),
(11, 12, 9, '5.00', '0.00', 1, '72.20', '120.34', '134.78', '673.90', '601.70', '673.90', '2025-10-23 14:45:48', '2025-10-25 14:57:43', 0),
(12, 12, 10, '2.00', '0.00', 1, '19.26', '32.11', '89.90', '179.80', '160.54', '179.80', '2025-10-23 14:45:48', '2025-10-26 13:56:52', 0),
(13, 12, 9, '0.00', '0.00', 0, '0.00', '0.00', '32.00', '0.00', '0.00', '0.00', '2025-10-26 13:32:04', '2025-10-26 13:32:04', 0),
(14, 13, 9, '0.00', '0.00', 0, '0.00', '0.00', '32.00', '0.00', '0.00', '0.00', '2025-12-26 03:26:05', '2025-12-26 03:26:05', 0),
(15, 13, 10, '0.00', '0.00', 1, '0.00', '0.00', '3.00', '0.00', '0.00', '0.00', '2025-12-26 03:26:05', '2025-12-26 03:26:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `receiving`
--

CREATE TABLE `receiving` (
  `id` int(11) NOT NULL,
  `receiving_no` varchar(255) DEFAULT NULL,
  `receiving_terms` int(11) NOT NULL DEFAULT 0,
  `receiving_date` date DEFAULT NULL,
  `receiving_due_date` date DEFAULT NULL,
  `status` enum('draft','closed','cancelled','') NOT NULL DEFAULT 'draft' COMMENT 'draft, closed, cancelled',
  `supplier_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `supplier_tag` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `supplier_person` varchar(255) DEFAULT NULL,
  `supplier_contact` varchar(255) DEFAULT NULL,
  `supplier_email` varchar(255) DEFAULT NULL,
  `supplier_address` text DEFAULT NULL,
  `supplier_cn` int(11) NOT NULL DEFAULT 0 COMMENT 'suppliers other contact information',
  `location_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `locations` varchar(255) DEFAULT NULL,
  `purchased` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `received` decimal(12,0) UNSIGNED NOT NULL DEFAULT 0,
  `vat_type` enum('inclusive','exclusive','out-of-scope') NOT NULL DEFAULT 'inclusive',
  `disc_type` enum('percent','value') NOT NULL DEFAULT 'percent',
  `discount_id` int(11) NOT NULL DEFAULT 0,
  `discount_cent` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_vat` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(12,0) NOT NULL DEFAULT 0,
  `total_gross` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_netofvat` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `received_by` int(11) NOT NULL DEFAULT 0 COMMENT 'user who received',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receiving_items`
--

CREATE TABLE `receiving_items` (
  `id` int(11) NOT NULL,
  `receiving_id` int(11) NOT NULL DEFAULT 0,
  `items_id` int(11) NOT NULL DEFAULT 0,
  `receiving_item_id` int(11) NOT NULL DEFAULT 0,
  `purchased` decimal(12,2) NOT NULL DEFAULT 0.00,
  `received` decimal(12,2) NOT NULL DEFAULT 0.00,
  `vat_id` int(11) NOT NULL DEFAULT 0,
  `vat` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gross` decimal(12,2) NOT NULL DEFAULT 0.00,
  `netofvat` decimal(12,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `receiving_items`
--

INSERT INTO `receiving_items` (`id`, `receiving_id`, `items_id`, `receiving_item_id`, `purchased`, `received`, `vat_id`, `vat`, `discount`, `cost`, `gross`, `netofvat`, `amount`, `created_at`, `updated_at`, `deleted`) VALUES
(5, 12, 9, 0, '0.00', '0.00', 0, '0.00', '0.00', '32.00', '0.00', '0.00', '0.00', '2025-10-21 15:35:43', '2025-10-23 00:39:14', 1),
(7, 12, 9, 0, '0.00', '0.00', 0, '0.00', '0.00', '32.00', '0.00', '0.00', '0.00', '2025-10-21 15:36:28', '2025-10-23 00:41:13', 1),
(8, 12, 10, 0, '0.00', '0.00', 0, '0.00', '0.00', '3.00', '0.00', '0.00', '0.00', '2025-10-21 15:36:28', '2025-10-23 00:41:13', 1),
(9, 12, 9, 0, '0.00', '0.00', 1, '0.00', '0.00', '32.00', '0.00', '0.00', '0.00', '2025-10-23 13:45:22', '2025-10-23 23:04:11', 1),
(10, 12, 10, 0, '0.00', '0.00', 1, '0.00', '0.00', '3.00', '0.00', '0.00', '0.00', '2025-10-23 13:45:22', '2025-10-23 14:45:15', 1),
(11, 12, 9, 0, '5.00', '0.00', 1, '72.20', '120.34', '134.78', '673.90', '601.70', '673.90', '2025-10-23 14:45:48', '2025-10-25 14:57:43', 0),
(12, 12, 10, 0, '2.00', '0.00', 1, '19.26', '32.11', '89.90', '179.80', '160.54', '179.80', '2025-10-23 14:45:48', '2025-10-26 13:56:52', 0),
(13, 12, 9, 0, '0.00', '0.00', 0, '0.00', '0.00', '32.00', '0.00', '0.00', '0.00', '2025-10-26 13:32:04', '2025-10-26 13:32:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transferred`
--

CREATE TABLE `transferred` (
  `id` int(11) NOT NULL,
  `transferred_no` varchar(255) DEFAULT NULL,
  `from_wh_id` int(11) DEFAULT NULL,
  `to_wh_id` int(11) DEFAULT NULL,
  `from_loc_id` int(11) DEFAULT NULL,
  `to_loc_id` int(11) DEFAULT NULL,
  `transferred_date` date DEFAULT NULL,
  `transferred_by` int(11) DEFAULT NULL,
  `total_qty` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_gross` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('draft','cancelled','transferred') NOT NULL DEFAULT 'draft',
  `created_by` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transferred_items`
--

CREATE TABLE `transferred_items` (
  `id` int(11) NOT NULL,
  `transferred_id` int(11) DEFAULT NULL,
  `items_id` int(11) DEFAULT NULL,
  `qty` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gross` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `classification` varchar(10) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `tags`, `descriptions`, `classification`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'pcs', 'Pieces', NULL, 1, '2025-09-13 05:46:35', '2025-09-16 01:29:17'),
(2, 'boxs', 'Boxes', 'major', 0, '2025-09-13 05:58:23', '2025-10-05 16:20:30'),
(3, '1M', '1 Meter', 'minor', 0, '2025-09-15 14:27:24', '2025-09-28 08:28:23'),
(4, '5M', '5Meters', 'minor', 0, '2025-09-15 14:29:03', '2025-09-28 08:28:28'),
(5, '10M', '10 Meters', 'minor', 0, '2025-09-15 14:31:38', '2025-09-28 08:28:31'),
(6, 'pcs', 'Pieces', 'minor', 0, '2025-09-16 01:30:52', '2025-09-28 08:28:36'),
(7, 'L', 'Liter', 'major', 0, '2025-09-28 08:33:37', '2025-09-28 08:33:37'),
(8, 'PSI', 'Pounds per square inch', 'minor', 0, '2025-09-28 08:33:57', '2025-09-28 08:33:57'),
(9, 'sample', 'example samples', 'major', 1, '2025-10-05 16:13:21', '2025-10-05 16:16:23'),
(10, 'next', 'examples 2 next', 'major', 1, '2025-10-05 16:14:03', '2025-10-05 16:15:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `contacts` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'User',
  `token` text DEFAULT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `contacts`, `email`, `user_type`, `token`, `profile`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'Rowena', 'Billones', 'gadmin', '$2y$10$TDKLVCoU/zAHOI8j6k7hyeFfATHG9Sq08yte8/fV27kHsynnvawBC', NULL, 'admin@gmedaire.com', 'Administrator', NULL, NULL, '2025-10-20 15:52:26', '2025-10-20 15:52:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vat`
--

CREATE TABLE `vat` (
  `id` int(11) NOT NULL,
  `vat` varchar(255) DEFAULT NULL,
  `percentage` int(11) NOT NULL DEFAULT 0,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `vat`
--

INSERT INTO `vat` (`id`, `vat`, `percentage`, `status`, `deleted`) VALUES
(1, 'VAT-Ex', 0, 'active', 0),
(2, 'VAT-S', 12, 'active', 0),
(3, '2% VAT', 2, 'active', 0),
(4, '20% VAT', 20, 'inactive', 0),
(5, '20% VAT', 20, 'active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `tags`, `descriptions`, `address`, `city`, `state`, `country`, `contact_person`, `contact_no`, `email`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'WH1', 'Main Warehouse', 'GMED AIRE Office', 'Manapla', 'Negros Occidental', 'Philippines', 'Rowena B. Billiones', '0950983903932', 'rowena@gmedaire.com', 0, '2025-09-14 12:21:31', '2025-10-07 16:29:37'),
(2, 'WH2', 'Cadiz Warehouse', 'Brgy. Cadiz Viejo', 'Cadiz City', 'Negros Occidental', 'Philippines', 'Anthony Cagaquit Posadas', '099581261222', 'cadizvbranch@gmedaire.com2', 0, '2025-09-16 12:27:48', '2025-10-07 16:34:56'),
(3, 'WH3', 'Highland Appliance', '1437 Pearcy Avenue Oconomowoc, WI 53066', 'Oconomowoc', 'United States', 'USA', 'Hatsuho Kinjo', '262-200-2565', 'HatsuhoKinjo@rhyta.com', 0, '2025-10-07 16:34:40', '2025-10-07 16:34:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cylinders`
--
ALTER TABLE `cylinders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_no` (`serial_no`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `location_idx` (`location_id`),
  ADD KEY `customer_idx` (`customer_id`);

--
-- Indexes for table `cylinder_categories`
--
ALTER TABLE `cylinder_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cylinder_locations`
--
ALTER TABLE `cylinder_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cylinder_types`
--
ALTER TABLE `cylinder_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cylinder_units`
--
ALTER TABLE `cylinder_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issued`
--
ALTER TABLE `issued`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_whId` (`from_wh_id`),
  ADD KEY `idx_deptId` (`to_dept_id`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_issuedto` (`issued_to`) USING BTREE;

--
-- Indexes for table `issued_items`
--
ALTER TABLE `issued_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_issuedId` (`issued_id`),
  ADD KEY `idx_itemsId` (`items_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items_expiry`
--
ALTER TABLE `items_expiry`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_expiry` (`expiry`,`items_id`);

--
-- Indexes for table `item_unit_conversions`
--
ALTER TABLE `item_unit_conversions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_id` (`item_id`) USING BTREE,
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners_locations`
--
ALTER TABLE `partners_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `po`
--
ALTER TABLE `po`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_supplier` (`supplier_id`),
  ADD KEY `idx_location` (`location_id`),
  ADD KEY `created_by` (`created_by`) USING BTREE;

--
-- Indexes for table `po_items`
--
ALTER TABLE `po_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_item` (`items_id`),
  ADD KEY `idx_po` (`po_id`) USING BTREE;

--
-- Indexes for table `receiving`
--
ALTER TABLE `receiving`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_supplier` (`supplier_id`),
  ADD KEY `idx_location` (`location_id`),
  ADD KEY `created_by` (`created_by`) USING BTREE;

--
-- Indexes for table `receiving_items`
--
ALTER TABLE `receiving_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_item` (`items_id`),
  ADD KEY `idx_po` (`receiving_item_id`) USING BTREE;

--
-- Indexes for table `transferred`
--
ALTER TABLE `transferred`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx_wh` (`from_wh_id`,`to_wh_id`),
  ADD KEY `idx_location` (`from_loc_id`,`to_loc_id`),
  ADD KEY `idx_transferredby` (`transferred_by`),
  ADD KEY `idx_createdby` (`created_by`) USING BTREE;

--
-- Indexes for table `transferred_items`
--
ALTER TABLE `transferred_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_transferredId` (`transferred_id`),
  ADD KEY `idx_itemsId` (`items_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vat`
--
ALTER TABLE `vat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cylinders`
--
ALTER TABLE `cylinders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cylinder_categories`
--
ALTER TABLE `cylinder_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cylinder_locations`
--
ALTER TABLE `cylinder_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cylinder_types`
--
ALTER TABLE `cylinder_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cylinder_units`
--
ALTER TABLE `cylinder_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `issued`
--
ALTER TABLE `issued`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `issued_items`
--
ALTER TABLE `issued_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `items_expiry`
--
ALTER TABLE `items_expiry`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `item_unit_conversions`
--
ALTER TABLE `item_unit_conversions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `partners_locations`
--
ALTER TABLE `partners_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `po`
--
ALTER TABLE `po`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `po_items`
--
ALTER TABLE `po_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `receiving`
--
ALTER TABLE `receiving`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receiving_items`
--
ALTER TABLE `receiving_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transferred`
--
ALTER TABLE `transferred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transferred_items`
--
ALTER TABLE `transferred_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vat`
--
ALTER TABLE `vat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item_unit_conversions`
--
ALTER TABLE `item_unit_conversions`
  ADD CONSTRAINT `item_unit_conversions_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `item_unit_conversions_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
