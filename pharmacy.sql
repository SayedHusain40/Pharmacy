-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2023 at 08:36 PM
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

--
-- Dumping data for table `order data`
--

INSERT INTO `order data` (`OrderID`, `UserID`, `ProductID`, `TotalPrice`, `PaymentMethod`, `Status`, `OrderDate`, `CreditCardInfo`, `AccBalance`, `MembershipPoints`, `PaymentID`) VALUES
(000000000, 000000003, 000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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

--
-- Dumping data for table `product data`
--

INSERT INTO `product data` (`ProductID`, `Name`, `Type`, `RequiresPrescription`, `Description`, `ExpireDate`, `Quantity`, `Availability`, `Price`, `Brand`, `Photo`, `Alternate`) VALUES
(000000001, 'Product 1', '', 0, '', '0000-00-00', 0, 5, 100, NULL, 'Product1.jpeg', ''),
(000000002, 'Product 2', '', 0, '', '0000-00-00', 60, 0, 10, NULL, 'Product1.jpeg', ''),
(000000003, 'Product 3', '', 0, '', '0000-00-00', 50, 0, 20, NULL, 'Product1.jpeg', '');

-- --------------------------------------------------------

--
-- Table structure for table `staff data`
--

CREATE TABLE `staff data` (
  `StaffID` int(9) UNSIGNED ZEROFILL NOT NULL,
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

--
-- Dumping data for table `staff data`
--

INSERT INTO `staff data` (`StaffID`, `CPR`, `FirstName`, `LastName`, `Gender`, `DOB`, `AcademicDegree`, `MobileNumber`, `Email`, `Address`, `ProfilePic`, `EmployeePosition`, `UserID`) VALUES
(000000026, 000000000, 'kjj', 'hkj', '', '0000-00-00', '', '+783456789', 'jhgfudyd@xc.dx', '', NULL, '', 000000027);

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
(000000026, 'wsdfghjk', 'jhgfuyd@xc.dx', '$2y$10$WNhHcbR16vcQhZStdaE.kenb0GCywFdBEN6x3SLg.1yjoo3LIUWL.', 'Staff'),
(000000027, 'wsdfghjkdd', 'jhgfudyd@xc.dx', '$2y$10$rCoG33E96zBqCDhdTBQbF.z3ZLiMkJvem9lrFUqdZosdHFDWf0Oj2', 'Staff'),
(000000028, 'dcfd', 'dddddddd@ss.xa', '$2y$10$KBo/TRCIvYjj9Jqa/stv8.7/GMZ81A8WMSOCsZ1uFoJ7IyTLiE7LO', 'Supplier');

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

--
-- Dumping data for table `view cart`
--

INSERT INTO `view cart` (`CartID`, `OrderID`, `ProductID`, `Qty`, `Total`, `AddedDate`) VALUES
(000000006, 000000000, 000000001, 3, 300, '2023-12-03'),
(000000007, 000000000, 000000002, 5, 50, '2023-12-03');

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
  MODIFY `CustomerID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `offers data`
--
ALTER TABLE `offers data`
  MODIFY `OfferID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order data`
--
ALTER TABLE `order data`
  MODIFY `OrderID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment database`
--
ALTER TABLE `payment database`
  MODIFY `PaymentID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product data`
--
ALTER TABLE `product data`
  MODIFY `ProductID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff data`
--
ALTER TABLE `staff data`
  MODIFY `StaffID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `supplier data`
--
ALTER TABLE `supplier data`
  MODIFY `SupplierID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user data`
--
ALTER TABLE `user data`
  MODIFY `UserID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `view cart`
--
ALTER TABLE `view cart`
  MODIFY `CartID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wish list data`
--
ALTER TABLE `wish list data`
  MODIFY `WID` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

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
