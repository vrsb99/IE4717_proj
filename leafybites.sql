create table category(
    categoryid int unsigned not null auto_increment primary key,
    categoryname char(50) not null
);


create table items(
    itemid int unsigned not null auto_increment,
    categoryid int unsigned not null,
    itemname char(50) not null,
    itemdescription text not null,
    itemimage char(50) not null,
    -- itemprice float(4,2) not null,
    primary key (itemid, categoryid)
);

create table sizes(
    sizeid int unsigned not null auto_increment,
    itemid int unsigned not null,
    categoryid int unsigned not null,
    size char(10) not null,
    sizeprice float(4,2) not null,
    primary key (sizeid, itemid, categoryid)
);

create table customers(
    customerid int unsigned not null auto_increment primary key,
    email char(50) not null
);

create table orders(
    orderid int unsigned not null auto_increment,
    customerid int unsigned not null,
    orderdate datetime not null,
    primary key (orderid, customerid)
);

create table order_items(
    orderid int unsigned not null,
    categoryid int unsigned not null,
    itemid int unsigned not null,
    sizeid int unsigned not null,
    price float(4,2) not null,
    quantity int unsigned not null,
    primary key (orderid, categoryid, itemid, sizeid)
);

create table users(
    userid int unsigned not null auto_increment primary key,
    username char(50) not null,
    email char(50) not null,
    password varchar(40)
);