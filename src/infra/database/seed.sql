USE `db_ecommerce`;

-- Inserts for persons

INSERT INTO `persons` VALUES (1, 'Person 1', 'person1@example.com', '555199999991', '2025-07-28 11:47:58');
INSERT INTO `persons` VALUES (2, 'Person 2', 'person2@example.com', '555199999992', '2025-07-28 11:47:58');
INSERT INTO `persons` VALUES (3, 'Person 3', 'person3@example.com', '555199999993', '2025-07-28 11:47:58');
INSERT INTO `persons` VALUES (4, 'Person 4', 'person4@example.com', '555199999994', '2025-07-28 11:47:58');
INSERT INTO `persons` VALUES (5, 'Person 5', 'person5@example.com', '555199999995', '2025-07-28 11:47:58');
INSERT INTO `persons` VALUES (6, 'Person 6', 'person6@example.com', '555199999996', '2025-07-28 11:47:58');
INSERT INTO `persons` VALUES (7, 'Person 7', 'person7@example.com', '555199999997', '2025-07-28 11:47:58');
INSERT INTO `persons` VALUES (8, 'Person 8', 'person8@example.com', '555199999998', '2025-07-28 11:47:58');
INSERT INTO `persons` VALUES (9, 'Person 9', 'person9@example.com', '555199999999', '2025-07-28 11:47:58');
INSERT INTO `persons` VALUES (10, 'Person 10', 'person10@example.com', '5551999999910', '2025-07-28 11:47:58');

-- Inserts for addresses

INSERT INTO `addresses` VALUES (1, 1, 'Street 1', 'Apt 1', 'City', 'State', 'Country', 90000001, '2025-07-28 11:47:58');
INSERT INTO `addresses` VALUES (2, 2, 'Street 2', 'Apt 2', 'City', 'State', 'Country', 90000002, '2025-07-28 11:47:58');
INSERT INTO `addresses` VALUES (3, 3, 'Street 3', 'Apt 3', 'City', 'State', 'Country', 90000003, '2025-07-28 11:47:58');
INSERT INTO `addresses` VALUES (4, 4, 'Street 4', 'Apt 4', 'City', 'State', 'Country', 90000004, '2025-07-28 11:47:58');
INSERT INTO `addresses` VALUES (5, 5, 'Street 5', 'Apt 5', 'City', 'State', 'Country', 90000005, '2025-07-28 11:47:58');
INSERT INTO `addresses` VALUES (6, 6, 'Street 6', 'Apt 6', 'City', 'State', 'Country', 90000006, '2025-07-28 11:47:58');
INSERT INTO `addresses` VALUES (7, 7, 'Street 7', 'Apt 7', 'City', 'State', 'Country', 90000007, '2025-07-28 11:47:58');
INSERT INTO `addresses` VALUES (8, 8, 'Street 8', 'Apt 8', 'City', 'State', 'Country', 90000008, '2025-07-28 11:47:58');
INSERT INTO `addresses` VALUES (9, 9, 'Street 9', 'Apt 9', 'City', 'State', 'Country', 90000009, '2025-07-28 11:47:58');
INSERT INTO `addresses` VALUES (10, 10, 'Street 10', 'Apt 10', 'City', 'State', 'Country', 90000010, '2025-07-28 11:47:58');

-- Inserts for users

