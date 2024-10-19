-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2024 at 01:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventorydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`) VALUES
(17, 'SHOCK'),
(19, 'RIM'),
(20, 'WHEELS'),
(21, 'Clutch Lever'),
(24, 'cat_test-1'),
(25, 'awdaw'),
(26, 'kilo');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `category_id`) VALUES
(124, 'Universal', 20, 19),
(125, 'sample1', 12, 17),
(126, 'sample2', 12, 17),
(127, 'sample3', 2, 17),
(128, 'sample4', 5, 17),
(129, 'sample5', 20, 17),
(130, 'sample6', 13, 20),
(136, 'sample9', 12, 17),
(137, 'sample10', 21, 19),
(138, 'sample11', 12, 19),
(139, 'sample20', 500, 21),
(140, 'a', 300, 17),
(141, 'b', 400, 17),
(142, '3', 450, 17);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`id`, `product_id`, `product_name`, `action`, `quantity`, `date_time`) VALUES
(13, 136, 'sample9', 'Added', 12, '2024-09-06 14:24:30'),
(14, 137, 'sample10', 'Added', 21, '2024-09-06 14:24:37'),
(15, 138, 'sample11', 'Added', 12, '2024-09-06 14:24:42'),
(16, 139, 'sample20', 'Added', 500, '2024-09-17 18:21:43'),
(17, 140, 'a', 'Added', 300, '2024-09-17 18:30:21'),
(18, 141, 'b', 'Added', 400, '2024-09-17 18:30:27'),
(19, 142, '3', 'Added', 450, '2024-09-17 18:30:41'),
(26, NULL, 'Universal', 'Deleted', 5, '2024-10-19 12:03:02'),
(27, NULL, 'dan', 'Updated', 12, '2024-10-19 12:03:25'),
(28, NULL, 'awdwad', 'Added', 12312, '2024-10-19 12:43:54'),
(29, NULL, 'dan', 'Deleted', 10, '2024-10-19 14:03:49'),
(30, NULL, '12', 'Added', 12, '2024-10-19 14:39:17'),
(31, NULL, '12', 'Deleted', 12, '2024-10-19 14:39:32'),
(32, NULL, 'awdwad', 'Deleted', 12312, '2024-10-19 14:48:08'),
(33, 124, 'Universal', 'Sold', 2, '2024-10-19 16:13:34'),
(34, 124, 'Universal', 'Added', 2, '2024-10-19 16:32:02'),
(35, 124, 'Universal', 'Added', 4, '2024-10-19 16:33:53'),
(36, 124, 'Universal', 'Sold', 22, '2024-10-19 16:34:27'),
(37, 124, 'Universal', 'Added', 20, '2024-10-19 16:35:07'),
(38, NULL, 'akora', 'Added', 12, '2024-10-19 17:11:21'),
(39, NULL, 'akora', 'Deleted', 12, '2024-10-19 17:12:05'),
(40, NULL, 'sample111', 'Added', 2147483647, '2024-10-19 17:12:53'),
(41, NULL, 'sample111', 'Deleted', 2147483647, '2024-10-19 17:13:31'),
(42, 130, 'sample6', 'Sold', 2, '2024-10-19 17:15:47'),
(43, 124, 'Universal', 'Sold', 2, '2024-10-19 17:16:01'),
(44, 124, 'Universal', 'Added', 4, '2024-10-19 17:16:58'),
(45, 124, 'Universal', 'Added', 2, '2024-10-19 18:59:15'),
(46, 124, 'Universal', 'Sold', 4, '2024-10-19 18:59:30'),
(47, 124, 'Universal', 'Out', 4, '2024-10-19 19:09:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaction_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
