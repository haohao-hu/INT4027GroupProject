-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2017 at 07:28 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `int4027project`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(4) UNSIGNED NOT NULL,
  `category_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(7) UNSIGNED NOT NULL,
  `customer_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `customer_address` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `customer_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `customer_password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_address`, `customer_email`, `customer_password`, `admin`) VALUES
(1, 'Mary', 'Guangzhou', 'mary@example.com', '123456', 0),
(2, 'John', 'Hong Kong', 'john@example.com', '123456', 0),
(3, 'Jimmy', 'Guangzhou, Baiyun District', 'jimmy@hotmail.com', '123456', 0),
(4, 'Jimmy Hu', 'Guangzhou', 'example-4@example.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0),
(6, 'Sherry', 'Hong Kong', 'example-5@example.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_favourite_category`
--

CREATE TABLE `customer_favourite_category` (
  `customerId` int(7) UNSIGNED NOT NULL,
  `categoryId` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_favourite_dish`
--

CREATE TABLE `customer_favourite_dish` (
  `customerId` int(7) UNSIGNED NOT NULL,
  `dishId` int(7) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

CREATE TABLE `dish` (
  `dish_id` int(7) UNSIGNED NOT NULL,
  `dish_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `price` float(6,2) NOT NULL,
  `restaurantId` int(7) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `purchaseId` int(11) UNSIGNED NOT NULL,
  `dishId` int(7) UNSIGNED NOT NULL,
  `quantity` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) UNSIGNED NOT NULL,
  `purchase_date_n_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_cost` float(8,2) UNSIGNED NOT NULL,
  `customerId` int(7) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `reply_id` int(11) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `reviewId` int(9) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) UNSIGNED NOT NULL,
  `customerId` int(7) UNSIGNED NOT NULL,
  `restaurantId` int(7) UNSIGNED NOT NULL,
  `number_of_customers` int(3) UNSIGNED NOT NULL,
  `r_date_and_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `restaurant_id` int(7) UNSIGNED NOT NULL,
  `restaurant_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `district` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `e-mail` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `taste` decimal(3,1) DEFAULT NULL,
  `environment` decimal(3,1) DEFAULT NULL,
  `service` decimal(3,1) DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_belongs_to_category`
--

CREATE TABLE `restaurant_belongs_to_category` (
  `restaurantId` int(7) UNSIGNED NOT NULL,
  `categoryId` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(10) UNSIGNED NOT NULL,
  `taste` decimal(3,1) NOT NULL,
  `environment` decimal(3,1) NOT NULL,
  `service` decimal(3,1) NOT NULL,
  `text` text NOT NULL,
  `customerId` int(7) UNSIGNED NOT NULL,
  `restaurantId` int(7) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `CUSTOMEREMAIL` (`customer_email`),
  ADD UNIQUE KEY `customer_name` (`customer_name`),
  ADD KEY `customer_name_2` (`customer_name`);

--
-- Indexes for table `customer_favourite_category`
--
ALTER TABLE `customer_favourite_category`
  ADD KEY `customerId` (`customerId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `customer_favourite_dish`
--
ALTER TABLE `customer_favourite_dish`
  ADD KEY `customerId` (`customerId`),
  ADD KEY `dishId` (`dishId`);

--
-- Indexes for table `dish`
--
ALTER TABLE `dish`
  ADD PRIMARY KEY (`dish_id`),
  ADD KEY `restaurantId` (`restaurantId`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD KEY `purchaseId` (`purchaseId`),
  ADD KEY `dishId` (`dishId`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `reviewId` (`reviewId`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `customerId` (`customerId`),
  ADD KEY `restaurantId` (`restaurantId`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`restaurant_id`),
  ADD UNIQUE KEY `EMAIL` (`e-mail`),
  ADD UNIQUE KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `restaurant_id_2` (`restaurant_id`);

--
-- Indexes for table `restaurant_belongs_to_category`
--
ALTER TABLE `restaurant_belongs_to_category`
  ADD KEY `categoryId` (`categoryId`),
  ADD KEY `restaurantId` (`restaurantId`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `customerId` (`customerId`),
  ADD KEY `restaurantId` (`restaurantId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `dish`
--
ALTER TABLE `dish`
  MODIFY `dish_id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `reply_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `restaurant_id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_favourite_category`
--
ALTER TABLE `customer_favourite_category`
  ADD CONSTRAINT `customer_favourite_category_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `customer_favourite_category_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `customer_favourite_dish`
--
ALTER TABLE `customer_favourite_dish`
  ADD CONSTRAINT `customer_favourite_dish_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `customer_favourite_dish_ibfk_2` FOREIGN KEY (`dishId`) REFERENCES `dish` (`dish_id`);

--
-- Constraints for table `dish`
--
ALTER TABLE `dish`
  ADD CONSTRAINT `dish_ibfk_1` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`restaurant_id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`purchaseId`) REFERENCES `purchase` (`purchase_id`),
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`dishId`) REFERENCES `dish` (`dish_id`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`reviewId`) REFERENCES `review` (`review_id`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`restaurant_id`);

--
-- Constraints for table `restaurant_belongs_to_category`
--
ALTER TABLE `restaurant_belongs_to_category`
  ADD CONSTRAINT `restaurant_belongs_to_category_ibfk_1` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`restaurant_id`),
  ADD CONSTRAINT `restaurant_belongs_to_category_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`restaurant_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