INSERT INTO `users` VALUES (1, 1, 'user1', 'password1', 1, '2025-07-28 11:47:58');
INSERT INTO `users` VALUES (2, 2, 'user2', 'password2', 0, '2025-07-28 11:47:58');
INSERT INTO `users` VALUES (3, 3, 'user3', 'password3', 1, '2025-07-28 11:47:58');
INSERT INTO `users` VALUES (4, 4, 'user4', 'password4', 0, '2025-07-28 11:47:58');
INSERT INTO `users` VALUES (5, 5, 'user5', 'password5', 1, '2025-07-28 11:47:58');
INSERT INTO `users` VALUES (6, 6, 'user6', 'password6', 0, '2025-07-28 11:47:58');
INSERT INTO `users` VALUES (7, 7, 'user7', 'password7', 1, '2025-07-28 11:47:58');
INSERT INTO `users` VALUES (8, 8, 'user8', 'password8', 0, '2025-07-28 11:47:58');
INSERT INTO `users` VALUES (9, 9, 'user9', 'password9', 1, '2025-07-28 11:47:58');
INSERT INTO `users` VALUES (10, 10, 'user10', 'password10', 0, '2025-07-28 11:47:58');

-- Inserts for products

INSERT INTO `products` VALUES (1, 'Product 1', 110.95, 11.0, 6.0, 16.0, 2.0, '/product1', '2025-07-28 11:47:58');
INSERT INTO `products` VALUES (2, 'Product 2', 52.86, 12.0, 7.0, 17.0, 3.0, '/product2', '2025-07-28 11:47:58');
INSERT INTO `products` VALUES (3, 'Product 3', 107.43, 13.0, 8.0, 18.0, 4.0, '/product3', '2025-07-28 11:47:58');
INSERT INTO `products` VALUES (4, 'Product 4', 131.46, 14.0, 9.0, 19.0, 5.0, '/product4', '2025-07-28 11:47:58');
INSERT INTO `products` VALUES (5, 'Product 5', 59.53, 15.0, 10.0, 20.0, 6.0, '/product5', '2025-07-28 11:47:58');
INSERT INTO `products` VALUES (6, 'Product 6', 13.12, 16.0, 11.0, 21.0, 7.0, '/product6', '2025-07-28 11:47:58');
INSERT INTO `products` VALUES (7, 'Product 7', 156.77, 17.0, 12.0, 22.0, 8.0, '/product7', '2025-07-28 11:47:58');
INSERT INTO `products` VALUES (8, 'Product 8', 197.07, 18.0, 13.0, 23.0, 9.0, '/product8', '2025-07-28 11:47:58');
INSERT INTO `products` VALUES (9, 'Product 9', 163.55, 19.0, 14.0, 24.0, 10.0, '/product9', '2025-07-28 11:47:58');
INSERT INTO `products` VALUES (10, 'Product 10', 32.78, 20.0, 15.0, 25.0, 11.0, '/product10', '2025-07-28 11:47:58');

-- Inserts for categories

INSERT INTO `categories` VALUES (1, 'Category 1', '2025-07-28 11:47:58');
INSERT INTO `categories` VALUES (2, 'Category 2', '2025-07-28 11:47:58');
INSERT INTO `categories` VALUES (3, 'Category 3', '2025-07-28 11:47:58');
INSERT INTO `categories` VALUES (4, 'Category 4', '2025-07-28 11:47:58');
INSERT INTO `categories` VALUES (5, 'Category 5', '2025-07-28 11:47:58');
INSERT INTO `categories` VALUES (6, 'Category 6', '2025-07-28 11:47:58');
INSERT INTO `categories` VALUES (7, 'Category 7', '2025-07-28 11:47:58');
INSERT INTO `categories` VALUES (8, 'Category 8', '2025-07-28 11:47:58');
INSERT INTO `categories` VALUES (9, 'Category 9', '2025-07-28 11:47:58');
INSERT INTO `categories` VALUES (10, 'Category 10', '2025-07-28 11:47:58');

-- Inserts for products_categories

INSERT INTO `products_categories` VALUES (1, 1);
INSERT INTO `products_categories` VALUES (2, 2);
INSERT INTO `products_categories` VALUES (3, 3);
INSERT INTO `products_categories` VALUES (4, 4);
INSERT INTO `products_categories` VALUES (5, 5);
INSERT INTO `products_categories` VALUES (6, 6);
INSERT INTO `products_categories` VALUES (7, 7);
INSERT INTO `products_categories` VALUES (8, 8);
INSERT INTO `products_categories` VALUES (9, 9);
INSERT INTO `products_categories` VALUES (10, 10);

