create or replace function orderPrice(desired_title varchar2)
    return integer is

    num_price integer;
begin
    select count(*)
    into   num_price
    from   Item_name
    where  title_name = desired_title;

    return num_price;
end;
/
show errors