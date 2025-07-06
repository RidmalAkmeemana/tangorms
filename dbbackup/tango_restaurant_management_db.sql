-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2025 at 10:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_status`) VALUES
(1, 'Breakfast', 1),
(2, 'Lunch', 1),
(3, 'Dinner', 1),
(5, 'Test2', -1),
(6, 'Test', -1),
(7, 'test', -1),
(8, 'effsfs', -1),
(9, 'sdfsf', -1),
(10, 'fefsef', -1),
(11, 'sefsfe', -1),
(12, 'yt8', -1),
(13, 'urtutyu', -1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_nic` varchar(12) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_mobile` varchar(10) NOT NULL,
  `customer_address` varchar(200) DEFAULT NULL,
  `customer_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_nic`, `customer_name`, `customer_mobile`, `customer_address`, `customer_status`) VALUES
(2, '199826600203', 'Ridmal Akmeemana', '0773697070', NULL, 1),
(5, '199826600204', 'Tharindu Deshan Nawagamuwa', '0773698081', 'No: 30, Kalaiya Rd, IDH', 1);

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
(15, 'Add Table', 'add-table.php', 1, 1),
(16, 'View All Tables', 'view-tables.php', 1, 1),
(17, 'User Report', 'user-report.php', 5, 1),
(18, 'Role Report', 'role-report.php', 10, 1),
(19, 'Edit Table', 'edit-table.php', 1, 1),
(20, 'Table Report', 'table-report.php', 1, 1),
(21, 'Add Room', 'add-room.php', 1, 1),
(22, 'View All Rooms', 'view-rooms.php', 1, 1),
(23, 'Room Report', 'room-report.php', 1, 1),
(24, 'View Room', 'view-room.php', 1, 1),
(25, 'Edit Room', 'edit-room.php', 1, 1),
(26, 'Room Delete', 'room_controller.php', 1, 1),
(27, 'Food Menu Management', 'menu.php', 3, 1),
(28, 'Add Category', 'add-category.php', 3, 1),
(29, 'View All Categories', 'view-categories.php', 3, 1),
(30, 'Edit Category', 'edit-category.php', 3, 1),
(32, 'Category Report', 'category-report.php', 3, 1),
(33, 'View Category', 'view-category.php', 3, 1),
(34, 'Category Delete', 'menu_controller.php', 3, 1),
(89, 'Add Item', 'add-item.php', 3, 1),
(90, 'View All Items', 'view-items.php', 3, 1),
(91, 'View Item', 'view-item.php', 3, 1),
(92, 'Edit Item', 'edit-item.php', 3, 1),
(93, 'Item Delete', 'menu_controller.php', 3, 1),
(94, 'Item Report', 'item-report.php', 3, 1),
(95, 'Inventory & Stock Management', 'inventory.php', 7, 1),
(96, 'View All Inventories', 'view-inventories.php', 7, 1),
(97, 'Inventory Report', 'inventory-report.php', 7, 1),
(98, 'Edit Inventory', 'edit-inventory.php', 7, 1),
(99, 'Sales & POS Management', 'pos.php', 4, 1),
(100, 'Add Customer', 'add-customer.php', 4, 1),
(101, 'View All Customers', 'view-customers.php', 4, 1),
(103, 'Customer Delete', 'customer_controller.php', 4, 1),
(104, 'Customer Report', 'customer-report.php', 4, 1),
(105, 'View Customer', 'view-customer.php', 4, 1),
(106, 'Edit Customer', 'edit-customer.php', 4, 1),
(107, 'New Sale', 'pos-sale.php', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `item_code` varchar(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` text DEFAULT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_category` int(100) DEFAULT NULL,
  `item_image` varchar(255) DEFAULT NULL,
  `item_qty` int(1) DEFAULT 1,
  `item_status` int(11) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_code`, `item_name`, `item_description`, `item_price`, `item_category`, `item_image`, `item_qty`, `item_status`, `last_update`) VALUES
