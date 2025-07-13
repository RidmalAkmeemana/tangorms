-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2025 at 03:55 PM
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
(14, 'Starters / Appetizers', 1),
(15, 'Soups', 1),
(16, 'Salads', 1),
(17, 'Rice & Curry', 1),
(18, 'Pasta', 1),
(19, 'Burgers & Sandwiches', 1),
(20, 'Pizza (10”)', 1),
(21, 'Mains (Grilled / Fried)', 1),
(22, 'Desserts', 1),
(23, 'Beverages', 1);

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
(5, '199826600204', 'Tharindu Deshan Nawagamuwa', '0773698081', 'No: 30, Kalaiya Rd, IDH', 1),
(6, '199826600255', 'Diluka Hewage', '0773698111', NULL, 1);

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
(107, 'New Sale', 'pos-sale.php', 4, 1),
(108, 'Duplicate Receipt', 'duplicate-receipt.php', 4, 1),
(109, 'View Orders', 'view-orders.php', 4, 1),
(110, 'Edit Order', 'edit-order.php', 4, 1),
(111, 'Kitchen Management', 'kitchen.php', 2, 1),
(112, 'View Orders', 'view-kitchen-orders.php', 2, 1),
(113, 'Kitchen Report', 'kitchen-report.php', 2, 1),
(114, 'Edit Order Status', 'edit-kitchen-order.php', 2, 1),
(115, 'Waiter Management', 'waiter.php', 11, 1),
(116, 'View Orders', 'view-waiter-orders.php', 11, 1),
(117, 'Waiter Report', 'waiter-report.php', 11, 1),
(118, 'Edit Order Status', 'edit-waiter-order.php', 11, 1),
(119, 'Delivery Management', 'delivery.php', 12, 1),
(120, 'View Orders', 'view-delivery-orders.php', 12, 1),
(121, 'Edit Order Status', 'edit-delivery-order.php', 12, 1),
(122, 'Delivery Report', 'delivery-report.php', 12, 1),
(123, 'Purchasing Management', 'purchasing.php', 8, 1),
(124, 'View Orders', 'receipt-payment.php', 8, 1),
(125, 'Payment Reversal', 'payment-reversal.php', 8, 1),
(126, 'Pay Receipt', 'pay-now.php', 8, 1),
(127, 'Reverse Payment', 'reverse-now.php', 8, 1),
(128, 'Purchasing Report', 'purchasing-report.php', 8, 1),
(129, 'Events Reservation Management', 'reservation.php', 6, 1),
(130, 'Add Reservation', 'add-reservation.php', 6, 1),
(131, 'Veiw Reservations', 'view-reservations.php', 6, 1),
(133, 'Edit Reservation', 'edit-reservation.php', 6, 1),
(135, 'Reservation Report', 'reservation-report.php', 6, 1),
(136, 'Advanced Reports', 'reports.php', 9, 1),
(137, 'Sales Report', 'sales-report.php', 9, 1),
(138, 'Customer Outstanding Report', 'customer-outstanding-report.php', 9, 1),
(139, 'Payment Report', 'payment-report.php', 9, 1),
(140, 'View Sales Report', 'view-sales-report.php', 9, 1),
(141, 'View Outstanding Report', 'view-outstanding-report.php', 9, 1),
(142, 'View Payment Report', 'view-payment-report.php', 9, 1);

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
(15, 'APP001', 'Vegetable Spring Rolls', 'Crispy rolls filled with mixed vegetables and served with sweet chili sauce.', 450.00, 14, '1752131702_download.jpeg', 50, 1, '2025-07-10 07:15:02'),
(16, 'APP002', 'Chicken Wings (6 pcs)', 'Tender chicken wings tossed in a spicy BBQ or honey glaze.', 750.00, 14, '1752131771_download (1).jpeg', 44, 1, '2025-07-12 05:22:22'),
(17, 'APP003', 'Garlic Bread with Cheese', 'Oven-baked bread slices topped with garlic butter and melted cheese.', 500.00, 14, '1752131825_download (2).jpeg', 50, 1, '2025-07-10 07:17:05'),
(18, 'SOU001', 'Tom Yum Soup (Chicken)', 'Thai-style sour and spicy soup with chicken, lemongrass, and mushrooms.', 700.00, 15, '1752131910_download (3).jpeg', 44, 1, '2025-07-12 04:31:16'),
(19, 'SOU002', 'Cream of Mushroom Soup', 'Smooth and creamy mushroom soup with a touch of herbs.', 550.00, 15, '1752131951_download (4).jpeg', 49, 1, '2025-07-13 04:21:08'),
(20, 'SOU003', 'Hot & Sour Soup (Veg)', 'Classic Indo-Chinese soup with a tangy kick and mixed veggies.', 600.00, 15, '1752132014_download (5).jpeg', 49, 1, '2025-07-10 18:15:14'),
(21, 'SAL001', 'Caesar Salad with Chicken', 'Romaine lettuce, grilled chicken, parmesan, croutons, and Caesar dressing.', 850.00, 16, '1752132090_download (6).jpeg', 47, 1, '2025-07-12 05:23:01'),
(22, 'SAL002', 'Greek Salad', 'Cucumber, tomato, onion, olives, feta cheese, and olive oil vinaigrette.', 750.00, 16, '1752132281_download (7).jpeg', 50, 1, '2025-07-10 07:24:41'),
(23, 'SAL003', 'Mixed Garden Salad', 'A colorful mix of fresh seasonal vegetables and dressing.', 650.00, 16, '1752132322_download (8).jpeg', 50, 1, '2025-07-10 07:25:22'),
(24, 'RNC001', 'Chicken Rice & Curry', 'Steamed rice served with chicken curry, dhal, sambol, and veggies.', 1200.00, 17, '1752132390_download (9).jpeg', 96, 1, '2025-07-10 11:52:52');

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
(10, 'Role Management', 'role.png', 'role.php', 1),
(11, 'Waiter Management', 'Waiter.png', 'waiter.php', 1),
(12, 'Delivery Management', 'delivery.png', 'delivery.php', 1);

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
  `order_status` enum('Pending','Ready','Preparing','Served','Delivering','Completed','Rejected','Canceled') NOT NULL,
  `reason` varchar(150) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `order_priority` enum('Low','Moderate','High') NOT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_date` timestamp NULL DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Id`, `receipt_no`, `customer_id`, `payment_status`, `sub_total_amount`, `discount`, `total_amount`, `paid_amount`, `balance`, `due_amount`, `payment_method`, `order_type`, `order_status`, `reason`, `table_id`, `order_priority`, `invoice_date`, `payment_date`, `last_update`) VALUES
