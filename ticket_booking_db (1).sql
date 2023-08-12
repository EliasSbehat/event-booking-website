-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 12, 2023 at 07:58 AM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticket_booking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `OrderID` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Customer_name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `Customer_email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `event_id` int NOT NULL,
  `eventData` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Total` decimal(6,2) NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `OrderID`, `title`, `Customer_name`, `Customer_email`, `event_id`, `eventData`, `Total`, `status`, `created_at`, `updated_at`) VALUES
(16, '83lRWKXIiZ3OJTXc0vYq1S2XECsc4n', 'test event title 1', 'Arjun', 'arjungongley@gmail.com', 12, '[{\"event_type\":\"adult\",\"event_type_value\":\"6\"},{\"event_type\":\"child\",\"event_type_value\":\"6\"}]', '48.00', 'complete', '2023-08-11 13:56:56', '2023-08-11 13:56:56'),
(17, 'R5FCGjjgtgCejjyxafiSEft7NKbkyn', 'Disney Quiz @ The Kings Arms', 'Arjun', 'arjungongley@gmail.com', 9, '[{\"event_type\":\"child\",\"event_type_value\":\"1\"},{\"event_type\":\"adult\",\"event_type_value\":\"2\"}]', '7.50', 'complete', '2023-08-11 14:03:52', '2023-08-11 14:03:52'),
(18, 'kQGw9RYlZVuBSaH0hzXCgUdJtUTayj', 'Disney Quiz @ The Cricketers', 'Arjun', 'arjungongley@gmail.com', 11, '[{\"event_type\":\"normal\",\"event_type_value\":\"5\"},{\"event_type\":\"basic\",\"event_type_value\":\"5\"}]', '30.00', 'complete', '2023-08-11 16:02:35', '2023-08-11 16:02:35'),
(19, '3hWedHnjqwR0aGHBQc3fghXjk6cUnE', 'Disney Quiz @ The Kings Arms', 'Arjun', 'arjungongley@gmail.com', 9, '[{\"event_type\":\"child\",\"event_type_value\":\"5\"},{\"event_type\":\"adult\",\"event_type_value\":\"5\"}]', '22.50', 'pending', '2023-08-11 16:07:51', '2023-08-11 16:07:51'),
(20, 'sB7wGfRfNQwqWP3Nx68ut26oCmwzKo', 'Disney Quiz @ The Kings Arms', 'Arjun', 'test-p9mm1h14u@srv1.mail-tester.com', 9, '[{\"event_type\":\"child\",\"event_type_value\":\"5\"},{\"event_type\":\"adult\",\"event_type_value\":\"5\"}]', '22.50', 'complete', '2023-08-11 17:13:33', '2023-08-11 17:13:33'),
(21, 'TypTH92CEV2AJz4JagSH5cTjbIsNyZ', 'Disney Quiz @ The Cricketers', 'speed', 'speedjudy928@gmail.com', 11, '[{\"event_type\":\"normal\",\"event_type_value\":\"2\"},{\"event_type\":\"basic\",\"event_type_value\":\"3\"}]', '14.00', 'complete', '2023-08-11 23:51:34', '2023-08-11 23:51:34'),
(22, 'cmU3Zx1gG61HDYsLNJserjS7PZZn9f', 'asfasd', 'ads', 'speedjudy928@gmail.com', 13, '[{\"event_type\":\"test\",\"event_type_value\":\"2\"},{\"event_type\":\"test2\",\"event_type_value\":\"0\"},{\"event_type\":\"test3\",\"event_type_value\":\"0\"}]', '6.00', 'pending', '2023-08-12 03:52:46', '2023-08-12 03:52:46'),
(23, '1WqsjvRk8AckZBc05g5Mh8D7k7FSXE', 'asfasd', 'a', 'speedjudy928@gmail.com', 13, '[{\"event_type\":\"test\",\"event_type_value\":\"2\"},{\"event_type\":\"test2\",\"event_type_value\":\"0\"},{\"event_type\":\"test3\",\"event_type_value\":\"0\"}]', '6.00', 'pending', '2023-08-12 06:44:34', '2023-08-12 06:44:34'),
(24, 'DJBp4zJfs48SavnKTlYc5awA3v76Ji', 'Disney Quiz @ The Kings Arms', 'sj', 'speedjudy928@gmail.com', 9, '[{\"event_type\":\"child\",\"event_type_value\":\"2\"},{\"event_type\":\"adult\",\"event_type_value\":\"1\"}]', '6.00', 'pending', '2023-08-12 16:43:36', '2023-08-12 16:43:36');

