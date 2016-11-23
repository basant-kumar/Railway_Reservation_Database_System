delimiter //
create or replace trigger auto_increment_booked_seat before insert on passenger
for each row
begin
	DECLARE pnr int(10);
	declare stn_c varchar(30);
	declare doj_ varchar(30);
	declare doj2 varchar(30);
	declare c_day integer;
	declare tn integer;
    
	select  t_from into  stn_c from tickets where pnr_no = NEW.pnr_no;
	select doj into doj_ from tickets where pnr_no = NEW.pnr_no;
	select train_no into tn from tickets where pnr_no = NEW.pnr_no;
	select current_day into c_day from schedule where train_no = tn and stn_code = stn_c;
    
	SET doj2 = DATE_SUB(doj_, INTERVAL c_day DAY);
	if(NEW.coach = 'AC1') then update status set bs_ac1 = bs_ac1+1 where train_no = tn and a_date = doj2;
	elseif(NEW.coach ='AC2') then update status set bs_ac2 = bs_ac2+1 where train_no = tn and a_date = doj2;
	elseif(NEW.coach ='AC3') then update status set bs_ac3 = bs_ac3+1 where train_no = tn and a_date = doj2;
	else update status set bs_sl = bs_sl+1 where train_no = tn and a_date = doj2;
	end if;
end//
delimiter ;