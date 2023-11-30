-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2023 at 03:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer data`
--

CREATE TABLE `customer data` (
  `CustomerID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `MobileNumber` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Area` varchar(30) NOT NULL,
  `House` varchar(30) NOT NULL,
  `Street` varchar(20) NOT NULL,
  `Block` int(5) NOT NULL,
  `DOB` date DEFAULT NULL,
  `CreditCardInfo` varchar(255) NOT NULL,
  `ShippingInfo` varchar(255) NOT NULL,
  `AccBalance` int(20) NOT NULL,
  `MembershipPoints` int(10) NOT NULL,
  `ProfilePic` text DEFAULT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee data`
--

CREATE TABLE `employee data` (
  `EmployeeID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `CPR` int(9) UNSIGNED ZEROFILL NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `DOB` date NOT NULL,
  `AcademicDegree` varchar(30) NOT NULL,
  `MobileNumber` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `ProfilePic` text DEFAULT NULL,
  `EmployeePosition` varchar(255) NOT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers data`
--

CREATE TABLE `offers data` (
  `OfferID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `ProductID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  `OfferCode` int(9) DEFAULT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `DiscountedPrice` double DEFAULT NULL,
  `OriginalPrice` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order data`
--

CREATE TABLE `order data` (
  `OrderID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  `ProductID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  `TotalPrice` double DEFAULT NULL,
  `PaymentMethod` varchar(20) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `CreditCardInfo` varchar(255) DEFAULT NULL,
  `AccBalance` int(20) DEFAULT NULL,
  `MembershipPoints` int(10) DEFAULT NULL,
  `PaymentID` int(9) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ordered item`
--

CREATE TABLE `ordered item` (
  `OrderID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `ProductID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `Total` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment database`
--

CREATE TABLE `payment database` (
  `PaymentID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `PayDate` date NOT NULL,
  `Total` decimal(4,3) NOT NULL,
  `ShippingInfo` varchar(255) NOT NULL,
  `Details` varchar(255) DEFAULT NULL,
  `MembershipPoints` int(10) DEFAULT NULL,
  `CreditCardInfo` varchar(255) DEFAULT NULL,
  `AccBalance` int(20) DEFAULT NULL,
  `PaymentStatus` varchar(20) DEFAULT NULL,
  `UserID` int(10) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product data`
--

CREATE TABLE `product data` (
  `ProductID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `RequiresPrescription` tinyint(1) NOT NULL,
  `Description` varchar(300) NOT NULL,
  `ExpireDate` date NOT NULL,
  `Quantity` int(10) NOT NULL,
  `Availability` tinyint(1) NOT NULL,
  `Price` double NOT NULL,
  `Brand` varchar(50) DEFAULT NULL,
  `Photo` varchar(500) DEFAULT NULL,
  `Alternate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier data`
--

CREATE TABLE `supplier data` (
  `SupplierID` int(10) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `MobileNumber` int(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `ProfilePic` text DEFAULT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user data`
--

CREATE TABLE `user data` (
  `UserID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Type` enum('Admin','Customer','Employee','Supplier') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `view cart`
--

CREATE TABLE `view cart` (
  `CartID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `OrderID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `ProductID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `Total` double DEFAULT NULL,
  `AddedDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wish list data`
--

CREATE TABLE `wish list data` (
  `WID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `ProductID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer data`
--
ALTER TABLE `customer data`
  ADD PRIMARY KEY (`CustomerID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `employee data`
--
ALTER TABLE `employee data`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `offers data`
--
ALTER TABLE `offers data`
  ADD PRIMARY KEY (`OfferID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `order data`
--
ALTER TABLE `order data`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `PaymentID` (`PaymentID`);

--
-- Indexes for table `ordered item`
--
ALTER TABLE `ordered item`
  ADD PRIMARY KEY (`OrderID`,`ProductID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `payment database`
--
ALTER TABLE `payment database`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `product data`
--
ALTER TABLE `product data`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `supplier data`
--
ALTER TABLE `supplier data`
  ADD PRIMARY KEY (`SupplierID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `user data`
--
ALTER TABLE `user data`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `view cart`
--
ALTER TABLE `view cart`
  ADD PRIMARY KEY (`CartID`,`OrderID`,`ProductID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `wish list data`
--
ALTER TABLE `wish list data`
  ADD PRIMARY KEY (`WID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer data`
--
ALTER TABLE `customer data`
  MODIFY `CustomerID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user data`
--
ALTER TABLE `user data`
  MODIFY `UserID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer data`
--
ALTER TABLE `customer data`
  ADD CONSTRAINT `customer data_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);

--
-- Constraints for table `employee data`
--
ALTER TABLE `employee data`
  ADD CONSTRAINT `employee data_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);

--
-- Constraints for table `offers data`
--
ALTER TABLE `offers data`
  ADD CONSTRAINT `offers data_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product data` (`ProductID`);

--
-- Constraints for table `order data`
--
ALTER TABLE `order data`
  ADD CONSTRAINT `order data_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`),
  ADD CONSTRAINT `order data_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product data` (`ProductID`),
  ADD CONSTRAINT `order data_ibfk_3` FOREIGN KEY (`PaymentID`) REFERENCES `payment database` (`PaymentID`);

--
-- Constraints for table `ordered item`
--
ALTER TABLE `ordered item`
  ADD CONSTRAINT `ordered item_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order data` (`OrderID`),
  ADD CONSTRAINT `ordered item_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product data` (`ProductID`);

--
-- Constraints for table `payment database`
--
ALTER TABLE `payment database`
  ADD CONSTRAINT `payment database_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);

--
-- Constraints for table `supplier data`
--
ALTER TABLE `supplier data`
  ADD CONSTRAINT `supplier data_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);

--
-- Constraints for table `view cart`
--
ALTER TABLE `view cart`
  ADD CONSTRAINT `view cart_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order data` (`OrderID`),
  ADD CONSTRAINT `view cart_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product data` (`ProductID`);

--
-- Constraints for table `wish list data`
--
ALTER TABLE `wish list data`
  ADD CONSTRAINT `wish list data_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product data` (`ProductID`),
  ADD CONSTRAINT `wish list data_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
