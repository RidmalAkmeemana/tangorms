-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 29, 2025 at 06:58 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tango_restaurant_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `function`
--

CREATE TABLE `function` (
  `function_id` int(11) NOT NULL,
  `function_name` varchar(150) NOT NULL,
  `function_url` varchar(150) NOT NULL,
  `module_id` int(11) NOT NULL,
  `function_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `function`
--

INSERT INTO `function` (`function_id`, `function_name`, `function_url`, `module_id`, `function_status`) VALUES
(1, 'User Management', 'user.php', 5, 1),
(2, 'Add User', 'add-user.php', 5, 1),
(3, 'View All Users', 'view-users.php', 5, 1),
(4, 'View User', 'view-user.php', 5, 1),
(5, 'Edit User', 'edit-user.php', 5, 1),
(6, 'Delete User', 'user_controller.php', 5, 1),
(8, 'Role Management', 'role.php', 10, 1),
(9, 'Add Role', 'add-role.php', 10, 1),
(10, 'View All Roles', 'view-roles.php', 10, 1),
(11, 'Delete Role', 'role_controller.php', 10, 1),
(12, 'Edit Role', 'edit-role.php', 10, 1),
(13, 'Screen Permission', 'screen-permission.php', 10, 1),
(14, 'Table Management', 'table.php', 1, 1),
(15, 'Add Table', 'add-table.php', 1, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `login_username`, `login_password`, `login_status`, `user_id`) VALUES
(1, 'kamal@esoft.lk', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 49),
(27, 'shevan.fernando99@gmail.com', 'e61e2173c4b2f51919eb2225be46ee0e36a1e313', 1, 50),
(28, 'Chela@gmail.com', '4ba6176a8931728e50515b364eb34148c93dea3d', 1, 51),
(29, 'gabe@tg.com', '96c0ee9c7bcd87a1af160095bf8d97b8a5e29121', 1, 52),
(30, 'ashan@gmail.com', '3bcbd2d90a7ab0c267b13f01d757d28a24ab9d66', 1, 53),
(31, 'shehara@gmail.com', '6d3c45cb589a2e68a30ec80cf23f84e70bcc8a09', 1, 54),
(32, 'Binara@gmail.com', '42c0feb4872d4284a26aca33163aae91e686cf66', 1, 55),
(33, 'Sula@gmail.com', '1f731b831686ed3c3ab9cc9768dc5222ca54bd68', 1, 56),
(34, 'ridmal@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 49),
(35, 'rajeewaakmeemana@gmail.com', 'c78e33f4b229277d86e3b8b252f9ea7a9651a270', 1, 57);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `menu_item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` text DEFAULT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_category` varchar(100) DEFAULT NULL,
  `item_image` varchar(255) DEFAULT NULL,
  `item_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`, `module_icon`, `module_url`, `module_status`) VALUES
