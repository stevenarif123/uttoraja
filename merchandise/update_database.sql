
-- First, create the new product_sizes table
CREATE TABLE IF NOT EXISTS `product_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Migrate existing stock data to the new table
INSERT INTO product_sizes (product_id, size, stock)
SELECT id, 
       COALESCE(SUBSTRING_INDEX(size_options, ',', 1), 'All Size') as size, 
       stock 
FROM products 
WHERE stock > 0;

-- Remove stock column from products table
ALTER TABLE `products` DROP COLUMN IF EXISTS `stock`;

-- Drop size_options if you don't need it anymore (optional)
-- ALTER TABLE `products` DROP COLUMN IF EXISTS `size_options`;

-- Update order_items table to ensure it has selected_size column
ALTER TABLE `order_items` 
ADD COLUMN IF NOT EXISTS `selected_size` varchar(10) AFTER `quantity`;

-- Create an index for faster size lookups
CREATE INDEX IF NOT EXISTS `idx_product_size` 
ON product_sizes (`product_id`, `size`);
