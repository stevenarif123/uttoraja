-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Mar 2025 pada 03.48
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `merchandise`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `name`, `created_at`) VALUES
(1, 'admin', '$2y$10$8FKqYmrPIb8wFxP5YHKpGOE5YR6E3A4ZgXqDXf8.IXqzGBGwzHKYi', 'Administrator', '2025-02-24 02:45:54'),
(2, 'fannycantik', '$2y$10$nl52rfQG7ysnFDD5iB0mnuIIETANauGvUXq3bNptcVL0C8hDrsI/u', 'Fanny', '2025-02-24 02:52:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` enum('pending','completed','canceled') NOT NULL,
  `delivery_method` varchar(50) DEFAULT NULL,
  `delivery_cost` decimal(10,2) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `status`, `delivery_method`, `delivery_cost`, `address`, `phone`) VALUES
(1, NULL, '2025-02-20 17:39:00', 'canceled', NULL, NULL, NULL, NULL),
(2, NULL, '2025-02-20 17:39:14', 'canceled', NULL, NULL, NULL, NULL),
(3, NULL, '2025-02-22 17:33:58', 'canceled', 'standard', 10000.00, '0', '6282293924242'),
(4, NULL, '2025-02-22 17:34:07', 'canceled', 'standard', 10000.00, '0', '6282293924242'),
(5, NULL, '2025-02-23 17:27:29', 'canceled', 'express', 20000.00, '0', '6282293924242'),
(6, NULL, '2025-02-23 17:27:39', 'canceled', 'express', 20000.00, '0', '6282293924242'),
(7, NULL, '2025-02-23 17:42:43', 'canceled', 'express', 20000.00, '0', '6282293924242');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `selected_size` varchar(10) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `selected_size`, `price`) VALUES
(2, 3, NULL, 4, NULL, 150000.00),
(3, 3, NULL, 1, NULL, 100000.00),
(4, 4, NULL, 4, NULL, 150000.00),
(5, 4, NULL, 1, NULL, 100000.00),
(6, 5, NULL, 3, NULL, 150000.00),
(7, 5, NULL, 1, NULL, 100000.00),
(8, 6, NULL, 3, NULL, 150000.00),
(9, 6, NULL, 1, NULL, 100000.00),
(10, 7, NULL, 3, NULL, 150000.00),
(11, 7, NULL, 1, NULL, 100000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price_student` decimal(10,2) NOT NULL,
  `price_guest` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `size_options` varchar(255) DEFAULT NULL COMMENT 'Comma-separated list of available sizes',
  `category` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `featured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price_student`, `price_guest`, `image`, `size_options`, `category`, `active`, `featured`) VALUES
(1, 'Baju Almamater', 'baju Almamater UT', 150000.00, 200000.00, '67bbf7773fc87_id-11134207-7r98y-lnklpmw7aikmc0.jpeg', NULL, 'Apparel', 1, 1),
(2, 'Topi UT', 'Topi dengan tulisan UT', 50000.00, 70000.00, '67bbf82c47ed0_316059194_634429251797308_7201826121817591657_n.jpeg', NULL, 'Headwear', 1, 0);

-- --------------------------------------------------------

-- Add new table for product sizes and stock
CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sample data for product_sizes
INSERT INTO product_sizes (product_id, size, stock) VALUES 
(1, 'S', 20),
(1, 'M', 25),
(1, 'L', 15),
(1, 'XL', 10),
(2, 'All Size', 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('student','guest') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nim`, `tanggal_lahir`, `name`, `email`, `role`) VALUES
(1, '123456789', '2024-02-01', 'Akhbar M. A.', 'akhbar@gmail.com', 'student');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

-- Remove stock column from products table
ALTER TABLE `products` DROP COLUMN `stock`;

-- Common Database Operations
-- Update stock level
UPDATE product_sizes 
SET stock = stock - 1 
WHERE product_id = 1 AND size = 'M';

-- Check stock level
SELECT p.name, ps.size, ps.stock 
FROM products p 
JOIN product_sizes ps ON p.id = ps.product_id 
WHERE ps.stock < 10;

-- Add new size to existing product
INSERT INTO product_sizes (product_id, size, stock) 
VALUES (1, 'XXL', 5);

-- Remove size from product
DELETE FROM product_sizes 
WHERE product_id = 1 AND size = 'XXL';

-- Update multiple sizes stock levels
UPDATE product_sizes 
SET stock = CASE 
    WHEN size = 'S' THEN 15
    WHEN size = 'M' THEN 20
    WHEN size = 'L' THEN 25
    ELSE stock
END
WHERE product_id = 1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
