delimiter //
create or replace trigger c_ticket_trig before insert on cancel_tickets
for each row
begin
	declare cnt integer;
	declare pnr_no_ integer;
	declare wait varchar(30);
	DECLARE done INTEGER DEFAULT 0;
	declare status_ varchar(30);
	declare seat_no_ integer;
	declare cur cursor for (select pnr_no, seat_no, t_status from passenger where train_no = NEW.train_no and s_date = NEW.c_doj and coach = NEW.coach and t_status != "Confirm" order by t_status);
	
	DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET done = 1;
	
	select count(*) into cnt from passenger where train_no = NEW.train_no and s_date = NEW.c_doj and coach = NEW.coach and t_status != "Confirm";
	delete from passenger where train_no=NEW.train_no and coach = NEW.coach and seat_no = NEW.seat_no and s_date = NEW.c_doj;
	if(cnt > 0) then 
		open cur;
		fetch cur into pnr_no_, seat_no_,status_;
		update passenger set seat_no=NEW.seat_no where pnr_no = pnr_no_ and t_status=status_;
		update passenger set t_status='Confirm' where pnr_no = pnr_no_ and t_status=status_;
		set cnt = 1;
		r_loop:  LOOP
			fetch cur into pnr_no_, seat_no_, status_;
			if done=1 then
				LEAVE r_loop;
			end if;
			set wait = CONCAT("Waiting(",cnt);
			set wait = CONCAT(wait,")");
			update passenger set t_status=wait where t_status = status_ and pnr_no = pnr_no_;
			set cnt = cnt+1;
		END LOOP;
		close cur;
	end if;
end //
delimiter ;