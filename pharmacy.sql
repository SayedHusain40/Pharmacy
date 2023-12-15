-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2023 at 02:43 PM
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
-- Database: `pharmacy`
--
CREATE DATABASE IF NOT EXISTS `pharmacy` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pharmacy`;

-- --------------------------------------------------------

--
-- Table structure for table `customer data`
--

DROP TABLE IF EXISTS `customer data`;
CREATE TABLE IF NOT EXISTS `customer data` (
  `CustomerID` int(9) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `MobileNumber` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Area` varchar(30) NOT NULL,
  `House` varchar(30) NOT NULL,
  `Street` varchar(20) NOT NULL,
  `Block` int(5) NOT NULL,
  `Gender` enum('Female','Male') NOT NULL,
  `DOB` date DEFAULT NULL,
  `CreditCardInfo` varchar(255) NOT NULL,
  `ShippingInfo` varchar(255) NOT NULL,
  `AccBalance` int(20) NOT NULL,
  `MembershipPoints` int(10) NOT NULL,
  `ProfilePic` text DEFAULT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  PRIMARY KEY (`CustomerID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer data`
--

INSERT INTO `customer data` (`CustomerID`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `Area`, `House`, `Street`, `Block`, `Gender`, `DOB`, `CreditCardInfo`, `ShippingInfo`, `AccBalance`, `MembershipPoints`, `ProfilePic`, `UserID`) VALUES
(1, 'faisal', 'name', '+97311111111', '1213sada2@hotmail.com', 'TEst1', 'TEst2', 'TEst23', 6514, 'Female', NULL, '', '', 0, 0, NULL, 000000003),
(2, 'at', 'table', '+9734567890', '', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000006),
(7, 'at', 'table', '+973456789876', '', '', '', '', 0, 'Female', NULL, '', '', 0, 488, NULL, 000000007),
(8, 'Walaa', 'Salman', '+97336735550', 'walaa.e@icloud.com', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000008),
(10, 'gdjehgfjkeh', 'jhgjjh', '+86723456789', '201908@stu.uob.edu.bh', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000010),
(12, 'dfghjk', 'ry', '+973456789', '2023068@stu.uob.edu.bh', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000012),
(13, 'gfhjk', 'fghjkl', '+945234567890', 'fabh2001@hotmail.com', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000013),
(14, 'hdkjfj', 'dekiho', '+9453254566789', 'faqbh2001@hotmail.com', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000015),
(15, 'goird', 'sdjhgtf', '+7843543543', 'fndjdgdid@stu.com', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000022),
(16, 'Fiddah', 'Ahmed Alqaidoom', '+97336654453', 'fiddah16@hotmail.com', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000029);

-- --------------------------------------------------------

--
-- Table structure for table `offers data`
--

DROP TABLE IF EXISTS `offers data`;
CREATE TABLE IF NOT EXISTS `offers data` (
  `OfferID` int(9) NOT NULL AUTO_INCREMENT,
  `ProductID` int(9) DEFAULT NULL,
  `OfferCode` int(9) DEFAULT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `DiscountedPrice` double DEFAULT NULL,
  `OriginalPrice` double DEFAULT NULL,
  PRIMARY KEY (`OfferID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order data`
--

DROP TABLE IF EXISTS `order data`;
CREATE TABLE IF NOT EXISTS `order data` (
  `OrderID` int(9) NOT NULL AUTO_INCREMENT,
  `UserID` int(9) DEFAULT NULL,
  `TotalPrice` double DEFAULT NULL,
  `PaymentMethod` varchar(20) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `CreditCardInfo` varchar(255) DEFAULT NULL,
  `AccBalance` int(20) DEFAULT NULL,
  `MembershipPoints` int(10) DEFAULT NULL,
  `PaymentID` int(9) DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `UserID` (`UserID`),
  KEY `PaymentID` (`PaymentID`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order data`
--

INSERT INTO `order data` (`OrderID`, `UserID`, `TotalPrice`, `PaymentMethod`, `Status`, `OrderDate`, `CreditCardInfo`, `AccBalance`, `MembershipPoints`, `PaymentID`) VALUES
(61, 6, 1450, 'Credit Card', 'Payment Confirmed', '2023-12-09', '{\"cardholderName\":\"fsefsf\",\"encryptedCardNumber\":\"ouC5SUkKffEzzQltRhpwJfvbN4CxKnwiUd8qKFVZ3jA=\",\"expirationDate\":\"12\\/55\",\"cvv\":\"3111\"}', NULL, NULL, 35),
(139, 7, 1450, 'Credit Card', 'Payment Confirmed', '2023-12-09', '{\"cardholderName\":\"dekjhkeh\",\"encryptedCardNumber\":\"7QMJ5XDyrXIT3ujRMHtjr1pBi+OaTaRE1J4pTOn+kUM=\",\"expirationDate\":\"04\\/56\",\"cvv\":\"3454\"}', NULL, 61, 38),
(140, 7, 1450, 'Credit Card', 'Payment Confirmed', '2023-12-09', '{\"cardholderName\":\"fedfe\",\"encryptedCardNumber\":\"O+pPFex127CQzesQg6uFEYEl+shzOOwmwrSNxN40iv4=\",\"expirationDate\":\"02\\/26\",\"cvv\":\"244\"}', NULL, 61, 39),
(141, 7, 1450, 'Credit Card', 'Payment Confirmed', '2023-12-09', '{\"cardholderName\":\"wfgd\",\"encryptedCardNumber\":\"0kzCTa6C53SLLgRbFAizoEDZC7i1lUDzpNuqqhIewwY=\",\"expirationDate\":\"09\\/65\",\"cvv\":\"4566\"}', NULL, 61, 40),
(142, 7, 1450, 'Credit Card', 'Payment Confirmed', '2023-12-09', '{\"cardholderName\":\"fdef\",\"encryptedCardNumber\":\"BZIjkULAHtNoib1J52qmYfYt0eVB1gLk\\/HwB4pBl+fc=\",\"expirationDate\":\"06\\/54\",\"cvv\":\"2334\"}', NULL, 61, 41),
(144, 6, 780, 'Credit Card', 'Payment Pending', '2023-12-09', NULL, NULL, NULL, NULL),
(145, 7, 1450, 'Credit Card', 'Payment Confirmed', '2023-12-09', '{\"cardholderName\":\"dfghjklyl\",\"encryptedCardNumber\":\"04oSSq85i6dHl9114vghtuAgLXIwKV8qWed5cJVmYMs=\",\"expirationDate\":\"09\\/96\",\"cvv\":\"4345\"}', NULL, 61, 42),
(146, 7, 1450, 'Credit Card', 'Payment Confirmed', '2023-12-09', '{\"cardholderName\":\"fkedgfj\",\"encryptedCardNumber\":\"M8\\/0kGqZW4IxLwRHleplWRR\\/n9BdPBz+Lj4NuHrwO2c=\",\"expirationDate\":\"08\\/66\",\"cvv\":\"245\"}', NULL, 61, 43);

-- --------------------------------------------------------

--
-- Table structure for table `ordered item`
--

DROP TABLE IF EXISTS `ordered item`;
CREATE TABLE IF NOT EXISTS `ordered item` (
  `OrderID` int(9) NOT NULL,
  `ProductID` int(9) NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `TotalPrice` double DEFAULT NULL,
  `TotalPoints` int(11) NOT NULL,
  PRIMARY KEY (`OrderID`,`ProductID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordered item`
--

INSERT INTO `ordered item` (`OrderID`, `ProductID`, `Qty`, `TotalPrice`, `TotalPoints`) VALUES
(61, 1, 2, 200, 0),
(61, 2, 2, 20, 0),
(121, 1, 4, 100, 2),
(121, 2, 4, 10, 3),
(121, 3, 4, 20, 4),
(122, 1, 5, 500, 10),
(122, 2, 7, 570, 31),
(122, 3, 8, 730, 63),
(124, 3, 6, 120, 24),
(126, 1, 2, 200, 4),
(126, 2, 2, 20, 6),
(126, 3, 2, 40, 8),
(127, 1, 4, 400, 8),
(127, 2, 2, 20, 6),
(127, 3, 3, 60, 12),
(128, 1, 4, 400, 8),
(128, 2, 7, 70, 21),
(128, 3, 7, 140, 28),
(129, 1, 4, 400, 8),
(129, 2, 7, 70, 21),
(129, 3, 7, 140, 28),
(130, 1, 1, 100, 2),
(131, 1, 1, 100, 2),
(133, 1, 5, 500, 10),
(133, 2, 5, 50, 15),
(136, 1, 13, 1300, 26),
(136, 2, 5, 50, 15),
(136, 3, 5, 100, 20),
(137, 1, 13, 1300, 26),
(137, 2, 5, 50, 15),
(137, 3, 5, 100, 20),
(139, 1, 13, 1300, 26),
(139, 2, 5, 50, 15),
(139, 3, 5, 100, 20),
(140, 1, 13, 1300, 26),
(140, 2, 5, 50, 15),
(140, 3, 5, 100, 20),
(141, 1, 13, 1300, 26),
(141, 2, 5, 50, 15),
(141, 3, 5, 100, 20),
(144, 1, 7, 200, 14),
(144, 2, 1, 0, 3),
(144, 3, 1, 0, 4),
(145, 1, 13, 1300, 26),
(145, 2, 5, 50, 15),
(145, 3, 5, 100, 20),
(146, 1, 13, 1300, 26),
(146, 2, 5, 50, 15),
(146, 3, 5, 100, 20);

-- --------------------------------------------------------

--
-- Table structure for table `payment database`
--

DROP TABLE IF EXISTS `payment database`;
CREATE TABLE IF NOT EXISTS `payment database` (
  `PaymentID` int(9) NOT NULL AUTO_INCREMENT,
  `PayDate` date NOT NULL,
  `Total` double NOT NULL,
  `ShippingInfo` varchar(255) NOT NULL,
  `Details` varchar(255) DEFAULT NULL,
  `MembershipPoints` int(10) DEFAULT NULL,
  `CreditCardInfo` varchar(255) DEFAULT NULL,
  `AccBalance` int(20) DEFAULT NULL,
  `PaymentStatus` varchar(20) DEFAULT NULL,
  `UserID` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  PRIMARY KEY (`PaymentID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment database`
--

INSERT INTO `payment database` (`PaymentID`, `PayDate`, `Total`, `ShippingInfo`, `Details`, `MembershipPoints`, `CreditCardInfo`, `AccBalance`, `PaymentStatus`, `UserID`) VALUES
(35, '2023-12-08', 9.999, '{\"RecipientName\":\"at table\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+9734567890\",\"Email\":\"\"}}', NULL, NULL, '{\"cardholderName\":\"fsefsf\",\"encryptedCardNumber\":\"ouC5SUkKffEzzQltRhpwJfvbN4CxKnwiUd8qKFVZ3jA=\",\"expirationDate\":\"12\\/55\",\"cvv\":\"3111\"}', NULL, 'paid', 0000000006),
(36, '2023-12-09', 9.999, '{\"RecipientName\":\"at table\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+973456789876\",\"Email\":\"\"}}', NULL, 61, '{\"cardholderName\":\"ejkhfjkdssfk\",\"encryptedCardNumber\":\"ZWk14acNBmIivl7tJ72hcDfdSRwHEx0yZxWi9LO9bxE=\",\"expirationDate\":\"08\\/46\",\"cvv\":\"467\"}', NULL, 'paid', 0000000007),
(37, '2023-12-09', 9.999, '{\"RecipientName\":\"at table\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+973456789876\",\"Email\":\"\"}}', NULL, 61, '{\"cardholderName\":\"jkdnf\",\"encryptedCardNumber\":\"qEi99AE6LlwTVVaXM47UtOpFhVmDr2EwhxanUnrPMJo=\",\"expirationDate\":\"08\\/42\",\"cvv\":\"124\"}', NULL, 'paid', 0000000007),
(38, '2023-12-09', 9.999, '{\"RecipientName\":\"at table\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+973456789876\",\"Email\":\"\"}}', NULL, 61, '{\"cardholderName\":\"dekjhkeh\",\"encryptedCardNumber\":\"7QMJ5XDyrXIT3ujRMHtjr1pBi+OaTaRE1J4pTOn+kUM=\",\"expirationDate\":\"04\\/56\",\"cvv\":\"3454\"}', NULL, 'paid', 0000000007),
(39, '2023-12-09', 9.999, '{\"RecipientName\":\"at table\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+973456789876\",\"Email\":\"\"}}', NULL, 61, '{\"cardholderName\":\"fedfe\",\"encryptedCardNumber\":\"O+pPFex127CQzesQg6uFEYEl+shzOOwmwrSNxN40iv4=\",\"expirationDate\":\"02\\/26\",\"cvv\":\"244\"}', NULL, 'paid', 0000000007),
(40, '2023-12-09', 0, '1450', NULL, 61, '{\"cardholderName\":\"wfgd\",\"encryptedCardNumber\":\"0kzCTa6C53SLLgRbFAizoEDZC7i1lUDzpNuqqhIewwY=\",\"expirationDate\":\"09\\/65\",\"cvv\":\"4566\"}', NULL, 'paid', 0000000007),
(41, '2023-12-09', 1450, '{\"RecipientName\":\"at table\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+973456789876\",\"Email\":\"\"}}', NULL, 61, '{\"cardholderName\":\"fdef\",\"encryptedCardNumber\":\"BZIjkULAHtNoib1J52qmYfYt0eVB1gLk\\/HwB4pBl+fc=\",\"expirationDate\":\"06\\/54\",\"cvv\":\"2334\"}', NULL, 'paid', 0000000007),
(42, '2023-12-09', 1450, '{\"RecipientName\":\"at table\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+973456789876\",\"Email\":\"\"}}', NULL, 61, '{\"cardholderName\":\"dfghjklyl\",\"encryptedCardNumber\":\"04oSSq85i6dHl9114vghtuAgLXIwKV8qWed5cJVmYMs=\",\"expirationDate\":\"09\\/96\",\"cvv\":\"4345\"}', NULL, 'paid', 0000000007),
(43, '2023-12-09', 1450, '{\"RecipientName\":\"at table\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+973456789876\",\"Email\":\"\"}}', NULL, 61, '{\"cardholderName\":\"fkedgfj\",\"encryptedCardNumber\":\"M8\\/0kGqZW4IxLwRHleplWRR\\/n9BdPBz+Lj4NuHrwO2c=\",\"expirationDate\":\"08\\/66\",\"cvv\":\"245\"}', NULL, 'paid', 0000000007);

-- --------------------------------------------------------

--
-- Table structure for table `product data`
--

DROP TABLE IF EXISTS `product data`;
CREATE TABLE IF NOT EXISTS `product data` (
  `ProductID` int(9) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `RequiresPrescription` tinyint(1) NOT NULL,
  `Description` varchar(300) NOT NULL,
  `ExpireDate` date NOT NULL,
  `Quantity` int(10) NOT NULL,
  `Availability` tinyint(1) NOT NULL,
  `Price` double NOT NULL,
  `Points` int(11) DEFAULT NULL,
  `Brand` varchar(50) DEFAULT NULL,
  `Photo` varchar(500) DEFAULT NULL,
  `Alternate` varchar(255) NOT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product data`
--

INSERT INTO `product data` (`ProductID`, `Name`, `Type`, `RequiresPrescription`, `Description`, `ExpireDate`, `Quantity`, `Availability`, `Price`, `Points`, `Brand`, `Photo`, `Alternate`) VALUES
(1, 'Product 1', '', 0, '', '0000-00-00', -124, 5, 100, 2, NULL, 'p1.jpg', ''),
(2, 'Product 2', '', 0, '', '0000-00-00', 6, 0, 10, 3, NULL, 'p2.jpg', ''),
(3, 'Product 3', '', 0, '', '0000-00-00', 8, 0, 20, 4, NULL, 'p3.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `remember_me_tokens`
--

DROP TABLE IF EXISTS `remember_me_tokens`;
CREATE TABLE IF NOT EXISTS `remember_me_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) DEFAULT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `expiration_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `remember_me_tokens_ibfk_1` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sorder data`
--

DROP TABLE IF EXISTS `sorder data`;
CREATE TABLE IF NOT EXISTS `sorder data` (
  `OrderID` int(9) NOT NULL AUTO_INCREMENT,
  `UserID` int(9) DEFAULT NULL,
  `TotalPrice` double DEFAULT NULL,
  `PaymentMethod` varchar(20) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `CreditCardInfo` varchar(255) DEFAULT NULL,
  `AccBalance` int(20) DEFAULT NULL,
  `MembershipPoints` int(10) DEFAULT NULL,
  `PaymentID` int(9) DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `UserID` (`UserID`),
  KEY `PaymentID` (`PaymentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sordered item`
--

DROP TABLE IF EXISTS `sordered item`;
CREATE TABLE IF NOT EXISTS `sordered item` (
  `OrderID` int(9) NOT NULL,
  `ProductID` int(9) NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `TotalPrice` double DEFAULT NULL,
  `TotalPoints` int(11) NOT NULL,
  PRIMARY KEY (`OrderID`,`ProductID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spayment database`
--

DROP TABLE IF EXISTS `spayment database`;
CREATE TABLE IF NOT EXISTS `spayment database` (
  `PaymentID` int(9) NOT NULL AUTO_INCREMENT,
  `PayDate` date NOT NULL,
  `Total` double NOT NULL,
  `ShippingInfo` varchar(255) NOT NULL,
  `Details` varchar(255) DEFAULT NULL,
  `MembershipPoints` int(10) DEFAULT NULL,
  `CreditCardInfo` varchar(255) DEFAULT NULL,
  `AccBalance` int(20) DEFAULT NULL,
  `PaymentStatus` varchar(20) DEFAULT NULL,
  `UserID` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  PRIMARY KEY (`PaymentID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sproduct data`
--

DROP TABLE IF EXISTS `sproduct data`;
CREATE TABLE IF NOT EXISTS `sproduct data` (
  `ProductID` int(9) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `RequiresPrescription` tinyint(1) NOT NULL,
  `Description` varchar(300) NOT NULL,
  `ExpireDate` date NOT NULL,
  `Quantity` int(10) NOT NULL,
  `Availability` tinyint(1) NOT NULL,
  `Price` double NOT NULL,
  `Points` int(11) DEFAULT NULL,
  `Brand` varchar(50) DEFAULT NULL,
  `Photo` varchar(500) DEFAULT NULL,
  `Alternate` varchar(255) NOT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff data`
--

DROP TABLE IF EXISTS `staff data`;
CREATE TABLE IF NOT EXISTS `staff data` (
  `StaffID` int(9) NOT NULL AUTO_INCREMENT,
  `CPR` int(9) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `DOB` date NOT NULL,
  `AcademicDegree` varchar(30) NOT NULL,
  `MobileNumber` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Area` varchar(200) NOT NULL,
  `House` varchar(30) NOT NULL,
  `Street` varchar(20) NOT NULL,
  `Block` int(5) NOT NULL,
  `ProfilePic` text DEFAULT NULL,
  `StaffPosition` varchar(255) NOT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  PRIMARY KEY (`StaffID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff data`
--

INSERT INTO `staff data` (`StaffID`, `CPR`, `FirstName`, `LastName`, `Gender`, `DOB`, `AcademicDegree`, `MobileNumber`, `Email`, `Area`, `House`, `Street`, `Block`, `ProfilePic`, `StaffPosition`, `UserID`) VALUES
(26, 0, 'kjj', 'hkj', '', '0000-00-00', '', '+783456789', 'jhgfudyd@xc.dx', '', '', '', 0, NULL, '', 000000027);

-- --------------------------------------------------------

--
-- Table structure for table `supplier data`
--

DROP TABLE IF EXISTS `supplier data`;
CREATE TABLE IF NOT EXISTS `supplier data` (
  `SupplierID` int(10) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `MobileNumber` int(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `ProfilePic` text DEFAULT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  PRIMARY KEY (`SupplierID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier data`
--

INSERT INTO `supplier data` (`SupplierID`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `ProfilePic`, `UserID`) VALUES
(24, 'x', 'cc', 677654, 'dddddddd@ss.xa', NULL, 000000028);

-- --------------------------------------------------------

--
-- Table structure for table `sview cart`
--

DROP TABLE IF EXISTS `sview cart`;
CREATE TABLE IF NOT EXISTS `sview cart` (
  `CartID` int(9) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ProductID` int(9) NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `Total` double DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`CartID`,`ProductID`,`UserID`) USING BTREE,
  KEY `ProductID` (`ProductID`,`UserID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swish list data`
--

DROP TABLE IF EXISTS `swish list data`;
CREATE TABLE IF NOT EXISTS `swish list data` (
  `WID` int(9) NOT NULL AUTO_INCREMENT,
  `ProductID` int(9) DEFAULT NULL,
  `UserID` int(9) DEFAULT NULL,
  PRIMARY KEY (`WID`),
  KEY `ProductID` (`ProductID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user data`
--

DROP TABLE IF EXISTS `user data`;
CREATE TABLE IF NOT EXISTS `user data` (
  `UserID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Type` enum('Admin','Customer','Staff','Supplier') NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user data`
--

INSERT INTO `user data` (`UserID`, `Username`, `Email`, `Password`, `Type`) VALUES
(000000001, 'fat', '20198132@stu.uob.edu.bh', 'A87654321a', 'Admin'),
(000000002, 'fatema', '20198@stu.uob.edu.bh', '$2y$10$TD3o2MduQ6lFXe0EnWpw6OU27tOhd.i4vO9xCH4Dslp/18kpx0LwW', 'Customer'),
(000000003, 'lkejdk', '202305538@stu.uob.edu.bh', '$2y$10$IL7cg/7gBU5GNftiUH0os.Aff5j.mYiXXN48Mu9huyh2F.ZUPVaKS', 'Customer'),
(000000004, 'ljcjk', 'jaffere2005@gmail.com', '$2y$10$KUu.xktWy6fisJlY7NB5ve08fZxoBFW/fIqLogG.FKLaw./UU40pW', 'Customer'),
(000000005, 'ASd', 'afd@dd.con', '$2y$10$tT/AtJ525JNdYiZdF5sfB.JufueyZvX6nG3XQAhXL9sjeq4yE81ia', 'Customer'),
(000000006, 'swdw', '2023058@stu.uob.edu.bh', '$2y$10$qwv.bP2TwOtiQzmAINZD1.9jN0qrHT54PCgRiXAgeqRiJADVslnMq', 'Customer'),
(000000007, 'sede', '20230538@stu.uob.edu.bh', '$2y$10$t7gcpwElzE36EyMox9wbuumWsorwsdfiVgHr424Gwx4Hu6vt3vLz2', 'Customer'),
(000000008, 'Walaae', 'walaa.e@icloud.com', '$2y$10$7z6kAxRbL.1cPNTOmdPyLuBq86CoOym2cmGGtOJH4JsGI4GmULRhK', 'Admin'),
(000000009, 'trfdglkj', 'afddd@dd.con', '$2y$10$hoUpjyT.l5k83sBPevaGLumczwUmfcAITDDtIYf7k6DeLpCMXvWZO', 'Customer'),
(000000010, 'dfhjbljld', '201908@stu.uob.edu.bh', '$2y$10$X6mHl02owMxnMvLkZY2fOuQ0H4UN.h7kFqjaW3Z30XjPUMF/5UnLO', 'Customer'),
(000000011, 'redtyu', '201981320@stu.uob.edu.bh', '$2y$10$qTErAwP0ZscgRix.m8kAR.F7Tmqulv7aWDlZxPpwpKRCGxPurbGLu', 'Customer'),
(000000012, 'dfghjkm', '2023068@stu.uob.edu.bh', '$2y$10$/Lx/dbRpkXO7KAC/3b1MBODiVp.vP3zfxNYKVwfKSetreMCbYwIkG', 'Customer'),
(000000013, 'jhdj', 'fabh2001@hotmail.com', '$2y$10$2urs/COjI.STZvJzOGr5euLK10fKKmCzzOmJlyYDclXbkNXLH4Xhi', 'Customer'),
(000000014, 'erfghjkl', 'faabh2001@hotmail.com', '$2y$10$FmMgrmtFdonGmaq8cHrhPueXMagc5ljfzlFhlKlVyKGPBHXZz7Xfq', 'Customer'),
(000000015, 'fiedjp', 'faqbh2001@hotmail.com', '$2y$10$z4AfOBqE.CCWU814KIlVUuG1sI1g0hyjf6/pC.2WQlrmLKc4k5KJO', 'Customer'),
(000000016, 'fiedjprt', 'faqbha2001@hotmail.com', '$2y$10$0l.ei/izhR.Z88F92xlcGu28cH2JErHku1MR5zNPf/T6lvURDsGxa', 'Staff'),
(000000017, 'fiedjprtg', 'faqbha20301@hotmail.com', '$2y$10$w.txHkkpcAZNFeTYs0jtae8H4Uja.D/bN6W5Z61BAOlWH0NrbR4pO', 'Admin'),
(000000018, 'gtddhgfyfh', '20198fa132@stu.uob.edu.bh', '$2y$10$VSZ/gBVxC1ND7T5gLEamoOL920QA4nqTIl5PfXQu3WeQPgg6PMQum', 'Supplier'),
(000000019, 'gtddhgfyfhh', '20198fa1342@stu.uob.edu.bh', '$2y$10$GWsFb1PGtTsutS1HwfjNXOSUX4A9UaellRkCba0Hdhds1SdSi.N7a', 'Admin'),
(000000020, 'fsgfdrgrdrf', 'afffdfgd@dd.con', '$2y$10$UYBD.DSRM8/8lKjKOMPlReaSUfgwK73E37kqVWazBZEiJUwIUS1NC', 'Admin'),
(000000021, 'fsgfdrgrdrff', 'afffdfggd@dd.con', '$2y$10$ozUfadjw28a1C1gXRgC1vODJm9WmssrLRYsi12IbNm4.Q2G2pCNVC', 'Admin'),
(000000022, 'jgidijgl', 'fndjdgdid@stu.com', '$2y$10$qBqXpA6amqw4fEiejhVsbe/sFLz.Vp/auOXmHJBdxtLPpIHmUmRNi', 'Customer'),
(000000023, 'lkgtfrtfog', 'glkrjgjkrehjg@gmail.com', '$2y$10$Qi19B3jJoF1WJJOWN1mcCOZtW8ak5FBvRDmUQ0sdTQgYa8EFaikX.', 'Supplier'),
(000000024, 'mgfdlm', 'lgmgl@ggg.ck', '$2y$10$mcYzecst0pyA.3Mhi4Upaeunz2LUah8fZxGzVVATi0g5O5jcJKDnK', 'Admin'),
(000000025, 'gtghthfyn', 'grdgrg@et.po', '$2y$10$dLnKT9yk82YqT.9Ytu/xPeR9chshFGlmdDtE0DZ2Ayp1YX14omHca', 'Staff'),
(000000027, 'wsdfghjkdd', 'jhgfudyd@xc.dx', '$2y$10$rCoG33E96zBqCDhdTBQbF.z3ZLiMkJvem9lrFUqdZosdHFDWf0Oj2', 'Staff'),
(000000028, 'dcfd', 'dddddddd@ss.xa', '$2y$10$KBo/TRCIvYjj9Jqa/stv8.7/GMZ81A8WMSOCsZ1uFoJ7IyTLiE7LO', 'Supplier'),
(000000029, 'Fiddah', 'fiddah16@hotmail.com', '$2y$10$UahvMwHfVfyc/Lnt/gLIKur3m4qc1cjRdx3RNPAuhhljzr5r8S60y', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `view cart`
--

DROP TABLE IF EXISTS `view cart`;
CREATE TABLE IF NOT EXISTS `view cart` (
  `CartID` int(9) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ProductID` int(9) NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `Total` double DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`CartID`,`ProductID`,`UserID`) USING BTREE,
  KEY `ProductID` (`ProductID`,`UserID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `view cart`
--

INSERT INTO `view cart` (`CartID`, `UserID`, `ProductID`, `Qty`, `Total`, `AddedDate`) VALUES
(17, 3, 3, 1, 20, '2023-12-06'),
(18, 3, 2, 2, 20, '2023-12-07'),
(19, 6, 1, 7, 200, '2023-12-07'),
(19, 6, 2, 1, 0, '2023-12-09'),
(19, 6, 3, 1, 0, '2023-12-09'),
(21, 6, 2, 2, 20, '2023-12-08'),
(22, 6, 2, 2, 20, '2023-12-08'),
(23, 6, 2, 1, 10, '2023-12-08'),
(39, 7, 1, 32, 3200, '2023-12-09'),
(39, 7, 2, 5, 50, '2023-12-09'),
(39, 7, 3, 5, 100, '2023-12-09'),
(40, 6, 2, 1, 10, '2023-12-14'),
(41, 6, 2, 1, 10, '2023-12-14');

-- --------------------------------------------------------

--
-- Table structure for table `wish list data`
--

DROP TABLE IF EXISTS `wish list data`;
CREATE TABLE IF NOT EXISTS `wish list data` (
  `WID` int(9) NOT NULL AUTO_INCREMENT,
  `ProductID` int(9) DEFAULT NULL,
  `UserID` int(9) DEFAULT NULL,
  PRIMARY KEY (`WID`),
  KEY `ProductID` (`ProductID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer data`
--
ALTER TABLE `customer data`
  ADD CONSTRAINT `customer data_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);

--
-- Constraints for table `payment database`
--
ALTER TABLE `payment database`
  ADD CONSTRAINT `payment database_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);

--
-- Constraints for table `remember_me_tokens`
--
ALTER TABLE `remember_me_tokens`
  ADD CONSTRAINT `remember_me_tokens_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);

--
-- Constraints for table `spayment database`
--
ALTER TABLE `spayment database`
  ADD CONSTRAINT `spayment database_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);

--
-- Constraints for table `staff data`
--
ALTER TABLE `staff data`
  ADD CONSTRAINT `staff data_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);

--
-- Constraints for table `supplier data`
--
ALTER TABLE `supplier data`
  ADD CONSTRAINT `supplier data_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
