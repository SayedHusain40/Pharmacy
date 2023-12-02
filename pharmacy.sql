-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2023 at 02:04 PM
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
CREATE DATABASE IF NOT EXISTS `pharmacy` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pharmacy`;

-- --------------------------------------------------------

--
-- Table structure for table `customer data`
--

CREATE TABLE IF NOT EXISTS `customer data` (
  `CustomerID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
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
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  PRIMARY KEY (`CustomerID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer data`
--

INSERT INTO `customer data` (`CustomerID`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `Area`, `House`, `Street`, `Block`, `DOB`, `CreditCardInfo`, `ShippingInfo`, `AccBalance`, `MembershipPoints`, `ProfilePic`, `UserID`) VALUES
(000000001, 'faisal', 'name', '+97323456783', '', '', '', '', 0, NULL, '', '', 0, 0, NULL, 000000003),
(000000002, 'at', 'table', '+9734567890', '', '', '', '', 0, NULL, '', '', 0, 0, NULL, 000000006),
(000000007, 'at', 'table', '+973456789876', '', '', '', '', 0, NULL, '', '', 0, 0, NULL, 000000007),
(000000008, 'Walaa', 'Salman', '+97336735550', 'walaa.e@icloud.com', '', '', '', 0, NULL, '', '', 0, 0, NULL, 000000008),
(000000010, 'gdjehgfjkeh', 'jhgjjh', '+86723456789', '201908@stu.uob.edu.bh', '', '', '', 0, NULL, '', '', 0, 0, NULL, 000000010),
(000000012, 'dfghjk', 'ry', '+973456789', '2023068@stu.uob.edu.bh', '', '', '', 0, NULL, '', '', 0, 0, NULL, 000000012),
(000000013, 'gfhjk', 'fghjkl', '+945234567890', 'fabh2001@hotmail.com', '', '', '', 0, NULL, '', '', 0, 0, NULL, 000000013),
(000000014, 'hdkjfj', 'dekiho', '+9453254566789', 'faqbh2001@hotmail.com', '', '', '', 0, NULL, '', '', 0, 0, NULL, 000000015),
(000000015, 'goird', 'sdjhgtf', '+7843543543', 'fndjdgdid@stu.com', '', '', '', 0, NULL, '', '', 0, 0, NULL, 000000022);

-- --------------------------------------------------------

--
-- Table structure for table `offers data`
--

CREATE TABLE IF NOT EXISTS `offers data` (
  `OfferID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `ProductID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
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

CREATE TABLE IF NOT EXISTS `order data` (
  `OrderID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  `ProductID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  `TotalPrice` double DEFAULT NULL,
  `PaymentMethod` varchar(20) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `CreditCardInfo` varchar(255) DEFAULT NULL,
  `AccBalance` int(20) DEFAULT NULL,
  `MembershipPoints` int(10) DEFAULT NULL,
  `PaymentID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `UserID` (`UserID`),
  KEY `ProductID` (`ProductID`),
  KEY `PaymentID` (`PaymentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ordered item`
--

CREATE TABLE IF NOT EXISTS `ordered item` (
  `OrderID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `ProductID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `Total` double DEFAULT NULL,
  PRIMARY KEY (`OrderID`,`ProductID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment database`
--

CREATE TABLE IF NOT EXISTS `payment database` (
  `PaymentID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `PayDate` date NOT NULL,
  `Total` decimal(4,3) NOT NULL,
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
-- Table structure for table `product data`
--

CREATE TABLE IF NOT EXISTS `product data` (
  `ProductID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
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
  `Alternate` varchar(255) NOT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff data`
--

CREATE TABLE IF NOT EXISTS `staff data` (
  `StaffID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
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
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  PRIMARY KEY (`StaffID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff data`
--

INSERT INTO `staff data` (`StaffID`, `CPR`, `FirstName`, `LastName`, `Gender`, `DOB`, `AcademicDegree`, `MobileNumber`, `Email`, `Address`, `ProfilePic`, `EmployeePosition`, `UserID`) VALUES
(000000026, 000000000, 'kjj', 'hkj', '', '0000-00-00', '', '+783456789', 'jhgfudyd@xc.dx', '', NULL, '', 000000027);

-- --------------------------------------------------------

--
-- Table structure for table `supplier data`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier data`
--

INSERT INTO `supplier data` (`SupplierID`, `FirstName`, `LastName`, `MobileNumber`, `Email`, `ProfilePic`, `UserID`) VALUES
(24, 'x', 'cc', 677654, 'dddddddd@ss.xa', NULL, 000000028);

-- --------------------------------------------------------

--
-- Table structure for table `user data`
--

CREATE TABLE IF NOT EXISTS `user data` (
  `UserID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Type` enum('Admin','Customer','Staff','Supplier') NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(000000026, 'wsdfghjk', 'jhgfuyd@xc.dx', '$2y$10$WNhHcbR16vcQhZStdaE.kenb0GCywFdBEN6x3SLg.1yjoo3LIUWL.', 'Staff'),
(000000027, 'wsdfghjkdd', 'jhgfudyd@xc.dx', '$2y$10$rCoG33E96zBqCDhdTBQbF.z3ZLiMkJvem9lrFUqdZosdHFDWf0Oj2', 'Staff'),
(000000028, 'dcfd', 'dddddddd@ss.xa', '$2y$10$KBo/TRCIvYjj9Jqa/stv8.7/GMZ81A8WMSOCsZ1uFoJ7IyTLiE7LO', 'Supplier');

-- --------------------------------------------------------

--
-- Table structure for table `view cart`
--

CREATE TABLE IF NOT EXISTS `view cart` (
  `CartID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `OrderID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `ProductID` int(9) UNSIGNED ZEROFILL NOT NULL,
  `Qty` int(10) DEFAULT NULL,
  `Total` double DEFAULT NULL,
  `AddedDate` date DEFAULT NULL,
  PRIMARY KEY (`CartID`,`OrderID`,`ProductID`),
  KEY `OrderID` (`OrderID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wish list data`
--

CREATE TABLE IF NOT EXISTS `wish list data` (
  `WID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `ProductID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
  `UserID` int(9) UNSIGNED ZEROFILL DEFAULT NULL,
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
