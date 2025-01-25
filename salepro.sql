-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 06, 2024 at 04:15 PM
-- Server version: 9.0.1
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salepro`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int UNSIGNED NOT NULL,
  `account_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initial_balance` double DEFAULT NULL,
  `total_balance` double NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `is_default` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_no`, `name`, `initial_balance`, `total_balance`, `note`, `is_default`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '10010', 'Sales Account', 0, 0, NULL, 1, 1, '2023-09-16 23:39:16', '2023-09-16 23:39:16'),
(2, '20010', 'Expense Account', 0, 0, NULL, NULL, 1, '2023-09-16 23:39:34', '2023-09-16 23:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `adjustments`
--

CREATE TABLE `adjustments` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` int NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_qty` double NOT NULL,
  `item` int NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `employee_id` int NOT NULL,
  `user_id` int NOT NULL,
  `checkin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checkout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billers`
--

CREATE TABLE `billers` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billers`
--

INSERT INTO `billers` (`id`, `name`, `image`, `company_name`, `vat_number`, `email`, `phone_number`, `address`, `city`, `state`, `postal_code`, `country`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Default Biller', NULL, 'My Company', NULL, 'biller@company.earth', '###', 'Somewhere', 'Geo', NULL, NULL, NULL, 1, '2023-09-16 23:36:11', '2023-09-16 23:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_registers`
--

CREATE TABLE `cash_registers` (
  `id` int UNSIGNED NOT NULL,
  `cash_in_hand` double NOT NULL,
  `user_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `minimum_amount` double DEFAULT NULL,
  `quantity` int NOT NULL,
  `used` int NOT NULL,
  `expired_date` date NOT NULL,
  `user_id` int NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `phone_number`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Default Courier', '000', 'Local', 1, '2023-09-16 23:42:42', '2023-09-16 23:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` double NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `exchange_rate`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'USD', '$', 1, 1, '2023-06-21 13:04:32', '2023-08-07 21:22:37');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int UNSIGNED NOT NULL,
  `customer_group_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `points` double DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `expense` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_group_id`, `user_id`, `name`, `company_name`, `email`, `phone_number`, `tax_no`, `address`, `city`, `state`, `postal_code`, `country`, `points`, `is_active`, `created_at`, `updated_at`, `deposit`, `expense`) VALUES
(1, 1, NULL, 'Walk-in Customer', NULL, NULL, '###', NULL, '@@@', 'Local', NULL, NULL, NULL, NULL, 1, '2023-09-16 23:38:07', '2023-09-16 23:38:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_groups`
--

CREATE TABLE `customer_groups` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_groups`
--

INSERT INTO `customer_groups` (`id`, `name`, `percentage`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'General Customers', '0', 1, '2023-09-16 23:36:59', '2023-09-16 23:36:59'),
(2, 'Wholesale Customers', '5', 1, '2023-09-16 23:37:22', '2023-09-16 23:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` bigint UNSIGNED NOT NULL,
  `belongs_to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_value` text COLLATE utf8mb4_unicode_ci,
  `option_value` text COLLATE utf8mb4_unicode_ci,
  `grid_value` int NOT NULL,
  `is_table` tinyint(1) NOT NULL,
  `is_invoice` tinyint(1) NOT NULL,
  `is_required` tinyint(1) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `is_disable` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `courier_id` int DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivered_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recieved_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Administration', 1, '2023-09-16 23:17:21', '2023-09-16 23:17:21'),
(2, 'Sales and Marketing', 1, '2023-09-16 23:17:33', '2023-09-16 23:17:33'),
(3, 'Huma Resource', 1, '2023-09-16 23:17:44', '2023-09-16 23:17:44'),
(4, 'Finance', 1, '2023-09-16 23:17:51', '2023-09-16 23:17:51');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `customer_id` int NOT NULL,
  `user_id` int NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicable_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_list` longtext COLLATE utf8mb4_unicode_ci,
  `valid_from` date NOT NULL,
  `valid_till` date NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double NOT NULL,
  `minimum_qty` double NOT NULL,
  `maximum_qty` double NOT NULL,
  `days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discount_plans`
--

CREATE TABLE `discount_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discount_plan_customers`
--

CREATE TABLE `discount_plan_customers` (
  `id` bigint UNSIGNED NOT NULL,
  `discount_plan_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discount_plan_discounts`
--

CREATE TABLE `discount_plan_discounts` (
  `id` bigint UNSIGNED NOT NULL,
  `discount_id` int NOT NULL,
  `discount_plan_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dso_alerts`
--

CREATE TABLE `dso_alerts` (
  `id` bigint UNSIGNED NOT NULL,
  `product_info` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_products` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `staff_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expense_category_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `account_id` int NOT NULL,
  `user_id` int NOT NULL,
  `cash_register_id` int DEFAULT NULL,
  `amount` double NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `code`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '20010', 'General Expense', 1, '2023-09-16 23:40:59', '2023-09-16 23:40:59'),
(2, '20020', 'Utility Bills', 1, '2023-09-16 23:41:21', '2023-09-16 23:41:21'),
(3, '20030', 'Payroll Expense', 1, '2023-09-16 23:41:37', '2023-09-16 23:41:37');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int UNSIGNED NOT NULL,
  `site_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_rtl` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_id` int DEFAULT NULL,
  `staff_access` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `without_stock` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `date_format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `developed_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_format` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `decimal` int DEFAULT '2',
  `state` int DEFAULT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `is_zatca` tinyint(1) DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_registration_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_title`, `site_logo`, `is_rtl`, `created_at`, `updated_at`, `currency`, `package_id`, `staff_access`, `without_stock`, `date_format`, `developed_by`, `invoice_format`, `decimal`, `state`, `theme`, `currency_position`, `expiry_date`, `is_zatca`, `company_name`, `vat_registration_number`) VALUES