(9, 'BUN-B01', 'Breakfast Bun ', 'Breakfast Bun', 150.00, 1, '1751781248_1751690007_images.jpeg', 4, 1, '2025-07-06 19:59:27'),
(10, 'BUN-L01', 'Lunch Bun', 'Lunch Bun', 250.00, 2, '1751705272_1751690007_images.jpeg', 6, 1, '2025-07-06 19:59:27'),
(11, 'BUN-D01', 'Dinner Bun', 'Dinner Bun', 100.00, 3, '1751705220_1751690007_images.jpeg', 10, -1, '2025-07-05 09:12:07'),
(13, 'BRD005', 'Bun', 'Bun', 100.00, 3, '1751708170_1751690007_images.jpeg', 11, -1, '2025-07-05 09:36:50'),
(14, 'BUN-L013', 'Bread', '22', 22.00, 1, '1751708164_1751690007_images.jpeg', 22, -1, '2025-07-05 09:36:47');

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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Id` int(11) NOT NULL,
  `receipt_no` varchar(30) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_status` enum('Fully Paid','Partially Paid','Unpaid') NOT NULL,
  `sub_total_amount` float(10,2) NOT NULL,
  `discount` float(10,2) NOT NULL,
  `total_amount` float(10,2) NOT NULL,
  `paid_amount` float(10,2) NOT NULL,
  `balance` float(10,2) NOT NULL,
  `due_amount` float(10,2) NOT NULL,
  `payment_method` enum('Cash','Card','Bank Transfer','N/A') NOT NULL,
  `order_type` enum('Dine-In','Take-Away','Delivery') NOT NULL,
  `order_status` enum('Pending','Preparing','Served','Delivering','Completed','Rejected','Canceled') NOT NULL,
  `reason` varchar(150) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Id`, `receipt_no`, `customer_id`, `payment_status`, `sub_total_amount`, `discount`, `total_amount`, `paid_amount`, `balance`, `due_amount`, `payment_method`, `order_type`, `order_status`, `reason`, `table_id`, `invoice_date`, `payment_date`) VALUES
(58, 'TANGOREC00001', 2, 'Fully Paid', 800.00, 0.00, 800.00, 800.00, 0.00, 0.00, 'Cash', 'Dine-In', 'Pending', NULL, 7, '2025-07-06 19:58:48', '2025-07-06 16:28:48'),
(59, 'TANGOREC00002', 5, 'Unpaid', 1100.00, 0.00, 1100.00, 0.00, 0.00, 1100.00, 'N/A', 'Dine-In', 'Pending', NULL, 8, '2025-07-06 19:59:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `Id` int(11) NOT NULL,
  `receipt_no` varchar(30) NOT NULL,
  `item_code` varchar(150) NOT NULL,
  `item_name` varchar(250) NOT NULL,
  `item_price` float(10,2) NOT NULL,
  `item_qty` int(11) NOT NULL,
  `total_price` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`Id`, `receipt_no`, `item_code`, `item_name`, `item_price`, `item_qty`, `total_price`) VALUES
(90, 'TANGOREC00001', 'BUN-B01', 'Breakfast Bun ', 150.00, 2, 300.00),
(91, 'TANGOREC00001', 'BUN-L01', 'Lunch Bun', 250.00, 2, 500.00),
(92, 'TANGOREC00002', 'BUN-B01', 'Breakfast Bun ', 150.00, 4, 600.00),
(93, 'TANGOREC00002', 'BUN-L01', 'Lunch Bun', 250.00, 2, 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `Id` int(11) NOT NULL,
  `receipt_no` varchar(30) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `total_amount` float(10,2) NOT NULL,
  `paid_amount` float(10,2) NOT NULL,
  `balance` float(10,2) NOT NULL,
  `due_amount` float(10,2) NOT NULL,
  `payment_method` enum('Cash','Card','Bank Transfer','N/A') NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`Id`, `receipt_no`, `payment_id`, `total_amount`, `paid_amount`, `balance`, `due_amount`, `payment_method`, `payment_date`) VALUES
(52, 'TANGOREC00001', 1, 800.00, 800.00, 0.00, 0.00, 'Cash', '2025-07-06 19:58:49');

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
(8, 'Test', -1),
(9, 'Test', -1),
(13, 'Admin', 1);

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
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 32),
(1, 33),
(1, 34),
(1, 89),
(1, 90),
(1, 91),
(1, 92),
(1, 93),
(1, 94),
(1, 95),
(1, 96),
(1, 97),
(1, 98),
(1, 99),
(1, 100),
(1, 101),
(1, 103),
(1, 104),
(1, 105),
(1, 106),
(1, 107),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 8),
(2, 9),
(2, 10),
(2, 12),
(2, 14),
(2, 15),
(2, 16),
(3, 14),
(3, 15),
(3, 16),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 25),
(3, 26);

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
(1, 3),
(1, 4),
(1, 5),
(1, 7),
(1, 10),
(2, 1),
(2, 5),
(2, 10),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(10) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_layout` varchar(255) DEFAULT NULL,
  `room_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `room_layout`, `room_status`) VALUES
(1, 'PDR 1', 'pdr1.png', 1),
(2, 'PDR 2', 'pdr2.png', 1),
(3, 'PDR 3', 'pdr3.png', 1),
(4, 'Main Dining Area', 'mda.png', 1),
(5, 'Outdoor Dining Area', 'oda.png', 1),
(6, 'Bar & Grill Area\r\n', 'bga.png', 1),
(17, 'Balcony Area', '1751444636_images.jpeg', 1),
(18, 'uyguyh', '1751706852_', -1),
(19, 'uyguyh', '1751707383_', -1),
(20, 'dsdsd', '1751707442_', -1),
(21, 'dfdfdf', '1751707520_', -1),
(22, 'thjg6', '', -1);

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
(7, 'RM1T1', 4, 'Seated', 1),
(8, 'RM1T2', 4, 'Seated', 1),
(9, 'RM1T3', 4, 'Vacant', 1),
(10, 'RM1T4', 1, 'Vacant', 3),
(11, 'RM1T5', 4, 'Vacant', 1),
(12, 'RM1T6', 4, 'Vacant', 1),
(13, 'RM1T7', 2, 'Vacant', 3),
(14, 'Testqq', 2, 'Vacant', 15),
(15, 'BTBL1', 4, 'Vacant', 17),
(16, 'BTBL2', 2, 'Vacant', 17),
(17, '1 Chair Table', 1, 'Vacant', 2);

-- --------------------------------------------------------

--
-- Table structure for table `temp_invoice`
--

CREATE TABLE `temp_invoice` (
  `id` int(1) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_invoice`
