-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2025 at 07:55 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kiosk`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `adminID` bigint(255) NOT NULL,
  `adminAge` int(100) NOT NULL,
  `adminEmail` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `membershipID` bigint(255) NOT NULL,
  `adminImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`adminID`, `adminAge`, `adminEmail`, `userName`, `membershipID`, `adminImage`) VALUES
(1, 23, 'Jimmy_2001@gmail.com', 'Jimmy', 1, 'uploads/adminImage.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `daily_menu`
--

CREATE TABLE `daily_menu` (
  `dailyMenuID` bigint(255) NOT NULL,
  `availabilityStatus` varchar(255) NOT NULL,
  `remainingQuantity` int(100) NOT NULL,
  `foodVendorID` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_menu`
--

INSERT INTO `daily_menu` (`dailyMenuID`, `availabilityStatus`, `remainingQuantity`, `foodVendorID`) VALUES
(2, 'Available', 100, 1),
(3, 'Limited', 12, 1),
(4, 'Available', 52, 1),
(12, 'Available', 100, 1),
(13, 'Available', 100, 19);

-- --------------------------------------------------------

--
-- Table structure for table `food_vendor`
--

CREATE TABLE `food_vendor` (
  `foodVendorID` bigint(255) NOT NULL,
  `foodVendorAge` int(100) NOT NULL,
  `foodVendorEmail` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `adminApprove` varchar(255) NOT NULL,
  `foodVendorImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_vendor`
--

INSERT INTO `food_vendor` (`foodVendorID`, `foodVendorAge`, `foodVendorEmail`, `userName`, `adminApprove`, `foodVendorImage`) VALUES
(1, 23, 'Deen_2001@gmail.com', 'Deen', 'Yes', ''),
(19, 24, 'nicholastankaejer2001@gmail.com', 'Koko', 'Yes', '');

-- --------------------------------------------------------

--
-- Table structure for table `general_user`
--

CREATE TABLE `general_user` (
  `gUserID` bigint(255) NOT NULL,
  `gUserAge` int(100) NOT NULL,
  `gUserEmail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_user`
--

INSERT INTO `general_user` (`gUserID`, `gUserAge`, `gUserEmail`) VALUES
(1, 21, 'Limin_2001@gmail.com'),
(87, 23, 'tanlimin0916@gmail.com'),
(88, 23, 'ascasac@sdvsvd'),
(89, 12, 'tanlimin0916@gmail.com'),
(90, 22, 'tanlimin0916@gmail.com'),
(91, 21, 'nicholastan_2001@hotmail.com'),
(92, 22, 'cd21062@student.ump.edu.my');

-- --------------------------------------------------------

--
-- Table structure for table `in_store_sales`
--

CREATE TABLE `in_store_sales` (
  `inStoreSalesID` bigint(255) NOT NULL,
  `totalSales` decimal(65,0) NOT NULL,
  `foodVendorID` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `in_store_sales`
--

INSERT INTO `in_store_sales` (`inStoreSalesID`, `totalSales`, `foodVendorID`) VALUES
(1, '7', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kiosk`
--

CREATE TABLE `kiosk` (
  `kioskID` bigint(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `operationStatus` varchar(100) NOT NULL,
  `foodVendorID` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kiosk`
--

INSERT INTO `kiosk` (`kioskID`, `location`, `operationStatus`, `foodVendorID`) VALUES
(1, 'Fakulti Komputer (Cafeteria)', 'Open', 1);

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `membershipID` bigint(255) NOT NULL,
  `membershipPoint` int(100) NOT NULL,
  `membershipQR` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`membershipID`, `membershipPoint`, `membershipQR`) VALUES
(1, 1000, 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=1000'),
(2, 500, 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=500'),
(142, 0, ''),
(143, 0, ''),
(144, 10, 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=10'),
(145, 0, ''),
(146, 10, 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=10'),
(147, 0, ''),
(148, 0, ''),
(149, 10, 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=10');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menuID` bigint(255) NOT NULL,
  `menuName` varchar(255) NOT NULL,
  `menuPrice` decimal(65,0) NOT NULL,
  `menuQR` varchar(255) NOT NULL,
  `dailyMenuID` bigint(255) NOT NULL,
  `adminID` bigint(255) DEFAULT NULL,
  `kioskID` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menuID`, `menuName`, `menuPrice`, `menuQR`, `dailyMenuID`, `adminID`, `kioskID`) VALUES
(2, 'Cheeseburger', '10', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=CheeseBurger      \r\n\r\n', 2, NULL, 1),
(3, 'Nasi Lemak Ayam Goreng', '8', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=NasiLemakAyamGoreng     \r\n\r\n', 3, 1, 1),
(4, 'Fried Rice', '7', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=FriedRice     \r\n\r\n', 4, 1, 1),
(12, 'Ayam Gunting', '10', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Ayam+Gunting', 12, 1, 1),
(13, 'Burger', '7', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Burger', 13, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `orderID` bigint(255) NOT NULL,
  `orderDate` datetime(6) NOT NULL,
  `orderStatus` varchar(255) NOT NULL,
  `totalAmount` decimal(65,0) NOT NULL,
  `orderQR` varchar(255) NOT NULL,
  `gUserID` bigint(255) DEFAULT NULL,
  `adminID` bigint(255) DEFAULT NULL,
  `rUserID` bigint(255) DEFAULT NULL,
  `foodVendorID` bigint(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`orderID`, `orderDate`, `orderStatus`, `totalAmount`, `orderQR`, `gUserID`, `adminID`, `rUserID`, `foodVendorID`) VALUES
(1, '2023-12-31 16:36:01.000000', 'Orderd', '5', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=5 ', 1, NULL, NULL, NULL),
(2, '2023-12-30 15:37:27.423000', 'Preparing', '10', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=10 \r\n\r\n', NULL, 1, NULL, NULL),
(3, '2023-12-29 00:00:00.000000', 'Completed', '8', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=8 ', NULL, NULL, 1, NULL),
(4, '2023-12-28 00:00:00.000000', 'Preparing', '7', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=7 ', NULL, NULL, NULL, 1),
(5, '2024-01-15 05:17:34.000000', 'Ordered', '16', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_', NULL, NULL, 1, NULL),
(6, '2024-01-15 05:26:27.000000', 'Ordered', '7', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID__UserID_87', 87, NULL, NULL, NULL),
(7, '2024-01-15 05:29:00.000000', 'Ordered', '18', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_', NULL, NULL, 1, NULL),
(8, '2024-01-15 05:30:27.000000', 'Ordered', '28', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_', NULL, NULL, 1, NULL),
(9, '2024-01-15 05:31:04.000000', 'Ordered', '20', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_', NULL, NULL, 1, NULL),
(10, '2024-01-15 07:02:52.000000', 'Ordered', '40', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID__UserID_91', 91, NULL, NULL, NULL),
(11, '2024-01-15 07:24:24.000000', 'Ordered', '10', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_', NULL, NULL, 1, NULL),
(12, '2024-01-15 07:26:08.000000', 'Ordered', '10', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID__UserID_92', 92, NULL, NULL, NULL),
(13, '2024-01-17 10:47:41.000000', 'Ordered', '10', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_', 1, NULL, NULL, NULL),
(14, '2024-01-17 11:26:29.000000', 'Ordered', '8', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_', 1, NULL, NULL, NULL),
(15, '2024-01-17 11:39:00.000000', 'Ordered', '10', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_', 1, NULL, NULL, NULL),
(16, '2024-01-17 11:47:55.000000', 'Ordered', '7', 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=OrderID_', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `orderItemID` bigint(255) NOT NULL,
  `quantityOrder` int(100) NOT NULL,
  `totalPrice` decimal(65,0) NOT NULL,
  `menuID` bigint(255) NOT NULL,
  `inStoreSalesID` bigint(255) DEFAULT NULL,
  `orderID` bigint(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`orderItemID`, `quantityOrder`, `totalPrice`, `menuID`, `inStoreSalesID`, `orderID`) VALUES
(2, 1, '10', 2, NULL, 2),
(3, 1, '8', 3, NULL, 3),
(4, 1, '7', 4, NULL, 4),
(5, 1, '7', 4, 1, NULL),
(6, 2, '16', 3, NULL, 5),
(7, 1, '7', 4, NULL, 6),
(8, 1, '8', 3, NULL, 7),
(9, 1, '10', 2, NULL, 7),
(10, 1, '8', 3, NULL, 8),
(11, 2, '20', 2, NULL, 8),
(12, 2, '20', 2, NULL, 9),
(13, 4, '40', 2, NULL, 10),
(14, 1, '10', 2, NULL, 11),
(15, 1, '10', 2, NULL, 12),
(16, 1, '10', 2, NULL, 13),
(17, 1, '8', 3, NULL, 14),
(18, 1, '10', 2, NULL, 15),
(19, 1, '7', 4, NULL, 16);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` bigint(255) NOT NULL,
  `paymentType` varchar(255) NOT NULL,
  `orderID` bigint(255) DEFAULT NULL,
  `inStoreSalesID` bigint(255) DEFAULT NULL,
  `membersipID` bigint(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentID`, `paymentType`, `orderID`, `inStoreSalesID`, `membersipID`) VALUES
(1, 'Kiosk Membership Point', 1, NULL, 1),
(2, 'Kiosk Membership Point', 2, NULL, 2),
(3, 'Cash', 3, NULL, NULL),
(4, 'Cash', 4, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `registered_user`
--

CREATE TABLE `registered_user` (
  `rUserID` bigint(255) NOT NULL,
  `rUserAge` int(100) NOT NULL,
  `rUserEmail` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `membershipID` bigint(255) NOT NULL,
  `rUserImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_user`
--

INSERT INTO `registered_user` (`rUserID`, `rUserAge`, `rUserEmail`, `userName`, `membershipID`, `rUserImage`) VALUES
(1, 22, 'NicholasTan_2001@gmail.com', 'NicholasTan', 2, 'uploads/rUserImage.jpeg'),
(23, 23, 'nicholastan_2001@hotmail.com', 'Nick', 146, ''),
(24, 22, 'nicholastan_2001@hotmail.com', 'Nich', 147, ''),
(25, 21, 'nick2001@hotmail.com', 'lol', 149, '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userName` varchar(255) NOT NULL,
  `userRole` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userName`, `userRole`, `userPassword`) VALUES
('', '', ''),
('Deen', 'foodVendor', '56789'),
('Jimmy', 'admin', '54321'),
('Koko', 'foodVendor', '12345'),
('lol', 'registeredUser', '123456789'),
('Nich', 'registeredUser', '12345'),
('NicholasTan', 'registeredUser', '12345'),
('Nick', 'registeredUser', '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`adminID`),
  ADD KEY `Text` (`userName`),
  ADD KEY `Test2` (`membershipID`);

--
-- Indexes for table `daily_menu`
--
ALTER TABLE `daily_menu`
  ADD PRIMARY KEY (`dailyMenuID`),
  ADD KEY `Test5` (`foodVendorID`);

--
-- Indexes for table `food_vendor`
--
ALTER TABLE `food_vendor`
  ADD PRIMARY KEY (`foodVendorID`),
  ADD KEY `test3` (`userName`);

--
-- Indexes for table `general_user`
--
ALTER TABLE `general_user`
  ADD PRIMARY KEY (`gUserID`);

--
-- Indexes for table `in_store_sales`
--
ALTER TABLE `in_store_sales`
  ADD PRIMARY KEY (`inStoreSalesID`),
  ADD KEY `Test6` (`foodVendorID`);

--
-- Indexes for table `kiosk`
--
ALTER TABLE `kiosk`
  ADD PRIMARY KEY (`kioskID`),
  ADD KEY `Test7` (`foodVendorID`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`membershipID`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menuID`),
  ADD KEY `Test8` (`dailyMenuID`),
  ADD KEY `Test9` (`adminID`),
  ADD KEY `Test10` (`kioskID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `Test11` (`adminID`),
  ADD KEY `Test12` (`foodVendorID`),
  ADD KEY `Test13` (`gUserID`),
  ADD KEY `Test14` (`rUserID`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`orderItemID`),
  ADD KEY `Text15` (`inStoreSalesID`),
  ADD KEY `Text16` (`menuID`),
  ADD KEY `Text17` (`orderID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `Text18` (`inStoreSalesID`),
  ADD KEY `Text19` (`membersipID`),
  ADD KEY `Text20` (`orderID`);

--
-- Indexes for table `registered_user`
--
ALTER TABLE `registered_user`
  ADD PRIMARY KEY (`rUserID`),
  ADD KEY `Test` (`userName`),
  ADD KEY `Test1` (`membershipID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `adminID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `daily_menu`
--
ALTER TABLE `daily_menu`
  MODIFY `dailyMenuID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `food_vendor`
--
ALTER TABLE `food_vendor`
  MODIFY `foodVendorID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `general_user`
--
ALTER TABLE `general_user`
  MODIFY `gUserID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `in_store_sales`
--
ALTER TABLE `in_store_sales`
  MODIFY `inStoreSalesID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kiosk`
--
ALTER TABLE `kiosk`
  MODIFY `kioskID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `membershipID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menuID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `orderID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `orderItemID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `registered_user`
--
ALTER TABLE `registered_user`
  MODIFY `rUserID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `Test2` FOREIGN KEY (`membershipID`) REFERENCES `membership` (`membershipID`),
  ADD CONSTRAINT `Text` FOREIGN KEY (`userName`) REFERENCES `user` (`userName`);

--
-- Constraints for table `daily_menu`
--
ALTER TABLE `daily_menu`
  ADD CONSTRAINT `Test5` FOREIGN KEY (`foodVendorID`) REFERENCES `food_vendor` (`foodVendorID`);

--
-- Constraints for table `food_vendor`
--
ALTER TABLE `food_vendor`
  ADD CONSTRAINT `test3` FOREIGN KEY (`userName`) REFERENCES `user` (`userName`);

--
-- Constraints for table `in_store_sales`
--
ALTER TABLE `in_store_sales`
  ADD CONSTRAINT `Test6` FOREIGN KEY (`foodVendorID`) REFERENCES `food_vendor` (`foodVendorID`);

--
-- Constraints for table `kiosk`
--
ALTER TABLE `kiosk`
  ADD CONSTRAINT `Test7` FOREIGN KEY (`foodVendorID`) REFERENCES `food_vendor` (`foodVendorID`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `Test10` FOREIGN KEY (`kioskID`) REFERENCES `kiosk` (`kioskID`),
  ADD CONSTRAINT `Test8` FOREIGN KEY (`dailyMenuID`) REFERENCES `daily_menu` (`dailyMenuID`),
  ADD CONSTRAINT `Test9` FOREIGN KEY (`adminID`) REFERENCES `administrator` (`adminID`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `Test11` FOREIGN KEY (`adminID`) REFERENCES `administrator` (`adminID`),
  ADD CONSTRAINT `Test12` FOREIGN KEY (`foodVendorID`) REFERENCES `food_vendor` (`foodVendorID`),
  ADD CONSTRAINT `Test13` FOREIGN KEY (`gUserID`) REFERENCES `general_user` (`gUserID`),
  ADD CONSTRAINT `Test14` FOREIGN KEY (`rUserID`) REFERENCES `registered_user` (`rUserID`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `Text15` FOREIGN KEY (`inStoreSalesID`) REFERENCES `in_store_sales` (`inStoreSalesID`),
  ADD CONSTRAINT `Text16` FOREIGN KEY (`menuID`) REFERENCES `menu` (`menuID`),
  ADD CONSTRAINT `Text17` FOREIGN KEY (`orderID`) REFERENCES `order` (`orderID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `Text18` FOREIGN KEY (`inStoreSalesID`) REFERENCES `in_store_sales` (`inStoreSalesID`),
  ADD CONSTRAINT `Text19` FOREIGN KEY (`membersipID`) REFERENCES `membership` (`membershipID`),
  ADD CONSTRAINT `Text20` FOREIGN KEY (`orderID`) REFERENCES `order` (`orderID`);

--
-- Constraints for table `registered_user`
--
ALTER TABLE `registered_user`
  ADD CONSTRAINT `Test` FOREIGN KEY (`userName`) REFERENCES `user` (`userName`),
  ADD CONSTRAINT `Test1` FOREIGN KEY (`membershipID`) REFERENCES `membership` (`membershipID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
