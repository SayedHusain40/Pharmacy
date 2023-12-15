-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2023 at 03:06 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `function` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `function`
--

INSERT INTO `function` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'PayForOrder.php', 4, 'NotDone'),
(2, 'SearchItems', 4, 'NotDone'),
(3, 'Trackorder.php', 1, 'NotDone'),
(4, 'Rating.php', 5, 'NotDone'),
(5, 'Sorting.php', 5, 'NotDone'),
(6, 'PriceFilter.php', 5, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `interface`
--

CREATE TABLE `interface` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(8, 'ShopByCategories.php', 5, 'NotDone'),
(9, 'ShopByBrand.php', 5, 'NotDone'),
(10, 'SPaymentPage.php', 5, 'NotDone'),
(14, 'PaymentPage.php', 3, 'Done'),
(16, 'AboutUs.php', 2, 'NotDone'),
(17, 'ContactUs.php', 2, 'NotDone'),
(18, 'FAQs.php', 2, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `manageoffers`
--

CREATE TABLE `manageoffers` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageoffers`
--

INSERT INTO `manageoffers` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'AddOffer.php', 5, 'NotDone'),
(2, 'EditOffer.php', 5, 'NotDone'),
(3, 'ViewOffer.php', 5, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `manageorders`
--

CREATE TABLE `manageorders` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageorders`
--

INSERT INTO `manageorders` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'AddOrder.php', 1, 'NotDone'),
(2, 'EditOrder.php', 1, 'NotDone'),
(3, 'ViewOrderList.php', 1, 'NotDone'),
(4, 'SAddOrder.php', 1, 'NotDone'),
(5, 'SEditOrder.php', 1, 'NotDone'),
(6, 'SViewOrderList.php', 1, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `manageproducts`
--

CREATE TABLE `manageproducts` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageproducts`
--

INSERT INTO `manageproducts` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'AddProduct.php', 5, 'NotDone'),
(2, 'EditProduct.php', 5, 'NotDone'),
(3, 'ViewProductList.php', 1, 'NotDone'),
(4, 'ProductDetails.php', 4, 'NotDone'),
(5, 'SAddProduct.php', 5, 'NotDone'),
(6, 'SEditProduct.php', 5, 'NotDone'),
(7, 'SViewProductList.php', 5, 'NotDone'),
(8, 'SProductDetails.php', 5, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `manageshoppingcart`
--

CREATE TABLE `manageshoppingcart` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageshoppingcart`
--

INSERT INTO `manageshoppingcart` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'AddAddresses.php', 3, 'Done'),
(2, 'AddToCart.php', 3, 'Done'),
(3, 'EditCart.php', 3, 'Done'),
(4, 'ViewShoppingCart.php', 3, 'Done'),
(5, 'SAddToCart.php', 5, 'NotDone'),
(6, 'SEditCart.php', 5, 'NotDone'),
(7, 'SViewShoppingCart.php', 5, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `manageusers`
--

CREATE TABLE `manageusers` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageusers`
--

INSERT INTO `manageusers` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'AddUsers.php', 1, 'Done'),
(2, 'EditUsers.php', 5, 'NotDone'),
(3, 'ViewUsers.php', 1, 'Done'),
(4, 'AddCustomer.php', 1, 'Done'),
(5, 'EditCustomer.php', 5, 'NotDone'),
(6, 'AddStaff.php', 1, 'Done'),
(7, 'EditStaff.php', 5, 'NotDone'),
(8, 'AddSupplier.php', 1, 'Done'),
(9, 'EditSupplier.php', 5, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `managewishlist`
--

CREATE TABLE `managewishlist` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `managewishlist`
--

INSERT INTO `managewishlist` (`id`, `task_name`, `member_id`, `task_status`) VALUES
(1, 'AddToWishList.php', 3, 'Done'),
(2, 'DeleteWishList.php', 3, 'Done'),
(3, 'ViewWishList.php', 3, 'Done'),
(4, 'SAddToWishList.php', 5, 'NotDone'),
(5, 'SDeleteWishList.php', 5, 'NotDone'),
(6, 'SViewWishList.php', 5, 'NotDone');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `Id` int(11) NOT NULL,
  `name` enum('Fatema','Elias','Sayed Hussian','Karrar','None') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `task_status` enum('Done','NotDone') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `function`
--
ALTER TABLE `function`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `interface`
--
ALTER TABLE `interface`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `manageoffers`
--
ALTER TABLE `manageoffers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `manageorders`
--
ALTER TABLE `manageorders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `manageproducts`
--
ALTER TABLE `manageproducts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `manageshoppingcart`
--
ALTER TABLE `manageshoppingcart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `manageusers`
--
ALTER TABLE `manageusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `managewishlist`
--
ALTER TABLE `managewishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `function`
--
ALTER TABLE `function`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `interface`
--
ALTER TABLE `interface`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `manageoffers`
--
ALTER TABLE `manageoffers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manageorders`
--
ALTER TABLE `manageorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `manageproducts`
--
ALTER TABLE `manageproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `manageshoppingcart`
--
ALTER TABLE `manageshoppingcart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `manageusers`
--
ALTER TABLE `manageusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `managewishlist`
--
ALTER TABLE `managewishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
