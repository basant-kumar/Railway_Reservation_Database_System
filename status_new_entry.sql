delimiter //
create or replace procedure status_new_entry(IN t_no integer(10),IN t_date date)

begin
	insert into Status values(t_no,100,0,100,0,100,0,100,0,t_date);
	
end //
delimiter ;