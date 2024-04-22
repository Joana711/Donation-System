-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2024 at 09:51 PM
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
-- Database: `group12`
--

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `donation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_amount` decimal(10,2) DEFAULT NULL,
  `date_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`donation_id`, `user_id`, `user_amount`, `date_date`) VALUES
(1, 3, 75000.50, '2024-03-07 15:45:00'),
(2, 5, 25000.75, '2024-03-06 12:00:00'),
(3, 7, 1000.00, '2024-03-05 09:20:00'),
(4, 2, 3000.25, '2024-03-04 18:10:00'),
(5, 4, 15000.00, '2023-12-20 08:45:00'),
(6, 6, 20000.50, '2023-11-10 14:30:00'),
(7, 2, 3000.75, '2023-08-25 09:00:00'),
(8, 3, 500.25, '2022-12-01 12:45:00'),
(9, 3, 1000.00, '2024-01-15 14:30:00'),
(10, 5, 5000.50, '2023-10-10 11:20:00'),
(11, 7, 750.25, '2023-06-05 08:00:00'),
(12, 2, 200.00, '2022-11-25 17:30:00'),
(13, 4, 100.50, '2022-09-12 10:15:00'),
(14, 6, 500.75, '2022-05-20 13:45:00'),
(15, 2, 900.75, '2023-08-15 14:00:00'),
(16, 3, 200.25, '2023-07-20 10:30:00'),
(17, 5, 1000.50, '2023-06-25 12:15:00'),
(18, 7, 300.75, '2023-05-30 08:45:00'),
(19, 2, 500.25, '2022-12-25 16:20:00'),
(20, 4, 2500.00, '2022-11-10 13:30:00'),
(21, 6, 3000.50, '2022-10-15 11:10:00'),
(22, 2, 400.75, '2022-09-20 09:00:00'),
(23, 3, 100.25, '2022-08-25 14:45:00'),
(24, 5, 200.50, '2022-07-30 10:20:00'),
(25, 7, 50.75, '2022-06-15 08:30:00'),
(26, 2, 10.00, '2024-03-09 02:03:45'),
(27, 2, 5.00, '2024-03-11 00:55:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(50) DEFAULT NULL,
  `user_lastname` varchar(50) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_access` varchar(50) DEFAULT NULL,
  `user_password` varchar(50) DEFAULT NULL,
  `user_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_access`, `user_password`, `user_address`) VALUES
(1, 'Joana Nicole', 'Donesa', 'joanadonesa7@gmail.com', 'Admin', '123', 'Talisay City'),
(2, 'Jhanna Gracey', 'Villan', 'jv@gmail.com', 'donator', 'brent', NULL),
(3, 'John Rey', 'Aranez', 'lauren@gmail.com', 'donator', 'gay', NULL),
(4, 'Erica Lynn', 'Dorone', 'ed@gmail.com', 'donator', 'erica123', NULL),
(5, 'Marc Bryan', 'De Juan', 'md@gmail.com', 'donator', 'pokemon', NULL),
(6, 'Michael', 'Smith', 'michael@gmail.com', 'donator', 'password123', '123 Main St'),
(7, 'Sarah', 'Johnson', 'sarah@gmail.com', 'donator', 'pass123', '456 Elm St'),
(8, 'Emily', 'Anderson', 'emily@gmail.com', 'donator', 'emily123', '321 Pine St'),
(9, 'David', 'Wilson', 'david@gmail.com', 'donator', 'davidpass', '654 Cedar St');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
