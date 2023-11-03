USE leafybites;

INSERT INTO category (categoryid, name) VALUES 
    (1, "Salad Bowls"),
    (2, "Burgers"),
    (3, "Beverages");

INSERT INTO items (itemid, categoryid, name, description, image) VALUES
    (1, 1, "Tuna Salad", "Romaine lettuce, croutons, parmesan cheese, and caesar dressing", "tuna_salad.jpg"),
    (2, 1, "Fruit Salad", "Romaine lettuce, tomatoes, cucumbers, red onions, feta cheese, and greek dressing", "fruit_salad.jpg"),
    (3, 1, "Veggie Salad", "Spinach, tomatoes, cucumbers, red onions, and balsamic vinaigrette", "veggie_salad.jpg"),
    (4, 2, "Salmon Burger", "Bacon, lettuce, tomato, and mayonnaise on white bread", "salmon_burger.jpg"),
    (5, 2, "Chicken Burger", "Ham, cheese, lettuce, tomato, and mayonnaise on white bread", "chicken_burger.jpg"),
    (6, 2, "Cheese Burger", "Turkey, cheese, lettuce, tomato, and mayonnaise on white bread", "cheeseburger.jpg"),
    (7, 3, "Coke", "Coca-Cola", "cola.jpg"),
    (8, 3, "Pepsi", "Diet Coca-Cola", "pepsi.jpg"),
    (9, 3, "Milk", "Sprite", "soy_milk.jpg");

INSERT INTO sizes (sizeid, itemid, name, price, quantity) VALUES
    (1, 1, "Regular", 5.00, 10),
    (2, 2, "Regular", 5.50, NULL),
    (3, 3, "Regular", 6.00, NULL),
    (4, 4, "Regular", 6.50, NULL),
    (5, 4, "Large", 7.00, 10),
    (6, 5, "Regular", 6.60, 10),
    (7, 5, "Large", 7.10, 10),
    (8, 6, "Regular", 6.70, NULL),
    (9, 6, "Large", 7.20, NULL),
    (10, 7, "Small", 1.50, NULL),
    (11, 7, "Medium", 2.00, NULL),
    (12, 7, "Large", 2.50, NULL),
    (13, 8, "Small", 1.60, NULL),
    (14, 8, "Medium", 2.10, NULL),
    (15, 8, "Large", 2.60, NULL),
    (16, 9, "Small", 1.70, NULL),
    (17, 9, "Medium", 2.20, NULL),
    (18, 9, "Large", 2.70, NULL);

-- INSERT INTO customers (customerid, email) VALUES
--     (1, "vignesh.rsb@gmail.com"),
--     (2, "vian.chan@gmail.com");

-- INSERT INTO orders (orderid, customerid, orderdate) VALUES 
--     (1, 1, "2023-10-23 10:10:10");

-- INSERT INTO order_items (orderid, itemid, sizeid, price, quantity) VALUES
--     (1, 1, 1, 5.00, 1),
--     (1, 4, 5, 7.00, 2),
--     (1, 7, 11, 2.00, 3);

INSERT INTO admin (adminid, password) VALUES    
    (0,"adminpassword");