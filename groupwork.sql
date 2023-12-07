-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2023 at 01:52 PM
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
-- Database: `groupwork`
--
CREATE DATABASE IF NOT EXISTS `groupwork` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `groupwork`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'Profile.php\r\n', 4, 'NotDone'),
(2, 'EditProfile.php\r\n', 4, 'NotDone'),
(3, 'Signup.php\r\n', 1, 'Done'),
(4, 'Login.php\r\n', 1, 'Done'),
(5, 'Logout.php', 1, 'Done');

-- --------------------------------------------------------

--
-- Table structure for table `function`
--

DROP TABLE IF EXISTS `function`;
CREATE TABLE IF NOT EXISTS `function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `function`
--

INSERT INTO `function` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'PayForOrder.php', 4, 'NotDone'),
(2, 'SearchItems', 4, 'NotDone'),
(3, 'Trackorder.php', 4, 'NotDone'),
(4, 'Rating.php', 5, 'NotDone'),
(5, 'Sorting.php', 5, 'NotDone'),
(6, 'PriceFilter.php', 5, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `interface`
--

DROP TABLE IF EXISTS `interface`;
CREATE TABLE IF NOT EXISTS `interface` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interface`
--

INSERT INTO `interface` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'Header.php', 2, 'NotDone'),
(2, 'Footer.php', 2, 'NotDone'),
(3, 'HomePage.php', 2, 'NotDone'),
(4, 'HomePageCustomer.php', 2, 'NotDone'),
(5, 'HomePageStaff.php', 2, 'NotDone'),
(6, 'HomePageAdmin.php', 2, 'NotDone'),
(7, 'HomePageSupplier.php', 2, 'NotDone'),
(8, 'ShopByCategories.php', 2, 'NotDone'),
(9, 'ShopByBrand.php', 4, 'NotDone'),
(10, 'ShoppingCart.php', 3, 'NotDone'),
(11, 'AddToCart&Favourite.php', 3, 'NotDone'),
(12, 'ViewCart.php', 3, 'NotDone'),
(13, 'WishListPage.php', 3, 'NotDone'),
(14, 'PaymentPage.php', 3, 'NotDone'),
(15, 'Checkout.php', 3, 'NotDone'),
(16, 'AboutUs.php', 2, 'NotDone'),
(17, 'ContactUs.php', 2, 'NotDone'),
(18, 'FAQs.php', 2, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `manageoffers`
--

DROP TABLE IF EXISTS `manageoffers`;
CREATE TABLE IF NOT EXISTS `manageoffers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageoffers`
--

INSERT INTO `manageoffers` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'AddOffer.php', 1, 'NotDone'),
(2, 'EditOffer.php', 1, 'NotDone'),
(3, 'ViewOffer.php', 1, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `manageorders`
--

DROP TABLE IF EXISTS `manageorders`;
CREATE TABLE IF NOT EXISTS `manageorders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageorders`
--

INSERT INTO `manageorders` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'AddOrder.php', 1, 'NotDone'),
(2, 'EditOrder.php', 1, 'NotDone'),
(3, 'ViewOrderList.php', 1, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `manageproducts`
--

DROP TABLE IF EXISTS `manageproducts`;
CREATE TABLE IF NOT EXISTS `manageproducts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageproducts`
--

INSERT INTO `manageproducts` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'AddProduct.php', 1, 'NotDone'),
(2, 'EditProduct.php', 1, 'NotDone'),
(3, 'ViewProductList.php', 4, 'NotDone'),
(4, 'ProductDetails.php', 1, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `manageusers`
--

DROP TABLE IF EXISTS `manageusers`;
CREATE TABLE IF NOT EXISTS `manageusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageusers`
--

INSERT INTO `manageusers` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'AddUsers.php', 1, 'NotDone'),
(2, 'EditUsers.php', 1, 'NotDone'),
(3, 'ViewUsers.php', 1, 'NotDone'),
(4, 'AddCustomer.php', 1, 'NotDone'),
(5, 'EditCustomer.php', 1, 'NotDone'),
(6, 'AddStaff.php', 1, 'NotDone'),
(7, 'EditStaff.php', 1, 'NotDone'),
(8, 'AddSupplier.php', 1, 'NotDone'),
(9, 'EditSupplier.php', 1, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` enum('Fatema','Elias','Sayed Hussian','Karrar','None') DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`Id`, `name`) VALUES
(1, 'Fatema'),
(2, 'Elias'),
(3, 'Sayed Hussian'),
(4, 'Karrar'),
(5, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'CurrentInventoryReport.php', 2, 'NotDone'),
(2, 'MedicineReport.php', 2, 'NotDone'),
(3, 'UsersReport.php', 2, 'NotDone'),
(4, 'CustomerInformationReport.php', 2, 'NotDone'),
(5, 'StaffInformationReport.php', 2, 'NotDone'),
(6, 'CustomerOrderDetailsReport.php', 2, 'NotDone'),
(7, 'TopSellingMedicinesReport.php', 2, 'NotDone'),
(8, 'SupplierReport.php', 2, 'NotDone'),
(9, 'OrderReport.php', 2, 'NotDone'),
(10, 'OfferReport.php', 2, 'NotDone');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`Id`);

--
-- Constraints for table `function`
--
ALTER TABLE `function`
  ADD CONSTRAINT `function_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`Id`);

--
-- Constraints for table `interface`
--
ALTER TABLE `interface`
  ADD CONSTRAINT `interface_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`Id`);

--
-- Constraints for table `manageoffers`
--
ALTER TABLE `manageoffers`
  ADD CONSTRAINT `manageoffers_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`Id`);

--
-- Constraints for table `manageorders`
--
ALTER TABLE `manageorders`
  ADD CONSTRAINT `manageorders_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`Id`);

--
-- Constraints for table `manageproducts`
--
ALTER TABLE `manageproducts`
  ADD CONSTRAINT `manageproducts_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`Id`);

--
-- Constraints for table `manageusers`
--
ALTER TABLE `manageusers`
  ADD CONSTRAINT `manageusers_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`Id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
