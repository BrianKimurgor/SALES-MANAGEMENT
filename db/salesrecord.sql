-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 02, 2024 at 11:16 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salesrecord`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int NOT NULL,
  `branchcode` int NOT NULL,
  `branchname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `branch_description` varchar(500) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branchcode`, `branchname`, `branch_description`) VALUES
(1, 2, 'kijape', 'selling phones'),
(2, 5, 'KAYOLE', 'OFFICIAL'),
(3, 5, 'KAYOLE', 'OFFICIAL'),
(4, 6, 'kijape', 'selling phones'),
(5, 5, 'KAYOLE', 'OFFICIAL');

-- --------------------------------------------------------

--
-- Table structure for table `formdata`
--

CREATE TABLE `formdata` (
  `id` int NOT NULL,
  `itemcode` int DEFAULT NULL,
  `item` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL,
  `sellingprice` double NOT NULL,
  `totalcost` int NOT NULL,
  `date` date NOT NULL,
  `user_id` int NOT NULL,
  `branch` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `formdata`
--

INSERT INTO `formdata` (`id`, `itemcode`, `item`, `quantity`, `sellingprice`, `totalcost`, `date`, `user_id`, `branch`) VALUES
(24, NULL, 'CHARGER', 2, 200, 400, '2023-11-27', 4, NULL),
(25, NULL, 'CHARGER', 2, 200, 400, '2023-11-27', 4, 'Branch1'),
(26, NULL, 'CHARGER', 4, 200, 800, '2023-11-27', 4, 'Branch1'),
(27, NULL, 'book', 2, 200, 400, '2023-11-27', 4, 'Branch1'),
(28, NULL, 'book', 2, 200, 400, '2023-11-27', 4, 'Branch1'),
(29, NULL, 'book', 2, 200, 400, '2023-11-27', 4, 'Branch1'),
(30, NULL, 'CHARGER', 4, 200, 800, '2023-11-28', 6, 'Kayole'),
(31, NULL, 'charger', 6, 200, 1200, '2023-11-28', 4, 'Branch1'),
(32, NULL, 'charger', 8, 200, 1600, '2023-11-28', 4, 'Branch1'),
(33, NULL, 'charger', 2, 200, 400, '2023-11-28', 4, 'Branch1'),
(35, 1270, 'phone', 5, 1500, 7500, '2023-11-29', 4, 'Branch1'),
(36, 1270, 'phone', 8, 1500, 12000, '2023-11-29', 7, 'NAIROBI'),
(37, 2, 'Techno R8-PHONE', 1, 12000, 12000, '2023-11-29', 4, 'Branch1'),
(38, 3, 'Toshiba Lap-Model123', 2, 30000, 60000, '2023-11-29', 4, 'Branch1'),
(40, 2, 'Techno R8-PHONE', 5, 12000, 60000, '2023-11-29', 4, 'Branch1'),
(41, 2, 'Techno R8-PHONE', 5, 12000, 60000, '2023-12-01', 5, 'Administrator'),
(42, 5, 'Pen', 5, 10, 50, '2023-12-02', 5, 'Administrator'),
(43, 133, 'IPHONE TX', 2, 15000, 30000, '2023-12-03', 5, 'Administrator'),
(44, 2548, 'HP-LAPTOP', 2, 30000, 60000, '2023-12-04', 5, 'Administrator'),
(45, 85748, 'Toshiba Lap-Model123', 2, 350000, 700000, '2023-12-04', 5, 'Administrator'),
(46, 12100, 'phone-techno', 5, 12000, 60000, '2023-12-17', 5, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int NOT NULL,
  `itemcode` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `costprice` int NOT NULL,
  `sellingprice` int NOT NULL,
  `status` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `itemcode`, `description`, `costprice`, `sellingprice`, `status`) VALUES
(8, '1', 'Memory card-Leno 2GB', 500, 800, NULL),
(9, '0012', 'Techno R8-PHONE', 10000, 12000, 'sold'),
(11, '4', 'book', 500, 700, 'available'),
(12, '5', 'Pen', 5, 10, 'sold'),
(13, '00133', 'IPHONE TX', 12000, 15000, 'sold'),
(14, '002548', 'HP-LAPTOP', 25000, 30000, 'sold'),
(15, '85748', 'Toshiba Lap-Model123', 25000, 350000, 'sold'),
(16, '12100', 'phone-techno', 10000, 12000, 'sold');

-- --------------------------------------------------------

--
-- Table structure for table `login_data`
--

CREATE TABLE `login_data` (
  `user_id` int NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_data`
--

INSERT INTO `login_data` (`user_id`, `username`, `password`, `branch`) VALUES
(4, 'seller', 'password', 'Branch1'),
(5, 'Admin', 'password', 'Administrator'),
(11, 'JOSHUA', '1212', 'KIAJA'),
(14, 'root', 'password', 'KAYOLE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formdata`
--
ALTER TABLE `formdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_data`
--
ALTER TABLE `login_data`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `formdata`
--
ALTER TABLE `formdata`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `login_data`
--
ALTER TABLE `login_data`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
