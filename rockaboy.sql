-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2022 at 09:35 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rockaboy`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `accountnames`
-- (See below for the actual view)
--
CREATE TABLE `accountnames` (
`purchaseheaderid` int(11)
,`stockidentify` int(11)
,`accountcode` int(11)
,`accountname` varchar(500)
);

-- --------------------------------------------------------

--
-- Table structure for table `accounttrans`
--

CREATE TABLE `accounttrans` (
  `id` int(11) NOT NULL,
  `accountcode` int(11) DEFAULT NULL,
  `narration` varchar(500) DEFAULT NULL,
  `amount` double(11,2) DEFAULT NULL,
  `total` double(11,2) NOT NULL,
  `ttype` varchar(4) DEFAULT NULL,
  `purchaseheaderid` int(11) DEFAULT NULL,
  `credit` varchar(6) DEFAULT NULL,
  `stockidentify` int(11) DEFAULT NULL,
  `stocktransid` int(11) NOT NULL DEFAULT '0',
  `transdate` date DEFAULT NULL,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `invoice_xpid` int(11) NOT NULL DEFAULT '0',
  `bracid` int(11) DEFAULT NULL,
  `isInput` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounttrans`
--

INSERT INTO `accounttrans` (`id`, `accountcode`, `narration`, `amount`, `total`, `ttype`, `purchaseheaderid`, `credit`, `stockidentify`, `stocktransid`, `transdate`, `invoice_id`, `invoice_xpid`, `bracid`, `isInput`, `created_at`, `updated_at`) VALUES
(1, 1113, 'stock in Computer Desktop', 30000.00, 30000.00, 'D', 1, NULL, 1, 0, '2021-12-04', 0, 0, 1, 1, '2021-12-04 14:40:07', '2021-12-04 14:40:07'),
(2, 4500, 'stock in Computer Desktop', 30000.00, 30000.00, 'C', 1, NULL, 1, 0, '2021-12-04', 0, 0, 1, 1, '2021-12-04 14:40:07', '2021-12-04 14:40:07'),
(3, 1113, 'stock in pandol Extra', 3600000.00, 3600000.00, 'D', 2, NULL, 2, 0, '2021-12-04', 0, 0, 1, 1, '2021-12-04 14:47:27', '2021-12-04 14:47:27'),
(4, 4500, 'stock in pandol Extra', 3600000.00, 3600000.00, 'C', 2, NULL, 2, 0, '2021-12-04', 0, 0, 1, 1, '2021-12-04 14:47:27', '2021-12-04 14:47:27'),
(5, 1000, 'Sale of  Computer Desktop @ 7,000', 42000.00, 42000.00, 'C', 3, NULL, 0, 3, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:49:58', '2021-12-04 14:49:58'),
(6, 3600, 'Sale of  Computer Desktop @ 7,000', 42000.00, 42000.00, 'D', 3, NULL, 0, 3, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:49:58', '2021-12-04 14:49:58'),
(7, 1113, 'Sale of  Computer Desktop', 18000.00, -18000.00, 'C', 3, NULL, 0, 3, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:49:58', '2021-12-04 14:49:58'),
(8, 1001, 'Sale of  Computer Desktop', 18000.00, 18000.00, 'D', 3, NULL, 0, 3, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:49:58', '2021-12-04 14:49:58'),
(9, 1000, 'Sale of  pandol Extra @ 60,000', 3000000.00, 3000000.00, 'C', 3, NULL, 0, 4, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:49:58', '2021-12-04 14:49:58'),
(10, 3600, 'Sale of  pandol Extra @ 60,000', 3000000.00, 3000000.00, 'D', 3, NULL, 0, 4, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:49:58', '2021-12-04 14:49:58'),
(11, 1113, 'Sale of  pandol Extra', 2000000.00, -2000000.00, 'C', 3, NULL, 0, 4, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:49:58', '2021-12-04 14:49:58'),
(12, 1001, 'Sale of  pandol Extra', 2000000.00, 2000000.00, 'D', 3, NULL, 0, 4, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:49:58', '2021-12-04 14:49:58'),
(13, 1000, 'Sale of  Computer Desktop @ 7,000', 7000.00, 7000.00, 'C', 4, NULL, 0, 5, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:53:43', '2021-12-04 14:53:43'),
(14, 3600, 'Sale of  Computer Desktop @ 7,000', 7000.00, 7000.00, 'D', 4, NULL, 0, 5, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:53:43', '2021-12-04 14:53:43'),
(15, 1113, 'Sale of  Computer Desktop', 3000.00, -3000.00, 'C', 4, NULL, 0, 5, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:53:43', '2021-12-04 14:53:43'),
(16, 1001, 'Sale of  Computer Desktop', 3000.00, 3000.00, 'D', 4, NULL, 0, 5, '2021-12-04', 0, 0, 1, 0, '2021-12-04 14:53:43', '2021-12-04 14:53:43'),
(17, 2312, 'Purchase 4 Toshiba @ 5,000', 20000.00, -20000.00, 'C', 5, NULL, NULL, 0, '2021-12-04', 1, 0, 1, 0, '2021-12-04 14:00:44', '2021-12-04 15:00:44'),
(18, 1994, 'Purchase of 4 Toshiba @ 5,000', 20000.00, 20000.00, 'D', 5, NULL, NULL, 0, '2021-12-04', 1, 0, 1, 0, '2021-12-04 14:00:44', '2021-12-04 15:00:44'),
(19, 2312, 'Purchase 3 fff @ 3,000', 9000.00, -9000.00, 'C', 5, NULL, NULL, 0, '2021-12-04', 2, 0, 1, 0, '2021-12-04 14:00:44', '2021-12-04 15:00:44'),
(20, 1994, 'Purchase of 3 fff @ 3,000', 9000.00, 9000.00, 'D', 5, NULL, NULL, 0, '2021-12-04', 2, 0, 1, 0, '2021-12-04 14:00:44', '2021-12-04 15:00:44'),
(21, 6070, 'Transport to gudna', 20000.00, 20000.00, 'D', 6, NULL, NULL, 0, '1970-01-01', 1, 2, 1, 0, '2021-12-04 15:03:00', '2021-12-04 15:03:00'),
(22, 2312, 'Transport to gudna', 20000.00, -20000.00, 'C', 6, NULL, NULL, 0, '1970-01-01', 1, 2, 1, 0, '2021-12-04 15:03:00', '2021-12-04 15:03:00'),
(23, 1113, 'stock in  of 4 Toshiba', 20000.00, 20000.00, 'D', 7, NULL, 3, 0, '2021-12-04', 7, 5, 1, 1, '2021-12-04 15:11:26', '2021-12-04 15:11:26'),
(24, 1994, 'stock in Toshiba', 20000.00, -20000.00, 'C', 7, NULL, 3, 0, '2021-12-04', 7, 5, 1, 1, '2021-12-04 15:11:26', '2021-12-04 15:11:26'),
(25, 1113, 'stock in  of 3 fff', 9000.00, 9000.00, 'D', 8, NULL, 4, 0, '2021-12-04', 8, 5, 1, 1, '2021-12-04 15:11:26', '2021-12-04 15:11:26'),
(26, 1994, 'stock in fff', 9000.00, -9000.00, 'C', 8, NULL, 4, 0, '2021-12-04', 8, 5, 1, 1, '2021-12-04 15:11:26', '2021-12-04 15:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `accounttypes`
--

CREATE TABLE `accounttypes` (
  `id` int(11) NOT NULL,
  `accounttype` varchar(400) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounttypes`
--

INSERT INTO `accounttypes` (`id`, `accounttype`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 'Current Assets', 1, NULL, NULL),
(2, 'Fixed Assets', 1, NULL, NULL),
(3, 'Current Liabilites', 1, NULL, NULL),
(4, 'Long Term Liablitites', 1, NULL, NULL),
(5, 'Equity', 1, NULL, NULL),
(6, 'Income', 1, NULL, NULL),
(7, 'Expenses', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `availablestocks`
--

CREATE TABLE `availablestocks` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `dmg` int(11) NOT NULL,
  `pno` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `availablestocks`
--

INSERT INTO `availablestocks` (`id`, `item_id`, `qty`, `dmg`, `pno`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 0, 0, '2021-12-04 14:11:26', '2021-12-04 15:00:30'),
(2, 2, 0, 0, 0, '2021-12-04 14:11:26', '2021-12-04 15:00:42');

-- --------------------------------------------------------

--
-- Table structure for table `bankings`
--

CREATE TABLE `bankings` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `paymentdetail` varchar(100) NOT NULL,
  `bankid` int(11) NOT NULL,
  `branchno` int(11) NOT NULL,
  `headerno` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `branchname` varchar(100) DEFAULT NULL,
  `contactPerson` varchar(100) DEFAULT NULL,
  `Tel` varchar(100) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `isDefault` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branchname`, `contactPerson`, `Tel`, `Address`, `isActive`, `isDefault`, `created_at`, `updated_at`) VALUES
(1, 'LUBOWA', NULL, NULL, NULL, NULL, 1, NULL, '2020-10-07 12:13:04');

-- --------------------------------------------------------

--
-- Stand-in structure for view `branchproducts`
-- (See below for the actual view)
--
CREATE TABLE `branchproducts` (
`id` int(11)
,`name` varchar(100)
,`stockcode` varchar(100)
,`description` varchar(100)
,`branch_id` int(11)
,`category` varchar(100)
,`subcategory` varchar(100)
,`openingstock` float
,`limitlevel` int(11)
,`buyingrate` int(11)
,`sellingrate` int(11)
,`unitofmeasure` int(11)
,`isActive` tinyint(1)
,`created_at` timestamp
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `bsheet`
-- (See below for the actual view)
--
CREATE TABLE `bsheet` (
`accountcode` int(11)
,`bracid` int(11)
,`ttype` varchar(4)
,`Debit` double(12,2)
,`transdates` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `bsheetpdfs`
-- (See below for the actual view)
--
CREATE TABLE `bsheetpdfs` (
`accountname` varchar(500)
,`accounttype` int(11)
,`accountcode` int(11)
,`bracid` int(11)
,`ttype` varchar(4)
,`Debit` double(12,2)
,`transdates` date
);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(90) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 'UnCategorized', NULL, NULL, NULL),
(2, 'PIECES', NULL, NULL, NULL),
(3, 'COSTUME', NULL, NULL, NULL),
(4, 'PANTS', NULL, NULL, NULL),
(5, 'T-SHIRTS', NULL, NULL, NULL),
(6, 'BLANKETS', NULL, NULL, NULL),
(7, 'SOCKS', NULL, NULL, NULL),
(8, 'SHIRTS', NULL, NULL, NULL),
(9, 'SHOES', NULL, NULL, NULL),
(10, 'VESTS', NULL, NULL, NULL),
(11, 'SWEATERS', NULL, NULL, NULL),
(12, 'JERSERY', NULL, NULL, NULL),
(13, 'BAGS', NULL, NULL, NULL),
(14, 'TOYS', NULL, NULL, NULL),
(15, 'JEANS', NULL, NULL, NULL),
(16, 'OVERALLS', NULL, NULL, NULL),
(17, 'TOWELS', NULL, NULL, NULL),
(18, 'JACKETS', NULL, NULL, NULL),
(19, 'NIGHTEES', NULL, NULL, NULL),
(20, '2 PIECE SETS LARGE GROUP', NULL, NULL, NULL),
(21, 'ACCESORIES', NULL, NULL, NULL),
(22, 'SHORTS', NULL, NULL, NULL),
(23, '2 PIECE SETS', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chartofaccounts`
--

CREATE TABLE `chartofaccounts` (
  `id` int(11) NOT NULL,
  `accountcode` int(11) DEFAULT NULL,
  `accountname` varchar(500) DEFAULT NULL,
  `accounttype` int(11) DEFAULT NULL,
  `mainaccount` int(11) DEFAULT NULL,
  `openingbal` int(11) DEFAULT NULL,
  `asof` date DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `isDefault` tinyint(1) DEFAULT NULL,
  `accept` tinyint(1) NOT NULL,
  `branchno` int(11) DEFAULT NULL,
  `isInventory` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chartofaccounts`
--

INSERT INTO `chartofaccounts` (`id`, `accountcode`, `accountname`, `accounttype`, `mainaccount`, `openingbal`, `asof`, `isActive`, `isDefault`, `accept`, `branchno`, `isInventory`, `created_at`, `updated_at`) VALUES
(5, 3600, 'Cash At Hand', 1, NULL, 0, NULL, 1, 0, 0, 1, 0, NULL, '2020-10-19 10:28:59'),
(42, 2314, 'Cash At Bank/Stanbic', 1, NULL, 0, NULL, NULL, 0, 0, 1, 0, NULL, '2020-11-02 08:59:32'),
(10, 1000, 'Sale of goods', 6, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(11, 1111, 'Accounts Recievable', 1, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, '2018-08-26 07:41:08'),
(12, 1001, 'Cost of goods', 7, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(13, 1112, 'Accounts Payable', 3, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(15, 1113, 'Inventory', 1, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(16, 1114, 'Retained Earnings', 5, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(17, 1120, 'Salaires', 7, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, '2018-11-05 10:08:49'),
(22, 3005, 'Airtime', 7, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(28, 3056, 'Rent', 7, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(24, 2202, 'Lunch', 7, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(25, 6070, 'Transport', 7, NULL, 0, NULL, NULL, NULL, 0, 1, 0, NULL, '2021-02-19 09:31:34'),
(26, 4500, 'Captial', 3, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(34, 7608, 'loan', 3, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(35, 4501, 'electricity', 7, NULL, NULL, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(38, 308, 'Retained Earnings', 5, NULL, 0, NULL, 1, 0, 0, 1, 0, NULL, NULL),
(41, 2312, 'Cash At Bank /Equity', 1, NULL, 0, NULL, NULL, 1, 0, 1, 1, NULL, '2021-01-12 10:42:58'),
(43, 33120, 'Point of Sale System', 7, NULL, 0, NULL, NULL, 0, 0, 1, 0, NULL, NULL),
(44, 4532, 'Other Expenses', 7, NULL, 0, NULL, NULL, 0, 0, 1, 0, NULL, NULL),
(45, 5423, 'UnKnown Deposits', 1, NULL, 0, NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(46, 5327, 'Telegraphic Transfers', 7, NULL, 0, NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(47, 8976, 'Transports & Taxes', 7, NULL, 0, NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(48, 2131, 'Printing Materials', 7, NULL, 0, NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(49, 2132, 'Packaging', 7, NULL, 0, NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(50, 2133, 'Repairs', 7, NULL, 0, NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(51, 1994, 'Goods Recivables', 1, NULL, 0, NULL, NULL, NULL, 0, 1, 0, NULL, NULL),
(52, 1993, 'Damaged Goods', 7, NULL, 0, NULL, NULL, NULL, 0, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `closeyears`
-- (See below for the actual view)
--
CREATE TABLE `closeyears` (
`accountcode` int(11)
,`name` varchar(400)
,`accounttype` int(11)
,`bracid` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `companynames`
--

CREATE TABLE `companynames` (
  `id` int(11) NOT NULL,
  `companyname` varchar(800) DEFAULT NULL,
  `boxnumber` varchar(150) DEFAULT NULL,
  `telphone` varchar(150) DEFAULT NULL,
  `location` varchar(600) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updatated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companys`
--

CREATE TABLE `companys` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `boxno` varchar(200) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `logo` varchar(800) DEFAULT NULL,
  `isPrint` tinyint(1) NOT NULL,
  `isBarCodePrint` int(11) NOT NULL DEFAULT '0',
  `printer` varchar(600) NOT NULL DEFAULT '0',
  `posprinter` varchar(300) DEFAULT NULL,
  `isbarcode` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companys`
--

INSERT INTO `companys` (`id`, `name`, `location`, `boxno`, `phone`, `email`, `logo`, `isPrint`, `isBarCodePrint`, `printer`, `posprinter`, `isbarcode`, `created_at`, `updated_at`) VALUES
(1, 'ROCKABOY COLLECTION LTD', 'QUALITY SHOPPING MALL LUBOWA', 'P.o Box OO', '+256704660119/+256752222344/+256200902221', 'rockaboycollection@gmail.com', 'rock.jpeg', 0, 0, 'Xprinter', 'Printer', 0, '2021-09-18 20:37:38', '2021-09-18 20:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `tel` varchar(55) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `tel`, `email`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 'Walk in Client \r\n', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'Madam Gloria', '(256) 772-451074', NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'Madam Mugisha', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'Madam Michelle', '(256) 759-330943', NULL, '254759330943', NULL, NULL, NULL, NULL),
(50, 'Trina Zuor', '(256) 772-961062', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Madam Rashida', '(256) 750-632186', 'Entebbe', NULL, NULL, NULL, NULL, '2021-01-07 12:05:47'),
(53, 'Madam Charlotte', '(256) 772-617787', 'Quality supermarket', NULL, NULL, NULL, NULL, NULL),
(54, 'Madam Victoria', '(256) 753-487193', NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'Mama Pesh', '(256) 782-006280', NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'Madam Deborah', '(256) 772-403046', NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'Madam Penninah', '(256) 794-600620', NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'Mr. Joseph', '(256) 782-151885', NULL, '256702151885', NULL, NULL, NULL, NULL),
(59, 'Mr. Victor', '(256) 782-186178', NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'Madam Geraldine', '(256) 776-263336', NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'Mash', '(256) 772-500888', NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'Madam Rosette', '(256) 700-443987', NULL, '256792344908', NULL, NULL, NULL, NULL),
(63, 'Daphine Rodgers', '(256) 782-053304', NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'Mama Daniel', '(256) 757-902420', NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'Mr. Simon', '(256) 782-565867', NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'Unknown', '(256) 701-852847', NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'Madam Ronnet', '(256) 784-397046', 'Kansanga', NULL, NULL, NULL, NULL, NULL),
(68, 'Madam Dorcus', '(256) 704-905502', NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'Madam Gladys', '(256) 781-381464', 'Luzira', '256701743331', NULL, NULL, NULL, NULL),
(70, 'Brenda Nnanjji', '(256) 776-695804', 'Bwebajja', NULL, NULL, NULL, NULL, NULL),
(71, 'Madam Doreen', '(256) 782-840932', NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'Madam Carol', '(256) 701-978525', NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'Unknown', '(256) 772-661558', NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'Madam Aisha', '(256) 752-880310', NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'Madam Alyen', '(256) 787-496471', NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'NATALE SYLVIA', '(256) 775-195169', NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'DON MUBIRI', '(256) 707-110404', 'KITENDE', '+256703916266', NULL, NULL, NULL, NULL),
(80, 'Madam Sophie', '(256) 787-481747', NULL, NULL, NULL, NULL, NULL, NULL),
(81, 'Mama Sami', '(256) 757-902420', NULL, NULL, NULL, NULL, NULL, NULL),
(82, 'Unknown', '(256) 775-946081', NULL, NULL, NULL, NULL, NULL, NULL),
(83, 'Madam Martha', '(256) 782-584505', NULL, '256751245562', NULL, NULL, NULL, NULL),
(84, 'Madam Phiona Mbabazi Umeme', '(256) 752-974337', NULL, NULL, NULL, NULL, NULL, NULL),
(85, 'Dr. Gumbo', '(256) 771-023544', NULL, NULL, NULL, NULL, NULL, NULL),
(86, 'Kiyemba Esther', '(256) 751-530981', 'ZANA', NULL, NULL, NULL, NULL, NULL),
(87, 'Mugabi Eunice', '(256) 755-588045', 'Entebbe', '256775588045', NULL, NULL, NULL, NULL),
(88, 'Madam Diana Quality', '(256) 782-581690', 'kigo', NULL, NULL, NULL, NULL, NULL),
(89, 'jalia', '(256) 705-364372', 'lubowa', NULL, NULL, NULL, NULL, NULL),
(90, 'Safi Jessica', '(256) 773-488789', 'Kitende', NULL, NULL, NULL, NULL, NULL),
(91, 'Ezamaru Ronald', '(256) 757-717674', '38 Nsamizi Road Entebbe', '256707110438', NULL, NULL, NULL, NULL),
(92, 'Madam Racheal', '(256) 751-334228', NULL, NULL, NULL, NULL, NULL, NULL),
(93, 'Alisat Fai', '(256) 780-906216', NULL, NULL, NULL, NULL, NULL, NULL),
(94, 'Aunt Tugee', '(256) 704-660119', NULL, NULL, NULL, NULL, NULL, NULL),
(95, 'Madam Jessica', '(256) 752-783748', NULL, NULL, NULL, NULL, NULL, NULL),
(96, 'Madam Christella', '(256) 759-745021', 'Akright Entebbe', NULL, NULL, NULL, NULL, NULL),
(97, 'Madam Ndibalekera Madrine', '(256) 784-552923', NULL, NULL, NULL, NULL, NULL, NULL),
(98, 'Madam Nabukenya Felicity', '(256) 701-543441', NULL, NULL, NULL, NULL, NULL, NULL),
(99, 'Madam Carol Atuhire', '(256) 701-078525', NULL, NULL, NULL, NULL, NULL, NULL),
(100, 'Madam Julia', '(256) 758-103686', 'Buziga', NULL, NULL, NULL, NULL, NULL),
(101, 'Madam Sarah Kakooza', '(266) 778-284604', NULL, NULL, NULL, NULL, NULL, NULL),
(102, 'Mr. Eric', '(256) 785-652017', NULL, NULL, NULL, NULL, NULL, NULL),
(103, 'Madam Lillian', '(256) 776-361037', NULL, NULL, NULL, NULL, NULL, NULL),
(104, 'Mr. Martin', '(256) 702-366189', NULL, '256782366189', NULL, NULL, NULL, NULL),
(105, 'Madam May', '(256) 788-193774', NULL, NULL, NULL, NULL, NULL, NULL),
(106, 'Mr. DAVID', '(256) 785-445135', NULL, NULL, NULL, NULL, NULL, NULL),
(107, 'Madam Racheal Damulira', '(256) 753-508540', NULL, NULL, NULL, NULL, NULL, NULL),
(108, 'Madam Mimi', '(256) 771-949798', NULL, NULL, NULL, NULL, NULL, NULL),
(109, 'Madam Allen', '(256) 787-496471', NULL, NULL, NULL, NULL, NULL, NULL),
(110, 'Madam Suzan', '(256) 780-139887', NULL, NULL, NULL, NULL, NULL, NULL),
(111, 'Zaitun', '(256) 703-535953', NULL, NULL, NULL, NULL, NULL, NULL),
(112, 'Mr. DAVID AMOOTI', '(256) 772-465464', NULL, NULL, NULL, NULL, NULL, NULL),
(113, 'Madam Blessing', '(256) 700-941131', NULL, NULL, NULL, NULL, NULL, NULL),
(114, 'Mr. Emmanuel Wamala', '(256) 703-802139', NULL, NULL, NULL, NULL, NULL, NULL),
(116, 'Madam Liilian Mutesi', '(256) 786-980145', NULL, NULL, NULL, NULL, NULL, '2021-05-23 13:44:23'),
(117, 'julia', '(077) 267-3066__', 'entebbe', NULL, NULL, NULL, NULL, NULL),
(118, 'Mr. George', '(256) 752-670041', 'Muyenga', NULL, NULL, NULL, NULL, NULL),
(120, 'FRANCIS', '(075) 000-333___', 'KIREKA', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `editexpenses`
-- (See below for the actual view)
--
CREATE TABLE `editexpenses` (
`code` int(11)
,`id` int(11)
,`name` varchar(500)
);

-- --------------------------------------------------------

--
-- Table structure for table `expenseinvoices`
--

CREATE TABLE `expenseinvoices` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `invoice_header` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenseinvoices`
--

INSERT INTO `expenseinvoices` (`id`, `amount`, `invoice_header`, `date`, `created_at`, `updated_at`) VALUES
(1, 40000, 2, '0000-00-00', '2021-08-22 21:50:16', '2021-08-22 21:50:16'),
(2, 10000, 4, '0000-00-00', '2021-08-22 22:06:38', '2021-08-22 22:06:38'),
(3, 10000, 6, '0000-00-00', '2021-08-22 22:13:00', '2021-08-22 22:13:00'),
(4, 35000, 8, '0000-00-00', '2021-08-28 21:26:44', '2021-08-28 21:26:44'),
(5, 35000, 9, '0000-00-00', '2021-08-28 21:30:39', '2021-08-28 21:30:39'),
(6, 140000, 11, '0000-00-00', '2021-08-29 19:47:49', '2021-08-29 19:47:49'),
(7, 250000, 14, '0000-00-00', '2021-09-04 19:39:22', '2021-09-04 19:39:22'),
(8, 0, 16, '0000-00-00', '2021-09-04 20:56:05', '2021-09-04 20:56:05'),
(9, 100000, 19, '0000-00-00', '2021-09-13 13:55:11', '2021-09-13 13:55:11'),
(10, 30000, 21, '0000-00-00', '2021-09-13 14:01:26', '2021-09-13 14:01:26'),
(11, 50000, 25, '0000-00-00', '2021-09-18 19:16:51', '2021-09-18 19:16:51'),
(12, 20000, 27, '0000-00-00', '2021-09-18 20:45:22', '2021-09-18 20:45:22'),
(13, 3504000, 29, '0000-00-00', '2021-11-03 20:48:27', '2021-11-03 20:48:27'),
(14, 140000, 29, '0000-00-00', '2021-11-03 20:48:47', '2021-11-03 20:48:47'),
(15, 200000, 31, '0000-00-00', '2021-11-06 09:25:34', '2021-11-06 09:25:34'),
(16, 3644000, 33, '0000-00-00', '2021-11-06 09:40:32', '2021-11-06 09:40:24'),
(17, 3644000, 33, '0000-00-00', '2021-11-06 15:32:37', '2021-11-06 09:40:38'),
(18, 5000, 34, '0000-00-00', '2021-11-06 10:57:06', '2021-11-06 10:57:06'),
(19, 7000, 35, '0000-00-00', '2021-11-06 10:58:05', '2021-11-06 10:58:05'),
(20, 70000, 36, '0000-00-00', '2021-11-06 10:59:05', '2021-11-06 10:59:05'),
(21, 3644000, 37, '0000-00-00', '2021-11-06 15:41:19', '2021-11-06 16:40:53'),
(22, 3644000, 37, '0000-00-00', '2021-11-06 15:41:19', '2021-11-06 16:41:18'),
(23, 3644000, 37, '0000-00-00', '2021-11-06 15:42:49', '2021-11-06 16:42:17'),
(24, 3644000, 37, '0000-00-00', '2021-11-06 15:42:49', '2021-11-06 16:42:47'),
(25, 20000, 2, '0000-00-00', '2021-12-04 15:03:00', '2021-12-04 15:03:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `expensepdfs`
-- (See below for the actual view)
--
CREATE TABLE `expensepdfs` (
`transdate` date
,`narration` varchar(500)
,`amount` double(11,2)
,`ttype` varchar(4)
,`accountname` varchar(500)
,`bracid` int(11)
,`accountcode` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `financialyears`
--

CREATE TABLE `financialyears` (
  `id` int(11) NOT NULL,
  `startperiod` date DEFAULT NULL,
  `endperiod` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `yearnumber` int(11) NOT NULL DEFAULT '1',
  `yearstatus` tinyint(1) DEFAULT '0',
  `branchid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `financialyears`
--

INSERT INTO `financialyears` (`id`, `startperiod`, `endperiod`, `status`, `yearnumber`, `yearstatus`, `branchid`, `created_at`, `updated_at`) VALUES
(1, '2020-06-01', '2021-05-31', 0, 1, 1, 1, NULL, '2021-01-04 15:45:12'),
(2, '2021-06-01', '2022-05-31', 1, 1, 0, 1, NULL, '2021-06-03 17:36:28');

-- --------------------------------------------------------

--
-- Stand-in structure for view `incomepdfs`
-- (See below for the actual view)
--
CREATE TABLE `incomepdfs` (
`transdate` date
,`narration` varchar(500)
,`amount` double(11,2)
,`ttype` varchar(4)
,`accountname` varchar(500)
,`bracid` int(11)
,`accountcode` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `incomestatement`
-- (See below for the actual view)
--
CREATE TABLE `incomestatement` (
`accountname` varchar(500)
,`accounttype` int(11)
,`accountcode` int(11)
,`type` varchar(400)
,`Debit` double(19,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `incstat`
-- (See below for the actual view)
--
CREATE TABLE `incstat` (
`ttype` varchar(4)
,`amount` double(11,2)
,`credit` varchar(6)
,`accountname` varchar(500)
,`accounttype` int(11)
,`accountcode` int(11)
,`type` varchar(400)
,`transdates` date
);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoiceDate` date NOT NULL,
  `supplierName` int(11) NOT NULL,
  `batchNo` varchar(200) NOT NULL,
  `isSaved` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoiceDate`, `supplierName`, `batchNo`, `isSaved`, `created_at`, `updated_at`) VALUES
(1, '2021-12-04', 1, '', 1, '2021-12-04 15:00:43', '2021-12-04 15:00:43'),
(2, '2021-12-04', 1, '', 1, '2021-12-04 15:03:00', '2021-12-04 15:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `itemgroups`
--

CREATE TABLE `itemgroups` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `itemgroups`
--

INSERT INTO `itemgroups` (`id`, `name`, `updated_at`, `created_at`) VALUES
(1, 'UnGrouped', '2020-11-02 04:39:24', '2020-11-02 04:39:24');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `firstname` varchar(89) DEFAULT NULL,
  `lastname` varchar(89) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updatated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2018_06_16_104819_create_registers_table', 1),
(2, '2018_06_16_104819_create_posts_table', 2),
(3, '2018_06_18_060031_create_stocks_table', 3),
(4, '2018_06_20_125712_create_data_table', 4),
(5, '2018_06_23_084128_create_code_generators_table', 5),
(6, '2018_06_26_121100_create_pupils_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `modeofpayments`
--

CREATE TABLE `modeofpayments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `isDefault` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modeofpayments`
--

INSERT INTO `modeofpayments` (`id`, `name`, `isActive`, `isDefault`, `created_at`, `updated_at`) VALUES
(1, 'Cash', 1, NULL, NULL, NULL),
(2, 'Cheque', 1, NULL, NULL, NULL),
(3, 'Credit', 1, NULL, NULL, NULL),
(4, 'Eft', 1, NULL, NULL, NULL),
(5, 'Loans', NULL, NULL, NULL, NULL),
(6, 'MTN Mobile Money', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `orders` int(11) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `isOthers` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `orders`, `isActive`, `isAdmin`, `isOthers`, `created_at`, `updated_at`) VALUES
(1, 'Sales', 1, 1, 0, 0, NULL, '2019-02-12 10:09:32'),
(2, 'Inventory Setup', 8, 1, 0, 0, NULL, '2018-10-18 13:14:55'),
(3, 'Reports', 6, 1, 0, 0, NULL, '2018-09-01 03:24:29'),
(6, 'Utilities', 7, 1, 0, 0, NULL, '2018-09-01 03:24:34'),
(8, 'Accounts', 5, 1, 0, 0, NULL, '2018-09-01 03:24:38'),
(12, 'Purchases', 2, 1, 0, 0, NULL, NULL),
(13, 'Banking', 3, 1, 0, 0, NULL, '2020-10-16 10:38:23'),
(15, 'Expenses', 3, 1, 0, 0, NULL, NULL),
(16, 'Incomes', 4, 1, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `newpurchases`
--

CREATE TABLE `newpurchases` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `invoice_no` int(11) NOT NULL,
  `header` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `limits` int(11) NOT NULL,
  `category` int(11) NOT NULL DEFAULT '1',
  `cost` int(11) NOT NULL,
  `selling` int(11) NOT NULL,
  `isSave` int(11) DEFAULT '0',
  `recqty` int(11) NOT NULL,
  `dmgqty` int(11) NOT NULL,
  `remarks` varchar(400) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `newpurchases`
--

INSERT INTO `newpurchases` (`id`, `name`, `qty`, `price`, `subtotal`, `invoice_no`, `header`, `description`, `limits`, `category`, `cost`, `selling`, `isSave`, `recqty`, `dmgqty`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Toshiba', 4, 5000, 20000, 1, 5, 'fffff', 2, 1, 10714, 25000, 1, 0, 0, 'ff', '2021-12-04 14:11:26', '2021-12-04 15:11:26'),
(2, 'fff', 3, 3000, 9000, 1, 5, 'ddd', 5, 5, 8714, 15000, 1, 0, 0, '66', '2021-12-04 14:11:26', '2021-12-04 15:11:26');

-- --------------------------------------------------------

--
-- Stand-in structure for view `outofstock`
-- (See below for the actual view)
--
CREATE TABLE `outofstock` (
`stock` int(1)
,`limitlevel` bigint(11)
,`ctrlLimit` varchar(39)
);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `pendings`
-- (See below for the actual view)
--
CREATE TABLE `pendings` (
`transdate` date
,`customer` varchar(100)
,`purchaseheaderid` int(11)
,`totalamt` double(19,2)
,`bal` double(19,2)
,`totalpaid` double(19,2)
,`stockname` varchar(200)
);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Title` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `Posts` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `created_at`, `updated_at`, `Title`, `Posts`) VALUES
(1, '2018-06-15 21:00:00', NULL, 'post one', 'this is post one as the body'),
(2, '2018-06-16 21:00:00', NULL, 'Post Two', 'This is body for post two'),
(3, '2018-06-16 16:36:56', '2018-06-16 16:36:56', 'Post three', 'This is post for three'),
(4, '2018-06-16 16:53:39', '2018-06-17 09:08:42', 'post Vier', 'Diese fur post vier es im deutsch geschrieben'),
(5, '2018-06-16 16:56:58', '2018-06-16 16:56:58', 'Post Sechs', 'Diese Sechs'),
(6, '2018-06-17 08:13:37', '2018-06-17 08:13:37', 'Sieben', 'Diese ist Post Sieben'),
(7, '2018-06-18 02:56:18', '2018-06-18 02:56:18', 'Acht', 'Diese Post nummer acht'),
(8, '2018-06-18 07:23:53', '2018-06-18 07:23:53', 'Post neun', 'Diese ist Post nummer Neun'),
(9, '2018-06-21 11:12:22', '2018-06-21 11:12:22', 'same', 'go'),
(10, '2018-06-21 11:14:43', '2018-06-21 11:14:43', 'ff', 'denis');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `barcode` varchar(400) DEFAULT NULL,
  `first` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `barcode`, `first`, `created_at`, `updated_at`) VALUES
(9, 'Apple Vegetables', '1234567898765', '', '2020-10-03 16:22:44', '2019-06-13 07:05:14'),
(10, 'Cake Black Forest', '1234567876543', '', '2020-10-02 22:06:15', '2019-06-13 07:07:53'),
(11, 'Meat Vegetables ', '2345678765434', '', '2020-10-02 22:06:49', '2019-06-13 07:11:10'),
(12, 'Beef Meat', '2345432678653', '', '2020-10-03 06:54:21', '0000-00-00 00:00:00'),
(13, 'Goat Pillau', '1234564323454', '', '2020-10-03 06:54:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseheaders`
--

CREATE TABLE `purchaseheaders` (
  `id` int(11) NOT NULL,
  `transdates` date DEFAULT NULL,
  `mode` varchar(90) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseheaders`
--

INSERT INTO `purchaseheaders` (`id`, `transdates`, `mode`, `supplier_id`, `customer_id`, `branch_id`, `remarks`, `isActive`, `created_at`, `updated_at`) VALUES
(1, '2021-12-04', NULL, NULL, NULL, 1, NULL, NULL, '2021-12-04 14:40:06', '2021-12-04 14:40:06'),
(2, '2021-12-04', NULL, NULL, NULL, 1, NULL, NULL, '2021-12-04 14:47:27', '2021-12-04 14:47:27'),
(3, '2021-12-04', NULL, NULL, NULL, 1, NULL, 1, '2021-12-04 14:49:58', '2021-12-04 14:49:58'),
(4, '2021-12-04', NULL, NULL, NULL, 1, NULL, 1, '2021-12-04 14:53:43', '2021-12-04 14:53:43'),
(5, '2021-12-04', NULL, NULL, NULL, 1, NULL, 1, '2021-12-04 15:00:44', '2021-12-04 15:00:44'),
(6, '2021-12-04', NULL, NULL, NULL, 1, NULL, 1, '2021-12-04 15:03:00', '2021-12-04 15:03:00'),
(7, '2021-12-04', NULL, NULL, NULL, 1, NULL, NULL, '2021-12-04 15:11:26', '2021-12-04 15:11:26'),
(8, '2021-12-04', NULL, NULL, NULL, 1, NULL, NULL, '2021-12-04 15:11:26', '2021-12-04 15:11:26'),
(9, '2021-12-04', NULL, NULL, NULL, 1, NULL, NULL, '2021-12-04 15:12:16', '2021-12-04 15:12:16'),
(10, '2021-12-04', NULL, NULL, NULL, 1, NULL, NULL, '2021-12-04 15:12:16', '2021-12-04 15:12:16'),
(11, '2021-12-04', NULL, NULL, NULL, 1, NULL, NULL, '2021-12-04 15:12:27', '2021-12-04 15:12:27'),
(12, '2021-12-04', NULL, NULL, NULL, 1, NULL, NULL, '2021-12-04 15:12:27', '2021-12-04 15:12:27'),
(13, '2021-12-04', NULL, NULL, NULL, 1, NULL, NULL, '2021-12-04 15:12:45', '2021-12-04 15:12:45'),
(14, '2021-12-04', NULL, NULL, NULL, 1, NULL, NULL, '2021-12-04 15:12:45', '2021-12-04 15:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `recievedstocks`
--

CREATE TABLE `recievedstocks` (
  `id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `date` date NOT NULL,
  `item_code` int(11) NOT NULL,
  `purchaseNo` int(11) NOT NULL,
  `remarks` varchar(2000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recievedstocks`
--

INSERT INTO `recievedstocks` (`id`, `qty`, `date`, `item_code`, `purchaseNo`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 4, '2021-12-04', 3, 7, 'ff', '2021-12-04 15:11:26', 2021),
(2, 3, '2021-12-04', 4, 8, '66', '2021-12-04 15:11:26', 2021);

-- --------------------------------------------------------

--
-- Table structure for table `registers`
--

CREATE TABLE `registers` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `firstname` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registers`
--

INSERT INTO `registers` (`id`, `created_at`, `updated_at`, `firstname`, `lastname`, `phone`) VALUES
(1, '2018-06-16 08:31:56', '2018-06-16 08:31:56', 'ssamba', 'denis', 704531731),
(2, '2018-06-16 08:36:22', '2018-06-16 08:36:22', 'edwin', 'Niwaha', 704563172),
(3, '2018-06-16 08:51:13', '2018-06-16 08:51:13', 'makerere', 'univerty', 70456382);

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE `requirements` (
  `id` int(11) NOT NULL,
  `name` varchar(300) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `Urls` varchar(300) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requirements`
--

INSERT INTO `requirements` (`id`, `name`, `module_id`, `Urls`, `isActive`, `admin`, `created_at`, `updated_at`) VALUES
(4, 'Set Functionality', 7, '/requirements', 1, 0, NULL, '2020-10-12 16:31:10'),
(3, 'Supplier Entry', 2, '/suppliers', 1, 1, NULL, '2020-10-12 16:31:15'),
(5, 'Customer Entry', 2, '/customers', 1, 0, NULL, '2020-10-12 16:31:20'),
(6, 'Category Setup', 2, '/categories', 1, 1, NULL, '2020-10-24 13:04:20'),
(7, 'Sub-Category Setup', 2, '/subcategories', 0, 0, NULL, '2020-10-12 16:31:32'),
(8, 'Unit of Measure Setup', 2, '/uoms', 1, 1, NULL, '2020-10-12 16:31:39'),
(9, 'Setup Module', 7, '/modules', 1, 0, NULL, '2020-10-12 16:31:45'),
(10, 'Designer', 7, '/CodeGenerator', 1, 0, NULL, '2020-10-12 16:31:52'),
(11, 'Stock Entry', 2, '/stocks', 1, 1, NULL, '2020-10-12 16:31:57'),
(12, 'Purchase Stock', 12, '/newpurchase', 1, 1, NULL, '2021-08-22 21:28:29'),
(13, 'Set Payment Mode', 7, 'modeofpayments', 1, 0, NULL, NULL),
(16, 'Stock Sales', 1, '/barcodesales', 1, 0, NULL, '2020-10-09 16:48:00'),
(17, 'Sales Reports', 1, '/salesreport', 1, 0, NULL, '2020-10-12 16:32:36'),
(18, 'Purchase Report', 12, '/newpurchasereports', 1, 1, NULL, '2021-08-22 21:27:49'),
(19, 'Outsanding', 1, 'outstandings', 0, 0, NULL, '2020-10-09 11:35:47'),
(20, 'Pending Purchases', 12, 'pending', 0, 1, NULL, '2020-10-27 05:18:14'),
(21, 'Branch Setup', 2, 'branches', 0, 0, NULL, '2020-10-13 16:58:51'),
(22, 'Stock Transfer', 2, 'stocktransfers', 0, 0, NULL, '2020-10-12 17:05:28'),
(23, 'Stock Report', 3, '/stockreport', 1, 1, NULL, '2020-10-12 16:32:55'),
(24, 'Account Types', 8, 'accounttypes', 0, 0, NULL, '2018-10-18 12:32:20'),
(26, 'Chart of Accounts', 6, '/chartofaccounts', 1, 1, NULL, '2020-10-16 10:34:38'),
(27, 'Pay Expenses', 15, '/expenses', 1, 1, NULL, '2020-10-12 16:34:53'),
(28, 'Ledgers', 8, '/ledgers', 1, 1, NULL, '2020-10-12 16:34:44'),
(29, 'Total Expenses', 15, '/totalexpenses', 1, 1, NULL, '2020-10-12 16:34:37'),
(30, 'Trial Balance', 8, '/trialbalance', 1, 1, NULL, '2020-10-12 16:34:30'),
(31, 'Balance Sheet', 8, '/balancesheet', 1, 1, NULL, '2020-10-12 16:50:58'),
(32, 'Recieve other Incomes', 16, '/otherincomes', 1, 1, NULL, '2020-10-12 16:34:18'),
(33, 'Income Statement', 8, '/incomestats', 1, 1, NULL, '2020-10-12 16:34:11'),
(34, 'Inventory Accounts', 6, '/inventorysettings', 1, 1, NULL, '2020-10-19 06:41:56'),
(35, 'Financial Period', 6, '/financialyears', 1, 1, NULL, '2020-10-16 10:34:49'),
(36, 'Create a Company', 6, '/companynames', 0, 1, NULL, '2020-10-12 16:33:49'),
(37, 'Total Income', 16, '/totalincome', 1, 1, NULL, '2020-10-12 16:33:33'),
(39, 'User Management', 6, '/users', 1, 1, NULL, '2020-10-12 16:33:40'),
(40, 'Profits per Item', 3, 'itemprofits', 1, 1, NULL, '2020-10-28 08:01:57'),
(41, 'Funds Transfer', 8, 'fundtransfers', 0, 0, NULL, '2018-10-18 12:33:29'),
(42, 'Journal Entry', 8, '/journels', 1, 1, NULL, '2020-10-12 16:32:29'),
(44, 'Workers', 1, 'workers', 0, 0, NULL, '2018-10-18 12:52:34'),
(45, 'Enter workers', 17, 'workers', 1, 0, NULL, NULL),
(48, 'Transfer Reports', 3, 'transferreports', 0, 0, NULL, '2020-10-12 17:03:29'),
(49, 'Journal Rpts', 8, '/journelreports', 1, 1, NULL, NULL),
(50, 'My Company', 6, '/companys', 1, 1, NULL, NULL),
(51, 'Deposits', 13, '/bankings', 1, 1, NULL, NULL),
(52, 'Group Item', 2, '/itemgroups', 1, 1, NULL, NULL),
(53, 'Customer Ledger', 1, '/customerledger', 1, 0, NULL, NULL),
(54, 'Credit Sales', 1, '/salespending', 1, 0, NULL, NULL),
(55, 'Sales Conversion', 1, '/salesconversion', 1, 0, NULL, '2021-01-12 10:18:45'),
(56, 'Stock Transactions', 3, 'stockdetails', 1, 1, NULL, NULL),
(57, 'Inventory Entry & Expenses', 12, '/invoicereports', 1, 0, NULL, NULL),
(58, 'Recieved Stock', 12, '/recievedstock', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `retainedearnings`
--

CREATE TABLE `retainedearnings` (
  `id` int(11) NOT NULL,
  `acode` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `yearStart` date NOT NULL,
  `yearEnd` date NOT NULL,
  `branchid` int(11) NOT NULL,
  `isFirst` tinyint(1) NOT NULL,
  `isComplete` int(11) NOT NULL DEFAULT '0',
  `yearid` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stockbals`
--

CREATE TABLE `stockbals` (
  `id` int(11) NOT NULL,
  `headno` int(11) NOT NULL,
  `balance` int(11) DEFAULT NULL,
  `stocktransid` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `stockcode` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `category` varchar(100) DEFAULT '1',
  `subcategory` varchar(100) DEFAULT NULL,
  `openingstock` float DEFAULT NULL,
  `openingstok` double NOT NULL,
  `limitlevel` int(11) DEFAULT NULL,
  `buyingrate` int(11) DEFAULT NULL,
  `buyingrateitem` int(11) DEFAULT NULL,
  `sellingrate` int(11) DEFAULT NULL,
  `wholeprice` int(11) DEFAULT NULL,
  `wholeitemp` int(11) DEFAULT NULL,
  `unitofmeasure` int(11) DEFAULT NULL,
  `barcode` varchar(500) DEFAULT NULL,
  `saveid` int(11) NOT NULL DEFAULT '0',
  `stockheader` int(11) NOT NULL DEFAULT '0',
  `delhead` int(11) NOT NULL DEFAULT '0',
  `partno` varchar(200) DEFAULT NULL,
  `groupitem` int(11) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `name`, `stockcode`, `description`, `branch_id`, `category`, `subcategory`, `openingstock`, `openingstok`, `limitlevel`, `buyingrate`, `buyingrateitem`, `sellingrate`, `wholeprice`, `wholeitemp`, `unitofmeasure`, `barcode`, `saveid`, `stockheader`, `delhead`, `partno`, `groupitem`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 'Computer Desktop', 'ComputerDesktop-0', 'tOSHIBA', 1, '5', NULL, 10, 10, 5, 3000, 3, 7000, NULL, NULL, 1, '00000000000001', 0, 0, 0, '3333333', 1, NULL, NULL, NULL),
(2, 'pandol Extra', 'pandolExtra-1', 'ddk', 1, '5', NULL, 90, 90, 45, 40000, 40, 60000, NULL, NULL, 1, '00000000000002', 0, 0, 0, NULL, 1, NULL, NULL, NULL),
(3, 'Toshiba', 'Toshiba-2', 'fffff', 1, '1', NULL, 4, 4, 2, 10714, 10714, 25000, NULL, NULL, 1, '00000000000003', 1, 5, 7, '', 1, 1, NULL, NULL),
(4, 'fff', 'fff-3', 'ddd', 1, '5', NULL, 3, 3, 5, 8714, 8714, 15000, NULL, NULL, 1, '00000000000005', 2, 5, 8, '', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stocktrans`
--

CREATE TABLE `stocktrans` (
  `id` int(11) NOT NULL,
  `purchaseheaderid` int(11) DEFAULT NULL,
  `transdate` date DEFAULT NULL,
  `stockname` varchar(200) DEFAULT NULL,
  `quantity` int(11) DEFAULT '0',
  `qua` int(11) NOT NULL DEFAULT '0',
  `type` varchar(4) DEFAULT NULL,
  `totalamt` double(11,2) DEFAULT NULL,
  `totalpaid` double(11,2) DEFAULT NULL,
  `totaldue` int(11) DEFAULT NULL,
  `sellingrate` int(11) DEFAULT NULL,
  `buyingrate` double(11,2) DEFAULT '0.00',
  `transfercode` int(11) NOT NULL,
  `branchno` int(11) NOT NULL,
  `customer` varchar(300) NOT NULL,
  `delheader` int(11) NOT NULL DEFAULT '0',
  `isInput` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stocktrans`
--

INSERT INTO `stocktrans` (`id`, `purchaseheaderid`, `transdate`, `stockname`, `quantity`, `qua`, `type`, `totalamt`, `totalpaid`, `totaldue`, `sellingrate`, `buyingrate`, `transfercode`, `branchno`, `customer`, `delheader`, `isInput`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-12-04', '1', 10, 10, 'I', NULL, NULL, NULL, NULL, 3000.00, 0, 1, '', 0, 1, '2021-12-04 14:40:06', '2021-12-04 14:40:06'),
(2, 2, '2021-12-04', '2', 90, 90, 'I', NULL, NULL, NULL, NULL, 40000.00, 0, 1, '', 0, 1, '2021-12-04 14:47:27', '2021-12-04 14:47:27'),
(3, 3, '2021-12-04', '1', 6, 0, 'O', 42000.00, 42000.00, NULL, 42000, 18000.00, 0, 1, '1', 0, 0, '2021-12-04 14:49:58', '2021-12-04 14:49:58'),
(4, 3, '2021-12-04', '2', 50, 0, 'O', 3000000.00, 3000000.00, NULL, 3000000, 2000000.00, 0, 1, '1', 0, 0, '2021-12-04 14:49:58', '2021-12-04 14:49:58'),
(5, 4, '2021-12-04', '1', 1, 0, 'O', 7000.00, 7000.00, NULL, 7000, 3000.00, 0, 1, '85', 0, 0, '2021-12-04 14:53:43', '2021-12-04 14:53:43'),
(6, 5, '2021-12-04', '3', 4, 4, 'I', NULL, NULL, NULL, NULL, 10714.00, 0, 1, '', 7, 1, '2021-12-04 15:11:26', '2021-12-04 15:11:26'),
(7, 5, '2021-12-04', '4', 3, 3, 'I', NULL, NULL, NULL, NULL, 8714.00, 0, 1, '', 8, 1, '2021-12-04 15:11:26', '2021-12-04 15:11:26'),
(8, 5, '2021-12-04', '3', 0, 0, 'I', NULL, NULL, NULL, NULL, 10714.00, 0, 1, '', 9, 1, '2021-12-04 15:12:16', '2021-12-04 15:12:16'),
(9, 5, '2021-12-04', '4', 0, 0, 'I', NULL, NULL, NULL, NULL, 8714.00, 0, 1, '', 10, 1, '2021-12-04 15:12:16', '2021-12-04 15:12:16'),
(10, 5, '2021-12-04', '3', 0, 0, 'I', NULL, NULL, NULL, NULL, 10714.00, 0, 1, '', 11, 1, '2021-12-04 15:12:27', '2021-12-04 15:12:27'),
(11, 5, '2021-12-04', '4', 0, 0, 'I', NULL, NULL, NULL, NULL, 8714.00, 0, 1, '', 12, 1, '2021-12-04 15:12:27', '2021-12-04 15:12:27'),
(12, 5, '2021-12-04', '3', 0, 0, 'I', NULL, NULL, NULL, NULL, 10714.00, 0, 1, '', 13, 1, '2021-12-04 15:12:45', '2021-12-04 15:12:45'),
(13, 5, '2021-12-04', '4', 0, 0, 'I', NULL, NULL, NULL, NULL, 8714.00, 0, 1, '', 14, 1, '2021-12-04 15:12:45', '2021-12-04 15:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `subname` varchar(100) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `subname`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 'Andriod', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `companyName` varchar(300) DEFAULT NULL,
  `contactPerson` varchar(100) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address1` varchar(120) DEFAULT NULL,
  `address2` varchar(120) DEFAULT NULL,
  `isDefault` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `companyName`, `contactPerson`, `tel`, `email`, `address1`, `address2`, `isDefault`, `created_at`, `updated_at`) VALUES
(1, 'System Default', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-11-02 05:15:05');

-- --------------------------------------------------------

--
-- Stand-in structure for view `tb`
-- (See below for the actual view)
--
CREATE TABLE `tb` (
`accounttype` int(11)
,`accountname` varchar(500)
,`Debit` double(19,2)
,`Credits` double(19,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `available` int(11) NOT NULL DEFAULT '0',
  `sellingpx` int(11) NOT NULL,
  `member_id` int(11) NOT NULL DEFAULT '2',
  `header` int(11) NOT NULL DEFAULT '0',
  `stockid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `totalincome`
-- (See below for the actual view)
--
CREATE TABLE `totalincome` (
`ttype` varchar(4)
,`amount` double(11,2)
,`credit` varchar(6)
,`accountname` varchar(500)
,`accounttype` int(11)
,`accountcode` int(11)
,`type` varchar(400)
,`transdates` date
);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `trial`
-- (See below for the actual view)
--
CREATE TABLE `trial` (
`accountcode` int(11)
,`Debit` double(19,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `trialfooter`
-- (See below for the actual view)
--
CREATE TABLE `trialfooter` (
`transdate` date
,`accountname` varchar(500)
,`accountcode` int(11)
,`Debits` double(19,2)
,`Credits` double(19,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `trialpdfs`
-- (See below for the actual view)
--
CREATE TABLE `trialpdfs` (
`bracid` int(11)
,`amount` double(11,2)
,`ttype` varchar(4)
,`accountname` varchar(500)
,`accountcode` int(11)
,`transdate` date
);

-- --------------------------------------------------------

--
-- Table structure for table `uoms`
--

CREATE TABLE `uoms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `primaryuom` varchar(400) NOT NULL,
  `secondaryuom` varchar(400) NOT NULL,
  `uomalias` varchar(400) NOT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uoms`
--

INSERT INTO `uoms` (`id`, `name`, `primaryuom`, `secondaryuom`, `uomalias`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 'Pcs', 'Pcs', 'Pcs', '', 1, NULL, '2019-06-18 08:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `branchid` int(11) NOT NULL,
  `branchname` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `isAdmin`, `branchid`, `branchname`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mikel', 'denisdenha@gmail.com', '$2y$10$FB3u4bb1mQDxcLWVMEI2vOwZDxSf.1yw334r2wQl6Qfuw7gkrwoAq', 1, 0, 1, 'Bisoboka Savings Group', 'P2qFVpbJjWpTHe5hwBcgOylzf3Sa4CyexnTtHa2nIGyYxbTxapT1CH3rWi1y', NULL, '2020-09-30 02:16:25'),
(11, 'Anata', 'anata@gmail.com', '$2y$10$3GhMF4GJn5z3SWIJeRM85eGrVNB5ZciB.p3k0QEVYo/J0vpMAxB0C', 1, 0, 1, 'ROCKABOY COLLECTION LTD', 'PN5hdOSW9YAc7AkysGInqpxP5UAm3Y9wP8UswzrDtVVQIiDuqZQFA930yb2E', NULL, NULL),
(12, 'Hanna', 'hanna@gmail.com', '$2y$10$6h.kOuLkEuUtcC9d5iPh1uhOZyYN5WbSMxvrwhn4iT.qe6vnmTlq.', 0, 0, 1, 'ROCKABOY COLLECTION LTD', '26cN3zsTHZAEW2URL80grkWfzohQ4ihVIpytyToLTFTTtc6iNpNnv4r1i1tR', NULL, NULL),
(13, 'hamy kasim', 'hamzamatovuk@gmail.com', '$2y$10$JR6VoEAFCUtcYsyAVsoXNOEOSMjq2mK5cWYQVjAoEJIp5/5S0G.CK', 1, 0, 1, 'ROCKABOY COLLECTION LTD', 'MTIobTAtDw1b8jU4nSWGYkdAA5eUSuBBIVnPZQslv8umuWVYs0Yqz1z26HEV', NULL, NULL),
(15, 'Denis', 'denis@gmail.com', '$2y$10$94XXsjTqp7RBYikKBu11u.NZkofD4iMd.1sLlHBgTF4KIUwtRRwHC', 0, 0, 1, 'ROCKABOY COLLECTION LTD', 'I1WY7MvNEoNYvCJoL2bTctPO9P7ng5iLzoQZOmL4CUUiOuE2pCFIyynFlFkG', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `id` int(11) NOT NULL,
  `name` varchar(114) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `yearexpenses`
-- (See below for the actual view)
--
CREATE TABLE `yearexpenses` (
`Expenses` double(11,2)
,`bracid` int(11)
,`Incomes` double(11,2)
,`accountcode` int(11)
,`amount` double(11,2)
,`ttype` varchar(4)
,`transdate` date
,`accounttype` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `accountnames`
--
DROP TABLE IF EXISTS `accountnames`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `accountnames`  AS  select `accounttrans`.`purchaseheaderid` AS `purchaseheaderid`,`accounttrans`.`stockidentify` AS `stockidentify`,`chartofaccounts`.`accountcode` AS `accountcode`,`chartofaccounts`.`accountname` AS `accountname` from (`accounttrans` join `chartofaccounts` on((`chartofaccounts`.`accountcode` = `accounttrans`.`accountcode`))) ;

-- --------------------------------------------------------

--
-- Structure for view `branchproducts`
--
DROP TABLE IF EXISTS `branchproducts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `branchproducts`  AS  select `stocks`.`id` AS `id`,`stocks`.`name` AS `name`,`stocks`.`stockcode` AS `stockcode`,`stocks`.`description` AS `description`,`stocks`.`branch_id` AS `branch_id`,`stocks`.`category` AS `category`,`stocks`.`subcategory` AS `subcategory`,`stocks`.`openingstock` AS `openingstock`,`stocks`.`limitlevel` AS `limitlevel`,`stocks`.`buyingrate` AS `buyingrate`,`stocks`.`sellingrate` AS `sellingrate`,`stocks`.`unitofmeasure` AS `unitofmeasure`,`stocks`.`isActive` AS `isActive`,`stocks`.`created_at` AS `created_at`,`stocks`.`updated_at` AS `updated_at` from `stocks` where (`stocks`.`branch_id` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `bsheet`
--
DROP TABLE IF EXISTS `bsheet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bsheet`  AS  select `accounttrans`.`accountcode` AS `accountcode`,`accounttrans`.`bracid` AS `bracid`,`accounttrans`.`ttype` AS `ttype`,if((`accounttrans`.`ttype` = 'D'),`accounttrans`.`amount`,-(`accounttrans`.`amount`)) AS `Debit`,`purchaseheaders`.`transdates` AS `transdates` from (`accounttrans` join `purchaseheaders` on((`purchaseheaders`.`id` = `accounttrans`.`purchaseheaderid`))) where ((`purchaseheaders`.`transdates` <= '2021/11/13') and (`accounttrans`.`bracid` = 1)) ;

-- --------------------------------------------------------

--
-- Structure for view `bsheetpdfs`
--
DROP TABLE IF EXISTS `bsheetpdfs`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bsheetpdfs`  AS  select `chartofaccounts`.`accountname` AS `accountname`,`chartofaccounts`.`accounttype` AS `accounttype`,`accounttrans`.`accountcode` AS `accountcode`,`accounttrans`.`bracid` AS `bracid`,`accounttrans`.`ttype` AS `ttype`,if((`accounttrans`.`ttype` = 'D'),`accounttrans`.`amount`,-(`accounttrans`.`amount`)) AS `Debit`,`purchaseheaders`.`transdates` AS `transdates` from ((`accounttrans` join `purchaseheaders` on((`purchaseheaders`.`id` = `accounttrans`.`purchaseheaderid`))) join `chartofaccounts` on((`chartofaccounts`.`accountcode` = `accounttrans`.`accountcode`))) group by `accounttrans`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `closeyears`
--
DROP TABLE IF EXISTS `closeyears`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `closeyears`  AS  select `accounttrans`.`accountcode` AS `accountcode`,`accounttypes`.`accounttype` AS `name`,`chartofaccounts`.`accounttype` AS `accounttype`,`accounttrans`.`bracid` AS `bracid` from ((`accounttrans` join `chartofaccounts` on((`accounttrans`.`accountcode` = `chartofaccounts`.`accountcode`))) join `accounttypes` on((`accounttypes`.`id` = `chartofaccounts`.`accounttype`))) group by `accounttrans`.`bracid`,`accounttrans`.`accountcode` ;

-- --------------------------------------------------------

--
-- Structure for view `editexpenses`
--
DROP TABLE IF EXISTS `editexpenses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `editexpenses`  AS  select `chartofaccounts`.`accountcode` AS `code`,`accounttrans`.`purchaseheaderid` AS `id`,`chartofaccounts`.`accountname` AS `name` from (`accounttrans` join `chartofaccounts` on((`accounttrans`.`accountcode` = `chartofaccounts`.`accountcode`))) where ((`chartofaccounts`.`accounttype` = 1) and (`chartofaccounts`.`accountcode` <> 1113)) group by `accounttrans`.`purchaseheaderid` ;

-- --------------------------------------------------------

--
-- Structure for view `expensepdfs`
--
DROP TABLE IF EXISTS `expensepdfs`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `expensepdfs`  AS  select `accounttrans`.`transdate` AS `transdate`,`accounttrans`.`narration` AS `narration`,`accounttrans`.`amount` AS `amount`,`accounttrans`.`ttype` AS `ttype`,`chartofaccounts`.`accountname` AS `accountname`,`accounttrans`.`bracid` AS `bracid`,`accounttrans`.`accountcode` AS `accountcode` from ((`purchaseheaders` join `accounttrans` on((`accounttrans`.`purchaseheaderid` = `purchaseheaders`.`id`))) join `chartofaccounts` on((`chartofaccounts`.`accountcode` = `accounttrans`.`accountcode`))) where (`chartofaccounts`.`accounttype` = 7) group by `accounttrans`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `incomepdfs`
--
DROP TABLE IF EXISTS `incomepdfs`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `incomepdfs`  AS  select `accounttrans`.`transdate` AS `transdate`,`accounttrans`.`narration` AS `narration`,`accounttrans`.`amount` AS `amount`,`accounttrans`.`ttype` AS `ttype`,`chartofaccounts`.`accountname` AS `accountname`,`accounttrans`.`bracid` AS `bracid`,`accounttrans`.`accountcode` AS `accountcode` from ((`purchaseheaders` join `accounttrans` on((`accounttrans`.`purchaseheaderid` = `purchaseheaders`.`id`))) join `chartofaccounts` on((`chartofaccounts`.`accountcode` = `accounttrans`.`accountcode`))) where (`chartofaccounts`.`accounttype` = 6) group by `accounttrans`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `incomestatement`
--
DROP TABLE IF EXISTS `incomestatement`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `incomestatement`  AS  select `chartofaccounts`.`accountname` AS `accountname`,`chartofaccounts`.`accounttype` AS `accounttype`,`chartofaccounts`.`accountcode` AS `accountcode`,`accounttypes`.`accounttype` AS `type`,abs(sum(if((`accounttrans`.`ttype` = 'D'),`accounttrans`.`amount`,-(`accounttrans`.`amount`)))) AS `Debit` from ((`accounttrans` join `chartofaccounts` on((`accounttrans`.`accountcode` = `chartofaccounts`.`accountcode`))) join `accounttypes` on((`chartofaccounts`.`accounttype` = `accounttypes`.`id`))) where ((`chartofaccounts`.`accounttype` = 6) or (`chartofaccounts`.`accounttype` = 7)) group by `accounttrans`.`accountcode`,`chartofaccounts`.`accountname`,`chartofaccounts`.`accounttype` order by `chartofaccounts`.`accounttype` ;

-- --------------------------------------------------------

--
-- Structure for view `incstat`
--
DROP TABLE IF EXISTS `incstat`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `incstat`  AS  select `accounttrans`.`ttype` AS `ttype`,`accounttrans`.`amount` AS `amount`,`accounttrans`.`credit` AS `credit`,`chartofaccounts`.`accountname` AS `accountname`,`chartofaccounts`.`accounttype` AS `accounttype`,`chartofaccounts`.`accountcode` AS `accountcode`,`accounttypes`.`accounttype` AS `type`,`purchaseheaders`.`transdates` AS `transdates` from (((`accounttrans` join `chartofaccounts` on((`accounttrans`.`accountcode` = `chartofaccounts`.`accountcode`))) join `accounttypes` on((`chartofaccounts`.`accounttype` = `accounttypes`.`id`))) join `purchaseheaders` on((`purchaseheaders`.`id` = `accounttrans`.`purchaseheaderid`))) where ((`chartofaccounts`.`accounttype` = 6) or (`chartofaccounts`.`accounttype` = 7)) ;

-- --------------------------------------------------------

--
-- Structure for view `outofstock`
--
DROP TABLE IF EXISTS `outofstock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `outofstock`  AS  select if((round(`stocks`.`limitlevel`,0) >= if((`uoms`.`isActive` > 1),substring_index((cast((sum(if(((`stocktrans`.`type` = 'I') or (`stocktrans`.`type` = 'IT')),`stocktrans`.`quantity`,0)) - sum(if(((`stocktrans`.`type` = 'O') or (`stocktrans`.`type` = 'OT')),`stocktrans`.`quantity`,0))) as unsigned) / `uoms`.`isActive`),'.',1),substring_index((cast((sum(if(((`stocktrans`.`type` = 'I') or (`stocktrans`.`type` = 'IT')),`stocktrans`.`quantity`,0)) - sum(if(((`stocktrans`.`type` = 'O') or (`stocktrans`.`type` = 'OT')),`stocktrans`.`quantity`,0))) as unsigned) / `uoms`.`isActive`),'.',1))),1,0) AS `stock`,round(`stocks`.`limitlevel`,0) AS `limitlevel`,if((`uoms`.`isActive` > 1),substring_index((cast((sum(if(((`stocktrans`.`type` = 'I') or (`stocktrans`.`type` = 'IT')),`stocktrans`.`quantity`,0)) - sum(if(((`stocktrans`.`type` = 'O') or (`stocktrans`.`type` = 'OT')),`stocktrans`.`quantity`,0))) as unsigned) / `uoms`.`isActive`),'.',1),substring_index((cast((sum(if(((`stocktrans`.`type` = 'I') or (`stocktrans`.`type` = 'IT')),`stocktrans`.`quantity`,0)) - sum(if(((`stocktrans`.`type` = 'O') or (`stocktrans`.`type` = 'OT')),`stocktrans`.`quantity`,0))) as unsigned) / `uoms`.`isActive`),'.',1)) AS `ctrlLimit` from ((((`stocktrans` join `purchaseheaders` on((`stocktrans`.`purchaseheaderid` = `purchaseheaders`.`id`))) join `branches` on((`branches`.`id` = `purchaseheaders`.`branch_id`))) join `stocks` on((`stocks`.`id` = `stocktrans`.`stockname`))) join `uoms` on((`stocks`.`unitofmeasure` = `uoms`.`id`))) group by `stocktrans`.`stockname` order by `stocks`.`name` ;

-- --------------------------------------------------------

--
-- Structure for view `pendings`
--
DROP TABLE IF EXISTS `pendings`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pendings`  AS  select `stocktrans`.`transdate` AS `transdate`,`customers`.`name` AS `customer`,`stocktrans`.`purchaseheaderid` AS `purchaseheaderid`,sum(`stocktrans`.`totalamt`) AS `totalamt`,(sum(`stocktrans`.`totalamt`) - sum(`stocktrans`.`totalpaid`)) AS `bal`,sum(`stocktrans`.`totalpaid`) AS `totalpaid`,`stocktrans`.`stockname` AS `stockname` from (`stocktrans` join `customers` on((`customers`.`id` = `stocktrans`.`customer`))) where (`stocktrans`.`transdate` <= '2021-12-04') group by `stocktrans`.`purchaseheaderid` having (`totalpaid` < `totalamt`) ;

-- --------------------------------------------------------

--
-- Structure for view `tb`
--
DROP TABLE IF EXISTS `tb`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tb`  AS  select `chartofaccounts`.`accounttype` AS `accounttype`,`chartofaccounts`.`accountname` AS `accountname`,(sum(if((`accounttrans`.`ttype` = 'D'),`accounttrans`.`amount`,0)) - sum(if((`accounttrans`.`ttype` = 'C'),`accounttrans`.`amount`,0))) AS `Debit`,sum(if((`accounttrans`.`ttype` = 'C'),`accounttrans`.`amount`,0)) AS `Credits` from (`accounttrans` join `chartofaccounts` on((`chartofaccounts`.`accountcode` = `accounttrans`.`accountcode`))) group by `accounttrans`.`accountcode` ;

-- --------------------------------------------------------

--
-- Structure for view `totalincome`
--
DROP TABLE IF EXISTS `totalincome`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `totalincome`  AS  select `incstat`.`ttype` AS `ttype`,`incstat`.`amount` AS `amount`,`incstat`.`credit` AS `credit`,`incstat`.`accountname` AS `accountname`,`incstat`.`accounttype` AS `accounttype`,`incstat`.`accountcode` AS `accountcode`,`incstat`.`type` AS `type`,`incstat`.`transdates` AS `transdates` from `incstat` where (((`incstat`.`transdates` = '2022/05/15') and isnull(`incstat`.`credit`)) or (`incstat`.`credit` = '')) ;

-- --------------------------------------------------------

--
-- Structure for view `trial`
--
DROP TABLE IF EXISTS `trial`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `trial`  AS  select `accounttrans`.`accountcode` AS `accountcode`,sum(if((`accounttrans`.`ttype` = 'D'),`accounttrans`.`amount`,-(`accounttrans`.`amount`))) AS `Debit` from (`purchaseheaders` join `accounttrans` on(((`purchaseheaders`.`id` = `accounttrans`.`purchaseheaderid`) and (`accounttrans`.`bracid` = 1)))) where ((`purchaseheaders`.`transdates` between '2021-06-01' and '2021/11/13') and (`purchaseheaders`.`transdates` between '2021-06-01' and '2022-05-31')) group by `accounttrans`.`accountcode` ;

-- --------------------------------------------------------

--
-- Structure for view `trialfooter`
--
DROP TABLE IF EXISTS `trialfooter`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `trialfooter`  AS  select `trialpdfs`.`transdate` AS `transdate`,`trialpdfs`.`accountname` AS `accountname`,`trialpdfs`.`accountcode` AS `accountcode`,if((sum(if((`trialpdfs`.`ttype` = 'D'),`trialpdfs`.`amount`,-(`trialpdfs`.`amount`))) < 0),0,sum(if((`trialpdfs`.`ttype` = 'D'),`trialpdfs`.`amount`,-(`trialpdfs`.`amount`)))) AS `Debits`,if((sum(if((`trialpdfs`.`ttype` = 'D'),`trialpdfs`.`amount`,-(`trialpdfs`.`amount`))) > 0),0,abs(sum(if((`trialpdfs`.`ttype` = 'D'),`trialpdfs`.`amount`,-(`trialpdfs`.`amount`))))) AS `Credits` from `trialpdfs` where (`trialpdfs`.`transdate` between '2021-06-01' and '2022-05-31') group by `trialpdfs`.`accountcode` ;

-- --------------------------------------------------------

--
-- Structure for view `trialpdfs`
--
DROP TABLE IF EXISTS `trialpdfs`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `trialpdfs`  AS  select `accounttrans`.`bracid` AS `bracid`,`accounttrans`.`amount` AS `amount`,`accounttrans`.`ttype` AS `ttype`,`chartofaccounts`.`accountname` AS `accountname`,`chartofaccounts`.`accountcode` AS `accountcode`,`accounttrans`.`transdate` AS `transdate` from ((`accounttrans` join `chartofaccounts` on((`accounttrans`.`accountcode` = `chartofaccounts`.`accountcode`))) join `purchaseheaders` on((`purchaseheaders`.`id` = `accounttrans`.`purchaseheaderid`))) group by `accounttrans`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `yearexpenses`
--
DROP TABLE IF EXISTS `yearexpenses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `yearexpenses`  AS  select if((`chartofaccounts`.`accounttype` = 7),`accounttrans`.`amount`,0) AS `Expenses`,`accounttrans`.`bracid` AS `bracid`,if((`chartofaccounts`.`accounttype` = 6),`accounttrans`.`amount`,0) AS `Incomes`,`accounttrans`.`accountcode` AS `accountcode`,`accounttrans`.`amount` AS `amount`,`accounttrans`.`ttype` AS `ttype`,`accounttrans`.`transdate` AS `transdate`,`chartofaccounts`.`accounttype` AS `accounttype` from (`accounttrans` join `chartofaccounts` on((`chartofaccounts`.`accountcode` = `accounttrans`.`accountcode`))) where ((`chartofaccounts`.`accounttype` = 6) or (`chartofaccounts`.`accounttype` = 7)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounttrans`
--
ALTER TABLE `accounttrans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounttypes`
--
ALTER TABLE `accounttypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `availablestocks`
--
ALTER TABLE `availablestocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bankings`
--
ALTER TABLE `bankings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chartofaccounts`
--
ALTER TABLE `chartofaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companynames`
--
ALTER TABLE `companynames`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companys`
--
ALTER TABLE `companys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenseinvoices`
--
ALTER TABLE `expenseinvoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financialyears`
--
ALTER TABLE `financialyears`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `itemgroups`
--
ALTER TABLE `itemgroups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modeofpayments`
--
ALTER TABLE `modeofpayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newpurchases`
--
ALTER TABLE `newpurchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchaseheaders`
--
ALTER TABLE `purchaseheaders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recievedstocks`
--
ALTER TABLE `recievedstocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registers`
--
ALTER TABLE `registers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retainedearnings`
--
ALTER TABLE `retainedearnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stockbals`
--
ALTER TABLE `stockbals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocktrans`
--
ALTER TABLE `stocktrans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uoms`
--
ALTER TABLE `uoms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounttrans`
--
ALTER TABLE `accounttrans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `accounttypes`
--
ALTER TABLE `accounttypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `availablestocks`
--
ALTER TABLE `availablestocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bankings`
--
ALTER TABLE `bankings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `chartofaccounts`
--
ALTER TABLE `chartofaccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `companynames`
--
ALTER TABLE `companynames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companys`
--
ALTER TABLE `companys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `expenseinvoices`
--
ALTER TABLE `expenseinvoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `financialyears`
--
ALTER TABLE `financialyears`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `itemgroups`
--
ALTER TABLE `itemgroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `modeofpayments`
--
ALTER TABLE `modeofpayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `newpurchases`
--
ALTER TABLE `newpurchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `purchaseheaders`
--
ALTER TABLE `purchaseheaders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `recievedstocks`
--
ALTER TABLE `recievedstocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registers`
--
ALTER TABLE `registers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `requirements`
--
ALTER TABLE `requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `retainedearnings`
--
ALTER TABLE `retainedearnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stockbals`
--
ALTER TABLE `stockbals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stocktrans`
--
ALTER TABLE `stocktrans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uoms`
--
ALTER TABLE `uoms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
