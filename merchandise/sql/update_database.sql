-- Start transaction for safety
START TRANSACTION;

-- First ensure products table has proper structure
-- REMOVED PRIMARY KEY MODIFICATION TO AVOID CONFLICTS
-- Keeping only necessary changes
ALTER TABLE `products` 
MODIFY COLUMN `id` int(11) NOT NULL AUTO_INCREMENT;

-- Drop existing product_sizes table if exists
DROP TABLE IF EXISTS `product_sizes`;

-- Create new product_sizes table with proper foreign key reference
CREATE TABLE `product_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_product_size` (`product_id`, `size`),
  CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) 
    REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert initial stock data
INSERT INTO `product_sizes` (product_id, size, stock)
SELECT id, 'All Size', 10 FROM products WHERE category = 'Headwear'
UNION ALL
SELECT id, 'S', 20 FROM products WHERE category = 'Apparel'
UNION ALL
SELECT id, 'M', 25 FROM products WHERE category = 'Apparel'
UNION ALL
SELECT id, 'L', 15 FROM products WHERE category = 'Apparel'
UNION ALL
SELECT id, 'XL', 10 FROM products WHERE category = 'Apparel';

-- Add helpful indexes
CREATE INDEX IF NOT EXISTS `idx_product_stock` ON product_sizes (`stock`);
CREATE INDEX IF NOT EXISTS `idx_product_size` ON product_sizes (`product_id`, `size`);

COMMIT;
