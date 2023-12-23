-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2023 at 04:20 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `customer data`
--

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
(18, 's', 'h', '+93554468648648', 's@h.com', '', '', '', 0, 'Female', NULL, '{\"cardholderName\":\"sada\",\"encryptedCardNumber\":\"WOSP082TgwfSPRDe16NxPy\\/ORg1o6krWEvnHbAmrS+U=\",\"expirationDate\":\"12\\/55\",\"cvv\":\"1213\"}', '{\"RecipientName\":\"s h\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+93554468648648\",\"Email\":\"s@h.com\"}}', 0, 195, NULL, 000000034);

-- --------------------------------------------------------

--
-- Table structure for table `offers data`
--

CREATE TABLE `offers data` (
  `OfferID` int(9) NOT NULL,
  `ProductID` int(9) DEFAULT NULL,
  `OfferCode` int(9) DEFAULT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `DiscountedPrice` double DEFAULT NULL,
  `OriginalPrice` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers data`
--

INSERT INTO `offers data` (`OfferID`, `ProductID`, `OfferCode`, `StartDate`, `EndDate`, `DiscountedPrice`, `OriginalPrice`) VALUES
(39, 5, NULL, '2023-12-21', '2023-12-25', 50, 100),
(41, 7, NULL, '2023-12-21', '2023-12-26', 20, 22);

-- --------------------------------------------------------

--
-- Table structure for table `order data`
--

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
  `PaymentID` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order data`
--

INSERT INTO `order data` (`OrderID`, `UserID`, `TotalPrice`, `PaymentMethod`, `Status`, `OrderDate`, `CreditCardInfo`, `AccBalance`, `MembershipPoints`, `PaymentID`) VALUES
(161, 34, 1500, 'Credit Card', 'Payment Confirmed', '2023-12-18', '{\"cardholderName\":\"wd\",\"encryptedCardNumber\":\"jt+CJj2tBO3FKG6OMUFz2rOiTuWYDVO18VQasEA6ecQ=\",\"expirationDate\":\"11\\/55\",\"cvv\":\"1321\"}', NULL, 30, 58),
(162, 34, 1100, 'Credit Card', 'Payment Confirmed', '2023-12-18', '{\"cardholderName\":\"fwefw\",\"encryptedCardNumber\":\"ARWNvbJbbnv\\/54vMbC9AHDo3ZkOQmArlbPpZhvwG5Hk=\",\"expirationDate\":\"11\\/55\",\"cvv\":\"1213\"}', NULL, 25, 59),
(163, 34, 199, 'Credit Card', 'Payment Confirmed', '2023-12-23', '{\"cardholderName\":\"sada\",\"encryptedCardNumber\":\"WOSP082TgwfSPRDe16NxPy\\/ORg1o6krWEvnHbAmrS+U=\",\"expirationDate\":\"12\\/55\",\"cvv\":\"1213\"}', NULL, 18, 60);

-- --------------------------------------------------------

--
-- Table structure for table `ordered item`
--

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
(161, 6, 5, 1500, 30),
(162, 4, 5, 1000, 20),
(162, 5, 1, 100, 5),
(163, 5, 2, 200, 10),
(163, 8, 1, 99, 8);

-- --------------------------------------------------------

--
-- Table structure for table `payment database`
--

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
(58, '2023-12-18', 1500, '{\"RecipientName\":\"s h\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+93554468648648\",\"Email\":\"s@h.com\"}}', NULL, 30, '{\"cardholderName\":\"wd\",\"encryptedCardNumber\":\"jt+CJj2tBO3FKG6OMUFz2rOiTuWYDVO18VQasEA6ecQ=\",\"expirationDate\":\"11\\/55\",\"cvv\":\"1321\"}', NULL, 'paid', 0000000034),
(59, '2023-12-18', 1100, '{\"RecipientName\":\"s h\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+93554468648648\",\"Email\":\"s@h.com\"}}', NULL, 25, '{\"cardholderName\":\"fwefw\",\"encryptedCardNumber\":\"ARWNvbJbbnv\\/54vMbC9AHDo3ZkOQmArlbPpZhvwG5Hk=\",\"expirationDate\":\"11\\/55\",\"cvv\":\"1213\"}', NULL, 'paid', 0000000034),
(60, '2023-12-23', 199, '{\"RecipientName\":\"s h\",\"Address\":{\"Area\":\"\",\"House\":\"\",\"Street\":\"\",\"Block\":0},\"Contact\":{\"MobileNumber\":\"+93554468648648\",\"Email\":\"s@h.com\"}}', NULL, 18, '{\"cardholderName\":\"sada\",\"encryptedCardNumber\":\"WOSP082TgwfSPRDe16NxPy\\/ORg1o6krWEvnHbAmrS+U=\",\"expirationDate\":\"12\\/55\",\"cvv\":\"1213\"}', NULL, 'paid', 0000000034);

-- --------------------------------------------------------

--
-- Table structure for table `product data`
--

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
(4, 'Product 4', 'Medicine', 0, '', '0000-00-00', 1, 0, 200, 4, NULL, 'p4.jpg', ''),
(5, 'Product 5', 'Medicine', 0, '', '0000-00-00', 3, 1, 100, 5, NULL, 'p1.jpg', ''),
(6, 'Product 6', 'Personal care', 0, '', '0000-00-00', 1, 0, 300, 6, NULL, 'p1.jpg', ''),
(7, 'Product 7', 'Medicine', 0, '', '0000-00-00', 66, 1, 22, 7, NULL, 'p2.jpg', ''),
(8, 'Product 8', 'Medicine', 0, '', '0000-00-00', 47, 1, 99, 8, NULL, 'p3.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `remember_me_tokens`
--

CREATE TABLE `remember_me_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `expiration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sorder data`
--

CREATE TABLE `sorder data` (
  `OrderID` int(9) NOT NULL,
  `UserID` int(9) DEFAULT NULL,
  `TotalPrice` double DEFAULT NULL,
  `PaymentMethod` varchar(20) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `CreditCardInfo` varchar(255) DEFAULT NULL,
  `AccBalance` int(20) DEFAULT NULL,
  `MembershipPoints` int(10) DEFAULT NULL,
  `PaymentID` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sordered item`
--

CREATE TABLE `sordered item` (
  `OrderID` int(9) NOT NULL,
  `ProductID` int(9) NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `TotalPrice` double DEFAULT NULL,
  `TotalPoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spayment database`
--

CREATE TABLE `spayment database` (
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

-- --------------------------------------------------------

--
-- Table structure for table `sproduct data`
--

CREATE TABLE `sproduct data` (
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

-- --------------------------------------------------------

--
-- Table structure for table `staff data`
--

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
(26, 0, 'kjj', 'hkj', '', '0000-00-00', '', '+783456789', 'jhgfudyd@xc.dx', '', '', '', 0, NULL, '', 000000027);

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

--
-- Dumping data for table `supplier data`
--

INSERT INTO `supplier data` (`SupplierID`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `ProfilePic`, `UserID`) VALUES
(24, 'x', 'cc', 677654, 'dddddddd@ss.xa', NULL, 000000028);

-- --------------------------------------------------------

--
-- Table structure for table `sview cart`
--

CREATE TABLE `sview cart` (
  `CartID` int(9) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductID` int(9) NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `Total` double DEFAULT NULL,
  `AddedDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swish list data`
--

CREATE TABLE `swish list data` (
  `WID` int(9) NOT NULL,
  `ProductID` int(9) DEFAULT NULL,
  `UserID` int(9) DEFAULT NULL
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
(000000033, 'Sayed', '', 'A123456789a', 'Admin'),
(000000034, 'sh', 's@h.com', '$2y$10$GzAAq3FF.xHX9D8xRkgnXeW8kSmCA0x7ZSJNE/qvVInn7QqAiQ8F.', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `view cart`
--

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
(96, 34, 5, 2, 200, '2023-12-23'),
(97, 34, 8, 1, 99, '2023-12-23'),
(98, 34, 7, 3, 60, '2023-12-23');

-- --------------------------------------------------------

--
-- Table structure for table `wish list data`
--

CREATE TABLE `wish list data` (
  `WID` int(9) NOT NULL,
  `ProductID` int(9) DEFAULT NULL,
  `UserID` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wish list data`
--

INSERT INTO `wish list data` (`WID`, `ProductID`, `UserID`) VALUES
(46, 0, NULL),
(47, 0, NULL),
(48, 0, NULL),
(49, 0, NULL),
(50, 0, NULL),
(51, 0, NULL),
(52, 0, NULL),
(53, 0, NULL),
(54, 0, NULL),
(55, 0, NULL),
(56, 4, 34),
(57, 0, NULL),
(58, 0, NULL),
(59, 0, NULL),
(60, 0, NULL),
(61, 0, NULL),
(62, 0, NULL),
(63, 0, NULL),
(64, 0, NULL),
(65, 0, NULL),
(66, 0, NULL),
(67, 0, NULL),
(68, 0, NULL),
(69, 0, NULL),
(70, 5, 34);

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
-- Indexes for table `sorder data`
--
ALTER TABLE `sorder data`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `PaymentID` (`PaymentID`);

--
-- Indexes for table `sordered item`
--
ALTER TABLE `sordered item`
  ADD PRIMARY KEY (`OrderID`,`ProductID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `spayment database`
--
ALTER TABLE `spayment database`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `sproduct data`
--
ALTER TABLE `sproduct data`
  ADD PRIMARY KEY (`ProductID`);

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
-- Indexes for table `sview cart`
--
ALTER TABLE `sview cart`
  ADD PRIMARY KEY (`CartID`,`ProductID`,`UserID`) USING BTREE,
  ADD KEY `ProductID` (`ProductID`,`UserID`) USING BTREE;

--
-- Indexes for table `swish list data`
--
ALTER TABLE `swish list data`
  ADD PRIMARY KEY (`WID`),
  ADD KEY `ProductID` (`ProductID`),
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
  MODIFY `CustomerID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `offers data`
--
ALTER TABLE `offers data`
  MODIFY `OfferID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `order data`
--
ALTER TABLE `order data`
  MODIFY `OrderID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `payment database`
--
ALTER TABLE `payment database`
  MODIFY `PaymentID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `product data`
--
ALTER TABLE `product data`
  MODIFY `ProductID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `remember_me_tokens`
--
ALTER TABLE `remember_me_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sorder data`
--
ALTER TABLE `sorder data`
  MODIFY `OrderID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spayment database`
--
ALTER TABLE `spayment database`
  MODIFY `PaymentID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sproduct data`
--
ALTER TABLE `sproduct data`
  MODIFY `ProductID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff data`
--
ALTER TABLE `staff data`
  MODIFY `StaffID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `supplier data`
--
ALTER TABLE `supplier data`
  MODIFY `SupplierID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `sview cart`
--
ALTER TABLE `sview cart`
  MODIFY `CartID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `swish list data`
--
ALTER TABLE `swish list data`
  MODIFY `WID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user data`
--
ALTER TABLE `user data`
  MODIFY `UserID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `view cart`
--
ALTER TABLE `view cart`
  MODIFY `CartID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `wish list data`
--
ALTER TABLE `wish list data`
  MODIFY `WID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

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