-- --------------------------------------------------------

--
-- Table structure for table `confirmation`
--

DROP TABLE IF EXISTS `confirmation`;
CREATE TABLE IF NOT EXISTS `confirmation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `confirmation`
--

INSERT INTO `confirmation` (`id`, `subject`, `content`) VALUES
(1, 'Booking Confirmation - {EventTitle}', '<p>Dear {Name}</p><p>We have pleasure in confirming your booking as following:</p><ul><li>{EventTitle}</li><li>{EventDateTime}</li><li>{EventLocation}</li><li>{TotalPrice}</li></ul><p>Tickets purchased</p><ul><li>{TicketsPurchased}</li></ul><p>Kind Regards</p><p>Nick Burrett</p><p>Somerset Smartphone Quizzes</p>');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `start_date_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `location`, `image`, `start_date_time`) VALUES
(9, 'Disney Quiz @ The Kings Arms', '<p>Join us Tursday 31th </p>\r\n<p>The Quiz starts at 8pm start</p>', '22 Straplegrove Road, Taura', '1691571825Image 19.jpg', '2023-08-09 18:18:00'),
(11, 'Disney Quiz @ The Cricketers', 'Join us on Thursday 7th September 2023 for our Disney Quiz at The Crickerters\r\nThe quiz starts aft 8pm sharp!\r\nPut your Disney knowledge to the test to see whether you can be crowned our Disney Prince or Princess and win the $50 bar tab', '15 High Street, Taunton, TA1 3pj', '1691589205Image 20.jpg', '2023-08-10 22:51:00');

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

DROP TABLE IF EXISTS `price`;
CREATE TABLE IF NOT EXISTS `price` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `ticket` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`id`, `event_id`, `type`, `price`, `ticket`) VALUES
(15, 11, 'normal', '4', '20'),
(10, 9, 'child', '1.5', '50'),
(9, 9, 'adult', '3', '100'),
(14, 11, 'basic', '2', '100');

-- --------------------------------------------------------

--
-- Table structure for table `pwd`
--

DROP TABLE IF EXISTS `pwd`;
CREATE TABLE IF NOT EXISTS `pwd` (
  `id` int NOT NULL AUTO_INCREMENT,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pwd`
--

INSERT INTO `pwd` (`id`, `password`) VALUES
(1, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `website_title` varchar(255) NOT NULL,
  `website_email` varchar(255) NOT NULL,
  `stripe_public_key` text NOT NULL,
  `stripe_secret_key` text NOT NULL,
  `website_image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `website_title`, `website_email`, `stripe_public_key`, `stripe_secret_key`, `website_image`) VALUES
(1, 'Somerset-website', 'quiz@quizbooking.co.uk', 'pk_test_51Nb0Q2ICth3bN2l6764pFq4TPeZK26lXyrDN5chzuw9N2b8mHpGCTpUh87LJlzoI5IP3u8JeBXiSnU6vn5BHyFo300RwVJGrXH', 'sk_test_51Nb0Q2ICth3bN2l6NST7mTH01Wuwr2b4nTMDwxk5rccuIO93YUaLD0ShdhCaS3FACVILXAvlubbk15ykYO4WtJac00UXf9f0it', '1691823357Image 18.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
