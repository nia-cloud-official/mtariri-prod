-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2024 at 09:52 PM
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
-- Database: `mtariri`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `phone_number` VARCHAR(15) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`phone_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`phone_number`, `name`, `email`, `password_hash`) VALUES
('715212928', 'Milton Vafana', 'milton.vafana@example.com', 'hashed_password');

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `phone_number` VARCHAR(15),
  `policy_number` VARCHAR(50) NOT NULL,
  `start_date` DATE,
  `end_date` DATE,
  `details` TEXT,
  FOREIGN KEY (`phone_number`) REFERENCES `users`(`phone_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `policies`
--

INSERT INTO `policies` (`phone_number`, `policy_number`, `start_date`, `end_date`, `details`) VALUES
('715212928', 'POL12345', '2024-01-01', '2025-01-01', 'Details about the policy.');

--
-- Table structure for table `claims`
--

CREATE TABLE `claims` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `phone_number` VARCHAR(15),
  `policy_id` INT,
  `claim_date` DATE,
  `status` VARCHAR(50),
  `details` TEXT,
  FOREIGN KEY (`phone_number`) REFERENCES `users`(`phone_number`),
  FOREIGN KEY (`policy_id`) REFERENCES `policies`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `claims`
--

INSERT INTO `claims` (`phone_number`, `policy_id`, `claim_date`, `status`, `details`) VALUES
('715212928', 1, '2024-06-01', 'Pending', 'Details about the claim.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
-- (Already defined in the table creation)

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `id` INT AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `claims`
--
ALTER TABLE `claims`
  MODIFY `id` INT AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