(1, 'Table Management', 'table.png', 'table.php', 1),
(2, 'Kitchen Management', 'kitchen.png', 'kitchen.php', 1),
(3, 'Food Menu Management', 'menu.png', 'menu.php', 1),
(4, 'Sales & POS Management', 'pos.png', 'pos.php', 1),
(5, 'User Management', 'user.png', 'user.php', 1),
(6, 'Events Reservation Management', 'reservation.png', 'reservation.php', 1),
(7, 'Inventory & Stock Management', 'inventory.png', 'inventory.php', 1),
(8, 'Purchasing Management', 'purchasing.png', 'purchasing.php', 1),
(9, 'Advanced Reports', 'Reports.png', 'reports.php', 1),
(10, 'Role Management', 'role.png', 'role.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `order_status` int(11) NOT NULL,
  `order_complete_time` time DEFAULT NULL,
  `waiter_id` int(11) DEFAULT NULL,
  `bill_number` varchar(20) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `bill_status` varchar(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `menu_item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `item_price` decimal(10,2) DEFAULT NULL,
  `item_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_table`
--

CREATE TABLE `restaurant_table` (
  `table_id` int(11) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `room_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_table`
--

INSERT INTO `restaurant_table` (`table_id`, `table_name`, `capacity`, `status_id`, `room_id`) VALUES
(6, 'T10', 10, 0, 4),
(7, 'T1', 2, 0, 6),
(8, 'T7', 10, 0, 2),
(9, 'T4', 2, 1, 5),
(10, 'T45', 15, 4, 6),
(11, 'T56', 4, 3, 2),
(12, 'T99', 6, 1, 4),
(13, 'T5', 2, 0, 1),
(14, 'T64', 4, 1, 3),
(15, 'T14', 10, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL,
  `role_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `role_status`) VALUES
(1, 'Group Manager', 1),
(2, 'Manager', 1),
(3, 'Staff', 1),
(4, 'Data Entry Clerk', 1),
(5, 'Delivery Rider', 1),
(8, 'Test', -1);

-- --------------------------------------------------------

--
-- Table structure for table `role_function`
--

CREATE TABLE `role_function` (
  `role_id` int(11) NOT NULL,
  `function_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_function`
--

INSERT INTO `role_function` (`role_id`, `function_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `role_module`
--

CREATE TABLE `role_module` (
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_module`
--

INSERT INTO `role_module` (`role_id`, `module_id`) VALUES
(1, 1),
(1, 5),
(1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(10) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_layout` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `room_layout`) VALUES
(1, 'PDR 1', 'pdr1.png'),
(2, 'PDR 2', 'pdr2.png'),
(3, 'PDR 3', 'pdr3.png'),
(4, 'Main Dining Area', 'mda.png'),
(5, 'Outdoor Dining Area', 'oda.png'),
(6, 'Bar & Grill Area\r\n', 'bga.png');

-- --------------------------------------------------------

--
-- Table structure for table `table`
--

CREATE TABLE `table` (
  `table_id` int(10) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `seat_count` int(10) DEFAULT NULL,
  `table_status` enum('Vacant','Out of Service','Reserved','Seated','Dirty') NOT NULL,
  `room_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table`
--

INSERT INTO `table` (`table_id`, `table_name`, `seat_count`, `table_status`, `room_id`) VALUES
(7, 'RM1T1', 4, 'Vacant', 1),
(8, 'RM1T2', 4, 'Out of Service', 1),
(9, 'RM1T3', 4, 'Reserved', 1),
(10, 'RM1T4', 4, 'Seated', 1),
(11, 'RM1T5', 4, 'Dirty', 1),
(12, 'RM1T6', 4, 'Vacant', 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_activity_log`
--

CREATE TABLE `table_activity_log` (
  `log_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `performed_by` int(11) NOT NULL,
  `related_table_id` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_fname` varchar(20) NOT NULL,
  `user_lname` varchar(30) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(150) NOT NULL,
  `user_dob` date NOT NULL,
  `user_nic` varchar(15) NOT NULL,
  `user_image` varchar(80) NOT NULL,
  `user_role` int(11) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT 1,
  `user_contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_fname`, `user_lname`, `user_email`, `user_password`, `user_dob`, `user_nic`, `user_image`, `user_role`, `user_status`, `user_contact`) VALUES
(49, 'Kamal', 'Perera', 'kamal@esoft.lk', '202cb962ac59075b964b07152d234b70', '2025-04-06', '605120458V', '1751128958_3d-cartoon-baby-genius-photo.jpg', 2, 1, '0773456060'),
(57, 'Ridmal', 'Akmeemana', 'rajeewaakmeemana@gmail.com', '202cb962ac59075b964b07152d234b70', '1998-09-22', '982660203V', '', 1, 1, '0773697070'),
(61, 'Miranga', 'Senarathna', 'miranga@sits.lk', '866c7ee013c58f01fa153a8d32c9ed57', '2025-06-24', '881441756V', '1750873659_3d-cartoon-baby-genius-photo.jpg', 2, 1, '0773697070'),
(62, 'Anusha', 'Perera', 'anusha@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-06-26', '963133223V', '1750958069_images (1).jpeg', 1, -1, '0773698080'),
(63, 'Janaka', 'Rathnayaka', 'janaka@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-06-19', '963133223V', '', 2, -1, '0773697070'),
(64, 'Miranga', 'Perera', 'miranga@sis.lk', '81dc9bdb52d04dc20036dbd8313ed055', '2025-06-26', '956182015V', '1751016923_images (1).jpeg', 2, 1, '0773697070'),
(65, 'Test', 'Senarathna', 'test@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-06-26', '963133223V', '1751091914_3d-cartoon-baby-genius-photo.jpg', 1, -1, '0773698080');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `function`
--
ALTER TABLE `function`
  ADD PRIMARY KEY (`function_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`),
  ADD UNIQUE KEY `login_username` (`login_username`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`menu_item_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `bill_number` (`bill_number`),
  ADD KEY `table_id` (`table_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `restaurant_table`
--
ALTER TABLE `restaurant_table`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `role_function`
--
ALTER TABLE `role_function`
  ADD PRIMARY KEY (`role_id`,`function_id`),
  ADD KEY `function_id` (`function_id`);

--
-- Indexes for table `role_module`
--
ALTER TABLE `role_module`
  ADD PRIMARY KEY (`role_id`,`module_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `table`
--
ALTER TABLE `table`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `table_activity_log`
--
ALTER TABLE `table_activity_log`
  ADD PRIMARY KEY (`log_id`);

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
  MODIFY `function_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `menu_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant_table`
--
ALTER TABLE `restaurant_table`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `table`
--
ALTER TABLE `table`
  MODIFY `table_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `table_activity_log`
--
ALTER TABLE `table_activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `restaurant_table` (`table_id`) ON DELETE SET NULL;

--
-- Constraints for table `role_function`
--
ALTER TABLE `role_function`
  ADD CONSTRAINT `role_function_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_function_ibfk_2` FOREIGN KEY (`function_id`) REFERENCES `function` (`function_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
