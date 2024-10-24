-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 29, 2024 at 09:01 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `food_beverages`
--

DROP TABLE IF EXISTS `food_beverages`;
CREATE TABLE IF NOT EXISTS `food_beverages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `food_beverages`
--

INSERT INTO `food_beverages` (`id`, `name`, `description`, `price`, `image`, `category`) VALUES
(34, 'burger', 'chicken', 200.00, 'food-1.png', ''),
(35, 'Chicken Kebab', 'Salt', 300.00, 'promo2.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `food_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `food_id`, `quantity`) VALUES
(28, 'Batman', 34, 2),
(25, 'fad', 37, 1);

-- --------------------------------------------------------

--
-- Table structure for table `parking_availability`
--

DROP TABLE IF EXISTS `parking_availability`;
CREATE TABLE IF NOT EXISTS `parking_availability` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `parking_spot` varchar(50) NOT NULL,
  `is_available` tinyint NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parking_availability`
--

INSERT INTO `parking_availability` (`ID`, `parking_spot`, `is_available`, `updated_at`) VALUES
(1, 'p1', 1, '2024-07-23 11:12:30'),
(2, 'p2', 1, '2024-07-23 12:27:31'),
(3, 'p3', 0, '2024-07-24 13:14:48');

-- --------------------------------------------------------

--
-- Table structure for table `table_reservation`
--

DROP TABLE IF EXISTS `table_reservation`;
CREATE TABLE IF NOT EXISTS `table_reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `guests` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `table_reservation`
--

INSERT INTO `table_reservation` (`id`, `name`, `email`, `phone`, `date`, `time`, `guests`) VALUES
(8, 'imani', 'ima@gmail.com', '0774563456', '2024-08-01', '17:00:00', 4),
(11, 'fad', 'fad@gmail.com', '0774563456', '2024-07-18', '01:42:00', 4),
(5, 'Gav', 'Gav@gmail.com', '0776746496', '2024-07-17', '01:22:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users_form`
--

DROP TABLE IF EXISTS `users_form`;
CREATE TABLE IF NOT EXISTS `users_form` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users_form`
--

INSERT INTO `users_form` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(13, 'fad', 'fad@gmail.com', 'b0baee9d279d34fa1dfd71aadb908c3f', 'admin'),
(14, 'gav', 'gav@gmail.com', 'b0baee9d279d34fa1dfd71aadb908c3f', 'user'),
(20, 'ima', 'ima@gmail.com', 'b0baee9d279d34fa1dfd71aadb908c3f', 'customer');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
