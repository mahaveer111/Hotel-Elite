-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2026 at 12:00 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Ayush', 'Vyas1111');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `room_no` varchar(20) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `booking_status` varchar(20) DEFAULT 'Pending',
  `payment_status` varchar(20) DEFAULT 'Pending',
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'Cash'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `customer_name`, `room_no`, `check_in_date`, `check_out_date`, `booking_status`, `payment_status`, `total_amount`, `payment_method`) VALUES
(1, 'krishna', '101', '2026-10-15', '2026-10-17', 'Confirmed', 'Pending', 4500.00, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(6, 'Krishna', 'kvyas3900@gmail.com', 'good work all! thank you', '2026-10-20 17:40:59'),
(7, 'yahya muthiya', 'kvyas3900@gmail.com', 'ok sir', '2026-10-22 06:41:03'),
(8, 'kamaludin sarkar', 'kamal786@gmail.com', 'Best Service you provide. Thank All Staff', '2026-10-25 18:33:40'),
(9, 'Santram Maharaj', 'Maharaj11@gmail.com', 'Good choice for picnic and party.', '2026-10-26 10:52:17');

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `food_name`, `price`, `image`) VALUES
(1, 'Mumbai Vadapav', 60.00, 'https://images.unsplash.com/photo-1601050690597-df0568f70950'),
(3, 'Continental Breakfast', 600.00, 'https://images.unsplash.com/photo-1533089860892-a7c6f0a88666'),
(4, 'Paneer Tikka', 360.00, 'https://images.unsplash.com/photo-1565557623262-b51c2513a641'),
(5, 'Cheesy Pizza', 350.00, 'https://images.unsplash.com/photo-1513104890138-7c749659a591'),
(6, 'Veggie Burger', 180.00, 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd'),
(7, 'White Sauce Pasta', 280.00, 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5'),
(8, 'Healthy Green Salad', 150.00, 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c'),
(9, 'Chocolate Brownie', 350.00, 'https://images.unsplash.com/photo-1578985545062-69928b1d9587'),
(10, 'Cold Coffee with Ice Cream', 260.00, 'https://images.unsplash.com/photo-1517701604599-bb29b565090c'),
(11, 'Fresh Lemon Juice', 90.00, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd'),
(12, 'Special Masala Dosa', 220.00, 'https://images.unsplash.com/photo-1668236543090-82eba5ee5976');

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
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Ordered',
  `payment_status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_orders`
--

INSERT INTO `food_orders` (`id`, `customer_name`, `room_no`, `items`, `total_amount`, `payment_mode`, `order_date`, `status`, `payment_status`) VALUES
(11, 'Krishna', '101', 'Cold Coffee with Ice Cream (₹140), Crispy Veg Burger (₹150)', 290, 'Online', '2026-10-23 17:18:13', 'Delivered', 'Paid'),
(12, 'ka', '102', 'Chocolate Brownie (₹180)', 180, 'Online', '2026-10-24 04:55:13', 'Ordered', 'Pending'),
(13, 'kamaludin sarkar', '105', 'Special Gujarati Thali (₹280), Special Gujarati Thali (₹280), Special Gujarati Thali (₹280), Paneer Tikka Masala (₹320), Cold Coffee with Ice Cream (₹140), Cold Coffee with Ice Cream (₹140), Cold Coffee with Ice Cream (₹140)', 1580, 'Cash', '2026-10-25 18:34:36', 'Preparing', 'Pending'),
(14, 'Santaram Maharaj', '103', 'Healthy Green Salad (₹150)', 150, 'Cash', '2026-10-26 10:50:46', 'Ordered', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_no` varchar(20) NOT NULL,
  `floor` varchar(50) DEFAULT NULL,
  `room_type` varchar(50) DEFAULT NULL,
  `room_status` varchar(50) DEFAULT 'Clean & Ready',
  `price` decimal(10,2) NOT NULL DEFAULT 1800.00,
  `bed_type` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `max_adults` int(11) DEFAULT 2,
  `max_children` int(11) DEFAULT 1,
  `extra_adult_charge` decimal(10,2) DEFAULT 500.00,
  `extra_child_charge` decimal(10,2) DEFAULT 300.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `floor`, `room_type`, `room_status`, `price`, `bed_type`, `image`, `max_adults`, `max_children`, `extra_adult_charge`, `extra_child_charge`) VALUES
(1, '101', NULL, 'Single Room', 'Clean & Ready', 1200.00, 'Single Bed', 'https://images.unsplash.com/photo-1591088398332-8a7791972843', 1, 0, 400.00, 200.00),
(2, '102', NULL, 'Standard Room', 'Clean & Ready', 1800.00, 'Queen Size Bed', 'https://images.unsplash.com/photo-1611892440504-42a792e24d32', 2, 0, 500.00, 300.00),
(3, '103', NULL, 'Deluxe Room', 'Clean & Ready', 2500.00, 'Twin Beds', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b', 2, 1, 600.00, 300.00),
(4, '104', NULL, 'Executive Suite', 'Clean & Ready', 3800.00, 'King Size Bed', 'https://images.unsplash.com/photo-1566073771259-6a8506099945', 3, 1, 800.00, 400.00),
(5, '105', NULL, 'King Size Luxury', 'Clean & Ready', 9999.00, 'King Size Luxury', 'https://images.unsplash.com/photo-1591088398332-8a7791972843', 4, 2, 1200.00, 600.00);

-- --------------------------------------------------------

--
-- Table structure for table `room_bookings`
--

CREATE TABLE `room_bookings` (
  `id` int(11) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `room_id` int(11) DEFAULT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT 'Cash',
  `payment_status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_bookings`
--

INSERT INTO `room_bookings` (`id`, `phone`, `booking_date`, `room_id`, `check_in`, `check_out`, `user_email`, `user_name`, `total_price`, `payment_method`, `payment_status`) VALUES
(46, '9327014244', '2026-10-23 17:16:35', 1, '2026-10-23 23:00:00', '2026-10-24 11:00:00', 'kvyas3900@gmail.com', 'krishna', 1200.00, NULL, 'Confirmed'),
(47, '9327014244', '2026-10-24 04:07:51', 2, '2026-10-23 12:00:00', '2026-10-24 11:00:00', 'kvyas3900@gmail.com', 'kartik vyas', 1800.00, NULL, 'Cancelled'),
(49, '9998786786', '2026-10-25 18:17:39', 5, '2026-11-17 12:00:00', '2026-11-19 11:00:00', 'kamal786@gmail.com', 'Kamaludin Sarkar', 19000.00, 'Cash', 'Pending (Pay at Hotel)'),
(50, '9876543210', '2026-10-26 10:48:32', 3, '2026-11-11 12:00:00', '2026-11-13 11:00:00', 'Maharaj11@gmail.com', 'Santram Maharaj', 5000.00, 'Cash', 'Pending (Pay at Hotel)');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Staff',
  `work_assigned` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `email`, `password`, `role`, `work_assigned`, `status`, `created_at`) VALUES
(1, 'Rohit Pareekh', 'rohit.p@hotelelite.com', 'rohit123', 'Manager', 'Overall hotel management, finances, and admin supervision', 'Active', '2026-10-25 14:23:10'),
(2, 'Het Mordiya', 'het@hotelelite.com', 'het123', 'Kitchen Manager', 'Manage food orders, menu updates, and kitchen delivery', 'Active', '2026-10-25 14:23:10'),
(3, 'Muskan Malik', 'muskan@hotelelite.com', 'muskan123', 'Receptionist', 'Handle room bookings, guest check-ins, and phone calls', 'Active', '2026-10-25 14:23:10'),
(4, 'Sneha Shukla', 'sneha@hotelelite.com', 'sneha123', 'Room Service', 'Guest room assistance, luggage handling, and food room delivery', 'Active', '2026-10-25 14:23:10'),
(5, 'Priyanshi Yadav', 'priyanshi@hotelelite.com', 'priyanshi123', 'Housekeeping Lead', 'Room cleaning, maintenance, and hotel hygiene management', 'Active', '2026-10-25 14:23:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(6, 'krishna', 'kvyas3900@gmail.com', '2512'),
(7, 'kartik Vyas', 'mahaveerdevil65@gmail.com', 'Vyas1111'),
(8, 'Rohit Pareek', 'Rohit@gmail.com', 'Rohit@123'),
(9, 'Siddhi', 'siddhi@gmail.com', '11'),
(10, 'kamaludin sarkar', 'kamal786@gmail.com', '786'),
(11, 'Santram Maharaj', 'Maharaj11@gmail.com', '11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `food_orders`
--
ALTER TABLE `food_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `room_bookings`
--
ALTER TABLE `room_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
