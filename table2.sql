-- Item table
drop table Item cascade constraints;
create table Item (
    Item_id char(5),
    Item_name varchar2(32),
    Item_price number(4,2),
    primary key (Item_id)
);

-- Orders table
drop table Orders cascade constraints;
create table Orders (
    Order_id char(5),
    Cus_fname varchar2(15),
    Cus_lname varchar2(15),
    Cus_phone number(10),
    primary key (Order_id)
);

-- Ordered_item table
drop table Order_item cascade constraints;
create table Order_item (
    Ordered_id char(5),
    Order_Item_id char(5),
    Order_Item_amt number(4,2),
    foreign key (Order_Item_id) references Item(Item_id),
    foreign key (Ordered_id) references Orders(Order_id)
);