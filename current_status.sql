delimiter //
create or replace procedure current_status(IN t_no int(10),IN t_date date)

begin
	select * from status where train_no=t_no and a_date=t_date;
end //
delimiter ;

