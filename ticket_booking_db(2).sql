-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2023 at 03:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `OrderID` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `Customer_name` varchar(30) NOT NULL,
  `Customer_email` varchar(255) NOT NULL,
  `event_id` int(11) NOT NULL,
  `eventData` varchar(255) DEFAULT NULL,
  `Total` decimal(6,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `OrderID`, `title`, `Customer_name`, `Customer_email`, `event_id`, `eventData`, `Total`, `status`, `created_at`, `updated_at`) VALUES
(16, '83lRWKXIiZ3OJTXc0vYq1S2XECsc4n', 'test event title 1', 'Arjun', 'arjungongley@gmail.com', 12, '[{\"event_type\":\"adult\",\"event_type_value\":\"6\"},{\"event_type\":\"child\",\"event_type_value\":\"6\"}]', 48.00, 'complete', '2023-08-11 13:56:56', '2023-08-11 13:56:56'),
(17, 'R5FCGjjgtgCejjyxafiSEft7NKbkyn', 'Disney Quiz @ The Kings Arms', 'Arjun', 'arjungongley@gmail.com', 9, '[{\"event_type\":\"child\",\"event_type_value\":\"1\"},{\"event_type\":\"adult\",\"event_type_value\":\"2\"}]', 7.50, 'complete', '2023-08-11 14:03:52', '2023-08-11 14:03:52'),
(18, 'kQGw9RYlZVuBSaH0hzXCgUdJtUTayj', 'Disney Quiz @ The Cricketers', 'Arjun', 'arjungongley@gmail.com', 11, '[{\"event_type\":\"normal\",\"event_type_value\":\"5\"},{\"event_type\":\"basic\",\"event_type_value\":\"5\"}]', 30.00, 'complete', '2023-08-11 16:02:35', '2023-08-11 16:02:35'),
(19, '3hWedHnjqwR0aGHBQc3fghXjk6cUnE', 'Disney Quiz @ The Kings Arms', 'Arjun', 'arjungongley@gmail.com', 9, '[{\"event_type\":\"child\",\"event_type_value\":\"5\"},{\"event_type\":\"adult\",\"event_type_value\":\"5\"}]', 22.50, 'pending', '2023-08-11 16:07:51', '2023-08-11 16:07:51'),
(20, 'sB7wGfRfNQwqWP3Nx68ut26oCmwzKo', 'Disney Quiz @ The Kings Arms', 'Arjun', 'test-p9mm1h14u@srv1.mail-tester.com', 9, '[{\"event_type\":\"child\",\"event_type_value\":\"5\"},{\"event_type\":\"adult\",\"event_type_value\":\"5\"}]', 22.50, 'complete', '2023-08-11 17:13:33', '2023-08-11 17:13:33');

-- --------------------------------------------------------

--
-- Table structure for table `confirmation`
--

CREATE TABLE `confirmation` (
  `id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `content` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `confirmation`
--

INSERT INTO `confirmation` (`id`, `subject`, `content`) VALUES
(1, 'deposite issue', '<p>sadfsd<u>dsfsdfsd</u></p><p><u>asdf</u></p>');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `start_date_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `location`, `image`, `start_date_time`) VALUES
(9, 'Disney Quiz @ The Kings Arms', '<p>Join us Tursday 31th </p>\r\n<p>The Quiz starts at 8pm start</p>', '22 Straplegrove Road, Taura', '1691571825Image 19.jpg', '2023-08-09 18:18:00'),
(11, 'Disney Quiz @ The Cricketers', 'Join us on Thursday 7th September 2023 for our Disney Quiz at The Crickerters\r\nThe quiz starts aft 8pm sharp!\r\nPut your Disney knowledge to the test to see whether you can be crowned our Disney Prince or Princess and win the $50 bar tab', '15 High Street, Taunton, TA1 3pj', '1691589205Image 20.jpg', '2023-08-10 22:51:00'),
(12, 'test event title 1', 'test description', 'test location', '1691659388Image 13.jpg', '2023-08-11 18:23:00'),
(13, 'asfasd', 'testas', 'fasf', '1691666736Image 9.jpg', '2023-08-11 20:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `ticket` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`id`, `event_id`, `type`, `price`, `ticket`) VALUES
(15, 11, 'normal', '4', '20'),
(10, 9, 'child', '1.5', '50'),
(9, 9, 'adult', '3', '100'),
(14, 11, 'basic', '2', '100'),
(16, 12, 'adult', '5', '90'),
(17, 12, 'child', '3', '100'),
(18, 13, 'test', '3', '11'),
(19, 13, 'test2', '4', '11'),
(20, 13, 'test3', '5', '22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `confirmation`
--
ALTER TABLE `confirmation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `confirmation`
--
ALTER TABLE `confirmation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
