-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 12, 2024 at 04:23 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `customer-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int UNSIGNED NOT NULL,
  `customer_id` int UNSIGNED NOT NULL,
  `city` varchar(64) NOT NULL,
  `state` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `zipcode` mediumint UNSIGNED NOT NULL,
  `geolat` decimal(10,6) DEFAULT NULL,
  `geolng` decimal(10,6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `customer_id`, `city`, `state`, `zipcode`, `geolat`, `geolng`, `created_at`, `updated_at`) VALUES
(1, 1, 'Springfield', 'ID', 62701, 39.781700, -89.650100, '2024-12-12 12:37:52', '2024-12-12 06:53:46'),
(4, 2, 'Austin', 'TX', 73301, 30.267200, -97.743100, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(5, 3, 'Seattle', 'WA', 98101, 47.606200, -122.332100, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(7, 4, 'Miami', 'FL', 33101, 25.761700, -80.191800, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(8, 5, 'Nashville', 'TN', 37201, 36.162700, -86.781600, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(10, 6, 'Portland', 'OR', 97201, 45.515200, -122.678400, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(11, 7, 'Dallas', 'TX', 75201, 32.776700, -96.797000, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(12, 8, 'Chicago', 'IL', 60601, 41.878100, -87.629800, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(13, 9, 'Boston', 'MA', 2101, 42.360100, -71.058900, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(14, 13, 'San Francisco', 'CA', 94101, 37.774900, -122.419400, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(15, 14, 'Las Vegas', 'NV', 89101, 36.169900, -115.139800, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(16, 15, 'Detroit', 'MI', 48201, 42.331400, -83.045800, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(17, 16, 'Charlotte', 'NC', 28201, 35.227100, -80.843100, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(18, 17, 'San Diego', 'CA', 92101, 32.715700, -117.161100, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(19, 18, 'Orlando', 'FL', 32801, 28.538300, -81.379200, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(20, 19, 'Denver', 'CO', 80204, 39.739200, -104.990300, '2024-12-12 12:37:52', '2024-12-12 12:37:52'),
(21, 20, 'Seattle', 'WA', 98104, 47.606200, -122.332100, '2024-12-12 12:37:52', '2024-12-12 12:37:52');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'johndoe1@example.com', '$2y$10$8Aw744NiMKcWsc7I1VZ9YOG9XfomP0GJ/lTYgOVkn/7uDXJJz7IXS', '2024-12-12 12:37:33', '2024-12-12 08:44:55'),
(2, 'Jane Smith', 'janesmith2@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(3, 'Mary Johnson1', 'maryjohnson3@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 09:02:22'),
(4, 'James Brown', 'jamesbrown4@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(5, 'Patricia Taylor', 'patriciataylor5@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(6, 'Robert Anderson', 'robertanderson6@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(7, 'Michael Thomas', 'michaelthomas7@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(8, 'Linda Jackson', 'lindajackson8@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(9, 'William White', 'williamwhite9@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(13, 'Richard Garcia', 'richardgarcia13@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(14, 'Susan Martinez', 'susanmartinez14@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(15, 'Joseph Robinson', 'josephrobinson15@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(16, 'Jessica Clark', 'jessicaclark16@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(17, 'Charles Lewis', 'charleslewis17@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(18, 'Sarah Walker', 'sarahwalker18@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(19, 'Thomas Hall', 'thomashall19@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33'),
(20, 'Karen Allen', 'karenallen20@example.com', '$2y$10$L3anbIZa.0ZTA6Sh.Y84ie/GObHXZrr8Wh3GQzEb6npD0z1nl6jca', '2024-12-12 12:37:33', '2024-12-12 12:37:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `geo_coords` (`geolat`,`geolng`),
  ADD KEY `fk_customer_id` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
