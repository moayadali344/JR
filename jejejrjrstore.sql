-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2026 at 04:40 PM
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
-- Database: `jejejrjrstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name_en` varchar(255) NOT NULL,
  `product_name_ar` varchar(255) NOT NULL,
  `buy_price` decimal(10,2) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL,
  `description_en` text DEFAULT NULL,
  `description_ar` text DEFAULT NULL,
  `warning_en` text DEFAULT NULL,
  `warning_ar` text DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `rating_average` decimal(3,2) DEFAULT 0.00,
  `rating_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `discount_percentage` decimal(5,2) DEFAULT 0.00,
  `price_before_discount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name_en`, `product_name_ar`, `buy_price`, `sell_price`, `description_en`, `description_ar`, `warning_en`, `warning_ar`, `product_image`, `rating_average`, `rating_count`, `created_at`, `discount_percentage`, `price_before_discount`) VALUES
(1, 'sadsad', 'sadasd', 0.00, 0.00, 'sadas', 'sadsda', 'sadsda', 'sdasad', '../zero-uploads/69f60d0a470f0_togpt.png', 0.00, 0, '2026-05-02 14:41:14', 0.00, NULL),
(2, 'netflixs', 'نتفلمش', 25.00, 247.50, 'enrd', 'ending', 'sss', 'تنسيشس', '../zero-uploads/69f60dd443731_toabdalrh2am1.png', 5.00, 1, '2026-05-02 14:44:36', 0.00, NULL),
(3, 'maza', 'ماذا', 32.00, 34.00, '', '', '', '', 'zero-uploads/69f73ee1e3eeb_toabdalrham1.png', 5.00, 1, '2026-05-03 12:26:09', 0.00, NULL),
(4, 'talk', 'about', 22.00, 24.75, '213', '123', '13', '13', 'zero-uploads/69f8940bc2d07_toabdalrham1.png', 0.00, 0, '2026-05-04 12:41:47', 1.00, NULL),
(5, 'asa', 'asas', 222.00, 25.00, 'adsad', 'asdasd', 'asdsad', 'asdasd', 'zero-uploads/6a03307eb2539_togpt.png', 0.00, 0, '2026-05-12 13:51:58', 50.00, 0.00),
(6, 'test', 'test', 333.00, 250.00, '1010', '1010', '1010', '1010', 'zero-uploads/6a0330d2c3759_togpt.png', 0.00, 0, '2026-05-12 13:53:22', 50.00, 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `payment_status` varchar(30) DEFAULT 'processing',
  `request_status` varchar(30) DEFAULT 'processing',
  `request_result` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `paid_price` decimal(10,2) DEFAULT 0.00,
  `product_buy_price` decimal(10,2) DEFAULT NULL,
  `product_gomla_price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `user_id`, `product_id`, `quantity`, `payment_status`, `request_status`, `request_result`, `created_at`, `total_price`, `payment_method`, `payment_proof`, `paid_price`, `product_buy_price`, `product_gomla_price`) VALUES
(1, 1, 1, 2, 'failed', 'rejected', 'Rejected', '2026-05-04 17:57:56', 0.00, 'cash', '', 0.00, 0.00, 0.00),
(2, 17, 2, 1, 'pending', 'success', 'bad payment ', '2026-05-04 17:57:56', 247.50, 'bank', '', 247.50, 25.00, 0.00),
(3, 6, 3, 3, 'paid', 'rejected', '', '2026-05-04 17:57:56', 102.00, 'cash', '', 0.00, 32.00, 0.00),
(4, 7, 4, 1, 'paid', 'pending', 'Delivered', '2026-05-04 17:57:56', 24.75, 'cash', '', 24.75, 22.00, 0.00),
(5, 8, 2, 2, 'failed', 'rejected', 'Rejected', '2026-05-04 17:57:56', 495.00, 'bank', '', 0.00, 25.00, 0.00),
(6, 9, 3, 1, 'paid', 'pending', 'Delivered', '2026-05-04 17:57:56', 34.00, 'cash', '', 30.00, 32.00, 0.00),
(7, 10, 4, 4, 'failed', 'rejected', 'Rejected', '2026-05-04 17:57:56', 99.00, 'cash', '', 0.00, 22.00, 0.00),
(8, 1, 2, 1, 'pending', 'rejected', 'bad paymenu', '2026-05-04 17:57:56', 247.50, 'bank', '', 200.00, 25.00, 0.00),
(9, 4, 3, 2, 'paid', 'pending', 'Delivered', '2026-05-04 17:57:56', 68.00, 'cash', '', 68.00, 32.00, 0.00),
(10, 17, 1, 5, 'paid', 'success', 'emailhhmoayad@gmail.com', '2026-05-04 17:57:56', 0.00, 'cash', '', 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(1, 17, 3, 5, 'aaa', '2026-05-10 10:48:06'),
(2, 17, 2, 5, 'exllent product', '2026-05-12 13:12:17');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `usd_rate` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `usd_rate`) VALUES
(1, 4200);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `preferred_language` varchar(10) DEFAULT 'ar',
  `profile_pic` varchar(255) DEFAULT '/assets/default-profile.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(100) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `gender`, `preferred_language`, `profile_pic`, `created_at`, `username`, `is_verified`) VALUES
