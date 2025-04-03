-- Step 1: Add new columns to the orders table
ALTER TABLE `orders` 
ADD COLUMN `reference_number` VARCHAR(20) AFTER `id`,
ADD COLUMN `email` VARCHAR(100) AFTER `phone`,
ADD COLUMN `notes` TEXT AFTER `email`,
ADD COLUMN `customer_name` VARCHAR(100) AFTER `user_id`,
ADD COLUMN `payment_method` VARCHAR(50) AFTER `status`,
ADD COLUMN `payment_status` ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending' AFTER `payment_method`,
ADD COLUMN `total_amount` DECIMAL(10,2) AFTER `delivery_cost`,
ADD COLUMN `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Step 2: Create an order tracking table to monitor status changes (optional)
CREATE TABLE `order_tracking` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `status` VARCHAR(50) NOT NULL,
  `notes` TEXT,
  `created_by` VARCHAR(50) DEFAULT 'system',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_tracking_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