-- Inserts for carts

INSERT INTO `carts` VALUES (1, 'session1', 1, 1, 20.23, '2025-07-28 11:47:58');
INSERT INTO `carts` VALUES (2, 'session2', 2, 2, 9.23, '2025-07-28 11:47:58');
INSERT INTO `carts` VALUES (3, 'session3', 3, 3, 11.53, '2025-07-28 11:47:58');
INSERT INTO `carts` VALUES (4, 'session4', 4, 4, 25.39, '2025-07-28 11:47:58');
INSERT INTO `carts` VALUES (5, 'session5', 5, 5, 5.18, '2025-07-28 11:47:58');
INSERT INTO `carts` VALUES (6, 'session6', 6, 6, 16.14, '2025-07-28 11:47:58');
INSERT INTO `carts` VALUES (7, 'session7', 7, 7, 33.02, '2025-07-28 11:47:58');
INSERT INTO `carts` VALUES (8, 'session8', 8, 8, 17.32, '2025-07-28 11:47:58');
INSERT INTO `carts` VALUES (9, 'session9', 9, 9, 39.95, '2025-07-28 11:47:58');
INSERT INTO `carts` VALUES (10, 'session10', 10, 10, 32.07, '2025-07-28 11:47:58');

-- Inserts for carts_products

INSERT INTO `carts_products` VALUES (1, 1, 1, '2025-07-29 11:47:58', '2025-07-28 11:47:58');
INSERT INTO `carts_products` VALUES (2, 2, 2, '2025-07-29 11:47:58', '2025-07-28 11:47:58');
INSERT INTO `carts_products` VALUES (3, 3, 3, '2025-07-29 11:47:58', '2025-07-28 11:47:58');
INSERT INTO `carts_products` VALUES (4, 4, 4, '2025-07-29 11:47:58', '2025-07-28 11:47:58');
INSERT INTO `carts_products` VALUES (5, 5, 5, '2025-07-29 11:47:58', '2025-07-28 11:47:58');
INSERT INTO `carts_products` VALUES (6, 6, 6, '2025-07-29 11:47:58', '2025-07-28 11:47:58');
INSERT INTO `carts_products` VALUES (7, 7, 7, '2025-07-29 11:47:58', '2025-07-28 11:47:58');
INSERT INTO `carts_products` VALUES (8, 8, 8, '2025-07-29 11:47:58', '2025-07-28 11:47:58');
INSERT INTO `carts_products` VALUES (9, 9, 9, '2025-07-29 11:47:58', '2025-07-28 11:47:58');
INSERT INTO `carts_products` VALUES (10, 10, 10, '2025-07-29 11:47:58', '2025-07-28 11:47:58');

-- Inserts for orders_status

INSERT INTO `orders_status` VALUES (1, 'Em Aberto');
INSERT INTO `orders_status` VALUES (2, 'Pago');
INSERT INTO `orders_status` VALUES (3, 'Enviado');
INSERT INTO `orders_status` VALUES (4, 'Entregue');

-- Inserts for orders

INSERT INTO `orders` VALUES (1, 1, 1, 4, 402.81, '2025-07-28 11:47:58');
INSERT INTO `orders` VALUES (2, 2, 2, 4, 359.06, '2025-07-28 11:47:58');
INSERT INTO `orders` VALUES (3, 3, 3, 1, 65.22, '2025-07-28 11:47:58');
INSERT INTO `orders` VALUES (4, 4, 4, 1, 187.42, '2025-07-28 11:47:58');
INSERT INTO `orders` VALUES (5, 5, 5, 3, 136.62, '2025-07-28 11:47:58');
INSERT INTO `orders` VALUES (6, 6, 6, 1, 244.28, '2025-07-28 11:47:58');
INSERT INTO `orders` VALUES (7, 7, 7, 3, 80.6, '2025-07-28 11:47:58');
INSERT INTO `orders` VALUES (8, 8, 8, 2, 297.51, '2025-07-28 11:47:58');
INSERT INTO `orders` VALUES (9, 9, 9, 1, 53.1, '2025-07-28 11:47:58');
INSERT INTO `orders` VALUES (10, 10, 10, 1, 325.45, '2025-07-28 11:47:58');

