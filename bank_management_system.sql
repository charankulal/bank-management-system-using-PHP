-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2024 at 06:53 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_number` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `balance` text NOT NULL,
  `date_opened` date NOT NULL DEFAULT current_timestamp(),
  `branch_id` int(11) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `account`:
--

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_number`, `customer_id`, `balance`, `date_opened`, `branch_id`, `status`) VALUES
('6784251', 5, '40000', '2024-03-23', 7, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `location` text NOT NULL,
  `manager_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `phone_number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `branch`:
--

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `location`, `manager_id`, `email`, `phone_number`) VALUES
(7, 'Mysore', 1, 'charankulal0241@gmail.com', '9108394592');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `phone_number` text NOT NULL,
  `dob` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `customer`:
--

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `username`, `password`, `email`, `address`, `phone_number`, `dob`) VALUES
(4, 'Charan K', 'aa', '81dc9bdb52d04dc20036dbd8313ed055', 'charankulal0241@gmail.com', 'Koppala House, Kukkedi Post and Village', '09108394592', '2024-03-20'),
(5, 'Charan K', 'a1', '6512bd43d9caa6e02c990b0a82652dca', 'charankulal0241@gmail.com', 'Koppala House, Kukkedi Post and Village', '09108394592', '2024-03-20'),
(6, 'charan k', 'aa2', '81dc9bdb52d04dc20036dbd8313ed055', 'charankulal0241@gmail.com', 'kaliya peraje house,nala post, nyayatharpu village,belthangady taluk,dakshina kannada district.', '09108394592', '2024-03-21'),
(7, 'Charan K', 'aa3', '81dc9bdb52d04dc20036dbd8313ed055', 'charankulal0241@gmail.com', 'Koppala House, Kukkedi Post and Village', '09108394592', '2024-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `job_type` text NOT NULL,
  `email` text NOT NULL,
  `phone_number` text NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `employee`:
--

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `name`, `username`, `password`, `job_type`, `email`, `phone_number`, `branch_id`) VALUES
(1, 'Admin', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'admin@bank.com', '9876543210', 1),
(9, 'charan k', 'charan', '81dc9bdb52d04dc20036dbd8313ed055', 'Manager', 'charankulal0241@gmail.com', '09108394592', 7);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `transaction_type` text NOT NULL,
  `amount` text NOT NULL,
  `transaction_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `transaction`:
--   `account_number`
--       `account` -> `account_number`
--

--
-- Triggers `transaction`
--
DELIMITER $$
CREATE TRIGGER `update_balance` BEFORE INSERT ON `transaction` FOR EACH ROW BEGIN

IF NEW.transaction_type = 'Withdraw' THEN
UPDATE account SET balance=balance-NEW.amount WHERE account.account_number = NEW.account_number;

ELSEIF
NEW.transaction_type = 'Deposit' THEN
UPDATE account SET balance=balance+NEW.amount WHERE account.account_number = NEW.account_number;
ELSEIF
NEW.transaction_type = 'Transfer' THEN
UPDATE account SET balance=balance-NEW.amount WHERE account.account_number = NEW.account_number;
END IF;

END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_number`),
  ADD UNIQUE KEY `customer_id` (`customer_id`),
  ADD KEY `account_ibfk_2` (`branch_id`),
  ADD KEY `account_ibfk_1` (`customer_id`) USING BTREE;

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `branch_ibfk_1` (`manager_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `account_number` (`account_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`account_number`) REFERENCES `account` (`account_number`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
