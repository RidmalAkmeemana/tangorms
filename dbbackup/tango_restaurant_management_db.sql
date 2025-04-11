-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2025 at 07:43 AM
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
-- Database: `tango_restaurant_management_db`
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
(1, 'Add Table', 1, 1),
(2, 'Edit Table', 1, 1),
(3, 'Remove Table', 1, 1),
(4, 'Check Available Tables', 1, 1),
(5, 'Assign Table to Customers', 1, 1),
(6, 'Update Table Status', 1, 1),
(7, 'Merge/Split Tables', 1, 1),
(8, 'View Table Occupancy Summary', 1, 1),
(9, 'Set Maximum Seating Capacity', 1, 1),
(10, 'View Orders Sent to Kitchen', 2, 1),
(11, 'Update Order Status', 2, 1),
(12, 'Filter Orders by Status', 2, 1),
(13, 'Mark Urgent Orders', 2, 1),
(14, 'Track Time Taken for Each Order', 2, 1),
(15, 'Cancel an Order', 2, 1),
(16, 'View Special Requests for Each Order', 2, 1),
(17, 'Notify Waiter When an Order is Ready', 2, 1),
(18, 'Assign Orders to Delivery Staff', 3, 1),
(19, 'Update Delivery Status', 3, 1),
(20, 'View Pending Deliveries', 3, 1),
(21, 'View All Delivery Orders', 3, 1),
(22, 'Notify Customer When Order is Out for Delivery', 3, 1),
(23, 'Notify Customer When Order is Delivered', 3, 1),
(24, 'Filter Orders by Status', 3, 1),
(25, 'View Delivery History', 3, 1),
(26, 'Add New Menu Item', 4, 1),
(27, 'Edit Menu Item', 4, 1),
(28, 'Remove Menu Item', 4, 1),
(29, 'Update Menu Item Price', 4, 1),
(30, 'Mark Item as Available/Unavailable', 4, 1),
(31, 'Categorize Menu Items', 4, 1),
(32, 'Upload Image for Menu Item', 4, 1),
(33, 'Search & Filter Menu Items', 4, 1),
(34, 'Record a New Sale', 5, 1),
(35, 'View Sales Reports', 5, 1),
(36, 'Generate Receipts for Customers', 5, 1),
(37, 'Track Payment Methods', 5, 1),
(38, 'Apply Discounts & Offers', 5, 1),
(39, 'Refund or Cancel a Sale', 5, 1),
(40, 'View Sales by Date & Category', 5, 1),
(41, 'Search Sales Records', 5, 1),
(42, 'Add New User', 6, 1),
(43, 'Edit User Details', 6, 1),
(44, 'Delete User Account', 6, 1),
(45, 'View User List', 6, 1),
(46, 'Change User Password', 6, 1),
(47, 'Assign Roles to Users', 6, 1),
(48, 'Activate or Deactivate User Account', 6, 1),
(49, 'Reset Forgotten Password', 6, 1),
(50, 'Create a New Event Reservation', 7, 1),
(51, 'Modify Event Reservation', 7, 1),
(52, 'Cancel Event Reservation', 7, 1),
(53, 'View All Event Reservations', 7, 1),
(54, 'Set Event Date and Time', 7, 1),
(55, 'Assign Event to Specific Area', 7, 1),
(56, 'Store Customer Contact Details', 7, 1),
(57, 'Filter Event Reservations by Status', 7, 1),
(58, 'Add New Stock Item', 8, 1),
(59, 'Edit Stock Item', 8, 1),
(60, 'Remove Stock Item', 8, 1),
(61, 'View Current Stock Levels', 8, 1),
(62, 'Track Stock Usage', 8, 1),
(63, 'Set Minimum Stock Alerts', 8, 1),
(64, 'Generate Stock Reports', 8, 1),
(65, 'Filter Stock Items by Category', 8, 1),
(66, 'Add New Purchase Order', 9, 1),
(67, 'Edit Purchase Order', 9, 1),
(68, 'Cancel Purchase Order', 9, 1),
(69, 'View All Purchase Orders', 9, 1),
(70, 'Track Purchase Order Status', 9, 1),
(71, 'Manage Supplier Details', 9, 1),
(72, 'Generate Purchase Reports', 9, 1),
(73, 'Set Reorder Level Alerts', 9, 1),
(74, 'View Daily Sales Summary', 10, 1),
(75, 'View Most Ordered Menu Items', 10, 1),
(76, 'Generate Monthly Sales Report', 10, 1),
(77, 'View Inventory Usage Report', 10, 1),
(78, 'Track Employee Performance', 10, 1),
(79, 'Analyze Customer Order Trends', 10, 1),
(80, 'Filter Reports by Date Range', 10, 1),
(81, 'Export Reports to PDF or Excel', 10, 1),
(82, 'Store Customer Name & Contact Info', 10, 1),
(83, 'View Customer Order History', 10, 1),
(84, 'Search & Filter Customers', 10, 1),
(85, 'Track Frequent Customers', 10, 1),
(86, 'Assign Membership or Loyalty Levels', 10, 1),
(87, 'Store Special Preferences & Notes', 10, 1),
(88, 'Export Customer Data for Marketing', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `function_user`
--

CREATE TABLE `function_user` (
  `function_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `function_user`
--

INSERT INTO `function_user` (`function_id`, `user_id`) VALUES
(1, 37),
(1, 38),
(1, 39),
(1, 41),
(1, 42),
(2, 37),
(2, 39),
(2, 41),
(2, 42),
(3, 39),
(3, 41),
(3, 42),
(4, 38),
(4, 39),
(4, 41),
(4, 42),
(5, 39),
(5, 41),
(5, 42),
(6, 38),
(6, 39),
(6, 41),
(6, 42),
(7, 37),
(7, 39),
(7, 41),
(7, 42),
(8, 37),
(8, 38),
(8, 39),
(8, 41),
(8, 42),
(9, 37),
(9, 38),
(9, 39),
(9, 41),
(9, 42),
(10, 37),
(10, 38),
(10, 39),
(10, 41),
(10, 42),
(11, 37),
(11, 38),
(11, 39),
(11, 41),
(11, 42),
(12, 37),
(12, 38),
(12, 39),
(12, 41),
(12, 42),
(13, 37),
(13, 38),
(13, 39),
(13, 41),
(13, 42),
(14, 37),
(14, 38),
(14, 39),
(14, 41),
(14, 42),
(15, 37),
(15, 38),
(15, 39),
(15, 41),
(15, 42),
(16, 37),
(16, 38),
(16, 39),
(16, 41),
(16, 42),
(17, 37),
(17, 38),
(17, 39),
(17, 41),
(17, 42),
(18, 38),
(18, 42),
(19, 38),
(19, 42),
(20, 38),
(20, 42),
(21, 38),
(21, 42),
(22, 38),
(22, 42),
(23, 38),
(23, 42),
(24, 38),
(24, 42),
(25, 38),
(25, 42),
(26, 38),
(26, 42),
(27, 38),
(27, 42),
(28, 38),
(28, 42),
(29, 38),
(29, 42),
(30, 38),
(30, 42),
(31, 38),
(31, 42),
(32, 38),
(32, 42),
(33, 38),
(33, 42);

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
(1, 'kamal@esoft.lk', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 1),
(2, 'nimal@esoft.lk', '1942b8a7af05e18a50c3e0627bf22ada5e89afc7', 1, 4),
(3, 'khkhk@jhgfjg.llk', 'be7f6ac64af5d5d3f358b379d078f9853cdc50eb', 1, 5),
(4, 'Ravisara@esoft.lk', '4009d36b4ab7dcf3649de953599acf1c435fd4f9', 1, 6),
(7, 'Ravisaraa@esoft.lk', 'd25d1e74a443e520a06218c6a2889e04c15396da', 1, 9),
(8, 'jhfjv@kjhgj.lkjb', '1532e48e4d9aa249098f9301c2a48bd5977f9091', 1, 10),
(9, 'uytuygigi@gmail.com', 'be0df39d6efe0298610733e5ce48a14ad257ebb8', 1, 11),
(10, 'araliya@gmail.com', 'e61e2173c4b2f51919eb2225be46ee0e36a1e313', 1, 32),
(12, 'gune@gmail.com', '1f731b831686ed3c3ab9cc9768dc5222ca54bd68', 1, 34),
(14, 'efelfh@gmail.com', '1f731b831686ed3c3ab9cc9768dc5222ca54bd68', 1, 36),
(15, 'hgfjgcj@gjgjhv.lk', '68f086b0626249cd5b2867e6bc29dc95ae837b0e', 1, 37),
(16, 'hgfjgcj@g99hv.lk', '5e277cd9966be37a8bccb004d047321e5bfec387', 1, 38),
(17, 'shevan.fernando99@gmail.com', '7ce77bf9c6692511001cc68ba995a68576315aaf', 1, 39),
(19, 'shevan.fernando98@gmail.com', 'e61e2173c4b2f51919eb2225be46ee0e36a1e313', 1, 41),
(20, 'Sheyara@gmail.com', '304694b959470a198a141a29f46bb20ffe5632c4', 1, 42);

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
(3, 'Delivery Management', 'delivery.png', 'delivery.php', 1),
(4, 'Food Menu Management', 'menu.png', 'menu.php', 1),
(5, 'Sales & POS Management', 'pos.png', 'pos.php', 1),
(6, 'User Management', 'user.png', 'user.php', 1),
(7, 'Events Reservation Management', 'reservation.png', 'reservation.php', 1),
(8, 'Inventory & Stock Management', 'inventory.png', 'inventory.php', 1),
(9, 'Purchasing Management', 'purchasing.png', 'purchasing.php', 1),
(10, 'Advanced Reports', 'Reports.png', 'Reports.png', 1);

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
(3, 'Kitchen Staff', 1),
(4, 'Waiter', 1);

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
(1, 0),
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(2, 3),
(2, 4);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_fname`, `user_lname`, `user_email`, `user_dob`, `user_nic`, `user_image`, `user_role`, `user_status`) VALUES
(1, 'Kamal', 'Perera', 'kamal@esoft.lk', '2024-11-05', '951420321V', '', 1, -1),
(3, 'nimal', 'perera', 'nimal@esoft.lk', '2025-02-20', '990431744V', 'auty.jpg', 1, -1),
(4, 'nimal', 'perera', 'nimal@esoft.lk', '2025-02-20', '990431744V', '', 1, -1),
(11, 'kugu', 'igig', 'uytuygigi@gmail.com', '2025-02-20', '998877667V', '', 1, -1),
(12, 'SHEVAN', 'ANTHONY', 'shevan.fernando99@gmail.com', '2025-03-12', '990431755', '', 1, -1),
(13, 'SHEVAN', 'ANTHONY', 'shevan.fernando99@gmail.com', '2025-03-12', '990431755', '', 1, -1),
(14, 'SHEVAN', 'ANTHONY', 'hgfgc@hfjg.hkh', '2025-03-12', '990431749', '', 1, -1),
(15, 'SHEVAN', 'ANTHONY', 'hgfgc@hfjg.hkh', '2025-03-12', '990431749', '', 1, -1),
(16, 'SHEVAN', 'ANTHONY', 'hgfgc@hfjg.hkh', '2025-03-12', '990431749', '', 1, -1),
(17, 'SHEVAN', 'ANTHONY', 'hgfgc@hfjg.hkh', '2025-03-12', '990431749', '', 1, -1),
(18, 'jgfjhvj', 'zcdcasdca', 'gvugv@kjhij.lk', '2025-03-13', '990431888V', '', 1, -1),
(19, 'SHEVAN', 'ANTHONY', 'shevan.fernando99@gmail.com', '2025-02-27', '990431748V', '', 1, -1),
(20, 'SHEVANI', 'ANTHONYY', 'shevan.fernando99@gmail.com', '2025-02-27', '990431748V', '', 1, -1),
(21, 'SHEVANI', 'ANTHONYY', 'shevan.fernando99@gmail.com', '2025-02-27', '990431748V', '', 1, -1),
(22, 'Has', 'Pur', 'fernando99@gmail.com', '2025-03-05', '990431748V', '', 1, -1),
(23, 'ara', 'liya', 'ara@gmail.com', '2025-03-11', '990431745V', '', 1, -1),
(24, 'araliya', 'alwis', 'araliya@gmail.com', '2025-03-11', '990431745V', '', 1, 1),
(25, 'araliya', 'alwis', 'araliya@gmail.com', '2025-03-11', '990431745V', '', 1, 1),
(26, 'araliya', 'alwis', 'araliya@gmail.com', '2025-03-11', '990431745V', '', 1, 1),
(27, 'araliya', 'alwis', 'araliya@gmail.com', '2025-03-11', '990431745V', '', 1, 1),
(28, 'araliyaa', 'alwis', 'araliya@gmail.com', '2025-03-11', '990431745V', '', 1, 1),
(29, 'araliyaa', 'alwis', 'araliya@gmail.com', '2025-03-11', '990431745V', '', 1, 1),
(30, 'araliyaa', 'alwis', 'araliya@gmail.com', '2025-03-11', '990431745V', '', 1, 1),
(31, 'Araliya', 'Alwis', 'araliya@gmail.com', '2025-03-12', '990431755V', '', 1, 1),
(32, 'Araliya', 'Alwis', 'araliya@gmail.com', '2025-03-12', '990431755V', '', 1, 1),
(33, 'Araliya', 'Alwis', 'araliya@gmail.com', '2025-03-12', '990431755V', '', 1, 1),
(34, 'Tharushi', 'Gunasekara', 'gune@gmail.com', '2025-03-12', '990431748V', '', 1, 1),
(35, 'Tharushi', 'Gunasekara', 'gune@gmail.com', '2025-03-12', '990431748V', '', 1, 1),
(36, 'fheoe', 'eoifhoei', 'efelfh@gmail.com', '2025-03-12', '990431748V', '', 1, 1),
(37, 'yfjffgjgh', 'jfvfhfcv', 'hgfjgcj@gjgjhv.lk', '2025-03-26', '880076532V', '', 1, -1),
(38, 'yfjffgjgfgdhgf', 'jfvfhfcv8ghjf', 'hgfjgcj@g99hv.lk', '2025-03-26', '890076532V', '', 2, -1),
(39, 'SHEVAN', 'ANTHONY', 'shevan.fernando99@gmail.com', '2025-03-20', '990431798V', '', 1, 1),
(40, 'SHEVAN', 'ANTHONY', 'shevan.fernando99@gmail.com', '2025-03-20', '990431798V', '', 1, 1),
(41, 'SHEVAN', 'ANTHONY', 'shevan.fernando98@gmail.com', '2025-03-26', '990431755V', '', 1, 1),
(42, 'Shehara', 'Fernando', 'Sheyara@gmail.com', '2025-04-02', '990431955V', '', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_contact`
--

CREATE TABLE `user_contact` (
  `contact_id` int(11) NOT NULL,
  `contact_number` int(10) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_contact`
--

INSERT INTO `user_contact` (`contact_id`, `contact_number`, `user_id`) VALUES
(1, 2147483647, 41),
(2, 2147483647, 41),
(3, 2147483647, 42),
(4, 2147483647, 42);

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
-- Indexes for table `user_contact`
--
ALTER TABLE `user_contact`
  ADD PRIMARY KEY (`contact_id`);

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
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user_contact`
--
ALTER TABLE `user_contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
