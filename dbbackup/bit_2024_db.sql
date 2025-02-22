-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2025 at 02:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bit_2024_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `function`
--

CREATE TABLE `function` (
  `function_id` int(11) NOT NULL,
  `function_name` varchar(50) NOT NULL,
  `module_id` int(11) NOT NULL,
  `function_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `function`
--

INSERT INTO `function` (`function_id`, `function_name`, `module_id`, `function_status`) VALUES
(1, 'Add Category', 1, 1),
(2, 'Update Category', 1, 1),
(3, 'View Category', 1, 1),
(4, 'Add Size', 1, 1),
(5, 'Update Size', 1, 1),
(6, 'View Size', 1, 1),
(7, 'Add Product', 1, 1),
(8, 'Update Product', 1, 1),
(9, 'View Product', 1, 1),
(10, 'Add Stock', 2, 1),
(11, 'Update Stock', 2, 1),
(12, 'View Stock', 2, 1),
(13, 'Quality Inspection', 2, 1),
(14, 'Reports by Quality', 2, 1),
(15, 'Reports by Quantity', 2, 1),
(16, 'Add GRN', 2, 1),
(17, 'Add Purchase Order', 3, 1),
(18, 'Send Purchase Order', 3, 1),
(19, 'Generate Purchase Order', 3, 1),
(20, 'Add Supplier Invoice', 3, 1),
(21, 'Add User', 8, 1),
(22, 'Update User', 8, 1),
(23, 'View User', 8, 1),
(24, 'Generate User Reports', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `function_user`
--

CREATE TABLE `function_user` (
  `function_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(11) NOT NULL,
  `login_username` varchar(80) NOT NULL,
  `login_password` text NOT NULL,
  `login_status` int(11) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `login_username`, `login_password`, `login_status`, `user_id`) VALUES
(1, 'kamal@esoft.lk', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(30) NOT NULL,
  `module_icon` varchar(50) NOT NULL,
  `module_url` text NOT NULL,
  `module_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`, `module_icon`, `module_url`, `module_status`) VALUES
(1, 'Product management', 'product.png', 'product.php', 1),
(2, 'Inventory Management', 'product.png', 'inventory.php', 1),
(3, 'Purchasing Management', 'order.png', 'purchasing.php', 1),
(4, 'Supplier Management', 'supplier.png', 'supplier.php', 1),
(5, 'Customer Management', 'customer.png', 'customer.php', 1),
(6, 'Order Management', 'order.png', 'order.php', 1),
(7, 'Delivery Management', 'delivery.png', 'delivery.php', 1),
(8, 'User management', 'user.png', 'user.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL,
  `role_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `role_status`) VALUES
(1, 'Director', 1),
(2, 'Data Entry Clerk', 1),
(3, 'Stock Keeper', 1),
(4, 'Purchasing Manager', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_module`
--

CREATE TABLE `role_module` (
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `role_module`
--

INSERT INTO `role_module` (`role_id`, `module_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(3, 2),
(4, 2),
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_fname` varchar(20) NOT NULL,
  `user_lname` varchar(30) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_dob` date NOT NULL,
  `user_nic` varchar(15) NOT NULL,
  `user_image` varchar(80) NOT NULL,
  `user_role` int(11) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_fname`, `user_lname`, `user_email`, `user_dob`, `user_nic`, `user_image`, `user_role`, `user_status`) VALUES
(1, 'Kamal', 'Perera', 'kamal@esoft.lk', '2024-11-05', '951420321V', '', 1, 1),
(2, 'werwer', 'werwerwer', 'k.d.p.hasendra@gmail.com', '2025-02-03', '874521368V', '1739616862_loginimage.jpg', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `function`
--
ALTER TABLE `function`
  ADD PRIMARY KEY (`function_id`);

--
-- Indexes for table `function_user`
--
ALTER TABLE `function_user`
  ADD PRIMARY KEY (`function_id`,`user_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`),
  ADD UNIQUE KEY `login_username` (`login_username`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `role_module`
--
ALTER TABLE `role_module`
  ADD PRIMARY KEY (`role_id`,`module_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `function`
--
ALTER TABLE `function`
  MODIFY `function_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
