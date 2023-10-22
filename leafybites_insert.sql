use leafybites;

insert into category values 
    (1, "Salad Bowls"),
    (2, "Sandwiches"),
    (3, "Beverages");

insert into items values
    (1, 1, "Caesar Salad", "Romaine lettuce, croutons, parmesan cheese, and caesar dressing", "caesar_salad.jpg"),
    (2, 1, "Greek Salad", "Romaine lettuce, tomatoes, cucumbers, red onions, feta cheese, and greek dressing", "greek_salad.jpg"),
    (3, 1, "Spinach Salad", "Spinach, tomatoes, cucumbers, red onions, and balsamic vinaigrette", "spinach_salad.jpg"),
    (4, 2, "BLT", "Bacon, lettuce, tomato, and mayonnaise on white bread", "blt.jpg"),
    (5, 2, "Ham and Cheese", "Ham, cheese, lettuce, tomato, and mayonnaise on white bread", "ham_and_cheese.jpg"),
    (6, 2, "Turkey and Cheese", "Turkey, cheese, lettuce, tomato, and mayonnaise on white bread", "turkey_and_cheese.jpg"),
    (7, 3, "Coke", "Coca-Cola", "coke.jpg"),
    (8, 3, "Diet Coke", "Diet Coca-Cola", "diet_coke.jpg"),
    (9, 3, "Sprite", "Sprite", "sprite.jpg");

insert into sizes values
    (1, 1, 1, "Regular", 5.00),
    (2, 2, 1, "Regular", 5.50),
    (3, 3, 1, "Regular", 6.00),
    (4, 4, 2, "Regular", 6.50),
    (5, 4, 2, "Large", 7.00),
    (6, 5, 2, "Regular", 6.60),
    (7, 5, 2, "Large", 7.10),
    (8, 6, 2, "Regular", 6.70),
    (9, 6, 2, "Large", 7.20),
    (10, 7, 3, "Small", 1.50),
    (11, 7, 3, "Medium", 2.00),
    (12, 7, 3, "Large", 2.50),
    (13, 8, 3, "Small", 1.60),
    (14, 8, 3, "Medium", 2.10),
    (15, 8, 3, "Large", 2.60),
    (16, 9, 3, "Small", 1.70),
    (17, 9, 3, "Medium", 2.20),
    (18, 9, 3, "Large", 2.70);

insert into customers values
    (1, "vignesh.rsb@gmail.com"),
    (2, "vian.chan@gmail.com");

insert into orders values 
    (1, 1, "2023-10-23 10:10:10");

insert into order_items values
    (1, 1, 1, 1, 5.00, 1),
    (1, 2, 4, 5, 7.00, 2),
    (1, 3, 7, 11, 2.00, 3);