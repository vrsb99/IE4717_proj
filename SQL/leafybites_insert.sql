USE leafybites;

INSERT INTO category (categoryid, name) VALUES 
    (1, "Salad Bowls"),
    (2, "Burgers"),
    (3, "Beverages");

INSERT INTO items (itemid, categoryid, name, description, image) VALUES
    (1, 1, "Tuna Salad", "Romaine lettuce, croutons, parmesan cheese, and caesar dressing", "tuna_salad.jpg"),
    (2, 1, "Fruit Salad", "A taste of paradise in every bite. Our refreshing blend of the season's sweetest fruits, expertly diced and drizzled with a light citrus dressing.", "fruit_salad.jpg"),
    (3, 1, "Veggie Salad", "Our crisp, garden-fresh salad bursting with a rainbow of vegetables, tossed in a zesty vinaigrette. A healthy and flavorful masterpiece for those who crave freshness on their plate.", "veggie_salad.jpg"),
    (4, 2, "Salmon Burger", "A seafood lover's delight.", "salmon_burger.jpg"),
    (5, 2, "Chicken Burger", "Our tender, seasoned chicken patty, impeccably grilled, and nestled in a warm, toasted bun. Accompanied by a medley of fresh toppings for a taste sensation that's clucking good!", "chicken_burger.jpg"),
    (6, 2, "Cheese Burger", "A classic masterpiece of flavors. Our juicy, perfectly grilled beef patty, topped with melted cheese, nestled in a soft, toasted bun. Served with all the fixings for an unforgettable, mouthwatering experience", "cheeseburger.jpg"),
    (7, 3, "Coke", "Coca-Cola", "cola.jpg"),
    (8, 3, "Pepsi", "Pepsi", "pepsi.jpg"),
    (9, 3, "Milk", "Our milk is the essence of wholesome goodness, a timeless ingredient that nourishes and delights in every dish it touches.", "soy_milk.jpg");

INSERT INTO sizes (sizeid, itemid, name, price, quantity) VALUES
    (1, 1, "Regular", 5.00, 1),
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

INSERT INTO admin (adminid, password) VALUES    
    (0,"e3274be5c857fb42ab72d786e281b4b8");