-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2024 at 08:46 PM
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
CREATE TABLE `customer data` (
  `CustomerID` int(9) NOT NULL,
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
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer data`
--

INSERT INTO `customer data` (`CustomerID`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `Area`, `House`, `Street`, `Block`, `Gender`, `DOB`, `CreditCardInfo`, `ShippingInfo`, `AccBalance`, `MembershipPoints`, `ProfilePic`, `UserID`) VALUES
(1, 'faisal', 'name', '+97311111111', '1213sada2@hotmail.com', 'TEst1', 'TEst2', 'TEst23', 6514, 'Female', NULL, '{\"cardholderName\":\"dgehfkedhfk\",\"encryptedCardNumber\":\"+LkfBDEOgA3g4aCsWW4vjTom80YV424yc4bhxtCoKDE=\",\"expirationDate\":\"08\\/27\",\"cvv\":\"232\"}', '{\"RecipientName\":\"faisal name\",\"Address\":{\"Area\":\"TEst1\",\"House\":\"TEst2\",\"Street\":\"TEst23\",\"Block\":6514},\"Contact\":{\"MobileNumber\":\"+97311111111\",\"Email\":\"1213sada2@hotmail.com\"}}', 0, 60004, NULL, 000000003),
(2, 'at', 'table', '+9734567890', '', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000006),
(7, 'at', 'table', '+973456789876', '', '', '', '', 0, 'Female', NULL, '', '', 0, 488, NULL, 000000007),
(8, 'Walaa', 'Salman', '+97336735550', 'walaa.e@icloud.com', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000008),
(10, 'gdjehgfjkeh', 'jhgjjh', '+86723456789', '201908@stu.uob.edu.bh', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000010),
(12, 'dfghjk', 'ry', '+973456789', '2023068@stu.uob.edu.bh', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000012),
(13, 'gfhjk', 'fghjkl', '+945234567890', 'fabh2001@hotmail.com', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000013),
(14, 'hdkjfj', 'dekiho', '+9453254566789', 'faqbh2001@hotmail.com', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000015),
(15, 'goird', 'sdjhgtf', '+7843543543', 'fndjdgdid@stu.com', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000022),
(16, 'Fiddah', 'Ahmed Alqaidoom', '+97336654453', 'fiddah16@hotmail.com', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000029),
(18, 'Jaffar', 'Ebrahim', '+9423456782', 'jaffer32re2005@gmail.com', '', '', '', 0, 'Female', NULL, '', '', 0, 0, NULL, 000000033),
(29, 'FATEMA', 'Ebrahim', '+9687654325', '2019fsd8132@stu.uob.edu.bh', '', '', '', 0, 'Female', '1986-03-13', '', '', 0, 0, NULL, 000000044),
(30, 'faisal', 'rtbggtrbt', '+96543265', 'fatoooomabhfdgre2001@hotmail.com', '', '', '', 0, 'Male', '1854-03-04', '', '', 0, 0, NULL, 000000045),
(31, 'FATEMA', 'Ebrahima', '+934567896', '20198nesdmbcf132@stu.uob.edu.bh', 'hdjwgaj', '2748', '8726', 376, 'Male', '1974-02-04', '', '', 0, 0, NULL, 000000047);

-- --------------------------------------------------------

--
-- Table structure for table `offers data`
--

DROP TABLE IF EXISTS `offers data`;
CREATE TABLE `offers data` (
  `OfferID` int(9) NOT NULL,
  `ProductID` int(9) DEFAULT NULL,
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

DROP TABLE IF EXISTS `order data`;
CREATE TABLE `order data` (
  `OrderID` int(9) NOT NULL,
  `UserID` int(9) DEFAULT NULL,
  `TotalPrice` double DEFAULT NULL,
  `PaymentMethod` varchar(20) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `CreditCardInfo` varchar(255) DEFAULT NULL,
  `AccBalance` int(20) DEFAULT NULL,
  `MembershipPoints` int(10) DEFAULT NULL,
  `OrderDetails` varchar(255) NOT NULL,
  `PaymentID` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order data`
--

INSERT INTO `order data` (`OrderID`, `UserID`, `TotalPrice`, `PaymentMethod`, `Status`, `OrderDate`, `CreditCardInfo`, `AccBalance`, `MembershipPoints`, `OrderDetails`, `PaymentID`) VALUES
(61, 6, 3382, 'Credit Card', 'Completed', '2024-01-03', '{\"cardholderName\":\"fsefsf\",\"encryptedCardNumber\":\"ouC5SUkKffEzzQltRhpwJfvbN4CxKnwiUd8qKFVZ3jA=\",\"expirationDate\":\"12\\/55\",\"cvv\":\"3111\"}', NULL, NULL, '', 35),
(139, 7, 3382, 'Credit Card', 'Out for Delivery', '2024-01-03', '{\"cardholderName\":\"dekjhkeh\",\"encryptedCardNumber\":\"7QMJ5XDyrXIT3ujRMHtjr1pBi+OaTaRE1J4pTOn+kUM=\",\"expirationDate\":\"04\\/56\",\"cvv\":\"3454\"}', NULL, 61, '', 38),
(140, 7, 3382, 'Credit Card', 'Completed', '2024-01-03', '{\"cardholderName\":\"fedfe\",\"encryptedCardNumber\":\"O+pPFex127CQzesQg6uFEYEl+shzOOwmwrSNxN40iv4=\",\"expirationDate\":\"02\\/26\",\"cvv\":\"244\"}', NULL, 61, '', 39),
(141, 7, 3382, 'Credit Card', 'Completed', '2024-01-03', '{\"cardholderName\":\"wfgd\",\"encryptedCardNumber\":\"0kzCTa6C53SLLgRbFAizoEDZC7i1lUDzpNuqqhIewwY=\",\"expirationDate\":\"09\\/65\",\"cvv\":\"4566\"}', NULL, 61, '', 40),
(142, 7, 3382, 'Credit Card', 'Completed', '2024-01-03', '{\"cardholderName\":\"fdef\",\"encryptedCardNumber\":\"BZIjkULAHtNoib1J52qmYfYt0eVB1gLk\\/HwB4pBl+fc=\",\"expirationDate\":\"06\\/54\",\"cvv\":\"2334\"}', NULL, 61, '', 41),
(144, 6, 3382, 'Credit Card', 'Completed', '2024-01-03', NULL, NULL, NULL, '', NULL),
(145, 7, 3382, 'Credit Card', 'Completed', '2024-01-03', '{\"cardholderName\":\"dfghjklyl\",\"encryptedCardNumber\":\"04oSSq85i6dHl9114vghtuAgLXIwKV8qWed5cJVmYMs=\",\"expirationDate\":\"09\\/96\",\"cvv\":\"4345\"}', NULL, 61, '', 42),
(146, 7, 3382, 'Credit Card', 'Completed', '2024-01-03', '{\"cardholderName\":\"fkedgfj\",\"encryptedCardNumber\":\"M8\\/0kGqZW4IxLwRHleplWRR\\/n9BdPBz+Lj4NuHrwO2c=\",\"expirationDate\":\"08\\/66\",\"cvv\":\"245\"}', NULL, 61, '', 43),
(147, 1, 3382, 'Credit Card', 'Confirmed', '2024-01-03', NULL, NULL, 60340, '', NULL),
(148, 7, 3382, 'Credit Card', 'Pending', '2024-01-03', NULL, NULL, 146, '', NULL),
(149, 7, 3382, 'Credit Card', 'Pending', '2024-01-03', NULL, NULL, 30359, '', NULL),
(150, 3, 40, 'Credit Card', 'Payment Confirmed', '2024-01-03', '{\"cardholderName\":\"dgehfkedhfk\",\"encryptedCardNumber\":\"+LkfBDEOgA3g4aCsWW4vjTom80YV424yc4bhxtCoKDE=\",\"expirationDate\":\"08\\/27\",\"cvv\":\"232\"}', NULL, 60004, '', 44);

-- --------------------------------------------------------

--
-- Table structure for table `ordered item`
--

DROP TABLE IF EXISTS `ordered item`;
CREATE TABLE `ordered item` (
  `OrderID` int(9) NOT NULL,
  `ProductID` int(9) NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `TotalPrice` double DEFAULT NULL,
  `TotalPoints` int(11) NOT NULL
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
(146, 3, 5, 100, 20),
(147, 1, 1, 101, 2),
(147, 2, 2, 20, 60000),
(147, 3, 1, 20, 4),
(147, 11, 1, 3, 334),
(148, 1, 1, 101, 2),
(148, 3, 1, 20, 4),
(148, 13, 3, 9, 117),
(148, 18, 1, 233, 23),
(149, 1, 1, 101, 2),
(149, 2, 1, 10, 30000),
(149, 11, 1, 3, 334),
(149, 32, 1, 2345, 23),
(150, 2, 2, 20, 60000),
(150, 3, 1, 20, 4);

-- --------------------------------------------------------

--
-- Table structure for table `payment database`
--

DROP TABLE IF EXISTS `payment database`;
CREATE TABLE `payment database` (
  `PaymentID` int(9) NOT NULL,
  `PayDate` date NOT NULL,
  `Total` double NOT NULL,
  `ShippingInfo` varchar(255) NOT NULL,
  `Details` varchar(255) DEFAULT NULL,
  `MembershipPoints` int(10) DEFAULT NULL,
  `CreditCardInfo` varchar(255) DEFAULT NULL,
  `AccBalance` int(20) DEFAULT NULL,
  `PaymentStatus` varchar(20) DEFAULT NULL,
  `UserID` int(10) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(43, '2023-12-09', 1450, '{\"RecipientName\":\"at table\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+973456789876\",\"Email\":\"\"}}', NULL, 61, '{\"cardholderName\":\"fkedgfj\",\"encryptedCardNumber\":\"M8\\/0kGqZW4IxLwRHleplWRR\\/n9BdPBz+Lj4NuHrwO2c=\",\"expirationDate\":\"08\\/66\",\"cvv\":\"245\"}', NULL, 'paid', 0000000007),
(44, '2024-01-03', 40, '{\"RecipientName\":\"faisal name\",\"Address\":{\"Area\":\"TEst1\",\"House\":\"TEst2\",\"Street\":\"TEst23\",\"Block\":6514},\"Contact\":{\"MobileNumber\":\"+97311111111\",\"Email\":\"1213sada2@hotmail.com\"}}', NULL, 60004, '{\"cardholderName\":\"dgehfkedhfk\",\"encryptedCardNumber\":\"+LkfBDEOgA3g4aCsWW4vjTom80YV424yc4bhxtCoKDE=\",\"expirationDate\":\"08\\/27\",\"cvv\":\"232\"}', NULL, 'paid', 0000000003);

-- --------------------------------------------------------

--
-- Table structure for table `product data`
--

DROP TABLE IF EXISTS `product data`;
CREATE TABLE `product data` (
  `ProductID` int(9) NOT NULL,
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
  `Alternate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product data`
--

INSERT INTO `product data` (`ProductID`, `Name`, `Type`, `RequiresPrescription`, `Description`, `ExpireDate`, `Quantity`, `Availability`, `Price`, `Points`, `Brand`, `Photo`, `Alternate`) VALUES
(1, 'Product 1', 'Medicine', 1, 'dvfges', '2023-12-05', 124, 1, 101, 2, 'rfg', '../images/p1.jpg', 'gdrd'),
(2, 'Product 2', 'Medicine', 1, 'ghbdf', '0000-00-00', 4, 1, 10, 30000, 'gfb', 'p2.jpg', 'bgf'),
(3, 'Product 3', 'Medicine', 0, 'esdgd', '0000-00-00', 7, 1, 20, 4, 'grfdh', 'p3.jpg', 'fdhnf'),
(11, 'VC', 'Medicine', 1, '3VC', '2023-12-28', 3, 1, 3, 334, 'VC', '../images/658d4506c9eb1.jpeg', 'VC'),
(13, 'gftgd', 'Medicine', 1, 'gtrgbtrf', '2023-12-11', 3, 1, 3, 39, 'gbgnbgh', '../images/658bd3f70761e.jpg', 'frgt'),
(18, 'refrere', 'Medicine', 1, 'ferfe', '2023-12-05', 23, 0, 233, 23, 'fdv', NULL, 'vfvvg'),
(19, 'refrere', 'Medicine', 1, 'ferfe', '2023-12-05', 23, 0, 233, 23, 'fdv', NULL, 'vfvvg'),
(20, 'refrerefre', 'Health Accessories', 1, 'ferfefre', '2023-12-05', 23000, 0, 233, 2332, 'fdv23', NULL, 'vfvvgrd'),
(21, 'refrerefre', 'Health Accessories', 1, 'ferfefre', '2023-12-05', 23000, 0, 233, 2332, 'fdv23', '../images/658f1b1f65746.jpg', 'vfvvgrd'),
(22, 'refrerefre', 'Health Accessories', 1, 'ferfefre', '2023-12-05', 23000, 0, 233, 2332, 'fdv23', '../images/658f1b5258671.jpg', 'vfvvgrd'),
(23, 'fcre', 'Feminine Hygiene', 1, 'dewfc', '2023-12-13', 332, 1, 32, 32, 'cfvfvf', NULL, 'referer'),
(24, 'fcre', 'Feminine Hygiene', 1, 'dewfc', '2023-12-13', 332, 1, 32, 32, 'cfvfvf', NULL, 'referer'),
(25, 'dfgfh', 'Hair Wash & Care', 1, 'hrdhrtkmktyh', '2435-03-24', 23, 1, 243, 324, 'sgddfhth', '../images/65943773677c4.jpg', '13'),
(26, 'dfgfh', 'Hair Wash & Care', 1, 'hrdhrtkmktyh', '2435-03-24', 23, 1, 243, 324, 'sgddfhth', '../images/659437df387bb.jpg', '13'),
(27, 'dfgfh', 'Hair Wash & Care', 1, 'hrdhrtkmktyh', '2435-03-24', 23, 1, 243, 324, 'sgddfhth', '../images/659437f22ed8d.jpg', '13'),
(28, 'dfgfh', 'Hair Wash & Care', 1, 'hrdhrtkmktyh', '2435-03-24', 23, 1, 243, 324, 'sgddfhth', '../images/6594381caddb6.jpg', '13'),
(29, 'dfgfh', 'Hair Wash & Care', 1, 'hrdhrtkmktyh', '2435-03-24', 23, 1, 243, 324, 'sgddfhth', '../images/65943842c85d2.jpg', '13'),
(30, 'dfgfh', 'Hair Wash & Care', 1, 'hrdhrtkmktyh', '2435-03-24', 23, 1, 243, 324, 'sgddfhth', '../images/659438778f951.jpg', '13'),
(31, 'dfgfh', 'Bath & Shower', 1, 'dsewfreeght', '1999-03-03', 345, 1, 2345, 23, ' nhgbfvftgbvfcdfddsxz', '../images/65943b38e47f5.jpg', 'refrerefre'),
(32, 'dfgfh', 'Medicine', 1, 'sadsafd', '3443-01-02', 345, 1, 2345, 23, ' nhgbfvftgbvfcdfddsxz', '../images/65943bb5887f0.jpg', 'Product 1');

-- --------------------------------------------------------

--
-- Table structure for table `remember_me_tokens`
--

DROP TABLE IF EXISTS `remember_me_tokens`;
CREATE TABLE `remember_me_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `expiration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff data`
--

DROP TABLE IF EXISTS `staff data`;
CREATE TABLE `staff data` (
  `StaffID` int(9) NOT NULL,
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
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff data`
--

INSERT INTO `staff data` (`StaffID`, `CPR`, `FirstName`, `LastName`, `Gender`, `DOB`, `AcademicDegree`, `MobileNumber`, `Email`, `Area`, `House`, `Street`, `Block`, `ProfilePic`, `StaffPosition`, `UserID`) VALUES
(26, 0, 'kjj', 'hkj', '', '0000-00-00', '', '+783456789', 'jhgfudyd@xc.dx', '', '', '', 0, NULL, '', 000000027),
(28, 740637654, 'FATEMA', 'Ebrahim', '', '1974-02-04', 'sfdfhgfjgh', '+934567896', '20198nesdmrfbcf132@stu.uob.edu.bh', 'hdjwgaj', '2748', '8726', 376, NULL, 'dfhfgmgfjnghykm', 000000048);

-- --------------------------------------------------------

--
-- Table structure for table `supplier data`
--

DROP TABLE IF EXISTS `supplier data`;
CREATE TABLE `supplier data` (
  `SupplierID` int(10) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `MobileNumber` int(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `ProfilePic` text DEFAULT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier data`
--

INSERT INTO `supplier data` (`SupplierID`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `ProfilePic`, `UserID`) VALUES
(24, 'x', 'cc', 677654, 'dddddddd@ss.xa', NULL, 000000028),
(26, 'Jaffar', 'Ebrahim', 2147483647, 'jaffere20erfwe05@gmail.com', NULL, 000000046);

-- --------------------------------------------------------

--
-- Table structure for table `trackorder`
--

DROP TABLE IF EXISTS `trackorder`;
CREATE TABLE `trackorder` (
  `OrderID` int(11) DEFAULT NULL,
  `ConfirmedDate` timestamp NULL DEFAULT NULL,
  `ProcessingDate` timestamp NULL DEFAULT NULL,
  `ReadyToPickUpDate` timestamp NULL DEFAULT NULL,
  `OutForDeliveryDate` timestamp NULL DEFAULT NULL,
  `CompleteOrderDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trackorder`
--

INSERT INTO `trackorder` (`OrderID`, `ConfirmedDate`, `ProcessingDate`, `ReadyToPickUpDate`, `OutForDeliveryDate`, `CompleteOrderDate`) VALUES
(139, '2024-01-02 21:00:02', '2024-01-02 21:01:16', NULL, '2024-01-02 21:01:33', '2024-01-02 20:53:33'),
(140, '2024-01-02 21:01:50', '2024-01-02 21:01:57', '2024-01-02 20:59:19', NULL, '2024-01-02 21:02:12'),
(144, '2024-01-02 21:02:29', '2024-01-02 20:59:35', '2024-01-02 21:01:04', NULL, '2024-01-02 21:02:38'),
(61, '2024-01-02 21:02:48', '2024-01-02 21:02:55', NULL, '2024-01-02 20:59:48', '2024-01-02 21:03:02'),
(141, '2024-01-02 21:03:13', '2024-01-02 21:03:20', '2024-01-02 21:00:18', NULL, '2024-01-02 21:03:29'),
(142, '2024-01-02 21:03:37', '2024-01-02 21:00:29', NULL, '2024-01-02 21:03:53', '2024-01-02 21:04:01'),
(145, '2024-01-02 21:04:18', '2024-01-02 21:00:49', '2024-01-02 21:04:25', NULL, '2024-01-02 21:04:33'),
(146, '2024-01-02 21:04:43', '2024-01-02 21:04:50', NULL, '2024-01-02 21:04:58', '2024-01-02 21:05:05'),
(147, '2024-01-03 15:14:42', '2024-01-03 15:14:15', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user data`
--

DROP TABLE IF EXISTS `user data`;
CREATE TABLE `user data` (
  `UserID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Type` enum('Admin','Customer','Staff','Supplier') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(000000029, 'Fiddah', 'fiddah16@hotmail.com', '$2y$10$UahvMwHfVfyc/Lnt/gLIKur3m4qc1cjRdx3RNPAuhhljzr5r8S60y', 'Customer'),
(000000033, 'hybtrhtr', 'jaffer32re2005@gmail.com', '$2y$10$kinjVR/ceQdFuYBcWNDGb.1Agh0xda1DGOvLO/.bTIfjKEVAsgqPK', 'Customer'),
(000000044, 'fdrgtrgtrgtyhbyth', '2019fsd8132@stu.uob.edu.bh', '$2y$10$nrhV3KV/5Cvq6h7w0QlYfuiYin5P2TcNnQqkX58jgX9A5CNwruLua', 'Customer'),
(000000045, 'lkyjhtgfujhygfd', 'fatoooomabhfdgre2001@hotmail.com', '$2y$10$OVW32BnmOQVWkh/b2DyFZu5Leked9G/UxKF25TJaGeP40PNpkQ33C', 'Customer'),
(000000046, 'eftrhtyjnyujui', 'jaffere20erfwe05@gmail.com', '$2y$10$batjeq95Zef4Hv0Ud91CUeeb1XXbESaWHZYY9u14cZ5D8m8yyhmOu', 'Supplier'),
(000000047, 'smsnddbskfj', '20198nesdmbcf132@stu.uob.edu.bh', '$2y$10$zXAvzmXPzArfcI5WukDiwe1j04j8K9fm/VXlkRZmVPn6cp.OCFsSG', 'Customer'),
(000000048, 'smsnddbskfjewrfer', '20198nesdmrfbcf132@stu.uob.edu.bh', '$2y$10$bi8St.h9mRhWL95RbwBBXe8M0MNFHLxG02L738dmuQyQz1XF4Z.mS', 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `view cart`
--

DROP TABLE IF EXISTS `view cart`;
CREATE TABLE `view cart` (
  `CartID` int(9) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductID` int(9) NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `Total` double DEFAULT NULL,
  `AddedDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(41, 6, 2, 1, 10, '2023-12-14'),
(42, 6, 2, 1, 10, '2023-12-15');

-- --------------------------------------------------------

--
-- Table structure for table `wish list data`
--

DROP TABLE IF EXISTS `wish list data`;
CREATE TABLE `wish list data` (
  `WID` int(9) NOT NULL,
  `ProductID` int(9) DEFAULT NULL,
  `UserID` int(9) DEFAULT NULL
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
-- Indexes for table `remember_me_tokens`
--
ALTER TABLE `remember_me_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remember_me_tokens_ibfk_1` (`UserID`);

--
-- Indexes for table `staff data`
--
ALTER TABLE `staff data`
  ADD PRIMARY KEY (`StaffID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `supplier data`
--
ALTER TABLE `supplier data`
  ADD PRIMARY KEY (`SupplierID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `trackorder`
--
ALTER TABLE `trackorder`
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `user data`
--
ALTER TABLE `user data`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `view cart`
--
ALTER TABLE `view cart`
  ADD PRIMARY KEY (`CartID`,`ProductID`,`UserID`) USING BTREE,
  ADD KEY `ProductID` (`ProductID`,`UserID`) USING BTREE;

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
  MODIFY `CustomerID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `offers data`
--
ALTER TABLE `offers data`
  MODIFY `OfferID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order data`
--
ALTER TABLE `order data`
  MODIFY `OrderID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `payment database`
--
ALTER TABLE `payment database`
  MODIFY `PaymentID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `product data`
--
ALTER TABLE `product data`
  MODIFY `ProductID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `remember_me_tokens`
--
ALTER TABLE `remember_me_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff data`
--
ALTER TABLE `staff data`
  MODIFY `StaffID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `supplier data`
--
ALTER TABLE `supplier data`
  MODIFY `SupplierID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user data`
--
ALTER TABLE `user data`
  MODIFY `UserID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `view cart`
--
ALTER TABLE `view cart`
  MODIFY `CartID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `wish list data`
--
ALTER TABLE `wish list data`
  MODIFY `WID` int(9) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `staff data`
--
ALTER TABLE `staff data`
  ADD CONSTRAINT `staff data_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);

--
-- Constraints for table `supplier data`
--
ALTER TABLE `supplier data`
  ADD CONSTRAINT `supplier data_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user data` (`UserID`);

--
-- Constraints for table `trackorder`
--
ALTER TABLE `trackorder`
  ADD CONSTRAINT `trackorder_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order data` (`OrderID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
