-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2017 at 01:22 PM
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

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(6, 'British'),
(1, 'Chinese'),
(5, 'coffee'),
(12, 'Curry'),
(2, 'French'),
(9, 'German'),
(3, 'Italian'),
(4, 'noodle'),
(10, 'Russian'),
(11, 'Spanish'),
(8, 'US traditional'),
(7, 'Vietnamese');

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
(4, 'Jimmy Hu', 'Guangzhou', 'example-4@example.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0),
(6, 'Sherry', 'Hong Kong', 'example-5@example.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1),
(8, 'Johnson', 'Guangzhou', 'johnson@example.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0),
(9, 'Jackson', '10 Lo Ping Road', 'example-6@example.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_favourite_category`
--

CREATE TABLE `customer_favourite_category` (
  `customerId` int(7) UNSIGNED NOT NULL,
  `categoryId` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_favourite_category`
--

INSERT INTO `customer_favourite_category` (`customerId`, `categoryId`) VALUES
(4, 3),
(8, 6),
(8, 1),
(8, 12),
(6, 1),
(6, 8),
(9, 5),
(9, 12),
(9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `customer_favourite_dish`
--

CREATE TABLE `customer_favourite_dish` (
  `customerId` int(7) UNSIGNED NOT NULL,
  `dishId` int(7) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_favourite_dish`
--

INSERT INTO `customer_favourite_dish` (`customerId`, `dishId`) VALUES
(9, 1),
(9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

CREATE TABLE `dish` (
  `dish_id` int(7) UNSIGNED NOT NULL,
  `dish_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `price` float(6,2) NOT NULL,
  `image_name` varchar(100) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `restaurantId` int(7) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dish`
--

INSERT INTO `dish` (`dish_id`, `dish_name`, `price`, `image_name`, `description`, `restaurantId`) VALUES
(1, 'Fried Chicken', 15.00, 'fried_chicken.jpg', NULL, 1),
(3, 'Fried fish', 70.00, 'fried_fish.jpg', NULL, 2),
(4, 'Kebab', 50.00, 'kebab.png', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `purchaseId` int(11) UNSIGNED NOT NULL,
  `dishId` int(7) UNSIGNED NOT NULL,
  `quantity` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`purchaseId`, `dishId`, `quantity`) VALUES
(1, 1, 10),
(2, 1, 10);

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

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `purchase_date_n_time`, `total_cost`, `customerId`) VALUES
(1, '2017-04-13 12:01:14', 150.00, 4),
(2, '2017-04-13 14:14:36', 150.00, 4);

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `reply_id` int(11) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `reviewId` int(9) UNSIGNED NOT NULL,
  `reply_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`reply_id`, `text`, `reviewId`, `reply_time`) VALUES
(12, 'Thanks for commenting', 6, '2017-04-16 20:30:34');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) UNSIGNED NOT NULL,
  `customerId` int(7) UNSIGNED NOT NULL,
  `restaurantId` int(7) UNSIGNED NOT NULL,
  `number_of_customers` int(3) UNSIGNED NOT NULL,
  `r_date_and_time` datetime NOT NULL,
  `Confirmed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `customerId`, `restaurantId`, `number_of_customers`, `r_date_and_time`, `Confirmed`) VALUES
(6, 6, 2, 5, '2017-04-17 20:30:00', 1),
(7, 6, 3, 6, '2017-04-17 18:45:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `restaurant_id` int(7) UNSIGNED NOT NULL,
  `restaurant_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `district` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `taste` decimal(3,1) DEFAULT NULL,
  `environment` decimal(3,1) DEFAULT NULL,
  `service` decimal(3,1) DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`restaurant_id`, `restaurant_name`, `address`, `district`, `email`, `taste`, `environment`, `service`, `password`) VALUES
(1, 'cafe', 'lo ping 10', 'Tai Po', 'example@example.com', '2.2', '2.2', '3.0', '7c4a8d09ca3762af61e59520943dc26494f8941b'),
(2, 'Ccan', '10 Lo Ping', 'Tai Po', 'ccan@example.com', '2.4', '3.5', '3.4', '7c4a8d09ca3762af61e59520943dc26494f8941b'),
(3, 'uuu', 'Guangzhou', 'Sai Kung', 'uuu@example.com', NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_belongs_to_category`
--

CREATE TABLE `restaurant_belongs_to_category` (
  `restaurantId` int(7) UNSIGNED NOT NULL,
  `categoryId` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant_belongs_to_category`
--

INSERT INTO `restaurant_belongs_to_category` (`restaurantId`, `categoryId`) VALUES
(1, 1),
(1, 6),
(2, 3),
(2, 5),
(3, 6),
(3, 1),
(3, 4);

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
  `restaurantId` int(7) UNSIGNED NOT NULL,
  `post_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `taste`, `environment`, `service`, `text`, `customerId`, `restaurantId`, `post_time`) VALUES
(4, '2.5', '2.0', '3.0', 'Good', 6, 2, '2017-04-15 16:17:59'),
(5, '1.5', '3.5', '4.0', 'Fantastic', 6, 2, '2017-04-15 16:17:58'),
(6, '4.0', '4.0', '4.5', 'I have gone there numerous times for their bakery alone.  Their baked goods (especially the BBQ pork buns) are delicious, and very reasonably priced.  Get there early in the day, in my experience they have run out!  Oh yeah, they also have a nice selection of asian groceries.', 6, 2, '2017-04-15 19:58:48'),
(9, '2.5', '3.0', '3.0', 'Good', 4, 1, '2017-04-17 17:43:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

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
  ADD UNIQUE KEY `image_name` (`image_name`),
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
  ADD UNIQUE KEY `EMAIL` (`email`),
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
  MODIFY `category_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `dish`
--
ALTER TABLE `dish`
  MODIFY `dish_id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `reply_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `restaurant_id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_favourite_category`
--
ALTER TABLE `customer_favourite_category`
  ADD CONSTRAINT `customer_favourite_category_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_favourite_category_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_favourite_dish`
--
ALTER TABLE `customer_favourite_dish`
  ADD CONSTRAINT `customer_favourite_dish_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_favourite_dish_ibfk_2` FOREIGN KEY (`dishId`) REFERENCES `dish` (`dish_id`) ON DELETE CASCADE;

--
-- Constraints for table `dish`
--
ALTER TABLE `dish`
  ADD CONSTRAINT `dish_ibfk_1` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`purchaseId`) REFERENCES `purchase` (`purchase_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`dishId`) REFERENCES `dish` (`dish_id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`reviewId`) REFERENCES `review` (`review_id`) ON DELETE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE CASCADE;

--
-- Constraints for table `restaurant_belongs_to_category`
--
ALTER TABLE `restaurant_belongs_to_category`
  ADD CONSTRAINT `restaurant_belongs_to_category_ibfk_1` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `restaurant_belongs_to_category_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`restaurantId`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
