
create or replace procedure search_trains(f_stn_code varchar(10),t_stn_code varchar(10),t_day integer)
begin
		select cc.train_no,cc.current_day ee.train_name,ee.train_type,cc.arrival_time as fat,cc.departure_time as fdt,dd.arrival_time as tat, dd.departure_time as tdt, (dd.current_day-cc.current_day) as extra_day, (dd.dist_so_far-cc.dist_so_far) as dist, (dd.fair_so_far-cc.fair_so_far) as fair 
		from
			(select aa.train_no,aa.current_day,aa.arrival_time,aa.dist_so_far,aa.fair_so_far,aa.departure_time
			from
				(select train_no, current_day, dist_so_far, fair_so_far, arrival_time, departure_time from schedule where stn_code = f_stn_code) as aa,
				(select train_no, available_day from trains_availability) as bb
			where aa.train_no=bb.train_no and (bb.available_day+aa.current_day)%7 = t_day) 
			as cc,
			(select train_no, current_day,dist_so_far, fair_so_far, arrival_time, departure_time from schedule where stn_code = t_stn_code) as dd,
			(select train_name, train_no,train_type from trains)
			as ee
		where dd.train_no = cc.train_no and ee.train_no=dd.train_no and (dd.current_day >= cc.current_day or dd.arrival_time>=cc.arrival_time);

END;
	