(1, '', '', 'asdasd@ddd.com', '$2y$10$c9xP91fAuOTEaplroe1A0uNo7wi45b7ZgDP5E1r1HLpZKbxHi/mS2', NULL, 'ar', '/assets/default-profile.png', '2026-04-23 11:50:19', 'sadasd', 0),
(4, '', '', 'asdasd@ddad.com', '$2y$10$VbQQn8U4rgYCWnXAuDqC2.edj8Ks.nJ4eoUfRtoO1Xf3Mju8O/evq', 'female', 'ar', '/assets/default-profile.png', '2026-04-23 12:04:10', 'sadasda', 0),
(6, '', '', 'haaaahhtest@gmail.com', '$2y$10$XpPT/fW8mg/Il2qXLfDyf.4ZltvV1Mm1EhXz1yKy/0GCyhWCTR/pm', 'male', 'ar', '/assets/default-profile.png', '2026-04-24 14:08:27', 'haha@', 0),
(7, '', '', 'sssssss@22.cooom', '$2y$10$PIGCvcUPUSjhMclnewTLWuuU7875XTdL09E//oKt6QymazbscT.MK', 'male', 'ar', '/assets/default-profile.png', '2026-04-24 14:09:57', 'sssssssss', 0),
(8, '', '', 'ads@asd.vo', '$2y$10$MUialEmuwqK0DcjP9wjBruZo8vhGCo0oIHo0qa9D8QELq/3smKr1a', 'male', 'ar', '/assets/default-profile.png', '2026-04-24 14:14:38', 'asd', 0),
(9, '', '', 'ahmed@gmail.comm', '$2y$10$P9sbLKctIztLbc2l4CrgeekomoBwuA5nq/Ded3lZtqEjt6cakChQ.', 'male', 'ar', '/assets/default-profile.png', '2026-04-24 20:33:51', 'ahmedd', 0),
(10, '', '', 'hhhtest@gmail.com', '$2y$10$ZqzIl8FC7TcO/H1/Ge9vxuW1ClJBpK/fIPuMd8mC5k5/FMfRCLn1a', 'male', 'ar', '/assets/default-profile.png', '2026-04-26 11:53:43', 'loyal344', 0),
(11, '', '', 'hhhtest@gmail.comm', '$2y$10$w4Z/objSeSbHhWD7IS05fOYJRcZ0exAy9NVFlT8rHTKACrvNS4UAS', 'male', 'ar', '/assets/default-profile.png', '2026-04-26 11:54:26', 'loyal3444', 0),
(12, '', '', 'grom@gmail.com', '$2y$10$xcCd.cZyAVsVVQFZxEjx/ewHg2a.KoRpQiDmtw84aIbY6.x3BTiLa', 'male', 'ar', '/assets/default-profile.png', '2026-04-26 11:56:06', 'krkrkr344', 0),
(13, '', '', '1hhhtest@gmail.com', '$2y$10$/ypblhQOPdJs.cWBcug3vuH/SkU1cELZgp3ZEjbqxw2QLVUPUFEG6', 'male', 'ar', '/assets/default-profile.png', '2026-04-26 12:07:12', 'kokoko', 0),
(14, '', '', 'taketakos@gmail.com', '$2y$10$T8RsnUWiv8k7uyMbvwAUBex2F./zRxMWnlZMCUpj6OTJc/IajwykO', 'male', 'ar', '/assets/default-profile.png', '2026-04-26 13:20:41', 'tako', 0),
(15, '', '', 'SSS@S.COM', '$2y$10$yntwcXJoQoMqAazr5HO7tOPLj4ECqT2oVER9L1rksyGl5U5dWLw/u', 'male', 'ar', '/assets/default-profile.png', '2026-04-26 17:49:19', 'ss', 0),
(16, '', '', 'ahmed@gmaiil.com', '$2y$10$jLKvKihjw50yetxUbXXUHe47aZhYJIxQI.pJrv1dl3XNOYfnb89hO', 'female', 'ar', '/assets/default-profile.png', '2026-04-26 19:37:55', 'koko', 0),
(17, '', '', 'hhhmoayad@gmail.com', '$2y$10$R3LsSgWsUqOChdMdCOOR9.P0KxkOP2zvRKZH0L4JvUjGBLWiThx12', 'male', 'ar', '/assets/default-profile.png', '2026-05-07 06:33:15', 'kirito344', 0),
(18, '', '', 'zerf344@gmail.com', '$2y$10$hzOuqgzOm4Pgn/W8dQfrxO40.MftsCbVDuHU0.jwxlPtzuw.9axtO', 'male', 'ar', '/assets/default-profile.png', '2026-05-09 08:29:00', 'xer', 0),
(19, '', '', 'hhhmoayad@cmail.com', '$2y$10$fcDVThioq.0wSimkd4WvNuAm9v9EcR9TN.yJI6FdNGeAzYDQ4fKa.', 'male', 'ar', '/assets/default-profile.png', '2026-05-12 10:49:30', 'Jr344', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
