
-- INSERT DATA

-- Add new admin
INSERT INTO admins (username, password, name) 
VALUES ('admin2', '$2y$10$hashedpassword', 'Admin Name');

-- Add new product
INSERT INTO products (name, description, price_student, price_guest, image) 
VALUES ('Product Name', 'Description', 100000.00, 120000.00, 'image.jpg');

-- Add product sizes and stock
INSERT INTO product_sizes (product_id, size, stock) 
VALUES 
(1, 'S', 10),
(1, 'M', 15),
(1, 'L', 20);

-- Add new order
INSERT INTO orders (user_id, status, delivery_method, delivery_cost, address, phone) 
VALUES (1, 'pending', 'standard', 10000.00, 'Delivery Address', '08123456789');

-- Add order items
INSERT INTO order_items (order_id, product_id, quantity, selected_size, price) 
VALUES (1, 1, 2, 'M', 100000.00);

-- DELETE DATA

-- Delete product (will cascade to product_sizes)
DELETE FROM products WHERE id = 1;

-- Delete specific size stock
DELETE FROM product_sizes WHERE product_id = 1 AND size = 'S';

-- Delete order (will cascade to order_items)
DELETE FROM orders WHERE id = 1;

-- Delete specific order item
DELETE FROM order_items WHERE id = 1;

-- Delete admin
DELETE FROM admins WHERE id = 1;

-- UPDATE DATA

-- Update product stock
UPDATE product_sizes 
SET stock = stock - 1 
WHERE product_id = 1 AND size = 'M';

-- Update order status
UPDATE orders 
SET status = 'completed' 
WHERE id = 1;

-- Update product prices
UPDATE products 
SET price_student = 110000.00, 
    price_guest = 130000.00 
WHERE id = 1;
