-- Add missing columns to products table
ALTER TABLE `products` 
ADD COLUMN `category` varchar(50) DEFAULT NULL,
ADD COLUMN `active` tinyint(1) NOT NULL DEFAULT 1,
ADD COLUMN `featured` tinyint(1) NOT NULL DEFAULT 0;

-- Update existing products with categories
UPDATE `products` SET `category` = 'Apparel', `featured` = 1 WHERE `id` = 1;
UPDATE `products` SET `category` = 'Headwear' WHERE `id` = 2;

-- Add index on category for faster filtering
ALTER TABLE `products` ADD INDEX `idx_category` (`category`);

-- Add index on active status for faster queries
ALTER TABLE `products` ADD INDEX `idx_active` (`active`);

-- You might want to add some more product categories for testing
INSERT INTO `products` (`name`, `description`, `price_student`, `price_guest`, `category`, `active`, `featured`) VALUES 
('UT Notebook', 'Spiral notebook with UTToraja logo', 25000.00, 30000.00, 'Stationery', 1, 0),
('UTToraja Mug', 'Ceramic mug with UTToraja logo', 45000.00, 60000.00, 'Accessories', 1, 1),
('UTToraja Lanyard', 'ID card holder with UTToraja colors', 15000.00, 20000.00, 'Accessories', 1, 0),
('UTToraja Hoodie', 'Warm hoodie with embroidered UTToraja logo', 200000.00, 250000.00, 'Apparel', 1, 1);

-- Add sizes for new products
INSERT INTO `product_sizes` (`product_id`, `size`, `stock`) VALUES
(3, 'A5', 50),
(4, 'Standard', 30),
(5, 'Standard', 100),
(6, 'S', 10),
(6, 'M', 15),
(6, 'L', 20),
(6, 'XL', 10);
