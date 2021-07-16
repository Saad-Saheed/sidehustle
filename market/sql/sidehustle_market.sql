-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2021 at 08:21 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sidehustle_market`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` double(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `name`, `description`, `price`, `image`, `created_at`, `updated_at`) VALUES
(3, 1, 'Shoe', 'this is awesome shoe', 1500.00, '16264466672604_D15164B609F3D6975790243AE706D505_QL-X-QG-23.jpg', '2021-07-15 09:32:27', '2021-07-16 15:44:27'),
(4, 1, 'cover shoe', 'this is awesome shoe here we are Lorem, ipsum dolor sit amet consectetur adipisicing elit. At delectus harum dolore modi quos tempore voluptatem adipisci quidem consectetur. Quidem temporibus totam ratione at incidunt. Soluta fuga illo sint ratione.', 400.00, '1626338144Rectangle 50 (1).png', '2021-07-15 09:35:44', '2021-07-15 12:28:02'),
(5, 1, 'ice cream', 'deliciuos icream from The Kingdom is here.', 900.00, '16264437807012_XL-G-WH-25.jpg', '2021-07-16 14:56:20', '2021-07-16 14:56:20'),
(7, 14, 'Ewa Aganyin', 'what a delicious beans, you will difinatelly like it, especially with bread Agege.', 500.00, '162646296911327_SM-G-DC-06105.jpg', '2021-07-16 20:16:09', '2021-07-16 20:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `phone` varchar(14) NOT NULL,
  `email` varchar(125) NOT NULL,
  `password` varchar(125) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `phone`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'alabi jamiu', 'male', '09081150550', 'Jamiu@yahoo.com', '81dc9bdb52d04dc20036dbd8313ed055', '2021-07-14 10:22:50', '2021-07-16 16:33:12'),
(14, 'alao ibrahim', 'male', '07054638292', 'ibrahimalao@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2021-07-16 18:43:16', '2021-07-16 18:43:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