(76, 'TANGOREC00001', 5, 'Fully Paid', 3150.00, 0.00, 3150.00, 3150.00, 0.00, 0.00, 'Card', 'Dine-In', 'Completed', NULL, 28, 'Moderate', '2025-07-10 07:31:50', '2025-07-10 04:01:50', '2025-07-10 13:56:06'),
(77, 'TANGOREC00002', 2, 'Fully Paid', 2900.00, 0.00, 2900.00, 3000.00, 100.00, 0.00, 'Card', 'Dine-In', 'Completed', NULL, 26, 'High', '2025-07-10 08:57:57', '2025-07-10 05:27:57', '2025-07-10 13:56:15'),
(78, 'TANGOREC00003', 6, 'Fully Paid', 700.00, 0.00, 700.00, 700.00, 0.00, 0.00, 'Cash', 'Take-Away', 'Completed', NULL, NULL, 'Moderate', '2025-07-10 09:30:08', '2025-07-12 04:32:21', '2025-07-12 04:32:21'),
(79, 'TANGOREC00004', 6, 'Fully Paid', 2400.00, 0.00, 2400.00, 2400.00, 0.00, 0.00, 'Cash', 'Delivery', 'Completed', NULL, NULL, 'Moderate', '2025-07-10 11:52:52', '2025-07-10 08:22:52', '2025-07-10 13:55:45'),
(80, 'TANGOREC00005', 6, 'Fully Paid', 600.00, 0.00, 600.00, 600.00, 0.00, 0.00, 'Cash', 'Take-Away', 'Completed', NULL, NULL, 'Moderate', '2025-07-10 18:15:13', '2025-07-12 04:31:49', '2025-07-13 04:27:59'),
(81, 'TANGOREC00006', 2, 'Fully Paid', 2200.00, 0.00, 2200.00, 2200.00, 0.00, 0.00, 'Cash', 'Dine-In', 'Completed', NULL, 19, 'Low', '2025-07-10 18:15:53', '2025-07-12 04:32:36', '2025-07-13 04:28:06'),
(82, 'TANGOREC00007', 6, 'Fully Paid', 1400.00, 5.00, 1330.00, 1330.00, 0.00, 0.00, 'Card', 'Take-Away', 'Completed', NULL, NULL, 'Moderate', '2025-07-12 04:31:16', '2025-07-12 04:31:16', '2025-07-13 04:28:11'),
(83, 'TANGOREC00008', 5, 'Fully Paid', 1600.00, 0.00, 1600.00, 1600.00, 0.00, 0.00, 'Cash', 'Dine-In', 'Completed', NULL, 27, 'Moderate', '2025-07-12 05:22:22', '2025-07-12 05:22:22', '2025-07-13 04:28:18'),
(84, 'TANGOREC00009', 2, 'Fully Paid', 1700.00, 0.00, 1700.00, 1700.00, 0.00, 0.00, 'Bank Transfer', 'Delivery', 'Completed', NULL, NULL, 'Moderate', '2025-07-12 05:23:01', '2025-07-12 06:03:25', '2025-07-13 04:28:23'),
(85, 'TANGOREC00010', 2, 'Unpaid', 550.00, 0.00, 550.00, 0.00, 0.00, 550.00, 'Cash', 'Dine-In', 'Completed', NULL, 18, 'Low', '2025-07-13 04:21:08', NULL, '2025-07-13 04:24:25');

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
(115, 'TANGOREC00001', 'RNC001', 'Chicken Rice & Curry', 1200.00, 2, 2400.00),
(116, 'TANGOREC00001', 'APP002', 'Chicken Wings (6 pcs)', 750.00, 1, 750.00),
(117, 'TANGOREC00002', 'APP002', 'Chicken Wings (6 pcs)', 750.00, 2, 1500.00),
(118, 'TANGOREC00002', 'SOU001', 'Tom Yum Soup (Chicken)', 700.00, 2, 1400.00),
(119, 'TANGOREC00003', 'SOU001', 'Tom Yum Soup (Chicken)', 700.00, 1, 700.00),
(120, 'TANGOREC00004', 'RNC001', 'Chicken Rice & Curry', 1200.00, 2, 2400.00),
(121, 'TANGOREC00005', 'SOU003', 'Hot & Sour Soup (Veg)', 600.00, 1, 600.00),
(122, 'TANGOREC00006', 'APP002', 'Chicken Wings (6 pcs)', 750.00, 2, 1500.00),
(123, 'TANGOREC00006', 'SOU001', 'Tom Yum Soup (Chicken)', 700.00, 1, 700.00),
(124, 'TANGOREC00007', 'SOU001', 'Tom Yum Soup (Chicken)', 700.00, 2, 1400.00),
(125, 'TANGOREC00008', 'APP002', 'Chicken Wings (6 pcs)', 750.00, 1, 750.00),
(126, 'TANGOREC00008', 'SAL001', 'Caesar Salad with Chicken', 850.00, 1, 850.00),
(127, 'TANGOREC00009', 'SAL001', 'Caesar Salad with Chicken', 850.00, 2, 1700.00),
(128, 'TANGOREC00010', 'SOU002', 'Cream of Mushroom Soup', 550.00, 1, 550.00);

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
(60, 'TANGOREC00001', 1, 3150.00, 3150.00, 0.00, 0.00, 'Card', '2025-07-10 07:31:50'),
(61, 'TANGOREC00002', 1, 2900.00, 3000.00, 100.00, 0.00, 'Card', '2025-07-10 08:57:57'),
(62, 'TANGOREC00004', 1, 2400.00, 2400.00, 0.00, 0.00, 'Cash', '2025-07-10 11:52:52'),
(63, 'TANGOREC00006', 1, 2200.00, 1500.00, 0.00, 700.00, 'Cash', '2025-07-10 18:15:53'),
(69, 'TANGOREC00006', 2, 2200.00, 600.00, 0.00, 100.00, 'Card', '2025-07-12 04:30:13'),
(70, 'TANGOREC00007', 1, 1330.00, 1330.00, 0.00, 0.00, 'Card', '2025-07-12 04:31:16'),
(71, 'TANGOREC00005', 1, 600.00, 600.00, 0.00, 0.00, 'Cash', '2025-07-12 04:31:49'),
(72, 'TANGOREC00003', 1, 700.00, 700.00, 0.00, 0.00, 'Cash', '2025-07-12 04:32:21'),
(73, 'TANGOREC00006', 3, 2200.00, 100.00, 0.00, 0.00, 'Cash', '2025-07-12 04:32:36'),
(74, 'TANGOREC00008', 1, 1600.00, 1600.00, 0.00, 0.00, 'Cash', '2025-07-12 05:22:22'),
(78, 'TANGOREC00009', 1, 1700.00, 1700.00, 0.00, 0.00, 'Bank Transfer', '2025-07-12 06:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `Id` int(11) NOT NULL,
  `reservation_no` varchar(30) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `reservation_status` enum('Reserved','Canceled') NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `reserved_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`Id`, `reservation_no`, `customer_id`, `reservation_status`, `table_id`, `reserved_date`) VALUES
(93, 'TANGORES00007', 2, 'Reserved', 18, '2025-07-12 18:30:00'),
(94, 'TANGORES00008', 5, 'Reserved', 20, '2025-07-13 18:30:00');

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
(3, 'Cashier', 1),
(4, 'Data Entry Clerk', 1),
(5, 'Delivery Rider', 1),
(19, 'Waiter', 1),
(20, 'Chef', 1);

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
(1, 108),
(1, 109),
(1, 110),
(1, 111),
(1, 112),
(1, 113),
(1, 114),
(1, 115),
(1, 116),
(1, 117),
(1, 118),
(1, 119),
(1, 120),
(1, 121),
(1, 122),
(1, 123),
(1, 124),
(1, 125),
(1, 126),
(1, 127),
(1, 128),
(1, 129),
(1, 130),
(1, 131),
(1, 133),
(1, 135),
(1, 136),
(1, 137),
(1, 138),
(1, 139),
(1, 140),
(1, 141),
(1, 142),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 32),
(2, 33),
(2, 34),
(2, 89),
(2, 90),
(2, 91),
(2, 92),
(2, 93),
(2, 94),
(2, 95),
(2, 96),
(2, 97),
(2, 98),
(2, 99),
(2, 100),
(2, 101),
(2, 103),
(2, 104),
(2, 105),
(2, 106),
(2, 107),
(2, 108),
(2, 109),
(2, 110),
(2, 111),
(2, 112),
(2, 113),
(2, 114),
(2, 115),
(2, 116),
(2, 117),
(2, 118),
(3, 99),
(3, 100),
(3, 101),
(3, 104),
(3, 105),
(3, 106),
(3, 107),
(3, 108),
(3, 109),
(3, 110),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 8),
(4, 9),
(4, 10),
(4, 14),
(4, 15),
(4, 16),
(4, 19),
(4, 21),
(4, 22),
(4, 24),
(4, 25),
(4, 26),
(4, 27),
(4, 28),
(4, 29),
(4, 30),
(4, 32),
(4, 33),
(4, 34),
(4, 89),
(4, 90),
(4, 91),
(4, 92),
(4, 93),
(4, 95),
(4, 96),
(4, 98),
(5, 119),
(5, 120),
(5, 121),
(5, 122),
(19, 115),
(19, 116),
(19, 117),
(19, 118),
(20, 111),
(20, 112),
(20, 113),
(20, 114);

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
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 7),
(2, 10),
(2, 11),
(3, 4),
(4, 1),
(4, 3),
(4, 5),
(4, 7),
(4, 10),
(5, 12),
(19, 11),
(20, 2);

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
(23, 'Event Area', '1752130707_Event Area.png', 1),
(24, 'Family Area', '1752130720_Family Area.png', 1),
(25, 'Couple Area', '1752130734_Couple Area.png', 1);

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
(18, 'Table 01', 6, 'Reserved', 23),
(19, 'Table 02', 6, 'Vacant', 23),
(20, 'Table 03', 4, 'Reserved', 24),
(21, 'Table 04', 4, 'Vacant', 24),
(22, 'Table 05', 4, 'Vacant', 24),
(23, 'Table 06', 4, 'Vacant', 24),
(24, 'Table 07', 2, 'Vacant', 25),
(25, 'Table 08', 2, 'Vacant', 25),
(26, 'Table 09', 2, 'Vacant', 25),
(27, 'Table 10', 2, 'Vacant', 25),
(28, 'Table 11', 2, 'Vacant', 25),
(29, 'Table 12', 2, 'Vacant', 25);

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
(1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `temp_reservation`
--

CREATE TABLE `temp_reservation` (
  `id` int(1) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_reservation`
--

INSERT INTO `temp_reservation` (`id`, `value`) VALUES
(1, 9);

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
(49, 'Nilesh', 'Akmeemana', 'nilesh@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-04-06', '200326600203', '', 20, 1, '0773456060'),
(57, 'Ridmal', 'Akmeemana', 'rajeewaakmeemana@gmail.com', '202cb962ac59075b964b07152d234b70', '1998-09-22', '199826600203', '', 1, 1, '0773697070'),
(69, 'Inula', 'Januka', 'inula@gmail.com', '202cb962ac59075b964b07152d234b70', '2003-11-14', '200326600440', '', 4, 1, '0773456060'),
(70, 'Miranga', 'Senarathna', 'miranga@sits.lk', '202cb962ac59075b964b07152d234b70', '1988-06-15', '881441756V', '', 19, 1, '0714568822'),
(71, 'Kamal', 'Perera', 'kamal@esoft.lk', '202cb962ac59075b964b07152d234b70', '2025-07-07', '605120458V', '', 3, 1, '0742587744'),
(72, 'Bhagya', 'Dilhara', 'bhagya@sits.lk', '202cb962ac59075b964b07152d234b70', '1997-06-18', '975120458V', '', 5, 1, '0773456060');

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
  ADD KEY `Invoice_Id` (`receipt_no`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Invoice_Id` (`reservation_no`),
  ADD UNIQUE KEY `Invoice_No` (`reservation_no`),
  ADD UNIQUE KEY `Invoice_Id_2` (`reservation_no`),
  ADD UNIQUE KEY `receipt_no` (`reservation_no`),
  ADD KEY `Customer_Id` (`customer_id`);

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
-- Indexes for table `temp_reservation`
--
ALTER TABLE `temp_reservation`
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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `function`
--
ALTER TABLE `function`
  MODIFY `function_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `table`
--
ALTER TABLE `table`
  MODIFY `table_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `temp_invoice`
--
ALTER TABLE `temp_invoice`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `temp_reservation`
--
ALTER TABLE `temp_reservation`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

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
