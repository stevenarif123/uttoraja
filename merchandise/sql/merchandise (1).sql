-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Apr 2025 pada 10.42
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
(2, 'fannycantik', '$2y$10$nl52rfQG7ysnFDD5iB0mnuIIETANauGvUXq3bNptcVL0C8hDrsI/u', 'Fanny', '2025-02-24 02:52:15'),
(3, 'admin2', '$2y$10$hashedpassword', 'Admin Name', '2025-03-04 03:03:57');

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
(7, NULL, '2025-02-23 17:42:43', 'canceled', 'express', 20000.00, '0', '6282293924242'),
(8, NULL, '2025-03-04 11:59:29', 'pending', NULL, 0.00, NULL, NULL),
(9, NULL, '2025-03-26 16:04:07', 'pending', 'standard', 10000.00, '0', '6282293924242'),
(10, NULL, '2025-03-26 16:59:50', 'pending', NULL, 0.00, NULL, NULL);

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
(11, 7, NULL, 1, NULL, 100000.00),
(12, 8, 2, 2, NULL, 70000.00),
(13, 9, 2, 1, NULL, 70000.00),
(14, 9, 1, 1, NULL, 200000.00),
(15, 10, 1, 1, NULL, 200000.00);

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
(1, 'Baju Almamater', 'baju Almamater UT', 150000.00, 200000.00, '67ee36e908f06.jpg', NULL, 'Apparel', 1, 1),
(2, 'Topi UT', 'Topi dengan tulisan UT', 50000.00, 70000.00, '67bbf82c47ed0_316059194_634429251797308_7201826121817591657_n.jpeg', NULL, 'Headwear', 1, 0),
(3, 'Product Name', 'Description', 100000.00, 120000.00, 'image.jpg', NULL, NULL, 1, 0),
(4, 'UT Notebook', 'Spiral notebook with UTToraja logo', 25000.00, 30000.00, NULL, NULL, 'Stationery', 1, 0),
(5, 'UTToraja Mug', 'Ceramic mug with UTToraja logo', 45000.00, 60000.00, NULL, NULL, 'Accessories', 1, 1),
(6, 'UTToraja Lanyard', 'ID card holder with UTToraja colors', 15000.00, 20000.00, NULL, NULL, 'Accessories', 1, 0),
(7, 'UTToraja Hoodie', 'Warm hoodie with embroidered UTToraja logo', 200000.00, 250000.00, '67ee37022e468.jpg', NULL, 'Apparel', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `sort_order`, `created_at`) VALUES
(12, 1, '67ee36e908f06.jpg', 1, 0, '2025-04-03 08:29:18'),
(13, 2, '67bbf82c47ed0_316059194_634429251797308_7201826121817591657_n.jpeg', 1, 0, '2025-04-03 08:29:18'),
(14, 3, 'image.jpg', 1, 0, '2025-04-03 08:29:18'),
(15, 7, '67ee37022e468.jpg', 1, 0, '2025-04-03 08:29:18'),
(19, 1, '67bbf7773fc87_id-11134207-7r98y-lnklpmw7aikmc0.jpeg', 1, 0, '2025-04-03 08:29:18'),
(20, 2, '67bbf82c47ed0_316059194_634429251797308_7201826121817591657_n.jpeg', 1, 0, '2025-04-03 08:29:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `size`, `stock`) VALUES
(2, 2, 'All Size', 20),
(3, 3, 'A5', 50),
(4, 4, 'Standard', 30),
(5, 5, 'Standard', 100),
(6, 6, 'S', 10),
(7, 6, 'M', 15),
(8, 6, 'L', 20),
(9, 6, 'XL', 10),
(10, 1, 'All Size', 70),
(11, 7, 'All Size', 10);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_active` (`active`);

--
-- Indeks untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `idx_product_size` (`product_id`,`size`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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

--
-- Ketidakleluasaan untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