--

INSERT INTO `temp_invoice` (`id`, `value`) VALUES
(1, 3);

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
(49, 'Kamal', 'Perera', 'kamal@esoft.lk', '202cb962ac59075b964b07152d234b70', '2025-04-06', '605120458V', '', 3, 1, '0773456060'),
(57, 'Ridmal', 'Akmeemana', 'rajeewaakmeemana@gmail.com', '202cb962ac59075b964b07152d234b70', '1998-09-22', '982660203V', '', 1, 1, '0773697070'),
(61, 'Miranga', 'Senarathna', 'miranga@sits.lk', '202cb962ac59075b964b07152d234b70', '2025-06-24', '881441756V', '', 3, 1, '0773697070'),
(62, 'Anusha', 'Perera', 'anusha@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-06-26', '963133223V', '1750958069_images (1).jpeg', 1, -1, '0773698080'),
(63, 'Janaka', 'Rathnayaka', 'janaka@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-06-19', '963133223V', '', 2, -1, '0773697070'),
(64, 'Miranga', 'Perera', 'miranga@sis.lk', '81dc9bdb52d04dc20036dbd8313ed055', '2025-06-26', '956182015V', '1751016923_images (1).jpeg', 2, -1, '0773697070'),
(65, 'Test', 'Senarathna', 'test@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-06-26', '963133223V', '1751091914_3d-cartoon-baby-genius-photo.jpg', 1, -1, '0773698080'),
(66, 'Test', 'Perera', 'test@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-06-30', '956182015V', '', 1, -1, '0773698080'),
(67, 'dwsd', 'aedawd', 'ridmal.akmeemana@colombo.rezgateway.com', '1d74b99d4aae9c5aab2f6003fee2d8d0', '2025-07-01', '605120458V', '', 2, -1, '0773456060');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_nic` (`customer_nic`);

--
-- Indexes for table `function`
--
ALTER TABLE `function`
  ADD PRIMARY KEY (`function_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `item_code` (`item_code`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Invoice_Id` (`receipt_no`),
  ADD UNIQUE KEY `Invoice_No` (`receipt_no`),
  ADD UNIQUE KEY `Invoice_Id_2` (`receipt_no`),
  ADD UNIQUE KEY `receipt_no` (`receipt_no`),
  ADD KEY `Customer_Id` (`customer_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `receipt_no` (`receipt_no`),
  ADD KEY `Invoice_Id` (`receipt_no`);

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
-- Indexes for table `temp_invoice`
--
ALTER TABLE `temp_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `function`
--
ALTER TABLE `function`
  MODIFY `function_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `table`
--
ALTER TABLE `table`
  MODIFY `table_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `temp_invoice`
--
ALTER TABLE `temp_invoice`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

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
