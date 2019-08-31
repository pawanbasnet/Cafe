create or replace procedure new_orders
(new_fname Orders.Cus_fname%TYPE, new_Lname Orders.Cus_lname%TYPE, 
 new_item Orders.Order_item%TYPE) as
    max_order_id   Orders.Order_id%TYPE;
begin

    select nvl(max(Order_id), '0')
    into max_order_id
    from Orders;

    insert into Orders
    values
        (max_order_id + 35, new_fname, new_Lname, new_item);
end;
/
show errors

rollback;