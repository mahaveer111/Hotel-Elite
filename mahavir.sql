-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2026 at 07:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mahavir`
--

-- --------------------------------------------------------

--
-- Table structure for table `food_orders`
--

CREATE TABLE `food_orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `room_no` varchar(20) DEFAULT NULL,
  `items` text DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_orders`
--

INSERT INTO `food_orders` (`id`, `customer_name`, `room_no`, `items`, `total_amount`, `payment_mode`, `order_date`) VALUES
(1, 'Krishna', '101', 'Mumbai Vadapav (₹50), Mumbai Vadapav (₹50), Masala Soda (₹60), Masala Soda (₹60), Veggie Burger (₹180), Veggie Burger (₹180), Chocolate Brownie (₹200), White Sauce Pasta (₹280)', 1060, 'Online', '2026-10-03 17:14:27');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_no` varchar(20) NOT NULL,
  `floor` varchar(50) DEFAULT NULL,
  `room_type` varchar(50) DEFAULT NULL,
  `room_status` varchar(50) DEFAULT 'Clean & Ready'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `floor`, `room_type`, `room_status`) VALUES
(1, '101', '1st Floor', 'Standard Room', 'Clean & Ready'),
(2, '102', '1st Floor', 'Standard Room', 'Clean & Ready'),
(3, '201', '2nd Floor', 'Deluxe Room', 'Clean & Ready'),
(4, '202', '2nd Floor', 'Deluxe Room', 'Clean & Ready'),
(5, '301', '3rd Floor', 'Executive Suite', 'Clean & Ready'),
(6, '302', '3rd Floor', 'Executive Suite', 'Clean & Ready');

-- --------------------------------------------------------

--
-- Table structure for table `room_bookings`
--

CREATE TABLE `room_bookings` (
  `id` int(11) NOT NULL,
  `room_no` varchar(20) DEFAULT NULL,
  `room_name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `adults` int(11) DEFAULT NULL,
  `children` int(11) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `checkin_date` date DEFAULT NULL,
  `checkout_date` date DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_bookings`
--

INSERT INTO `room_bookings` (`id`, `room_no`, `room_name`, `price`, `adults`, `children`, `customer_name`, `phone`, `checkin_date`, `checkout_date`, `payment_mode`, `booking_date`) VALUES
(1, '101', 'Stanard room', 1800, 2, 0, 'krishna', '03211456987', '2026-10-10', '2026-10-12', 'Credit Card', '2026-10-03 17:13:08'),
(2, '202', 'Deluxe Room', 4300, 2, 2, 'Rohit', '0321456987', '2026-10-10', '2026-10-15', 'Credit / Debit Card', '2026-10-03 17:23:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food_orders`
--
ALTER TABLE `food_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_bookings`
--
ALTER TABLE `room_bookings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food_orders`
--
ALTER TABLE `food_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room_bookings`
--
ALTER TABLE `room_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
