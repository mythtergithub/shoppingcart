-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2017 at 11:39 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoppingcart`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL,
  `log_desc` varchar(255) NOT NULL,
  `log_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_type` int(11) NOT NULL,
  `user_id` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `activity_type`
--

CREATE TABLE `activity_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_type`
--

INSERT INTO `activity_type` (`type_id`, `type_name`) VALUES
(1, 'USER_LOG'),
(2, 'PROFILE_CREATION'),
(3, 'PROFILE_UPDATE'),
(4, 'PROFILE_DEACTIVATION'),
(5, 'ITEM_UPLOAD'),
(6, 'ITEM_UPDATE'),
(7, 'CART_ADD'),
(8, 'CART_REMOVE'),
(9, 'CART_CHECKOUT'),
(10, 'ORDER_MAKE'),
(11, 'ORDER_INVOICE_GENERATE'),
(12, 'ORDER_STATUS_CHANGE'),
(13, 'REPORT_GENERATE'),
(14, 'CATEGORY_ADD'),
(15, 'CATEGORY_UPDATE');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_code` varchar(45) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_desc` varchar(255) NOT NULL,
  `directory` varchar(45) NOT NULL,
  `category_dateAdded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_dateModified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_code`, `category_name`, `category_desc`, `directory`, `category_dateAdded`, `category_dateModified`) VALUES
(1, 'MENW', 'Men''s Wear and Accessories', 'Latest trends for men''s wear and accessories', 'MEN', '2017-11-10 18:37:22', '2017-11-10 18:37:22'),
(2, 'WMENW', 'Women''s Wear and Accessories', 'Latest trends for women''s wear and accessories', 'WOMEN', '2017-11-10 18:37:22', '2017-11-10 18:37:22'),
(3, 'MENFW', 'Men''s Footwear', 'Latest trends in men''s footwear', 'MEN', '2017-11-10 18:37:22', '2017-11-10 18:37:22'),
(4, 'WMENFW', 'Women''s Footwear', 'Latest trends in women''s footwear', 'WOMEN', '2017-11-10 18:37:22', '2017-11-10 18:37:22'),
(5, 'KIDSW', 'Kid''s Wear and Acccessories', 'Latest trends in kid''s wear and accessories', 'KIDS', '2017-11-10 18:37:22', '2017-11-10 18:37:22'),
(6, 'KIDSFW', 'Kid''s Footwear', 'Latest trends in kid''s footwear', 'KIDS', '2017-11-10 18:37:22', '2017-11-10 18:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` varchar(45) NOT NULL,
  `item_code` varchar(45) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_desc` varchar(255) NOT NULL,
  `item_category` int(11) NOT NULL,
  `item_dateAdded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_dateModified` datetime NOT NULL,
  `item_status` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_code`, `item_name`, `item_desc`, `item_category`, `item_dateAdded`, `item_dateModified`, `item_status`) VALUES
('10a4cedabebff438e243737e2c6587c7', 'KIDSFW-001', 'Sporty Shoes-Western', 'Comfy and sporty shoes for your energetic kids', 6, '2017-10-24 14:51:35', '2017-10-24 14:51:35', 1),
('3b342724bf9fc4c953a27a871af9291a', 'MENW-001', 'Polo Shirt-Western', 'Western inspired polo shirts', 1, '2017-10-23 09:42:35', '2017-10-23 09:42:35', 1),
('5b8891789f0b9cfd6243b2045f23aa1c', 'WMENW-001', 'Blouse-Western', 'Western-styled blouses', 2, '2017-10-23 09:40:35', '2017-11-10 11:54:31', 1),
('72996e6feda4bbbc71b0f573d5ddf9dd', 'WMENFW-001', 'Floral Hi-Heeled Wedge-Western', 'A floral design, high-heeled wedge sandals for the Western summer', 4, '2017-10-24 10:15:35', '2017-10-24 10:15:35', 1),
('a429d0918bebebb4e2fc7b6dd95abbaa', 'KIDSW-001', 'Top Set Navy Blue Wear-Western', 'A Navy Blue chaleco and jacket for your kid&#039;s top set', 5, '2017-10-24 14:51:35', '2017-10-24 14:51:35', 1),
('cd753bdbca05ec235759a741bbec9db3', 'MENFW-001', 'Hi-Cut Denim Shoes-Western', 'Western denim shoes in hi-cut fashion', 3, '2017-10-24 10:04:35', '2017-10-24 10:04:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(45) NOT NULL,
  `username` varchar(100) NOT NULL,
  `passwd` varchar(45) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `mid_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `isAdmin` tinyint(4) NOT NULL DEFAULT '0',
  `isLoggedin` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `passwd`, `first_name`, `mid_name`, `last_name`, `isAdmin`, `isLoggedin`) VALUES
('d2abaa37a7c3db1137d385e1d8c15fd2', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'Admin', 'Admin', 1, 1),
('d887ed5220a66b723dd547442b6ba165', 'test_client', '098f6bcd4621d373cade4e832627b4f6', 'Test', 'Test', 'Client', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `activity_type`
--
ALTER TABLE `activity_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `activity_type`
--
ALTER TABLE `activity_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
