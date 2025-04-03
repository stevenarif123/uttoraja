-- Create product_images table if not exists
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Remove any existing entries to avoid duplicates
DELETE FROM `product_images`;

-- Insert existing product images with properly structured data
INSERT INTO `product_images` (`product_id`, `image_path`, `is_primary`, `sort_order`)
SELECT id, image, 1, 0 FROM products 
WHERE image IS NOT NULL AND image != '';

-- IMPORTANT: Make sure these image files exist in your uploads directory
-- If they don't, copy your existing product images with these names

-- Almamater (product_id = 1)
INSERT INTO `product_images` (`product_id`, `image_path`, `is_primary`, `sort_order`) VALUES
(1, '67bbf7773fc87_id-11134207-7r98y-lnklpmw7aikmc0.jpeg', 1, 0);

-- Topi (product_id = 2)
INSERT INTO `product_images` (`product_id`, `image_path`, `is_primary`, `sort_order`) VALUES
(2, '67bbf82c47ed0_316059194_634429251797308_7201826121817591657_n.jpeg', 1, 0);
