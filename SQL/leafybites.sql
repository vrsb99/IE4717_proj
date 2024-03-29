CREATE TABLE category(
    categoryid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE items(
    itemid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    categoryid INT UNSIGNED NOT NULL,
    name VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(50),
    FOREIGN KEY (categoryid) REFERENCES category(categoryid)
);

CREATE TABLE sizes(
    sizeid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    itemid INT UNSIGNED NOT NULL,
    name VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL, -- 10 digits, 2 decimal places
    quantity INT UNSIGNED,
    FOREIGN KEY (itemid) REFERENCES items(itemid)
);

CREATE TABLE customers(
    customerid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL
);

CREATE TABLE orders(
    orderid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    customerid INT UNSIGNED NOT NULL,
    orderdate DATETIME NOT NULL,
    FOREIGN KEY (customerid) REFERENCES customers(customerid)
);

CREATE TABLE order_items(
    orderid INT UNSIGNED NOT NULL,
    itemname VARCHAR(50) NOT NULL,
    sizename VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT UNSIGNED NOT NULL,
    FOREIGN KEY (orderid) REFERENCES orders(orderid)
);

CREATE TABLE users(
    userid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(40)

);

CREATE TABLE admin(
    adminid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    password VARCHAR(40) NOT NULL
);

CREATE TABLE usersfeedback(
   customerid INT UNSIGNED NOT NULL,
   feedback TEXT NOT NULL
); 