(1, 'SalePro', '20230718035103.png', 0, '2023-06-20 23:00:00', '2023-09-16 23:45:14', '1', NULL, 'own', 'no', 'Y-m-d', 'Lion Coders', 'standard', 2, 1, 'default.css', 'prefix', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gift_cards`
--

CREATE TABLE `gift_cards` (
  `id` int UNSIGNED NOT NULL,
  `card_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `expense` double NOT NULL,
  `customer_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `created_by` int NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gift_card_recharges`
--

CREATE TABLE `gift_card_recharges` (
  `id` int UNSIGNED NOT NULL,
  `gift_card_id` int NOT NULL,
  `amount` double NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `is_approved` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_settings`
--

CREATE TABLE `hrm_settings` (
  `id` int UNSIGNED NOT NULL,
  `checkin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checkout` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `created_at`, `updated_at`) VALUES
(1, 'en', '2018-07-07 21:59:17', '2019-12-24 16:34:20');

-- --------------------------------------------------------

--
-- Table structure for table `mail_settings`
--

CREATE TABLE `mail_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `encryption` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_02_17_060412_create_categories_table', 1),
(4, '2018_02_20_035727_create_brands_table', 1),
(5, '2018_02_25_100635_create_suppliers_table', 1),
(6, '2018_02_27_101619_create_warehouse_table', 1),
(7, '2018_03_03_040448_create_units_table', 1),
(8, '2018_03_04_041317_create_taxes_table', 1),
(9, '2018_03_10_061915_create_customer_groups_table', 1),
(10, '2018_03_10_090534_create_customers_table', 1),
(11, '2018_03_11_095547_create_billers_table', 1),
(12, '2018_04_05_054401_create_products_table', 1),
(13, '2018_04_06_133606_create_purchases_table', 1),
(14, '2018_04_06_154600_create_product_purchases_table', 1),
(15, '2018_04_06_154915_create_product_warhouse_table', 1),
(16, '2018_04_10_085927_create_sales_table', 1),
(17, '2018_04_10_090133_create_product_sales_table', 1),
(18, '2018_04_10_090254_create_payments_table', 1),
(19, '2018_04_10_090341_create_payment_with_cheque_table', 1),
(20, '2018_04_10_090509_create_payment_with_credit_card_table', 1),
(21, '2018_04_13_121436_create_quotation_table', 1),
(22, '2018_04_13_122324_create_product_quotation_table', 1),
(23, '2018_04_14_121802_create_transfers_table', 1),
(24, '2018_04_14_121913_create_product_transfer_table', 1),
(25, '2018_05_13_082847_add_payment_id_and_change_sale_id_to_payments_table', 1),
(26, '2018_05_13_090906_change_customer_id_to_payment_with_credit_card_table', 1),
(27, '2018_05_20_054532_create_adjustments_table', 1),
(28, '2018_05_20_054859_create_product_adjustments_table', 1),
(29, '2018_05_21_163419_create_returns_table', 1),
(30, '2018_05_21_163443_create_product_returns_table', 1),
(31, '2018_06_02_050905_create_roles_table', 1),
(32, '2018_06_02_073430_add_columns_to_users_table', 1),
(33, '2018_06_03_053738_create_permission_tables', 1),
(34, '2018_06_21_063736_create_pos_setting_table', 1),
(35, '2018_06_21_094155_add_user_id_to_sales_table', 1),
(36, '2018_06_21_101529_add_user_id_to_purchases_table', 1),
(37, '2018_06_21_103512_add_user_id_to_transfers_table', 1),
(38, '2018_06_23_061058_add_user_id_to_quotations_table', 1),
(39, '2018_06_23_082427_add_is_deleted_to_users_table', 1),
(40, '2018_06_25_043308_change_email_to_users_table', 1),
(41, '2018_07_06_115449_create_general_settings_table', 1),
(42, '2018_07_08_043944_create_languages_table', 1),
(43, '2018_07_11_102144_add_user_id_to_returns_table', 1),
(44, '2018_07_11_102334_add_user_id_to_payments_table', 1),
(45, '2018_07_22_130541_add_digital_to_products_table', 1),
(46, '2018_07_24_154250_create_deliveries_table', 1),
(47, '2018_08_16_053336_create_expense_categories_table', 1),
(48, '2018_08_17_115415_create_expenses_table', 1),
(49, '2018_08_18_050418_create_gift_cards_table', 1),
(50, '2018_08_19_063119_create_payment_with_gift_card_table', 1),
(51, '2018_08_25_042333_create_gift_card_recharges_table', 1),
(52, '2018_08_25_101354_add_deposit_expense_to_customers_table', 1),
(53, '2018_08_26_043801_create_deposits_table', 1),
(54, '2018_09_02_044042_add_keybord_active_to_pos_setting_table', 1),
(55, '2018_09_09_092713_create_payment_with_paypal_table', 1),
(56, '2018_09_10_051254_add_currency_to_general_settings_table', 1),
(57, '2018_10_22_084118_add_biller_and_store_id_to_users_table', 1),
(58, '2018_10_26_034927_create_coupons_table', 1),
(59, '2018_10_27_090857_add_coupon_to_sales_table', 1),
(60, '2018_11_07_070155_add_currency_position_to_general_settings_table', 1),
(61, '2018_11_19_094650_add_combo_to_products_table', 1),
(62, '2018_12_09_043712_create_accounts_table', 1),
(63, '2018_12_17_112253_add_is_default_to_accounts_table', 1),
(64, '2018_12_19_103941_add_account_id_to_payments_table', 1),
(65, '2018_12_20_065900_add_account_id_to_expenses_table', 1),
(66, '2018_12_20_082753_add_account_id_to_returns_table', 1),
(67, '2018_12_26_064330_create_return_purchases_table', 1),
(68, '2018_12_26_144708_create_purchase_product_return_table', 1),
(69, '2018_12_27_110018_create_departments_table', 1),
(70, '2018_12_30_054844_create_employees_table', 1),
(71, '2018_12_31_125210_create_payrolls_table', 1),
(72, '2018_12_31_150446_add_department_id_to_employees_table', 1),
(73, '2019_01_01_062708_add_user_id_to_expenses_table', 1),
(74, '2019_01_02_075644_create_hrm_settings_table', 1),
(75, '2019_01_02_090334_create_attendances_table', 1),
(76, '2019_01_27_160956_add_three_columns_to_general_settings_table', 1),
(77, '2019_02_15_183303_create_stock_counts_table', 1),
(78, '2019_02_17_101604_add_is_adjusted_to_stock_counts_table', 1),
(79, '2019_04_13_101707_add_tax_no_to_customers_table', 1),
(80, '2019_08_19_000000_create_failed_jobs_table', 1),
(81, '2019_10_14_111455_create_holidays_table', 1),
(82, '2019_11_13_145619_add_is_variant_to_products_table', 1),
(83, '2019_11_13_150206_create_product_variants_table', 1),
(84, '2019_11_13_153828_create_variants_table', 1),
(85, '2019_11_25_134041_add_qty_to_product_variants_table', 1),
(86, '2019_11_25_134922_add_variant_id_to_product_purchases_table', 1),
(87, '2019_11_25_145341_add_variant_id_to_product_warehouse_table', 1),
(88, '2019_11_29_182201_add_variant_id_to_product_sales_table', 1),
(89, '2019_12_04_121311_add_variant_id_to_product_quotation_table', 1),
(90, '2019_12_05_123802_add_variant_id_to_product_transfer_table', 1),
(91, '2019_12_08_114954_add_variant_id_to_product_returns_table', 1),
(92, '2019_12_08_203146_add_variant_id_to_purchase_product_return_table', 1),
(93, '2020_02_28_103340_create_money_transfers_table', 1),
(94, '2020_07_01_193151_add_image_to_categories_table', 1),
(95, '2020_09_26_130426_add_user_id_to_deliveries_table', 1),
(96, '2020_10_11_125457_create_cash_registers_table', 1),
(97, '2020_10_13_155019_add_cash_register_id_to_sales_table', 1),
(98, '2020_10_13_172624_add_cash_register_id_to_returns_table', 1),
(99, '2020_10_17_212338_add_cash_register_id_to_payments_table', 1),
(100, '2020_10_18_124200_add_cash_register_id_to_expenses_table', 1),
(101, '2020_10_21_121632_add_developed_by_to_general_settings_table', 1),
(102, '2020_10_30_135557_create_notifications_table', 1),
(103, '2020_11_01_044954_create_currencies_table', 1),
(104, '2020_11_01_140736_add_price_to_product_warehouse_table', 1),
(105, '2020_11_02_050633_add_is_diff_price_to_products_table', 1),
(106, '2020_11_09_055222_add_user_id_to_customers_table', 1),
(107, '2020_11_17_054806_add_invoice_format_to_general_settings_table', 1),
(108, '2021_02_10_074859_add_variant_id_to_product_adjustments_table', 1),
(109, '2021_03_07_093606_create_product_batches_table', 1),
(110, '2021_03_07_093759_add_product_batch_id_to_product_warehouse_table', 1),
(111, '2021_03_07_093900_add_product_batch_id_to_product_purchases_table', 1),
(112, '2021_03_11_132603_add_product_batch_id_to_product_sales_table', 1),
(113, '2021_03_25_125421_add_is_batch_to_products_table', 1),
(114, '2021_05_19_120127_add_product_batch_id_to_product_returns_table', 1),
(115, '2021_05_22_105611_add_product_batch_id_to_purchase_product_return_table', 1),
(116, '2021_05_23_124848_add_product_batch_id_to_product_transfer_table', 1),
(117, '2021_05_26_153106_add_product_batch_id_to_product_quotation_table', 1),
(118, '2021_06_08_213007_create_reward_point_settings_table', 1),
(119, '2021_06_16_104155_add_points_to_customers_table', 1),
(120, '2021_06_17_101057_add_used_points_to_payments_table', 1),
(121, '2021_07_06_132716_add_variant_list_to_products_table', 1),
(122, '2021_09_27_161141_add_is_imei_to_products_table', 1),
(123, '2021_09_28_170052_add_imei_number_to_product_warehouse_table', 1),
(124, '2021_09_28_170126_add_imei_number_to_product_purchases_table', 1),
(125, '2021_10_03_170652_add_imei_number_to_product_sales_table', 1),
(126, '2021_10_10_145214_add_imei_number_to_product_returns_table', 1),
(127, '2021_10_11_104504_add_imei_number_to_product_transfer_table', 1),
(128, '2021_10_12_160107_add_imei_number_to_purchase_product_return_table', 1),
(129, '2021_10_12_205146_add_is_rtl_to_general_settings_table', 1),
(130, '2022_01_13_191242_create_discount_plans_table', 1),
(131, '2022_01_14_174318_create_discount_plan_customers_table', 1),
(132, '2022_01_14_202439_create_discounts_table', 1),
(133, '2022_01_16_153506_create_discount_plan_discounts_table', 1),
(134, '2022_02_05_174210_add_order_discount_type_and_value_to_sales_table', 1),
(135, '2022_05_26_195506_add_daily_sale_objective_to_products_table', 1),
(136, '2022_05_28_104209_create_dso_alerts_table', 1),
(137, '2022_06_01_112100_add_is_embeded_to_products_table', 1),
(138, '2022_06_14_130505_add_sale_id_to_returns_table', 1),
(139, '2022_07_19_115504_add_variant_data_to_products_table', 1),
(140, '2022_07_25_194300_add_additional_cost_to_product_variants_table', 1),
(141, '2022_09_04_195610_add_purchase_id_to_return_purchases_table', 1),
(142, '2023_01_18_125040_alter_table_general_settings', 1),
(143, '2023_01_18_133701_alter_table_pos_setting', 1),
(144, '2023_01_25_145309_add_expiry_date_to_general_settings_table', 1),
(145, '2023_02_23_125656_alter_table_sales', 1),
(146, '2023_02_26_124100_add_package_id_to_general_settings_table', 1),
(147, '2023_03_04_120325_create_custom_fields_table', 1),
(148, '2023_03_22_174352_add_currency_id_and_exchange_rate_to_returns_table', 1),
(149, '2023_03_27_114320_add_currency_id_and_exchange_rate_to_purchases_table', 1),
(150, '2023_03_27_132747_add_currency_id_and_exchange_rate_to_return_purchases_table', 1),
(151, '2023_04_25_150236_create_mail_settings_table', 1),
(152, '2023_05_13_125424_add_zatca_to_general_settings_table', 1),
(153, '2023_05_28_155540_create_tables_table', 1),
(154, '2023_05_29_115039_add_is_table_to_pos_setting_table', 1),
(155, '2023_05_29_115301_add_table_id_to_sales_table', 1),
(156, '2023_05_31_165049_add_queue_no_to_sales_table', 1),
(157, '2023_07_23_160254_create_couriers_table', 1),
(158, '2023_07_23_174343_add_courier_id_to_deliveries_table', 1),
(159, '2023_08_12_124016_add_staff_id_to_employees_table', 1),
(160, '2023_08_14_142608_add_is_active_to_currencies_table', 1),
(161, '2023_08_24_130203_change_columns_to_attendances_table', 1),
(162, '2023_09_10_134503_add_without_stock_to_general_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `money_transfers`
--

CREATE TABLE `money_transfers` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_account_id` int NOT NULL,
  `to_account_id` int NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int UNSIGNED NOT NULL,
  `purchase_id` int DEFAULT NULL,
  `sale_id` int DEFAULT NULL,
  `cash_register_id` int DEFAULT NULL,
  `account_id` int NOT NULL,
  `payment_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `used_points` double DEFAULT NULL,
  `paying_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_cheque`
--

CREATE TABLE `payment_with_cheque` (
  `id` int UNSIGNED NOT NULL,
  `payment_id` int NOT NULL,
  `cheque_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_credit_card`
--

CREATE TABLE `payment_with_credit_card` (
  `id` int UNSIGNED NOT NULL,
  `payment_id` int NOT NULL,
  `customer_id` int DEFAULT NULL,
  `customer_stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_gift_card`
--

CREATE TABLE `payment_with_gift_card` (
  `id` int UNSIGNED NOT NULL,
  `payment_id` int NOT NULL,
  `gift_card_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_paypal`
--

CREATE TABLE `payment_with_paypal` (
  `id` int UNSIGNED NOT NULL,
  `payment_id` int NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` int NOT NULL,
  `account_id` int NOT NULL,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `paying_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(4, 'products-edit', 'web', '2018-06-03 00:00:09', '2018-06-03 00:00:09'),
(5, 'products-delete', 'web', '2018-06-03 21:54:22', '2018-06-03 21:54:22'),
(6, 'products-add', 'web', '2018-06-03 23:34:14', '2018-06-03 23:34:14'),
(7, 'products-index', 'web', '2018-06-04 02:34:27', '2018-06-04 02:34:27'),
(8, 'purchases-index', 'web', '2018-06-04 07:03:19', '2018-06-04 07:03:19'),
(9, 'purchases-add', 'web', '2018-06-04 07:12:25', '2018-06-04 07:12:25'),
(10, 'purchases-edit', 'web', '2018-06-04 08:47:36', '2018-06-04 08:47:36'),
(11, 'purchases-delete', 'web', '2018-06-04 08:47:36', '2018-06-04 08:47:36'),
(12, 'sales-index', 'web', '2018-06-04 09:49:08', '2018-06-04 09:49:08'),
(13, 'sales-add', 'web', '2018-06-04 09:49:52', '2018-06-04 09:49:52'),
(14, 'sales-edit', 'web', '2018-06-04 09:49:52', '2018-06-04 09:49:52'),
(15, 'sales-delete', 'web', '2018-06-04 09:49:53', '2018-06-04 09:49:53'),
(16, 'quotes-index', 'web', '2018-06-04 21:05:10', '2018-06-04 21:05:10'),
(17, 'quotes-add', 'web', '2018-06-04 21:05:10', '2018-06-04 21:05:10'),
(18, 'quotes-edit', 'web', '2018-06-04 21:05:10', '2018-06-04 21:05:10'),
(19, 'quotes-delete', 'web', '2018-06-04 21:05:10', '2018-06-04 21:05:10'),
(20, 'transfers-index', 'web', '2018-06-04 21:30:03', '2018-06-04 21:30:03'),
(21, 'transfers-add', 'web', '2018-06-04 21:30:03', '2018-06-04 21:30:03'),
(22, 'transfers-edit', 'web', '2018-06-04 21:30:03', '2018-06-04 21:30:03'),
(23, 'transfers-delete', 'web', '2018-06-04 21:30:03', '2018-06-04 21:30:03'),
(24, 'returns-index', 'web', '2018-06-04 21:50:24', '2018-06-04 21:50:24'),
(25, 'returns-add', 'web', '2018-06-04 21:50:24', '2018-06-04 21:50:24'),
(26, 'returns-edit', 'web', '2018-06-04 21:50:25', '2018-06-04 21:50:25'),
(27, 'returns-delete', 'web', '2018-06-04 21:50:25', '2018-06-04 21:50:25'),
(28, 'customers-index', 'web', '2018-06-04 22:15:54', '2018-06-04 22:15:54'),
(29, 'customers-add', 'web', '2018-06-04 22:15:55', '2018-06-04 22:15:55'),
(30, 'customers-edit', 'web', '2018-06-04 22:15:55', '2018-06-04 22:15:55'),
(31, 'customers-delete', 'web', '2018-06-04 22:15:55', '2018-06-04 22:15:55'),
(32, 'suppliers-index', 'web', '2018-06-04 22:40:12', '2018-06-04 22:40:12'),
(33, 'suppliers-add', 'web', '2018-06-04 22:40:12', '2018-06-04 22:40:12'),
(34, 'suppliers-edit', 'web', '2018-06-04 22:40:12', '2018-06-04 22:40:12'),
(35, 'suppliers-delete', 'web', '2018-06-04 22:40:12', '2018-06-04 22:40:12'),
(36, 'product-report', 'web', '2018-06-24 22:05:33', '2018-06-24 22:05:33'),
(37, 'purchase-report', 'web', '2018-06-24 22:24:56', '2018-06-24 22:24:56'),
(38, 'sale-report', 'web', '2018-06-24 22:33:13', '2018-06-24 22:33:13'),
(39, 'customer-report', 'web', '2018-06-24 22:36:51', '2018-06-24 22:36:51'),
(40, 'due-report', 'web', '2018-06-24 22:39:52', '2018-06-24 22:39:52'),
(41, 'users-index', 'web', '2018-06-24 23:00:10', '2018-06-24 23:00:10'),
(42, 'users-add', 'web', '2018-06-24 23:00:10', '2018-06-24 23:00:10'),
(43, 'users-edit', 'web', '2018-06-24 23:01:30', '2018-06-24 23:01:30'),
(44, 'users-delete', 'web', '2018-06-24 23:01:30', '2018-06-24 23:01:30'),
(45, 'profit-loss', 'web', '2018-07-14 20:50:05', '2018-07-14 20:50:05'),
(46, 'best-seller', 'web', '2018-07-14 21:01:38', '2018-07-14 21:01:38'),
(47, 'daily-sale', 'web', '2018-07-14 21:24:21', '2018-07-14 21:24:21'),
(48, 'monthly-sale', 'web', '2018-07-14 21:30:41', '2018-07-14 21:30:41'),
(49, 'daily-purchase', 'web', '2018-07-14 21:36:46', '2018-07-14 21:36:46'),
(50, 'monthly-purchase', 'web', '2018-07-14 21:48:17', '2018-07-14 21:48:17'),
(51, 'payment-report', 'web', '2018-07-14 22:10:41', '2018-07-14 22:10:41'),
(52, 'warehouse-stock-report', 'web', '2018-07-14 22:16:55', '2018-07-14 22:16:55'),
(53, 'product-qty-alert', 'web', '2018-07-14 22:33:21', '2018-07-14 22:33:21'),
(54, 'supplier-report', 'web', '2018-07-30 02:00:01', '2018-07-30 02:00:01'),
(55, 'expenses-index', 'web', '2018-09-05 00:07:10', '2018-09-05 00:07:10'),
(56, 'expenses-add', 'web', '2018-09-05 00:07:10', '2018-09-05 00:07:10'),
(57, 'expenses-edit', 'web', '2018-09-05 00:07:10', '2018-09-05 00:07:10'),
(58, 'expenses-delete', 'web', '2018-09-05 00:07:11', '2018-09-05 00:07:11'),
(59, 'general_setting', 'web', '2018-10-19 22:10:04', '2018-10-19 22:10:04'),
(60, 'mail_setting', 'web', '2018-10-19 22:10:04', '2018-10-19 22:10:04'),
(61, 'pos_setting', 'web', '2018-10-19 22:10:04', '2018-10-19 22:10:04'),
(62, 'hrm_setting', 'web', '2019-01-02 09:30:23', '2019-01-02 09:30:23'),
(63, 'purchase-return-index', 'web', '2019-01-02 20:45:14', '2019-01-02 20:45:14'),
(64, 'purchase-return-add', 'web', '2019-01-02 20:45:14', '2019-01-02 20:45:14'),
(65, 'purchase-return-edit', 'web', '2019-01-02 20:45:14', '2019-01-02 20:45:14'),
(66, 'purchase-return-delete', 'web', '2019-01-02 20:45:14', '2019-01-02 20:45:14'),
(67, 'account-index', 'web', '2019-01-02 21:06:13', '2019-01-02 21:06:13'),
(68, 'balance-sheet', 'web', '2019-01-02 21:06:14', '2019-01-02 21:06:14'),
(69, 'account-statement', 'web', '2019-01-02 21:06:14', '2019-01-02 21:06:14'),
(70, 'department', 'web', '2019-01-02 21:30:01', '2019-01-02 21:30:01'),
(71, 'attendance', 'web', '2019-01-02 21:30:01', '2019-01-02 21:30:01'),
(72, 'payroll', 'web', '2019-01-02 21:30:01', '2019-01-02 21:30:01'),
(73, 'employees-index', 'web', '2019-01-02 21:52:19', '2019-01-02 21:52:19'),
(74, 'employees-add', 'web', '2019-01-02 21:52:19', '2019-01-02 21:52:19'),
(75, 'employees-edit', 'web', '2019-01-02 21:52:19', '2019-01-02 21:52:19'),
(76, 'employees-delete', 'web', '2019-01-02 21:52:19', '2019-01-02 21:52:19'),
(77, 'user-report', 'web', '2019-01-16 05:48:18', '2019-01-16 05:48:18'),
(78, 'stock_count', 'web', '2019-02-17 09:32:01', '2019-02-17 09:32:01'),
(79, 'adjustment', 'web', '2019-02-17 09:32:02', '2019-02-17 09:32:02'),
(80, 'sms_setting', 'web', '2019-02-22 04:18:03', '2019-02-22 04:18:03'),
(81, 'create_sms', 'web', '2019-02-22 04:18:03', '2019-02-22 04:18:03'),
(82, 'print_barcode', 'web', '2019-03-07 04:02:19', '2019-03-07 04:02:19'),
(83, 'empty_database', 'web', '2019-03-07 04:02:19', '2019-03-07 04:02:19'),
(84, 'customer_group', 'web', '2019-03-07 04:37:15', '2019-03-07 04:37:15'),
(85, 'unit', 'web', '2019-03-07 04:37:15', '2019-03-07 04:37:15'),
(86, 'tax', 'web', '2019-03-07 04:37:15', '2019-03-07 04:37:15'),
(87, 'gift_card', 'web', '2019-03-07 05:29:38', '2019-03-07 05:29:38'),
(88, 'coupon', 'web', '2019-03-07 05:29:38', '2019-03-07 05:29:38'),
(89, 'holiday', 'web', '2019-10-19 07:57:15', '2019-10-19 07:57:15'),
(90, 'warehouse-report', 'web', '2019-10-22 05:00:23', '2019-10-22 05:00:23'),
(91, 'warehouse', 'web', '2020-02-26 05:47:32', '2020-02-26 05:47:32'),
(92, 'brand', 'web', '2020-02-26 05:59:59', '2020-02-26 05:59:59'),
(93, 'billers-index', 'web', '2020-02-26 06:11:15', '2020-02-26 06:11:15'),
(94, 'billers-add', 'web', '2020-02-26 06:11:15', '2020-02-26 06:11:15'),
(95, 'billers-edit', 'web', '2020-02-26 06:11:15', '2020-02-26 06:11:15'),
(96, 'billers-delete', 'web', '2020-02-26 06:11:15', '2020-02-26 06:11:15'),
(97, 'money-transfer', 'web', '2020-03-02 04:41:48', '2020-03-02 04:41:48'),
(98, 'category', 'web', '2020-07-13 11:13:16', '2020-07-13 11:13:16'),
(99, 'delivery', 'web', '2020-07-13 11:13:16', '2020-07-13 11:13:16'),
(100, 'send_notification', 'web', '2020-10-31 05:21:31', '2020-10-31 05:21:31'),
(101, 'today_sale', 'web', '2020-10-31 05:57:04', '2020-10-31 05:57:04'),
(102, 'today_profit', 'web', '2020-10-31 05:57:04', '2020-10-31 05:57:04'),
(103, 'currency', 'web', '2020-11-08 23:23:11', '2020-11-08 23:23:11'),
(104, 'backup_database', 'web', '2020-11-14 23:16:55', '2020-11-14 23:16:55'),
(105, 'reward_point_setting', 'web', '2021-06-27 03:34:42', '2021-06-27 03:34:42'),
(106, 'revenue_profit_summary', 'web', '2022-02-08 12:57:21', '2022-02-08 12:57:21'),
(107, 'cash_flow', 'web', '2022-02-08 12:57:22', '2022-02-08 12:57:22'),
(108, 'monthly_summary', 'web', '2022-02-08 12:57:22', '2022-02-08 12:57:22'),
(109, 'yearly_report', 'web', '2022-02-08 12:57:22', '2022-02-08 12:57:22'),
(110, 'discount_plan', 'web', '2022-02-16 08:12:26', '2022-02-16 08:12:26'),
(111, 'discount', 'web', '2022-02-16 08:12:38', '2022-02-16 08:12:38'),
(112, 'product-expiry-report', 'web', '2022-03-30 04:39:20', '2022-03-30 04:39:20'),
(113, 'purchase-payment-index', 'web', '2022-06-05 13:12:27', '2022-06-05 13:12:27'),
(114, 'purchase-payment-add', 'web', '2022-06-05 13:12:28', '2022-06-05 13:12:28'),
(115, 'purchase-payment-edit', 'web', '2022-06-05 13:12:28', '2022-06-05 13:12:28'),
(116, 'purchase-payment-delete', 'web', '2022-06-05 13:12:28', '2022-06-05 13:12:28'),
(117, 'sale-payment-index', 'web', '2022-06-05 13:12:28', '2022-06-05 13:12:28'),
(118, 'sale-payment-add', 'web', '2022-06-05 13:12:28', '2022-06-05 13:12:28'),
(119, 'sale-payment-edit', 'web', '2022-06-05 13:12:28', '2022-06-05 13:12:28'),
(120, 'sale-payment-delete', 'web', '2022-06-05 13:12:28', '2022-06-05 13:12:28'),
(121, 'all_notification', 'web', '2022-06-05 13:12:29', '2022-06-05 13:12:29'),
(122, 'sale-report-chart', 'web', '2022-06-05 13:12:29', '2022-06-05 13:12:29'),
(123, 'dso-report', 'web', '2022-06-05 13:12:29', '2022-06-05 13:12:29'),
(124, 'product_history', 'web', '2022-08-25 13:04:05', '2022-08-25 13:04:05'),
(125, 'supplier-due-report', 'web', '2022-08-31 08:46:33', '2022-08-31 08:46:33'),
(126, 'custom_field', 'web', '2023-05-02 06:41:35', '2023-05-02 06:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `pos_setting`
--

CREATE TABLE `pos_setting` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `biller_id` int NOT NULL,
  `product_number` int NOT NULL,
  `keybord_active` tinyint(1) NOT NULL,
  `is_table` tinyint(1) NOT NULL DEFAULT '0',
  `stripe_public_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_secret_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_live_api_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_live_api_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_live_api_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_options` text COLLATE utf8mb4_unicode_ci,
  `invoice_option` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pos_setting`
--

INSERT INTO `pos_setting` (`id`, `customer_id`, `warehouse_id`, `biller_id`, `product_number`, `keybord_active`, `is_table`, `stripe_public_key`, `stripe_secret_key`, `paypal_live_api_username`, `paypal_live_api_password`, `paypal_live_api_secret`, `payment_options`, `invoice_option`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 50, 0, 0, NULL, NULL, NULL, NULL, NULL, 'cash,card,gift_card,deposit', 'thermal', '2023-06-21 13:20:02', '2023-09-16 23:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode_symbology` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` int DEFAULT NULL,
  `category_id` int NOT NULL,
  `unit_id` int NOT NULL,
  `purchase_unit_id` int NOT NULL,
  `sale_unit_id` int NOT NULL,
  `cost` double NOT NULL,
  `price` double NOT NULL,
  `qty` double DEFAULT NULL,
  `alert_quantity` double DEFAULT NULL,
  `daily_sale_objective` double DEFAULT NULL,
  `promotion` tinyint DEFAULT NULL,
  `promotion_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `last_date` date DEFAULT NULL,
  `tax_id` int DEFAULT NULL,
  `tax_method` int DEFAULT NULL,
  `image` longtext COLLATE utf8mb4_unicode_ci,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_embeded` tinyint(1) DEFAULT NULL,
  `is_variant` tinyint(1) DEFAULT NULL,
  `is_batch` tinyint(1) DEFAULT NULL,
  `is_diffPrice` tinyint(1) DEFAULT NULL,
  `is_imei` tinyint(1) DEFAULT NULL,
  `featured` tinyint DEFAULT NULL,
  `product_list` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variant_list` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty_list` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_list` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_details` text COLLATE utf8mb4_unicode_ci,
  `variant_option` text COLLATE utf8mb4_unicode_ci,
  `variant_value` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_adjustments`
--

CREATE TABLE `product_adjustments` (
  `id` int UNSIGNED NOT NULL,
  `adjustment_id` int NOT NULL,
  `product_id` int NOT NULL,
  `variant_id` int DEFAULT NULL,
  `qty` double NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_batches`
--

CREATE TABLE `product_batches` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `batch_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_date` date NOT NULL,
  `qty` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_purchases`
--

CREATE TABLE `product_purchases` (
  `id` int UNSIGNED NOT NULL,
  `purchase_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_batch_id` int DEFAULT NULL,
  `variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_unicode_ci,
  `qty` double NOT NULL,
  `recieved` double NOT NULL,
  `purchase_unit_id` int NOT NULL,
  `net_unit_cost` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_quotation`
--

CREATE TABLE `product_quotation` (
  `id` int UNSIGNED NOT NULL,
  `quotation_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_batch_id` int DEFAULT NULL,
  `variant_id` int DEFAULT NULL,
  `qty` double NOT NULL,
  `sale_unit_id` int NOT NULL,
  `net_unit_price` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_returns`
--

CREATE TABLE `product_returns` (
  `id` int UNSIGNED NOT NULL,
  `return_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_batch_id` int DEFAULT NULL,
  `variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_unicode_ci,
  `qty` double NOT NULL,
  `sale_unit_id` int NOT NULL,
  `net_unit_price` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_sales`
--

CREATE TABLE `product_sales` (
  `id` int UNSIGNED NOT NULL,
  `sale_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_batch_id` int DEFAULT NULL,
  `variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_unicode_ci,
  `qty` double NOT NULL,
  `sale_unit_id` int NOT NULL,
  `net_unit_price` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_transfer`
--

CREATE TABLE `product_transfer` (
  `id` int UNSIGNED NOT NULL,
  `transfer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_batch_id` int DEFAULT NULL,
  `variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_unicode_ci,
  `qty` double NOT NULL,
  `purchase_unit_id` int NOT NULL,
  `net_unit_cost` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `variant_id` int NOT NULL,
  `position` int NOT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional_cost` double DEFAULT NULL,
  `additional_price` double DEFAULT NULL,
  `qty` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_warehouse`
--

CREATE TABLE `product_warehouse` (
  `id` int UNSIGNED NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_batch_id` int DEFAULT NULL,
  `variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_unicode_ci,
  `warehouse_id` int NOT NULL,
  `qty` double NOT NULL,
  `price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `supplier_id` int DEFAULT NULL,
  `currency_id` int DEFAULT NULL,
  `exchange_rate` double DEFAULT NULL,
  `item` int NOT NULL,
  `total_qty` int NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_cost` double NOT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `order_discount` double DEFAULT NULL,
  `shipping_cost` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `paid_amount` double NOT NULL,
  `status` int NOT NULL,
  `payment_status` int NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_product_return`
--

CREATE TABLE `purchase_product_return` (
  `id` int UNSIGNED NOT NULL,
  `return_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_batch_id` int DEFAULT NULL,
  `variant_id` int DEFAULT NULL,
  `imei_number` text COLLATE utf8mb4_unicode_ci,
  `qty` double NOT NULL,
  `purchase_unit_id` int NOT NULL,
  `net_unit_cost` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `biller_id` int NOT NULL,
  `supplier_id` int DEFAULT NULL,
  `customer_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `item` int NOT NULL,
  `total_qty` double NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_price` double NOT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `order_discount` double DEFAULT NULL,
  `shipping_cost` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `quotation_status` int NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `sale_id` int DEFAULT NULL,
  `cash_register_id` int DEFAULT NULL,
  `customer_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `biller_id` int NOT NULL,
  `account_id` int NOT NULL,
  `currency_id` int DEFAULT NULL,
  `exchange_rate` double DEFAULT NULL,
  `item` int NOT NULL,
  `total_qty` double NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_price` double NOT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_note` text COLLATE utf8mb4_unicode_ci,
  `staff_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_purchases`
--

CREATE TABLE `return_purchases` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` int DEFAULT NULL,
  `warehouse_id` int NOT NULL,
  `user_id` int NOT NULL,
  `purchase_id` int DEFAULT NULL,
  `account_id` int NOT NULL,
  `currency_id` int DEFAULT NULL,
  `exchange_rate` double DEFAULT NULL,
  `item` int NOT NULL,
  `total_qty` double NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_cost` double NOT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_note` text COLLATE utf8mb4_unicode_ci,
  `staff_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reward_point_settings`
--

CREATE TABLE `reward_point_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `per_point_amount` double NOT NULL,
  `minimum_amount` double NOT NULL,
  `duration` int DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reward_point_settings`
--

INSERT INTO `reward_point_settings` (`id`, `per_point_amount`, `minimum_amount`, `duration`, `type`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 500, 0, 0, 'Year', 0, '2023-09-16 22:58:38', '2023-09-16 22:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`, `guard_name`) VALUES
(1, 'Admin', 'Admins have full access to the system', 1, '2018-06-01 22:46:44', '2023-06-21 13:38:36', 'web'),
(2, 'Owner', 'Full access to the system except technical aspects.', 1, '2018-10-22 01:38:13', '2023-09-16 23:07:38', 'web'),
(3, 'Cashier', 'Cashier has limited access to sales data', 1, '2018-06-01 23:05:27', '2023-06-21 13:38:46', 'web'),
(5, 'Customer', 'Customers can access their own data', 1, '2020-11-05 05:43:16', '2020-11-14 23:24:15', 'web'),
(6, 'Admin (Demo)', 'Demo admin with restricted access to system settings', 1, '2023-08-12 07:55:13', '2023-08-12 07:55:13', 'web');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
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
(38, 1),
(39, 1),
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
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(84, 2),
(85, 2),
(86, 2),
(87, 2),
(88, 2),
(89, 2),
(90, 2),
(91, 2),
(92, 2),
(93, 2),
(94, 2),
(95, 2),
(96, 2),
(97, 2),
(98, 2),
(99, 2),
(100, 2),
(101, 2),
(102, 2),
(103, 2),
(104, 2),
(105, 2),
(106, 2),
(107, 2),
(108, 2),
(109, 2),
(110, 2),
(111, 2),
(112, 2),
(113, 2),
(114, 2),
(115, 2),
(116, 2),
(117, 2),
(118, 2),
(119, 2),
(120, 2),
(121, 2),
(122, 2),
(123, 2),
(124, 2),
(125, 2),
(126, 2),
(4, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(12, 3),
(13, 3),
(16, 3),
(17, 3),
(20, 3),
(21, 3),
(22, 3),
(24, 3),
(25, 3),
(28, 3),
(29, 3),
(32, 3),
(36, 3),
(47, 3),
(49, 3),
(52, 3),
(53, 3),
(55, 3),
(56, 3),
(57, 3),
(63, 3),
(64, 3),
(90, 3),
(93, 3),
(106, 3),
(112, 3),
(7, 5),
(28, 5),
(4, 6),
(5, 6),
(6, 6),
(7, 6),
(8, 6),
(9, 6),
(10, 6),
(11, 6),
(12, 6),
(13, 6),
(14, 6),
(15, 6),
(16, 6),
(17, 6),
(18, 6),
(19, 6),
(20, 6),
(21, 6),
(22, 6),
(23, 6),
(24, 6),
(25, 6),
(26, 6),
(27, 6),
(28, 6),
(29, 6),
(30, 6),
(31, 6),
(32, 6),
(33, 6),
(34, 6),
(35, 6),
(36, 6),
(37, 6),
(38, 6),
(39, 6),
(40, 6),
(41, 6),
(42, 6),
(43, 6),
(44, 6),
(45, 6),
(46, 6),
(47, 6),
(48, 6),
(49, 6),
(50, 6),
(51, 6),
(52, 6),
(53, 6),
(54, 6),
(55, 6),
(56, 6),
(57, 6),
(58, 6),
(61, 6),
(62, 6),
(63, 6),
(64, 6),
(65, 6),
(66, 6),
(67, 6),
(68, 6),
(69, 6),
(70, 6),
(71, 6),
(72, 6),
(73, 6),
(74, 6),
(75, 6),
(76, 6),
(77, 6),
(78, 6),
(79, 6),
(82, 6),
(84, 6),
(85, 6),
(86, 6),
(87, 6),
(88, 6),
(89, 6),
(90, 6),
(91, 6),
(92, 6),
(93, 6),
(94, 6),
(95, 6),
(96, 6),
(97, 6),
(98, 6),
(99, 6),
(101, 6),
(102, 6),
(103, 6),
(105, 6),
(106, 6),
(107, 6),
(108, 6),
(109, 6),
(110, 6),
(111, 6),
(112, 6),
(113, 6),
(114, 6),
(115, 6),
(116, 6),
(117, 6),
(118, 6),
(119, 6),
(120, 6),
(121, 6),
(122, 6),
(123, 6),
(124, 6),
(125, 6),
(126, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `cash_register_id` int DEFAULT NULL,
  `table_id` int DEFAULT NULL,
  `queue` int DEFAULT NULL,
  `customer_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `biller_id` int NOT NULL,
  `item` int NOT NULL,
  `total_qty` double NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_price` double NOT NULL,
  `grand_total` double NOT NULL,
  `currency_id` int DEFAULT NULL,
  `exchange_rate` double DEFAULT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `order_discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_discount_value` double DEFAULT NULL,
  `order_discount` double DEFAULT NULL,
  `coupon_id` int DEFAULT NULL,
  `coupon_discount` double DEFAULT NULL,
  `shipping_cost` double DEFAULT NULL,
  `sale_status` int NOT NULL,
  `payment_status` int NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `sale_note` text COLLATE utf8mb4_unicode_ci,
  `staff_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_counts`
--

CREATE TABLE `stock_counts` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_id` int NOT NULL,
  `category_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initial_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `is_adjusted` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `image`, `company_name`, `vat_number`, `email`, `phone_number`, `address`, `city`, `state`, `postal_code`, `country`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Default Supplier', NULL, 'Supplier Co', NULL, 'supplier@supplier.earth', '###', 'Somewhere', 'Geo', NULL, NULL, NULL, 1, '2023-09-16 23:35:09', '2023-09-16 23:35:09');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_person` int DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int UNSIGNED NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `status` int NOT NULL,
  `from_warehouse_id` int NOT NULL,
  `to_warehouse_id` int NOT NULL,
  `item` int NOT NULL,
  `total_qty` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_cost` double NOT NULL,
  `shipping_cost` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int UNSIGNED NOT NULL,
  `unit_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_unit` int DEFAULT NULL,
  `operator` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operation_value` double DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_code`, `unit_name`, `base_unit`, `operator`, `operation_value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Pc(s)', 'Piece', NULL, '*', 1, 1, '2023-09-16 23:44:06', '2023-09-16 23:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int NOT NULL,
  `biller_id` int DEFAULT NULL,
  `warehouse_id` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `company_name`, `role_id`, `biller_id`, `warehouse_id`, `is_active`, `is_deleted`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$WMlshh/KvYumKOPD8aPu3ut2Lch3uTVEfaqycho7scwrYfR8kq9fa', NULL, '2023-08-12 04:51:23', '2024-12-06 16:15:03', '+1-800-0000001', 'My Company', 1, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `variants`
--

CREATE TABLE `variants` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `phone`, `email`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Default Warehouse', '000', NULL, 'Local', 1, '2023-09-16 23:43:36', '2023-09-16 23:43:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adjustments`
--
ALTER TABLE `adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_date_employee_id_checkin_unique` (`date`,`employee_id`,`checkin`);

--
-- Indexes for table `billers`
--
ALTER TABLE `billers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_registers`
--
ALTER TABLE `cash_registers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_plans`
--
ALTER TABLE `discount_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_plan_customers`
--
ALTER TABLE `discount_plan_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_plan_discounts`
--
ALTER TABLE `discount_plan_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dso_alerts`
--
ALTER TABLE `dso_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_cards`
--
ALTER TABLE `gift_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_card_recharges`
--
ALTER TABLE `gift_card_recharges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_settings`
--
ALTER TABLE `hrm_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_settings`
--
ALTER TABLE `mail_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `money_transfers`
--
ALTER TABLE `money_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_cheque`
--
ALTER TABLE `payment_with_cheque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_credit_card`
--
ALTER TABLE `payment_with_credit_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_gift_card`
--
ALTER TABLE `payment_with_gift_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_paypal`
--
ALTER TABLE `payment_with_paypal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_setting`
--
ALTER TABLE `pos_setting`
  ADD UNIQUE KEY `pos_setting_id_unique` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_adjustments`
--
ALTER TABLE `product_adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_batches`
--
ALTER TABLE `product_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_purchases`
--
ALTER TABLE `product_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_quotation`
--
ALTER TABLE `product_quotation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_returns`
--
ALTER TABLE `product_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sales`
--
ALTER TABLE `product_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_transfer`
--
ALTER TABLE `product_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_product_return`
--
ALTER TABLE `purchase_product_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_purchases`
--
ALTER TABLE `return_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_point_settings`
--
ALTER TABLE `reward_point_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_counts`
--
ALTER TABLE `stock_counts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `variants`
--
ALTER TABLE `variants`
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
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `adjustments`
--
ALTER TABLE `adjustments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billers`
--
ALTER TABLE `billers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_registers`
--
ALTER TABLE `cash_registers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discount_plans`
--
ALTER TABLE `discount_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discount_plan_customers`
--
ALTER TABLE `discount_plan_customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discount_plan_discounts`
--
ALTER TABLE `discount_plan_discounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dso_alerts`
--
ALTER TABLE `dso_alerts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gift_cards`
--
ALTER TABLE `gift_cards`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gift_card_recharges`
--
ALTER TABLE `gift_card_recharges`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_settings`
--
ALTER TABLE `hrm_settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mail_settings`
--
ALTER TABLE `mail_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `money_transfers`
--
ALTER TABLE `money_transfers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_with_cheque`
--
ALTER TABLE `payment_with_cheque`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_with_credit_card`
--
ALTER TABLE `payment_with_credit_card`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_with_gift_card`
--
ALTER TABLE `payment_with_gift_card`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_with_paypal`
--
ALTER TABLE `payment_with_paypal`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_adjustments`
--
ALTER TABLE `product_adjustments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_batches`
--
ALTER TABLE `product_batches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_purchases`
--
ALTER TABLE `product_purchases`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_quotation`
--
ALTER TABLE `product_quotation`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_returns`
--
ALTER TABLE `product_returns`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_sales`
--
ALTER TABLE `product_sales`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_transfer`
--
ALTER TABLE `product_transfer`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_product_return`
--
ALTER TABLE `purchase_product_return`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_purchases`
--
ALTER TABLE `return_purchases`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reward_point_settings`
--
ALTER TABLE `reward_point_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_counts`
--
ALTER TABLE `stock_counts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `variants`
--
ALTER TABLE `variants`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

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