-- Inserts for users_logs

INSERT INTO `users_logs` VALUES (1, 1, 'User log example', '192.168.0.1', 'Mozilla/5.0', 'session1', '/url1', '2025-07-28 11:47:58');
INSERT INTO `users_logs` VALUES (2, 2, 'User log example', '192.168.0.1', 'Mozilla/5.0', 'session2', '/url2', '2025-07-28 11:47:58');
INSERT INTO `users_logs` VALUES (3, 3, 'User log example', '192.168.0.1', 'Mozilla/5.0', 'session3', '/url3', '2025-07-28 11:47:58');
INSERT INTO `users_logs` VALUES (4, 4, 'User log example', '192.168.0.1', 'Mozilla/5.0', 'session4', '/url4', '2025-07-28 11:47:58');
INSERT INTO `users_logs` VALUES (5, 5, 'User log example', '192.168.0.1', 'Mozilla/5.0', 'session5', '/url5', '2025-07-28 11:47:58');
INSERT INTO `users_logs` VALUES (6, 6, 'User log example', '192.168.0.1', 'Mozilla/5.0', 'session6', '/url6', '2025-07-28 11:47:58');
INSERT INTO `users_logs` VALUES (7, 7, 'User log example', '192.168.0.1', 'Mozilla/5.0', 'session7', '/url7', '2025-07-28 11:47:58');
INSERT INTO `users_logs` VALUES (8, 8, 'User log example', '192.168.0.1', 'Mozilla/5.0', 'session8', '/url8', '2025-07-28 11:47:58');
INSERT INTO `users_logs` VALUES (9, 9, 'User log example', '192.168.0.1', 'Mozilla/5.0', 'session9', '/url9', '2025-07-28 11:47:58');
INSERT INTO `users_logs` VALUES (10, 10, 'User log example', '192.168.0.1', 'Mozilla/5.0', 'session10', '/url10', '2025-07-28 11:47:58');

-- Inserts for users_passwords_recoveries

INSERT INTO `users_passwords_recoveries` VALUES (1, 1, '192.168.0.1', NULL, '2025-07-28 11:47:58');
INSERT INTO `users_passwords_recoveries` VALUES (2, 2, '192.168.0.1', NULL, '2025-07-28 11:47:58');
INSERT INTO `users_passwords_recoveries` VALUES (3, 3, '192.168.0.1', NULL, '2025-07-28 11:47:58');
INSERT INTO `users_passwords_recoveries` VALUES (4, 4, '192.168.0.1', NULL, '2025-07-28 11:47:58');
INSERT INTO `users_passwords_recoveries` VALUES (5, 5, '192.168.0.1', NULL, '2025-07-28 11:47:58');
INSERT INTO `users_passwords_recoveries` VALUES (6, 6, '192.168.0.1', NULL, '2025-07-28 11:47:58');
INSERT INTO `users_passwords_recoveries` VALUES (7, 7, '192.168.0.1', NULL, '2025-07-28 11:47:58');
INSERT INTO `users_passwords_recoveries` VALUES (8, 8, '192.168.0.1', NULL, '2025-07-28 11:47:58');
INSERT INTO `users_passwords_recoveries` VALUES (9, 9, '192.168.0.1', NULL, '2025-07-28 11:47:58');
INSERT INTO `users_passwords_recoveries` VALUES (10, 10, '192.168.0.1', NULL, '2025-07-28 11:47:58');